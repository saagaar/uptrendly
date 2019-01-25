<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin_how_why_reverse extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->image_name_path = '';
	}
	
	public $validate_cms =  array(
			array('field' => 'title', 'label' => 'Title', 'rules' => 'required'),
			// array('field' => 'slug', 'label' => 'Slug', 'rules' => 'callback_check_slug'),
			array('field' => 'description', 'label' => 'Description', 'rules' => 'required'),
		);
		
	
	//added by pradip
	public function get_cms_lists_by_cms_type($cms_type)
	{	
		if($cms_type!=''){
			$this->db->where('cms_type',$cms_type);
		}
		$this->db->order_by('cms_type DESC, title ASC, id DESC');		
		$query = $this->db->get('cms_others');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
	}
	
	
	
	
	public function get_cms_details_by_id($id)
	{	
		$this->db->where('id',$id);
		$query = $this->db->get('cms_others');
		
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		}
		return false;
	}
	
	//added by pradip
	public function insert_cms()
	{
		$cms_data = array(					   
			   'title' => $this->input->post('title', TRUE),
			   'description' => $this->input->post('description', TRUE),
			   // 'cms_slug' => $this->general->clean_url($slug),
			   'is_display' => $this->input->post('is_display', TRUE),
			   'cms_type' => $this->input->post('cms_type', TRUE),
			   'image' => $this->image_name_path,
			);

		// if(!empty($_FILES['image']['name']))
		// {
		// 	//make file settins and do upload it
		// 	$image1_name = $this->file_settings_do_upload('image');
			
  //           if ($image1_name['file_name'])
  //           {
		// 		$this->image_name_path1 = $image1_name['file_name'];				
  //           }
  //           else
  //           {
		// 	   $image_error = TRUE;
  //           }
		// }
		// $cms_data['image'] = $this->image_name_path1;
		$this->db->insert('cms_others', $cms_data); 
		return $this->db->insert_id();
	}
	
	
	//added by pradip
	public function update_cms($cms_id)
	{
		
		$cms_data = array(					   
			   'title' => $this->input->post('title', TRUE),
			   'description' => $this->input->post('description', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),
			   'cms_type' => $this->input->post('cms_type', TRUE),
		);
		if(isset($this->image_name_path) && $this->image_name_path !="")
		{
			@unlink('./'.HOW_AND_WHY_IMAGES.$this->input->post('old_img'));
			$cms_data['image'] = $this->image_name_path;
		}	
		$this->db->where('id', $cms_id);
		$query = $this->db->update('cms_others', $cms_data);
		return true;
	}
	
	
	
	public function get_cms_by_slug($slug)
	{
		$this->db->select('id,title,description,cms_slug');
		$this->db->where('cms_slug',$slug);
		$query = $this->db->get('cms_others');

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
	}

	public function file_settings_do_upload($file)
	{
		$config['upload_path'] = './'.HOW_AND_WHY_IMAGES;//define in constants
		$config['allowed_types'] = 'gif|jpg|png';
		$config['remove_spaces'] = TRUE;		
		$config['max_size'] = '2000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$this->upload->initialize($config);
		//print_r($_FILES);
		
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			$this->error_img = $this->upload->display_errors();
			// echo $this->error_img;
			return false;
		}
		else
		{
			$data = $this->upload->data();
			return $data;
		}			
	}

	public function upload_image($job)
	{
		$image_error = FALSE;
		$this->session->unset_userdata('error_img');
		
		// Upload image 1
		if(($_FILES && $job =='Add') || (!empty($_FILES['image']['name']) && $job =='Edit'))
		{
			//make file settins and do upload it
			$image_name = $this->file_settings_do_upload('image');
			
            if ($image_name['file_name'])
            {
				$this->image_name_path = $image_name['file_name'];
				//resize image
				// $this->resize_image($this->image_name_path,'thumb_'.$image_name['raw_name'].$image_name['file_ext'],120,120); //55,74
            }
            else
            {
			   $image_error = TRUE;
               $this->session->set_userdata('error_img',$this->error_img);
            }
		}
			return $image_error;
	}
	
}
