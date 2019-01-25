<ul>
	<li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/how-and-why/index/');?>"><span>View All Contents</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='how_it_works')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/how-and-why/index/how_it_works');?>"><span>How It Works Contents</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'all' && $this->uri->segment('4')=='why_reverse_auction')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/how-and-why/index/why_reverse_auction');?>"><span>Why Reverse Auction Contents</span></a>
    </li>
    
    
    <li <?php echo (@$current_menu == 'add')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/how-and-why/add_cms');?>"><span>Add Content</span></a>
    </li>
    
    <?php if(@$current_menu == 'edit'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/how-and-why/edit/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6)); ?>"><span>Edit Content</span></a>
    </li>
    <?php endif; ?>     
                        
</ul>
                    
                              