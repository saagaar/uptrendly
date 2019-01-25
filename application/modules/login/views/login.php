<div class="loginbox">
<div class="bodysec">
<header>Log in to Admin Panel</header>
<form name="admin_login" action="" method="post" accept-charset="utf-8">
  <fieldset>
  <?php if($this->session->flashdata('message')) { ?>
    <div  class="message"> <?php echo validation_errors(); ?>
      <p>
        <?php if($this->session->flashdata('message')) echo $this->session->flashdata('message');?>
      </p>
    </div>
    <?php } ?>
    <ul>
      <li>
        <label>User Name: </label>
        <input name="username" type="text" />
      </li>
      <li>
        <label>Password: </label>
        <input name="password" type="password" />
      </li>
      
      <li>
        <!-- <a href="<?php echo site_url('login/password/forget');?>" class="frgt">Forgot your password</a> -->
        <button type="submit" >login</button>
      </li>
    </ul>
  </fieldset>
  <footer> &copy; <?php echo date('Y'); ?>  <a href="<?php echo site_url();?>"><?php echo WEBSITE_NAME;?></a>. ALL RIGHTS RESERVED. </footer>
  </div>
  </div>
</form>
