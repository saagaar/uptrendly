<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model 
{
    private $tableLOG_AUDIT = 'log_admin_activity';
    private $tableLOG_INVALID_LOGINS = 'log_invalid_logins';
    private $tableMEMBER = 'members';
       
        
    public function get_total_audit_trial(){
        return $this->db->count_all_results($this->tableLOG_AUDIT);
    }
	
    public function get_total_invalid_login(){
        return $this->db->count_all_results($this->tableLOG_INVALID_LOGINS);
    }
    

    public function get_member_username($id){
        $this->db->select('username');
        $query = $this->db->get_where($this->tableMEMBER, array('id' => $id), 1);
        if ($query->num_rows() > 0){
            return $query->row()->username;
        }
        else{
            return false;
        }
    }
	
	
    public function get_all_admin_activity_log($limit=50,$offset=0){        
        $this->db->order_by($this->tableLOG_AUDIT.".log_time", "desc"); 
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get($this->tableLOG_AUDIT);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0){

            return $query->result_array();
        }
        else{
            return false;
        }
    }
	
	
    public function get_all_invalid_login($limit=50,$offset=0){        
        $this->db->order_by($this->tableLOG_INVALID_LOGINS.".log_time", "desc"); 
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->tableLOG_INVALID_LOGINS);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0){

            return $query->result_array();
        }
        else{
            return false;
        }
    }
    

    public function get_invalid_login_detail($id){
        $query = $this->db->get_where($this->tableLOG_INVALID_LOGINS,array('log_id' => $id), 1);
        //echo $this->db->last_query(); die();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        else{
            return FALSE;
        }
    }
    public function get_log_detail($id){
        $query = $this->db->get_where($this->tableLOG_AUDIT,array('log_id' => $id), 1);
        //echo $this->db->last_query(); die();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        else{
            return FALSE;
        }
    }
    
    
}