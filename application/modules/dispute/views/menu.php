
<ul>
<h2 class="ttl">Disputes</h2>
    <li <?php echo (@$current_menu == 'list_dispute')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/dispute/index');?>"><span>List All Disputes</span></a>
    </li>
    
  <!--   <li <?php echo (@$current_menu == 'add_product')?'class="active"':''?>>
    <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/add_product');?>"><span>Add Product</span></a>
  </li>
   -->
    <?php if(@$current_menu == 'view_bid_Placed'){ ?>
    <li class='active'>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/view_bids/'.$this->uri->segment(4));?>"><span>View Bids Placed</span></a>
    </li>
    <?php } ?>

    <?php if(@$current_menu == 'edit_product'){?>
    <li class="active">
       	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/edit_product/'.$this->uri->segment(4));?>"><span>Edit Post</span></a>
  	</li>
  	<?php } ?>
    
 <!--   <h2 class="ttl">Post Type</h2>
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
                 -->       
</ul>


                    
                              