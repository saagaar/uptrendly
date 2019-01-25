<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function count_all_public_auctions()
	{
		$current_time = $this->general->get_local_time('now');
		$this->db->select('P.id, P.product_code, P.name, P.description, P.auc_start_time, P.auc_end_time');
		$this->db->from('products P');
		$this->db->where('P.auction_type', '1');	
		$this->db->where('auc_end_time >', $current_time); // auction end date > current date time	
		$this->db->where('P.status', '2');		
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function get_all_public_auctions($limit, $offset)
	{
		$current_time = $this->general->get_local_time('now');
		$this->db->select('P.id, P.product_code, P.name, P.description, P.auc_start_time, P.auc_end_time');
		$this->db->from('products P');
		$this->db->where('P.auction_type', '1');
		$this->db->where('auc_end_time >', $current_time); // auction end date > current date time
		$this->db->where('P.status', '2');

		if($limit)
			$this->db->limit($limit, $offset);
		$this->db->order_by('P.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}

	public function get_auction_product_details($product_id)
	{
		$this->db->select('P.id, P.product_code, P.name as product_name, P.description, P.seller_id, P.auc_start_time, P.auc_end_time,  M.username as seller_name, M.reg_date, M.is_login');
		$this->db->from('products P');
		$this->db->join('members M','P.seller_id=M.id');
		$this->db->where('P.status','2');
		$this->db->where('P.auc_start_time <=',$this->current_date);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}
	
	public function get_how_or_why_data($cms_type='')
	{
		$this->db->where('cms_type', $cms_type);
		$this->db->limit(4);
		$query = $this->db->get('cms_others');
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}
	
}// end of model