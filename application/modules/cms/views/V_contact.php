
<div class="mid-part">

<div class="main-ttl">
<div class="container">
	<h1>Contact</h1>
</div>
<div class="clearfix"></div>
</div>

<div class=" container">
	<div class="reg-inner">
    	<h2>Contact</h2>
        <p>For any queries.Please leave a short message</p> 
		<!-- <p><strong>Register now it will only take a minute.</strong></p> -->

		<b>(<em>*</em> ) is mandatory field.</b>
        
        <div class="log-form">
            	<form id="contact_forms" method="post" action="<?php echo base_url().'cms/submitcontact'?>">
					<fieldset>
						<?php if($this->session->flashdata('success_message')) {
							echo  "<span class='text-success'>".$this->session->flashdata('success_message')."</span>";
						} else if($this->session->flashdata('error_message')) {
							echo  "<span class='text-danger'>".$this->session->flashdata('error_message')."</span>";
						}
						?>
						<!-- <h4><i class="fa fa-user">&nbsp;</i> Contact</h4> -->
							<div class="row">
							 <div class="col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
                                <label><em>*</em> Name</label>
								<input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>">
                                <?php echo form_error('name'); ?>
								</div>
							
								
								<div class="form-group">
                                <label><em>*</em> Contact Number</label>
								<input type="text" name="contactno" class="form-control" value="<?php echo set_value('contactno'); ?>">
								<?php echo form_error('contactno'); ?>
								</div>

								<div class="form-group">
                                <label><em>*</em> Email</label>
								<input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>">
								<?php echo form_error('email'); ?>
								</div>
							
								<div class="form-group txtar">
                                 <label>Message <span class="req">*</span> :</label>
            						<textarea name="message" cols="35" rows="5" class="form-control" 	></textarea>
								<?php echo form_error('message'); ?>
								</div>
							
                            
                            <!-- <h4><i class="fa fa-sign-in">&nbsp;</i> Login Details</h4> -->
							<!-- <div class="row">
								<div class="form-group">
                                <label><em>*</em> User Name</label>
								<input type="text" name="username" class="form-control" value="<?php echo set_value('username'); ?>">
								<?php echo form_error('username'); ?>
								</div>
								<div class="form-group">
                                <label><em>*</em> Password</label>
								<input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>">
								<?php echo form_error('password'); ?>
								</div>
							</div> -->
                            
                            <!-- <div class="form-group terms">
                            	<input type="checkbox" name="terms_conditions"><span>By proceeding, you agree to the High Tree Group <a href="<?php if($terms_condition) {echo site_url('/page/').'/'.$terms_condition->cms_slug;} else {echo '#';} ?>">Terms & Conditions</a>.</span><br />
                            	<?php echo form_error('terms_conditions'); ?>
                            </div> -->
							
                          <button id="btnctactform" type="submit" name="button" class="btn">Send</button>
                          </div>
                          	 	<div class="col-md-6 col-sm-6 col-xs-12">
                         <h4><i class="fa fa-info-circle">&nbsp;</i> Contact Details</h4>
                            <p><b>The High Tree Group B&B Company , 1234 address name , 123 456 7890 / your city name, Country 01234, <a href="#">info@yourdomain.com</a></b></p>
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope"></i> contact@hightreegroup.com</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>  +977 - 9230-3415</a></li>
                                <li><a href="#"><i class="fa fa-skype"></i>  hightreegroup</a></li>
                           </ul>
                           <summary>
                             We'll get back to you within one business day. You can also call ua at +977 - 1234567890 or Email at <a href="#">info@yourdomain.com</a>
                           </summary>
                           
                        </div>
                          	 
                            </div>
					</fieldset>
				</form>
            </div>
        
    </div>
	
<div class="clearfix"></div>
</div>

<div class="clearfix"></div>
</div>