<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin_cms extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public $validate_cms =  array(
		array('field' => 'heading', 'label' => 'Heading', 'rules' => 'required'),
		array('field' => 'slug', 'label' => 'Slug', 'rules' => 'required|callback_check_slug_add'),
		array('field' => 'content', 'label' => 'Content', 'rules' => 'required'),
		array('field' => 'page_title', 'label' => 'Page Title', 'rules' => 'trim'),
		array('field' => 'meta_key', 'label' => 'Meta Key', 'rules' => 'trim'),
		array('field' => 'meta_description', 'label' => 'Meta Description', 'rules' => 'trim')			
	);

	public $validate_cms_edit =  array(
		array('field' => 'heading', 'label' => 'Heading', 'rules' => 'required'),
		array('field' => 'slug', 'label' => 'Slug', 'rules' => 'required|callback_check_slug_edit'),
		array('field' => 'content', 'label' => 'Content', 'rules' => 'required'),	
		array('field' => 'page_title', 'label' => 'Page Title', 'rules' => 'trim'),
		array('field' => 'meta_key', 'label' => 'Meta Key', 'rules' => 'trim'),
		array('field' => 'meta_description', 'label' => 'Meta Description', 'rules' => 'trim')		
	);
		
	public $validate_contact_form=array(
		array('field' => 'name', 'label' => 'Name', 'rules' => 'required|min_length[1]|max_length[50]'),
		array('field' => 'contactno', 'label' => 'Contact Number', 'rules' => 'required|min_length[1]|max_length[50]'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
		array('field'=>'message','label'=>'Message','rules=>trim|required|min_length[50]|max_length[250]')
	);
	
	//added by pradip
	public function get_cms_lists_by_cms_type()
	{	
		
		$this->db->order_by('heading ASC, id DESC');		
		$query = $this->db->get('cms');
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
	}	
	
	public function get_cms_details_by_id($id)
	{	
		$this->db->where('id',$id);
		$query = $this->db->get('cms');
		
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		}
		return false;
	}
	
	//added by pradip
	public function insert_cms()
	{
		$slug = $this->input->post('slug', TRUE);
		if($slug==''){
			$slug = $this->input->post('heading', TRUE);
		}
		$slug = $this->general->clean_url($slug);
		
		
		$cms_data = array(					   
			   'heading' => $this->input->post('heading', TRUE),
			   'content' => $this->input->post('content', TRUE),
			   'cms_slug' => $slug,
			   'page_title' => $this->input->post('page_title', TRUE),
			   'meta_key' => $this->input->post('meta_key', TRUE),
			   'meta_description' => $this->input->post('meta_desc', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),
			   'created_date' =>$this->general->get_local_time('time'),
			   // 'cms_type' => $this->input->post('cms_type', TRUE),
			);
			
		$this->db->insert('cms', $cms_data); 
		return $this->db->insert_id();
		//echo $this->db->last_query(); exit;
	}
	
	//added by pradip
	public function update_cms($cms_id)
	{
		$slug = $this->input->post('slug', TRUE);
		if($slug==''){
			$slug = $this->input->post('heading', TRUE);
		}
		$slug = $this->general->clean_url($slug);
		
		$cms_data = array(					   
			   'heading' => $this->input->post('heading', TRUE),
			   'content' => $this->input->post('content', TRUE),
			   'cms_slug' => $slug,
			   'page_title' => $this->input->post('page_title', TRUE),
			   'meta_key' => $this->input->post('meta_key', TRUE),
			   'meta_description' => $this->input->post('meta_desc', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),
			   // 'cms_type' => $this->input->post('cms_type', TRUE),
			   'last_update' => $this->general->get_local_time('now'),
		);
			
		$this->db->where('id', $cms_id);
		$query = $this->db->update('cms', $cms_data);
		return TRUE;
		//echo $this->db->last_query();exit;
	}
	
	
	
	public function get_cms_by_slug($slug)
	{
		$this->db->select('id,heading,content,cms_slug,page_title,meta_key,meta_description');
		$this->db->where('cms_slug',$slug);
		$this->db->limit(1);
		$query = $this->db->get('cms');

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return FALSE;
	}
	
}
