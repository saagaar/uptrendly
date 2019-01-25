<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Notification
{
	
	function __construct()
	{
		$this->ci =& get_instance();
	}

	// Example function call 
    //send_email_notification(1, 1, 'email1@gmail.com, email2@gmail.com', 'test@test.com', 'email3@gmail.com','email4@gmail.com', array("EMAIL"=>'Bikram',"PASSWORD"=>'123456',"SITENAME"=>WEBSITE_NAME) ) );
	public function send_email_notification($email_code, $user_id, $sender_email, $receiver_email, $cc='', $bcc='', $parse_element=array(), $attachments=array() ){

		$email_template = $this->get_email_part($email_code);

		if(empty($email_template) OR $email_template == ''){
			return false;
		}
		$email_template_id = $email_template->id;
			// Get Template's Default Settings by admin
		$template_settings = $this->get_template_settings_byid($email_template_id);	
		
			//Get user custom settings
		$user_settings = $this->get_user_notification_setting($email_template_id, $user_id);

			//If user settings is not set, put template default settings to user.
		if( empty( $user_settings ) ){
			$user_settings = $template_settings;
		}

		// If admin set the template setting is not visible to user and send email notification is set yes, send email to user by default
		// Also IF user has previllage to enable/disable email notification, we have to check user's and templates default email send notification option. If both are set yes then send this sms template to user.		
		if(($template_settings->is_display_notification == 0 && $template_settings->is_email_notification_send ==1)  || ($template_settings->is_display_notification==1 && $template_settings->is_email_notification_send==1 && $user_settings->is_email_notification_send==1) ) {			

			if( $this->send_mail($sender_email, $receiver_email, $cc, $bcc, $template_settings->subject, $template_settings->email_body, $parse_element,$attachments)){
				return true;
			}else{
				return false;
			}					
		}

		
	}

	public function send_sms_notification($template_id, $user_id, $senderid, $mobileno,$parse_element=array()){
		
		if(SMS_NOTIFICATION == 1){

			// Get Template's Default Settings by admin
			$template_settings = $this->get_email_settings_email_templateid($template_id);	

			//Get user custom settings
			$user_settings = $this->get_user_notification_setting($template_id, $user_id);

			//If user settings is not set, put template default settings to user.
			if( empty( $user_settings ) ){
				$user_settings = $template_settings;
			}

			// If admin set the template setting is not visible to user and send sms notification is set yes, send sms to user by default		
			//Also IF user has previllage to enable/disable sms notification, check users and templates sms send notification option. If both are set yes then send this sms template to user.	
			if(($template_settings->is_display_notification == 0 && $template_settings->is_sms_notification_send ==1 )||($template_settings->is_display_notification==1 && $template_settings->is_email_notification_send==1 && $user_settings->is_email_notification_send==1)) {			

				 // http://gateway80.onewaysms.sg/api2.aspx  
				$message = $this->parse_message($parse_element, $sms_msg);      
				$query_string = "?apiusername=".SMS_API_USERNAME."&apipassword=".SMS_API_PASSWORD;
				$query_string .= "&senderid=".rawurlencode($sms_from)."&mobileno=".rawurlencode($sms_to);

				$query_string .= "&message=".rawurlencode(stripslashes($message)) . "&languagetype=1"; 

				$url = SMS_GATEWAY_URL.$query_string;     
		  // echo $url ;  exit;

				$fd = @implode ('', file ($url));
		  // print_r($fd); echo file ($url); exit; 				     
				if ($fd)  
				{ 
					//print_r($fd);  exit;                      
					if ($fd > 0) {
						//Print("MT ID : " . $fd);
						$ok = true;
					}        
					else {
						//print("Please refer to API on Error : " . $fd);
						$ok = false;
					}
				}           
				else      
				{                       
                    // no contact with gateway                      
					$ok = false;       
				}           

			} 
			else{
				$ok = false;
			}

			return $ok;
		}
	}

	// updated by manish 
	public function user_notification_settings($userid)
	{	
		
		$data['user_set'] = $this->import_user_settings($userid);
		$data['default_set'] = $this->import_default_settings();
		$final_result = array();

		foreach ($data['default_set'] as $defkey => $defval) {

			if( $defval->is_display_notification ==1 ){

				$final_result[$defval->id]['email_template_id'] = $defval->id;

				$final_result[$defval->id]['email_send_user'] = $defval->is_email_notification_send;

				$final_result[$defval->id]['email_send_admin'] = $defval->is_email_notification_send;

				$final_result[$defval->id]['subject'] = $defval->subject;

				if(SMS_NOTIFICATION ==1){

					$final_result[$defval->id]['sms_send_admin'] = $defval->is_sms_notification_send;

					$final_result[$defval->id]['sms_send_user'] = $defval->is_sms_notification_send;
				}

				if($data['user_set']) {
					foreach ($data['user_set'] as $usrkey => $usrval) {

						if( $defval->id == $usrval->email_template_id ){


							$final_result[$defval->id]['email_send_user'] = $usrval->is_email_notification_send;

							if(SMS_NOTIFICATION ==1){							

								$final_result[$defval->id]['sms_send_user'] = $usrval->is_sms_notification_send;
							}
							
						} 
					
					}
				}
			}
		}

		return $final_result;
	}

	// to parse the the email which is available in the
	function parse_message($parseElement,$mail_body)
	{
		foreach($parseElement as $key=>$value)
		{
			$parserName=$key;
			$parseValue=$value;
			$mail_body=str_replace("[$parserName]",$parseValue,$mail_body);
		}

		return $mail_body;
	}

	public function send_mail($from,$to,$cc,$bcc,$subject,$body, $parse_element, $attachments = array()) { 

		$this->ci->load->library('email');
		$config['charset'] = 'utf-8';
	  	$config['wordwrap'] = TRUE;
	  	$config['mailtype'] = 'html';
	  	$config['protocol'] = 'sendmail';
		$this->ci->email->initialize($config); 

		$email_header = $this->get_email_part('email_header');

		$email_footer = $this->get_email_part('email_footer');

		$message = $email_header->email_body.$body.$email_footer->email_body;

		$parsed_message = $this->parse_message($parse_element,$message);

		// echo $from.'<br/>';

		// echo $to.'<br/>';
		// echo $subject.'<br/>';
		// echo $parsed_message.'<br/>';
		$this->ci->email->from($from);

		$this->ci->email->to($to);

		if($cc!=''){
			$this->ci->email->cc($cc);
		}
		if($bcc!=''){
			$this->ci->email->bcc($bcc);
		}

		$this->ci->email->subject($subject);

		$this->ci->email->message($parsed_message);

		if(count($attachments)>0){

			foreach($attachments as $files){

				$this->ci->email->attach($files->path.'/'.$files->name);
			}
		}
		if ($this->ci->email->send())
			// exit;
			return true;
		else
			return false;

	}

	public function get_user_notification_setting($email_template_id, $user_id){

		$query = $this->ci->db->get_where('member_notification_settings', array('user_id'=>$user_id, 'email_template_id'=>$email_template_id));

		if($query->num_rows()==1){

			return $query->row();
		}

	}

	//function to get email details by email code
	public function get_template_settings_byid($email_template_id)
	{		

		$query = $this->ci->db->get_where('email_settings',array("id "=>$email_template_id));

		if ($query->num_rows() > 0)
		{
			return $query->row();
		} 

		return false;
	}

	function get_email_part($email_code){

		$this->ci->db->select('id,email_body');
		$query = $this->ci->db->get_where('email_settings',array('email_code'=>$email_code));
		if( $query->num_rows() > 0 ){
			return $query->row();
		}else
		return false;
	}	

	public function import_user_settings($userid){

		$query = $this->ci->db->get_where('member_notification_settings', array('user_id'=>$userid) );

		if($query->num_rows() > 0 ){

			return $query->result();
		} else {

			return false;
		}
	}
	public function import_default_settings(){

		$this->ci->db->select('id, is_display_notification, is_email_notification_send, is_sms_notification_send, subject, email_code');

		$query = $this->ci->db->get('email_settings');

		if($query->num_rows() > 0 ){

			return $query->result();
		} else {
			
			return false;
		}
	}

	public function update_notification_status($field, $value, $template_id, $user_id){
		$data = array(
			$field=>$value,
		);
		$this->ci->db->where('user_id', $user_id);
		$this->ci->db->where('email_template_id', $template_id);
		if( $this->ci->db->update('member_notification_settings', $data) ){
			return true;
		}else{
			return false;
		}

	}

	public function insert_notification_status($field, $value, $template_id, $user_id){
		$data = array(
			$field=>$value,
			'email_template_id'=>$template_id,
			'user_id'=>$user_id
		);
		
		if( $this->ci->db->insert('member_notification_settings', $data) ){
			return true;
		}else{
			return false;
		}

	}



	public function get_user_settingsby_tempid($template_id, $user_id){

		$this->ci->db->select('id');
		$query = $this->ci->db->get_where('member_notification_settings', array('email_template_id'=>$template_id,'user_id'=>$user_id));

		if( $query->num_rows() > 0 ){

			return true;
			
		}else{
			return false;
		}
	}

	// Added by manish for deleting user notification settings
	public function delete_notification_settings($user_id)
	{
		$this->ci->db->where('user_id', $user_id);
		$this->ci->db->delete('member_notification_settings');
	}

	// added by manish
	// for batch insert user notification settings
	public function insert_batch_notification_status($settings_data){
		
		if( $this->ci->db->insert_batch('member_notification_settings', $settings_data) ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	// added by manish
	// for batch update user notificaiton settings
	public function update_batch_notification_status($settings_data) {
		if( $this->ci->db->update_batch('member_notification_settings', $settings_data, 'email_template_id') ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}