<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load CI library
			$this->load->library('form_validation');		
		//load custom module
			$this->load->model('Admin_change_password');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index()
	{
		$this->form_validation->set_rules('old_password', 'Old Password','required|callback_check_oldpassword');
		$this->form_validation->set_rules('new_password', 'New Password','required|callback_checkpassword');
		$this->form_validation->set_rules('re_password', 'Confirm Password','required|matches[new_password]');
		
		if($this->form_validation->run()==TRUE)
		{
			//update site setting
			$this->Admin_change_password->update_admin_password();
			
			//echo $this->db->last_query(); exit;
			$this->session->set_flashdata('message','The password has been changed. Please login again.');
			//remove session of admin
			if ($this->general->admin_logout()){redirect(ADMIN_LOGIN_PATH, 'refresh');exit;}
			
		}
		$this->data = '';
		$this->template
			->set_layout('admin_dashboard')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.'- Change Password')
			->build('change_password', $this->data);	
		
	}
	
	public function check_oldpassword($password)
    {
		$option = array('id'=>$this->session->userdata(ADMIN_LOGIN_ID));
		$query = $this->db->get_where('members',$option);
		$record = $query->row();
		
		//echo $this->db->last_query(); exit;
		//echo $record->password; echo "<br>"; exit;
		//echo $this->general->hash_password($this->input->post('old_password',TRUE),$record->salt); exit;
		
		if(isset($record->password) && $record->password===$this->general->hash_password($this->input->post('old_password',TRUE),$record->salt))
		{
			return TRUE;	
		}
		else
		{
			$this->form_validation->set_message('check_oldpassword', 'Old Password does not match');
			return FALSE;			
		}
     }

     public function checkpassword()
     {
	  	$query = $this->db->get_where('members', array('id' =>$this->session->userdata(ADMIN_LOGIN_ID)));
        $row = $query->row();
               
        if($row->username == $this->input->post('new_password'))
        {
        	$this->form_validation->set_message('checkpassword', 'Username and Password cannot be same.');
            return false;
        }
        else
        	return true;
     }
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */