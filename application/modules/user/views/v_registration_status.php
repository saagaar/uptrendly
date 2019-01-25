 <?php if(($this->session->userdata('registration_error')!=false) && $this->session->userdata('registration_error')!=''){
  ?>
 <section class="section creator1" id="section0">
      <div class="container">
      <div class="login-form signup text-center"><h1 class="f-bold mb-30 text-center fs-20"><?php echo WEBSITE_NAME;?></h1>     
      <h5>We've encountered an error with the account you were trying to link.</h5>
      <div class="row form-group">
      	<ul class="text-red text-danger"><li>You must have at least 

         <?php   $media= strtolower($this->session->userdata('registration_error'));
       
         if($media=='facebook')
         {
           echo  '1 Facebook page with over '.FACEBOOK_LEAST_FAN_COUNT .' likes.';
         }
          if($media=='twitter' || $media=='tumblr' || $media=='youtulee' || $media=='instagram')
         {
            echo '1 '.ucfirst($media).' account with over '.constant(strtoupper($media.'_least_fan_count')) .' Followers.';
         }
         if($media=='youtube')
         {
            echo '1 '.ucfirst($media).' account with over '.constant(strtoupper($media.'_least_fan_count')) .' Subscribers.';
         }
         
         ?>

        </li></ul>
      </div>
       
      <p>Please <a href="<?php echo site_url('user/register/creator');?>" rel="nofollow" target="_self" class="font-bold">go back</a> and choose a different account.</p>
      <p>If you feel that you have seen this message in error, please contact support at <a href="mailto:<?php echo CONTACT_EMAIL?>"><?php echo CONTACT_EMAIL?></a></p>

      <p class="btm">&copy;  <?php echo date('Y');?> Uptrendly </p>
      </div>
    </div>
    </section>  
    <?php 

  }
  else{
    ?>
<section class="login-signup" id="section0">
      <div class="container ">
      <div class="login-form signup text-center"><h1 class="f-bold mb-30 text-center fs-20" ><?php echo WEBSITE_NAME;?></h1>
      
      <p><b>You have successfully registered to our system</b></p>
      <div class="row form-group">
        <ul class="text-red text-danger"><li>
    <?php if(NEED_USER_ACTIVATION=='0')
      echo 'You must verify your email to get access to the system.Please look at the email we have send.';
      else echo 'You will be active after Admin verification.'; ?>

        </li></ul>
      </div>
       
      <!-- <p>Please <a href="<?php echo site_url('user/register/creator');?>" rel="nofollow" target="_self" class="font-bold">go back</a> and choose a different account.</p> -->
      <p>If you feel that you have seen this message in error, please contact support at <a href="mailto:<?php echo CONTACT_EMAIL?>"><?php echo CONTACT_EMAIL?></a></p>

      <p class="btm">&copy; <?php echo date('Y');?> Uptrendly</p>
      </div>
    </div>
    </section>  
    <?php
  }

  ?>