<ul>
    <li <?php echo (@$current_menu == 'all' && ($this->uri->segment(4)=='1') OR ($this->uri->segment(4)==''))?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/index/1');?>"><span>Site Statistics</span></a>
    </li>

	<li <?php echo (@$current_menu == 'all' && $this->uri->segment(4)=='2')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_report/2');?>"><span>Report Generation</span></a>
    </li>
    
                        
</ul>
                    
                              