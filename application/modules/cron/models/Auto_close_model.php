<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_close_model extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
	}
	
	function get_all_closing_campaigns()
	{
		$this->db->select('*');
		$expiring_date= date('Y-m-d');
		$this->db->where(array( 'DATE_ADD(CAST(pb.upload_date AS DATE),INTERVAL +7 DAY)<' => date('Y-m-d',strtotime($this->general->get_local_time('now')))));
		$this->db->where('pb.status not in ("7","6","4","5")');
		$this->db->where('pb.socialtrackid is not null');
		// $this->db->from('draft_promotion d');
		$this->db->from('product_bids pb');
		$query=$this->db->get();
		   $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$data = $query->result();	
			$query->free_result();
			return $data;
		}
		return false;
	}
	// function get_membership_expiring()
	// {
	// 	$today=$this->general->get_local_time('now');
	// 	$nextdate= date('Y-m-d', strtotime("+30 days"));
		
	// 	$this->db->select('*');
	// 	$this->db->where('cast(member_validity as DATE) =', $nextdate);
	// 	$this->db->where('membership_type', 'unlimited');
	// 	$query=$this->db->get('members');
	// 	//echo $this->db->last_query();
	// 	if($query->num_rows() > 0)
	// 	{
	// 		$data = $query->result();	
	// 		$query->free_result();
	// 		return $data;
	// 	}
	// 	return false;
	// }
	
	// public function get_buyer_useremail($product_id)
	// {	
	// 	$this->db->select('*');
	// 	$this->db->from('products as p');
	// 	$this->db->join('members as m','p.seller_id=m.id');
	// 	$this->db->join('product_currency as c','p.currency=c.id','left');
	// 	$this->db->where('p.id',$product_id);
	// 	$query=$this->db->get();
	// 	$result=$query->row();
	// 	if(count($result)>0) return $result;
	// 	else return array();
	// }
	// public function get_bidder_useremail($product_id)
	// {	
	// 	$this->db->select('*');
	// 	$this->db->from('product_bids as b');
	// 	$this->db->join('members as m','b.user_id=m.id');
	// 	$this->db->join('products as p','b.product_id=p.id');
	// 	$this->db->join('product_currency as c','p.currency=c.id','left');
	// 	$this->db->where('b.product_id',$product_id);
	// 	$query=$this->db->get();
	// 	$result=$query->result();
	// 	if(count($result)>0) return $result;
	// 	else return array();
	// }
	
	
	// public function update_auction_to_closed()
	// {
	// 	$this->closed_date=$this->general->get_local_time('now');
	// 	$data = array(
	// 		'status'=>"3",
	// 		'auc_end_time'=>$this->closed_date
	// 	);
		
	// 	$this->db->where(array('id'=>$this->product_id));
	// 	$id = $this->db->update('products', $data);			
	// 	return $id;
	// }
	// public function send_email_buyer($buyer=array(),$no_bidder)
	// {
	// 	$template_id=58;
	// 	$to=$buyer->email;
	// 	$from=CONTACT_EMAIL;
	// 	$parseElement=array (
	// 							'USERNAME'		=> 		$buyer->username,
	// 							'product_name'	=>		$buyer->name,
	// 							'budget'		=>		$buyer->budget,
	// 							'auc_end_time'	=>		$buyer->auc_end_time,
	// 							'auc_start_time'=>		$buyer->auc_start_time,
	// 							'CURRENCY'		=>		$buyer->currency_code,
	// 							'no_bidder'		=>		$no_bidder,
	// 							'SITENAME'		=>		WEBSITE_NAME
	// 						);

	// 	$email=$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());	
		

	// }
	// public function send_email_bidder($bidder=array())
	// {
	
	// 	foreach ($bidder as $key => $value) {
	// 			$template_id=59;
	// 			$to=$value->email;
	// 			$from=CONTACT_EMAIL;
	// 			$parseElement=array(

	// 									'USERNAME'		=> 		$value->username,
	// 									'product_name'	=>		$value->name,
	// 									'auc_end_date'	=>		$value->auc_end_time,
	// 									'auc_start_date'=>		$value->auc_start_time,
	// 									'bid_amount'	=>		$value->user_bid_amt,
	// 									'CURRENCY'		=>		$value->currency_code,
	// 									'SITENAME'		=>		WEBSITE_NAME
	// 								);

	// 			$email=$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());	
				
	// 	}
	// 	return 1;
	// }
	

	

	
}
?>	