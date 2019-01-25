<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_dashboard extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function get_total_products()
	{
		$this->db->limit(7);
		$this->db->order_by('id','desc');
		$result=$this->db->get('car_management');
		if($result):
			return $result->result();
		else:
			return false;
		endif;	
		
	}
	
	function total_site_commissions()
	{
		// $this->db->select('SUM( quantity * sale_commission ) as totalcommission');
		// $this->db->from('product_order');
		// $this->db->where('status !=',1);
		// $query = $this->db->get();
		// if($query->num_rows() > 0)
		// {
		// 	$data = $query->row();
		// 	return $data->totalcommission;
		// }
		// return false;
	}
	
	function get_total_revenue($transaction_type="")
	{
		$this->db->select('SUM( amount ) as total_amount');
		$this->db->from('transaction');
		$this->db->where('transaction_status','Completed');
		$this->db->where('transaction_type', $transaction_type);
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data->total_amount;
		}
		return 0;
	}
	
	function count_total_sold_products()
	{
		//count the sales order from sales order table
		$this->db->where('payment_status', 'Completed');
		$query = $this->db->get('product_winner');
		
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0)
		{
			$data = $query->row();
		}
		return 0;
	}
	
	
	public function get_admin_recent_inbox($usertype)
	{
     	$admin_id=1;
	    $this->db->where('receiver_id',$admin_id); 
        if($usertype=='influencer')
        {
        	 $this->db->where('m.user_type','4');
        }
        else if($usertype=='advertiser')
        {
        	$this->db->where('m.user_type','3');
        }
        $this->db->where('receiver_id',$admin_id);
        $this->db->from('communication c ');
        $this->db->join('members m','c.sender_id=m.id');
         $this->db->join('members_details md','m.id=md.user_id');
        $this->db->order_by("messagedate", "desc");
        $this->db->limit(6);
      
	   	$query = $this->db->get();
	   	// print_r($query->result());
           // echo $this->db->last_query();
        if ($query->num_rows() > 0){
               return $query->result();
        }
        else{
        	return false;
       	}
    }
	
	public function get_recent_members($usertype)
	{
		$this->db->select('m.id, m.username, m.email, m.reg_date,md.name');
		$this->db->where('status',1);
		if($usertype=='advertiser')
		{
			$this->db->where_in('user_type',array('3'));
		}
		else if($usertype=='influencer')
		{
			$this->db->where_in('user_type',array('4'));
		}
		else
		{
			$this->db->where_in('user_type',array('3','4'));
		}
		$this->db->order_by("reg_date", "DESC");
		$this->db->from('members m');
		$this->db->join('members_details md','m.id=md.user_id');
        $this->db->limit(6);
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
		return false;
	}
	
	
	public function get_recent_products()
	{
		$this->db->select('P.name, P.brand_id, P.post_date, PC.name as cat_name,m.username');
		$this->db->from('products P');
		$this->db->join('members m', 'm.id = P.brand_id');
		$this->db->join('category PC', 'P.cat_id = PC.id', 'left');
		// $this->db->where('P.listing_payment_status','1');
		$this->db->order_by("P.post_date", "DESC");
		$this->db->limit(6);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
		  return $query->result();
		}
		return FALSE;
	}
	
}
