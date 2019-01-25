<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	private $admin_permissions = NULL;
        private $admin_logged = NULL;
        function __construct() 
		{
			parent::__construct();
		
			// Check if User has logged in
			if (!$this->general->admin_logged_in())			
			{
				redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
			}

			//load CI library
				$this->load->library('form_validation');
				$this->load->library('pagination');		

			//load custom model
				$this->load->model('admin_model');
			
				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
	 			$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
		}
		
	
		public function index()
		{
            $data = array();
            $data['current_menu'] = 'all';
            $data['admin_permissions'] = $this->admin_permissions;
			
			//echo "<pre>"; print_r($data['admin_permissions']); echo "</pre>"; exit;
           if(array_key_exists('module-administrator', $this->admin_permissions)):
				$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/administrator/index');
				$config['total_rows'] = $this->admin_model->get_total_admins();
				$config['per_page'] = ADMIN_LIST_PERPAGE;
				$config['page_query_string'] = FALSE;
				$config["uri_segment"] = 4;
				
				$this->general->get_pagination_config($config);            
				$this->pagination->initialize($config); 
				
				$offset=$this->uri->segment(4,0);            
	
				$data['admins'] = $this->admin_model->get_all_admins($config["per_page"],$offset);
				
				$data["pagination_links"] = $this->pagination->create_links();
	
				$this->template
					->set_layout('dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Administator')
					->build('admin-list', $data);
           
		   else:
                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
                        ->build('administrator-denied', $data);

           endif;        
		}
		
		
        public function view($username=NULL,$id=0)
		{
            $admin_detail = $this->admin_model->get_detail_info($username,$id);
            if($admin_detail):
                $data['current_menu'] = 'view';            
                $data['admin_default'] = $admin_detail;
                $data['admin_permissions'] = $this->admin_permissions;
               if(array_key_exists('view-administrator', $this->admin_permissions)):
                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Administrator')
                        ->build('admin-view', $data);
               
               else:
                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
                        ->build('administrator-denied', $data);

                endif;
            else:
                redirect(ADMIN_DASHBOARD_PATH.'/administrator/index');    
            endif;
        }
		

        public function add()
		{
            $data['current_menu'] = 'add';            
            $data['admin_default'] = null;
            $data['admin_permissions'] = $this->admin_permissions;
			//echo "<pre>"; print_r($data['admin_permissions']); echo "</pre>"; exit;
            if(array_key_exists('add-administrator', $this->admin_permissions)):

    			if ($this->input->server('REQUEST_METHOD') === 'POST')
    			{
				    //echo "<pre>"; print_r($_POST); echo "</pre>";
				
    				$this->form_validation->set_rules($this->admin_model->validate_rules_administrator);
    				$this->form_validation->set_rules($this->admin_model->validate_rules_add_admin);
    				$this->form_validation->set_rules($this->admin_model->validate_rules_password);    
    				if($this->form_validation->run()==TRUE)
    				{
    					$trans_stat = $this->admin_model->add_administrator();
    					if($trans_stat)
    					{
    						if(LOG_ADMIN_ACTIVITY == 'Y'){
                                $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'administrator added', 'action' => 'Add'));
                            }
    						
    						//echo "Administrator Added sucessfully";
    						$this->session->set_flashdata('message','Administrator Added sucessfully!!.'); 
    					}
    					else
    					{
    						//echo "Failed to Add Administrator";
    						$this->session->set_flashdata('message','Failed to Add Administrator.');                      
    					}
    					redirect(ADMIN_DASHBOARD_PATH.'/administrator/index');
    				}
    				else
    				{
    					if(LOG_ADMIN_ACTIVITY == 'Y'){
                                    $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'add administrator failed', 'action' => 'Add',  'extra_info' => 'validation:'.validation_errors()));
                                }	
    				
    				}
			    }

            	$this->template->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Administrator')
                    ->build('add-edit', $data);
            else:
			
				$this->template->set_layout('dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
					->build('administrator-denied', $data);
        	endif;
			
        }
		
		
        public function edit($username=NULL,$id=0)
		{
            $admin_detail = $this->admin_model->get_detail_by_username_id($username,$id);
            if($admin_detail){
                $data['current_menu'] = 'edit';            
                $data['admin_default'] = $admin_detail;
                $data['admin_permissions'] = $this->admin_permissions;
				 
				if(array_key_exists('edit-administrator', $this->admin_permissions))
				{
                    if ($this->input->server('REQUEST_METHOD') === 'POST')
					{
                        $this->form_validation->set_rules($this->admin_model->validate_rules_administrator);
                        $this->form_validation->set_rules($this->admin_model->validate_rules_edit_admin);

                        if($this->input->post('change_password') == 'change_password')
						{
                        	$this->form_validation->set_rules($this->admin_model->validate_rules_password);
                        }
						
                        if($this->form_validation->run()==TRUE)
						{	
							//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
							
                            $check_edit = $this->admin_model->update_administrator($username,$id);
							//echo  $check_edit; exit;
                            if($check_edit)
							{
								if(LOG_ADMIN_ACTIVITY == 'Y'){
                                $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'administrator updated', 'action' => 'Edit'));
                            	}
								
                                $this->session->set_flashdata('message','Administrator Updated sucessfully!!.'); 
                            }
							else
							{
								if(LOG_ADMIN_ACTIVITY == 'Y'){
                                $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'administrator update failed', 'action' => 'Edit'));
								}
							
                                $this->session->set_flashdata('message','Administrator Update Failed.');                        
                            }
                            redirect(ADMIN_DASHBOARD_PATH.'/administrator/edit/'.$username.'/'.$id);
                        }
                    }

                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Administrator')
                        ->build('add-edit', $data);
                    
				}
				else
				{
                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
                        ->build('administrator-denied', $data);
				}  
			}
			else
			{
                redirect(ADMIN_DASHBOARD_PATH.'/administrator/index');    
			}
        }
		
		
        public function delete($username=NULL,$id=0)
		{
            if(($username ==  $this->session->userdata(ADMIN_USER_NAME)) && ($id ==  $this->session->userdata(ADMIN_LOGIN_ID))):
                $this->session->set_flashdata('message','You cannot delete yourself'); 
                redirect(ADMIN_DASHBOARD_PATH.'/administrator/index');
            else:
                
            endif;
			
            $data['admin_permissions'] = $this->admin_permissions;
            if(array_key_exists('delete-administrator', $this->admin_permissions)):
                $trans_stat = $this->admin_model->delete_administrator($username,$id);
                if($trans_stat)
				{
					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'administrator deleted', 'action' => 'Delete', 'extra_info' => 'username:'.$username.' | id:'.$id));
					}
					
                    $this->session->set_flashdata('message','Administrator Deleted sucessfully!!.'); 
                }else{
					
					if(LOG_ADMIN_ACTIVITY == 'Y')
					{
						$this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'administrator delete failed', 'action' => 'Delete',  'extra_info' => 'username:'.$username.' | id:'.$id));
					}
                    $this->session->set_flashdata('message','Administrator Couldnot be Deleted, Try again later.');                        

                }
            else:
                $this->session->set_flashdata('message','You donot have authority to access this page.');                        
            endif;
            redirect(ADMIN_DASHBOARD_PATH.'/administrator/index');
        }
		
		
		
        public function actions(){   
            if(array_key_exists('edit-administrator', $this->admin_permissions)):
            
                if ($this->input->server('REQUEST_METHOD') === 'POST'){
                    switch($this->input->post('more_actions')){
                        case 'make_active':
                            list($trans_stat,$failed) = $this->admin_model->change_status('1');
                            break;
                        case 'make_disable':
                            list($trans_stat,$failed) = $this->admin_model->change_status('2');
                            break;
                        default:
                    }
                }
                if($trans_stat){
                    $this->session->set_flashdata('message','Action Perfomed successfully with '.$failed.' Failed Operations');
                }
                else{
                    $this->session->set_flashdata('message','More Actions Failed');
                }
            
            else:
                $this->session->set_flashdata('message','You donot have authority to perform this action.');                        
            endif;
            
            redirect(ADMIN_DASHBOARD_PATH.'/administrator/index');
            exit();
        }
		
		
		



        public function roles(){
            $data = array();
           	$data['current_menu'] = 'roles';
            $data['admin_permissions'] = $this->admin_permissions;
            if(array_key_exists('role-permission', $this->admin_permissions)):

             	$this->template->set_layout('dashboard')
                				->enable_parser(FALSE)
                            	->title(WEBSITE_NAME.' - Admin Panel - Administator')
                            	->build('role-list', $data);
                
            else:
                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
                        ->build('administrator-denied', $data);

          	endif;    
        }
		
		
        public function role($action=NULL, $id=0){
            switch($action):
                case 'view': $this->viewrole($id); break;
                case 'edit': $this->editrole($id); break;
                default: $this->viewrole($id); 
            endswitch;
        }
        
        public function viewrole($id=0){
            
        }
		
		
        public function editrole($id=0)
		{
            $role_perm = $this->admin_model->get_all_roles_permission($id,0);

            if($id):
                $data['current_menu'] = 'editrole';
                $data['role_default'] = $id;
                $data['admin_permissions'] = $this->admin_permissions;
                if(array_key_exists('role-permission', $this->admin_permissions)):
            
                    if ($this->input->server('REQUEST_METHOD') === 'POST')
					{
						//echo "validated"; exit;
						$trans_stat = $this->admin_model->update_role_permissions();
						
						//echo "$trans_stat"; exit;
						
						if($trans_stat)
						{
							if(LOG_ADMIN_ACTIVITY == 'Y'){
                                $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'administrator Permission updated', 'action' => 'Edit', 'extra_info' => 'type:'.$id));
							}
							
							$this->session->set_flashdata('message','Data Updated sucessfully!!.'); 
						}
						else
						{
							if(LOG_ADMIN_ACTIVITY == 'Y'){
                                $this->general->log_admin_activity(array('user_id' => $this->session->userdata(ADMIN_LOGIN_ID), 'user_type' =>  $this->session->userdata(ADMIN_USER_TYPE), 'module' => 'Administrator', 'module_desc' => 'Administrator Permission update failed', 'action' => 'Edit', 'extra_info' => 'type:'.$id));
							}
							
							$this->session->set_flashdata('message','No any Changes made');                        
						}
						redirect(ADMIN_DASHBOARD_PATH.'/administrator/role/edit/'.$id);
                    }

                    $selected_permissions_array = array();
                    
                    $data['modules'] = $this->admin_model->get_child_recursive_permissions();
                    $data['role_permissions'] = $role_perm;
                    if($role_perm)
					{
                        foreach($role_perm as $role_perms)
						{
                            $selected_permissions_array[$role_perms['permission_id']] = $role_perms['permission_id']; 
                        }
                    }
                    $data['selected_permissions_array'] = $selected_permissions_array;
                    
					//print_r($selected_permissions_array); exit;
					
                    $this->template->set_layout('dashboard')
                            ->enable_parser(FALSE)
                            ->title(WEBSITE_NAME.' - Admin Panel - Administator')
                            ->build('role-edit', $data);
                    
                 else:
                    $this->template->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Auction Settings')
                        ->build('administrator-denied', $data);

                endif;    
            else:
                redirect(ADMIN_DASHBOARD_PATH.'/administrator/roles');
            endif;
        }
		

        /*Callback Function to Validate the Form*/

        public function _username_unique($username){
            $query = $this->db->get_where('members',array('username' => $username, 'id != ' => $this->input->post('id')));
            if($query->num_rows()>0){
                $this->form_validation->set_message('_username_unique', '%s is already taken');            
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
		
		 public function _email_unique($email){
            $query = $this->db->get_where('members',array('email' => $email, 'id != ' => $this->input->post('email')));
            if($query->num_rows()>0){
                $this->form_validation->set_message('_email_unique', '%s is already used');            
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
        
        public function _rolecode_unique($code){
            $query = $this->db->get_where('admin_roles',array('code' => $code, 'role_id	 != ' => $this->input->post('role_id')));
            if($query->num_rows()>0){
                $this->form_validation->set_message('_rolecode_unique', '%s already exists');            
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
}