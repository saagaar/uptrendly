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
		$this->load->model('admin_email_settings');

		//load custom helper
		$this->load->helper('editor_helper');
		
		// get array of permissions for logged in use type
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	
	public function index()
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('email-settings', $this->admin_permissions)):
			
			$this->data['current_menu'] = 'view_templates';
			
			$this->data['email_templates']= '';
			$this->data['email_templates'] = $this->admin_email_settings->get_email_settings_all_templates();
			//echo "<pre>"; print_r($this->data['email_templates']); echo "</pre>"; exit;
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Email Settings Management')
				->build('a_list_email_templates', $this->data);
			
		else:
				$this->template
					->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Email Settings Maangement')
					->build('administrator-denied', $data);

        endif;	
	}
	
	public function detail($email_code='')
	{
		if($email_code==''){redirect(ADMIN_DASHBOARD_PATH.'/email-settings/index', 'refresh');exit;}
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('email-settings', $this->admin_permissions)):

			$this->data['current_menu'] = 'update';
			
			//Changing the Error Delimiters
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			//print_r($_POST);
			// Set the validation rules
			$this->form_validation->set_rules($this->admin_email_settings->validate_settings);
			
			if(SMS_NOTIFICATION==1)
			$this->form_validation->set_rules($this->admin_email_settings->validate_sms_settings);
			

			if($this->form_validation->run()==TRUE)
			{

				$trans = $this->admin_email_settings->update_email_settings();
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Email Settings', 'module_desc' => 'Email Template Updated', 'action' => 'Edit', 'extra_info' => 'Email Code: '.$email_code));
					}
					
					$this->session->set_flashdata('message','Email setting updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Email Settings', 'module_desc' => 'Email Template Update Error', 'action' => 'Edit', 'extra_info' => 'Email Code: '.$email_code));
					}
					
					$this->session->set_flashdata('message','Unable to edit Email setting.');
				}
				
				redirect(ADMIN_DASHBOARD_PATH.'/email-settings/index/','refresh');
				exit;
			}
			
			
			$this->data['email_data'] = $this->admin_email_settings->get_email_settings_details_by_emailcode($email_code);
			//echo "<pre>"; print_r($this->data['email_data']); echo "</pre>"; exit;
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Email Settings Management')
				->build('a_edit_email_template', $this->data);
			
		else:
				$this->template
					->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Email Settings Management')
					->build('administrator-denied', $data);

        endif;	
	}

	

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */