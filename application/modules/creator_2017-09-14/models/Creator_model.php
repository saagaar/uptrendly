<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Creator_model extends CI_Model
{
	public function __construct() 
	{
		parent::__construct();
	}

	public $validate_collab_creation =  array(	
		array('field' => 'name', 'label' => 'Collab Title', 'rules' => 'trim|required|min_length[2]|max_length[100]'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'trim|required|min_length[2]|max_length[300]'),
		array('field' => 'least_fan_count', 'label' => 'Least Fan Count', 'rules' => 'trim|required|integer'),
		array('field' => 'submission_deadline', 'label' => 'Submission Deadline', 'rules' => 'trim|required'),
	);
	public $validate_draft =  array(	
		array('field' => 'description', 'label' => 'Description', 'rules' => 'trim|required|min_length[2]|max_length[300]'),
		array('field' => 'link', 'label' => 'Link', 'rules' => 'trim|required|min_length[2]|max_length[200]'),
		array('field' => 'bidid', 'label' => 'Bid id', 'rules' => 'trim|required'),
	);
	public function submitproposal()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$socialmedia=$this->general->get_all_media();	
		$productid=$this->input->post('productid');
		
		$current_date=$this->general->get_local_time('now');
		$this->db->trans_start();
		$error=false;
		$mediaconn='';
		$brand=$this->general->get_member_by_product($productid);
	
		foreach ($socialmedia as $key => $value) 
		{
		
			
			if(count($this->input->post($value,true))>0)
			{	
					$mediaconn.=$value.',';
				$mediaid=$this->input->post($value)['mediaid'];
				$isalreayinserted=$this->general->get_single_row('product_bids',array('user_id'=>$userid,'product_id'=>$productid,'mediaid'=>$mediaid));
				$productmediaid=$this->general->get_product_media_id($productid,$mediaid);
				$usermediaid=$this->general->get_member_media_id($userid,$mediaid);
				if(count($isalreayinserted)>0)
					{
							$updatedata  =     array(
													
													'bid_details'	=>	$this->input->post($value)['bid_details'],
													'user_bid_amt'	=>	$this->input->post($value)['bid_amount'],
													'delivery_date'	=>	$this->input->post($value)['delivery_date']
												   );
							$id=$this->general->update_data('product_bids',$updatedata,array('id'=>$isalreayinserted->id));
					}
				else{
						
						$products=$this->general->get_single_row('products',array('id'=>$productid));
						$members=$this->general->get_single_row('member_socialmedia',array('user_id'=>$userid,'media_type_id'=>$mediaid));
						$memberdetail=$this->general->get_single_row('members',array('id'=>$userid));
						
						$remaininglikes=$members->total_reach-$products->least_fan_count;
						if(isset($this->input->post($value)['bid_amount']))
						{
							$bid_amount=$this->input->post($value)['bid_amount'];
						}
						else {
							$bid_amount=0;
						}
						if($remaininglikes>=0)
						{
									$insertdata  =     array(
															'user_id'		=>	$userid,
															'product_id'	=>	$productid,
															'bid_date'		=>	$current_date,
															'mediaid'		=>	$mediaid,
															'bid_details'	=>	$this->input->post($value)['bid_details'],
															'user_bid_amt'	=>	$bid_amount,
															'delivery_date'	=>	$this->input->post($value)['delivery_date'],
															'membermediaid'	=>	$usermediaid,
															'productmediaid'=>  $productmediaid
														   );
									$id=$this->general->insert_data('product_bids',$insertdata);
									/*if user is referred by some other users then we give them point*/
									$referralid=$memberdetail->referred_by;
								
									if($referralid!=null)
									{
										$this->db->set('referral_points', 'referral_points+'.CREATOR_REFER_POINT, FALSE);
										$this->db->where('id',$referralid);
										$this->db->update('members');
										$this->general->update_data('members',array('referred_by'=>null),array('id'=>$userid));
									}
						}
						else {
							 $error=true;
						}
				    }
			}
		}
		
				
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			return array('error_message'=>'Sorry,Something went wrong.Please try in a while');
		}else {
			if($error) 
			{
				$this->session->set_flashdata('error_message','You cannot send proposal to this post');
				// redirect(site_url('/'.CREATOR.'sponsorship/public'));
				echo json_encode(array('error_message'=>'You cannot send proposal to this post'));exit;
			}

		else{
				if(!count($isalreayinserted)>0){
					$template='proposal_received';
					$from=SYSTEM_EMAIL;
					$to=$brand->email;
					$brandid=$brand->id;

					$parseElement=array(
											'EMAIL'					=>		$to,
											'PRODUCT_NAME'			=>		$products->name,
											'SUBMISSION_DEADLINE'	=>		$products->submission_deadline,
											'SOCIAL_MEDIA'			=>		$mediaconn,
											'WEBSITE_NAME'			=>		WEBSITE_NAME
									   );
					$this->notification->send_email_notification($template, '', $from, $to, '', '', $parseElement, array());
					if($products->create_type=='campaign')
						$redirect=site_url('/'.BRAND.'getproposalbyproduct/'.$products->product_code);
					else
						$redirect=site_url('/'.CREATOR.'getproposalbyproduct/'.$products->product_code);
					$notifymsg='<a href="'. $redirect.'" >You have Received a proposal for Campaign '.$products->name.' .Please review proposal</a>';
					$this->general->savethisasnotification($brandid,$notifymsg);
					return array('success_message'=>'Proposal Submitted succesfully');
				}else{
					return array('success_message'=>'Proposal Updated succesfully');
				}
				
		}
		}
		
		
	}

	public function getallsponsorship($type='public',$id=false)
	{
			$cond='';
			if(!is_int($id)) $id=false;
			if($type=='public') $cond="and p.auction_type='1'";
			// elseif($type=='private') $cond="and p.auction_type='2'";
			$media=$this->input->post('filtermediatype',true);
			$userid=$this->session->userdata(SESSION.'user_id');
			// $userdetail=$ths->general->get_single_row('member_socialmedia',array('id'=>$userid));
			$price_range=$this->input->post('filterpricerange',true);
			$name=$this->db->escape_like_str($this->input->post('filtername',true));
			$category=$this->input->post('filtercategory',true);
			$join='';
			// $viewtype=$this->input->post('viewtype',true);
			$prefix=$this->db->dbprefix;
			$select='';
			
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
			if($id)
			{
				$cond=$cond."and p.id=$id";
			}
			
			if($type=='my-proposal'){
				$select=' ,pb.id as bid_id,pb.status as bid_status,dp.draft_accept';
				$join=$join.' JOIN '.$prefix.'product_bids pb on (p.id=pb.product_id)';
				$join=$join.' left join '.$prefix.'draft_promotion dp on (dp.bid_id=pb.id)';
				$cond=$cond." and pb.user_id=$userid";
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
											p.name AS product_name,p.id as product_id,p.status,p.description'.$select.',p.product_url,p.submission_deadline,pr.price_range 
										FROM '.$prefix.'products p 
										JOIN '.$prefix.'category c ON p.cat_id=c.id
										JOIN '.$prefix.'pricerange pr ON (p.price_range=pr.id)

										'.
										$join.'
										WHERE p.status="2" AND p.create_type="campaign"  and p.winner_notified="0" '.$cond.'
									');
			
			   $this->db->last_query();
		
				$result=$query->result('array');
				// echo '<pre>';
				// print_r($result);
				if(count($result)>0) return $result;
				else return array();
		

	}

	public function inviteuser()
	{
		$userid=$this->input->post('userid');
		$userdata=$this->general->get_single_row('members',array('id'=>$userid));
		$email=$userdata->email;
		if($_FILES)
		{

			    $fdata=$this->multiple_image_upload('uploadimage',PRODUCT_IMAGE_PATH,'encrypt');
			   
				$count=	count($fdata);
				if($count>0)
				{
					
					$imageproduct=array();
					foreach ($fdata as $key => $value) 
					{
						
					
						$images=$value['file_name'];
					}
				}
				if(isset($this->error_img))
				{
					return array('error_message'=>$this->error_img);
				}
				
		}
		// $product_id=$this->input->post('product_id');
		// $campaign=$this->general->get_single_row('products',array('id'=>$product_id));
		$message=$this->input->post('message');
		$current_date=$this->general->get_local_time('now');
		$parseElement = array
					(
						
						"EMAIL"				=> $userdata->email,
						"SITENAME"			=> WEBSITE_NAME,
						"message"			=> $message
					);
		$from=SYSTEM_EMAIL;
		$template_code='invitation_brand';
		$this->notification->send_email_notification($template_code, '', $from, $email, '', '', $parseElement, array());
		$notifymsg='You have Been invited by Creator '.$userdata->username.' .Check your email';
		$this->general->savethisasnotification($userid,$notifymsg);
		$data=array(
						'user_email'	=>	$email,
						'message'		=>	$message,
						'invite_date'	=>	$current_date,
						'user_id'		=>	$userid,
						'images'		=>	$images
				   );
		$id=$this->general->insert_data('product_invitation',$data);
			
		if($id) return array('success_message'=>'Invitation sent successfully');
		else return array('error_message'=>'Invitation sent failed');
	}
	
	public function get_brands()
	{
		$this->db->select('*');
		$this->db->from('members m');
		$this->db->join('members_details md','m.id=md.user_id');
		$this->db->WHERE(array('status'=>'1','user_type'=>'3'));
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else return false;
	}

	 public function multiple_image_upload($file, $location, $encrypt_filename='')
    {
       
          $final_files_data=array();
          $this->load->library('upload');
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
                  $this->upload->initialize($config);
                  if ( ! $this->upload->do_upload('uploadimagenew')) :
                    $error = array('error' => $this->upload->display_errors());
                   return $error;
                  else :
                    $final_files_data[] = $this->upload->data();
                    endif;
            }
             
        endfor; 
        // print_r($final_files_data);exit;   
        return $final_files_data;
    }
	public function getmyproposalsponsor($type='public',$id=false)
	{
		if($type=='public') $cond="and p.auction_type='1'";
		else $cond="and p.auction_type='2'";
		$media=$this->input->post('filtermediatype',true);
		$price_range=$this->input->post('filterpricerange',true);
		$name=$this->db->escape_like_str($this->input->post('filtername',true));
		$category=$this->input->post('filtercategory',true);
		$join='';
		$userid=$this->session->userdata(SESSION.'user_id');
		$prefix=$this->db->dbprefix;
		// $name='car';
		
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
		if($id)
		{
			$cond=$cond."and p.id=$id";
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
										p.name AS product_name,p.id as product_id,p.status,p.description,p.product_url,p.submission_deadline,pr.price_range 
									FROM '.$prefix.'products p 
									JOIN '.$prefix.'category c ON p.cat_id=c.id
									JOIN '.$prefix.'pricerange pr ON (p.price_range=pr.id)
									JOIN '.$prefix.'product_bids pb on (p.id=pb.product_id)
									'.

									$join.'
									WHERE p.status="2" AND p.create_type="campaign" and pb.user_id='.$userid.' and p.winner_notified="0" '.$cond.'
								');
		
		 $this->db->last_query();
		
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
	}

	public function getallcollaborationposts($type,$id=false){
		$cond='';
		if($type=='public') $cond="and p.auction_type='1'";
		
		// else $cond="and p.auction_type='2'";
		$media=$this->db->escape($this->input->post('filtermediatype',true));
		$likes=$this->db->escape($this->input->post('filterfancount',true));
		$name=$this->db->escape_like_str($this->input->post('filtername',true));
		$userid=$this->session->userdata(SESSION.'user_id');
		// $viewtype=$this->input->post('viewtype',true);
		$join='';
		$select='';
		$prefix=$this->db->dbprefix;
			if(!( (trim($name)=='') || (trim($name)=='NULL')))
		{
			$cond=$cond." and p.name like ('%$name%')";
		}
		if(!( (trim($likes)=='') || (trim($likes)=='NULL')))
		{
			
			$cond=$cond." and p.least_fan_count>=$likes";
		}

		if(!( (trim($media)=='') || (trim($media)=='NULL'))){
				
			$join=' JOIN '.$prefix.'product_socialmedia psa ON (p.id=psa.product_id)';
			$cond=$cond." and psa.socialmedia_id=$media";
		}
		if($id)
		{
			$cond=$cond."and p.id=$id";
		}
		if($type=='my-proposal'){
				$select=' ,pb.id as bid_id,pb.status as bid_status,dp.draft_accept';
				$join=$join.' JOIN '.$prefix.'product_bids pb on (p.id=pb.product_id)';
				$join=$join.' left join '.$prefix.'draft_promotion dp on (dp.bid_id=pb.id and (dp.draft_accept=0 or dp.draft_accept=2))';
				$cond=$cond." and pb.user_id=$userid";
			}	
		$query=$this->db->query('
									SELECT 
										(
											SELECT cover_image FROM '.$prefix.'members_details AS i WHERE i.user_id=p.brand_id LIMIT 1 
										) as image,
										(
											SELECT GROUP_CONCAT(media_type SEPARATOR ",") FROM '.$prefix.'product_socialmedia  ps
											JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ps.socialmedia_id) WHERE ps.product_id=p.id
											GROUP BY ps.product_id 
										) as media,
										p.name AS product_name,p.id as product_id,p.least_fan_count,p.status,p.description,p.submission_deadline,p.brand_id'.$select.'
									FROM '.$prefix.'products p'.
									$join.'
									WHERE p.status="2" AND  p.create_type="collab" '.$cond.'
								');
		
		 $this->db->last_query();
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
		

	}

	public function getmycollaborationposts()
	{
		$userid=$this->session->userdata(SESSION.'user_id');
		$prefix=$this->db->dbprefix;	
			$query=$this->db->query('
									SELECT 
										
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
										) as collabscount,
										(
											SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("7")
										) as completedcount,
										p.name AS product_name,p.product_code,m.cover_image,p.id as product_id,p.status,p.submission_deadline,p.least_fan_count,p.description,p.product_url
									FROM '.$prefix.'products p 
									join '.$prefix.'members_details m on p.brand_id=m.user_id
									
									WHERE  p.brand_id='.$userid.' 
								');
		
		 $this->db->last_query();
		
		$result=$query->result('array');
		// print_r($result);
		if(count($result)>0) return $result;
		else return array();
		


			// SELECT GROUP_CONCAT(media_type SEPARATOR ",") FROM '.$prefix.'product_socialmedia  ps
			// 								JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ps.socialmedia_id) WHERE ps.product_id=p.id
			// 								GROUP BY ps.product_id 
			// 							) as media,
		// $this->db->from('products as p');
		// $this->db->join()

	}

	// getproductoffer($userid)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('products p');
	// 	$this->db->join('products_bids b','p.id=b.product_id');
	// 	$this->db->where('b.user_id',$userid);
	// }
	public function getuserproduct($userid=false,$type='campaign')
	{	
		// $media=$this->input->post('filtermediatype',true);
		// $price_range=$this->input->post('filterpricerange',true);
		// $name=$this->input->post('filterproductname',true);
		// $category=$this->input->post('filtercategory',true);
		// $status=$this->input->post('filterstatus',true);
		$proposaltype=$this->input->post('filterproposaltype',true);
		$join='';
		$cond='';
		$prefix=$this->db->dbprefix;	
		// if((trim($name)!=''))
		// {
		// 	$cond=$cond." and p.name like ('%$name%')";
		// }
		// if((trim($price_range)!=''))
		// {
			
		// 	$cond=$cond." and p.price_range=$price_range";
		// }
		// if(trim($category)!='')
		// {

		// 	$cond=$cond." and  p.cat_id=$category";
		// }

		// if(trim($media)!=''){
				
		// 	$join='JOIN '.$prefix.'product_socialmedia psa ON (p.id=psa.product_id)';
		// 	$cond=$cond." and psa.socialmedia_id=$media";
		// }
		if($userid){
			$cond=$cond." and pb.user_id=$userid";
		}
		
		if($proposaltype){
			if($proposaltype=='open'){
				$cond=$cond." and pb.status not in ('0','3','4','5','6','7')";
			}elseif($proposaltype=='new_offers'){
				$cond=$cond." and pb.status='0'";
			}elseif($proposaltype=='completed'){
				$cond=$cond." and pb.status in ('7')";
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
										SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("0")
										) as pendingcount,
										(
										SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("3","4")
										) as rejectedcount,
										(
											SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("1","2","3")
										) as productioncount,
										(
												SELECT count(id) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("7")
										) as completedcount,
										(
											SELECT sum(user_bid_amt) from  '.$prefix.'product_bids pb where pb.product_id=p.id and pb.status in ("1","2","3","7")
										) as spend,
										p.name AS campaign_name,product_code,p.id as product_id,p.status,p.submission_deadline,p.post_date,p.description,p.product_url,p.product_name,c.name as category_name,pb.status as bid_status,pb.id as bid_id,dp.draft_accept,pb.socialtrackid
									FROM '.$prefix.'products p 
									join '.$prefix.'product_bids pb on p.id=pb.product_id
									left join '.$prefix.'draft_promotion dp on (dp.bid_id=pb.id and dp.draft_accept!="2")
									JOIN '.$prefix.'category c ON p.cat_id=c.id
									'.
									$join.'
									WHERE p.status=2 and p.create_type="'.$type.'" '.$cond.' order by p.id desc
								');
		
		 $this->db->last_query();
		
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
		
	}

	public function send_draft_promotion()
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		$bidid=$this->input->post('bidid',true);
		$description=$this->input->post('description',true);
		$link=$this->input->post('link',true);
		$id=$this->input->post('draftid',true);
		$check=$this->general->get_single_row('product_bids',array('id'=>$bidid,'user_id'=>$user_id));
		$member=$this->general->get_single_row('members',array('id'=>$user_id));
		$status=$check->status;
		$product_id=$check->product_id;
		$date=$this->general->get_local_time('time');

		if(count($check)<1)
		{
			echo json_encode(array('error_message'=> 'You are not authorized to view the proposal'));exit;
		}
		else
		{
			if($id)
			{
					$data=array(
									'description'	=>	$description,
									'link'			=>	$link,
									'draft_accept'	=>	'0',
									'date'			=>	$date
							   );
					if($_FILES)
					{
							if($_FILES['uploadimage']['name'])
								{

									$fdata=$this->general->file_settings_do_upload('uploadimage',DRAFT_IMAGE_PATH,'encrypt');
									if($fdata)
									{
										$data['image']	= $fdata['file_name'];
									}
									else
									{
										return array('error'=>$this->error_img);
									}

								}
					}
					
					$id=$this->general->update_data('draft_promotion',$data,array('id'=>$id));
					if($id) return array('success_message'=>"Draft has been updated");
			}
			else
			{
					$this->db->select('email,p.name,m.id,p.product_code');
					$this->db->from('products p');
					$this->db->join('members m','p.brand_id=m.id');
					$this->db->where('p.id',$product_id);
					$query=$this->db->get();
					if($query->num_rows()==1)
					{
						$data= $query->row();
					}
					$uid=$data->id;
					$email=$data->email;
					$productname=$data->name;
					$parseElement=array(
											'EMAIL'				=>	$email,
											'POST_NAME'			=>	$productname,
											'SENDER_EMAIL'		=>	$member->email,
											'DESCRIPTION'		=>	$description,
											'LINK'				=>	$link,
											'SITENAME'			=>	WEBSITE_NAME
									   );
					$from=SYSTEM_EMAIL;
					$to=$email;
					$email_code='draft_promotion_received';
					$proposalurl=site_url('/'.BRAND.'getproposalbyproduct/'.$data->product_code);
					$this->notification->send_email_notification($email_code, '', $from, $to, '', '', $parseElement, array());
					$notifymsg='You have received a draft of promotion for the campaign <a href="'.$proposalurl.'">'.$productname.' </a>.Please review the draft';
					$this->general->savethisasnotification($uid,$notifymsg,$check->product_id);
					$data=array(
									'bid_id'		=>	$bidid,
									'description'	=>	$description,
									'link'			=>	$link,
									'date'			=>	$date
							   );
					if($_FILES)
					{
							if($_FILES['uploadimage']['name'])
								{

									$fdata=$this->file_settings_do_upload('uploadimage',DRAFT_IMAGE_PATH,'encrypt');
									if($fdata)
									{
										$data['image']	= $fdata['file_name'];
									}
									else
									{
										return array('error'=>$this->error_img);
									}

								}
					}
					$id=$this->general->insert_data('draft_promotion',$data);
						if($id) return array('success_message'=>"Draft has been submitted to user email");
				
			}
			
				 return false;
			
		}

	}

	 public function file_settings_do_upload($file, $location, $encrypt_filename='')
    {
        $this->load->library('upload');
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
	public function get_all_invitation($limit=false,$offset=false)
	{
		
		$user_id=$this->session->userdata(SESSION.'user_id');
		$prefix=$this->db->dbprefix;
		$this->db->select('i.*,p.name as  campaign,m.name as brandname,(select GROUP_CONCAT(ss.id SEPARATOR ",") FROM '.$prefix.'product_socialmedia  ps
											JOIN '.$prefix.'socialmedia_settings ss ON (ss.id=ps.socialmedia_id) WHERE ps.product_id=p.id
											GROUP BY ps.product_id 
										) as media');
		$this->db->from('product_invitation i');
		$this->db->join('products p','i.product_id=p.id');
		$this->db->join('members_details m','p.brand_id=m.user_id');
		$this->db->where('i.user_id',$user_id);
		$this->db->limit($limit,$offset);
		$query=$this->db->get();
		$result=$query->result();
		if($query->num_rows()>0)
			return $result;
		else return false;
	}
	public function get_all_invitation_count()
	{
		$user_id=$this->session->userdata(SESSION.'user_id');
		$prefix=$this->db->dbprefix;
		$this->db->select('i.*');
		$this->db->from('product_invitation i');
		$this->db->join('products p','i.product_id=p.id');
		$this->db->join('members_details m','p.brand_id=m.user_id');
		$this->db->where('i.user_id',$user_id);

		$query=$this->db->get();
	
		return $query->num_rows();
	}
}



