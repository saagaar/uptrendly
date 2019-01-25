<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_payment_model extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public $validate_paypal =  array(
		array('field' => 'email', 'label' => 'PayPal Email', 'rules' => 'required')
	);
		
	public function file_settings_do_upload()
	{
		$config['upload_path'] = './'.PAYMENT_API_LOGO_PATH;//define in constants
		$config['allowed_types'] = 'gif|jpg|png';
		$config['remove_spaces'] = TRUE;		
		$config['max_size'] = '100';
		$config['max_width'] = '350';
		$config['max_height'] = '100';

		// load upload library and set config				
		if(isset($_FILES['logo']['tmp_name']))
		{
			$this->upload->initialize($config);
			$this->upload->do_upload('logo');
		}		
	}
		
	public function get_payment_gateway_info($id)
	{		
		$query = $this->db->get_where('payment_gateway',array("id"=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	public function update_paypal_settings($logo_full_path)
	{
		$data = array(
               'email' => $this->input->post('email', TRUE),
               'status' => $this->input->post('status', TRUE),               			   
			   'is_display' => $this->input->post('is_display', TRUE),			   
			   'last_update' => $this->general->get_local_time('time')
            );
		
		//only if new image is uploaded
		if(isset($logo_full_path) && $logo_full_path !="")
		{
			@unlink('./'.$this->input->post('logo_old'));
			$data['payment_logo'] = $logo_full_path;
		}
		
		$this->db->where('id', 1);
		$this->db->update('payment_gateway', $data); 
		//echo $this->db->last_query(); exit;
		
		return true;
	}
}
