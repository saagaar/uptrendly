
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Admin extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		// Check if User has logged in
		if (!$this->general->admin_logged_in()){
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
		//load CI library
		$this->load->library('form_validation');
		// $this->load->library('upload');
		// $this->load->library('image_lib');
		$this->load->library('pagination');
		//load custom module
		$this->load->model('admin_winner_model','admin_winner_model');
		//load helper
		$this->load->helper('editor_helper');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}	

	public function index($status = 'all')
	{
		
		if(trim($this->input->post('submit'))=='Pay now')
		{

			$this->db->trans_start();
			$bidid=$this->input->post('bidid');
			$product_id=$this->input->post('product_id');
			$product_name=$this->input->post('product_name');
			$userid=$this->input->post('creatorid');
			$balance=$this->input->post('balance');
			if($bidid && $bidid!='')
			{
					$this->db->set('balance', 'balance-'.$balance, FALSE);
					$this->db->where(array('id'=>$userid));
					$this->db->update('members');
					$this->db->last_query();
					$member=$this->general->get_single_row('members',array('id'=>$userid));
					$curbalance=$member->balance;
					$transval=array(	
										'user_id'			=>		$userid,
										'product_id'		=>		$product_id,
										'amount'			=>		$balance,
										'credit_debit'		=>		'DEBIT',
										'transaction_name'	=>		'Win amount transferred to respective account '.DEFAULT_CURRENCY_SIGN.' '.$balance,
										'transaction_date'	=>		 $this->general->get_local_time('time'),
										'transaction_type'	=>		 'pay_won_amount_admin',
										'transaction_status'=>		 'Completed',
										'payment_method'	=>		 'Direct',
										'current_balance'	=>		 $curbalance,
										'currency'			=>		 DEFAULT_CURRENCY_CODE,
										'admin_id'			=>		 $this->session->userdata(ADMIN_LOGIN_ID)
									);
					$this->general->insert_data('transaction',$transval);
					$this->general->update_data('product_winner',array('payment_status'=>'Completed'),array('bid_id'=>$bidid,'product_id'=>$product_id));
					$this->db->trans_complete();
					if ($this->db->trans_status() === TRUE)
					{
						$notifymsg='Your paypal account for your won campaign : '.$product_name .' has been credited by amount'.DEFAULT_CURRENCY_CODE. $balance.' Please check email for details';
						$parseElement=array(
												'USERNAME'		=>		$member->username,
												'PRODUCT_NAME'	=>		$product_name,
												'AMOUNT'		=>		$balance,
												'PAYMENT_METHOD'=>		'paypal',
										    );
						$template_code='final_payment_won_bid';
						$this->general->savethisasnotification($userid,$notifymsg);
						$from=SYSTEM_EMAIL;
						$to=$member->email;
						$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());

						if(LOG_ADMIN_ACTIVITY == 'Y')
						{
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'winner-payment', 'module_desc' => 'PAyment completed', 'action' => 'Pay creator', 'extra_info' => 'bid id: '.$bidid));
						}
						$this->session->set_flashdata('message','Payment is successfull');
						redirect( site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/'));
					}
			}
			
		}
		
		if(trim($this->input->post('submit',true))=='Notify')
		{
			$userid=$this->input->post('creatorid');
			$notifymsg='<a style="text-decoration:none" href="'.site_url('/'.MY_ACCOUNT.'settings/address').'">We are unable to process your payment until you fill up your Billing information</a>';
			$this->general->savethisasnotification($userid,$notifymsg);
			$this->session->set_flashdata('message','Notification sent successfully.');
			redirect( site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/'));		
		}
		$this->data['current_menu'] = $status;
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		/*Checking permission*/
		if(array_key_exists('winner-payment', $this->admin_permissions)):
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/'.$status);
			$config['total_rows'] = $this->admin_winner_model->count_total_winners($status);
			$config['per_page'] = ADMIN_PRODUCT_LIST_PERPAGE;
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 5;	
			//get further config from general library
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			$offset = $this->uri->segment(5,0);            
			$this->data['winner_data'] = $this->admin_winner_model->get_winner_lists($status,$config["per_page"],$offset);
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Winner Payment View')
				->build('a_view_winner', $this->data);

		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Winner Payment Management')
				->build('administrator-denied', $data);
        endif;
	}	
}

