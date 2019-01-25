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
	public function submitproposal(){
		$userid=$this->session->userdata(SESSION.'user_id');
		$socialmedia=$this->general->get_all_media();	
		$productid=$this->input->post('productid',true);
		$current_date=$this->general->get_local_time('now');
		$this->db->trans_start();
		foreach ($socialmedia as $key => $value) 
		{
			
			if(count($this->input->post($value,true))>0)
			{
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
							$insertdata  =     array(
													'user_id'		=>	$userid,
													'product_id'	=>	$productid,
													'bid_date'		=>	$current_date,
													'mediaid'		=>	$mediaid,
													'bid_details'	=>	$this->input->post($value)['bid_details'],
													'user_bid_amt'	=>	$this->input->post($value)['bid_amount'],
													'delivery_date'	=>	$this->input->post($value)['delivery_date'],
													'membermediaid'	=>	$usermediaid,
													'productmediaid'=>  $productmediaid
												   );
							$id=$this->general->insert_data('product_bids',$insertdata);
				    }
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			return array('error'=>'Sorry,Something went wrong.Please try in a while');
		}
		return array('success'=>true);
	}

		public function getallsponsorship($type='public',$id=false){
		if($type=='public') $cond="and p.auction_type='1'";
		else $cond="and p.auction_type='2'";
		$media=$this->input->post('filtermediatype',true);
		$price_range=$this->input->post('filterpricerange',true);
		 $name=$this->db->escape_like_str($this->input->post('filterproductname',true));
		$category=$this->input->post('filtercategory',true);
		$join='';
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
									JOIN '.$prefix.'product_categories c ON p.cat_id=c.id
									JOIN '.$prefix.'pricerange pr ON (p.price_range=pr.id)'.
									$join.'
									WHERE p.status="2" AND p.create_type="campaign" and p.winner_notified="0" '.$cond.'
								');
		
		 $this->db->last_query();
		
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
		

	}

	public function getallcollaborationposts($type,$id=false){

		if($type=='public') $cond="and p.auction_type='1'";
		else $cond="and p.auction_type='2'";
		$media=$this->db->escape($this->input->post('filtermediatype',true));
		$likes=$this->db->escape($this->input->post('filterfancount',true));
		$name=$this->db->escape_like_str($this->input->post('filterproductname',true));
		$join='';
		$prefix=$this->db->dbprefix;
		// $name='car';
		
		if((trim($name)!=''))
		{
			$cond=$cond." and p.name like ('%$name%')";
		}
		if((trim($likes)!=''))
		{
			
			$cond=$cond." and p.least_fan_count>=$likes";
		}

		if(trim($media)!=''){
				
			$join=' JOIN '.$prefix.'product_socialmedia psa ON (p.id=psa.product_id)';
			$cond=$cond." and psa.socialmedia_id=$media";
		}
		if($id)
		{
			$cond=$cond."and p.id=$id";
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
										p.name AS product_name,p.id as product_id,p.least_fan_count,p.status,p.description,p.submission_deadline 
									FROM '.$prefix.'products p'.
									$join.'
									WHERE p.status="2" AND p.create_type="collab" '.$cond.'
								');
		
	echo	 $this->db->last_query();
		
		$result=$query->result('array');
		if(count($result)>0) return $result;
		else return array();
		

	}
}



