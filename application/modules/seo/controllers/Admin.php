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
			$this->load->model('admin_seo');
			//$this->load->model('language-settings/Admin_language_settings');
		
		//load custom helper
		$this->load->helper('editor_helper');
		$this->load->helper('form');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-seo', $this->admin_permissions)):

			$this->data['jobs']='View';
			$this->data['seo_data'] = $this->admin_seo->get_seo_lists();				
				
			$this->page_title = WEBSITE_NAME.' SEO Management';
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
	
	
	function add_seo()
	{
		$this->data['jobs']='Add';
	  	$this->data['current_menu'] = 'add';
		$this->data['error']=FALSE;
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-seo', $this->admin_permissions)):
		
			$this->data['all_seo_pages']=$this->admin_seo->get_all_seo_pages();
			
			//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
			
			$this->form_validation->set_rules($this->admin_seo->validate_seo);
			if($this->form_validation->run()==TRUE && $this->data['error']==FALSE)
			{	
				//Insert Lang Settings
				$trans = $this->admin_seo->insert_seo();
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'SEO', 'module_desc' => 'SEO Added', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','The SEO records added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'SEO', 'module_desc' => 'Unable to ADD SEO', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','Unable to Add SEO record.');
				}
				
				redirect(ADMIN_DASHBOARD_PATH.'/seo/index','refresh');			
				exit;
			}
		
			$this->page_title = WEBSITE_NAME.' Add SEO Management System';
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_add',$this->data);
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - SEO Settings')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	
	function edit($id)
	{
		$this->data['current_menu'] = 'edit';
	
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-seo', $this->admin_permissions)):
		
			$this->data['jobs'] = 'Edit';
			$this->data['all_seo_pages']=$this->admin_seo->get_all_seo_pages();
			
			//check id, if it is not set then redirect to view page
			if(!isset($id))
			{	
				redirect(ADMIN_DASHBOARD_PATH.'/seo/index','refresh');
				exit;
			}
			
			$this->data['seo_data']=$this->admin_seo->get_seo_details_by_id($id);
			if($this->data['seo_data'] ==false)
			{
				redirect(ADMIN_DASHBOARD_PATH.'/seo/index','refresh');
				exit;
			}
			
			$this->data['error'] = FALSE;
			
			//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			
			//Set the validation rules
			$this->form_validation->set_rules($this->admin_seo->validate_seo);
			
			if($this->form_validation->run()==TRUE && $this->data['error']==FALSE)
			{
				//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
				//Insert CMS Data
				$trans = $this->admin_seo->update_seo($id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'SEO', 'module_desc' => 'SEO Updated', 'action' => 'Update', 'extra_info' => 'SEO Page id: '.$id));
					}
					
					$this->session->set_flashdata('message','The SEO record updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'SEO', 'module_desc' => 'Unable to Update SEO', 'action' => 'Edit', 'extra_info' => ' SEO Page id: '.$id));
					}
					
					$this->session->set_flashdata('message','Unable to Update SEO.');
				}

				redirect(ADMIN_DASHBOARD_PATH.'/seo/index','refresh');			
				exit;
			}
			
			
				
			$this->page_title = WEBSITE_NAME.' Edit SEO Management System';
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_edit',$this->data);
			 
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - SEO Settings')
				->build('administrator-denied', $data);

        endif;	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */