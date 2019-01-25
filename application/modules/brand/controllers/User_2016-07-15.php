<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		//load custom language library
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			//check whether logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
			if(!$this->session->userdata('MAINTAINANCE_KEY') OR $this->session->userdata('MAINTAINANCE_KEY')!='YES'){
				redirect(site_url('/maintainance'));exit;
			}
		}
		
		if(!$this->session->userdata(SESSION.'user_id'))
        {
          	$this->session->set_flashdata('loginerror', "Please Login to access this page.");
			redirect(site_url('/'),'refresh');exit;
        }
		 
		 //check banned IP address
		$this->general->check_banned_ip();
		 
		//load CI library
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('form_validation');
		$this->load->library("pagination");	

		$this->load->helper('text');
		
		$this->load->model('account_module');
		$this->load->model('paypal_module');
		
		$this->load->model('email-settings/admin_email_settings');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');		
	}
	
	// buyers dashboard 
	// may require pagination 
	public function buyer()
	{
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="dashboard";
		$this->data['account_title']="Buyer Dashboard";
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/')); }

		//get my account details		
		$this->data['details'] = $this->general->get_user_details($user_id);
		
		$this->data['live_products'] = $this->account_module->get_live_buyer_auctions($user_id);
		// print_r($this->data['live_products']);exit;
		$this->page_title = 'My Account Dashboard'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_dashboard', $this->data);		
	}
	//buyer general profile page
	public function buyer_profile()
	{
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="buyers_profile";
		$this->data['account_title']="Buyer Dashboard";		
		
		//get my account details
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) {redirect(site_url('/'));}

		$this->data['countries'] = $this->general->get_all_countries();
		$this->data['profile'] = $this->general->get_user_details($user_id);		
		
		$this->form_validation->set_rules($this->account_module->validate_buyer_profile_settings);
		if($this->form_validation->run() == TRUE)
		{		
			if($this->data['profile']->email != $this->input->post('email',TRUE))
			{
				$update_data['new_email'] = $this->input->post('email',TRUE);
				
				// send email changed notification to member
				// $this->account_module->update_new_email_confirmation_email();
			}
			
			$update_profile = $this->account_module->update_buyer_profile($user_id);
			if($update_profile)
			{
				//display success message
				$this->session->set_flashdata('success_message', "Profile Updated Successfully.");
				redirect(site_url('/'.MY_ACCOUNT.'buyer_profile'),'refresh');
			}
			else
			{
				//display error message
				$this->session->set_flashdata('error_message', "Unable to update profile. Please Try Again.");
				redirect(site_url('/'.MY_ACCOUNT.'buyer_profile'),'refresh');
			}
		}
		
		$this->page_title = 'Profile'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_profile', $this->data);
	}
	
	// added by Manish
	// for create auction	
	public function create_auction()
	{
		// echo AUCTION_POST_ACTIVATION;
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="create_auction";
		$this->data['account_title']="Create Auction";

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/'),'refresh');}	

		$auction_post_validity = $this->general->get_auction_post_member_validity($user_id);
		// var_dump($auction_post_validity); exit;
		if($auction_post_validity === FALSE)
		{
			redirect(site_url('/'.MY_ACCOUNT. 'buyer_packages'));exit;
		}

		// generate product code
		$this->data['product_code'] = strtotime('now').$user_id;
		$this->data['currencies'] = $this->general->fetch_all_currency();
		
		$this->data['custom_field_html'] = '';
		
		//get static form field values
		//$this->data['static_field'] = $this->account_module->get_product_static_fields_data();
		$this->data['static_field'] = $this->general->get_product_static_fields_data();
		//echo "<pre>";print_r($this->data['static_field']);echo "</pre>";//exit;
		
		//assign values from custom fields to the local variable
		$cf_post_value = $this->input->post('meta',TRUE);
		
		$this->data['basic_field_html'] = $this->account_module->get_custom_fields_html_by_category(0, $cf_post_value, 'add','','basic');
		//echo $this->data['basic_field_html'];
		
		$this->data['category_tree'] = $this->general->get_category_tree();
		
		if($this->input->post('category',TRUE) && $this->input->post('category',TRUE)!=''){
			$cat_id = $this->input->post('category',TRUE);
			$this->data['custom_field_html'] = $this->account_module->get_custom_fields_html_by_category($cat_id, $cf_post_value,'add','','custom');
			// var_dump($this->data['custom_field_html']);exit;
		}
		
		//Set form validation rules. Generate rules based on the items visible for static fields
		$this->form_validation->set_rules($this->account_module->generate_validation_rules($this->data['static_field']));
		//echo "<pre>"; print_r($static_form_validation_rules); echo "</pre>";
		
		if($this->form_validation->run()==TRUE)
		{
			$product_id = $this->account_module->insert_new_product($auction_post_validity);
			if(AUCTION_POST_ACTIVATION == '1')
			{
				$this->session->set_flashdata('success_message', "Item Added Successfully. It wil be active after admin verification");
				redirect(site_url('/'.MY_ACCOUNT.'create_auction')); exit;
			}
			else
			{
				$this->session->set_flashdata('success_message', 'Item Added Successfully.');
				redirect(site_url('/'.MY_ACCOUNT.'invitation/'.$product_id),'refresh'); exit;
			}
		}//else{echo validation_errors();}
		
		$this->page_title = 'Create Auction'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_create_auction', $this->data);
	}

	public function view_auction(){
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="view_auction";
		$this->data['account_title']="View Auction";
		$user_id = $this->session->userdata(SESSION.'user_id');
		$this->load->library('pagination');
		if(!$user_id) { redirect(site_url('/')); }

				
				$config['base_url'] = site_url('/'.MY_ACCOUNT.'view_auction/');
				$config['total_rows'] = $this->account_module->count_all_buyer_auctions($user_id);
				$config['per_page'] = 5;
				$config['page_query_string'] = FALSE;
				$config["uri_segment"] = 3;
				$this->general->frontend_pagination_config($config);        
				$this->pagination->initialize($config); 
				$offset=$this->uri->segment(3,0);            		
				$this->data['live_products'] = $this->account_module->get_all_buyer_auctions($user_id,$config["per_page"],$offset);
				$this->data["pagination_links"] = $this->pagination->create_links();
		$this->page_title = 'View Auction'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_view_auction', $this->data);
	}

	public function invitation($product_id = '')
	{
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="invitation";
		$this->data['account_title']="Invitation";
		if(!$product_id || !is_numeric($product_id) || $product_id == 0)		
		{
			redirect(site_url('/'.MY_ACCOUNT.'buyer'));
		}
		$invitedaccounts = $this->account_module->listprivateinvitationsent($product_id);
		$this->data['invitedaccounts']=$invitedaccounts;
		
		$this->form_validation->set_rules($this->account_module->validate_invitation_settings);
		if($this->form_validation->run() === TRUE)
		{
			$invite_status = $this->account_module->invite_suppliers($product_id);
			
			if($invite_status)
			{
				$this->session->set_flashdata('success_message', 'Invitation Sent Successfully.');
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Sorry, Unable to send Invitation.');
			}
			redirect(site_url('/'. MY_ACCOUNT. 'invitation/'. $product_id));
		}

		$this->page_title = 'Invitation'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_invite', $this->data);
	}

	// added by manish for cancel auction
	public function cancel_auction($auction_id = '')
	{
		// if user id session is not set redirect to site url
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) {redirect(site_url('/'));}
		// if auction id is not available redirect to buyers dashboard 
		if(empty($auction_id)) {redirect(site_url('/'.MY_ACCOUNT.'buyer'));}

		// pass product code as parameter
		$cancel_status = $this->account_module->cancel_auction($auction_id);
		if($cancel_status)
		{
			// if cancel is sucessful redirect to buyers dashboard with success message
			$this->session->set_flashdata('success_message', 'The auction cancelled sucessfully');
			redirect(site_url('/'.MY_ACCOUNT.'buyer'), 'refresh');
		}
		else
		{
			// if cancel is sucessful redirect to buyers dashboard with error message			
			$this->session->set_flashdata('error_message', 'Unable to cancel auction. Please try again!');
			redirect(site_url('/'.MY_ACCOUNT.'buyer'), 'refresh');
		}
	}

	// Product Detail
	// added by manish
	public function auction_detail($auction_id = '')
	{
		$this->data['account_title']="Live Auction";	


		// if user id session is not set redirect to site url
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) {redirect(site_url('/'));}

		// if auction id is not available redirect to buyers dashboard 
		if($auction_id=='' || $auction_id==0 || $auction_id =='0' || !is_numeric($auction_id)) 
		{
			if($this->session->userdata(SESSION.'usertype') == '3')
				redirect(site_url(MY_ACCOUNT.'buyer'), 'refresh');
			elseif($this->session->userdata(SESSION.'usertype') == '4')
				redirect(site_url(MY_ACCOUNT.'supplier'), 'refresh');			
		}

		//now get product details
		$this->data['product'] = $this->account_module->get_product_by_id($auction_id);
		// print_r(json_encode($this->data['product'])); exit;
		//if there is no product id in url, then redirect to inventory page
		if($this->data['product']=='' || $this->data['product']==FALSE || empty($this->data['product'])){
			redirect(site_url('/'.MY_ACCOUNT.'buyer'));
		}

		$this->data['static_field'] = $this->general->get_product_static_fields_data();
		
		//populate basic form fields values
		$this->data['basic_form_values'] = $this->account_module->get_basic_fields_meta_key_values($auction_id, 'basic');
		
		// currently not implemented
		$this->data['custom_form_values'] = $this->account_module->get_basic_fields_meta_key_values($auction_id, 'custom');
		
		$this->data['current_date'] = $this->general->get_local_time('now');
		
		// For the bidding section in product detail section
		$this->data['privacy_policy'] = $this->general->get_cms_details(5); 		
		$this->data['terms_condition'] = $this->general->get_cms_details(6); 

		$this->page_title = 'Auction Detail'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_auction_detail', $this->data);
	}

	// Edit Auction
	// Added By Manish
	public function edit_auction($auction_id='')
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/')); }
		//if there is no product id in url, then redirectto inventory page
		if($auction_id=='' OR $auction_id==0 OR $auction_id =='0' OR !is_numeric($auction_id)){
			redirect(site_url('/'.MY_ACCOUNT.'buyer'));
		}

		$this->data['user_type'] = "buyer";
		$this->data['custom_field_html'] = '';
		$this->data['account_menu_active']="edit_auction";
		$this->data['job'] = 'edit';
		
		$this->data['currencies'] = $this->general->fetch_all_currency();
		
		//now get product details
		$this->data['product'] = $this->account_module->get_product_by_id($auction_id,$user_id);
		// echo "<pre>"; print_r($this->data['product']); echo "</pre>"; exit;
		
		//if there is no product id in url, then redirect to inventory page
		if($this->data['product']=='' OR $this->data['product']==false OR empty($this->data['product'])){
			redirect(site_url('/'.MY_ACCOUNT.'buyer'));
		}
		
		//store product code in local variable
		$this->data['product_code'] = $this->data['product']->product_code;
		
		$this->data['static_field'] = $this->general->get_product_static_fields_data();
		
		//populate basic form fields values
		$basic_form_value = $this->account_module->get_basic_fields_meta_values($auction_id);
		$this->data['basic_field_html'] = $this->account_module->get_custom_fields_html_by_category(0, $basic_form_value, 'edit', '','basic');
		
		$this->data['category_tree'] = $this->general->get_category_tree();
		
		if($this->input->post('category',TRUE) && $this->input->post('category',TRUE)!=''){
			$this->data['cat_id'] = $this->input->post('category',TRUE);
			//assign values from custom fields to the local variable	
			$cf_post_value = $this->input->post('meta',TRUE);
			
			//get files if this product already contains files
			$cf_old_files = $this->account_module->get_custom_fields_meta_files($auction_id);
		}else{
			$this->data['cat_id'] = $this->data['product']->sub_cat_id!=0?$this->data['product']->sub_cat_id:$this->data['product']->cat_id;
			$cf_post_value = $this->account_module->get_custom_fields_meta_values($auction_id);
			$cf_old_files = '';
		}

		//get category name by its id
		$this->data['categoryName'] = $this->general->get_product_category_name_by_id($this->data['cat_id']);
		
		//fetch custom fields
		$this->data['custom_field_html']=$this->account_module->get_custom_fields_html_by_category($this->data['cat_id'],$cf_post_value,'edit',$cf_old_files,'custom');

		
		//set form validation rules
		$this->form_validation->set_rules($this->account_module->generate_validation_rules($this->data['static_field']));
		
		
		//now set all the form validation rules and update product
		if($this->form_validation->run()==TRUE)
		{
			$trans = $this->account_module->edit_auction($auction_id, $this->data['product']->status);
			$this->session->set_flashdata('success_message', "Product Edited Successfully");
			redirect(site_url('/'.MY_ACCOUNT.'buyer'),'refresh');exit;
		}//else{echo validation_errors();}
		
		$this->page_title = $this->data['product']->name.' - '.WEBSITE_NAME;
		$this->data['meta_keys'] = WEBSITE_NAME;
		$this->data['meta_desc'] = WEBSITE_NAME;
		
		$this->template
		->set_layout('general')
		->enable_parser(FALSE)
		->title($this->page_title)		
		->build('v_buyer_edit_auction', $this->data);
	}	
	
	// for buyer change password
	public function buyer_change_password()
	{ 
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/')); }

		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active'] = "buyer_change_password";
		$this->data['account_title'] = "Change Password";

		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			//set the form validation rules
			$this->form_validation->set_rules($this->account_module->validate_change_password);
			if($this->form_validation->run()==TRUE)
			{
				//now change users password
				$change = $this->account_module->change_users_password($user_id);
				if($change)
				{
					//now clear session and redirect to home page after chaging password
					$this->session->unset_userdata(SESSION.'user_id');
					$this->session->unset_userdata(SESSION.'usertype');
					$this->session->unset_userdata(SESSION.'email');
					$this->session->unset_userdata(SESSION.'username');	

					$this->session->set_flashdata('success_message',"Password changed successfully.");
					redirect(site_url('/'));
				}
				else
				{
					$this->session->set_flashdata('error_message',"Unable to Change Password.");
					redirect(site_url('/'.MY_ACCOUNT.'buyer_change_password'));
				}
			}			
		}

		$this->page_title = 'Change Password'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_change_password', $this->data);		
		
	}


	public function buyer_packages()
	{
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="buyer_packages";
		$this->data['account_title']="Membership Pacakges";
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/')); }

		// get my account details		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->form_validation->set_rules($this->account_module->validate_package_purchase);
			if($this->form_validation->run() === TRUE)
			{
				// proceed to payment processing
			}
		}
		$this->data['packages'] = $this->account_module->get_membership_packages('buyer');
		$this->data['payment_gateways'] = $this->account_module->get_all_active_payment_gateways();
		
		$this->page_title = 'Membership Packages'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_membership_packages', $this->data);		
	}	
	
	// for seller change password
	public function supplier_change_password()
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/')); }

		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active'] = "supplier_change_password";
		$this->data['account_title'] = "Change Password";

		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			//set the form validation rules
			$this->form_validation->set_rules($this->account_module->validate_change_password);
			if($this->form_validation->run()==TRUE)
			{
				//now change users password
				$change = $this->account_module->change_users_password($user_id);
				if($change)
				{
					//now clear session and redirect to home page after chaging password
					$this->session->unset_userdata(SESSION.'user_id');
					$this->session->unset_userdata(SESSION.'usertype');
					$this->session->unset_userdata(SESSION.'email');
					$this->session->unset_userdata(SESSION.'username');	

					$this->session->set_flashdata('success_message',"Password changed successfully.");
					redirect(site_url('/'));
				}
				else
				{
					$this->session->set_flashdata('error_message',"Unable to Change Password.");
					redirect(site_url('/'.MY_ACCOUNT.'supplier_change_password'));
				}
			}			
		}

		$this->page_title = 'Change Password'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_change_password', $this->data);		
		
	}

	// sellers dashboard
	public function supplier()
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));
		
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="dashboard";
		$this->data['account_title'] = 'Supplier Dashboard';

		$config['base_url'] = site_url('/'. MY_ACCOUNT .'supplier');
		$config['total_rows'] = $this->account_module->count_all_live_public_auctions();
		$config['per_page'] = 10;
		$config['page_query_string'] = FALSE;
		$config["uri_segment"] = 3;
		
		//get further config from general library
		$this->general->frontend_pagination_config($config);            
		$this->pagination->initialize($config); 
		
		$offset = $this->uri->segment(3,0); 		
		$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
		
		$this->data['live_products'] = $this->account_module->get_live_public_products($config['per_page'], $offset);
		
		$this->data['category_tree'] = $this->general->get_category_tree();

		$this->page_title = 'Supplier Dashboard'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_supplier_dashboard', $this->data);
	}

	// supplier company details
	public function company_details()
	{
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="company_details";
		$this->data['account_title'] = 'Personal/Company Details';

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));

		$this->data['countries'] = $this->general->get_all_countries();
		$this->data['profile'] = $this->general->get_user_details($user_id);		
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules($this->account_module->validate_supplier_profile_settings);
			if($this->form_validation->run() == TRUE)
			{		
				if($this->data['profile']->email != $this->input->post('email',TRUE))
				{
					$update_data['new_email'] = $this->input->post('email',TRUE);
					
					//send email changed notification to member
					// $this->account_module->update_new_email_confirmation_email();
				}
				
				$update_profile = $this->account_module->update_supplier_profile($user_id);
				if($update_profile)
				{
					//display success message
					$this->session->set_flashdata('success_message', "Company Details Updated Successfully.");
					redirect(site_url('/'.MY_ACCOUNT.'company_details'),'refresh');
				}
				else
				{
					//display error message
					$this->session->set_flashdata('error_message', "Unable to update Company details. Please Try Again.");
					redirect(site_url('/'.MY_ACCOUNT.'company_details'),'refresh');
				}
			}
		}	
		$this->page_title = 'Personal/Company Details'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_supplier_company_details', $this->data);
		
	}

	public function proposal_bids()
	{
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="proposal_bids";
		$this->data['account_title'] = 'My Proposal Bids';

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));

		$this->data['proposal_bids'] = $this->account_module->get_user_proposal_bids($user_id);

		$this->page_title = 'Proposal Bids'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_supplier_proposal_bids', $this->data);
	}
	
	public function won_bids()
	{
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="won_bids";
		$this->data['account_title'] = 'My Won Bids';

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));

		$this->data['won_bids'] = $this->account_module->get_user_won_bids($user_id);

		$this->page_title = 'Won Bids'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_supplier_won_bids', $this->data);
	}
	

	// for buyer notification setting
	public function buyer_notification()
	{		
		$this->data['user_type'] = "buyer";
		$this->data['account_menu_active']="buyer_notification";
		$this->data['account_title'] = 'Buyer Notification Settings';

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			// delete all notification settings for current user
			$this->notification->delete_notification_settings($user_id);

			$email_settings_data = array();
			$sms_settings_data = array();

			// manipulate data and generate required array of data to be inserted for email setting			
			foreach ($this->input->post('email_notification') as $template_id => $status) {
				$email_setting_data = array(
					'is_email_notification_send'=>$status,
					'email_template_id'=>$template_id,
					'user_id'=>$user_id
				);
				array_push($email_settings_data, $email_setting_data);
			}

			if(is_array($email_settings_data) && count($email_settings_data) > 0)
			{
				// insert email notification settings data in batch
				$this->notification->insert_batch_notification_status($email_settings_data);
			}

			// manipulate data and generate required array of data to be inserted for sms setting			
			foreach ($this->input->post('sms_notification') as $template_id => $status) {
				$sms_setting_data = array(
					'is_sms_notification_send'=>$status,
					'email_template_id'=>$template_id,
					'user_id'=>$user_id
				);
				array_push($sms_settings_data, $sms_setting_data);
			}

			if(is_array($sms_settings_data) && count($sms_settings_data) > 0)
			{
				// insert sms notification settings in batch
				$this->notification->update_batch_notification_status($sms_settings_data);
			}

			$this->session->set_flashdata('success_message', 'Buyer Notification Settings updated successfully');
		}
		
		$this->data['settings'] = $this->notification->user_notification_settings($user_id);

		$this->page_title = 'Buyer Notification Settings'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_supplier_notification', $this->data);
	}

	// for supplier notification settings
	public function supplier_notification()
	{		
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="supplier_notification";
		$this->data['account_title'] = 'Supplier Notification Settings';

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			// delete all notification settings for current user			
			$this->notification->delete_notification_settings($user_id);

			$email_settings_data = array();
			$sms_settings_data = array();

			// manipulate data and generate required array of data to be inserted
			foreach ($this->input->post('email_notification') as $template_id => $status) {
				$email_setting_data = array(
					'is_email_notification_send'=>$status,
					'email_template_id'=>$template_id,
					'user_id'=>$user_id
				);
				array_push($email_settings_data, $email_setting_data);
			}
			// var_dump($email_settings_data); exit;
			if(is_array($email_settings_data) && count($email_settings_data) > 0)
			{
				// echo count($email_settings_data);exit;
				// insert email notification settings data in batch
				$this->notification->insert_batch_notification_status($email_settings_data);
				
			}

			// manipulate data and generate required array of data to be inserted for sms setting			
			foreach ($this->input->post('sms_notification') as $template_id => $status) {
				$sms_setting_data = array(
					'is_sms_notification_send'=>$status,
					'email_template_id'=>$template_id,
					'user_id'=>$user_id
				);
				array_push($sms_settings_data, $sms_setting_data);
			}

			if(is_array($sms_settings_data) && count($sms_settings_data) > 0)
			{
				// insert sms notification settings in batch
				$this->notification->update_batch_notification_status($sms_settings_data);				
			}
			$this->session->set_flashdata('success_message', 'Supplier Notification Settings updated successfully');
		}
		
		$this->data['settings'] = $this->notification->user_notification_settings($user_id);

		$this->page_title = 'Supplier Notification Settings'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_buyer_supplier_notification', $this->data);
	}

	public function supplier_packages()
	{
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="supplier_packages";
		$this->data['account_title']="Membership Pacakges";
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/')); }

		// get my account details		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->form_validation->set_rules($this->account_module->validate_package_purchase);
			if($this->form_validation->run() === TRUE)
			{
				// proceed to payment processing
			}
		}
		$this->data['packages'] = $this->account_module->get_membership_packages('supplier');
		$this->data['payment_gateways'] = $this->account_module->get_all_active_payment_gateways();
		
		$this->page_title = 'Membership Packages'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_supplier_membership_package', $this->data);
	}

	public function ajax_process_custom_fields()
	{
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		$cat_id = $this->input->post('category',TRUE);
		
		if($cat_id)
		{
			//now get custom fields html value from model
			$custom_fields_html = $this->account_module->get_custom_fields_html_by_category($cat_id,'','add','');
			if($custom_fields_html)
			{
				$response['status'] = 'success';
				$response['html'] = $custom_fields_html;
			}
			else
			{
				$response['status'] = 'error';
				$response['status_message'] = 'data not found';
			}
		}
		else
		{
			$response['status'] = 'error';
			$response['status_message'] = 'data not found';
		}
		print_r(json_encode($response)); exit;
	}
	
	
	
	//multiple image uploader
	function multiple_image_ajax_uploader()
	{
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		//add images 	
		if($_FILES)
		{
			//print_r($_POST);
			$image_count=0;
			$image_data = array();
			$response_array = '';
			
			foreach($_FILES as $key=>$value){
				//echo $key."<br>";
				$image_name = $this->account_module->file_settings_do_upload($key, PRODUCT_IMAGE_PATH_TEMP, 'encrypt');
				if ($image_name['file_name'])
				{
					$this->image_name_path = $image_name['file_name'];
					$image_count++;
					
				   //push image data into array
				   	array_push($image_data, array('product_code' => $this->input->post('pcodeimg', TRUE), 'image' => $this->image_name_path));
					//now store response in an array.
					$response_array = array('status'=>'success', 'name'=>$this->image_name_path);
					
					//stop uploading images if numbers of images exceeds the allowed images
					// if($image_count>=MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES){
					// 	break; //will break if condition and foreach loop
					// }
					//echo $this->db->last_query()."<br><br>";
				}
				else
				{
					$response_array = array('status'=>'error','message'=>'invalid file');
				}   
			}
			//insert into database if response is success
			if($response_array['status']=='success'){
				$this->db->insert_batch('product_images_temp', $image_data); //insert image into database in a batch
			}
		}
		print_r(json_encode($response_array)); exit;
	}
	
	
	//function to remove images from temporary folder when user chooses to remove image 
	public function ajax_delete_product_temp_images()
	{
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		if($this->input->server('REQUEST_METHOD')=='POST'){
			//print_r(json_encode($_POST)); exit;
			
			$image_name = $this->input->post('name',TRUE);
			$product_code = $this->input->post('pcode',TRUE);
			if($image_name && $image_name!='')
			{
				$query = $this->db->get_where('product_images_temp',array('image'=>$image_name));
				if ($query->num_rows() > 0)
				{
					$temp_image =  $query->result();
					@unlink(PRODUCT_IMAGE_PATH_TEMP.''.$image_name);
					$query = $this->db->delete('product_images_temp',array('image'=>$image_name));
					if($query){
						$response['result'] = 'success';
						$response['image_quota'] = (MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES - $this->general->count_total_temp_images_by_product_code($product_code));
						print_r(json_encode($response)); exit;
					}
				}
			}
		}
		print_r(json_encode(array('result'=>'error'))); exit;
	}	
	
	//controller method to delete product images using ajax
	public function ajax_delete_product_image()
	{
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		//print_r($_POST);
		$response = array(); 
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$product_id = intval($this->input->post('pid',TRUE));
			$image = $this->input->post('name',TRUE);
			//print_r($_POST);
			if($product_id && $image){
				$delete = $this->account_module->delete_product_image($product_id, $image);
				if($delete){
					//$total_uploaded = $this->general->count_total_images_in_product($product_id);
					$response['result'] = 'success';
					$response['image_quota'] = (MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES - $this->general->count_total_images_in_product($product_id));
					print_r(json_encode($response));exit;
				}
			}
		}
		$response['result'] = 'Error';
		$response['image_quota'] = '';
		print_r(json_encode($response));exit;
	}
	
	
	
	//controller method to buy product(not an auction)
	public function purchase_checkout($product_id)
	{
		if(!is_numeric($product_id)){
			redirect(site_url('/'.MY_ACCOUNT.'my_auctions'),'refresh'); exit;
		}
		$this->form_validation->set_rules($this->account_module->validate_checkout_shipping_details);
		if($this->input->server('REQUEST_METHOD')=='POST' && $this->form_validation->run()==TRUE){
			//pay by paypal
			$this->paypal();
		}else{
			//echo validation_errors();
			$this->breadcrumbs->push('Purchase Product', '/'); //second parameter is link
			$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
			$this->data['product_id'] = $product_id;
			$this->data['static_field'] = $this->general->get_product_static_fields_data();
			$this->data['product'] = $this->account_module->get_product_details_by_id_for_purchase($product_id);
			$this->data['address'] = $this->account_module->get_members_mailing_address($this->data['user_id']);
			$this->data['countries'] = $this->general->get_all_countries();
			$this->data['payment_gateways'] = $this->account_module->get_all_active_payment_gateways();
			//echo $this->data['user_id'];
			//echo "<pre>"; print_r($this->data['payment_gateways']); echo "</pre>";
			
			//redirect to home page if no data found
			if(!$this->data['product'])	{ redirect(site_url(''),'refresh');	}
			
			
			//SEO parameters
			$this->page_title = $this->data['product']->name.' - '. WEBSITE_NAME;
			$this->data['meta_keys'] = WEBSITE_NAME;
			$this->data['meta_desc'] = WEBSITE_NAME;
			
			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('v_buyer_purchase_checkout', $this->data);		
		}	
	}	
	
	public function paypal()
	{
		//get payment method info
		$this->payment_data = $this->account_module->get_payment_gateway_byid('1'); //$this->payment_method_id
		
	
		if($this->payment_data)
		{
			//paypal settings			
			$this->load->model('paypal_module');//load paypal module
			
		

			$this->data['body'] = $this->paypal_module->set_paypal_form_submit();
			//echo "paypal payment body loaded"; echo "<br>"; exit;
						
			$this->data['wait_msg'] = "<h3>Processing Payment</h3>";
			//print_r($this->data['body']);exit;
			
			//set SEO data
			$this->page_title = WEBSITE_NAME. ' - ' .lang('pay_by_paypal_page_title');
			$this->data['meta_keys'] = "";
			$this->data['meta_desc'] = "";
	
			
			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('v_processing_payment', $this->data);
		}		
		else
		{					
			redirect(site_url()); 
			exit;
		}
	}
	
	
	
	public function paypal_success()
	{
		if($_REQUEST['option_name1'] == 'transaction_type' && $_REQUEST['option_selection1']!='')
		{
			$transaction_type = $_REQUEST['option_selection1'];
			/*if($transaction_type=='pay_for_buy_now_product')
			{
				$this->session->set_flashdata('message','Payment Successful for your purchased product');	
				redirect(site_url(MY_ACCOUNT.'my-purchases'),'refresh');exit;
			}
			else if($transaction_type=='pay_for_won_auction')
			{
				$this->session->set_flashdata('message',"You have successfully paid for your won auction.");	
				redirect(site_url(MY_ACCOUNT.'my-purchases'),'refresh');exit;
			}
			else
			{
				$this->session->set_flashdata('message',lang('payment_sucessful_message'));	
				redirect($this->general->lang_uri('/my-bidcy/user'),'refresh');
				exit;
			}*/
	
			$this->page_title = 'Payment Successful'.' - '.WEBSITE_NAME;
			$this->data['meta_key'] = "";
			$this->data['meta_description'] = "";
			
			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)			
				->build('v_buyer_purchase_success', $this->data);	
		}
		else
		{
			redirect(site_url()); exit;
		}
	}
	
	
	public function paypal_cancel()	//return to this url if pay by paypal is cancelled 
	{
		@$transaction_type = $_REQUEST['item_name'];
		@$payment_status = $_REQUEST['payment_status'];
		
		$this->data['payment'] ='paypal';
		
		//echo $transaction_type; exit;
	
		$this->page_title = WEBSITE_NAME. ' - ' .lang('seo_payment_cancelled_page');
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('v_payment_cancel', $this->data);
	}
	
	
	function unique_auction_name()
	{
		$input_name = strtolower($this->input->post('auction_name',TRUE));
		//check whether this name exists in other users auction name or not
		$this->db->select('host_name');
		$this->db->where(array('host_name'=>$input_name,'seller_id !='=>$this->session->userdata(SESSION.'user_id')));
		$query = $this->db->get('host_auctions');
		if($query->num_rows()>0){
			$this->form_validation->set_message('unique_auction_name', '"'.$input_name.'" is already used. Choose unique name');
			return FALSE;
		}else{
			return true;
		}
	}
	
	
	//callback function to exclude certain names in auction name
	function exclude_names()
	{
		$input_name = strtolower($this->input->post('auction_name',TRUE));
		if($input_name=='bidwarz' || $input_name=='bidwarzlive'){
			$this->form_validation->set_message('exclude_names', 'You cannot use "'.$input_name.'" for auction name');
			return FALSE;
		}else{
			return true;
		}
	}
	
	
	function check_date(){
		$current_date = $this->general->get_local_time('time');	
		if($this->input->post('start_date_time',TRUE)<=$current_date){
			$this->form_validation->set_message('check_date', 'Host Auction start date must be greater than current date');
			return FALSE;
		}
		return TRUE;
	}
	
	
	function check_coseller_auctions(){
		if($this->input->post('public_private',TRUE)=='public' && ($this->input->post('total_auctions',TRUE) <= $this->input->post('co_sellers_auctions',TRUE))){
			$this->form_validation->set_message('check_coseller_auctions', 'Cosellers allotment cannot be greater than total Items');
			return FALSE;
		}
		return TRUE;	
	}
	
	public function profile_check_email()
	{
		//echo "hello"; exit;
		$this->db->select('id,email');
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('id !=',$this->session->userdata(SESSION.'user_id'));
		$query = $this->db->get('members');
			
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('profile_check_email', "This Email is already taken by other user.");
			return FALSE;
		}
		return TRUE;
	}
	
	//callback in jquery validation to check duplicate email
	public function ajax_check_duplicate_paypal_email()
	{
		$this->db->where('paypal_email',$this->input->post('email',TRUE));
		$query = $this->db->get('members_paypal_accounts');
		if($query->num_rows()>0)
		{
			echo "taken"; exit;
		}
		else
		{
			echo "available"; exit;
		}
	}
	
	
	
	public function check_end_date()
	{
		if($this->input->post('end_date',TRUE) <= $this->input->post('start_date',TRUE))
		{
			$this->form_validation->set_message('check_end_date', "End Date must be greater than Start Date.");
			return false;
		}
		return true;
	}
	
	
	//callback function to change password
	public function check_password()
	{
		//$this->account_module->check_old_password();	
		$option = array('id'=>$this->session->userdata(SESSION.'user_id'));
		$query = $this->db->get_where('members',$option);
		$user_data = $query->row();
		
	  	if(isset($user_data->password) && $user_data->password===$this->general->hash_password($this->input->post('password',TRUE),$user_data->salt))
		{
			return TRUE;	
		}
		else
		{
			$this->form_validation->set_message('check_password', "Current Password not matched");
			return FALSE;			
		}
	}
	
	
	//callback function to check valid file extension
	public function _check_file_extension($str,$post_meta_field_params)
	{
		//echo $post_meta_field_params;// exit;
		
		//parameter contains post meta field id and allowed extensions
		// first value is post meta field id and remaining other are extensions
		
		$post_meta_field_params_arr = explode('#', $post_meta_field_params);
		//print_r($post_meta_field_params_arr); //exit;
		
		$post_meta_field_id = $post_meta_field_params_arr[0];
		//echo $post_meta_field_id; //exit;
		
		$filename = $_FILES['metafile_'.$post_meta_field_id]['name'];
		//echo $filename; exit;
		
		$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
		if($file_ext=='docx' OR $file_ext=='xlsx'){
			$file_ext = substr($file_ext, 0, -1);
		}
		//echo $file_ext; //exit;
		
		//now remove first array index (both key and value) so that remainig array is only array of extensions.
		array_shift($post_meta_field_params_arr);
		//print_r($post_meta_field_params_arr); exit;
		
		if(in_array($file_ext,$post_meta_field_params_arr))
		{
			//echo "false"; exit;
			return TRUE;			
		}
		else
		{
			//echo "True"; exit;
			$this->form_validation->set_message('_check_file_extension', 'Invalid File Uploaded.');
			return FALSE;
		}
	}

	// not in use
	public function attachment($product_id)
	{
		if($product_id)
		{
			$attachment = $this->account_module->is_valid_attachment($product_id);
			if($attachment)
			{
				
				$args = array(
					'download_path' => FCPATH.CUSTOM_FIELDS_FILES_PATH,
					'file' => $attachment->file_saved,
					'file_name' => $attachment->file_name,
					'referrer_check' => TRUE,					
				);
			
				$this->mail_model->get_file_download($args);
			}
			else
			{
				redirect(site_url('/'.MY_ACCOUNT. 'auction_detail/'. $product_id),'refresh');exit;
			}
		}
		else
		{
			redirect(site_url('/'.MY_ACCOUNT. 'auction_detail/'. $product_id),'refresh');exit;
		}
	}
	
	public function email_available()
	{
		$option = array('email'=>$this->input->post('user_email'), 'user_type' => '4');
		$query = $this->db->get_where('members',$option);
		$user_data = $query->row();		
	  	if(isset($user_data->email))
		{
			return TRUE;	
		}
		else
		{
			$this->form_validation->set_message('email_available', "Supplier with this email is not available in system");
			return FALSE;			
		}
	}

	public function supplier_expertise()
	{
		$this->data['user_type'] = "supplier";
		$this->data['account_menu_active']="supplier_expertise";
		$this->data['account_title'] = 'My Expertise';

		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) redirect(site_url('/'));

		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules($this->account_module->validate_supplier_expertise);
			if($this->form_validation->run() === TRUE)
			{
				$expertise_add_status = $this->account_module->add_expertise($user_id);
				if($expertise_add_status)
				{
					//display success message
					$this->session->set_flashdata('success_message', "Expertise set Successfully.");
					redirect(site_url('/'.MY_ACCOUNT.'supplier_expertise'),'refresh');
				}
				else
				{
					//display error message
					$this->session->set_flashdata('error_message', "Unable to set. Please Try Again.");
					redirect(site_url('/'.MY_ACCOUNT.'supplier_expertise'),'refresh');
				}
			}
		}	

		// retrieve suppliers expertise area
		$expertise_area = $this->account_module->get_expertise_area($user_id);
		$this->data['expertise_area'] = array();
		if(!empty($expertise_area))
		$this->data['expertise_area'] = $expertise_area;
		$this->data['category_tree'] = $this->general->get_category_tree();

		$this->page_title = 'Suplier Expertise'.' - '. WEBSITE_NAME;
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_supplier_expertise', $this->data);
	}

	// to check for expertise validation
	public function check_expertise_limit()
	{
		$categories = $this->input->post('categories',TRUE);
		if(!empty($categories) && is_array($categories) && SUPPLIER_CATEGORY_LIMIT>0)
		{
			if( count($categories) > SUPPLIER_CATEGORY_LIMIT)
			{
				$this->form_validation->set_message('check_expertise_limit', 'You are not allowed to choose expertise category more than '. SUPPLIER_CATEGORY_LIMIT);
				return FALSE;
			}
			else 
				return TRUE;
		}		
		return TRUE;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */