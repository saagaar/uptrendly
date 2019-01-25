<?php 
/**
* 
*/
class Emailset extends CI_Controller {

	public $validate_email = array(
		array('field'=>'email_to', 'label'=>'Email To', 'rules'=>'required'),
		array('field'=>'subject', 'label'=>'Subject', 'rules'=>'required'),
		array('field'=>'message', 'label'=>'Message', 'rules'=>'required')
		);


	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');

		$this->load->library('email');	

		$this->load->library('notification');

		//load admin_email_settings module
		$this->load->model('admin_email_settings');
	}
	public function index(){	

		if($_SERVER['REQUEST_METHOD']=='POST')
		{

			$user_id = 1; //$this->session->userdata(SESSION.'user_id');
			
			foreach ($this->input->post('email_notification') as $template_id => $status) {

				if( $this->notification->get_user_settingsby_tempid($template_id, $user_id ) ){

					$this->notification->update_notification_status('is_email_notification_send', $status, $template_id, $user_id  );

				} else {

					$this->notification->insert_notification_status('is_email_notification_send', $status, $template_id, $user_id );

				}

				
			}
			foreach ($this->input->post('sms_notification') as $template_id => $status) {

				if( $this->notification->get_user_settingsby_tempid($template_id, $user_id  ) ){

					$this->notification->update_notification_status('is_sms_notification_send', $status, $template_id, $user_id );

				} else {

					$this->notification->insert_notification_status('is_sms_notification_send', $status, $template_id, $user_id );

				}
			}
		}
		
		$data['settings'] = $this->notification->user_notification_settings();
		
		$this->load->view('user_settings', $data);

	}

	
}
?>