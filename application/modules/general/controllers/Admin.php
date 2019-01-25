<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load custom module
		$this->load->model('setting_model');
		
		//load CI library
		$this->load->library('form_validation');
			
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
		// get array of permissions for logged in use type
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function profession()
	{
		
		$this->data['current_menu']='All';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('profession', $this->admin_permissions)):
		
			$this->data['jobs']='View';
			$this->data['profession'] = $this->setting_model->get_profession();
			
			$this->title = WEBSITE_NAME." - View Profession";
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->title)
				->build('a_view_profession', $this->data);
				
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Product Category')
				->build('administrator-denied', $data);
        endif;
	}


	
	function add_profession($id=false)
	{
	
		if($id)
		{
				$this->data['current_menu']='edit_profession';
		}
		else{
				$this->data['current_menu']='add_profession';
		}
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-profession', $this->admin_permissions)):
			
			$this->data['jobs']='Add';
			$this->data['error']=FALSE;
			$this->data['profession']=false;
			if($id)
			{
				$this->data['profession']=$this->setting_model->get_profession($id);
			}
			$this->form_validation->set_rules($this->setting_model->validate_profession);
			if($this->form_validation->run()==TRUE)
			{
				//Insert category			
				$trans = $this->setting_model->insert_profession($id);
				if($id) $action='Updat';
				else $action='Add';
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'General', 'module_desc' => "Profession ".$action.'ed', 'action' => $action, 'extra_info' => 'profession id: '.$trans));
					}
					
					$this->session->set_flashdata('message','Profession '.$action.'ed successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Profession', 'module_desc' => 'Unable to Add/Edit Profession', 'action' => 'Add/Edit', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Profession.');
				}
			
				
				//$this->session->set_flashdata('message','The Category record added successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/general/profession	/','refresh');			
				exit;
			
		}
		
			$this->title = WEBSITE_NAME." - Add Category";
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_add_profession',$this->data);
	
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Add Category')
				->build('administrator-denied', $data);
        endif;
	}
	

	
	
	public function delete_profession($id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-profession', $this->admin_permissions)):
		
			$query = $this->db->get_where('profession', array('id' => $id));
	
			if($query->num_rows() > 0) 
			{
				$this->db->delete('profession', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'General', 'module_desc' => 'Profession Deleted', 'action' => 'Delete', 'extra_info' => 'id: '.$id));
					}
				
				$this->session->set_flashdata('message','Profession  deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/general/profession/','refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'General', 'module_desc' => 'Unable to Delete Profession', 'action' => 'Delete', 'extra_info' => 'id: '.$id));
				}
				
				$this->session->set_flashdata('message','Sorry no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/general/profession/','refresh');
				exit;
			}
			
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Delete Profession')
				->build('administrator-denied', $data);
        endif;	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */