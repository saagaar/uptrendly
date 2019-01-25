<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_close extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline'){
			exit;
		}
		
		$this->load->model('auto_close_model');
	}
	
	
		
	public function index()
	{
		//$this->test_send_email('Job Scheduler STARTED','This is test email for job scheduler!!!');	
		$this->current_date_time = $this->general->get_local_time('time');
		$closed_auctions = $this->auto_close_model->get_all_closing_campaigns();
		echo '<pre>';
		print_r($closed_auctions);
		$this->db->trans_start();
		if($closed_auctions)
		{
			foreach($closed_auctions as $eachauctions)
			{
			 	$product_id = $eachauctions->product_id;
			 	$bid_id=$eachauctions->bid_id;
				$socialmediaid=$eachauctions->link;
				$user_id=$eachauctions->user_id;
				$media_id=$eachauctions->mediaid;
				$socialmedia=$this->general->get_single_row('member_socialmedia',array('user_id'=>$user_id,'media_type_id'=>$media_id));
				// echo '<pre>';
				// print_r($socialmedia);
				 $this->general->update_data('product_bids',array('status'=>'7'),array('id'=>$bid_id));
				 $page_id=$socialmedia->page_id;
				 /***************Fetch data from fb post and insert to report*************************/
				 if($media_id==FACEBOOKMEDIAID)
				 {
				 	$objectid=$page_id.'_'.$socialmediaid;
				 	$this->load->library('facebook');
				 	$accestoken=$this->facebook->getAppAccessToken();
			 	    $alldata=$this->facebook->request('GET',$objectid.'/?fields=shares,likes.limit(0).summary(true),comments.limit(0).summary(true)',$accestoken);
			 	
			 	    $likes=$alldata['likes']['summary']['total_count'];
			 	    $share=$alldata['shares']['count'];
			 	    $comments=$alldata['comments']['summary']['total_count'];
			 	    $this->general->insert_data('report',array('upload_link'=>$socialmediaid,'likes'=>$likes,'comments'=>$comments,'share'=>$share,'product_id'=>$product_id,'bid_id'=>$bid_id));
			 	    $influencer=$this->general->get_single_row('members',array('id'=>$user_id));

			 	    /**********Send email to brand for campaign complete***********/
			 	    $template='campaign_completed_brand';
			 	    $memberproduct=$this->general->get_member_by_product($product_id);
			 	    $from=CONTACT_EMAIL;
			 	    $to=$memberproduct->email;
			 	    $notifymsg='Campaign Completed and closed';
			 	    $parseElement=array(
			 	    						'USERNAME'			=> 				ucfirst($memberproduct->username),
			 	    						'INFLUENCER_NAME'	=>				ucfirst($influencer->username),
			 	    						'CAMPAIGN_NAME'		=>				$memberproduct->name,
			 	    						'PRODUCT_NAME'		=>				$memberproduct->product_name,
			 	    						'PRODUCT_URL'		=>				$memberproduct->product_url,
			 	    						'PRODUCT_DESC'		=>				$memberproduct->description,
			 	    						'CAMPAIGN_TYPE'		=>				ucfirst($memberproduct->campaign_type),
			 	    						'POST_DATE'			=>				$memberproduct->post_date,
			 	    						'SITENAME'			=>				WEBSITE_NAME
			 	    				   );
			 	    $this->notification->send_email_notification($template, '', $from, $to, '', '', $parseElement, array());
			 	    $this->general->savethisasnotification($memberproduct->brand_id,$notifymsg,$product_id);
			 	     /**********Send email to Influencer for campaign complete***********/
			 	    $template='campaign_completed_influencer';
			 	    $memberproduct=$this->general->get_member_by_product($product_id);
			 	    $from=CONTACT_EMAIL;
			 	  
			 	    $to=$influencer->email;
			 	    $parseElement=array(
			 	    						'USERNAME'			=> 				ucfirst($influencer->username),
			 	    						'CAMPAIGN_NAME'		=>				$memberproduct->name,
			 	    						'PRODUCT_NAME'		=>				$memberproduct->product_name,
			 	    						'PRODUCT_URL'		=>				$memberproduct->product_url,
			 	    						'PRODUCT_DESC'		=>				$memberproduct->description,
			 	    						'CAMPAIGN_TYPE'		=>				ucfirst($memberproduct->campaign_type),
			 	    						'POST_DATE'			=>				$memberproduct->post_date,
			 	    						'SITENAME'			=>				WEBSITE_NAME
			 	    				   );
			 	    $this->notification->send_email_notification($template, '', $from, $to, '', '', $parseElement, array());
			 	    $this->general->savethisasnotification($influencer->id,$notifymsg,$product_id);
				 }			
			}
		}

			$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return array('error_message'=>'Sorry,Something went wrong.Please try in a while');
		}

		
		
	}
	
	 // function check_membership_expire()
	 // {
	 	
		// $membership_expiring = $this->auto_close_model->get_membership_expiring();
		// if(count($membership_expiring)>0)
		// {
		// 	foreach ($membership_expiring as $key => $value) {
		// 		$template_id=60;
		// 		$to=$value->email;
		// 		$from=CONTACT_EMAIL;
		// 		$parseElement=array(
		// 								'USER'			=> 		$value->username,
		// 								'SITENAME'		=>		WEBSITE_NAME
		// 							);
		// 		$email=$this->notification->send_email_notification($template_id, '', $from, $to, '', '', $parseElement, array());	
		
		// 	}		
		// }

		
	 // }
	
	function test_send_email($subject,$message)
	{
		$this->load->library('email');

		$this->email->from('demo@topencheres.fr');
		$this->email->to('ktm.test@yahoo.com');
		
		$this->email->subject($subject);
		$this->email->message($message); 
		
		$this->email->send();
	}
}	
?>