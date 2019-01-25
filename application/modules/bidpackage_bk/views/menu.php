<ul>
	<li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/bidpackage/index/');?>"><span>View All Bidpackage</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/bidpackage/add');?>"><span>Add Bidpackage</span></a>
    </li>
    
    <?php if(@$current_menu == 'edit'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/bidpackage/edit/'.$this->uri->segment(4)); ?>"><span>Edit Bidpackage</span></a>
    </li>
    <?php endif; ?>     
                        
</ul>
                    
                              