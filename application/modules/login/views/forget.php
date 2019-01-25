<div class="loginbox">
  <div class="bodysec frgpass">
    <header>Foget  Your Pasword</header>
    <form id="adminForgetForm" autocomplete="off" method="post" >
      <fieldset>
        <?php if($message): ?>
        <div  class="message">
          <p><?php echo $message; ?></p>
        </div>
        <?php endif; ?>
        <ul>
          <li>
            <label>Email: </label>
            <input name="admin_email" type="text"  />
            <?php echo form_error('admin_username'); ?> </li>
          <li>
            <label>Captcha Code: <i></i></label>
            <input name="admin_captcha" type="text" class="captcha">
            <div class="cap_sec"> <span id="admin_captcha_container" class="load_new_captcha"><?php echo $admin_captcha; ?></span> <img id="new_captcha_button" class="load_new_captcha" src="<?php echo base_url().ADMIN_IMG_DIR; ?>reload_orange.gif" alt="Reload Verification code"> </div>
            <div id="admincapcha_error_container"></div>
            <?php echo form_error('admin_captcha'); ?> </li>
          <li> <a href="<?php echo site_url(ADMIN_LOGIN_PATH.''); ?>" class="frgt">Login</a>
            <button type="submit"  >Reset Password</button>
          </li>
        </ul>
      </fieldset>
    </form>
    <footer> &copy; <?php echo date('Y'); ?> <a href="<?php echo site_url();?>">BIDCY</a>. ALL RIGHTS RESERVED. </footer>
  </div>
</div>
