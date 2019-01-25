<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_login extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
	}
	
	public function admin_login()
	{		
		$login = $this->check_admin_login();
                
		if($login == 'success'){
			
			return true;
		}
		else {
			return false;
		}
	}

	
	/* admin login */
	public function check_admin_login() 
	{
		$uname = $this->input->post('username',TRUE);
		$pass = $this->input->post('password',TRUE);
	
		$this->db->select('id,username,user_type,salt,password,status');
		$this->db->where('username',$this->input->post('username',TRUE));
		$this->db->where("(user_type='1' OR user_type='2')");
		$query = $this->db->get('members');

		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0)
		{
			$record = $query->row();
			//echo $record->status; exit;
			
			//check active admin
			if($record->status==='1')
			{
				if(strtolower($record->username)===strtolower($uname) && $record->password===$this->general->hash_password($pass,$record->salt))
				{
					//update admin last login
					$this->update_member($record->id);
					
					$this->session->set_userdata(ADMIN_LOGIN_ID, $record->id);
					$this->session->set_userdata(ADMIN_USER_NAME, $record->username);
					$this->session->set_userdata(ADMIN_USER_TYPE, $record->user_type); 
					
					return "success";
				}
				else
				{
					//keep log of login if login is not successful
					if(LOG_ADMIN_INVALID_LOGIN == 'Y'){ 
                    $this->general->log_invalid_logins(array('password' => $pass, 'username' => $uname, 'module' => 'Admin Login', 'desc' => 'invalid password'));
                	}
					
					return 'wrong password ';	
				}
				
			}
			else
			{
				//keep log of login if login is not successful
				if(LOG_ADMIN_INVALID_LOGIN == 'Y'){ 
				$this->general->log_invalid_logins(array('password' => $pass, 'username' => $uname, 'module' => 'Admin Login', 'desc' => 'Admin not activated'));
				}
				
				return 'Admin not activated';	
			}
		}
		else
		{
			//keep log of login if login is not successful
			if(LOG_ADMIN_INVALID_LOGIN == 'Y'){ 
			$this->general->log_invalid_logins(array('password' => $pass, 'username' => $uname, 'module' => 'Admin Login', 'desc' => 'Admin user not registered'));
			}
			
			return 'Admin user not registered';
		}
	}
	
	public function update_member($memid)
	{
		$ip_addr = $this->general->get_real_ipaddr();
		$cdate = $this->general->get_local_time('time');
		
		$udata = array(
               	'last_login_date' => $cdate,
				'last_login_ip' =>$ip_addr,
				'is_login' => '1'
				);
				
		$this->db->where('id',$memid);
		$this->db->update('members',$udata);
	}
}
