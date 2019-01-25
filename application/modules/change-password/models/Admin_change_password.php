<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_change_password extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
	}		
		
		
	public function update_admin_password()
	{
		$data = array('password' => md5($this->input->post('new_password', TRUE)));
		
		$salt = $this->general->salt();		
		$hash_password = $this->general->hash_password($this->input->post('new_password',TRUE),$salt);
		
		//set member info
		$data = array(
			   'password' => $hash_password,
			   'salt' => $salt,
			   'last_modify_date' => $this->general->get_local_time('time')
            );
				//insert records in the database
		$this->db->where('id',$this->session->userdata(ADMIN_LOGIN_ID));
		$this->db->update('members', $data); 
	}
}
