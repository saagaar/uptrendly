<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_close extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == '2')
		{
			redirect($this->general->lang_uri('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			redirect($this->general->lang_uri('/maintainance'));exit;
		}
		
		 //check banned IP address
		$this->general->check_banned_ip();
		
		//load custom language library
		$this->load->library('my_language');
		
		
		$this->load->model('auto_close_model');
	}
	
	public function index()
	{
	  	$result_auction = $this->auto_close_model->get_num_closing_auction();
	
		//echo"<pre>";  print_r($result_auction); echo "</pre>"; exit;
	   	
		if($result_auction)
		{
		    $this->product_id = $result_auction['id'];
			$this->product_code = $result_auction['product_code'];
			$this->cat_id = $result_auction['cat_id'];
			$this->sub_cat_id = $result_auction['sub_cat_id'];
			$this->seller_id = $result_auction['seller_id'];
			$this->product_name = $result_auction['name'];
			$this->shipping_cost = $result_auction['shipping_cost'];
			$this->shipping_type = $result_auction['shipping_type'];
	
			
			$result_array = $this->general->find_winner($result_auction['id']);
			
			if($result_array)
			{
            	//print_r($result_array); exit;
				$this->winner_id = $result_array['user_id'];
				$this->winner_name = $result_array['user_name'];
				//$this->winner_full_name = $result_array['first_name']." ".$result_array['last_name'];		
				//$this->winner_bid_id = $result_array['bid_id'];
				$this->winner_amount = $result_array['user_bid_amt'];
				$this->closed_date = $this->general->get_local_time('time');										
			
				//start transaction
				$this->db->trans_start();
			
				if($this->winner_id)
				{
					//Insert record in the winner table
					//$quantity=$this->auto_close_model->insert_winner_in_product_order();
					$this->auto_close_model->insert_winner_in_product_order();
					
					//insert updates in notification table for alert
					$this->auto_close_model->insert_notification_tbl();
					
					//$this->auto_close_model->update_auction();																				
					//$this->auto_close_model->update_product_tbl($quantity);
					$this->auto_close_model->update_product_tbl();
					
					//Now Send Email to winner & Admin and seller
					$this->auto_close_model->send_email_winner_admin();												
				}
			
				$this->db->trans_complete();
			}//end of if for result_array
		}//end of 	if condition for result_auction
	}//end of index method
	
	
	
}//end of auto_close class
?>