<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
    private $tableADMIN = 'members';
    //private $tableROLES = 'admin_roles';
    private $tablePERMISSIONS = 'admin_permissions';
    private $tableROLE_PERMISSION = 'admin_roles_permission';


    /**
     * Email Template Form Validation Rules
     */
    public $validate_rules_password = array(
        array('field' => 'password' , 'label' => 'Password' , 'rules' => 'required|min_length[6]|max_length[20]'),
        array('field' => 'confirm_password' , 'label' => 'Password Confirmation' , 'rules' => 'required|min_length[6]|max_length[20]|matches[password]'),
    );
	
    public $validate_rules_administrator = array(
        array('field' => 'user_type' , 'label' => 'Admin Type' , 'rules' => 'required|integer'),
        array('field' => 'status' , 'label' => 'Status' , 'rules' => 'required'),    
    );
	
    public $validate_rules_add_admin = array(
	 	array('field' => 'email' , 'label' => 'Email' , 'rules' => 'required|valid_email|is_unique[members.email]'),
        array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[6]|is_unique[members.username]'),
    );
	
    public $validate_rules_edit_admin = array(
	array('field' => 'email' , 'label' => 'Email' , 'rules' => 'required|valid_email|callback__email_unique]'),
        array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[6]|callback__username_unique') 
    );
    
   /* public $validate_role_permission = array(
        array('field' => 'role_name', 'label' => 'Name', 'rules' => 'trim|required|min_length[6]|max_length[100]'),       
        array('field' => 'role_code', 'label' => 'Code', 'rules' => 'trim|required|min_length[4]|max_length[50]|callback__rolecode_unique'),
        array('field' => 'role_desc', 'label' => 'Description', 'rules' => 'trim|required|min_length[6]|max_length[200]'),        
    );*/
    
    public function get_total_admins(){
		$this->db->where('user_type','1');
		$this->db->or_where('user_type','2');
        return $this->db->count_all_results($this->tableADMIN);
    }
	
    public function get_total_roles(){
        return $this->db->count_all_results($this->tableROLES);
    }

    public function get_all_admins($limit=50,$offset=0)
	{
		$this->db->where('user_type','1');
		$this->db->or_where('user_type','2');
        $this->db->order_by($this->tableADMIN.".username", "asc"); 
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->tableADMIN);        
        if ($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
	
    public function get_all_admin_roles($limit=50,$offset=0){
        $this->db->order_by($this->tableROLES.".name", "asc"); 
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->tableROLES);        
        if ($query->num_rows() > 0){

            return $query->result();
        }
        else{
            return false;
        }
    }
	
    public function get_detail_info($username=NULL,$id=0){
        $this->db->select($this->tableADMIN.'.*',FALSE);
       
        if($username){
            $this->db->where(array('username' => $username));
        }
        $query = $this->db->get_where($this->tableADMIN, array('id' => $id),1);        
        if($query->num_rows()>0){
            return $query->row_array();
        }
        else{
            return FALSE;
        }
    }

    public function get_detail_by_username_id($username=NULL,$id=0){
        if($username)
		{
            $this->db->where(array('username' => $username));
        }
        $query = $this->db->get_where($this->tableADMIN, array('id' => $id));        
        
		//echo $this->db->last_query(); exit;
		//echo $query->num_rows(); exit;
		
		if($query->num_rows()==1)
		{
            return $query->row_array();
        }
        else
		{
            return FALSE;
        }
    }
    
    public function get_all_roles(){
        $query = $this->db->get($this->tableROLES);
        if($query->num_rows()>0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
	
    public function add_administrator(){
		$salt = $this->general->salt();
        $password = $this->input->post('password',TRUE);	
		$hash_password = $this->general->hash_password($password,$salt);
		
		$data = array(
			'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $hash_password,
            'salt' => $salt,
            'user_type' => $this->input->post('user_type'),
			'reg_date' => $this->general->get_local_time('time'),
            'reg_ip' => $this->input->ip_address(),
			'status' => $this->input->post('status'),
        );
        $this->db->insert($this->tableADMIN,$data);
        return $this->db->affected_rows();
    }
	

    public function update_administrator($username=NULL,$id=0)
	{       
        $data = array(
		 	'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
           	'user_type' => $this->input->post('user_type'),
            'status' => $this->input->post('status'), 
        );
        //Change Password
        if($this->input->post('change_password') == 'change_password')
		{
            //add salt change password
            $checkadmin = $this->get_detail_by_username_id(null,$this->input->post('id'));
            if($checkadmin)
			{
				$salt = $this->general->salt();		
				$password = $this->input->post('password',TRUE);
				$hash_password = $this->general->hash_password($password,$salt);

                $data['password'] = $hash_password;
				$data['salt'] = $salt;
				 
            }
			//echo "<pre>"; print_r($checkadmin); echo "</pre>"; //exit;
        }
		
		//echo "<pre>"; print_r($data); echo "</pre>"; exit;
		
        $check = $this->db->update($this->tableADMIN,$data,array('id' => $this->input->post('id')));
		
		if($check)
		{
			return true;
		}
		else
		{
			return false;
		}
    }
	
    
    public function delete_administrator($username,$id)
	{
        $this->db->delete($this->tableADMIN,array('username' => $username, 'id' => $id));
        return $this->db->affected_rows();
    }
	
	
    public function change_status($status)
	{
        $failed = 0;
        if($this->input->post('auction_select')){
            $data = array('status' => $status);
            $admin_selected = array_values($this->input->post('auction_select'));
            //delete the admin id if it is yourself
            if(($key = array_search($this->session->userdata(ADMIN_LOGIN_ID), $admin_selected)) !== false) {
                unset($admin_selected[$key]);
                $failed++;
            }
            //update the admins
            $this->db->where_in('id',$admin_selected);
            $this->db->update($this->tableADMIN,$data); 
			
			//echo $this->db->last_query(); exit;
			               
            return array($this->db->affected_rows(),$failed);
        }
        else
		{
            return array(FALSE,$failed);
        }
    }

    
	public function get_role_permission($id)
	{
        $this->db->join($this->tablePERMISSIONS, $this->tableROLE_PERMISSION.'.permission_id = '.$this->tablePERMISSIONS.'.permission_id','left');
        $query = $this->db->get_where($this->tableROLE_PERMISSION,array('role_id' => $id));
        if($query->num_rows()>0){
            return $query->result_array();
        }
    }
	
	
    public function get_all_roles_permission($user_type,$parent_id)
	{
        $this->db->join($this->tableROLE_PERMISSION, ''.$this->tablePERMISSIONS.'.permission_id = '.$this->tableROLE_PERMISSION.'.permission_id ','left');
                
        //$this->db->order_by($this->tablePERMISSIONS.'.display_order','asc');
        $query = $this->db->get_where($this->tablePERMISSIONS,array($this->tableROLE_PERMISSION.'.user_type' => $user_type));        
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return FALSE;
        }
    }
    
	
   
    
    /*
     * Get Nested Permissions Recursively
     * @param int $group_id
     * @return array $output
     */
	 
    public function get_child_recursive_permissions($group_id=0){
        $output = array();
        $this->db->order_by($this->tablePERMISSIONS.'.display_order', 'ASC');
        $query = $this->db->get_where($this->tablePERMISSIONS, array('group_id' => $group_id));
        if($query->num_rows()>0)
		{
            foreach($query->result() as $item)
			{
                $perm_data = new stdClass();
                $perm_data->info = $item;
                $perm_data->child = $this->get_child_recursive_permissions($item->permission_id);
                $output[$item->permission_id] = $perm_data;
            }
        }else{
            return FALSE;
        }
        
        return $output;
    }
	
    public function delete_role_permissions($user_type){
        $this->db->delete($this->tableROLE_PERMISSION, array('user_type' => $this->input->post('user_type')));
		//echo $this->db->last_query(); exit;
    }

    public function update_role_permissions()
	{
        $action_performed = 0;
        $permissions = $this->input->post('permission');
		
		//echo "<pre>"; print_r($permissions); echo "</pre>";  //exit;
		
        //delete old permission
        $this->delete_role_permissions($this->input->post('user_type'));
        //add new permission
        if($permissions)
		{
            $data_permission = array();
            foreach($permissions as $perms)
			{
                $data_permission[] = array(
                    'user_type' => $this->input->post('user_type'),
                    'permission_id' => $perms
                );
            }
            if(count($data_permission)>0)
			{
                $this->db->insert_batch($this->tableROLE_PERMISSION, $data_permission); 
                $action_performed = $this->db->affected_rows();
				//echo $this->db->last_query(); 
            }
        }
        
        return $action_performed;
    }
    
     
    public function role_exists_by_id($role_id){
        $query = $this->db->get_where($this->tableROLES, array('role_id' => $role_id));
        if($query->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
    public function is_role_assigned($role_id){
        $query = $this->db->get_where($this->tableADMIN, array('role_id' => $role_id));
        if($query->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
    public function delete_requested_role($role_id){
        $this->db->delete($this->tableROLES, array('role_id' => $role_id));
        return $this->db->affected_rows();
    }
}