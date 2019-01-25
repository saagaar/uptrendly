   <!-- Footer--Section -->
 <!--<footer class="footer-fix">-->
 <footer class="footer-fix">
	<div class="footer-top">
    	<div class="container">
        	<div class="row">
            	<aside class="col-md-2 col-sm-6">
                	<div class="title">
                    	<h4>Information</h4>
                        <ul>
                        	<?php 
								$cms = $this->general->get_cms_selected_fields_data(array('1','3','4'),array('cms_slug','heading'));
								if($cms){
									foreach($cms as $data)
									{
									?>
                                    <li>
                                    	<a href="<?php echo site_url('/page/'.$data->cms_slug); ?>">
											<?php echo $data->heading ?>
                                      	</a>
                                  	</li>
                                    <?php
									}
								}	
							?>
                        	<li><a href="<?php echo site_url('/contact-us'); ?>">Contact Us</a></li>
                            <li><a href="<?php echo site_url('/help'); ?>">Help</a></li>
                        </ul>
                    </div>
                </aside>
                <aside class="col-md-2 col-sm-6">
                	<div class="title">
                    	<h4>Auctions</h4>
                        <ul>
                        	<li><a href="#">Plaza</a></li>
                            <li><a href="<?php echo site_url('marketplace-auctions'); ?>">MarketPlace</a></li>
                            <li><a href="#">Galleria</a></li>
                            <li><a href="#">Auction by Category</a></li>
                            <li><a href="#">Auction Catelogs</a></li>
                            <li><a href="#">Auction Schedules</a></li>
                        </ul>
                    </div>
                </aside>
                <aside class="col-md-2 col-sm-6">
                	<div class="title">
                    	<h4>Shipping</h4>
                        <ul>
                        	<li><a href="#">Local Shipping</a></li>
                            <li><a href="#">International Shipping</a></li>
                            <li><a href="#">Returns</a></li>
                        </ul>
                    </div>
                </aside>
                <aside class="col-md-5 col-sm-6">
                	<div class="title">
                    	<h4>Secure Payment & Shipping</h4>
                        <div class="sprite">
                            <div class="vco">
                                <a href="#"></a>
                            </div>
                            <div class="v-card">
                                <a href="#"></a>
                            </div>
                            <div class="visa">
                                <a href="#"></a>
                            </div>
                            <div class="master-card">
                                <a href="#"></a>
                            </div>
                            <div class="mastro">
                                <a href="#"></a>
                            </div>
                            <div class="paypal">
                                <a href="#"></a>
                            </div>
                            <div class="ups">
                                <a href="#"></a>
                            </div>
                             <div class="dhl">
                                <a href="#"></a>
                            </div>
                             <div class="fed">
                                <a href="#"></a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <div class="footer-inner">
    	<div class="container">
        	<div class="row">
            	<aside class="col-md-4 col-sm-5 col-xs-6 connect-responsive">
                    <div class="social-media clearfix">
                         <ul>
                         	<li>Connect with Us</li>
                            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                            <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
                            <li><a href="#"><span class="fa fa-pinterest"></span></a></li>
                        </ul> 
                    </div>
                </aside>
                <aside class="col-md-8 col-sm-7 col-xs-6 connect-responsive">
                    <div class="newsletter pull-right">
                    	<form action="//nepaimpressions.us11.list-manage.com/subscribe/post?u=612f2f96d8424ef19c29c02d8&amp;id=8fb778fc8d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" role="form" novalidate>
                        	<ul>
                            	<li>Sign up for our newsletter</li>
                            	<li>
                                    <div class="form-group inbox">
                                    <input type="email" value="" name="EMAIL" class="form-control" placeholder="email address" required>
                                    </div>
                             	</li>
                             	<li>
                             	    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Sign up</button>
                                        <input type="hidden" name="b_612f2f96d8424ef19c29c02d8_8fb778fc8d" tabindex="-1" value="">
                                    </div>
                            	</li>
                        	</ul>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
    	<div class="container">
        	<div class="row">
            	<aside class="col-md-6 col-sm-6">
                	<p>&copy; 2015 <a href="<?php echo site_url('/'); ?>">Bid<span>warz</span>live</a></p>
                </aside>
                <aside class="col-md-6 col-sm-6">
                	<p class="text-right">Designed By : <a href="http://www.emultitechsolution.com/" target="_blank">Emultitech Solution Pvt Ltd</a></p>
                </aside>
            </div>
        </div>
    </div>
</footer>
    <!-- Close--Footer--Section -->
       
 <!--Display this only in home page if user is not lgged in--> 
 <?php if($this->session->userdata(SESSION.'user_id')){ ?>
 	<div id="changePasswordModal" class="modal fade" role="dialog">
    
    <span class="popp text-center">
        <span class="response_msg text-center" id="changePasswordResponse" style="display:none;">sadfadfasdfasfsadfsadf</span>
    </span>
        
  <div class="modal-dialog edit-modal"> 
    <!-- Modal content-->
    <form method="post" action="" id="changePasswordForm">
      <div class="modal-content">
      
      <div class="modal-body">
      	<div class="row clearfix">
          <div class="col-md-4 col-sm-5">
            <label>Current Password</label>
          </div>
         <div class="col-sm-8 form-group">
            <input type="password" name="password" class="form-control" placeholder="Enter Current Password">
          </div>
          <div class="clearfix"></div>
        </div>
        
        <div class="row clearfix">
          <div class="col-md-4 col-sm-5">
            <label>New Password</label>
          </div>
         <div class="col-sm-8 form-group">
            <input type="password" name="new_password" id="newPassword" class="form-control" placeholder="Enter New Password">
          </div>
          <div class="clearfix"></div>
        </div>
        
        <div class="row clearfix">
          <div class="col-md-4 col-sm-5">
            <label>Retype New Password</label>
          </div>
         <div class="col-sm-8 form-group">
            <input type="password" name="re_new_password" id="reNewPassword" class="form-control" placeholder="Re Enter New Password">
          </div>
          <div class="clearfix"></div>
        </div>
        
        <div class="btn-green form-group">
        	<button type="submit" name="button" id="changePasswordBtn" data-type="add">Change Password</button>
        </div>
      </div>
      </div>
    </form>
  </div>
</div>
<script>var urlChangePassword = '<?php echo site_url('/'.MY_ACCOUNT.'change_pasword/'); ?>';</script>

        
 <?php } else if(!$this->session->userdata(SESSION.'user_id')){ ?>    
   <!-- Modal -->
   <div id="loginSignupModal" class="modal fade" role="dialog">	
    
    	<span class="popp text-center">
        	<span class="response_msg text-center" id="loginRegisterResponse" style="display:none;">sadfadfasdfasfsadfsadf</span>
        </span>
        	
      
      <div class="modal-dialog signup_popup">    	
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
          
          <!-- Sign up. -->
          <div id="sign-up-div" style="display:block;">
              <p class="modal-title text-center">Welcome to
                <h2 class="text-center">Bid<span>Warz</span>Live</h2>
              </p>
                
              <form method="post" action="" enctype="multipart/form-data" id="signUpForm">
                <fieldset>
                 <div class="form-group">
                  <input type="text" class="form-control" name="name" value="" placeholder="Name">
                  <!--<p for="first_name" generated="true" class="text-danger">This field is required</p>-->
                  <?php echo form_error('name'); ?>
                 </div>
                 <div class="form-group">
                  <input type="email" class="form-control" name="email" value="" placeholder="Email">
                   <?php echo form_error('email'); ?>
                </div>
                 <div class="form-group">
                  <input type="password" class="form-control" name="password" value="" placeholder="Password">
                  <?php echo form_error('password'); ?>
                </div>
                 <!--<div class="form-group">
                  <input type="text" class="form-control" name="promo_code" value="" placeholder="Promo Code">
                </div>-->
                <input type="hidden" name="ref" value="<?php if($this->input->get('ref',TRUE)){echo $this->input->get('ref',TRUE);} ?>" />
                <div class="form-group">
                    <button type="submit" class="btn btn_green" id="signUpBtn">Sign up</button>
                     <center>Already have an account? <a href="javascript:void(0)" class="open-sign-in">Sign in</a></center>
                </div>
                </fieldset>
              </form>
         </div>
         
         <!-- Sign in. -->
         <div id="sign-in-div" style="display:none;" class="sigin_popup">
         	<h2 class="text-center">Sign in</h2>
            
            <form method="post" action="" enctype="multipart/form-data" id="signInForm">
                <fieldset>
                 	<div class="form-group has-error">
                  		<input type="email" class="form-control" name="email" value="" placeholder="Email">
                        <?php echo form_error('email'); ?>
                 	</div>
                 	<div class="form-group">
                  		<input type="password" class="form-control" name="password" value="" placeholder="Password">
                        <?php echo form_error('password'); ?>
                	</div>
                 <div class="form-group check_sec">
                  <input type="checkbox" name="rememberme" value="yes"> <span>Remember Me</span>
                 <p class="forgot_pw"><a href="javascript:void(0)" class="open-reset-pw">Forgot / Change your password</a></p>
                 </div>
                 
                 <div class="form-group">
                    <button type="submit" class="btn btn_green" id="signInBtn">Sign in</button>
                     <center>Don't have an account? <a href="javascript:void(0);" class="open-sign-up">Sign up</a></center>
                </div>
                </fieldset>
             </form>
         </div>
         
         
          <!-- Forgot Password. -->
         <div id="reset-password-div" style="display:none;" class="reset_popup">
         	<h2 class="text-center">Reset your password</h2>
            
            <form method="post" action="" enctype="multipart/form-data" id="forgotPasswordForm">
                <fieldset>
                  <div class="form-group">
                  <input type="email" class="form-control" name="email" value="" placeholder="Email">
                 </div>
                 <div class="form-group">
                    <button type="submit" class="btn btn_green" id="forgotPasswordBtn">Reset Password</button>
                     <center><a href="javascript:void(0);" class="open-sign-in">Sign in</a></center>
                </div>
                </fieldset>
             </form>
         </div>
         
          <!-- Reset Success. -->
         <div id="reset-success-div" style="display:none;" class="reset_success_popup">
         	<h2 class="text-center">Your Password Has Been Reset</h2>
            <p class="text-center">An email has been sent to you with the reset password link.</p>
            <center><a href="javascript:void(0)" class="open-sign-in">Sign in</a></center>
         </div>
         
          </div>
          <div class="modal-footer">
          	<a href="javascript:void(0);" onclick="return facebookLogin();" class="btn_fb"><i class="fa fa-facebook"></i>Sign up with <span>Facebook</span></a>
            <?php /*?><a href="<?php echo site_url('/user/twitter/auth') ?>" class="btn_twitter" onclick="return twitterLogin();"><i class="fa fa-twitter"></i>Sign up with <span>Twitter</span></a><?php */?>
            <a href="javascript:void(0)" class="btn_google" onclick="return googlelogin();"><i class="fa fa-google-plus"></i>Sign up with <span>Google</span></a> 
          </div>
        </div>
      </div>
    </div>   
		<script>
            var urlCheckDuplicateEmail = '<?php echo site_url('/user/register/check_email_availability') ?>';
            var urlRegisterNewUser = '<?php echo site_url('/user/register/register_new_user') ?>';
            var urlUserLogin = '<?php echo site_url('/user/login/user_login') ?>';
            var urlForgotPassword = '<?php echo site_url('/user/login/forgot_password') ?>';
            var urlFacebookLogin = '<?php echo site_url("/user/login/facebook_login/");?>';
            var FacebookAppID = '<?php echo FACEBOOK_APP_ID; ?>';
			var urlGoogleLogin = '<?php echo site_url("/user/login/google_login/");?>';
			var googleAppKey = '<?php echo GOOGLE_PLUS_APP_KEY; ?>'; //from site settings
			var googleClientId = '<?php echo GOOGLE_PLUS_APP_CLIENT_ID; ?>'; //from site settings
		</script>
         <?php
		}
	?>
