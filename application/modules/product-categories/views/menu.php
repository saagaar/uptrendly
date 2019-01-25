<ul>
    <li <?php echo (@$current_menu == 'all')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/index');?>"><span>View All Categories</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'add_cat')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/add_category');?>"><span>Add Category</span></a>
    </li>
    
     <?php if(@$current_menu == 'edit_cat'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/edit_category/'.$this->uri->segment(4)); ?>"><span>Edit Product Category</span></a>
  </li>
  <?php endif; ?>
      
   <!--   <li <?php echo (@$current_menu == 'add_subcat')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/add_sub_category');?>"><span>Add Sub Category</span></a>
    </li>
    
     <?php if(@$current_menu == 'view_subcat'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/view_subcategory/'.$this->uri->segment(4)); ?>"><span>View Product Subcategory</span></a>
  </li>
  <?php endif; ?>
    
    <?php if(@$current_menu == 'edit_subcat'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/edit_sub_category/'.$this->uri->segment(4)); ?>"><span>Edit Product Subcategory</span></a>
  </li>
  <?php endif; ?>
          -->               
</ul>
                    
                              