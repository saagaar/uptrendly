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
		//load upload libarary	
			$this->load->library('upload');		
		
		//load file helper
		$this->load->helper('file');			
		//load custom module
		$this->load->model('admin_site_settings');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	
	public function index()
	{
		$data['admin_permissions'] = $this->admin_permissions;
		 
		if(array_key_exists('site-setting', $this->admin_permissions)):
		  
			//Changing the Error Delimiters
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
			// Set the validation rules
			$this->form_validation->set_rules($this->admin_site_settings->validate_site_settings);
			
			if(SMS_NOTIFICATION==1){
				$this->form_validation->set_rules($this->admin_site_settings->validate_sms_settings);
			}
			if($this->input->post('site_status',TRUE)=='3'){
				$this->form_validation->set_rules('maintainance_key','Maintainance Key','required');
			}
			
			//make file settins and do upload it
			if(isset($_FILES['site_logo']['tmp_name']) && $_FILES['site_logo']['tmp_name']!='')
			{
				$this->admin_site_settings->file_settings_do_upload();
				$image_data = $this->upload->data();			
				$img_full_path = WEBSITE_LOGO_PATH.$image_data['file_name'];
				
				$file_error = $this->upload->display_errors();
			}
			else
			{
				$file_error = '';
				$img_full_path = '';
			}
			
		
			if($this->form_validation->run()==TRUE):
				//update site setting
				$trans = $this->admin_site_settings->update_site_settings($img_full_path);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Site Settings', 'module_desc' => 'Site settings Updated', 'action' => 'Edit', 'extra_info' => ''));
					}	
				$this->session->set_flashdata('message','The PayPal Gateway API updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Site Settings', 'module_desc' => 'Unable to update Site settings', 'action' => 'Edit', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','unable to update Site settings.');
				}
				
				$this->session->set_flashdata('message','The site settings records updated successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/site-settings/index','refresh');
				exit;
			endif;
		
			$this->data['site_set'] = $this->admin_site_settings->get_site_setting();
			$this->data['socialmedia_set'] = $this->general->get_data('socialmedia_settings');
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Site Settings')
				->build('site_settings', $this->data);
		
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
				->build('administrator-denied');
        endif;
	}	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */