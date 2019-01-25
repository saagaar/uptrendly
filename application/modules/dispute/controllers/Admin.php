
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Admin extends CI_Controller {



	function __construct() 

	{

		parent::__construct();

		

		// Check if User has logged in

		if (!$this->general->admin_logged_in()){

			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;

		}

		

		//load CI library

		$this->load->library('form_validation');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->library('pagination');

			

		//load custom module

		$this->load->model('admin_dispute_model');

		// $this->load->model('my-account/account_model','account');

		

		//load helper

		$this->load->helper('editor_helper');

		

		//Changing the Error Delimiters

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		

		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));

	}	

	

	public function index($status = 'all')

	{
		

		// echo $status;exit;

		$this->data['current_menu'] = 'list_dispute';

		

		$data = array();

		$data['admin_permissions'] = $this->admin_permissions;

		
		if(array_key_exists('module-dispute', $this->admin_permissions)):



			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/dispute/index/'.$status);

			$config['total_rows'] = $this->admin_dispute_model->count_total_disputes($status);

			$config['per_page'] = ADMIN_VIEW_DISPUTE_LIST_PERPAGE;

			$config['page_query_string'] = FALSE;

			$config["uri_segment"] = 4;

			//get further config from general library

			$this->general->get_pagination_config($config);            

			$this->pagination->initialize($config); 

			

			$offset = $this->uri->segment(5,0);            

			$this->data['dispute_data'] = $this->admin_dispute_model->get_dispute_lists($status,$config["per_page"],$offset);

			

			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);

			

			$this->template

				->set_layout('admin_dashboard')

				->enable_parser(FALSE)

				->title(WEBSITE_NAME.'- Dispute View')

				->build('a_view_dispute', $this->data);

		

		else:

			$this->template->set_layout('admin_dashboard')

				->enable_parser(FALSE)

				->title(WEBSITE_NAME.' - Admin Panel - Dispute View')

				->build('administrator-denied', $data);



        endif;

	}

	Public function view_conversation($bidid,$reporterid){
		$data=$this->general->get_single_row('reportuser',array('id'=>$reporterid));
		$offenderid=$data->offenderid;
		$reporterid=$data->reporterid;
		$offendername=$this->general->getusername_id($offenderid);
		$reportername=$this->general->getusername_id($reporterid);

		$namearr=array(
						$reporterid=>$reportername->name,
						$offenderid=>$offendername->name
						);
		$conversation=$this->admin_dispute_model->get_all_conversation($bidid);
		$this->data['namearr']=$namearr;
		$this->data['offenderid']=$offenderid;
		$this->data['reporterid']=$reporterid;
		$this->data['conversation']=$conversation;
		$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Edit Product')
				->build('a_view_conversation',$this->data);
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

		

			// $this->data['images_quota'] = MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES;

			// if($this->data['product_images']){

			// 	$this->data['images_quota'] = (MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES - count(array_filter($this->data['product_images'])));

			// }

		

			//get static form field values

			//$this->data['static_field'] = $this->admin_product_model->get_product_static_fields_data();

			// $this->data['static_field'] = $this->general->get_product_static_fields_data();

			//echo "<pre>"; print_r($this->data['static_field']); echo "</pre>"; exit;

			

			//populate basic form fields values

			// $basic_form_value = $this->admin_product_model->get_basic_fields_meta_values($product_id);

			//echo "<pre>"; print_r($basic_form_value); echo "</pre>"; exit;

			

			// $this->data['basic_field_html'] = $this->admin_product_model->get_custom_fields_html_by_category(0, $basic_form_value, 'edit', '','basic');

			

			// if(PRODUCT_CATEGORY_STATUS=='enabled')

			// {

				$this->data['category_tree'] = $this->general->get_category_tree();

				

				if($this->input->post('category',TRUE) && $this->input->post('category',TRUE)!=''){

					$this->data['cat_id'] = $this->input->post('category',TRUE);

				}else{

					$this->data['cat_id'] = $this->data['product']->sub_cat_id!=0?$this->data['product']->sub_cat_id:$this->data['product']->cat_id;

				}

			

				

				//get category name by its id

				$this->data['categoryName'] = $this->general->get_product_category_name_by_id($this->data['cat_id']);

				

				//fetch custom fields

				// $this->data['custom_field_html']=$this->admin_product_model->get_custom_fields_html_by_category($this->data['cat_id'],$cf_post_value,'edit',$cf_old_files,'custom');

			// }

			// if($this->input->server('REQUEST_METHOD') == 'POST')

			// {	

			// 	print_r(json_encode($_POST)); exit;

			// }

			// print_r(json_encode($this->admin_product_model->generate_validation_rules($this->data['static_field']))); exit;
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

				 // $trans=1;

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

			// else

			// {

			// echo "invalid"; 	



			// }	

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

		//echo "page under construction"; exit;

		//get product id from uri

		$product_id = $this->uri->segment('4');

		if(!$product_id || $product_id==''){redirect(ADMIN_DASHBOARD_PATH.'/product/index/','refresh'); exit;}

	

		$this->data['current_menu'] = 'view_bid_Placed';	

		$data = array();

		$data['admin_permissions'] = $this->admin_permissions;

		if(array_key_exists('module-product', $this->admin_permissions)):



			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/'.$product_id);

			$config['total_rows'] = $this->admin_product_model->count_total_bid_placed_on_product($product_id);

			$config['per_page'] = ADMIN_VIEW_BID_LIST_PERPAGE;

			$config['page_query_string'] = FALSE;

			$config["uri_segment"] = 5;



			//get further config from general library

			$this->general->get_pagination_config($config);            

			$this->pagination->initialize($config); 

			

			$offset = $this->uri->segment(5,0);            

			$this->data['bids_data']=$this->admin_product_model->get_total_bid_placed_on_product($config["per_page"],$offset,$product_id);

			

			//echo "<pre>"; print_r($this->data['product_data']); echo "</pre>"; exit;

			

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

				->title(WEBSITE_NAME.' - Admin Panel - Product Management')

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

		if($this->input->post('auction_end_time',TRUE)<=$current_date){

			$this->form_validation->set_message('check_start_date', 'Auction end date time must be greater than curent date time');

			return FALSE;

		}

		return TRUE;

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

			// $this->data['time_zones'] = $this->general->get_all_timezones();

			// $this->data['images_quota'] = MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES;

			// if($this->data['product_images']){

			// 	$this->data['images_quota'] = (MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES - count(array_filter($this->data['product_images'])));

			// }

		

			//get static form field values

			$this->data['static_field'] = $this->general->get_product_static_fields_data();

			//echo "<pre>"; print_r($this->data['static_field']); echo "</pre>"; exit;

			

			

			//assign values from custom fields to the local variable

			$cf_post_value = $this->input->post('meta',TRUE);

		

			$this->data['basic_field_html'] = $this->admin_product_model->get_custom_fields_html_by_category(0, $cf_post_value, 'add','','basic');

		 

			//display this only if category is enabled

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

			}//else{echo validation_errors();}

			

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

