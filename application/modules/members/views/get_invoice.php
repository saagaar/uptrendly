<div style="padding:6px 20px; float:left; width:610px; background:#202020; color:#ABABAB;"><span class="breed"><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>/auction/index">Member  Management </a> &raquo; Auction Item  Management </span></div>
<div style="padding:3px 20px; float:right; width:80px; background:#202020; color:#ABABAB; line-height:18px;"> <a href="javascript:history.go(-1)" style="text-decoration:none;"> <img src="<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/back.gif" width="18" height="18" alt="back" style="padding:0; margin:0; width:18px; height:18px;" align="right" /> </a><span class="breed"><a href="javascript:history.go(-1)"> go Back</a></span></div>
<h2>Invoice Detail </h2>
<div class="mid_frm">
  <table width="55%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
    <tr>
      <td align="left" valign="top" bgcolor="#FFFFFF"><table width="95%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td colspan="2"><div align="left"><span>This transaction has been completed without errors.</span></div></td>
          </tr>
          
          <tr>
            <td width="45%" height="20" align="left" valign="middle" ><strong>Invoice No:</strong></td>
            <td width="55%" height="20" align="left" valign="middle" style="padding-left:10px;"><?=$invoice_info->invoice_id;?></td>
          </tr>
          
          <?php // if($invoice_info->txn_id!='') {?>
          <tr>
            <td height="20" align="left" valign="middle" ><strong>
              <?php
              	if($invoice_info->payment_method=='clickandbuy')
				{
					echo "Clickandbuy";
				}
				elseif($invoice_info->payment_method=='paypal')
				{
					echo "Paypal";
				}
			?>
              Transaction ID:</strong></td>
            <td height="20" align="left" valign="middle"  style="padding-left:10px;"><? if($invoice_info->txn_id) echo $invoice_info->txn_id; else echo "N.A";?></td>
          </tr>
          <?php // } ?>
          
          <tr>
            <td height="20" align="left" valign="middle" ><strong>Date & Time:</strong></td>
            <td height="20" align="left" valign="middle"  style="padding-left:10px;"><?php echo $this->general->formated_date_time($invoice_info->transaction_date);?></td>
          </tr>
          
          <tr>
            <td height="20" align="left" valign="middle" ><strong>Amount:</strong></td>
            <td height="20" align="left" valign="middle"  style="padding-left:10px;">
              <?php echo DEFAULT_CURRENCY_SIGN.' '.$invoice_info->amount; ?>
			</td>
          </tr>
          
          <tr>
            <td height="20" align="left" valign="middle" ><strong>Payment Detail:</strong></td>
            <td height="20" align="left" valign="middle"  style="padding-left:10px;"><?php echo $invoice_info->transaction_name;?></td>
          </tr>
          
          <tr>
            <td height="20" align="left" valign="middle" ><strong>Status: </strong></td>
            <td height="20" align="left" valign="middle"  style="padding-left:10px;"><?php if($invoice_info->transaction_status)echo $invoice_info->transaction_status; else echo "Incomplete";?></td>
          </tr>
          
          <tr>
            <td height="20" align="left" valign="middle" ><strong>PayPal Account Name: </strong></td>
            <td height="20" align="left" valign="middle"  style="padding-left:10px;"><? if($invoice_info->payer_email) echo $invoice_info->payer_email; else echo "N.A";?></td>
          </tr>
          
          <tr align="left">
            <td>&nbsp;</td>
            <td align="left" valign="middle"></td>
          </tr>
          
          <tr align="right">
            <td colspan="2" align="left" >&nbsp;</td>
          </tr>
          
        </table>
      </td>
    </tr>
  </table>
  <span><a href="javascript:history.go(-1)"> Back</a></span></div>
</div>
<div class="clear"></div>
</div>
