
<input type="hidden" class="viewtype" value="creator">
<?php 
if(count($active_sponsor)<1)
 {
    echo 'No Sponsorships Found';
 }
 else
 {
  foreach($active_sponsor as $sponsor):
    $customlink=$this->general->create_custom_link($sponsor->product_id,$sponsor->user_id);
  ?>
<div class="creator_p_info">
  <ul class="list-unstyled product_listing campaigns_list">
    <li>
      <div class="row">
        <div class="col-sm-3 col-xs-5">
          <div class="image relative"> <span class="active_indicator"> <i class="fa fa-circle"></i>
            <?php 
                if($sponsor->socialtrackid!='') echo 'Content Uploaded';
                elseif($sponsor->socialtrackid=='' && ($sponsor->draft_accept=='0')) echo 'Draft Sent';
                elseif($sponsor->socialtrackid=='' && ($sponsor->draft_accept=='1')) echo 'Draft Accepted';
                elseif($sponsor->socialtrackid=='' && ($sponsor->draft_accept=='2')) echo 'Draft Rejected';
                elseif($sponsor->status=='2') echo 'Changes Required';
                elseif($sponsor->status=='1') echo 'Action Required';
                elseif($sponsor->status=='7') echo 'Completed';
                elseif($sponsor->status=='0') echo 'Proposal Sent'; 
                ?>
            </span>
            <?php 
                $image=site_url('/'.PRODUCT_IMAGE_PATH.$sponsor->image);
              ?>
            <img src="<?php echo  $image;?>" alt="proposal Image" /> </div>
        </div>
        <div class="col-sm-9 col-xs-7">
          <h4> <a href="javascript:void(0)"><?php echo $sponsor->name;?></a>
            <?php
                              if(defined('FACEBOOKMEDIAID') && FACEBOOKMEDIAID==$sponsor->mediaid)
                                {
                                  ?>
            <span class="round_btn pull-right facebook "> <i class="fa fa-facebook-f"></i> </span>
            <?php
                                }
                               if( defined('TWITTERMEDIAID') && TWITTERMEDIAID==$sponsor->mediaid)
                                {
                                  ?>
            <span class="round_btn pull-right twitter"> <i class="fa fa-twitter-square"></i> </span>
            <?php
                                }
                                if( defined('INSTAGRAMMEDIAID') && INSTAGRAMMEDIAID==$sponsor->mediaid)
                                {
                                  ?>
            <span class="round_btn pull-right instagram"> <i class="fa fa-instagram"></i> </span>
            <?php
                                }
                               if(defined('YOUTUBEMEDIAID') && YOUTUBEMEDIAID==$sponsor->mediaid)
                                {
                                  ?>
            <span class="round_btn pull-right youtube"> <i class="fa fa-youtube"></i> </span>
            <?php
                                }
                                if(defined('YOUTULEEMEDIAID') && YOUTULEEMEDIAID==$sponsor->mediaid)
                                { ?>
            <span class=" admin_pos_fix round_btn pull-right btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="25px"> </span>
            <?php
                                }
                                 if(defined('TUMBLRMEDIAID') && TUMBLRMEDIAID==$sponsor->mediaid)
                                { ?>
            <span  class="round_btn pull-right   tumblr"><i class="fa fa-tumblr"></i></span>
            <?php }
              ?>
          </h4>
          <p> <?php echo $sponsor->description;?> </p>
          <div class="row">
            <div class="col-sm-4 border_right">
              <h5> <strong>Deadline</strong> <span><?php echo $this->general->date_formate($sponsor->delivery_date)?></span> </h5>
            </div>
            <div class="col-sm-4">
              <h5> <strong>Budget</strong> <span><?php echo DEFAULT_CURRENCY_SIGN.' '.$sponsor->user_bid_amt;?></span> </h5>
            </div>
          </div>
          <div class="border_top">
            <div class="alert alert-warning pull-left creator_p_info_alert"> <strong>Custom url:</strong><span class="text-lowercase"><?php echo $customlink;?></span> </div>
            <a href="javascript:void(0)" id="claimreport" data-bidid="<?php echo $sponsor->id;?>" data-toggle="modal" data-target="#reportModal" class="btn btn-sm btn-default pull-right"><i class="fa fa-exclamation-circle"></i> Report</a> </div>
        </div>
      </div>
    </li>
  </ul>
</div>
<?php endforeach;
} 
if(DASHBOARD_NOTE!=''):
 ?>
<div class="alert alert-info creator_p_info_alert"> <strong>Note:</strong> <?php echo DASHBOARD_NOTE;?> </div>
<?php endif;?>
