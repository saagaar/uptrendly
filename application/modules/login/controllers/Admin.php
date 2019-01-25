<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//load CI library
			$this->load->library('form_validation');
			$this->load->library('encrypt');
				
		//load custom module
			$this->load->model('admin_login');
	}
	
	
	public function index()
	{
		// Check if User has logged in
		if ($this->general->admin_logged_in()){redirect(ADMIN_DASHBOARD_PATH, 'refresh');exit;}
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		//check the form validation
		if ($this->form_validation->run() == true)
		{ 
			//if the login is successful
			$admin_login_status= $this->admin_login->check_admin_login();
			if ($admin_login_status=='success')
			{
				redirect(ADMIN_DASHBOARD_PATH, 'refresh');exit;
			}
			else
			{
				//$this->session->set_flashdata('message','wrong username/password');
				$this->session->set_flashdata('message',$admin_login_status);
				redirect(ADMIN_LOGIN_PATH, 'refresh');exit;	
			}
		}
			  
		$this->data ='';
		$this->template
			->set_layout('admin_login')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.' - Admin Login')
			->build('login', $this->data);	
		
	}
	
	
	public function logout()
	{
		if ($this->general->admin_logout())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */