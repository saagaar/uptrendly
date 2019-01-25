<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_close_model extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
	}
	
	function get_num_closing_auction()
	{
		$current_date = $this->general->get_local_time('time');

		$this->db->where('end_time <=',$current_date);
		$this->db->where('listing_payment_status','1');
		$this->db->where('item_type !=',1);
		$this->db->where('status',2);
		$this->db->limit(1);
		$query=$this->db->get('products');
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			//print_r($data);exit;
			$query->free_result();
			return $data;
		}
		return false;
	}
	
	
	public function insert_winner_in_product_order()
	{       
		$quantity=1;
		$product_type = 2;
		$status= 1;
		
		$commission_amount= ($this->winner_amount * ITEM_SELLING_COMMISSION ) / 100;
		
		$data = array(
			'user_id'=>$this->winner_id,
			'product_id'=>$this->product_id,
			'quantity'=>$quantity,
			'product_cost'=>$this->winner_amount,
			'shipping_cost'=>$this->shipping_cost,
			'sale_commission'=>$commission_amount,
			'order_date'=>$this->closed_date,
			'shipping_type'=>$this->shipping_type,
			'product_type'=>$product_type,
			'status'=>$status,
			);
		$query = $this->db->insert('product_order', $data);
		//return $quantity;	
		//echo $this->db->last_query(); exit;
	}
	
	//public function update_product_tbl($quantity)
	public function update_product_tbl()
	{
		$data=array('status'=>'3');
		
		$this->db->where(array('id'=>$this->product_id));
		
		$query=$this->db->update('products', $data);			
	}
	
	
	public function insert_notification_tbl()
	{       
		$current_date = $this->general->get_local_time('time');
		
		$data = array(
			'generator_id'=>$this->seller_id,
			'receiver_id'=>$this->winner_id,
			'product_id'=>$this->product_id,
			'notification_type'=>'auction_won',
			'notification_desc'=>'Congratulations! you have won the auction : '.$this->product_name,
			'create_date'=>$current_date,
			'status_read'=>"No"
		); 
		$query = $this->db->insert('notification', $data);
		$gcm_user_data = $this->general->get_gcm_user_data($this->winner_id);
		if($gcm_user_data)
      	{
	        $regId = array($gcm_user_data->gcm_regid);

	        $message_arr = array(
	        	'message' => $data['notification_desc'], 
	        	'notification_type' => 'auction_won', 
	        	'product_id' => $this->product_id,
        	);
        	$message = array('message' => json_encode($message_arr));
	        $status = $this->general->send_gcm_message($regId, $message);
      	}
		
		$data_looser=$this->get_auction_looser_details($this->winner_id,$this->product_id);
		
		if($data_looser)
		{
			$loosers_ids = array();
			foreach($data_looser as $data_looser)
			{
				$dta = array(
					'generator_id'=>$this->seller_id,
					'receiver_id'=>$data_looser->user_id,
					'product_id'=>$this->product_id,
					'notification_type'=>'auction_lost',
					'notification_desc'=>'Sorry! you have lost the auction : '.$this->product_name,
					'create_date'=>$current_date,
					'status_read'=>"No"
				); 
				$this->db->insert('notification', $dta);
				array_push($loosers_ids, $data_looser->user_id);
			}
			if(count($loosers_ids) > 0)
			{
				$gcm_users_data = $this->general->get_multiple_gcm_user_data($loosers_ids);
				if($gcm_users_data)
				{	
					$regIds = array();
					foreach ($gcm_users_data as $gcm_user_data) 
					{
						array_push($regIds, $gcm_user_data->gcm_regid);
					}
					
					$message_arr = array(
			        	'message' => 'Sorry! you have lost the auction : '. $this->product_name,
			        	'notification_type' => 'auction_lost', 
			        	'product_id' => $this->product_id,
    				);
    				$message = array('message' => json_encode($message_arr));
	        		$status = $this->general->send_gcm_message($regIds, $message);
				}
			}
		}
    }
	
	public function get_auction_looser_details($winner_id="",$product_id="")
	{
		$this->db->select('user_id');
		$this->db->from('product_bids');
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id !=',$winner_id);
		$this->db->group_by('user_id');
		$qry=$this->db->get();
		if($qry->num_rows() > 0)
		{
			return $qry->result();
		}
		return false;
	}
	
	
	function greaterDate($start_date,$end_date)
	{
		$uts['start'] = strtotime($start_date); 
		$uts['end'] = strtotime($end_date); 
		$diff = $uts['end'] - $uts['start'];
		if ($diff > 0)
			return 1;
		else
			return 0;		
	}	
	
	

	
	public function send_email_winner_admin()
	{
		$this->load->library('email');
		
		//ini_set("SMTP","smtp.wlink.com.np" );
		
		//configure mail
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		$this->email->initialize($config);

		$this->load->model('email_model');		
		
		//Step 1: Sending Email to the winner
		$user_info = $this->get_winner_info($this->winner_id);
		$user_email = $user_info->email;
		$lang_id=$user_info->lang_id;
	
	    //Get category info
		$product_cat_info = $this->get_cat_info($this->cat_id);
		$product_sub_cat_info = $this->get_cat_info($this->sub_cat_id);
		
		//seller information
		$seller_info=$this->get_winner_info($this->seller_id);
		
		$template=$this->email_model->get_email_template("auction_closed_notification_user",$lang_id);

        $subject=$template['subject'];
        $emailbody=$template['email_body'];
		
		if(isset($subject) && isset($emailbody))
		{
		 	//parse email
         	$parseElement = array("USERNAME"=>$this->winner_name,
                             "SITENAME"=>WEBSITE_NAME,
                             "AUCTIONNAME"=>$this->product_name,									
                             "AMOUNT"=>$this->winner_amount,
                             "DATE"=>$this->closed_date);
		 
		 	$subject=$this->email_model->parse_email($parseElement,$subject);
         	$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
		
		 	//echo $emailbody;
		
			//email sent to the winner
			$this->email->from(CONTACT_EMAIL);
			$this->email->to($user_email); 
	    	$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			$this->email->clear();
		}
		
		//Step 2: Sending email to the admin of the site
		$template=$this->email_model->get_email_template("auction_closed_notification_admin",$lang_id);
	    
		$subject=$template['subject'];
        $emailbody=$template['email_body'];
		
		if(isset($subject) && isset($emailbody))
		{
			$parseElement = array("PRODUCT_CATEGORY"=>$product_cat_info->name,
				"PRODUCT_SUBCATEGORY"=>$product_sub_cat_info->name,
				"PRODUCT_NAME"=>$this->product_name,
				"AUCTION_ID"=>$this->product_code,
				"AMOUNT"=>$this->winner_amount,
				"DATE"=>$this->closed_date,
				"SELLER_ID"=>$this->seller_id,
				"SELLER_NAME"=>$seller_info->user_name,
				"USER_ID"=>$this->winner_id,
				"USERNAME"=>$this->winner_name,
				"SITENAME"=>WEBSITE_NAME
			);
			//parse email
         	$subject=$this->email_model->parse_email($parseElement,$subject);
         	$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
		
			//echo $emailbody;
		
			//set the email things
			$this->email->from(CONTACT_EMAIL);
			$this->email->to(CONTACT_EMAIL); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
		}
		
		//Step 3: finally email sent to the seller
		if($this->seller_id)
		{
			$user_info = $this->get_winner_info($this->seller_id);
			$user_email = $user_info->email;
			$template=$this->email_model->get_email_template("auction_closed_notification_seller",$lang_id);
	
	    	$subject=$template['subject'];
        	$emailbody=$template['email_body'];
		
		    if(isset($subject) && isset($emailbody))
			{
				 $parseElement=array(
					"SELLER_NAME"=>$seller_info->user_name,
					"PRODUCT_CATEGORY"=>$product_cat_info->name,
					"PRODUCT_SUBCATEGORY"=>$product_sub_cat_info->name,
					"PRODUCT_NAME"=>$this->product_name,
					"AUCTION_ID"=>$this->product_code,
					"AMOUNT"=>$this->winner_amount,
                    "DATE"=>$this->closed_date,
					"USER_ID"=>$this->winner_id,
					"USERNAME"=>$this->winner_name,
                    "SITENAME"=>WEBSITE_NAME
                    );
				
				 //parse email
				 $subject=$this->email_model->parse_email($parseElement,$subject);
				 $emailbody=$this->email_model->parse_email($parseElement,$emailbody);
						
				//echo $emailbody;
				
				//set the email things
				$this->email->from(CONTACT_EMAIL);
				$this->email->to($user_email); 
				$this->email->subject($subject);
				$this->email->message($emailbody); 
				$this->email->send();
				}
			 
		 }
		
	}	
	
	public function get_winner_info($winner_id)
	{
		$query = $this->db->get_where('members',array('id'=>$winner_id));

		if ($query->num_rows() > 0)
		{
		  return $query->row(); 
		} 

	}
	public function get_cat_info($product_id)
	{
		
		$this->db->select('name');
		$this->db->from('product_categories');
		$array = array('id' => $product_id);
		$this->db->where($array); 
	
	    $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			$query->free_result();
			return $data;
		}
	}	
	
	
	public function get_users_used_fee($product_id)
	{
		$this->db->select('user_id,SUM(user_bid_fee) balance');
		$this->db->group_by('user_id');
		$this->db->group_by('user_id');
		
		$query = $this->db->get_where('product_bids',array('product_id'=>$product_id));
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	public function update_user_balance($return_credit,$user_id)
	{		
		//get user current balance
		$this->db->select('balance');
		$query = $this->db->get_where('members', array('id'=>$user_id));
		$user_balance = $query->row();
		
		$user_total_balance = $user_balance->balance+$return_credit;
		
		//update user balance
		$data=array('balance'=>$user_total_balance);
		$this->db->where('id',$user_id);
		$this->db->update('members', $data);
	}
	
	public function update_refund_transaction($user_id,$product_id,$total_amount,$item_name)
	{
		
		$invoice_id = strtotime("now").$user_id;
		
		$inserting_transaction=array('user_id'=>$user_id,
									 'invoice_id'=>$invoice_id,
								     'product_id'=>$product_id,
								     'credit_get'=>$total_amount,
								     'credit_debit'=>'CREDIT',
								     'transaction_name'=>$item_name,
								     'transaction_date'=>$this->general->get_local_time('time'),
								     'transaction_status' => 'Completed', 	
								     'transaction_type'=>'refund bid'
											 );
		$this->db->insert('transaction', $inserting_transaction);	
	}
	
	
	public function get_auction_byproductid($product_id)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id',$product_id);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			$query->free_result();
			return $data;
		}
		return FALSE;				
	}
	
	
	//sending email to the admin and seller for auction cancel notification
	public function send_auction_cancel_notification_admin_seller($product_id,$seller_id,$won_amt)
	{
		//load email library
    	$this->load->library('email');
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			
			
		$this->load->model('email_model');		
		
		//dnt get confused with the function name this functin is used for getting user info
		$seller_info = $this->get_winner_info($seller_id);
		$seller_email = $seller_info->email;
		$lang_id = $seller_info->lang_id;
		
		//Get auction info
		$auction_info = $this->get_auction_byproductid($product_id);
		$product_name = $auction_info->name;
		
		//sending email to seller
		$template=$this->email_model->get_email_template("auction_cancel_notification_seller",$lang_id);
			

        $subject=$template['subject'];
        $emailbody=$template['email_body'];
		
				//parse email
                $parseElement=array("USERNAME"=>$seller_info->user_name,
                                    "SITENAME"=>WEBSITE_NAME,
                                    "PRODUCT_NAME"=>$product_name,								
                                    "AMOUNT"=>$won_amt,
                                    "DATE"=>$this->general->get_local_time('time'));

                $subject=$this->email_model->parse_email($parseElement,$subject);
                $emailbody=$this->email_model->parse_email($parseElement,$emailbody);
	
		
		//echo $emailbody;
		$this->email->clear();
		$this->email->from(CONTACT_EMAIL);
		$this->email->to($seller_email); 
		$this->email->subject($subject);
		$this->email->message($emailbody); 
		$this->email->send();
		
		
		
		//sending email to admin
		$template=$this->email_model->get_email_template("auction_cancel_notification_admin",LANG_ID);
			

        $subject=$template['subject'];
        $emailbody=$template['email_body'];
		
				//parse email
                $parseElement=array("SITENAME"=>WEBSITE_NAME,
                                    "PRODUCT_NAME"=>$product_name,								
                                    "AMOUNT"=>$won_amt,
                                    "DATE"=>$this->general->get_local_time('time'));

                $subject=$this->email_model->parse_email($parseElement,$subject);
                $emailbody=$this->email_model->parse_email($parseElement,$emailbody);
	    
		//echo $emailbody;
	
		$this->email->clear();
		$this->email->from($seller_email); 
		$this->email->to(CONTACT_EMAIL);
		$this->email->subject($subject);
		$this->email->message($emailbody); 
		$this->email->send();
		
		
		
	}
	
	
	
	
	//sending email to the user and returning bids if any
	public function send_auction_cancel_notification_user($product_id,$user_id,$return_credit="")
	{
		//load email library
    	$this->load->library('email');
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			
					
		$this->load->model('email_model');		
		
		//dnt get confused with the function name this functin is used for getting user info
		$user_info = $this->get_winner_info($user_id);
		$user_email = $user_info->email;
		$lang_id = $user_info->lang_id;
		
		//Get auction info
		$auction_info = $this->get_auction_byproductid($product_id);
		$product_name = $auction_info->name;
		//Get auction closed template for winner
		$template=$this->email_model->get_email_template("auction_cancel_notification_user",$lang_id);
			

        $subject=$template['subject'];
        $emailbody=$template['email_body'];
		
				//parse email
                $parseElement=array("USERNAME"=>$user_info->user_name,
                                    "SITENAME"=>WEBSITE_NAME,
                                    "PRODUCT_NAME"=>$product_name,								
                                    "AMOUNT"=>$return_credit,
                                    "DATE"=>$this->general->get_local_time('time'));

                $subject=$this->email_model->parse_email($parseElement,$subject);
                $emailbody=$this->email_model->parse_email($parseElement,$emailbody);
	
	   //echo $emailbody; 
		
		$this->email->clear();
		$this->email->from(CONTACT_EMAIL);
		$this->email->to($user_email); 
		$this->email->subject($subject);
		$this->email->message($emailbody); 
		$this->email->send();
	}
		

}
?>	