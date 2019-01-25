<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load custom module
		$this->load->model('category_model');
		
		//load CI library
		$this->load->library('form_validation');
			
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
		// get array of permissions for logged in use type
		$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
	}
	
	public function index()
	{
		// echo 'here';exit;
		$this->data['current_menu']='all';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('module-product-category', $this->admin_permissions)):
		
			$this->data['jobs']='View';
			$this->data['cat_data'] = $this->category_model->get_all_category_details();
			
			$this->title = WEBSITE_NAME." - View Category";
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->title)
				->build('a_view', $this->data);
				
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Product Category')
				->build('administrator-denied', $data);
        endif;
	}


	
	function add_category()
	{
		$this->data['current_menu']='add_cat';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-product-category', $this->admin_permissions)):
			
			$this->data['jobs']='Add';
			$this->data['error']=FALSE;
			
			$this->form_validation->set_rules($this->category_model->validate_category);
			if($this->form_validation->run()==TRUE)
			{
				//Insert category			
				$trans = $this->category_model->insert_category();
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Category Added', 'action' => 'Add', 'extra_info' => 'category id: '.$trans));
					}
					
					$this->session->set_flashdata('message','Product Category added successfully.');
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Add Product category', 'action' => 'Add', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Product category.');
				}
			
				
				//$this->session->set_flashdata('message','The Category record added successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index/','refresh');			
				exit;
			
		}
		
			$this->title = WEBSITE_NAME." - Add Category";
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_add_cat',$this->data);
	
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Add Category')
				->build('administrator-denied', $data);
        endif;
	}
	

	
	function edit_category($id='')
	{
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index', 'refresh');exit;}
		
		$this->data['current_menu']='edit_cat';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-product-category', $this->admin_permissions)):
		
			
			$this->data['jobs']='Edit';
			$this->data['error']=FALSE;
			
			$this->data['cat_data']=$this->category_model->get_category_by_id($id);
			
			if($this->data['cat_data'] ==false)
			{
				redirect(ADMIN_DASHBOARD_PATH.'/product_categories/index','refresh');
				exit;
			}
			
			//Set the validation rules
			$this->form_validation->set_rules($this->category_model->validate_category);
			
			if($this->form_validation->run()==TRUE)
			{
				//edit category
				$trans = $this->category_model->update_category($id);
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Category Updated', 'action' => 'Edit', 'extra_info' => 'category id: '.$id));
					}
					
						$this->session->set_flashdata('message','Product Category updated successfully.');
						redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index','refresh');exit;
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Edit Product category', 'action' => 'Edit', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Edit Product Category.');
					redirect(ADMIN_DASHBOARD_PATH.'/product-categories/edit_category/'.$id,'refresh');exit;
				}
			}
			
			$this->title = WEBSITE_NAME." - Edit Category- ".$this->data['cat_data']->name;	
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_edit_cat',$this->data);
		
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Category')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	public function view_subcategory($parent_id='')
	{	
		if($parent_id==''){redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index', 'refresh');exit;}
		
		$this->data['current_menu']='view_subcat';
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('view-product-sub-category', $this->admin_permissions)):
			
			$this->data['jobs']='View';
			$this->data['subcat_data'] = $this->category_model->get_subcategories_by_parent_id($parent_id);
			$this->data['catname'] = $this->category_model->get_category_name_by_id($parent_id);
			
			$this->title = WEBSITE_NAME." - View Sub-Category";
				
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title($this->title)
				->build('a_view_subcat', $this->data);
				
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - View Sub-Category')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	function add_sub_category($parent_id='')
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('add-product-sub-category', $this->admin_permissions)):
		
			if(intval($parent_id)!=''){
				$this->data['parent_id'] = $parent_id;
			}else{
				$this->data['parent_id']= '';
			}
			
			//echo $this->data['cat_lang']; exit;
			
			$this->data['current_menu']='add_subcat';
			$this->data['jobs']='Add';
			$this->data['error']=FALSE;
			
			$this->data['all_categories']=$this->category_model->get_all_categories();
			
			$this->form_validation->set_rules($this->category_model->validate_subcategory);
			
			if($this->form_validation->run()==TRUE)
			{
				//Insert category			
				$trans = $this->category_model->insert_sub_category();
				//var_dump($trans); exit;
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Sub-Category Added', 'action' => 'Add', 'extra_info' => 'category id: '.$trans));
					}
					
					$this->session->set_flashdata('message','The Sub Category record added successfully.');
					redirect(ADMIN_DASHBOARD_PATH.'/product-categories/view_subcategory/'.$this->input->post('parent_id'),'refresh');exit;
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Add Product category', 'action' => 'Add', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Add Product Sub-Category.');
					redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index/','refresh');exit;
				}
			}
		
			$this->title = WEBSITE_NAME." - Add Sub Category";
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_add_subcat',$this->data);
				 
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Add Sub Category')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	
	function edit_sub_category($id='')
	{
		if($id==''){redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index', 'refresh');exit;}
		
		$this->data['current_menu']='edit_subcat';
		
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('edit-product-sub-category', $this->admin_permissions)):
		
			$this->data['error']=FALSE;
			$this->data['jobs']='Edit';

			$this->data['cat_data']=$this->category_model->get_category_by_id($id);
			
			$this->data['all_categories']=$this->category_model->get_all_categories();
			
			if($this->data['cat_data'] ==false)
			{
				redirect(ADMIN_DASHBOARD_PATH.'/product_categories/index','refresh');
				exit;
			}
			
			$this->form_validation->set_rules($this->category_model->validate_subcategory);
			
			if($this->form_validation->run()==TRUE)
			{
				//Insert category			
				$trans = $this->category_model->update_sub_category();
				
				if($trans)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product Sub-Category Updated', 'action' => 'Edit', 'extra_info' => 'category id: '.$id));
					}
					
						$this->session->set_flashdata('message','The Product Sub-Category records Edited successfully.');
						redirect(ADMIN_DASHBOARD_PATH.'/product-categories/view_subcategory/'.$this->input->post('parent_id'),'refresh');exit;
				}
				else
				{
					if(LOG_ADMIN_ACTIVITY == 'Y'){
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Edit Product Sub-Category', 'action' => 'Edit', 'extra_info' =>''));
					}
					
					$this->session->set_flashdata('message','Unable to Edit Product Sub Category.');
					redirect(ADMIN_DASHBOARD_PATH.'/product-categories/edit_sub_category/'.$id,'refresh');exit;	
				}
			}
		
			$this->title = WEBSITE_NAME." - Edit Sub Category";
			
			$this->template
				 ->set_layout('admin_dashboard')
				 ->enable_parser(FALSE)
				 ->title($this->title)
				 ->build('a_edit_subcat',$this->data);
				 
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Edit Sub Category')
				->build('administrator-denied', $data);
        endif;
	}
	
	
	public function delete_category($id)
	{
		$data = array();
		$data['admin_permissions'] = $this->admin_permissions;
		if(array_key_exists('delete-product-categories', $this->admin_permissions)):
		
			$query = $this->db->get_where('category', array('id' => $id));
	
			if($query->num_rows() > 0) 
			{
				$this->db->delete('category', array('parent_id' => $id));
				$this->db->delete('category', array('id' => $id));
				
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Product category Deleted', 'action' => 'Delete', 'extra_info' => 'id: '.$id));
					}
				
				$this->session->set_flashdata('message','The Product Category record deleted successfully.');
				redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index/','refresh');
				exit;
			}
			else
			{
				if(LOG_ADMIN_ACTIVITY == 'Y'){
					$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Product', 'module_desc' => 'Unable to Delete Product category', 'action' => 'Delete', 'extra_info' => 'id: '.$id));
				}
				
				$this->session->set_flashdata('message','Sorry no record found.');
				redirect(ADMIN_DASHBOARD_PATH.'/product-categories/index/','refresh');
				exit;
			}
			
		else:
			$this->template
				->set_layout('admin_dashboard')
				->enable_parser(FALSE)
				->title(WEBSITE_NAME.' - Admin Panel - Delete Product Category')
				->build('administrator-denied', $data);
        endif;	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */