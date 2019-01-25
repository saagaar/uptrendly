<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Front_help extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();	
	}
	
	public function get_help_contents()
	{	    
	    $this->db->select('id, title, description');
		$this->db->where('is_display','Yes');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('help');
		if($query->num_rows() > 0)
		{
			$data = $query->result();
			$query->free_result();
			return $data;
		}
		return FALSE;
	}
	
}