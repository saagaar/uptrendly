<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->user_id='';
	}
	
	public $user_id; //initialization of user id variable
	
	public $validate_signup_creator =  array(
		array('field' => 'name', 'label' => 'name', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[6]|max_length[20]'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[members.email]|is_unique[members.new_email]'),
		array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|is_unique[members.username]|is_unique[members.username]'),
		array('field' => 'instagram_username', 'label' => 'Instagram Username', 'rules' => 'trim|required'),
		array('field' => 'facebook_profile', 'label' => 'Facebook Profile', 'rules' => 'trim|required')

	);

	public $validate_email_regisration =  array
	(
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[members.email]|is_unique[members.new_email]'),
		array('field' => 'fb_link', 'label' => 'Facebook Link', 'rules' => 'trim|min_length[6]|max_length[50]'),
		array('field' => 'insta_link', 'label' => 'Instagram Link', 'rules' => 'trim|required'),
	);
		
	public $validate__brand_regisration =  array(
		array('field' => 'brand_name', 'label' => 'Brand Name', 'rules' => 'trim|required|min_length[2]|max_length[100]'),
		array('field' => 'brand_url', 'label' => 'Brand URL', 'rules' => 'trim|required|min_length[2]|max_length[100]'),
		array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[members.email]|is_unique[members.new_email]'),
		array('field' => 'username', 'label' => 'username', 'rules' => 'trim|required|is_unique[members.username]|min_length[6]|max_length[200]'),	
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[6]|max_length[50]'),
		array('field' => 'terms_condition', 'label' => 'Terms and Condition', 'rules' => 'trim|required'),
		array('field' => 'phone', 'label' => 'Contact No.', 'rules' => 'trim|required'),
		
			);
		public $validate_youtulee_registeration =  array(
		array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[members.email]|is_unique[members.new_email]'),	
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'youtulee_id', 'label' => 'Youtulee id', 'rules' => 'trim|required|min_length[2]|max_length[50]'),
		array('field' => 'total_reach', 'label' => 'Total Reach', 'rules' => 'trim|required|integer'),
		array('field' => 'average_reach', 'label' => 'Average Reach', 'rules' => 'trim|integer'),
		array('field' => 'country', 'label' => 'Country', 'rules' => 'trim|required'),
		array('field' => 'ratings', 'label' => 'Average Ratings', 'rules' => 'trim|integer'),
		array('field' => 'terms_condition', 'label' => 'Terms and Condition', 'rules' => 'trim|required'),
		
			);
			

	public function insert_brand()
	{
		
		$brand_name=$this->input->post('brand_name',true);
		$brand_url=$this->input->post('brand_url',true);
		$name=$this->input->post('name',true);
		$email=$this->input->post('email',true);
		$phone=$this->input->post('phone',true);
		$country=$this->input->post('country',true);
		$salt=$this->general->salt();
		$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);
		$activation_code = $this->general->random_number();	
		$current_time = $this->general->get_local_time('time');
		$username=$this->input->post('username');
		$referralid=$this->session->userdata('referral_id');
		$user_type='3';
		$status = "2";		
		if(NEED_USER_ACTIVATION =='0')
			$status = "1";
		$data=array(
						'email'				=>	 $email,
						'password'			=>	 $password,
						'salt'				=>	 $salt,
						'user_type'			=>	 $user_type,
						'reg_date'			=>	 $current_time,
						'reg_ip'			=>	 $this->general->get_real_ipaddr(),
						'activation_code'	=>	 $activation_code,
						'status'			=>	 $status,
						'brand_name'		=>	 $brand_name,
						'brand_url'			=>	 $brand_url,
						'username'			=>	 $username,
						'referred_by'		=>	 $referralid
				   );
		 $this->db->insert('members',$data);
		 $this->db->last_query();
		 $this->user_id = $this->db->insert_id();
		 if($this->user_id)
		 {
		 	 $datadetail=array(
							'name'		=>		$name,
							'user_id'	=>		$this->user_id,
							'phone'		=>		$phone
							
					      );
		  $this->db->insert('members_details',$datadetail);
		  $this->db->last_query();
		
			return $activation_code;
		 }
		 else return false;
		

	}
	
	public function insert_member_fb($userinfo,$member_type='creator',$id=false)
	{
		try
		{
			if(!$id)
			{
				//for inserting data for first time
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));
				$salt=$this->general->salt();
				$activation_code = $this->general->random_number();	
				//get random 10 numeric degit	
				$name=$this->input->post('name',true);
				$username=$this->input->post('username',true);
				$instagram_username=$this->input->post('instagram_username',true);
				$facebook_profile=$this->input->post('facebook_profile',true);
				$memberemail=$this->input->post('email',true);
				$emailaccount=$userinfo['userinfo']['email'];
				$gender=$userinfo['userinfo']['gender'];
				$socialmediaid=$userinfo['userinfo']['id'];
				$image=$userinfo['userinfo']['picture']['data']['url'];
				$referralid=$this->session->userdata('referral_id');
				$arrContextOptions=array(
                    "ssl"=>array(
                          "verify_peer"=>false,
                          "verify_peer_name"=>false,
                      ),
                  );  

                    $pic =file_get_contents($image,false, stream_context_create($arrContextOptions));
				    $filename=$socialmediaid.'_profilepic.jpg';
				    $path=USER_IMAGE_PATH.$filename;
				    file_put_contents($path, $pic);

				$primaryaccount=$primary_media->id;
				$totalreach=$this->session->userdata('page_likes');
				$access_token_user=$this->session->userdata('access_token');
				$pageid=$this->session->userdata('pageid');

				$location=explode(',',$userinfo['userinfo']['location']['name']);
				$country=$location[count($location)-1];
				$ratings=$userinfo['ratings'];
				$avg_reach='';
				
				//generate password
					
				$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);

				$status = "2";		
				if (NEED_USER_ACTIVATION =='0')
					$status = "1";
				
				// set user type {3 for brand, 4 for creator}
			
				if($member_type == 'creator')
				{
					$user_type = '4';
				}else{
						$user_type = '3';
				}
				
				 //Running Transactions
				$this->db->trans_start();
				
				//set member info
				$mem_data = array(
					'username'=>$username,
					'email' => $this->input->post('email'),
					'password'=>$password,
					'user_type' => $user_type,
					'activation_code'=>$activation_code,
					'salt'			=>	$salt,
					'membership_type'=>'',
					'reg_date' => $current_time,
					'reg_ip' => $this->general->get_real_ipaddr(),
					'status' => $status,
					'primary_media'=>$primaryaccount,
					'referred_by'		=>	 $referralid,				
					);
				

				//insert records in the members
				$this->db->insert('members',$mem_data);
				$this->user_id = $this->db->insert_id();
				$this->session->set_userdata('user_id',$this->user_id);
				
				// insert detail data into members_details
				$mem_details = array(
					'user_id' => $this->user_id,
					'name' => $name,
					'cover_image'=>$filename,
					'instagram_username'	=>	$instagram_username,
					'facebook_profile'		=>	$facebook_profile
				);

				// insert detail data into members_socialmedia
				$this->db->insert('members_details',$mem_details);
				$media_info=array(
									'media_type_id'		=> 	$primaryaccount,
									'user_id'			=>	$this->user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'email'				=>	$emailaccount,
									'access_token'		=>	$access_token_user,
									'page_id'			=>	$pageid,
									'total_reach'		=>	$totalreach,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time
								 );
				$this->db->insert('member_socialmedia',$media_info);
				$this->db->trans_complete();
				
				//exit;
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $activation_code;
			}else{
				//to update data
				// echo '<pre>';
				//print_r($user_info)
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));

				$totalreach=$this->session->userdata('page_likes');
				$access_token_user=$this->session->userdata('access_token');
				if(isset($userinfo['userinfo']['email']))
				$emailaccount=$userinfo['userinfo']['email'];
				$location=explode(',',$userinfo['userinfo']['location']['name']);
				$country=$location[count($location)-1];
				$ratings=$userinfo['ratings'];
				$avg_reach=0;
				$country='';
				$media_info=array(
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'email'				=>	$emailaccount

								 );
				//update table member_socialmedia
				$response=$this->db->update('member_socialmedia',$media_info,array('id'=>$id));
				return $response;
			}
		}
		catch(exception $e)
		{
			echo $e->getMessage();
		}
		
	}

	public function insert_secondary_media_facebook($userinfo)
	{
		
		$current_time = $this->general->get_local_time('time');
		$secondarymedia=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));
		$primaryaccount=$secondarymedia->id;
		$userid=$this->session->userdata(SESSION.'user_id');
		$emailaccount=isset($userinfo['userinfo']['email'])?$userinfo['userinfo']['email']:'';
		$gender=isset($userinfo['userinfo']['gender'])?$userinfo['userinfo']['gender']:'';
		$image=$userinfo['userinfo']['picture']['data']['url'];
		$socialmediaid=$userinfo['userinfo']['id'];
		$totalreach=$this->session->userdata('page_likes');
		$access_token_user=$this->session->userdata('access_token');
		$pageid=$this->session->userdata('pageid');

		$location=explode(',',$userinfo['userinfo']['location']['name']);
		$country=$location[count($location)-1];
		$ratings=$userinfo['ratings'];
		$avg_reach='';
		$media_info=array(
							'media_type_id'		=> 	$primaryaccount,
							'user_id'			=>	$userid,
							'socialmedia_id'	=>	$socialmediaid,
							'email'				=>	$emailaccount,
							'access_token'		=>	$access_token_user,
							'page_id'			=>	$pageid,
							'total_reach'		=>	$totalreach,
							'country'			=>	$country,
							'rating'			=>	$ratings,
							'avg_reach'			=>	$avg_reach,
							'date_modified'		=>	$current_time
						 );
		$id=$this->db->insert('member_socialmedia',$media_info);
		if($id) return true;
		else return false;
				
	}

	public function insert_member_insta($userinfo,$id=false)
	{
	try
		{
			if(!$id)
			{
				
				//for inserting data for first time
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'instagram'));
				$salt=$this->general->salt();
				$activation_code = $this->general->random_number();	
				//get random 10 numeric degit	
				$name=$this->input->post('name',true);
				$username=$this->input->post('username',true);
				$instagram_username=$this->input->post('instagram_username',true);
				$facebook_profile=$this->input->post('facebook_profile',true);
				$memberemail=$this->input->post('email',true);	
				$socialmediaid=$userinfo['user']->data->id;
				$referralid=$this->session->userdata('referral_id');
				$primaryaccount=$primary_media->id;
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$accountuser=$userinfo['user']->data->username;
				$profile_picture=$userinfo['user']->data->profile_picture;
				// $location=explode(',',$userinfo['userinfo']['location']['name']);
				$arrContextOptions=array(
                    "ssl"=>array(
                          "verify_peer"=>false,
                          "verify_peer_name"=>false,
                      ),
                  );  

                $pic =file_get_contents($profile_picture,false, stream_context_create($arrContextOptions));
			    $filename=$socialmediaid.'_profilepic.jpg';
			    $path=USER_IMAGE_PATH.$filename;
			    file_put_contents($path, $pic);
				$country='';
				
				$avg_reach='';
				
				//generate password
					
				$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);

				$status = "2";		
				// if (NEED_USER_ACTIVATION =='0')
				// 	$status = "1";
				
				// set user type {3 for brand, 4 for creator
					$user_type = '4';
				
				 //Running Transactions
				$this->db->trans_start();
				
				//set member info
				$mem_data = array(
					'username'=>$username,
					'email' => $this->input->post('email'),
					'password'=>$password,
					'user_type' => $user_type,
					'activation_code'=>$activation_code,
					'salt'			=>	$salt,
					'membership_type'=>'',
					'reg_date' => $current_time,
					'reg_ip' => $this->general->get_real_ipaddr(),
					'status' => $status,
					'primary_media'=>$primaryaccount,
					'referred_by'		=>	 $referralid,				
					);
				

				//insert records in the members
				$this->db->insert('members',$mem_data);
				$this->user_id = $this->db->insert_id();
				$this->session->set_userdata('user_id',$this->user_id);
				
				// insert detail data into members_details
				$mem_details = array(
					'user_id' => $this->user_id,
					'name' => $name,
					'cover_image'=>$filename,
					'instagram_username'	=>	$instagram_username,
					'facebook_profile'		=>	$facebook_profile
				);

				// insert detail data into members_socialmedia
				$this->db->insert('members_details',$mem_details);
				$media_info=array(
									'media_type_id'		=> 	$primaryaccount,
									'user_id'			=>	$this->user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'username'			=>	$accountuser,
									'email'				=>	$this->input->post('email'),
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time
								 );
				$this->db->insert('member_socialmedia',$media_info);
				$this->db->trans_complete();
				
				//exit;
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $activation_code;
			}else{
				//to update data
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'instagram'));
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$username=$userinfo['user']->data->username;
				$avg_reach=0;
				$country='';
				$media_info=array(
									'username'			=>	$username,
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time
								 );
				//update table member_socialmedia
				$response=$this->db->update('member_socialmedia',$media_info,array('id'=>$id));
				return $response;
			}
		}
		catch(exception $e)
		{
			echo $e->getMessage();
		}
		
	}

	public function insert_secondary_media_instagram($userinfo)
	{
			$current_time = $this->general->get_local_time('time');
			$secondarymedia=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'instagram'));
			//get random 10 numeric degit	
			$name=$this->input->post('name',true);
			$memberemail=$this->input->post('email',true);	
			$socialmediaid=$userinfo['user']->data->id;
			$accountid=$secondarymedia->id;
			$totalreach=$this->session->userdata('user_followers');
			$access_token_user=$this->session->userdata('access_token');
			$username=$userinfo['user']->data->username;
			$country='';
			$ratings=0;
			$avg_reach=0;
			$media_info=array(
								'media_type_id'		=> 	$accountid,
								'user_id'			=>	$this->session->userdata(SESSION.'user_id'),
								'socialmedia_id'	=>	$socialmediaid,
								'username'			=>	$username,
								'email'				=>	$memberemail,
								'access_token'		=>	$access_token_user,
								'total_reach'		=>	$totalreach,
								'country'			=>	$country,
								'rating'			=>	$ratings,
								'avg_reach'			=>	$avg_reach,
								'date_modified'		=>	$current_time
							 );
			
		$id=$this->db->insert('member_socialmedia',$media_info);
		if($id) return true;
		else return false;
				
	}

	public function insert_member_youtube($userinfo,$id=false)
	{
	try
		{
			$agegroupgenderdata=array();
			$countrywisedata=array();
			if(!$id)
			{
				//for inserting data for first time
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'youtube'));
				$salt=$this->general->salt();
				$activation_code = $this->general->random_number();	
				//get random 10 numeric degit	
				$name=$this->input->post('name',true);
				$username=$this->input->post('username',true);
				$referralid=$this->session->userdata('referral_id');
				$memberemail=$this->input->post('email',true);	
				$accountemail=$userinfo['userinfo']->email;
				$socialmediaid=$userinfo['userinfo']->id;
				$pageid=$userinfo['statistics']['0']->id;
				$primaryaccount=$primary_media->id;
				$image=$userinfo['userinfo']->picture;
				$arrContextOptions=array(
                    "ssl"=>array(
                          "verify_peer"=>false,
                          "verify_peer_name"=>false,
                      ),
                  );  

                    $pic =file_get_contents($image,false, stream_context_create($arrContextOptions));
				    $filename=$socialmediaid.'_profilepic.jpg';
				    $path=USER_IMAGE_PATH.$filename;
				    file_put_contents($path, $pic);
				$totalreach=$this->session->userdata('user_subscribers');
				$access_token_user=$this->session->userdata('access_token');
				// $username=$userinfo['user']->data->username;
				$mcountry='';
				
				$avg_reach='';
				$ratings=0;
				

				//generate password
					
				$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);

				$status = "2";		
				if (NEED_USER_ACTIVATION =='0')
					$status = "1";
				
				// set user type {3 for brand, 4 for creator
					$user_type = '4';
				
				 //Running Transactions
				$this->db->trans_start();
				
				//set member info
				$mem_data = array(
					'email' => $memberemail,
					'password'=>$password,
					'user_type' => $user_type,
					'activation_code'=>$activation_code,
					'salt'			=>	$salt,
					'membership_type'=>'',
					'reg_date' => $current_time,
					'reg_ip' => $this->general->get_real_ipaddr(),
					'status' => $status,
					'primary_media'=>$primaryaccount,
					'referred_by'		=>	 $referralid,
					'username'		=>$username
				);
				

				//insert records in the members
				$this->db->insert('members',$mem_data);
				$this->user_id = $this->db->insert_id();
				$this->session->set_userdata('user_id',$this->user_id);
				
				// insert detail data into members_details
				$mem_details = array(
					'user_id' => $this->user_id,
					'name' => $name,
					'cover_image'=>$filename
				);
				
				if(count($userinfo['countrywiseviews']->rows)>0){
					foreach($userinfo['countrywiseviews']->rows as $country)
					{
						$countrywisedata[]=array('user_id'=>$this->user_id,'country_code'=>$country['0'],'number_user'=>$country['1']);
					}
				}
				if(count($userinfo['agegroupgender']->rows)>0){
					foreach($userinfo['agegroupgender']->rows as $agegroup)
					{
						$agearr=explode('age',$agegroup['0']);
						
						$agegroupgenderdata[]=array('user_id'=>$user_id,'age_range'=>$agearr['1'],'number_female'=>$agegroup['1'],'number_male'=>$agegroup['2']);
					}
				}
				
				if(count($countrywisedata)>0)
				{
					$delid=$this->db->delete('audience_geography',array('user_id'=>$this->user_id));
					 $this->db->insert_batch('audience_geography',$countrywisedata);
				}
				if(count($agegroupgenderdata)>0)
				{
					$delid=$this->db->delete('audience_demographic',array('user_id'=>$this->user_id));
					$this->db->insert_batch('audience_demographic',$agegroupgenderdata);
				}
				// insert detail data into members_socialmedia
				$this->db->insert('members_details',$mem_details);
				$media_info=array(
									'media_type_id'		=> 	$primaryaccount,
									'user_id'			=>	$this->user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'email'				=>	$accountemail,
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'country'			=>	'',
									'rating'			=>	$ratings,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time,
									'page_id'			=>	$pageid
								 );
				$this->db->insert('member_socialmedia',$media_info);
				$this->db->trans_complete();
				
				//exit;
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $activation_code;
			}else{
				//to update data
				
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'youtube'));
				$totalreach=$this->session->userdata('user_subscribers');
				$access_token_user=$this->session->userdata('access_token');
				// $username=$userinfo['user']->data->username;
				$avg_reach=0;
				$country='';
				$media_info=array(
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time
								 );
				 //Running Transactions
				$this->db->trans_start();
			
				$user_id=$this->session->userdata(SESSION . 'user_id');
				
				if(count($userinfo['countrywiseviews']->rows)>0){
					foreach($userinfo['countrywiseviews']->rows as $country)
					{
						$countrywisedata[]=array('user_id'=>$user_id,'country_code'=>$country['0'],'number_user'=>$country['1']);
					}
				}
				
				if(count($userinfo['agegroupgender']->rows)>0){
					$i=0;
					foreach($userinfo['agegroupgender']->rows as $agegroup)
					{
						
						$agearr=explode('age',$agegroup['0']);
						$male=0;
						$female=0;
						
						if($agegroup['1']=='male')
						{
							$male=$agegroup['2'];

						}
						if($agegroup['1']=='female')
						{
							$female=$agegroup['2'];
						}

						$agegroupgenderdata[]=array('user_id'=>$user_id,'age_range'=>$agearr['1'],'number_female'=>$female,'number_male'=>$male);
					}
				}
				

				if(count($countrywisedata)>0)
				{
					$delid=$this->db->delete('audience_geography',array('user_id'=>$user_id));
					 $this->db->insert_batch('audience_geography',$countrywisedata);
				}
				if(count($agegroupgenderdata)>0)
				{
					$delid=$this->db->delete('audience_demographic',array('user_id'=>$user_id));
					$this->db->insert_batch('audience_demographic',$agegroupgenderdata);
				}
				//update table member_socialmedia
				$response=$this->db->update('member_socialmedia',$media_info,array('id'=>$id));
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $response;
			}
		}
		catch(exception $e)
		{
			echo $e->getMessage();
		}
		
	}

		public function insert_secondary_media_youtube($userinfo)
		{
				$agegroupgenderdata=array();
				$countrywisedata=array();
				$current_time = $this->general->get_local_time('time');
				$secondarymedia=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'youtube'));
				
				$memberemail=$this->input->post('email',true);	
				$accountemail=$userinfo['userinfo']->email;
				$socialmediaid=$userinfo['userinfo']->id;
				$pageid=$userinfo['channelid'];
				$currentaccount=$secondarymedia->id;
				$user_id=$this->session->userdata(SESSION.'user_id');
				$country='';
				$avg_reach=0;
				$ratings=0;
				
				$totalreach=$this->session->userdata('user_subscribers');
				$access_token_user=$this->session->userdata('access_token');

				if(count($userinfo['countrywiseviews']->rows)>0)
				{
					foreach($userinfo['countrywiseviews']->rows as $country)
					{
						$countrywisedata[]=array('user_id'=>$user_id,'country_code'=>$country['0'],'number_user'=>$country['1']);
					}
				}
				if(count($userinfo['agegroupgender']->rows)>0)
				{
					foreach($userinfo['agegroupgender']->rows as $agegroup)
					{
						$agearr=explode('age',$agegroup['0']);
						$agegroupgenderdata[]=array('user_id'=>$user_id,'age_range'=>$agearr['1'],'number_female'=>$agegroup['1'],'number_male'=>$agegroup['2']);
					}
				}

				// $username=$userinfo['user']->data->username;
				// $location=explode(',',$userinfo['userinfo']['location']['name']);
				$media_info=array(
									'media_type_id'		=> 	$currentaccount,
									'user_id'			=>	$user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'email'				=>	$accountemail,
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'country'			=>	'',
									'rating'			=>	$ratings,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time,
									'page_id'			=>	$pageid,
								 );

				
			$this->db->trans_start();
			$id=$this->db->insert('member_socialmedia',$media_info);
			// echo $this->db->last_query();
			
			
			if(count($countrywisedata)>0)
			{
				$delid=$this->db->delete('audience_geography',array('user_id'=>$user_id));
				$this->db->insert_batch('audience_geography',$countrywisedata);
				// echo $this->db->last_query();
			}
			if(count($agegroupgenderdata)>0)
			{
				$delid=$this->db->delete('audience_demographic',array('user_id'=>$user_id));
				$this->db->insert_batch('audience_demographic',$agegroupgenderdata);
				// echo $this->db->last_query();
			}
			if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				else{
					// exit;
					if($id) return true;
					else return false;
				}
			
			
					
		}
		
	public function insert_member_twitter($userinfo,$id=false)
	{
	try
		{
			if(!$id)
			{
				//for inserting data for first time
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'twitter'));
				$salt=$this->general->salt();
				$activation_code = $this->general->random_number();	
				//get random 10 numeric degit	
				$name=$this->input->post('name',true);
				$username=$this->input->post('username',true);
				$memberemail=$this->input->post('email',true);	
				$referralid=$this->session->userdata('referral_id');
				$socialmediaid=$userinfo['user']->id;
				$primaryaccount=$primary_media->id;
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$location=explode(' ',$userinfo['user']->location);
				$country=$location['1'];
				$image='';
				$ratings='';
				$avg_reach='';
				
				//generate password
					
				$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);

				$status = "2";		
				if (NEED_USER_ACTIVATION =='0')
					$status = "1";
				
				// set user type {3 for brand, 4 for creator
					$user_type = '4';
				
				 //Running Transactions
				$this->db->trans_start();
				
				//set member info
				$mem_data = array(
					'email' => $this->input->post('email'),
					'password'=>$password,
					'user_type' => $user_type,
					'activation_code'=>$activation_code,
					'salt'			=>	$salt,
					'membership_type'=>'',
					'reg_date' => $current_time,
					'reg_ip' => $this->general->get_real_ipaddr(),
					'status' => $status,
					'primary_media'=>$primaryaccount,
					'referred_by'		=>	 $referralid,
					'username'	=>$username
				);
				

				//insert records in the members
				$this->db->insert('members',$mem_data);
				$this->user_id = $this->db->insert_id();
				$this->session->set_userdata('user_id',$this->user_id);
				
				// insert detail data into members_details
				$mem_details = array(
					'user_id' => $this->user_id,
					'name' => $name,
					'cover_image'=>$image
				);

				// insert detail data into members_socialmedia
				$this->db->insert('members_details',$mem_details);
				$media_info=array(
									'media_type_id'		=> 	$primaryaccount,
									'user_id'			=>	$this->user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'username'			=>	$userinfo['user']->screen_name,
									'email'				=>	$this->input->post('email'),
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time
								 );
				$this->db->insert('member_socialmedia',$media_info);
				$this->db->trans_complete();
				
				//exit;
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $activation_code;
			}else{
				//to update data
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'twitter'));
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$username=$userinfo['user']->screen_name;
				$avg_reach=0;
				$location=explode(' ',$userinfo['user']->location);
				$country=$location['1'];
				$ratings=0;
				
				$media_info=array(
									'username'			=>	$username,
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time,
									'country'			=>	$country,
									'rating'			=>	$ratings
								 );
				//update table member_socialmedia
				$response=$this->db->update('member_socialmedia',$media_info,array('id'=>$id));
				return $response;
			}
		}
		catch(exception $e)
		{
			echo $e->getMessage();
		}
		
	}


	public function insert_secondary_media_twitter($userinfo)
	{
			$current_time = $this->general->get_local_time('time');
			$secondarymedia=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'twitter'));
			$memberemail=$this->input->post('email',true);	
			$socialmediaid=$userinfo['user']->id;
			$currentaccount=$secondarymedia->id;
			$totalreach=$this->session->userdata('user_followers');
			$access_token_user=$this->session->userdata('access_token');
			$username=$userinfo['user']->screen_name;
			$location=explode(' ',$userinfo['user']->location);
			$country=$location['1'];
			$ratings=0;
			$avg_reach='';
			$media_info=array(
								'media_type_id'		=> 	$currentaccount,
								'user_id'			=>	$this->session->userdata(SESSION.'user_id'),
								'socialmedia_id'	=>	$socialmediaid,
								'username'			=>	$username,
								'email'				=>	$memberemail,
								'access_token'		=>	$access_token_user,
								'total_reach'		=>	$totalreach,
								'country'			=>	$country,
								'rating'			=>	$ratings,
								'avg_reach'			=>	$avg_reach,
								'date_modified'		=>	$current_time
							 );
				
		$id=$this->db->insert('member_socialmedia',$media_info,true);

		if($id) return true;
		else return false;
				
	}
	public function insert_member_youtulee()
	{
		$current_time = $this->general->get_local_time('time');
		$primarymedia=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'youtulee'));
		$primaryaccount=$primarymedia->id;
		$name=$this->input->post('name',true);
		$username=$this->input->post('username',true);
		$referralid=$this->session->userdata('referral_id');
		$email=$this->input->post('email',true);
		$password=$this->input->post('password',true);
		$socialmediaid=$this->input->post('youtulee_id',true);
		$total_reach=$this->input->post('total_reach',true);
		$average_reach=$this->input->post('average_reach',true);
		$country=$this->input->post('country',true);
		$ratings=$this->input->post('ratings',true);
		$activation_code = $this->general->random_number();	
				
		$salt=$this->general->salt();
		$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);
		$status = "2";		
				if (NEED_USER_ACTIVATION =='0')
					$status = "1";
				
				// set user type {3 for brand, 4 for creator
					$user_type = '4';
				
				 //Running Transactions
				$this->db->trans_start();
				
				//set member info
				$mem_data = array(
					'email' 			=> 	$email,
					'password'			=>	$password,
					'user_type' 		=>	$user_type,
					'activation_code'	=>	$activation_code,
					'salt'				=>	$salt,
					'username'			=>	$username,
					'membership_type'	=>	'',
					'reg_date' 			=> 	$current_time,
					'reg_ip'			=> 	$this->general->get_real_ipaddr(),
					'status' 			=> 	$status,
					'primary_media'		=>	$primaryaccount,
					'referred_by'		=>	 $referralid

				);
				

				//insert records in the members
				$this->db->insert('members',$mem_data);
				$this->user_id = $this->db->insert_id();
				$this->session->set_userdata('user_id',$this->user_id);
				
				// insert detail data into members_details
				$mem_details = array(
					'user_id' => $this->user_id,
					'name' => $name,
				);

				// insert detail data into members_socialmedia
				$this->db->insert('members_details',$mem_details);
				$media_info=array(
									'media_type_id'		=> 	$primaryaccount,
									'user_id'			=>	$this->user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'username'			=>	$username,
									'email'				=>	$email,
									'access_token'		=>	'',
									'total_reach'		=>	$total_reach,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'avg_reach'			=>	$average_reach,
									'date_modified'		=>	$current_time
								 );
				$this->db->insert('member_socialmedia',$media_info);
				$this->db->trans_complete();
				
				//exit;
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $activation_code;
	}
	

	public function insert_member_tumblr($userinfo,$id=false)
	{
	try
		{
			if(!$id)
			{
				//for inserting data for first time
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'tumblr'));
				$salt=$this->general->salt();
				$activation_code = $this->general->random_number();	
				//get random 10 numeric degit	
				$name=$this->input->post('name',true);
				$username=$this->input->post('username',true);
				$memberemail=$this->input->post('email',true);	
				$socialmediaid=$userinfo['user']->user->blogs['0']->uuid;
				$referralid=$this->session->userdata('referral_id');
				$primaryaccount=$primary_media->id;
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$location='';
				$country='';
				
				$avg_reach='';
				
				//generate password
					
				$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);

				$status = "2";		
				if (NEED_USER_ACTIVATION =='0')
					$status = "1";
				
				// set user type {3 for brand, 4 for creator
					$user_type = '4';
				
				 //Running Transactions
				$this->db->trans_start();
				
				//set member info
				$mem_data = array(
					'email' => $this->input->post('email'),
					'password'=>$password,
					'user_type' => $user_type,
					'activation_code'=>$activation_code,
					'salt'			=>	$salt,
					'membership_type'=>'',
					'reg_date' => $current_time,
					'reg_ip' => $this->general->get_real_ipaddr(),
					'status' => $status,
					'primary_media'=>$primaryaccount,
					'referred_by'		=>	 $referralid,
					'username'		=>$username
				);
				

				//insert records in the members
				$this->db->insert('members',$mem_data);
				$this->user_id = $this->db->insert_id();
				$this->session->set_userdata('user_id',$this->user_id);
				
				// insert detail data into members_details
				$mem_details = array(
					'user_id' => $this->user_id,
					'name' => $name,
					'cover_image'=>$image
				);

				// insert detail data into members_socialmedia
				$this->db->insert('members_details',$mem_details);
				$media_info=array(
									'media_type_id'		=> 	$primaryaccount,
									'user_id'			=>	$this->user_id,
									'socialmedia_id'	=>	$socialmediaid,
									'username'			=>	$userinfo['user']->user->name,
									'email'				=>	$this->input->post('email'),
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'avg_reach'			=>	$avg_reach,
									'date_modified'		=>	$current_time
								 );
				$this->db->insert('member_socialmedia',$media_info);
				$this->db->trans_complete();
				
				//exit;
				if ($this->db->trans_status() === FALSE){
					throw new exception("System error", 1);
				}
				return $activation_code;
			}else{
				//to update data
				
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'tumblr'));
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$username=$userinfo['user']->user->name;
				$avg_reach=0;
				$ratings=0;
				$country='';
				$media_info=array(
									'username'			=>	$username,
									'access_token'		=>	$access_token_user,
									'total_reach'		=>	$totalreach,
									'avg_reach'			=>	$avg_reach,
									'country'			=>	$country,
									'rating'			=>	$ratings,
									'date_modified'		=>	$current_time
								 );
				//update table member_socialmedia
				$response=$this->db->update('member_socialmedia',$media_info,array('id'=>$id),true);
				echo 'herewe po';
				return $response;
			}
		}
		catch(exception $e)
		{
			echo $e->getMessage();
		}
		
	}


	public function insert_secondary_media_tumblr($userinfo)
	{
			$current_time = $this->general->get_local_time('time');
			$secondarymedia=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'tumblr'));
			$memberemail=$this->input->post('email',true);	
			$socialmediaid=$userinfo['user']->user->blogs['0']->uuid;
			$currentaccount=$secondarymedia->id;
			$totalreach=$this->session->userdata('user_followers');
			$access_token_user=$this->session->userdata('access_token');
			$username=$userinfo['user']->user->name;
			// $location=explode(' ',$userinfo['user']->location);
			$country='';
			$ratings=0;
			$avg_reach='';
			$media_info=array(
								'media_type_id'		=> 	$currentaccount,
								'user_id'			=>	$this->session->userdata(SESSION.'user_id'),
								'socialmedia_id'	=>	$socialmediaid,
								'username'			=>	$username,
								'email'				=>	$memberemail,
								'access_token'		=>	$access_token_user,
								'total_reach'		=>	$totalreach,
								'country'			=>	$country,
								'rating'			=>	$ratings,
								'avg_reach'			=>	$avg_reach,
								'date_modified'		=>	$current_time
							 );
				
		$id=$this->db->insert('member_socialmedia',$media_info,true);

		if($id) return true;
		else return false;
				
	}

	public function save_member_temp()
	{
		$email=$this->input->post('email',true);
		$fb_link=$this->input->post('fb_link',true);
		$insta_link=$this->input->post('insta_link',true);
		$data=$this->general->insert_data('members_temp',array('email'=>$email,'fb_link'=>$fb_link,'insta_link'=>$insta_link));
		if($data)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//update balance in referral account and add referral tranaction
	public function update_referral_balance_and_bonus_records_transaction($referrer_id, $new_user_id)
	{
		$current_date = $this->general->get_local_time('time');
		
		//update referrers bonus
		$this->db->set('balance', 'balance+'.REFER_BONUS, FALSE);
		$this->db->where('id', $referrer_id);
		$this->db->update('members');
		
		//add transaction to transaction table
		$txn_data = array(
		   'user_id' => $referrer_id,		   		
		   'credit_get' => REFER_BONUS,
		   'credit_debit' => 'CREDIT',
		   'transaction_name' => lang('referral_bonus').' :'.$new_user_id,
		   'transaction_date' => $current_date,
		   'transaction_type' => 'referer_bonus',
		   'transaction_status' => 'Completed',
		   'payment_method' => 'direct',
		   'current_balance' => 'current_balance +'.$user_total_balance
			);
	
		$this->db->insert('transaction', $txn_data);
		return $this->db->insert_id(); 	
	}
	
		
	// public function insert_signup_bonus_records_transaction()
	// {
	// 	$invoice = strtotime("now");
	// 	$data = array(
	// 	   'invoice_id' => $invoice,
	// 	   'user_id' => $this->user_id,		   		
	// 	   'credit_get' => SIGNUP_BONUS,
	// 	   'credit_debit' => 'CREDIT',
	// 	   'transaction_type' => 'signup_bonus',
	// 	   'transaction_name' => lang('free_balance_for_signup'),
	// 	   'transaction_date' => $this->general->get_local_time('time'),
	// 	   'transaction_status' => 'Completed',
	// 	   'payment_method' => 'direct',
	// 	   //'current_balance' => SIGNUP_BONUS
	// 	);
	
	// 	$this->db->insert('transaction', $data);
	// 	return $this->db->insert_id(); 
	// }
	

	public function reg_confirmation_email($info,$activation_code)
	{			
		$template_id = 'email_confirmation'; // for register_notification
		
		//parse email		
		$user_id=$this->session->userdata(SESSION.'user_id');	
		 $confirm="<a href='".site_url('/user/register/activation/'.$activation_code.'/'.$this->user_id)."'>".site_url('/user/register/activation/'.$activation_code.'/'.$this->user_id)."</a>";

		$parseElement = array(
			"USERNAME"=>$info['userinfo']['email'], 
			"CONFIRM"=>$confirm,
			"SITENAME"=>WEBSITE_NAME
		);	
		
		$this->notification->send_email_notification($template_id, $user_id, $from, $to, '', '', $parseElement, array());
		
		return true;
						
	}
	public function reg_complete_email($usertype='brand')
	{			
		// error_reporting(E_ALL);
		// ini_set('dispaly_errors',1);
		$template_id = 'register_notification'; // for register_notification
		if($usertype=='brand')
		{
			$admin_email=ADVERTISER_EMAIL;
		}
		else{
			$admin_email=INFLUENCER_EMAIL;
		}
		$parseElement = array
							(
								"USERNAME"=>$this->input->post('username'), 
								"SITENAME"=>WEBSITE_NAME,
								"ADMIN_EMAIL"=>$admin_email,
							);	
		$from = $admin_email;
		 $to = $this->input->post('email', TRUE);
		$this->notification->send_email_notification($template_id, $user_id, $from, $to, '', '', $parseElement, array());
	
						
	}
	
	
	public function send_welcome_mail_to_new_user($activation_code)
	{
		
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
		//initialize email configurations
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		
			
		$this->load->model('email_model');
		//get subjet & body
		$template = $this->email_model->get_email_template("welcome_email");
		$subject=$template['subject'];
		$emailbody=$template['email_body'];
		
		//check blank value before send message
		if(isset($subject) && isset($emailbody))
		{
			//parse email
			$parseElement = array(
				"FIRSTNAME"=>$this->input->post('first_name'), 
				"SITENAME"=>WEBSITE_NAME,
				"EMAIL"=>$this->input->post("email")
				
			);

			$subject = $this->email_model->parse_email($parseElement,$subject);
			$emailbody = $this->email_model->parse_email($parseElement,$emailbody);
					
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->from(CONTACT_EMAIL, WEBSITE_NAME);
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			
			/*echo $subject;
			echo "<br>";
			echo $emailbody;
			echo "<br><br><br><br>";
			exit;*/
			//echo $this->email->print_debugger();exit;
		}
	
	}
	
	public function check_user_activation($activation_code,$user_id)
	{
		$query = $this->db->get_where('members',array('activation_code'=>$activation_code,'id'=>$user_id, 'status'=>2));
		
		if ($query->num_rows() > 0) {
            $user_data = $query->row_array();
            $user_id = $user_data['id'];
            //$refer_id=$user_data['referer_id'];

            $data = array('status' => 1);
            $this->db->where('id', $user_id);
            $this->db->update('members', $data);

            $template_id = 1; // for register_notification
		$query=$this->db->get_where('members',array('id'=>$user_id));
		$user=$query->row_array();
		$username=$user['username'];
		$email=$user['email'];

	
		$parseElement = array(
			"USERNAME"=>$username, 
			"SITENAME"=>WEBSITE_NAME,
			"EMAIL"=>$email
		);	
		
		$from = CONTACT_EMAIL;
		$to = $email;

		$this->notification->send_email_notification($template_id, $user_id, $from, $to, '', '', $parseElement, array());

            return TRUE;
        } else {
            return FALSE;
        }
    }	
        public function get_succes_register_message($client){
            $this->db->where('cms_slug',$client);
            $query=$this->db->get('cms');
            if($query->num_rows()==1){
                return $query->row();
            }
        }
	
	public function username_exists($username)
	{
		$data = array();
		$query = $this->db->get_where("members",array('username'=>$username));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();				
		}
		$query->free_result();	
		return $data;
	}
	
	public function email_exists($email)
	{
		$data = array();
		$query = $this->db->get_where("members",array('email'=>$email));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();				
		}
		$query->free_result();	
		return $data;
	}
	
	
	
	function get_captcha()
	{
		$configs = array(
			'word' => strtolower(random_string('alnum', 8)),
			'img_path'     => './captcha/',
			'img_url'	 => base_url().CAPTCHA_PATH,
			'img_width'     => '150',
			'img_height' => 32,
			'char_set' 		=> "ABCDEFGHJKLMNPQRSTUVWXYZ2345689",
			'char_color' 	=> "#000000"
			); 
		$captcha = $this->antispam->get_antispam_image($configs);
		
		$cap=strtolower($captcha['word']); 
				
		$this->session->set_userdata('word',$cap);
		
		return $captcha['image'];
	}	
	
	
	private function delete_old_captcha(){
        /** define the captcha directory **/
        $dir = './'.CAPTCHA_PATH;
        
        /*** cycle through all files in the directory ***/
        foreach (glob($dir."*.jpg") as $file) {
        //echo filemtime($file); echo '<br/>';
        /*** if file is 24 hours (86400 seconds) old then delete it ***/
        if (filemtime($file) < time() - 3600) {
             @unlink($file);
             //echo $file;
            }
        }
    }
	
	
	//function to send test email
	public function send_test_email($subject,$message)
	{
		$this->load->library('email');

		$this->email->from('demo@nepaimpressions.com', 'Pradip');
		//$this->email->to('ktm.test1@gmail.com');		
		$this->email->to('ktm.test1@gmail.com');
		
		$this->email->subject($subject);
		$this->email->message($message); 
		
		$this->email->send();
	}
}
