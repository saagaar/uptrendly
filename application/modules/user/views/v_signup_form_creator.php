 <section class="login-signup" id="section0">
      <div class="container">
   <div class="login-form signup text-center"><h1 class="f-bold mb-30 text-center fs-20">Only takes 30 seconds to join!</h1>
          <!-- Sign up. -->
          <div id="sign-up-div">
             
              <?php
              $name=$this->input->post('name',true);
              $email=$this->input->post('email',true);
              $username=$this->input->post('username',true);
            
              ?>
              <form method="post" action="<?php echo site_url('/user/register/'.$action)?>" id="creatorsignup" enctype="multipart/form-data">
                <fieldset class="row m-0">
                 <div class="form-group col-xs-6">
                  <input type="text" value="" class="form-control"  name="name" placeholder="Name" value="<?php echo $name?>">
                  <!-- <p for="name" generated="true" ></p> -->
                    <?php echo form_error('name'); ?>
                 </div>
                 <div class="form-group col-xs-6">
                  <input type="text" value="" class="form-control" autocomplete="off" name="email" placeholder="Email" value="<?php echo $email?>">
                    <?php echo form_error('email'); ?>
                </div>
                <div class="form-group col-xs-6">
                  <input type="text" value="" class="form-control" autocomplete="off" name="username" placeholder="Username" value="<?php echo $username?>">
                    <?php echo form_error('username'); ?>
                </div>
                 <div class="form-group col-xs-6">
                  <input type="password" value="" class="form-control" autocomplete="off" name="password" placeholder="Password">
                    <?php echo form_error('password'); ?>
                </div>
                <div class="form-group col-xs-6">
                  <input type="text" value="" class="form-control" autocomplete="off" name="instagram_username" placeholder="Instagram Username">
                    <?php echo form_error('instagram_username'); ?>
                </div>
                <div class="form-group col-xs-6">
                  <input type="text" value="" class="form-control" autocomplete="off" name="facebook_profile" placeholder="Facebook Profile Link">
                    <?php echo form_error('facebook_profile'); ?>
                </div>

                <div class="form-group col-xs-12">
                <input type="submit" id="creator_registration" class="btn btn-blue mt-10 mb-20">
                </div>
                </fieldset>
              </form>
         </div>

        <p class="btm">By signing up you confirm that you accept our</a>  <a href="<?php echo site_url('sitesetup/termscondition')?>">Terms & condition.</p>
        <p>© 2017 <a>Uptrendly</a> - All rights reserved.</p>
      </div>
      </div>
</section>

<script>
    var urlCheckDuplicateEmail = '<?php echo site_url("user/register/check_email_availability"); ?>';
    var urlCheckDuplicateUsername = '<?php echo site_url("user/register/check_username_availability"); ?>';
</script>