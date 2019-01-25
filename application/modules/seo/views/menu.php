<ul>
    <li <?php echo (@$current_menu == 'all')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/seo/index');?>"><span>SEO Pages List</span></a>
    </li>

	<?php /*<li <?php echo (@$current_menu == 'add')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/seo/add_seo');?>"><span>Add SEO</span></a>
    </li>*/?>

    <?php if(@$current_menu == 'edit'):?>
    <li class="active">
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/seo/edit/'.$this->uri->segment(4)); ?>"><span>Edit SEO</span></a>
    </li>
    <?php endif; ?>     
                        
</ul>
                    
                              