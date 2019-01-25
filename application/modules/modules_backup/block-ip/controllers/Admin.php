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
			$this->load->model('admin_block_ip');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('blockip-setting', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'ip_list';
			$this->data['ip_data'] = $this->admin_block_ip->get_ip_details();
			
			//$this->data = '';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Block IP View')
				->build('ip_view', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
				->build('administrator-denied', $data);
						
       endif; 	
	}
	
	public function add_ip()
	{
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('blockip-setting', $this->admin_permissions)):
		
		$this->data['current_menu'] = 'add_ip';
		$this->data['jobs'] = 'Add';
		// Set the validation rules
		$this->form_validation->set_rules('ip_address', 'IP Address', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');
			
		if($this->form_validation->run()==TRUE)
		{			
			//Insert Lang Settings
			$trans = $this->admin_block_ip->insert_ip_record();
			
			if($trans)
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Block IP', 'module_desc' => 'Block IP Added', 'action' => 'Add', 'extra_info' => 'Blocked ip:'.$trans));
				}
				
				$this->session->set_flashdata('message','The IP Address is inserted successfully.');
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Block IP', 'module_desc' => 'Unable to add IP', 'action' => 'Add', 'extra_info' => ''));
				}
				
				$this->session->set_flashdata('message','Unable to add IP Address.');
			}	
			
			redirect(ADMIN_DASHBOARD_PATH.'/block-ip/index','refresh');
			exit;
		}
		
		$this->template
			->set_layout('admin_dashboard')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.' - Add IP Address')
			->build('ip_add', $this->data);
			
		else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
					->build('administrator-denied', $data);
						
       endif;
	}
	
	
	public function edit_ip($id)
	{
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('blockip-setting', $this->admin_permissions)):
			$this->data['current_menu'] = 'edit_ip';
			$this->data['jobs'] = 'Edit';
			
			//check lang id, if it is not set then redirect to view page
			if(!isset($id)){redirect(ADMIN_DASHBOARD_PATH.'/block-ip/index','refresh');exit;}
			
			$this->data['data_ip'] = $this->admin_block_ip->get_IP_by_id($id);
			
			//check lang data, if it is not set then redirect to view page
			if($this->data['data_ip'] == false){redirect(ADMIN_DASHBOARD_PATH.'/block-ip/index','refresh');exit;}
	
			// Set the validation rules
			$this->form_validation->set_rules('ip_address', 'IP Address', 'required');	
			
			if($this->form_validation->run()==TRUE)
			{	
				//Insert Lang Settings
				$trans = $this->admin_block_ip->update_ip_record($id);
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Block IP', 'module_desc' => 'Block IP Updated', 'action' => 'Edit', 'extra_info' => 'Blocked ip:'.$trans));
					}
					
					$this->session->set_flashdata('message','The Block IP Address record updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Block IP', 'module_desc' => 'Unable to Update IP', 'action' => 'Edit', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','Unable to update IP Address.');
				}
				
				
				redirect(ADMIN_DASHBOARD_PATH.'/block-ip/index','refresh');
				exit;
			}
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'-  Edit IP Address')
				->build('ip_edit', $this->data);
			
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Block IP Settings')
				->build('administrator-denied', $data);
						
       endif; 		
	}
	
	
	
	public function delete_ip($id)
	{
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('blockip-setting', $this->admin_permissions)):
		
			$query = $this->db->get_where('block_ips', array('id' => $id));
	
			if($query->num_rows() > 0) 
			{
				$this->db->delete('block_ips', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
				$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Block IP', 'module_desc' => 'Blocked IP Deleted', 'action' => 'Delete', 'extra_info' => 'id:'.$id));
			}
				
				$this->session->set_flashdata('message','The IP Address record delete successful.');
				redirect(ADMIN_DASHBOARD_PATH.'/block-ip/index','refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Block IP', 'module_desc' => 'wrong attempt to delete IP', 'action' => 'Delete', 'extra_info' => 'id:'.$id));
				}
				
				$this->session->set_flashdata('message','No record in our database.');
				redirect(ADMIN_DASHBOARD_PATH.'/block-ip/index','refresh');
				exit;
			}
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Block IP Settings')
				->build('administrator-denied', $data);
						
       endif;
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */