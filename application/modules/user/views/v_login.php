<section class="login-signup">
  <div class="login-form">
    <?php   if($this->session->flashdata('success_message'))
		{
        echo "<div class='alert alert-success text-success'>".$this->session->flashdata('success_message')."</div>";
        } else if($this->session->flashdata('error_message')) {
        echo "<div class='alert alert-danger text-error'>".$this->session->flashdata('error_message')."</div>";
        } ?>
    <form class="col-xs-12" method="post">
      <h1 class="f-bold mb-30 text-center fs-20">Dashboard Login</span></h1>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="E-mail" name="email">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password">
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="">
          <!-- <span class="cr"><i class="cr-icon fa fa-check"></i></span> Remember me</label> -->
      </div>
      <button type="submit" class="btn btn-blue btn-block mt-20 mb-20">Sign in</button>
    </form>
    <div class="text-center col-xs-12">
      <p><a href="<?php echo site_url('user/login/forget')?>">Forgot Password</a><span class="block-ele fs-18 mt-15">Don't have an Account?</span></p>
      <a href="<?php echo site_url('user/register/creator')?>" class="btn btn-white btn-block mb-20 mt-15">Sign up as a Influencer</a> <a href="<?php echo site_url('user/register/brand')?>" class="btn btn-white btn-block mb-20">Sign up as a Advertiser</a>
      <p>© 2017 <a>Uptrendly</a> - All rights reserved.</p>
      <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
  </div>
</section>
