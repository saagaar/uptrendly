<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * EMTS General Class
 *
 * We made common functions which are use general different part of the project
 *
 */
class General
{
	protected $ci;
	//private $tableSITE_SETTINGS = 'site_settings';
	private $tableSITEOPTIONS = 'site_options';
	private $tableAUCTYPES = 'auction_types';
	private $tableMEMBERS = 'members';
	private $tableUSER_PERMS = 'members_permissions';
	private $tableUSER_ROL_PERMS = 'members_roles_permission';
	private $tableLOG_AUDIT = 'log_audit';
	private $tablePRODCATEGORY = 'product_categories';
	private $tablePRODSTATICFIELDS = 'product_static_fields';
	private $tablePRODIMGTEMP = 'product_images_temp';
	private $tableMETAFIELDS = 'meta_fields';
	private $tablePRODMETADATA = 'products_meta_data';
	 private $tableMEMBERSHIP = 'membership';
	 private $tableEVENT_IMAGE='event_images';
	 private $tableActivity_Log='activity_log';
	
	function __construct($config = array())
	{
		$this->ci =& get_instance();
		
		//Get all site settings and define as constanct
		$site_info = $this->get_site_settings_info();
		define('SITE_NAME',$site_info['site_name']);
		define('DEFAULT_TIMEZONE',$site_info['default_timezone']);
		
		//Auction Settings
		$auction_info = $this->get_site_options_info('auction_settings');
		//print_r($auction_info);exit;
		
		define('AUCSET_SALE_COMMISSION',$auction_info['sale_commission']);
		define('AUCSET_NO_IMG_POST_PRODUCT',$auction_info['no_img_post_product']);
		define('AUCSET_IMG_SIZE',$auction_info['image_size']);
		define('AUCSET_PENNY_AUC_RESET_TIME',$auction_info['penny_auc_reset_time']);
		define('AUCSET_AUC_SHOW_TIME',$auction_info['reveal_auc_show_time']);
		define('AUCSET_REVEAL_BUY_TIME',$auction_info['reveal_auc_buy_time']);
		define('AUCSET_MAX_BONUS_USED_PER_AUCTION',$auction_info['max_bonus_user_per_auc']);
		define('AUCSET_MAX_BONUS_USED_PER_USER',$auction_info['max_bonus_user_per_user']);
		define('AUCSET_POST_ADMIN_APPROVAL_REQ',$auction_info['auc_post_admin_approval']);
		define('AUCSET_EBAY_AUC_BID_FEE',$auction_info['ebay_style_auc_bid_fee']);
		define('AUCSET_REVERSE_AUC_BID_FEE',$auction_info['reverse_auc_bid_fee']);
		define('AUCSET_AUC_DETAILS_PAGE_LOGIN',$auction_info['require_auc_details_page_login']);
		define('AUCSET_AUC_DETAILS_PAGE_COMMENT',$auction_info['auc_details_page_comment']);
		define('AUCTION_LUB_MULTI_BID_RANGE',$auction_info['lub_multiple_bid_range']);
		define('AUCTION_HUB_MULTI_BID_RANGE',$auction_info['hub_multiple_bid_range']);
		define('AUCTION_NO_BID_MULTI_BID_RANGE',$auction_info['no_bid_multiple_bid_range']);
		//print_r($auction_info);
		
		define('LOG_ADMIN_AUDIT_TRAIL', 'Y'); //Y/N
		define('ACTIVITY_LOG','Y');
	}


	// Get Site Setting data
    public function get_site_settings_info(){
		
				 $this->ci->db->select('option_value');
		$query = $this->ci->db->get_where($this->tableSITEOPTIONS,array('option_name' => 'site_settings'));
		if($query->num_rows() > 0){
			$resutls = $query->row_array();
			$query->free_result();
		   return unserialize($resutls['option_value']);
			
		}else{return FALSE;}

	}
	
