<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller 
{

	function __construct() 
	{
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load CI library
			$this->load->library('form_validation');


		//load custom module
			$this->load->model('admin_bidpackage');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		$data = array();
        $data['current_menu'] = 'all';
        $data['admin_permissions'] = $this->admin_permissions;
	 	if(array_key_exists('module-bidpackage', $this->admin_permissions)):
			$data['bp_data'] = $this->admin_bidpackage->get_bid_package();		
			$this->template
					->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Bidpackage Management')
					->build('bidpackage_view', $data);           
	   	else:
            $this->template->set_layout('admin_dashboard')
                ->enable_parser(FALSE)
                ->title(WEBSITE_NAME.' - Admin Panel - Bidpackage Management')
                ->build('administrator-denied', $data);

        endif;        
		
	}
	
	
	
	public function add()
	{		
		$data = array();
        $data['current_menu'] = 'add';
        $data['admin_permissions'] = $this->admin_permissions;

        if(array_key_exists('add-bidpackage', $this->admin_permissions)):
        	if ($this->input->server('REQUEST_METHOD') === 'POST')
			{				  
				// Set the validation rules
				$this->form_validation->set_rules($this->admin_bidpackage->validate_bidpackage);
							
				if($this->form_validation->run()==TRUE)
				{			
					// Insert Bidpackage
					$bidpackage_add_status = $this->admin_bidpackage->insert_bidpackage_record();
					if($bidpackage_add_status)
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
                            $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Bidpackage', 'module_desc' => 'Bipdackage added', 'action' => 'Add', 'extra_info' => ''));
                        }
						$this->session->set_flashdata('message','The Bid Package is added successful.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
	                        $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Bidpackage', 'module_desc' => 'Add Bidpackage Failed', 'action' => 'Add',  'extra_info' => ''));
	                    }	
						$this->session->set_flashdata('message','The Bid Package is added successful.');

					}
					redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index/','refresh');					
					exit;
				}				
			}	

			$this->template->set_layout('admin_dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Bidpackage Management')
                    ->build('bidpackage_add', $data);
        else:
		
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Bidpackage Management')
				->build('administrator-denied', $data);
    	endif;
	}
	
	
	public function edit($id = 0)
	{
		if(!isset($id) || $id == 0){redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index','refresh');exit;}

		$data = array();
        $data['current_menu'] = 'edit';
        $data['admin_permissions'] = $this->admin_permissions;
		

		if(array_key_exists('edit-bidpackage', $this->admin_permissions)):
			$data['bidpackage'] = $this->admin_bidpackage->get_bidpackage_by_id($id);		

			//check bidpackage data, if it is not set then redirect to view page
			if($data['bidpackage']==false){redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index','refresh');exit;}
        	
        	if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				// Set the validation rules
				$this->form_validation->set_rules($this->admin_bidpackage->validate_bidpackage);				
				
				if($this->form_validation->run()==TRUE)
				{	
					//Update Bidpackage Data
					$bidpackage_edit_status = $this->admin_bidpackage->update_bidpackage_record($id);
					if($bidpackage_edit_status)
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
                            $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Bidpackage', 'module_desc' => 'Bipdackage updated', 'action' => 'Edit', 'extra_info' => ''));
                        }
						$this->session->set_flashdata('message','The Bid Package records are update successful.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
	                        $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Bidpackage', 'module_desc' => 'Edit Bidpackage Failed', 'action' => 'Edit', 'extra_info' => ''));
	                    }	
						$this->session->set_flashdata('message','The Bid Package records are update failed.');
					}
					redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index','refresh');
					exit;
				}
				

			}
			$this->template->set_layout('admin_dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Bidpackage Management')
                    ->build('bidpackage_edit', $data);
		else: 
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Bidpackage Management')
				->build('administrator-denied', $data);
		endif;
			

	}
	
	public function delete($id = 0)
	{
		if(!isset($id) || $id == 0){redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index','refresh');exit;}

		$data['admin_permissions'] = $this->admin_permissions;
        if(array_key_exists('delete-bidpackage', $this->admin_permissions)):
			$query = $this->db->get_where('membership_package', array('id' => $id));

			if($query->num_rows() > 0) 
			{
				$this->db->delete('membership_package', array('id' => $id));
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Bidpackage', 'module_desc' => 'Membership Package Deleted', 'action' => 'Delete', 'extra_info' => 'mebershipid: '.$id));
				}
				$this->session->set_flashdata('message','The Bid Package record delete successful.');
				
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Bidpacakge', 'module_desc' => 'Unable to delete Bidpackage', 'action' => 'Delete', 'extra_info' => ''));
				}				
				$this->session->set_flashdata('message','No record in our database.');
			}
			redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index','refresh');
			exit;
				
		else:
			$this->session->set_flashdata('message','You donot have authority to access this page.');                        
        endif;
        redirect(ADMIN_DASHBOARD_PATH.'/bidpackage/index');

	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */