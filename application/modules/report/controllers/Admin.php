<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
		
		$total_member = $this->general->get_all_total();
		define('TOTAL_MEMBER',$total_member);
		
		$mem_active_info=$this->general->get_total_members(1);		
		define('ACTIVE_MEMBER',$mem_active_info);
		
		$mem_inactive_info=$this->general->get_total_members(2);		
		define('INACTIVE_MEMBER',$mem_inactive_info);
		
		$mem_suspended_info=$this->general->get_total_members(3);		
		define('SUSPENDED_MEMBER',$mem_suspended_info);
		
		$mem_close_info=$this->general->get_total_members(4);		
		define('CLOSE_MEMBER',$mem_close_info);
		
		//load CI library
			$this->load->library('form_validation');		
		//load custom module
			$this->load->model('admin_report');
			//$this->load->model('language-settings/Admin_language_settings');
		
		//load custom helper
		$this->load->helper('editor_helper');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			// $this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
			
			// if($this->uri->segment(4)) 
			// 	{$this->data['lang_id'] = $this->uri->segment(4);}
			// else
			// 	{$this->data['lang_id'] = $this->data['lang_details'][0]->id;}
			
		$this->data['total_payment_by_paypal']=$this->admin_report->total_payment_by_payment_gateway('paypal');
		$this->data['totalBidCredit']=$this->admin_report->total_sum('balance','members');
		$this->data['total_sale']=$this->admin_report->count_total_sold_products();
		$this->data['total_sale_cost']=$this->admin_report->total_cost_products_sold();
		
		// $this->data['total_site_commission']=$this->admin_report->total_site_commissions();
		// $this->data['total_site_commission_last_week']=$this->admin_report->total_site_commissions(7);
		// $this->data['total_site_commission_last_month']=$this->admin_report->total_site_commissions(30);
		
	    $this->data['top_products_sold'] = $this->admin_report->top_products_sold();
		// $this->data['top_buyer'] = $this->admin_report->top_buyers();
		// $this->data['top_seller'] = $this->admin_report->top_sellers();
		
		
		// $this->data['total_revenue_bidcredit'] = $this->admin_report->get_total_revenue('purchase_credit');
		// $this->data['total_revenue_item_listing'] = $this->admin_report->get_total_revenue('pay_for_product_listing');
		
		
		
		$this->page_title = WEBSITE_NAME.' Report Management System';
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view', $this->data);
		 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	public function csv_member()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
			
		$member_statistics = WEBSITE_NAME.' Member Statistics';
		$member_statistics .="\n";
		$member_statistics .="\n";

		$member_statistics .= '"Active Members","'.ACTIVE_MEMBER.'"'; 
		$member_statistics .="\n";
		
		$member_statistics .= '"Inactive Members","'.INACTIVE_MEMBER.'"'; 
		$member_statistics .="\n";
		
		$member_statistics .= '"Suspended Members","'.SUSPENDED_MEMBER.'"'; 
		$member_statistics .="\n";
		
		$member_statistics .= '"Closed Members","'.CLOSE_MEMBER.'"'; 
		$member_statistics .="\n";
		
		$member_statistics .= '"Total Members","'.TOTAL_MEMBER.'"'; 
		$member_statistics .="\n";
		$member_statistics .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=member-statistics-result-".date("Y-m-d").".csv");
		  
		echo $member_statistics;  
		exit;
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	
	public function csv_site_revenue()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		$total_payment_by_paypal = $this->admin_report->total_payment_by_payment_gateway('paypal');
		if($total_payment_by_paypal)$paypal_total_amount=$total_payment_by_paypal->amount;else $paypal_total_amount=0;
		
		
		$totalBidCredit =$this->admin_report->total_sum('balance','members');
		if($totalBidCredit)$total_bid_credits=$totalBidCredit->balance; else $total_bid_credits=0; 
		
		$total_sale = $this->admin_report->count_total_sold_products();
		if($total_sale)$total_sales=$total_sale->quantity; else $total_sales=0;
		
		$this->data['total_sale_cost']=$this->admin_report->total_cost_products_sold();
		if($this->data['total_sale_cost'])$total_sales_cost=$this->data['total_sale_cost']->totalcost; else $total_sales_cost=0;
		
		$this->data['total_site_commission']=$this->admin_report->total_site_commissions();
		if($this->data['total_site_commission'])$total_commission=$this->data['total_site_commission']->totalcommission; else $total_commission=0;
		
		$this->data['total_revenue_bidcredit'] = $this->admin_report->get_total_revenue('purchase_credit');
		if($this->data['total_revenue_bidcredit'])$total_revenue_bidcredit=$this->data['total_revenue_bidcredit']->total_amount; else $total_revenue_bidcredit=0;
		
		$this->data['total_revenue_item_listing'] = $this->admin_report->get_total_revenue('pay_for_product_listing');
		if($this->data['total_revenue_item_listing'])$total_revenue_item_listing=$this->data['total_revenue_item_listing']->total_amount; else $total_revenue_item_listing=0;
		
		$site_revenue = WEBSITE_NAME.' Site Revenue Statistics';
		$site_revenue .="\n";
		$site_revenue .="\n";

		$site_revenue .= '"Total Money Deposited From PayPayl:","'.$paypal_total_amount.'"'; 
		$site_revenue .="\n";
		
		$site_revenue .= '"Total Credits in Member Accounts:","'.$total_bid_credits.'"'; 
		$site_revenue .="\n";
		
		$site_revenue .= '"Total Products Sold:","'.$total_sales.'"'; 
		$site_revenue .="\n";
		
		$site_revenue .= '"Total Products Sold Cost:","'.$total_sales_cost.'"'; 
		$site_revenue .="\n";
		
		$site_revenue .= '"Total Commissions from product sold:","'.$total_commission.'"'; 
		$site_revenue .="\n";
		
		$site_revenue .= '"Total revenue from item listing:","'.$total_revenue_item_listing.'"'; 
		$site_revenue .="\n";
		
		$site_revenue .= '"Total revenue from bid credits:","'.$total_revenue_bidcredit.'"'; 
		$site_revenue .="\n";
		
		
		$site_revenue .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=site-revenue-statistics".date("Y-m-d").".csv");
		  
		echo $site_revenue;  
		exit;
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	
	public function csv_top_products()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		$this->data['top_products_sold'] = $this->admin_report->top_products_sold();
		
		$top_products = WEBSITE_NAME.' Top Products Sold';
		$top_products .="\n";
		$top_products .="\n";

		$top_products .= '"Product Name","Total Sale"'; 
		$top_products .="\n";
		
		if($this->data['top_products_sold'])
		{
		 foreach($this->data['top_products_sold'] as $product)
		  {
		   $top_products .= '"'.$product->name.'","'.$product->totalsale.'"'; 
		   $top_products .="\n";
		  }
		}
		else{
			$top_products .= 'No records found'; 
		    $top_products .="\n";
	        }
		
		$top_products .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=top-product-sold".date("Y-m-d").".csv");
		  
		echo $top_products;  
		exit;
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	public function csv_top_seller()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		$this->data['top_seller'] = $this->admin_report->top_sellers();
		
		$top_seller = WEBSITE_NAME.' Top Seller';
		$top_seller .="\n";
		$top_seller .="\n";

		$top_seller .= '"Seller Name","Total Sale"'; 
		$top_seller .="\n";
		
		if($this->data['top_seller'])
		{
		 foreach($this->data['top_seller'] as $seller)
		  {
		   $top_seller .= '"'.$seller->user_name.'(ID : '.$seller->seller_id.')","'.$seller->totalsale.'"'; 
		   $top_seller .="\n";
		  }
		}
		else{
			$top_seller .= 'No records found'; 
		    $top_seller .="\n";
	        }
		
		$top_seller .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=top-seller-".date("Y-m-d").".csv");
		  
		echo $top_seller;  
		exit;
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	public function csv_top_buyer()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
			$this->data['top_buyer'] = $this->admin_report->top_buyers();
		
		$top_buyer = WEBSITE_NAME.' Top Buyer';
		$top_buyer .="\n";
		$top_buyer .="\n";

		$top_buyer .= '"Buyer Name","Total Buys"'; 
		$top_buyer .="\n";
		
		if($this->data['top_buyer'])
		{
		 foreach($this->data['top_buyer'] as $buyer)
		  {
		   $top_buyer .= '"'.$buyer->user_name.'(ID : '.$buyer->user_id.')","'.$buyer->totalbuys.'"'; 
		   $top_buyer .="\n";
		  }
		}
		else{
			$top_buyer .= 'No records found'; 
		    $top_buyer .="\n";
	        }
		
		$top_buyer .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=top-buyer-".date("Y-m-d").".csv");
		  
		echo $top_buyer;  
		exit;
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	public function csv_commisssion()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		 $this->data['total_site_commission']=$this->admin_report->total_site_commissions();
		if($this->data['total_site_commission']->totalcommission)$total_site_commission=$this->data['total_site_commission']->totalcommission;
		else $total_site_commission=0;
		
		$this->data['total_site_commission_last_week']=$this->admin_report->total_site_commissions(7);
		if($this->data['total_site_commission_last_week']->totalcommission)$total_site_commission_last_week=$this->data['total_site_commission_last_week']->totalcommission;
		else $total_site_commission_last_week=0;
		
		$this->data['total_site_commission_last_month']=$this->admin_report->total_site_commissions(30);	
		if($this->data['total_site_commission_last_month']->totalcommission)$total_site_commission_last_month=$this->data['total_site_commission_last_month']->totalcommission;
		else $total_site_commission_last_month=0;   	
				
		
		$commissions = WEBSITE_NAME.' Transaction Details';
		$commissions .="\n";
		$commissions .="\n";

		$commissions .= '"Commissions Last 7 Days","'.$total_site_commission_last_week.'"'; 
		$commissions .="\n";
		
		$commissions .= '"Commissions Last 30 Days","'.$total_site_commission_last_month.'"'; 
		$commissions .="\n";
		
		$commissions .= '"Total Commissions","'.$total_site_commission.'"'; 
		$commissions .="\n";
		
		$commissions .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=site-commission--".date("Y-m-d").".csv");
		  
		echo $commissions;  
		exit;
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	
	public function csv_transaction_by_time()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		$paypal=$this->input->post('paypal');
		$total_sold=$this->input->post('total_sold');
		$total_commission=$this->input->post('total_commission');
		$total_revenue_credit=$this->input->post('total_revenue_credit');
		$total_revenue_listing=$this->input->post('total_revenue_listing');
			
		
		$transaction = WEBSITE_NAME.' Transaction Details';
		$transaction .="\n";
		$transaction .="\n";

		$transaction .= '"Total Money Deposited From Paypal","'.$paypal.'"'; 
		$transaction .="\n";
		
		$transaction .= '"Total Products Sold","'.$total_sold.'"'; 
		$transaction .="\n";
		
		$transaction .= '"Total Commission on sold products","'.$total_commission.'"'; 
		$transaction .="\n";
		
		$transaction .= '"Total revenue from sold credits","'.$total_revenue_credit.'"'; 
		$transaction .="\n";
		
		$transaction .= '"Total revenue from item listing","'.$total_revenue_listing.'"'; 
		$transaction .="\n";
		
		$transaction .="\n";
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=transaction-details--".date("Y-m-d").".csv");
		  
		echo $transaction;  
		exit;
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	public function generate_report()
	{
		echo 'incomplete'; exit;
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			// $this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		
		
		if($this->input->post('from_date_transaction')!='' && $this->input->post('to_date_transaction')!='')
		{		
		
			$date_from = date("Y-m-d",strtotime($this->input->post('from_date_transaction')));
			$date_to = date("Y-m-d",strtotime($this->input->post('to_date_transaction')));
			
			$this->data['todays_payment_by_paypal'] = $this->admin_report->get_todays_payment('paypal',$date_from, $date_to);
			//$this->data['todays_payment_by_global_commercia'] = $this->report_model->get_todays_payment('Global Commercia',$date_from, $date_to);
			$this->data['todays_sale'] = $this->admin_report->products_sold_today($date_from,$date_to);
			$this->data['total_commissions_date_range'] = $this->admin_report->total_commissions_time_range($date_from,$date_to);
		    $this->data['total_revenue_credits'] = $this->admin_report->get_total_revenue_sold_credits_byDateRange('purchase_credit',$date_from,$date_to);
			$this->data['total_revenue_listing'] = $this->admin_report->get_total_revenue_sold_credits_byDateRange('pay_for_product_listing',$date_from,$date_to);
			
			
		    $this->data['info_header'] = "Transaction Details between ".$date_from." and ".$date_to;
		}
		else
		{
			$this->data['info_header'] = "Today's Transaction Details (".date('y-m-d').")";
			
			$this->data['todays_payment_by_paypal'] = $this->admin_report->get_todays_payment('paypal');
			$this->data['todays_sale'] = $this->admin_report->products_sold_today();
			$this->data['total_commissions_date_range'] = $this->admin_report->total_commissions_time_range();
			$this->data['total_revenue_credits'] = $this->admin_report->get_total_revenue_sold_credits_byDateRange('purchase_credit');
			$this->data['total_revenue_listing'] = $this->admin_report->get_total_revenue_sold_credits_byDateRange('pay_for_product_listing');
			
		}
		
		  
		  $this->page_title = WEBSITE_NAME.' Report Management System';
		   
		   $this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view_report', $this->data);
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	public function generate_member_report()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		 $this->form_validation->set_rules($this->admin_report->validate_settings_member_report);
		
		 if($this->form_validation->run()==TRUE)
		 {
		  $this->data['report'] = $this->admin_report->create_customer_registration_report();
		  }
		
		   $this->page_title = WEBSITE_NAME.' Report Management System';
		   $this->generate_report();
		   
		   /*$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view_report', $this->data);*/
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	function check_end_date()
	{
		if(strtotime($this->input->post('to_date')) <= strtotime($this->input->post('from_date')))
		{
			$this->form_validation->set_message('check_end_date',"To date must be greater than from date.");
			return false;
		}
	}
	
	public function generate_product_report()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		 $this->form_validation->set_rules($this->admin_report->validate_settings_product_report);
		
		 if($this->form_validation->run()==TRUE)
		 {
		 $this->data['report'] = $this->admin_report->create_product_sold_report_by_date();
		 }
		   $this->page_title = WEBSITE_NAME.' Report Management System';
		   
		  
		  
		  $this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view_report', $this->data);
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	function check_end_date_product()
	{
		if(strtotime($this->input->post('to_date_product')) <= strtotime($this->input->post('from_date_product')))
		{
			$this->form_validation->set_message('check_end_date_product',"To date must be greater than from date.");
			return false;
		}
	}
	
	
	public function generate_credit_report()
	{
		$data = array();
		$data['current_menu'] = 'all';
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('module-report', $this->admin_permissions)):
		
			$this->data['lang_details'] = $this->admin_report->get_lang_details_for_others();
			$this->data['jobs']='View';
			$this->data['current_menu'] = 'all';
		
		 $this->form_validation->set_rules($this->admin_report->validate_settings_credit_report);
		
		 if($this->form_validation->run()==TRUE)
		 {
		 $this->data['report'] = $this->admin_report->create_credit_sold_report_by_date();
		 }
		   $this->page_title = WEBSITE_NAME.' Report Management System';
		   
		  
		  
		  $this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('a_view_report', $this->data);
			
				 
		 else:
				$this->template->set_layout('admin_dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Report Settings')
					->build('administrator-denied', $data);

        endif;
	}
	
	
	function check_end_date_credit()
	{
		if(strtotime($this->input->post('to_date_credit')) <= strtotime($this->input->post('from_date_credit')))
		{
			$this->form_validation->set_message('check_end_date_credit',"To date must be greater than from date.");
			return false;
		}
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */