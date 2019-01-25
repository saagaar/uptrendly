<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Bidding_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->image_name_path='';
	}
	
	public function get_auction_byid($product_id)
	{			
		$this->db->select('*');
		$query = $this->db->get_where('products',array('id'=>$product_id));
	
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			$query->free_result();
			return $data;
		}
		return FALSE;

	}

	//get user record by user id
	public function get_user_data($user_id)
	{
		
		$this->db->select('balance,username,email');
		$query = $this->db->get_where('members',array('id'=>$user_id));

		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			$query->free_result();
			return $data;
		}
		return FALSE;
	}

	function check_duplicate_bid($auc_id,$user_id, $auc_amt)
	{
		$where = "user_bid_amt = ".$auc_amt." AND product_id = ".$auc_id." AND user_id = ".$user_id;
		$this->db->where($where);
		$query=$this->db->get('product_bids');
		return $query->num_rows();
	}

	function insert_bid($product_id,$user_id,$bid_value, $detail, $time, $payment_type)
	{
	    $this->auction_id = $product_id;
		
		$this->user_id = $user_id;		
		
		$this->user_bid_amt = $bid_value;
		
		$this->user_bid_time = $time;
		$this->bid_detail = $detail;
		
		$this->payment_type = $payment_type;
		// $this->click_cost = $bid_fee;				
				
		/***********************Running Transactions************************/
		$this->db->trans_start();
				
		//Insert user biding record
		$this->insert_user_bid();
				
		
		//update member table
		// $this->update_member_balance();
		
				
		//insert bidding records in the transaction table
		$this->insert_transaction_record();
				
		$this->db->trans_complete();
		/***********************End Running Transactions************************/		
	 }
	 
	public function insert_user_bid()
	{
		$data = array(
			'product_id'	=>	$this->auction_id,
	  		'user_id'		=>	$this->user_id,
		  	'user_bid_amt' 	=> 	$this->user_bid_amt,						 
		  	'bid_date' 		=> 	$this->user_bid_time,
		  	'bid_details' 	=>  $this->bid_detail,
		  	'payment_type'	=>	$this->payment_type,
	  	);
		if($this->image_name_path)
		{
			$data['attachment'] = $this->image_name_path;
		}		
		$this->db->insert('product_bids', $data); 
	
		$this->bid_id = $this->db->insert_id();			
	}

	function update_bid($product_id, $user_id, $bid_value, $detail, $time, $payment_type)
	{	
		$this->auction_id = $product_id;
		
		$this->user_id = $user_id;		
		
		$this->user_bid_amt = $bid_value;
		
		$this->user_bid_time = $time;
		$this->bid_detail = $detail;	
		$this->payment_type = $payment_type;
		/***********************Running Transactions************************/
		$this->db->trans_start();
				
		//update user biding record
		$this->update_user_bid();
				

		//update member table
		// $this->update_member_balance();
	
				
		//insert bidding records in the transaction table
		$this->insert_transaction_record();
				
		$this->db->trans_complete();
		/***********************End Running Transactions************************/		
	 }

	 public function update_user_bid()
	 {
	 	$data = array(
			'user_bid_amt' 	=> $this->user_bid_amt,
			'bid_details' 	=> $this->bid_detail,
			'bid_date' 		=> $this->user_bid_time,
			'payment_type'	=>	$this->payment_type,
		);

		if($this->image_name_path)
		{
			$data['attachment'] = $this->image_name_path;
		}
		$this->db->where('product_id', $this->auction_id);
		$this->db->where('user_id', $this->user_id);

		$this->db->update('product_bids', $data); 
	 }
	 
	// update member 
	public function update_member_balance()
	{
		$this->db->select('balance');
						
		$query = $this->db->get_where('members', array('id'=>$this->user_id));
						
		$user_balance = $query->row();
						
		$user_total_balance = $user_balance->balance - $this->click_cost;	
						
		$mem_data=array('balance'=>$user_total_balance);						
						
		if($query->num_rows() > 0)
		{
						
			$this->db->where('id', $this->user_id);
							
			$this->db->update('members', $mem_data);
							
		}		
	}

	//added by manish for getting total number of bids
	public function get_users_total_bids($auc_id)
	{			
		$query = $this->db->get_where("product_bids",array('product_id'=>$auc_id));	
		return $query->num_rows();			
	}
	 
	function getHighestBidder($product_id)
    {
	 	$this->db->select("user_bid_amt,user_id, bid_date");
	 	$this->db->from("product_bids");
	 	$this->db->where('product_id',$product_id);
	 	$this->db->order_by('user_bid_amt','DESC');
	 	$this->db->order_by('bid_date','ASC');
	 	$this->db->limit(1);
	 	$query=$this->db->get();

     	if($query->num_rows() > 0 )
	  	{
	  		return $query->row();
	  	}
  	 
	 	return FALSE;
  	}
	  
  	// to upload bid attachments
  	public function file_settings_do_upload($file)
	{
		$config['upload_path'] = './'.BID_ATTACHMENTS;//define in constants
		$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf';
		$config['remove_spaces'] = TRUE;		
		$config['max_size'] = '2000';
		// $config['max_width'] = '1000';
		// $config['max_height'] = '1000';
		$this->upload->initialize($config);
		//print_r($_FILES);
		
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			$this->error_img = $this->upload->display_errors();
			// echo $this->error_img;
			return false;
		}
		else
		{
			$data = $this->upload->data();
			return $data;
		}			
	}

	// method to upload attachments while bidding 
	public function upload_bid_attachment()
	{
		$image_error = FALSE;

		// Upload Attachments
		if(!empty($_FILES['bid_attachment']['name']))
		{
			//make file settins and do upload it
			$image_name = $this->file_settings_do_upload('bid_attachment');
			
            if ($image_name['file_name'])
            {
				$this->image_name_path = $image_name['file_name'];				
            }
            else
            {
			   $image_error = TRUE;
            }
		}		
		
		return $image_error;
	}

	// check if bid is already placed for the auction by the current user
	public function check_bid_already_placed($user_id, $product_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('product_id', $product_id);
		$this->db->limit(1);
		$query = $this->db->get('product_bids');

		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	// insert transaction record for bid
	function insert_transaction_record()
	{
		$invoice_id = strtotime('now');
		
		$data = array(
		   'user_id' => $this->user_id,
		   'invoice_id' => $invoice_id,
		   'product_id' => $this->auction_id,		   		
		   'credit_debit' => 'DEBIT',		   
		   'transaction_name' =>'Bid Fee For auction ID: '.$this->auction_id,
		   'transaction_date' => $this->general->get_local_time('time'),
		   'transaction_type' => 'bid',
		   'transaction_status' => 'Completed',		   
		   'payment_method' => 'direct',
		   'amount'=>$this->user_bid_amt,
		   'pay_type' => $this->payment_type,
	   	);
		
		$this->db->insert('transaction', $data);
		return $this->db->insert_id(); 	
	}

	// method to update transaction record for bid
	public function update_tranasction_record()
	{
		$data = array(
		   'amount'				=> $this->user_bid_amt,	
		   'pay_type' => $this->payment_type,		   			   
		   'transaction_date'	=> $this->general->get_local_time('time'),		   
	   	);
		
		$this->db->where('user_id', $this->user_id);
		$this->db->where('product_id', $this->auction_id);
		$this->db->where('transaction_type', 'bid');
		$this->db->where('transaction_status', 'Completed');
		$this->db->where('payment_method', 'direct');
		$this->db->update('transaction', $data);
	}

	// method to update product end time if remaining time is less than 2 minutes
	public function update_product_end_time($product_id, $time = 30)
	{
		$update_auction = 	"UPDATE emts_auction SET
							auc_end_time = DATE_ADD( auc_end_time, INTERVAL '$time' SECOND )
							WHERE id='$product_id'
							";						
		$this->db->query($update_auction);
	}
	
}