
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Admin extends CI_Controller {



	function __construct() 

	{

		parent::__construct();
		if (!$this->general->admin_logged_in())
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('pagination');
		$this->load->model('admin_product_model');
		$this->load->helper('editor_helper');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}	

	public function index($status = 'all')
	{
		$this->data['current_menu'] = 'all_product';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-product', $this->admin_permissions)):
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/product/index/'.$status);
			$config['total_rows'] = $this->admin_product_model->count_total_products($status);
			$config['per_page'] = ADMIN_PRODUCT_LIST_PERPAGE;
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 5;
			$this->general->get_pagination_config($config);            

			$this->pagination->initialize($config); 

			

			$offset = $this->uri->segment(5,0);            

			$this->data['product_data'] = $this->admin_product_model->get_product_lists($status,$config["per_page"],$offset);

			

			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);

			

			$this->template

				->set_layout('admin_dashboard')

				->enable_parser(FALSE)

				->title(WEBSITE_NAME.'- Product View')

				->build('a_view_product', $this->data);

		

		else:

			$this->template->set_layout('admin_dashboard')

				->enable_parser(FALSE)

				->title(WEBSITE_NAME.' - Admin Panel - Product Management')

				->build('administrator-denied', $data);



        endif;

	}

	public function activate_product($product_id)
	{
		if($product_id=='' OR $product_id==0 OR $product_id =='0' OR !is_numeric($product_id)){

			redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');

		}

	}

	//edit product 

	public function edit_product($product_id='')

	{

		

		if($product_id=='' OR $product_id==0 OR $product_id =='0' OR !is_numeric($product_id)){

			redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');

		}

		$data = array();

		$data['admin_permissions'] = $this->admin_permissions;

		if(array_key_exists('edit_product', $this->admin_permissions))

		{

		

			$this->data['current_menu'] = 'edit_product';

			$this->data['custom_field_html'] = '';

			$this->data['job'] = 'edit';

			$this->data['currencies'] = $this->general->fetch_all_currency();
			$this->data['price_range']=$this->general->get_price_range();

			// $this->data['time_zones'] = $this->general->get_all_timezones();

			

			//get product data

			$this->data['product']=$this->admin_product_model->get_product_byid($product_id);

			//if there is no product id in url, then redirect to inventory page

			if($this->data['product']=='' OR $this->data['product']==false OR empty($this->data['product'])){

				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');

			}

			$this->data['socialmedia']=$this->general->get_product_media($product_id);
		

			//store product code in local variable

			$this->data['product_code'] = $this->data['product']->product_code;

			//echo $this->data['product_code']; exit;

		

			//now get images in this product

			$this->data['product_images']=$this->admin_product_model->get_product_images_by_product_id($product_id);
				$this->data['category_tree'] = $this->general->get_category_tree();
				if($this->input->post('category',TRUE) && $this->input->post('category',TRUE)!=''){
					$this->data['cat_id'] = $this->input->post('category',TRUE);
				}else{
					$this->data['cat_id'] = $this->data['product']->sub_cat_id!=0?$this->data['product']->sub_cat_id:$this->data['product']->cat_id;
				}

				//get category name by its id
				$this->data['categoryName'] = $this->general->get_product_category_name_by_id($this->data['cat_id']);
				if($this->input->post('create_type')=='campaign'){
					$this->form_validation->set_rules($this->admin_product_model->validate_product_campaign);
				}else{
					$this->form_validation->set_rules($this->admin_product_model->validate_product_collab);
				}
			if($this->form_validation->run()==TRUE)
			{
				$categories[] = $this->input->post('category',TRUE);
				//update product records
				 $updatestatus=$this->input->post('status');
				$trans = $this->admin_product_model->update_product($product_id, $this->data['product']->status);
				if($trans)
				{
				$this->admin_product_model->send_email_notification_tobuyer($product_id,$updatestatus);
				if($updatestatus=='2')
				{
					$auctiontype=$this->input->post('auction_type');
					if($auctiontype=='1')
					{

						//here

						$parseElement = array(

								'description' 		=> $this->input->post('description', TRUE),

								"product_name"		=> $this->input->post('name',true),

								"auc_start_time"	=> $this->input->post('auction_start_time', TRUE),

								"auc_end_days"		=> $this->input->post('auc_end_days', TRUE),

								"product_url"		=> site_url('my-account/auction_detail/'.$product_id),

								"budget"			=> $this->input->post('price', TRUE),

								"SITENAME"			=> WEBSITE_NAME,

								"message"			=> ' '

						);

						$this->send_email_notification_to_public($categories,$parseElement);



	

					}

				}

				// if

					if(LOG_ADMIN_ACTIVITY == 'Y'){

						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Updated', 'action' => 'Edit', 'extra_info' => 'Product id: '.$product_id));

					}

					$this->session->set_flashdata('message','Product records updated successfully.');

				}

				else

				{

					if(LOG_ADMIN_ACTIVITY == 'Y'){

						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Update Product', 'action' => 'Edit', 'extra_info' => 'Product id: '.$product_id));

					}

					$this->session->set_flashdata('message','Unable to Edit Product.');

				}

				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');exit;

			}
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Edit Product')
				->build('a_edit_product', $this->data);
		}

		else

		{

			$this->template->set_layout('admin_dashboard')

				->enable_parser(FALSE)

				->title(WEBSITE_NAME.' - Admin Panel - Product Management')

				->build('administrator-denied', $data);

		}

	}

	public function cancelbid($bid_id)
	{
		try{

			if(!$bid_id) throw new Exception("No Bid selected", 1);
			$this->load->model('my-account/account_module');
			$data=$this->account_module->delete_bid($bid_id);
			if($data){

				$this->session->set_flashdata('success_message', 'The Bid cancelled sucessfully');
				redirect(site_url('/'.MY_ACCOUNT.'proposal_bids'), 'refresh');
			}else{
				$this->session->set_flashdata('error_message', 'The Bid Cancellation Failed');
				redirect(site_url('/'.MY_ACCOUNT.'proposal_bids'), 'refresh');
			}

		
			

		}

		catch(Exception $e){

			echo $e->getMessage;

		}
	}


	

	public function send_email_notification_to_public($categories=array(),$parseElement=array()){

				$this->db->select('DISTINCT(email)');

				$this->db->from('emts_member_expertise a');

				$this->db->join('emts_members m','a.user_id=m.id');

				$this->db->where_in('category_id',$categories);

				$query=$this->db->get();

				$emailnotify=$query->result('array');

				$emailnotify = array_column($emailnotify, 'email');

				$toemail=implode(',',$emailnotify);

				$template_id='56';



				if($toemail!=''){

					$from=SYSTEM_EMAIL;

					$this->notification->send_email_notification($template_id, '', $from, $toemail, '', '', $parseElement, array());

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

			$custom_fields_html = $this->admin_product_model->get_custom_fields_html_by_category($cat_id,'','add','');

			//print_r(json_encode($custom_fields_html)); exit;

			if($custom_fields_html){

				//echo "<pre>"; print_r($custom_fields_html); echo "</pre>"; exit;

				//print_r(json_encode($custom_fields_html)); //exit;

				$response['status'] = 'success';

				$response['html'] = $custom_fields_html;

			}else{

				$response['status'] = 'error';

				$response['status_message'] = 'data not found';

			}

		}else{

			$response['status'] = 'error';

			$response['status_message'] = 'data not found';

		}

		print_r(json_encode($response)); exit;

	}

	

	

	

	//controller method to delete product images using ajax

	public function ajax_delete_product_image()

	{

		if(!$this->input->is_ajax_request()){

			exit('No direct script access allowed');

        }

		//print_r($_POST);

		$response = array(); 

		if($this->input->server('REQUEST_METHOD')=='POST'){

			$product_id = intval($this->input->post('pid',TRUE));

			$image = $this->input->post('name',TRUE);

			//print_r($_POST);

			if($product_id && $image){

				$delete = $this->admin_product_model->delete_product_image($product_id, $image);

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

Public function edit_product_front($productid)
{
	$this->db->select('m.*');
	$this->db->from('products p');
	$this->db->join('members m','p.brand_id=m.id');
	$this->db->where('p.id',$productid);
	$query=$this->db->get();
	
	$record=$query->row_array();
	$this->session->set_userdata(array(SESSION.'admin_id' => $this->session->userdata(ADMIN_LOGIN_ID)));
	$this->session->set_userdata(array(SESSION.'user_id' => $record['id']));
	$this->session->set_userdata(array(SESSION.'usertype' => $record['user_type']));
	$this->session->set_userdata(array(SESSION.'email' => $record['email']));
	$this->session->set_userdata(array(SESSION.'username' => $record['username']));
    $this->session->set_userdata(array(SESSION.'fullname' => $record['name']));
    redirect(site_url(BRAND.'create_campaign/'.$productid));
}
	
public function change_status($product_id,$status)
	{
		$data = array();
		// $data['admin_permissions'] = $this->admin_permissions;
		// if(array_key_exists('delete-product', $this->admin_permissions)):
			$productdata=$this->general->get_single_row('products', array('id' => $product_id));
			$memberdata=$this->general->get_single_row('members', array('id' => $productdata->brand_id));
			if(is_object($productdata) && (count($productdata)>0))	 
			{
				
				$owner_name=$productdata->owner_name;
				$campaign_name=$productdata->name;
				$description=$productdata->description;
				$product_name=$productdata->product_name;
				$product_url=$productdata->product_url;
				$date=$this->general->get_local_time();
				$submission_deadline=$productdata->submission_deadline;
				if($status=='2')
				{
					$stat='Activated';
					$statneg='Activate';
				}else{
					$stat='Rejected';
					$statneg='Reject';
				}
				
				$this->db->update('products',array('status'=>$status),array('id' => $product_id));
				$emaillinear='';
				if($status=='2')
				{
					$productimages=$this->general->get_data('product_images',array('product_id'=>$product_id));
					$imageattach = new stdClass();
					$newimagearr=array();
					if(count($productimages)>0)
					{
						foreach($productimages as $data)
						{
										$imageattach->path=PRODUCT_IMAGE_PATH;
										$imageattach->name=$data->image;
										$newimagearr[]=$imageattach;
						}
					}

				
					/****************Email and notification to Brand*************************/
					$notifymsg='Your Product is live and running';
					$template_id='product_published';
					$from=CONTACT_EMAIL;
					$to=$memberdata->email;
					$parseElement=array(
											'USER'				=>		$memberdata->username,
											'CAMPAIGN_NAME'		=>		$campaign_name,
											'DESCRIPTION'		=>		$description,
											'PRODUCT_NAME'		=>		$product_name,
											'PRODUCT_URL'		=>		$product_url,
											'SITENAME'			=>		WEBSITE_NAME
									   );
					$this->notification->send_email_notification($template_id, '', $from,$to, '', '', $parseElement, array());
					$this->general->savethisasnotification($memberdata->id,$notifymsg,$product_id);
					/**********Email and notification to influecer****************/
					$this->db->select('m.email,m.id as user_id');
					$this->db->from('product_bids p');
					$this->db->join ('members m','p.user_id=m.id');
					$this->db->where(array('p.product_id'=>$product_id,'m.status'=>'1'));
					$query=$this->db->get();

					$notifyarr=array();
					if($query->num_rows()>0)
					{
						$creators=$query->result();
						
						foreach ($creators as  $value) 
						{
							$member=$this->general->get_user_details($value->user_id);
							$template_id='creator_selected_for_campaign';
							$from=CONTACT_EMAIL;
							$parseElement=array(
													'USER'						=>		$member->username,
													'COST'						=>		$member->price,
													'CAP_LIKES'					=>		$member->ceiling_likes,
													'BRAND_NAME'				=>		$memberdata->brand_name,
													'PRODUCT_NAME'				=>		$product_name,
													'SUBMISSION_DEADLINE'		=>		date('Y-m-d',strtotime($submission_deadline)),
													'SITENAME'					=>		WEBSITE_NAME,
													'LINK'						=>		'<a href="'.site_url(CREATOR.'campaigns').'">'.site_url(CREATOR.'campaigns').'</a>',
													'ADVERTISER_EMAIL'			=>	ADVERTISER_EMAIL,
													'INFLUENCER_EMAIL'			=>	INFLUENCER_EMAIL,
													'FACEBOOK_LINK'				=>  FACEBOOK_URL,
											   );
							$this->notification->send_email_notification($template_id, '', $from,$value->email, '', '', $parseElement, $newimagearr);
							$notifyarr[]=array('user_id'=>$value->user_id,'isnotifyseen'=>'0','datetime'=>$date,'is_display'=>'1','product_id'=>$product_id,'notification_message'=>'You have been Selected for the campaign');

						}
						
					}
					$this->db->insert_batch('notification',$notifyarr);
					
				}else
				{
					/****************Rejected Email and notification to Brand*************************/
					$notifymsg='Your Product is Rejected by Admin';
					$template_id='product_rejected';
					$from=CONTACT_EMAIL;
					$to=$memberdata->email;
					$parseElement=array(
											'USER'				=>		$memberdata->username,
											'CAMPAIGN_NAME'		=>		$campaign_name,
											'DESCRIPTION'		=>		$description,
											'PRODUCT_NAME'		=>		$product_nameame,
											'PRODUCT_URL'		=>		$product_url,
											'SITENAME'			=>		WEBSITE_NAME
									   );
					$this->notification->send_email_notification($template_id, '', $from,$to, '', '', $parseElement, array());
					$this->general->savethisasnotification($memberdata->id,$notifymsg,$product_id);
				}
				if(LOG_ADMIN_ACTIVITY == 'Y')
				{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product '.$stat, 'action' => stat, 'extra_info' => 'Product id: '.$product_id));

				}
				$this->session->set_flashdata('message','Product record '.$stat.' successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');

				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){

						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Wrong Attempt to '.$statneg.' Product', 'action' => $statneg, 'extra_info' => 'prodcut id: '.$product_id));

					}

				$this->session->set_flashdata('message','Sorry! no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');
				exit;
			}

		// else:
		// 	$this->template
		// 		->set_layout('admin_dashboard')
		// 		->enable_parser(FALSE)
		// 		->title(WEBSITE_NAME.' - Admin Panel - Product Management')
		// 		->build('administrator-denied', $data);

  //       endif;	
	}

	//delete product

	public function delete_product($id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-product', $this->admin_permissions)):
			$query = $this->db->get_where('products', array('id' => $id));
			if($query->num_rows() > 0) 
			{
				$dquery = $this->db->get_where('product_images', array('id' => $id));
				if ($dquery->num_rows() > 0)
				{
					$data = $dquery->row_array();
					foreach($data as $data)
					{
						@unlink('/'.PRODUCT_IMAGE_PATH.$data['image']);
						@unlink('/'.PRODUCT_IMAGE_PATH.'thumb_'.$data['image']);
					}
					$del = $this->db->delete('product_images', array('product_id' => $id));
				}
				$this->db->delete('products', array('id' => $id));
				if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Deleted', 'action' => 'Delete', 'extra_info' => 'Product id: '.$id));

					}
				$this->session->set_flashdata('message','Product record deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');

				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){

						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Wrong Attempt to delete Product', 'action' => 'Delete', 'extra_info' => 'prodcut id: '.$id));

					}

				$this->session->set_flashdata('message','Sorry! no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');
				exit;
			}

		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Product Management')
				->build('administrator-denied', $data);

        endif;	
	}
	public function view_bids()
	{
		//get product id from uri
		$status = $this->uri->segment('4');

	
		$this->data['current_menu'] = 'view_bid_Placed';	
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-product', $this->admin_permissions)):

			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/');
			$config['total_rows'] = $this->admin_product_model->count_total_bid_placed($status);
			$config['per_page'] = ADMIN_VIEW_BID_LIST_PERPAGE;
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 5;

			//get further config from general library

			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			$offset = $this->uri->segment(5,0);            
			$this->data['bids_data'] = $this->admin_product_model->get_total_bid_placed($status,$config["per_page"],$offset);
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
			
		
			
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- View Bids Placed')
				->build('a_view_bids', $this->data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Post Management')
				->build('administrator-denied', $data);
        endif;

	}
	public function view_product_bids()
	{
		//get product id from uri
		$product_id = $this->uri->segment('4');

		if(!$product_id || $product_id==''){redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh'); exit;}
		$this->data['current_menu'] = 'view_bids_products';	
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-product', $this->admin_permissions)):

			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/product/view_product_bids/'.$product_id);
			$config['total_rows'] = $this->admin_product_model->count_total_bid_placed_on_product($product_id);
			$config['per_page'] = ADMIN_VIEW_BID_LIST_PERPAGE;
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 5;

			//get further config from general library

			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 
			$offset = $this->uri->segment(5,0);            
			$this->data['bids_data']=$this->admin_product_model->get_total_bid_placed_on_product($config["per_page"],$offset,$product_id);

			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
			$this->data['product_data'] = $this->admin_product_model->get_product_byid($product_id);
			$this->data['total_credits'] = $this->admin_product_model->get_total_bid_amount($product_id);
			$this->data['total_bids'] = $config['total_rows'];
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- View Bids Placed')
				->build('a_view_bids', $this->data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Post Management')
				->build('administrator-denied', $data);
        endif;

	}

	public function add_report($bidid=false)
	{
		
		$this->data['current_menu'] = 'add_report';	
		$data = array();
		$biddata=$this->general->get_product_by_bid($bidid);
		$influecer=$this->general->get_influencer_by_bid($bidid);
		$advertiser=$this->general->get_influencer_by_bid($bidid);
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-product', $this->admin_permissions)):
		$this->form_validation->set_rules($this->admin_product_model->validate_report_addition);
		if($this->form_validation->run()==TRUE)
		{
				$response=$this->admin_product_model->save_report($bidid);
				if($response)
				{
					$parseElement=array(
											'CAMPAIGN_NAME'				=>		$biddata->name,
											'PRODUCT_NAME'				=>		$biddata->product_name,
											'PRODUCT_URL'				=>		$biddata->product_url,
											'CAMPAIGN_TYPE'				=>		ucfirst($biddata->campaign_type),
											'SITENAME'					=>		WEBSITE_NAME,
											'LINK'						=>		'<a href="'.site_url(BRAND.'getproposalbyproduct/'.$biddata->product_code).'">'.site_url(BRAND.'getproposalbyproduct/'.$biddata->product_code).'</a>',
											'ADVERTISER_EMAIL'			=>	ADVERTISER_EMAIL,
											'INFLUENCER_EMAIL'			=>	INFLUENCER_EMAIL,
											'FACEBOOK_LINK'				=>  FACEBOOK_URL,
											'USERNAME'					=>	$advertiser->username
									   );
					$template='campaign_completed_brand';
					$from=ADVERTISER_EMAIL;
					$to=$advertiser->email;
					$this->notification->send_email_notification($template, '', $from, $to, '', '', $parseElement, array());

					$parseElement=array(
											'CAMPAIGN_NAME'				=>		$biddata->name,
											'PRODUCT_NAME'				=>		$biddata->product_name,
											'PRODUCT_URL'				=>		$biddata->product_url,
											'CAMPAIGN_TYPE'				=>		ucfirst($biddata->campaign_type),
											'SITENAME'					=>		WEBSITE_NAME,
											'LINK'						=>		'<a href="'.site_url(BRAND.'getproposalbyproduct/'.$biddata->product_code).'">'.site_url(CREATOR.'getproposalbyproduct/'.$biddata->product_code).'</a>',
											'ADVERTISER_EMAIL'			=>	ADVERTISER_EMAIL,
											'INFLUENCER_EMAIL'			=>	INFLUENCER_EMAIL,
											'FACEBOOK_LINK'				=>  FACEBOOK_URL,
											'USERNAME'					=>	$influecer->username
									   );
					$template='campaign_completed_influencer';
					$fromemail=INFLUENCER_EMAIL;
					$toemail=$influecer->email;
					$this->notification->send_email_notification($template, '', $fromemail, $toemail, '', '', $parseElement, array());

					
					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Report Added', 'action' => 'Add', 'extra_info' => 'bid id: '.$bidid));
					}
					
					$this->session->set_flashdata('message','Report has been added successfully.');
				}
				else
				{
					$this->session->set_flashdata('message','Some error occured. Please try again');
				}
					redirect(ADMIN_DASHBOARD_PATH.'/product/view_product_bids/'.$biddata->product_id,'refresh');			
				exit;
		}

			$this->data['content']=$this->general->get_uploaded_content($bidid);
			$this->data['report']=$this->general->get_report($bidid);
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- View Bids Placed')
				->build('a_add_report', $this->data);
		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Post Management')
				->build('administrator-denied', $data);
        endif;
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

	function check_start_date(){
		$current_date = $this->general->get_local_time('time');	
		if($this->input->post('auction_start_time',TRUE)<=$current_date){
			$this->form_validation->set_message('check_start_date', 'Auction start date time must be greater than curent date time');
			return FALSE;
		}
		return TRUE;
	}
	function check_end_date()
	{
		$current_date = $this->general->get_local_time('time');	
		if($this->input->post('auction_end_time',TRUE)<=$current_date)
		{
			$this->form_validation->set_message('check_start_date', 'Auction end date time must be greater than curent date time');
			return FALSE;
		}
		return TRUE;

	}
	public function insert_report()
	{

	}

	function check_coseller_auctions(){
		if($this->input->post('public_private',TRUE)=='public' && ($this->input->post('total_auctions',TRUE) <= $this->input->post('co_sellers_auctions',TRUE))){
			$this->form_validation->set_message('check_coseller_auctions', 'Cosellers Auctions cannot be greater than total Items');
			return FALSE;
		}
		return TRUE;	
	}	

	public function add_product()
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-product', $this->admin_permissions))
		{		
			$this->data['current_menu'] = 'add_product';
			$this->data['custom_field_html'] = '';
			$this->data['job'] = 'add';
			$this->data['product_code'] = strtotime('now').$this->session->userdata(ADMIN_LOGIN_ID);
			$this->data['currencies'] = $this->general->fetch_all_currency();
			
			//get static form field values
			$this->data['static_field'] = $this->general->get_product_static_fields_data();

			//assign values from custom fields to the local variable
			$cf_post_value = $this->input->post('meta',TRUE);
			$this->data['basic_field_html'] = $this->admin_product_model->get_custom_fields_html_by_category(0, $cf_post_value, 'add','','basic');
			// if(PRODUCT_CATEGORY_STATUS=='enabled'){
				$this->data['category_tree'] = $this->general->get_category_tree();
				if($this->input->post('category',TRUE) && $this->input->post('category',TRUE)!=''){
					$cat_id = $this->input->post('category',TRUE);
					$this->data['custom_field_html'] = $this->admin_product_model->get_custom_fields_html_by_category($cat_id, $cf_post_value,'add','','custom');
				}

			// }


			
			$this->form_validation->set_rules($this->admin_product_model->generate_validation_rules($this->data['static_field']));

			if($this->form_validation->run()==TRUE)

			{
				//update product records
				$trans = $this->admin_product_model->add_product();
				if($trans)

				{

					if(LOG_ADMIN_ACTIVITY == 'Y'){

						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Added', 'action' => 'Add', 'extra_info' => ''));

					}
					$this->session->set_flashdata('message','Product records added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Add Product', 'action' => 'Add', 'extra_info' => ''));

					}

					$this->session->set_flashdata('message','Unable to Edit Product.');
				}
				redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh');exit;

			}

			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Add Product')
				->build('a_add_product', $this->data);				
		}
		else
		{
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Product Management')
				->build('administrator-denied', $data);
		}
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

				$image_name = $this->admin_product_model->file_settings_do_upload_ajax($key, PRODUCT_IMAGE_PATH_TEMP, 'encrypt');

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

	

}

