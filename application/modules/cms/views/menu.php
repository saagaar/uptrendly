<ul>
	<li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/index/');?>"><span>View All CMS Pages</span></a>
    </li>
    
    <!-- <li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='system')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/index/system');?>"><span>System CMS Pages</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='website')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/index/website');?>"><span>Website CMS Pages</span></a>
    </li> -->
    
    
    <li <?php echo (@$current_menu == 'add')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/add_cms');?>"><span>Add CMS Page</span></a>
    </li>
    
    <?php if(@$current_menu == 'edit'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/edit/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>"><span>Edit CMS</span></a>
    </li>
    <?php endif; ?>     
                        
</ul>
                    
                              