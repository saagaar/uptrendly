<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_newsletter extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();		
	}
	
	public $validate_add_edit_newsletter =  array(			
		array('field' => 'subject', 'label' => 'Subject', 'rules' => 'required'),
		array('field' => 'message', 'label' => 'Message', 'rules' => 'required')
	);
	
	public $validate_send_newsletter =  array(			
		array('field' => 'send_to', 'label' => 'Email Send type', 'rules' => 'required'),
		array('field' => 'news_id', 'label' => 'Newsletter Template', 'rules' => 'required'),
	);
	
	public $validate_send_newsletter_selected_members =  array(			
		array('field' => 'member[]', 'label' => 'Members', 'rules' => 'required'),
	);
	
	function insert_newsletter()
	{	
		$data = array(              
			'subject' => $this->input->post('subject', TRUE),			   
			'message' => $this->input->post('message'),
			'is_display' => $this->input->post('is_display', TRUE),
			'send_test_email' => $this->input->post('send_test_email', TRUE),
		);
		
		$this->db->insert('news_letter',$data);
		return $this->db->insert_id();	
	}
	
	function update_newsletter($id)
	{
		$data = array(              
			'subject' => $this->input->post('subject', TRUE),			   
			'message' => $this->input->post('message'),
			'is_display' => $this->input->post('is_display', TRUE),
			'send_test_email' => $this->input->post('send_test_email', TRUE),
			'update_date' => $this->general->get_local_time('now'),
		);
		
		$this->db->where('id', $id);
		$this->db->update('news_letter', $data);
		return $this->db->affected_rows();
	}
	
	
	function get_newsletter_info_byid($id)
	{
		$query = $this->db->get_where('news_letter',array('id'=>$id));		
		return $query->row();
	}
	
	
	function get_all_newsletter_info()
	{
		$query=$this->db->get_where('news_letter', array('is_display' => '1'));
		if($query->num_rows()>0)
		{
			$result = $query->result_array();
			$query->free_result();
			return $result;
		}
		return array();
	}
	
	
	public function count_total_members()
	{	
		$this->db->select('M.id, M.username, M.email, M.user_type, MD.name, MD.last_name');
		$this->db->from('members M');
		$this->db->join('members_details MD', 'MD.user_id = M.id', 'LEFT');
		if($this->input->post('srch')!="")
		{
			$where = "(MD.name LIKE '%".$this->input->post('srch')."%' OR M.username LIKE '%".$this->input->post('srch')."%' OR M.email LIKE '%".$this->input->post('srch')."%' OR MD.mobile LIKE '%".$this->input->post('srch')."%')";
			
			$this->db->where($where);
		}
		$this->db->where_not_in('user_type', array('1', '2'));

		$query = $this->db->get();
		return $query->num_rows();
	}
	
	
	public function get_members_details($perpage,$offset)
	{
		$this->db->select('M.id, M.username, M.email, M.user_type, MD.name, MD.last_name');
		$this->db->from('members M');
		$this->db->join('members_details MD', 'MD.user_id = M.id', 'LEFT');
		if($this->input->post('srch')!="")
		{
			$where = "(MD.name LIKE '%".$this->input->post('srch')."%' OR M.username LIKE '%".$this->input->post('srch')."%' OR M.email LIKE '%".$this->input->post('srch')."%' OR MD.mobile LIKE '%".$this->input->post('srch')."%')";
			
			$this->db->where($where);
		}
		$this->db->where_not_in('user_type', array('1', '2'));

		$this->db->order_by("id", "desc");
		if($perpage)
			$this->db->limit($perpage, $offset);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		} 

		return FALSE;
	}
	
	function get_all_members_email($members = '', $member_type = '')
	{
		$data=array();
		$this->db->select('M.id, M.username, M.email, MD.mobile, MD.name, MD.last_name');
		$this->db->from('members M');
		$this->db->join('members_details MD', 'MD.user_id = M.id', 'LEFT');
		if($members)
			$this->db->where_in('M.id', $members);
		elseif($member_type == 'buyers')
			$this->db->where('M.user_type', '3');
		elseif($member_type == 'suppliers')
			$this->db->where('M.user_type', '4');
		$this->db->where_not_in('user_type', array('1', '2'));
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$data=$query->result_array();
		}
		return $data;
	}
	

	function viewnewsletter()
	{
		$data=array();
		$query=$this->db->get('news_letter');
		if($query->num_rows()>0)
		{
			$data=$query->result();
		}		
		return $data;
	}
	
	//SEND NEWSLETTER EMAIL TO SELECTED MEMBERS
	function send_newsletter()
	{	
		// load email model
		// $this->load->model('email_model');

		$newsid = $this->input->post('news_id',TRUE);
			
		//get newslettter template
		$query = $this->db->get_where('news_letter',array('id'=>$newsid));
		$newsletter_info = $query->row_array();
			
		$subject = $newsletter_info['subject'];
		$message = $newsletter_info['message'];
		
		$count=0;

		//Load email
		$this->load->library('email');
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
 		$this->email->set_newline("\r\n");			
		
		if($this->input->post('send_to',TRUE) == 'selected_members') 
		{ 
			$members = $this->input->post('member',TRUE);
			if($members)
			{
				$members_info = $this->get_all_members_email($members, 'selected');
				if($members_info)
				{
					$count = $this->send_newsletter_email($members_info, $message, $subject);
				}
			}
			
		}
		else if($this->input->post('send_to', TRUE) == 'all_buyers')
		{
			//send email to all the members
			$all_buyers_data = $this->get_all_members_email('', 'buyers');
			if($all_buyers_data)
			{
				$count = $this->send_newsletter_email($all_buyers_data, $message, $subject);
			}
		}
		else if($this->input->post('send_to', TRUE) == 'all_suppliers')
		{
			//send email to all the members
			$all_buyers_data = $this->get_all_members_email('', 'suppliers');
			if($all_buyers_data)
			{
				$count = $this->send_newsletter_email($all_buyers_data, $message, $subject);
			}
		}
		else if($this->input->post('send_to',TRUE) == 'all_members')
		{
			//send email to all the members
			$all_members_data = $this->get_all_members_email();
			if($all_members_data)
			{
				$count = $this->send_newsletter_email($all_members_data, $message, $subject);
			}
		}		
		
		return $count;
	}

	// send news letter
	public function send_newsletter_email($members_data, $message, $subject)
	{
		$count=0;
		foreach($members_data as $data)
		{		
			$parseElement = array(						
				"USERNAME" => $data['username'],
				"EMAIL" => $data['email'],
				"FIRSTNAME" => $info['name'],
			);

			// $email_message = $this->email_model->parse_email($parseElement,$message);

			// $this->email->from(CONTACT_EMAIL);
			// $this->email->to($data['email']); 
			// $this->email->subject($subject);
			// $this->email->message($email_message); 				
			// $this->email->send();				
			$count++;
		}
		return $count;
	}

	public function send_test_mail($subject, $email_message)
	{
		$this->email->from(CONTACT_EMAIL);
		$this->email->to(CONTACT_EMAIL); 
		$this->email->subject($subject);
		$this->email->message($email_message); 				
		$this->email->send();
	}
}
?>