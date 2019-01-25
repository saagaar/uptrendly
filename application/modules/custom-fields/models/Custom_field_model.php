<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Custom_field_model extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
	}
	
	public $validate_custom_fields =  array(
		array('field' => 'name', 'label' => 'Name', 'rules' => 'required'),
		//array('field' => 'categories', 'label' => 'Categories', 'rules' => 'required'),
		//array('field' => 'extension', 'label' => 'Extension', 'rules' => 'required'),
	);
	
	public function get_static_fields()
	{
		//$this->db->order_by('field_name','ASC');		
		$query = $this->db->get('product_static_fields');
		if ($query->num_rows() > 0){
		   return $query->result();
		} 
		return false;
	}
	
	public function get_visible_static_fields()
	{
		//$this->db->order_by('field_name','ASC');		
		$this->db->where('display','1');
		$query = $this->db->get('product_static_fields');
		if ($query->num_rows() > 0){
		   return $query->result();
		} 
		return false;
	}
	
	
	public function get_static_field_data_by_id($id)
	{
		//$this->db->order_by('field_name','ASC');
		$this->db->where('id',$id);		
		$query = $this->db->get('product_static_fields');
		if ($query->num_rows() > 0){
		   return $query->row();
		} 
		return false;
	}
	
	public function update_static_field($id)
	{
		$data = array(
			'field_label'=>$this->input->post('field_label',TRUE),
			'options'=>$this->input->post('options',TRUE),
			//'display'=>$this->input->post('display',TRUE),
		);
	
		$query = $this->db->update('product_static_fields', $data, array('id' => $id));
		if($query){return TRUE;}
		return false;
	}
	
	
	
	//function to get category with maximim numbers of custom fields.
	public function get_category_with_max_fields()
	{
		$this->db->select('MC.category_id, COUNT(MC.field_id) AS count, PC.name as category_name', false);
		$this->db->from('meta_categories MC');
		$this->db->join('product_categories PC','MC.category_id=PC.id','LEFT');
		$this->db->group_by('category_id');
		$this->db->order_by('count','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			$data = $query->row();
			return $data;
		}
		return false;
	}
	

	public function get_custom_meta_fields_by_category($category_id)
	{
		$this->db->select('MF.*');
		$this->db->from('meta_fields MF');
		$this->db->join('meta_categories MC','MF.id=MC.field_id','LEFT');
		$this->db->where('MF.form_field_type','custom');
		$this->db->where('MC.category_id',$category_id);
		$this->db->group_by('MC.field_id');
		$this->db->order_by('MC.field_order');
		$query = $this->db->get();

		//echo $this->db->last_query();exit;
		
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}
				
	
	public function get_basic_meta_fields_data()
	{
		$this->db->where('form_field_type','basic');
		$this->db->order_by('basic_field_order','ASC');		
		$query = $this->db->get('meta_fields');
		if ($query->num_rows() > 0){
		   return $query->result();
		} 
		return false;
	}
	
	
	
	public function get_meta_field_data_by_id($id)
	{		
		$query = $this->db->get_where('meta_fields',array("id"=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	
	
	public function get_custom_field_categories_by_id($id)
	{
		$query = $this->db->get_where('meta_categories',array("field_id"=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	
	
	public function insert_meta_field($form_field_type)
	{
		if($form_field_type=='custom' OR $form_field_type=='basic'){
			
			$current_time = $this->general->get_local_time('time');
			
			// for extensions
			$extensions = '';
			if($this->input->post('extension', TRUE)){
				foreach($this->input->post('extension', TRUE) as $key=>$value){
					$extensions .= $value.',';
				}
				$extensions =  rtrim($extensions,',');
			}
			
			//now get all the validations and encode them to json format
			$validations = array();
			$validation_rules = '';
			if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)=='EMAIL'){
				$validations['email'] = 'true';
			}
			if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)=='NUMBER'){
				$validations['number'] = 'true';
			}
			if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)=='URL'){
				$validations['url'] = 'true';
			}
			if($this->input->post('required',TRUE)){
				$validations['required'] = $this->input->post('required',TRUE);
			}
			
			
			/*if($this->input->post('alpha',TRUE)){
				$validations['alpha'] = $this->input->post('alpha',TRUE);
			}
			if($this->input->post('alphanumeric',TRUE)){
				$validations['alphanumeric'] = $this->input->post('alphanumeric',TRUE);
			}*/
			
			if($this->input->post('al_alnum',TRUE) && $this->input->post('al_alnum',TRUE)=='alpha'){
				$validations['alpha'] = "true";
			}
			if($this->input->post('al_alnum',TRUE) && $this->input->post('al_alnum',TRUE)=='alphanumeric'){
				$validations['alphanumeric'] = "true";
			}
			
			
			if($this->input->post('digits',TRUE)){
				$validations['digits'] = $this->input->post('digits',TRUE);
			}
			if($this->input->post('min',TRUE)){
				$validations['min'] = $this->input->post('min',TRUE);
			}
			if($this->input->post('max',TRUE)){
				$validations['max'] = $this->input->post('max',TRUE);
			}
			if($this->input->post('minlength',TRUE)){
				$validations['minlength'] = $this->input->post('minlength',TRUE);
			}
			if($this->input->post('maxlength',TRUE)){
				$validations['maxlength'] = $this->input->post('maxlength',TRUE);
			}
			if($this->input->post('exactlength',TRUE)){
				$validations['exactlength'] = $this->input->post('exactlength',TRUE);
			}
			
			if($validations && !empty($validations)){
				$validation_rules = json_encode($validations);
			}
			
			//echo $validation_rules; exit;
			
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'slug' => $this->input->post('name', TRUE),
				'type' => $this->input->post('type', TRUE),
				'options' => $this->input->post('options', TRUE),
				'extensions'=>$extensions,
				//'required'  => $this->input->post('required', TRUE),
				'validation_rules' => $validation_rules,
				'added_date' => $current_time,
				'last_update' => $current_time,
				'form_field_type'=>$form_field_type,
			);
			
			$this->db->insert('meta_fields',$data);
			$custom_field_id =  $this->db->insert_id();
			
			//now add categories
			$form_categories = $this->input->post('categories', TRUE);
			if($form_categories){
				//create an array to insert categories in batch
				$data = array();
				foreach($form_categories as $categories){
					//$new_arr = array('category_id'=>$categories, 'field_id'=>$custom_field_id);
					array_push($data, array('category_id'=>$categories, 'field_id'=>$custom_field_id));
				}
				$this->db->insert_batch('meta_categories', $data); 
			}
			return $custom_field_id;
		}
		return false;
	}
	
	

	public function update_meta_field($id,$form_field_type)
	{
		$current_time = $this->general->get_local_time('time');
		
		$extensions = '';
		if($this->input->post('extension', TRUE)){
			foreach($this->input->post('extension', TRUE) as $key=>$value){
				$extensions .= $value.',';
			}
			$extensions =  rtrim($extensions,',');
		}
		
		$validations = array();
		$validation_rules = '';
		if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)=='EMAIL'){
			$validations['email'] = 'true';
		}
		if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)=='NUMBER'){
			$validations['number'] = 'true';
		}
		if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)=='URL'){
			$validations['url'] = 'true';
		}
		if($this->input->post('required',TRUE)){
			$validations['required'] = $this->input->post('required',TRUE);
		}
		
		/*if($this->input->post('alpha',TRUE)){
			$validations['alpha'] = $this->input->post('alpha',TRUE);
		}
		if($this->input->post('alphanumeric',TRUE)){
			$validations['alphanumeric'] = $this->input->post('alphanumeric',TRUE);
		}*/
		
		if($this->input->post('al_alnum',TRUE) && $this->input->post('al_alnum',TRUE)=='alpha'){
			$validations['alpha'] = "true";
		}
		if($this->input->post('al_alnum',TRUE) && $this->input->post('al_alnum',TRUE)=='alphanumeric'){
			$validations['alphanumeric'] = "true";
		}
		
		if($this->input->post('digits',TRUE)){
			$validations['digits'] = $this->input->post('digits',TRUE);
		}
		if($this->input->post('min',TRUE)){
			$validations['min'] = $this->input->post('min',TRUE);
		}
		if($this->input->post('max',TRUE)){
			$validations['max'] = $this->input->post('max',TRUE);
		}
		if($this->input->post('minlength',TRUE)){
			$validations['minlength'] = $this->input->post('minlength',TRUE);
		}
		if($this->input->post('maxlength',TRUE)){
			$validations['maxlength'] = $this->input->post('maxlength',TRUE);
		}
		if($this->input->post('exactlength',TRUE)){
			$validations['exactlength'] = $this->input->post('exactlength',TRUE);
		}
		
		if($validations && !empty($validations)){
			$validation_rules = json_encode($validations);
		}
		
		//echo $validation_rules; exit;
		
		$data = array(
			'name' => $this->input->post('name', TRUE),
			'slug' => $this->input->post('name', TRUE),
		   	'type' => $this->input->post('type', TRUE),
		   	'options' => $this->input->post('options', TRUE), 
			'extensions'=>$extensions,
			//'required'  => $this->input->post('required', TRUE), 
			'validation_rules' => $validation_rules,
		   	'last_update' => $current_time, 
		);
		
		$this->db->update('meta_fields', $data, array('id' => $id));
		
		//now add categories
		$form_categories = $this->input->post('categories', TRUE);
		if($form_categories){
			//delete previous data from meta_categories table
			$this->db->delete('meta_categories',array('field_id'=>$id));
			
			//create an array to insert categories in batch
			$data = array();
			foreach($form_categories as $categories){
				//$new_arr = array('category_id'=>$categories, 'field_id'=>$custom_field_id);
				array_push($data, array('category_id'=>$categories, 'field_id'=>$id));
			}
			$this->db->insert_batch('meta_categories', $data); 
		}

		return true;
	}
	
	
	function sort_basic_meta_fields($list_order)
	{
		$list = explode(',' , $list_order);
		$i = 1 ;
		$data = array();
		foreach($list as $id) {
			array_push($data,array('id'=>$id,'basic_field_order'=>$i));
			$i++;
		}
		//print_r($data); exit;
		$this->db->where('form_field_type','basic');
		$this->db->update_batch('meta_fields', $data, 'id');
		//echo $this->db->last_query(); exit;
		return true;
	}
	
	function sort_custom_fields_by_category_id($cat_id,$list_order)
	{
		$list = explode(',' , $list_order);
		$i = 1 ;
		$data = array();
		foreach($list as $id) {
			array_push($data,array('field_id'=>$id,'field_order'=>$i));
			$i++;
		}
		//print_r($data); exit;
		$this->db->where('category_id',$cat_id);
		$this->db->update_batch('meta_categories', $data, 'field_id');
		//echo $this->db->last_query();
		return true;
	}
	
}
