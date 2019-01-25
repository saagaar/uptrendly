<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_module extends CI_Model
{
	public function __construct() 
	{
		parent::__construct();
		$this->image_name_path='';
	}
	
	//form validation rules for buyers profile
	public $validate_buyer_profile_settings = array(
		array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'),
		array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email|callback_profile_check_email'),
		array('field' => 'phone', 'label' => 'Phone', 'rules' => 'required'),
		array('field' => 'city', 'label' => 'City', 'rules' => 'required'),
		array('field' => 'country', 'label' => 'Country', 'rules' => 'required'),
		array('field' => 'company_website', 'label' => 'Company Website', 'rules' => 'required|valid_url'),
		array('field' => 'company_name', 'label' => 'Company Name', 'rules' => 'trim|required'),
		array('field' => 'company_address1', 'label' => 'Company Address', 'rules' => 'trim|required'),
		array('field' => 'company_city', 'label' => 'Company City', 'rules' => 'trim|required'),

	);
	//End Of form validation rules for buyers profile

	public $validate_supplier_profile_settings = array(
		array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'),
		array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email|callback_profile_check_email'),
		array('field' => 'phone', 'label' => 'Phone', 'rules' => 'required'),
		array('field' => 'company_country', 'label' => 'Country', 'rules' => 'required'),
		array('field' => 'company_name', 'label' => 'Company Name', 'rules' => 'trim|required'),
		array('field' => 'company_address1', 'label' => 'Company Address', 'rules' => 'trim|required'),
		array('field' => 'company_city', 'label' => 'Company City', 'rules' => 'trim|required'),
		array('field' => 'company_state', 'label' => 'Company State', 'rules' => 'trim|required'),
		array('field' => 'company_zipcode', 'label' => 'Company Post Code', 'rules' => 'trim|required'),
		array('field' => 'company_website', 'label' => 'Company Website', 'rules' => 'trim|required|valid_url'),
		array('field' => 'company_phone', 'label' => 'Company Phone', 'rules' => 'trim|required'),
		array('field' => 'description', 'label' => 'Company Description', 'rules' => 'trim|required'),
	);
	

	//validation for add/edit product in inventory
	public $validate_product_settings =  array(	
		array('field' => 'name', 'label' => 'Product Name', 'rules' => 'required|min_length[2]|max_length[100]'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'required|min_length[2]|max_length[300]'),
		array('field' => 'condition', 'label' => 'Condition', 'rules' => 'required'),
		array('field' => 'brand', 'label' => 'Brand', 'rules' => 'required'),
		array('field' => 'warranty', 'label' => 'Warranty', 'rules' => 'required'),
		array('field' => 'start_bid', 'label' => 'Start Bid', 'rules' => 'required'),
	);
	
	//validation rules for change password
	public $validate_change_password = array(
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|callback_check_password'),
		array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'trim|required|min_length[6]|max_length[20]'),
		array('field' => 're_new_password', 'label' => 'Confirm New Password', 'rules' => 'required|matches[new_password]'),	
	);	

	public $validate_package_purchase = array(
		array('field' => 'package' , 'label' => 'Membership Package', 'rules' => 'required'),
		array('field' => 'payment_type', 'label' => 'Payment Option', 'rules' => 'required'),
	);

	public $validate_invitation_settings = array(
		array('field' => 'user_email', 'label' => 'User Email', 'rules' => 'trim|required|callback_email_available'),
		array('field' => 'message', 'label' => 'Invitation Message' , 'rules' => 'trim|required|min_length[10]|max_length[100]'),
	);
	

	public $validate_supplier_expertise = array(
		array('field' => 'categories[]', 'label' => 'Expertise Area', 'rules' => 'required|callback_check_expertise_limit'),
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
		
		// if(isset($static_field['auction_type']) && $static_field['auction_type']['display']=='1'){ 
		// 	array_push($static_field_validation_arr,array('field' => 'condition', 'label' => 'Condition', 'rules' => 'required'));
		// }
		
		if(isset($static_field['auction_start_time']) && $static_field['auction_start_time']['display']=='1'){ 
			array_push($static_field_validation_arr,array('field' => 'auc_start_time', 'label' => 'Auction Start Time', 'rules' => 'required'));
		}
		
		// if(isset($static_field['auction_end_time']) && $static_field['auction_end_time']['display']=='1'){ 
		// 	array_push($static_field_validation_arr,array('field' => 'auc_end_time', 'label' => 'Auction End Time', 'rules' => 'required'));
		// }
		if(isset($static_field['auction_end_days']) && $static_field['auction_end_days']['display'] == '1')
		{
			array_push($static_field_validation_arr,array('field' => 'auc_end_days', 'label' => 'Auction End Days', 'rules' => 'required|integer|greater_than[0]'));
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
		// if(isset($static_field['budget']) && $static_field['budget']['display']=='1'){ 
		// 	array_push($static_field_validation_arr,array('field' => 'price', 'label' => 'Budget', 'rules' => 'required'));
		// }
		
		return $static_field_validation_arr;
	}
	
	// get member detail
	public function get_members_details($user_id='')
	{
		if($user_id!='')
		{
			$this->db->where('id',$user_id);
		}
		$query = $this->db->get('members');
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		return FALSE;
	}
	
	// to fetch members specified fields
	public function fetch_members_selected_fields($fields='', $where='')
	{
		if($fields!='')
		{
			$this->db->select($fields);
		}
		if($where!='')
		{
			$this->db->where($where);
		}
		$query = $this->db->get('members');
		//echo $this->db->last_query(); exit;
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		return FALSE;
	}
	
	// to update member selected fields
	public function update_members_selected_fields($fields, $where)
	{
		$update = $this->db->update('members',$fields, $where);
		if($update)
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	public function get_members_paypal_accounts($user_id)
	{
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('members_paypal_accounts');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}
	
	
	public function update_new_email_confirmation_email()
	{
	  
	  	$activation_code = $this->general->random_number();
		
		//set member info
		$data = array('new_email' => $this->input->post('email', TRUE),'activation_code'=>$activation_code);
			
		 //insert records in the database
		 $this->db->where('id', $this->session->userdata(SESSION.'user_id'));
		 $this->db->update('members',$data);
	
		//send email confirm to user
		
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
		$template = $this->email_model->get_email_template("email_confirmation");

        $subject = $template['subject'];
        $emailbody = $template['email_body'];
		
		//check blank value before send message
		if(isset($subject) && isset($emailbody))
		{
			// generate varification encryption
		    // $verify_encrypt =  sha1(base64_encode($profile->id."&&".$profile->email."&&".$profile->new_email));
			
			//parse email			
			$confirm="<a href='".site_url('/user/eactivation/index/'.$activation_code.'/'.$this->session->userdata(SESSION.'user_id'))."'>"."Click This Link"."</a>";
	
			$parseElement = array(
				"NAME"=>$this->input->post('name',TRUE),
				"CONFIRM"=>$confirm,
				"SITENAME"=>WEBSITE_NAME,
				"EMAIL"=>$this->input->post('email')
			);

			$subject=$this->email_model->parse_email($parseElement,$subject);
			$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
			//echo $emailbody; exit;		
			//set the email things
			$this->email->from(CONTACT_EMAIL);
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger(); 
			//exit;
		}
	}
	
	
	
	
	// upload users profile.
	public function change_profile_image($user_id)
	{
		//Upload image if file input is found and user id is not empty
		if($_FILES && $user_id)
		{
			//make file settins and do upload it
			$image_name = $this->file_settings_do_upload('profile_picture', USER_IMAGE_PATH, 'encrypt');
			//print_r($image1_name); exit;
			if($image_name['file_name'])
			{				
				//echo $image1_name['file_name']; exit;
				$this->image_name_path = $image_name['file_name'];
				//resize image
				$this->resize_image(USER_IMAGE_PATH,$this->image_name_path,$image_name['raw_name'].$image_name['file_ext'],100,80);
				//now remove old image
				@unlink(USER_IMAGE_PATH.$this->input->post('old'));
				
				//supdate 
				$this->update_members_selected_fields(array('image'=>$this->image_name_path), array('id'=>$user_id));
				return TRUE;
			}	
		}
		return FALSE;
	}
	

	public function change_users_password($member_id)
	{
		//generate password
		$salt = $this->general->salt();		
		$password = $this->general->hash_password($this->input->post('new_password',TRUE),$salt);
		$current_date = $this->general->get_local_time('time');
		
		//set member info
		$data = array(
		   'password' => $password,
		   'salt' => $salt,
		   'last_modify_date' => $current_date,
		);
		
		//insert records in the database
		$update = $this->db->update('members',$data,array('id'=> $member_id));
		if($update)
			return TRUE;
		return FALSE;
	}
	
	
	public function get_payment_gateway_byid($id)
	{
		$query = $this->db->get_where('payment_gateway',array('id'=>$id, 'is_display'=>'Yes'));
		
		if($query->num_rows()>0)
		{
			return $query->row();
		}
	}
	
	public function get_all_active_payment_gateways()
	{
		$query = $this->db->get_where('payment_gateway',array('is_display'=>'Yes'));
		
		//echo $this->db->last_query();exit;
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}
	
	function send_refer_email_to_friend()
	{
		//get this users details
		$user_id = $this->session->userdata(SESSION.'user_id');
		$fields = array('name','email');
		$seller_data = $this->fetch_members_selected_fields(array('name','email'), array('id'=>$user_id));
		
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
		$template = $this->email_model->get_email_template("refer_a_friend_email");

        $subject = $template['subject'];
        $emailbody = $template['email_body'];
		
		foreach($this->input->post('email', TRUE) as $key=>$value)
		{
			if($value!='')
			{
				//echo $ref_email;
				//check blank value before send message
				if(isset($subject) && isset($emailbody))
				{
					//parse email			
					$parseElement = array(
						"MESSAGE"=>$this->input->post('message',TRUE),
						"CONFIRM"=>"<a href='".site_url('?ref='.$user_id)."'>"."Click To Signup"."</a>",
						"FIRSTNAME"=>$seller_data->name,
						"SITENAME"=>WEBSITE_NAME,
					);
		
					$parsed_subject=$this->email_model->parse_email($parseElement,$subject);
					$parsed_emailbody=$this->email_model->parse_email($parseElement,$emailbody);
					//echo $emailbody; exit;		
					//set the email things
					$this->email->from(CONTACT_EMAIL,$seller_data->name);
					$this->email->to($value);
					$this->email->reply_to($seller_data->email,$seller_data->name);
					$this->email->subject($parsed_subject);
					$this->email->message($parsed_emailbody); 
					$this->email->send();
					//echo $this->email->print_debugger(); 
					//exit;
				}
			}
		}
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
	
	
	/*public function get_product_static_fields_data()
	{
		$this->db->where('display','1');		
		$query = $this->db->get('product_static_fields');
		if ($query->num_rows() > 0){
		   	$data = $query->result();
			//return $data;
			$new_arr = array();
		   	foreach($data as $key=>$value){
				$new_arr[$value->field_name]['field_name'] = $value->field_name;
				$new_arr[$value->field_name]['field_label'] = $value->field_label;
				$new_arr[$value->field_name]['options'] = $value->options;
				$new_arr[$value->field_name]['display'] = $value->display;
			}
			return $new_arr;
		} 
		return false;
	}*/
	
	
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
			$html = $cat_id>0?'<h4>Additional Information</h4>':'<h4><i class="fa fa-paperclip" aria-hidden="true">&nbsp;</i>Attach Supplementary Documents</h4>';
			
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
							$validation_class .= ' required ';
						
							if($_POST && !$this->input->is_ajax_request()){
								$error_message = '<p class="text-danger">The '.$field->name.' is required.</p>';
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
								$error_message = '<p class="text-danger">The '.$field->name.' is required.</p>';
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
					$input = '<textarea class="form-control form-control-2'.$validation_class.'" rows="7" name="meta['.$field->id.']" '.$validation_extra_param.'>'.($cf_post_value ?$cf_post_value[$field->id]:'').'</textarea>';	
				}else if($field->type=='DROPDOWN'){
					$input .= '<select name="meta['.$field->id.']" class="form-control select_control'.$validation_class.'">';
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
						$input .= '<span class="radio-inline"><input name="meta['.$field->id.']" type="radio" class="'.$validation_class.'" value="'.trim($option).'" '.$checked.'>'.trim($option).' </span>';
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
					$input = '<input type="checkbox" name="meta['.$field->id.']" class="'.$validation_class.'" value="1" '.$checked.'>';
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
						$input = '<input type="checkbox" name="old_metafile[]" value="'.$field->id.'" class="form-control update_metafile" /> '.$cf_post_value[$field->id];
						$input .= '<br>(Check to change this file)';
						
						$input .= '<input name="metafile_'.$field->id.'" type="file" accept="'.$accept.'" class="metafile filestyle"  data-buttonName="btn-primary" data-icon="false" data-buttonText="Browse"  style="display:none"/>';
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
						$input .= '<input name="metafile_'.$field->id.'" type="file" accept="'.$accept.'" class="metafile filestyle"  data-buttonName="btn-primary" data-icon="false" data-buttonText="Browse"  '.$file_input_style.' />';
						//$input .= '<input name="metafile_'.$field->id.'" type="file" extension="'.$extension.'" class="metafile"/>';
					}else{
						$input = '<input type="file" name="metafile_'.$field->id.'" class="'.trim($validation_class).' filestyle" data-buttonName="btn-primary" data-icon="false" data-buttonText="Browse" accept="'.$accept.'">';
						//$input = '<input type="file" name="metafile_'.$field->id.'" class="'.trim($validation_class).'" extension="'.$extension.'" />';
					}
				}else if($field->type=='TEXT'){
					$input = '<input class="form-control'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'" '.$validation_extra_param.'>';
				}else if($field->type=='NUMBER'){
					$input = '<input class="form-control'.$validation_class.'" type="number"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'" '.$validation_extra_param.'>';
				}else if($field->type=='EMAIL'){
					$input = '<input class="form-control'.$validation_class.'" type="email"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'" >';
				}else if($field->type=='URL'){
					$input = '<input class="form-control'.$validation_class.'" type="url"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'">';
				}else if($field->type=='DATE'){
					$input = '<input class="form-control datepicker'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'">';
				}else if($field->type=='DATETIME'){
					$input = '<input class="form-control datetimepicker'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'">';
				}else{
					$input = '<input type="'.strtolower($field->type).'" name="meta['.$field->id.']" class="'.$validation_class.'" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'">';
				}
				
				//now set asterisk for required fields.
				$required_mark = (isset($validation_rules->required) && $validation_rules->required=='true')?' <em>*</em>':'';
				
				//create view for html 
				// $html .= '<div class="form-group row"><div class="col-md-4 col-sm-5"><label>'.$field->name.'</label>'.$required_mark.'</div><div class="col-md-8 col-sm-7">'.$input.'</div>'.$error_message.'<div class="clearfix"></div></div>';
				$html .= '<div class="col-md-6 col-sm-12 form-group"><label>'.$field->name.'</label>'.$required_mark.$input.'</div>'.$error_message;
			}
			//echo "<pre>"; print_r($this->validate_product_settings); echo "</pre>"; exit;
			//now return html code generated.
			return $html;
		}
	}
	
	// to insert new product 
	public function insert_new_product($payment_type)
	{

	 	$username=$this->session->userdata(SESSION.'username');
		$user_id = $this->session->userdata(SESSION.'user_id');
		$product_code = $this->input->post('product_code',TRUE);		
		$auction_type = $this->input->post('auction_type', TRUE);
		$auction_start_time = $this->input->post('auc_start_time', TRUE);
		$days = $this->input->post('auc_end_days', TRUE);

		$categories = $this->input->post('categories', TRUE);
		if(empty($categories))
    		$categories = array();
		$product_data = array(
			'product_code' 		=> $product_code,
			// 'sub_cat_id' 		=> $this->input->post('subcat', TRUE),
			'seller_id' 		=> $user_id,
			'name' 				=> $this->input->post('name', TRUE),
			// 'category' 			=> $this->input->post('category', TRUE),
			'description' 		=> $this->input->post('description', TRUE),
			'auction_type' 		=> $this->input->post('auction_type', TRUE),
			'auc_start_time' 	=> $auction_start_time,
			'auction_type' 		=> $auction_type,
			'auction_time_zone' => $this->input->post('auction_time_zone', TRUE),
			'currency' 			=> $this->input->post('currency', TRUE),
			'bid_decrement' 	=> $this->input->post('bid_decrement', TRUE),
			'budget'			=> $this->input->post('price', TRUE),
			'post_date' 		=> $this->general->get_local_time('time'),
			'payment_type'		=> $payment_type,
			'auc_end_days'		=> $days,
		);

    		// $this->db->delete('emts_product_post_categories', array('user_id' => $user_id)); 
    	
    		
		if(AUCTION_POST_ACTIVATION == '1')
		{
			$product_data['status'] = '1'; // pending
			// show message to user
		}
		else
		{
			$product_data['status'] = '2'; // activated		
			$product_data['auc_end_time'] = $this->general->get_end_date($auction_start_time, $days);
		}
		
		$this->db->insert('products',$product_data);
		$product_id = $this->db->insert_id();

		// reduce user balance after auction post
		$this->general->reduce_balance($user_id, $payment_type);
		if($product_id)
		{
			foreach($categories as $value){
    		$datapostcat[]=array(
    						'user_id' 		=>	 $user_id,
    						'category_id'	=>	 $value,
    						'product_id'	=>	 $product_id
    					 );
    		}	
    		$this->db->insert_batch('emts_product_post_categories', $datapostcat);
			//sending email to supplier for matched category if auction type is public
			if((AUCTION_POST_ACTIVATION != '1') && ($auction_type=='1')){
				$parseElement = array(
						'description' 		=> $this->input->post('description', TRUE),
						"product_name"		=> $this->input->post('name',true),
						"auc_start_time"	=> $auction_start_time,
						"auc_end_days"		=> $days,
						"product_url"		=> site_url('my-account/auction_detail/'.$product_id),
						"budget"			=> $this->input->post('price', TRUE),
						"SITENAME"			=> WEBSITE_NAME
					);
				$this->send_email_notification_to_public($categories,$parseElement);	
			}
		
			

			//insert custom fields data if it is not empty
			if(isset($_POST['meta']) && !empty($_POST['meta']))
			//if(isset($this->input->post('meta',TRUE)))
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
			
			
			return $product_id; 
		}

		// if($auction_type == '1')
		// {
		// 	// send notification to member group based on category group
		// }
		// elseif($auction_type == '2')
		// {
		// 	// send notification to selected member
		// }
	}

