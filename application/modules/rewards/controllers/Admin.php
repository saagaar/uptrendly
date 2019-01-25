
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
		$this->load->model('admin_reward_model');
		//load helper
		$this->load->helper('editor_helper');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}	

	public function index()
	{

		$this->data['current_menu'] = 'rewards';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-reward', $this->admin_permissions)):
			$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/rewards/index/');
			$config['total_rows'] = $this->admin_reward_model->count_total_rewards();
			$config['per_page'] = ADMIN_PRODUCT_LIST_PERPAGE;
			$config['page_query_string'] = FALSE;
			$config["uri_segment"] = 5;
			//get further config from general library
			$this->general->get_pagination_config($config);            
			$this->pagination->initialize($config); 

			$offset = $this->uri->segment(5,0);            
			$this->data['rewards_list'] = $this->admin_reward_model->get_rewards_lists($config["per_page"],$offset);
			$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.'- Rewards Management')
				->build('a_view_rewards', $this->data);

		else:
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Rewards Management')
				->build('administrator-denied', $data);
      endif;
	}


	//delete rewards

	public function delete_rewards($id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-reward', $this->admin_permissions)):
			$query = $this->db->get_where('referral_prize', array('id' => $id));
		if($query->num_rows() > 0) 
			{
					$data = $query->row_array();
					@unlink('/'.PRODUCT_IMAGE_PATH.$data['image']);
			
			$this->db->delete('referral_prize', array('id' => $id));
			if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Rewards', 'module_desc' => 'Reward Delete', 'action' => 'Delete', 'extra_info' => 'Reward id: '.$id));
				}
			$this->session->set_flashdata('message','Rewards deleted successfully.');
			redirect(ADMIN_DASHBOARD_PATH.'/rewards/index/','refresh');
			exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Rewards', 'module_desc' => 'Wrong Attempt to delete Reward', 'action' => 'Delete', 'extra_info' => 'Reward id: '.$id));

					}
				$this->session->set_flashdata('message','Sorry! no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/rewards/index/','refresh');
				exit;
			}

		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Reward Management')
				->build('administrator-denied', $data);
        endif;	
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

	public function add_rewards($id=false)

	{

		$data = array();
		$this->data['error']='';
		$data['admin_permissions'] = $this->admin_permissions;

		if(array_key_exists('add-reward', $this->admin_permissions))
		{		
			$this->data['current_menu'] = 'add_rewards';
			$this->form_validation->set_rules($this->admin_reward_model->reward_validation_rule);
			if($this->form_validation->run()==TRUE)
			{
				//update product records
				$trans = $this->admin_reward_model->add_rewards($id);
				
			if(isset($trans['success']))
			{

					if($trans['success'])
					{
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Rewards', 'module_desc' => 'Reward Added', 'action' => 'Add', 'extra_info' => ''));

						}
						$this->session->set_flashdata('message','Product records added successfully.');
					}
					else
					{
						if(LOG_ADMIN_ACTIVITY == 'Y'){
							$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Reward', 'module_desc' => 'Unable to Add Reward', 'action' => 'Add', 'extra_info' => ''));
						}
						$this->session->set_flashdata('message','Unable to Edit Product.');
					}
					redirect(ADMIN_DASHBOARD_PATH.'/rewards/index/','refresh');exit;
				
			}	
			else{
				if(isset($trans['error']))$this->data['error']=$trans['error'];
			}

				
			
			}
			if($id)
			{
				$this->data['data']=$this->general->get_single_row('referral_prize',array('id'=>$id));
			}
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Add Rewards')
				->build('a_add_reward', $this->data);				
		}
		else
		{
			$this->template->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Rewards Management')
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
			$image_count=0;
			$image_data = array();
			$response_array = '';

			foreach($_FILES as $key=>$value){
				$image_name = $this->admin_reward_model->file_settings_do_upload_ajax($key, PRODUCT_IMAGE_PATH, 'encrypt');
				if ($image_name['file_name'])
				{
					$this->image_name_path = $image_name['file_name'];
					$image_count++;
				   //push image data into array
				   	// array_push($image_data, array('product_code' => $this->input->post('pcodeimg', TRUE), 'image' => $this->image_name_path));
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

