<h2 class="ttl">Members</h2>
<ul>
	 <li <?php echo (@$current_menu == 'add_member')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/add_member');?>"><span>Add Members</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/');?>"><span>Total Members</span></a>
    </li>
    
     <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='1')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/1');?>"><span>Active Members</span></a>
    </li>
    
     <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='2')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/2');?>"><span>Inactive Members</span></a>
    </li>
    
     <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='3')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/3');?>"><span>Suspended Members</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='4')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/4');?>"><span>Closed Members</span></a>
    </li>
    
     <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='online')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/online');?>"><span>Online Members</span></a>
    </li>
    
     <li <?php echo (@$current_menu == 'view_member' && $this->uri->segment(4)=='join_today')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/join_today');?>"><span>Today Joined Member</span></a>
    </li>


       
  <?php if(@$current_menu == 'edit_member' OR @$current_menu == 'transaction' OR @$current_menu == 'add_balance' OR @$current_menu == 'view_watchlist' OR @$current_menu == 'view_bid_history' || @$current_menu == 'statistics'  || @$current_menu == 'notiifcation'){ ?>                   
  <h2 class="ttl">Operations</h2>
  
  
    <li <?php echo (@$current_menu == 'edit_member')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/edit_member/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>Edit Member</span></a>
    </li>
 
  
  <li <?php echo (@$current_menu == 'transaction')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/transaction/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>Transaction</span></a>
    </li>

	<?php /*?><li <?php echo (@$current_menu == 'add_balance')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/add_balance/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>Add Balance</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'view_watchlist')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/view_watchlist/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>View Watchlist</span></a>
    </li>
    
    <li <?php echo (@$current_menu == 'view_bid_history')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/view_bid_history/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>View Bids History</span></a>
    </li><?php */?>
     <li <?php echo (@$current_menu == 'add_balance')?'class="active"':''?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/add_balance/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>Add balance</span></a>
    </li>
   <!--  <li <?php echo (@$current_menu == 'notification')?'class="active"':''?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/notification/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>"><span>Notification Settings</span></a>
    </li> -->
    <?php } ?> 
    
</ul>
                    
                              