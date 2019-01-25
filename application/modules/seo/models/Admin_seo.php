<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin_seo extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
		
	public $validate_seo =  array(
		array('field' => 'seo_page_name', 'label' => 'SEO Page', 'rules' => 'required'),
		array('field' => 'page_title', 'label' => 'Page Title', 'rules' => 'required'),
		array('field' => 'meta_key', 'label' => 'Meta Key', 'rules' => 'required'),
		array('field' => 'meta_desc', 'label' => 'Meta Description', 'rules' => 'required')
		);
		

	public function get_all_seo_pages()
	{		
		$this->db->order_by("id", "ASC");
		$query = $this->db->get('seo');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	//function that joins help table and language details table for lang name associated with the cms
	public function get_seo_details_by_id($id)
	{		
		$this->db->where('id',$id);
		$query = $this->db->get('seo');
		
		//echo $this->db->last_query(); exit;

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		}
		return false;
	}
	
	//added by pradip
	public function get_seo_lists()
	{	
		$this->db->order_by('id ASC, last_update DESC');		
		$query = $this->db->get('seo');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
	}
	
	//added by pradip
	public function insert_seo()
	{
		//set auction details info
		$array_data = array(
			'seo_page_name' => $this->input->post('seo_page_name', TRUE),				   
			'page_title' => $this->input->post('page_title', TRUE),
			'meta_key' => $this->input->post('meta_key', TRUE),
			'meta_description' => $this->input->post('meta_desc', TRUE),
			'created_date' => $this->general->get_local_time('time'),
			'last_update'=> $this->general->get_local_time('time')
		);
			
		$this->db->insert('seo', $array_data); 
		return true;
	}
	
	
	//added by pradip
	public function update_seo($id)
	{
		//set seo details info
		$update_seo_data = array(
			'seo_page_name' => $this->input->post('seo_page_name', TRUE),					
			'page_title' => $this->input->post('page_title', TRUE),
			'meta_key' => $this->input->post('meta_key', TRUE),
			'meta_description' => $this->input->post('meta_desc', TRUE),
			'last_update' => $this->general->get_local_time('time')
		);
			
			$this->db->where('id', $id);
			$this->db->update('seo', $update_seo_data);
		return true;
	}
	
	
	public function get_last_parent_id()
	{
		$this->db->select_max('parent_id');
		$query = $this->db->get('seo');
		return $query->row();
	}
	
	public function get_cms_by_slug_and_lang($slug,$current_lang_id)
	{
		$this->db->select('id,parent_id,lang_id,heading,content,cms_slug,page_title,meta_key,meta_description');
		$this->db->where('cms_slug',$slug);
		$this->db->where('lang_id',$current_lang_id);
		$query = $this->db->get('cms');

//echo $this->db->last_query(); exit;

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
	}
	
}
