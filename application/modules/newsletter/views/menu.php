<ul>
    <li <?php echo (@$current_menu == 'Send')?'class="active"':''?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/newsletter/send/');?>"><span>Send Newsletters</span></a>
    </li>
	<li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/newsletter/view/');?>"><span>View All Newsletters</span></a>
    </li>
    <li <?php echo (@$current_menu == 'add')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/newsletter/add');?>"><span>Add Newsletter</span></a>
    </li>
    
    <?php if(@$current_menu == 'edit'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/newsletter/edit/'.$this->uri->segment(4)); ?>"><span>Edit Newsletter</span></a>
    </li>
    <?php endif; ?>     
                        
</ul>



                    
                              