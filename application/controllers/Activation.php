<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 

		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('/offline'),'refresh');
			exit;
		}
    }
 
    function email($user_id='',$encrypt='')
    {
		$this->data = array();
		//set SEO data
		$this->page_title = "Auktis";
		$this->data['meta_keys'] = "Auktis";
		$this->data['meta_desc'] = "Auktis";
					
		//check blank parameter variable
		if($user_id == '' || $encrypt == '')
		{
			redirect(site_url(''), 'refresh');exit;
		}
		
		//check num row into user table and if blank then redirect to home page.
		$query = $this->db->get_where('members',array("id"=>$user_id));
		if ($query->num_rows() == 1)
		{
		   $user_info = $query->row_array();
		   //print_r($user_info['id']);exit;
		   
		   //make encryption combination based with user info and check it with URL encrypted value
		   $db_encrypt = sha1(base64_encode($user_info['id']."&&".$user_info['email']."&&".$user_info['new_email']));
		   if($db_encrypt === $encrypt)
		   {
		   		$data=array('email'=>$user_info['new_email']);
                $this->db->where('id',$user_info['id']);
                $this->db->update('members',$data);
				
				
					
					$this->data['offline_msg']->heading = 'Email Activation';
					$this->data['offline_msg']->content = 'email activation';
					$this->load->view('offline',$this->data);
		   }
		   else
		   		{
					
					$this->data['offline_msg']->heading = 'Email Activation';
					$this->data['offline_msg']->content = 'Email Activation';
					$this->load->view('offline',$this->data);
				}
		   	
		} 
		else
			{
				redirect(site_url(''), 'refresh');exit;
			}
	
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */