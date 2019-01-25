<div class="loginbox">
  <div class="bodysec">
    <header>Foget  Your Pasword</header>
    <?php echo form_open('',array('id' => 'adminForgetForm','autocomplete' => 'off'));  ?>
    <fieldset>
      <?php if($message): ?>
      <div  class="message">
        <p><?php echo $message; ?></p>
      </div>
      <?php endif; ?>
      <p> Your Login details has been sent to your email address. Please check your email and change your password in your first login. </p>
    </fieldset>
    <?php echo form_close(); ?>
    <footer> © <?php echo date('Y'); ?> <a href="<?php echo site_url();?>">BIDCY</a>. ALL RIGHTS RESERVED. </footer>
  </div>
</div>
