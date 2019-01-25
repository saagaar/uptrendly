<section class="mid_part">
  <div class="container">
    <div class="white_box">
      <div class="row">
        <aside class="col-md-6 col-sm-5">
          <div class="product_img">
            <figure><img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'live_'.$product->image); ?>"></figure>
          </div>
        </aside>
        <aside class="col-md-6 col-sm-7 product_info">
          <h2><?php echo $product->name; ?></h2>
          
          <?php if(isset($static_field['buy_now_price']) && $static_field['buy_now_price']['display']=='1'){ ?>
          <p><?php echo $static_field['buy_now_price']['field_label']; ?> : <span><?php echo DEFAULT_CURRENCY_SIGN.$product->buy_now_price; ?></span></p>
          <?php } ?>
			
          <?php if(isset($static_field['shipping_charge']) && $static_field['shipping_charge']['display']=='1'){ ?>
          <p><?php echo $static_field['shipping_charge']['field_label']; ?> : <span><?php echo DEFAULT_CURRENCY_SIGN.$product->shipping_charge; ?></span></p>
          <?php } ?>
                    
          <p>Total Payable Amount: <span><?php echo DEFAULT_CURRENCY_SIGN.($product->buy_now_price + $product->shipping_charge); ?></span></p>
        </aside>
        <div class="clearfix"></div>
        <div class="shipping_info">
          <form method="post" action="" enctype="multipart/form-data">
            <h3>Shipping Address</h3>
            <ul>
            <div class="row">
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php if(!empty($address)){echo $address->first_name;} ?>">
                <?php echo form_error('first_name'); ?>
              </li>
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php if(!empty($address)){echo $address->last_name;} ?>">
                <?php echo form_error('last_name'); ?>
              </li>
              </div>
              <div class="row">
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>Address 1</label>
                <input type="text" name="address1" class="form-control" value="<?php if(!empty($address)){echo $address->street_adress_1;} ?>">
                <?php echo form_error('address1'); ?>
              </li>
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>Address 2</label>
                <input type="text" name="address2" class="form-control" value="<?php if(!empty($address)){echo $address->street_adress_2;} ?>">
              </li>
              </div>
              <div class="row">
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="<?php if(!empty($address)){echo $address->city;} ?>">
                <?php echo form_error('city'); ?>
              </li>
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>Post Code</label>
                <input type="text" name="post_code" class="form-control" value="<?php if(!empty($address)){echo $address->post_code;} ?>">
                <?php echo form_error('post_code'); ?>
              </li>
              </div>
              <div class="row">
              <li class="col-md-6 col-sm-6 col-xs-12">
                <label>Country</label>
                <?php
					$selected_country = '';// $profile->country;
					if($this->input->post('country',TRUE)){
						$selected_country = $this->input->post('country',TRUE);
					}else if(!empty($address)){
						$selected_country = $address->country;
					}
					
					$country_arr = array();
					$country_arr[''] = "Choose Country";
					foreach($countries as $country)	
					{
						$country_arr[$country->id] = $country->country;
					}
					echo form_dropdown('country', $country_arr, $selected_country,"class='form-control' onchange='return getMyStates(this);'");
					echo form_error('country');
				?>
              </li>
              
              <?php if(!empty($address) && $address->state!=''){ ?>
                  <li class="col-md-6 col-sm-6 col-xs-12" id="stateField">
                  	<label>State/Region</label>
                	<input type="text" name="state" class="form-control" value="<?php if(!empty($address)){echo $address->state;} ?>">
                	<?php echo form_error('state'); ?>
                  </li>
                  </div>
			  <?php }else{ ?>
              <div class="row">
                  <li class="col-md-6 col-sm-6 col-xs-12" id="stateField" style="display:none;">
                  
                  </li>
              </div>    
			  <?php } ?>
              
              <div class="clearfix"></div>
            </ul>
            
            <h3>Payment</h3>
            <?php
			if($payment_gateways)
			{
		  		if(count($payment_gateways)>1)
				{
					$i=1;
					?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	<?php foreach($payment_gateways as $payment){ ?>
                        	<input type="radio" name="payment_gateway" value="<?php echo $payment->payment_gateway; ?>" <?php if($i==1){echo 'checked="checked"';} ?>> <?php echo $payment->payment_gateway; ?>
                        	<figure><img src="<?php echo site_url($payment->payment_logo); ?>" alt="pay now" /></figure>
                        <?php 
						$i++;
						}
					?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
				}
				else
				{
					foreach($payment_gateways as $payment)
					{
						?>
                        <input type="hidden" name="payment_gateway" value="<?php echo $payment->payment_gateway ?>" />
                        <figure><img src="<?php echo site_url($payment->payment_logo); ?>" alt="payment" /></figure>
                        <?php
					}
				}
				?>
                <input type="hidden" name="transaction_type" value="pay_for_buy_now_product" />
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
          		<div class="btn-green"><button type="submit">Pay Now</button></div>
          		<div class="clearfix"></div>
                <?php
			}
		?>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>

<script>
	var urlGetStatesByCountry = '<?php echo site_url('/'.MY_ACCOUNT.'get_regions_by_country_id') ?>';
</script>

<script>
function getMyStates(obj){
	//console.log(type);
	//console.log(obj.value);
    var country = obj.value;
    if (country != '') {
        $.ajax({
            type: 'POST',
            url: urlGetStatesByCountry,
            dataType: 'html',
            data: {
                country_id: country,
				data_for: 'checkout'
            },
            success: function(data) {
                //alert(data);
				//console.log(data);
				$('#stateField').css('display','block');
				$('#stateField').html(data);
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                /*$('#waiting').hide(500);
				$('#message').removeClass().addClass('error').text('There was an error.').show(500);
				$('#demoForm').show(500);  */
                alert('error');
            }
        });
    }
}
</script>
