	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller {
	function __construct() {
		parent::__construct();
		    $this->load->library('Ajax_pagination');
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
			redirect(site_url('/user/login'),'refresh');exit;
        }
        if($this->session->userdata(SESSION.'usertype')!='3')
        {
          	$this->session->set_flashdata('loginerror', "You are not authroized to Access.");
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
		$this->load->model('brand_model','model');
		$this->load->model('my-account/account_module');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');		
	}
	// for create Campaign	
	public function create_campaign()
	{
		$product_id=$this->input->post('productid');
		$this->load->model('my-account/account_module');
		$this->data['user_type'] = "brand";	
		$this->data['account_title']="Create Campaign";
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/'),'refresh');}	
		if($product_id!=''){
			$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$product_id));
			if(count($check)<1)
			{
				echo json_encode(array('error_message'=> 'You are not authorized to edit the content'));
			}
		}
		// $this->data['product_code'] = strtotime('now').$user_id
		$this->form_validation->set_rules($this->account_module->validate_campaign_creation);

		if($this->form_validation->run()==TRUE)
		{
			$response = $this->account_module->insert_new_product($product_id);

			if(isset($response['success'])){
				if(AUCTION_POST_ACTIVATION == '1')
				{
					
				echo json_encode(array('success_message'=> "Item Added Successfully. It wil be active after admin verification"));
				}
				else
				{
						echo json_encode(array('success_message'=> 'Item Added Successfully.'));	
				}
			}
			else {
					echo json_encode(array('error_message'=> $response['error']));
			}
			

		}
		redirect(site_url('/'.MY_ACCOUNT.'brand'),'refresh'); exit;
	}

	// public function
	public function creators()
	{
				
			$this->data['user_type'] = "brand";	
			$this->data['account_title']="creator";
			$user_type = $this->session->userdata(SESSION . 'usertype');
      
			$user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='3') redirect(site_url('/'));
			  $creators=$this->model->getallcreators();
