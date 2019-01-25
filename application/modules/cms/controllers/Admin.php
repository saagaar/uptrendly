<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

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
			$this->load->model('admin_cms');
			//$this->load->model('language-settings/Admin_language_settings');
		
		//load custom helper
		$this->load->helper('editor_helper');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-cms', $this->admin_permissions)):
			
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
				
			$this->data['cms_data'] = $this->admin_cms->get_cms_lists_by_cms_type();
				
			$this->page_title = WEBSITE_NAME.' Content Management System';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view', $this->data);
		 
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - CMS Settings')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	function add_cms()
	{
		$this->data['jobs']='Add';
	  	$this->data['current_menu'] = 'add';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-cms', $this->admin_permissions)):

			//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;

			$this->form_validation->set_rules($this->admin_cms->validate_cms);
			if($this->form_validation->run()==TRUE)
			{	
				//Insert Lang Settings
				$trans = $this->admin_cms->insert_cms();
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'CMS Added', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','The CMS records added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'Unable to Add CMS', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','Unable to Add CMS record.');
				}
				
				redirect(ADMIN_DASHBOARD_PATH.'/cms/index/','refresh');			
				exit;
			}
			
		
			$this->page_title = WEBSITE_NAME.' Add Content Management System';
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_add',$this->data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - CMS Settings')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	
	function edit($id='')
	{
		//check id, if it is not set then redirect to view page
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/cms/index','refresh');	exit; }
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-cms', $this->admin_permissions)):
			$this->data['current_menu'] = 'edit';
			$this->data['jobs'] = 'Edit';
		
			$this->data['cms_data']=$this->admin_cms->get_cms_details_by_id($id);
			if($this->data['cms_data'] ==false){redirect(ADMIN_DASHBOARD_PATH.'/cms/index','refresh'); exit;}
			//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			
			//Set the validation rules
			$this->form_validation->set_rules($this->admin_cms->validate_cms_edit);
			
			if($this->form_validation->run()==TRUE )
			{
				//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
				//Insert CMS Data
				$trans = $this->admin_cms->update_cms($id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'CMS Updated', 'action' => 'Update', 'extra_info' => 'cms id: '.$id));
					}
					
					$this->session->set_flashdata('message','The CMS record updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'Unable to Update CMS', 'action' => 'Edit', 'extra_info' => 'cms id: '.$id));
					}
					
					$this->session->set_flashdata('message','Unable to Update CMS.');
				}

				redirect(ADMIN_DASHBOARD_PATH.'/cms/index/','refresh');			
				exit;
			}
				
			$this->page_title = WEBSITE_NAME.' Edit Content Management System';
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_edit',$this->data);
			 
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - CMS Settings')
				->build('administrator-denied', $data);

        endif;	
	}
	
	
	public function delete($id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-cms', $this->admin_permissions)):
		
			$query = $this->db->get_where('cms', array('id' => $id));
			if($query->num_rows() > 0) 
			{
				$this->db->delete('cms', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
				$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'CMS Deleted', 'action' => 'Delete', 'extra_info' => 'cms id: '.$id));
				}
				
				$this->session->set_flashdata('message','The cms record deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/cms/index/','refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'unable to delete CMS', 'action' => 'Delete', 'extra_info' => 'parent id: '.$parent_id));
				}
				
				$this->session->set_flashdata('message','Sorry no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/cms/index/','refresh');
				exit;
			}
		
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - CMS Settings')
				->build('administrator-denied', $data);

        endif;		
	}
	
	public function check_slug_add()
	{		
		$slug = $this->input->post('slug');
		$query = $this->db->get_where('cms', array('cms_slug'=>$slug));	
		if($query->num_rows()> 0) 
		{	
			$this->form_validation->set_message('check_slug_add',"The cms slug is already in use.");
			return false;
		}
		return true;
	}
	
	public function check_slug_edit()
	{		
		$slug = $this->input->post('slug');
		$contentid=$this->uri->segment(4);
		$query = $this->db->get_where('cms', array('id !=' => $contentid, 'cms_slug'=>$slug));	
		if($query->num_rows()> 0) 
		{	
			$this->form_validation->set_message('check_slug_edit',"The cms slug is already in use.");
			return false;
		}
		return true;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */