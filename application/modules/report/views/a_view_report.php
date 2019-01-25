<script type="text/javascript">
function doconfirm()
{
	job=confirm("Are you sure to delete permanently?");
	if(job!=true)
	{
		return false;
	}
}

function form_submit()
{
	this.form.submit();
}

</script>

<!--scripts for calendar-->
<script>var FilesFolderPath = "<?php echo base_url().CALENDER_PATH;?>";</script>
<script src="<?php echo base_url().CALENDER_PATH;?>Scripts/DateTimePicker.js" type="text/javascript"></script>


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
        
        <form name="sitesetting" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_member_report/')?>" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Members Registration Report by Date range</div>
            <ul class="frm">
                
                 <li>
                    <div>
                        <label>Language<span>*</span></label>
                        <?php 
                            $lang_arr = array();
                            $lang_arr[''] = "Select Language";
                            foreach($this->general->get_all_languages() as $ln_data)
                            {
                                $lang_arr[$ln_data->id] = $ln_data->lang_name;
                            }
                            echo form_dropdown('lang_id', $lang_arr , $this->input->post('lang_id'), "onchange='return getCat(this);'");
                        ?>
                        <?=form_error('lang_id')?>
                    </div>
                </li>
               
                <li>
                    <div>
                      <label>Registered From<span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" name="from_date" id="from_date" value="<?php echo set_value('from_date'); ?>" readonly="readonly";/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" class="dpick" style="cursor: pointer;" onclick="javascript:NewCssCal('from_date','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('from_date')?>
                    </div>
              	</li>
                
                <li>
                    <div>
                      <label>Registered To<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="to_date" id="to_date" value="<?php echo set_value('to_date'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('to_date','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('to_date')?>
                    </div>
              	</li>
               
                <li>
                   <div>
                     <label>&nbsp;</label>
                     <input type="submit" value="Generate Report" class="butn" name="member_report">
                   </div>
              	</li>
               
              
             </ul>
          </fieldset>
        </form>
      </div>
      
        
      <div class="box_block">
        
        <form name="sitesetting" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_product_report/')?>" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Product Sold Report By Date range</div>
            <ul class="frm">
                
                <li>
                    <div>
                      <label>Product Sold From<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="from_date_product" id="from_date_product" value="<?php echo set_value('from_date_product'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('from_date_product','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('from_date_product')?>
                    </div>
              	</li>
                
                <li>
                    <div>
                      <label>Product Sold To<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="to_date_product" id="to_date_product" value="<?php echo set_value('to_date_product'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('to_date_product','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('to_date_product')?>
                    </div>
              	</li>
               
                <li>
                   <div>
                     <label>&nbsp;</label>
                     <input type="submit" value="Generate Report" class="butn" name="product_report">
                   </div>
              	</li>
               
              
             </ul>
          </fieldset>
        </form>
      </div>
      
      
      <div class="box_block">
        
        <form name="sitesetting" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_credit_report/')?>" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Credits Sold Report By Date range</div>
            <ul class="frm">
                
                <li>
                    <div>
                      <label>Credit Sold From<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="from_date_credit" id="from_date_credit" value="<?php echo set_value('from_date_credit'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('from_date_credit','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('from_date_credit')?>
                    </div>
              	</li>
                
                <li>
                    <div>
                      <label>Credit Sold To<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="to_date_credit" id="to_date_credit" value="<?php echo set_value('to_date_credit'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('to_date_credit','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('to_date_credit')?>
                    </div>
              	</li>
               
                <li>
                   <div>
                     <label>&nbsp;</label>
                     <input type="submit" value="Generate Report" class="butn" name="credit_report">
                   </div>
              	</li>
               
              
             </ul>
          </fieldset>
        </form>
      </div>
      
      <div class="box_block">
        
        <form name="sitesetting" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_report/')?>" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Generate Transaction report</div>
            <ul class="frm">
                
                <li>
                    <div>
                      <label>Transaction From<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="from_date_transaction" id="from_date_transaction" value="<?php echo set_value('from_date_transaction'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('from_date_transaction','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('from_date_transaction')?>
                    </div>
              	</li>
                
                <li>
                    <div>
                      <label>Transaction To<span>*</span> :</label>
                        <input size="50" class="inputtext dpick" type="text" name="to_date_transaction" id="to_date_transaction" value="<?php echo set_value('to_date_transaction'); ?>" readonly="readonly"/>
                        <img src="<?php echo base_url().CALENDER_PATH;?>Image/cal.gif" style="cursor: pointer;" onclick="javascript:NewCssCal('to_date_transaction','yyyyMMdd','arrow',true,'24')" />
                  <?=form_error('to_date_transaction')?>
                    </div>
              	</li>
               
                <li>
                   <div>
                     <label>&nbsp;</label>
                     <input type="submit" value="Generate Report" class="butn" name="transaction_report">
                   </div>
              	</li>
               
              
             </ul>
          </fieldset>
        </form>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="tbl_list tbl_full">
                <thead>
                    <tr> 
                        <th width="33%" align="left"><?php echo $info_header;?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>     
                    <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
                            <tr>
                                <td>Total Money Deposited From Paypal</td>
                                <td ><?php if($todays_payment_by_paypal->amount) echo $todays_payment_by_paypal->amount;else echo "0";?></td>
                            </tr>
                            
                            <tr>
                                <td>Total Products Sold</td>
                                <td ><?php if($todays_sale->totalProducts)echo $todays_sale->totalProducts;else echo "0";?></td>
                            </tr>
                            
                            <tr>
                                <td>Total Commission on sold products</td>
                                <td ><?php if($total_commissions_date_range->totalcommission)echo $total_commissions_date_range->totalcommission;else echo "0";?></td>
                            </tr>
                          
                            <tr>
                                <td>Total revenue from sold credits</td>
                                 <td ><?php if($total_revenue_credits->total_amount)echo $total_revenue_credits->total_amount;else echo "0";?></td>
                            </tr>
                            
                            <tr>
                                <td>Total revenue from item listing</td>
                               <td ><?php if($total_revenue_listing->total_amount)echo $total_revenue_listing->total_amount;else echo "0";?></td>
                            </tr>
                            
                             <tr>
                                <td></td>
                                <td style="font-weight:bold;color:#09F;">
                                    <form name="transaction-detail" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/csv_transaction_by_time/');?>" accept-charset="utf-8">
                                        <input type="hidden" name="paypal" value="<?php if($todays_payment_by_paypal->amount)echo $todays_payment_by_paypal->amount;else echo "0";?>">
                                        <input type="hidden" name="total_sold" value="<?php if($todays_sale->totalProducts)echo $todays_sale->totalProducts;else echo "0";?>">
                                        <input type="hidden" name="total_commission" value="<?php if($total_commissions_date_range->totalcommission)echo $total_commissions_date_range->totalcommission;else echo "0";?>">
                                        <input type="hidden" name="total_revenue_credit" value="<?php if($total_revenue_credits->total_amount)echo $total_revenue_credits->total_amount;else echo "0";?>">
                                        <input type="hidden" name="total_revenue_listing" value="<?php if($total_revenue_listing->total_amount)echo $total_revenue_listing->total_amount;else echo "0";?>"> 
                                        <input type="submit" value="Export as CSV" class="butn">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>             
            	</tr>
       		</tbody>
     	</table>
      </div>    
        
        
            
		</section>
  		<div class="clearfix"></div>
	</div>
    
</article>
<div> </div>
