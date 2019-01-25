<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_product_model extends CI_Model 

{

	public function __construct() 

	{

		parent::__construct();	

		$this->image_name_path='';

	}



	public $validate_product_campaign =  array
	(	

		array('field' => 'name', 'label' => 'Product Name', 'rules' => 'required|min_length[2]|max_length[100]'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'required|min_length[2]|max_length[300]'),
		array('field' => 'product_url', 'label' => 'Product url', 'rules' => 'required'),
		array('field' => 'least_fan_count', 'label' => 'Least Fan Count', 'rules' => 'required|numeric'),
		array('field' => 'price_range', 'label' => 'Price Range', 'rules' => 'required'),
		array('field' => 'submission_deadline', 'label' => 'Submission Deadline', 'rules' => 'required'),
	);
	public $validate_product_collab =  array
	(	
		array('field' => 'name', 'label' => 'Product Name', 'rules' => 'required|min_length[2]|max_length[100]'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'required|min_length[2]|max_length[300]'),
		array('field' => 'least_fan_count', 'label' => 'Least Fan Count', 'rules' => 'required|numeric'),
		array('field' => 'submission_deadline', 'label' => 'Submission Deadline', 'rules' => 'required'),
	);
	public $validate_report_addition =  array
	(	
		array('field' => 'page_like', 'label' => 'Page Like', 'rules' => 'required|integer'),
		array('field' => 'page_comment', 'label' => 'Comments', 'rules' => 'required|integer'),
		array('field' => 'page_share', 'label' => 'Share', 'rules' => 'required|integer'),
		array('field' => 'profile_like', 'label' => 'Like', 'rules' => 'integer'),
		array('field' => 'profile_comment', 'label' => 'Comments', 'rules' => 'integer'),
		array('field' => 'profile_share', 'label' => 'Share', 'rules' => 'integer'),

		array('field' => 'instagram_like', 'label' => 'Page Like', 'rules' => 'integer'),
		array('field' => 'instagram_comment', 'label' => 'Comments', 'rules' => 'integer'),
		
	);
	

	public $validate_host_an_auction_settings =  array(	

		array('field' => 'start_date_time', 'label' => 'Date & Time', 'rules' => 'required|callback_check_date'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'required|min_length[2]|max_length[300]'),
		array('field' => 'host_name', 'label' => 'Name', 'rules' => 'required|callback_unique_auction_name|callback_exclude_names'),
		array('field' => 'total_auctions', 'label' => 'Total Item', 'rules' => 'required'),
		//array('field' => 'category', 'label' => 'Category', 'rules' => 'required'),
		array('field' => 'start_bid_amount', 'label' => 'Starting Bid', 'rules' => 'required|numeric'),
		array('field' => 'free_shipping', 'label' => 'Free Shipping', 'rules' => 'required'),
		array('field' => 'public_private', 'label' => 'Public or Private', 'rules' => 'required'),
		array('field' => 'host_terms', 'label' => 'Auction Terms', 'rules' => 'required'),
	);

	

	public $validate_host_an_auction_co_seller_settings = array(

		array('field' => 'co_sellers_auctions', 'label' => 'Co Sellers Auctions', 'rules' => 'required|callback_check_coseller_auctions'),

	);

	

	//function to generate form validation rules for static_fields

	public function generate_validation_rules($static_field)

	{

		$static_field_validation_arr = array();

		if(isset($static_field['name']) && $static_field['name']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'name', 'label' => 'Product Name', 'rules' => 'required|min_length[2]|max_length[100]'));

		}

		

		if(isset($static_field['description']) && $static_field['description']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'description', 'label' => 'Description', 'rules' => 'required|min_length[2]|max_length[300]'));

		}

		

		if(isset($static_field['auction_start_time']) && $static_field['auction_start_time']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'auction_start_time', 'label' => 'Auction Start Time', 'rules' => 'required'));

		}

		

		if(isset($static_field['auction_end_days']) && $static_field['auction_end_days']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'auc_end_days', 'label' => 'Auction End Days', 'rules' => 'required|numeric'));

		}

		

		if(isset($static_field['auction_time_zone']) && $static_field['auction_time_zone']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'auction_time_zone', 'label' => 'Auction Time Zone', 'rules' => 'required'));

		}



		if(isset($static_field['currency']) && $static_field['currency']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'currency', 'label' => 'Currency', 'rules' => 'required'));

		}

		if(isset($static_field['bid_decrement']) && $static_field['bid_decrement']['display']=='1'){ 

			array_push($static_field_validation_arr,array('field' => 'bid_decrement', 'label' => 'Bid Decrement', 'rules' => 'required'));

		}

				

		return $static_field_validation_arr;

	}

	public function save_report($bidid)
	{

		$newdataarr=array();
		$pageid=$this->input->post('page_content_id',true);
		$profileid=$this->input->post('profile_content_id',true);
		$instagramid=$this->input->post('instagram_content_id',true);
		$pagelike=$this->input->post('page_like',true);
		$profilelike=$this->input->post('profile_like',true);
		$instagramlike=$this->input->post('instagram_like',true);
		$pagecomment=$this->input->post('page_comment',true);
		$profilecomment=$this->input->post('profile_comment',true);
		$instagramcomment=$this->input->post('instagram_comment',true);
		$pageshare=$this->input->post('page_share',true);
		$profileshare=$this->input->post('profile_share',true);
		$biddata=$this->general->get_single_row('product_bids',array('id'=>$bidid));
		$productid=$biddata->product_id;
		$this->db->trans_start();
		$this->db->delete('report',array('bid_id'=>$bidid));
		$this->db->insert('report',array('content_id'=>$pageid,'likes'=>$pagelike,'comments'=>$pagecomment,'share'=>$pageshare,'bid_id'=>$bidid,'product_id'=>$productid));
		$this->db->insert('report',array('content_id'=>$profileid,'likes'=>$profilelike,'comments'=>$profilecomment,'share'=>$profileshare,'bid_id'=>$bidid,'product_id'=>$productid));
		$this->db->insert('report',array('content_id'=>$instagramid,'likes'=>$instagramlike,'comments'=>$instagramcomment,'bid_id'=>$bidid,'product_id'=>$productid));

		
		$this->db->update('product_bids',array('status'=>'7'),array('id'=>$bidid));

		/***************For closing product if not bidder are found***************/
		$this->db->where('status in ("0","1","2")');
		$this->db->where('product_id',$productid);
		$query=$this->db->get('product_bids');
		if($query->num_rows()<1)
		{	
			$this->db->update('products',array('status'=>'4'),array('id'=>$productid));
		}
		// $this->db->insert_batch('report',$newdataarr);
		$this->db->trans_complete();
		if($this->db->trans_status()===false)
		{
			return false;
		}
		return true;
	}
	//function to count total products
	public function count_total_products($status)
	{
		$this->db->select('P.*, PC.name as cat_name, M.username as buyer_name');

		$this->db->from('products P');

		$this->db->join('category PC', 'P.cat_id = PC.id', 'left');

		$this->db->join('members M', 'P.brand_id = M.id', 'left');

		if($status && $status != 'all')

			$this->db->where('P.status', $status);

		if($this->input->post('srch')!=""){

			$this->db->where("(M.username LIKE '%".$this->input->post('srch',TRUE)."%' OR M.email LIKE '%".$this->input->post('srch',TRUE)."%')");

		}

		$query = $this->db->get();

		return $query->num_rows();

	}

	

	

	public function get_product_lists($status, $limit, $start)

	{
		$prefix=$this->db->dbprefix;
		$this->db->select('P.*, 
			(select count(pb.id)  from '.$prefix.'product_bids pb where  pb.status not in ("7") and pb.product_id=P.id and pb.upload_status ="1" and  DATE_ADD(CAST(pb.upload_date AS DATE),INTERVAL +7 DAY) <"'.date('Y-m-d',strtotime($this->general->get_local_time('now'))).'") as completedcount , 
			PC.name as cat_name, M.name as buyer_name');
		$this->db->from('products P');
		$this->db->join('category PC', 'P.cat_id = PC.id', 'left');
		$this->db->join('members_details M', 'P.brand_id = M.user_id', 'left');
		if($status && $status != 'all')
			$this->db->where('P.status', $status);
		if(trim($this->input->post('srch'))!=""){
			$this->db->where("(P.name LIKE '%".$this->input->post('srch',TRUE)."%' OR M.id LIKE '%".$this->input->post('srch',TRUE)."%' OR M.name LIKE '%".$this->input->post('srch',TRUE)."%') OR  (P.create_type='".strtolower($this->input->post('srch',TRUE))."') OR (P.create_type='".strtolower($this->input->post('srch',TRUE))."')");
		}
		if($this->input->post('type')!=""){
			$this->db->where("(P.create_type='".strtolower($this->input->post('type',TRUE))."') OR (P.create_type='".strtolower($this->input->post('type',TRUE))."')");
		}
		$this->db->order_by('P.id','DESC');

		//$this->db->group_by('id','DESC');

		$this->db->limit($limit, $start);
		$query = $this->db->get();
 		// echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
		  return $query->result();
		}
		return FALSE;

	}
	public function get_product_byid($id)
	{
		$this->db->select('*,p.name as product_name');
		$this->db->from('products p');
		$this->db->join('members m','p.brand_id=m.id');
		 $this->db->where(array('p.id'=>$id));
		 $query =$this->db->get();	
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
	}

	public function get_categories_byproduct($product_id)
	{
		$query = $this->db->get_where('emts_product_post_categories',array('product_id'=>$product_id));
		if ($query->num_rows() > 0)
		{
		   return $query->result('array');
		} 
		return false;
	}

	public function get_basic_fields_meta_values($product_id)
	{
		$this->db->select('MP.meta_fields_id, MP.value, MF.type');
		$this->db->from('meta_products MP');
		$this->db->join('meta_fields MF','MP.meta_fields_id=MF.id','LEFT');
		$this->db->where('MP.product_id',$product_id);
		$this->db->where('MF.form_field_type','basic');
		$query = $this->db->get('');
		if($query->num_rows()>0)
		{
			$data = $query->result();
			$new_arr = array();
			foreach($data as $custom)
			{
				$new_arr[$custom->meta_fields_id] = $custom->value;
			}
			return $new_arr;
		}
		return false;
	}

	public function get_custom_fields_by_category_id($cat_id)
	{
		$this->db->select('MF.*, MC.*');
		$this->db->from('meta_fields MF');
		$this->db->join('meta_categories MC', 'MF.id = MC.field_id', 'left');
		$this->db->where('MC.category_id',$cat_id);
		$this->db->order_by('MC.field_order');
		$query = $this->db->get();

		//echo $this->db->last_query(); exit;

		if($query->num_rows()>0)

		{

			return $query->result();

		}

		return false;

	}

	

	public function get_basic_fields()

	{

		$this->db->where('form_field_type','basic');

		$this->db->order_by('basic_field_order','ASC');		

		$query = $this->db->get('meta_fields');

		if ($query->num_rows() > 0){

		   return $query->result();

		}

		return false;

	}

	

	

	//get custom fields files of specific category

	public function get_custom_fields_meta_files($product_id)

	{

		$this->db->select('MP.meta_fields_id, MP.value, MF.type');

		$this->db->from('meta_products MP');

		$this->db->join('meta_fields MF','MP.meta_fields_id=MF.id','LEFT');

		$this->db->where('MP.product_id',$product_id);

		$this->db->where('MF.form_field_type','custom');

		$this->db->where('MF.type','FILE');

		$query = $this->db->get('');

		//echo $this->db->last_query(); exit;

		if($query->num_rows()>0)

		{

			$data = $query->result();

			$new_arr = array();

			foreach($data as $custom){

				$new_arr[$custom->meta_fields_id] = $custom->value;

			}

			//print_r($new_arr);

			return $new_arr;

		}

		return false;

	}

	

	

	public function get_custom_fields_meta_values($product_id)

	{

		$this->db->select('MP.meta_fields_id, MP.value, MF.type');

		$this->db->from('meta_products MP');

		$this->db->join('meta_fields MF','MP.meta_fields_id=MF.id','LEFT');

		$this->db->where('MP.product_id',$product_id);

		$this->db->where('MF.form_field_type','custom');

		$query = $this->db->get('');

		//echo $this->db->last_query(); exit;

		if($query->num_rows()>0)

		{

			$data = $query->result();

			$new_arr = array();

			foreach($data as $custom)

			{

				$new_arr[$custom->meta_fields_id] = $custom->value;

			}

			return $new_arr;

		}

		return false;

	}

	

	

	public function get_product_images_by_product_id($product_id)

	{

		$query = $this->db->get_where('product_images',array('product_id'=>$product_id));



		if ($query->num_rows() > 0){

		   return $query->result();

		} 

		return false;

	}

	

	

	//function to populate custom fields and their values for sell item and edit item

	public function get_custom_fields_html_by_category($cat_id, $cf_post_value, $operation, $cf_old_files, $type='custom')

	{

		//return $operation; exit;

		//echo "<pre>"; print_r($cf_post_value); echo "</pre>"; //exit;

		

		//now check whther this category contains custom fields or not

		if($type=='custom'){

			$custom_fields = $this->get_custom_fields_by_category_id($cat_id);

		}else if($type=='basic'){

			$custom_fields = $this->get_basic_fields($cat_id);

		}

		//echo "<pre>"; print_r($custom_fields); echo "</pre>"; exit;

		

		if($custom_fields)

		{

			//define new variable for holding full html input field and store heading if it is a custom form field

			$html = $cat_id>0?'<div class="title_h3">Additional Information</div>':'<div class="title_h3">Basic Informations</div>';

			$html .='<ul class="frm">'; //open ul tag

			

			//create an array of checkboxes values when user checks to remove previous file and add new file

			//product edit section when user checks to delete previous file and chooses new file

			$old_metafile_arr = array();

			if(isset($_POST['old_metafile']) && !empty($_POST['old_metafile'])){

				$old_metafile_arr = $this->input->post('old_metafile',TRUE);

			}

			//echo "<pre>";print_r($old_metafile_arr); echo "</pre>"; //exit;

			

			

			foreach($custom_fields as $field)

			{

				//now get validation rules for this category

				$input = '';

				$accept = '';  //for accepted files type

				$extension = '';

				$error_message = '';

				$validation_class = '';  //for jquery validation class e.g.  <input class="required number ....">

				$validation_rules_pipe = '';  //for server side validation e.g. 'rules'=>'required|number|.....'

				$validation_extra_param = '';  //to hold extra fields in input tag. like custom validation message, max min values etc

				

				//get validation json and decode it

				$validation_rules_json = $field->validation_rules;

				$validation_rules = json_decode($validation_rules_json);

				//echo "<pre>"; print_r($validation_rules); echo "</pre>";

				

				if($field->type=='FILE')

				{

					if(isset($validation_rules->required) && $validation_rules->required=='true'){

						if (($operation=='add' && empty($_FILES['metafile_'.$field->id]['name'][$field->id])) OR ($operation=='edit' && $old_metafile_arr && in_array($field->id, $old_metafile_arr) && (empty($_FILES['metafile_'.$field->id]['name'][$field->id]) && !isset($cf_post_value[$field->id]))))

						{

							//return "hello ".$field->id; exit;

							//echo $_FILES['metafile_'.$field->id]['name'];

							

							// this is required field so define required for server side

							$validation_rules_pipe = 'required|';

							

							//format extensions

							//$valid_extensions = str_replace(',', '|', $field->extensions);

							//echo $valid_extensions;

							

							//this is required field so define required for client side

							$validation_class .= ' required';

						

							if($_POST && !$this->input->is_ajax_request()){

								$error_message = '<div class="error">The '.$field->name.' is required.</div>';

							}

						}

						

						$valid_extensions = str_replace(',', '#', $field->extensions);

						

						//Now push validation rules

						//array_push($this->validate_product_settings, array('field' => 'metafile_'.$field->id, 'label' => $field->name, 'rules' => $validation_rules_pipe.'callback__check_file_extension['.$field->id.'#'.$valid_extensions.']'));

						array_push($this->validate_product_settings, array('field' => 'metafile_'.$field->id, 'label' => $field->name, 'rules' => $validation_rules_pipe));

					}

				}else{

					if(isset($validation_rules->required) && $validation_rules->required=='true')

					{

						//now store validation rules in a local variable

						$validation_rules_pipe .= 'required';

						$validation_class .= ' required';

						

						//if form is not validated display validation error

						/*if($_POST){

							if($cf_post_value && array_key_exists($field->id, $cf_post_value) && (!$this->input->post('meta',TRUE) || $cf_post_value[$field->id] ==''))

							{

								$error_message = '<div class="error">The '.$field->name.' is required.</div>';

							}

						}*/

					}

					

					

					if(isset($validation_rules->email) && $validation_rules->email=='true')

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'valid_email':'|valid_email';

						$validation_class .= ' email';

					}

					

					

					if(isset($validation_rules->number) && $validation_rules->number=='true')

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'number':'|number';

						$validation_class .= ' number';

						

						//check max value, min value, digit validation etc

						if(isset($validation_rules->digits) && $validation_rules->digits=='true'){

							//now store validation rules for server side and client side in a local variable

							$validation_rules_pipe .= $validation_rules_pipe==''?'integer':'|integer';

						}

						

						if(isset($validation_rules->min) && isset($validation_rules->max)){

							//now store validation rules for server side and client side in a local variable

							$validation_rules_pipe .= $validation_rules_pipe==''?'greater_than['.$validation_rules->min.']':'|less_than['.$validation_rules->max.']';

						

						//add extra parameter for input tag to validate min/max value

						$validation_extra_param = 'min="'.$validation_rules->min.'" max="'.$validation_rules->max.'"';

						}

					}

					

					if(isset($validation_rules->url) && $validation_rules->url=='true')

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'valid_url':'|valid_url';

						$validation_class .= ' url';

					}

					

					if(isset($validation_rules->alpha) && $validation_rules->alpha=='true')

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'alpha':'|alpha';

						$validation_class .= ' alpha';

					}

					

					if(isset($validation_rules->alphanumeric) && $validation_rules->alphanumeric=='true')

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'alpha_numeric':'|alpha_numeric';

						$validation_class .= ' alphanumeric';

					}

					

					if(isset($validation_rules->minlength) && isset($validation_rules->maxlength))

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'min_length':'|min_length';

						$validation_extra_param = 'minlength="'.$validation_rules->minlength.'" maxlength="'.$validation_rules->maxlength.'"';

					}

					

					if(isset($validation_rules->exactlength) && $validation_rules->exactlength!='')

					{

						//now store validation rules for server side and client side in a local variable

						$validation_rules_pipe .= $validation_rules_pipe==''?'exact_length['.$validation_rules->exactlength.']':'|exact_length['.$validation_rules->exactlength.']';

						

						//$validation_extra_param = 'pattern=".{'.$validation_rules->exactlength.'}" title="Input string should be exactly '.$validation_rules->exactlength.' characters"';

						$validation_extra_param = 'exactlength="'.$validation_rules->exactlength.'"';

					}

					

					//now push the array into rule array add validation rules for server side

					array_push($this->validate_product_settings, array('field' => 'meta['.$field->id.']', 'label' => $field->name, 'rules' => $validation_rules_pipe));

					

					//if form is not validated display validation error

					$error_message = form_error('meta['.$field->id.']');

					//echo $error_message; exit;

				}

	

				//now check condition to determine the type of input field

				if($field->type=='TEXTAREA'){

					$input = '<textarea class="'.$validation_class.'" rows="7" name="meta['.$field->id.']" '.$validation_extra_param.'>'.($cf_post_value ?$cf_post_value[$field->id]:'').'</textarea>';	

				}else if($field->type=='DROPDOWN'){

					$input .= '<select name="meta['.$field->id.']" class="'.$validation_class.'">';

					$input .= '<option value="">Select '.$field->name.'</option>';

					$options = explode(",", $field->options);

					foreach($options as $option){

						if($cf_post_value && $cf_post_value[$field->id]==trim($option)){$selected='selected';}else{$selected='';}

						$input .= '<option value="'.trim($option).'" '.$selected.'>'.trim($option).'</option>';

					}

					$input .= '</select>';

				}else if($field->type=='RADIO'){

					$options = explode(",", $field->options);

					

					foreach($options as $option){

						//populate radio button

						$checked='';

						if( $cf_post_value ){

							if(array_key_exists($field->id, $cf_post_value)){

								if($cf_post_value[$field->id]==trim($option)){

									$checked='checked="checked"';

								}

							}

						}

						$input .= '<span><input name="meta['.$field->id.']" type="radio" class="'.$validation_class.'" value="'.trim($option).'" '.$checked.'>'.trim($option).' </span>';

					}

				}else if($field->type=='CHECKBOX'){

					//repopulate checkbox data

					$checked='';

					

					if($cf_post_value){

						if(array_key_exists($field->id, $cf_post_value)){

							if($cf_post_value[$field->id]!=''){

								$checked='checked';

							}

						}

					}

					$input = '<input type="checkbox" name="meta['.$field->id.']" class="inputtext'.$validation_class.'" value="1" '.$checked.'>';

				}else if($field->type=='FILE'){

					$type = explode(',',$field->extensions);

					foreach($type as $ext){

						if($ext=='doc'){

							$accept .= 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document';

							$extension .='doc,docx';

						}

						if($ext=='xls'){

							if($accept!=''){$accept .=','; $extension .=',';}

							$accept .='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/excel, application/vnd.ms-excel, application/vnd.msexcel';

							$extension .='xls,xlsx';

							}

						if($ext=='pdf'){

							if($accept!=''){$accept .=','; $extension .=',';}

							$accept .='application/pdf, application/x-pdf, application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf';

							//$accept .='application/pdf, application/x-pdf';

							$extension .='pdf';

						}

					}

					

					//echo "<pre>"; print_r($cf_post_value); echo "</pre>";

					//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;

					

					//echo (array_key_exists($field->id, $cf_post_value))?$cf_post_value[$field->id]:''.'\n';

					if($cf_post_value && array_key_exists($field->id,$cf_post_value)){

						//echo "found ".$field->id;; 

						$input = '<input type="checkbox" name="old_metafile[]" value="'.$field->id.'" class="update_metafile" /> '.$cf_post_value[$field->id];

						$input .= '<br>(Check to change this file)';

						

						$input .= '<input name="metafile_'.$field->id.'" type="file" accept="'.$accept.'" class="metafile" style="display:none"/>';

						//$input .= '<input name="metafile_'.$field->id.'" type="file" extension="'.$extension.'" class="metafile" style="display:none"/>';

					}else if($cf_old_files && array_key_exists($field->id,$cf_old_files)){

						$input_check_style='';

						$file_input_style = 'style="display:none"';

						if(($old_metafile_arr && in_array($field->id, $old_metafile_arr))){

							$input_check_style = 'checked="checked"';

							$file_input_style = 'style="display:block"';

						}

						

						$input = '<input type="checkbox" name="old_metafile[]" value="'.$field->id.'" class="update_metafile" '.$input_check_style.'/> '.$cf_old_files[$field->id];

						$input .= '<br>(Check to change this file)';

						$input .= '<input name="metafile_'.$field->id.'" type="file" accept="'.$accept.'" class="metafile" '.$file_input_style.' />';

						//$input .= '<input name="metafile_'.$field->id.'" type="file" extension="'.$extension.'" class="metafile"/>';

					}else{

						$input = '<input type="file" name="metafile_'.$field->id.'" class="'.trim($validation_class).'" accept="'.$accept.'">';

						//$input = '<input type="file" name="metafile_'.$field->id.'" class="'.trim($validation_class).'" extension="'.$extension.'" />';

					}

				}else if($field->type=='TEXT'){

					$input = '<input class="inputtext'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'" '.$validation_extra_param.'>';

				}else if($field->type=='NUMBER'){

					$input = '<input class="inputtext'.$validation_class.'" type="number"  name="meta['.$field->id.']" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'" '.$validation_extra_param.'>';

				}else if($field->type=='EMAIL'){

					$input = '<input class="inputtext'.$validation_class.'" type="email"  name="meta['.$field->id.']" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'" >';

				}else if($field->type=='URL'){

					$input = '<input class="inputtext'.$validation_class.'" type="url"  name="meta['.$field->id.']" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'">';

				}else if($field->type=='DATE'){

					$input = '<input class="inputtext datepicker'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'">';

				}else if($field->type=='DATETIME'){

					$input = '<input class="inputtext datetimepicker'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'">';

				}else{

					$input = '<input type="'.strtolower($field->type).'" name="meta['.$field->id.']" class="'.$validation_class.'" value="'.((isset($cf_post_value) && isset($cf_post_value[$field->id])) ?$cf_post_value[$field->id]:'').'">';

				}

				

				//now set asterisk for required fields.

				$required_mark = (isset($validation_rules->required) && $validation_rules->required=='true')?' <span>*</span>':'';

				

				//create view for html 

				$html .= '<li><div><label>'.$field->name.$required_mark.'</label>'.$input.'</div>'.$error_message.'</li>';

			}

			

			$html .='</ul>'; //close ul tag

			//echo "<pre>"; print_r($this->validate_product_settings); echo "</pre>"; exit;

			//now return html code generated.

			return $html;

		}

	}

	

	

	public function delete_product_image($product_id, $image)

	{

		$this->db->where(array('product_id'=>$product_id,'image'=>$image));

		$query = $this->db->delete('product_images');

		//echo $this->db->last_query();

		if($query){

			//unlink all the images

			@unlink(PRODUCT_IMAGE_PATH.$image);

			@unlink(PRODUCT_IMAGE_PATH.'thumb_'.$image);

			@unlink(PRODUCT_IMAGE_PATH.'upcoming_'.$image);

			@unlink(PRODUCT_IMAGE_PATH.'live_'.$image);

			

			return true;

		}

		return false;

	}

	

	

	

	public function update_product($product_id, $product_status)

	{

		$status = $this->input->post('status', TRUE);

		$submission_deadline = $this->input->post('submission_deadline', TRUE);
		$reject_reason='';
		if($this->input->post('reject_reason',true))
			$reject_reason=$this->input->post('reject_reason',true);

		//set product details info

		$product_data = array
						(	
							'cat_id' => $this->input->post('cat', TRUE),
							'name' => $this->input->post('name', TRUE),
							'description' =>$this->input->post('description'),
							'auction_type' => $this->input->post('auction_type', TRUE),
							'least_fan_count' => $this->input->post('least_fan_count', TRUE),
							'product_url' => $this->input->post('product_url', TRUE),
							'price_range' => $this->input->post('price_range', TRUE),			
							'submission_deadline' =>$submission_deadline,
							'save_method' => $this->input->post('save_method', TRUE),
							'budget' => $this->input->post('budget', TRUE),
							'status' => $status,			
							'reject_reason'	=>$reject_reason,
							'update_date' => $this->general->get_local_time('now')
						);

		$this->db->update('products',$product_data, array('id'=>$product_id));
		$userid=$this->data['product']->brand_id;
		$user=$this->general->get_single_row('members',array('id'=>$userid));
		$to=$user->email;
		$from=SYSTEM_EMAIL;
		$productname=$this->input->post('name', TRUE);
		$template='';
		if($product_status!=$status){
			if($status=='3'){
				$template='auction_closed_brand';
				$parseElement=array(
										'email'				 =>		 $to,	
										'product_name'		 =>		 $this->input->post('name', TRUE),
										'product_details'	 =>		 $this->input->post('description'),
										'price_range'		 =>		 $this->input->post('price_range', TRUE),
										'submission_deadline'=>		 $submission_deadline,
										'status'			 =>		 'Closed',
										'SITENAME'			 =>		WEBSITE_NAME

									);
				$notifymsg='You Campaign '.$productname.' have Been Closed by Admin .Check your email or consult Admin for more info';
				
			}
			elseif($status=='4'){
				$template='auction_cancel_notification_user';
				$parseElement=array
								(
									'email'				 =>		 $to,
									'product_name'		 =>		 $this->input->post('name', TRUE),
									'product_details'	 =>		 $this->input->post('description'),
									'price_range'		 =>		 $this->input->post('price_range', TRUE),
									'submission_deadline'=>		 $submission_deadline,
									'status'			 =>		 'Cancelled',
									'reject_reason'		 =>		 $reject_reason,
									'SITENAME'			 =>		WEBSITE_NAME
								);
				$notifymsg='You Campaign '.$productname.' have Been Cancelled by Admin .Check your email or consult Admin for more info';
			}
			else{
				$template='auction_update_notification_user';
				if($status=='2')
				{
					$stat='Active';
					$notifymsg='Your Campaign '.$productname.' has Been Activated .Check your email , you are live';	
				} 
				else 
				{
						$stat='Pending';
						$notifymsg='Your Campaign '.$productname.' has Been Updated .Check your email';
				}
				$parseElement=array
								(
									'product_name'		 =>		 $this->input->post('name', TRUE),
									'product_details'	 =>		 $this->input->post('description'),
									'price_range'		 =>		 $this->input->post('price_range', TRUE),
									'submission_deadline'=>		 $submission_deadline,
									'status'			 =>		 $stat,
									'email'				=>		 $to,
									'SITENAME'			 =>		WEBSITE_NAME
								);

				
			}
			
			$this->notification->send_email_notification($template, $userid, $from, $to, '', '', $parseElement, array());
			$this->general->savethisasnotification($userid,$notifymsg);
		}
		

		//Now remove all the custom fields values for this product id

		//$this->db->delete('meta_products',array('product_id'=>$product_id));

		

		$sql = 'DELETE MP FROM emts_meta_products MP LEFT JOIN emts_meta_fields MF ON MP.meta_fields_id = MF.id WHERE MP.product_id = '.$product_id.' AND MF.type!="FILE"';

		$this->db->query($sql);

		//echo $this->db->last_query(); exit;

			

		//now add custom fields values in meta prodcuts table if it is not empty

		if(isset($_POST['meta']) && !empty($_POST['meta']))

		{

			$meta_data = array();

			foreach ($this->input->post('meta',TRUE) as $key=>$value){

				//$new_arr = array('category_id'=>$categories, 'field_id'=>$custom_field_id);

				array_push($meta_data, array('product_id'=>$product_id, 'meta_fields_id'=>$key, 'value'=>$value));

			}

			$this->db->insert_batch('meta_products', $meta_data); 

			//now change image location from temp to real db

		}

		

		

		//now remove old files if found

		if($this->input->post('old_metafile',TRUE))

		{

			//print_r($this->input->post('old_metafile')); exit;

			foreach($this->input->post('old_metafile') as $key=>$value)

			{

				//remove this only if new file is uploaded to take its place if its a required field

				if($_FILES['metafile_'.$value]['name']!=''){

					//echo $key." : ".$value."<br>";

					$query = $this->db->get_where('meta_products', array('meta_fields_id' => $value,'product_id'=>$product_id));

					//echo $this->db->last_query(); //exit;

					if ($query->num_rows() > 0)

					{

						$data = $query->row();

						//print_r($data);

						$del = $this->db->delete('meta_products', array('meta_fields_id' => $value,'product_id'=>$product_id));

						

						//echo $data->value."<br>";

						@unlink('/'.CUSTOM_FIELDS_FILES_PATH.$data->value);

					}

				}

			}

		}
		//upload new files if found

		if($_FILES)

		{

			//upload this file and store the content in database

			//echo "<pre>"; print_r($_FILES); echo "</pre>"; //exit;

			$meta_data = array();

			foreach($_FILES as $key => $value){

				//echo "<pre>"; print_r($value); echo "</pre>"; exit;

				$upload = $this->upload_custom_fields_files($key, CUSTOM_FIELDS_FILES_PATH);

				if($upload){

					//echo "<pre>"; print_r($upload); echo "</pre>";

					$meta_field_name = substr($key, 9);

					array_push($meta_data, array('product_id'=>$product_id, 'meta_fields_id'=>$meta_field_name, 'value'=>$upload['file_name']));

				}

			}

			if(!empty($meta_data)){

				$this->db->insert_batch('meta_products', $meta_data);

			}

		}



		

		//echo $this->db->last_query(); exit;

			

		$query = $this->db->get_where('product_images_temp',array('product_code'=>$this->input->post('pcodeimg', TRUE)));

			

		if ($query->num_rows() > 0)

		{ 

			$tmp_images =  $query->result();

			$img_cnt=0;

			$image_data = array();

				

			foreach($tmp_images as $img){

				//echo $img->image; 

				$source_img = './'.PRODUCT_IMAGE_PATH_TEMP.''.$img->image;

				$destination_img = './'.PRODUCT_IMAGE_PATH.''.$img->image;

				

				if(file_exists($source_img)){

					$movefile = copy($source_img, $destination_img); //move_uploaded_file($filename, $dest);

					if($movefile){

						//var_dump($movefile); //exit;

						//echo 'Source: '.$source_img; echo 'Destination: '.$destination_img; echo "<br>";

						//generate new name for product image

						

						$image_path_info = pathinfo($destination_img);

						$image_extension = $image_path_info['extension'];

						

						$new_image_name = 'PRODUCT-'.$this->input->post('pcodeimg',TRUE).$img_cnt.'.'.$image_extension;

						

						$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'thumb_'.$new_image_name,60,52); //55,74

						$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'upcoming_'.$new_image_name,180,130);

						$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'live_'.$new_image_name,204,150);

						$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, $new_image_name,420,275); //55,74

						

						@unlink(PRODUCT_IMAGE_PATH_TEMP.''.$img->image);

						@unlink(PRODUCT_IMAGE_PATH.''.$img->image);

						

						//push image details into array

						array_push($image_data, array('product_id'=>$product_id, 'image'=>$new_image_name));

						//echo "<pre>"; print_r($image_data); echo "</pre>";

					}

				}

				$img_cnt++;

			}

			//echo "<pre>"; print_r($image_data); echo "</pre>";//exit;

			

			$this->db->insert_batch('product_images', $image_data); //insert image into database in a batch

			//echo $this->db->last_query(); exit;

			

			//now delete temp images from database

			$query = $this->db->delete('product_images_temp',array('product_code'=>$this->input->post('pcodeimg', TRUE)));

		}

		//echo $this->db->last_query(); exit;

		return true;

	}

		

	

	

	public function upload_custom_fields_files($file,$location)

	{

		$config['upload_path'] = './'.$location;   //file upload location

		$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf';

		$config['remove_spaces'] = TRUE;

		$config['encrypt_name'] = TRUE; 

		/*$config['max_size'] = '5000';

		$config['max_width'] = '2000';

		$config['max_height'] = '2000';*/

		$this->upload->initialize($config);

		//print_r($file);

		//print_r($config);

		//echo $file; exit;

		

		$this->upload->do_upload($file);

		if($this->upload->display_errors())

		{

			$this->error_img = $this->upload->display_errors();

			//echo $this->error_img; exit;

			return false;

		}

		else

		{

			$data = $this->upload->data();

			return $data;

		}	

	}



	//function to resize images

	public function resize_image($location,$source_image,$new_image,$width,$height)

	{

		$config['image_library'] = 'gd2';

		$config['source_image'] = './'.$location.$source_image;

		$config['maintain_ratio'] = TRUE;

		$config['width'] = $width;

		$config['height'] = $height;

		$config['master_dim'] = 'width';

		$config['new_image'] = './'.$location.$new_image;

		

		$this->image_lib->initialize($config);

		$resize = $this->image_lib->resize();

		//echo $this->image_lib->display_errors();

		//$this->image_lib->clear(); 

	}

	

	public function file_settings_do_upload($file)

	{

		$config['upload_path'] = './'.PRODUCT_IMAGE_PATH;//define in constants

		$config['allowed_types'] = 'gif|jpg|png';

		$config['remove_spaces'] = TRUE;		

		$config['max_size'] = '2000';

		$config['max_width'] = '1000';

		$config['max_height'] = '1000';

		$this->upload->initialize($config);

		//print_r($_FILES);

		

		$this->upload->do_upload($file);

		if($this->upload->display_errors())

		{

			$this->error_img = $this->upload->display_errors();

			echo $this->error_img;

			return false;

		}

		else

		{

			$data = $this->upload->data();

			return $data;

		}			

	}

	public function count_total_bid_placed($status)
	{
		if($status=='pending')
		{
			$status ='0';
		}
		if($status=='progress'){
			$status="'1','2','3'";
		}
		if($status=='rejected'){
			$status="'4','5'";
		}
		if($status=='finished')
		{
			$status='7';
		}
		if($status)
		{
			$this->db->where('status in ('.$status.')');

		}
		$query = $this->db->get_where('product_bids');
		return $query->num_rows();
	}
	public function get_total_bid_placed($status, $limit, $start)
	{

		$this->db->select('PB.*, M.id as user_id,MD.name as membername,P.name as product, M.email, M.username, MD.name as first_name, MD.last_name');
		$this->db->from('product_bids PB');
		$this->db->join('products P','PB.product_id=P.id');
		$this->db->join('members M', 'M.id = PB.user_id', 'left');
		$this->db->join('members_details MD', 'M.id = MD.user_id', 'left');
		if($status=='pending')
		{
			$status ="'0'";
		}
		if($status=='progress'){
			$status="'1','2','3'";
		}
		if($status=='rejected'){
			$status="'4','5'";
		}
		if($status=='finished')
		{
			$status="'7'";
		}
		if($status!='')
		{
			$this->db->where('PB.status in ('.$status.')');

		}
		
		$this->db->order_by('PB.id','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		 $this->db->last_query();
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
	}

	

	public function count_total_bid_placed_on_product($product_id)
	{
		$query = $this->db->get_where('product_bids',array('product_id'=>$product_id));
		return $query->num_rows();
	}
	public function get_total_bid_placed_on_product($limit, $start, $product_id)
	{
		$this->db->select('PB.*, M.id as user_id,PB.id as bid_id,d.*, MD.name as membername,M.email,P.name as product, M.username, MD.name as name');
		$this->db->from('product_bids PB');
		$this->db->join('products P','PB.product_id=P.id');
		$this->db->join('draft_promotion d','d.bid_id=PB.id','LEFT');
		$this->db->join('members M', 'M.id = PB.user_id', 'left');
		$this->db->join('members_details MD', 'M.id = MD.user_id', 'left');
		$this->db->where('PB.product_id',$product_id);
		$this->db->order_by('PB.id','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
	}

	//get total credits spent by all users for bidding a single product

	public function get_total_bid_amount($product_id)

	{

		$this->db->select_sum('user_bid_amt');

		$query = $this->db->get_where('product_bids',array('product_id'=>$product_id));

		//echo $this->db->last_query(); exit;

		if ($query->num_rows() > 0)

		{

			$data = $query->row();

		   	return $data->user_bid_amt;

		}

		return false;

	}

	
	public function add_product()
	{

		$product_code = $this->input->post('pcodeimg',TRUE);

		//echo 'Product Code : '.$product_code;

		//set product details info

		$product_data = array(

			

			'product_code' => $product_code, //$this->input->post('pcodeimg',TRUE),

			'cat_id' => $this->input->post('cat', TRUE),

			'sub_cat_id' => $this->input->post('subcat', TRUE),

			'seller_id' => $this->session->userdata(ADMIN_LOGIN_ID),

			'name' => $this->input->post('name', TRUE),

			'description' =>$this->input->post('description'),

			'auction_type' => $this->input->post('auction_type', TRUE),

			'bid_decrement' => $this->input->post('bid_decrement', TRUE),

			

			'auction_time_zone' => $this->input->post('auction_time_zone', TRUE),

			'currency' => $this->input->post('currency', TRUE),

			

			'auc_start_time' =>$this->input->post('auction_start_time',TRUE),

			// 'auc_end_time' => $this->input->post('auction_end_time', TRUE),

			'auc_end_days' => $this->input->post('auc_end_days', TRUE),

			'budget' => $this->input->post('budget', TRUE),

			'status' => $this->input->post('status', TRUE),			

			'post_date' => $this->general->get_local_time('now'),			

		);

		

		if($product_data['status'] == 2)

		{

			$product_data['auc_end_time'] = $this->general->get_end_date($product_data['auc_start_time'], $product_data['auc_end_days']);

		}



		$this->db->insert('products',$product_data);

		$product_id = $this->db->insert_id();

		if($product_id)

		{

			//insert custom fields data if it is not empty

			if(isset($_POST['meta']) && !empty($_POST['meta']))

			{

				$meta_data = array();

				foreach ($this->input->post('meta',TRUE) as $key=>$value){

					//$new_arr = array('category_id'=>$categories, 'field_id'=>$custom_field_id);

					array_push($meta_data, array('product_id'=>$product_id, 'meta_fields_id'=>$key, 'value'=>$value));

				}

				$this->db->insert_batch('meta_products', $meta_data);

				//now change image location from temp to real db

			}

			

			if($_FILES)

			{

				//upload this file and store the content in database

				//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;

				

				//get all file extensions

				$meta_data = array();

				foreach($_FILES as $key => $value){

					//echo "<pre>"; print_r($value); echo "</pre>"; exit;

					$upload = $this->upload_custom_fields_files($key, CUSTOM_FIELDS_FILES_PATH);

					//print_r($upload);

					if($upload){

						//echo "<pre>"; print_r($upload); echo "</pre>";

						$meta_field_name = substr($key, 9);

						array_push($meta_data, array('product_id'=>$product_id, 'meta_fields_id'=>$meta_field_name, 'value'=>$upload['file_name']));

					}

				}

				if(!empty($meta_data)){

					$this->db->insert_batch('meta_products', $meta_data);

				}

			}

						

			//Image Operations

			$query = $this->db->get_where('product_images_temp',array('product_code'=>$product_code));

			//echo $this->db->last_query();

			

			if ($query->num_rows() > 0)

			{ 

				$tmp_images =  $query->result();

				$img_cnt=0;

				$image_data = array();

				

				foreach($tmp_images as $img){

					

					//echo $img->image; 

					$source_img = './'.PRODUCT_IMAGE_PATH_TEMP.''.$img->image;

					$destination_img = './'.PRODUCT_IMAGE_PATH.''.$img->image;

					

					if(file_exists($source_img)){

						$movefile = copy($source_img, $destination_img); //move_uploaded_file($filename, $dest);

						if($movefile){

							//var_dump($movefile);

							//generate new name for product image

							

							$path_info = pathinfo($destination_img);

							$image_ext = $path_info['extension'];

							

							$new_image_name = 'PRODUCT-'.$product_code.$img_cnt.'.'.$image_ext;

							

							$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'thumb_'.$new_image_name,60,52); //55,74

							$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'upcoming_'.$new_image_name,180,130);

							$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'live_'.$new_image_name,204,150);

							$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, $new_image_name,420,275); //55,74

							

							@unlink(PRODUCT_IMAGE_PATH_TEMP.''.$img->image);

							@unlink(PRODUCT_IMAGE_PATH.''.$img->image);

							

							//push image details into array

							array_push($image_data, array('product_id'=>$product_id, 'image'=>$new_image_name));

						}

					}

					$img_cnt++;

				}

				//echo "<pre>"; print_r($image_data); echo "</pre>";

				//now insert product images in batch

				$this->db->insert_batch('product_images', $image_data); //insert image into database in a batch

				//echo $this->db->last_query();

				

				//now delete temp images from database

				$query = $this->db->delete('product_images_temp',array('product_code'=>$product_code));

				//echo $this->db->last_query().'<br>';

			}

			return $product_id; 

		}

	}

	

	public function file_settings_do_upload_ajax($file, $location, $encrypt_filename='')

 	{

		$config['upload_path'] = './'.$location;   //file upload location

		$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';

		$config['remove_spaces'] = TRUE;  

		$config['max_size'] = '5000';

		$config['max_width'] = '2000';

		$config['max_height'] = '2000';

		if($encrypt_filename='encrypt')

		{

			//$config['file_name'] = $new_file_name;

			$config['encrypt_name'] = TRUE;

		}

		$this->upload->initialize($config);

		//print_r($_FILES);

		

		$this->upload->do_upload($file);

		if($this->upload->display_errors())

		{

			$this->error_img = $this->upload->display_errors();

			//echo $this->error_img;

			return false;

		}

		else

		{

			$data = $this->upload->data();

			return $data;

		}

	}

	public function send_email_notification_tobuyer($product_id,$formerstatus)

	{

		$template_id=42;

		$this->db->select('m.email,m.username,p.name,p.budget,p.update_date,p.status as prostatus,p.reject_reason');

		$this->db->from('emts_products as p');

		$this->db->join('emts_members as m','m.id=p.brand_id');

		$this->db->where('p.id',$product_id);

		$query=$this->db->get();



		$data=$query->row();



		if($data->prostatus==1)  $statuschanges='Updated';

		if($data->prostatus==2)  $statuschanges='Activated';

		if($data->prostatus==3)  $statuschanges='Closed';

		if($data->prostatus==4)  $statuschanges='Cancelled';

	

		$parseElement = array(

								'PRODUCT_NAME' 		=> $data->name,

								"USERNAME"			=> $data->username,

								"AMOUNT"			=> $data->budget,

								"DATE"				=> $data->update_date,

								"status"	    	=> $statuschanges,
								"REJECT_REASON"		=>	$data->reject_reason,

								"SITENAME"			=> WEBSITE_NAME

								

							);

		$from=SYSTEM_EMAIL;

		$to=$data->email;



		$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());

		return true;

	}

}

