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
			$this->load->model('admin_currency');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		$data = array();
        $data['current_menu'] = 'all';
        $data['admin_permissions'] = $this->admin_permissions;
	 	if(array_key_exists('module-currency', $this->admin_permissions)):
			$data['currencies'] = $this->admin_currency->get_currency();		
			$this->template
					->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Currency Management')
					->build('currency_view', $data);           
	   	else:
            $this->template->set_layout('admin_dashboard')
                ->enable_parser(FALSE)
                ->title(WEBSITE_NAME.' - Admin Panel - Currency Management')
                ->build('administrator-denied', $data);

        endif;        
		
	}
	
	
	
	public function add()
	{		
		$data = array();
        $data['current_menu'] = 'add';
        $data['admin_permissions'] = $this->admin_permissions;

        if(array_key_exists('add-currency', $this->admin_permissions)):
        	if ($this->input->server('REQUEST_METHOD') === 'POST')
			{				  
				// Set the validation rules
				$this->form_validation->set_rules($this->admin_currency->validate_currency);
							
				if($this->form_validation->run()==TRUE)
				{			
					// Insert Currency
					$currency_add_status = $this->admin_currency->insert_currency_record();
					if($currency_add_status)
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
                            $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Currency', 'module_desc' => 'Currency added', 'action' => 'Add', 'extra_info' => ''));
                        }
						$this->session->set_flashdata('message','The Currency is added successful.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
	                        $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Currency', 'module_desc' => 'Add Currency Failed', 'action' => 'Add', 'extra_info' => ''));
	                    }	
						$this->session->set_flashdata('message','Unable to Add Currency record.');

					}
					redirect(ADMIN_DASHBOARD_PATH.'/currency/index/','refresh');					
					exit;
				}				
			}	

			$this->template->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Currency Management')
                    ->build('currency_add', $data);
        else:
		
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Currency Management')
				->build('administrator-denied', $data);
    	endif;
	}
	
	
	public function edit($id = 0)
	{
		if(!isset($id) || $id == 0){redirect(ADMIN_DASHBOARD_PATH.'/currency/index','refresh');exit;}

		$data = array();
        $data['current_menu'] = 'edit';
        $data['admin_permissions'] = $this->admin_permissions;
		

		if(array_key_exists('edit-currency', $this->admin_permissions)):
			$data['currency'] = $this->admin_currency->get_currency_by_id($id);
				
			//check currency data, if it is not set then redirect to view page
			if($data['currency']==false){redirect(ADMIN_DASHBOARD_PATH.'/currency/index','refresh');exit;}
				
        	if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				// Set the validation rules
				$this->form_validation->set_rules($this->admin_currency->validate_currency);				
				
				if($this->form_validation->run()==TRUE)
				{	
					//Update Currency Data
					$currency_edit_status = $this->admin_currency->update_currency_record($id);
					if($currency_edit_status)
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
                            $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Currency', 'module_desc' => 'Currency updated', 'action' => 'Edit', 'extra_info' => ''));
                        }
						$this->session->set_flashdata('message','The Currency records are update successful.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
	                        $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Currency', 'module_desc' => 'Edit Currency Failed', 'action' => 'Edit', 'extra_info' => ''));
	                    }	
						$this->session->set_flashdata('message','The Currency records are update failed.');
					}
					redirect(ADMIN_DASHBOARD_PATH.'/currency/index','refresh');
					exit;
				}
			}


			$this->template->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Currency Management')
                    ->build('currency_edit', $data);
		else: 
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Currency Management')
				->build('administrator-denied', $data);
		endif;
			

	}
	
	public function delete($id = 0)
	{
		if(!isset($id) || $id == 0){redirect(ADMIN_DASHBOARD_PATH.'/currency/index','refresh');exit;}

		$data['admin_permissions'] = $this->admin_permissions;
        if(array_key_exists('delete-currency', $this->admin_permissions)):
			$query = $this->db->get_where('currency', array('id' => $id));

			if($query->num_rows() > 0) 
			{
				$this->db->delete('currency', array('id' => $id));
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Currency', 'module_desc' => 'Currency Deleted', 'action' => 'Delete', 'extra_info' => 'currency id: '.$id));
				}
				$this->session->set_flashdata('message','The Currency record delete successful.');
				
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Currency', 'module_desc' => 'Unable to delete Currency', 'action' => 'Delete', 'extra_info' => ''));
				}				
				$this->session->set_flashdata('message','No record in our database.');
			}
			redirect(ADMIN_DASHBOARD_PATH.'/currency/index','refresh');
			exit;
				
		else:
			$this->session->set_flashdata('message','You donot have authority to access this page.');                        
        endif;
        redirect(ADMIN_DASHBOARD_PATH.'/currency/index');

	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */