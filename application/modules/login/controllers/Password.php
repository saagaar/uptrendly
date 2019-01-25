<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {
    function __construct()
    {
        parent::__construct();  
		
		//load CI library
			$this->load->library('form_validation');		
		//load custom module
			$this->load->model('password_model');
			$this->load->model('email_model');
        
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        //$this->lang->load('investor');
    }
	
    public function index(){
        $this->forget();
    }
	
    public function forget()
	{
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
            $this->form_validation->set_rules($this->password_model->validate_password_forget);
            if($this->form_validation->run()==TRUE)
			{
                if($this->password_model->check_email() == 1)
				{
					$this->password_model->admin_send_Password_reset_email();
					$this->session->set_flashdata('password_success', 'Mail sent Successfully');
					//echo "happy"; exit;	
				}
				else
				{
					 $this->session->set_flashdata('login_message', 'Invalid Username');
					 //echo "sad"; exit;
				}
                 redirect('login/password/forget');
            }
        }
		
        if($this->session->flashdata('password_success'))
		{
            $data['message'] = $this->session->flashdata('password_success');
            $data['admin_captcha'] = $this->password_model->get_captcha();
            $this->template
			->set_layout('admin_login')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.' - Admin Panel - Forget Password')
			->build('forget-success', $data);
        }
		else
		{
            $data['message'] = $this->session->flashdata('login_message');
            $data['admin_captcha'] = $this->password_model->get_captcha();
            $this->template
				->set_layout('admin_login')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Forget Password')
				->build('forget', $data);
        } 
    }
	
	
	

    public function reload(){
        if($this->input->is_ajax_request())
		{
            echo $this->password_model->get_captcha();
        }
        else
		{
            return $this->password_model->get_captcha();
        }
    }
    
   public function _captcha_code_forget($code)
   {
        if (strcasecmp($code,$this->session->userdata('admin_captcha')) == 0)
        {            
            return TRUE;
        }        
        else
        {
	    	$this->form_validation->set_message('_captcha_code_forget', 'Verification Code doesnot match');            
            return FALSE;
        }
    }
	
}