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
			$this->load->library('upload');		
		//load custom module
			$this->load->model('admin_how_why_reverse');
		
		//load custom helper
		$this->load->helper('editor_helper');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index($cms_type='')
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-how-and-why', $this->admin_permissions)):
			
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
				
			$this->data['cms_data'] = $this->admin_how_why_reverse->get_cms_lists_by_cms_type($cms_type);
			//echo "<pre>"; print_r($this->data['cms_data']); echo "</pre>"; exit;
				
			$this->page_title = WEBSITE_NAME.' How it Works/ Why Reverse Auction';
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view', $this->data);
		 
		 else:
				$this->template->set_layout('dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - How it Works/ Why Reverse Auction')
					->build('administrator-denied', $data);

        endif;
	}
	
	
	function add_cms()
	{
		$this->data['jobs']='Add';
	  	$this->data['current_menu'] = 'add';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-how-and-why', $this->admin_permissions)):
			//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
			$this->form_validation->set_rules($this->admin_how_why_reverse->validate_cms);
			if($this->form_validation->run()==TRUE)
			{	
				$upload_result = $this->admin_how_why_reverse->upload_image($this->data['jobs']);
				if($upload_result == FALSE)
				{
					//Insert Lang Settings
					$trans = $this->admin_how_why_reverse->insert_cms();
					
					if($trans)
					{
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'How it Works/ Why Reverse Auction', 'module_desc' => 'How it Works/ Why Reverse Auction Content Added', 'action' => 'Add', 'extra_info' => ''));
						}
						
						$this->session->set_flashdata('message','The How It Works/Why Reverse Content added successfully.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'How it Works/ Why Reverse Auction', 'module_desc' => 'Unable to Add How it Works/ Why Reverse Auction Content ', 'action' => 'Add', 'extra_info' => ''));
						}
						
						$this->session->set_flashdata('message','Unable to Add How It Works/Why Reverse Content.');
					}
					
					redirect(ADMIN_DASHBOARD_PATH.'/how-and-why/index/'.$this->input->post('cms_type',TRUE),'refresh');			
					exit;
				}
			}
		
			$this->page_title = WEBSITE_NAME.' Add How it Works/ Why Reverse Auction';
			$this->template
				 ->set_layout('dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_add',$this->data);
		else:
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - How it Works/ Why Reverse Auction')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	
	function edit($id='')
	{
		//check id, if it is not set then redirect to view page
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/how-and-why/index','refresh');	exit; }
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-how-and-why', $this->admin_permissions)):
			$this->data['current_menu'] = 'edit';
			$this->data['jobs'] = 'Edit';
		
			$this->data['cms_data']=$this->admin_how_why_reverse->get_cms_details_by_id($id);
			if($this->data['cms_data'] ==false){redirect(ADMIN_DASHBOARD_PATH.'/how-and-why/index','refresh'); exit;}
			//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			
			//Set the validation rules
			$this->form_validation->set_rules($this->admin_how_why_reverse->validate_cms);
			
			if($this->form_validation->run()==TRUE )
			{
				$upload_result = $this->admin_how_why_reverse->upload_image($this->data['jobs']);
				if($upload_result == FALSE)
				{
					//Insert CMS Data
					$trans = $this->admin_how_why_reverse->update_cms($id);
					
					if($trans)
					{
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'How it Works/ Why Reverse Auction', 'module_desc' => 'How it Works/ Why Reverse Auction Content Updated', 'action' => 'Update', 'extra_info' => 'content id: '.$id));
						}
						
						$this->session->set_flashdata('message','The How it Works/ Why Reverse Auction Cotent updated successfully.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'How it Works/ Why Reverse Auction', 'module_desc' => 'Unable to Update How it Works/ Why Reverse Auction Content', 'action' => 'Edit', 'extra_info' => 'content id: '.$id));
						}
						
						$this->session->set_flashdata('message','Unable to Update How it Works/ Why Reverse Auction Content .');
					}
	
					redirect(ADMIN_DASHBOARD_PATH.'/how-and-why/index/'.$this->input->post('cms_type',TRUE),'refresh');			
					exit;
				}
			}
				
			$this->page_title = WEBSITE_NAME.' Edit How it Works/ Why Reverse Auction';
			$this->template
				 ->set_layout('dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_edit',$this->data);
			 
		else:
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - How it Works/ Why Reverse Auction')
				->build('administrator-denied', $data);

        endif;	
	}
	
	
	public function delete($id,$cms_type)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-how-and-why', $this->admin_permissions)):
		
			$query = $this->db->get_where('cms_others', array('id' => $id));
			if($query->num_rows() > 0) 
			{
				$result = $query->row();
				@unlink('./'.HOW_AND_WHY_IMAGES.$result->image);
				$this->db->delete('cms_others', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
				$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'How it Works/ Why Reverse Auction', 'module_desc' => 'How it Works/ Why Reverse Auction Content Deleted', 'action' => 'Delete', 'extra_info' => 'content id: '.$id));
				}
				
				$this->session->set_flashdata('message','The How it Works/ Why Reverse Auction Content deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/how-and-why/index/'.$cms_type,'refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'How it Works/ Why Reverse Auction', 'module_desc' => 'Unable to delete How it Works/ Why Reverse Auction Content', 'action' => 'Delete', 'extra_info' => 'content id: '.$id));
				}
				
				$this->session->set_flashdata('message','Sorry no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/how-and-why/index/'.$cms_type,'refresh');
				exit;
			}
		
		else:
			$this->template->set_layout('dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - How it Works/ Why Reverse Auction')
				->build('administrator-denied', $data);

        endif;		
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */