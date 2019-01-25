
<ul>
<h2 class="ttl">Post</h2>
    <li <?php echo (@$current_menu == 'all_product')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index');?>"><span>List All Posts</span></a>
    </li>
    
  <!--   <li <?php echo (@$current_menu == 'add_product')?'class="active"':''?>>
    <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/add_product');?>"><span>Add Product</span></a>
  </li>
   -->
   
    <li  <?php echo (@$current_menu == 'view_bid_Placed')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/');?>"><span>View Bids Placed</span></a>
    </li>
     <?php if(@$current_menu == 'view_bid_Placed'){ ?>
     <h2 class="ttl">Bids Type</h2>
    <li <?php echo (@$current_menu == 'view_bid_Placed' && $this->uri->segment(4)=='pending')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/pending');?>"><span>Pending</span></a>
    </li>
    <li <?php echo (@$current_menu == 'view_bid_Placed' && $this->uri->segment(4)=='progress')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/progress');?>"><span>In Progress</span></a>
    </li>
    <li <?php echo (@$current_menu == 'view_bid_Placed' && $this->uri->segment(4)=='rejected')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/rejected');?>"><span>Rejected</span></a>
    </li>
    <li <?php echo (@$current_menu == 'view_bid_Placed' && $this->uri->segment(4)=='finished')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/finished');?>"><span>Finished</span></a>
    </li>
    <?php } ?>


    <?php if(@$current_menu == 'edit_product'){?>
    <li class="active">
       	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/edit_product/'.$this->uri->segment(4));?>"><span>Edit Post</span></a>
  	</li>
  	<?php } ?>
     <?php if(@$current_menu == 'all_product'){?>
   <h2 class="ttl">Post Type</h2>
    <li <?php echo (@$current_menu == 'all_product' && $this->uri->segment(4)=='1')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index/1');?>"><span>Pending</span></a>
    </li>
    <li <?php echo (@$current_menu == 'all_product' && $this->uri->segment(4)=='2')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index/2');?>"><span>Active</span></a>
    </li>
    <li <?php echo (@$current_menu == 'all_product' && $this->uri->segment(4)=='3')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index/3');?>"><span>Closed</span></a>
    </li>
    <li <?php echo (@$current_menu == 'all_product' && $this->uri->segment(4)=='4')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index/4');?>"><span>Cancelled</span></a>
    </li>
      <?php } ?>                  
</ul>


                    
                              