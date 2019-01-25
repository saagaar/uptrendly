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
		$this->load->library('upload');
			
		//load custom module
		$this->load->model('admin_payment_model');	
			
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
			
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index()
	{
		redirect(ADMIN_DASHBOARD_PATH.'/payment/paypal','refresh');
	}
	
	public function paypal()
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('paypal-payment', $this->admin_permissions)):
			
			$this->data['current_menu']='paypal';
			
			$this->form_validation->set_rules($this->admin_payment_model->validate_paypal);
			
			//make file settins and do upload it
			if(isset($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name']!='')
			{
				$this->admin_payment_model->file_settings_do_upload();
				$image_data = $this->upload->data();			
				$logo_full_path = PAYMENT_API_LOGO_PATH.$image_data['file_name'];
				
				$file_error = $this->upload->display_errors();
			}
			else
			{
				$file_error = '';
				$logo_full_path = '';
			}
				
			if($this->form_validation->run()==TRUE && !$file_error)
			{
				//update site setting
				$trans = $this->admin_payment_model->update_paypal_settings($logo_full_path);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Payment Gateway', 'module_desc' => 'Paypal details Updated', 'action' => 'Edit', 'extra_info' => ''));
					}	
				$this->session->set_flashdata('message','The PayPal Gateway API updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Payment Gateway', 'module_desc' => 'Unable to update Paypal details', 'action' => 'Edit', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','unable to change PayPal Gateway API details.');
				}

				redirect(ADMIN_DASHBOARD_PATH.'/payment/paypal','refresh');
				exit;
			}
	
			$this->data['payment'] = $this->admin_payment_model->get_payment_gateway_info(1);
			//print_r($this->data['payment']);
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title('Payment Management System | '.WEBSITE_NAME)
				->build('admin_paypal', $this->data);
				
		else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - CMS Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	
	
	
	
	public function servired()
	{
		$this->data['current_menu']='global';
		
		$this->form_validation->set_rules($this->admin_payment_model->validate_servired);
		
		//make file settins and do upload it
		if(isset($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name']!='')
		{
			$this->admin_payment_model->file_settings_do_upload();
			$image_data = $this->upload->data();			
			$logo_full_path = PAYMENT_API_LOGO_PATH.$image_data['file_name'];
			
			$file_error = $this->upload->display_errors();
		}
		else
		{
			$file_error = '';
			$logo_full_path = '';
		}
			
		if($this->form_validation->run()==TRUE && !$file_error)
		{
			//update site setting
			$this->admin_payment_model->update_servired_settings($logo_full_path);
			$this->session->set_flashdata('message','The Payment Gateway API updated successfully.');
			redirect(ADMIN_DASHBOARD_PATH.'/payment/servired','refresh');
			exit;
		}
		
		
		$this->data['payment'] = $this->admin_payment_model->get_payment_gateway_info(2);
		//print_r($this->data['payment']);
		
		$this->template
			->set_layout('admin_dashboard')
			->enable_parser(FALSE)
			->title('Payment Management System | '.WEBSITE_NAME)
			->build('admin_servired', $this->data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */