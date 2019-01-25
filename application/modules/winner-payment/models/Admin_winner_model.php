<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_winner_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();	
	}


	//function to count total products

	public function count_total_winners($status)
	{
		$this->db->select('P.name as product_name, M.name as creator,M2.name as brand,PB.user_bid_amt,PB.bid_date');
		$this->db->from('product_winner PW');
		$this->db->join('products P','PW.product_id=P.id');
		$this->db->join('product_bids PB', 'PB.id = PW.bid_id and PB.status="7"');
		$this->db->join('members_details M', 'PB.user_id = M.user_id');
		$this->db->join('members_details M2', 'P.brand_id = M2.user_id');
		$this->db->where('PB.status="7"');
		if($status && $status == 'paid')
			$this->db->where('PW.payment_status', 'Completed');
		if($status && $status == 'unpaid')
			$this->db->where('PW.payment_status', 'Incomplete');
		if($this->input->post('srch')!="")
		{
			$this->db->where("(P.name LIKE '%".$this->input->post('srch',TRUE)."%' OR M.user_id LIKE '%".$this->input->post('srch',TRUE)."%' OR M2.user_id LIKE '%".$this->input->post('srch',TRUE)."%'  OR M.name LIKE '%".$this->input->post('srch',TRUE)."%' OR M2.name LIKE '%".$this->input->post('srch',TRUE)."%')");
		}

		$this->db->order_by('field("PW.payment_status","Incomplete,Completed")');
		$this->db->order_by('PW.id','DESC');
		$query = $this->db->get();
		 $this->db->last_query();
		return $query->num_rows();
	}

	public function get_winner_lists($status, $limit, $start)
	{
		$this->db->select('P.name as product_name,PB.id as bid_id,PB.user_id,P.id as product_id, M.name as creator,M2.name as brand,PW.won_amount,ms.email,M.country,M.identification_no,M.phone,PW.product_close_date,PW.payment_status,PB.mediaid');
		$this->db->from('product_winner PW');
		$this->db->join('products P','PW.product_id=P.id');
		$this->db->join('product_bids PB', 'PB.id = PW.bid_id');
		$this->db->join('members_details M', 'PB.user_id = M.user_id');
		$this->db->join('members ms','M.user_id=ms.id');
		$this->db->join('members_details M2', 'P.brand_id = M2.user_id');
		// $this->db->where('PB.status="7"');
		if($status && $status == 'paid')
			$this->db->where('PW.payment_status', 'Completed');
		if($status && $status == 'unpaid')
			$this->db->where('PW.payment_status', 'Incomplete');
		if($this->input->post('srch')!=""){
			$this->db->where("(P.name LIKE '%".$this->input->post('srch',TRUE)."%' OR M.user_id LIKE '%".$this->input->post('srch',TRUE)."%' OR M2.user_id LIKE '%".$this->input->post('srch',TRUE)."%'  OR M.name LIKE '%".$this->input->post('srch',TRUE)."%' OR M2.name LIKE '%".$this->input->post('srch',TRUE)."%')");

		}
		$this->db->order_by('field("PW.payment_status","Incomplete,Completed")');
		$this->db->order_by('PW.id','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		  return $query->result();
		}
		return FALSE;
	}
}

