<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestKaushal
 *
 * @author Aman Subedi
 */
class Emailtest extends CI_Controller {
    //put your code here
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
	{
		
		phpinfo();
	}
        public  function phpmail(){
            
        }
        
        public function cimail(){
            $this->load->library('email');

            $this->email->from('demo@nepaimpressions.com', 'Sujit Emultitechsolution Pvt. Ltd.');
            $this->email->to('pradeep@emultitechsolution.com');
            $this->email->cc('ktm.test1@gmail.com');
            $this->email->bcc('ktm.test@yahoo.com');

            $this->email->subject('CI Email Test');
            $this->email->message('Testing the email from Emts class.');

            $this->email->send();

            echo $this->email->print_debugger();
        }
}

?>
