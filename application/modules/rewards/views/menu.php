
<ul>
<h2 class="ttl">Rewards</h2>
    <li <?php echo (@$current_menu == 'rewards')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/index');?>"><span>List All Rewards</span></a>
    </li>
    
     <li <?php echo (@$current_menu == 'add_product')?'class="active"':''?>>
    <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/add_rewards');?>"><span>Add rewards</span></a>
  </li>


    <?php if(@$current_menu == 'edit_rewards'){?>
    <li class="active">
       	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/edit_rewards/'.$this->uri->segment(4));?>"><span>Edit Post</span></a>
  	</li>
  	<?php } ?>
    
   <!-- <h2 class="ttl">Post Type</h2>
    <li <?php echo (@$current_menu == 'rewards' && $this->uri->segment(4)=='1')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/index/1');?>"><span>Pending</span></a>
    </li>
    <li <?php echo (@$current_menu == 'rewards' && $this->uri->segment(4)=='2')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/index/2');?>"><span>Active</span></a>
    </li>
    <li <?php echo (@$current_menu == 'rewards' && $this->uri->segment(4)=='3')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/index/3');?>"><span>Closed</span></a>
    </li>
    <li <?php echo (@$current_menu == 'rewards' && $this->uri->segment(4)=='4')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/index/4');?>"><span>Cancelled</span></a>
    </li> -->
                       
</ul>


                    
                              