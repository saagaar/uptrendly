<ul>
	<h2 class="ttl">Static Fields</h2>
    <li <?php echo (@$current_menu == 'view_static_fields')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/view_static_fields/');?>"><span>View All Static fields</span></a>
    </li>
    
    <?php if(@$current_menu == 'edit_static_field'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/edit_static_field/'.$this->uri->segment(4)); ?>"><span>Edit Static field</span></a>
  	</li>
  	<?php endif; ?>
    
    
	<h2 class="ttl">Basic Fields</h2>
    <li <?php echo (@$current_menu == 'view_basic_fields')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/view_basic_fields');?>"><span>View All Basic fields</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add_basic_field')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/add_basic_field');?>"><span>Add Basic field</span></a>
    </li>
    
  <?php if(@$current_menu == 'edit_basic_field'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/edit_basic_field/'.$this->uri->segment(4)); ?>"><span>Edit Basic field</span></a>
  	</li>
  <?php endif; ?>
  
    <?php //if(PRODUCT_CATEGORY_STATUS=='enabled'){ ?>
	<h2 class="ttl">Custom Fields</h2>
    <li <?php echo (@$current_menu == 'view_custom_field')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/view_custom_fields');?>"><span>View All Custom fields</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add_custom_field')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/add_custom_field');?>"><span>Add Custom field</span></a>
    </li>
    
  <?php if(@$current_menu == 'edit_custom_field'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/edit_custom_field/'.$this->uri->segment(4)); ?>"><span>Edit Custom field</span></a>
  	</li>
  <?php endif; ?>
  
  <?php //} ?>
</ul>
                    
                              