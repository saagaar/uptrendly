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
			array('field' => 'package_name', 'label' => 'Package Name ', 'rules' => 'required'),
			array('field' => 'bids', 'label' => 'Bids', 'rules' => 'required|integer'),
			array('field' => 'cost', 'label' => 'Cost', 'rules' => 'required|numeric'),
			array('field' =>'package_type','label'=>'Package Type','rules'=>'required')
			// array('field' => 'valid_time', 'label' => 'Valid Time', 'rules' => 'trim|required'),
			
		);
		
	public function get_bid_package()
	{	
        $this->db->order_by("bids", "asc"); 
	    $query = $this->db->get('membership_package');
		
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}	
	
	public function get_bidpackage_by_id($id)
	{
		$query = $this->db->get_where('membership_package',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	public function insert_bidpackage_record()
	{
		$data = array(
               'package_name' => $this->input->post('package_name', TRUE),
			   'bids' => $this->input->post('bids', TRUE),
			   'cost' => $this->input->post('cost', TRUE),
			   'member_type' => $this->input->post('member_type', TRUE),
			   'valid_time' => $this->input->post('valid_time', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),	
			   'package_type'=>$this->input->post('package_type',true)      
            );

		$this->db->insert('membership_package', $data); 
        return $this->db->affected_rows();


	}
	
	public function update_bidpackage_record($id)
	{
		$data = array(
			   'package_name' => $this->input->post('package_name', TRUE),
			   'bids' => $this->input->post('bids', TRUE),
			   'cost' => $this->input->post('cost', TRUE),
			   'member_type' => $this->input->post('member_type', TRUE),
			   'valid_time' => $this->input->post('valid_time', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),				   		   			   
			   'update_date' => $this->general->get_local_time('time'),  
			   'package_type'=>$this->input->post('package_type',true)          
            );

		$this->db->where('id', $id);
		$this->db->update('membership_package', $data);
		return $this->db->affected_rows();
	}

}
