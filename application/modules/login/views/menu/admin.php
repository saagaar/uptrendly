<ul>
    <li <?php if($current_menu == 'profile'){ echo 'class="active"'; }?>>
        <a href="<?php echo site_url(EXEADMIN_PUBLIC_DIR.'/profile'); ?>"><span>My Profile</span></a>
  </li>
  <li <?php if($current_menu == 'password'){ echo 'class="active"'; }?>>
        <a href="<?php echo site_url(EXEADMIN_PUBLIC_DIR.'/change-password'); ?>"><span>Change Password</span></a>
  </li>  
</ul>