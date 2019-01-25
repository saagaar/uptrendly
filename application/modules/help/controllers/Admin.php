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
		$this->load->model('admin_help');
		
		//load helper
		$this->load->helper('editor_helper');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{	
		$this->data['current_menu'] = 'all_help';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-help', $this->admin_permissions)):
		
			$this->data['help_data'] = $this->admin_help->get_help_lists();
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Help View')
				->build('a_view_help', $this->data);
		
		else:
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Help Management')
				->build('administrator-denied', $data);

        endif;	
	}
	
	
	//add help content
	public function add_help()
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-help', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'add_help';
			$this->data['jobs'] = 'Add';
			//$name = $this->input->post('name');
			//print_r($name[1]);//exit;
			$this->data['error'] = FALSE;
			
			// $this->data['category_data'] = $this->admin_help->get_visible_categories();
			
			// Set the validation rules
			$this->form_validation->set_rules($this->admin_help->validate_help_settings);		
			
			if($this->form_validation->run()==TRUE && $this->data['error'] == FALSE)
			{			
				//Insert Lang Settings
				$trans = $this->admin_help->insert_help();
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Help', 'module_desc' => 'Help Added', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','Help record inserted successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Help', 'module_desc' => 'Unable to Add Help', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Help record.');
				}

				redirect(ADMIN_DASHBOARD_PATH.'/help/index','refresh');
				exit;
			}
			
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Add Help')
				->build('a_add_help', $this->data);	
				
		else:
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Help Management')
				->build('administrator-denied', $data);

        endif;	
	}
	
	
	//edit help content
	public function edit_help($help_id='')
	{
		if($help_id == ''){redirect(ADMIN_DASHBOARD_PATH.'/help/index','refresh');exit; }
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-help', $this->admin_permissions)):
			$this->data['current_menu'] = 'edit_help';
			$this->data['data_help'] = $this->admin_help->get_help_byid($help_id);
						
			//Set the validation rules
			$this->form_validation->set_rules($this->admin_help->validate_help_settings);
			if($this->form_validation->run()==TRUE)
			{
				//print_r($_POST); exit;
				//update help records
				$trans = $this->admin_help->update_help($help_id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Help', 'module_desc' => 'Help Updated', 'action' => 'Update', 'extra_info' => 'help id: '.$help_id));
					}
					
					$this->session->set_flashdata('message','Help records updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Help', 'module_desc' => 'Unable to Update Help', 'action' => 'Edit', 'extra_info' => 'help id: '.$help_id));
					}
					
					$this->session->set_flashdata('message','Unable to Update Help.');
				}
				
				
				redirect(ADMIN_DASHBOARD_PATH.'/help/index/','refresh');			
				exit;
			}
			
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Edit Help')
				->build('a_edit_help', $this->data);
				
		else:
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Help Management')
				->build('administrator-denied', $data);

        endif;	
	}
	
	
	//delete help
	public function delete_help($id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-help', $this->admin_permissions)):
		
			$query = $this->db->get_where('help', array('id' => $id));
	
			if($query->num_rows() > 0) 
			{
				$this->db->delete('help', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
				$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Help', 'module_desc' => 'Help Deleted', 'action' => 'Delete', 'extra_info' => 'help id: '.$id));
				}
				
				$this->session->set_flashdata('message','Help record deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/help/index/','refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Help', 'module_desc' => 'unable to delete Help', 'action' => 'Delete', 'extra_info' => 'help id: '.$id));
				}
				
				$this->session->set_flashdata('message','Sorry! no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/help/index/','refresh');
				exit;
			}
		
				
		else:
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Help Management')
				->build('administrator-denied', $data);

        endif;	
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */