<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Help extends CI_Controller 
	{
	   function __construct() {
		
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
		
		//check banned IP address
		$this->general->check_banned_ip();
		
		//load model
		$this->load->model('front_help');
	}
	
	
	
	public function index()
	{
	
		$this->data['help_contents'] = $this->front_help->get_help_contents();

		$seo_data = $this->general->get_seo(3);
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
		    $this->page_title = WEBSITE_NAME;
		    $this->data['meta_keys']= WEBSITE_NAME;
		    $this->data['meta_desc']= WEBSITE_NAME;
		}	 
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('v_help_body', $this->data);	
	}
	
}
/* End of file help.php */
/* Location: ./application/controllers/welcome.php */