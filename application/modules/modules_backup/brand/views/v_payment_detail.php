<form method="post" id="paymentproceed" action="" name="payment_proceed">
<div class="shipping_detail">
	<div class="shipping_detail_card">
		<div class="ship_prod_title"><h3>Your Current Balance: <span> <?php echo DEFAULT_CURRENCY_SIGN.' '.$balance;?></span></h3></div>
		<?php
		$amount=isset($amount)?$amount:$amount='';
	 	$payamount='';
	 if($this->input->post('amount',true)) $payamount=$this->input->post('amount',true);
			else  $payamount=$amount;
			
			?>
		<div class="ship_prod_detail">
			<ul>
				<input type="hidden" name="transaction_type" value="topup_balance">
				<li><span>Date and Time</span>: 24 feb 2017 14:30</li>
				<li><span>Top up Amount</span>: <?php echo DEFAULT_CURRENCY_SIGN;?> <input type="text" class="form-control" name="amount" id="amount" value="<?php echo $amount;?>"/>
				<?php echo form_error('amount');?>
				</li>	
				<!-- <li><span>Total Price</span>: <?php echo DEFAULT_CURRENCY_SIGN.' '.$balance;?></li>					 -->
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="shipping_detail_card">
		<div class="payment_choice">
			<h4>Choose Payment Method</h4>
			<!-- <div class="col-sm-6">
				<input type="radio" class="radio" name="pay_choice"/>
				<img src="../../upload_files/payment/pym.jpg" alt="">
			</div>	 -->
			<?php
			$no_payment_gate = count($payment_gateway);
			if($no_payment_gate>0)
			{


			 foreach($payment_gateway as $payment){
				?>

				<div class="col-sm-6">
					<input name="payment_type" type="radio" value="<?php echo $payment->id;?>" <?php echo set_radio('payment_type', $payment->id); ?> <?php if($no_payment_gate ==1){echo 'checked="checked"';}?> />
                            <img src="<?php echo site_url(PAYMENT_API_LOGO_PATH	.$payment->payment_logo);?>" alt="<?php echo $payment->payment_gateway;?>">
                            	<?php echo form_error('payment_type');?>
				</div>	
				<?php
				}
				}
				?>
		
			<div class="clearfix"></div>
		</div>
	</div>

 	<div class="shipping_detail_card">
		<div class="ship_info">
<!--			<h4>Shipping Address</h4>
			<div class="form_sec">
			<div class="form-group">
				<div class="col-sm-6">
					<label>Email Address</label>
					<input type="text" class="form-control" />
				</div>
				<div class="col-sm-6">
					<label>Name</label>
					<input type="text" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Address</label>
					<input type="text" class="form-control" />
				</div>
				<div class="col-sm-6">
					<label>Address 2</label>
					<input type="text" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Country</label>
					<input type="text" class="form-control" />
				</div>
				<div class="col-sm-6">
					<label>City</label>
					<input type="text" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Post Code</label>
					<input type="text" class="form-control" />
				</div>
				<div class="col-sm-6">
					<label>Mobile No.</label>
					<input type="text" class="form-control" />
				</div>
			</div>-->
			<div class="col-sm-12">
				<button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check createcheck"></i> Submit</button>
			</div>
			<div class="clearfix"></div>
			</div>
				
		</div>
	</div> 
	</form>
</div>