<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ipbanned extends CI_Controller {

	function __construct() {
		parent::__construct();	
	}
	
	public function index()
	{
		$this->data['blocked_message'] = $this->general->get_banned_ip_message();
		//print_r($this->data['offline_msg']);
		
		//set SEO data
		$this->page_title = 'IP Blocked - '.WEBSITE_NAME;
		$this->load->view('ipbanned',$this->data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */