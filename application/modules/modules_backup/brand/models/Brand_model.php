<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends CI_Model
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

	public $validate_invitation_settings = array(
		array('field' => 'user_email', 'label' => 'User Email', 'rules' => 'trim|required|callback_email_available'),
		array('field' => 'message', 'label' => 'Invitation Message' , 'rules' => 'trim|required|min_length[10]|max_length[100]'),
	);
	public $validate_buyer_send_message = array(
		array('field' => 'message', 'label' => 'Message', 'rules' => 'required'),
		array('field'=>'attachment','label'=>"file",'rules'=>'')
	);
	public $validate_payment = array(
		array('field' => 'amount', 'label' => 'Top up Amount', 'rules' => 'required|integer|trim|xss_clean'),
		array('field' => 'payment_type', 'label' => 'Payment Method', 'rules' => 'required'),
	);
	
	public function getallcreators()
	{	
		$creatortype=$this->input->post('creatortype',true);
		$audience_country=$this->input->post('audience_country',true);
		$creator_country=$this->input->post('creator_country',true);
		$cond='';
		if($audience_country)
		{
			$cond=$cond." and a.country_code='$audience_country'";
		}
		if($creator_country)
		{
			$cond=$cond." and s.country='$creator_country'";
		}
		$join='';
		$prefix=$this->db->dbprefix;
		$sql=$this->db->query(
								'SELECT 
								(
								
								SELECT GROUP_CONCAT(media_type SEPARATOR ",") FROM '.$prefix.'member_socialmedia  ms
								JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ms.media_type_id) WHERE ms.user_id=m.id
								GROUP BY ms.user_id 
								) AS media,
								(select country_code from '.$prefix.'audience_geography where user_id=m.id order by number_user desc limit 1 ) as audience_country,
									d.name AS member_name,d.cover_image,s.*
								FROM '.$prefix.'members m  
								left JOIN '.$prefix.'members_details d ON m.id=d.user_id
								JOIN '.$prefix.'member_socialmedia s ON (m.primary_media=s.media_type_id and s.user_id=m.id)
								WHERE user_type="4" AND STATUS="1"'. $cond
							 );
	// echo  $this->db->last_query();
		$result=$sql->result('array');
		if(count($result)>0) return $result;
		else return array();
				
	}

	public function getaudiencedemography(){
		$prefix=$this->db->dbprefix;
		$sql=$this->db->query('
							SELECT * FROM '.$prefix.'audience_demographic AS a 
							JOIN (
									 SELECT id,number_male AS number   FROM '.$prefix.'audience_demographic  AS b where user_id=42
									 UNION ALL SELECT id,number_female FROM '.$prefix.'audience_demographic  AS t where user_id=42 ORDER BY number DESC LIMIT 1
									 )AS c ON(a.id=c.id)'
								 );
		$this->db->last_query();
		$result=$sql->result('array');
		if(count($result)>0) return $result;
		else return array();

	}

	public function getuserproduct($userid=false,$type='campaign')
	{	
		$media=$this->input->post('filtermediatype',true);
		$price_range=$this->input->post('filterpricerange',true);
		$name=$this->input->post('filterproductname',true);
		$category=$this->input->post('filtercategory',true);
		$status=$this->input->post('filterstatus',true);
		$proposaltype=$this->input->post('filterproposaltype',true);
		$join='';
		$cond='';
		$prefix=$this->db->dbprefix;	
		if((trim($name)!=''))
		{
			$cond=$cond." and p.name like ('%$name%')";
		}
		if((trim($price_range)!=''))
		{
			
			$cond=$cond." and p.price_range=$price_range";
		}
		if(trim($category)!='')
		{

			$cond=$cond." and  p.cat_id=$category";
		}

		if(trim($media)!=''){
				
			$join='JOIN '.$prefix.'product_socialmedia psa ON (p.id=psa.product_id)';
			$cond=$cond." and psa.socialmedia_id=$media";
		}
		if($userid){
			$cond=$cond." and p.brand_id=$userid";
		}
		
		if($proposaltype){
			if($proposaltype=='open'){
				$cond=$cond." and p.save_method=1 and p.status not in (3,4)";
			}elseif($proposaltype=='draft'){
				$cond=$cond." and p.save_method=2";
			}elseif($proposaltype=='closed'){
				$cond=$cond." and p.status in (3,4)";
			}else{
				$cond=$cond;
			}
		}

		$query=$this->db->query('
									SELECT 
										(
											SELECT image FROM '.$prefix.'product_images AS i WHERE i.product_id=p.id LIMIT 1 
										) as image,
										(
											SELECT GROUP_CONCAT(media_type SEPARATOR ",") FROM '.$prefix.'product_socialmedia  ps
											JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ps.socialmedia_id) WHERE ps.product_id=p.id
											GROUP BY ps.product_id 
										) as media,
										(
											SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id
										) as proposalcount,
										(
											SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("1","2","3")
										) as productioncount,
										(
											SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("7")
										) as completedcount,
										(
											SELECT sum(user_bid_amt) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("1","2","3","7")
										) as spend,
										p.name AS product_name,product_code,p.id as product_id,p.status,p.submission_deadline,pr.price_range,p.post_date,p.description,p.product_url
									FROM '.$prefix.'products p 
									JOIN '.$prefix.'product_categories c ON p.cat_id=c.id
									JOIN '.$prefix.'pricerange pr ON (p.price_range=pr.id)'.
									$join.'
									WHERE p.create_type="'.$type.'" '.$cond.'
								');
		
		 $this->db->last_query();
		
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
		
	}

	
	public function getproposal($productcode)
	{
		$prefix=$this->db->dbprefix;
		$media=$this->input->post('filtermediatype',true);
		$name=$this->input->post('filtername',true);
		$status=$this->input->post('filterstatus',true);
		$cond='';
		$join='';
		$condtem=''; 
		
		if((trim($name)!=''))
		{
			$cond=$cond." and m.name like ('%$name%')";
			$condtem=$condtem." and md.name like ('%$name%')";
			$join='JOIN '.$prefix.'members_details md ON (md.user_id=pb.user_id)';
		}
		if(trim($media)!=''){
				
			$cond=$cond." and b.mediaid=$media";
			$condtem=$condtem." and pb.mediaid=$media";
		}
		if($status){
			$cond=$cond." and b.status='$status'";
			$condtem=$condtem." and pb.status='$status'";
		}
		$user_id=$this->session->userdata(SESSION.'user_id');
		
		$query=$this->db->query('
								SELECT
									(
										SELECT count(pb.id) from  '.$prefix.'product_bids pb 
										'.$join.'
										where pb.product_id=b.product_id'.$condtem.'
									) as proposalcount,
									(
										SELECT dp.bid_id from  '.$prefix.'draft_promotion dp 
										
										where dp.bid_id=b.id and (b.status="1" or b.status="2") and dp.draft_accept="0"  limit 1
									) as draft,
									(
										SELECT dp.bid_id from  '.$prefix.'draft_promotion dp 
										
										where dp.bid_id=b.id and (b.status="1" or b.status="2") and dp.draft_accept="1"  limit 1
									) as draftaccepted,
									(
										SELECT count(pb.id) from  '.$prefix.'product_bids pb 
										'.$join.'
										where pb.product_id=b.product_id and pb.status in ("1","2","3")'.$condtem.'
									) as productioncount,
									(
										SELECT count(pb.id) from  '.$prefix.'product_bids pb 
										'.$join.'
										where pb.product_id=b.product_id  and pb.status in ("7")'.$condtem.'
									) as completedcount	,
									(
											SELECT sum(user_bid_amt) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("1","2","3","7")
										) as spend,
									(
										SELECT age_range FROM '.$prefix.'audience_demographic AS a 
											JOIN (
											 SELECT id,number_male AS number   FROM '.$prefix.'audience_demographic  AS b where user_id='.$user_id.'
											 UNION ALL SELECT id,number_female FROM '.$prefix.'audience_demographic  AS t where user_id='.$user_id.' ORDER BY number DESC LIMIT 1
											 )AS c ON(a.id=c.id)
									) as audience_demographic,
									(
										select country_code from  '.$prefix.'audience_geography where user_id='.$user_id.' order by number_user desc limit 1
									) as audience_geography,
									(
										
									SELECT  CASE WHEN 
										(SELECT id FROM  '.$prefix.'audience_demographic WHERE number_male=(SELECT GREATEST(MAX(number_male),MAX(number_female)) AS max FROM '.$prefix.'audience_demographic))!="" THEN "Male"
										ELSE "Female"
										END AS primary_audience_gender
									) as primary_audience_gender,
									b.*,b.id as bid_id,b.status as bid_status,ms.*,dp.id as draft_id,dp.draft_accept,p.product_code,m.name as member_name,p.name as product_name,dp.description ,dp.link
										
									FROM '.$prefix.'product_bids b
									join '.$prefix.'products p on (p.id=b.product_id)
									left join '.$prefix.'draft_promotion dp on (b.id=dp.bid_id  )
									join '.$prefix.'members_details m on (b.user_id=m.user_id)
									join '.$prefix.'member_socialmedia ms on (b.mediaid=ms.media_type_id and ms.user_id=m.user_id)
									join '.$prefix.'socialmedia_settings ss on (ms.media_type_id=ss.id)
									WHERE p.product_code="'.$productcode.'"'.$cond.'
									ORDER BY FIELD(b.status, "2","1", "3","0","6","5","7","4")
								');
		
		 $this->db->last_query();
		 $result=$query->result('array');
		 
		if(count($result)>0) return $result;
		else return array();
	}
	public function inviteuser()
	{
		$userid=$this->input->post('userid');
		$userdata=$this->general->get_single_row('members',array('id'=>$userid));
		$email=$userdata->email;
		$product_id=$this->input->post('product_id');
		$campaign=$this->general->get_single_row('products',array('id'=>$product_id));
		$message=$this->input->post('message');
		$current_date=$this->general->get_local_time('now');
		$parseElement = array
					(
						"campaign_name"		=> $campaign->name,
						"EMAIL"				=> $userdata->email,
						"SITENAME"			=> WEBSITE_NAME,
						"message"			=> $message
					);
		$from=SYSTEM_EMAIL;
		$template_code='invitation_creator';
		$this->notification->send_email_notification($template_code, '', $from, $email, '', '', $parseElement, array());
		$notifymsg='You have Been invited for Campaign '.$campaign->name.' .Check your email and visit sponsorship menu';
		$this->general->savethisasnotification($userid,$notifymsg);
		$data=array(
						'product_id'	=>	$product_id,
						'user_email'	=>	$email,
						'message'		=>	$message,
						'invite_date'	=>	$current_date,
						'user_id'		=>	$userid
				   );
		$id=$this->general->insert_data('product_invitation',$data);
			
		if($id) return array('message'=>'Invitation sent successfully');
		else return array('message'=>'Invitation sent failed');
	}

	

	public function checkmessagevalidity($product_id,$bidid){
		$userid=$this->session->userdata(SESSION.'user_id');
		$usertype=$this->session->userdata(SESSION.'usertype');
		if($usertype==3)
		{
			$cond=array('p.seller_id'=>$userid,'p.id'=>$product_id);
		}
		if($usertype==4)
		{
			$cond=array('b.user_id'=>$userid,'p.id'=>$product_id);
		}
		$this->db->select('*');
		$this->db->from('products p');
		$this->db->join('product_bids b','p.id=b.product_id');
		$this->db->where($cond);
		$this->db->where('b.id',$bidid);
		$query=$this->db->get();
		$this->db->last_query();
		$result=count($query->result('array'));
		 return $result;
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
		if($query->num_rows()==1)
		{
		return $query->row();
		}
		return FALSE;
	}

	// to update member selected fields
	public function update_members_selected_fields($fields, $where)
	{
		$update = $this->db->update('members_details',$fields, $where);
		if($update)
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
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
			if($image_name['file_name'])
			{				
				$this->image_name_path = $image_name['file_name'];
				$this->resize_image(USER_IMAGE_PATH,$this->image_name_path,$image_name['raw_name'].$image_name['file_ext'],100,80);
				//now remove old image
				@unlink(USER_IMAGE_PATH.$this->input->post('old'));
				$this->update_members_selected_fields(array('cover_image'=>$this->image_name_path), array('user_id'=>$user_id));
				return TRUE;
			}	
		}
		return FALSE;
	}

	public function upload_custom_fields_files($file,$location)
	{
		$config['upload_path'] = './'.$location;   //file upload location
		$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE; 
		$this->upload->initialize($config);
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			$this->error_img = $this->upload->display_errors();
			return false;
		}
		else
		{
			$data = $this->upload->data();
			return $data;
		}	
	}

	public function upload_attachments_files($file,$location,$name)
	{
		$config['upload_path'] = './'.$location;   //file upload location
		$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf|jpg|jpeg|png';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = false; 
		$config['max_size'] = '2000';
		$config['file_name'] = $name;
		$this->upload->initialize($config);
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			$this->error_img = $this->upload->display_errors();
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
			$config['encrypt_name'] = TRUE;
		}
		$this->upload->initialize($config);
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			 $this->error_img = $this->upload->display_errors();
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
	}

	public function getallmessagecontent($product_id,$bidid)
	{
		$this->db->select('c.*,ca.*,m.username,ca.id as attachmentid,c.messagedate as senddate,md.cover_image');
		$this->db->from('communication c');
		$this->db->join('members m' ,'m.id=c.user_id');
		$this->db->join('members_details md' ,'m.id=md.user_id','left');
		$this->db->join('communication_attachment ca' ,'c.id=ca.msg_id','left');
		$this->db->where(array('c.product_id'=>$product_id,'c.bid_id'=>$bidid));
		$this->db->order_by('c.id','asc');
		$query=$this->db->get();
	    $this->db->last_query();
		$data=$query->result();
		return $data;
	}

	public function getoverallrating($user_id)
	{
		$this->db->select('COALESCE(AVG(overall_rating),0) AS averagerating');
		$this->db->from('member_rating');
		$this->db->where('to_user_id',$user_id.'A');
		$this->db->group_by('to_user_id');
		$query=$this->db->get();
		$result=$query->row();
		if($result) return $result;
		else return (object) array('averagerating'=>0);
	}

	public function getproductwiserating($user_id){
		    $products=$this->db->dbprefix('products');
			$member_rating=$this->db->dbprefix('member_rating');
			$members_detail=$this->db->dbprefix('members_details');
			$query=	$this->db->query('SELECT *,p.name as productname,
					( SELECT COALESCE(AVG(overall_rating),0) FROM '. $member_rating.' AS a WHERE a.to_user_id=mr.from_user_id  GROUP BY a.to_user_id ) AS rateduserrating 
					FROM '. $member_rating.' AS mr
					JOIN '.$products.' AS p ON (mr.product_id=p.id)
					join '.$members_detail.' as d on (d.user_id=mr.from_user_id)
					where mr.to_user_id='.$user_id
					);	
		 	$this->db->last_query();
			$data=$query->result();
			return $data;
		}	

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

    public function listprivateinvitationsent($product_id=false)
    {
    	try{
    		if(!$product_id) throw new Exception("Product  not found", 1);
    			$query=$this->db->get_where('product_invitation',array('product_id'=>$product_id));
    			$data=$query->result('array');
    			if($data) return $data;
    			else return array();
    		}
    	catch(Exception $e){
    		echo $e->getMessage();
    	}

    }

}



