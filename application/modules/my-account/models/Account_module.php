<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_module extends CI_Model
{
	public function __construct() 
	{
		parent::__construct();
		$this->image_name_path='';
	}

//validation for add/edit product in inventory
	public $validate_campaign_creation =  array(	
		array('field' => 'campaign_name', 'label' => 'Campaign Title', 'rules' => 'trim|required|min_length[2]|max_length[100]'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'trim|required|min_length[2]|max_length[200]'),
		array('field' => 'objective[]', 'label' => 'Objective', 'rules' => 'trim|required'),
		array('field' => 'product_name', 'label' => 'Product Name', 'rules' => 'trim|required|max_length[20]|min_length[2]'),
		array('field' => 'product_url', 'label' => 'Product URL', 'rules' => 'trim|max_length[100]'),
		array('field' => 'owner_name', 'label' => 'Full Name', 'rules' => 'trim|required|max_length[50]|min_length[2]'),
		array('field' => 'vatno', 'label' => 'Vat/Pan', 'rules' => 'trim|max_length[50]|min_length[2]'),
		array('field' => 'contact_no', 'label' => 'Contact No', 'rules' => 'trim|required|max_length[15]|min_length[5]'),
		array('field' => 'category', 'label' => 'Category', 'rules' => 'trim|required'),
		array('field' => 'campaign_type', 'label' => 'Campaign Type', 'rules' => 'trim|required'),
		array('field' => 'submission_deadline', 'label' => 'Submission Deadline', 'rules' => 'trim|required'),
		array('field' => 'critical_deadline', 'label' => 'Critical Deadline', 'rules' => 'trim|required'),
		array('field' => 'time_sensitive', 'label' => 'Time Sensitive', 'rules' => 'trim|required'),
	);

//validation rules for change password
	public $validate_changepassword = array(
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required'),
		array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'trim|required|min_length[6]|max_length[20]'),
		array('field' => 're_new_password', 'label' => 'Confirm New Password', 'rules' => 'required|matches[new_password]'),	
	);
	//validation rules for change password
	public $validate_bankdetail = array(
		array('field' => 'bank_name', 'label' => 'Bank Name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'account_no', 'label' => 'Account Number', 'rules' => 'trim|required|max_length[50]'),
	
	);	
	public $validate_general_influencer=array(
	 	array('field' => 'age', 'label' => 'Age', 'rules' => 'trim|required|numeric'),
		array('field' => 'gender', 'label' => 'Gender', 'rules' => 'trim|required'),
		array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'trim|required|max_length[20]'),
		array('field' => 'phone', 'label' => 'Phone', 'rules' => 'trim|required|max_length[15]'),
		array('field' => 'address', 'label' => 'Address', 'rules' => 'trim|required|max_length[100]'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
		array('field' => 'profession[]', 'label' => 'Profession', 'rules' => 'trim|required'),
		array('field' => 'brand_url', 'label' => 'Company Website', 'rules' => 'trim|min_length[2]|max_length[100]'),
		array('field' => 'about_user', 'label' => 'About User', 'rules' => 'trim|required|min_length[2]|max_length[200]'),
		array('field' => 'bank_name', 'label' => 'Bank Name', 'rules' => 'trim|min_length[2]|max_length[50]'),
		array('field' => 'account_no', 'label' => 'Account No', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		
	 );

	public $validate_general_brand=array(
	 	array('field' => 'brand_name', 'label' => 'Company Name', 'rules' => 'trim|required|max_length[100]'),
		array('field' => 'brand_url', 'label' => 'Company Website', 'rules' => 'trim|required|max_length[200]'),
		array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'phone', 'label' => 'Phone', 'rules' => 'trim|required|max_length[15]'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
		array('field' => 'pan_no', 'label' => 'Pan/Vat', 'rules' => 'trim|max_length[20]'),
		array('field' => 'address', 'label' => 'Company Location', 'rules' => 'trim|min_length[2]|max_length[300]'),
		array('field' => 'mobile', 'label' => 'Mobile', 'rules' => 'trim|required|min_length[2]|max_length[15]'),
		array('field' => 'designation', 'label' => 'Designation', 'rules' => 'trim|required|max_length[50]'),
		
	 );
	public $validate_address=array(
	 	array('field' => 'company_address1', 'label' => 'Street Name 1', 'rules' => 'trim|required|min_length[2]|max_length[100]'),
		array('field' => 'company_address2', 'label' => 'Street Name 2', 'rules' => 'trim|required|min_length[2]|max_length[100]'),
		array('field' => 'company_city', 'label' => 'City', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'identification_no', 'label' => 'Identification Number', 'rules' => 'trim|required'),
		array('field' => 'company_state', 'label' => 'State', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'company_zipcode', 'label' => 'Zip Code', 'rules' => 'trim|required|min_length[2]|max_length[10]'),
		array('field' => 'country', 'label' => 'Country', 'rules' => 'trim|required'),
	 );
	public $validate_communication=array(
	 	array('field' => 'message', 'label' => 'Message', 'rules' => 'trim|required|max_length[500]'),
	 	array('field' => 'subject', 'label' => 'Subject', 'rules' => 'trim|required|max_length[200]')
	 );
	public $validate_profile=array(
	 	array('field' => 'urllist', 'label' => 'URL', 'rules' => 'trim|required|max_length[300]')
	 );
	

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

	
	public function insert_new_product($product_id=false)
	{
		$action='add';	
		if($product_id) $action='edit';
		$socialmediaid=explode(',',$this->input->post('brandmediaid',true));
		$campaign_name=$this->input->post('campaign_name',TRUE);
		$description=$this->input->post('description',TRUE);
		$create_type=$this->input->post('create_type',TRUE);
		$owner_name=$this->input->post('owner_name',TRUE);
		$contact_no=$this->input->post('contact_no',TRUE);
		$pan_no=$this->input->post('vatno',TRUE);
		$product_url=$this->input->post('product_url',TRUE);
		$product_name=$this->input->post('product_name',TRUE);
		$price_range=$this->input->post('price_range',TRUE);
		$category_id=$this->input->post('category',TRUE);
		$budgetamount=$this->input->post('budgetamount',TRUE);
		$creatorselected=$this->input->post('creatorselected',TRUE);
		$campaign_type=$this->input->post('campaign_type',TRUE);
		if(!$category_id) $category_id=0;

		$submission_deadline=$this->input->post('submission_deadline',TRUE);
		$critical_deadline=$this->input->post('critical_deadline',TRUE);
		$save_method=$this->input->post('save_method',TRUE);
		$time_sensitive=$this->input->post('time_sensitive',TRUE);
		$least_fan_count=$this->input->post('least_fan_count',true);
		$objective=$this->input->post('objective',true);
		$user_id = $this->session->userdata(SESSION.'user_id');
		$product_code = strtotime('now').$user_id;		

		$tentative_date=$this->input->post('tentative_date',TRUE);
		$tentative_budget=$this->input->post('tentative_budget',true);
		$no_influencer=$this->input->post('no_influencer',true);
		$preferred_gender=$this->input->post('preferred_gender',TRUE);
		$preferred_age=$this->input->post('preferred_age',true);
		$product_data = 
					array
					(	
						'cat_id' 				=> $category_id,
						'brand_id' 				=> $user_id,
						'name' 					=> $campaign_name,
						'description' 			=> $description,
						'product_url' 			=> $product_url,	
						'submission_deadline'	=> $submission_deadline,
						'critical_deadline'		=> $critical_deadline,
						'price_range'			=> isset($price_range)?$price_range:0,
						'owner_name'			=> $owner_name,
						'pan_no'				=> $pan_no,
						'contact_no'			=> $contact_no,
						'create_type'			=> $create_type,
						'campaign_type'			=> $campaign_type,
						'product_name'			=> $product_name,
						'save_method'			=> $save_method,
						'time_sensitive'		=> $time_sensitive,
						'tentative_date'		=> $tentative_date,
						'tentative_budget'		=> $tentative_budget,
						'no_influencer'			=> $no_influencer,
						'preferred_gender'		=> $preferred_gender,
						'preferred_age'			=> $preferred_age
					);
				
		if(($this->session->userdata(SESSION.'admin_id')))
		{
			$product_data['smart_status']='1';
			$this->session->unset_userdata(SESSION.'admin_id');
		}
		
		$this->db->trans_start();
		if($product_id)
		{

			$product_data['update_date']=$this->general->get_local_time('time');
			$this->general->update_data('products',$product_data,array('id'=>$product_id));
			
		}
		else
		{
				if(AUCTION_POST_ACTIVATION == '1')
				{
					$product_data['status'] = '1'; // pending
				}
				else
				{
					$product_data['status'] = '2'; // activated		
				}
				$product_data['post_date']=$this->general->get_local_time('time');
				$product_data['product_code']=$product_code;
				$this->general->insert_data('products',$product_data);
				$product_id = $this->db->insert_id();
				
		}
			
		if(is_array($objective) && count($objective)>0)
		{
				$productobjective=array();
				$reasonotherid=$this->general->get_obj_reason_other_id();
				$this->db->where(array('product_id'=>$product_id));	
				$this->db->delete('product_objective');
				foreach ($objective as $key=>$value)
				{
					$reason='';
					if($value==$reasonotherid)
					$reason=$this->input->post('reason'.$value);
					array_push($productobjective, array('product_id'=>$product_id, 'objective_id'=>$value,'reason'=>$reason));
				}

				$this->db->insert_batch('product_objective', $productobjective);
		}	
		if(isset($_POST['brandmediaid']) && !empty($_POST['brandmediaid']))
		{
				$productsocialmedia=array();

				$this->db->where(array('product_id'=>$product_id));	
				$this->db->delete('product_socialmedia');
				foreach ($socialmediaid as $key=>$value){
					array_push($productsocialmedia, array('product_id'=>$product_id, 'user_id'=>$user_id, 'socialmedia_id'=>$value));
				}

				$this->db->insert_batch('product_socialmedia', $productsocialmedia);
		}
	
		if(isset($_FILES) && count($_FILES)>0 && $_FILES['uploadimage'])
		{
				$fdata=$this->multiple_image_upload('uploadimage',PRODUCT_IMAGE_PATH,'encrypt');
				$count=	count($fdata);
				if($count>0)
				{
				
					$this->db->where(array('product_id'=>$product_id));
					$this->db->delete('product_images');
					$imageproduct=array();
					foreach ($fdata as $key => $value) 
					{
						array_push($imageproduct, array('product_id'=>$product_id, 'image'=>$value['file_name']));
					}
					
					$this->db->insert_batch('product_images',$imageproduct);
				}
				if(isset($this->error_img))
				{
					return array('error_message'=>$this->error_img);
				}
				
		}
			if(is_array($creatorselected) && (count($creatorselected)>0))
			{
				$creatorsdblist=$this->general->get_data('product_bids',array('product_id'=>$product_id));
				$creatorindb=array();
				$creatorlist=array();
				foreach($creatorsdblist as $eachcreator)
				{
					$creatorindb[]=$eachcreator->user_id;
				}
				
				$this->db->where(array('product_id'=>$product_id));
				$this->db->where_not_in('user_id',$creatorselected);
				$this->db->delete('product_bids');
				foreach ($creatorselected as $key => $value) 
				{
					if(!in_array($value,$creatorindb))
					{
						array_push($creatorlist,array('product_id'=>$product_id,'mediaid'=>null,'membermediaid'=>null,'productmediaid'=>null,'user_id'=>$value,'bid_date'=>$this->general->get_local_time()));	
					}
				}
				$this->db->insert_batch('product_bids', $creatorlist);	
			}
				$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				return array('error'=>'Sorry,Something went wrong.Please try in a while');
			}
			if($action=='add')
			{
				$template='campaign_created_admin';
				$to=SYSTEM_EMAIL;
				$from=CONTACT_EMAIL;
				$parseElement=array(
										'username'		=>		$owner_name,
										'campaign_name'	=>		$campaign_name,
										'description'	=>		$description,
										'product_url'	=>		$product_url,
										'campaign_type'	=>		$campaign_type,
										'SITENAME'		=>		WEBSITE_NAME
								   );
				$this->notification->send_email_notification($template, '', $from, $to, '', '', $parseElement, array());
				$template2='campaign_created_brand';
				$brand=$this->general->get_single_row('members',array('id'=>$user_id));
				$toemail=$brand->email;
				$fromemail=ADVERTISER_EMAIL;
				$parseElementn=array
								(
									
									'USERNAME'			=>		$brand->username,
									'SITENAME'			=>		WEBSITE_NAME,
									'LINK'				=>		'<a href="'.site_url(BRAND.'/campaigns').'">'.site_url(BRAND.'/campaigns').'</a>',
									'ADVERTISER_EMAIL'	=>	ADVERTISER_EMAIL,
									'INFLUENCER_EMAIL'	=>	INFLUENCER_EMAIL,
									'FACEBOOK_LINK'		=>  FACEBOOK_URL,
									'CAMPAIGN_NAME'		=>	$campaign_name
								);
				$this->notification->send_email_notification($template2, '', $fromemail, $toemail, '', '', $parseElementn, array());
				
				}
		  	return array('success'=>true);
		
	}

	public function get_productdetail_by_id($productid)
	{
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
		
		if($status){
			if($status=='open'){
				$cond=$cond."and p.save_method=1 and p.status not in (3,4)";
			}elseif($status=='draft'){
				$cond=$cond."and p.save_method=2";
			}elseif($status=='closed'){
				$cond=$cond."and p.status in (3,4)";
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
										p.name AS product_name,p.id as product_id,p.status,p.submission_deadline,pr.price_range,p.description,p.product_url
									FROM '.$prefix.'products p 
									JOIN '.$prefix.'category c ON p.cat_id=c.id
									JOIN '.$prefix.'pricerange pr ON (p.price_range=pr.id)'.
									$join.'
									WHERE p.create_type="'.$type.'" and brand_id='.$userid.'  '.$cond.'
								');
		
		 $this->db->last_query();
		
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
		
	}

	public function send_message()
	{
				$date=$this->general->get_local_time('time');
			 	$bidid=$this->input->post('bidid');
			 	$product_id=$this->input->post('productid');
			 	$messageby=$this->session->userdata(SESSION.'usertype');
				$message=$this->input->post('message');
				$subject=$this->input->post('subject');
				$current_user = $this->session->userdata(SESSION.'user_id');		
				$sender_id=$current_user;
				$receiver_id=1;
				$arraydata=array(
										'receiver_id'	=>		1, //set 1 for admin ..
										'sender_id'		=>		$sender_id,
										'message'		=>		$message,
										'messagedate'	=>		$date,
										'subject'		=>		$subject,
										'product_id'	=>		$product_id,
								);

				$lastid=$this->general->insert_data('communication',$arraydata);
				$member=$this->general->get_user_details($current_user);		
				$datetime = new DateTime($date);
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i');
                if($date<date('Y-m-d')){
                  $ddate=$date;
                }else $ddate='';
                if($date==date('Y-m-d')){
                  $date='';
                }
                $datetime=trim($ddate.' '.$time);
					$returndata=array(
										'messagedate'	=>$datetime,
										'message'		=>$message,
										'name'			=>$member->name,
										'cover_image'	=> site_url(USER_IMG_DIR.$member->cover_image)
									 );
					if(count($_FILES)>0 && $_FILES['attachmentcommunication'] && $lastid)
					{
						$name = time().$lastid.$_FILES["attachmentcommunication"]['name'];
						$upload = $this->account_module->upload_attachments_files('attachmentcommunication', ATTACHMENT_UPLOAD_DIR,$name);
						if($upload){
							$dataatt=array(

												'msg_id'		=>	$lastid,
												'file_name'		=>	$_FILES['attachmentcommunication']['name'],
												'file_size'		=>	$_FILES['attachmentcommunication']['size'],
												'file_mimetype'	=>	$_FILES['attachmentcommunication']['type'],
												'file_saved'	=>	$name
										   );

							$id=$this->general->insert_data('communication_attachment',$dataatt);
							if($id)
							$message='Attachement Uploaded';		
							else $message='Attchment couldn\'t  be upload';
						}
						else{
						
							return array('error_message'=>$this->upload->display_errors());
						}
					}
					
						if($lastid)
						{
							$from=$member->email;
							if($member->user_type=='3') $email=ADVERTISER_EMAIL;
							if($member->user_type=='4') $email=INFLUENCER_EMAIL;
							
							$parseElement=array(
													'SELLER_NAME'		=>		$member->name,
													'SUBJECT'			=>		$subject,
													'MESSAGE'			=>		$message,
													'SITENAME'			=>		WEBSITE_NAME
											   );
							$template_id='communication-from-seller';
								
								$from=SYSTEM_EMAIL;
								$this->notification->send_email_notification($template_id, '', $from, $email, '', '', $parseElement, array());
							
							return array('success_message'=>'Message Sent Successfully.' ,'data'=>$returndata);
							
						}
						else
						{
							return array('success_message'=>'Error in Message sending.');
						}
				// }
	
}
	public function getmessage($type='inbox')
	{

		    $userid=$this->session->userdata(SESSION.'user_id');
		    $string=$this->input->post('searchstr',true);
		    $cond='1=1';
		   
		    $group='product_id';
		    $filt=false;
			if($type=="inbox")
			{
				$filt=array('c.receiver_id'=>$userid);		
			}
			if($type=='sent'){
				$filt=array('c.sender_id'=>$userid);
			}
			// if($type=='action_required')
			// {
			// 	$cond=array('c.bid_status'=>1);
			// 	$group='bid_id,bid_status';
			// }
			// if($type=='review')
			// {
			// 	$cond=array('c.bid_status'=>2);
			// 	$group='bid_id,bid_status';
			// }
			// if($type=='production')
			// {
			// 	$cond=array('c.bid_status'=>3);
			// 	$group='bid_id,bid_status';
			// }
			// if($type=='completed')
			// {
			// 	$cond=array('c.bid_status'=>7);
			// 	$group='bid_id,bid_status';
			// }
			if($string){
				$searchstr=" ec.message like '%$string%'";
			}

			$this->db->select('product_id,max(c.id) as pid');
			$this->db->from('communication c');
			$this->db->join('communication_attachment ca','c.id=ca.msg_id','left');
			if($filt) $this->db->where($filt);
			else{
				 $this->db ->or_group_start();
			     $this->db->where(array('c.receiver_id'=>$userid));
				 $this->db->or_where(array('c.sender_id'=>$userid));
				 $this->db->group_end();
				}
			 $this->db->where($cond);
			 $this->db->group_by($group);
			   $tempquery=$this->db->get_compiled_select();

			 $this->db->select('ec.product_id,ec.message,ec.ismsgseen,ec.sender_id,ec.receiver_id');
			 $this->db->from('('.$tempquery.') as a');
			 $this->db->join('communication ec','a.pid=ec.id');
			 // $this->db->join('members m','ec.sender_id=m.id');
			 // $this->db->join('members n','ec.receiver_id=n.id');
			// $this->db->select('m.email as sender_email,c.bid_id,n.email as receiver_email,c.message,ismsgseen,c.sender_id,c.receiver_id');
			
			// $this->db->join('communication_attachment ca','c.id=ca.msg_id','left');
			// $this->db->join('members m','c.sender_id=m.id');
			// $this->db->join('members n','c.receiver_id=n.id');
			
			// if($filt) $this->db->where($filt);
			// else{
			// 	$this->db ->or_group_start();
			//      $this->db->where(array('c.receiver_id'=>$userid));
			// 	 $this->db->or_where(array('c.sender_id'=>$userid));
			// 	 $this->db->group_end();
			// }
			 // $this->db->where($cond);
			//  $this->db->where(array('bid_id')=>$bidid)
				
			if($string)
				$this->db->where($searchstr);

		
			// $this->db->group_by($group);
			// $this->db->order_by('c.id','DESC');
		 	$query=$this->db->get();
			  $this->db->last_query();
			$data=$query->result();

		if($data) return $data;
		else return false;


	}

	public function getdetailmessage($productid)
	{
		
		$type=$this->input->get('view');
		$userid=$this->session->userdata(SESSION.'user_id');
		$string=$this->input->post('searchstr',true);
		$cond='1=1';	       
			
			// if($type=='action_required')
			// {
			// 	$cond=array('c.bid_status'=>0);	
			// }
			// if($type=='review')
			// {
			// 	$cond=array('c.bid_status'=>2);
			// }
			// if($type=='production')
			// {
			// 	$cond=array('c.bid_status'=>3);
			// }
			// if($type=='completed')
			// {
			// 	$cond=array('c.bid_status'=>7);
			// }
			if($string){
				$searchstr="m.email like '%$string%' or c.message like '%$string%'";
			}
			$select='';
			 $select=',m.cover_image as sender_image,m.name as sender_name';
			$this->db->select('c.messagedate,c.product_id,c.message,ismsgseen,c.sender_id,c.receiver_id'.$select);
			$this->db->from('communication c');
			$this->db->join('communication_attachment ca','c.id=ca.msg_id','left');
			
			$this->db->join('members_details m','(c.sender_id=m.user_id and c.sender_id='.$userid.') or (c.receiver_id=m.user_id and c.receiver_id='.$userid.')');
			// $this->db->join('members_details n','c.receiver_id=n.user_id and c.receiver_id!=1','left');
				 $this->db ->or_group_start();
			     $this->db->where(array('c.receiver_id'=>$userid));
				 $this->db->or_where(array('c.sender_id'=>$userid));
				 $this->db->group_end();
			
			$this->db->where($cond);
			$this->db->where(array('product_id'=>$productid));
			if($string)
				$this->db->where($searchstr);

			$this->db->order_by('messagedate','ASC');
			// $this->db->group_by($group);
			$query=$this->db->get();
			// echo $this->db->last_query();
			$response=$query->result();

		if($response) return $response;
		else return false;


	}
	public function get_all_reports()
	{
			$userid=$this->session->userdata(SESSION.'user_id');
			$name=$this->input->post('filtername');
			$fromdate=$this->input->post('filterfromdate');
			$todate=$this->input->post('filtertodate');
			$today=$this->general->get_local_time();
			$cond='1=1';
			if($fromdate!='' && $todate!='')
		    {
		        $cond=$cond." and date(p.post_date) between '". $fromdate."' and '".$todate."'";
		    }
		    elseif($fromdate){
		        $cond=$cond." and date(p.post_date) between '". $fromdate."' and '".$today."'";
		    }
		    elseif($todate){
		        $cond=$cond." and date(p.post_date) between '". $today."' and '".$todate."'";
		    }
		    if($name)
		    {
		    	$cond=$cond." and p.name like('%$name%')" ;
		    }

			$prefix=$this->db->dbprefix;
			$userid=$this->session->userdata(SESSION.'user_id');
			$this->db->select('*,(SELECT GROUP_CONCAT(image SEPARATOR ",") FROM '.$prefix.'product_images  pi where pi.product_id=p.id ) as image');
			$this->db->from('products p');
			$this->db->join('product_bids pb','pb.product_id=p.id');
			$this->db->join('report r','pb.id=r.bid_id');
			$this->db->where($cond);
			$this->db->where(array('pb.status'=>'7','p.brand_id'=>$userid));
			
			 $query=$this->db->get();
			  $this->db->last_query();
			if($query->num_rows()>0)
			{
				$result=$query->result('array');
			}
			else $result= false;
		
			return $result;
	}
	public function makemessageseen($bidid)
	{
		$type=$this->input->post('view');
		$userid=$this->session->userdata(SESSION.'user_id');
		$cond=false;
			if($type=='action_required')
			{
				$cond=array('bid_status'=>0);	
			}
			if($type=='review')
			{
				$cond=array('bid_status'=>2);
			}
			if($type=='production')
			{
				$cond=array('bid_status'=>3);
			}
			if($type=='completed')
			{
				$cond=array('bid_status'=>7);
			}
			 	
				 // $this->db ->or_group_start();
			     $this->db->where(array('receiver_id'=>$userid));
				 // $this->db->or_where(array('sender_id'=>$userid));
				 // $this->db->group_end();
				 if($cond)
				 $this->db->where($cond);
				 $this->db->where(array('bid_id'=>$bidid));
				 $this->db->update('communication',array('ismsgseen'=>'1'));
				  $this->db->last_query();
				 return true;
	}		
/* sending email to supplier for matched category if auction type is public	 */
	public function send_email_notification_to_public($categories=array(),$parseElement=array()){
				$this->db->select('DISTINCT(email)');
				$this->db->from('member_expertise a');
				$this->db->join('members m','a.user_id=m.id');
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

	public function get_user_details($userid){
		try{
			if(!$userid)  throw new Exception("User id not found", 1);
			
			$this->db->select('*');
			$this->db->from('members m');
			$this->db->join('members_details md','m.id= md.user_id','left');
			$this->db->where('m.id',$userid);
			$query=$this->db->get();
			 $this->db->last_query();
			$result=$query->row_array();

			if(count($result)>0) return $result;
			else return array();
		}catch(Exception $e)
		{
			throw $e->getMessage()	;
		}
		
	}

	public function get_creator_details($userid){
		try{
			if(!$userid)  throw new Exception("User id not found", 1);
			
			$this->db->select('m.*,md.*');
			$this->db->from('members m');
			$this->db->join('members_details md','m.id= md.user_id','left');
			// $this->db->join('profession p','p.id= md.profession','left');
			
			$this->db->where('m.id',$userid);
			$query=$this->db->get();
			 $this->db->last_query();
			$result=$query->row_array();
			$profile['basicinfo']=$result;

			$profile['socialmediadetail']=$this->general->get_data('member_socialmedia',array('user_id'=>$userid));
			$profile['socialmediaprofile']=$this->general->get_data('socialmedia_profile',array('user_id'=>$userid));
			$profile['audience_demography']=$this->general->get_data('audience_demographic',array('user_id'=>$userid));
			$this->db->select('*');
			$this->db->from('audience_geography ag');
			$this->db->join('country c','ag.country_code=c.iso_code');
			$this->db->where(array('user_id'=>$userid));
			$this->db->order_by('number_user','DESC');
			$query=$this->db->get();
			$profile['audience_geography']=$query->result();
			if(count($result)>0) return $profile;
			else return false;
		}catch(Exception $e)
		{
			throw $e->getMessage()	;
		}
		
	}

	public function general()
	{
		$company_name=$this->input->post('brand_name');
		$userid=$this->session->userdata(SESSION.'user_id');
		$first_name=$this->input->post('first_name');
		$last_name=$this->input->post('last_name');
		$age=$this->input->post('age');
		$company_website=$this->input->post('brand_url');
		$facebook_link=$this->input->post('facebook_link');
		$gender=$this->input->post('gender');
		$profession=$this->input->post('profession');
		$pan_no=$this->input->post('pan_no');
		$mobile=$this->input->post('mobile');
		$address=$this->input->post('address');
		$designation=$this->input->post('designation');
		$userscategories=$this->input->post('usercategory');
		$phone=$this->input->post('phone',true);
		$about_user=$this->input->post('about_user',true);
		$email=$this->input->post('email');
		$userdetail=$this->general->get_single_row('members_details',array('user_id'=>$userid));
		$bank_name=$this->input->post('bank_name',true);
		$account_no=$this->input->post('account_no',true);
		$cover_image=$userdetail->cover_image;
		// $url=$this->input->post('urllist',true);
		$media=$this->input->post('media',true);

		if(isset($_FILES['profile_picture']['tmp_name']) && $_FILES['profile_picture']['tmp_name']!='')
		{
				$cover_image=$this->change_profile_image($userid);
			
		}

		$datamembers=array(
							'email'			=>	$email,
							'brand_name'	=>	$company_name,
							'brand_url'		=>	$company_website
						  );


		$datamemberdetail=array(
								'company_website'	=>	$company_website,
								'name'				=>	$first_name.' '.$last_name,
								'phone'				=>	$phone,
								'mobile'			=>	$mobile,
								'designation'		=>	$designation,
								'facebook_link'		=>	$facebook_link,
								'age'				=>	$age,
								'address'			=>	$address,
								'gender'			=> 	$gender,
								'cover_image'		=>	$cover_image,
								'about_user'		=>	$about_user,
								'pan_no'			=>	$pan_no,
								'account_no'		=>	$account_no,
								'bank_name'			=>	$bank_name
								);
		
		$this->db->trans_start();
		$this->general->update_data('members',$datamembers,array('id'=>$userid));
		$id=$this->general->update_data('members_details',$datamemberdetail,array('user_id'=>$userid));

		if(is_array($userscategories) && (count($userscategories)>0))
			{
				$categories=array();
				$this->db->where(array('user_id'=>$userid));
				$this->db->delete('member_expertise');
				foreach ($userscategories as $key => $value) 
				{
					array_push($categories,array('user_id'=>$userid,'category_id'=>$value,'date'=>$this->general->get_local_time()));
				}
				$this->db->insert_batch('member_expertise', $categories);
			}

		if(is_array($profession) && (count($profession)>0))
			{
				$profess=array();
				$this->db->where(array('user_id'=>$userid));
				$this->db->delete('member_profesion');
				foreach ($profession as $key => $value) 
				{
					array_push($profess,array('user_id'=>$userid,'profession_id'=>$value));
				}
				$this->db->insert_batch('member_profesion', $profess);
			}
			$arrdata=array();

			if(is_array($media) && (count($media)>0))
			{
				foreach($media as $eachmedia)
				{
				
					if(trim($eachmedia)!='')
					{
						$medias=($this->input->post($eachmedia.'url',true));
						if(count($medias)>0)
						{
							foreach ($medias as $key => $value) 
							{
								if(trim($value)!='')
								{
									array_push($arrdata, array('user_id'=>$userid, 'media_id'=>constant(strtoupper($eachmedia).'MEDIAID'), 'url'=>$value));
								}
							}
						}
						
						
					}
					
				}
				$this->db->delete('socialmedia_profile',array('user_id'=>$userid));
				$this->db->insert_batch('socialmedia_profile',$arrdata);
			}
			
		

				$this->db->trans_complete();
		
				if ($this->db->trans_status() === FALSE){
					return array('error_message'=>'Sorry,There was error saving data.Please try in a while');
				}else {
					
					return array('success_message'=>'General Settings are updated');
					
				}
	}

	public function address()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$company_address1=$this->input->post('company_address1');
		$company_address2=$this->input->post('company_address2');
		$company_city=$this->input->post('company_city');
		$identification_no=$this->input->post('identification_no',true);
		$company_state=$this->input->post('company_state');
		$company_zipcode=$this->input->post('company_zipcode');
		$country=$this->input->post('country');
		$userid=$this->session->userdata(SESSION.'user_id');
		$data=array(
					'company_address1'			=>		$company_address1,
					'company_address2'			=>		$company_address2,
					'company_city'				=>		$company_city,
					'company_state'				=>		$company_state,
					'country'					=>		$country,
					'company_zipcode'			=>		$company_zipcode,
					'identification_no'			=> 		$identification_no
					);
		$cond=array('user_id'=>$userid);
		$id=$this->general->update_data('members_details',$data,$cond);
		if($id) return array('success_message'=>'Billing address is updated');
		else return array('error_message'=>'Nothing to update');
	}

	public function changepassword()
	{
		if($this->input->post('new_password',TRUE)!=$this->input->post('re_new_password',TRUE))
		{
			return array('error_message'=>'New Password and Confirm Password must match');
		}
		$userid=$this->session->userdata(SESSION.'user_id');
		$pass = $this->general->get_single_row('members',array('id'=>$userid));		
		$salt=$pass->salt;
		$oldpassword = $this->general->hash_password($this->input->post('password',TRUE),$salt);
		if($oldpassword==$pass->password)
		{
			$data=$this->change_users_password($userid);
			if($data) {
					$this->session->unset_userdata(SESSION.'user_id');
					$this->session->unset_userdata(SESSION.'usertype');
					$this->session->unset_userdata(SESSION.'email');
					$this->session->unset_userdata(SESSION.'username');	
					$this->session->set_flashdata('success_message',"Password changed successfully.");
					return array('success_message'=>'Congratulation Password changed Successfully');
			}else{
					return array('error_message'=>'Some error occured');
			}
		}
		else{
			return array('error_message'=>'Your Current Password doesn\'t match');
		}
	}
	public function bankdetail()
	{
		$bank_name=$this->input->post('bank_name',true);
		$account_no=$this->input->post('account_no',true);
		$userid=$this->session->userdata(SESSION.'user_id');
		$data=array(
					'account_no'				=>		$account_no,
					'bank_name'					=>		$bank_name
				   );
		$cond=array('user_id'=>$userid);
		$id=$this->general->update_data('members_details',$data,$cond);
		if($id) return array('success_message'=>'Bank Details is updated');
		else return array('error_message'=>'Nothing to update');
	}
	public function getproductbyid($productid){
		$prefix=$this->db->dbprefix;	
		
		$query=$this->db->query('
									SELECT 
										(
											SELECT image FROM '.$prefix.'product_images AS i WHERE i.product_id=p.id LIMIT 1 
										) as image,
										(
											SELECT GROUP_CONCAT(ss.id SEPARATOR ",") FROM '.$prefix.'product_  ps
											JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ps.socialmedia_id) WHERE ps.product_id=p.id
											GROUP BY ps.product_id 
										) as media,
										
										p.name AS product_name,p.monthly_budget,p.monthly_post_no,p.long_term_sponsorship,p.id as product_id,p.status,p.submission_deadline,p.price_range,p.description,p.product_url,p.save_method,p.cat_id,p.least_fan_count
									FROM '.$prefix.'products p 
									WHERE p.id="'.$productid.'"
								');
		
		 $this->db->last_query();
		 $result=$query->row_array();
		if(count($result)>0) return $result;
		else return array();
		
	}

	public function saveprofile()
	{
		try
		{
			$arrdata=array();
		$url=$this->input->post('urllist',true);
		$media=$this->input->post('media',true);
		$userid=$this->session->userdata(SESSION.'user_id');

		foreach($url as $dataurl)
		{
			if(trim($dataurl)!='')
			{
				array_push($arrdata, array('user_id'=>$userid, 'media_id'=>constant(strtoupper($media).'MEDIAID'), 'url'=>$dataurl));
			}
			
		}
		$this->db->trans_start();
		$this->db->delete('socialmedia_profile',array('user_id'=>$userid, 'media_id'=>constant(strtoupper($media).'MEDIAID')));
		$id=$this->db->insert_batch('socialmedia_profile',$arrdata);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			throw new Exception('Sorry,Something went wrong.Please try in a while',1);
		}
		if($id)	
			return true;
		else return false;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
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

	public function get_all_live_active_sponsorship()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$usertype=$this->session->userdata(SESSION.'usertype');
	    $status=$this->input->post('filterstatus');
		 $name=$this->input->post('filtername');
		$prefix=$this->db->dbprefix;
		$selectq='';
		$filter='';
		
		
		// $status='2';
		if($status!='')
		{
			 
			$filter="b.status='$status' ";
		}

		if($name)
		{	
			if($filter!='')
				$filter=$filter.' and p.name like "%'.$name.'%"';
			else 
				$filter='p.name like "%'.$name.'%"';
		}
		$cond=array();
		if($usertype=='3')
		{
			$cond=array('p.brand_id'=>$userid,'pb.status'=>'7');
			/*Completed Count*/
			$this->db->where($cond);
			$this->db->join('products p','p.id=product_id');
		 	$completed= $this->db->count_all_results('product_bids pb');
			/*completed earned*/
			$this->db->where($cond);
		
			$this->db->select_sum('user_bid_amt');
			$this->db->join('products p','p.id=product_id');
			$sum=$this->db->get('product_bids pb');
			$completedsum=$sum->row();

			/*production count*/
			$this->db->where('pb.status in ("1","2")');
			$this->db->where(array('p.brand_id'=>$userid));
			$this->db->join('products p','p.id=product_id');
			$production= $this->db->count_all_results('product_bids pb');
			$this->db->last_query();	
			/*condition for main query*/
			$where="p.brand_id=$userid";
		}
		if($usertype=='4')
		{
			$cond=array('user_id'=>$userid,'status'=>'7');
			/*Completed Count*/
			$this->db->where($cond);
			$completed= $this->db->count_all_results('product_bids');
			/*completed earned*/
			$this->db->where($cond);
			$this->db->select_sum('user_bid_amt');
			$sum=$this->db->get('product_bids pb');
			$completedsum=$sum->row();

			/*production count*/
			$this->db->where('status in ("1","2")');
			$this->db->where(array('user_id'=>$userid));
			$production= $this->db->count_all_results('product_bids pb');
				 $this->db->last_query();
			/*condition for main query*/
			$where="b.user_id=$userid";
		}
		$response['completedcount']=$completed;
		$response['productioncount']=$production;
		$response['completedsum']=$completedsum->user_bid_amt;
	
		/*Get creator media id informatio*/
		$query='(SELECT GROUP_CONCAT(media_type SEPARATOR ",") FROM '.$prefix.'member_socialmedia  ms
										JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ms.media_type_id) WHERE ms.user_id=b.user_id
										GROUP BY ms.user_id) as allmedia';
		$this->db->select('b.*,(select image from emts_product_images as pm where pm.product_id=p.id limit 1) as  image ,p.name,p.product_code,p.description,m.name as creator_name,ms.total_reach,m.country,p.brand_id,dp.draft_accept,'.$query);
		$this->db->from('product_bids as b');
		$this->db->join('draft_promotion as dp','b.id=dp.bid_id','left');
		$this->db->join('members_details as m','m.user_id=b.user_id');
		$this->db->join('member_socialmedia as ms','ms.media_type_id=b.mediaid and ms.user_id=b.user_id');
		$this->db->join('products as p','b.product_id=p.id');
		$cond=array(
						'p.create_type'		=> 		'campaign',
						'p.status'			=>		'2'
				   );

		$this->db->where($cond);
		
	
		$this->db->where('b.status in ("0","1","2")');
		if($filter)
		$this->db->where($filter);
		$this->db->where($where);
		$this->db->order_by('FIELD(b.status, "2","1", "0")');
		$this->db->order_by('b.id','DESC');
		$query=$this->db->get();
		  $this->db->last_query();
		$data=$query->result();

		$response['data']=$data;

		if($query->num_rows()>0)
		{
			return $response;
		}else{
			return false;
		}

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
				//resize image
				// $this->resize_image(USER_IMAGE_PATH,$this->image_name_path,$image_name['raw_name'].$image_name['file_ext'],200,200);
				//now remove old image
				// @unlink(USER_IMAGE_PATH.$this->input->post('old'));
				// $this->update_members_selected_fields(array('cover_image'=>$this->image_name_path), array('user_id'=>$user_id));
				return $this->image_name_path;
			
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

	// to upload custom fields files
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

	public function multiple_image_upload($file, $location, $encrypt_filename='')
	{
		 $final_files_data=array();
		  $number_of_files_uploaded = count($_FILES[$file]['tmp_name']);
	      $newfiles=$_FILES;
	      for ($i = 0; $i < $number_of_files_uploaded; $i++) :
	    	
	
	    	if(isset($_FILES[$file]['name'][$i]) && $_FILES[$file]['name'][$i]!='')
	    	{

	    		
	    		    $_FILES['uploadimagenew']['name']     = $_FILES[$file]['name'][$i];
			        $_FILES['uploadimagenew']['type']     = $_FILES[$file]['type'][$i];
			        $_FILES['uploadimagenew']['tmp_name'] = $_FILES[$file]['tmp_name'][$i];
			        $_FILES['uploadimagenew']['error']    = $_FILES[$file]['error'][$i];
			        $_FILES['uploadimagenew']['size']     = $_FILES[$file]['size'][$i];
			        $config['upload_path'] = './'.$location;   //file upload location
					$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
					$config['remove_spaces'] = TRUE; 
					$config['max_size'] = '4000';
					$config['max_width'] = '2000';
					$config['max_height'] = '2000';
					if($encrypt_filename='encrypt')
					{
						$config['encrypt_name'] = TRUE;
					}
			      $this->upload->initialize($config);
			      if ( ! $this->upload->do_upload('uploadimagenew')) :
			        $error = array('error' => $this->upload->display_errors());
			       return $error;
			      else :
			        $final_files_data[] = $this->upload->data();
			       
	      			endif;
	      		
	    	}
			 
    	endfor;    
    	return $final_files_data;
	}
	public function file_settings_do_upload($file, $location, $encrypt_filename='')
 	{
 		
		$config['upload_path'] = './'.$location;   //file upload location
		$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
		$config['remove_spaces'] = TRUE; 
		$config['max_size'] = '8000';
		$config['max_width'] = '4000';
		$config['max_height'] = '4000';
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
	public function get_product_by_id($product_id, $user_id = 0)
	{
		$this->db->select('P.*, C.id as currency_id, C.currency_sign, C.currency_code');
		$this->db->from('products P');
		$this->db->join('product_currency C', 'P.currency = C.id');
		$this->db->where('P.id',$product_id);
		if($user_id && $user_id != 0 && $user_id >0)
		$this->db->where('seller_id',$user_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$query->free_result();
			return $result;
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
		if($query->num_rows()>0){
			return $query->row();
		}
		return false;
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

	public function getbidbyproduct($product_id)
	{
		$this->db->select('user_bid_amt,bid_date,id,user_id,product_id');
		$query=$this->db->get_where('product_bids',array('product_id'=>$product_id));
		$data=$query->result('array');
		$chartdata=array();
		foreach ($data as  $value) {
			$date=$this->general->date_formate($value['bid_date']);
			$supplierid=$value['user_id'].'-'.$value['product_id'].'-'.$value['id'];
			$chartdata[]=array($date,round($value['user_bid_amt']));
		}
		return json_encode($chartdata);
	}

	public function gettransactionhistory($limit=5,$offset=0)
	{
		$user_id=$this->session->userdata(SESSION.'user_id');
		$this->db->select('*');
		$this->db->from('transaction as t');
		$this->db->join('products as p','p.id=t.product_id');
		$this->db->where(array('t.user_id'=>$user_id,'t.transaction_status'=>'Completed'));
		$this->db->order_by('t.id','desc');
		$this->db->limit($limit, $offset);
		$query=$this->db->get();
		$result=$query->result();
		if(count($result)>0) return $result ;
		else return array();
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
    
}



