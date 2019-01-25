  <section class="login-signup" id="section0">
    <div class="login-form sign-inf">
      <div class="col-xs-12"><h2 class="text-center"><b>Reset Password</b></h2>
    <?php   if($this->session->flashdata('success_message'))
    {
        echo "<div class='alert alert-success text-success'>".$this->session->flashdata('success_message')."</div>";
        } else if($this->session->flashdata('error_message')) {
        echo "<div class='alert alert-danger text-error'>".$this->session->flashdata('error_message')."</div>";
        } ?>
        <form method="post" class="form-group">
          <label class="forgetp_label">
            Enter your email to reset your password
          </label>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="E-mail" name="email">
          </div>

          <button type="submit" class="btn btn-info btn-block">Reset Password</button>
        </form>

        <div class="btn-sec text-center">
        <div class=""><a href="<?php echo site_url('user/login')?>"> Back to Login</a></div>
        </div>
        <p class="btm text-center">&copy; 2017 <?php echo WEBSITE_NAME;?></p>

      </div>
      <div class="clearfix"></div>
    </div>
  </section>



<!--
<div class="mid-part">

<div class="main-ttl">
<div class="container">
  <h1>Password Recovery</h1>
</div>
<div class="clearfix"></div>
</div>

<div class=" container">
  <div class="reg-inner">
      <h2>Login to The High Tree Group</h2>
        <div class="log-form">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                  <form method="post" action="" enctype="multipart/form-data">
          <fieldset>
                    <?php
                      if($this->session->flashdata('success_message'))
                      {
                        echo "<span class='text-success'>".$this->session->flashdata('success_message')."</span>";
                      } else if($this->session->flashdata('error_message')) {
                        echo "<span class='text-error'>".$this->session->flashdata('error_message')."</span>";
                      }
                    ?>
                <h4><i class="fa fa-user">&nbsp;</i> Enter your email & we will send a new password.</h4>
                <div class="form-group">
                                <label>Email</label>
                <input type="text" name="email" class="form-control">
                <?php echo form_error('email'); ?>
                </div>
                <button type="submit" name="button" class="btn">Send <span>to my account</span></button>
          </fieldset>
        </form>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="gray_box">
                        <p class="b_txt">Not yet registered?</p>
                        <p>Register today...</p>
            <p>It only take's 'two ticks' to register now...</p>
                        <div class="btn_sec"><a href="<?php echo site_url('user/register/buyer'); ?>">Buyer Register</a> <a href="<?php echo site_url('user/register/supplier'); ?>">Supplier Register</a></div>
                    </div>
                </div>
            </div>              
            </div>        
    </div>  
<div class="clearfix"></div>
</div>

<div class="clearfix"></div>
</div>
-->