<ul>
    <li <?php echo (@$current_menu == 'ip_list')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/block-ip/index');?>"><span>View Blocked IP</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add_ip')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/block-ip/add_ip');?>"><span>Add IP</span></a>
    </li>
    
     <?php if(@$current_menu == 'edit_ip'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/block-ip/edit_ip/'.$this->uri->segment(4)); ?>"><span>Edit Blocked IP</span></a>
  	</li>
  <?php endif; ?> 
</ul>