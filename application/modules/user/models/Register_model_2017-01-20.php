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
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[members.email]|is_unique[members.new_email]')
	);
		
	public $validate__brand_regisration =  array(
		array('field' => 'brand_name', 'label' => 'Brand Name', 'rules' => 'trim|required|min_length[2]|max_length[20]'),
		array('field' => 'brand_url', 'label' => 'Brand URL', 'rules' => 'trim|required|min_length[2]|max_length[20]'),
		array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required'),
		array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[members.email]|is_unique[members.new_email]'),	
		array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required'),
		array('field' => 'terms_condition', 'label' => 'Terms and Condition', 'rules' => 'trim|required'),
		
			);
			

	public function insert_brand()
	{
		$brand_name=$this->input->post('brand_name',true);
		$brand_url=$this->input->post('brand_url',true);
		$name=$this->input->post('name',true);
		$email=$this->input->post('email',true);
		$salt=$this->general->salt();
		$password = $this->general->hash_password($this->input->post('password',TRUE),$salt);
		$activation_code = $this->general->random_number();	
		$current_time = $this->general->get_local_time('time');
		$user_type='3';
		$data=array(
						'email'				=>	 $email,
						'password'			=>	 $password,
						'salt'				=>	 $salt,
						'user_type'			=>	 $user_type,
						'reg_date'			=>	 $current_time,
						'reg_ip'			=>	 $this->general->get_real_ipaddr(),
						'activation_code'	=>	 $activation_code,
						'status'			=>	 '2',
						'brand_name'		=>	 $brand_name,
						'brand_url'			=>	 $brand_url
				   );
		$this->db->insert('members',$data);
		$this->user_id = $this->db->insert_id();
		return $activation_code;

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
				$memberemail=$this->input->post('email',true);
				$emailaccount=$userinfo['userinfo']['email'];
				$gender=$userinfo['userinfo']['gender'];
				$socialmediaid=$userinfo['userinfo']['id'];
				$image=$userinfo['userinfo']['picture']['data']['url'];
				$arrContextOptions=array(
                    "ssl"=>array(
                          "verify_peer"=>false,
                          "verify_peer_name"=>false,
                      ),
                  );  

                    $pic =file_get_contents($userinfo	['picture'],false, stream_context_create($arrContextOptions));
				    $filename=$socialmediaid.'_profilepic.jpg';
				    $path=USER_IMG_DIR.$filename;
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
					'email' => $this->input->post('email'),
					'password'=>$password,
					'user_type' => $user_type,
					'activation_code'=>$activation_code,
					'salt'			=>	$salt,
					'membership_type'=>'',
					'reg_date' => $current_time,
					'reg_ip' => $this->general->get_real_ipaddr(),
					'status' => $status,
					'primary_media'=>$primaryaccount
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
				$current_time = $this->general->get_local_time('time');
				$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));

				$totalreach=$this->session->userdata('page_likes');
				$access_token_user=$this->session->userdata('access_token');
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
		$primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));
		$primaryaccount=$primary_media->id;
		$userid=$this->session->userdata(SESSION.'user_id');
		$emailaccount=$userinfo['userinfo']['email'];
		$gender=$userinfo['userinfo']['gender'];
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
				$memberemail=$this->input->post('email',true);	
				$socialmediaid=$userinfo['user']->data->id;
				$primaryaccount=$primary_media->id;
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$username=$userinfo['user']->data->username;
				// $location=explode(',',$userinfo['userinfo']['location']['name']);
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
					'primary_media'=>$primaryaccount
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
									'username'			=>	$username,
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
				    $path=USER_IMG_DIR.$filename;
				    file_put_contents($path, $pic);
				$totalreach=$this->session->userdata('user_subscribers');
				$access_token_user=$this->session->userdata('access_token');
				// $username=$userinfo['user']->data->username;
				// $location=explode(',',$userinfo['userinfo']['location']['name']);
				$country='';
				
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
					'primary_media'=>$primaryaccount
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
						$agegroupgenderdata[]=array('user_id'=>$this->user_id,'age_range'=>$agegroup['0'],'number_female'=>$agegroup['1'],'number_male'=>$agegroup['2']);
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
									'country'			=>	$country,
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
				$user_id='42';
				if(count($userinfo['countrywiseviews']->rows)>0){
					foreach($userinfo['countrywiseviews']->rows as $country)
					{
						$countrywisedata[]=array('user_id'=>$user_id,'country_code'=>$country['0'],'number_user'=>$country['1']);
					}
				}
				if(count($userinfo['agegroupgender']->rows)>0){
					foreach($userinfo['agegroupgender']->rows as $agegroup)
					{
						$agegroupgenderdata[]=array('user_id'=>$user_id,'age_range'=>$agegroup['0'],'number_female'=>$agegroup['1'],'number_male'=>$agegroup['2']);
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
				$memberemail=$this->input->post('email',true);	
				$socialmediaid=$userinfo['user']->id;
				$primaryaccount=$primary_media->id;
				$totalreach=$this->session->userdata('user_followers');
				$access_token_user=$this->session->userdata('access_token');
				$username=$userinfo['user']->screen_name;
				$location=explode(' ',$userinfo['user']->location);
				$country=$location['1'];
				
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
					'primary_media'=>$primaryaccount
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
									'username'			=>	$username,
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
				$username=$userinfo['user']->data->username;
				$avg_reach=0;
				$location=explode(' ',$userinfo['userinfo']->location);
				$country=$location['1'];
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
		$template_id = 3; // for register_notification
		
		//parse email		
		$user_id=$this->session->userdata(SESSION.'user_id');	
		 $confirm="<a href='".site_url('/user/register/activation/'.$activation_code.'/'.$this->user_id)."'>".site_url('/user/register/activation/'.$activation_code.'/'.$this->user_id)."</a>";

		$parseElement = array(
			"USERNAME"=>$info['userinfo']['name'], 
			"CONFIRM"=>$confirm,
			"SITENAME"=>WEBSITE_NAME
		);	
		
		 $from = CONTACT_EMAIL;
		 $to = $info['userinfo']['email'];

		$this->notification->send_email_notification($template_id, $user_id, $from, $to, '', '', $parseElement, array());
		
		return true;
						
	}
	public function reg_complete_email()
	{			
		$template_id = 1; // for register_notification
		
	
		$parseElement = array(
			"USERNAME"=>$this->input->post('username'), 
			"SITENAME"=>WEBSITE_NAME,
			"EMAIL"=>$this->input->post("email"),
			"PASSWORD"=>$this->input->post('password')
		);	
		
		$from = CONTACT_EMAIL;
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
