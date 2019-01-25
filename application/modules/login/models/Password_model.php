<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	 public $validate_password_forget = array(
            array('field' => 'admin_email', 'label' => 'Email', 'rules' => 'required|valid_email'),
            array('field' => 'admin_captcha', 'label' => 'Verification Code', 'rules' => 'required|callback__captcha_code_forget')
        );
	
	public function admin_send_Password_reset_email()
	{
		$options = array('email'=>$this->input->post('admin_email',TRUE));
        $query = $this->db->get_where('members',$options);
		$row = $query->row();
		
		//echo $this->db->last_query(); 
		//generate password
		$salt = $this->general->salt();
		$new_password = $this->general->create_password();
	
		$password_hash = $this->general->hash_password($new_password,$salt);
		
		$username = $row->username;
		
		$password = $password_hash;
		
		//ini_set("SMTP","smtp.wlink.com.np" );
		
		//load email library
    	$this->load->library('email');
		//configure mail
		$config = Array(
			//'protocol' => 'sendmail',
			'protocol' => 'mail',
			'smtp_host' => 'smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'ktmtest2@gmail.com',
			'smtp_pass' => 'admin#123',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8',
			'wordwrap'  =>TRUE,
		);
		
		$this->email->initialize($config);
		
		$this->load->model('email_model');		
		
		//get subjet & body
		$template = $this->email_model->get_email_template("forgot_password_notification");


        $subject=$template['subject'];
        $emailbody=$template['email_body'];
		
		//check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{
			//parse email
			$parseElement=array("USERNAME"=>$username,
								"SITENAME"=>WEBSITE_NAME,
								"EMAIL"=>$this->input->post('admin_email'),
								"PASSWORD"=>$new_password);

			$subject=$this->email_model->parse_email($parseElement,$subject);
			$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
					
			//set the email things
			$this->email->from(CONTACT_EMAIL);
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			
			//update salt & password into the user table
			$update_data = array('salt'=>$salt,'password'=>$password_hash);
            $this->db->where('email',$this->input->post('email',TRUE));
            $this->db->update('members',$update_data);
			
			//echo $emailbody; echo "<br><br>";
			
			//echo $username."<br>".$new_password."<br>".$password_hash; exit;
			//echo $this->email->print_debugger();exit;			
		}
	}
	
	public function check_email()
	{
		$options = array('email'=>$this->input->post('admin_email',TRUE));
        $query = $this->db->get_where('members',$options);
		return $query->num_rows();
	}
	
	public function get_captcha(){
	// load codeigniter captcha helper
		$this->load->helper('captcha');
		//delete old captcha images
		$this->delete_old_captcha();

		$vals = array(
		'word' => strtolower(random_string('alnum', 8)),
		'img_path'	 => './'.CAPTCHA_PATH,
		'img_url'	 => base_url().CAPTCHA_PATH,
		'img_width'	 => 138,
		'img_height' => 28,
		'border' => 0, 
		//'font_path'	 => './'.FONT_PATH.'Instruction.ttf',  
		'font_path'	 => './'.ADMIN_THEMES_DIR.'fonts/proximanova-bold-webfont',
		'expiration' => 7200
		);
		
		//echo $vals['font_path']; exit;
		 // create captcha image
		$cap = create_captcha($vals);
		// store the captcha word in a session
		$this->session->set_userdata('admin_captcha', $cap['word']);
		//echo $cap['word']; echo $cap['image'];exit;
		return $cap['image'];   
    }
	
	private function delete_old_captcha(){
        /** define the captcha directory **/
        $dir = './'.CAPTCHA_PATH;
        
        /*** cycle through all files in the directory ***/
        foreach (glob($dir."*.jpg") as $file) {
        //echo filemtime($file); echo '<br/>';
        /*** if file is 24 hours (86400 seconds) old then delete it ***/
        if (filemtime($file) < time() - 3600) {
             @unlink($file);
             //echo $file;
            }
        }
    }
}