	public function get_site_options_info($option_name){
		
				 $this->ci->db->select('option_value');
		$query = $this->ci->db->get_where($this->tableSITEOPTIONS,array('option_name' => $option_name));
		if($query->num_rows() > 0){
			$resutls = $query->row_array();
			$query->free_result();
			
		   return unserialize($resutls['option_value']);
			
		}else{return FALSE;}

	}
	function random_number() 
	{
		return mt_rand(100, 999) . mt_rand(100,999) . mt_rand(11, 99);
	} 
	
	public function admin_controlpanel_logged_in(){
		
		if($this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION) && $this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION.'login_string') && $this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION.'username')){

            $admin_id = $this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION);
            $username = $this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION.'username');
            //return true;

        }else{
				return FALSE;
			 }

        $query = $this->ci->db->get_where($this->tableMEMBERS,array('id'=>$admin_id, 'user_name' => $username, 'user_type'=> 1, 'status' => 1),1);
		//echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0){

            return $query->row();

        }else{
            return FALSE;
        }

    }
	
	function get_admin_id(){

        return $this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION);

    }
	
	function log_audit_trial($data){

		$userid=$this->ci->session->userdata(SESSION_DOMAIN.ADMIN_LOGIN_SESSION);
		$query=$this->ci->db->select('user_type')
		        ->from($this->tableMEMBERS)
		        ->where(['id'=>$userid])
		        ->get();
		 $usertype=$query->result();
		  $usertype1="Normal User";
		  foreach ($usertype as $value) {
		  if($value->user_type==0)
		  {
		   $usertype1="Super Admin";
		  }
		  else if($value->user_type==1)
		  {
		   $usertype1="Admin";
		  }
		  else
		  {
		   $usertype1="Normal User";
		  }
		  }


        $this->ci->load->library('user_agent');
        //Extra Info
        $extra_info = '';
        if($this->ci->agent->mobile())
            $extra_info .= 'mobile:'.$this->ci->agent->mobile();
        if(isset($data['extra_info'])){
            $extra_info .= $data['extra_info'];
        }

        $data_log = array('log_user_id' => $data['user_id'], 'log_user_type' =>$usertype1, 'module_name' => $data['module'], 'module_desc' => $data['module_desc'], 'log_action' => $data['action'], 'log_ip' => $this->ci->input->ip_address(), 'log_platform' => $this->ci->agent->platform(), 'log_browser' => $this->ci->agent->browser().' | '.$this->ci->agent->version(), 'log_agent' => $this->ci->input->user_agent(), 'log_referrer' => $this->ci->agent->referrer(), 'log_extra_info' => $extra_info);
        $this->ci->db->insert($this->tableLOG_AUDIT,$data_log);
    }

    public function activity_log($data)
    {

    	$this->ci->db->insert($this->tableActivity_Log,$data);
    }
	
	public function get_admin_permissions(){

        $admin_info = $this->admin_controlpanel_logged_in();

        if($admin_info){

            return $this->get_admin_role_permission($admin_info->role_id);

        }else{

            return array();

        }

    }

     public function get_real_ipaddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip=$_SERVER['REMOTE_ADDR'];

		return $ip;
	}

    public function get_admin_role_permission($role_id){

        $this->ci->db->select('code, name');
        $this->ci->db->from($this->tableUSER_PERMS.' AS ap');
        $this->ci->db->where('ap.permission_id = arp.permission_id');
        $query = $this->ci->db->get_where($this->tableUSER_ROL_PERMS.' AS arp',array('role_id'=>$role_id));

        //echo $this->ci->db->last_query();

        if ($query->num_rows() > 0){

            return $this->generate_permission_array($query->result());

        }else{

            return array();

        }

    }

    

    public function generate_permission_array($array_perms){

        $formated = array();

        if($array_perms && count($array_perms)>0){

            foreach ($array_perms as $item){

                $formated[$item->code] = $item->name; 

            }

        }

        return $formated;

    }

    public function salt() 
	{
		return substr(md5(uniqid(rand(), true)), 0, '10');
	}
	public function hash_password($password, $salt) 
	{
		return  sha1($salt.sha1($salt.sha1($password)));	
	}

	function get_local_time($time="none")
	{
		if($time!='none')
		return date("Y-m-d H:i:s");
		else
			return date("Y-m-d");
	}
	
	public function get_captcha($img_width,$img_height){

        // load codeigniter captcha helper			
            $this->ci->load->helper('captcha');
            $this->ci->load->helper('string');
            $this->ci->load->library('antispam');
			
            //delete old captcha images
            $this->delete_old_captcha();
			
			
			 $configs = array(
                'word'       => strtolower(random_string('alnum', 8)),
                'img_path'	 => './'.CAPTCHA_PATH,
            	'img_url'	 => base_url().CAPTCHA_PATH,
                'img_width'  => $img_width,
                'img_height' => $img_height,
                'char_set'   => "ABCDEFGHJKLMNPQRSTUVWXYZ2345689",
                'char_color' => "#000000",
				'expiration' => 60
            );
            $captcha = $this->ci->antispam->get_antispam_image($configs);
			return $captcha;
    }

    private function delete_old_captcha(){
		
        /** define the captcha directory **/
        $dir = './'.CAPTCHA_PATH;
        
        /*** cycle through all files in the directory ***/
        foreach (glob($dir."*.jpg") as $file) {

        /*** if file is 24 hours (86400 seconds) old then delete it ***/
        if (filemtime($file) < time() - 60) {
             @unlink($file);
            }
        }

    }
	
	// Get list of all timezonees
	public function timezone_list($name, $default='') {
		static $timezones = null;

		if ($timezones === null) {
			$timezones = [];
			$offsets = [];
			$now = new DateTime();

			foreach (DateTimeZone::listIdentifiers() as $timezone) {
				$now->setTimezone(new DateTimeZone($timezone));
				$offsets[] = $offset = $now->getOffset();

				$hours = intval($offset / 3600);
				$minutes = abs(intval($offset % 3600 / 60));
				$gmt_ofset = 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');

				$timezone_name = str_replace('/', ', ', $timezone);
				$timezone_name = str_replace('_', ' ', $timezone_name);
				$timezone_name = str_replace('St ', 'St. ', $timezone_name);

				$timezones[$timezone] = $timezone_name.' (' . $gmt_ofset . ')';

			}

			array_multisort($offsets, $timezones);
		}

		$formdropdown = form_dropdown($name, $timezones, trim($default),'class="form-control"');

		return $formdropdown;
	}
	
	function change_date_time_format_admin($str)
	{
		return date("m-d-Y H:i", strtotime($str));
	}
	function change_date_time_format_front($str)
	{
		return date("m-d-Y H:i", strtotime($str));
	}
	
	function change_date_time_format_satndard($str)
	{
		return date("Y-m-d H:i:s", strtotime($str));
	}
	
	public function get_gmt_time($time=""){
		if($time =='none') {
			return gmdate('Y-m-d');
		} else 
			return gmdate('Y-m-d H:i:s');
	}
	
	public function convert_gmt_time($dt, $tz1=DEFAULT_TIMEZONE)
	{
		$df1 = 'Y-m-d H:i:s';
		$df2 = 'Y-m-d H:i:s';
		$tz2 = 'UTC';
		
		//Example > $this->general->convert_gmt_time('2017-02-16 14:21:00', 'Asia/Kathmandu', 'Y-m-d H:i:s', 'UTC', 'Y-m-d H:i:s A');
		 // create DateTime object
		  $d = DateTime::createFromFormat($df1, $dt, new DateTimeZone($tz1));
		  // convert timezone
		  $d->setTimeZone(new DateTimeZone($tz2));
		  // convert dateformat
		  return $d->format($df2);
	}
	
	public function convert_local_time($date,$timeZone=DEFAULT_TIMEZONE,$time="time")
	{		
		$utc_date = DateTime::createFromFormat('Y-m-d H:i:s', $date, new DateTimeZone('UTC'));
						
		$nyc_date = $utc_date;
		$nyc_date->setTimeZone(new DateTimeZone($timeZone));

		if($time =='none') {
			return $nyc_date->format('Y-m-d');
		} else 
			return $nyc_date->format('Y-m-d H:i:s');
	}
	
	//function to resize images
	public function resize_image($location,$source_image,$new_image,$width,$height)
	{		
		$this->ci->load->library('image_lib');
        $config['image_library'] = 'gd2';
		$config['source_image'] = './'.$location.$source_image;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['master_dim'] = 'width';
		$config['new_image'] = './'.$location.$new_image;
		
		$this->ci->image_lib->initialize($config);
		$resize = $this->ci->image_lib->resize();		
	}
	
	public function file_upload_settings($file_upload_dir,$max_upload_size,$max_width='',$max_height='',$file_name='',$type='IMAGE')
	{
		
		//Make Directory
		$upload_path = FCPATH.$file_upload_dir;
		
        if (!is_dir($upload_path)) {
        	
            $theupload_path = mkdir($upload_path, 0755,true);
        }
		
		$config['upload_path'] = $upload_path;
		$config['remove_spaces'] = TRUE;				
		$config['max_size'] = $max_upload_size;
		if($type == 'VIDEO')
			$config['allowed_types'] = ALLOW_VIDEO_EXTENSION;
		else if($type == 'DOC')
			$config['allowed_types'] = ALLOW_DOC_EXTENSION;
		else
			$config['allowed_types'] = ALLOW_IMG_EXTENSION;
			
			$config['encrypt_name'] = ($file_name)?FALSE:TRUE;
			
			if($file_name!='')
			$config['file_name'] = $file_name;
			
			if($max_width!='')
			$config['max_width'] = $max_width;
			
			if($max_height!='')
			$config['max_height'] = $max_height;
		
		return $config;
	}
	
	public function do_image_upload($field,$file_upload_dir,$max_width='',$max_height='',$file_name='',$max_upload_size=MAX_IMAGE_UPLOAD_SIZE,$type='IMAGE')
	{

		$data = array();
    
		if(is_uploaded_file($_FILES[$field]['tmp_name']	)){
				
				$this->ci->load->library('upload');
				$this->ci->upload->initialize($this->file_upload_settings($file_upload_dir,$max_upload_size,$max_width,$max_height,$file_name,$type));
				
				$this->ci->upload->do_upload($field);
			
				if($this->ci->upload->display_errors())
				{
					$data[0] = 'error';
					$data[1] = $this->ci->upload->display_errors();
				}
				else
				{
					$result = $this->ci->upload->data();
					$data[0] = 'success';
					$data[1] = $result['file_name'];
				}
		
			}
		return $data;
	}
	
	public function get_system_auction_type($auc_code=''){
		
		if($auc_code)
		$this->ci->db->where('auc_code',$auc_code);
		
		$query = $this->ci->db->get_where($this->tableAUCTYPES,array('system_display' => 1));		
		if($query->num_rows() > 0){
			$resutls = $query->result();
			$query->free_result();
		   return $resutls;
			
		}else{return FALSE;}

	}
	
	public function get_auction_type($auc_code=''){
		
		if($auc_code)
		$this->ci->db->where('auc_code',$auc_code);
		
		$query = $this->ci->db->get_where($this->tableAUCTYPES,array('system_display' => 1,'admin_display' => 1));		
		if($query->num_rows() > 0){
			$resutls = $query->result();
			$query->free_result();
		   return $resutls;
			
		}else{return FALSE;}

	}
	
	public function clean_url($str, $replace=array(), $delimiter='-') 
	{
		if( !empty($replace) ) {$str = str_replace((array)$replace, ' ', $str);}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}
	
	public function get_category_tree()
	{
		$this->ci->db->where('is_display','1');
		$query = $this->ci->db->get($this->tablePRODCATEGORY);
		
		//echo $this->ci->db->last_query();
		if ($query->num_rows() > 0) 
		{
			//$all_categories = $query->result();
			foreach($query->result() as $cat)
			{
				if($cat->parent_id=='0'){
					//category
					$categories_arr[$cat->id] = array('id' => $cat->id, 'parent_id'=>$cat->parent_id ,'name' => $cat->name, 'subcat' => '');
				}else{
					//subcategory;
					$categories_arr[$cat->parent_id]['subcat'][] = array('id' => $cat->id, 'parent_id' => $cat->parent_id, 'name' => $cat->name);
				}
			}
			return $categories_arr;
		}				
		return false;
	}
	
	public function get_product_static_fields_data()
	{
		$this->ci->db->where('is_display','1');		
		$query = $this->ci->db->get($this->tablePRODSTATICFIELDS);
		if ($query->num_rows() > 0){
		   	$data = $query->result();
			//return $data;
			$new_arr = array();
		   	foreach($data as $key=>$value){
				$new_arr[$value->field_name]['field_name'] = $value->field_name;
				$new_arr[$value->field_name]['field_label'] = $value->field_label;
				$new_arr[$value->field_name]['options'] = $value->options;
				$new_arr[$value->field_name]['display'] = $value->is_display;
			}
			return $new_arr;
		} 
		return false;
	}
	
	//function to populate custom fields and their values for sell item and edit item
	public function get_custom_fields_html_by_category($model_name, $cat_id, $cf_post_value, $operation, $cf_old_files, $type='custom')
	{
		
		if($type=='custom'){

			$custom_fields = $this->get_custom_fields_by_category_id($cat_id);

		}else if($type=='basic'){

			$custom_fields = $this->get_basic_fields();
		}

		if($custom_fields)
		{
			//define new variable for holding full html input field and store heading if it is a custom form field
			$html = '';

			//create an array of checkboxes values when user checks to remove previous file and add new file
			//product edit section when user checks to delete previous file and chooses new file
			$old_metafile_arr = array();
			if(isset($_POST['old_metafile']) && !empty($_POST['old_metafile'])){

				$old_metafile_arr = $this->input->post('old_metafile',TRUE);
			}			

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
				
				//Validation Rule
				if($field->type=='FILE')
				{
					if(isset($validation_rules->required) && $validation_rules->required=='true'){
						if (($operation=='add' && empty($_FILES['metafile_'.$field->id]['name'][$field->id])) OR ($operation=='edit' && $old_metafile_arr && in_array($field->id, $old_metafile_arr) && (empty($_FILES['metafile_'.$field->id]['name'][$field->id]) && !isset($cf_post_value[$field->id]))))
						{

							// this is required field so define required for server side
							$validation_rules_pipe = 'required|';							

							//this is required field so define required for client side
							$validation_class .= ' required';

							if($_POST && !$this->ci->input->is_ajax_request()){
								$error_message = '<div class="text-red">The '.$field->name.' is required.</div>';
							}
						}

						$valid_extensions = str_replace(',', '#', $field->extensions);
						array_push($this->ci->$model_name->validate_product_settings, array('field' => 'metafile_'.$field->id, 'label' => $field->name, 'rules' => $validation_rules_pipe));

					}

				}else{
					
					//validation rule for required
					if(isset($validation_rules->required) && $validation_rules->required=='true')
					{
						//now store validation rules in a local variable
						$validation_rules_pipe .= 'required';
						$validation_class .= ' required';
					}
					//validation rule for email
					if(isset($validation_rules->email) && $validation_rules->email=='true')
					{
						//now store validation rules for server side and client side in a local variable
						$validation_rules_pipe .= $validation_rules_pipe==''?'valid_email':'|valid_email';
						$validation_class .= ' email';
					}
					//validation rule for number
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
					//for url
					if(isset($validation_rules->url) && $validation_rules->url=='true')
					{
						//now store validation rules for server side and client side in a local variable
						$validation_rules_pipe .= $validation_rules_pipe==''?'valid_url':'|valid_url';
						$validation_class .= ' url';
					}
					//for alpha
					if(isset($validation_rules->alpha) && $validation_rules->alpha=='true')
					{
						//now store validation rules for server side and client side in a local variable
						$validation_rules_pipe .= $validation_rules_pipe==''?'alpha':'|alpha';
						$validation_class .= ' alpha';
					}
					//for alpha numeric
					if(isset($validation_rules->alpha_numeric) && $validation_rules->alpha_numeric=='true')
					{
						//now store validation rules for server side and client side in a local variable
						$validation_rules_pipe .= $validation_rules_pipe==''?'alpha_numeric':'|alpha_numeric';
						$validation_class .= ' alphanumeric';
					}
					//for min & max length
					if(isset($validation_rules->minlength) && isset($validation_rules->maxlength))
					{
						//now store validation rules for server side and client side in a local variable
						$validation_rules_pipe .= $validation_rules_pipe==''?'min_length':'|min_length';
						$validation_extra_param = 'minlength="'.$validation_rules->minlength.'" maxlength="'.$validation_rules->maxlength.'"';
					}
					//for exactlength
					if(isset($validation_rules->exactlength) && $validation_rules->exactlength!='')
					{
						//now store validation rules for server side and client side in a local variable
						$validation_rules_pipe .= $validation_rules_pipe==''?'exact_length['.$validation_rules->exactlength.']':'|exact_length['.$validation_rules->exactlength.']';
						$validation_extra_param = 'exactlength="'.$validation_rules->exactlength.'"';
					}
					

					//now push the array into rule array add validation rules for server side
					array_push($this->ci->$model_name->validate_product_settings, array('field' => 'meta['.$field->id.']', 'label' => $field->name, 'rules' => $validation_rules_pipe));					

					//if form is not validated display validation error
					$error_message = form_error('meta['.$field->id.']');
				}

	

				//now check condition to determine the type of input field
				if($field->type=='TEXTAREA'){

					$input = '<textarea class="form-control form-control-2'.$validation_class.'" name="meta['.$field->id.']" '.$validation_extra_param.'>'.($cf_post_value ?$cf_post_value[$field->id]:'').'</textarea>';	

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

					$type = explode('|',$field->extensions);

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

					if($cf_post_value && array_key_exists($field->id,$cf_post_value)){

						//echo "found ".$field->id;; 

						$input = '<input type="checkbox" name="old_metafile[]" value="'.$field->id.'" class="update_metafile" /> '.$cf_post_value[$field->id];
						$input .= '<br>(Check to change this file)';
						$input .= '<input name="metafile_'.$field->id.'" type="file" accept="'.$accept.'" class="metafile" style="display:none"/>';

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

						$input .= '<input type="hidden" name="old_metafile['.$field->id.']" value=""'.'/> ';

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

					$input = '<input class="form-control datepicker'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'" readonly>';

				}else if($field->type=='DATETIME'){

					$input = '<input class="form-control datetimepicker'.$validation_class.'" type="text"  name="meta['.$field->id.']" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'" readonly>';

				}else{

					$input = '<input type="'.strtolower($field->type).'" name="meta['.$field->id.']" class="'.$validation_class.'" value="'.($cf_post_value ?$cf_post_value[$field->id]:'').'">';

				}
			

				//now set asterisk for required fields.
				$required_mark = (isset($validation_rules->required) && $validation_rules->required=='true')?' <em>*</em>':'';
				

				//create view for html 

				$html .= '<div class="col-md-2"><div class="form-group"><label>'.$field->name.'</label>'.$input.$error_message.'</div></div>';
			}

			//now return html code generated.
			return $html;

		}

	}
	
	public function get_custom_fields_by_category_id($cat_id)
	{
		$this->ci->db->where("find_in_set(".$cat_id.",meta_categories) <> 0");
		$this->ci->db->where('form_field_type','custom');
		$this->ci->db->order_by('basic_field_order','ASC');		
		$query = $this->ci->db->get($this->tableMETAFIELDS);
		
		if ($query->num_rows() > 0){
		   return $query->result();
		}
		return false;

	}

	

	public function get_basic_fields()
	{
		$this->ci->db->where('form_field_type','basic');
		$this->ci->db->order_by('basic_field_order','ASC');		
		$query = $this->ci->db->get($this->tableMETAFIELDS);
		if ($query->num_rows() > 0){
		   return $query->result();
		}
		return false;
	}
	
	public function get_product_meta_data($product_id)
	{
		$this->ci->db->select('MP.meta_fields_id, MP.value, MF.type');
		$this->ci->db->from($this->tablePRODMETADATA.' MP');
		$this->ci->db->join($this->tableMETAFIELDS.' MF','MP.meta_fields_id=MF.id','LEFT');
		$this->ci->db->where('MP.product_id',$product_id);
		$query = $this->ci->db->get('');
		if($query->num_rows()>0)
		{
			$data = $query->result();
			$new_arr = array();
			foreach($data as $custom)
			{
				if($custom->type == 'FILE')
				$new_arr['metafile_'.$custom->meta_fields_id] = $custom->value;
				else
				$new_arr['meta['.$custom->meta_fields_id.']'] = $custom->value;
			}
			return $new_arr;
		}
		return false;
	}
	
	
	public function count_total_temp_images_by_product_code($product_code)
	{
		$this->ci->db->where('product_code',$product_code);
		$this->ci->db->from($this->tablePRODIMGTEMP);
		return $this->ci->db->count_all_results();
	}
	
	public function get_product_all_images($product_id,$filter='')
	{
		$this->ci->load->helper('directory'); //load directory helper
		$dir = FCPATH.UPLOAD_PRODUCT_DIR.$product_id.'/'; // Your Path to folder
		$map = @directory_map($dir); /* This function reads the directory path specified in the first parameter and builds an array representation of it and all its contained files. */		
	
		if($map){
			foreach($map as $key=>$value){
				if (strpos($value, $filter) == FALSE)
				{
				 	unset($map[$key]);
				}
			}
			return  array_values($map);
		}
		return false;
	}
	public function multiple_upload($field,$file_upload_dir,$max_width='',$max_height='',$event_id)
	{

        $this->ci->load->library('upload');
        $response=array('success','error');
        /*** check if a file has been submitted ***/
		
        if(isset($_FILES[$field]['tmp_name']))
        {
              
            /** loop through the array of files ***/
            for($i=0; $i < count($_FILES[$field]['tmp_name']);$i++)
            {
                
                if(is_uploaded_file($_FILES[$field]['tmp_name'][$i]))
                {
                   
                    $field_name = "file_".$field.'_'.$i;
                    //Fake File Upload reference:https://snipt.net/raw/f9519011d704be9e77af9f36f1f44f16/?nice
                    foreach($_FILES[$field] as $key => $v)
                    {                        
                        $_FILES[$field_name][$key] = $v[$i];
                    }

                    $file_name = $_FILES[$field]['name'][$i];


                    $save_file_name = time().'_'.$file_name;
                    
                    $this->ci->upload->initialize($this->upload_file_config_team($save_file_name,$file_upload_dir));
                 	
                    if($this->ci->upload->do_upload($field_name)){

					
                        $response['success'][] = $this->save_multiple_images($this->ci->upload->data(),$event_id); 

                    }
                    else{
                    	
                        $response['errors'][] =  false;
                    }

                }

            }
            return $response;
        }
	}

	public function upload_file_config_team($filename,$file_upload_dir)
	{
		
        $upload_path = FCPATH.$file_upload_dir;
        
        //die($upload_path);
        //Make Directory
        if (!is_dir($upload_path)) { 
            $theupload_path = mkdir($upload_path, 0755,true);
            // echo 'hreref';exit;
            //var_dump($theupload_path);
        }
        
        $config = array(
            'allowed_types' => ALLOW_IMG_EXTENSION,
            'upload_path' => $upload_path,
            'max_size' => MAX_IMAGE_UPLOAD_SIZE,
            'file_name' => $filename,
            'overwrite' => true
                
        );
        return $config;
     }
    
	public function save_multiple_images($file_uploaded,$event_id)
	{	
			
	        $data_set = array(        
	                    
	            'image_name' => $file_uploaded['file_name'],
	            'imageEvent_id' => $event_id 
	           
	        );

	        $this->ci->db->insert($this->tableEVENT_IMAGE,$data_set);
	        
	        return $this->ci->db->affected_rows();
	        
	 } 

	
}

// END Template class