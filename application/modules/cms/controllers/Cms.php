<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller 
{

	function __construct() 
	{
		parent::__construct();
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			//check whetheh logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
			if(!$this->session->userdata('MAINTAINANCE_KEY')=='YES' OR $this->session->userdata('MAINTAINANCE_KEY')!='YES'){
				redirect(site_url('/maintainance'));exit;
			}
		}
		//load custom module
		$this->load->model('Admin_cms');
		
		//load custom helper
		$this->load->helper('editor_helper');
	}
	
	public function index($slug='')
	{
		if($slug=='contact')
		{
			$this->data['page_title'] = 'Contact-Us'.' - '. WEBSITE_NAME;
			$this->data['meta_keys'] = "";
			$this->data['meta_desc'] = "";
			$view='V_contact';
		}else{
			$this->data['account_menu_active']=false;
			$this->data['cms_data'] = $this->Admin_cms->get_cms_by_slug($slug)	;
			if($this->data['cms_data']== FALSE) {redirect(site_url(''));}

			if($this->data['cms_data']->page_title!=''){  $this->data['page_title'] = $this->data['cms_data']->page_title; }
			else{ $this->data['page_title']=WEBSITE_NAME."- ".$this->data['cms_data']->heading;}

			if($this->data['cms_data']->meta_key!=''){	$this->data['meta_keys'] = $this->data['cms_data']->meta_key; }
			else{ $this->data['meta_keys']=WEBSITE_NAME; }

			if($this->data['cms_data']->meta_description!='') {	$this->data['meta_desc'] = $this->data['cms_data']->meta_description; }
			else{ $this->data['meta_desc']=WEBSITE_NAME;}
			$view='v_cms';
		}
		$this->template
		->set_layout('general')
		->enable_parser(FALSE)
		->title($this->data['page_title'])
		->build($view,$this->data);
	}

	public function submitcontact(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->Admin_cms->validate_contact_form);
		
		if($this->form_validation->run() === TRUE)
		{	
			$name 		=	$this->input->post('name');
			$contact 	=	$this->input->post('contactno');
			$email 		= 	$this->input->post('email');
			$message 	=	$this->input->post('message');
			
			$parseElement = array(
				"name"		=> $name, 
				"contact"	=> $contact,
				"email"		=> $email,
				"message"	=> $message
			);	
			$template_id = 54;
			$from=SYSTEM_EMAIL;
			$to=CONTACT_EMAIL;
			$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());	
			$this->session->set_flashdata('success_message','Query submission sucessful. Thank you for your interest.');
			redirect(site_url('page/contact'), 'refersh');
		}
			
		
			$this->data['page_title'] = 'Contact-Us'.' - '. WEBSITE_NAME;
			$this->data['meta_keys'] = "";
			$this->data['meta_desc'] = "";
			$view='V_contact';
		 $this->template
		->set_layout('general')
		->enable_parser(FALSE)
		->title($this->data['page_title'])
		->build($view,$this->data);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */