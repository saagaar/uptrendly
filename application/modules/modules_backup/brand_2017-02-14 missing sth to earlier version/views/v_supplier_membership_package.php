<div class="col-md-8 col-sm-7">
        <div class="log-form">         
        <?php   echo validation_errors();?> 
        <?php if($this->session->flashdata('pay_msg')){
            echo "<div class='alert alert-danger fade in'>
    
    <strong>Error!</strong>  ".$this->session->flashdata('pay_msg').
"</div>";


           }?>   
        <h4>Membership Package</h4>            
        
        <form action="" method="post">
        <?php if($packages) { ?>
            <table class="table table-hover footable">
                <thead>
                    <tr>
                        <th width="5%">Chose one</th>
                        <th data-hide="phone" width="20%">Package Name</th>
                        <th data-hide="phone" width="20%">Price</th>
                        <!-- <th data-hide="phone" width="10%">Status</th> -->
                    </tr>
                </thead>
                <tbody>                
                <?php foreach($packages as $package) {?>
                    <tr>
                        <td><input type="radio" name="package" class="from-control" value="<?php echo $package->id; ?>" /></td>
                        <td><?php echo $package->package_name; ?></td>
                        <td><?php echo $package->cost; ?></td>              
                         <?php echo form_error('package'); ?>          
                    </tr>
                <?php  } ?>
                </tbody>
            </table>
           
            <?php  } else { echo "No Membership packages available"; } ?>
            
            <h4 class="pay_confirm">Choose payment method</h4>

            <div class="row pay_method">
            <?php 
                if($payment_gateways)
                {             
                     $i=0; 
                    foreach($payment_gateways as $payment) {
                         if($i==0) $check="checked='checked'";
                        ?>
                    <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                        <!-- <div class="payment_box"> -->
                            <label for=""><?php echo $payment->payment_gateway;?></label>
                            <span>
                                <input id="payment_type" <?php echo $check;?> name="payment_type" type="radio" value="<?php echo $payment->id;?>" <?php echo set_radio('payment_type', $payment->id); ?> > <figure><img src="<?php echo base_url().PAYMENT_API_LOGO_PATH.$payment->payment_logo;?>"></figure>
                            </span>
                            
                            <p id="ptype"><?php echo form_error('payment_type')?></p>  
                        <!-- </div> -->
                    </div>
            <?php  
            $i++;
                }
                } ?>             
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3 form-group">
            <input type="submit" value="Proceed" class="form-control btn-primary">    
            </div>
            <input type="hidden" name="transaction_type" value="purchase_credit" />       
        </form>
        
         
         </div>
            
        </div>
