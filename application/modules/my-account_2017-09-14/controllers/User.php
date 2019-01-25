
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User extends CI_Controller 
{
	function __construct() 
	{
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
	public function brand() 
	{
		$user_id = $this->session->userdata(SESSION . 'user_id');
        $user_type = $this->session->userdata(SESSION . 'usertype');
        if (!$user_id && $user_type!='3')  redirect(site_url('/'));
         $datares=$this->account_module->get_all_live_active_sponsorship();
        $this->data['active_sponsor']=$datares['data'];
       
        $this->data['productioncount']=$datares['productioncount'];
        $this->data['completedcount']=$datares['completedcount'];
        $this->data['completedsum']=$datares['completedsum'];
        $this->data['user_type'] = "brand";
        $this->data['account_menu_active'] = "dashboard";
        $this->data['account_title'] = 'Brand Dashboard';
        $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
        $this->data['meta_keys'] = "";
        $this->data['meta_desc'] = "";
        $this->template
                ->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_brand_dashboard', $this->data);
    } 
    public function invoice()
    {
    	$this->load->library('pdf');
    			$data['members']=$this->general->get_user_details(83);
    			$data['site']=$this->general->get_single_row('site_settings');
    			$data['invoice']=135;
    			$data['amount']=2000;
    			$data['transaction']=$this->general->get_single_row('transaction',array('id'=>13));
    	$view=$this->load->view('invoice',$data,true);
		// $this->pdf->WriteHTML($stylesheet,1);
     	// $this->pdf->WriteHTML($view);
		$this->pdf->sendpdf('',$view,'');
		//   // Output a PDF file directly to the browser
		//   $this->pdf->Output();
		   // $this->pdf->WriteHTML('asd');

      // Output a PDF file directly to the browser
      // $this->pdf->Output();
		 
    }

    // CREATORS dashboard
    public function creator() 
    {
        $user_id = $this->session->userdata(SESSION . 'user_id');
        if (!$user_id)
            redirect(site_url('/'.MY_ACCOUNT.'/settings'));
        $datares=$this->account_module->get_all_live_active_sponsorship();
        $this->data['active_sponsor']=$datares['data'];
        $this->data['productioncount']=$datares['productioncount'];
        $this->data['completedcount']=$datares['completedcount'];
        $this->data['completedsum']=$datares['completedsum'];
        
        $this->data['user_type'] = "creator";
        $this->data['account_menu_active'] = "settings";
        $this->data['account_title'] = 'Creator Dashboard';
        $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
        $this->data['meta_keys'] = "";
        $this->data['meta_desc'] = "";
        $this->template
                ->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_creator_dashboard', $this->data);
    }

    public function ajax_dashboard()
    {
	    $user_id = $this->session->userdata(SESSION . 'user_id');
        if (!$user_id)
            redirect(site_url('/'));
        
        $view=$this->input->post('viewtype',true);
        if($view=='creator') $viewfile='ajax_creator';
        if($view=='brand') $viewfile='ajax_brand';

        $datares=$this->account_module->get_all_live_active_sponsorship();
        $data['active_sponsor']=$datares['data'];
        $res=$this->load->view($viewfile,$data,true);
        echo $res;	
    }
	public function settings($type='profile')
	{
		
		 	$user_type = $this->session->userdata(SESSION . 'usertype');
			$user_id = $this->session->userdata(SESSION.'user_id');
			$this->data['userdetail']=$this->general->get_user_details($user_id);
			$this->data['category']=$this->general->get_member_category($user_id);
			$this->data['active_products']=$this->general->get_active_bid_by_user($user_id);
			 if (!$user_id && ($user_type!=3 || $user_type!=4))
			  redirect(site_url('/'));

			if( $user_type=='4' ) $validationvar='validate_general_influencer';
			if($user_type=='3')	$validationvar='validate_general_brand';

			if(($this->input->post('formtype')))
			{
				$formtype=$this->input->post('formtype');
				$validationvar='validate_'.$formtype;
				if( $user_type=='4' && $formtype=='general')
				{
					$validationvar='validate_general_influencer';
				}
				if($user_type=='3'&& $formtype=='general')
				{
					$validationvar='validate_general_brand';
				}	
			}
			
			if($user_type=='4')
			{
				  $this->data['userconnection']=$this->general->getusermediaconnectionlist($user_id);
				  $this->getsocialmedialink();
				  $this->data['user_type'] = "creator";	
				  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
				  $view='v_settings_influencer';
			}
			if($user_type=='3')
			{
				  $this->data['userconnection']=array('');
				  $this->data['user_type'] = "brand";	
				  $view='v_settings_brand';
				  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			}

			$this->form_validation->set_rules($this->account_module->{$validationvar});
			if($this->form_validation->run() === TRUE)
			{			
				
				$res=$this->account_module->{$formtype}();
				echo json_encode($res);exit;	
			}	
			else
			{
			
			$userdetail=$this->general->get_user_details($user_id);
			$allcountry=$this->general->get_all_countries();
			$mediadetail=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));
			$mediaprofile=$this->general->get_data('socialmedia_profile',array('user_id'=>$user_id));
			$this->data['account_title'] = 'Settings';
			$this->data['mediaprofile']=$mediaprofile;
			$this->data['mediadetail']=$mediadetail;
			$this->data['userdetail']=$userdetail;
			$this->data['allcountry']=$allcountry;
			$this->data['account_menu_active'] = "dashboard";
			$this->data['view']=$type;
     		 														
		      $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build($view, $this->data);
			}
			
	}
	public function send_message()
	{
		try{
				// $bidid=$this->input->post('bidid');
				// if((!$bidid)) throw new Exception("Error in data selection", 1);
				$user = $this->session->userdata(SESSION.'user_id');		
				if($this->input->server('REQUEST_METHOD') === 'POST')
				{
					$this->form_validation->set_rules($this->account_module->validate_communication);
					if($this->form_validation->run() == TRUE)
					{
						$data=$this->account_module->send_message();
						echo json_encode($data);
					}
				}
			}
			catch(Exception $e)
			{
					echo $e->getMessage();
			}

	}
	public function getsocialmedialink()
	{
		 
        $relogin='';
    if((defined('FACEBOOK_APP_KEY') && defined('FACEBOOK_APP_SECRET')))
      {
         $this->load->library('Facebook'); 
         $fburl=$this->facebook->login_url();   
         
      }
     else 
          $fburl='#';
     if((defined('INSTAGRAM_APP_KEY') && defined('INSTAGRAM_APP_SECRET')))
     {
       $this->load->library('Instagrams');
       $insurl=$this->instagrams->login_url();
     }       
     else
      	$insurl='#';
	  if((defined('YOUTUBE_APP_KEY') && defined('YOUTUBE_APP_SECRET')))
	   {
	       $this->load->library('Google');
	       $yturl=$this->google->login_url();
	   }
	  else
  	 	 $yturl='#';
      if((defined('TWITTER_APP_KEY') && defined('TWITTER_APP_SECRET')))
      {
        $this->load->library('Twitter');
        $twurl=$this->twitter->getLoginUrl();
      }                
      else 
        $twurl='#';
      if((defined('YOUTULEE_APP_KEY') && defined('YOUTULEE_APP_SECRET')))
            $ytl_url=site_url("user/register/signup_youtulee");
        else 
            $ytl_url='#';
     
    
        if((defined('TUMBLR_APP_KEY') && defined('TUMBLR_APP_SECRET')))
        {
           $this->load->library('Tumblr');
            $tm_url= $this->tumblr->handle_auth();  
        }
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
	public function messages($view='inbox')
	{	


		    $user_id = $this->session->userdata(SESSION.'user_id');
		   if($this->session->userdata(SESSION.'usertype')=='3')
	        {
	        	$this->data['user_type'] = "brand";	
				$this->data['account_title']="brand";
				$user_type = $this->session->userdata(SESSION . 'usertype');
	      		$message=$this->account_module->getmessage($view);
	      		
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "messages";
     		  $this->data['account_title'] = 'Brand';
     		  $this->data['message'] = $message;
     		  $this->data['view'] = $view;
			  $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_all_messages', $this->data);
	        }
	        if($this->session->userdata(SESSION.'usertype')=='4')
	        {
	        	$this->data['user_type'] = "creator";	
				$this->data['account_title']="creator";
				$user_type = $this->session->userdata(SESSION . 'usertype');

	      		$message=$this->account_module->getmessage($view);

			  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "messages";
     		  $this->data['account_title'] = 'Creator';
     		  $this->data['message'] = $message;
     		  $this->data['view'] = $view;
			  $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_all_messages', $this->data);
	        }

	}
	public function ajax_messages($view='inbox')
	{	
		$data['message']=$this->account_module->getmessage($view);
		$data['view']=$view;
		echo $this->load->view('ajax_messages',$data,true);	
	}

	public function Detailmessages($bidid=false)
	{
			try
			{
				if(!$bidid) throw new Exception("Error Processing Request", 1);
				
				 $user_id = $this->session->userdata(SESSION.'user_id');
				 $memberdetail=$this->general->get_single_row('members_details',array('user_id'=>$user_id));
				 $avatar=$this->general->get_profile_image($memberdetail->cover_image);
			   if($this->session->userdata(SESSION.'usertype')=='3')
		        {
		        	$this->data['user_type'] = "brand";	
					$this->data['account_title']="brand";
					$user_type = $this->session->userdata(SESSION . 'usertype');
		      		$messagedetail=$this->account_module->getdetailmessage($bidid);
		      		$this->account_module->makemessageseen($bidid);

				  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
				  $this->data['account_menu_active'] = "messages";
	     		  $this->data['account_title'] = 'Brand';
	     		  $this->data['view']='msgdetail';
	     		  $this->data['bidid']=$bidid;
	     		  $this->data['data'] = $messagedetail;
	     		  $this->data['avatar']=$avatar;
				  $this->data['meta_keys'] = "";
			      $this->data['meta_desc'] = "";
			      $this->template
	               	->set_layout('dashboard')
	                ->enable_parser(FALSE)
	                ->title($this->page_title)
	                ->build('v_all_messages', $this->data);
		        }
		        if($this->session->userdata(SESSION.'usertype')=='4')
		        {
		        	$this->data['user_type'] = "creator";	
					$this->data['account_title']="creator";
					$user_type = $this->session->userdata(SESSION . 'usertype');
		      		$messagedetail=$this->account_module->getdetailmessage($bidid);
		      		$this->account_module->makemessageseen($bidid);
				  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
				  $this->data['account_menu_active'] = "messages";
	     		  $this->data['account_title'] = 'Creator';
	     		  $this->data['view']='msgdetail';
	     		  $this->data['data'] = $messagedetail;
	     		  $this->data['avatar']=$avatar;
	     		  $this->data['bidid']=$bidid;
				  $this->data['meta_keys'] = "";
			      $this->data['meta_desc'] = "";
			      $this->template
	               	->set_layout('dashboard')
	                ->enable_parser(FALSE)
	                ->title($this->page_title)
	                ->build('v_all_messages', $this->data);
		        }	
			}
			catch(exception $e){
				// echo $this->session->set_flashdata('error','No proposal')
				echo json_encode(array('error_message' =>'No chat history Found'));
			}
		  
	}
	public function getdetailmessage($bidid)
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		$memberdetail=$this->general->get_single_row('members_details',array('user_id'=>$user_id));
	 	$avatar=$this->general->get_profile_image($memberdetail->cover_image);
		$value['data']=$this->account_module->getdetailmessage($bidid);
		$value['bidid']=$bidid;	
		$value['avatar']=$avatar;
		$this->account_module->makemessageseen($bidid);
		echo $this->load->view('message_detail',$value,true);
	}
	public function reportuser()
	{
		try
		{
			if(!$this->input->post('bidid')) throw new Exception("Some error Occured.Please Reload and try again in a while", 1);
			$bidid=$this->input->post('bidid',true);
			$userid=$this->session->userdata(SESSION.'user_id');
			$product=$this->general->get_product_by_bid($bidid);
			$getuser=$this->general->get_single_row('product_bids',array('id'=>$bidid));
			if((count($product))>0)
			{
				$brand_id=$product->brand_id;
				if($userid==$brand_id)
				{
					$reporterid=$userid;
					$offenderid=$getuser->user_id;
					$title=$this->input->post('title',true);
					$message=$this->input->post('message',true);
					$checksend=$this->general->get_data('reportuser',array('bid_id'=>$bidid,'reporterid'=>$reporterid,'offenderid'=>$offenderid));
					if(count($checksend)>0)
					{
						throw new Exception('You have already reported this user');
					}
					$data=array(	
									'reporterid'			=>		$reporterid,
									'offenderid'			=>		$offenderid,
									'title'					=>		$title,
									'description'			=>		$message,
									'bid_id'				=>		$bidid,
									'report_date'			=>		$this->general->get_local_time('time')
						        );
					$id=$this->general->insert_data('reportuser',$data);
					if($id)
						echo json_encode(array('success_message'=>'Report submitted to admin'));
					else echo json_encode(array('error_message'=>'Error in Report Submission'));
				}
				else 
				{
					
					if($getuser->user_id==$userid)
					{
						$reporterid=$userid;
						$offenderid=$brand_id;
						$title=$this->input->post('title',true);
						$message=$this->input->post('message',true);
						$checksend=$this->general->get_data('reportuser',array('bid_id'=>$bidid,'reporterid'=>$reporterid,'offenderid'=>$offenderid));
						if(count($checksend)>0){
							throw new Exception('You have already reported this user');
						}
						$data=array(	
										'reporterid'			=>		$reporterid,
										'offenderid'			=>		$offenderid,
										'title'					=>		$title,
										'description'			=>		$message,
										'bid_id'				=>		$bidid
							        );
						$id=$this->general->insert_data('reportuser',$data);
						if($id)
							echo json_encode(array('success_message'=>'Report submitted to admin'));
						else echo json_encode(array('error_message'=>'Error in Report Submission'));
					}
					else
					{
						throw new Exception('You are not allowed to report this user');
					}
				}
						
			}else{
				throw new Exception('You are not authorized to report this user');
			}
			
		}
		catch(exception $e){
			echo json_encode(array('global_error'=>$e->getMessage()));
		}
	}

	public function gettrackid()
	{
		$bidid=$this->input->post('bidid');
		$check=$this->general->get_single_row('draft_promotion',array('bid_id'=>$bidid,'draft_accept'=>'1'));
		if((count($check))<1)
		{
			echo json_encode(array('error_message'=>'You are Not authorized to perform the action'));exit;
		}
		else
		{
				$data=$this->general->get_single_row('product_bids',array('id'=>$bidid));
				if((count($data)>0)){
					$trackid=$data->socialtrackid;
					if($trackid!=NULL){
						echo json_encode(array('success_message'=>'Data received','trackid'=>$trackid));
					}else{
						echo json_encode(array('success_message'=>'Data received','trackid'=>''));
					}
				}
				else{
					echo json_encode(array('error_message'=>'Something Went wrong,Please try again in a while'));
				}
		}
		
	}
	public function savetrackid()
	{
		$bidid=$this->input->post('bidid');
		$trackid=$this->input->post('socialmediaid');
		$check=$this->general->get_single_row('draft_promotion',array('bid_id'=>$bidid,'draft_accept'=>'1'));
		$this->db->select('p.*,pb.socialtrackid');
		$this->db->from('product_bids pb');
		$this->db->join('products p','p.id=pb.product_id');
		$this->db->where('pb.id',$bidid);
		$query=$this->db->get();
		$data=$query->row();
		$date=$this->general->get_local_time('time');
		$brandid=$data->brand_id;
		if((count($check))<1)
		{
			echo json_encode(array('error_message'=>'You are Not authorized to perform the action'));exit;
		}
		if($data->socialtrackid=='')
		{
			$id=$this->general->update_data('product_bids',array('socialtrackid'=>$trackid,'upload_date'=>$date),array('id'=>$bidid));	
		}else
		{
			$id=$this->general->update_data('product_bids',array('socialtrackid'=>$trackid),array('id'=>$bidid));	
		}

		if($id)
		{
			if($data->create_type=='campaign')
			{
				$proposalurl=site_url('/'.BRAND.'getproposalbyproduct/'.$data->product_code);
			}else{
				$proposalurl=site_url('/'.CREATOR.'getproposalbyproduct/'.$data->product_code);

			}
				
				$notifymsg='The draft has been uploaded to respective social media for post <a href="'.$proposalurl.'">'.$data->name.' </a>.Verify the upload from proposal list';
				$this->general->savethisasnotification($brandid,$notifymsg);
			echo json_encode(array('success_message'=>'Track id has been saved successfully'));
		}
		else{
			echo json_encode(array('error_message'=>'Something went wrong,Please try again in a while'));
		}
	}
	public function contents()
	{
			$user_id = $this->session->userdata(SESSION.'user_id');
			$user_type = $this->session->userdata(SESSION . 'usertype');
			if($user_type==3)
			{
				$this->data['user_type'] = "brand";	
				$this->data['account_title']="Brand|Contents";
				$this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			}
			elseif($user_type==4)
			{
				$this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
				$this->data['user_type'] = "creator";	
				$this->data['account_title']="influencer|Contents";
			}
			else{
				redirect(site_url('/'));
			}
      
			$user_id = $this->session->userdata(SESSION.'user_id');
			$reports=$this->account_module->get_all_reports();
			$this->data['reports']=$reports;
			$this->data['account_menu_active'] = "contents";
			  $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_reports', $this->data);
	}

	public function ajax_report()
	{
		$reports=$this->account_module->get_all_reports();
		$this->data['reports']=$reports;
		echo $this->load->view('ajax_report',$this->data,true);
	}
	public function download_report()
    {
    	$this->load->library('pdf');
    	$reports=$this->account_module->get_all_reports();
    	$this->data['reports']=$reports;
    	$view=$this->load->view('ajax_report',$this->data,true);
    	$this->pdf->downloadpdf('',$view,'');
    	redirect(site_url('/'.MY_ACCOUNT.'contents'));
    }
	public function getmediabyproduct($product_id)
	{
		$socialmediaid=$this->general->get_data('product_socialmedia',array('product_id'=>$product_id));
		foreach ($socialmediaid as $key => $value) {
			$media[]=$value->socialmedia_id;
		}
		if(count($media)>0)
		{
			echo json_encode($media);
		}
		else
		{
			echo json_encode('error_message','No product media found');
		}
		
	}
	public function getproductbyid($product_id)
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		if($product_id){	
			$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$product_id));
			if(count($check)<1)
			{
				echo json_encode(array('error_message'=> 'You are not authorized to edit the content'));exit;
			}
			else
			{
				$data=$this->account_module->getproductbyid($product_id);
				if(count($data)>0)
				{
					echo json_encode($data);exit;
				}
				else
				{
					echo json_encode(array());exit;
				}
			}
		}
		echo json_encode(array('error_message'=> 'No Product selected'));
	}

	public function accept_reject_brand_request()
	{
		$bidid=$this->input->post('bidid');
		$productid=$this->input->post('productid');
		$status=$this->input->post('status');
		$user_id = $this->session->userdata(SESSION.'user_id');
		$creatorname=$this->session->userdata(SESSION.'first_name').' '.$this->session->userdata(SESSION.'last_name');
		$productdetail=$this->general->get_single_row('products',array('id'=>$productid));
		$productbid=$this->general->get_single_row('product_bids',array('id'=>$bidid,'user_id'=>$user_id));
		$notifymsg=false;
		if(count($productbid)<1)
		{

				echo json_encode(array('error_message'=> 'You are not authorized to alter this proposal'));exit;
		}else
		{
			$this->db->trans_start();
			$res=$this->general->update_data('product_bids',array('status'=>$status),array('id'=>$bidid));
		
				
					$this->db->trans_complete();
						$memberpropsender=$this->general->get_single_row('members',array('id'=>$productdetail->brand_id));
						
						$notifymsg='Influencer '.$creatorname.' has accepted your request to promote campaign'.$productdetail->name;
						$productbidnew=$this->general->get_single_row('product_bids',array('id'=>$bidid));
							if($productbid->status=='0' && $productbidnew->status=='1')
							{
								$parseElement=array(
												'USERNAME'				=>		$memberpropsender->username,
												'PRODUCT_NAME' 			=>		$productdetail->name,
												'DESCRIPTION'			=>		$productdetail->description,
												'SITENAME'				=>		WEBSITE_NAME,
												'CREATOR'				=>		$this->session->userdata(SESSION.'fullname'),
												'EMAIL'					=>		$memberpropsender->email
									);
								$template_code='bid_proposal_accepted';
								$from=SYSTEM_EMAIL;
								$to=$memberpropsender->email;
								$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
							$this->general->savethisasnotification($productdetail->brand_id,$notifymsg,$productid);
							}
							if($productbid->status=='0' && $productbidnew->status=='4')
							{
								$parseElement=array(
												'USERNAME'				=>		$memberpropsender->username,
												'PRODUCT_NAME' 			=>		$productdetail->name,
												'DESCRIPTION'			=>		$productdetail->description,
												'SITENAME'				=>		WEBSITE_NAME,
												'CREATOR'				=>		$this->session->userdata(SESSION.'fullname'),
												'EMAIL'					=>		$memberpropsender->email
									);
								$notifymsg='Influencer '.$creatorname.' has rejected your request to promote campaign'.$productdetail->name;
						
								
								$template_code='bid_proposal_rejected';
								$from=SYSTEM_EMAIL;
								$to=$memberpropsender->email;
								$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
								$this->general->savethisasnotification($productdetail->brand_id,$notifymsg,$productid);
							}
				
				
				
					$this->db->trans_complete();
					if ($this->db->trans_status() !== TRUE)
					{
						$res=false;
					}
				
			//send email to user
			// $template_id='';
			// $response=$this->load->view('ajax_proposal',$data,true);
			if($res){
				$this->session->set_flashdata('success_message','Status Updated');
				echo json_encode(array('success_message'=>'Status Updated'));
			}
			else{
				$this->session->set_flashdata('error_message','Status Update failed');
				echo json_encode(array('error_message'=>'Update failed'));
			} 
		}	
		
	}

	public function update_bid_status()
	{
		$bidid=$this->input->post('bidid');
		$productid=$this->input->post('productid');
		$status=$this->input->post('status');
		$user_id = $this->session->userdata(SESSION.'user_id');
		$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
		$productbid=$this->general->get_single_row('product_bids',array('id'=>$bidid));
		$notifymsg=false;
		if((count($check))<1)
		{

				echo json_encode(array('error_message'=> 'You are not authorized to alter this proposal'));exit;
		}else{
			$this->db->trans_start();
			$res=$this->general->update_data('product_bids',array('status'=>$status),array('id'=>$bidid));
			
			if($productbid->status=='0' && isset($res))
			{
				$uid=$productbid->user_id;
				//for maintaining transaction since to select proposal for campaign brand must  pay creator
				if($check->create_type=='campaign')
				{
					$res=$this->general->update_data('product_bids',array('bidamount_paid'=>'1'),array('id'=>$bidid));
					$post='Campaign post';
					$cond=array('id'=>$user_id);
					$this->db->set('balance', 'balance-'.$productbid->user_bid_amt, FALSE);
					$this->db->where($cond);
					$this->db->update('members');
					 $this->db->last_query();
					$member=$this->general->get_single_row('members',array('id'=>$user_id));
					$curbalance=$member->balance;
					$transval=array(	
										'user_id'			=>		$user_id,
										'product_id'		=>		$productid,
										'amount'			=>		$productbid->user_bid_amt,
										'credit_debit'		=>		'DEBIT',
										'transaction_name'	=>		'Deduct Balance for Accepting Proposal of '.DEFAULT_CURRENCY_SIGN.' '.$productbid->user_bid_amt,
										'transaction_date'	=>		 $this->general->get_local_time('time'),
										'transaction_type'	=>		 'bidaccept_amount',
										'transaction_status'=>		 'Completed',
										'payment_method'	=>		 'Direct',
										'current_balance'	=>		 $curbalance,
										'currency'			=>		 DEFAULT_CURRENCY_CODE
									);
					$this->general->insert_data('transaction',$transval);
					$url=site_url('/creator/sponsorship/my-proposal');
				}
				else 
					{
						$post='Collab Post';
						$url=site_url('/creator/collaborations/my-proposal');
					}
				$notifymsg='<a href="'.$url.'"> You have been selected for '.$post.' '.$check->name. 'Now you can submit a draft of promotion</a>';
			$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE){
					if($notifymsg)
					{
						$memberpropsender=$this->general->get_single_row('members',array('id'=>$uid));
						$productbidnew=$this->general->get_single_row('product_bids',array('id'=>$bidid));
							if($productbid->status=='0' && $productbidnew->status=='1')
							{
								$parseElement=array(
												'PRODUCT_NAME' 			=>		$check->name,
												'DESCRIPTION'			=>		$check->description,
												'SITENAME'				=>		WEBSITE_NAME,
												'EMAIL'					=>		$memberpropsender->email
									);
								$template_code='bid_proposal_accepted';
								$from=SYSTEM_EMAIL;
								$to=$memberpropsender->email;
								$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
								$this->general->savethisasnotification($uid,$notifymsg);
							}
							if($productbid->status=='0' && $productbidnew->status=='4')
							{
								$parseElement=array(
												'PRODUCT_NAME' 			=>		$check->name,
												'DESCRIPTION'			=>		$check->description,
												'SITENAME'				=>		WEBSITE_NAME,
												'EMAIL'					=>		$memberpropsender->email
									);
								$notifymsg='You have been Rejected for '.$post.' '.$check->name. 'Now you can check email for more Information.';
								$template_code='bid_proposal_rejected';
								$from=SYSTEM_EMAIL;
								$to=$memberpropsender->email;
								$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
								$this->general->savethisasnotification($uid,$notifymsg);
							}
					}
				}
				}
				else
				{
					$this->db->trans_complete();
					if ($this->db->trans_status() !== TRUE){
						$res=false;
					}
				}
			//send email to user
			// $template_id='';
			// $response=$this->load->view('ajax_proposal',$data,true);
			if($res){
				$this->session->set_flashdata('success_message','Status Updated');
				echo json_encode(array('success_message'=>'Status Updated'));
			}
			else{
				$this->session->set_flashdata('error_message','Status Update failed');
				echo json_encode(array('error_message'=>'Update failed'));
			} 
				
		}
	}

	public function update_notification_toseen()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$cond=array('user_id'=>$userid,'isnotifyseen'=>'0');
		$data=array('isnotifyseen'=>'1');
		$id=$this->general->update_data('notification',$data,$cond);
		echo json_encode(array('success_message'=>'All notification is set seen'));
		exit;

	}	
	function redirect_custom_link($brandname,$product_id,$product_name)
	{
		// $member=$this->general->get_single_row('members',array('username'=>$username));
		// $userid=$member->id;
		$product=$this->general->get_single_row('products',array('id'=>$product_id));
		$producturl=$product->product_url;
		if (preg_match('/^(http(s)?:\/\/)/',$producturl)==1) 
		{
   				redirect($producturl);
		}
		else{
			redirect('http://'.$producturl);
		}
	}

	
	public function saveprofileurl(){
		try
		{
			$response=$this->account_module->saveprofile();
			if($response)
				echo json_encode(array('success_message'=>'Profile saved successfully'));
			else echo json_encode(array('error_message'=>'Nothing to Update'));
		}
		catch(Exception $e)
		{
			echo json_encode(array('error_message'=>$e->getMessage()));
		}
		
	}
	public function acceptreject_draft()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$bidid=$this->input->post('bidid',true);
		$draftid=$this->input->post('draftid',true);
		$btnval=$this->input->post('btnval',true);
		$this->db->select('p.id,pb.user_id,p.name,p.product_code');
		$this->db->from('products p');
		$this->db->join('product_bids pb','p.id=pb.product_id');
		$this->db->where('p.brand_id',$userid);
		$this->db->where('pb.id',$bidid);
		$query=$this->db->get();
		$data=$query->row();
		$user=$data->user_id;
		$member=$this->general->get_single_row('members',array('id'=>$user));
		$email=$member->email;
		$this->db->trans_start();
		if((count($data))>0) {
			if($btnval=='accept') $info='1';
			else $info='2';
			$cond=array('bid_id'=>$bidid,'id'=>$draftid);
			$id=$this->general->update_data('draft_promotion',array('draft_accept'=>$info),$cond);
			$productname=$data->name;
			$draft=$this->general->get_single_row('draft_promotion',array('id'=>$draftid));
			$parseElement=array(
											'PRODUCT_NAME' 			=>		$productname,
											'DESCRIPTION'			=>		$draft->description,
											'LINK'					=>		$draft->link,
											'SITENAME'				=>		WEBSITE_NAME,
											'EMAIL'					=>		$email
								);
				if($info==1){
					$this->db->trans_complete();
					if ($this->db->trans_status() === false)
					{
						$this->db->trans_rollback();
						echo json_encode( array('error_message'=>'Some error has occured,Please try again in a while'));exit;
					}
					$template_code='draft_accepted';
					$from=SYSTEM_EMAIL;
					$to=$email;
					
					$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
					$notifymsg='Your draft of promotion for the campaign '.$productname.' has been accepted,Upload the content to social media.Please check email';
					$this->general->savethisasnotification($user,$notifymsg);
					echo json_encode( array('success_message'=>'Draft has been Accepted'));exit;
				}			
				else 
				{
					if ($this->db->trans_status() === false)
					{
						$this->db->trans_rollback();
						echo json_encode( array('error_message'=>'Some error has occured,Please try again in a while'));
					}
					$template_code='draft_rejected';
					$from=SYSTEM_EMAIL;
					$to=$email;
					$id=$this->general->update_data('product_bids',array('status'=>'2'),array('id'=>$bidid));
					$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
					$notifymsg='Your draft of promotion for the campaign '.$productname.' has been rejected.Please check email';
					$this->general->savethisasnotification($user,$notifymsg);
					echo  json_encode(array('success_message'=>'Draft has been Rejected'));exit;
				} 
			// }
			// else {
			// 	return array('error_message'=>'Some error occured,Please try again in a while');
			// }
		
		}
		else {
			echo json_encode(array('error_message'=>'You are not authroized to perform the operation'));
		}
	}

	public function acceptreject_Upload()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$bidid=$this->input->post('bidid',true);
		$btnval=$this->input->post('btnval',true);
		$this->db->select('p.id,pb.user_id,p.name,p.create_type,pb.user_bid_amt');
		$this->db->from('products p');
		$this->db->join('product_bids pb','p.id=pb.product_id');
		$this->db->where('p.brand_id',$userid);
		$this->db->where('pb.id',$bidid);
		$query=$this->db->get();
		$data=$query->row();
		$brand=$userid;
		$creator=$data->user_id;
		$member=$this->general->get_single_row('members',array('id'=>$creator));
		$email=$member->email;
		$bid_fee=$data->user_bid_amt;
		$this->db->trans_start();
		if((count($data))>0) {
			if($btnval=='yes') $info='1';
			else $info='2';
			$cond=array('id'=>$bidid);
			if($info==1)
			{
				$typepost=$data->create_type;
				if($typepost=='campaign')
				{
					
				
					/* Add the balance to creator where 10% commision is given to site*/
					$commission=COMMISSION_PERCENT*$bid_fee/100;
					$creatorpayment=$bid_fee-$commission;
					$this->db->set('balance', 'balance+'.$creatorpayment, FALSE);
					$this->db->where(array('id'=>$creator));
					$this->db->update('members');
					$creatorbalance=$this->general->get_single_row('members',array('id'=>$creator));
					/*Manage transaction as credit for creator payment*/
					$transval=array(	
										'user_id'			=>		$creator,
										'product_id'		=>		$data->id,
										'amount'			=>		$creatorpayment,
										'credit_debit'		=>		'CREDIT',
										'transaction_name'	=>		'Pay for won Campaign Bid '.DEFAULT_CURRENCY_SIGN.' '.$bid_fee,
										'transaction_date'	=>		 $this->general->get_local_time('time'),
										'transaction_type'	=>		 'payment_for_task_completion',
										'transaction_status'=>		 'Completed',
								   		'commission'   		=>		 $commission,
										'payment_method'	=>		 'Direct',
										'current_balance'	=>		 $creatorbalance->balance,
										'currency'			=>		 DEFAULT_CURRENCY_CODE
									);
					$this->general->insert_data('transaction',$transval);
					/*Update status of completed*/
					$id=$this->general->update_data('product_bids',array('status'=>'7'),$cond);
					$wonproductarr=array(
											'user_id'			=>		$creator,
											'product_id'		=>		$data->id,
											'bid_id'			=>		$bidid,
											'won_amount'		=>		$creatorpayment,
											'product_close_date'=>		$this->general->get_local_time('time'),
											'payment_status'	=>	    'Incomplete'
										);
					$this->general->insert_data('product_winner',$wonproductarr);

					// $this->general->savethisasnotificationforadmin()
				
				}
				else
				{
					$id=$this->general->update_data('product_bids',array('status'=>'7'),$cond);
				}
			}
			
			$productname=$data->name;
			$parseElement=array(
											'PRODUCT_NAME' 			=>		$productname,
											'SITENAME'				=>		WEBSITE_NAME,
											'WINNERID'				=>		$creator,
											'EMAIL'					=>		$email,
											'WINNERID'				=>		$creator,
											'PAY_AMOUNT'			=>		$bid_fee
								);
			// if($id){
				if($info==1){
					$this->db->trans_complete();
					if ($this->db->trans_status() === false)
					{
						$this->db->trans_rollback();
						echo json_encode( array('error_message'=>'Some error has occured,Please try again in a while'));
					}
					$template_code='promotion_complete';
					$from=SYSTEM_EMAIL;
					$to=$email;
					
					if(isset($bid_fee) && $bid_fee>0)
					{
						$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
						$notifymsg='<a class="no-style" href="'. site_url('/'.MY_ACCOUNT.'transaction_history').'"> Your Promotion for the campaign <b>'.$productname.' </b> has been completed,You have received a payment of '.DEFAULT_CURRENCY_CODE.' '.$bid_fee.'to your account</a>';
						/*Admin notification*/
						$template_code='promotion_completed_admin';
						$from=SYSTEM_EMAIL;
						$to=CONTACT_EMAIL;
						$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
						$this->general->savethisasnotificationforadmin('Promotion for campaign: <b>'.$productname.' </b> for bid fee '.$bid_fee.' is completed.');
				}else
				{
					$this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
					$notifymsg='Your Promotion for the campaign <b>'.$productname.'</b> has been completed.';
				}
					
					$this->general->savethisasnotification($creator,$notifymsg);
					echo json_encode( array('success_message'=>'Promotion is completed'));
				}			
				else 
				{
					if ($this->db->trans_status() === false)
					{
						$this->db->trans_rollback();
						echo json_encode( array('error_message'=>'Some error has occured,Please try again in a while'));
					}
					// $template_code='draft_rejected';
					// $from=SYSTEM_EMAIL;
					// $to=$email;
					// $id=$this->general->update_data('product_bids',array('status'=>'2'),array('id'=>$bidid));
					// $this->notification->send_email_notification($template_code, '', $from, $to, '', '', $parseElement, array());
					$notifymsg='Your Uploaded content is rejected by Brand for <b>'.$productname.'</b>.Please check and consult brand and in case of dispute report user';
					$this->general->savethisasnotification($creator,$notifymsg);
					echo  json_encode(array('success_message'=>'Promotion Upload is not accepted'));
				} 
			// }
			// else {
			// 	return array('error_message'=>'Some error occured,Please try again in a while');
			// }
		
		}
		else {
			echo json_encode(array('error_message'=>'You are not authroized to perform the operation'));
		}
	}

	  public function transaction_history($page = false) {
        try {
         
            $user_id = $this->session->userdata(SESSION . 'user_id');
            if (!$user_id)
                redirect(site_url('/'));

            $user_type = $this->session->userdata(SESSION . 'usertype');
           if($user_type=='4'){
				// echo 'wewe';
				 
				  $this->getsocialmedialink();
				  $this->data['user_type'] = "creator";	
				  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
			}
			if($user_type=='3')
			{
				 
				  $this->data['user_type'] = "brand";	
				  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			}
            $this->data['account_menu_active'] = "transaction_history";
            $this->data['account_title'] = "Transaction History";
            $this->load->library('pagination');
            $config['base_url'] = site_url('/' . MY_ACCOUNT . 'transaction_history');
            $condition = array('user_id' => $user_id, 'transaction_status' => 'Completed');
             $config['total_rows'] = $this->general->count_all_data('transaction', $condition);
            $config['per_page'] = FRONTEND_TABLE_DATA;
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
                    ->set_layout('dashboard')
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
			$this->breadcrumbs->push('Purchase Product', '/'); //second parameter is link
			$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
			$this->data['product_id'] = $product_id;
			$this->data['static_field'] = $this->general->get_product_static_fields_data();
			$this->data['product'] = $this->account_module->get_product_details_by_id_for_purchase($product_id);
			$this->data['address'] = $this->account_module->get_members_mailing_address($this->data['user_id']);
			$this->data['countries'] = $this->general->get_all_countries();
			$this->data['payment_gateways'] = $this->account_module->get_all_active_payment_gateways();
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
		$post_meta_field_params_arr = explode('#', $post_meta_field_params);
		$post_meta_field_id = $post_meta_field_params_arr[0];
		$filename = $_FILES['metafile_'.$post_meta_field_id]['name'];
		$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
		if($file_ext=='docx' OR $file_ext=='xlsx'){
			$file_ext = substr($file_ext, 0, -1);
		}
		//now remove first array index (both key and value) so that remainig array is only array of extensions.
		array_shift($post_meta_field_params_arr);
		if(in_array($file_ext,$post_meta_field_params_arr))
		{
		return TRUE;			
		}
		else
		{
			$this->form_validation->set_message('_check_file_extension', 'Invalid File Uploaded.');
			return FALSE;
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
}

