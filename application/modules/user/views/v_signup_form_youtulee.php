  <section class="section creator1" id="section0">
      <div class="container">
      <div class="bg_fff small_bg_fff youtulee_form"><h2 class="text-center"><b>Sign up</b></h2>
      <form method="post"   name="registration_youtulee" id="registrationyoutulee" action="">
      <div>
          <input type="text" class="form-control" placeholder="Full Name" name="name">
          <?php echo form_error('name'); ?>
      </div>
      <div>
          <input type="text" class="form-control" placeholder="E-mail" name="email">
          <?php echo form_error('email'); ?>
      </div>
      <div >
          <input type="password" class="form-control" placeholder="Password" name="password">
          <?php echo form_error('password'); ?>
      </div>
      
      <div class="two_col ">
          <input type="text" class="form-control" placeholder="Youtulee Id" name="youtulee_id">
          <?php echo form_error('youtulee_id'); ?>
      </div>
      <div class="two_col right_float">
          <input type="text" class="form-control" placeholder="User Name" name="username">
            <?php echo form_error('username'); ?>
      </div>
      <div class="two_col">
            <input type="text" class="form-control" placeholder="Total Reach" name="total_reach">
              <?php echo form_error('total_reach'); ?>
      </div>
      <div class="two_col right_float">
            <input type="text" class="form-control" placeholder="Average Reach" name="average_reach">
              <?php echo form_error('average_reach'); ?>
      </div>
      <div class="two_col">
           <select name="country" class="form-control">
            <option value="">----Select----</option>
            <?php foreach($country as $countrylis){
                ?>
              <option value="<?php echo $countrylis->country;?>"><?php echo $countrylis->country;?></option>
                <?php 
                }
            ?>
           </select>
              <?php echo form_error('country'); ?>
      </div>
      <div class="two_col right_float">
            <input type="text" class="form-control" placeholder="Ratings" name="ratings">
              <?php echo form_error('ratings'); ?>
      </div>      
      
      
      <div class="checkbox"><label><input type="checkbox" name="terms_condition"> By signing up you confirm that you accept the <a href="#">Terms &amp; Conditions</a></label>
      <?php echo form_error('terms_condition'); ?>
      </div>
      <button type="submit" class="btn btn-info btn-block" id="youtuleeregbtn">Sign up</button>
      </form>
      <!-- <div class="btn-sec text-center">
      <p><b>Already have an account?</b></p>
      <div class=""><a href="login.html" class="btn btn-block btn-default"> Sign in</a></div>
      </div> -->
      <p class="btm text-center">&copy; 2016 popler, LLC.</p>
      </div>
    </div>
    </section>  

    <script>
var urlCheckDuplicateEmail = '<?php echo site_url("user/register/check_email_availability"); ?>';
var checkDuplicateUsername = '<?php echo site_url("user/register/check_username_availability"); ?>';
</script>