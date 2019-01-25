<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Admin_report extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public $validate_settings_member_report =  array(	
			array('field' => 'from_date', 'label' => 'From Date', 'rules' => 'required'),
			array('field' => 'to_date', 'label' => 'To Date', 'rules' => 'required|callback_check_end_date')
		);
	
	public $validate_settings_product_report =  array(	
			array('field' => 'from_date_product', 'label' => 'From Date', 'rules' => 'required'),
			array('field' => 'to_date_product', 'label' => 'To Date', 'rules' => 'required|callback_check_end_date_product')
		);
	
	
	public $validate_settings_credit_report =  array(	
			array('field' => 'from_date_credit', 'label' => 'From Date', 'rules' => 'required'),
			array('field' => 'to_date_credit', 'label' => 'To Date', 'rules' => 'required|callback_check_end_date_credit')
		);
	
	//get languages 
	public function get_lang_details_for_others()
	{		
		$this->db->order_by("id", "ASC");
		$query = $this->db->get('language');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	
  function total_payment_by_payment_gateway($payment_method,$datefrom='', $dateto='')
	{
		$this->db->select_sum('amount');
		$this->db->where('payment_method',$payment_method);
		$this->db->where('transaction_status','Completed');
		if($datefrom!='' && $dateto!='')
		{
			$this->db->where('transaction_date >',$datefrom);
			$this->db->where('transaction_date <',$dateto);		
		}
		
		$query = $this->db->get('transaction');
		if($query->num_rows() > 0)
		{
		return $query->row();
		}
		return false;
	}
	
	function total_sum($field_name,$table_name)
	{
		$this->db->select_sum($field_name);
		$query = $this->db->get($table_name);
		if($query->num_rows() > 0)
		{
		return $query->row();
		}
		return false;
	}
	
	function count_total_sold_products($datefrom='', $dateto='')
	{
		//count the sales order from sales order table

		$this->db->where('payment_status ', 'Completed');
		// if($datefrom!='' && $dateto!='')
		// {
		// 	$this->db->where('order_date >',$datefrom);
		// 	$this->db->where('order_date <',$dateto);	
		// }
		$query = $this->db->get('product_winner');
		
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		return false;
	}
	
	
	function total_cost_products_sold()
	{
		$this->db->select('won_amount as totalcost');
		$this->db->from('product_winner');
		$this->db->where('payment_status', 'Completed');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data;
		}
		return false;
	}
	
	function total_site_commissions($days="")
	{
		$this->db->select('SUM( quantity * sale_commission ) as totalcommission');
		$this->db->from('product_order');
		
		if($days !="")
		{
		$current_date = $this->general->get_local_time('time');
        $fromdate = strtotime ( '-'.$days.' day' , strtotime ( $current_date ) ) ;
        $fromdate = date ( 'Y-m-d H:i:s' , $fromdate );
		$this->db->where('order_date >=',$fromdate);
	    $this->db->where('order_date <',$current_date);
		}
		
		$this->db->where('status !=',1);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data;
		}
		return false;
	}
	
	
	function get_total_revenue($transaction_type="")
	{
		$this->db->select('SUM( amount ) as total_amount');
		$this->db->from('transaction');
		$this->db->where('transaction_status','Completed');
		$this->db->where('transaction_type', $transaction_type);
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data;
		}
		return false;
	}
	
	
	function top_products_sold()
	{
		$this->db->select('p.name');
		$this->db->from('product_winner po');
		$this->db->join('products p','p.id = po.product_id','left');

		$this->db->where('po.payment_status', 'Completed');
		$this->db->group_by('po.product_id');
		// $this->db->order_by('totalsale','DESC');
		$this->db->limit('10');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$data = $query->result();
			return $data;
		}
		return false;
	}
	
	function top_buyers()
	{
		$this->db->select('SUM( quantity ) as  totalbuys, po.user_id, m.username');
		$this->db->from('product_order po');
		$this->db->join('members m','m.id = po.user_id','left');
		$this->db->where('po.status !=',1);
		$this->db->group_by('po.user_id');
		$this->db->order_by('totalbuys','DESC');
		$this->db->limit('10');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->result();
			return $data;
		}
		return false;
	}
	
	function top_sellers()
	{
		$this->db->select('SUM( po.quantity ) as  totalsale, p.seller_id, m.user_name');
		$this->db->from('product_order po');
		$this->db->join('products p','p.id = po.product_id','left');
		$this->db->join('members m','m.id = p.seller_id','left');
		$this->db->where('po.status !=',1);
		$this->db->group_by('m.user_name');
		$this->db->order_by('totalsale','DESC');
		$this->db->limit('10');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->result();
			return $data;
		}
		return false;
	}
	
	
	function create_customer_registration_report()
	{
		//$date_from ='2013-01-30 11:08:40';
		//$date_to = '2014-02-03 11:08:40';
		
		$pad = ':00';
		$date_from = $this->input->post('from_date').$pad;
		$date_to = $this->input->post('to_date').$pad;
		
		//print_r($_POST); exit;
		
		$date_from=date("Y-m-d",strtotime($date_from));
		$date_to=date("Y-m-d",strtotime($date_to));
		
		$reg_report = "";
		
		$reg_report = WEBSITE_NAME." Member Registration Report - By Date Range";
		
		$reg_report .= "\n";
		
		$reg_report.='"Member Registration Date","User ID","User Name","Email Address","Balance","User Status"';
		
		$reg_report .= "\n";
		
		$this->member_details = $this->get_member_details_by_date($date_from, $date_to);
		if($this->member_details)
		{
			foreach($this->member_details as $mem)
			{	
				$reg_date = $mem->reg_date;
				$user_id = $mem->id;
				$user_name = $mem->user_name;
				$email = $mem->email;
				$balance = $mem->balance;
				
				if($mem->status == 1)
				$status = "Active";
				else if($mem->status == 2)
				$status = "Inactive";
				else if($mem->status == 3)
				$status = "Suspended";
				else
				$status = "Closed";
				
				
				
				$reg_report .= '"'.$reg_date.'","'.$user_id.'","'.$user_name.'","'.$email.'","'.$balance.'","'.$status.'"';
				$reg_report .= "\n";
				//$reg_report .= "<br>";
			}
		}
		else
		{
			$reg_report .= "No Data found";	
		}
		
		// Output to browser with appropriate mime type, you choose ;)  
	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=customer-registation-report-by-date-".date("Y-m-d").".csv");
		echo $reg_report;
		exit;
	}
	
	function get_member_details_by_date($date_from, $date_to)
	{
		$this->db->select('*');
		$this->db->from('members');
		$this->db->where('reg_date >=',$date_from);
	    $this->db->where('reg_date <',$date_to);
		
		if($this->input->post('lang_id'))
		{
		$this->db->where('lang_id',$this->input->post('lang_id'));
		}
		
		$query = $this->db->get();
	
	    if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
			return false;			
	}
	
	function create_product_sold_report_by_date()
	{
		
		$pad = ':00';
		$date_from = $this->input->post('from_date_product').$pad;
		$date_to = $this->input->post('to_date_product').$pad;
	
	    $date_from = date("Y-m-d",strtotime($date_from));
		$date_to = date("Y-m-d",strtotime($date_to));

		$pro_sold = '';
		$pro_sold .= WEBSITE_NAME." Sold Report - By Date Range";
		
		$pro_sold .= "\n";
		
		$pro_sold .= '"Sold Date","Invoice ID","Product ID","Product Name","Quantity","Product Price","Shipping Charge","Total Paid","Payment gateway","User ID","User Name","Country"';
		
		$pro_sold .= "\n";
		
		$this->product_sold_details = $this->get_total_sold_products($date_from, $date_to);
		
		//echo "<pre>"; print_r($this->product_sold_details); echo "</pre>"; exit;
		
		if($this->product_sold_details)
		{
			foreach ($this->product_sold_details as $sales)
			{
				$sold_date = $sales->order_date;
				$invoice_id = $sales->invoice_id;
				$product_id = $sales->product_id;
				$product_name =$sales->name;
				$product_price=$sales->product_cost;
		   	    $quantity=$sales->quantity;
				$shipping=$sales->shipping_cost;
				$total=$sales->shipping_cost + $product_price;
				$payment_method = $sales->payment_method;
				
				$mem_id = $sales->user_id;
				$mem_det = $this->general->get_member_details_by_user_id($mem_id);
				$user_name=$mem_det->name;
				$country=$mem_det->country;
				
				
				$pro_sold .= '"'.$sold_date.'","'.$invoice_id.'","'.$product_id.'","'.$product_name.'","'.$quantity.'","'.$product_price.'","'.$shipping.'","'.$total.'","'.$payment_method.'","'.$mem_id.'","'.$user_name.'","'.$country.'"';
				$pro_sold .= "\n";
				
				//$pro_sold .= "<br>";	
			}
		}
		else
		{
			$pro_sold .= "No Data found";	
		}
		
		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=product-sold-report-by-date-".date("Y-m-d").".csv");
		
		echo $pro_sold;  
		exit;
	}
	
	function get_total_sold_products($datefrom='', $dateto='')
	{
		
		$this->db->select('po.*,p.name,trans.invoice_id,trans.payment_method');
		$this->db->from('product_order po');
		$this->db->join('products p','p.id = po.product_id','left');
		$this->db->join('transaction trans','trans.product_id = po.product_id','left');
		
		$this->db->where('po.status !=',1);
		$this->db->where('p.status',3);
		
		if($datefrom != '' && $dateto != '')
		{
		$this->db->where('po.order_date >=',$datefrom);
	    $this->db->where('po.order_date <',$dateto);
		}
		
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}
	
		
	function create_credit_sold_report_by_date()
	{
		
		$pad = ':00';
		$date_from = $this->input->post('from_date_credit').$pad;
		$date_to = $this->input->post('to_date_credit').$pad;
		
		$date_from=date("Y-m-d",strtotime($date_from));
		$date_to=date("Y-m-d",strtotime($date_to));
		
		$cre_sold = '';
		
		$cre_sold .= WEBSITE_NAME." Credits Sold Report - By Date Range";
		
		$cre_sold .= "\n";
		
		$cre_sold .= '"Date","Invoice ID","Member ID","Member Full Name","Credits Issued","Total Paid","Payment gateway"';
		$cre_sold .= "\n";
		
		$this->credit_sold_details = $this->get_all_transaction_by_transaction_type('purchase_credit',$date_from, $date_to);
		
		if($this->credit_sold_details)
		{
			foreach($this->credit_sold_details as $csr)
			{
				$tdate = $csr->transaction_date;
				$invoice_id = $csr->invoice_id;
				$mem_id = $csr->user_id;
				$mem_det = $this->general->get_member_details_by_user_id($mem_id);
				$mem_name = $mem_det->name;
				$credit_issued = $csr->credit_get;
				$total_paid = $csr->amount;
				$payment_method = $csr->payment_method;
				
				$cre_sold .= '"'.$tdate.'","'.$invoice_id.'","'.$mem_id.'","'.$mem_name.'","'.$credit_issued.'","'.$total_paid.'","'.$payment_method.'"';
				$cre_sold .= "\n";
			}
		}
		else
		{
			$cre_sold .= "No Data found";	
		}

		// Output to browser with appropriate mime type, you choose ;)  
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=credits-sold-report-by-date-".date("Y-m-d").".csv");
	  
		//header("Content-type: text/csv");  
		//header("Content-type: application/csv");
		
		echo $cre_sold;  
		exit;
	}
	
	
	function get_all_transaction_by_transaction_type($transaction_type,$datefrom='',$dateto='')
	{
		$this->db->where('transaction_type',$transaction_type);
		
		if($datefrom!='' && $dateto!='')
		{
			$this->db->where('transaction_date >=',$datefrom);
			$this->db->where('transaction_date <',$dateto);	
		}
		$query = $this->db->get('transaction');
		
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}
	
	function get_todays_payment($payment_method,$date_from='', $date_to='')
	{
		
		$this->db->select_sum('amount');
		$this->db->where('payment_method',$payment_method);
		
		if($date_from !='' && $date_to !='')
		{
			$this->db->where('transaction_date >=',$date_from);
			$this->db->where('transaction_date <',$date_to);	
		}
		else
		{
		$this->db->like('transaction_date',date("Y-m-d"));	
		}
		
		$this->db->where('transaction_status','completed');
		
		$query = $this->db->get('transaction');
		if($query->num_rows() > 0)
		{
		return $query->row();
		}
		return false;
	}
	
	function products_sold_today($date_from="",$date_to="")
	{
		$this->db->select("SUM( quantity ) as totalProducts");
		$this->db->from('product_order');
		$this->db->where('status !=',1);
		
		if($date_from !='' && $date_to !='')
		{
			$this->db->where('order_date >=',$date_from);
			$this->db->where('order_date <',$date_to);	
		}
		else
		{
		$this->db->like('order_date',date("Y-m-d"));
		}
		
		
		$query = $this->db->get();
		
		//echo $this->db->last_query(); exit;
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		return false;
	}
	
	function total_commissions_time_range($date_from="",$date_to="")
	{
		$this->db->select('SUM( quantity * sale_commission ) as totalcommission');
		$this->db->from('product_order');
		
		if($date_from!='' && $date_to!='')
		{
		$this->db->where('order_date >=',$date_from);
	    $this->db->where('order_date <',$date_to);
		}
		else
		{
		$this->db->like('order_date',date("Y-m-d"));
		}
		
		$this->db->where('status !=',1);
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data;
		}
		return false;
	}
	
	function get_total_revenue_sold_credits_byDateRange($transaction_type="",$date_from="",$date_to="")
	{
		$this->db->select('SUM( amount ) as total_amount');
		$this->db->from('transaction');
		$this->db->where('transaction_status','Completed');
		$this->db->where('transaction_type', $transaction_type);
		
		if($date_from != '' && $date_to !='')
		{
		$this->db->where('transaction_date >=',$date_from);
	    $this->db->where('transaction_date <',$date_to);
		}
		else
		{
		$this->db->like('transaction_date',date("Y-m-d"));
		}
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data;
		}
		return false;
	}


}
