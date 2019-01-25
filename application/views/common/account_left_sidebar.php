<div class="col-md-4 col-sm-5 res_hide">
  <div class="sidebar-left">
  <?php if(isset($user_type) && $user_type=='buyer'){ ?>
    <ul class="nav nav-pills nav-stacked">
        <li <?php if(isset($account_menu_active) && $account_menu_active=='dashboard'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'buyer'); ?>">Dashboard</a></li>
        <li <?php if(isset($account_menu_active) && $account_menu_active=='buyers_profile'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'buyer_profile'); ?>">My Profile</a></li>
        <?php if($this->general->get_auction_post_member_validity($this->session->userdata(SESSION. 'user_id')) != 'unlimited') { ?>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='buyer_packages'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'buyer_packages'); ?>">Membership Package</a></li>
        <?php }?>
        <li <?php if(isset($account_menu_active) && $account_menu_active=='create_auction'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'create_auction'); ?>">Create Auction</a></li>
        <li <?php if(isset($account_menu_active) && $account_menu_active=='view_auction'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'view_auction'); ?>">View Auctions</a></li>
       <!--  <li <?php if(isset($account_menu_active) && $account_menu_active=='buyer_message'){echo 'class="active"';} ?>><a href="<?php echo site_url('/my-messages/buyer_inbox'); ?>">Message</a></li>
        <li <?php if(isset($account_menu_active) && $account_menu_active=='buyer_notification'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'buyer_notification'); ?>">Notification Settings</a></li>
 -->        <li <?php if(isset($account_menu_active) && $account_menu_active=='buyer_change_password'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'buyer_change_password'); ?>">Change Password</a></li>
        <li><a href="<?php echo site_url('/user/logout'); ?>">Logout</a></li>
    </ul>
    <?php } elseif(isset($user_type) && $user_type=='supplier') { ?>
        <ul class="nav nav-pills nav-stacked">
          <li <?php if(isset($account_menu_active) && $account_menu_active=='dashboard'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'supplier'); ?>">Dashboard</a></li>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='company_details'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'company_details'); ?>">Personal/Company Details</a></li>
          <?php if($this->general->get_bid_member_validity($this->session->userdata(SESSION. 'user_id')) != 'unlimited') { ?>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='supplier_packages'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'supplier_packages'); ?>">Membership Packages</a></li>
          <?php }?>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='proposal_bids'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'proposal_bids'); ?>">My Proposal Bid</a></li>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='won_bids'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'won_bids'); ?>">My Won Bid</a></li>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='supplier_expertise'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'supplier_expertise'); ?>">My Expertise</a></li>
          <!-- <li <?php if(isset($account_menu_active) && $account_menu_active=='supplier_message'){echo 'class="active"';} ?>><a href="<?php echo site_url('/my-messages/supplier_inbox'); ?>">My Message</a></li>
          <li <?php if(isset($account_menu_active) && $account_menu_active=='supplier_notification'){echo 'class="active"';} ?>><a href="<?php echo site_url(MY_ACCOUNT.'supplier_notification'); ?>">Notification Settings</a></li> -->
          <li <?php if(isset($account_menu_active) && $account_menu_active=='supplier_change_password'){echo 'class="active"';} ?>><a href="<?php echo site_url('/'. MY_ACCOUNT. 'supplier_change_password'); ?>">Change Password</a></li>
          <li><a href="<?php echo site_url('/user/logout'); ?>">Logout</a></li>
        </ul>
    <?php } ?>
  </div>
</div>