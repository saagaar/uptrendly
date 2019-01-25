<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adaptivepaypal_ipn extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('paypal_module');
		define("DEBUG", 1);
		define("USE_SANDBOX", 1);
		define("LOG_FILE", "ipn.log");
	}
	
    public function index() {
		
       $raw_post_data = file_get_contents('php://input');
	   
		$raw_post_array = explode('&', $raw_post_data);
		//@mail('binita_thakur@yahoo.com','DATAs ',$raw_post_data);
		
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
			
		//@mail('binita_thakur@yahoo.com',' Query ',$this->paypal_module->get_transaction_data(23539));
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		 }
		 
		 @mail('ktm.test@yahoo.com','post data ',$req);
		 
		  $post_array = $this->decodePayPalIPN($req);
		  
		   //@mail('binita_thakur@yahoo.com','LIST DATA ',$post_array);

        if(isset($post_array['sender_email'])) {
            $sender_email = $post_array['sender_email'];
        }
		
		if(isset($post_array['verify_sign'])) {
            $verify_sign = $post_array['verify_sign'];
        }
		
        if(isset($post_array['status'])) {
            $status = $post_array['status'];
        }
        if(isset($post_array['payment_request_date'])) {
            $payment_request_date = $post_array['payment_request_date'];
        }
		
		 if(isset($post_array['transaction_type'])) {
            $payment_transaction_type = $post_array['transaction_type'];
        }
		
        if(isset($post_array['transaction'][0]['receiver'])) {
            $receiver0 = $post_array['transaction'][0]['receiver'];
        }
        /*if(isset($post_array['transaction'][1]['receiver'])) {
            $receiver1 = $post_array['transaction'][1]['receiver'];
        }*/
        if(isset($post_array['transaction'][0]['id'])) {
            $id0 = $post_array['transaction'][0]['id'];
        }
        /*if(isset($post_array['transaction'][1]['id'])) {
            $id1 = $post_array['transaction'][1]['id'];
        }*/
        if(isset($post_array['transaction'][0]['invoiceId'])) {
            $invoiceId0 = $post_array['transaction'][0]['invoiceId'];
        }
        /*if(isset($post_array['transaction'][1]['invoiceId'])) {
            $invoiceId1 = $post_array['transaction'][1]['invoiceId'];
        }*/
        /*if(isset($post_array['transaction'][0]['amount'])) {
            $amount0 = $post_array['transaction'][0]['amount'];
        }*/
        /*if(isset($post_array['transaction'][1]['amount'])) {
            $amount1 = $post_array['transaction'][1]['amount'];
        }*/
        if(isset($post_array['transaction'][0]['status'])) {
            $status0 = $post_array['transaction'][0]['status'];
        }
        /*if(isset($post_array['transaction'][1]['status'])) {
            $status1 = $post_array['transaction'][1]['status'];
        }*/
        if(isset($post_array['transaction'][0]['id_for_sender_txn'])) {
            $id_for_sender_txn0 = $post_array['transaction'][0]['id_for_sender_txn'];
        }
        /*if(isset($post_array['transaction'][1]['id_for_sender_txn'])) {
            $id_for_sender_txn1 = $post_array['transaction'][1]['id_for_sender_txn'];
        }*/
        if(isset($post_array['transaction'][0]['status_for_sender_txn'])) {
            $status_for_sender_txn0 = $post_array['transaction'][0]['status_for_sender_txn'];
        }
        /*if(isset($post_array['transaction'][1]['status_for_sender_txn'])) {
            $status_for_sender_txn1 = $post_array['transaction'][1]['status_for_sender_txn'];
        }*/
        if(isset($post_array['transaction'][1]['pending_reason'])) {
            $pending_reason0 = $post_array['transaction'][1]['pending_reason'];
        }
        /*if(isset($post_array['transaction'][1]['pending_reason'])) {
            $pending_reason1 = $post_array['transaction'][1]['pending_reason'];
        }*/
	   
			// Post IPN data back to PayPal to validate the IPN data is genuine
			// Without this step anyone can fake IPN data
			if(USE_SANDBOX == true) {
				$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			} else {
				$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
			}
			$ch = curl_init($paypal_url);
			if ($ch == FALSE) {
				return FALSE;
			}
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			if(DEBUG == true) {
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
			}
		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		//$cert = __DIR__ . "./cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		$res = curl_exec($ch);
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {	
				error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
			}
			curl_close($ch);
			exit;
		} else {
				// Log the entire HTTP response if debug is switched on.
				if(DEBUG == true) {
					error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
					error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
				}
				curl_close($ch);
		}
	// Inspect IPN validation result and act accordingly
	// Split response headers and payload, a better way for strcmp
	$tokens = explode("\r\n\r\n", trim($res));
	$res = trim(end($tokens));
	if (strcmp ($res, "VERIFIED") == 0) {
		
		@mail('binita_thakur@yahoo.com','IPN VERIFIED',$res);
		
		// check whether the payment_status is Completed
			if($post_array['status']=='COMPLETED'){
				
				@mail('binita_thakur@yahoo.com','TXN Completed',$post_array['status']);
				// get primary receiver imformation
				/*$invoice = $post_array['transaction'][0]['invoiceId'];
				$status = $post_array['transaction'][0]['status'];*/
				$currencyamount =  $post_array['transaction'][0]['amount'];
				$newamt = explode(' ',$currencyamount);
				$currency =  $newamt[0];
				$amount0 = $newamt[1];
				//$txn_id = $post_array['transaction'][0]['id_for_sender_txn'];
				//$txn_status = $post_array['transaction'][0]['status_for_sender_txn'];
				//$pending_reason =  $post_array['transaction'][0]['pending_reason'];
				
				
				$this->payment_receiver = $this->account_module->get_payment_gateway_byid('1');
				$account_receiver_email = $this->payment_receiver->email;
			
			//check that receiver_email is your PayPal email	
			if($account_receiver_email==$receiver0){
				@mail('binita_thakur@yahoo.com','Receiver Email',$account_receiver_email.' - '.$receiver0);
		        $this->get_txn_data = $this->paypal_module->get_transaction_data($invoiceId0);
								
							//check empty value
							if($this->get_txn_data)
							{
								 // check txn amount is correct
							if($this->get_txn_data->amount == $amount0)
								{					
									
									if($this->get_txn_data->transaction_type == 'pay_for_cart_item')
								    {									
																	
										$data=array('gross_amount'=>$amount0,'receiver_email'=>$receiver0,
													'transaction_status'=>'Completed','pending_reason'=>$pending_reason0,
													'payment_date'=>$payment_request_date,
													'tax'=>'','mc_currency'=>'','txn_id'=>$id0,
													'txn_type'=>'Adaptive Payment PAY','payer_email'=>$sender_email,
													'payer_status'=>$status_for_sender_txn0,'payment_type'=>'','notify_version'=>'UNVERSIONED',
													'verify_sign'=>$verify_sign,'date_creation'=>'');																
										$this->db->where('invoice_id', $invoiceId0);
										$this->db->update('emts_transaction', $data); 
										
										
										$this->payment_status = 2;
									$this->paypal_module->update_sales_payment_status($this->payment_status, $this->get_txn_data->order_id, $this->get_txn_data->user_id);
									
									//update product table 
									//(we dont have product_id in transaction table, so take product id from sales order table)
									$this->paypal_module->update_product_table($this->get_txn_data->order_id);
									
									//delete cart items from product_cart of this particular user
									 $this->account_module->delete_cart_items_by_user_id($this->get_txn_data->user_id);
																
									//now send email to user to inform that his/her payment is completed
									$this->account_module->send_payment_status_email_to_buyer($this->get_txn_data->user_id, $this->get_txn_data->order_id, $invoiceId0, $this->get_txn_data->amount, 'Paypal');
									
									//send email to admin to inform that a product has been sold.
									$this->account_module->product_sold_notification_admin($this->get_txn_data->user_id, $this->get_txn_data->order_id, $invoiceId0, $this->get_txn_data->amount, 'Paypal');
																		
									//send email to all the sellers to inform that their product has been sold .
									$this->account_module->product_sold_notification_sellers($this->get_txn_data->user_id, $this->get_txn_data->order_id, $invoiceId0, 'Paypal');
										
									} 
									else if($this->get_txn_data->transaction_type == 'purchase_credit')
									{	
										//$this->send_test_email('Inside Pay For credit pack', $post_string);
										//update transaction records
										$data=array('gross_amount'=>$amount0,'receiver_email'=>$receiver0,
													'transaction_status'=>'Completed','pending_reason'=>$pending_reason0,
													'payment_date'=>$payment_request_date,
													'tax'=>'','mc_currency'=>'','txn_id'=>$id0,
													'txn_type'=>'Adaptive Payment PAY','payer_email'=>$sender_email,
													'payer_status'=>$status_for_sender_txn0,'payment_type'=>'','notify_version'=>'UNVERSIONED',
													'verify_sign'=>$verify_sign,'date_creation'=>'');																
										$this->db->where('invoice_id', $invoiceId0);
										$this->db->update('emts_transaction', $data); 
											
										//update user balance
										$this->new_balance = $this->paypal_module->update_user_balance($this->get_txn_data->credit_get, $this->get_txn_data->user_id);
										//update transaction table for current balance
										$this->account_module->update_txn_current_balance($this->new_balance, $invoiceId0);
									}
									else if($this->get_txn_data->transaction_type == 'pay_for_product_listing')
									{
									
										//update transaction records
										$data=array('gross_amount'=>$amount0,'receiver_email'=>$receiver0,
													'transaction_status'=>'Completed','pending_reason'=>$pending_reason0,
													'payment_date'=>$payment_request_date,
													'tax'=>'','mc_currency'=>'','txn_id'=>$id0,
													'txn_type'=>'Adaptive Payment PAY','payer_email'=>$sender_email,
													'payer_status'=>$status_for_sender_txn0,'payment_type'=>'','notify_version'=>'UNVERSIONED',
													'verify_sign'=>$verify_sign,'date_creation'=>'');																
										$this->db->where('invoice_id', $invoiceId0);
										$this->db->update('emts_transaction', $data); 
	
										//update product table to change product status to approved
										$this->account_module->change_product_status_to_approved($this->get_txn_data->product_id);
	
										//send email to admin to inform that a product has been listed.
										$this->account_module->listing_fee_payment_notification_admin($this->get_txn_data->user_id, $invoiceId0, $this->get_txn_data->product_id, 'Paypal');
										
										//send status email to seller
										$this->account_module->listing_fee_payment_notification_seller($this->get_txn_data->user_id, $invoiceId0, $this->get_txn_data->product_id, 'Paypal');	
									}
									elseif($this->get_txn_data->transaction_type == 'pay_for_won_auction')
										{	
														
										//update transaction records
										$data=array('gross_amount'=>$amount0,'receiver_email'=>$receiver0,
													'transaction_status'=>'Completed','pending_reason'=>$pending_reason0,
													'payment_date'=>$payment_request_date,
													'tax'=>'','mc_currency'=>'','txn_id'=>$id0,
													'txn_type'=>'Adaptive Payment PAY','payer_email'=>$sender_email,
													'payer_status'=>$status_for_sender_txn0,'payment_type'=>'','notify_version'=>'UNVERSIONED',
													'verify_sign'=>$verify_sign,'date_creation'=>'');																
										$this->db->where('invoice_id', $invoiceId0);
										$this->db->update('emts_transaction', $data); 
										
										//update user product order table for payment status
										$this->paypal_module->update_product_order_for_won_auction(2, $this->get_txn_data->order_id, $this->get_txn_data->user_id);
																		
										}
									$this->db->trans_complete(); //transaction end
									
								} // amount
							} //txn data
				 } //receiver email
			}
		// check whether the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment and mark item as paid.
		// assign posted variables to local variables
		//$item_name = $_POST['item_name'];
		//$item_number = $_POST['item_number'];
		//$payment_status = $_POST['payment_status'];
		//$payment_amount = $_POST['mc_gross'];
		//$payment_currency = $_POST['mc_currency'];
		//$txn_id = $_POST['txn_id'];
		//$receiver_email = $_POST['receiver_email'];
		//$payer_email = $_POST['payer_email'];
		
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
		}
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
			}
		}
		
	}
	
	function decodePayPalIPN($raw_post_data)
    {
        //log_message('error', "testing");
		//@mail('binita_thakur@yahoo.com','IPN Decode',$raw_post);
        if (empty($raw_post_data)) {
            return array();
        } 
		
        $post = array();
        $pairs = explode('&', $raw_post_data);
		//@mail('binita_thakur@yahoo.com','2 IPN Decode',$pairs);
        foreach ($pairs as $pair) {
            list($key, $value) = explode('=', $pair, 2);
            $key = urldecode($key);
            $value = urldecode($value);
            # This is look for a key as simple as 'return_url' or as complex as 'somekey[x].property'
            preg_match('/(\w+)(?:\[(\d+)\])?(?:\.(\w+))?/', $key, $key_parts);
			
            switch (count($key_parts)) {
                case 4:
				//@mail('binita_thakur@yahoo.com','CAse 4',count($key_parts));
                    //# Original key format: somekey[x].property
                   // # Converting to $post[somekey][x][property]
                    if (!isset($post[$key_parts[1]])) {
                        $post[$key_parts[1]] = array($key_parts[2] => array($key_parts[3] => $value));
                    } else if (!isset($post[$key_parts[1]][$key_parts[2]])) {
                        $post[$key_parts[1]][$key_parts[2]] = array($key_parts[3] => $value);
                    } else {
                        $post[$key_parts[1]][$key_parts[2]][$key_parts[3]] = $value;
                    }
					//@mail('binita_thakur@yahoo.com','44 IPN Decode', $value);
                    break;
                case 3:
                    //# Original key format: somekey[x]
                   // # Converting to $post[somkey][x] 
                    if (!isset($post[$key_parts[1]])) {
                        $post[$key_parts[1]] = array();
                    }
                    $post[$key_parts[1]][$key_parts[2]] = $value;
					//@mail('binita_thakur@yahoo.com','55 IPN Decode', $value);
                    break;
                default:
                   // # No special format
                    $post[$key] = $value;
					//@mail('binita_thakur@yahoo.com','55 IPN Decode', $value);
                    break;
            }//#switch
        }//#foreach
		//@mail('binita_thakur@yahoo.com','33 IPN Decode post',$post);
        return $post;
    }//#decodePayPalIPN()

}
?>