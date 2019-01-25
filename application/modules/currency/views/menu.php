<ul>
	<li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/currency/index/');?>"><span>View All Currency</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/currency/add');?>"><span>Add Currency</span></a>
    </li>
    
    <?php if(@$current_menu == 'edit'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/currency/edit/'.$this->uri->segment(4)); ?>"><span>Edit Currency</span></a>
    </li>
    <?php endif; ?>     
                        
</ul>
                    
                              