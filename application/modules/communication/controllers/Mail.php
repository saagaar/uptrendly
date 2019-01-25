<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//load custom language library
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			//check whether logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
			if(!$this->session->userdata('MAINTAINANCE_KEY') OR $this->session->userdata('MAINTAINANCE_KEY')!='YES'){
				redirect(site_url('/maintainance'));exit;
			}
		}
		
		if(!$this->session->userdata(SESSION.'user_id'))
        {
          	$this->session->set_flashdata('loginerror', "Please Login to access this page.");
			redirect(site_url('/'),'refresh');exit;
        }
		 //check banned IP address
		$this->general->check_banned_ip();
		 
		//load CI library
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('form_validation');
		$this->load->library("pagination");	
		$this->load->helper('text');
		$this->load->model('mail_model');
		
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$user_type = $this->session->userdata(SESSION.'usertype');
		if($user_type == '3')
			$this->buyer_inbox();
		else if($user_type == '4')
			$this->supplier_inbox();		
	}

    public function buyer_inbox()
	{
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="buyer_message";
		$this->data['account_title']="My Message";
		$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
		
		if(!$this->data['user_id']) { redirect(site_url('/')); }

		// $this->data['details'] = $this->general->fetch_members_selected_fields(array('name','email'), array('id'=>$this->data['user_id']));
		$this->data['buyer_messages'] = $this->mail_model->buyer_seller_inbox_communications($this->data['user_id']);
		//echo "<pre>"; print_r($this->data['inbox_msg']); echo "</pre>";
		
		$this->page_title = 'My Messages'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_mail_buyer_inbox', $this->data);
	}

	public function supplier_inbox()
	{
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="supplier_message";
		$this->data['account_title']="My Message";
		$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
		
		if(!$this->data['user_id']) { redirect(site_url('/')); }

		// $this->data['details'] = $this->general->fetch_members_selected_fields(array('name','email'), array('id'=>$this->data['user_id']));
		$this->data['buyer_messages'] = $this->mail_model->buyer_seller_inbox_communications($this->data['user_id']);
		//echo "<pre>"; print_r($this->data['inbox_msg']); echo "</pre>";
		
		$this->page_title = 'My Messages'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_mail_buyer_inbox', $this->data);
	}	
	
	public function outbox()
	{
		$this->breadcrumbs->push('Messaging :: Outbox', '/'); //second parameter is link
		$this->data['account_menu_active']="sent";
		$this->data['user_type'] = "buyer";
		$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
		
		$this->data['details'] = $this->general->fetch_members_selected_fields(array('name','email'), array('id'=>$this->data['user_id']));
		$this->data['outbox_msg']=$this->mail_model->seller_outbox_communications($this->data['user_id']);
		
		$this->page_title ='My Outbox'. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_mail_outbox', $this->data);
	}
	
	
	public function compose()
	{
		$this->data['account_menu_active']="compose";
		$this->data['page_header']=lang('mail_compose_header');

		$this->data['details'] = $this->mail_model->get_user_details();
		
		$this->form_validation->set_rules($this->mail_model->validate_rules_compose);
        if($this->form_validation->run()==TRUE)
		{
			$this->load->library('upload');
			
			$trans_stat = $this->mail_model->insert_message();              
			if($trans_stat)
			{
				$this->session->set_flashdata('message',lang('mail_mesg_sent'));
				redirect($this->general->lang_uri('/mail/outbox/'),'refresh');exit;
			}
        }
		
		$this->page_title = 'Compose Mail'. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_mail_compose', $this->data);
	}
	
	
	 public function action($type='')
	 {
		//echo $type; exit;
		$user_type = $this->session->userdata(SESSION.'usertype');
		if($type == 'outbox' OR $type =='inbox')
		{
			
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				//perform the actions according to the action selected
				switch($this->input->post('conversation_actions'))
				{
					case 'make_read': $trans_stat = $this->mail_model->change_message_status(2, $type); break;
					case 'make_unread': $trans_stat = $this->mail_model->change_message_status(1, $type); break;
					case 'make_delete': $trans_stat = $this->mail_model->change_message_status(3, $type); break;
					//case 'make_trash': $trans_stat = $this->admin_communication_model->delete_message_forever(); break;
					//case 'make_undo': $trans_stat = $this->admin_communication_model->change_admin_delete('N'); break;
					default : $trans_stat = FALSE;
				 }
				 //echo $trans_stat; exit;
				if($trans_stat)
				{
					 $this->session->set_flashdata('success_message',"Action Performed Successfully");
					 redirect($_SERVER['HTTP_REFERER'],'refresh');exit;                         
				}
				else
				{
					 $this->session->set_flashdata('error_message',"Unable to perform Action");
					 redirect($_SERVER['HTTP_REFERER'],'refresh');exit; 
				}
			}
			else
			{

				$this->session->set_flashdata('error_message',"Access Denied."); 
				if($user_type == '3')
				{
					redirect(site_url('my-messages/buyer_inbox/'),'refresh');exit;
				}
				else if($user_type == '4')
				{
					redirect(site_url('my-messages/supplier_inbox/'),'refresh');exit;					
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error_message',"Access Denied."); 
			if($user_type == '3')
			{
				redirect(site_url('my-messages/buyer_inbox/'),'refresh');exit;
			}
			else if($user_type == '4')
			{
				redirect(site_url('my-messages/supplier_inbox/'),'refresh');exit;					
			}
		}
		
	}
		
	
	public function conversation($type=NULL,$id=NULL,$seller_id=NULL)
	{
        $this->data = NULL;
		// $this->breadcrumbs->push('Messaging :: Conversation', '/'); //second parameter is link
		
		$this->data['account_menu_active']=$type;
		$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
		$this->data['msg_id'] = $id;
		//echo $this->data['user_id'];
		if(!$this->data['user_id']) { redirect(site_url('/')); exit; }

		$user_type = $this->session->userdata(SESSION.'usertype');
		if($user_type == '3')
			$this->data['user_type'] = "buyer";
		else if($user_type == '4')
			$this->data['user_type'] = "supplier";

		$this->form_validation->set_rules('message','Message','required');
		if($this->input->server('REQUEST_METHOD')=='POST' && $this->form_validation->run()==TRUE)
		{
			
			$this->load->library('upload');
			
			$trans_stat = $this->mail_model->insert_reply_message($this->data['user_id']);              
			if($trans_stat)
			{
				$this->session->set_flashdata('success_message','Message Sent Successfully');
				if($user_type == '3')
				{
					redirect(site_url('my-messages/buyer_inbox/'),'refresh');exit;
				}
				else if($user_type == '4')
				{
					redirect(site_url('my-messages/supplier_inbox/'),'refresh');exit;					
				}
			}
			else
			{
				$this->session->set_flashdata('error_message','Unable to send Message.');
				if($user_type == '3')
				{
					redirect(site_url('my-messages/buyer_inbox/'),'refresh');exit;
				}
				else if($user_type == '4')
				{
					redirect(site_url('my-messages/supplier_inbox/'),'refresh');exit;
				}
			}
		}
		
		$this->data['my_detail'] = $this->general->fetch_members_selected_fields(array('username','email'), array('id'=>$this->data['user_id']));
		
		$this->data['conversations'] = $this->mail_model->get_conversation_by_id($type,$id,$seller_id);
		//echo "<pre>"; print_r($this->data['conversations']); echo "</pre>";
		
		if(!$this->data['conversations'])
		{
			if($user_type == '3')
			{
				redirect(site_url('my-messages/buyer_inbox/'),'refresh');exit;
			}
			else if($user_type == '4')
			{
				redirect(site_url('my-messages/supplier_inbox/'),'refresh');exit;
			}
		}
		
		//change status of message to read if it is unread
		if($type=='inbox' && $this->data['conversations']->inbox_status==1)
		{
			$this->mail_model->change_message_status_to_read($id,2);
		}
		
		$this->data['attachment'] = $this->mail_model->get_conversation_attachments_by_id($id);
		
		//Another user who send (if type is 'inbox') or received (if type is 'outbox') the email
		$this->data['seller_info'] = $this->general->fetch_members_selected_fields(array('id', 'username','email'), array('id'=>$seller_id));
		//print_r($this->data['seller_info']);
		$this->page_title = 'My Message'. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_mail_conversation', $this->data);
	}
		
		
	public function attachment($type='',$msg_id=0,$file_id=0,$member_id=0)
	{
		//$member=$this->general->get_member_complete_details_by_user_id($member_id);
		if($msg_id && $file_id && $member_id)
		{
			$attachment = $this->mail_model->is_valid_attachment($msg_id,$file_id);
			//var_dump($attachment); die();
			if($attachment)
			{
				if($type=='inbox')
				{
					$args = array
					(
						'download_path' => FCPATH.ATTACHMENT_ADMIN_UPLOAD_DIR.''.$member_id.'/'.ATTACHMENTS_DIR.$msg_id.'/',
						'file' => $attachment->file_saved,
						'file_name' => $attachment->file_name,
						'referrer_check' => TRUE,
						//'referrer' => $this->general->lang_uri('/mail/conversation/'),
					);
				}
				else if($type=='sent')
				{
					$args = array(
						'download_path' => FCPATH.ATTACHMENT_UPLOAD_DIR.''.$member_id.'/'.ATTACHMENTS_DIR.$msg_id.'/',
						'file' => $attachment->file_saved,
						'file_name' => $attachment->file_name,
						'referrer_check' => TRUE,
						//'referrer' => $this->general->lang_uri('/mail/conversation/'),
					); 
				}
				$this->mail_model->get_file_download($args);
			}
			else
			{
				redirect($this->general->lang_uri('/mail/inbox/'),'refresh');exit;
			}
		}
		else
		{
			redirect($this->general->lang_uri('/mail/inbox/'),'refresh');exit;
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */