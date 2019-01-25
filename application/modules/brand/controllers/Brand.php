	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller 
{
	function __construct() {
		parent::__construct();
		$this->load->library('Ajax_pagination');
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			if(!$this->session->userdata('MAINTAINANCE_KEY') OR $this->session->userdata('MAINTAINANCE_KEY')!='YES')
			{
				redirect(site_url('/maintainance'));exit;
			}
		}
		if(!$this->session->userdata(SESSION.'user_id'))
        {
          	$this->session->set_flashdata('error_message', "Please Login to access this page.");
          	$this->session->set_userdata('redirectToCurrent', current_url());

			redirect(site_url('user/login'),'refresh');exit;
        }
        if($this->session->userdata(SESSION.'usertype')!='3')
        {
          	$this->session->set_flashdata('loginerror', "You are not authroized to Access.");
			redirect(site_url('/'),'refresh');exit;
        }
		$this->general->check_banned_ip();
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('form_validation');
		$this->load->library("pagination");
		$this->load->helper('text');
		$this->load->model('brand_model','model');
		$this->load->model('my-account/account_module');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');		
	}
	public function create_campaign($product_id=false)
	{
		$this->load->library('user_agent');
		if(!$product_id)
		{
			$product_id=$this->input->post('productid');
		}
		$this->load->model('my-account/account_module');
		$this->data['user_type'] = "brand";	
		$this->data['product_id'] = "";	
		$this->data['account_title']="Create Campaign";
		$this->data['mediaassoc']=$this->general->get_socialmedia_channel();
		$user_id = $this->session->userdata(SESSION.'user_id');
		if(!$user_id) { redirect(site_url('/'),'refresh');}	
			if($product_id!='')
			{
				$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$product_id));
				if(count($check)<1)
				{
					$this->session->set_flashdata('error_message', 'You are not authorized to edit the content');
					 redirect($this->agent->referrer());exit;	
				}
				else
				{
					$product=$this->general->getproductbyid($product_id);
					$this->data['product']=$product;
					$this->data['product_id']=$product_id;
				}
			}
		   $this->form_validation->set_rules($this->account_module->validate_campaign_creation);
			if($this->form_validation->run()==TRUE)
			{
				$response = $this->account_module->insert_new_product($product_id);
				if(isset($response['success']))
				{
					if(isset($product_id) && $product_id!='')
					{
						// $this->session->set_flashdata('success_message',)
						echo json_encode(array('success_message'=> "Item Updated Successfully."));exit;
					}
					else
					{
						if(AUCTION_POST_ACTIVATION == '1')
						{
							echo json_encode(array('success_message'=> "Item Added Successfully. It wil be active after admin verification"));exit;
						}
						else
						{
								echo json_encode(array('success_message'=> 'Item Added Successfully.'));	exit;
						}
					}
				}
				else 
				{
						echo json_encode(array('error_message'=> $response['error']));exit;
				}
			}
			  $userdetail=$this->general->get_user_details($user_id);
		 	  $creators=$this->model->getallcreators();
			  $this->data['step']=1;
		   	  $this->data['product_id']=$product_id;
		  	  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "create_campaign";
     		  $this->data['account_title'] = 'brand';
			  $this->data['creators']=$creators;
			  $this->data['userdetail']=$userdetail;	
			  $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_create_campaign', $this->data);
	}
	public function settings($type='general')
	{
		 	$user_type = $this->session->userdata(SESSION . 'usertype');
			$user_id = $this->session->userdata(SESSION.'user_id');
			$this->data['userdetail']=$this->general->get_user_details($user_id);
			 if (!$user_id && ($user_type!=3 || $user_type!=4))
			  redirect(site_url('/'));
			$validationvar='validate_generalsettings';
			if(($this->input->post('formtype')))
			{
				$formtype=$this->input->post('formtype');
				$validationvar='validate_'.$formtype;
			}	
			$this->form_validation->set_rules($this->account_module->{$validationvar});
			if($this->form_validation->run() === TRUE)
			{			
				$res=$this->account_module->{$formtype}();
				echo json_encode($res);exit;	
			}	
			else
			{
				if($user_type=='4')
				{
					  $this->data['userconnection']=$this->general->getusermediaconnectionlist($user_id);
					  $this->getsocialmedialink();
					  $this->data['user_type'] = "creator";	
					  $this->page_title = 'Creator Dashboard' . ' - ' . WEBSITE_NAME;
				}
				if($user_type=='3')
				{
					  $this->data['userconnection']=array('');
					  $this->data['user_type'] = "brand";	
					  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
				}
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
	                ->build('v_settings', $this->data);
			}
			
	}
	public function influencer()
	{
			$this->data['user_type'] = "brand";	
			$this->data['account_title']="creator";
			$user_type = $this->session->userdata(SESSION . 'usertype');
		 	 $user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='3') redirect(site_url('/'));
			  $creators=$this->model->getallcreators();
			  $campaigns=$this->general->get_data('products',array('brand_id'=>$user_id,'status'=>'2'));
			  // $audience_country=$this->general->getmaxcolumn('audience_geography','number_user',array('user_id'=>$user_id));
			  // $audience_demography=$this->model->getaudiencedemography();
			  $this->data['mediaassoc']=$this->general->get_socialmedia_channel();
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
	public function ajax_creators($type='creators',$product_id=false)
	{
			  $this->data['account_menu_active']=$type;
			  $user_type = $this->session->userdata(SESSION . 'usertype');
		 	  $user_id = $this->session->userdata(SESSION.'user_id');
			  if (!$user_id && $user_type!='3') redirect(site_url('/'));
			  $creators=$this->model->getallcreators();
			  $campaigns=$this->general->get_data('products',array('brand_id'=>$user_id,'status'=>'2'));
			  $audience_country=$this->general->getmaxcolumn('audience_geography','number_user',array('user_id'=>$user_id));
			  $this->data['product_id']=$product_id;
			  if($product_id)
			  {
			  	$product=$this->general->getproductbyid($product_id);
				$this->data['product']=$product;
			  }
			  $audience_demography=$this->model->getaudiencedemography();
			  $this->data['creators']=$creators;
			  $this->data['campaigns']=$campaigns;
			  echo $this->load->view('ajax_filter_result_creators',$this->data,true);
	}
	public function inviteuser()
	{
		$data=$this->model->inviteuser();
		echo json_encode($data);
	}
	public function campaigns($type=false)
	{
			$this->data['user_type'] = "brand";	
			$this->data['account_title']="Brand";
			$user_type = $this->session->userdata(SESSION . 'usertype');
			 $user_id = $this->session->userdata(SESSION.'user_id');
			 if (!$user_id && $user_type!='3') redirect(site_url('/'));
			  $campaigns=$this->model->getuserproduct($user_id,$type);
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  if($type!='closed')
			  {
			  	   $this->data['account_menu_active'] = "campaigns";
			  	   $this->general->update_data('notification',array('isnotifyseen'=>'1'),array('user_id'=>$user_id));
			  }
			  else
			  	$this->data['account_menu_active'] = "contents";
     		  $this->data['account_title'] = 'Campaigns';
			  $this->data['campaigns']=$campaigns;

		      $this->data['meta_keys'] = "";
		      $this->data['meta_desc'] = "";
		      $this->template
               	->set_layout('dashboard')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_my_campaigns', $this->data);
	}
	public function ajax_campaigns($type=false)
	{
		  $user_id = $this->session->userdata(SESSION.'user_id');
		  $data['campaigns']=$this->model->getuserproduct($user_id,$type);
		  echo   $this->load->view('ajax_campaign',$data,true);
	}
	public function getproposalbyproduct($productcode,$id=false)
	{
		  $user_id = $this->session->userdata(SESSION.'user_id');
		  $user_type = $this->session->userdata(SESSION . 'usertype');
			
		 $check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'product_code'=>$productcode));
		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
		}else
		{
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
			  $this->data['product_id']=$check->id;
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
			$data['product_code']=$check->product_code;
			$data['productname']=$check->name;
			$data['proposals']=$this->model->getproposal($data['product_code']);

			$userdata=$this->general->get_single_row('members',array('id'=>$user_id));
			$balance=$userdata->balance;
			$data['userbalance']=$balance;
			$response=$this->load->view('ajax_proposal',$data,true);
			echo $response;
		}
				
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
		if($balance>=$bid_amt || $bidamount_paid=='1' || $data->status>=1){
			echo json_encode(array('success_message'=> true));exit;
		}
		else echo json_encode(array('error_message'=> 'You don\'t have enough balance.You will be redirected to payment page in a while'));exit;
	}

	public function payment($amount=false)
	{
	  $user_id = $this->session->userdata(SESSION.'user_id');
  	  $getuser=$this->general->get_user_details($user_id);	
  	  // echo '<pre>';
  	  // print_r($getuser);exit;
  	  if($getuser->country=='' ||  $getuser->identification_no=='' )
  	  {
  	  	$this->session->set_flashdata('error_message','You need to complete billing address and profile to make payment');
  	  	redirect(site_url('/'.MY_ACCOUNT.'settings/address'),'refresh');
  	  }
  	  
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
  	  			if($amount)
  	  			{
  	  				$this->data['amount']=$amount;
  	  			}
  	  		  $this->data['user_type'] = "brand";	
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "campaigns";
     		  $this->data['account_title'] = 'Payments';
			  $this->data['payment_gateway']=$this->general->get_all_payment_gateway();
			  $this->data['balance']=$userbalance;
			  $this->data['country']=$getuser->country;
			  $this->data['tax']=$this->general->get_tax_percent_by_country($this->data['country']);
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
			$this->load->model('brand/paypal_module');//load paypal module
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
			// error_reporting('0');
			if(!$user_id) throw new Exception("Sorry,No user selected", 1);
			
			$this->data['campaigns']=$this->general->get_data('products',array('brand_id'=>$user_id,'status'=>'2'));
			$this->data['user_info']=$this->account_module->get_creator_details($user_id);
			$this->data['creator_expertise']=$this->general->get_data('member_expertise',array('user_id'=>$user_id));
			$this->data['mediadetail']=$this->general->get_data('member_socialmedia',array('user_id'=>$user_id));

			if((!$this->data['user_info']) || (count($this->data['mediadetail'])<1)){
				$this->session->set_flashdata('error_message','No Creator found');
				redirect(site_url('/'.MY_ACCOUNT.'brand'));
			}
			
			$this->data['mediaprofile']=$this->general->get_data('socialmedia_profile',array('user_id'=>$user_id));
			$this->data['profession']=$this->general->get_member_profession($user_id);
			$this->data['user_type'] = "Brand";
			$this->data['account_menu_active']="creator";
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

	public function reports($productid=false)
	{
		try
			{
				error_reporting(E_ALL);

				if(!$productid) throw new exception("Sorry, No Campaign Selected",1);
					$user_id = $this->session->userdata(SESSION.'user_id');
					
					if (!$user_id && $user_type!='3') redirect(site_url('/'));
					$checkuservalidity=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
					// if(count($checkuservalidity)<1) throw new exception("You are not authroized to visit this link",1);
					$reports=$this->model->get_product_report($productid);
					$this->data['objective']=$this->model->get_objective_by_product($productid);
					$this->data['images']=$this->general->get_data('product_images',array('product_id'=>$productid));
					
					$this->data['user_type'] = "brand";	
					$this->data['account_title']="Brand";
					$user_type = $this->session->userdata(SESSION . 'usertype');
					
					  // $campaigns=$this->model->getuserproduct($user_id);
					  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
					  $this->data['account_menu_active'] = "contents";
		     		  $this->data['account_title'] = 'Brand';
					  $this->data['product']=$checkuservalidity;
					  $this->data['product_id']=$productid;
					  $this->data['reports']=$reports;
				      $this->data['meta_keys'] = "";
				      $this->data['meta_desc'] = "";
				      $this->template
		               	->set_layout('dashboard')
		                ->enable_parser(FALSE)
		                ->title($this->page_title)
		                ->build('v_report_details', $this->data);
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('error_message',$e->getMessage());
			    redirect(site_url(BRAND.'campaigns/closed'));
			}
	}

	public function download_reports($productid=false)
	{
		try
			{
				$this->load->library('pdf');

				if(!$productid) throw new exception("Sorry, No Campaign Selected",1);
					$user_id = $this->session->userdata(SESSION.'user_id');
					
					if (!$user_id && $user_type!='3') redirect(site_url('/'));
					$checkuservalidity=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
					// if(count($checkuservalidity)<1) throw new exception("You are not authroized to visit this link",1);
					$reports=$this->model->get_product_report($productid);
					$this->data['objective']=$this->model->get_objective_by_product($productid);
					$this->data['images']=$this->general->get_data('product_images',array('product_id'=>$productid));
				
				
					$user_type = $this->session->userdata(SESSION . 'usertype');
					$this->data['product']=$checkuservalidity;
					$this->data['reports']=$reports;
					$view=$this->load->view('v_report_brand_pdf',$this->data,true);
			    	$this->pdf->downloadpdf('',$view,'');
			    		// $this->pdf->downloadpdf('',$view,'');
			    	// redirect(site_url('/'.CREATOR.'campaigns'));
					
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('error_message',$e->getMessage());
			    redirect(site_url(BRAND.'campaigns/closed'));
			}
	}

	public function get_embed_post()
	{
		$data['mediatype']=$this->input->get('mediatype');
		$data['url']=$this->input->get('url');
		echo $this->load->view('fb_embed_post',$data,true);
	}
	Public function delete_campaign_post($id=false)
	{
		$this->load->library('user_agent');
		try
		{
			
			if(!$id) throw new Exception("No Delete Record Found", 1);
			$this->db->trans_start();
			$this->db->where('id', $id);
			$this->db->delete('products',array('id'=>$id));
			if($this->db->affected_rows()>0)
			{
				$this->db->delete('product_images',array('product_id'=>$id));
				$this->db->delete('product_bids',array('product_id'=>$id));
				$this->db->delete('product_objective',array('product_id'=>$id));
				$this->db->delete('product_socialmedia',array('product_id'=>$id));	
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					if ($this->agent->is_referral())
					{
							$this->session->set_flashdata('error_message','Sorry,Something went wrong.Please try in a while');
					   		 redirect($this->agent->referrer());
					}
					
				}
					
					
					$this->session->set_flashdata('success_message','Campaign Deleted Successfully');
				    redirect($this->agent->referrer());
			}
			
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	public function close_campaign($productid)
	{
		
	}

	public function download_partial_report($bidid)
    {
    	$this->load->library('pdf');
    	
    	$this->data['bid_id']=$bidid;
    	$product=$this->general->get_product_by_bid($bidid);
    	$this->data['type']='download';
    	$this->data['report']=$this->general->get_report($bidid);
    	$this->data['content']=$this->general->get_uploaded_content($bidid);
    	$this->data['product_name']=$product->name;
    	$view=$this->load->view('v_partial_report_pdf',$this->data,true);
    	$this->pdf->downloadpdf('',$view,'S');
    	redirect(site_url('/'.CREATOR.'campaigns'));
    }

}	



