	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//load custom language library
		if(!$this->session->userdata(SESSION.'user_id'))
        {
          	// redirect(site_url('/'),'refresh');exit;
        }
	}
	
	public function index()
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		$update_data = array('is_login' => '0');
		$this->db->where('id',$user_id);
		$this->db->update('members',$update_data);
		
		//echo $this->db->last_query(); exit;
		
		$this->session->unset_userdata(SESSION.'user_id');
		$this->session->unset_userdata(SESSION.'username');
		$this->session->unset_userdata(SESSION.'usertype');
		
		
		// $this->session->unset_userdata(SESSION.'image');
		$this->session->unset_userdata(SESSION.'first_name');
		$this->session->unset_userdata(SESSION.'email');
		$this->session->unset_userdata(SESSION.'last_name');
		
		$this->session->unset_userdata(SESSION.'last_login');
		
		$this->session->sess_destroy();

		redirect(site_url('/user/login'),'refresh');
		exit;
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */