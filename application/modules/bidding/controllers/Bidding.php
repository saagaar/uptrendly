<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
* 
*/
class Bidding extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		//load custom language library
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			//check whether logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
			if(!$this->session->userdata('MAINTAINANCE_KEY') OR $this->session->userdata('MAINTAINANCE_KEY')!='YES'){
				redirect(site_url('/maintainance'));exit;
			}
		}
		
		if(!$this->session->userdata(SESSION.'user_id'))
        {
          	$this->session->set_flashdata('loginerror', "Please Login to access this page.");
			redirect(site_url('/'),'refresh');exit;
        }
		 
		 //check banned IP address
		$this->general->check_banned_ip();
		 
		//load CI library
		$this->load->library('upload');
		// $this->load->library('image_lib');
		$this->load->library('form_validation');

		$this->load->model('bidding_model');
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');	

	}


	public function index()
	{
		// if(!$this->input->is_ajax_request())
 	//    	{
  //       	exit('No direct script access allowed');
  //      	}
	   	
	 	$user_id = $this->session->userdata(SESSION.'user_id');
	   	
   		if(!$user_id) { redirect(site_url('/user/login')); }

	 	// $nowdate=$this->general->get_local_time('time');
	  
     	$product_id = $this->input->post('auc_id', TRUE);
   		if(!$product_id) { redirect(site_url('/user/login')); }

	 	$bid_value = trim($this->input->post('bid_amount', TRUE));
	 	$bid_description = $this->input->post('bid_description',TRUE);
	 	//product details
	
	 	$auc_data=$this->bidding_model->get_auction_byid($product_id);
	 	$bid_decrement=$auc_data->bid_decrement;
	 	$budget=$auc_data->budget;
	 	
	 		//member details
	 	$user_info=$this->bidding_model->get_user_data($user_id);
	 
	 // 	if($bid_value != '')
		// {
		// 	$count_amt=$this->bidding_module->check_duplicate_bid($product_id, $user_id, $bid_value);
		// }
	 	
	 	// check if bid is already placed by user or not
	 	$already_bid = $this->bidding_model->check_bid_already_placed($user_id, $product_id);

	 	$new_bid_value = 0;
	 	if($already_bid)
	 	{
	 		$previous_bid_amount = $already_bid->user_bid_amt;

	 		$new_bid_value = $previous_bid_amount - $auc_data->bid_decrement;
	 	}

	 	$remaining_time = $this->get_closing_remaining_time($auc_data->auc_end_time);

	 	// calculate remaining time of auction to close
	 	$remaining_minutes = $remaining_time / 60;

	 	// check member validity
	 	$bid_available = $this->general->get_bid_member_validity($user_id);

 		

	   	$arr=explode('.',$bid_value);

	   	if(($bid_value<$bid_decrement) || ($bid_value>$budget))
	   	{
	   		$data['status'] = 'error';
	    	$data['message'] = 'Invalid Bid amount.Bid amount must be smaller then bid decrement and greater then budget amount';
	    	$data['estage'] = 1;
	    	echo json_encode($data);
	    	exit;
	   	}
	   	if(($bid_value%$bid_decrement!=0) )
	 	{
	 		$data['status'] = 'error';
	    	$data['message'] = 'Invalid Bid amount.Bid amount must be multiple of bid decrement';
	    	$data['estage'] = 1;
	    	echo json_encode($data);
	    	exit;
	 		 
	 	}


	   
	    if($bid_value=='')
    	{
    		// check if bid value is empty
    		$data['status'] = 'error';
	    	$data['message'] = 'Parameter Missing';
	    	$data['estage'] = 1;
	    	echo json_encode($data);
	    	exit;
		}
        else if($bid_value <= 0.00)
        {
        	// check if bid value is less than or equal to 0
			$data['status'] = 'error';
	    	$data['message'] = 'Invalid bid amount';
	    	$data['estage'] = 2;

	    	echo json_encode($data);
	    	exit;
		}
        else if(!is_numeric($bid_value))
		{
			// check if bid value is numeric or not
			$data['status'] = 'error';
	    	$data['message'] = 'Please enter valid amount';
	    	$data['estage'] = 3;

	    	echo json_encode($data);
	    	exit;
		}
		else if(!isset($arr[1]) || (isset($arr[1]) && strlen($arr[1])<2) || (isset($arr[1]) && strlen($arr[1])>2))
		{
			// check if bid value contains decimal digits and properly formatted as {xx.xx} format
			$data['status'] = 'error';
	    	$data['message'] = 'Incorrect';
	    	$data['estage'] = 4;

	    	echo json_encode($data);
	    	exit;
		}

		else if($bid_available === FALSE)
		{
			// if bid balance is not available
			$data['status'] = 'error';
	    	$data['message'] = 'You have no balance to bid on this auction';
	    	$data['estage'] = 5;

	    	echo json_encode($data);
	    	exit;
		}		
		else if($already_bid && $remaining_minutes < 2)
		{
			// if user have already bid on the product and auction is going to end within 2 minutes
			$data['status'] = 'error';
	    	$data['message'] = 'You cannot update your previous bid since auction end time is less than 2 minutes';
	    	$data['estage'] = 6;
	    	
	    	echo json_encode($data);
	    	exit;
		}
		else if($already_bid && $new_bid_value > 0 && $bid_value >= $new_bid_value)
		{

			$data['status'] = 'error';
	    	$data['message'] = 'Bid amount must be less than '. $new_bid_value;
	    	$data['estage'] = 7;

	    	echo json_encode($data);
	    	exit;
		}
		else if($remaining_time <= 0)
		{
			// if auction end time has passed
			$data['status'] = 'error';
	    	$data['message'] = 'This auction is closed';
	    	$data['estage'] = 8;

	    	echo json_encode($data);
	    	exit;				
     	}	
		else
		{
		    
	        $time=$this->general->get_local_time('time');	
			
			// if bid is placed by this users in current product 
			if($already_bid)
			{
				// if  auction remaining time >= 2 minutes then update bid record
				if($remaining_minutes >= 2)
				{
					$this->bidding_model->upload_bid_attachment();
					$result = $this->bidding_model->update_bid($product_id, $user_id, $bid_value, $bid_description, $time, $bid_available);
				}
			}
			else
			{
				$this->bidding_model->upload_bid_attachment();
				$result = $this->bidding_model->insert_bid($product_id,$user_id,$bid_value, $bid_description, $time, $bid_available);
				$this->load->model('my-account/account_module');
				$user=$this->account_module->get_data('members',array('id'=>$user_id));
				$validity=0;
				if($user[0]->balance_free>0)
					$balance_free=$user[0]->balance_free;
				else $balance_free=0;
				if($user[0]->membership_type=='one_bid' && $user[0]->balance_paid>0)
				{	
					$membership_type='One bid';
					$noofbid=$user[0]->balance_paid;
				}
				else {
					$membership_type='One bid';
					$noofbid=0;
				} 
				if($user[0]->membership_type=='unlimited')
				{
					$remainingday=$this->general->get_remaining_time($user[0]->member_validity);
					if($remainingday>0)
					{
						$membership_type='Unlimited';
						$validity=$remainingday.' days';
					}
					else{
						$membership_type='Unlimited';
						$validity='expired';
					}
				}
				$template_id=57;
				$from=CONTACT_EMAIL;
				$to=$user[0]->email;
				$username=$user[0]->username;
				$parseElement=array(
										'user'			=>	$username,
										'FreePost'		=>	$balance_free,
										'MembershipType'=>	$membership_type,
										'vaildity'		=>	$validity,
										'SITENAME'		=>	WEBSITE_NAME,
									);
				$emailsend=$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());



			}

			// if auction has less than 2 minues to close increase the auction end time by 30 seconds
	        if($remaining_minutes > 0 && $remaining_minutes < 2)
	        {
	        	$this->bidding_model->update_product_end_time($product_id);
	        }

			//current highest bid amount 
          	$bid_status = $this->bidding_model->getHighestBidder($product_id);	
			
			// reduce balance for the bid place and update if successful
			$this->general->reduce_balance($user_id, $bid_available);
			
			$msg='';
			
			if($bid_value < $bid_status->user_bid_amt)
	        {
	        	// if bid value is less than previous highest bid
	        	$msg = 'Not Highest';
	        }
			else if($bid_value > $bid_status->user_bid_amt)
			{
	        	// if bid value is greater than previous highest bid				
				$msg = 'Highest';
			}
	        else if($bid_value == $bid_status->user_bid_amt && $time == $bid_status->bid_date)
	        {
	        	// if bid value is equal to previous highest bid and previous highest bid date equals to current time
	        	$msg = 'Highest';
	        }
			else if($bid_value == $bid_status->user_bid_amt && $time != $bid_status->bid_date)
			{
	        	// if bid value is equal to previous highest bid and previous highest bid date is not equal to current time
				$msg = 'Not Highest';
			}	
			$data['data']=$this->bidding_model->check_bid_already_placed($user_id, $product_id);

			$data['status'] = 'success';
			$data['message'] = 'Bid placed succesfully';
			$data['bid_status'] = $msg;
	    	$data['estage'] = 9;
	    	
			echo json_encode($data);
			exit;
		}
	}

	// get the closing remaining time
	public function get_closing_remaining_time($end_time)
	{
		return strtotime($end_time)-strtotime($this->general->get_local_time('time'));
	}	

}