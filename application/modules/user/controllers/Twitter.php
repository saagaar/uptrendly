<?php
/**
 * Twitter OAuth library.
 * Sample controller.
 * Requirements: enabled Session library, enabled URL helper
 * Please note that this sample controller is just an example of how you can use the library.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter extends CI_Controller
{
	/**
	 * TwitterOauth class instance.
	 */
	private $connection;
	
	/**
	 * Controller constructor
	 */
	function __construct()
	{
		parent::__construct();
		//load login model
		$this->load->model('login_module');
		
		// load text helper
		$this->load->helper('text');
		
		// Loading TwitterOauth library. Delete this line if you choose autoload method.
		$this->load->library('twitteroauth');
		
		// Loading twitter configuration.
		$this->config->load('twitter');
		
		
		
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// If user already logged in
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		{
			// If user in process of authentication
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		}
	}
	
	/**
	 * Here comes authentication process begin.
	 * @access	public
	 * @return	void
	 */
	 
	 
	public function auth()
	{
		$response = array();
		//echo "<pre>"; print_r($this->session->all_userdata()); echo "</pre>";   exit;
		/*
			echo TWITTER_API_SECRET;
			echo "<br>";
			echo $this->config->item('twitter_consumer_secret'); exit;
		*/
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// User is already authenticated.
			//check whether this user is already registered in our system or not
			//register and get data if not registered and get users data if already registered
			$twitter_user = $this->login_module->check_twitter_user($this->session->userdata('twitter_user_id'));
			
			if($twitter_user)
			{
				if($twitter_user->id){$this->session->set_userdata(array(SESSION.'user_id' =>$twitter_user->id));}
				if($twitter_user->first_name){$this->session->set_userdata(array(SESSION.'first_name'=>$twitter_user->first_name));}
				if($twitter_user->last_name){$this->session->set_userdata(array(SESSION.'last_name'=>$twitter_user->last_name));}	
				if($twitter_user->image){$this->session->set_userdata(array(SESSION.'image'=>$twitter_user->image));}	
				if($twitter_user->mem_login_state){$this->session->set_userdata(array(SESSION.'login_state'=>$twitter_user->mem_login_state));}	
				if($twitter_user->last_login){$this->session->set_userdata(array(SESSION.'last_login'=>$twitter_user->last_login_date));}	
				//echo "<pre>"; print_r($this->data['twitter_user']); echo "</pre>"; exit;	
			}
			if(!$twitter_user->email)
			{	
				//redirect to profile page if email is not set
				$this->session->set_flashdata('message',lang('error_incomplete_profile'));
				
				$response['status'] = 'success';
				$response['redirect'] = 'yes';
				$response['message'] = 'Login successful';
				//redirect(site_url(MY_ACCOUNT.'/profile')); exit;
			}
			
			$response['status'] = 'error';
			$response['message'] = 'Login not successful';
			//redirect(site_url('/'));
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(site_url('/user/twitter/callback'));

			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				
				//echo "login successful inside auth"; exit;
				redirect($url);
			}
			else
			{
				// An error occured. Make sure to put your error notification code here.
				//echo "Error Code:  ".$this->connection->http_code; exit;
				$response['status'] = 'error';
				$response['message'] = $this->connection->http_code;
				
				//redirect(site_url('/'));
			}
		}
		
		//return json
		print_r(json_encode($response));
	}
	
	/**
	 * Callback function, landing page for twitter.
	 * @access	public
	 * @return	void
	 */
	public function callback()
	{
		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_session();
			redirect(site_url('/user/twitter/auth'));
		}
		else
		{
			$access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
			//print_r($access_token); exit;
		
			if ($this->connection->http_code == 200)
			{
				//if authentication success
				//set values in session and redirect to auth method
				$this->session->set_userdata('access_token', $access_token['oauth_token']);
				$this->session->set_userdata('access_token_secret', $access_token['oauth_token_secret']);
				$this->session->set_userdata('twitter_user_id', $access_token['user_id']);
				$this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
				
				//get users image and set link in session
				$method['show'] =   'users/show/'.$access_token['user_id'];
				$show = $this->connection->get($method['show']);
				//echo "<pre>"; print_r($show); echo "</pre>"; exit;
				$image_url = $show->profile_image_url;   // user profile image of 48x48 pixels
				//set session for userts image
				$this->session->set_userdata('twitter_user_image_link', $image_url);
				//echo $this->session->userdata('twitter_user_image_link'); exit;
				
				//unset user request token
				$this->session->unset_userdata('request_token');
				$this->session->unset_userdata('request_token_secret');
				
				//echo "Login successful inside callback"; exit;
				redirect(site_url('/user/twitter/auth'));
			}
			else
			{
				// An error occured. Add your notification code here.
				//echo "error occured"; exit;
				
				$response['status'] = 'error';
				$response['message'] = 'error occured';
				
				//redirect(site_url('/user/register'));
				
			}
		}
	}
	
	
	/**
	 * Reset session data
	 * @access	private
	 * @return	void
	 */
	private function reset_session()
	{
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('access_token_secret');
		$this->session->unset_userdata('request_token');
		$this->session->unset_userdata('request_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
	}
}

/* End of file twitter.php */
/* Location: ./application/controllers/twitter.php */