</div>

<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'additional.methods.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'validation.error.messages.js'); ?>"></script>


<?php if($this->session->userdata(SESSION.'user_id')){ ?>
<?php //Buyer ?>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'buyer.general.profile.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'buyer.address.js'); ?>"></script>

<?php //Seller ?>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'seller.policies.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'seller.connections.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'seller.add-edit.inventory.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'seller.host.an.auction.js'); ?>"></script>


<?php //Both seller and buyer ?>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'member.verify.add.paypal.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'member.change.pasword.js'); ?>"></script>

<!--sellers profile page in frontend-->
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'sellers.profile.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'host.auction.accept.terms.js'); ?>"></script>

<!--Auction details page-->
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'auction.detail.js'); ?>"></script>


<?php //inport jquery ui pluginn ?>
<script type="text/javascript" src="<?php echo base_url(JQUERYUI_PATH.'jquery-ui.min.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'jquery-ui.min.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'datepicker.css'); ?>">
<script type="text/javascript" src="<?php echo base_url(JQUERYUI_PATH.'jquery-ui-timepicker-addon.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().JQUERYUI_PATH.'jquery-ui-timepicker-addon.css'; ?>">

<script>
	//initialize date time picker in datepicker and datetimepicker classes
	$('body').on('focus',".datetimepicker", function(){
		$(this).datetimepicker({
			dateFormat: "yy-mm-dd",
			altFieldTimeOnly: false,
			altTimeFormat: "h:m t",
			altSeparator: " @ ",
			//buttonImage: 'http://localhost/bidwarz/themes/jqueryui/images/calendar.gif', 
      		//buttonImageOnly: true
		});
	});
	
	$('body').on('focus',".datepicker", function(){
		$(this).datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
</script>
<?php }else{ if(isset($trigger_login_Popup) && $trigger_login_Popup='yes'){ ?>
<script>
	$(document).ready(function(e){$("#loginSignupModal").modal('show');});
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url().USER_JS_DIR; ?>users.form.validation.js"></script>
<script type="text/javascript" src="<?php echo base_url().USER_JS_DIR; ?>social.login.facebook.js"></script>
<script type="text/javascript" src="<?php echo base_url().USER_JS_DIR; ?>social.login.google.js"></script>
<?php } ?>
</body>
</html>