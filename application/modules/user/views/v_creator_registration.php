<section class="login-signup">
  <div class="login-form sign-inf">
    <div class="col-xs-12">
      <div class="mb-20 text-center">
        <h1 class="f-bold fs-20">Influencer Sign Up </h1>
        <span class="signup_quote">
          <p class="lead_q">Get top Brand's endorsement campaigns now!</p>
          <p class="follow_q" style="margin-top:5px;"> Choose the platform with greater following for Sign up</p>
        </span>
      </div>
      <div class="social-btn">
        <?php if((defined('YOUTUBE_APP_KEY') && defined('YOUTUBE_APP_SECRET'))):?>
        <a href="<?php echo $yt_url;?>" class="btn btn-danger btn-block mb-15"><i class="fa fa-youtube-play fs-30"></i> Sign up with Youtube</a>
        <?php endif;?>
        <?php if((defined('FACEBOOK_APP_KEY') && defined('FACEBOOK_APP_SECRET'))):?>
        <a href="<?php echo $fb_url;?>" class="btn btn-primary btn-block mb-15"><i class="fa fa-facebook fs-30"></i> Sign up with Facebook</a>
        <?php endif;?>
        <?php if((defined('TWITTER_APP_KEY') && defined('TWITTER_APP_SECRET'))):?>
        <a href="<?php echo $tw_url;?>" class="btn btn-info btn-block mb-15"><i class="fa fa-twitter fs-30"></i> Sign up with Twitter</a>
        <?php endif;?>
        <?php if((defined('INSTAGRAM_APP_KEY') && defined('INSTAGRAM_APP_SECRET'))):?>
        <a href="<?php echo $ins_url;?>" class="btn btn-insta btn-block mb-15"><i class="fa fa-instagram fs-30"></i> Sign up with Instagram</a>
        <?php endif;?>
        <!--  <a href="" class="btn btn-snap btn-block mb-30"><i class="fa fa-snapchat-ghost fs-30"></i> Sign up with Snapchat</a> -->
      </div>  
      <div class="text-center">
       <p><span class="block-ele fs-18 mt-15">Already have an account?</span></p>
        <a href="<?php echo site_url('user/login')?>" class="btn btn-blue btn-block mb-20">Sign in</a>
        <p>© 2017 <a>Uptrendly</a> - All rights reserved.</p>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</section>