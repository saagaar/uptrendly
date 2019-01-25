<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if(SITE_STATUS == '2')
		{
			redirect(site_url('/offline'));exit;
		}
		else if(SITE_STATUS == '3')
		{
			//check whetheh logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
			if(!$this->session->userdata('MAINTAINANCE_KEY') OR $this->session->userdata('MAINTAINANCE_KEY')!='YES'){
				redirect(site_url('/maintainance'));exit;
			}
		}
		
		//check banned IP address
		$this->general->check_banned_ip();
		
		//load module
		$this->load->model('home_model');
		$this->load->library('pagination');
		$this->load->helper('text');
		//$this->load->library('form_validation');
	
		//Changing the Error Delimiters
		//$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}
	
	
	public function index()
	{
		$this->data['home'] = 'yes';
	 	$this->data['static_banner']="yes";
		$this->data['how_it_works']="yes";
		$this->data['why_reverse_auction']="yes";
		$this->data['about']="yes";

		$this->data['banner_text'] = $this->general->get_cms_details(7);		
		$this->data['about_content'] = $this->general->get_cms_details(2);		
		
		$config['base_url'] = base_url().'home/';
		$config['total_rows'] = $this->home_model->count_all_public_auctions();
		$config['per_page'] = 9;
		$config['page_query_string'] = FALSE;
		$config["uri_segment"] = 2;
		
		//get further config from general library
		$this->general->frontend_pagination_config($config);            
		$this->pagination->initialize($config); 
		
		$offset = $this->uri->segment(2,0); 		
		$this->data["links"] = $this->pagination->create_links($config["per_page"], $offset);
			
		$this->data['public_auctions'] = $this->home_model->get_all_public_auctions($config['per_page'], $offset);
		$this->data['how_it_works_data'] = $this->home_model->get_how_or_why_data('how_it_works');
		$this->data['why_reverse_data'] = $this->home_model->get_how_or_why_data('why_reverse_auction');
		//getting seo data for home page
		$seo_data=$this->general->get_seo(1);
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
		    $this->page_title = WEBSITE_NAME;
		    $this->data['meta_keys']= WEBSITE_NAME;
		    $this->data['meta_desc']= WEBSITE_NAME;
		}

		$this->template
			->set_layout('home')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_home', $this->data);
	}
	
	
	//get auctions by their types like marketplace, plaza, or gallaria
	public function auctions($type='marketplace'){
		$this->breadcrumbs->push('Marketplace', '/'); //second parameter is link
		
		if($type!='plaza' && $type!='marketplace' && $type!='gallaria'){
			redirect(site_url('/'));exit;
		}
		
		//store current date in local variable.
		$this->current_date = $this->general->get_local_time('time');
		$this->data['current_date'] = $this->current_date;
		//$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');
		
		$this->data['bids_count'] = '';
		
		$this->data['live_auction_host'] = $this->home_module->get_live_auctions_by_type($type);
		if($this->data['live_auction_host']){
			$product_id_arr = array();
			foreach($this->data['live_auction_host'] as $auction){
				array_push($product_id_arr, $auction->product_id);
			}
			$this->data['auction_image'] = $this->home_module->get_auction_images($product_id_arr);
			$this->data['bids_count'] = $this->home_module->get_bid_placed_count($product_id_arr);
		}
		
		//echo "<pre>"; print_r($this->data['live_auction_host']); echo "</pre>";
		//echo "<pre>"; print_r($product_id_arr); echo "</pre>";
		//echo "<pre>"; print_r($this->data['auction_image']); echo "</pre>";
		
		//echo "<pre>"; print_r($this->data['bids_count']); echo "</pre>";
		//now calculate the total bids placed in each a
		
		$this->data['upcoming_auction_hosts'] = $this->home_module->get_upcoming_auctions_by_type($type,'6');
		//echo "<pre>"; print_r($this->data['upcoming_auction_hosts']); echo "</pre>";
		
		$this->data['categories_auctions'] = $this->home_module->get_categories_auctions($type);
		if($this->data['categories_auctions']){
			$product_ids_arr = array();
			foreach($this->data['categories_auctions'] as $auction){
				array_push($product_ids_arr, $auction->product_id);
			}
			$this->data['auction_images'] = $this->home_module->get_auction_multiple_images($product_ids_arr);
		}
		
		//echo "<pre>"; print_r($this->data['categories_auctions']); echo "</pre>";
		//echo "<pre>"; print_r($product_ids_arr); echo "</pre>";
		//echo "<pre>"; print_r($this->data['auction_images']); echo "</pre>";
		
		
		$seo_data=$this->general->get_seo(2);
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
		    $this->page_title = WEBSITE_NAME;
		    $this->data['meta_keys']= WEBSITE_NAME;
		    $this->data['meta_desc']= WEBSITE_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_auctions', $this->data);
	}
	
	
	
	public function detail($product_id="")
	{
		//echo "<pre>"; print_r($this->session->all_userdata()); echo "</pre>";
	
		if(empty($product_id)){redirect(site_url(''),'refresh');}
		
		//$this->breadcrumbs->push('Live Auction', '/'); //second parameter is link
		
		//store current date in local variable.
		$this->current_date = $this->general->get_local_time('time');
		$this->data['current_date'] = $this->current_date;
		$this->data['page_for'] = 'bid';
		$this->data['user_id'] = $this->session->userdata(SESSION.'user_id');

		//var_dump($this->data['paypal_verified']); exit;
		
		$this->data['product'] = $this->home_module->get_auction_product_details($host_id);
		//echo "<pre>"; print_r($this->data['product']); echo "</pre>";
		
		//redirect to home page if no data found
		if(!$this->data['product'])	{ redirect(site_url(''),'refresh');	}
		
		//now get additional fields in product 
		$this->data['custom_fields'] = $this->home_module->get_custom_fields_values_by_product_id($this->data['product']->product_id);
		
	  	$this->page_title = WEBSITE_NAME;
		$this->data['meta_keys'] = WEBSITE_NAME;
		$this->data['meta_desc'] = WEBSITE_NAME;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)	
			->build('v_auction_detail', $this->data);	
	}	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */