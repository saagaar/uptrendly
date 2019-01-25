<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
       // private $admin_permissions = NULL;
       // private $admin_logged = NULL;
        function __construct() 
		{
			parent::__construct();
					
			// Check if User has logged in
			if (!$this->general->admin_logged_in())			
			{
				redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
			}
			
			//redirect to dashboard if admin chooses not to keep logs
			if(LOG_ADMIN_ACTIVITY=='N' OR LOG_ADMIN_INVALID_LOGIN=='N')
			{
				redirect(ADMIN_DASHBOARD_PATH, 'refresh');exit;
			}
			
			//load CI library
			$this->load->library('pagination');
			$this->load->library('encrypt');
			
			//load custom model
			$this->load->model('log_model');
			
			$this->admin_permissions = $this->general->get_admin_role_permission($this->session->userdata(ADMIN_USER_TYPE));
		}
		
		
		
        public function index()
		{
            $data = array();
            $data['current_menu'] = 'all';
            $data['admin_permissions'] = $this->admin_permissions;
            if(array_key_exists('log-setting', $this->admin_permissions))
			{
                $this->load->library('pagination');
                $config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/site-logs/index');
                $config['total_rows'] = $this->log_model->get_total_audit_trial();
                $config['per_page'] = ADMIN_LIST_PERPAGE;
                $config['page_query_string'] = FALSE;
                $config["uri_segment"] = 4;
				
                $this->general->get_pagination_config($config);            
                $this->pagination->initialize($config); 
                $offset = $this->uri->segment(4,0);            
                $data['offset'] = $offset;
				
                $data['logitems'] = $this->log_model->get_all_admin_activity_log($config["per_page"],$offset);
                $data["pagination_links"] = $this->pagination->create_links();

				$this->template
					->set_layout('dashboard')
					->enable_parser(FALSE)
					->title(WEBSITE_NAME.' - Admin Panel - Log - Audit Trial')
					->build('admin-log-list', $data);
			}
			else
			{
                $this->template
					->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Log - Audit Trial')
                    ->build('log-denied', $data);
			}
        }
		
		
        
        public function invalid_login(){
            $data = array();
            $data['current_menu'] = 'invalid-login';
            $data['admin_permissions'] = $this->admin_permissions;
            if(array_key_exists('log-setting', $this->admin_permissions)):
                $this->load->library('pagination');
                $config['base_url'] = site_url(ADMIN_DASHBOARD_PATH.'/site-logs/invalid_login');
                $config['total_rows'] = $this->log_model->get_total_invalid_login();
                $config['per_page'] = ADMIN_LIST_PERPAGE;
                $config['page_query_string'] = FALSE;
                $config["uri_segment"] = 5;
                $this->general->get_pagination_config($config);            
                $this->pagination->initialize($config); 
                $offset=$this->uri->segment(4,0);            
                $data['offset'] = $offset;
                $data['logitems'] = $this->log_model->get_all_invalid_login($config["per_page"],$offset);
                $data["pagination_links"] = $this->pagination->create_links();
				//echo  $config['total_rows']; exit;
				//echo "<pre>"; print_r( $data['logitems']); echo "</pre>"; exit;

                $this->template
					->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Log - Invalid Login')
                    ->build('invalid-login-list', $data);
            else:
                $this->template
					->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Log - Invalid Login')
                    ->build('log-denied', $data);
					                
            endif;        
        }
        
		
		
        public function invalid_login_detail($id)
		{   
        	$data = array();
        	$item_detail = $this->log_model->get_invalid_login_detail($id);
        	if($item_detail){
            	$data['current_menu'] = 'detail';
            	$data['log_id'] = $id;
            	$data['item_default'] = $item_detail;
            	$data['admin_permissions'] = $this->admin_permissions;
            	if(array_key_exists('log-setting', $this->admin_permissions))
				{
                	$this->template
						->set_layout('dashboard')
                        ->enable_parser(FALSE)
                        ->title(WEBSITE_NAME.' - Admin Panel - Log - Invalid Login')
                        ->build('invalid-login-detail', $data);
				}
				else
				{
					$this->template
						->set_layout('dashboard')
						->enable_parser(FALSE)
						->title(WEBSITE_NAME.' - Admin Panel - Log - Invalid Login')
						->build('log-denied', $data);
				}
			}
			else
			{
            	redirect(ADMIN_DASHBOARD_PATH.'/settings/log');
			}
    }
	
	
    public function site_log_detail($id){
        //load custom helper
           
        $data = array();
        $item_detail = $this->log_model->get_log_detail($id);
        if($item_detail):
            $data['current_menu'] = 'log_detail';
            $data['log_id'] = $id;
            $data['item_default'] = $item_detail;
            $data['admin_permissions'] = $this->admin_permissions;
            if(array_key_exists('log-setting', $this->admin_permissions)):

                $this->template
					->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Site Logs')
                    ->build('admin-log-detail', $data);
                
            else:
                $this->template
					->set_layout('dashboard')
                    ->enable_parser(FALSE)
                    ->title(WEBSITE_NAME.' - Admin Panel - Site Logs')
                    ->build('log-denied', $data);
                
            endif;    
        else:
            redirect(ADMIN_DASHBOARD_PATH.'/site-logs/index');
        endif;
    }
}