/* sending email to supplier for matched category if auction type is public	 */
	public function send_email_notification_to_public($categories=array(),$parseElement=array()){
				$this->db->select('DISTINCT(email)');
				$this->db->from('emts_member_expertise a');
				$this->db->join('emts_members m','a.user_id=m.id');
				$this->db->where_in('category_id',$categories);
				$query=$this->db->get();
				$emailnotify=$query->result('array');
				$emailnotify = array_column($emailnotify, 'email');
				$toemail=implode(',',$emailnotify);
				$template_id='56';

				if($toemail!=''){
					$from=SYSTEM_EMAIL;
					$this->notification->send_email_notification($template_id, '', $from, $toemail, '', '', $parseElement, array());
				}
	}
	
	// to edit auction
	public function edit_auction($product_id, $product_status)
	{	
		$auction_type = $this->input->post('auction_type', TRUE);
		$auction_start_time = $this->input->post('auc_start_time', TRUE);
		$days = $this->input->post('auc_end_days', TRUE);
		$status = $this->input->post('status', TRUE);
		//set product details info
		$product_data = array(
			'cat_id' 			=> $this->input->post('cat', TRUE),
			'sub_cat_id' 		=> $this->input->post('subcat', TRUE),
			'seller_id' 		=> $this->session->userdata(SESSION.'user_id'),
			'name' 				=> $this->input->post('name', TRUE),
			'description' 		=> $this->input->post('description', TRUE),
			'auction_type' 		=> $this->input->post('auction_type', TRUE),
			'auc_start_time' 	=> $auction_start_time,
			'auc_end_days' 		=> $days,
			'auction_type' 		=> $auction_type,
			'auction_time_zone' => $this->input->post('auction_time_zone', TRUE),
			'currency' 			=> $this->input->post('currency', TRUE),	
			'bid_decrement' 	=> $this->input->post('bid_decrement', TRUE),
			'budget'				=> $this->input->post('price', TRUE),	
			'update_date' => $this->general->get_local_time('time'),
		);
		if($status = '2' && $product_status != '2')
		{
			$product_data['auc_end_time'] = $this->general->get_end_date($this->general->get_local_time('now'), $days);
		}
		$this->db->update('products',$product_data, array('id'=>$product_id));
		
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
		
		
		//echo $this->db->last_query(); exit;
		
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
			
		// $query = $this->db->get_where('product_images_temp',array('product_code'=>$this->input->post('pcodeimg', TRUE)));
			
		// if ($query->num_rows() > 0)
		// { 
		// 	$tmp_images =  $query->result();
		// 	$img_cnt=0;
		// 	$image_data = array();
				
		// 	foreach($tmp_images as $img){
		// 		//echo $img->image; 
		// 		$source_img = './'.PRODUCT_IMAGE_PATH_TEMP.''.$img->image;
		// 		$destination_img = './'.PRODUCT_IMAGE_PATH.''.$img->image;
				
		// 		if(file_exists($source_img)){
		// 			$movefile = copy($source_img, $destination_img); //move_uploaded_file($filename, $dest);
		// 			if($movefile){
		// 				//var_dump($movefile);
		// 				//generate new name for product image
						
		// 				$path_info = pathinfo($destination_img);
		// 				$image_ext = $path_info['extension'];
						
		// 				$new_image_name = 'PRODUCT-'.$this->input->post('pcodeimg',TRUE).$img_cnt.'.'.$image_ext;
						
		// 				$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'thumb_'.$new_image_name,60,52); //55,74
		// 				$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'upcoming_'.$new_image_name,180,130);
		// 				$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, 'live_'.$new_image_name,204,150);
		// 				$this->resize_image(PRODUCT_IMAGE_PATH, $img->image, $new_image_name,420,275); //55,74
						
		// 				@unlink(PRODUCT_IMAGE_PATH_TEMP.''.$img->image);
		// 				@unlink(PRODUCT_IMAGE_PATH.''.$img->image);
						
		// 				//push image details into array
		// 				array_push($image_data, array('product_id'=>$product_id, 'image'=>$new_image_name));
		// 				//echo "<pre>"; print_r($image_data); echo "</pre>";
		// 			}
		// 		}
		// 		$img_cnt++;
		// 	}
		// 	$this->db->insert_batch('product_images', $image_data); //insert image into database in a batch
			
		// 	//now delete temp images from database
		// 	$query = $this->db->delete('product_images_temp',array('product_code'=>$this->input->post('pcodeimg', TRUE)));
		// }
	}
	
	// to upload custom fields files
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
	
	
	public function file_settings_do_upload($file, $location, $encrypt_filename='')
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
	
	
	
	//function to resize images
	public function resize_image($location,$source_image,$new_image,$width,$height)
	{
		//echo "#Location :".$location.' #$original file : '.$source_image.' New file name :'.$new_image.' #width :'.$width.' #height'.$height;
		//echo './'.$location.$source_image;
		
        $config['image_library'] = 'gd2';
		$config['source_image'] = './'.$location.$source_image;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['master_dim'] = 'width';
		$config['new_image'] = './'.$location.$new_image;
		
		$this->image_lib->initialize($config);
		$resize = $this->image_lib->resize();
		//var_dump($resize);
		//echo $this->image_lib->display_errors();
		// $this->image_lib->clear(); 
	}
	
	
	
	public function copy_product_images($product_id,$new_product_code)
	{
		$i= 1;
		$temp_img_arr = array();
		$current_date = $this->general->get_local_time('time');
		
		//now get all the images in $product_id product and store to temp folder of $new_product_code product temp
		$previous_images = $this->get_product_images($product_id);
		if($previous_images){
			foreach($previous_images as $image){
				//create new name for product images
				$new_image_name = $new_product_code.$i.'.'.pathinfo($image->image, PATHINFO_EXTENSION);
				
				//copy product image to temp folder.
				copy(PRODUCT_IMAGE_PATH.''.$image->image, PRODUCT_IMAGE_PATH_TEMP.''.$new_image_name);
				array_push($temp_img_arr,array('product_code'=>$new_product_code,'image'=>$new_image_name,'added_date'=>$current_date));
				$i++;
			}
			//now bulk insert
			$this->db->insert_batch('product_images_temp',$temp_img_arr);
			return $this->get_product_temp_images($new_product_code);
		}
	}
	
	// updated by manish to change the view
	public function get_product_by_id($product_id, $user_id = 0)
	{
		$this->db->select('P.*, C.id as currency_id, C.currency_sign, C.currency_code');
		$this->db->from('products P');
		$this->db->join('product_currency C', 'P.currency = C.id');
		$this->db->where('P.id',$product_id);
		if($user_id && $user_id != 0 && $user_id >0)
			$this->db->where('seller_id',$user_id);
		$query = $this->db->get();
		// echo $this->db->last_query(); exit;
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$query->free_result();
			return $result;
		}
		return FALSE;
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
			return $new_arr;
		}
		return FALSE;
	}
	
	
	
	public function get_basic_fields_meta_values($product_id)
	{
		$this->db->select('MP.meta_fields_id, MP.value, MF.type');
		$this->db->from('meta_products MP');
		$this->db->join('meta_fields MF','MP.meta_fields_id=MF.id','LEFT');
		$this->db->where('MP.product_id',$product_id);
		$this->db->where('MF.form_field_type','basic');
		$query = $this->db->get();
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
		return FALSE;
	}
	
	
	
	public function get_product_images($product_id)
	{
		$this->db->select('id, image');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('product_images');
		if($query->num_rows>0)
		{
			return $query->result();
		}
		return FALSE;
	}
	
	public function get_product_temp_images($product_code)
	{
		$this->db->select('id, image');
		$this->db->where('product_code',$product_code);
		$query = $this->db->get('product_images_temp');
		if($query->num_rows>0){
			return $query->result();
		}
		return FALSE;
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
			
			return TRUE;
		}
		return FALSE;
	}
	
	
	
	public function remove_product_images_temp($product_code)
	{
		$query = $this->db->get_where('product_images_temp',array('product_code'=>$product_code));
		if($query->num_rows()>0)
		{
			$data = $query->result();
			if($data){
				foreach($data as $img){
				@unlink(PRODUCT_IMAGE_PATH_TEMP.''.$img->image);
				}
			}
			$this->db->delete('product_images_temp',array('product_code'=>$product_code));
		}
	}		
	
	public function get_product_details_by_id_for_purchase($product_id)
	{
		$this->db->select('P.product_code, P.name, P.name, P.retail_price, P.buy_now_price, P.package_weight, P.free_shipping, P.shipping_charge, P.package_size, P.buy_now_quantity, P.order_quantity, PIMG.image');
		$this->db->from('products P');
		$this->db->join('product_images PIMG','P.id=PIMG.product_id','LEFT');
		$this->db->where(array('P.id'=>$product_id,'buy_now'=>'1'));
		$this->db->where('P.buy_now_quantity > ','P.order_quantity');
		$this->db->group_by('P.id');
		$query = $this->db->get('');
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0){
			return $query->row();
		}
		return false;
	}
	
	//email to buyer to notify his/her payment is completed
	function send_payment_status_email_to_buyer($user_id, $product_id ,$invoice_id, $amount, $payment_method)
	{
		//load email library
		$this->load->library('email');
		$this->load->model('email_model');
		
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
		
		//get winner info
		$buyer_info = $this->fetch_members_selected_fields(array('name','email'), array('id'=>$user_id));
		
		//get product details by product id
		$product_info = $this->general->fetch_single_product_selected_fields(array('product_code','name'), array('id'=>$product_id));
		
		//generate invoice link
		$invoice_link = "<a href=".site_url(MY_ACCOUNT.'invoice/'.$invoice_id).">Invoice Link</a>";
		
		//Get payment completed template for product buyer
		$template = $this->email_model->get_email_template("pay_for_buy_now_product_status_email_buyer");
		
		if($template){
			//print_r($user_info);
			$subject = $template['subject'];
			$emailbody = $template['email_body'];
			
			//parse email
			$parseElement = array("NAME"=>$buyer_info->name,
				"INVOICE_ID"=>$invoice_id,
				"PAID_AMOUNT"=>DEFAULT_CURRENCY_SIGN.$amount,
				"PAYMENT_METHOD"=>$payment_method,
				"INVOICE_LINK"=>$invoice_link,                                  
				"PAYMENT_DATE"=>$this->general->get_local_time('time'),
				"PRODUCT_NAME" => $product_info->name,
				"SITENAME"=>WEBSITE_NAME,
			);
	
			$subject = $this->email_model->parse_email($parseElement,$subject);
			$emailbody = $this->email_model->parse_email($parseElement,$emailbody);
			
			//echo $emailbody; exit;
					
			//set the email parameters
			$this->email->from(CONTACT_EMAIL);
			$this->email->to($buyer_info->email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
		}
	}
	
	//email to admin if product is sold
	function product_sold_notification_admin($user_id, $product_id, $invoice_id, $amount, $payment_method)
	{
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

		//get Buyer info
		$buyer_info = $this->fetch_members_selected_fields(array('name','email'), array('id'=>$user_id));
		
		//get product details by product id
		$product_info = $this->general->fetch_single_product_selected_fields(array('product_code','name', 'seller_id'), array('id'=>$product_id));
		
		//get sellers info
		$seller_info = $this->fetch_members_selected_fields(array('name','email'), array('id'=>$product_info->seller_id));
		
		/*echo "<pre>";print_r($buyer_info);echo "</pre>";*/
		
		//complete this link after completing buyer module (winner module)
		$link = "<a href=".site_url('/dashboard/ordered-products/details/'.$invoice_id).">Order Detail Link</a>";
		
		//Get auction closed template for admin
		$template = $this->email_model->get_email_template("pay_for_buy_now_product_notification_admin");
		
		if($template)
		{
			$subject=$template['subject'];
			$emailbody=$template['email_body'];
			
			//parse email
			$parseElement = array(
				"INVOICE_ID"=>$invoice_id,
				"PAID_AMOUNT"=>DEFAULT_CURRENCY_SIGN.$amount,
				"PAYMENT_METHOD" => $payment_method,
				"ORDER_DETAIL_LINK"=>$link,
				"DATE"=>$this->general->get_local_time('time'),
				
				"BUYER_USER_ID" => $user_id,
				"BUYER_NAME" => $buyer_info->name,
				"BUYER_EMAIL" => $buyer_info->email,
				
				"SELLER_USER_ID" => $user_id,
				"SELLER_NAME" => $buyer_info->name,
				"SELLER_EMAIL" => $buyer_info->email,
				
				"SITENAME"=>WEBSITE_NAME,
			);
	
			$subject = $this->email_model->parse_email($parseElement,$subject);
			$emailbody = $this->email_model->parse_email($parseElement,$emailbody);
			
			//send test email
			//$this->send_test_email('email body', $emailbody);
					
			//echo $emailbody; exit;
					
			//set the email things
			$this->email->from(CONTACT_EMAIL);
			$this->email->to(CONTACT_EMAIL);
			$this->email->subject($subject);
			$this->email->message($emailbody);
			$this->email->send();
		}
	}
	
	//mail function to send mail to seller to notify that his/her product is sold
	function product_sold_notification_seller($user_id, $product_id, $invoice_id, $amount, $payment_method)
	{
		//load email library
    	$this->load->library('email');
		$this->load->model('email_model');
		
		
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
	
		//get Buyer info
		$buyer_info = $this->fetch_members_selected_fields(array('name','email'), array('id'=>$user_id));
		
		//get product details by product id
		$product_info = $this->general->fetch_single_product_selected_fields(array('product_code','name', 'seller_id'), array('id'=>$product_id));
		
		//get sellers info
		$seller_info = $this->fetch_members_selected_fields(array('name','email'), array('id'=>$product_info->seller_id));
		
		/*echo "<pre>";print_r($buyer_info);echo "</pre>";*/
		
		//Get product sold template for seller
		$template = $this->email_model->get_email_template("pay_for_buy_now_product_notification_seller");
		if($template)
		{
		
			$subject = $template['subject'];
			$emailbody = $template['email_body'];
			
			//parse email
			$parseElement = array(

				"SELLER"=>$seller_info->name,
				"PRODUCT_ID"=>$product_id,
				"PRODUCT_NAME"=>$product_info->name,
				"PAYMENT_METHOD" =>$payment_method,
				"PAID_AMOUNT"=>DEFAULT_CURRENCY_SIGN.$amount,
				"DATE"=>$this->general->get_local_time('time'),
				
				"BUYER_ID" => $user_id, 
				"BUYER_NAME"=>$buyer_info->name,
				"BUYER_EMAIL"=>$buyer_info->email,
				"SITENAME"=>WEBSITE_NAME
			);
		
			$subject = $this->email_model->parse_email($parseElement,$subject);
			$emailbody = $this->email_model->parse_email($parseElement,$emailbody);
			
			//send test email
			//$this->send_test_email('email to seller (subject)', $subject);
			//$this->send_test_email('email to seller (body)', $emailbody);
			//$this->send_test_email('email to seller (email id)', $seller_email);
					
			//echo $emailbody; exit;
					
			//set the email things
			$this->email->from(CONTACT_EMAIL);
			$this->email->to($seller_info->email);
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();	
		}
	} //end of send email to seller function	
	
	//function to send test email
	public function send_test_email($subject,$message)
	{
		$this->load->library('email');

		$this->email->from('demo@nepaimpressions.com', 'Pradip');
		//$this->email->to('ktm.test1@gmail.com');		
		$this->email->to('ktm.test@yahoo.com');
		
		$this->email->subject($subject);
		$this->email->message($message); 
		
		$this->email->send();
	}

	// added by sagar
	// to retrieve total no of live auctions
	public function count_all_buyer_auctions($buyer_id)
	{
		
		$this->db->where('seller_id', $buyer_id);
        return $this->db->count_all_results('products');
	}
	
	//to retrieve all auctions
	public function get_all_buyer_auctions($buyer_id,$limit=50,$offset=0)
	{
	
		$this->db->select('id, product_code, name, auc_start_time, auc_end_time, status');
		$this->db->where('seller_id', $buyer_id);
		$this->db->order_by("id", "desc"); 
		$this->db->limit($limit, $offset);
		$query = $this->db->get('products');
		 // $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}
	// to retrieve buyer live auctions 
	public function get_live_buyer_auctions($buyer_id)
	{
		$current_time = $this->general->get_local_time('now');
		$this->db->select('id, product_code, name, auc_start_time, auc_end_time, status');
		$this->db->where('seller_id', $buyer_id);
		$this->db->where('auc_end_time >', $current_time); // auction end date > current date time
		$this->db->order_by("id", "desc"); 
		// $this->db->limit($limit, $offset);
		$query = $this->db->get('products');
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}

	// added by manish
	// To update buyer profile
	public function update_buyer_profile($member_id)
	{
		// prepare update data array
		$update_data = array(
			'name'				=> $this->input->post('first_name',TRUE),
			'last_name'			=> $this->input->post('last_name',TRUE),
			'phone'				=> $this->input->post('phone',TRUE),
			'about_user'		=> $this->input->post('about_user',TRUE),
			'address'			=> $this->input->post('address',TRUE),
			'address2'			=> $this->input->post('address2',TRUE),
			'city'				=> $this->input->post('city',TRUE),
			'state'				=> $this->input->post('state',TRUE),
			'post_code'			=> $this->input->post('post_code',TRUE),
			'country'			=> $this->input->post('country',TRUE),
			'company_name'		=> $this->input->post('company_name',TRUE),
			'description'		=> $this->input->post('description',TRUE),
			'company_address1'	=> $this->input->post('company_address1',TRUE),
			'company_address2'	=> $this->input->post('company_address2',TRUE),
			'company_city'		=> $this->input->post('company_city',TRUE),
			'company_state'		=> $this->input->post('company_state',TRUE),
			'company_zipcode'	=> $this->input->post('company_zipcode',TRUE),
			'company_country'	=> $this->input->post('company_country',TRUE),
			'company_phone'		=> $this->input->post('company_phone',TRUE),
			'company_website'	=> $this->input->post('company_website',TRUE),
		);

		
		// update the user details and return update status
		$this->db->where('user_id', $member_id);
		return $this->db->update('members_details', $update_data);
	}

	// added by manish for cancel auction 
	// needs product code as paramenter
	public function cancel_auction($auction_id)
	{
		$this->db->where('product_code', $auction_id);
		$data = array(
			'status' => '4'
		);

		$this->db->update('products', $data);
		return $this->db->affected_rows() > 0;
	}
	
	// added by manish to get basic field key and values
	public function get_basic_fields_meta_key_values($product_id, $type)
	{
		$this->db->select('MP.meta_fields_id, MF.name,MF.type, MP.value');
		$this->db->from('meta_products MP');
		$this->db->join('meta_fields MF','MP.meta_fields_id=MF.id','LEFT');
		$this->db->where('MP.product_id',$product_id);
		$this->db->where('MF.form_field_type',$type);
		$query = $this->db->get('');
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0)
		{
			$data = $query->result();
			$new_arr = array();
			foreach($data as $custom)
			{
				$new_arr[$custom->meta_fields_id] = $custom;
			}
			return $new_arr;
		}
		return FALSE;
	}

	// added by manish
	// get messages 
	public function get_messages($user_id)
	{
		$this->db->select('COM.id, M.username as sender, COM.subject, COM.message, COM.date');
		$this->db->from('communication COM');
		$this->db->join('members M', 'COM.sender = M.id');
		$this->db->where('COM.receiver', $user_id);
		$this->db->where('COM.inbox_status !=', '3');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}

	// added by manish
	// get message details
	public function get_message_detail($user_id, $message_id)
	{
		$this->db->select('COM.id, COM.msg_root_id, M.email, COM.subject, COM.message, COM.date');
		$this->db->from('communication COM');
		$this->db->join('members M', 'COM.sender = M.id');
		$this->db->where('COM.receiver', $user_id);
		$this->db->where('COM.id', $message_id);
		$this->db->where('COM.inbox_status !=',  '3');
		$this->db->limit(1);
		$query = $this->db->get();		
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}

	// added by manish
	// to retrieve membership package for both buyer and supplier
	public function get_membership_packages($member_type='')
	{
		// 1 for buyer and 2 for supplier
		if($member_type =='buyer')
			$this->db->where('member_type', '1'); 
		else if($member_type == 'supplier' )
			$this->db->where('member_type', '2');

		$this->db->where('is_display','1');
		$query = $this->db->get('membership_package');
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}

	// added by manish
	// to count total live public auction 
	public function count_all_live_public_auctions()
	{
		$current_time = $this->general->get_local_time('now');

		$category = $this->input->post('cat', TRUE);
		$subcategory = $this->input->post('subcat', TRUE);
		
		$this->db->where('auc_end_time >', $current_time); // auction end date > current date time
		$this->db->where('status', '2'); // status active
		$this->db->where('auction_type', '1');

		if($category && $category > 0)
			$this->db->where('cat_id', $category);
		if($subcategory && $subcategory > 0)
			$this->db->where('sub_cat_id', $subcategory);

		$query = $this->db->get('products');
		return $query->num_rows();
		
	}

	// added by manish
	// to retrieve all public products
	public function get_live_public_products($limit, $offset)
	{
		$current_time = $this->general->get_local_time('now');

		$category = $this->input->post('cat', TRUE);
		$subcategory = $this->input->post('subcat', TRUE);

		$this->db->select('id, product_code, name, description, auc_start_time, auc_end_time, status');
		
		$this->db->where('auc_end_time >', $current_time); // auction end date > current date time
		$this->db->where('status', '2'); // status active
		$this->db->where('auction_type', '1');

		if($category && $category > 0)
			$this->db->where('cat_id', $category);
		if($subcategory && $subcategory > 0)
			$this->db->where('sub_cat_id', $subcategory);
		
		if($limit)
			$this->db->limit($limit, $offset);
		$query = $this->db->get('products');
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}
	
	// added by manish
	// to update supplier profile
	public function update_supplier_profile($member_id)
	{
		// prepare update data array
		$update_data = array(
			'name'				=> $this->input->post('first_name',TRUE),
			'last_name'			=> $this->input->post('last_name',TRUE),
			'phone'				=> $this->input->post('compnay_phone',TRUE),
			'address'			=> $this->input->post('company_address1',TRUE),
			'address2'			=> $this->input->post('company_address2',TRUE),
			'city'				=> $this->input->post('company_city',TRUE),
			'state'				=> $this->input->post('company_state',TRUE),
			'post_code'			=> $this->input->post('company_zipcode',TRUE),
			'country'			=> $this->input->post('company_country',TRUE),
			'company_name'		=> $this->input->post('company_name',TRUE),
			'description'		=> $this->input->post('description',TRUE),
			'company_address1'	=> $this->input->post('company_address1',TRUE),
			'company_address2'	=> $this->input->post('company_address2',TRUE),
			'company_city'		=> $this->input->post('company_city',TRUE),
			'company_state'		=> $this->input->post('company_state',TRUE),
			'company_zipcode'	=> $this->input->post('company_zipcode',TRUE),
			'company_country'	=> $this->input->post('company_country',TRUE),
			'company_phone'		=> $this->input->post('company_phone',TRUE),
			'company_website'	=> $this->input->post('company_website',TRUE),
		);
		
		// update the user details and return update status
		$this->db->where('user_id', $member_id);
		return $this->db->update('members_details', $update_data);
	}

	// added by manish
	// to retrieve suppliers live bids
	public function get_user_proposal_bids($user_id)
	{
		$this->db->select('P.id as prd_id, P.product_code, P.name, PB.user_bid_amt, PB.bid_date');
		$this->db->from('product_bids PB');
		$this->db->join('products P', 'P.id = PB.product_id');
		$this->db->where('PB.user_id', $user_id);
		$this->db->where('P.status', '2'); // status live
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return FALSE;
	}

	// added by manish
	// to retrieve suppliers won bids
	public function get_user_won_bids($user_id)
	{
		
		return FALSE;
	}

	// not used 
	public function is_valid_attachment($prdduct_id)
	{
    
        $this->db->where('id',$product_id);
        // $this->db->where('id',$file_id);
      	$query = $this->db->get('meta_products');
       
	   	if ($query->num_rows() > 0)
	   	{
        	return $query->row();
      	}
      	else
      	{
        	return false;
        }
	}
	
	// not in use
	public function get_file_download($args=array())
	{
        $this->load->model('download/download_model');
        
		$this->download_model->set_args($args);
        $this->download_model->set_extensions();
        $this->download_model->prepare_download();
            
        if($this->download_model->download_hook['download'])
		{
        	$this->download_model->set_download();
    		$this->download_model->start_download();
        }
        else
        {
            die($this->download_model->download_hook['message']);
        }
    }

    // added by manish
    // reduce balance for both buyer and supplier
    public function reduce_balance($user_id, $payment_type)
    {
     	if($payment_type == 'free')
     	{
     		$this->db->set('balance_free', 'balance_free-1', FALSE);
    		$this->db->where('id', $user_id);
     		return $this->db->update('members');
     	}
     	else if ($payment_type == 'paid')
     	{
     		$this->db->set('balance_paid', 'balance_paid-1', FALSE);
     		$this->db->where('id', $user_id);
     		return $this->db->update('members');
     	}
    } 

    // added by sagar
    // invite supplier
    public function invite_suppliers($product_id)
    {
    	$invitemail=$this->input->post('user_email');
    	$message=$this->input->post('message');
    	$invitation_data = array(
    		'product_id' => $product_id,
    		'user_email' => $invitemail,
    		'message'    => $message
		);
		$productdetail=$this->db->get_where('emts_products',array('id'=>$product_id));
		$data=$productdetail->first_row('array');
		
		$parseElement = array(
						'description' 		=> $data['description'],
						"product_name"		=> $data['name'],
						"auc_start_time"	=> $data['auc_start_time'],
						"auc_end_days"		=> $data['auc_end_days'],
						"product_url"		=> site_url('my-account/auction_detail/'.$product_id),
						"budget"			=> $data['budget'],
						"message"			=> $message,
						"SITENAME"			=> WEBSITE_NAME
					);
		$template_id='56';
		$to=$invitemail;
		$from=SYSTEM_EMAIL;
		$emailsend=$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());
		if($emailsend){
			$this->db->insert('product_invitation', $invitation_data);
			return $this->db->insert_id();
		}else{
			return false;
		}
    }

    // to add expertise area
    public function add_expertise($user_id=false)
    {
    	try{
    		if(!$user_id) throw new Exception("User id not found", 1);
    		
    		$categories = $this->input->post('categories', TRUE);
    		if(empty($categories))
    		$categories = array();
    		$this->db->delete('emts_member_expertise', array('user_id' => $user_id)); 
    		foreach($categories as $value){
    			$data[]=array(
    							'user_id' 		=>	 $user_id,
    							'category_id'	=>	 $value
    						 );
    		}
    		
    		$this->db->insert_batch('emts_member_expertise', $data);
    		
    	}
    	catch(Exception $e){
    		echo $e->getMessage();
    	}
    	
    }

   	// added by manish 
   	// to retrieve users{suppliers} expertise area
    public function get_expertise_area($user_id)
    {
    	$this->db->select('category_id');
    	$query = $this->db->get_where('emts_member_expertise', array('user_id'=>$user_id));
    	if($query->num_rows() >0)
    	{
    		$supplier_expertise = $query->result('array');
    		// echo '<pre>';
    		// print_r($supplier_expertise);
    		// print_r($supplier_expertise[0]);
    		return $supplier_expertise;
    	}
    	return FALSE;
    }

    public function listprivateinvitationsent($product_id=false)
    {
    	try{
    		if(!$product_id) throw new Exception("Product  not found", 1);
    			$query=$this->db->get_where('emts_product_invitation',array('product_id'=>$product_id));
    			$data=$query->result('array');
    			if($data)
    					return $data;
    			else 
    					return array();

    		}
    	catch(Exception $e){
    		echo $e->getMessage();
    	}
    	
    		

    }
}
