<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		//load custom language library
		$this->load->library('my_language');
				
		if(SITE_STATUS == '2')
		{
			redirect($this->general->lang_uri('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			redirect($this->general->lang_uri('/maintainance'));exit;
		}
		 
		 //check banned IP address
		$this->general->check_banned_ip();
		
	    //load upload and image library
		$this->load->library('upload');
		$this->load->library('image_lib');
		
		//load module
		$this->load->model('user_model');
	}
	
	
	
	public function index()
	{
		//dont show third nav menu
		$this->data['header_navigation_menu'] = 'inactive';
		$seller = intval($this->uri->segment('3'));
		//echo $seller; exit;
		
		$this->data['seller'] = $this->general->get_member_names_by_member_id($seller);
		
		//redirect to home page if seller data is not found
		if(!$this->data['seller']){redirect($this->general->lang_uri('/'),'refresh'); exit;}
		
		$this->data['image']=$this->user_model->get_image($seller);
		
		//echo "<pre>"; print_r($this->data['seller']); echo "</pre>"; //exit;
		
		$this->data['positive_feedback']=$this->user_model->get_total_positive_rating($seller);
		$this->data['negative_feedback']=$this->user_model->get_total_negative_rating($seller);
		$this->data['neutral_feedback']=$this->user_model->get_total_neutral_rating($seller);
		
		$config = array();
		//$config["base_url"] = $this->general->lang_uri('/usr/'.$seller."/".$seller_name);
		
		$config["base_url"] = $this->general->lang_uri('/usr/'.$seller);
		
		$config["total_rows"] = $this->user_model->count_total_item_for_sale($seller);
		
		$config['prev_link'] = lang('previous');
  		$config['next_link'] = lang('next');
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = ' <li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>'; 
		$config["per_page"] = 12;
		$config["uri_segment"] = 4;
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		//total number of products
		$this->data["total_rows"] = $this->user_model->count_total_item_for_sale($seller);
		
		$this->data['get_all_items'] = $this->user_model->get_total_items_for_sale($config["per_page"],$page,$seller);
		
		$this->data["links"] = $this->pagination->create_links($config["per_page"], $page);
		
		//set SEO data
		$this->page_title =lang('seo_user_profile_page_title'). WEBSITE_NAME;
		$this->data['meta_keys'] = WEBSITE_NAME;
		$this->data['meta_desc'] = WEBSITE_NAME;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_user', $this->data);
	}
	
	
	
	//added by rabi for all feedback details
	public function all_feedback()
	{
		$seller = $this->uri->segment('4');
		
		$this->data['seller'] = $this->general->get_member_complete_details_by_user_id($seller);
		
		if(!$this->data['seller']){redirect($this->general->lang_uri('/'),'refresh'); exit;}
		
		$config = array();
		$config["base_url"] = $this->general->lang_uri('/usr/feedback/'.$seller);
		$config["total_rows"] = $this->user_model->count_my_total_feedbacks($seller);
		$config['prev_link'] = lang('previous');
  		$config['next_link'] = lang('next');
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = ' <li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>'; 
		$config["per_page"] = 2;
		$config["uri_segment"] = 5;
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data['total_feedback_buyer_toseller'] = $this->user_model->my_total_feedbacks($config["per_page"], $page,$seller);
		
		//echo "<pre>"; print_r($this->data['total_feedback']); echo "</pre>"; exit;
		
		//echo "<pre>"; print_r($this->data['seller']); echo "</pre>"; exit;
				
		$this->data["links1"] = $this->pagination->create_links($config["per_page"], $page);
		
		
		//pagination for buyer to seller feedback message
		$config = array();
		$config["base_url"] = $this->general->lang_uri('/usr/feedback/'.$seller);
		$config["total_rows"] = $this->user_model->count_my_total_feedbacks_to_seller($seller);
		$config['prev_link'] = lang('previous');
  		$config['next_link'] = lang('next');
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = ' <li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>'; 
		$config["per_page"] = 2;
		$config["uri_segment"] = 5;
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data['total_feedback_seller_tobuyer'] = $this->user_model->my_total_feedbacks_to_seller($config["per_page"], $page,$seller);
		
		//echo "<pre>"; print_r($this->data['total_feedback']); echo "</pre>"; exit;
				
		$this->data["links2"] = $this->pagination->create_links($config["per_page"], $page);
		
		
		//positive feedback
		$this->data['positive_feedback_1mnth']=$this->user_model->get_total_feedback_positive_by_time($seller,30);
		$this->data['positive_feedback_6mnth']=$this->user_model->get_total_feedback_positive_by_time($seller,180);
		$this->data['positive_feedback_12mnth']=$this->user_model->get_total_feedback_positive_by_time($seller,365);
		
		//nuetral feedback
		$this->data['neutral_feedback_1mnth']=$this->user_model->get_total_feedback_neutral_by_time($seller,30);
		$this->data['neutral_feedback_6mnth']=$this->user_model->get_total_feedback_neutral_by_time($seller,180);
		$this->data['neutral_feedback_12mnth']=$this->user_model->get_total_feedback_neutral_by_time($seller,365);
		
		//negative feedback
		$this->data['negative_feedback_1mnth']=$this->user_model->get_total_feedback_negative_by_time($seller,30);
		$this->data['negative_feedback_6mnth']=$this->user_model->get_total_feedback_negative_by_time($seller,180);
		$this->data['negative_feedback_12mnth']=$this->user_model->get_total_feedback_negative_by_time($seller,365);
		
		
		//calculating aggregate feedback to decide whether seller is top rated seller ot not
		if($this->data['positive_feedback_12mnth']->total){
			$this->data['average_positive'] = number_format(($this->data['positive_feedback_12mnth']->total / $this->data['positive_feedback_12mnth']->times),2);
		} else	{
			$this->data['average_positive'] = '0';
		}
		
		//for negative feedback
		if($this->data['negative_feedback_12mnth']->total){
			$this->data['average_negative'] = number_format(($this->data['negative_feedback_12mnth']->total / $this->data['negative_feedback_12mnth']->times),2);
		} else	{
			$this->data['average_negative'] = '0';
		}
		
		
		
		//set SEO data
		$this->page_title =lang('seo_user_allfeedback_page_title'). WEBSITE_NAME;
		$this->data['meta_keys'] = WEBSITE_NAME;
		$this->data['meta_desc'] = WEBSITE_NAME;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_feedback_details.php', $this->data);
	}
	
	//added by rabi for uploading the profile image
	public function upload_profile_image()
	{
	 	if(SELLER_PERMISSION=='Yes'){
			$mem_id = intval($this->uri->segment('4'));
			
			$this->data['seller'] = $this->general->get_member_names_by_member_id($mem_id);
			if($this->data['seller']->user_name){
				$uname = $this->data['seller']->user_name; 
			}else{
				$uname = $this->data['seller']->name;	
		}
		
		}else {
			$mem_id = $this->session->userdata(SESSION.'user_id');	
		}

	 	$this->data['jobs'] = 'Update';
	 	$this->data['error'] = FALSE;
	 
	 	$this->data['image']=$this->user_model->get_image($mem_id);
	
	 	$upload_result = $this->user_model->upload_profile_images($this->data['jobs']);
		
	 
	 	if( !empty($_FILES['profile_pic']['tmp_name']) && $upload_result == FALSE && $this->data['error'] == FALSE)
        {
  	    	$this->user_model->update_profile_photo($mem_id);
		}
		if(SELLER_PERMISSION=='Yes'){
			redirect($this->general->lang_uri('/usr/'.$mem_id."/".$uname),'refresh');
			exit;
		} else {
			redirect($this->general->lang_uri('/my-bidcy/user'),'refresh');
			exit;
		}
		
	}
	
	//added by rabi for uploading the cover image
	public function upload_cover_image()
	{
	 	$mem_id = intval($this->uri->segment('4'));
	 	$this->data['seller'] = $this->general->get_member_names_by_member_id($mem_id);
		if($this->data['seller']->user_name){
			$uname = $this->data['seller']->user_name; 
		}else{
			$uname = $this->data['seller']->name;	
		}
	 
	 	$this->data['jobs'] = 'Update';
	 	$this->data['error'] = FALSE;
	 
	 	$this->data['image']=$this->user_model->get_image($mem_id);
	
	 	$upload_result = $this->user_model->upload_profile_images($this->data['jobs']);
	 
	 	if( !empty($_FILES['cover_pic']['tmp_name']) && $upload_result == FALSE && $this->data['error'] == FALSE)
        {
  	    	$this->user_model->update_cover_photo($mem_id);
		}
		redirect($this->general->lang_uri('/usr/'.$mem_id."/".$uname),'refresh');
		exit;
	}
	
	//added by rabi for uploading the cover image
	public function update_info_text()
	{
		if(!$this->input->is_ajax_request())
	  	{
      		exit('No direct script access allowed');
      	}
	  
		$mem_id = $this->uri->segment('4');
		$info_text=$this->input->post('info_text');
	
		$data['info_text'] =$info_text;
		$this->db->where('user_id', $mem_id);
		$this->db->update('members_details', $data);
		echo "success@@".$info_text;
	}
	
	public function contact_seller()
	{
	 if(!$this->input->is_ajax_request())
		{
        	exit('No direct script access allowed');
        }
	    if($this->user_model->send_email())
		echo "success";
		else
		echo "failed";
	  }
		
}