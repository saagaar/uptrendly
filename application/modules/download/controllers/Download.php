<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
     
    function __construct() {
		parent::__construct();        
        $this->load->model('download_model');
        
    } 
	public function index()
	{
	       //EXE_CMS_SITE_URL
		    redirect('login');
	}
    private function _get_file_($args=array()){
        $this->download_model->set_args($args);
            $this->download_model->set_extensions();
            $this->download_model->prepare_download();
            
            if($this->download_model->download_hook['download']){
                
                $this->download_model->set_download();
    			$this->download_model->start_download();
            }
            else{
                die($this->download_model->download_hook['message']);
            }
    }
    public function seller_authorize_person(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => site_url('seller-application/register/guarantor'),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
        
        
    }
    public function account_seller_authorize_person(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => site_url('seller/account/guarantor'),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
        
        
    }
    
    public function seller_company_authorization(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => site_url('seller-application/register/agreements-signature'),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
        
    }
    public function investor_company_authorization(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => site_url(EXEINVESTOR_APPLICATION_PUBLIC_URL.'/register/signature'),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
        
    }
    
    public function seller_membership_agreement(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => site_url('seller-application/register/agreements-signature'),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
        
    }
    public function buyer_membership_agreement(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => site_url(EXEINVESTOR_APPLICATION_PUBLIC_URL.'/register/signature'),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
        
    }
    
    public function post_auction(){
        $file = rawurldecode($this->input->get('file'));
        if($file){
            $args = array(
                'download_path' => FCPATH.ADMIN_DOWNLOAD_PATH,
                'file' => $file,
                'file_name' => $file,
                'referrer_check' => TRUE,
                'referrer' => array(site_url('seller/post-auction'),site_url('seller/edit-auction')),
            );
            $this->_get_file_($args);            
            
        }
        else{
            die('File not found.');
        }
    }

    public function bid_document($bidid=false){
    try{
        if(!$bidid) throw new  Exception("No valid bid item found", 1);
        $this->load->model('my-account/account_module');
        $bid= $this->account_module->get_data('emts_product_bids',array('id'=>$bidid));

        if($bid[0]->attachment)
        {
              $args = array(
                'download_path' => BID_ATTACHMENTS,
                'file' => $bid[0]->attachment,
                'file_name' => $bid[0]->attachment,
                'referrer_check' => false,
                'referrer' => array()
            );
            $this->_get_file_($args);    
        }
        else
        {
           $this->session->set_flashdata('success_message', 'No Attachment found with this bid.');
            redirect(site_url('my-account/user/bid_details'),'refresh');
        }

    }catch(Exception $e){
        $e->getMessage();
    }
    }
    
    
    public function message_attachment($attachmentid=false){
    try{
        if(!$attachmentid) throw new  Exception("No valid bid item found", 1);
        $this->load->model('my-account/account_module');
        $attach= $this->account_module->get_data('emts_communication_attachment',array('id'=>$attachmentid));

        if($attach[0]->file_saved)
        {
              $args = array(
                'download_path' => ATTACHMENT_UPLOAD_DIR,
                'file' => $attach[0]->file_saved,
                'file_name' => $attach[0]->file_saved,
                'referrer_check' => false,
                'referrer' => array()
            );
            $this->_get_file_($args);    
        }
        else
        {
          return false;
        }

    }catch(Exception $e){
        echo $e->getMessage();
    }
    }
    
}