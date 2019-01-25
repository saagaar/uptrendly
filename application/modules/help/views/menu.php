<?php //echo $current_menu; ?>

<ul>
    <li <?php echo (@$current_menu == 'all_help')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/help/index');?>"><span>List All Help</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add_help')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/help/add_help');?>"><span>Add Help</span></a>
    </li>
    
     <?php if(@$current_menu == 'edit_help'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/help/edit_help/'.$this->uri->segment(4));?>"><span>Edit Help</span></a>
  	</li>
  	<?php endif; ?>
    
    
                  
</ul>
                    
                              