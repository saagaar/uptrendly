<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eactivation extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		//load custom language library
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
		
		
		$this->load->model('register_model');
	}
	

	//email change activation
	public function index($code='', $id='')
	{	
		
		if(!isset($id) OR $id == '') {redirect(site_url(''));}
		if(!isset($code) OR $code == '') {redirect(site_url(''));}
		 
		$query = $this->db->get_where('members',array('activation_code'=>$code,'id'=>$id));
		 
		/*echo $this->db->last_query();
		echo "<br><br>";
		echo $id; exit;*/
		
		if($query->num_rows()>0)
        {
			$user_data = $query->row_array();
			
			$user_id=$user_data['id'];
			$new_email=$user_data['new_email'];
			
			$duplicate_email = $this->db->get_where('members',array('email'=>$new_email));
			
			// $this->db->last_query();
			//echo $id; exit;
			//echo "<br>".$duplicate_email->num_rows(); exit;
			if($duplicate_email->num_rows()==0)
			{
				$data=array('email'=>$new_email);
				$this->db->where('id',$id);
				$this->db->update('members',$data);
				
				$this->data['class'] = 'alert-success';
				$cms_id = 17;
			}
			else
			{
				$cms_id = 18;
				$this->data['class'] = 'alert-danger'; 
			}	 
		}
		else
		{
			//$this->session->set_flashdata('message','No valid info to update new email!');
			redirect(site_url(''));   
		}
		 
		$this->data['cms'] = $this->general->get_cms_details($cms_id);
		
		//set SEO data
		$this->page_title = 'Change Email Confirmation'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('v_cms_data', $this->data);
		 
	}
	
	

}