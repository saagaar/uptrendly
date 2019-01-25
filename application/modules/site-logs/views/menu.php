<ul>
    <li <?php echo ($current_menu == 'all')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/index');?>"><span>Admins Activity Log</span></a>
    </li>
    <?php if($current_menu == 'log_detail'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/site_log_detail/'.$log_id); ?>"><span>View Detail</span></a>
    </li>
    <?php endif; ?>
    <li <?php echo ($current_menu == 'invalid-login')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/invalid_login');?>"><span>Invalid Login</span></a>
    </li>
      <?php if($current_menu == 'detail'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/invalid_login_detail/'.$log_id); ?>"><span>View Detail</span></a>
    </li>
    <?php endif; ?>                   
</ul>
                    
                              