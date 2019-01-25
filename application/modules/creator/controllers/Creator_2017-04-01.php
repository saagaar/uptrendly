<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Creator extends CI_Controller {

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
			redirect(site_url('user/login'),'refresh');exit;
        }
		 //check banned IP address
		$this->general->check_banned_ip();
		//load CI library
		// $this->load->library('upload');
		// $this->load->library('image_lib');
		$this->load->library('form_validation');
		// $this->load->library("pagination");	
		// $this->load->helper('text');
		$this->load->model('creator_model','model');
		// $this->load->model('paypal_module');
		// $this->load->model('email-settings/admin_email_settings');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');		
	}

	public function sponsorship($type='public',$id=false)
	{	
		// $this->load->library('google');
		 	$KEY_FILE_LOCATION = __DIR__.'/vid-energy-4340085007a9.json';
		 	chmod($KEY_FILE_LOCATION,'777');
		 	// echo $KEY_FILE_LOCATION;
		 	// if(!file_exists($KEY_FILE_LOCATION))
		 	// {
		 	// 	echo 'here';exit;
		 	// }
		 	// exit;
		 	 $newcl = new Google_Client();
		 	
		  $newcl->setApplicationName("Vid.Energy");
		  $newcl->setAuthConfig($KEY_FILE_LOCATION);
		  $newcl->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
		  $analytics = new Google_Service_Analytics($newcl);


			$accounts = $analytics->management_accounts->listManagementAccounts();

  if (count($accounts->getItems()) > 0) {
    $items = $accounts->getItems();

    $firstAccountId = $items[0]->getId();

    // Get the list of properties for the authorized user.
    $properties = $analytics->management_webproperties
        ->listManagementWebproperties($firstAccountId);
	

    if (count($properties->getItems()) > 0) {
      $items = $properties->getItems();

      $firstPropertyId = $items[0]->getId();

      // Get the list of views (profiles) for the authorized user.
      $profiles = $analytics->management_profiles
          ->listManagementProfiles($firstAccountId, $firstPropertyId);

      if (count($profiles->getItems()) > 0) {
        // $items = $profiles->getItems();
        // echo '<pre>';
        // print_r($items);exit;
        // Return the first view (profile) ID.
     $tableid= $items[0]->getId();
	        $optParams = array(
	      'dimensions' => 'ga:eventCategory',
	      'filters' => 'ga:eventCategory==buttons115',
	      'max-results' => '25');

		  $data= $analytics->data_ga->get(
		       'ga:' .$tableid,
		      '2017-01-10',
		      '2017-06-15',
		     
		    	'ga:sessions',
		    	$optParams);
			  // print_r($data);
			

      } else {
        throw new Exception('No views (profiles) found for this user.');
      }
    } else {
      throw new Exception('No properties found for this user.');
    }
  } else {
    throw new Exception('No accounts found for this user.');
  }

// print_r($data);
			$this->data['user_type'] = "creator";	
			$this->data['account_title']="Sponsorship";
			$user_type = $this->session->userdata(SESSION . 'usertype');
      
			$user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='4') redirect(site_url('/'));

			  $mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			  $this->getsocialmedialink();
			  $sponsorships=$this->model->getallsponsorship($type,$id);
			  // $myproposals=$this->model->getmyproposalsponsor($type,$id);
			  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "sponsorship";
     		  $this->data['account_title'] = 'Sponsorship';
			  $this->data['sponsorships']=$sponsorships;
			  // $this->data['myproposals']=$myproposals;
			  $this->data['usermediaassociation']=$mediaassociated;
		      $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_sponsorship', $this->data);
	}
	public function setsession()
	{
		$var=$this->input->post('sessionvar');
		$val=$this->input->post('sessdata');
		$productid=$this->input->post('productid');
		$this->session->set_userdata($var,$val);
		$this->session->set_userdata('selectedproduct',$productid);	
	}
	public function ajax_sponsorship($type='public')
	{
			$this->getsocialmedialink();
			$user_id = $this->session->userdata(SESSION.'user_id');
			$user_type = $this->session->userdata(SESSION . 'usertype');
			if (!$user_id && $user_type!='4') redirect(site_url('/'));
			$mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));  
		    $this->data['sponsorships']=$this->model->getallsponsorship($type);
		    $this->data['usermediaassociation']=$mediaassociated;
			echo $this->load->view('creator/ajax-sponsorship',$this->data,true);
	}

	public function getsocialmedialink(){
		 $this->load->library('Facebook');
         $this->load->library('Instagrams');
         $this->load->library('Google');
         $this->load->library('Twitter');
        $relogin='';
      if((defined('FACEBOOK_APP_KEY') && defined('FACEBOOK_APP_SECRET')))
            $fburl=$this->facebook->login_url();    
        else 
            $fburl='#';
     if((defined('INSTAGRAM_APP_KEY') && defined('INSTAGRAM_APP_SECRET')))
                $insurl=$this->instagrams->login_url();
      else
       $insurl='#';
    if((defined('YOUTUBE_APP_KEY') && defined('YOUTUBE_APP_SECRET')))
                $yturl=$this->google->login_url();
      else
       $yturl='#';
      if((defined('TWITTER_APP_KEY') && defined('TWITTER_APP_SECRET')))
                // $twurl=$this->twitter->getLoginUrl(); 
                $twurl='#';
      else 
        $twurl='#';
      if((defined('VINE_APP_KEY') && defined('VINE_APP_SECRET')))
            $vine_url='#';
       else 
       		 $vine_url='#';
       if((defined('TUMBLR_APP_KEY') && defined('TUMBLR_APP_SECRET')))
            $tm_url='#';
       else 
            $tm_url='#';
        $this->data['fb_url']=$fburl;
        $this->data['tw_url']=$twurl;
        $this->data['ins_url']=$insurl;
        $this->data['yt_url']=$yturl;
        $this->data['relogin']=$relogin;
        $this->data['vine_url']=$vine_url;
        $this->data['tm_url']=$tm_url;
        return ;
	}
	public function collaborations($type='public',$id=false){
			$this->data['user_type'] = "creator";	
			$this->load->library('facebook');
			 
			$this->data['fb_url']=$this->facebook->login_url();
			$this->data['account_title']="creator";
			$user_type = $this->session->userdata(SESSION . 'usertype');
      		$user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='3') redirect(site_url('/'));
			$mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			
			$collaboration=$this->model->getallcollaborationposts('public');
			$mycollabposts=$this->model->getmycollaborationposts();

			  // $audience_country=$this->general->getmaxcolumn('audience_geography','number_user',array('user_id'=>$user_id));
			  // $audience_demography=$this->brand_model->getaudiencedemography();
			  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "collaboration";
     		  $this->data['account_title'] = 'Collaborations';
			  $this->data['collaboration']=$collaboration;
			  $this->data['my_collabs']=$mycollabposts;
			  $this->data['usermediaassociation']=$mediaassociated;
		      $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_collaborations', $this->data);
	}

	public function ajax_collab($type='public')
	{
			$user_id = $this->session->userdata(SESSION.'user_id');
			$user_type = $this->session->userdata(SESSION . 'usertype');
			if (!$user_id && $user_type!='4') redirect(site_url('/'));
			$mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			$data['usermediaassociation']=$mediaassociated;
		    $data['collaboration']=$this->model->getallcollaborationposts($type);
			echo $this->load->view('creator/ajax-collab',$data,true);
	}

	public function sendproposal(){
		$response=$this->model->submitproposal();
		if($response) echo json_encode($response);
		else echo json_encode(array('error_message'=>'Sorry something went wrong,Try again in a while'));
	}
	public function getproposal($productid,$mediaid=false)
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		$this->session->unset_userdata('selectedproduct');
		$this->session->set_userdata('selectedproduct',$productid);
		$data=$this->general->get_single_row('product_bids',array('user_id'=>$user_id,'product_id'=>$productid,'mediaid'=>$mediaid));
		
		if($data)
			echo json_encode($data);
		else{
			$products=$this->general->get_single_row('products',array('id'=>$productid));
			$members=$this->general->get_single_row('member_socialmedia',array('user_id'=>$user_id,'media_type_id'=>$mediaid));
			$remaininglikes=$products->least_fan_count-$members->total_reach;
			if($remaininglikes<=0){
				echo json_encode(array(''));
			}else{
				echo json_encode(array('error_message'=>'You still need more '.$remaininglikes.' user in your Fan club '));
			}
		}
	}
	public function getmedialist($productid){
		 $user_id = $this->session->userdata(SESSION.'user_id');
		$usermediaassociated=  $this->general->get_member_media($user_id);
		$productmedia=  $this->general->get_product_media($productid);
		$allmedia=  $this->general->get_all_media();
		$data['allmedia']=$allmedia;
		$data['userconnected']=array();

		if(count($productmedia)>0)
		{
			foreach($productmedia as $productm)
			{

				if(in_array($productm,$usermediaassociated))
				{
					$data['userconnected'][]=$productm;
				}else{
					$data['usernotconnected'][]=$productm;
				}
			}
		}
		echo json_encode($data);
		
	}
	
	// for create Campaign	
	public function create_collab()
	{
		$product_id=false;
		$product_id=$this->input->post('productid');
		$this->load->model('my-account/account_module');
		$this->data['user_type'] = "creator";	
		$this->data['account_title']="Create Collab";
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/'),'refresh');}	
		if($product_id!='')
		{
			$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$product_id));
			
			if(count($check)<1)
			{
				echo json_encode(array('error_message'=> 'You are not authorized to edit the content'));exit;
			}
		}
		// $this->data['product_code'] = strtotime('now').$user_id
		// $this->data['product_code'] = strtotime('now').$user_id
		$this->form_validation->set_rules($this->model->validate_collab_creation);

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

		// redirect(site_url('/'.MY_ACCOUNT.'creator'),'refresh'); exit;
	}

	public function getproposalbyproduct($productcode,$id=false)
	{
			$this->load->model('brand/brand_model');
			$user_id = $this->session->userdata(SESSION.'user_id');
			$user_type = $this->session->userdata(SESSION . 'usertype');	
			$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'product_code'=>$productcode));
			if(count($check)<1)
			{
				echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
			}else
			{
					$proposals=$this->brand_model->getproposal($productcode);
				
				  $this->data['user_type'] = "creator";	
				  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
				  $this->data['account_menu_active'] = "collaboration";
	     		  $this->data['account_title'] = 'Creators';
				  $this->data['proposals']=$proposals;
				  $this->data['productname']=$check->name;
				  $this->data['product_id']=$check->id;
				  $this->data['meta_keys'] = "";
			      $this->data['meta_desc'] = "";
			      $this->template
	               	->set_layout('dashboard')
	                ->enable_parser(FALSE)
	                ->title($this->page_title)
	                ->build('v_collab_proposal_list', $this->data);
			}
		}
	public function ajax_proposal($productid){
		$this->load->model('brand_model');
		$user_id = $this->session->userdata(SESSION.'user_id'); 
		$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
		}else{
			$data['product_id']=$productid;
			$data['productname']=$check->name;
			$data['proposals']=$this->brand_model->getproposal($productid);
			$response=$this->load->view('ajax_collab_proposal',$data,true);
			echo $response;
		}
				
	}

	public function get_draft(){
		$user_id = $this->session->userdata(SESSION.'user_id');
		$bidid=$this->input->post('bidid');
		$check=$this->general->get_single_row('product_bids',array('id'=>$bidid,'user_id'=>$user_id));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the draft'));exit;
		}else{
				$draft=$this->general->get_single_row('draft_promotion',array('bid_id'=>$bidid,'bid_status'=>'2','draft_accept'=>'0'));
				if($draft) echo json_encode($draft);
				else echo json_encode(array());

		}
	}

	public function send_draft(){
		$user_id = $this->session->userdata(SESSION.'user_id');

		$this->form_validation->set_rules($this->model->validate_draft);
		if($this->form_validation->run()==TRUE)
		{
			
				$res=$this->model->send_draft_promotion();
				if($res)
					echo json_encode($res);
				else echo json_encode(array('error_message'=>'No data updated'));
			
		}
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
	 		$this->payment_method_id = $this->input->post('payment_type',TRUE);
		 	 switch($this->payment_method_id)
			 {
				case '1':
							$this->paypal();
							break;
				default:
						 $this->session->set_flashdata('message',"Please choose bid pack & payment method properly.");
						 redirect(site_url('/'.MY_ACCOUNT.'buyer_packages'),'refresh');
						 exit;
			 }
			
			}
			else{
				redirect(site_url('/'.MY_ACCOUNT.'buyer_packages'),'refresh');
						 exit;
			}
		}
		
		else{
			

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

	// public function supplier()

	// {
	// 	$user_id = $this->session->userdata(SESSION.'user_id');

	// 	if(!$user_id) redirect(site_url('/'));

		

	// 	$this->data['user_type'] = "supplier";

	// 	$this->data['account_menu_active']="dashboard";

	// 	$this->data['account_title'] = 'Supplier Dashboard';



	// 	$config['base_url'] = site_url('/'. MY_ACCOUNT .'supplier');

	// 	$config['total_rows'] = $this->account_module->count_all_live_public_auctions();

	// 	$config['per_page'] = 5;

	// 	$config['page_query_string'] = FALSE;

	// 	$config["uri_segment"] = 3;

		

	// 	//get further config from general library

	// 	$this->general->frontend_pagination_config($config);            

	// 	$this->pagination->initialize($config); 

		

	// 	$offset = $this->uri->segment(3,0); 		

	// 	$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);

		

	// 	$this->data['live_products'] = $this->account_module->get_live_public_products($config['per_page'], $offset);

		

	// 	$this->data['category_tree'] = $this->general->get_category_tree();



	// 	$this->page_title = 'Supplier Dashboard'.' - '. WEBSITE_NAME;

	// 	$this->data['meta_keys'] = "";

	// 	$this->data['meta_desc'] = "";

		

	// 	$this->template

	// 		->set_layout('general')

	// 		->enable_parser(FALSE)

	// 		->title($this->page_title)

	// 		->build('v_supplier_dashboard', $this->data);

	// }

 public function supplier2(){
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page; //($page-1)*2;
        }
        
        //total rows count
        
         $config['total_rows'] = $this->account_module->count_all_live_public_auctions();
        //pagination configuration
        $config['target']      = '#f_content';
        $config['base_url'] = site_url('/' . MY_ACCOUNT . 'supplier2');
       
        $config['per_page']    = 5;
        $this->ajax_pagination->initialize($config);
        //get the posts data
         $this->data['live_products'] = $this->account_module->get_live_public_products($config['per_page'],$offset);

         $this->data['links']  = $this->ajax_pagination->create_links();

        //$this->data['search_data'] = $this->home_model->get_search();
     $this->load->view('v_filter_auction', $this->data);

    }
    // sellers dashboard

    public function supplier() {
    //     if($this->input->is_ajax_request()){
    //     die($this->input->post('order_choice'));
    // }
        $user_id = $this->session->userdata(SESSION . 'user_id');
        if (!$user_id)
            redirect(site_url('/'));
        

            // Ajax pagination 
      
        $config['target']      = '#f_content';
          $config['base_url'] = site_url('/' . MY_ACCOUNT . 'supplier2');
       
        $config['total_rows'] = $this->account_module->count_all_live_public_auctions();
        $config['per_page']    = 5;
        $this->ajax_pagination->initialize($config);
        $this->data['live_products'] = $this->account_module->get_live_public_products($config['per_page'],0);
        $this->data["links"] = $this->ajax_pagination->create_links();

        $this->data['details'] = $this->general->get_user_details($user_id);
       
        $this->data['user_type'] = "supplier";
        $this->data['account_menu_active'] = "dashboard";
        $this->data['account_title'] = 'Supplier Dashboard';
        $this->data['my_rating'] = $this->account_module->getoverallrating($user_id);
        $this->data['productwise_rating'] = $this->account_module->getproductwiserating($user_id);
        $membership = $this->account_module->get_data('members', array('id' => $user_id));
        $this->data['memberinfo'] = $membership['0'];
        //$config['base_url'] = site_url('/' . MY_ACCOUNT . 'supplier');
        //$config['total_rows'] = $this->account_module->count_all_live_public_auctions();
        //$config['per_page'] = 5;
        //$config['page_query_string'] = FALSE;
        //$config["uri_segment"] = 3;
        //get further config from general library
       // $this->general->frontend_pagination_config($config);
        //$this->pagination->initialize($config);
       // $offset = $this->uri->segment(3, 0);
       // $this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
        //$this->data['live_products'] = $this->account_module->get_live_public_products($config['per_page'], $offset);
        $this->data['category_tree'] = $this->general->get_category_tree();
        $this->page_title = 'Supplier Dashboard' . ' - ' . WEBSITE_NAME;
        $this->data['meta_keys'] = "";
        $this->data['meta_desc'] = "";
        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_supplier_dashboard', $this->data);
    }

    //get filtered item
    public function filtered_item(){

        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page; 
        }
      
         $config['target']      = '#f_content';
         $config['base_url'] = site_url('/' . MY_ACCOUNT . 'filtered_item');
         $config['total_rows'] = $this->account_module->count_all_live_public_auctions();
         $config['per_page'] = 5;
        $this->ajax_pagination->initialize($config);
        //$config['page_query_string'] = FALSE;
       // $config["uri_segment"] = 3;
       // $this->general->frontend_pagination_config($config);
       // $this->pagination->initialize($config);
         //$offset = $this->uri->segment(3, 0)?$this->uri->segment(3, 0):0;
       // $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['live_products'] = $this->account_module->get_live_public_products($config['per_page'], $offset);
      $this->data["links"] = $this->ajax_pagination->create_links();
         $this->load->view('v_filter_auction', $this->data);
         
        
        
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

	

	public function bid_details($product_id=false)

	{

		try{

			if(!$product_id) throw new Exception("No product found", 1);

			$user_id = $this->session->userdata(SESSION.'user_id');

			if(!$user_id) { redirect(site_url('/')); }

			$this->data['user_type'] = "buyer";

			$this->data['account_menu_active']="bid_details";
			$this->data['my_rating']=$this->account_module->getoverallrating($user_id);
			// print_r($this->data['my_rating']);
			$this->data['account_title'] = 'Bid Details';

				$this->load->library('pagination');

				$config['base_url'] = site_url('/'.MY_ACCOUNT.'view_auction/');

				$condition=array('product_id'=>$product_id);

				$config['total_rows'] = $this->account_module->count_all_data('product_bids',$condition);

				$config['per_page'] = 5;

				$config['page_query_string'] = FALSE;

				$config["uri_segment"] = 3;

				$this->general->frontend_pagination_config($config);        

				$this->pagination->initialize($config); 

				$offset=$this->uri->segment(4,0);            		

				$this->data['bidslist'] = $this->account_module->getbidsdetail($product_id,$config["per_page"],$offset);

				$this->data["pagination_links"] = $this->pagination->create_links();

			

			$this->page_title = 'Bid Detail'.' - '. WEBSITE_NAME;

			$this->data['meta_keys'] = "";

			$this->data['meta_desc'] = "";

		

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('v_buyer_view_bid', $this->data);

		}

		catch(Exception $e){

			throw $e->getMessage();

		}

	}



	//for making supplier winner	

	public function make_winner($product_id=false,$user_id=false)

	{

		try{

			if(!($product_id && $user_id)) throw new Exception("Error in data variables", 1);

			 $sessuser=$this->session->userdata(SESSION.'user_id');

			$checkvalidproductforuser=$this->account_module->get_data('products',array('seller_id'=>$sessuser,'id'=>$product_id));

			

			if(count($checkvalidproductforuser)==0)

			{

				$this->session->set_flashdata('error_message', 'Sorry,You are not authorized to complete this action');

				redirect(site_url('/'.MY_ACCOUNT.'bid_details/'.$product_id),'refresh');

			}



			$date=$this->general->get_local_time('time');

			$cond=array('product_id'=>$product_id,'user_id'=>$user_id);

			$data=$this->account_module->get_data('product_bids',$cond);

			if(count($data)==0)

			{

				$this->session->set_flashdata('error_message', 'Sorry,No bid found for this user');

				redirect(site_url('/'.MY_ACCOUNT.'bid_details/'.$product_id),'refresh');

			}

			$checkifwinnerisset=$this->account_module->get_data('product_winner',array('product_id'=>$product_id));

			if(count($checkifwinnerisset)>0)

			{

				$this->session->set_flashdata('error_message', 'Winner has already set for this product');

				redirect(site_url('/'.MY_ACCOUNT.'bid_details/'.$product_id),'refresh');

			}

			$insertdata= array(	

								'product_id'		 => 	$product_id,
								'user_id'			 =>		$user_id,
								'bid_id'			 =>		$data[0]->id,
								'won_amount'		 =>		$data[0]->user_bid_amt,
								'product_close_date' =>		$date,
								'payment_status'	 =>		'Incomplete',
								'email_sent'		 =>		0		

							  );

			$id=$this->account_module->insert_data('product_winner',$insertdata);

			if($id)
			{

				$user=$this->account_module->get_data('members',array('id'=>$user_id));

				$product=$this->account_module->get_data('products',array('id'=>$product_id));

				$from=SYSTEM_EMAIL;

				$to=$user[0]->email;

				$template_id=21;

				$parseElement=array(

										'EMAIL'			=> 		$to,
										'INVOICE'		=>		22,
										'PRODUCTNAME'	=>		$product[0]->name,
										'AMOUNT'		=>		$data[0]->user_bid_amt,
										'DATE'			=>		$date,
										'SITENAME'		=>		WEBSITE_NAME
									);

				$email=$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());	

				if($email) $email=$email; else $email=0;



				$product_update=array('status'=>'3','update_date'=>$date,'winner_notified'=>'1','auc_end_time'=>$date);

			

				$id=$this->account_module->update_data('products',$product_update,array('id'=>$product_id));

				if($id)

				{

							$this->session->set_flashdata('success_message', 'Winner has been notified through email.');

							redirect(site_url('/'.MY_ACCOUNT.'bid_details/'.$product_id),'refresh');

				}else{

					$this->session->set_flashdata('error_message', 'Error in Winner selection');

							

				}



			}

		}

		catch(Exception $e){

			throw $e->getMessage();

		}

	}



	//for sending message to seller

	public function send_message($product_id=false,$bidid=false)

	{

		try{

			if((!$bidid) || (!$product_id)) throw new Exception("Error in data selection", 1);

			$currentuser=$this->session->userdata(SESSION.'user_id');

			$this->data['user_type'] = "buyer";

			$this->data['account_menu_active']="bid_details";

			$this->data['account_title'] = 'Bid Details';

			$valid=$this->account_module->checkmessagevalidity($product_id,$bidid);

			if($valid<1) redirect(site_url('/'.MY_ACCOUNT.'bid_details/'.$product_id));

			$this->data['communicationdata']=$this->account_module->getallmessagecontent($product_id,$bidid);

			if($this->input->server('REQUEST_METHOD') === 'POST')

			{

				$this->form_validation->set_rules($this->account_module->validate_buyer_send_message);

				if($this->form_validation->run() == TRUE)

				{

					$date=$this->general->get_local_time('time');

					

					$arraydata=array(

										'product_id'	=> 		$this->input->post('product_id'),

										'user_id'		=>		$this->input->post('user_id'),

										'bid_id'		=>		$this->input->post('bid_id'),

										'message'		=>		$this->input->post('message'),

										'messagedate'	=>		$date

									);

					$lastid=$this->account_module->insert_data('communication',$arraydata);

					// $lastid=7;

					$message='';

					if($_FILES['attachmentcommunication'] && $lastid)

					{

						$name = time().$lastid.$_FILES["attachmentcommunication"]['name'];

						



						$upload = $this->account_module->upload_attachments_files('attachmentcommunication', ATTACHMENT_UPLOAD_DIR,$name);

						if($upload){



							$dataatt=array(

												'msg_id'		=>	$lastid,

												'file_name'		=>	$_FILES['attachmentcommunication']['name'],

												'file_size'		=>	$_FILES['attachmentcommunication']['size'],

												'file_mimetype'	=>	$_FILES['attachmentcommunication']['type'],

												'file_saved'	=>	$name



										   );

							$id=$this->account_module->insert_data('communication_attachment',$dataatt);

							if($id)

							$message='Attachement Uploaded';		

							else $message='Attchment couldn\'t  be upload';

						}

						else{

						

							$this->session->set_flashdata('upload_error', $this->upload->display_errors() );

							redirect(site_url('/'.MY_ACCOUNT.'send_message/'.$product_id.'/'.$bidid),'refresh');

					}

					if($lastid)

						{

							$this->session->set_flashdata('success_message', 'Message Sent Successfully.'.$message );

							redirect(site_url('/'.MY_ACCOUNT.'send_message/'.$product_id.'/'.$bidid),'refresh');

						}

						else {

							$this->session->set_flashdata('error_message', 'Error in Message sending.');

							redirect(site_url('/'.MY_ACCOUNT.'bid_details/'.$product_id.'/'.$bidid),'refresh');

						}

				}

			}

		}

			//to make all message seen when viewed
			$this->account_module->update_data('communication',array('ismsgseen'=>'1'),array('product_id'=>$product_id,'bid_id'=>$bidid,'user_id'=>$currentuser));
			$this->data['product_id']=$product_id;

			$this->data['bid_id']=$bidid;
			
			$biddata=$this->account_module->get_data('product_bids',array('id'=>$bidid));
			$this->data['user_id']=$biddata[0]->user_id;
			$this->page_title = 'Bid Detail'.' - '. WEBSITE_NAME;

			$this->data['meta_keys'] = "";

			$this->data['meta_desc'] = "";

		

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('v_buyer_send_message', $this->data);

				}

				catch(Exception $e)

				{

					echo $e->getMessage();

				}

	}



	public function member_profile($user_id=false){

		try{

			if(!$user_id) throw new Exception("Sorry,No user selected", 1);

			$this->data['productwise_rating']=$this->account_module->getproductwiserating($user_id);

			$this->data['user_info']=$this->account_module->get_data('members_details',array('user_id'=>$user_id));

			$this->data['my_rating']=$this->account_module->getoverallrating($user_id);

			$this->data['account_menu_active']="user_profile";

			$this->data['account_title'] = 'User Profile';

			$this->page_title = 'Bid Detail'.' - '. WEBSITE_NAME;

			$this->data['meta_keys'] = "";

			$this->data['meta_desc'] = "";

		

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('v_user_profile', $this->data);

				

				

		}

		catch(Exception $e){

			echo $e->getMessage();

		}

	}



	//for displaying user rating

	public function getrating()

	{

		$touser=$this->input->post('touser');

		$fromuser=$this->input->post('fromuser');

		$productid=$this->input->post('product_id');
		$cond=array(

						'from_user_id'	=>	$fromuser,

						'to_user_id'	=>	$touser,

						'product_id'	=>	$productid

					);

		$memberrate=$this->account_module->get_data('member_rating',$cond);

		if(count($memberrate)>0)

		{

			echo json_encode($memberrate[0]);

		}

		else{

			echo json_encode(array());

		}

	}

	//for saving user rating

	public function saverating(){

		$rate=$this->input->post('rate');

		$comment=$this->input->post('comment');

		$touser=$this->input->post('touser');

		$fromuser=$this->input->post('fromuser');

		$productid=$this->input->post('product_id');

		$date=$this->general->get_local_time('time');

		$cond=array(

						'from_user_id'	=>	$fromuser,

						'to_user_id'	=>	$touser,

						'product_id'	=>	$productid

					);

		$memberrate=$this->account_module->get_data('member_rating',$cond);

		if(count($memberrate)>0){

			$dataarray=array(

						'overall_rating'=>	$rate,

						'comment'		=>	$comment,

						'rating_date'	=>	$date

						);

			$id=$this->account_module->update_data('member_rating',$dataarray,array('rating_id'=>$memberrate[0]->rating_id));	

		}

		else{

					$dataarray=array(

							'from_user_id'	=>	$fromuser,

							'to_user_id'	=>	$touser,

							'product_id'	=>	$productid,

							'overall_rating'=>	$rate,

							'comment'		=>	$comment,

							'rating_date'	=>	$date

						);

				$id=$this->account_module->insert_data('member_rating',$dataarray);

		}

		

		if($id) echo json_encode(array('success'=>'Thank you for your time!'));

		else echo json_encode(array('error'=>'Sorry something went wrong please try once'));

	}



	//get content for chart  to show in auction detail

	public function getbidbyproduct($product_id=false)

	{

		try{

			if(!$product_id) throw new Exception("No product selected", 1);

			$data=$this->account_module->getbidbyproduct($product_id);

			echo $data;

		}

		catch(Exception $e){

			echo $e->getMessage;

		}

	}

	  public function transaction_history($page = false) {
        try {
            // echo '<pre>';
            // print_r($this->account_module->get_data('members'));
            $user_id = $this->session->userdata(SESSION . 'user_id');
            if (!$user_id)
                redirect(site_url('/'));

            $user_type = $this->session->userdata(SESSION . 'usertype');
            if ($user_type == '3')
                $this->data['user_type'] = "buyer";
            if ($user_type == '4')
                $this->data['user_type'] = "supplier";

            $this->data['account_menu_active'] = "transaction_history";
            $this->data['account_title'] = "Transaction History";

            $this->load->library('pagination');
            $config['base_url'] = site_url('/' . MY_ACCOUNT . 'transaction_history');
            $condition = array('user_id' => $user_id, 'transaction_status' => 'Completed');
             $config['total_rows'] = $this->account_module->count_all_data('transaction', $condition);
            $config['per_page'] = 5;
            $config['page_query_string'] = FALSE;
            $config["uri_segment"] = 3;
            $config['num_links'] = 2;
            $this->general->frontend_pagination_config($config);
            $this->pagination->initialize($config);
            if ($this->uri->segment(3)) {
                $page = ($this->uri->segment(3));
            } else {
                $page = 1;
            }
            $this->data['transactions'] = $this->account_module->gettransactionhistory($config["per_page"], $page);
            $this->data["pagination_links"] = $this->pagination->create_links();
            $this->page_title = 'Transaction History' . ' - ' . WEBSITE_NAME;
            $this->data['meta_keys'] = "";
            $this->data['meta_desc'] = "";

            $this->template
                    ->set_layout('general')
                    ->enable_parser(FALSE)
                    ->title($this->page_title)
                    ->build('v_transaction_history', $this->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function changeprofilepicture()
    {
    	$userid=$this->session->userdata(SESSION.'user_id');
    	$response=$this->account_module->change_profile_image($userid);
    	if($response)
    	{
    		$image=$this->account_module->get_data('members_details',array('user_id'=>$userid));
    		$pp= base_url().USER_IMAGE_PATH.$image[0]->cover_image;
    		echo json_encode(array('success'=>'Profile Changed Successfully','finalimg'=>$pp));
    	}
    	else{
    		echo json_encode(array('error'=>$this->upload->display_errors()));
    	}

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

		$this->data['account_title']="Membership Packages";

		$user_id = $this->session->userdata(SESSION.'user_id');

		if(!$user_id) { redirect(site_url('/')); }



		// get my account details		

		if($this->input->server('REQUEST_METHOD')=='POST')

		{

			$this->form_validation->set_rules($this->account_module->validate_package_purchase);
			// echo validation_errors();
			if($this->form_validation->run() === TRUE)

			{
				$this->payment_method_id = $this->input->post('payment_type',TRUE);
			 	 switch($this->payment_method_id)
				 {
					case '1':
								$this->paypal();
								break;
					default:
							 $this->session->set_flashdata('message',"Please choose bid pack & payment method properly.");
							 redirect(site_url('/'.MY_ACCOUNT.'supplier_packages'),'refresh');
							 exit;
				 }

			}
			else{
				redirect(site_url('/'.MY_ACCOUNT.'supplier_packages'),'refresh');
						 exit;
			}

		}
		else{
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
		if(count($this->payment_data)>0)
		{
			//paypal settings			
			$this->load->model('paypal_module');//load paypal module
			$this->data['body'] = $this->paypal_module->set_paypal_form_submit();
			$this->data['wait_msg'] = "<h3>Processing Payment</h3>";

			
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
		
	$status=$this->input->post('payment_status');
	$user_id=$this->session->userdata(SESSION.'user_id');
	$usertype=$this->session->userdata(SESSION.'usertype');
	if($usertype=='3') $this->data['user_type'] = "buyer";
	if($usertype=='4') $this->data['user_type'] = "supplier";

		$this->data['account_title']="Payment Success";
			$this->page_title = 'Payment Successful'.' - '.WEBSITE_NAME;
			$this->data['meta_keys'] = WEBSITE_NAME;
			$this->data['meta_desc'] = WEBSITE_NAME;
			$this->data['status']=$status;
			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)			
				->build('v_buyer_purchase_success', $this->data);	

	}

	

	

	public function paypal_cancel()	//return to this url if pay by paypal is cancelled 
	{
		$usertype=$this->session->userdata(SESSION.'usertype');
		if($usertype=='3') $this->data['user_type'] = "buyer";
		if($usertype=='4') $this->data['user_type'] = "supplier";
		$this->page_title = WEBSITE_NAME. ' - ' .lang('seo_payment_cancelled_page');
		
		$this->data['meta_keys'] = "";
		$this->data['meta_desc'] = "";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('v_transaction_cancel', $this->data);

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