<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_communication_model extends CI_Model 
{
   var $validate_rules_compose = array(
		array('field' => 'msg_to', 'label' => 'Message To', 'rules' => 'trim|required|valid_email|callback_check_email_existence'),	
		array('field' => 'subject', 'label' => 'Subject', 'rules' => 'trim|required|min_length[2]|max_length[200]'),
		array('field' => 'msg_attachments', 'label' => 'Attachment', 'rules' => 'callback__handel_file_uploads[msg_attachments]'),
		array('field' => 'message', 'label' => 'Message', 'rules' => 'trim|required|min_length[5]'),
	);   
   
   
   	public function get_total_admin_inbox()
	{
    	$admin_id=1;
		$this->db->where('receiver_id','1'); 
		// $this->db->where('inbox_status !=',3);
    	return $this->db->count_all_results('communication');
    }
	
	
	public function get_total_admin_sent(){
    	$admin_id=1;
		$this->db->where('sender_id',$admin_id); 
    	$this->db->where('ismsgseen !=',1);
    	return $this->db->count_all_results('communication');
    }
	
	public function admin_inbox_communications($limit=50,$offset=0){
        $admin_id=1;
		$this->db->select("C.*, M.username, M.email,C.ismsgseen");
		$this->db->from('communication C');
		$this->db->join('members M','C.sender_id=M.id');
		$this->db->join('products p','p.id=C.product_id','left');
		$this->db->where(array('C.receiver_id'=>1)); 
		// $this->db->where('C.inbox_status !=',3); 
		$this->db->order_by("C.messagedate", "desc"); 
		$this->db->group_by("C.id"); 
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get('communication');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();
		}
		return false;            
    }
	
	public function admin_sent_communications($limit=50,$offset=0){
        $admin_id=1;
		$this->db->select("C.*, MD.name as name, M.email");
		$this->db->from('communication C');
		$this->db->join('members M','C.receiver_id=M.id');
		$this->db->join('members_details MD','MD.user_id=M.id');
		$this->db->join('products p','p.id=C.product_id','left');
		$this->db->where(array('C.sender_id'=>$admin_id)); 
		// $this->db->where('C !=',3); 
		$this->db->order_by("C.messagedate", "desc"); 
		$this->db->group_by("C.id"); 
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get('communication');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();
		}
		return false;            
    }
	
	//modified by rabi for the active seller
	public function get_active_seller()
	{
		$query = $this->db->get_where('members',array('user_type'=>3));
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}
	
	public function get_members_email_autocomplete($keyword)
	{
		$keyword = strtolower($keyword);
		$this->db->select('id, email as label, username as name');
		$this->db->where("(LOWER(email) like '%".$keyword."%' OR LOWER(username) like '%".$keyword."%')", NULL, FALSE);
		$this->db->order_by('id','DESC');
		$query = $this->db->get('members');
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			$data = $query->result();
			return $data;
		}
		return false;
	}
	
       
	public function insert_message(){
		$admin_id=1;
	  	$receiver_email = $this->input->post('msg_to');
		$user_id = $this->get_members_id_by_email($receiver_email);
		if($user_id == false){
			return false; //return false if users id is not found.
		}
		
		$data = array(
		   'receiver_id' => $user_id,
		   'sender_id' => $admin_id,
		   'subject' => $this->input->post('subject'),
		   'message' => $this->input->post('message'),
		   'product_id' => $this->input->post('product_id'),
		   'messagedate' => $this->general->get_local_time('time'),
		   'ismsgseen' => '0',
		  
	   	);
	  	
		$fields = array('name','email','phone','city','country','time_zone,user_type');
		$user_info=$this->general->get_user_details($user_id);
		
		$attach_file = array();
		//Insert Message
		
	   	$this->db->insert('communication',$data);
	   	$message_id = $this->db->insert_id();
		
		//insert attachments
	   	if(isset($_FILES['msg_attachments']) && is_uploaded_file($_FILES['msg_attachments']['tmp_name']))
		{
			$data_attach = $this->prepare_message_attachments($message_id,$user_id); 
			if($data_attach)
			{
				$this->db->insert('communication_attachment',$data_attach);
				$attachment = new stdClass();
				$attachment->path = FCPATH.ATTACHMENT_ADMIN_UPLOAD_DIR.''.$user_id.'/'.ATTACHMENTS_DIR.$message_id.'/'.$data_attach['file_saved'];
				$attachment->name = $data_attach['file_name'];
				$attach_file = array($attachment);
			}
		}
		$this->load->library('email');
	
		//configure mail
		$config = Array(
			//'protocol' => 'sendmail',
			'protocol' => 'mail',
			'smtp_host' => 'smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'ktmtest2@gmail.com',
			'smtp_pass' => 'admin#123',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8',
			'wordwrap'  =>TRUE,
		);
		
		$this->email->initialize($config);
	
		$this->load->model('email_model');	
		
		$template=$this->email_model->get_email_template("communication-from-admin");
	
		$subject=$template['subject'];
		$emailbody=$template['email_body'];
	
		if(isset($subject) && isset($emailbody))
		{
			//parse email
			$parseElement = array(
				"SELLER_NAME"=>$user_info->name,
				"SELLER_ID"=>$user_id,
				"SUBJECT"=>$this->input->post('subject'),									
				"MESSAGE"=>$this->input->post('message'),
				"SITENAME"=>WEBSITE_NAME
			);
		 
			$subject=$this->email_model->parse_email($parseElement,$subject);
			$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
			
			
			if($user_info->user_type=='3')
			{
				$emailfrom=ADVERTISER_EMAIL;
			}
			else{
				$emailfrom=INFLUENCER_EMAIL;
			}
			$this->email->from($emailfrom);
			$this->email->to($user_info->email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			$this->email->clear();
			
		}		
	   	return $this->db->affected_rows();
	} 
	   
	public function prepare_message_attachments($message_id = 0,$seller_id){
		$file_uploaded = $this->seller_save_file('msg_attachments',ATTACHMENTS_DIR.$message_id,$seller_id);
		if($file_uploaded){
			$data_attach = array(
				'msg_id' => $message_id,
				'file_name' => $file_uploaded['client_name'],
				'file_saved' => $file_uploaded['file_name'],
				'file_size' => $file_uploaded['file_size'],
				'file_mimetype' => $file_uploaded['file_type']
			);
			return $data_attach;
		} else {
		   return false;
		}
	}
	
	
	public function seller_save_file($field,$step_name,$member_id){
        $file_name = null;
        $save_name = time();
        if(is_uploaded_file($_FILES[$field]['tmp_name'])){
            $file_name = $_FILES[$field]['name'];
            $save_file_name = $save_name.'.'.$this->get_file_extension($file_name);
            $this->upload->initialize($this->seller_upload_file_config($step_name,$save_file_name,$member_id));
            if($this->upload->do_upload($field)){
                return $this->upload->data();
            }
            else{
                return false;
            }
        }
    }
	
	
	public function get_file_extension($file_name){
		return pathinfo($file_name,PATHINFO_EXTENSION);
	}
	
	public function seller_upload_file_config($step_name,$filename,$member_id){
		$upload_path = FCPATH.ATTACHMENT_ADMIN_UPLOAD_DIR.''.$member_id.'/'.$step_name.'/';
		//Make Directory
		if (!is_dir($upload_path)) { 
			$theupload_path = mkdir($upload_path, 0755,true);
			//var_dump($theupload_path);
		}
        
        $config = array(
            'allowed_types' => ALLOW_ATTACHMENT_EXTENSION,
            'upload_path' => $upload_path,
            'max_size' => 2000,
            'file_name' => $filename,
            'overwrite' => true
        );
        //var_dump($config);
        return $config;
	}
	
	   
	public function change_admin_message_status($status, $type){
		if($this->input->post('msg_select'))
		{
				if($status=='3')
				{

					$message_selected = array_values($this->input->post('msg_select'));                
					$this->db->where_in('id',$message_selected);
					$this->db->delete('communication');
					return $this->db->affected_rows();
				}
				else
				{
					$data = array('ismsgseen' => $status);
					$message_selected = array_values($this->input->post('msg_select'));                
					$this->db->where_in('id',$message_selected);
					$this->db->update('communication',$data);
					//echo $this->db->last_query(); die();
					return $this->db->affected_rows();
				}
				
		}
		else{
			return false;
		}
	}
		
	public function get_conversation_by_id($type=NULL,$id=NULL,$user=NULL)
	{
		$type='';
		if($type == 'sent')
		{
			$this->db->where('receiver_id',$user);
		}
		else if($type == 'inbox')
		{
			$this->db->where('sender_id',$user);
		}
		
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get('communication');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}
	
	public function change_message_status_to_read($msg_id,$status_code)
	{
		$this->db->where('id',$msg_id);
		$this->db->update('communication',array('ismsgseen' => '1'));
		return $this->db->affected_rows();
	}
	
		
	public function get_conversation_attachments_by_id($id=NULL)
	{
		$this->db->where('msg_id',$id);
		$this->db->limit(1);
		$query=$this->db->get('communication_attachment');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return false;
	}
	   
	   
	public function is_valid_attachment($msg_id,$file_id)
	{
		$this->db->where('msg_id',$msg_id);
		$this->db->where('id',$file_id);
		$query = $this->db->get('communication_attachment');		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	
	public function get_file_download($args=array())
	{
        $this->load->model('download/download_model');
        
		$this->download_model->set_args($args);
        $this->download_model->set_extensions();
        $this->download_model->prepare_download();
            
        if($this->download_model->download_hook['download'])
		{
         	$this->download_model->set_download();
    	 	$this->download_model->start_download();
        }
        else
        {
            die($this->download_model->download_hook['message']);
        }
    }
	
	public function get_members_id_by_email($email)
	{
		$this->db->select('id,user_type');
		$this->db->where(array('email'=>$email));
		$query = $this->db->get('members');
		//echo $this->db->last_query(); exit;
		if($query->num_rows()==1)
		{
			$data = $query->row();
			return $data->id;
		}
		return false;
	}
	
	
	public function insert_notification()
	{   
		$admin_id=$this->session->userdata(ADMIN_LOGIN_ID);
		$user_id=$this->input->post('msg_to');
		$current_date = $this->general->get_local_time('time');
		$data = array(
			'generator_id'=>$admin_id,
			'receiver_id'=>$user_id,
			'notification_type'=>'email',
			'notification_desc'=>'1 new message',
			'create_date'=>$current_date,
			'status_read'=>"No"
		); 
		$query = $this->db->insert('notification', $data);
	} 
}