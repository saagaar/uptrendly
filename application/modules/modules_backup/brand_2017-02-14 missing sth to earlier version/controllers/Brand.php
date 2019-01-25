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
			
			  $this->data['user_type'] = "brand";	
			  $this->page_title = 'Brand Dashboard' . ' - ' . WEBSITE_NAME;
			  $this->data['account_menu_active'] = "campaigns";
     		  $this->data['account_title'] = 'Creators';
			  $this->data['proposals']=$proposals;
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
			$response=$this->load->view('ajax_proposal',$data,true);
			echo $response;
		}
				
	}

	public function update_bid_status(){
		$bidid=$this->input->post('bidid');
		$productid=$this->input->post('productid');
		$status=$this->input->post('status');
		$user_id = $this->session->userdata(SESSION.'user_id');
		$check=$this->general->get_single_row('products',array('brand_id'=>$user_id,'id'=>$productid));
		if(count($check)<1)
		{
				echo json_encode(array('error_message'=> 'You are not authorized to alter this proposal'));exit;
		}else{
			$res=$this->general->update_data('product_bids',array('status'=>$status),array('id'=>$bidid));
			// $response=$this->load->view('ajax_proposal',$data,true);
			if($res){
				echo json_encode(array('success_message'=>'Status Updated'));
			}
			else 
				echo json_encode(array('error_message'=>'Update failed'));
		}
	}



	// public function

	

}