// print_r($creators);
			  $campaigns=$this->general->get_data('products',array('brand_id'=>$user_id,'status'=>'2'));
			  $audience_country=$this->general->getmaxcolumn('audience_geography','number_user',array('user_id'=>$user_id));
			  $audience_demography=$this->model->getaudiencedemography();
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "creator";
     		  $this->data['account_title'] = 'Creators';
			  $this->data['creators']=$creators;
			  $this->data['campaigns']=$campaigns;
		      $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_creators', $this->data);

	}
	public function inviteuser(){
		$data=$this->model->inviteuser();
		echo json_encode($data);
	}

	public function campaigns(){
			$this->data['user_type'] = "brand";	
			$this->data['account_title']="Brand";
			$user_type = $this->session->userdata(SESSION . 'usertype');
			 $user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='3') redirect(site_url('/'));
			  $campaigns=$this->model->getuserproduct($user_id);
			 
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "campaigns";
     		  $this->data['account_title'] = 'Creators';
			  // $this->data['creators']=$creators;
			  $this->data['campaigns']=$campaigns;
		      $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_my_campaigns', $this->data);
	}

	public function ajax_campaigns(){
		 $user_id = $this->session->userdata(SESSION.'user_id');
		  $data['campaigns']=$this->model->getuserproduct($user_id);
		echo   $this->load->view('ajax_campaign',$data,true);
	}


	
	public function getproposalbyproduct($productcode,$id=false){
		  $user_id = $this->session->userdata(SESSION.'user_id');
		  $user_type = $this->session->userdata(SESSION . 'usertype');
			
		 $check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'product_code'=>$productcode));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
		}else{
				$proposals=$this->model->getproposal($productcode);
				$userdata=$this->general->get_single_row('members',array('id'=>$user_id));
				$balance=$userdata->balance;
					
			  $this->data['user_type'] = "brand";	
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "campaigns";
     		  $this->data['account_title'] = 'Creators';
			  $this->data['proposals']=$proposals;
			  $this->data['userbalance']=$balance;
			  $this->data['productname']=$check->name;
			  $this->data['product_code']=$productcode;
			  $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_proposal_list', $this->data);
		}
	}

	
	public function ajax_proposal($productid){
		
		$user_id = $this->session->userdata(SESSION.'user_id');
		 
		$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
		}else{
			$data['product_id']=$productid;
			$data['productname']=$check->name;
			$data['proposals']=$this->model->getproposal($productid);

			$userdata=$this->general->get_single_row('members',array('id'=>$user_id));
			$balance=$userdata->balance;
			$data['userbalance']=$balance;
			$response=$this->load->view('ajax_proposal',$data,true);
			echo $response;
		}
				
	}

	public function acceptreject_draft(){
		$data=$this->model->acceptreject_draft();
		echo json_encode($data);exit;	
	}
	public function check_user_balance()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$this->db->select('balance');
		$query=$this->db->get_where('members',array('id'=>$userid));
		$userdata=$query->row();
		$balance=$userdata->balance;
		$bidid=$this->input->post('bidid');
		$productid=$this->input->post('productid');
		$data=$this->general->get_single_row('product_bids',array('id'=>$bidid,'product_id'=>$productid));
		$bid_amt=$data->user_bid_amt;
		$bidamount_paid=$data->bidamount_paid;
		if($balance>=$bid_amt || $bidamount_paid=='1' || $data->status>=2){
			echo json_encode(array('success_message'=> true));exit;
		}
		else echo json_encode(array('error_message'=> 'You don\'t have enough balance.You will be redirected to payment page in a while'));exit;
	}

	public function payment($amount=false)
	{
			  $user_id = $this->session->userdata(SESSION.'user_id');
		  	  $getuser=$this->general->get_single_row('members',array('id'=>$user_id));	
		  	  $userbalance=$getuser->balance;
		  	  $this->form_validation->set_rules($this->model->validate_payment);
		  	  if($this->form_validation->run()==true)
		  	  {
		  	  	$this->payment_method_id = $this->input->post('payment_type',TRUE);
		  	  		 switch($this->payment_method_id)
					 {
						case '1':
									$this->paypal();
									break;
						default:
								 // $this->session->set_flashdata('message',"Please choose bid pack & payment method properly.");
								 // redirect(site_url('/'.MY_ACCOUNT.'buyer_packages'),'refresh');
								 exit;
					 }
		  	  	}
		  	  	else
		  	  		{
		  	  			if($amount){
		  	  				$this->data['amount']=$amount;
		  	  			}
		  	  		  $this->data['user_type'] = "brand";	
					  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
					  $this->data['account_menu_active'] = "campaigns";
		     		  $this->data['account_title'] = 'Payments';
					  $this->data['payment_gateway']=$this->general->get_all_payment_gateway();
					  $this->data['balance']=$userbalance;
					  			  // $this->data['product_code']=$productcode;
					  $this->data['meta_keys'] = "";
				      $this->data['meta_desc'] = "";
				      $this->template
		               	->set_layout('dashboard')
		                ->enable_parser(FALSE)
		                ->title($this->page_title)
		                ->build('v_payment_detail', $this->data);
		  	  	}
		  	  
			
	}
	public function paypal()
	{
		//get payment method info
		$data = $this->general->get_all_payment_gateway('1'); //$this->payment_method_id
		$this->payment_data=$data['0'];
		if(count($this->payment_data)>0)
		{

			//paypal settings			
			$this->load->model('paypal_module');//load paypal module
			$this->data['body'] = $this->paypal_module->set_paypal_form_submit();
		 	$this->data['wait_msg'] = "<h3>Processing Payment</h3>";

		  $this->data['user_type'] = "brand";	
		  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
		  $this->data['account_menu_active'] = "campaigns";
 		  $this->data['account_title'] = 'Creators';
			//set SEO data
			$this->page_title = WEBSITE_NAME. ' - Payment';
			$this->data['meta_keys'] = "";
			$this->data['meta_desc'] = "";
			$this->template
				->set_layout('dashboard')
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
	
	$status=$this->input->post('payment_status');
	$user_id=$this->session->userdata(SESSION.'user_id');
	$usertype=$this->session->userdata(SESSION.'usertype');
	$getuser=$this->general->get_single_row('members',array('id'=>$user_id));	
	$userbalance=$getuser->balance;
	if($usertype=='3') $this->data['user_type'] = "Creator";
	if($usertype=='4') $this->data['user_type'] = "Brand";

		$this->data['account_title']="Payment Success";
			$this->page_title = 'Payment Successful'.' - '.WEBSITE_NAME;
			$this->data['balance']=$userbalance;
			$this->data['account_menu_active'] = "";
			$this->data['meta_keys'] = WEBSITE_NAME;
			$this->data['meta_desc'] = WEBSITE_NAME;
			$this->data['status']=$status;
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)			
				->build('v_payment_success', $this->data);	

	}
	public function paypal_cancel()	//return to this url if pay by paypal is cancelled 
	{
		$usertype=$this->session->userdata(SESSION.'usertype');
		if($usertype=='3') $this->data['user_type'] = "Creator";
		if($usertype=='4') $this->data['user_type'] = "Brand";
		$this->page_title = WEBSITE_NAME. ' - ' .lang('seo_payment_cancelled_page');
		$this->data['account_menu_active'] = "";
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('v_transaction_cancel', $this->data);

	}

	public function profile($user_id=false){
		try{
			if(!$user_id) throw new Exception("Sorry,No user selected", 1);
			$this->load->library('google');
			$this->load->library('twitter');
			// $arrContextOptions=array(
   //                  "ssl"=>array(
   //                        "verify_peer"=>false,
   //                        "verify_peer_name"=>false,
   //                    ),
   //                );  
                    // $pic =file_get_contents($image,);
// 	$JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=RmU2Swe2eI0&key=AIzaSyCyVNboZ93IgX4Ap622BTzaIwXzACULkBI");
// $json_data = json_decode($JSON, true);
// echo $json_data['items'][0]['statistics']['

			// $a=$this->general->get_data('members');
			// echo '<pre>';
			// print_r($a);
			$this->data['user_info']=$this->account_module->get_creator_details($user_id);
			$this->data['mediadetail']=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));

			if((!$this->data['user_info']) || (count($this->data['mediadetail'])<1)){
				$this->session->set_flashdata('error_message','No Creator found');
				redirect(site_url('/'.MY_ACCOUNT.'brand'));
			}
			
			$this->data['mediaprofile']=$this->general->get_data('socialmedia_profile',array('user_id'=>$user_id));
		
			$this->data['user_type'] = "Brand";
			$this->data['account_menu_active']="user_profile";
			$this->data['account_title'] = 'User Profile';
			$this->page_title = 'User Profile'.' - '. WEBSITE_NAME;
			$this->data['meta_keys'] = "";
			$this->data['meta_desc'] = "";
			$this->template
				->set_layout('dashboard')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('v_user_profile', $this->data);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	public function get_embed_post(){
		$data['mediatype']=$this->input->get('media');
		$data['url']=$this->input->get('url');
		echo $this->load->view('fb_embed_post',$data,true);
	}

}



