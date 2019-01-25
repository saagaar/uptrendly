<?php 
          $profile=array();
           $mediaassoc=array();
        if(count($mediadetail)>0){
          foreach($mediadetail as $allmedia)
          {
            $mediaassoc[]=$allmedia->media_type_id;

          }
        }
      if(is_array($mediaprofile) && count($mediaprofile)>0){
       foreach($mediaprofile as $value)
        {
          $profile[$value->media_id][]=$value->url;
        }
      }

 ?>

<div class="mid-part">
  <div class="content_sec">
    <div class="public_pfl">
      <div class="col-sm-7">
        <?php 
           $data['mediaassoc']=$mediaassoc;
           $data['mediadetail']=$mediadetail;
           $this->load->view('v_user_profile_sidebar',$data);?>
      </div>
      <div class="col-sm-5 no-pad-left">
          <?php 
  // if(count($user_info['socialmediaprofile'])<1):
  //     echo 'No Profile has been set ';
  // else:
  //   echo 'yes';
          ?>
        
          <?php 

        $media=array();
        foreach ($user_info['socialmediaprofile'] as $key => $value) {
          $media[$value->media_id][]=$value;
        }

      
          
        
    
  // $firstelement=0;
  $align=0;
  // if( defined('FACEBOOKMEDIAID') && in_array(FACEBOOKMEDIAID,$mediaassoc)): ?>
          <div  id="tab-fb" class="profile_s_links" >
                          <?php

                             foreach($mediaassoc as $eachmedia): 
                              if(defined('FACEBOOKMEDIAID') && $eachmedia==FACEBOOKMEDIAID && array_key_exists(FACEBOOKMEDIAID,$profile)):
                               ?>
                               <label> <span class="pull-right round_btn facebook"> <i class="fa fa-facebook-f"></i> </span>
                              </label>
                              <?php
                              endif;
                               if(defined('INSTAGRAMMEDIAID') &&  $eachmedia==INSTAGRAMMEDIAID && array_key_exists(INSTAGRAMMEDIAID,$profile)):
                              ?>
                               <label>   <span class="pull-right round_btn instagram"> <i class="fa fa-instagram"></i> </span>
                              </label>
                              <?php
                              endif;
                               if(defined('TWITTERMEDIAID')  &&  $eachmedia==TWITTERMEDIAID && array_key_exists(TWITTERMEDIAID,$profile)):
                              ?>
                              <label>
                                     <span class="pull-right round_btn twitter"> <i class="fa fa-twitter-square"></i> 
                                     </span>
                              </label>
                              <?php
                              endif;
                               if(defined('YOUTUBEMEDIAID') &&  $eachmedia==YOUTUBEMEDIAID && array_key_exists(YOUTUBEMEDIAID,$profile)):
                              ?>
                               <label>  <span class="pull-right round_btn youtube"> <i class="fa fa-youtube-play"></i> </span>
                              </label>
                              <?php
                              endif;
                              if(array_key_exists($eachmedia,$profile)):
                                foreach($profile[$eachmedia] as $eachdata):
                              ?>
                                <p>
                                   <a href="<?php echo $eachdata?>" target="_blank"><?php echo $eachdata?></a> 
                                </p>
                            
                            <?php
                               endforeach;
                            endif;
                            endforeach;?>
                       <div class="clearfix"></div>
          </div>
          <?php 

  $firstelement=1;

  
  $align=0;
   if(defined('YOUTULEEMEDIAID') && in_array(YOUTULEEMEDIAID,$mediaassoc)):

  ?>
          <div  id="tab-ytl" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in"> </div>
          <?php

  $firstelement=1;
  endif;?>
          <?php  
