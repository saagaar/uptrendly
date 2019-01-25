<script type="text/javascript">
$(document).ready(function() { 
    // call the tablesorter plugin 
    $("table").tablesorter({ 
        // sort on the first second third fourth and fifth column, order asc 
        //sortList: [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0]],
		 sortList: [[1,0]],
		sortInitialOrder : 'asc'
    }); 
});

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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Winner Payment</h2>
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
            	<form name="search_product" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            		<fieldset>
                    <ul class="frm">
                      <li style="width:30%">
                        <div>
                          <input type="text" name="srch" class="inputtext" size=45 placeholder="Enter seller name, seller id or Post name" value="<?php if($this->input->post('srch',TRUE)){echo $this->input->post('srch',TRUE);} ?>">
                        </div>
                      </li>
                      
                      <li><div><input type="submit" name="submit"  value="search" class="butn"></div></li>
              		</ul>
          		</fieldset>
            	</form>
            </div>

			<div class="box_block">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablesorter tbl_list tbl_full">
    				<thead>
                        <tr>
                            <th width="4%">Id</th>
                             <th width="12%">Campaign Name </th>
                            <th width="8%">Amount</th>
                            <th width="8%">Creator Name</th>
                            <th width="5%">Creator Email</th>
                            <th width="8%">Brand Name</th>
                            <th width="10%">Completed Date</th>
                            <th width="5%">Social media</th>
                            <th width="10%">Status</th>
                            <!-- <th width="13%" class="optn"> Operations </th> -->
                        </tr>
                    </thead>
    				<tbody>
					<?php 
          // echo '<pre>';
          // print_r($winner_data);exit;
                    $i=1;
                    if($winner_data)
                    {
                        foreach($winner_data as $value)
                        { 

                          ?>
                          <tr>
                            <td><?php  echo $i;?></td>
                            <td><?php echo Ucfirst($value->product_name)?></td>
                            <td><?php echo $value->won_amount;?></td>
                            <td><?php echo $this->general->string_limit($value->creator,20); ?></td>
                            <td><?php echo $value->email;?></td>
                            <td><?php echo $this->general->string_limit($value->brand,20); ?></td>
                            <td><?php echo $this->general->short_date_time_format($value->product_close_date);?></td>
                            <td>
                            <?php
                              if(FACEBOOKMEDIAID==$value->mediaid)
                                {
                                  ?>
                                <span class="round_btn facebook ">
                                     <i class="fa fa-facebook-f"></i>
                                </span>
                              <?php
                                }
                               if(TWITTERMEDIAID==$value->mediaid)
                                {
                                  ?>
                                <span class="round_btn twitter">
                                     <i class="fa fa-twitter-square"></i>
                                </span>
                              <?php
                                }
                                if(INSTAGRAMMEDIAID==$value->mediaid)
                                {
                                  ?>
                                <span class="round_btn instagram">
                                     <i class="fa fa-instagram"></i>
                                </span>
                              <?php
                                }
                               if(YOUTUBEMEDIAID==$value->mediaid)
                                {
                                  ?>
                                  <span class="round_btn youtube">
                                       <i class="fa fa-youtube"></i>
                                  </span>
                              <?php
                                }
                                if(YOUTULEEMEDIAID==$value->mediaid)
                                { ?>
                                  <span class=" admin_pos_fix round_btn btn-youtulee">
                                   <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="25px"> 
                                </span>
                             <?php
                                }
                                 if(TUMBLRMEDIAID==$value->mediaid)
                                { ?>
                                   <span  class="round_btn   tumblr"><i class="fa fa-tumblr"></i></span>
                          <?php }
              ?>
                             </td> 
                            <td><?php if($value->payment_status=='Completed')
                                      {
                                          echo 'Paid';
                                      }else
                                      {
                                        if($value->identification_no=='' && $value->country=='')
                                        { ?>
                                            <div>
                                        <form name="notify_creator" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/')?>">
                                        
                                          <input type="hidden" name="creatorid" value="<?php echo $value->user_id;?>">
                                        
                                         <i class="fa fa-warning notifycreator"><span>Billing profile incomplete</span></i>
                                
                                          <input type="submit" name="submit" name="send_notification"  value="Notify" class="butn">
                                        </fo  rm>
                                        </div>
                         <?php          }
                                        else
                                        { ?>
                                              
                                        <div>
                                        <form name="payment" method="post" action="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/')?>">
                                          <input type="hidden" name="bidid" value="<?php echo $value->bid_id;?>">
                                          <input type="hidden" name="product_id" value="<?php echo $value->product_id;?>">
                                          <input type="hidden" name="creatorid" value="<?php echo $value->user_id;?>">
                                          <input type="hidden" name="product_name" value="<?php echo $value->product_name;?>">
                                          <input type="hidden" name="balance" value="<?php echo $value->won_amount;?>">
                                          <input type="submit" name="submit" name="pay_creator"  value="Pay now" class="butn">
                                        </form>
                                        </div>
                                   <?php }
                                        ?>
                                      <?php 
                                      }
                              ?> </td> 
                            
                          </tr>
                       <?php 
                       $i++;
                       } }else{ ?>
                        <tr>
                        	<td colspan="8"><div class="confrmmsg"><p>No Won Record found.</p></div></td>
                    	</tr>
                    <?php } ?>
                </tbody>
  				</table>
  			</div>
             <?php if ($links) { echo "<ul class='pagination'>".$links."</ul>"; } ?>
		</section>
  		<div class="clearfix"></div>
	</div>
</article>
<div> </div>
