<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model 
{
   var $validate_rules_compose = array(
		// array('field' => 'msg_to', 'label' => 'Message To', 'rules' => 'trim|required'),	
		array('field' => 'subject', 'label' => 'Subject', 'rules' => 'trim|required|min_length[2]|max_length[200]'),
		//array('field' => 'msg_attachments', 'label' => 'Attachment', 'rules' => 'callback__handel_file_uploads[msg_attachments]'),
		array('field' => 'message', 'label' => 'Message', 'rules' => 'trim|required|min_length[5]')
	);
   
   	
	//Added by pradip to fetch members inbox messages.
	//updated by manish
	public function buyer_seller_inbox_communications($user_id){
		$this->db->select('C.*, M.username, M.user_type');
		$this->db->from('communication C');
		$this->db->join('members M','C.sender=M.id');
		$this->db->where('C.receiver',$user_id); 
		$this->db->where('C.inbox_status !=',3); 
		$this->db->order_by("C.date", "desc"); 
		//$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();
		}
		return false;           
    }
	
	 //modified by rabi for the admin inbox 
	 public function seller_outbox_communications( $user_id){
		$this->db->select('C.*, M.name, M.user_type');
		$this->db->from('communication C');
		$this->db->join('members M','C.sender=M.id');
		$this->db->where('C.sender',$user_id);
		$this->db->where('C.outbox_status !=',3); 
		$this->db->order_by("C.date", "desc"); 
		//$this->db->limit($limit, $offset);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	   
	   
	public function insert_message(){
		
		$user_id=$this->session->userdata(SESSION.'user_id');
		
		$user_info=$this->general->get_member_complete_details_by_user_id($user_id);
		$super_admin=$this->general->get_super_admin();  
		$data = array(
		   'receiver' => $super_admin->id,
		   'sender' => $user_id,
		   'subject' => $this->input->post('subject',TRUE),
		   'message' => $this->input->post('message',TRUE),
		   'date' => $this->general->get_local_time('time'),
		   'status_seller' => 1,
		   //'admin_read' => 'Y',
		   //'seller_delete' => 'N',
		   //'admin_delete' => 'N',
		   //'msg_root_id' => $id,
		   //'admin_id' => $this->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION)
		);
		
		$attach_file = array();
		
		//Insert Message
		$this->db->insert('communication',$data);
		$message_id = $this->db->insert_id();
		
		
		//insert attachments
		if(is_uploaded_file($_FILES['msg_attachments']['tmp_name']))
		{
			$data_attach = $this->prepare_message_attachments($message_id,$user_id); 
			if($data_attach)
			{
				$this->db->insert('communication_attachment',$data_attach);
				$attachment = new stdClass();
				$attachment->path = FCPATH.ATTACHMENT_UPLOAD_DIR.''.$user_id.'/'.ATTACHMENTS_DIR.$message_id.'/'.$data_attach['file_saved'];
				$attachment->name = $data_attach['file_name'];
				$attach_file = array($attachment);
			}
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
		   }
		   else {
			   return false;
			}
       }
	   
	   
	   	public function seller_save_file($field,$step_name,$member_id)
	   	{
       		$file_name = null;
        	$save_name = time();
        	if(is_uploaded_file($_FILES[$field]['tmp_name']))
			{
            	$file_name = $_FILES[$field]['name'];
            	$save_file_name = $save_name.'.'.$this->get_file_extension($file_name);
            	$this->upload->initialize($this->seller_upload_file_config($step_name,$save_file_name,$member_id));
            	if($this->upload->do_upload($field)){
                	return $this->upload->data();
            	}
            	else
				{
                	return false;
            	}
        	}
    	}
		
	
	   	public function get_file_extension($file_name){
        	return pathinfo($file_name,PATHINFO_EXTENSION);
       	}
	   
	   
	   	public function seller_upload_file_config($step_name,$filename,$member_id)
	  	{
       		$upload_path = FCPATH.ATTACHMENT_UPLOAD_DIR.''.$member_id.'/'.$step_name.'/';
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
		
		
		//insert reply message
		public function insert_reply_message($user_id)
		{
			$data = array(
               'msg_root_id' => $this->input->post('msg_root',TRUE),
			   'receiver' => $this->input->post('receiver',TRUE),
               'sender' => $this->input->post('sender',TRUE),
               'subject' => $this->input->post('subject',TRUE),
               'message' => $this->input->post('message',TRUE),
               'date' => $this->general->get_local_time('time'),
               'inbox_status' => 1,
			   'outbox_status' => 1,
          	);
           
		   	//Insert Message
           	$this->db->insert('communication',$data);
            $message_id = $this->db->insert_id();
		   	$attach_file = array();
		   	if($_FILES)
           	{
           		//insert attachments
   	           	if(is_uploaded_file($_FILES['msg_attachments']['tmp_name']))
   			   	{
   			    	$data_attach = $this->prepare_message_attachments($message_id,$user_id); 
   	                if($data_attach)
   					{
   					    $this->db->insert('communication_attachment',$data_attach);
   	                    $attachment = new stdClass();
   	                    $attachment->path = FCPATH.ATTACHMENT_UPLOAD_DIR.''.$user_id.'/'.ATTACHMENTS_DIR.$message_id.'/'.$data_attach['file_saved'];
   	                    $attachment->name = $data_attach['file_name'];
   	                    $attach_file = array($attachment);
   	              	}
   			   }
   			}
		   return $this->db->affected_rows();
		}
		
	
	  	public function change_message_status($status, $type)
		{
        	if($this->input->post('msg_select'))
			{
				if($type == 'inbox'){
					$data = array('inbox_status' => $status);
				}else if($type == 'outbox'){
					$data = array('outbox_status' => $status);
				}
			
        		$message_selected = array_values($this->input->post('msg_select'));                
            	$this->db->where_in('id',$message_selected);
            	$this->db->update('communication',$data);
            	//echo $this->db->last_query(); die();
            	return $this->db->affected_rows();
        	}
			else
			{
            	return FALSE;
            }
		}
		
		public function change_message_status_to_read($msg_id,$status_code)
		{
			$this->db->where('id',$msg_id);
            $this->db->update('communication',array('inbox_status' => $status_code));
			return $this->db->affected_rows();
		}
		
		
		public function get_conversation_by_id($type=NULL,$id=NULL,$seller=NULL)
		{
			$type='';
			if($type == 'outbox'){
				$this->db->where('receiver',$seller);
			}else if($type == 'inbox'){
				$this->db->where('sender',$seller);
			}
			
			$this->db->where('id',$id);
			$this->db->limit(1);
			$query=$this->db->get('communication');
			if($query->num_rows() > 0){
				return $query->row();
			}
			return false;
		}
		
		
		public function get_conversation_attachments_by_id($id=NULL){
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
       
	   	if ($query->num_rows() > 0){
        	return $query->row();
      	}else{
        	return false;
        }
	}
	
	public function get_file_download($args=array()){
        $this->load->model('download/download_model');
        
		$this->download_model->set_args($args);
        $this->download_model->set_extensions();
        $this->download_model->prepare_download();
            
        if($this->download_model->download_hook['download'])
		{
         $this->download_model->set_download();
    	 $this->download_model->start_download();
        }
        else{
            die($this->download_model->download_hook['message']);
            }
    } 
	
	   
	
}