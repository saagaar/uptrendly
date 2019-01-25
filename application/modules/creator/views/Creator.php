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
        	
          	$this->session->set_flashdata('error_message', "Please Login to access this page.");
          	$this->session->set_userdata('redirectToCurrent', current_url());

			redirect(site_url('user/login'),'refresh');exit;
        }
         if($this->session->userdata(SESSION.'usertype')!='4')
        {
          	$this->session->set_flashdata('error_message', "You are not authroized to Access.");
			redirect(site_url('/'),'refresh');exit;
        }

		 //check banned IP address
		$this->general->check_banned_ip();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('creator_model','model');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');		
	}

/*******************For changing Availability option****************/
	public function change_user_availability_option()
	{	
		$status=$this->input->post('availability_status',true);
		$user=$this->session->userdata(SESSION.'user_id');
		$response=$this->general->update_data('members',array('available_status'=>$status),array('id'=>$user));
		if($response)
		{
			if($status=='1')
			{
				echo json_encode(array('success_message'=>'You are Now online.'));
			}
			else
			{
				echo json_encode(array('success_message'=>'You have gone Offline.'));
			}
		}
		else
		{
			echo json_encode(array('error_message'=>'Sorry Something went wrong.Please try again.'));
		}
	}

	public function sponsorship($type='public',$id=false)
	{	
	
        // Return the first view (profile) ID.
		 	$this->data['user_type'] = "creator";	
			$this->data['account_title']="Sponsorship";
			$user_type = $this->session->userdata(SESSION . 'usertype');
      
			$user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='4') redirect(site_url('/'));
			    $mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			    $this->getsocialmedialink();
			    $sponsorships=$this->model->getallsponsorship($type,$id);
				$config['base_url'] = site_url('/'.CREATOR.'/sponsorship/invitation');
				// $condition=array('seller_id'=>$user_id);
				$config['total_rows'] = $this->model->get_all_invitation_count();
				$config['per_page'] = FRONTEND_TABLE_DATA;
				$config['page_query_string'] = FALSE;
				$config["uri_segment"] =4;
				$config['num_links'] = 2;
				$this->general->frontend_pagination_config($config);        
				$this->pagination->initialize($config); 
				if($this->uri->segment(4)){
					$page = ($this->uri->segment(4)) ;
				}
				else{
					$page = 0;
				}    	

			  $invitation=$this->model->get_all_invitation($config["per_page"],$page);
			  $this->data["pagination_links"] = $this->pagination->create_links();
			  // $myproposals=$this->model->getmyproposalsponsor($type,$id);
			  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "sponsorship";
     		  $this->data['account_title'] = 'Sponsorship';
			  $this->data['sponsorships']=$sponsorships;
			  $this->data['invitation']=$invitation;
			  $this->data['views']=$type;
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

			
	// print_r($sponsorships);
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
			$this->data['views']=$type;
			if (!$user_id && $user_type!='4') redirect(site_url('/'));
			$this->data['views']=$type;
			$mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));  
		    $this->data['sponsorships']=$this->model->getallsponsorship($type);
		    $this->data['usermediaassociation']=$mediaassociated;
			echo $this->load->view('creator/ajax-sponsorship',$this->data,true);
	}

	
	public function collaborations($type='public',$id=false){
			$this->data['user_type'] = "creator";	
			$this->load->library('facebook');
			 $this->getsocialmedialink();
			$this->data['fb_url']=$this->facebook->login_url();
			$this->data['account_title']="creator";
			$this->data['views']=$type;
			$user_type = $this->session->userdata(SESSION . 'usertype');
      		$user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='3') redirect(site_url('/'));
			$mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			
			$collaboration=$this->model->getallcollaborationposts($type);
			
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

			$this->getsocialmedialink();
			$user_id = $this->session->userdata(SESSION.'user_id');
			$user_type = $this->session->userdata(SESSION . 'usertype');
			if (!$user_id && $user_type!='4') redirect(site_url('/'));
			$this->data['views']=$type;
			if($this->input->post('viewtype')) $type=$this->input->post('viewtype');
			$mediaassociated=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			$this->data['usermediaassociation']=$mediaassociated;
		    $this->data['collaboration']=$this->model->getallcollaborationposts($type);
			echo $this->load->view('creator/ajax-collab',$this->data,true);
	}
	public function getsocialmedialink(){
		 $this->load->library('Facebook');
         $this->load->library('Instagrams');
         $this->load->library('Google');
         $this->load->library('Twitter');
         $this->load->library('Tumblr');
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
                $twurl=$this->twitter->getLoginUrl(); 
                // $twurl='#';
      else 
        $twurl='#';
      if((defined('YOUTULEE_APP_KEY') && defined('YOUTULEE_APP_SECRET')))
            $ytl_url='#';
       else 
       		 $ytl_url='#';
       if((defined('TUMBLR_APP_KEY') && defined('TUMBLR_APP_SECRET')))
             $tm_url= $this->tumblr->handle_auth();  
       else 
            $tm_url='#';
        $this->data['fb_url']=$fburl;
        $this->data['tw_url']=$twurl;
        $this->data['ins_url']=$insurl;
        $this->data['yt_url']=$yturl;
        $this->data['relogin']=$relogin;
        $this->data['ytl_url']=$ytl_url;
        $this->data['tm_url']=$tm_url;
        return ;
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
	public function getmedialist($productid)
	{
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
	public function ajax_proposal($productid)
	{
		$this->load->model('brand/brand_model');
		$user_id = $this->session->userdata(SESSION.'user_id'); 
		$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
		}
		else
		{
			$data['product_id']=$productid;
			$data['productname']=$check->name;
			$data['proposals']=$this->brand_model->getproposal($productid);
			$response=$this->load->view('ajax_collab_proposal',$data,true);
			echo $response;
		}		
	}

	public function get_draft()
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
	 	$bidid=$this->input->post('bidid');
		$check=$this->general->get_single_row('product_bids',array('id'=>$bidid,'user_id'=>$user_id));
	 	$customlink=$this->general->create_custom_link( $check->product_id,$this->session->userdata(SESSION.'user_id'));
  		$product=$this->general->get_single_row('products',array('id'=>$check->product_id));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the draft'));exit;
		}
		else
		{
				$this->db->where('(draft_accept="0" or draft_accept="2")');
				$query=$this->db->get_where('draft_promotion',array('bid_id'=>$bidid));
				$draft=$query->row();
			
				 $this->db->last_query();
				 if($product->create_type=='campaign')
				 {
				 	if($draft) echo json_encode(array('customlink'=>$customlink,'data'=>$draft));
				 	else echo json_encode(array('customlink'=>$customlink));
				 }
				else
				{
					if($draft) echo json_encode(array('customlink'=>false,'data'=>$draft));
					else echo json_encode(array('customlink'=>false));
				}
		}
	}

	public function send_draft()
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		$this->form_validation->set_rules($this->model->validate_draft);
		if($this->form_validation->run()==TRUE)
		{
				$res=$this->model->send_draft_promotion();
				if($res) echo json_encode($res);
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
			else
			{
				redirect(site_url('/'.MY_ACCOUNT.'buyer_packages'),'refresh');
						 exit;
			}
		}
		else
		{
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


	
	public function campaigns()
	{
			$this->data['user_type'] = "creator";	
			$this->data['account_title']="Creator";
			 $user_type = $this->session->userdata(SESSION . 'usertype');
			 $user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='4') redirect(site_url('/'));
			  $campaigns=$this->model->getuserproduct($user_id);
			 
			  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
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
 
	public function ajax_campaigns()
	{
		  $user_id = $this->session->userdata(SESSION.'user_id');
		  $data['campaigns']=$this->model->getuserproduct($user_id);
		  echo   $this->load->view('ajax_campaign',$data,true);
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
			$image_count=0;
			$image_data = array();
			$response_array = '';
			foreach($_FILES as $key=>$value){
				$image_name = $this->account_module->file_settings_do_upload($key, PRODUCT_IMAGE_PATH_TEMP, 'encrypt');
				if ($image_name['file_name'])
				{
					$this->image_name_path = $image_name['file_name'];
					$image_count++;
				   //push image data into array
				   	array_push($image_data, array('product_code' => $this->input->post('pcodeimg', TRUE), 'image' => $this->image_name_path));
					//now store response in an array.
					$response_array = array('status'=>'success', 'name'=>$this->image_name_path);
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
		$response = array(); 
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$product_id = intval($this->input->post('pid',TRUE));
			$image = $this->input->post('name',TRUE);
			if($product_id && $image){
				$delete = $this->account_module->delete_product_image($product_id, $image);
				if($delete){
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

	function check_date(){

		$current_date = $this->general->get_local_time('time');	
		if($this->input->post('start_date_time',TRUE)<=$current_date){
			$this->form_validation->set_message('check_date', 'Host Auction start date must be greater than current date');
			return FALSE;
		}
		return TRUE;
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

}



/* End of file creator.php */

