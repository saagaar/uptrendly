<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_help extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();	
	}

	public $validate_help_settings =  array(	
		array('field' => 'name', 'label' => 'Help Title', 'rules' => 'required'),
		array('field' => 'description', 'label' => 'Help Description', 'rules' => 'required'),		
	);

	//public function get_help_lists
	public function get_help_lists()
	{		
		$this->db->order_by('id DESC');
		
		$query = $this->db->get('help');

		if ($query->num_rows() > 0)
		{
		  return $query->result();
		} 
	}
	
	
	public function get_help_byid($id)
	{
		$query = $this->db->get_where('help',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		}
		return false;
	}
	
	public function insert_help()
	{
		//set auction details info
		$array_data = array(
			'title' => $this->input->post('name', TRUE),
		   	'description' =>$this->input->post('description'),
		   	'is_display' => $this->input->post('is_display', TRUE),
		   	'last_update' => $this->general->get_local_time('time')
		);
		//print_r($array_data); exit;		
		$this->db->insert('help', $array_data);
		return $this->db->insert_id(); 
	}
	
	
	public function update_help($id)
	{
		//set value
		$data = array(
			'title' => $this->input->post('name', TRUE),
			'description' => $this->input->post('description'),
			'is_display' => $this->input->post('is_display', TRUE),
			'last_update' => $this->general->get_local_time('time')
		);		
		$this->db->where('id', $id);
		$this->db->update('help', $data);
		
		return true;
	}
}
