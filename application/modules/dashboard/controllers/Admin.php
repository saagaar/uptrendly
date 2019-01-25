<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if ( ! $this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
		$this->load->model('admin_dashboard');
		
	}
	
	public function index()
	{
		$this->data[''] ='';
		
		// error_reporting(E_ALL);
		// ini_set('display_errors',1);
		
		$this->data['advertiser_msg'] = $this->admin_dashboard->get_admin_recent_inbox('advertiser');
		$this->data['influencer_msg'] = $this->admin_dashboard->get_admin_recent_inbox('influencer');
		$this->data['total_active_members'] = $this->general->get_total_members(1);
		$this->data['total_sold_products'] = $this->admin_dashboard->count_total_sold_products();
		$this->data['total_revenue_from_credits'] = $this->admin_dashboard->get_total_revenue('purchase_credit');	

		// //ge recent members
		$this->data['advertiser'] = $this->admin_dashboard->get_recent_members('advertiser');
		$this->data['influencer'] = $this->admin_dashboard->get_recent_members('influencer');
		// // get recent products
		$this->data['recent_products'] = $this->admin_dashboard->get_recent_products();

		$this->template
			->set_layout('admin_dashboard')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.'- Dashboard')
			->build('a_dashboard', $this->data);	
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */