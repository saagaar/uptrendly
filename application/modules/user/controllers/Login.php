<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			//check whetheh logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
			if(!$this->session->userdata('MAINTAINANCE_KEY')=='YES' OR $this->session->userdata('MAINTAINANCE_KEY')!='YES'){
				redirect(site_url('/maintainance'));exit;
			}
		}
		
		if($this->session->userdata(SESSION.'user_id'))
		{
			if($this->session->userdata(SESSION.'usertype')=='3')
			redirect(site_url('/'.MY_ACCOUNT.'settings/profile'),'refresh');
			else
			redirect(site_url('/'.MY_ACCOUNT.'settings/profile'),'refresh');
		}
		 
		 //check banned IP address
		$this->general->check_banned_ip();
		
		//load CI library
		$this->load->library('form_validation');
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span generated="true" class="text-danger">', '</span>');
		
		//load module
		$this->load->model('login_module');
		
		// load text helper
		$this->load->helper('text');
		
		//load mailchimp library
		// $this->load->library('mailchimp_library');
	}
	
	public function index()
	{
		
		$this->form_validation->set_rules($this->login_module->validate_settings);
		if($this->form_validation->run()==TRUE)
		{

			$email = $this->input->post('email',TRUE);
			$password = $this->input->post('password',TRUE);
			
			 $login_status = $this->general->check_login_process($email, $password);
			
			if($login_status == "success")
			{
				$redirect= $this->session->userdata('redirectToCurrent');
				$this->session->unset_userdata('redirectToCurrent');
				if($redirect)
				{
					redirect($redirect);
				}
				else
				{
					if($this->session->userdata(SESSION.'usertype') == '3')
					redirect(site_url(MY_ACCOUNT.'settings/profile'), 'refresh');
					elseif($this->session->userdata(SESSION.'usertype') == '4')
					redirect(site_url(MY_ACCOUNT.'settings/profile'), 'refresh');	
				}
				
			}
			else
			{					
				if($login_status==='unregistered')
					$this->session->set_flashdata('error_message','You are not Registered. Please register first');
				else if($login_status==='unverified')
					$this->session->set_flashdata('error_message','You are not Verified yet.');
				else if($login_status==='suspended')
					$this->session->set_flashdata('error_message','You are Suspended.');
				else if($login_status==='close')
					$this->session->set_flashdata('error_message','Your Account is Deleted.');				
				else if($login_status==='invalid')
					$this->session->set_flashdata('error_message','Invalid Email/Username Or Password.');

				redirect(site_url('user/login'), 'refresh');
			}
				}
		$this->data['account_menu_active'] = "login";
		$this->data['meta_keys']= WEBSITE_NAME;
	    $this->data['meta_desc']= WEBSITE_NAME;
		$this->page_title = WEBSITE_NAME.' - Login';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_login', $this->data);	
	}
	
	
	public function user_login()
	{
		//return FALSE if it is not an ajax request
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		//echo "<pre>"; print_r($_GET); echo "</pre>"; exit;
		$this->form_validation->set_rules($this->login_module->validate_settings);
		if($this->form_validation->run()==TRUE)
		{
			//print_r($_POST); exit;
			//echo "<pre>"; print_r($_COOKIE); echo "</pre>"; exit;
			$username = $this->input->post('email',TRUE);
			$password = $this->input->post('password',TRUE);
			
			$login_status = $this->general->check_login_process($username, $password);
			
			if($login_status == "success")
			{
				//set username and password to cookie if user checked stay signed in
				$remember_me = (($this->input->post('rememberme',TRUE) && $this->input->post('rememberme',TRUE)!='')?'yes':'');
				
				if($remember_me=="yes"){
					setcookie('email', $username, time()+3600*24*10);
					setcookie('password', $password, time()+3600*24*10);
					//echo "<pre>"; print_r($_COOKIE); echo "</pre>"; exit;
				}else{
					setcookie('email', '',0);
					setcookie('password', '',0);
				}
				
				$return_data = array(
					'status'=>'success',
					//'message'=>'Login Sucessful.Now you will be redirected to your account page',
					'message'=>'Login Sucessful.',
					'return_url' =>($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:site_url(),
				);
			}
			else
			{
				$return_data['status'] = "error";
					
				if($login_status==='unregistered')
					$return_data['message'] =  "You are not Registered. Please register first";
				else if($login_status==='unverified')
					 $return_data['message'] = "You are not Verified yet.";
				else if($login_status==='suspended')
					$return_data['message'] = "You are Suspended.";
				else if($login_status==='close')
					$return_data['message'] = "Your Account Deleted.";
				else if($login_status==='invalid')
					$return_data['message'] = "Invalid Email/Username Or Password.";
			}
		}else{
			$return_data = array(
				'status'=>'error',
				'message'=>validation_errors()
			);
		}
		//print_r(json_encode($_POST)); exit;
		print_r(json_encode($return_data)); exit;
	}
	
	
	
	
	
	//controller method for facebook login
	public function facebook_login()
	{
		//return FALSE if it is not an ajax request
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		$final_response = array();
		
		$facebook_id = ($this->input->post('id',TRUE) && $this->input->post('id',TRUE)!='') ? $this->input->post('id',TRUE):'';
		$email = ($this->input->post('email',TRUE) && $this->input->post('email',TRUE)!='') ? $this->input->post('email',TRUE):'';
		$gender = ($this->input->post('gender',TRUE) && $this->input->post('gender',TRUE)!='') ? $this->input->post('gender',TRUE):'';
		$name = ($this->input->post('name',TRUE) && $this->input->post('name',TRUE)!='') ? $this->input->post('name',TRUE):'';
		
		if($facebook_id && $email )
		{
			//assign current date and users ip in local variables
			$this->current_date = $this->general->get_local_time('time');
			$this->user_ip = $this->general->get_real_ipaddr();
			
			//check whether this user exists or not
			$this->data['user_nums'] = $this->login_module->get_fb_user_num($facebook_id);
  			//echo $this->data['user_nums'];  //exit;

			
			if($this->data['user_nums'] == 1)
			{   
				//means user already registered
				$this->data['user_data'] = $this->login_module->get_fb_user($facebook_id);
				//echo "<pre>"; print_r($this->data['user_data']); echo "</pre>"; exit;
				//incase user changes his/her email address of facebook
				if($email != $this->data['user_data']->email)
				{
					$data = array('email' => $email	);
				
					$this->db->where('id',$this->data['user_data']->id);   		
					$this->db->update('members',$data);
			
					$this->session->set_userdata(array(SESSION.'email' => $email));
				}
				else
				{
					$this->session->set_userdata(array(SESSION.'email' => $this->data['user_data']->email));
				}
				
				$this->session->set_userdata(array(SESSION.'user_id' => $this->data['user_data']->id));
				
				if($this->data['user_data']->user_type){
					$this->session->set_userdata(array(SESSION.'usertype' => $this->data['user_data']->user_type));
				}
				
				if($this->data['user_data']->name)
				{ $this->session->set_userdata(array(SESSION.'name' => $this->data['user_data']->name));}
					
				if($this->data['user_data']->image) 
				{	$this->session->set_userdata(array(SESSION.'image' => $this->data['user_data']->image)); }
				//print_r($this->session->all_userdata());   exit;
				
				//update users login status
				$this->db->update('members',array('is_login'=>'1'), array('facebook_id'=>$facebook_id));
				
				//response
				$final_response = array(
					'status' => 'success',
					'logged_in' => 'yes',
					//'message' => 'Login Successful. Now you will be redirected to your account page'
					'message'=>'Login Sucessful',
				);
			}
			else
			{
				//first check whether email from facebook login is already used in our site or not.
				//if already exists redirect to register page with error message
				//if doesnot exist insert data into table
				
				/*echo "facebook user not registered";
				echo $facebook_id;
				exit;*/
				
				//var_dump($this->general->check_members_email_existance($email)); exit;
				if($this->general->check_members_email_existance($email)==FALSE)
				{
					//this email is already in members list
					//$this->session->set_flashdata('error_msg',lang('facebook_email_already_in_use'));
					//redirect(site_url('/user/register'));  exit;
					
					$final_response = array(
						'status' => 'error',
						'logged_in' => 'no',
						'message' => 'This email already exits.'
					);
				}
				
				
				//echo "facebook user not registered";
				//echo $facebook_id; 
				//insert into database and direct to the profile page
				$this->data['user_profile'] = $this->login_module->insert_facebook_member($facebook_id, $email, $name, $this->user_ip);
				//print_r($this->data['user_profile']); exit;
				
				//maintain the session
				$this->session->set_userdata(array(SESSION.'user_id' => $this->data['user_profile']->id));
				$this->session->set_userdata(array(SESSION.'email' => $this->data['user_profile']->email));
							
				if($this->data['user_profile']->name)
				{ $this->session->set_userdata(array(SESSION.'name' => $this->data['user_profile']->name)); }
					
				
				if($this->data['user_profile']->user_type){
					$this->session->set_userdata(array(SESSION.'usertype' => $this->data['user_profile']->user_type));
				}
				
				if($this->data['user_profile']->image) 
				{	$this->session->set_userdata(array(SESSION.'image' => $this->data['user_profile']->image)); }
				
					
				//response
				$final_response = array(
					'status' => 'success',
					'logged_in' => 'yes',
					//'message' => 'Login Successful. Now you will be redirected to your account page'
					'message'=>'Login Sucessful',
				);
			}						 
		}
		else if($facebook_id)
		{
			$final_response = array(
				'status' => 'error',
				'logged_in' => 'no',
				'message' => 'This email already exits.'
			);
		}
		
		print_r(json_encode($final_response)); exit;
		//end of facebook login 
	}
	
	
	public function google_login()
	{
		//return FALSE if it is not an ajax request
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		$final_response = array();
		
		$google_id = ($this->input->post('id',TRUE) && $this->input->post('id',TRUE)!='') ? $this->input->post('id',TRUE):'';
		$name = ($this->input->post('name',TRUE) && $this->input->post('name',TRUE)!='') ? $this->input->post('name',TRUE):'';
		$email = ($this->input->post('email',TRUE) && $this->input->post('email',TRUE)!='') ? $this->input->post('email',TRUE):'';
		$gender = ($this->input->post('gender',TRUE) && $this->input->post('gender',TRUE)!='') ? $this->input->post('gender',TRUE):'';
		$image_url = ($this->input->post('image_url',TRUE) && $this->input->post('image_url',TRUE)!='') ? $this->input->post('image_url',TRUE):'';
		
		//print_r(json_encode($_POST)); exit;
		
		if($google_id && $email )
		{
			//assign current date and users ip in local variables
			$this->current_date = $this->general->get_local_time('time');
			$this->user_ip = $this->general->get_real_ipaddr();
			
			//check whether this user exists or not
			$this->data['user_nums'] = $this->login_module->get_google_user_num($google_id);
  			//echo $this->data['user_nums'];  //exit;

			
			if($this->data['user_nums'] == 1)
			{   
				//means user already registered
				$this->data['user_data'] = $this->login_module->get_google_user($google_id);
				//echo "<pre>"; print_r($this->data['user_data']); echo "</pre>"; exit;
				//incase user changes his/her email address of facebook
				if($email != $this->data['user_data']->email)
				{
					$data = array('email' => $email	);
				
					$this->db->where('id',$this->data['user_data']->id);   		
					$this->db->update('members',$data);
			
					$this->session->set_userdata(array(SESSION.'email' => $email));
				}
				else
				{
					$this->session->set_userdata(array(SESSION.'email' => $this->data['user_data']->email));
				}
				
				$this->session->set_userdata(array(SESSION.'user_id' => $this->data['user_data']->id));
				
				if($this->data['user_data']->user_type){
					$this->session->set_userdata(array(SESSION.'usertype' => $this->data['user_data']->user_type));
				}
				
				if($this->data['user_data']->name)
				{ $this->session->set_userdata(array(SESSION.'name' => $this->data['user_data']->name));}
					
				if($this->data['user_data']->image) 
				{	$this->session->set_userdata(array(SESSION.'image' => $this->data['user_data']->image)); }
				//print_r($this->session->all_userdata());   exit;
				
				//response
				$final_response = array(
					'status' => 'success',
					'logged_in' => 'yes',
					//'message' => 'Login Successful. Now you will be redirected to your account page'
					'message' => 'Login Successful.'
				);
			}
			else
			{
				//first check whether email from facebook login is already used in our site or not.
				//if already exists redirect to register page with error message
				//if doesnot exist insert data into table
				
				/*echo "facebook user not registered";
				echo $facebook_id;
				exit;*/
				
				//var_dump($this->general->check_members_email_existance($email)); exit;
				if($this->general->check_members_email_existance($email)==FALSE)
				{
					//this email is already in members list
					//$this->session->set_flashdata('error_msg',lang('facebook_email_already_in_use'));
					//redirect(site_url('/user/register'));  exit;
					
					$final_response = array(
						'status' => 'error',
						'logged_in' => 'no',
						'message' => 'This email already exits.'
					);
				}
				
				//echo "facebook user not registered";
				//echo $facebook_id; 
				//insert into database and direct to the profile page
				$this->data['user_profile'] = $this->login_module->insert_google_member($google_id, $name, $email, $image_url, $this->user_ip);
				//print_r($this->data['user_profile']); exit;
				
				//maintain the session
				$this->session->set_userdata(array(SESSION.'user_id' => $this->data['user_profile']->id));
				$this->session->set_userdata(array(SESSION.'email' => $this->data['user_profile']->email));
							
				if($this->data['user_profile']->name)
				{ $this->session->set_userdata(array(SESSION.'name' => $this->data['user_profile']->name)); }
					
				
				if($this->data['user_profile']->user_type){
					$this->session->set_userdata(array(SESSION.'usertype' => $this->data['user_profile']->user_type));
				}
				
				if($this->data['user_profile']->image) 
				{	$this->session->set_userdata(array(SESSION.'image' => $this->data['user_profile']->image)); }
				
				//response
				$final_response = array(
					'status' => 'success',
					'logged_in' => 'yes',
					//'message' => 'Login Successful. Now you will be redirected to your account page'
					'message'=>'Login Sucessful',
				);
			}						 
		}
		else if($facebook_id)
		{
			$final_response = array(
				'status' => 'error',
				'logged_in' => 'no',
				'message' => 'This email already exits.'
			);
		}
		print_r(json_encode($final_response)); exit;
		//end of google login 
	}
	
	
	
	
	
	public function forget()
	{		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->data['account_menu_active']='';
		if($this->form_validation->run()==TRUE)
		{
			 //check email from our database record
			$user_info = $this->login_module->get_user_by_email($this->input->post('email',TRUE));
			if($user_info)
			{
				if($user_info->status == '1')
				{
					$email = $this->login_module->send_forget_password_link($user_info->id, $user_info->email);
                   	if($email)
					{
						$this->session->set_flashdata('success_message','Password reset link sent to your email. Pleae Check your email.');
                 	}
                    else
					{	
						$this->session->set_flashdata('error_message','Unable to send email. Please Try Again.');
					}
           		}
                else
				{
					$this->session->set_flashdata('error_message','Account is not active');
				}
			}
			else
			{
				$this->session->set_flashdata('error_message','Account Doesnot exists');
			}
		}

		$this->data['meta_keys']= WEBSITE_NAME;
	    $this->data['meta_desc']= WEBSITE_NAME;
		$this->page_title = WEBSITE_NAME.' - Reset Password';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_reset_password', $this->data);	
		
	}
	
	
	public function reset_password()
	{
		 $code = urldecode($this->input->get('key'));
         $email = (base64_decode(urldecode($this->input->get('auth'))));
		
		$user = $this->login_module->is_user_ready_reset_password($email,$code);
	
		if($user)
		{
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
           	// echo $this->input->server('REQUEST_METHOD'); exit;
			   	$this->form_validation->set_rules($this->login_module->validate_rules_reset_password);
				//echo "form validatoin"; exit;
                if($this->form_validation->run()==TRUE){
					
                    $trans_stat = $this->login_module->change_users_password($email);
                    if($trans_stat){
                        $this->session->set_flashdata('success_message', 'Password changed successfully');
                        redirect('/user/login'); exit();
                    }  else {
                       $this->session->set_flashdata('forget_message', 'Unable to change password');
                        redirect('login/forgot_password/?key='.urlencode($code).'&auth='.  urlencode(base64_encode($email))); exit(); 
                    }
                }
            }
			
			if(strtotime($user->forgot_password_code_expire)> time()){
                $this->data['allow_reset'] = TRUE;
            
            }else{
                $this->data['allow_reset'] = FALSE;
              
                $this->session->set_flashdata('error_message',"Session has expired,Please request a new reset link");
                redirect(site_url('user/login/forget'));
            }
           
			$this->data['meta_keys']= '';
		    $this->data['meta_desc']= '';
			$this->page_title = WEBSITE_NAME.' - Reset Password';
			
			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)			
				->build('v_change_password', $this->data);
		}
		else
		{
			$this->session->set_flashdata('error_msg',"Enter your Email");
			redirect(site_url(''));
		}	
	}
	
}