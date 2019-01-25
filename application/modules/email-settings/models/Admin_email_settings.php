<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_email_settings extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();		
	}
	public $validate_settings =  array(
			array('field' => 'subject', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'content', 'label' => 'Email Body', 'rules' => 'required'),
			array('field' => 'is_display_notification', 'label' => 'Display Notification', 'rules' => 'required'),
			array('field' => 'is_email_notification_send', 'label' => 'Email Notification Send', 'rules' => 'required')
			);
	public $validate_sms_settings =  array(
			array('field' => 'sms_text', 'label' => 'SMS Text', 'rules' => 'required'), array('field' => 'is_sms_notification_send', 'label' => 'SMS Notification Send', 'rules' => 'required')
			);

	//function to get email details by email code
	public function get_email_settings_all_templates()
	{	
		$this->db->where('display_admin', '1');	
		$query = $this->db->get('email_settings');
		 $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		} 

		return false;
	}

	
	//function to get email details by email code
	public function get_email_settings_details_by_emailcode($emailcode)
	{		
		$query = $this->db->get_where('email_settings',array("email_code "=>$emailcode));

		if ($query->num_rows() > 0)
		{
			return $query->row();
		} 

		return false;
	}
	

	public function update_email_settings()
	{
		$data = array(
			'subject' => $this->input->post('subject', TRUE),               
			'email_body' => $this->input->post('content', TRUE),
			'is_display_notification' => $this->input->post('is_display_notification', TRUE),
			'is_email_notification_send' =>$this->input->post('is_email_notification_send', TRUE),
			'last_update' => $this->general->get_local_time('time')
			);
		if(SMS_NOTIFICATION == 1){
			$data['sms_text'] = $this->input->post('sms_text', TRUE);
			$data['is_sms_notification_send'] = $this->input->post('is_sms_notification_send', TRUE);
		}



		$email_code = $this->uri->segment(4);
		
		//check this data is exist or not, if it is not exist then insert into table otherwise update it
		$query = $this->db->get_where('email_settings',array("email_code"=>$email_code));
		
		if ($query->num_rows() > 0)
		{
			$this->db->where('email_code', $email_code);
			$query = $this->db->update('email_settings', $data); 
		}
		else
		{
			$data['email_code'] = $email_code;
			$query = $this->db->insert('email_settings', $data); 
		}
		//echo $this->db->last_query(); exit;
		if($query){return true;} else {return false;}
	}

	

	

}