$align=0;
   if(defined('TUMBLRMEDIAID') && in_array(TUMBLRMEDIAID,$mediaassoc)):

  ?>
          <div  id="tab-tmb" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">
            <?php 
  if(array_key_exists(TUMBLRMEDIAID,$media)):
    if(isset($media[TUMBLRMEDIAID])) :       
      foreach($media[TUMBLRMEDIAID] as $tmprofile):
        /****************Tumblr oembed request url****************/
     
   $tbdata = @file_get_contents('https://www.tumblr.com/oembed/1.0?url='.$tmprofile->url.'&omit_script=true');

          $tmbarr = json_decode($tbdata, true);
   
                          
          ?>
            <a class="modalprofile" href="javascript:void(0)" data-toggle="modal" data-media="tumblr" data-url="<?php echo $tmprofile->url;?>" >
            <?php if($align%2==0):

          ?>
            <div class="p_item">
              <div class="p_cntnt"> 
                <!-- <img src="<?php echo $json_data['items']['0']['snippet']['thumbnails']['default']['url']?>" alt="" class="pp"> -->
                <div class="p_item_cmt yt">
                  <h4><?php echo $tmbarr['html']?></h4>
                </div>
                <div class="scio_cnt"> <span class="col-sm-6 no-pad-sides vw"> <span class="vw_ttl">Followers</span> <span class="vw_cnt"></span> </span> <span class="col-sm-6 no-pad-sides lk"> <span class="lk_ttl">Notes</span> <span class="lk_cnt">
                  <?php //echo $fbarr['share']['comment_count']  ?>
                  </span> </span> </div>
                <div class="clearfix"></div>
              </div>
            </div>
            <?php 

      else:?>
            <div class="p_item">
              <div class="p_cntnt"> 
                <!-- <img src="<?php echo $json_data['items']['0']['snippet']['thumbnails']['default']['url']?>" alt="" class="pp"> -->
                <div class="p_item_cmt yt">
                  <h4><?php echo $tmbarr['html']?></h4>
                </div>
                <!-- <div class="scio_cnt">
              <span class="col-sm-6 no-pad-sides vw">
                <span class="vw_ttl">Followers</span>
                <span class="vw_cnt"><?php //echo $fbarr['share']['comment_count']  ?></span>
              </span>
              <span class="col-sm-6 no-pad-sides lk">
                <span class="lk_ttl">Notes</span>
                <span class="lk_cnt"><?php //echo $fbarr['share']['comment_count']  ?></span>
              </span>
            </div> -->
                <div class="clearfix"></div>
              </div>
            </div>
            <?php 
        endif;?>
            </a>
            <?php
        $align++;

     

      endforeach;
      endif;
       endif;
      ?>
            <div class="clearfix"></div>
          </div>
          <?php

  $firstelement=1;
  endif;
 
  ?>          
        </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

<!-- Modal -->
<?php $this->load->view('popup_post'); ?>
<!-- invitation to creators -->
<div id="invite_creators" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="sendprop_modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
        <div class="sendprop_modal_container">
          <div class="modal_title">
            <h2>Invite Creator</h2>
            <p>You can invite creators to submit a proposal for a campaign below</p>
            <div style="clear: both;"></div>
          </div>
          <form name="sendinvitation" id="sendinvitation" action="#" method="post">
            <input type="hidden" name="userid" id="inviteuser" value="">
            <div class="body">
              <div class="col-sm-12 clearfix">
                <div class="col-sm-12">
                  <div class="invite_img">
                    <div class="img_box"> <img src="" class="center" id="profilepicturecreator"> </div>
                  </div>
                </div>
                <div class="col-sm-12 alert-pad-sides" id="invitesent" style="display:none;color:red">
                  <div class="alert alert-danger error-message"> </div>
                </div>
                <div class="form-group">
                  <label>Select Campaign:</label>
                  <select class="form-control" name="product_id">
                    <?php 
                               foreach($campaigns as $value){
                                  ?>
                    <option  value="<?php echo $value->id;?>"><?php echo $value->name?></option>
                    <?php
                                  }
                                  ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 clearfix">
                <textarea  rows="8" class="form-control" id="message" name="message" placeholder="Message(optional)"></textarea>
                <div class="clear"></div>
              </div>
              <div class=" col-sm-12 bottom_content text-center">
                <button class="btn btn-success" id="sendinvitationbtn">
                <div class="btn-img" style="float:left">
                  <div class="img-loader" style="z-index:1000;display: none;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
                  <i class="fa fa-check createcheck"></i> </div>
                Send Proposal </button>
              </div>
              <div style="clear: both;"></div>
            </div>
          </form>
          <div style="clear: both;"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var embed_posturl='<?php echo site_url('/'.BRAND.'get_embed_post');?>';
 $(document).ready(function(){
  $('ul.tabs li').click(function(){
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs li').removeClass('current');
    $('.tab-content').removeClass('current in');
    $(this).addClass('current');
    $("#"+tab_id).addClass('current in');
             // alert($("#cnt-"+tab_id).attr('class'));
             $("#cnt-"+tab_id).addClass('current');
           })
})
var sendinvitation='<?php echo site_url('/'.BRAND.'inviteuser');?>'
</script> 