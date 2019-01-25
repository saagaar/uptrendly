<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //error_reporting(0);

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
			$this->load->library('pagination');

		//load custom module
			$this->load->model('admin_member');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	
	
	public function index($usertype='all',$status = 'total')
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-member', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'view_member';
			$this->current_time = $this->general->get_local_time();	
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/index/'.$status;
			$config['total_rows'] = $this->admin_member->count_total_members($usertype,$status);					
			$config['page_query_string'] = FALSE;
			$config['per_page'] = ADMIN_MEMBER_LIST_PERPAGE;
			$config['uri_segment'] = '5';

			
			//get further config from general library
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			$offset = $this->uri->segment(6,0);
				
			
			$this->data['member_data'] = $this->admin_member->get_members_list($usertype,$status,$config['per_page'],$offset);
			//echo "<pre>";print_r($this->data['member_data']); echo "</pre>"; exit;
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
			$this->data['usertype']=$usertype;
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Members View')
				->build('a_view_members', $this->data);
		
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Members')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	public function add_member()
	{
		//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-member', $this->admin_permissions)):
	
			$this->data['current_menu'] = 'add_member';
			$this->data['countries'] = $this->general->get_all_countries();
			//Set the validation rules
			$this->form_validation->set_rules($this->admin_member->validate_settings_add);
			if($this->form_validation->run()==TRUE)
			{
				
				//Insert Lang Settings
				$trans = $this->admin_member->add_member();
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Member Added', 'action' => 'Add', 'extra_info' => 'member id: '.$trans));
					}
					$this->session->set_flashdata('message','New Member Added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Unable to Add Member', 'action' => 'Add', 'extra_info' => ''));
					}
					$this->session->set_flashdata('message','Unable to Add New Member.');
				}
				
				
				redirect(ADMIN_DASHBOARD_PATH.'/members/index/advertiser','refresh');			
				exit;
			}
			
			$this->data['usertype']='advertiser';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Member Add')
				->build('a_add_member',$this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Add Members')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	
	
	public function edit_member($status = '', $id = '')
	{
		if($status=='' OR $id=='' OR !is_numeric($id) OR !is_numeric($status))
		{
			redirect(ADMIN_DASHBOARD_PATH.'/members/index/','refresh');exit;
		}
		
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-member', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'edit_member';
			$this->data['countries'] = $this->general->get_all_countries();
			$this->data['socialmedia']=array('');
			//check id, if it is not set then redirect to view page
			if(!isset($id)){redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');exit;}
			
			$this->data['profile'] = $this->admin_member->get_member_byid($id);
			// print_r($this->data['profile']);exit;
			if($this->data['profile']->user_type=='4'){
				$this->data['socialmedia']=$this->general->get_socialmedia_user($id);
			}
			$this->data['usertype']='advertiser';
			$user_type=$this->data['profile']->user_type;
			if($user_type=='4')
			{
				$this->data['usertype']=='influencer';
			}
			else
			{
				$this->data['usertype']=='advertiser';
			}
			
			if($this->data['profile'] == false){redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$this->data['usertype'].'/'.$status,'refresh');exit;}
			
			//Set the validation rules
			if($this->data['profile']->user_type=='4'){
				$this->form_validation->set_rules($this->admin_member->validate_settings_edit_influencer);
			}
			if($this->data['profile']->user_type=='3')
			{
				$this->form_validation->set_rules($this->admin_member->validate_settings_edit_brand);
			}
			
			
			if($this->form_validation->run()==TRUE)
			{
				//Insert Lang Settings
				$trans = $this->admin_member->update_member($id);
				
				if($trans) 
				{
					$newprofile= $this->admin_member->get_member_byid($id);
					if($this->data['profile']->status=='2' && $newprofile->status=='1')
					{
						$this->admin_member->sent_email_notification('activate',$newprofile->user_type);
					}
					if($this->data['profile']->status=='2' && $newprofile->status=='4')
					{
						$this->admin_member->sent_email_notification('reject',$newprofile->user_type);
					}

					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Member Updated', 'action' => 'Edit', 'extra_info' => 'member id: '.$id));
					}
					
					$this->session->set_flashdata('message','The Member records updated successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Unable to Edit Member', 'action' => 'Edit', 'extra_info' => 'member id: '.$id));
					}
					
					$this->session->set_flashdata('message','Unable to Edit Member.');
				}
				
				redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$this->data['usertype'].'/'.$newprofile->status,'refresh');			
				exit;
			}
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Member Edit')
				->build('a_edit_member', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Members')
				->build('administrator-denied', $data);

        endif;
	}	
	public function delete_member($status = '',$id = '')
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-member', $this->admin_permissions)):
		
			$query = $this->db->get_where('members', array('id' => $id));
	
			if($query->num_rows() > 0) 
			{
				$this->db->delete('members', array('id' => $id));				
				
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Member Deleted', 'action' => 'Delete', 'extra_info' => 'member id: '.$id));
				}
				
				$this->session->set_flashdata('message','Member record deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Wrong Attempt to delete Member', 'action' => 'Delete', 'extra_info' => 'member id: '.$id));
					}
				
				$this->session->set_flashdata('message','Sorry no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');
				exit;
			}
			
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Members')
				->build('administrator-denied', $data);

        endif;
	}
	

	public function change_user_password()
	{
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[30]');
		if($this->form_validation->run()==TRUE)
		{
			echo $this->admin_member->change_member_password();		
		}
		else
		{
			echo '<input name="password" type="text" class="inputtext" id="password" size="30" /> <input class="bttn" type="button" name="Submit" value="Change" id="changed"  onclick="changedpassword(this.value)" />'.form_error('password');
		}
	}
			
	
	public function transaction($status = '', $user_id = '')
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('member-transaction', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'transaction';
			
			$this->data['profile'] = $this->admin_member->get_member_byid($user_id);
			
			if($this->uri->segment(4)) $status = $this->uri->segment(4); else $status = 'active';
			//set pagination configuration			
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/transaction/'.$status.'/'.$user_id;
			$config['total_rows'] = $this->admin_member->count_member_transaction($user_id);
			$config['page_query_string'] = FALSE;
			$config['per_page'] = '20';
			$config['uri_segment'] = '5';
			
			//get further config from general library
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			//echo "<pre>";print_r($config); echo "</pre>"; exit;
			$offset = $this->uri->segment(6,0);
			
			$this->data['transaction_data'] = $this->admin_member->get_member_transaction($user_id,$config['per_page'],$offset);
			
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);	
			
			//$this->data = '';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Members Transaction')
				->build('a_transaction', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Members Transaction')
				->build('administrator-denied', $data);

        endif;
	}
	
	
	public function add_balance($user_id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-balance', $this->admin_permissions)):

			$this->data['current_menu'] = 'add_balance';
			//check id, if it is not set then redirect to view page
			if(!isset($user_id)){redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');exit;}
			
			$this->data['profile'] = $this->admin_member->get_member_byid($user_id);
			
			$this->form_validation->set_rules('number_credit','Number Referral Points','trim|required|numeric|greater_than[0]|xss_clean');
			$this->form_validation->set_rules('transaction_name','Transaction Details','trim|required|xss_clean');
			
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->admin_member->member_add_balance($user_id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Add Referral Point to Member Account', 'action' => 'Add', 'extra_info' => 'member id: '.$user_id));
					}
					
				$this->session->set_flashdata('message','The referral points added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Member', 'module_desc' => 'Unable to Add Referral Point to Member Account', 'action' => 'Add', 'extra_info' => 'member id: '.$user_id));
					}
					
					$this->session->set_flashdata('message','Unable to Add Referral Points  to Member Account.');
				}	
				
				redirect(ADMIN_DASHBOARD_PATH.'/members/index/1','refresh');
			}	
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Member Add Credits')
				->build('a_add_credit', $this->data);
		
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Add Balance')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	public function view_watchlist($status,$user_id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('member-transaction', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'view_watchlist';
			
			$this->data['profile'] = $this->admin_member->get_member_byid($user_id);
						
			if($this->uri->segment(4)) $status = $this->uri->segment(4); else $status = 'active';
			//set pagination configuration			
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/view_watchlist/'.$status.'/'.$user_id;
			$config['total_rows'] = $this->admin_member->count_member_watchlist($user_id);
			$config['page_query_string'] = FALSE;
			$config['per_page'] = '20';
			$config['uri_segment'] = '5';
			
			//get further config from general library
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			//echo "<pre>";print_r($config); echo "</pre>"; exit;
			
			$offset = $this->uri->segment(6,0);
			
			$this->data['transaction_data'] = $this->admin_member->get_member_watchlist($user_id,$config['per_page'],$offset);
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);		
			//$this->data = '';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Members Transaction')
				->build('a_watchlist', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Members Transaction')
				->build('administrator-denied', $data);

        endif;
	}
	
	public function view_bid_history($status,$user_id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('member-transaction', $this->admin_permissions)):
		
			$this->data['current_menu'] = 'view_bid_history';
			$this->data['user_id'] = $user_id;
			$this->data['profile'] = $this->admin_member->get_member_byid($user_id);
			
			
			if($this->uri->segment(4)) $status = $this->uri->segment(4); else $status = 'active';
			//set pagination configuration			
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/view_bid_history/'.$status.'/'.$user_id;
			$config['total_rows'] = $this->admin_member->count_member_bids($user_id);
			$config['page_query_string'] = FALSE;
			$config['per_page'] = '20';
			$config['uri_segment'] = '5';
			
			//get further config from general library
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			//echo "<pre>";print_r($config); echo "</pre>"; exit;
			
			$offset = $this->uri->segment(6,0);
	
			$this->data['bids_data'] = $this->admin_member->get_member_bids_history($user_id,$config['per_page'],$offset);
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);	
			
			
			
			//$this->data = '';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Members Bidding Information')
				->build('a_bid_history', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Members Transaction')
				->build('administrator-denied', $data);

        endif;
	}

	public function invoice($invoice_id)
	{
		$this->data['invoice_info']=$this->admin_member->get_invoice_info($invoice_id);
		
		$this->template
			->set_layout('admin_dashboard')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.' - Member Bid Detial')
			->build('get_invoice', $this->data);		
	}
	
	
	//callback function to check email
	public function check_email()
	{
		$user_id = $this->input->post('user_id');
		$email = $this->input->post('email');
		$query = $this->db->get_where('members', array('id !=' => $user_id, 'email'=>$email));
		if($query->num_rows() > 0) 
		{
			$this->form_validation->set_message('check_email',"The email address is already in use.");
			return false;
		}
	}

	// Statistics 
	// Incomplete
	public function statistics($status = '', $id= '')
	{
		echo 'Statistics Section to be done'; exit;

		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('member-statistics', $this->admin_permissions)):
		
			$this->data = array();

			$this->data['current_menu'] = 'statistics';
			
			$this->data['profile'] = $this->admin_member->get_member_byid($user_id);
						
			// if($this->uri->segment(4)) $status = $this->uri->segment(4); else $status = 'active';
			// //set pagination configuration			
			// $config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/view_watchlist/'.$status.'/'.$user_id;
			// $config['total_rows'] = $this->admin_member->count_member_watchlist($user_id);
			// $config['page_query_string'] = FALSE;
			// $config['per_page'] = '20';
			// $config['uri_segment'] = '5';
			
			// //get further config from general library
			// $this->general->get_pagination_config($config);            
			// $this->pagination->initialize($config); 
			
			// $offset = $this->uri->segment(6,0);
			
			// $this->data['transaction_data'] = $this->admin_member->get_member_watchlist($user_id,$config['per_page'],$offset);
			// $this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);		
			// //$this->data = '';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Members Statistics')
				->build('a_view_statistics', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Member Statistics')
				->build('administrator-denied', $data);

        endif;
	}

	// Notification Settings
	// Incomplete
	public function notification($status = '', $user_id = '')
	{
		echo 'Notification Settings Section to be done'; exit;
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('member-notificaiton', $this->admin_permissions)):
			$this->data = array();
			$this->data['current_menu'] = 'notification';
			
			$this->data['profile'] = $this->admin_member->get_member_byid($user_id);
						
			// if($this->uri->segment(4)) $status = $this->uri->segment(4); else $status = 'active';
			// //set pagination configuration			
			// $config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/view_watchlist/'.$status.'/'.$user_id;
			// $config['total_rows'] = $this->admin_member->count_member_watchlist($user_id);
			// $config['page_query_string'] = FALSE;
			// $config['per_page'] = '20';
			// $config['uri_segment'] = '5';
			
			// //get further config from general library
			// $this->general->get_pagination_config($config);            
			// $this->pagination->initialize($config); 
			
			// $offset = $this->uri->segment(6,0);
			
			// $this->data['transaction_data'] = $this->admin_member->get_member_watchlist($user_id,$config['per_page'],$offset);
			// $this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);		
			//$this->data = '';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Members Notification Settings')
				->build('a_notification_settings', $this->data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Member Notificaiton Settings')
				->build('administrator-denied', $data);

        endif;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */