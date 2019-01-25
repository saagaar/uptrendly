<script type="text/javascript">
function doconfirm()
{
	job=confirm("Are you sure to delete permanently?");
	if(job!=true)
	{
		return false;
	}
}
</script>

<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Site Statistics</h2>
  </div>
</section>

<article id="bodysec" class="sep">
	<div class="wrap">
		<aside class="lftsec"><?php $this->load->view('menu'); ?></aside>
		<section class="smfull">
			<?php
				 if($this->session->flashdata('message')) 
				 {
					 ?>
						<div id="displayErrorMessage" class="confrmmsg">
  							<p><?php echo $this->session->flashdata('message'); ?></p>
						</div>
					<?php
                 }
			?>
    
        <div class="box_block">
        <h3>Site Statistics</h3>
        	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tbl_list tbl_full">
                <thead>
                    <tr> 
                        <th width="33%" align="left">Members Statistics</th>
                        <th width="33%" align="left">Revenue Statistics</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>     
                    <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                            <tr>
                                <td>Active Members</td>
                                <td ><?php if(ACTIVE_MEMBER)echo ACTIVE_MEMBER;else echo "0";?></td>
                            </tr>
                            
                            <tr>
                                <td>Inactive Members</td>
                                <td ><?php if(INACTIVE_MEMBER)echo INACTIVE_MEMBER;else echo "0";?></td>
                            </tr>
                            <tr>
                                <td>Suspended Members</td>
                                <td ><?php if(SUSPENDED_MEMBER)echo SUSPENDED_MEMBER;else echo "0";?></td>
                            </tr>
                            <tr>
                                <td>Closed Members</td>
                                <td><?php if(CLOSE_MEMBER)echo CLOSE_MEMBER;else echo "0";?></td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Total Members</td>
                                <td style="font-weight:bold;"><strong><?php if(TOTAL_MEMBER)echo TOTAL_MEMBER;else echo "0";?></strong></td>
                            </tr>
                            
                             <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_member/');?>"><strong>Export as CSV file</strong></a>
                                </td>
                             </tr>
                             
                        </table>
                    </td>
                    

                    <td align="left" valign="top" >
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                                <tr>
                                    <td>Total Money Deposited From PayPayl:	</td>
                                    <td><?php if($total_payment_by_paypal)echo DEFAULT_CURRENCY_SIGN.' '.$total_payment_by_paypal->amount;else echo "0";?></td>
                                </tr>
                                
                                <tr>
                                    <td>Total Credits in Member Accounts:</td>
                                    <td ><?php if($totalBidCredit)echo $totalBidCredit->balance;else echo "0";?> Credits</td>
                                </tr> 
                                
                                <tr>
                                    <td>Total Products Sold:</td>
                                    <td ><?php if($total_sale)echo $total_sale->quantity;else echo "0";?></td>
                                </tr>
                               
                                <tr>
                                    <td>Total Products Sold Cost:</td>
                                    <td ><?php if($total_sale_cost) {echo DEFAULT_CURRENCY_SIGN.' '.$total_sale_cost->totalcost;} else echo "0";?></td>
                                </tr>
                                
                                <tr>
                                <!-- <td>Total Commissions from product sold</td>
                                <td >
								<?php if($total_site_commission->totalcommission)echo DEFAULT_CURRENCY_SIGN.' '.$total_site_commission->totalcommission;else echo "0";?>
                                </td>
                                </tr>
                               
                                <tr>
                                <td>Total revenue form item listing</td>
                                <td >
								<?php if($total_revenue_item_listing->total_amount) echo DEFAULT_CURRENCY_SIGN.' '.$total_revenue_item_listing->total_amount; else echo "0";?>
                                </td>
                            </tr>
                                
                                <tr>
                                <td>Total revenue form bid credits:</td>
                                <td >
								<?php if($total_revenue_bidcredit->total_amount) echo DEFAULT_CURRENCY_SIGN.' '.$total_revenue_bidcredit->total_amount;else echo "0";?>
                                </td>
                                </tr> -->
                                
                                
                                <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_site_revenue/');?>"><strong>Export as CSV file</strong></a>
                                </td>
                            </tr>
                    		</table>
                    	</td>
                    </tr>
                </tbody>
            </table>
		</div>
        
        <div class="box_block">
        <h3>Top 10 results</h3>
        	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tbl_list tbl_full">
                <thead>
                    <tr> 
                        <th width="33%" align="left">Top Sold products</th>
                        <!--  <th width="33%" align="left">Top Sellers</th>
                        <th width="33%" align="left">Top Buyers</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>     
                    <td align="left" valign="top" >
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                                <tr>
                                    <td style="font-weight:bold;">Product Name</td>
                                    <td style="font-weight:bold;">Total Sale</td>
                                </tr>
                                <?php
                                if($top_products_sold){?>
                                <?php foreach($top_products_sold as $products){?>
                                <tr>
                                    <td><?php echo $products->name;?></td>
                                    <td ><?php echo $products->totalsale;?></td>
                                </tr> 
                                <?php } ?>
                                
                                <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_top_products/');?>"><strong>Export as CSV file</strong></a>
                                </td>
                                </tr>
                                <?php } else {?>
                                <tr>
                                    <td>No records found.</td>
                                    <td ></td>
                                </tr>
                                <?php } ?>
                            
                            
                    		</table>
                    	</td>
                    
                    <!-- <td align="left" valign="top" >
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                                <tr>
                                    <td style="font-weight:bold;">Seller Name</td>
                                    <td style="font-weight:bold;">Total Sale</td>
                                </tr>
                                <?php
                                if($top_seller){?>
                                <?php foreach($top_seller as $seller){?>
                                <tr>
                                    <td><?php echo $seller->user_name." ( ID : ".$seller->seller_id." )";?></td>
                                    <td ><?php echo $seller->totalsale;?></td>
                                </tr> 
                                <?php } ?>
                                
                                <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_top_seller/');?>"><strong>Export as CSV file</strong></a>
                                </td>
                                </tr>
                                <?php } else {?>
                                <tr>
                                    <td>No records found.</td>
                                    <td ></td>
                                </tr>
                                <?php } ?>
                            
                            
                    		</table>
                    	</td> -->
                    
                    <!-- <td align="left" valign="top" >
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                                <tr>
                                    <td style="font-weight:bold;">Buyer Name</td>
                                    <td style="font-weight:bold;">Total Buys</td>
                                </tr>
                                <?php
                                if($top_buyer){?>
                                <?php foreach($top_buyer as $buyer){?>
                                <tr>
                                    <td><?php echo $buyer->user_name." ( ID : ".$buyer->user_id." )";?></td>
                                    <td ><?php echo $buyer->totalbuys;?></td>
                                </tr> 
                                <?php } ?>
                                
                                <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_top_buyer/');?>"><strong>Export as CSV file</strong></a>
                                </td>
                                </tr>
                                <?php } else {?>
                                <tr>
                                    <td>No records found.</td>
                                    <td ></td>
                                </tr>
                                <?php } ?>
                            
                            
                    		</table>
                    	</td> -->
                    </tr>
                </tbody>
            </table>
		</div>
        
        <!-- <div class="box_block">
        <h3>Site Commissions</h3>
        	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tbl_list tbl_full">
                <thead>
                    <tr> 
                        <th width="33%" align="left">Commission Statistics</th>
                         <th width="33%" align="left"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>     
                    <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                            <tr>
                                <td>Total Commissions last 7 Days</td>
                                <td >
								<?php if($total_site_commission_last_week->totalcommission) echo DEFAULT_CURRENCY_SIGN.' '.$total_site_commission_last_week->totalcommission;else echo "0";?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>Total Commissions last 30 Days</td>
                                <td >
								<?php if($total_site_commission_last_month->totalcommission) echo DEFAULT_CURRENCY_SIGN.' '.$total_site_commission_last_month->totalcommission;else echo "0";?>
                                </td>
                            </tr>
                          
                            <tr>
                                <td style="font-weight:bold;">Total Commissions</td>
                                <td style="font-weight:bold;">
                                <strong><?php if($total_site_commission) echo DEFAULT_CURRENCY_SIGN.' '.$total_site_commission->totalcommission;else echo "0";?></strong>
                                </td>
                            </tr>
                            
                             <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_commisssion/');?>"><strong>Export as CSV file</strong></a>
                                </td>
                            </tr>
                        
                        </table>
                    </td>
                    
                    <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                        </table>
                    </td>
                    
                    </tr>
                </tbody>
            </table>
		</div> -->
        
        
            
		</section>
  		<div class="clearfix"></div>
	</div>
    
</article>
<div> </div>
