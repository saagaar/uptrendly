
<ul>
<h2 class="ttl">Winner</h2>
    <li <?php echo (@$current_menu == 'all')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index');?>"><span>List All Winners</span></a>
    </li>
   <h2 class="ttl">Payment Type </h2>

    <li <?php echo (@$current_menu == 'paid' && $this->uri->segment(4)=='paid')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/paid');?>"><span>Paid</span></a>
    </li>
    <li <?php echo (@$current_menu == 'unpaid' && $this->uri->segment(4)=='unpaid')?'class="active"':''?>>
      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/unpaid');?>"><span>Unpaid</span></a>
    </li>
   <!--  <li <?php echo (@$current_menu == 'dispute' && $this->uri->segment(4)=='3')?'class="active"':''?>>
     <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/3');?>"><span>Dispute</span></a>
   </li> -->
               
</ul>


                    
                              