<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General {

	/**

	 * CodeIgniter global

	 *

	 * @var string

	 **/

	protected $ci;



	/**

	 * account status ('not_activated', etc ...)

	 *

	 * @var string

	 **/

	protected $status;



	/**

	 * error message (uses lang file)

	 *

	 * @var string

	 **/

	protected $errors = array();

	

	public $members_data;





	public function __construct()

	{

		$this->ci =& get_instance();



		if($this->ci->session->userdata(SESSION.'user_id')){

			$this->updateOnlineMemberByTime();

		}



	}
    function create_password($length = 8, $use_upper = 1, $use_lower = 1, $use_number = 1, $use_custom = "") {
        $upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $lower = "abcdefghijklmnopqrstuvwxyz";
        $number = "0123456789";
        $seed_length = '';
        $seed = '';
        $password = '';
        if ($use_upper) {
            $seed_length += 26;
            $seed .= $upper;
        }
        if ($use_lower) {
            $seed_length += 26;
            $seed .= $lower;
        }
        if ($use_number) {
            $seed_length += 10;
            $seed .= $number;
        }
        if ($use_custom) {
            $seed_length +=strlen($use_custom);
            $seed .= $use_custom;
        }
        for ($x = 1; $x <= $length; $x++) {
            $password .= $seed{rand(0, $seed_length - 1)};
        }
        return $password;
    }

	

	public function get_pagination_config(&$config)

	{

		$config['first_link'] = 'First';

		$config['first_tag_open'] = '';

		$config['first_tag_close'] = '';

		$config['last_link'] = 'Last';

		$config['last_tag_open'] = '';

		$config['last_tag_close'] = '';

		$config['next_link'] = 'Next';

		$config['prev_link'] = 'Previous';

		$config['next_tag_open'] = '';

		$config['next_tag_close'] = '';

		$config['cur_tag_open'] = '<span>';

		$config['cur_tag_close'] = '</span>';

		$config['num_tag_open'] = '';

		$config['num_tag_close'] = '';

		$get_vars = $this->ci->input->get();

		if(is_array($get_vars)){

			$config['suffix'] = '?'.http_build_query($get_vars,'','&');

		}

		return $config;

	}

	

	

	//pagination config for frontend

	public function frontend_pagination_config(&$config)

	{        

		$config['full_tag_open'] = '<ul class="pagination">';

		$config['full_tag_close'] = '</ul>';

		$config['next_link'] = '&raquo;';

		$config['next_tag_open'] = '<li>';

		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&laquo;';

		$config['prev_tag_open'] = '<li>';

		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)"><span>';

		$config['cur_tag_close'] = '</span></a></li>';

		$config['num_tag_open'] = '<li>';

		$config['num_tag_close'] = '</li>';

		$config['first_link'] = 'First';

		$config['first_tag_open'] = '<li>';

		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';

		$config['last_tag_open'] = '<li>';

		$config['last_tag_close'] = '</li>';

		

		$get_vars = $this->ci->input->get();

		if(is_array($get_vars)){

			$config['suffix'] = '?'.http_build_query($get_vars,'','&'); 

		}

		return $config;       

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

	

	

	public function get_admin_role_permission($user_type)

	{

		$this->ci->db->select($this->ci->db->dbprefix('admin_permissions').'.code, '.$this->ci->db->dbprefix('admin_permissions').'.name ');

		

		$this->ci->db->from('admin_permissions');

		

		$this->ci->db->where($this->ci->db->dbprefix('admin_permissions').'.permission_id = '.$this->ci->db->dbprefix('admin_roles_permission').'.permission_id');

		

		$query = $this->ci->db->get_where('admin_roles_permission',array('user_type'=>$user_type));

		

        //echo $this->ci->db->last_query(); exit;

		

		if ($query->num_rows() > 0){

			return $this->generate_permission_array($query->result());

		}else{

			return array();

		}

	}

	

	//function to log admins activity

	function log_admin_activity($data){

		$this->ci->load->library('user_agent');

        //Extra Info

		$extra_info = '';

		if($this->ci->agent->mobile())

			$extra_info .= 'mobile:'.$this->ci->agent->mobile();

		

		if($data['extra_info'])

		{

			$extra_info .= $data['extra_info'];

		}

		

	     	$data_log = array('log_user_id' => $data['user_id'], 'log_user_type' => $data['user_type'], 'module_name' => $data['module'], 'module_desc' => $data['module_desc'], 'log_action' => $data['action'], 'log_ip' => $this->ci->input->ip_address(), 'log_platform' => $this->ci->agent->platform(), 'log_browser' => $this->ci->agent->browser().' | '.$this->ci->agent->version(), 'log_agent' => $this->ci->input->user_agent(), 'log_referrer' => $this->ci->agent->referrer(), 'log_extra_info' => $extra_info);

		

		$this->ci->db->insert("log_admin_activity",$data_log);

	}

	

	

	//log admin's login error

	function log_invalid_logins($data){           

		$this->ci->load->library('user_agent');

		$encrypted_pwd = $this->ci->encrypt->encode($data['password'],'kks');

        //Extra Info

		$extra_info = '';

		if($this->ci->agent->mobile())

			$extra_info .= 'mobile:'.$this->ci->agent->mobile();

		

		$data_log = array('log_module' => $data['module'], 'log_username' => $data['username'], 'log_password' => $encrypted_pwd, 'log_ip' => $this->ci->input->ip_address(), 'log_platform' => $this->ci->agent->platform(), 'log_browser' => $this->ci->agent->browser().' | '.$this->ci->agent->version(), 'log_agent' => $this->ci->input->user_agent(), 'log_referrer' => $this->ci->agent->referrer(), 'log_desc' => $data['desc'], 'log_extra_info' => $extra_info);

		$this->ci->db->insert('log_invalid_logins', $data_log);

		//echo $this->ci->db->last_query(); exit;  

	}

	

	/*public function normalizeFiles($entry) {

        if(isset($entry) && is_array($entry)) {

            $files = array();

            foreach($entry['name'] as $k => $name) {

                $files[$k] = array(

                    'name' => $name,

                    'tmp_name' => $entry['tmp_name'][$k],

                    'size' => $entry['size'][$k],

                    'type' => $entry['type'][$k],

                    'error' => $entry['error'][$k]

                );

            }

            return $files;

        }

        return $entry;

    }*/

    

    

    public function get_product_static_fields_data()

    {

    	$this->ci->db->where('display','1');		

    	$query = $this->ci->db->get('product_static_fields');

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

    	return FALSE;

    }

    

    

    public function get_category_tree()

    {

    	$this->ci->db->where('is_display','1');

    	$query = $this->ci->db->get('category');

    	

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

    	return FALSE;

    }

    public function get_price_range(){
        return $this->get_data('pricerange',array(),'priority','ASC');
    }
    public function get_profession(){
        return $this->get_data('profession',array('status'=>'1'));
    }
    public function get_socialmedia_channel(){
        return $this->get_data('socialmedia_settings',array('isActive'=>1));
    }
      public function get_socialmedia_user($userid){
        return $this->get_data('member_socialmedia',array('user_id'=>$userid));
    }
    

    public function get_tree_of_category_having_product()

    {

    	$this->ci->db->select('PC.id, PC.parent_id, PC.name');

    	$this->ci->db->from('products P');

    	$this->ci->db->join('category PC','P.cat_id=PC.id');

    	$this->ci->db->join('host_auctions HA','PC.id=HA.category');

		//$this->ci->db->where("(P.status='1' OR P.status='2')");

    	$this->ci->db->where('P.status','2');

    	$this->ci->db->where('PC.is_display','1');

    	$this->ci->db->where('HA.start_date_time >', $this->get_local_time('time'));

    	$this->ci->db->group_by('PC.id');

    	$query = $this->ci->db->get('');

    	

		//echo $this->ci->db->last_query();

    	if ($query->num_rows() > 0) 

    	{

    		$categories_arr = array();

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

    	return FALSE;

    }

    

    

    

    public function get_category_having_product()

    {

    	$this->ci->db->select('PC.id, PC.parent_id, PC.name');

    	$this->ci->db->from('products P');

    	$this->ci->db->join('category PC','P.cat_id=PC.id');

    	$this->ci->db->group_by('PC.id');

    	$this->ci->db->where('PC.is_display','1');

    	$query = $this->ci->db->get('');

    	

		//echo $this->ci->db->last_query();

    	if ($query->num_rows() > 0){

    		return $query->result_array();

    	}				

    	return FALSE;

    }

    

    public function fetch_single_product_selected_fields($fields='', $where='')

    {

    	if($fields!=''){

    		$this->ci->db->select($fields);

    	}

    	if($where!=''){

    		$this->ci->db->where($where);

    	}

    	$query = $this->ci->db->get('products');

		//echo $this->ci->db->last_query(); exit;

    	if($query->num_rows()==1)

    	{

    		return $query->row();

    	}

    	return FALSE;

    }

    

    public function get_single_host_auction_selected_fields($fields='', $where='')

    {

    	if($fields!=''){

    		$this->ci->db->select($fields);

    	}

    	if($where!=''){

    		$this->ci->db->where($where);

    	}

    	$query = $this->ci->db->get('host_auctions');

		//echo $this->ci->db->last_query(); exit;

    	if($query->num_rows()==1){

    		return $query->row();

    	}

    	return FALSE;

    }

    

    

    

    public function get_live_auctions(){

    	$current_date = $this->get_local_time('time');

    	$this->ci->db->select('P.id as product_id, P.product_code, P.name as product_name, P.auc_current_price, HA.id as host_id, HA.host_name, count(A.id) as count');

    	$this->ci->db->from('auctions A');

    	$this->ci->db->join('host_auctions HA','A.host_id=HA.id');

    	$this->ci->db->join('products P','A.product_id=P.id');

    	$this->ci->db->where('HA.start_date_time <=',$current_date);

    	$this->ci->db->where('HA.host_status','2');

    	$this->ci->db->where('P.status','2');

    	$this->ci->db->order_by('A.order','ASC');

    	$this->ci->db->group_by("HA.id");

    	$query = $this->ci->db->get();

		//echo $this->ci->db->last_query(); //exit;

    	if($query->num_rows()>0){

    		return $query->result();

    	}

    	return FALSE;	

    }

    

    

    public function get_product_category_name_by_id($id)

    {	

    	$this->ci->db->select('name');

    	$query = $this->ci->db->get_where("category",array("id"=>$id));

    	if ($query->num_rows() > 0) 

    	{

    		$data=$query->row();

    		$query->free_result();

    		return $data->name;				

    	}		

    }

    

    

    public function count_total_images_in_product($product_id)

    {

    	$this->ci->db->where('product_id',$product_id);

    	$this->ci->db->from('product_images');

    	return $this->ci->db->count_all_results();

    }

    

    public function count_total_temp_images_by_product_code($product_code)

    {

    	$this->ci->db->where('product_code',$product_code);

    	$this->ci->db->from('product_images_temp');

    	return $this->ci->db->count_all_results();

    }

    

    

    

	 //added by rabi for getting seo

    public function get_seo($seo_page_id='')

    {      

    	$this->ci->db->select('page_title,meta_key,meta_description');

    	$this->ci->db->from('emts_seo');

    	$this->ci->db->where('id',$seo_page_id);

    	$this->ci->db->limit(1);

    	$query = $this->ci->db->get();

    	if($query->num_rows() == 1)

    	{

    		return $query->row(); 

    	}

    	return FALSE;

    }

    

    public function get_cms_details($cms_id='')

    {			

    	$data = array();

    	if($cms_id!=''){

    		$this->ci->db->where("id",$cms_id);

    	}

    	$this->ci->db->where("is_display","Yes");				 

    	$query = $this->ci->db->get("cms");

    	

    	

    	if ($query->num_rows() > 0) 

    	{

    		$data=$query->row();

    		return $data;				

    	}

    	return FALSE;		

    }

    

    

	//function to get detals of multiple cms by array of cms id's

    public function get_cms_selected_fields_data($cms_id_arr, $fields='')

    {			

    	$data = array();

    	if(!$cms_id_arr OR $cms_id_arr=='' OR empty($cms_id_arr)){

    		return FALSE;

    	}

    	if($fields!=''){

    		$this->ci->db->select($fields);

    	}

    	$this->ci->db->where('is_display','Yes');

    	$this->ci->db->where_in('id',$cms_id_arr);

    	$query = $this->ci->db->get("cms");

		//echo $this->ci->db->last_query(); exit;

    	if ($query->num_rows() > 0) {

    		return $query->result();

    	}

    	return FALSE;		

    }

    

    

    public function get_all_countries()

    {

    	$query = $this->ci->db->get('country');

    	if($query->num_rows()>0){

    		return $query->result();

    	}

    	return FALSE;

    }

    

    public function get_regions_by_country_id($country_id)

    {

    	$this->ci->db->where('country_id',$country_id);

    	$query = $this->ci->db->get('regions_cities');

    	if($query->num_rows()>0){

    		return $query->result();

    	}

    	return FALSE;

    }

    

    public function get_country_name_by_id($id)

    {

    	$this->ci->db->select('country');

    	$this->ci->db->where('id',$id);

    	$query = $this->ci->db->get('country');

    	$this->ci->db->limit(1);

    	if($query->num_rows()>0){

    		$data = $query->row();

    		return $data->country;

    	}

    	return FALSE;

    }

    

    

    public function get_all_timezones()

    {

    	$query = $this->ci->db->get('time_zone_setting');

    	if($query->num_rows()>0){

    		return $query->result();

    	}

    	return FALSE;

    }

    public function get_total_members($status='')

    {	

    	$this->ci->db->select('id,email');

    	if($status!=''){

    		$this->ci->db->where('status',$status);		

    	}

    	$query = $this->ci->db->get('members');

    	if($query->num_rows() > 0)

    	{

    		return $query->num_rows();

    	}

    	return FALSE;

    }

    

    public function fetch_members_selected_fields($fields='', $where='')

    {

    	if($fields!=''){

    		$this->ci->db->select($fields);

    	}

    	if($where!=''){

    		$this->ci->db->where($where);

    	}

    	$query = $this->ci->db->get('members');

		//echo $this->ci->db->last_query(); exit;

    	if($query->num_rows()==1)

    	{

    		return $query->row();

    	}

    	return FALSE;

    }

    

	//get member email by user id

    public function check_members_email_existance($email)

    {

    	$this->ci->db->select('id');

    	$this->ci->db->where('email',$email);

    	$query = $this->ci->db->get('members');

		//echo $this->ci->db->last_query(); exit;

    	if($query->num_rows()>0){

    		return true;

    	}else {

    		return false;

    	}

    }

    

    public function get_member_online_status($user_id)

    {

    	$this->ci->db->select('is_login');

    	$this->ci->db->where(array('id'=>$user_id));

    	$query = $this->ci->db->get('members');

    	if($query->num_rows()>0){

    		$data = $query->row();

    		return $data->is_login;

    	}else return FALSE;

    }

    

    public function check_members_paypal_verification($user_id)

    {

    	$this->ci->db->select('paypal_verified');

    	$this->ci->db->where(array('user_id'=>$user_id,'paypal_verified'=>'yes'));

    	$query = $this->ci->db->get('members_paypal_accounts');

    	if($query->num_rows()>0){return $query->num_rows();}else return FALSE;	

    }

    

    public function string_limit($string,$limit)

    {

    	$name = (strlen($string) > $limit) ? substr($string , 0 , $limit).'...' : $string;

    	return $name;

    }

    

    

	//function to check admin logged in

    public function admin_logged_in()

    {		

    	return $this->ci->session->userdata(ADMIN_LOGIN_ID);

    }

    

    public function check_host_terms_accepted_by_cohost($seller_id,$host_id){

    	$this->ci->db->where(array('seller_id'=>$seller_id,'host_id'=>$host_id));

    	$query = $this->ci->db->get('cohost_accept_terms');

    	if($query->num_rows()>0){

    		return TRUE;

    	}

    	return FALSE;

    }

    

	//functin to check login and set session

    public function check_login_process($username, $password, $request_from='')

    {

		//get member info based on login value

		//$this->ci->db->where("(email = '$username' OR username = '$username') AND user_type = '3'");
        
    	//$this->ci->db->where("email = '$username' AND (user_type = '3' OR user_type = '4')");
      
    	        $this->ci->db->select('m.*,md.name,m.first_login');
                $this->ci->db->from('members m');
                $this->ci->db->join('members_details md','m.id=md.user_id');
                $this->ci->db->where("(email = '$username' OR username='$username') AND (user_type = '3' OR user_type = '4')");
                $query = $this->ci->db->get();
		
		//check valide login

    	if($query->num_rows()>0)
    	{
    		$record = $query->row_array();
		    //check active user
    		if($record['status']==='1')
    		{
    			if($record['password']===$this->hash_password($password,$record['salt']))
    			{
    				$user_ip = $this->get_real_ipaddr();

					//check blocked IP

    				if($this->check_block_ip($user_ip)===0)

    				{

    					$current_date = $this->get_local_time('time');

    					

    					$update_data = array('last_login_date'=>$current_date,'last_login_ip'=>$user_ip,'is_login'=>'1','first_login'=>'0');

    					$this->ci->db->where('id',$record['id']);

    					$this->ci->db->update('members',$update_data);

    					

						//print_r($mem_details); exit;

    					if($request_from != 'mobile'){

    						$this->ci->session->set_userdata(array(SESSION.'user_id' => $record['id']));

    						$this->ci->session->set_userdata(array(SESSION.'usertype' => $record['user_type']));

    						$this->ci->session->set_userdata(array(SESSION.'email' => $record['email']));

    						$this->ci->session->set_userdata(array(SESSION.'username' => $record['username']));
                            $this->ci->session->set_userdata(array(SESSION.'fullname' => $record['name']));
                            if($record['first_login']=='1')
                            {
                               $this->ci->session->set_userdata(array(SESSION.'first_login' => true)); 
                            }
                            else
                            {
                                 $this->ci->session->set_userdata(array(SESSION.'first_login' => false));
                            }

							// $this->ci->session->set_userdata(array(SESSION.'image' => $record['image']));

    					}



    					return 'success';		

    				}

    				else

    				{

    					return 'blocked_ip';

    				}

    			}

    			else

    			{

    				return 'invalid';

    			}

    		}

    		else if($record['status']==='2')

    		{

    			return 'unverified';

    		}

    		else if($record['status']==='3')

    		{

    			return 'suspended';

    		}

    		else if($record['status']==='4')

    		{

    			return 'closed';

    		}

    	}

    	else

    	{

    		return 'unregistered';

    	}

    }

    

    

	//function to admin logout

    public function admin_logout()

    {		

    	$this->ci->db->where('id',$this->ci->session->userdata(ADMIN_LOGIN_ID));

    	$this->ci->db->update('members',array('is_login' => '0'));

    	$this->ci->session->unset_userdata(ADMIN_LOGIN_ID);

    	return TRUE;

    }

    

	//find user real ip address

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

	

	



	//count cart items

	public function count_my_cart_items($user_id)

	{

		$this->ci->db->where('user_id',$user_id);

		$query = $this->ci->db->get('product_cart');

		//echo $this->ci->db->last_query(); exit; 

		return $query->num_rows();

	}

	

	public function calculate_percentage($max_val, $min_val){

		return (($max_val - $min_val)*100)/$max_val;

	}





	// Change & Get Time Zone based on settings

	function get_local_time($time="none")

	{

		if($time!='none')

			return date("Y-m-d H:i:s");

		else

			return date("Y-m-d");

	}

	

	

	function get_local_time_clock()

	{

		$time=date("H:i:s");				

		$piece = explode(":",$time);



		return $piece[0]*60*60+$piece[1]*60+$piece[2];	

	}



	//get GMT time from database

	// function get_gmt_info()

	// {

	// 	$data=array();

	// 	$CI =& get_instance();

	// 	$CI->db->select("gmt_time");		

 //        $query = $CI->db->get_where("time_zone_setting",array("status"=>"on"));

	// 	if ($query->num_rows() > 0) 

	// 	{

	// 		$data=$query->row_array();				

	// 	}		

	// 	$query->free_result();

	// 	return $data['gmt_time'];

	// }

	

	//for updating members online status 

	public function updateOnlineMemberByTime()

	{

		$options = array('is_login'=>'1');

		$this->ci->db->select('id, is_login, mem_last_activated');

		$query = $this->ci->db->get_where('members',$options);

		//echo $this->ci->db->last_query(); exit; 

		if($query->num_rows()>0)

		{

			$record = $query->result();

			

			foreach($record as $result)

			{

				$time_now = strtotime($this->get_local_time('time'));

				$login_time = strtotime($result->mem_last_activated);

				$time_diff = $time_now-$login_time;

				$time_diff = ($time_diff/60);

				if($time_diff>3)

				{

					$this->ci->db->update('members', array('is_login' => '0'), array('id' => $result->id));

				}

			}

		}

	}



	

	//date format only

	//for date in format: 12th march 2014

	function date_formate($date)

	{

		$str_date=strtotime($date);

		$dt_frmt=date("D, dS M Y",$str_date);

		return $dt_frmt;

	}

	

	//long date time format for admin panel only

	function long_date_time_format($str)

	{

		return date('D, M d, Y H:i A',strtotime($str));

	}

	

	function time_format($date){

		return date('h :i A',strtotime($date));	

	}

	

	function short_date_time_format($date){

		return date("jS M, g:i a",strtotime($date));

	}

	

	function famebit_date_format($date){

		return date("jS M Y g:i a",strtotime($date));

	}

	

	function month_date_time_format($date){

		return date("F j, g:i a",strtotime($date));

	}



	// for hightree buyer dashboard live products

	function date_month_year_time_format($date)

	{

		return date('d M Y H:i', strtotime($date));

	}

	

	// date time format for message details section

	public function format_date_time_message($date)

	{

		// 2016-05-13 10:55:23

		return date('Y-m-d H:i:s', strtotime($date));

		

	}



	// for auction end date in seller dashboard

	public function format_date_time_auction($date)

	{

		// 18 April 2016 23:59:59

		return date('d M Y H:i:s', strtotime($date));

	}

	public function get_remaining_time($end_time)

	{
 $remtime=  strtotime($end_time)-strtotime($this->get_local_time('time'))."<br/>";
    return $remtime;
  
	}
   public function timeRemaining($inputSeconds) {

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($inputSeconds / $secondsInADay);

    // extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
    // $obj = array(
    //     'd' => (int) $days,
    //     'h' => (int) $hours,
    //     'm' => (int) $minutes,
    //     's' => (int) $seconds,
    // );
    return (int) $days." days";
}
    

	

	function random_number() 

	{

		return mt_rand(100, 999) . mt_rand(100,999) . mt_rand(11, 99);

	} 

	

	

	function clean_url($str, $replace=array(), $delimiter='-') 

	{

		if( !empty($replace) ) {$str = str_replace((array)$replace, ' ', $str);}



		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);

		$clean = strtolower(trim($clean, '-'));

		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);



		return $clean;

	}

	

	public function count_total_num_rows($table_name,$where=''){
		if($where!=''){
			$this->ci->db->where($where);
		}
		$query = $this->ci->db->get($table_name);
		return $query->num_rows();
	}

	public function count_total_closed_auctions_in_host_auction($auction_id){

		$this->ci->db->select('A.id');

		$this->ci->db->from('auctions A');

		$this->ci->db->join('products P','A.product_id=P.id','LEFT');

		$this->ci->db->where(array('A.host_id'=>$auction_id,'P.status'=>'3'));

		return $this->ci->db->count_all_results();

		

		//$this->ci->db->count_all_results();

		//echo $this->ci->db->last_query();

	}

	//function to check whether auction is added to reminder or not
	public function check_users_item_auction_reminder($type, $user_id, $host_id, $item_id, $email_sent='0'){

		$this->ci->db->where(array('type'=>$type, 'user_id'=>$user_id, 'email_sent'=>$email_sent));

		$query = $this->ci->db->get('auction_reminder');

		//echo $this->ci->db->last_query();

		if($query->num_rows()>0){

			return TRUE;

		}

		return FALSE;

	}

	

	

	//function to check whether auction host or item is addd in watchlist/favorite or not

	public function check_item_auction_favorites($type, $user_id, $host_id, $item_id, $email_sent='0'){

		$this->ci->db->where(array('type'=>$type, 'user_id'=>$user_id, 'email_sent'=>$email_sent, 'host_id'=>$host_id));

		if($type=='item'){

			$this->ci->db->where(array('item_id'=>$item_id));

		}

		$query = $this->ci->db->get('favorites');

		//echo $this->ci->db->last_query();

		if($query->num_rows()>0){

			return TRUE;

		}

		return FALSE;

	}

	

	public function salt() 

	{

		return substr(md5(uniqid(rand(), TRUE)), 0, '10');

	}

	

	public function generate_username() 

	{

		return substr(md5(uniqid(rand(), TRUE)), 0, '10');

	}

	

	public function hash_password($password, $salt) 

	{

		return  sha1($salt.sha1($salt.sha1($password)));	

	}

	

	

	function lang_uri($path)

	{						

		return site_url($this->ci->config->item('lang').$path);

	}

	

	function check_block_ip($ip_address)

	{

		$this->ci->db->select('ip_address');

		$query = $this->ci->db->get_where("block_ips",array("ip_address"=>$ip_address));

		return $query->num_rows();

	}

	

	public function check_banned_ip()

	{

		//get user ip and check with banned IP address lists.

		$user_ip = $this->get_real_ipaddr();

		

		if($this->check_block_ip($user_ip)!==0)

		{			

			redirect($this->lang_uri('/ipbanned'), 'refresh');exit;

		}

	}

	/********************famebit start**********/

	public function get_banned_ip_message()

	{

		//get user ip and check with banned IP address lists.

		$user_ip = $this->get_real_ipaddr();

		

		$this->ci->db->select('ip_address,message');

		$query = $this->ci->db->get_where("block_ips",array("ip_address"=>$user_ip));

		if($query->num_rows()>0)

		{

			return $query->row();

		}

		return FALSE;

	}

	public function get_first_letter($str){

		return substr($str,0,1);

	}	

    
