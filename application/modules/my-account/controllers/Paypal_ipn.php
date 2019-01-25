<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal_ipn extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('/offline'));exit;
		}
		
		$this->load->model('account_module');
		$this->load->model('brand/paypal_module');
		$this->load->library('general');
	}
	
	public function index()
	{
		//load paypal class
		$this->load->library('paypal_class');
		
		//get payment method info
		$data = $this->general->get_all_payment_gateway(1);

		$this->payment_data=$data['0'];
		// print_r($this->payment_data);
		$this->paypal_business_email = $this->payment_data->email;
		
		$post_string = '';    
			  foreach ($_POST as $field=>$value) { 
				 $this->ipn_data["$field"] = $value;
				 $post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
			  }
			  
		//for validate IPN
		if($this->payment_data->status == 2)
				$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal real url
			else
				$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // paypal testing u
				
				$this->send_test_email('Before Validate IPN',$post_string);//test email
		
		//check validate IPN
		if ($this->paypal_class->validate_ipn()) 	//Check log file created successfully or not
		{
			//$this->send_test_email('Validate IPN -log file created successfully!',$post_string);//test email
			
			//set paypal variable
			$this->set_paypal_post_value();
				
			//check duplicate transaction
			if($this->paypal_module->count_txn_id($this->txn_id) == 0)
			{
				// $this->send_test_email('Transaction OK',$post_string);//test email
				
				//check payment status
				if($this->payment_status == 'Completed')
				{
					// $this->send_test_email('Status Completed',$post_string);//test email
						
					//check business id for more validation
					if(strtolower(trim($this->business))==strtolower(trim($this->paypal_business_email)))
					{
						// $this->send_test_email('Business Email Verify',$post_string);//test email
							
						//get inserted transaction record based on invoice id & custom value.
						$this->get_txn_data = $this->paypal_module->get_transaction_data($this->invoice);
						
						// $this->send_test_email('Transaction Data Query: ',$this->db->last_query());//test email
							
						//check empty value
						if($this->get_txn_data)
						{
							// $this->send_test_email('Transaction Data fetch',$post_string);//test email
							
							if($this->get_txn_data->amount == $this->mc_gross)
							{
								// $this->send_test_email('Transaction Type : '.$this->get_txn_data->transaction_type, $post_string);//test email
								
								$this->db->trans_start();//transaction star
									//update transaction records
								$this->paypal_module->paypal_transaction_data_update();
								$cond=array('id'=>$this->get_txn_data->user_id);
								
								$this->db->set('balance', 'balance+'.$this->get_txn_data->amount, FALSE);
								$this->db->where($cond);
								$this->db->update('members');

								$member=$this->general->get_single_row('members',array('id'=>$this->get_txn_data->user_id));
								

								$email=$member->email;
								$parseElement=array(
														'USERNAME'			=>		$member->email,
														'INVOICE_ID'		=>		$this->invoice,
														'PAYMENT_METHOD'	=>		'Paypal',
														'PAID_AMOUNT'		=>		$this->get_txn_data->amount,
														'CURRENT_BALANCE'	=>		$member->balance,
														'PAYMENT_DATE'		=>		$this->input->post('payment_date'),
														'USER_ID'			=>		$this->get_txn_data->user_id,
														'SITENAME'			=> 		WEBSITE_NAME
												    );
								$from=SYSTEM_EMAIL;
								$template_code='payment_status_email';
								$template_code_admin='payment_status_admin';
								$this->db->trans_complete(); //transaction end
								if ($this->db->trans_status() === true){
									/*if user is referred by some other users then we give them point*/
									
									$referralid=$member->referred_by;
									if($referralid!=null)
									{
										$this->db->set('referral_points', 'referral_points+'.BRAND_REFER_POINT, FALSE);
										$this->db->where('id',$referralid);
										$this->db->update('members');
										$this->general->update_data('members',array('referred_by'=>null),array('id'=>$this->get_txn_data->user_id))	
									}
									  /***************Payment invoice*****************/
									$this->load->library('pdf');
					    			$data['members']=$this->general->get_user_details(83);
					    			$data['site']=$this->general->get_single_row('site_settings');
					    			$data['invoice']=$this->invoice;
					    			$data['amount']=$this->get_txn_data->amount;
					    			$data['transaction']=$this->general->get_single_row('transaction',array('id'=>$this->invoice));
					    			$view=$this->load->view('invoice',$data,true);
									$this->pdf->sendpdf('',$view,'');
				/********************************/
									// $this->notification->send_email_notification($template_code, '', $from, $email, '', '', $parseElement, array());
									$this->notification->send_email_notification($template_code_admin, '', SYSTEM_EMAIL, CONTACT_EMAIL, '', '', $parseElement, array());
									}								
																		
								
							}
						}
					}
				}	
			}
		}
	}
	
	public function send_test_email($subject,$message)
	{
		$this->load->library('email');

		$this->email->from('demo@nepaimpressions.com', 'Sagar');
		$this->email->to('saagarchapagain@gmail.com');		
		//$this->email->to('maharjanrabi1@gmail.com');	
		
		$this->email->subject($subject);
		$this->email->message($message); 
		
		$this->email->send();
	}
	
	public function set_paypal_post_value()
	{
		// assign posted variables to local variables
		$this->item_name = $this->input->post('item_name');
		$this->business = $this->input->post('business');
		$this->item_number = $this->input->post('item_number');
		$this->payment_status = $this->input->post('payment_status');
		$this->mc_gross = number_format($this->input->post('mc_gross'),2,".",'');
		$this->payment_currency = $this->input->post('mc_currency');
		$this->txn_id = $this->input->post('txn_id');
		$this->receiver_email = $this->input->post('receiver_email');
		$this->receiver_id = $this->input->post('receiver_id');
		$this->quantity = $this->input->post('quantity');
		$this->num_cart_items = $this->input->post('num_cart_items');
		$this->payment_date = $this->input->post('payment_date');
		$this->first_name = $this->input->post('first_name');
		$this->last_name = $this->input->post('last_name');
		$this->payment_type = $this->input->post('payment_type');
		
		$this->payment_gross = $this->input->post('payment_gross');
		$this->payment_fee = $this->input->post('payment_fee');		
		$this->payer_email = $this->input->post('payer_email');
		$this->txn_type = $this->input->post('txn_type');
		$this->payer_status = $this->input->post('payer_status');
		
		$this->invoice = $this->input->post('invoice');
		$this->custom = $this->input->post('custom');
		$this->notify_version = $this->input->post('notify_version');
		$this->verify_sign = $this->input->post('verify_sign');
		$this->payer_business_name = $this->input->post('payer_business_name');
		$this->payer_id =$this->input->post('payer_id');
		$this->mc_currency = $this->input->post('mc_currency');
		$this->mc_fee = number_format($this->input->post('mc_fee'),2,".",'');
		$this->exchange_rate = $this->input->post('exchange_rate');
		$this->settle_currency  = $this->input->post('settle_currency');
		$this->parent_txn_id  = $this->input->post('parent_txn_id');
		$this->pending_reason  = $this->input->post('pending_reason');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */