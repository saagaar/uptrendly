<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_currency extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();	
	}
		
	public function file_settings_do_upload()
	{
				$config['upload_path'] = './'.BID_PACKAGE_PATH;//define in constants
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['remove_spaces'] = TRUE;		
				$config['max_size'] = '60';
				$config['max_width'] = '625';
				$config['max_height'] = '385';
				
				//load upload library and set config
				if(isset($_FILES['picture1']['tmp_name']))
				{
				
				$this->upload->initialize($config);
				$this->upload->do_upload('picture1');
		
				}						
	}
		
	public $validate_currency =  array(
		array('field' => 'currency_code', 'label' => 'Currency Code', 'rules' => 'required'),
		array('field' => 'currency_sign', 'label' => 'Currency Sign', 'rules' => 'required'),
		array('field' => 'is_display', 'label' => 'Visible', 'rules' => 'required'),			
	);
		
	public function get_currency()
	{	
	    $query = $this->db->get('product_currency');
		
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}	
	
	public function get_currency_by_id($id)
	{
		$query = $this->db->get_where('product_currency',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	public function insert_currency_record()
	{
		$data = array(
               'currency_code' => $this->input->post('currency_code', TRUE),
			   'currency_sign' => $this->input->post('currency_sign', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),
			   // 'created_date' => $this->general->get_local_time('time'),			   
            );

		$this->db->insert('product_currency', $data); 
        return $this->db->affected_rows();


	}
	
	public function update_currency_record($id)
	{
		$data = array(
			   'currency_code' => $this->input->post('currency_code', TRUE),
			   'currency_sign' => $this->input->post('currency_sign', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),
			   // 'last_update' => $this->general->get_local_time('time'),            
            );

		$this->db->where('id', $id);
		$this->db->update('product_currency', $data);
		return $this->db->affected_rows();
	}
	
	
	

}
