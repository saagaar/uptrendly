<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_module extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public $validate_settings =  array(				
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required')
	);
	public $validate_rules_reset_password = array(
		array('field' => 'password' , 'label' => 'New Password' , 'rules' => 'required|min_length[6]|max_length[20]'),
		array('field' => 'repassword' , 'label' => 'New Password Confirmation' , 'rules' => 'required|min_length[6]|max_length[20]|matches[password]'),
	);

	public function check_email()
	{
		$options = array('email'=>$this->input->post('email',TRUE));
        $query = $this->db->get_where('members',$options);
		return $query->num_rows();
	}

	public function get_user_by_email($email)
	{
		$options = array('email'=>$email);
        $query = $this->db->get_where('members',$options);
		if($query->num_rows()>0)
		{
            return $query->row();
        }
        else
        {
            return FALSE;
        }
	}




	public function send_forget_password_link($user_id, $email)
	{
		$this->load->model('email_model');
		//get subjet & body
		$template = $this->email_model->get_email_template("send_password_reset_link");
		if($template)
		{
			$activation_key = $this->generate_password_activation_code($user_id, $email);
			
			$encoded_email = base64_encode($email);
						
			$reset_link = "<a href='".site_url('/user/login/reset_password').'/?key='.urlencode($activation_key).'&auth='.urlencode($encoded_email)."'>".site_url('/user/login/reset_password').'/?key='.urlencode($activation_key).'&auth='.urlencode($encoded_email)."</a>";
			
			//ini_set("SMTP","smtp.wlink.com.np");
			//load email library
			$this->load->library('email');
			
			$config = Array(
				'protocol' => 'mail',
				'smtp_host' => 'smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'ktmtest2@gmail.com',
				'smtp_pass' => 'admin#123',
				'mailtype'  => 'html', 
				'charset'   => 'utf-8',
				'wordwrap'  =>TRUE,
			);
			//initialize email configurations
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			
			$subject=$template['subject'];
			$emailbody=$template['email_body'];
			
			//check blank valude before send message
			if(isset($subject) && isset($emailbody))
			{
				//parse email
				$parseElement=array("CONFIRM"=>$reset_link,
									"SITENAME"=>WEBSITE_NAME
								);
	
				$subject = $this->email_model->parse_email($parseElement,$subject);
				$emailbody = $this->email_model->parse_email($parseElement,$emailbody);
						
				//set the email things
				$this->email->from(CONTACT_EMAIL);
				$this->email->to($email); 
				$this->email->subject($subject);
				$this->email->message($emailbody); 
				$ok = $this->email->send();
				
				//echo $emailbody; exit;
				//echo $this->email->print_debugger(); exit;
				
				if($ok)
				{
                	return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
		else 
		{
			return FALSE;
		}
	}
	
	
	
	public function generate_password_activation_code($id,$email){
        /*The activation code is only valid for next 24hrs
         * +24 hours   = for next 24 hrs
         * +6 hours    = for next 6 hrs
         */
        $data = array(
            'forgot_password_code' => random_string('unique'),
            'forgot_password_code_expire' => date('Y-m-d H:i:s',strtotime("+24 hours"))
        );
        
        $this->db->update('members', $data, array('id' => $id,'email' => $email));
        return $data['forgot_password_code'];
    }
	
	
	 public function is_user_ready_reset_password($email,$code){
        $this->db->select('forgot_password_code_expire');
        $query = $this->db->get_where('members', array('forgot_password_code' => $code, 'email' => $email));
        if($query->num_rows()>0){
            return $query->row();
        }
        else{
            return FALSE;
        }
    }
	
	
	public function change_users_password($email){
		$password_tmp  = $this->input->post('password');
		// Create a random salt
		$salt = $this->general->salt();		
		$password = $this->general->hash_password($password_tmp, $salt);
        
        $data = array(
            'password' => $password,
            'salt' => $salt,
            'forgot_password_code' => '',
			'forgot_password_code_expire' => '0000-00-00 00:00:00',
        );
        
        $this->db->update('members', $data,array('email' => $email));
       	// echo $this->db->last_query(); exit;
        return $this->db->affected_rows();
    }















	//check facebook username
	public function get_fb_user_num($facebook_id) 
	{	
		$option = array('facebook_id'=>$facebook_id,'reg_type'=>'facebook');
		$query = $this->db->get_where('members',$option);
		
		//echo $this->db->last_query(); exit;
		return $query->num_rows();
	}
	
	//modified by pradip for inserting new (facebook) member
	public function insert_facebook_member($facebook_id,$email, $name, $ip_addr)
    {
		//for users image from facebook
		$img = file_get_contents('https://graph.facebook.com/'.$facebook_id.'/picture?type=large');
		$file = FCPATH.USER_IMAGE_PATH.$facebook_id.'.jpg';
		file_put_contents($file, $img);
		//end of image copy from facebook server
		
		$data = array(
			'name' => $name,
			'email' => $email,
			'user_type' => '3',
			'status' => '1',
			'balance' => SIGNUP_BONUS,
		   	'reg_date' => $this->current_date,
			'reg_ip' => $ip_addr,
			'is_login' => '1',
			'reg_type' => 'facebook',
			'facebook_id' => $facebook_id,
		);
		$this->db->insert('members',$data);
		$this->user_id = $this->db->insert_id();

		
		//add transaction for signup bonus if greater than zero
		if(SIGNUP_BONUS>0){
			$this->insert_signup_bonus_record_transaction($this->user_id);	
		}
 		//$option = array('id'=>$this->user_id);
		//$qry = $this->db->get_where('members',$option);
		$qry = $this->get_fb_user($facebook_id);
		//echo $this->db->last_query(); exit;
	    if($qry){
			$this->insert_users_info_to_Mailchimp($email, $name);
			return $qry;
		}else{
			return FALSE;  
		}
     }
		
	 //check facebook user
	public function get_fb_user($facebook_id) 
	{	
		$this->db->where('facebook_id', $facebook_id);
		$query = $this->db->get('members');
		
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
		return FALSE;
	}
	
	//check facebook username
	public function get_google_user_num($google_id) 
	{	
		$option = array('google_id'=>$google_id,'reg_type'=>'google');
		$query = $this->db->get_where('members',$option);
		
		//echo $this->db->last_query(); exit;
		return $query->num_rows();
	}
	
	public function get_google_user($google_id) 
	{	
		$this->db->where('google_id', $google_id);
		$query = $this->db->get('members');
		
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
		return FALSE;
	}
	
	
	
	public function insert_signup_bonus_record_transaction($user_id)
	{
		$invoice = strtotime("now");
		$txdata = array(
		   'invoice_id' => $invoice,
			'user_id' => $user_id,		   		
			'credit_get' => SIGNUP_BONUS,
			'credit_debit' => 'CREDIT',
			'transaction_type' => 'signup_bonus',
			'transaction_name' => 'Free Balance for signup',
			'transaction_date' => $this->general->get_local_time('time'),
			'transaction_status' => 'Completed',
			'payment_method' => 'direct',
		   //'current_balance' => SIGNUP_BONUS
		);
		
		$this->db->insert('transaction', $txdata);
	}
	
	public function insert_users_info_to_Mailchimp($email, $name)
	{
		$result = $this->mailchimp_library->call('lists/subscribe', array(
			'id'                => '252d82a6a5',
			'email'             => array('email'=>$email),
			'merge_vars'        => array('FNAME'=>$name),
			'double_optin'      => FALSE,
			'update_existing'   => TRUE,
			'replace_interests' => FALSE,
			'send_welcome'      => FALSE,
		));
	}
	
	
	//modified by pradip for inserting new (facebook) member
	public function insert_google_member($google_id, $name, $email, $image_url, $reg_ip)
    {
		//for users image from facebook
		$img = file_get_contents($image_url);
		$file = FCPATH.USER_IMAGE_PATH.$google_id.'.jpg';
		file_put_contents($file, $img);
		//end of image copy from facebook server
		
		$data = array(
			'name' => $name,
			'email' => $email,
			'user_type' => '3',
			'status' => '1',
			'balance' => SIGNUP_BONUS,
		   	'reg_date' => $this->current_date,
			'reg_ip' => $reg_ip,
			'reg_type' => 'google',
			'google_id' => $google_id,
		);
		$this->db->insert('members',$data);
		$this->user_id = $this->db->insert_id();

		
		//add transaction for signup bonus if greater than zero
		if(SIGNUP_BONUS>0){
			$this->insert_signup_bonus_record_transaction($this->user_id);	
		}
 		//$option = array('id'=>$this->user_id);
		//$qry = $this->db->get_where('members',$option);
		$qry = $this->get_google_user($google_id);
		//echo $this->db->last_query(); exit;
	    if($qry){
			$this->insert_users_info_to_Mailchimp($email, $name);
			return $qry;
		}else{
			return FALSE;  
		}
     }
	
	
	//function to check twitter user
	function check_twitter_user($twitter_id) 
	{
		$this->local_time = $this->general->get_local_time('time');
		$this->ip_address = $this->general->get_real_ipaddr();
		
		$this->db->select('*');
		$this->db->where(array('reg_type'=>'twitter','twitter_id'=>$twitter_id));
		$query = $this->db->get('members');
		
		if($query->num_rows()>0)
		{
			//assign result to vaiable
			$result = $query->row();
			
			//update last login
			$update_data = array(
				'last_login_date'=>$this->local_time,
				'last_ip_address'=>$this->ip_address,
				'mem_login_state'=>1
			);
				
			$this->db->where('id',$result->id);
			$this->db->update('members',$update_data);
			
			//echo $this->db->last_query(); exit;
			return $result;
		}
		else
		{
			//insert data to member,transaction tables
			$data = array(
				'name'=>$this->session->userdata('twitter_screen_name'),
				'status' => '1',
				'user_type' => '3',   
		   		'reg_date' => $this->local_time,
		   		'reg_ip_address' => $this->ip_address,
				'balance' => SIGNUP_BONUS,
				'reg_type'=>'twitter',
				'twitter_id'=>$twitter_id
			);
			
				
			//for users image from twitter
			if($this->session->userdata('twitter_user_image_link') && $this->session->userdata('twitter_user_image_link')!='')
			{
				$img = file_get_contents($this->session->userdata('twitter_user_image_link'));
				$file = FCPATH.USER_IMAGE_PATH.$twitter_id.'.jpg';
				file_put_contents($file, $img);
				//end of image copy from twitter server
				$data['image'] = $twitter_id.'.jpg';
			}
			
			$this->db->insert('members',$data);
			$new_user_id = $this->db->insert_id();
			
			//echo $this->db->last_query(); echo "<br>";
			
			//insert signup bonus record into transaction table if signup bonus is greater than zero
			if(SIGNUP_BONUS>0){
				$txdata = array(
					'invoice_id' => strtotime("now").$new_user_id,
					'user_id' => $new_user_id,		   		
					'credit_get' => SIGNUP_BONUS,
					'credit_debit' => 'CREDIT',
					'transaction_type' => 'signup_bonus',
					'transaction_name' => 'Free Balance for signup',
					'transaction_date' => $this->local_time,
					'transaction_status' => 'Completed',
					'payment_method' => 'direct',
					'current_balance' => SIGNUP_BONUS
					);
			
				$this->db->insert('transaction', $txdata);
			}
			
			//echo $this->db->last_query(); echo "<br>";
			
			//now get currently added data
			$this->db->select('*');
			$this->db->where(array('reg_type'=>'twitter','twitter_id'=>$twitter_id));
			$query = $this->db->get('members');
			
			//echo $this->db->last_query(); echo "<br>"; exit;
			
			return $query->row();
		}
		return FALSE;
	}
	
	
	
	
}
