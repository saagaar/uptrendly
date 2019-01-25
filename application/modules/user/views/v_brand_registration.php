<?php echo validation_errors();?>
<section class="login-signup">
  <div class="login-form signup">
    <h1 class="f-bold mb-30 text-center fs-20">Sign Up, It's Free!</span></h1>
    <form method="post" action="" id="brand_registration">
      <div class="row m-0">
        <div class="form-group col-xs-6">
          <label>Brand Name</label>
          <input type="text" name="brand_name" class="form-control" placeholder="" value="<?php echo $this->input->post('brand_name');?>">
          <?php echo form_error('brand_name'); ?> </div>
        <div class="form-group col-xs-6">
          <label>Brand Url</label>
          <input type="text" name="brand_url" class="form-control" placeholder="www.brand.com." value="<?php echo $this->input->post('brand_url');?>">
          <?php echo form_error('brand_url'); ?> </div>
      </div>
      <div class="row m-0">
        <div class="form-group col-xs-6">
          <label>Full Name</label>
          <input type="text" name="name" class="form-control" placeholder="" value="<?php echo $this->input->post('name');?>">
          <?php echo form_error('name'); ?> </div>
        <div class="form-group col-xs-6">
          <label>Username</label>
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $this->input->post('username');?>">
          <?php echo form_error('username'); ?> </div>
      </div>

      <div class="row m-0">
        <div class="form-group col-xs-6">
          <label>Email</label>
          <input type="text" name="email" class="form-control" placeholder="" value="<?php echo $this->input->post('email');?>">
          <?php echo form_error('email'); ?> </div>
        <div class="form-group col-xs-6">
          <label>Office/Personal Phone</label>
          <input type="text" name="phone" class="form-control" placeholder="" value="<?php echo $this->input->post('phone');?>">
          <?php echo form_error('phone'); ?> </div>
      </div>
      <div class="row m-0">
        <div class="form-group col-xs-6">
          <label>Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="">
          <?php echo form_error('password'); ?> </div>
        <div class="form-group col-xs-6">
          <label>Confirm Password</label>
          <input type="password" name="cpassword" class="form-control" placeholder="">
          <?php echo form_error('password'); ?> </div>
      </div>
      <div class="col-xs-12">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="terms_condition">
            <span class="cr"><i class="cr-icon fa fa-check"></i></span> By signing up you confirm that you accept the <a href="<?php echo site_url('/page/terms-and-conditions');?>">Terms & Conditions.</a> <?php echo form_error('terms_condition'); ?> </label>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-blue mt-10 mb-20" id="brandregbtn">Sign up</button>
        </div>
      </div>
    </form>
    <div class="text-center">
      <p><span class="block-ele fs-18 mt-15">Already have an account?</span></p>
      <a href="<?php echo site_url('user/login')?>" class="btn btn-blue mb-20">Sign in</a>
      <p>© 2017 <a>Uptrendly</a> - All rights reserved.</p>
    </div>
  </div>
</section>
<script>
    var urlCheckDuplicateEmail = '<?php echo site_url("user/register/check_email_availability"); ?>';
    var urlCheckDuplicateUsername = '<?php echo site_url("user/register/check_username_availability"); ?>';
</script> 
