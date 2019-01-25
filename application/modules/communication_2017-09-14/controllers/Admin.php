<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    function __construct() 
	{
		parent::__construct();
        
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
		
		$this->load->library('form_validation');
		$this->load->model('admin_communication_model'); 
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index($member=NULL)
	{
         $this->inbox();
    }
	
	public function inbox(){
      $data = array();
		
		$data['current_menu'] = 'inbox';
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('admin-communication', $this->admin_permissions)):
			
			$this->load->library('pagination');
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/communication/inbox');
			$config['total_rows'] = $this->admin_communication_model->get_total_admin_inbox();
			$config['per_page'] = '5';
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 4;
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			

			$offset = $this->uri->segment(4,0); 
			//var_dump($config);
			$data['communications'] = $this->admin_communication_model->admin_inbox_communications($config["per_page"],$offset);
			//echo "<pre>"; print_r( $data['communications']); echo "</pre>"; exit;
			$data["pagination_links"] = $this->pagination->create_links();
			
		   $this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel -  Admin- Inbox')
				->build('admin-inbox', $data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Admin - Inbox')
				->build('administrator-denied', $data);
		endif;        
	}
	
	
	public function sent(){
		$data = array();
		//$data['current_status'] = AUCTION_STATUS_PENDING;
		$data['current_menu'] = 'sent';
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('admin-communication', $this->admin_permissions)):

			$this->load->library('pagination');
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/communication/sent');
			$config['total_rows'] = $this->admin_communication_model->get_total_admin_sent();
			$config['per_page'] = 5;
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 5;
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			$offset=$this->uri->segment(5,0);            
			//var_dump($config);
			$data['communications'] = $this->admin_communication_model->admin_sent_communications($config["per_page"],$offset);
			$data["pagination_links"] = $this->pagination->create_links();
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Admin - Sent')
				->build('admin-sent', $data);
				
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Admin - Sent')
				->build('administrator-denied', $data);
		endif;        
	}
   
   
    public function compose(){
		$data = array();
		$data['current_menu'] = 'compose';
		
		//print_r($_POST); exit;
			
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('admin-communication', $this->admin_permissions)):
               
		   if ($this->input->server('REQUEST_METHOD') === 'POST'){
				//Set the validation rules
				$this->form_validation->set_rules($this->admin_communication_model->validate_rules_compose);
				if($this->form_validation->run()==TRUE){
					$this->load->library('upload');
					
					$trans_stat = $this->admin_communication_model->insert_message();
					
					//$this->admin_communication_model->insert_notification();
					
					if($trans_stat){
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' =>$this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>$this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Admin Communication', 'module_desc' => 'compose message', 'action' => 'Send', 'extra_info'=>''));
						}
						else
						{
							if(LOG_ADMIN_ACTIVITY == 'Y'){
								$this->general->log_admin_activity(array('user_id' =>$this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>$this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Admin Communication', 'module_desc' => 'message sending failed', 'action' => 'Send', 'extra_info'=>''));
							}	
						}
						$this->session->set_flashdata('message','Message sent successfully');
						redirect(ADMIN_DASHBOARD_PATH.'/communication/sent');exit();
					}
				}
		  	}

			$data['sellers'] = $this->admin_communication_model->get_active_seller();
			
			$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Admin - Compose')
					->build('admin-compose', $data);
		else:
			
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Admin - Compose')
				->build('administrator-denied', $data);
			endif;      
	}
     
	 	

	public function action($type = ''){
		if($type == 'outbox' OR $type =='inbox'){
			//TODO: handel ajax call...
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				//perform the actions according to the action selected
				switch($this->input->post('conversation_actions')){
					case 'make_read': $trans_stat = $this->admin_communication_model->change_admin_message_status(2,$type); break;
					case 'make_unread': $trans_stat = $this->admin_communication_model->change_admin_message_status(1,$type); break;
					case 'make_delete': $trans_stat = $this->admin_communication_model->change_admin_message_status(3,$type); break;
					default : $trans_stat = FALSE;
				}
			 
				if($trans_stat){
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' => $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Admin Communication', 'module_desc' => 'conversation updated', 'action' => $this->input->post('conversation_actions'), 'extra_info'=>''));
						}
					 $this->session->set_flashdata('message','Action Performed successfully');                         
				}else{
					$this->session->set_flashdata('message','No any updates'); 
				}
			}
			$this->session->set_flashdata('message','Invalid Method');
			redirect(ADMIN_DASHBOARD_PATH.'/communication/index','refresh');exit();
		}else{
			$this->session->set_flashdata('message','Invalid Action');
			redirect(ADMIN_DASHBOARD_PATH.'/communication/index','refresh');exit();
		}
	}
		
         
	public function conversation($type=NULL,$id=NULL,$seller_id=NULL)
	{
		$data = NULL;
		$data['current_menu'] = $type;
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('admin-communication', $this->admin_permissions)):
			$data['conversations'] = $this->admin_communication_model->get_conversation_by_id($type,$id,$seller_id);
			//echo "<pre>"; print_r($data['conversations']); echo "</pre>"; exit;
			if(!$data['conversations'])
			{
				redirect(ADMIN_DASHBOARD_PATH.'/communication/inbox','refresh');
			}
			
			if($type=='inbox' && $data['conversations']->inbox_status==1){
				$this->admin_communication_model->change_message_status_to_read($id,2);
			}
			
			//echo $type.'##'.$data['conversations']->inbox_status; exit;
	
			$data['conversations_attach'] = $this->admin_communication_model->get_conversation_attachments_by_id($id);
	
			$data['seller_id'] = $seller_id;
	
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Communication - Admin Conversation')
				->build('admin-conversation', $data);
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(SITE_NAME.' - Admin Panel - admin')
				->build('administrator-denied', $data);
		endif;
	}
       
   
    public function attachment($current='',$msg_id=0,$file_id=0,$member_id = 0){
      //$member = $this->seller_model->get_seller_id_from_exe($member_id);
      // var_dump(array('msg_id' => $msg_id, 'file_id' => $file_id, 'member_id' => $member_id)); exit;
	  if($msg_id && $file_id && $member_id){  
		$attachment = $this->admin_communication_model->is_valid_attachment($msg_id,$file_id,$member_id);
          
		// var_dump($attachment); die();
		if($attachment){
			if($current=='outbox')
			{
				$args = array(
					'download_path' => FCPATH.ATTACHMENT_ADMIN_UPLOAD_DIR.''.$member_id.'/'.ATTACHMENTS_DIR.$msg_id.'/',
					'file' => $attachment->file_saved,
					'file_name' => $attachment->file_name,
					'referrer_check' => TRUE,
					//'referrer' => site_url(ADMIN_DASHBOARD_PATH.'/communication/conversation'),
				);
			}else{
				$args = array(
					'download_path' => FCPATH.ATTACHMENT_UPLOAD_DIR.''.$member_id.'/'.ATTACHMENTS_DIR.$msg_id.'/',
					'file' => $attachment->file_saved,
					'file_name' => $attachment->file_name,
					'referrer_check' => TRUE,
					//'referrer' => site_url(ADMIN_DASHBOARD_PATH.'/communication/conversation'),
			   );
			}
			$this->admin_communication_model->get_file_download($args);
		}else{
                redirect(ADMIN_DASHBOARD_PATH.'/communication/inbox');
            }
        }
        else{
            redirect(ADMIN_DASHBOARD_PATH.'/communication/inbox');
        }
    }
	
	
	public function get_members_email_autocomplete()
	{
		if(!$this->input->is_ajax_request()){
			exit('No direct script access allowed');
		}
		
		$term = trim($this->input->get('term',TRUE));
		$searched_emails = $this->admin_communication_model->get_members_email_autocomplete($term);
		if($searched_emails!=false){
			print(json_encode($searched_emails));
		}
		/*else{
			print(json_encode( ));
		}*/	
	}
	
	public function check_email_existence($receiver_email){
		$user_id = $this->admin_communication_model->get_members_id_by_email($receiver_email);
		if($user_id == false){
			$this->form_validation->set_message('check_email_existence','Invalid Email! This user doesnot exists.');
			return false;
		}
		return true;
	}

	/*
    Form Validation: callback function for file upload field
    */
    public function _handel_file_uploads($value,$param){
        $req = NULL;
        $params = explode(',',$param);
        $no_params = count($params);
        $name = $params[0];
        
        if($no_params>1)
            $req = $params[1];
        $tmp_name = $_FILES[$name]['tmp_name'];
        $file_name = $_FILES[$name]['name'];
        
        if($req == 'required'){
            if (!is_uploaded_file($tmp_name)){
               $this->form_validation->set_message('_handel_file_uploads', '%s is required');
                return FALSE; 
            }
        }
        
        if (is_uploaded_file($tmp_name)){
                            
            //the user must upload valid extension file
            $ext_arr = explode('|',ALLOW_ATTACHMENT_EXTENSION);  
            $extension = pathinfo($file_name,PATHINFO_EXTENSION);
            if(in_array($extension, $ext_arr)){
                return TRUE;
            }
            else{
                $this->form_validation->set_message('_handel_file_uploads', '%s is not valid file');
                return FALSE;
            }   
        }
    }
}