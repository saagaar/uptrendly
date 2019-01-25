<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); //error_reporting(0);
class Admin extends CI_Controller {

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
		$this->load->library('pagination');	

		//load custom model
		$this->load->model('admin_newsletter');	
		
		//load library
		
		//load custom helper
		
		$this->load->helper('editor_helper');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	
	function index()
	{
		redirect(ADMIN_DASHBOARD_PATH.'/newsletter/send');
	}
	
	
	function send()
	{
		$this->data['jobs']='Send';
	  	$this->data['current_menu'] = 'Send';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;

		$this->page_title = WEBSITE_NAME.' Newsletter Management';

		if(array_key_exists('send-newsletter', $this->admin_permissions)):

			$this->form_validation->set_rules($this->admin_newsletter->validate_send_newsletter);
			if($this->input->post('send_to',TRUE) == 'selected_members' && $this->input->post('member',TRUE) ==''){
				$this->form_validation->set_rules($this->admin_newsletter->validate_send_newsletter_selected_members);
			}
			
			if($this->form_validation->run() ==TRUE && $this->input->server('REQUEST_METHOD') == 'POST')
			{
				if($this->input->post('send_to',TRUE) == 'selected_members' && $this->input->post('member',TRUE) =='')
				{
					$this->session->set_flashdata('message', 'No Members Selected.');
					redirect(ADMIN_DASHBOARD_PATH.'/newsletter/send');	
				}
				
				$send_newsletter = $this->admin_newsletter->send_newsletter();
				if($send_newsletter)
				{
					//send newsletter success message
					$this->session->set_flashdata('message','Mail Successfully sent to '.$send_newsletter.' members.');
					redirect(ADMIN_DASHBOARD_PATH.'/newsletter/send');
				}
				else
				{
					$this->session->set_flashdata('message','Unable to send mail ');
					redirect(ADMIN_DASHBOARD_PATH.'/newsletter/send');
				}
			}

			$this->data['newsletter_info']=$this->admin_newsletter->get_all_newsletter_info();
				
			//set pagination configuration		
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/newsletter/send';
			$config['total_rows'] = $this->admin_newsletter->count_total_members();					
			//$config['num_links'] = 10;
			$config['prev_link'] = 'Prev';
			$config['next_link'] = 'Next';
			$config['per_page'] = '30'; 
			$config['next_tag_open'] = '<span>';
			$config['next_tag_close'] = '</span>';
			$config['cur_tag_open'] = '<span>';
			$config['cur_tag_close'] = '</span>';
			$config['num_tag_open'] = '<span>';
			$config['num_tag_close'] = '</span>';		
			$config['uri_segment'] = '4';		
			$this->pagination->initialize($config); 
			
			$this->data['offset'] = $this->uri->segment(4,0);
			$this->data['member_infos'] = $this->admin_newsletter->get_members_details($config['per_page'],$this->data['offset']);
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_send_newsletter', $this->data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('administrator-denied', $data);

        endif;
		
	}
	
	
	function add()
	{ 	
		$this->data['jobs']='Add';
	  	$this->data['current_menu'] = 'add';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;

		$this->page_title = WEBSITE_NAME.' Newsletter Management';

		if(array_key_exists('add-newsletter', $this->admin_permissions)):


			$this->form_validation->set_rules($this->admin_newsletter->validate_add_edit_newsletter);
			if($this->form_validation->run()==TRUE)
			{	
				//Insert Lang Settings
				$trans = $this->admin_newsletter->insert_newsletter();
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Newsletter', 'module_desc' => 'Newsletter Added', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','The Newsletter records added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Newsletter', 'module_desc' => 'Unable to Add Newsleter', 'action' => 'Add', 'extra_info' => ''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Newsletter record.');
				}
				
				redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view/','refresh');			
				exit;
			}

			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_add_newsletter', $this->data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('administrator-denied', $data);

        endif;
	}
	
	
	function edit($id='')
	{		
		//check id, if it is not set then redirect to view page
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view','refresh');	exit; }
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;

		$this->page_title = WEBSITE_NAME.' Newsletter Management';
		if(array_key_exists('edit-newsletter', $this->admin_permissions)):
			$this->data['current_menu'] = 'edit';
			$this->data['jobs'] = 'Edit';
		
			$this->data['news_letter']=$this->admin_newsletter->get_newsletter_info_byid($id);
			if($this->data['news_letter'] ==false){redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view','refresh'); exit;}
			
			//Set the validation rules
			$this->form_validation->set_rules($this->admin_newsletter->validate_add_edit_newsletter);
			
			if($this->form_validation->run()==TRUE )
			{
				//Insert CMS Data
				$trans = $this->admin_newsletter->update_newsletter($id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Newsletter', 'module_desc' => 'Newsletter Updated', 'action' => 'Edit', 'extra_info' => 'newsletter id: '.$id));
					}
					
					$this->session->set_flashdata('message','The Newsletter record updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Newsletter', 'module_desc' => 'Unable to Update Newsletter', 'action' => 'Edit', 'extra_info' => 'newsletter id: '.$id));
					}
					
					$this->session->set_flashdata('message','Unable to Update Newsletter Record.');
				}

				redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view/','refresh');			
				exit;
			}				
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->page_title)
				 ->build('a_edit_newsletter',$this->data);
			 
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('administrator-denied', $data);

        endif;	
	}
	
	function view()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		$this->page_title = WEBSITE_NAME.' Newsletter Management';
		
		if(array_key_exists('module-newsletter', $this->admin_permissions)):
			
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
				
			$this->data['newsletters'] = $this->admin_newsletter->viewnewsletter();
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view_newsletters', $this->data);
		 
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('administrator-denied', $data);

        endif;
	}
	
	
	
	function delete($id = '')
	{
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view','refresh');	exit; }

		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-newsletter', $this->admin_permissions)):
		
			$query = $this->db->get_where('news_letter', array('id' => $id));
			if($query->num_rows() > 0) 
			{
				$this->db->delete('news_letter', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
				$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Newsletter', 'module_desc' => 'Newsletter Deleted', 'action' => 'Delete', 'extra_info' => 'newsletter id: '.$id));
				}
				
				$this->session->set_flashdata('message','The Newsletter record deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view/','refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'CMS', 'module_desc' => 'unable to delete CMS', 'action' => 'Delete', 'extra_info' => 'newsletter id: '.$id));
				}
				
				$this->session->set_flashdata('message','Sorry no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/newsletter/view/','refresh');
				exit;
			}
		
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Newsletter Management')
				->build('administrator-denied', $data);

        endif;		
	}

	
	
}
