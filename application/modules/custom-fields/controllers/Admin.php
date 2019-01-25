<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load CI library
		$this->load->library('form_validation');
		
		//load custom module
		$this->load->model('custom_field_model');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
		// get array of permissions for logged in use type
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		//Do something here
		$this->view_static_fields();
	}
	
	public function view_static_fields()
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-custom-field', $this->admin_permissions)):
		
			$this->data['jobs']='View';
			$this->data['current_menu']='view_static_fields';
			//$this->data['field_data'] = $this->custom_field_model->get_static_fields();
			$this->data['field_data'] = $this->custom_field_model->get_visible_static_fields();
			
			$this->title = WEBSITE_NAME." - View Static Fields";
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->title)
				->build('a_view_static_fields', $this->data);
				
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Static Fields')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	function edit_static_field($id='')
	{
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_static_fields', 'refresh');exit;}
		
		$this->data['current_menu']='edit_static_field';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-custom-field', $this->admin_permissions)):
		
			$this->data['jobs']='Edit';
			$this->data['error']=FALSE;
			$this->data['field_data']= $this->custom_field_model->get_static_field_data_by_id($id);
			
			
			if($this->data['field_data'] ==false)
			{
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_static_fields','refresh');
				exit;
			}
			
			//Set the validation rules
			$this->form_validation->set_rules('field_label','Field Name/Label','required');
			if($this->form_validation->run()==TRUE)
			{
				//edit custom field
				$trans = $this->custom_field_model->update_static_field($id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Static Field Updated', 'action' => 'Edit', 'extra_info' => 'Static Field name: '.$this->input->post('name',TRUE)));
					}
					
					$this->session->set_flashdata('message','Static Field updated successfully.');
					redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_static_fields','refresh');exit;
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Unable to Edit Static Field', 'action' => 'Edit', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Edit Basic Field.');
					redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/edit_static_field/'.$id,'refresh');exit;
				}
			}
			
			$this->title = WEBSITE_NAME." - Edit Static Field- ".$this->data['field_data']->field_name;
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_edit_static_field',$this->data);
		
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Static Field')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	
	public function view_basic_fields()
	{
		//echo "<pre>"; print_r(PDO::getAvailableDrivers()); echo "</pre>";
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-custom-field', $this->admin_permissions)):
		
			$this->data['jobs']='View';
			$this->data['current_menu']='view_basic_fields';
			
			$this->data['field_data'] = $this->custom_field_model->get_basic_meta_fields_data();
			
			$this->title = WEBSITE_NAME." - View Basic Fields";
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->title)
				->build('a_view_fields', $this->data);
				
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Basic Fields')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	
	public function add_basic_field()
	{
		$this->data['current_menu']='add_basic_field';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-custom-field', $this->admin_permissions)):
			
			//$this->data['category_tree'] = $this->general->get_category_tree();
			//echo "<pre>"; print_r($this->data['category_tree']); echo "</pre>";
			
			$this->data['jobs']='Add';
			$this->data['error']=FALSE;
			
			$this->form_validation->set_rules($this->custom_field_model->validate_custom_fields);
			
			//now validate fields based on form values
			if($this->input->post('type',TRUE)=='DROPDOWN' OR $this->input->post('type',TRUE)=='RADIO'){
				$this->form_validation->set_rules('options','Options','required');
			}
			
			if($this->input->post('minlength',TRUE) OR $this->input->post('maxlength',TRUE))
			{
				$this->form_validation->set_rules('minlength','Min Length','trim|numeric|required');
				$this->form_validation->set_rules('maxlength','Max Length','trim|numeric|required|callback_check_min_max_length');
			}
			
			if($this->input->post('min',TRUE) && $this->input->post('max',TRUE))
			{
				$this->form_validation->set_rules('min','Min Value','trim|numeric|required');
				$this->form_validation->set_rules('max','Max Value','trim|numeric|required|callback_check_min_max_value');
			}

			if($this->form_validation->run()==TRUE)
			{
				//Insert custom field			
				$trans = $this->custom_field_model->insert_meta_field('basic');
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  						$this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Basic Field Added', 'action' => 'Add', 'extra_info' => 'Custom Field name: '.$this->input->post('name',TRUE)));
					}
					
					$this->session->set_flashdata('message','Basic Field added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Unable to Add Basic Field', 'action' => 'Add', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Basic Form Field.');
				}
			
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields','refresh');exit;			
			}else{echo validation_errors();}
			
			$this->title = WEBSITE_NAME." - Basic Fields";
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_add_field',$this->data);
	
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Basic Fields')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	function edit_basic_field($id='')
	{
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields', 'refresh');exit;}
		
		$this->data['current_menu']='edit_basic_field';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-custom-field', $this->admin_permissions)):
		
			$this->data['jobs']='Edit';
			$this->data['error']=FALSE;
			
			$this->data['field_data']= $this->custom_field_model->get_meta_field_data_by_id($id);
			
			$this->data['validation_rules'] = json_decode($this->data['field_data']->validation_rules);
			//print_r($this->data['validation_rules']);
			//get categories in this custom field and create array of categories 
			/*$this->data['field_categories'] = $this->custom_field_model->get_custom_field_categories_by_id($id);
			$this->data['field_cat_arr'] = array();
			
			if($this->data['field_categories']){
				foreach($this->data['field_categories'] as $cat){
					array_push($this->data['field_cat_arr'], $cat->category_id);
				}
			}*/
			
			if($this->data['field_data'] ==false)
			{
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields','refresh');
				exit;
			}
			
			//Set the validation rules
			$this->form_validation->set_rules($this->custom_field_model->validate_custom_fields);
			//$this->form_validation->set_rules('categories', 'Categories', 'required');
			//now validate fields based on form values
			if($this->input->post('type',TRUE)=='DROPDOWN' OR $this->input->post('type',TRUE)=='RADIO'){
				$this->form_validation->set_rules('options','Options','required');
			}else if($this->input->post('type',TRUE)=='FILE'){
				$this->form_validation->set_rules('extension[]','Extensions','required');
			}
			
			if($this->input->post('minlength',TRUE) OR $this->input->post('maxlength',TRUE))
			{
				$this->form_validation->set_rules('minlength','Min Length','trim|numeric|required');
				$this->form_validation->set_rules('maxlength','Max Length','trim|numeric|required|callback_check_min_max_length');
			}
			if($this->input->post('min',TRUE) && $this->input->post('max',TRUE))
			{
				$this->form_validation->set_rules('min','Min Value','trim|numeric|required');
				$this->form_validation->set_rules('max','Max Value','trim|numeric|required|callback_check_min_max_value');
			}
			
			
			if($this->form_validation->run()==TRUE)
			{
				//edit custom field
				$trans = $this->custom_field_model->update_meta_field($id,'custom');
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Basic Field Updated', 'action' => 'Edit', 'extra_info' => 'Custom Field name: '.$this->input->post('name',TRUE)));
					}
					
					$this->session->set_flashdata('message','Basic Field updated successfully.');
					redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields','refresh');exit;
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Unable to Edit Basic Field', 'action' => 'Edit', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Edit Basic Field.');
					redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/edit_basic_field/'.$id,'refresh');exit;
				}
			}
			
			$this->title = WEBSITE_NAME." - Edit Basic Field- ".$this->data['field_data']->name;	
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_edit_field',$this->data);
		
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Basic Field')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	public function view_custom_fields($cat_id='',$cat_name='')
	{
		//redirect to basic fields page if category is disabled
		// if(PRODUCT_CATEGORY_STATUS=='disabled'){
		// 	redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields/','refresh');exit;
		// }
		
		//echo "<pre>"; print_r(PDO::getAvailableDrivers()); echo "</pre>";
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-custom-field', $this->admin_permissions)):
		
			$this->data['jobs']='View';
			$this->data['current_menu']='view_custom_field';
			
			//set default category id and name
			$this->data['category_name'] = $cat_name!=''?$cat_name:'Choose Category';
			$this->data['category_id'] = intval($cat_id)!=''?$cat_id:'';
			
			//now get category with max custom fields count
			$get_default_category = $this->custom_field_model->get_category_with_max_fields();
			//print_r($get_default_category);
			if($get_default_category){
				$this->data['category_name'] = $get_default_category->category_name;  //selected category name
				$this->data['category_id'] = $get_default_category->category_id; //selecrted category id
			}
			
			$this->data['category_tree'] = $this->general->get_category_tree();
			
			$this->data['field_data'] = $this->custom_field_model->get_custom_meta_fields_by_category($this->data['category_id']);
			
			$this->title = WEBSITE_NAME." - View Custom Fields";
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->title)
				->build('a_view_fields', $this->data);
				
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Custom Fields')
				->build('administrator-denied', $data);
        endif;
	}
	

	
	function add_custom_field()
	{
		// if(PRODUCT_CATEGORY_STATUS=='disabled'){
		// 	redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields/','refresh');exit;
		// }
		
		$this->data['current_menu']='add_custom_field';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-custom-field', $this->admin_permissions)):
			
			$this->data['category_tree'] = $this->general->get_category_tree();
			//echo "<pre>"; print_r($this->data['category_tree']); echo "</pre>";
			
			$this->data['jobs']='Add';
			$this->data['error']=FALSE;
			
			$this->form_validation->set_rules($this->custom_field_model->validate_custom_fields);
			
			//now validate fields based on form values
			if($this->input->post('type',TRUE)=='DROPDOWN' OR $this->input->post('type',TRUE)=='RADIO'){
				$this->form_validation->set_rules('options','Options','required');
			}else if($this->input->post('type',TRUE)=='FILE'){
				$this->form_validation->set_rules('extension[]','Extensions','required');
			}
			
			if($this->input->post('minlength',TRUE) OR $this->input->post('maxlength',TRUE))
			{
				$this->form_validation->set_rules('minlength','Min Length','trim|numeric|required');
				$this->form_validation->set_rules('maxlength','Max Length','trim|numeric|required|callback_check_min_max_length');
			}
			if($this->input->post('min',TRUE) && $this->input->post('max',TRUE))
			{
				$this->form_validation->set_rules('min','Min Value','trim|numeric|required');
				$this->form_validation->set_rules('max','Max Value','trim|numeric|required|callback_check_min_max_value');
			}
			
			
			if($this->form_validation->run()==TRUE)
			{
				//Insert custom field			
				$trans = $this->custom_field_model->insert_meta_field('custom');
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  						$this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Custom Field Added', 'action' => 'Add', 'extra_info' => 'Custom Field name: '.$this->input->post('name',TRUE)));
					}
					
					$this->session->set_flashdata('message','Custom Field added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Unable to Add Custom Field', 'action' => 'Add', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Custom Fields.');
				}
			
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_custom_fields/','refresh');exit;
			}//else{echo validation_errors();}
			
			$this->title = WEBSITE_NAME." - Custom Fields";
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_add_field',$this->data);
	
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Custom Fields')
				->build('administrator-denied', $data);
        endif;
	}
	

	
	function edit_custom_field($id='')
	{
		// if(PRODUCT_CATEGORY_STATUS=='disabled'){
		// 	redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields/','refresh');exit;
		// }
		
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_custom_fields', 'refresh');exit;}
		
		$this->data['current_menu']='edit_custom_field';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-custom-field', $this->admin_permissions)):
		
			$this->data['jobs']='Edit';
			$this->data['error']=FALSE;
			
			$this->data['category_tree'] = $this->general->get_category_tree();
			
			$this->data['field_data']= $this->custom_field_model->get_meta_field_data_by_id($id);
			
			$this->data['validation_rules'] = json_decode($this->data['field_data']->validation_rules);
			//print_r($this->data['validation_rules']);
			//get categories in this custom field and create array of categories 
			$this->data['field_categories'] = $this->custom_field_model->get_custom_field_categories_by_id($id);
			$this->data['field_cat_arr'] = array();
			
			if($this->data['field_categories']){
				foreach($this->data['field_categories'] as $cat){
					array_push($this->data['field_cat_arr'], $cat->category_id);
				}
			}
			
			if($this->data['field_data'] ==false)
			{
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_custom_fields','refresh');
				exit;
			}
			
			//Set the validation rules
			$this->form_validation->set_rules($this->custom_field_model->validate_custom_fields);
			$this->form_validation->set_rules('categories[]', 'Categories', 'required');
			//now validate fields based on form values
			if($this->input->post('type',TRUE)=='DROPDOWN' OR $this->input->post('type',TRUE)=='RADIO'){
				$this->form_validation->set_rules('options','Options','required');
			}else if($this->input->post('type',TRUE)=='FILE'){
				$this->form_validation->set_rules('extension[]','Extensions','required');
			}
			
			if($this->input->post('minlength',TRUE) OR $this->input->post('maxlength',TRUE))
			{
				$this->form_validation->set_rules('minlength','Min Length','trim|numeric|required');
				$this->form_validation->set_rules('maxlength','Max Length','trim|numeric|required|callback_check_min_max_length');
			}
			if($this->input->post('min',TRUE) && $this->input->post('max',TRUE))
			{
				$this->form_validation->set_rules('min','Min Value','trim|numeric|required');
				$this->form_validation->set_rules('max','Max Value','trim|numeric|required|callback_check_min_max_value');
			}
			
			
			if($this->form_validation->run()==TRUE)
			{
				//edit custom field
				$trans = $this->custom_field_model->update_meta_field($id,'custom');
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Custom Field Updated', 'action' => 'Edit', 'extra_info' => 'Custom Field name: '.$this->input->post('name',TRUE)));
					}
					
					$this->session->set_flashdata('message','Custom Field updated successfully.');
					redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_custom_fields','refresh');exit;
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Unable to Edit Custom Field', 'action' => 'Edit', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Edit Custom Field.');
					redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/edit_custom_field/'.$id,'refresh');exit;
				}
			}
			
			$this->title = WEBSITE_NAME." - Edit Custom Field- ".$this->data['field_data']->name;	
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_edit_field',$this->data);
		
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Custom Field')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	
	
	
	
	public function delete($id,$referrer)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		
		if(array_key_exists('delete-custom-field', $this->admin_permissions)):
		
			$query = $this->db->get_where('meta_fields', array('id' => $id));
	
			if($query->num_rows() > 0) 
			{
				$this->db->delete('meta_fields', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Custom Field Deleted', 'action' => 'Delete', 'extra_info' => 'id: '.$id));
				}
				
				$this->session->set_flashdata('message','The '.ucwords($referrer).' Field record deleted successfully.');
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Custom Field', 'module_desc' => 'Unable to Delete '.ucwords($referrer).' Field', 'action' => 'Delete', 'extra_info' => 'id: '.$id));
				}
				
				$this->session->set_flashdata('message','Sorry no record found.');
			}
			if($referrer=='basic'){
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields/','refresh');exit;
			}else{
				redirect(ADMIN_DASHBOARD_PATH.'/custom-fields/view_custom_fields/','refresh');exit;
			}
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Delete Custom Field')
				->build('administrator-denied', $data);
        endif;	
	}
	
	
	//To get custom form fields by category
	public function ajax_get_custom_fields(){
		
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
        }
		
		$cat_id = $this->input->post('category',TRUE);
		
		if($cat_id)
		{
			//now get custom fields html value from model
			$custom_fields = $this->custom_field_model->get_custom_meta_fields_by_category($cat_id);
			
			if($custom_fields){
				//echo "<pre>"; print_r($custom_fields_html); echo "</pre>"; exit;
				//print_r(json_encode($custom_fields_html)); //exit;
				$html = '';
				$response['status'] = 'success';
				foreach($custom_fields as $field)
				{
					$html .= '<tr id="'.$field->id.'">';
					$html .= '<td><span class="handle">&nbsp;</span></td>';
					$html .= '<td>'.$field->name.'</td>';
					$html .= '<td>'.$field->type.'</td>';
					$html .= '<td class="optn"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="33"><a href="'.site_url(ADMIN_DASHBOARD_PATH).'/custom-fields/edit_custom_field/'.$field->id.'" style="margin-right:5px;" title="click to edit this field"><span>Edit</span></a></td><td width="33"><a href="'.site_url(ADMIN_DASHBOARD_PATH).'/custom-fields/delete/'.$field->id.'/custom" onClick="return ConfirmDelete(\'field\');" title="click to delete this field"><span>Delete</span></a></td></tr></table></td>';
					$html .= '</tr>';
				}
				$response['html'] = $html;
			}else{
				$response['status'] = 'success';
				$response['html'] ='<tr><td colspan="4"><div class="confrmmsg"><p>No custom field found in selected category</p></div></td></tr>';
			}
		}else{
			$response['status'] = 'error';
			$response['status_message'] = 'data not found';
		}
		print_r(json_encode($response)); exit;	
	}
	
	
	
	//sort custom fields
	public function ajax_sort_basic_fields()
	{
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
		}
		
		$this->form_validation->set_rules('list_order','List Order','required');
		if($this->input->server('REQUEST_METHOD')=='POST' && $this->form_validation->run()==TRUE)
		{
			//print_r(json_encode($_POST)); exit;
			$list_order = $this->input->post('list_order',TRUE);
			$sort_successful = $this->custom_field_model->sort_basic_meta_fields($list_order);
			if($sort_successful){
				print_r(json_encode(array('result'=>'success','message'=>'sorted successfully')));exit;
			}else{
				print_r(json_encode(array('result'=>'error','message'=>'unable to sort')));exit;
			}
		}else{
			print_r(json_encode(array('result'=>'error','message'=>'Invalid Operation. Data not found.')));
		}
	}
	
	
	
	public function ajax_sort_custom_fields()
	{
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
		}
		
		$this->form_validation->set_rules('category_id','Category','required');
		$this->form_validation->set_rules('list_order','List Order','required');
		if($this->input->server('REQUEST_METHOD')=='POST' && $this->form_validation->run()==TRUE)
		{
			//print_r(json_encode($_POST)); exit;
			$cat_id = $this->input->post('category_id',TRUE);
			$list_order = $this->input->post('list_order',TRUE);
			$sort_successful = $this->custom_field_model->sort_custom_fields_by_category_id($cat_id,$list_order);
			if($sort_successful){
				print_r(json_encode(array('result'=>'success','message'=>'sorted successfully')));exit;
			}else{
				print_r(json_encode(array('result'=>'error','message'=>'unable to sort')));exit;
			}
		}else{
			print_r(json_encode(array('result'=>'error','message'=>'Invalid Operation. Data not found.')));
		}
	}
	
	
	
	public function check_min_max_length()
	{
		if($this->input->post('min_length',TRUE) OR $this->input->post('max_length',TRUE))
		{
			if($this->input->post('min_length',TRUE) >=$this->input->post('max_length',TRUE)){
				$this->form_validation->set_message('check_min_max_length','Maximum length must be greater than Minimum Length');
				return false;
			}
		}
		return true;
	}
	
	
	
	public function check_min_max_value()
	{
		if($this->input->post('min',TRUE) OR $this->input->post('max',TRUE))
		{
			if($this->input->post('min',TRUE) >=$this->input->post('max',TRUE)){
				$this->form_validation->set_message('check_min_max_value','Maximum value must be greater than Minimum value');
				return false;
			}
		}
		return true;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */