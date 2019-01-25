<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Sitesetting  Management </h2>
  </div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <section class="smfull">
      <div class="confrmmsg">
        <?php 
            if($this->session->flashdata('message')){
            echo "<p>".$this->session->flashdata('message')."</p>";
            }
            // echo validation_errors();
        ?>
      </div>
      <div class="box_block">
        <form name="sitesetting" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8" id="siteSettingsForm">
          <fieldset>
            <div class="title_h3">System Settings</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Website Name<span>*</span> :</label>
                  <input type="text" name="site_name" class="inputtext" size=45 value="<?php echo set_value('site_name',$site_set['site_name']);?>">
                  <?=form_error('site_name')?>
                </div>
              </li>              
              <li>
                <div>
                  <label>Website Status</label>
                  <input name="site_status" type="radio" value="1" <?php if(set_value('site_status',$site_set['site_status']) == '1'){ echo 'checked="checked"';}?> />Online
                  <input name="site_status" type="radio" value="2" <?php if(set_value('site_status',$site_set['site_status']) == '2'){ echo 'checked="checked"';}?> />Offline
                  <input name="site_status" type="radio" value="3" <?php if(set_value('site_status',$site_set['site_status']) == '3'){ echo 'checked="checked"';}?>/>Maintainance
                </div>
              </li>

              <li><div>
                  <label>Influencer Name<span>*</span> :</label>
                  <input type="text" name="contact_name" id="contact_name" value="<?php echo set_value('contact_name',$site_set['contact_name']);?>"  />
                  <?=form_error('contact_name')?>
                </div></li>
              
        <li>
                <div>
                  <label>Influencer Email<span>*</span> :</label>
                  <input name="contact_email" type=text class="inputtext" id="contact_email" value="<?php echo set_value('contact_email',$site_set['contact_email']);?>" size=45>
                  <?=form_error('contact_email')?>
                </div>
              </li>
              <li><div>
                  <label>Advertiser Email Name<span>*</span> :</label>
                  <input type="text" name="system_email_name" id="system_email_name" value="<?php echo set_value('system_email_name',$site_set['system_email_name']);?>"  />
                  <?=form_error('system_email_name')?>
                </div></li>
              
        <li>
                <div>
                  <label>Advertiser Email Address<span>*</span> :</label>
                  <input name="system_email_address" type=text class="inputtext" id="system_email_address" value="<?php echo set_value('system_email_address',$site_set['system_email']);?>" size=45>
                  <?=form_error('system_email_address')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Default Currency Sign<span>*</span> :</label>
                  <input type="text" name="currency_sign" class="inputtext" value="<?php echo set_value('currency_sign',$site_set['currency_sign']);?>">
                  <?=form_error('currency_sign')?>
                </div>
              </li>
              
              <li>
                <div>
                  <label>Default Currency Code</label>
                   <input type="text" name="currency_code" class="inputtext" value="<?php echo set_value('currency_code',$site_set['currency_code']);?>">
                  <?=form_error('currency_code')?>
                </div>
              </li>
              
               <!-- <li id="maintainanceKeyHolder">
                <div>
                  <label>Maintanance Key<span>*</span> :</label>
                  <input type="text" name="maintainance_key" class="inputtext" size=45 value="<?php echo set_value('maintainance_key',$site_set['maintainance_key']);?>">
                  <?=form_error('maintainance_key')?>
                </div>
              </li> -->
            </ul>
          </fieldset>
          <fieldset>
            <div class="title_h3">Timezone Settings</div>
            <ul class="frm">
              <li>
                    <div>
                      <label>System Timezone<span>*</span> :</label>
                        <?php
                            $default_timezone = set_value('timezone',$site_set['timezone']);                    
                            echo $this->general->timezone_list('timezone', $default_timezone);
                            echo form_error('timezone');
                        ?>
                  </div>
                </li>
            </ul>
          </fieldset>
           <fieldset>
            <div class="title_h3">Static text content</div>
            <ul class="frm">
              <li>
                    <div>
                      <label>Contents<span>*</span> :</label>
                        <textarea name="v_content_static" Placeholder="text for displaying dumb text in content"><?php echo  set_value('v_content_static',$site_set['v_content_static'])?></textarea>
                          <?php echo form_error('v_content_static'); ?>
                  </div>
                </li>
                <li>
                    <div>
                      <label>Proposals<span>*</span> :</label>
                        <textarea name="proposal_static" Placeholder="text for displaying dumb text in Proposals menu"><?php echo set_value('proposal_static',$site_set['proposal_static'])?></textarea>
                          <?php echo form_error('proposal_static'); ?>
                  </div>
                </li>
                 <li>
                    <div>
                      <label>Dashboard Note<span>*</span> :</label>
                        <textarea name="dashboard_note" Placeholder="text for displaying dumb text in Dashboard"><?php echo set_value('dashboard_note',$site_set['dashboard_note'])?></textarea>
                          <?php echo form_error('dashboard_note'); ?>
                  </div>
                </li>
            </ul>
          </fieldset>
          <fieldset>
            <div class="title_h3">Brand/Creator Setting</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Membership Activation</label>
                  <input name="user_activation" type="radio" value="0" checked="checked" />No
                  <input name="user_activation" type="radio" value="1" <?php if($site_set['user_activation'] == '1'){ echo 'checked="checked"';}?> />Yes
                 </div>
              </li> 
              <li>
                <div>
                  <label>Brand Referral Point</label>
                   <input type="text" name="brand_refer_point" class="inputtext" value="<?php echo set_value('brand_refer_point',$site_set['brand_refer_point']);?>">
                  <?=form_error('brand_refer_point')?>
                 </div>
              </li> 
                <li>
                <div>
                  <label>Creator Referral Point</label>
                   <input type="text" name="creator_refer_point" class="inputtext" value="<?php echo set_value('creator_refer_point',$site_set['creator_refer_point']);?>">
                  <?=form_error('creator_refer_point')?>
                 </div>
              </li> 
              
              <li>
                <div>
                  <label> Commission Percent</label>
                  <input name="commission_percent" type="text" value="<?php echo set_value('commission_percent', $site_set['commission_percent']); ?>"  />
                   <?=form_error('commission_percent')?>
                 </div>
              </li>
              <li>
                <div>
                  <label> Fixed Commission</label>
                  <input name="fixed_commission" type="text" value="<?php echo set_value('fixed_commission', $site_set['fixed_commission']); ?>"  />
                   <?=form_error('fixed_commission')?>
                 </div>
              </li>
               <li>
                <div>
                  <label>Enable Rating</label>
                  <input name="enable_rating" type="radio" value="No" checked="checked" />No
                  <input name="enable_rating" type="radio" value="Yes" <?php if($site_set['enable_rating'] == 'Yes'){ echo 'checked="checked"';}?> />Yes
                </div>
              </li>  
              
        </ul>
          </fieldset>
          <fieldset>
            <div class="title_h3">Post Settings</div>
            <ul class="frm">
              <!-- <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>Charge Auction Post</label>
                   <input name="is_auction_post_cost" type="radio" value="1" <?php if($site_set['is_auction_post_cost'] == '1'){ echo 'checked="checked"';}?> />Yes
                  <input name="is_auction_post_cost" type="radio" value="0" <?php if($site_set['is_auction_post_cost'] == '0'){ echo 'checked="checked"';}?>/>No
                  <?php echo form_error('is_auction_post_cost'); ?>
                 </div>
              </li>    -->             
             <!--  <li>
                <div>
                  <label>No. of Bid Place(Free)</label>
                  <input name="no_bid_place_free" type="text" value="<?php echo set_value('no_bid_place_free', $site_set['no_bid_place_free']); ?>">(0 for no free bid places, 999999999 for unlimited, or any number)
                  <?php echo form_error('no_bid_place_free'); ?>
                 </div>
              </li>  -->
             <!--  <li>
                <div>
                  <label>Is Bid Place Cost</label>
                  <input name="is_bid_place_cost" type="radio" value="1" <?php if($site_set['is_bid_place_cost'] == '1'){ echo 'checked="checked"';}?> />Yes
                  <input name="is_bid_place_cost" type="radio" value="0" <?php if($site_set['is_bid_place_cost'] == '0'){ echo 'checked="checked"';}?>/>No
                  <?php echo form_error('is_bid_place_cost'); ?>
                </div>
              </li>   -->
              <li>
                <div>
                  <label>Post Activation</label>
                  <input name="auction_post_activation" type="radio" value="1" <?php if($site_set['auction_post_activation'] == '1'){ echo 'checked="checked"';}?> />Yes
                  <input name="auction_post_activation" type="radio" value="0" <?php if($site_set['auction_post_activation'] == '0'){ echo 'checked="checked"';}?>/>No
                  <?php echo form_error('auction_post_activation'); ?>
                </div>
              </li>               
          </ul>
          </fieldset>
            <fieldset>
            <div class="title_h3">Social media Settings</div>
            <?php 
            foreach ($socialmedia_set as $key => $value) {
              ${$value->media_type.'_key'}=empty($value->app_key)?'' : $value->app_key;
              ${$value->media_type.'_secret'}=empty($value->app_secret) ?'' : $value->app_secret;
              ${$value->media_type.'_redirect_uri'}=empty($value->redirect_uri) ? '' : $value->redirect_uri;
              ${$value->media_type.'_isactive'}=empty($value->redirect_uri) ? '' : $value->isActive;
              ${$value->media_type.'_least_fan_count'}=empty($value->least_fan_count) ? '' : $value->least_fan_count;
            }

            ?>
            <ul class="frm">
              <li class="social_ico_tag">
                <label>
                  Facebook
                </label>
                <span class="round_btn facebook ">
                  <i class="fa fa-facebook-f"></i>
                </span>
              </li> 

              
               <li>
                 <div>
                  <label> Key</label>
                   <input name="media_type_fb" type="hidden" value="facebook">
                  <input name="fb_key" type="text" value="<?php echo set_value('fb_key', $facebook_key); ?>">
                  <?php echo form_error('fb_key'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label> Secret</label>
                  <input name="fb_secret" type="text" value="<?php echo set_value('fb_secret', $facebook_secret); ?>">
                  <?php echo form_error('fb_secret'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>Redirect URI</label>
                  <input name="fb_redirect_uri" type="text" value="<?php echo set_value('fb_redirect_uri', $facebook_redirect_uri); ?>">
                  <?php echo form_error('fb_redirect_uri'); ?>
                 </div>
              </li> 
                <li class="social_ico_tag"></li>
                <li class="social_ico_tag"></li>
                <li>
                <div>
                  <label>Least Fan followers</label>
                  <input name="fb_least_fan_count" type="text" value="<?php echo set_value('fb_least_fan_count', $facebook_least_fan_count); ?>">
                  <?php echo form_error('fb_least_fan_count'); ?>
                 </div>
              </li> 
               <li class="socio_radio">
                <div>
                  <label>Enable</label>
                  <input name="fb_isactive" type="radio" value="1" <?php  echo set_value('fb_isactive', $facebook_isactive) == 1 ? "checked" : "";?>>Yes
                  <input name="fb_isactive" type="radio" value="0" <?php  echo set_value('fb_isactive', $facebook_isactive) == 0 ? "checked" : "";?>>No
                  <?php echo form_error('fb_isactive'); ?>
                 </div>
              </li> 
             <!--  <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              
 -->
           
		       </ul>
            <ul class="frm">
              <li class="social_ico_tag">
                <label>
                  Twitter
                </label>
                <span class="round_btn twitter ">
                  <i class="fa fa-twitter"></i>
                </span>
              </li> 

              
               <li>
                 <div>
                  <label> Key</label>
                   <input name="media_type_tw" type="hidden" value="twitter">
                  <input name="tw_key" type="text" value="<?php echo set_value('tw_key', $twitter_key); ?>">
                  <?php echo form_error('tw_key'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label> Secret</label>
                  <input name="tw_secret" type="text" value="<?php echo set_value('tw_secret', $twitter_secret); ?>">
                  <?php echo form_error('tw_secret'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>Redirect URI</label>
                  <input name="tw_redirect_uri" type="text" value="<?php echo set_value('tw_redirect_uri', $twitter_redirect_uri); ?>">
                  <?php echo form_error('tw_redirect_uri'); ?>
                 </div>
              </li> 
              <li class="social_ico_tag"></li>
              <li class="social_ico_tag"></li>
                 <li>
                <div>
                  <label>Least Fan followers</label>
                  <input name="tw_least_fan_count" type="text" value="<?php echo set_value('tw_least_fan_count', $twitter_least_fan_count); ?>">
                  <?php echo form_error('tw_least_fan_count'); ?>
                 </div>
              </li> 
               <li class="socio_radio">
                <div>
                  <label>Enable</label>
                  <input name="tw_isactive" type="radio" value="1" <?php  echo set_value('tw_isactive', $twitter_isactive) == 1 ? "checked" : "";?>>Yes
                  <input name="tw_isactive" type="radio" value="0" <?php  echo set_value('tw_isactive', $twitter_isactive) == 0 ? "checked" : "";?>>No
                  <?php echo form_error('tw_isactive'); ?>
                 </div>
              </li> 
             <!--  <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              
 -->
           
           </ul>

                <ul class="frm">
              <li class="social_ico_tag">
                <label>
                  Instagram
                </label>
                <span class="round_btn instagram ">
                  <i class="fa fa-instagram"></i>
                </span>
              </li> 

              
               <li>
                 <div>
                  <label> Key</label>
                   <input name="media_type_ins" type="hidden" value="instagram">
                  <input name="ins_key" type="text" value="<?php echo set_value('ins_key', $instagram_key); ?>">
                  <?php echo form_error('ins_key'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label> Secret</label>
                  <input name="ins_secret" type="text" value="<?php echo set_value('ins_secret', $instagram_secret); ?>">
                  <?php echo form_error('ins_secret'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>Redirect URI</label>
                  <input name="ins_redirect_uri" type="text" value="<?php echo set_value('ins_redirect_uri', $instagram_redirect_uri); ?>">
                  <?php echo form_error('ins_redirect_uri'); ?>
                 </div>
              </li> 
               <li class="social_ico_tag"></li>
               <li class="social_ico_tag"></li>
              <li>
                <div>
                  <label>Least Fan followers</label>
                  <input name="ins_least_fan_count" type="text" value="<?php echo set_value('ins_least_fan_count', $instagram_least_fan_count); ?>">
                  <?php echo form_error('ins_least_fan_count'); ?>
                 </div>
              </li> 
               <li class="socio_radio">
                <div>
                  <label>Enable</label>
                  <input name="ins_isactive" type="radio" value="1" <?php  echo set_value('ins_isactive', $instagram_isactive) == 1 ? "checked" : "";?>>Yes
                  <input name="ins_isactive" type="radio" value="0" <?php  echo set_value('ins_isactive', $instagram_isactive) == 0 ? "checked" : "";?>>No
                  <?php echo form_error('ins_isactive'); ?>
                 </div>
              </li> 
             <!--  <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              
 -->
           
           </ul>

             <ul class="frm">
              <li class="social_ico_tag">
                <label>
                  Youtube
                </label>
                <span class="round_btn youtube ">
                  <i class="fa fa-youtube"></i>
                </span>
              </li> 

              
               <li>
                 <div>
                  <label> Key</label>
                   <input name="media_type_yt" type="hidden" value="youtube">
                  <input name="yt_key" type="text" value="<?php echo set_value('yt_key', $youtube_key); ?>">
                  <?php echo form_error('yt_key'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label> Secret</label>
                  <input name="yt_secret" type="text" value="<?php echo set_value('yt_secret', $youtube_secret); ?>">
                  <?php echo form_error('yt_secret'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>Redirect URI</label>
                  <input name="yt_redirect_uri" type="text" value="<?php echo set_value('yt_redirect_uri', $youtube_redirect_uri); ?>">
                  <?php echo form_error('yt_redirect_uri'); ?>
                 </div>
              </li>
               <li class="social_ico_tag"></li>
               <li class="social_ico_tag"></li>
                 <li>
                <div>
                  <label>Least Fan followers</label>
                  <input name="yt_least_fan_count" type="text" value="<?php echo set_value('yt_least_fan_count', $youtube_least_fan_count); ?>">
                  <?php echo form_error('yt_least_fan_count'); ?>
                 </div>
              </li> 
               <li class="socio_radio">
                <div>
                  <label>Enable</label>
                  <input name="yt_isactive" type="radio" value="1" <?php  echo set_value('yt_isactive', $youtube_isactive) == 1 ? "checked" : "";?>>Yes
                  <input name="yt_isactive" type="radio" value="0" <?php  echo set_value('yt_isactive', $youtube_isactive) == 0 ? "checked" : "";?>>No
                  <?php echo form_error('yt_isactive'); ?>
                 </div>
              </li> 
             <!--  <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              
 -->
           
           </ul>
            <ul class="frm">
              <li class="social_ico_tag">
                <label>
                  Youtulee
                </label>
                <span class="round_btn youtulee btn-youtulee ">
                 <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="20px">
                </span>
              </li> 

              
               <li>
                 <div>
                  <label> Key</label>
                   <input name="media_type_ytl" type="hidden" value="youtulee">
                  <input name="ytl_key" type="text" value="<?php echo set_value('ytl_key', $youtulee_key); ?>">
                  <?php echo form_error('ytl_key'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label> Secret</label>
                  <input name="ytl_secret" type="text" value="<?php echo set_value('ytl_secret', $youtulee_secret); ?>">
                  <?php echo form_error('ytl_secret'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>Redirect URI</label>
                  <input name="ytl_redirect_uri" type="text" value="<?php echo set_value('ytl_redirect_uri', $youtulee_redirect_uri); ?>">
                  <?php echo form_error('ytl_redirect_uri'); ?>
                 </div>
              </li> 
               <li class="social_ico_tag"></li>
               <li class="social_ico_tag"></li>
               <li>
                <div>
                  <label>Least Fan followers</label>
                  <input name="ytl_least_fan_count" type="text" value="<?php echo set_value('ytl_least_fan_count', $youtulee_least_fan_count); ?>">
                  <?php echo form_error('ytl_least_fan_count'); ?>
                 </div>
              </li> 
               <li class="socio_radio">
                <div>
                  <label>Enable</label>
                  <input name="ytl_isactive" type="radio" value="1" <?php  echo set_value('ytl_isactive', $youtulee_isactive) == 1 ? "checked" : "";?>>Yes
                  <input name="ytl_isactive" type="radio" value="0" <?php  echo set_value('ytl_isactive', $youtulee_isactive) == 0 ? "checked" : "";?>>No
                  <?php echo form_error('ytl_isactive'); ?>
                 </div>
              </li> 
           </ul>
             <ul class="frm">
              <li class="social_ico_tag">
                <label>
                  Tumblr
                </label>
                   <span class="round_btn tumblr"><i class="fa fa-tumblr"></i>
                   </span>
              </li> 

              
               <li>
                 <div>
                  <label> Key</label>
                   <input name="media_type_tb" type="hidden" value="tumblr">
                  <input name="tb_key" type="text" value="<?php echo set_value('tb_key', $tumblr_key); ?>">
                  <?php echo form_error('tb_key'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label> Secret</label>
                  <input name="tb_secret" type="text" value="<?php echo set_value('tb_secret', $tumblr_secret); ?>">
                  <?php echo form_error('tb_secret'); ?>
                 </div>
              </li> 
              <li>
              
                <div>
                  <label>Redirect URI</label>
                  <input name="tb_redirect_uri" type="text" value="<?php echo set_value('tb_redirect_uri', $tumblr_redirect_uri); ?>">
                  <?php echo form_error('tb_redirect_uri'); ?>
                 </div>
              </li> 
               <li class="social_ico_tag"></li>
               <li class="social_ico_tag"></li>
               <li>
                <div>
                  <label>Least Fan followers</label>
                  <input name="tb_least_fan_count" type="text" value="<?php echo set_value('tb_least_fan_count', $tumblr_least_fan_count); ?>">
                  <?php echo form_error('tb_least_fan_count'); ?>
                 </div>
              </li> 
               <li class="socio_radio">
                <div>
                  <label>Enable</label>
                  <input name="tb_isactive" type="radio" value="1" <?php  echo set_value('tb_isactive', $tumblr_isactive) == 1 ? "checked" : "";?>>Yes
                  <input name="tb_isactive" type="radio" value="0" <?php  echo set_value('tb_isactive', $tumblr_isactive) == 0 ? "checked" : "";?>>No
                  <?php echo form_error('tb_isactive'); ?>
                 </div>
              </li> 
             <!--  <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              <li>
                <div>
                  <label>No of Auction Post(Free)</label>
                  <input name="no_auction_post_free" type="text" value="<?php echo set_value('no_auction_post_free', $site_set['no_auction_post_free']); ?>">(0 for no free auction posts, 99999 for unlimited, or any number)
                  <?php echo form_error('no_auction_post_free'); ?>
                 </div>
              </li> 
              
 -->
           
           </ul>
          </fieldset>          
          <fieldset>
            <div class="title_h3">Find us</div>
            <ul class="frm">
              
			  <li>
                <div>
                  <label>Facebook Link<span>*</span> :</label>
                  <input name="facebook" type="text" class="inputtext" id="facebook" value="<?php echo set_value('facebook',$site_set['facebook']);?>" size=45>
                  <?=form_error('facebook')?>
                </div>
              </li>
              
              <li>
                <div>
                  <label>Twitter Link<span>*</span> :</label>
                  <input type="text" name="twitter" class="inputtext" size="45" value="<?php echo set_value('twitter',$site_set['twitter']);?>" />
                </div>
              </li>
              
			  
			  <li>
                <div>
                  <label>Google Plus Link<span>*</span> :</label>
                  <input type="text" name="google_plus" class="inputtext" size="45" value="<?php echo set_value('google_plus',$site_set['google_plus']);?>" />
                </div>
              </li>
              
              <li>
                <div>
                  <label>LinkedIn Link<span>*</span> :</label>
                  <input type="text" name="linkedin" class="inputtext" size="45" value="<?php echo set_value('linkedin',$site_set['linkedin']);?>" />
                </div>
              </li>
              
              <!-- <li>
                <div>
                  <label>Pinterest Link<span>*</span> :</label>
                  <input type="text" name="pinterest" class="inputtext" size="45" value="<?php echo set_value('pinterest',$site_set['pinterest']);?>" />
                </div>
              </li>
               -->
              <!-- <li>
                <div>
                  <label>Rss Link <span>*</span>:</label>
                  <input type="text" name="rss_url" class="inputtext" size="45" value="<?php echo set_value('rss_link',$site_set['rss_url']);?>" />
                </div>
              </li> -->
           
			 <!--  <li>
                <div>
                  <label>Facebook App Id<span>*</span> :</label>
                  <input name="facebook_app_id" type="text" class="inputtext" id="facebook_app_id" value="<?php echo set_value('facebook_app_id',$site_set['facebook_app_id']);?>" size=45>
                  <?=form_error('facebook_app_id')?>
                </div>
              </li>
              
              
              <li>
                <div>
                  <label>Google Plus App Key<span>*</span> :</label>
                  <input name="googleplus_app_key" type="text" class="inputtext" id="googleplus_app_key" value="<?php echo set_value('googleplus_app_key',$site_set['googleplus_app_key']);?>" size=45>
                  <?=form_error('googleplus_app_key')?>
                </div>
              </li>
              
			  
              <li>
                <div>
                  <label>Google Plus App Client Id<span>*</span> :</label>
                  <input name="googleplus_app_client_id" type="text" class="inputtext" id="googleplus_app_client_id" value="<?php echo set_value('googleplus_app_client_id',$site_set['googleplus_app_client_id']);?>" size=45>
                  <?=form_error('googleplus_app_client_id')?>
                </div>
              </li> -->
			</ul>
          </fieldset>

          <fieldset>
            <div class="title_h3">Others</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Google Analytics Code<span>*</span> :</label>
                  <textarea name="google_analytics_code" cols="34" rows="3" id="google_analytics_code"><?php echo set_value('google_analytics_code',$site_set['google_analytics_code']);?></textarea>
  					<?=form_error('google_analytics_code')?>
                </div>
              </li>
              <?php if(SMS_NOTIFICATION==1):?>
              <li>
                <div>
                  <label>SMS Gateway Url :</label>
                  <input type="text" name="sms_gateway_url" class="sms_gateway_url" size="45" value="<?php echo set_value('sms_gateway_url',$site_set['sms_gateway_url']);?>" /><?=form_error('sms_gateway_url')?>
                </div>
              </li>
              <li>
                <div>
                  <label>SMS API Username :</label>
                  <Input type="text" name="sms_api_username" id="sms_api_username" value="<?php echo set_value('sms_api_username',$site_set['sms_api_username']);?>">
                  <?=form_error('sms_api_username')?>
                </div>
              </li>
              <li>
                <div>
                  <label>SMS API Password :</label>
                  <input type="password" name="sms_api_password" id="sms_api_password" value="<?php echo set_value('sms_api_password',$site_set['sms_api_password']);?>">
                <?=form_error('sms_api_password')?>
                </div>
              </li>
            <?php endif;?> 
            </ul>
          </fieldset>
          
          <fieldset class="btn">
            <input class="butn" type="submit" name="Submit" value="Update" />
          </fieldset>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>

<script>
$("input:radio[name=site_status]").click(function() {
    //var value = $(this).val();
    //console.log(value);
    if ($(this).val() == '3') {
        $('#maintainanceKeyHolder').show();
    } else {
        $('#maintainanceKeyHolder').hide();
    }
});

if ($('input[name=site_status]:checked', '#siteSettingsForm').val() == '3') {
    $('#maintainanceKeyHolder').show();
} else {
    $('#maintainanceKeyHolder').hide();
}
</script>