//GENERIC DATABASE FUNCTIONS.

    public function getmaxcolumn($table,$column,$condition)
    {
        $this->ci->db->select('*');
        $this->ci->db->from($table);
        $this->ci->db->order_by($column,'desc');
        $this->ci->db->limit(1);
        $query=$this->ci->db->get();
        return $query->row();
    }
    public function getmincolumn($table,$column,$condition)
    {
        $this->ci->db->select('*');
        $this->ci->db->from($table);
        $this->ci->db->order_by($column,'asc');
        $this->ci->db->limit(1);
        $query=$this->ci->db->get();
        return $query->row();
    }
    public function count_all_data($table,$condition)
    {
        $this->ci->db->where($condition);
        return $this->ci->db->count_all_results($table);
    }
     public function get_single_row($table,$condition=array(),$sortcolumn=false,$orderby=false)
    {
        $this->ci->db->select('*');
        $this->ci->db->from($table);
        $this->ci->db->where($condition);
        if($sortcolumn)
        $this->ci->db->order_by($sortcolumn,$orderby);
        $query = $this->ci->db->get();
        $this->ci->db->last_query();
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            $query->free_result();
            return $result;
        }
        return array();
    }
    //dynamic selection of a table data
    public function get_data($table,$condition=array(),$sortcolumn=false,$orderby=false,$uselimit=false,$limit=false,$offset=false)
    {
        $this->ci->db->select('*');
        $this->ci->db->from($table);
        if(count($condition)>0)
        $this->ci->db->where($condition);
        if($sortcolumn)
        $this->ci->db->order_by($sortcolumn,$orderby);
        if($uselimit)
        {
            $limit=isset($limit)?$limit:50;
            $offset=isset($offset)?$offset:50;
            $this->ci->db->limit($limit, $offset);
        }
        $query = $this->ci->db->get();
        $this->ci->db->last_query();
        if($query->num_rows() > 0)
        {
            $result = $query->result();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //dynamic single table update
    public function update_data($table,$data,$condition)
    {
        try{
            if((!$table)|| (!$condition)) throw new Exception("Error occured to perform operation", 1);
            $this->ci->db->where($condition);
            $this->ci->db->update($table, $data);
            if($this->ci->db->affected_rows() > 0)
            {
                return true;

            }
            else{
                return false;

            }

        }
        catch(Exception $e){
            throw $e->getMessage();
        }
    }

    public function insert_data($table,$data){
        try{
            if(!$table) throw new Exception("Error occured to perform operation", 1);
                $id=$this->ci->db->insert($table, $data);
                if($id) return $this->ci->db->insert_id();
                    else return false;

           }
        catch(Exception $e){
            throw $e->getMessage();
        }

    }
      public function get_all_media(){
        $mediaarr=array();
        $this->ci->db->select('media_type');
        $this->ci->db->from('socialmedia_settings');
        $this->ci->db->where('isActive','1');
        $query=$this->ci->db->get();
        $data=$query->result('array');
        foreach($data as $value){
            $mediaarr[]=$value['media_type'];
        }
        return $mediaarr;
    }
    public function get_member_media_id($userid,$mediaid){
        $this->ci->db->where('user_id',$userid);
        $this->ci->db->where('media_type_id',$mediaid);
        $this->ci->db->limit(1);
        $query = $this->ci->db->get('member_socialmedia');
        if($query->num_rows()>0)
        {
            $data= $query->row();   
            return $data->id;
        }
        return FALSE;
    }

     public function get_product_media_id($productid,$mediaid){
        $this->ci->db->where('product_id',$productid);
        $this->ci->db->where('socialmedia_id',$mediaid);
        $this->ci->db->limit(1);
        $query = $this->ci->db->get('product_socialmedia');
        if($query->num_rows()>0)
        {
            $data= $query->row();   
            return $data->id;
        }
        return FALSE;
    }
    public function get_product_media($productid){
        $mediaarr=array();
        $this->ci->db->select('media_type');
        $this->ci->db->from('product_socialmedia ps');
        $this->ci->db->join('socialmedia_settings ss','ps.socialmedia_id=ss.id');
        $this->ci->db->where('product_id',$productid);
        $this->ci->db->where('ss.isActive',1);
        $query=$this->ci->db->get();
        $data=$query->result('array');
        foreach($data as $value){
            $mediaarr[]=$value['media_type'];
        }
        return $mediaarr;

    }
    public function get_obj_reason_other_id()
    {
        $this->ci->db->select('id');
        $this->ci->db->where('lower(name) ="other" or lower(name) ="others"');
        $query=$this->ci->db->get('objective');
        return $query->row()->id;
    }
    public function get_member_media($userid){
        $mediaarr=array();
        $this->ci->db->select('media_type');
        $this->ci->db->from('member_socialmedia ms');
        $this->ci->db->join('socialmedia_settings ss','ms.media_type_id=ss.id');
        $this->ci->db->where('user_id',$userid);
        $this->ci->db->where('ss.isActive',1);
        $query=$this->ci->db->get();
        $data=$query->result('array');
        foreach($data as $value){
            $mediaarr[]=$value['media_type'];
        }
        return $mediaarr;

    }

      public function get_member_by_product($productid){
        $mediaarr=array();
        $this->ci->db->select('m.*,p.*');
        $this->ci->db->from('members m');
        $this->ci->db->join('products p','m.id=p.brand_id');
        $this->ci->db->where('p.id',$productid);
        // $this->ci->db->where('ss.isActive',1);
        $query=$this->ci->db->get();
        $data=$query->row();
       
        return $data;

    }

   public function get_member_category($userid)
   {
        $mediaarr=array();
        $this->ci->db->select('*');
        $this->ci->db->from('member_expertise m');
        $this->ci->db->join('category c' , 'm.category_id=c.id');
        $this->ci->db->where('m.user_id',$userid);
        $this->ci->db->where('c.is_display','1');
        $query=$this->ci->db->get();
        $data=$query->result();
       
        return $data;

    }
    public function get_member_profession($userid)
    {

         $profession=$this->get_profession();
         $memberprofession=$this->get_data('member_profesion',array('user_id'=>$userid));
        $proffessionname='';
        $professionarr=array();
        if(is_array($memberprofession) && count($memberprofession)>0)
        {
          foreach ($memberprofession as $key => $value) 
          {
            $professionarr[]=$value->profession_id;
          }
        }
        foreach($profession as $eachprofession):
         if(in_array($eachprofession->id,$professionarr)) 
         { 
                $proffessionname=$proffessionname.','.$eachprofession->profession; 
         }
        endforeach;
       return trim($proffessionname,',');
    }
    public function getusermediaconnectionlist($userid)
    {
      
        $usermediaassociated=  $this->get_member_media($userid); 
        $allmedia=  $this->get_all_media();
        $data['userconnected']=array();
        $data['usernotconnected']=array();
        if(count($allmedia)>0)
        {
            foreach($allmedia as $mediam)
            {

                if(in_array($mediam,$usermediaassociated))
                {
                    $data['userconnected'][]=$mediam;
                }
                else
                {
                    $data['usernotconnected'][]=$mediam;
                }
            }
        }
        return ($data);
        
    }
     public function get_product_by_bid($bidid)
     {
        $mediaarr=array();
        $this->ci->db->select('p.*,p.id as product_id');
        $this->ci->db->from('product_bids b');
        $this->ci->db->join('products p','b.product_id=p.id');
        $this->ci->db->where('b.id',$bidid);
        // $this->ci->db->where('ss.isActive',1);
        $query=$this->ci->db->get();
        $data=$query->row();
       
        return $data;
    }
    public function get_influencer_by_bid($bidid)
     {
        
        $this->ci->db->select('md.name,m.*');
        $this->ci->db->from('product_bids b');
        $this->ci->db->join('members m','m.id=b.user_id');
        $this->ci->db->join('members_details md','m.id=md.user_id');
        $this->ci->db->where('b.id',$bidid);
        // $this->ci->db->where('ss.isActive',1);
        $query=$this->ci->db->get();
        $data=$query->row();
       
        return $data;
    }
     public function get_product_by_user($user)
     {
        $mediaarr=array();
        $this->ci->db->select('p.*,p.id as product_id');
        $this->ci->db->from('products p');
        $this->ci->db->where('p.brand_id',$user);
        $this->ci->db->where('p.status','2');
        $query=$this->ci->db->get();
        $data=$query->result();
        return $data;
    }
	public function get_theme_details_by_theme_name($theme_name)
	{
		$this->ci->db->where('theme_name',$theme_name);
		$this->ci->db->where('display','Yes');
		$this->ci->db->limit(1);
		$query = $this->ci->db->get('themes');
		if($query->num_rows()>0)
		{
			return $query->row();	
		}
		return FALSE;
	}
	public function get_current_theme()
	{
		$theme_details = $this->get_theme_details_by_theme_name(SITE_DEFAULT_THEME);
		if($theme_details)
		{
			//create css link tag with related css file
			$theme_file_link = '<link href="'.base_url().CSS_DIR.$theme_details->file_name.'" rel="stylesheet" type="text/css">';
			return $theme_file_link;
		}
		return FALSE;
	}

	

	public function get_current_favicon()
	{
		//$theme_name = strtolower(SITE_DEFAULT_THEME);
		$theme_name = strtolower(substr(SITE_DEFAULT_THEME, 0, strrpos(SITE_DEFAULT_THEME, ' ')));
		$favicon_link = '<link rel="shortcut icon" href="'.base_url().IMG_DIR.$theme_name.'/fav.png">';
		return $favicon_link;
	}

	public function get_current_logo($location='')

	{

		//$location defines whetehr the logo is placed in frontend or admin login or admin dashboard

		$theme_name = strtolower(substr(SITE_DEFAULT_THEME, 0, strrpos(SITE_DEFAULT_THEME, ' ')));

		

		if($location=='admin-dashboard'){

			$logo_link = '<a href="'.site_url(ADMIN_DASHBOARD_PATH).'"><img src="'.base_url().IMG_DIR.$theme_name.'/admin_login_logo.png" alt="Bid-cy.com"><span>admin panel</span></a>';	

		}else if($location=='admin-login'){

			$logo_link = '<a href="'.site_url(ADMIN_LOGIN_PATH).'"><img src="'.base_url().IMG_DIR.$theme_name.'/admin_login_logo.png" alt="Bid-cy.com"></a>';

		}else if($location=='pay-by-paypal'){

			$logo_link = base_url().IMG_DIR.$theme_name.'/admin_login_logo.png';

		}else{

			$logo_link = '<a href="'.$this->lang_uri('/').'"><img src="'.base_url().IMG_DIR.$theme_name.'/logo.png" alt="Bid-cy.com"></a>';	

		}

		

		return $logo_link;

	}
	public function format_price_currency_sign($price,$html_start_tag="",$html_end_tag="")

	{

		//if(LANG_EXCHANGE_RATE == "") $exchange_rate = DEFAULT_LANG_EXCHANGE_RATE; else $exchange_rate = LANG_EXCHANGE_RATE;

		if(LANG_DISPLAY_IN == "") $display_in = DEFAULT_LANG_DISPLAY_IN; else $display_in = LANG_DISPLAY_IN;

		if(LANG_CURRENCY_SIGN == "") $currency_sign = DEFAULT_CURRENCY_SIGN; else $currency_sign = LANG_CURRENCY_SIGN;

		

		//$price = number_format($price * $exchange_rate,'2','.','');

		$price = number_format($price,'2','.','');

		

		if($display_in == 'Right')

		{

			$formate = $html_start_tag.$price.$html_end_tag.' '.$currency_sign.'';

		}

		else

		{

			$formate = ''.$currency_sign.' '.$html_start_tag.$price.$html_end_tag;	

		}

		

		return $formate;

	}

	public function formate_price_currency_sign_admin($lang_id,$price)
	{

		$lang_data = $this->get_lang_info($lang_id);

		$exchange_rate = $lang_data['exchange_rate'];

		$display_in = $lang_data['display_in'];

		$currency_sign = $lang_data['currency_sign'];

		

		$price = number_format($price * $exchange_rate,'2','.','');

		

		if($display_in == 'Right')

		{

			$formate = $price.'<span> '.$currency_sign.'</span>';

		}

		else

		{

			$formate = '<span>'.$currency_sign.' </span>'.$price;

		}

		

		return $formate;

	}



	// fetch all currency 

	public function fetch_all_currency()

	{

		$this->ci->db->select('id, currency_code, currency_sign');

		$this->ci->db->from('product_currency');

		$this->ci->db->where('is_display', '1');

		$query = $this->ci->db->get();

		if($query->num_rows() <= 0)

			return FALSE;

		else

		{

			$result = $query->result();

			$query->free_result();

			// $result = json_encode($result);

			return $result;

		}

	}

	

	public function get_all_total()

	{				

		$query = $this->ci->db->get('members');

		return $query->num_rows();

	}



	// Date Format Eg: 20 January 2016

	function format_date_frontend($date)

	{

		$str_date=strtotime($date);

		$dt_frmt=date("d F Y",$str_date);

		return $dt_frmt;

	}

    function format_date_frontenddatetime($date)

    {

        $str_date=strtotime($date);

        $dt_frmt=date("d F Y h:i a",$str_date);

        return $dt_frmt;

    }



	public function get_user_details($user_id)

	{

		$this->ci->db->select('M.id, M.username,M.email,M.balance,M.user_type, M.status, MD.name, MD.image, MD.address,MD.address2, MD.state,MD.city,MD.identification_no,MD.country,MD.post_code,MD.phone,MD.about_user,M.brand_url,MD.mobile,MD.company_name,MD.pan_no,MD.company_info, MD.company_address1, MD.company_address2,MD.company_city,MD.age,MD.gender, MD.company_state, MD.company_zipcode, MD.company_country,MD.company_phone,MD.company_fax, MD.bank_name,MD.account_no,M.balance,MD.company_website,MD.cover_image,M.brand_name,M.price,M.available_status,M.referral_points,MD.designation,MD.ceiling_likes,MD.facebook_link,M.price');

		$this->ci->db->from('members M');

		$this->ci->db->join('members_details MD', 'MD.user_id = M.id');
        // $this->ci->db->join('profession p', 'p.id = MD.profession','left');
        

		$this->ci->db->where('M.id', $user_id);

		$this->ci->db->limit(1);

		$query = $this->ci->db->get();

		if($query->num_rows() > 0)

		{

			$result = $query->row();

			$query->free_result();

			return $result;

		}

		return FALSE;

	}

    public function get_active_bid_by_user($userid)
    {
        $this->ci->db->select('*,p.id as product_id');
        $this->ci->db->from('product_bids pb');
        $this->ci->db->join('products p','p.id=pb.product_id');
        $this->ci->db->where(array('pb.user_id'=>$userid));
        $this->ci->db->where('pb.status in (0,1,2)');
        $query = $this->ci->db->get();

        if($query->num_rows() > 0)

        {

            $result = $query->result();

            return $result;

        }

    }


	// Display Text for the product status

	public function get_product_status($status)

	{

		$status_text = '';

		switch($status)

		{			

			case '1':

			$status_text = 'Pending';

			break;



			case '2':

			$status_text = 'Active';

			break;



			case '3':

			$status_text = 'Closed';

			break;



			case '4':

			$status_text = 'Cancelled';

			break;			

		}

		return $status_text;

	}



	// Get list of all timezonees

	public function timezone_list($name, $default='', $extra = '') {

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



		$formdropdown = form_dropdown($name, $timezones, trim($default), $extra);

		

		return $formdropdown;

	}



	// set validity while buyer registration

	public function set_member_validity_settings_buyer($user_id)

	{

		// update members data with free auction posts if no of free auction post is set less than 99999

		if(NO_FREE_AUCTION_POST < '99999') 

		{

			$data = array(

				'balance_free' => NO_FREE_AUCTION_POST,

				'balance_paid' => 0,

				'membership_type' => 'one_post',

				'member_validity' => $this->get_local_time('now'),

				);

			$this->ci->db->where('id', $user_id);

			$this->ci->db->update('members', $data);

			return $this->ci->db->affected_rows();

		}

		else

			return FALSE;

		

	}

    public function get_message_notification_user($userid)
    {
        $this->ci->db->select('count(id) as count');
        $query=$this->ci->db->get_where('communication',array('receiver_id'=>$userid,'ismsgseen'=>'0'));
        if($query->num_rows()>0)
        {
            $data= $query->row();   
            return $data->count;
        }
        else
        {
            return 0;
        }

    }

	// set validity while supplier registration

	public function set_member_validity_settings_supplier($user_id)

	{

		// update members data with free bid places if no of free bid palces is set less than 9999999999

		if(NO_FREE_BID_PLACES < '999999999')

		{

			$data = array(

				'balance_free' => NO_FREE_BID_PLACES,

				'balance_paid' => 0,

				'membership_type' => 'one_bid',

				'member_validity' => $this->get_local_time('now'),

				);

			$this->ci->db->where('id', $user_id);

			$this->ci->db->update('members', $data);

			return $this->ci->db->affected_rows();

		}

		else

			return FALSE;

	}



	// for buyer auction post validity

	public function get_auction_post_member_validity($user_id)

	{

		$member_data = $this->fetch_members_selected_fields(array('id', 'user_type','balance_free', 'balance_paid', 'membership_type', 'member_validity'), array('id' => $user_id));

       

        if(IS_AUCTION_POST_COST==1){

             $current_date = $this->get_local_time('now');

    		if(NO_FREE_AUCTION_POST > 0 && NO_FREE_AUCTION_POST < 99999)

    		{

    			if($member_data->balance_free > 0)

    				return 'free';

                else if($member_data->membership_type =='') return false;

                elseif($member_data->membership_type == 'one_post' && $member_data->balance_paid <= 0)

                    return false;

                else if ($member_data->membership_type == 'unlimited' && strtotime($member_data->member_validity) <= strtotime($current_date))

                    return false;



                else

                {

                    if($member_data->membership_type == 'one_post')

                     return 'one_post';

                    else return 'unlimited';

                }

                

    		}

    		else if(NO_FREE_AUCTION_POST == 0)

    		{

    			 $current_date = $this->get_local_time('now');

                 if($member_data->membership_type == 'one_post' && $member_data->balance_paid <= 0)

    				return FALSE;

    			 else if ($member_data->membership_type == 'unlimited' && strtotime($member_data->member_validity) <= strtotime($current_date))

    				return FALSE;

                 else if($member_data->membership_type =='') return false;

                 else

                {

                    if($member_data->membership_type == 'one_post')

                     return 'one_post';

                    else return 'unlimited';

                }

    		}

        }
        else{

            return 'free';

        }

		

	}



	// for seller bid validity

	public function get_bid_member_validity($user_id)

	{

		$member_data = $this->fetch_members_selected_fields(array('id', 'user_type','balance_free', 'balance_paid', 'membership_type', 'member_validity'), array('id' => $user_id));



		if(IS_BID_PLACE_COST==1){

              $current_date = $this->get_local_time('now');

                if(NO_FREE_BID_PLACES > 0 && NO_FREE_BID_PLACES < 999999999)

                {

                    if($member_data->balance_free > 0)

                            return 'free';

                        else if($member_data->membership_type =='') return false;

                        elseif($member_data->membership_type == 'one_bid' && $member_data->balance_paid <= 0)

                            return false;

                        else if ($member_data->membership_type == 'unlimited' && strtotime($member_data->member_validity) <= strtotime($current_date))

                            return false;



                        else

                        {

                            if($member_data->membership_type == 'one_bid')

                             return 'one_post';

                            else return 'unlimited';

                        }

                }

                else if(NO_FREE_BID_PLACES == 0)

                {

                     $current_date = $this->get_local_time('now');

                     if($member_data->membership_type == 'one_bid' && $member_data->balance_paid <= 0)

                        return FALSE;

                     else if ($member_data->membership_type == 'unlimited' && strtotime($member_data->member_validity) <= strtotime($current_date))

                        return FALSE;

                     else if($member_data->membership_type =='') return false;

                     else

                     {

                         if($member_data->membership_type == 'one_bid')

                         return 'one_bid';

                         else return 'unlimited';

                     }

                 }

        }

        else  return 'free';

	}

    public function get_objectives()
    {
        $response=$this->get_data('objective',array('status'=>'1'));
        if($response)      return $response;
        else  return false;
    }

	// to generate auction end date from auction start date and auction end days added while auction post

	public function get_end_date($start_date, $days)

	{

		// add days to start date to generate auction end date

		return date('Y-m-d H:i:s', strtotime("$start_date + $days days"));

	}



	// added by manish

    // reduce balance for both buyer and supplier

	public function reduce_balance($user_id, $payment_type)

	{


		if($payment_type == 'free')

		{

			$this->ci->db->set('balance_free', 'balance_free-1', FALSE);

			$this->ci->db->where('id', $user_id);

			return $this->ci->db->update('members');

		}

		else if ($payment_type == 'one_post' || $payment_type == 'one_bid')

		{

			$this->ci->db->set('balance_paid', 'balance_paid-1', FALSE);

			$this->ci->db->where('id', $user_id);

			return $this->ci->db->update('members');

		}
        else{
            return true;
        }

	} 

    function file_get_contents_curl( $url )
    {

     $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;

    }



	public function get_current_time_by_auction_timezone($auction_time_zone)

	{

		$userTimezone = new DateTimeZone($auction_time_zone);

		$end_time = new DateTime("now", $userTimezone); 

		return $end_time->format('Y-m-d H:i:s'); 

	}

    public function getunseenmessagenotification($user_id)
    {
         
         $this->ci->db->select('*');
         $this->ci->db->from('communication c');
         $this->ci->db->join('members_details m','c.sender_id=m.user_id');
         $this->ci->db->where(array('c.receiver_id'=>$user_id,'ismsgseen'=>'0'));
         $this->ci->db->group_by('c.bid_id');
         $this->ci->db->order_by('c.id','asc');
         $query=$this->ci->db->get();
         $this->ci->db->last_query();
         $result=$query->result();
     
        return $result;
    }
    public function savethisasnotification($user_id,$msg,$productid=false)
    {
        $data=array('user_id'=>$user_id,'notification_message'=>$msg,'product_id'=>$productid,'is_display'=>'1','datetime'=>date('Y-m-d h:i:s'));
        $id=$this->insert_data('notification',$data);
        return true;
    }
    public function savethisasnotificationforadmin($msg)
    {
        $data=array('user_id'=>'0','notification_message'=>$msg,'datetime'=>date('Y-m-d h:i:s'));
        $id=$this->insert_data('notification',$data);
        return true;
    }
    public function getunseennotification($user_id)
    {
        $data=array('user_id'=>$user_id,'is_display','1','isnotifyseen'=>'0');
        $data=$this->get_data('notification',$data);
        return $data;
    }
    public function getusername_id($userid)
    {
        $this->ci->db->select('username,name,md.country');
        $this->ci->db->from('members m');
        $this->ci->db->join('members_details md','m.id=md.user_id');
        $this->ci->db->where('m.id',$userid);
        $query= $this->ci->db->get();
        return $query->row();
    }

    public function get_all_payment_gateway($id=false)
    {
        //$this->db->order_by("amount", "ASC"); 
        $CI=& get_instance();
        if($id)
        {
            $CI->db->where('id',$id);
        }
        $query = $CI->db->get_where('payment_gateway',array('is_display'=>'Yes'));
        
        if($query->num_rows()>0)
        {
            return $query->result();
        }
    }
    function create_custom_link($product_id,$userid)
    {
        $product=$this->get_single_row('products',array('id'=>$product_id));
        $name=$product->name;
        $member=$this->get_single_row('members',array('id'=>$userid));
        $username=$member->username;
        if($username=='')
        {
            $usertemp=explode('@',$member->email);
            $username=$usertemp['0'];
        }
        $nametemp=explode(' ',$name);
        $name=implode('-',$nametemp);
        return site_url("/mycampaign/$name/$product_id/$username");
    }

    public function getmediabyproduct($product_id){
        $socialmediaid=$this->general->get_data('product_socialmedia',array('product_id'=>$product_id));
        foreach ($socialmediaid as $key => $value) {
            $media[]=$value->socialmedia_id;
        }
        if(count($media)>0)
        {
            echo json_encode($media);
        }
        else
        {
            echo json_encode('error_message','No product media found');
        }
        
    }

    public function get_uploaded_content($bidid)
    {
        $this->ci->db->select('*');
        $this->ci->db->from('final_uploaded_content');
        $this->ci->db->where('bid_id',$bidid);
        $query=$this->ci->db->get();
        if($query->num_rows()>0)
        {   
            return $query->result();
        }
        return false;
    }

     public function get_report($bidid)
    {
        $this->ci->db->select('*');
        $this->ci->db->from('report');
        $this->ci->db->where('bid_id',$bidid);
        $query=$this->ci->db->get();
        if($query->num_rows()>0)
        {   
            return $query->result();
        }
        return false;
    }

    public function getproductbyid($product_id){
        // $user_id = $this->session->userdata(SESSION.'user_id');
        if($product_id){    
           
          
                $productdetail=$this->get_single_row('products',array('id'=>$product_id));
          
                if(is_object($productdetail) && (count($productdetail)>0) )
                {
                  
                    $product['detail']=$productdetail;
                    $product['socialmedia']=$this->get_data('product_socialmedia',array('product_id'=>$product_id));
                    $product['image']=$this->get_data('product_images',array('product_id'=>$product_id));
                    $this->ci->db->select('pb.*,m.price');
                    $this->ci->db->from('product_bids pb');
                    $this->ci->db->join('members m','pb.user_id=m.id');
                    $this->ci->db->where('pb.product_id',$product_id);
                    $query=$this->ci->db->get();
                   
                    if($query->num_rows()>0)
                    {
                        $creators=$query->result();
                        $product['creators']=$creators;
                    }
                    else
                    {
                        $product['creators']=false;
                    }
                  
                    $product['objective']=$this->get_data('product_objective',array('product_id'=>$product_id));
                    return $product;
                }
                else return false;
        }
        else return false;
    }

    
    public function get_profile_image($image)
    {
     
         if(trim($image)!='' &&  file_exists($_SERVER['DOCUMENT_ROOT'].'/upload_files/user-images/'.$image))
             $pp=site_url('/'.USER_IMAGE_PATH.$image);
        else 
            $pp=site_url('/'.USER_IMG_DIR.'profileavatar.jpg');
        
        return $pp;               
    } 
     public function get_product_image($image)
    {

         if((trim($image)!='')  && file_exists($_SERVER['DOCUMENT_ROOT'].'/upload_files/product-images/'.$image))
         {
               $pp=site_url(PRODUCT_IMAGE_PATH.$image);
         }
        else 
            $pp=site_url('/'.USER_IMG_DIR.'defaultproduct.png');
        
        return $pp;               
    } 

    public function get_tax_percent_by_country($country){
        $arr=array('spain'=>'21','nepal'=>'10');
        foreach($arr as $key=>$countryarr)
        {
            if(strtolower($country)==strtolower($key))
            {
                return $countryarr;
            }
        }
        return 0;
      
    }
public function getmessage($type='inbox')
    {

            $userid=$this->ci->session->userdata(SESSION.'user_id');
            $string=$this->ci->input->post('searchstr',true);
            $cond='1=1';
            
            $group='bid_id';
            $filt=false;
            $type=false;
            if($type=="inbox")
            {
                $filt=array('c.receiver_id'=>$userid);      
            }
            if($type=='sent'){
                $filt=array('c.sender_id'=>$userid);
            }
            if($type=='action_required')
            {
                $cond=array('c.bid_status'=>1);
                $group='bid_id,bid_status';
            }
            if($type=='review')
            {
                $cond=array('c.bid_status'=>2);
                $group='bid_id,bid_status';
            }
            if($type=='production')
            {
                $cond=array('c.bid_status'=>3);
                $group='bid_id,bid_status';
            }
            if($type=='completed')
            {
                $cond=array('c.bid_status'=>7);
                $group='bid_id,bid_status';
            }
            if($string){
                $searchstr="m.email like '%$string%' or n.email like '%$string%' or ec.message like '%$string%'";
            }

            $this->ci->db->select('bid_id,max(c.id) as pid');
            $this->ci->db->from('communication c');
            $this->ci->db->join('communication_attachment ca','c.id=ca.msg_id','left');
            if($filt) $this->ci->db->where($filt);
            else{
                 $this->ci->db ->or_group_start();
                 $this->ci->db->where(array('c.receiver_id'=>$userid));
                 $this->ci->db->or_where(array('c.sender_id'=>$userid));
                 $this->ci->db->group_end();
                }
             $this->ci->db->where($cond);
             $this->ci->db->group_by($group);
               $tempquery=$this->ci->db->get_compiled_select();

             $this->ci->db->select('m.name as sender_name,m.user_id as sender_id,ec.bid_id,n.name as receiver_name,ec.message,ec.ismsgseen,ec.sender_id,ec.receiver_id,ec.messagedate,m.cover_image as sender_image,n.cover_image as receiver_image');
             $this->ci->db->from('('.$tempquery.') as a');
             $this->ci->db->join('communication ec','a.pid=ec.id');
             $this->ci->db->join('members_details m','ec.sender_id=m.user_id');
             $this->ci->db->join('members_details n','ec.receiver_id=n.user_id');
            // $this->ci->db->select('m.email as sender_email,c.bid_id,n.email as receiver_email,c.message,ismsgseen,c.sender_id,c.receiver_id');
            
            // $this->ci->db->join('communication_attachment ca','c.id=ca.msg_id','left');
            // $this->ci->db->join('members m','c.sender_id=m.id');
            // $this->ci->db->join('members n','c.receiver_id=n.id');
            
            // if($filt) $this->ci->db->where($filt);
            // else{
            //  $this->ci->db ->or_group_start();
            //      $this->ci->db->where(array('c.receiver_id'=>$userid));
            //   $this->ci->db->or_where(array('c.sender_id'=>$userid));
            //   $this->ci->db->group_end();
            // }
            //  $this->ci->db->where($cond);
            //  $this->ci->db->where(array('bid_id')=>$bidid)
                
            // if($string)
            //  $this->ci->db->where($searchstr);

        
            // $this->ci->db->group_by($group);
            // $this->ci->db->order_by('c.id','DESC');
            $query=$this->ci->db->get();
               $this->ci->db->last_query();
             $data=$query->result();
           
        if($data) return $data;
        else return false;


    }
    public function file_settings_do_upload($file, $location, $encrypt_filename='')
    {
        $this->ci->load->library('upload');
        $config['upload_path'] = './'.$location;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $config['remove_spaces'] = TRUE; 
        $config['max_size'] = '4000';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';
        if($encrypt_filename='encrypt')
        {
            $config['encrypt_name'] = TRUE;
        }
        $this->ci->upload->initialize($config);
        $this->ci->upload->do_upload($file);
        if($this->ci->upload->display_errors())
        {
             $this->ci->error_img = $this->ci->upload->display_errors();
             return false;
        }
        else
        {
            $data = $this->ci->upload->data();
            return $data;
        }
    }
   
    function time_elapsed_string($ptime)
    {
         $etime = time() - $ptime;
        if ($etime < 1)
        {
            return '0 sec';
        }
        $a = array( 365 * 24 * 60 * 60  =>  'year',
                     30 * 24 * 60 * 60  =>  'month',
                          24 * 60 * 60  =>  'day',
                               60 * 60  =>  'hour',
                                    60  =>  'minute',
                                     1  =>  'second'
                    );
        $a_plural = array( 'year'   => 'y',
                           'month'  => 'm',
                           'day'    => 'd',
                           'hour'   => 'h',
                           'minute' => 'min',
                           'second' => 'sec'
                    );

        foreach ($a as $secs => $str)
        {
             $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r. ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }
}

