<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal_module extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();	
		$this->load->model('account_module');		
	}
	
	public function set_paypal_form_submit()
	{
		$this->transaction_type = $this->input->post('transaction_type',TRUE);	
		$this->current_time = $this->general->get_local_time('time');
		$this->user_id = $this->session->userdata(SESSION.'user_id');		
		
			if(!$this->user_id) { redirect(site_url('')); exit; }
			$this->packageid = $this->input->post('package',TRUE);
			if(!$this->packageid) { redirect(site_url('')); exit; }
			$datapackage=$this->account_module->get_membership_package_byid($this->packageid);
			$this->amount = $datapackage->cost;	
			$this->item_name = $datapackage->package_name;
			
			
			//insert transaction record to transaction table
			$this->invoice_id = $this->insert_membership_package_transaction();
		
		$this->load->library('paypal_class');
		
		if($this->payment_data->status == 2)	//From user.php
			$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
		else
			$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
		
		$this->paypal_class->add_field('image_url', base_url().USER_IMG_DIR.'logo.png');			
		$this->paypal_class->add_field('return', site_url(MY_ACCOUNT.'paypal_success')); 		
		$this->paypal_class->add_field('cancel_return', site_url(MY_ACCOUNT.'paypal_cancel')); 		
		$this->paypal_class->add_field('notify_url', site_url('paypal/paypal_ipn')); 
		$this->paypal_class->add_field('currency_code', DEFAULT_CURRENCY_CODE);
		$this->paypal_class->add_field('business', $this->payment_data->email);		
		$this->paypal_class->add_field('item_name', $this->item_name);
		$this->paypal_class->add_field('amount', number_format($this->amount,2));
		$this->paypal_class->add_field('quantity', 1);
		$this->paypal_class->add_field('invoice', $this->invoice_id);
		$this->paypal_class->add_field('charset', 'utf-8');
		
		$this->paypal_class->add_field('on0', 'transaction_type');
		$this->paypal_class->add_field('os0', $this->transaction_type);
		
		return  $this->paypal_class->submit_paypal_post(); // submit the fields to paypal
		//$this->paypal_class->dump_fields();	exit;  // for debugging, output a table of all the fields		
	}
	
		// public function insert_ordered_item_records_transaction()
		// {
		// 	//insert transaction
		// 	$invoice = strtotime("now").$this->user_id;
		// 	$data = array(
		// 		'invoice_id' => $invoice,
		// 	   	'user_id' => $this->user_id,
		// 		'product_id' => $this->product_id,
		// 		'amount' => $this->total_cost,
		// 		'credit_debit' => 'DEBIT',
		// 		'transaction_name' => $this->item_name,
		// 		'transaction_date' => $this->current_time,
		// 	   	'transaction_type' => $this->transaction_type,
		// 		'transaction_status' => 'Processing',
		// 	   	'payment_method' => 'paypal',   	
		// 	);

		// 	$this->db->insert('transaction', $data);
		// 	//echo $this->db->last_query(); exit;
		// 	return $invoice;
		// }


	//Insert Pay for membership_package
	public function insert_membership_package_transaction()
	{
		$data = array(
		   	'user_id'            => $this->user_id,
			'amount'             => $this->amount,
			'credit_debit' 	     => 'CREDIT',
			'transaction_name'   => $this->item_name,
			'transaction_date'   => $this->current_time,
		   	'transaction_type'   => $this->transaction_type,
			'transaction_status' => 'Processing',
		   	'payment_method'     => 'paypal',   	
		   	'bidpackage_id'		 =>	$this->packageid
		);

		$this->db->insert('transaction', $data);
		$invoice= $this->db->insert_id($this->packageid);
		return $invoice;
	}
	
	
	
	public function add_product_items_to_sales_order_table(){
		$data = array(
			'product_id'=>$this->product_id,
			'user_id' => $this->user_id,
			'invoice_id' => $this->invoice_id,
			'product_cost' => $this->amount,
			'shipping_charge' => $this->ship_cost,
			'total_cost' => $this->total_cost,
			'order_datetime' => $this->current_time,
			'payment_status' => '0',
			'product_type' => 'buy'
		);
		$this->db->insert('sales_order',$data);
		return $this->db->insert_id();
	}


	
	
	public function add_buyer_shipping_address(){
		$shipping_data = array(
			'user_id' => $this->user_id,
			'invoice_id' => $this->invoice_id,
			'first_name' => $this->input->post('first_name',TRUE),
			'last_name' => $this->input->post('last_name',TRUE),
			'address1' => $this->input->post('address1',TRUE),
			'address2' => $this->input->post('address2',TRUE),
			'city' => $this->input->post('city',TRUE),
			'post_code' => $this->input->post('post_code',TRUE),
			'country' => $this->input->post('country',TRUE),
			'state' => $this->input->post('state',TRUE),
			'added_date' => $this->current_time,
		);
		
		$this->db->insert('buyer_shipping_addresses',$shipping_data);
		return $this->db->insert_id();
	}
	
	






	
	// get product id by order id
	public function get_productid_by_orderid($id)
	{
		$user_id = $this->session->userdata(SESSION.'user_id');
		$this->db->select('product_id,quantity,product_cost,shipping_cost,sale_commission');
		$this->db->from('product_order');
		$this->db->where('id',$id);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if($query->num_rows >0)
		{
			return $query->row();
		}
		return false;	
	}
	
	// get paypal account of seller
	
	public function get_paypalid_by_productid($id)
	{
		$this->db->select('M.user_type,M.paypal_account_id,P.seller_id');
		$this->db->from('members M');
		$this->db->join('products P','M.id = P.seller_id');
		$this->db->where(array('P.id'=>$id));
		$this->db->group_by('P.seller_id');

		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		return false;
	}
	
	
	
	
	public function update_buyer_shipping_address($shipping_id, $invoice_id){
		$sdata = array(
				'invoice_id' => $invoice_id 
			);															
					
		$this->db->where('id', $shipping_id);
		$this->db->update('buyer_shipping_addresses', $sdata);
		
	}
	
	//get data from transaction table
	public function get_transaction_data($invoice)
	{
		$query = $this->db->get_where('transaction',array('id'=>$invoice));
		
		if($query->num_rows()>0)
		{
			return $query->row();
		}
	}
	
	
	//update transaction table after payment
	public function paypal_transaction_data_update()
	{
		$data = array(
			'transaction_status' => $this->input->post('payment_status'),
			'txn_id' => $this->input->post('txn_id'),
			'payment_date' => $this->input->post('payment_date'),
			'mc_fee' => $this->input->post('mc_fee'),
			'mc_gross' => $this->input->post('mc_gross'),
			'tax' => $this->input->post('tax'),
			'mc_currency' => $this->input->post('mc_currency'),
			'txn_type'=>$this->input->post('txn_type'),
			'payer_email'=>$this->input->post('payer_email'),
			'payer_status'=>$this->input->post('payer_status'),
			'payment_type'=>$this->input->post('payment_type'),
			'notify_version'=>$this->input->post('notify_version'),
			'verify_sign'=>$this->input->post('verify_sign'),
			'receiver_email' => $this->input->post('receiver_email'),
		);															
					
		$this->db->where('id', $this->input->post('invoice'));
		$this->db->update('transaction', $data);
		
		//$query = $this->db->last_query();
		//$this->send_test_email('QUERY :: update transaction item', $query);													
	}
	
	
	//update sales status in sales order table
	public function update_sales_payment_status($invoice_id, $user_id)
	{
		//$this->send_test_email('inside update sales order function', "Invoice ID: ".$invoice_id." # USer ID: ".$user_id);
		//update sales order
		$this->db->update('sales_order', array('payment_status'=>'1'), array('invoice_id'=>$invoice_id, 'user_id'=>$user_id));
		
		//$query = $this->db->last_query();
		//$this->send_test_email('QUERY :: update order item', $query);
	}
	
	
	//update product table
	public function update_product_table_order_quantity($product_id)
	{
		//$this->send_test_email('inside update product function', "Product ID: ".$product_id);
		
		//get data from product table and update product table
		$this->db->select('order_quantity');
		$query = $this->db->get_where('products', array('id' => $product_id));
		$product_data = $query->row();
		
		//$last_query = $this->db->last_query();
		//$this->send_test_email('QUERY :: get product item details', $last_query);
		
		$new_order_quantity = $product_data->order_quantity + 1;
		
		//update product data
		$this->db->update('products', array('order_quantity' => $new_order_quantity), array('id' => $product_id));
		
		//$uquery = $this->db->last_query();
		//$this->send_test_email('QUERY :: update product item', $uquery);
	}
	
	
	//update sales status in sales order table
	public function update_product_order_for_won_auction($status, $order_id, $user_id)
	{
		//$this->send_test_email('inside_product_order_update_function', $status. " : ".$order_id." : ".$user_id);
		
		$this->db->where('id', $order_id);
		$this->db->where('user_id', $user_id);
		$this->db->update('product_order', array('status'=>'2'));
		
		$query = $this->db->last_query();
		$this->send_test_email('update_order_item', $query);
	}
	
	
    //added by rabi for getting total bids on the product
	public function get_users_used_fee($product_id)
	{
		$this->db->select('user_id,SUM(user_bid_fee) balance');
		$this->db->group_by('user_id');
		$query = $this->db->get_where('product_bids',array('product_id'=>$product_id));
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
		//added by rabi for updating user balance on returning the credit
	public function update_balance($return_credit,$user_id)
	{		
		//get user current balance
		$this->db->select('balance');
		$query = $this->db->get_where('members', array('id'=>$user_id));
		$user_balance = $query->row();
		
		$user_total_balance = $user_balance->balance+$return_credit;
		
		//update user balance
		$data=array('balance'=>$user_total_balance);
		$this->db->where('id',$user_id);
		$this->db->update('members', $data);
	}
	
	
	
	//added by rabi for inserting into transaction table for return credits
	public function update_refund_transaction($user_id,$product_id,$return_bid,$item_name)
	{
		$invoice_id = strtotime("now").$user_id;
		
		$inserting_transaction = array('user_id'=>$user_id,
			'invoice_id'=>$invoice_id,
			'product_id'=>$product_id,
			'credit_get'=>$return_bid,
			'credit_debit'=>'CREDIT',
			'transaction_name'=>$item_name,
			'transaction_date'=>$this->general->get_local_time('time'),
			'transaction_status' => 'Completed', 	
			'transaction_type'=>'refund_credit'
		);
		$this->db->insert('transaction', $inserting_transaction);	
	}
	
	
		
		
	public function get_user_info($user_id)
	{
		$query = $this->db->get_where('members',array('id'=>$user_id));

		if ($query->num_rows() > 0)
		{
		  return $query->row(); 
		} 
	}	

    public function get_auction_byproductid($product_id)
	{
		$this->db->select('name');
		$this->db->from('products');
		$this->db->where('id',$product_id);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			$query->free_result();
			return $data;
		}
		return FALSE;				
	}


	
	//insert product listing fee to transaction table
	public function insert_product_listing_fee_records_transaction(){
		
		//insert transaction
		$invoice = strtotime("now");
		
		$data = array(
			'invoice_id' => $invoice,
		   	'user_id' => $this->session->userdata(SESSION.'user_id'),
			'product_id' => $this->product_id,
			'amount' => $this->total_cost,
			'credit_debit' => 'DEBIT',
			'transaction_name' => $this->item_name,
			'transaction_date' => $this->general->get_local_time('time'),
		   	'transaction_type' => $this->transaction_type,
			'transaction_status' => 'Processing',	//Incomplete
		   	'payment_method' => 'paypal',   	
		);

		$this->db->insert('transaction', $data);
		//echo $this->db->last_query(); exit;
		return $invoice;
	}
	
	
	
	//Purchase credits transaction records
	public function insert_purchase_credit_records_transaction()
	{
		//insert transaction
		$invoice = strtotime("now");
		
		$data = array(
			'invoice_id' => $invoice,
		   'user_id' => $this->session->userdata(SESSION.'user_id') ,
		   'bidpackage_id' => $this->package_data->id,
		   'credit_get' => $this->package_data->credits,
		   'amount' => $this->total_cost,
		   'credit_debit' => 'CREDIT',
		   'transaction_name' => $this->item_name,
		   'transaction_date' => $this->general->get_local_time('time'),
		   'transaction_type' => $this->transaction_type,
		   'transaction_status' => 'Processing',	//Incomplete
		   'payment_method' => 'paypal',
		   //'bonus_points' => $this->bonus_points
		);

		$this->db->insert('transaction', $data);
		//echo $this->db->last_query(); exit;
		return $invoice; 	
	}
	
	public function update_user_balance($purchase_credit, $user_id)
	{		
		//get user current balance
		$this->db->select('balance', 'id');
		$query = $this->db->get_where('members', array('id' => $user_id));
		$user_balance = $query->row();
		
		$user_total_balance = $user_balance->balance + $purchase_credit;
		
		//update user balance
		$data=array('balance' => $user_total_balance);
		$this->db->where('id', $user_id);
		$this->db->update('members', $data);
		
		return $user_total_balance;	
	}
	
	
	public function get_product_order_details($order_id)
	{
		$this->db->select('PO.*, P.name, P.product_code');
		$this->db->from('product_order PO');
		$this->db->join('products P','PO.product_id=P.id','left');
		
		$this->db->where('PO.id',$order_id);
		$this->db->where('PO.product_type','2');
		
		$query = $this->db->get();
		
		if($query->num_rows >0)
		{
			return $query->row();
		}
		return false;	
	}
	
	
	//Insert Pay for won auction records transaction
	public function insert_won_auction_records_transaction($product_order_id)
	{
		//insert transaction
		$invoice = strtotime("now");
		
		$data = array(
			'invoice_id' => $invoice,
		   	'user_id' => $this->session->userdata(SESSION.'user_id'),
			'order_id' => $product_order_id,
			'product_id' => $this->product_id,
			'amount' => $this->total_cost,
			'credit_debit' => 'DEBIT',
			'transaction_name' => $this->item_name,
			'transaction_date' => $this->general->get_local_time('time'),
		   	'transaction_type' => $this->transaction_type,
			'transaction_status' => 'Processing',	//Incomplete
		   	'payment_method' => 'paypal',   	
		);

		$this->db->insert('transaction', $data);
		//echo $this->db->last_query(); exit;
		return $invoice;
	}
	
	
	public function get_Last_sales_order_id()
	{	
		$this->db->select('order_id');
		$this->db->from('sales_order');
		$this->db->where("(user_id='".$this->session->userdata(SESSION.'user_id')."' AND auc_id='".$this->auc_id."')");
		$this->db->order_by('order_id', 'DESC');
		$this->db->limit('1');
		$query = $this->db->get();
		
		$rec = $query->row();
		return $rec->order_id;
	}
	
	
	
	
	public function insert_ordered_billing_shipping()
	{
		$shipping_data = $this->session->userdata('shipping_details');
		
		$data = array(
		   'user_id' => $this->session->userdata(SESSION.'user_id'),
		   'auc_won_id' => $this->auc_ordered_id,	   
		   'invoice_id' => $this->invoice_id,
		   
		   'name' => $this->input->post('name',TRUE),
		   'email' => $this->input->post('email',TRUE),
		   'address' => $this->input->post('address',TRUE),
		   'country' => $this->input->post('country',TRUE),
		   'city' => $this->input->post('city',TRUE),
		   'post_code' => $this->input->post('post_code',TRUE),
		   'phone' => $this->input->post('phone',TRUE),
		   
		   'ship_name' => $shipping_data['ship_first_name']. " ". $shipping_data['ship_last_name'],
		   'ship_address' => $shipping_data['ship_address'],
		   'ship_phone' => $shipping_data['ship_phone'],
		   'ship_country' =>$shipping_data['ship_country'],
		   'ship_city' => $shipping_data['ship_city'],
		   'ship_post_code' =>$shipping_data['ship_post_code'],
		);
		
		$this->db->insert('auction_winner_address', $data);
		
		
		
		$data_sales_order = array(
			'shpping_member_name' => $shipping_data['ship_first_name']. " ". $shipping_data['ship_last_name'],
			'shipping_member_phone' => $shipping_data['ship_phone'],
			'shipping_address' =>  $shipping_data['ship_address'],
		);
		
		$this->last_ordered_id = $this->get_Last_sales_order_id();
		
		$this->db->where(array('order_id' =>$this->last_ordered_id, 'auc_id' => $this->auc_id, 'user_id' => $this->session->userdata(SESSION.'user_id')));
		$this->db->update('sales_order', $data_sales_order);
	}
	
	public function count_txn_id($txn_id)
	{
		$query = $this->db->get_where('transaction',array('txn_id'=>$txn_id));
		return $query->num_rows();
	}
	
	
	
	
	public function get_member_details_by_id($user_id)
	{
		$this->db->select('username, email, lang_id');
		$this->db->where('id',$user_id);
		$query = $this->db->get('members');
		
		if($query->num_rows()>0)
		{
			return $query->row();	
		}
		return false;
	}
	
	public function get_productname_by_id($pid)
	{
		$this->db->select('name');
		$this->db->where('id',$pid);
		$query = $this->db->get('products');
		
		if($query->num_rows()>0)
		{
			return $query->row();	
		}
		return false;
	}
	
	public function send_test_email($subject,$message)
	{
		$this->load->library('email');

		$this->email->from('demo@nepaimpressions.com', 'Pradip');
		$this->email->to('ktm.test1@gmail.com');		
		//$this->email->to('ktm.test@yahoo.com');
		
		$this->email->subject($subject);
		$this->email->message($message); 
		
		$this->email->send();
	}
	
}