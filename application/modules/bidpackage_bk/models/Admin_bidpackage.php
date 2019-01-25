<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_bidpackage extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();	
	}
		
	public function file_settings_do_upload()
	{
				$config['upload_path'] = './'.BID_PACKAGE_PATH;//define in constants
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['remove_spaces'] = TRUE;		
				$config['max_size'] = '60';
				$config['max_width'] = '625';
				$config['max_height'] = '385';
				
				//load upload library and set config
				if(isset($_FILES['picture1']['tmp_name']))
				{
				
				$this->upload->initialize($config);
				$this->upload->do_upload('picture1');
		
				}						
	}
		
	public $validate_bidpackage =  array(
			array('field' => 'member_type', 'label' => 'Member Type', 'rules' => 'required'),
			array('field' => 'name', 'label' => 'Bid Package Name ', 'rules' => 'required'),
			array('field' => 'amount', 'label' => 'Price', 'rules' => 'required'),
			array('field' => 'credits', 'label' => 'Bids', 'rules' => 'required|integer'),
			array('field' => 'valid_months', 'label' => 'Valid Months', 'rules' => 'trim|integer'),
			array('field' => 'valid_days', 'label' => 'Valid Days', 'rules' => 'trim|integer'),
		);
		
	public function get_bid_package()
	{	
        $this->db->order_by("amount", "asc"); 
	    $query = $this->db->get('bidpackage');
		
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}	
	
	public function get_bidpackage_by_id($id)
	{
		$query = $this->db->get_where('bidpackage',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	public function insert_bidpackage_record()
	{
		$data = array(
               'name' => $this->input->post('name', TRUE),
			   'amount' => $this->input->post('amount', TRUE),
			   'credits' => $this->input->post('credits', TRUE),
			   'member_type' => $this->input->post('member_type', TRUE),
			   'valid_months' => $this->input->post('valid_months', TRUE),
			   'valid_days' => $this->input->post('valid_days', TRUE),
			   'display' => $this->input->post('display', TRUE),
			   'last_update' => $this->general->get_local_time('time'),			   
            );

		$this->db->insert('bidpackage', $data); 
        return $this->db->affected_rows();


	}
	
	public function update_bidpackage_record($id)
	{
		$data = array(
			   'name' => $this->input->post('name', TRUE),			   
			   'amount' => $this->input->post('amount', TRUE),
			   'credits' => $this->input->post('credits', TRUE),
			   'member_type' => $this->input->post('member_type', TRUE),
			   'valid_months' => $this->input->post('valid_months', TRUE),
			   'valid_days' => $this->input->post('valid_days', TRUE),	
			   'display' => $this->input->post('display', TRUE),			   		   			   
			   'last_update' => $this->general->get_local_time('time'),            
            );

		$this->db->where('id', $id);
		$this->db->update('bidpackage', $data);
		return $this->db->affected_rows();
	}
	
	
	

}
