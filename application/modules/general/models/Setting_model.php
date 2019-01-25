<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
	}
	
	public $validate_profession =  array(
		array('field' => 'profession', 'label' => 'Name', 'rules' => 'required'),
		//array('field' => 'short_desc', 'label' => 'Short Description', 'rules' => 'required'),
	);
		
	public $validate_subcategory =  array(
		array('field' => 'parent_id', 'label' => 'Category', 'rules' => 'required'),
		array('field' => 'name', 'label' => 'Name', 'rules' => 'required'),
		//array('field' => 'short_desc', 'label' => 'Short Description', 'rules' => 'required'),
	);
		
	
			
	public function get_profession($id=false)
	{	
		
		if($id) $this->db->where(array('id'=>$id));
		$this->db->order_by('id','desc');		
		$query = $this->db->get('profession');
		 $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			if($id) return $query->row();
		    else return $query->result();
		} 
		return false;
	}
	
	public function insert_profession($id=false)
	{
		$data = array
		(
			'profession' => $this->input->post('profession', TRUE), 
		   	'status' => $this->input->post('is_display', TRUE),
		);

		if($id)
		{
			$this->db->update('profession',$data,array('id'=>$id));
			return $id;
		}
		else
		{
			$this->db->insert('profession',$data);	
			return $this->db->insert_id();
		}
		
		 
	}
	
	// public function get_all_category_details()
	// {	
	// 	$this->db->where('parent_id','0');
	// 	$this->db->order_by("last_update", "desc"); 		
	// 	$query = $this->db->get('category');

	// 	if ($query->num_rows() > 0)
	// 	{
	// 	   return $query->result();
	// 	} 
	// 	return false;
	// }
	
	
	
	// public function get_visible_categories()
	// {	
	// 	$this->db->where('parent_id','0');
	// 	$this->db->where('is_display','1');
	// 	$this->db->order_by('id','desc');		
	// 	$query = $this->db->get('category');

	// 	if ($query->num_rows() > 0)
	// 	{
	// 	   return $query->result();
	// 	} 
	// 	return false;
	// }
	
	
	// public function get_subcategories_by_parent_id($parent_id)
	// {	
	// 	$this->db->where('parent_id',$parent_id);
	// 	$this->db->order_by("last_update", "desc"); 		
	// 	$query = $this->db->get('category');

	// 	if ($query->num_rows() > 0)
	// 	{
	// 	   return $query->result();
	// 	} 
	// 	return false;
	// }
	
	
	// public function get_category_by_id($id)
	// {		
	// 	$query = $this->db->get_where('category',array("id"=>$id));

	// 	if ($query->num_rows() > 0)
	// 	{
	// 	   return $query->row();
	// 	} 

	// 	return false;
	// }
	
	
	// public function get_category_name_by_id($id)
	// {		
	// 	$this->db->select('name');
	// 	$this->db->where('id',$id);
	// 	$query = $this->db->get_where('category');

	// 	if ($query->num_rows() > 0)
	// 	{
	// 		$row = $query->row();
	// 	   	return $row->name;
	// 	} 

	// 	return false;
	// }
	
	
	
	
	

	// public function update_category($id)
	// {
	// 	$data = array(
	// 		'name' => $this->input->post('name', TRUE), 
	// 		'short_desc' => $this->input->post('short_desc', TRUE),
	// 		'added_date' => $this->general->get_local_time('time'),
	// 		'is_display' => $this->input->post('is_display', TRUE),
	// 		// 'display_menu' => $this->input->post('display_menu', TRUE)
	// 	);
		
	// 	$this->db->where('id', $id);
	// 	$this->db->update('category', $data);
		
	// 	return true;
	// }
	
	
	// public function insert_sub_category()
	// {
	// 	$data = array(
	// 		'parent_id' => $this->input->post('parent_id', TRUE), 
	// 	   	'name' => $this->input->post('name', TRUE), 
	// 	   	'short_desc' => $this->input->post('short_desc', TRUE),
	// 	   	'added_date' => $this->general->get_local_time('time'),
	// 	   	'is_display' => $this->input->post('is_display', TRUE),
	// 		// 'display_menu' => $this->input->post('display_menu', TRUE), 
	// 	);
		
	// 	$this->db->insert('category',$data);
	// 	return $this->db->insert_id();
	// }
	
	
	// public function update_sub_category()
	// {
	// 	$data = array(
	// 		'parent_id' => $this->input->post('parent_id', TRUE),
	// 		'name' => $this->input->post('name', TRUE), 
	// 		'short_desc' => $this->input->post('short_desc', TRUE),
	// 		'added_date' => $this->general->get_local_time('time'),
	// 		'is_display' => $this->input->post('is_display', TRUE),
	// 		// 'display_menu' => $this->input->post('display_menu', TRUE),          
	// 	);
			
	// 	//only if new img is uploaded
	// 	if(isset($this->image_name_path) && $this->image_name_path !="")
	// 	{
	// 		//@unlink('./'.$this->input->post('old_img'));
	// 		$data['image'] = $this->image_name_path;
	// 	}
			
	// 	$id = $this->uri->segment(4);
	// 	$this->db->where('id', $id);
	// 	$this->db->update('category', $data);
	// 	return $id;
	// }
	
}
