          <div class="content_sec inn_content">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  <?php 
  $mediaassoc=array();
  if(count($mediadetail)>0){
    foreach($mediadetail as $allmedia)
    {
      $mediaassoc[]=$allmedia->media_type_id;
    }
  }
  if(defined('YOUTUBEMEDIAID') && in_array(YOUTUBEMEDIAID,$mediaassoc)):?>
      <li role="presentation" <?php if($mediaassoc['0']==YOUTUBEMEDIAID):?> class="active" <?php endif;?>><a href="#ep_youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
  <?php endif;
  if(defined('TWITTERMEDIAID') && in_array(TWITTERMEDIAID,$mediaassoc)):?>
          <li role="presentation" <?php if($mediaassoc['0']==TWITTERMEDIAID):?> class="active"  <?php endif;?>><a href="#ep_twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
 <?php endif;
  if(defined('INSTAGRAMMEDIAID') && in_array(INSTAGRAMMEDIAID,$mediaassoc)):?>
          <li role="presentation" <?php if($mediaassoc['0']==INSTAGRAMMEDIAID):?> class="active"  <?php endif;?>><a href="#ep_instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
 <?php endif;
  if(defined('FACEBOOKMEDIAID') && in_array(FACEBOOKMEDIAID,$mediaassoc)):?>
           <li role="presentation" <?php if($mediaassoc['0']==FACEBOOKMEDIAID):?> class="active"  <?php endif;?>><a href="#ep_facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
 <?php endif;
  if(defined('YOUTULEEMEDIAID') && in_array(YOUTULEEMEDIAID,$mediaassoc)):?>
             <li role="presentation" <?php if($mediaassoc['0']==YOUTULEEMEDIAID):?> class="active"  <?php endif;?>><a href="#ep_youtulee" aria-controls="settings" role="tab" data-toggle="tab">Youtulee  <span class="round_btn youtulee"><img src="../themes/user/images/push.png" alt=""></span></a></li>
 <?php endif;
  if(defined('TUMBLRMEDIAID') && in_array(TUMBLRMEDIAID,$mediaassoc)):?>
            <li role="presentation" <?php if($mediaassoc['0']==TUMBLRMEDIAID):?> class="active"  <?php endif;?>><a href="#ep_tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>
 <?php endif;
  ?> 
  </ul>
  <!-- Tab panes -->
  <?php 
  $data=array();

  foreach($mediaprofile as $value)
  {
    $data[$value->media_id][]=$value->url;
  } 
  ?>
  <div class="tab-content gap_formgroup">
<?php
   if(defined('TUMBLRMEDIAID') && in_array(YOUTUBEMEDIAID,$mediaassoc)):?>
       <div role="tabpanel" class="tab-pane fade in <?php if($mediaassoc['0']==YOUTUBEMEDIAID):?> active<?php endif;?>" id="ep_youtube" >
    <form name="saveprofile" id="saveprofileyoutube" type="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saveprofileurl')?>">
    <div class="linkurl">
    <input type="hidden" name="media"  value="youtube"  />
  <?php 
    $i=0;
     if(array_key_exists(YOUTUBEMEDIAID, $data)){
         foreach ($data[YOUTUBEMEDIAID] as  $value) : 
            if($i==0){
                $url='URL';
                $extra='';
            }
            else{
              $url='';
              $extra='<div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>';
            }
            ?>
              <div class="form-group">
                      <div class="col-xs-2"><label><?php echo $url;?></label></div>
                      <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" value="<?php echo $value;?>"/></div><?php echo $extra;?>
              </div>
            <?php
            $i++;
       endforeach;
     }
     else{ ?>
        <div class="form-group">
            <div class="col-xs-2"><label>URL</label></div>
            <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" /></div>
          </div>
    <?php }
  ?>   
      </div>
      <div class="clearfix"></div>
      <div class="form-group">
                         <button class="btn btn-info saveurlbtn text-right " data-menuactive='youtube' type="submit" >
                                       <div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div> 
                                         <i class="fa fa-save createcheck"></i> 
                                      </div>
                                      Save
                          </button>
              </div>
      <div class="url_add" data-menuactive='youtube'><a href="javascript:void(0)">+ Add More</a></div>
      <div class="clearfix"></div>
      </form>
    </div>
  <?php endif;
  if(defined('TWITTERMEDIAID') &&  in_array(TWITTERMEDIAID,$mediaassoc)):?>
                <div role="tabpanel" class="tab-pane fade in <?php if($mediaassoc['0']==TWITTERMEDIAID):?> active<?php endif;?>" id="ep_twitter">
    <form name="saveprofiletwitter" id="saveprofiletwitter" type="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saveprofileurl')?>">
    <input type="hidden" name="media"  value="twitter"  />
      <div class="linkurl">
          <?php 
    $i=0;
     if(array_key_exists(TWITTERMEDIAID, $data)){
         foreach ($data[TWITTERMEDIAID] as  $value) : 
            if($i==0){
                $url='URL';
                $extra='';
            }
            else{
              $url='';
              $extra='<div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>';
            }
            ?>
              <div class="form-group">
                      <div class="col-xs-2"><label><?php echo $url;?></label></div>
                      <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" value="<?php echo $value;?>"/></div><?php echo $extra;?>
              </div>
            <?php
            $i++;
       endforeach;
     }
     else{ ?>
        <div class="form-group">
            <div class="col-xs-2"><label>URL</label></div>
            <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" /></div>
          </div>
    <?php }
  ?>
      </div>
     <div class="form-group">
                         <button class="btn btn-info saveurlbtn text-right" data-menuactive='twitter' type="submit" >
                                       <div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-save createcheck"></i> 
                                      </div>
                                      Save
                          </button>
              </div>
         <div class="url_add" data-menuactive='twitter'><a href="javascript:void(0)"> + Add More</a></div>
          <div class="clearfix"></div>
      </form>
    </div>
 <?php endif;
  if(defined('INSTAGRAMMEDIAID') && in_array(INSTAGRAMMEDIAID,$mediaassoc)):?>
    <div role="tabpanel" class="tab-pane fade in <?php if($mediaassoc['0']==INSTAGRAMMEDIAID):?> active<?php endif;?>" id="ep_instagram">
    <form name="saveprofileinstagram" id="saveprofileinstagram" type="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saveprofileurl')?>">
    <input type="hidden" name="media"  value="instagram"  />
     <div class="linkurl">
        <?php 
    $i=0;

    if(array_key_exists(INSTAGRAMMEDIAID, $data)){
         foreach ($data[INSTAGRAMMEDIAID] as  $value) : 
            if($i==0){
                $url='URL';
                $extra='';

            }
            else{
              $url='';
              $extra='<div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>';
            }
            ?>
              <div class="form-group">
                      <div class="col-xs-2"><label><?php echo $url;?></label></div>
                      <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" value="<?php echo $value;?>"/></div><?php echo $extra;?>
              </div>
            <?php
            $i++;
       endforeach;
     }
     else{ 

      ?>
        <div class="form-group">
            <div class="col-xs-2"><label>URL</label></div>
            <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" /></div>
          </div>
    <?php }
  ?>
     </div>
       <div class="form-group">
                         <button class="btn btn-info saveurlbtn text-right" data-menuactive='instagram' type="submit" >
                                       <div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-save createcheck"></i> 
                                      </div>
                                      Save
                          </button>
              </div>
        <div class="url_add" data-menuactive='instagram'><a href="javascript:void(0)">+ Add More</a></div>     
        <div class="clearfix"></div>
      </form>
    </div>
 <?php endif;
  if(defined('FACEBOOKMEDIAID') && in_array(FACEBOOKMEDIAID,$mediaassoc)):?>
                
    <div role="tabpanel" class="tab-pane fade in <?php if($mediaassoc['0']==FACEBOOKMEDIAID):?> active<?php endif;?>" id="ep_facebook">
    <form name="saveprofilefacebook" id="saveprofilefacebook" type="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saveprofileurl')?>">
    <input type="hidden" name="media"  value="facebook"/>
     <div class="linkurl">
         <?php 
    $i=0;
     if(array_key_exists(FACEBOOKMEDIAID, $data)){
         foreach ($data[FACEBOOKMEDIAID] as  $value) : 
            if($i==0){
                $url='URL';
                $extra='';

            }
            else{
              $url='';
              $extra='<div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>';
            }
            ?>
              <div class="form-group">
                      <div class="col-xs-2"><label><?php echo $url;?></label></div>
                      <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" value="<?php echo $value;?>"/></div><?php echo $extra;?>
              </div>
            <?php
            $i++;
       endforeach;
     }
     else{ ?>
        <div class="form-group">
            <div class="col-xs-2"><label>URL</label></div>
            <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" /></div>
          </div>
    <?php }
  ?>
     </div>
       <div class="form-group">
                         <button class="btn btn-info saveurlbtn text-right" data-menuactive='facebook' type="submit" >
                                       <div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-save createcheck"></i> 
                                      </div>
                                      Save
                          </button>
              </div>
        <div class="url_add" data-menuactive='facebook'><a href="javascript:void(0)">+ Add More</a></div>   
        <div class="clearfix"></div>
      </form>
    </div>
 <?php endif;
  if( defined('YOUTULEEMEDIAID') &&  in_array(YOUTULEEMEDIAID,$mediaassoc)):
 
  ?>
           <div role="tabpanel" class="tab-pane fade in <?php if($mediaassoc['0']==YOUTULEEMEDIAID):?> active<?php endif;?>" id="ep_youtulee">
    <form name="saveprofileyoutulee" id="saveprofileyoutulee" type="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saveprofileurl')?>">
    <input type="hidden" name="media"  value="youtulee"  />
       <div class="linkurl">
          <?php 
    $i=0;
     if(array_key_exists(YOUTULEEMEDIAID, $data)){
         foreach ($data[YOUTULEEMEDIAID] as  $value) : 
            if($i==0){
                $url='URL';
                $extra='';

            }
            else{
              $url='';
              $extra='<div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>';
            }
            ?>
              <div class="form-group">
                      <div class="col-xs-2"><label><?php echo $url;?></label></div>
                      <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" value="<?php echo $value;?>"/></div><?php echo $extra;?>
              </div>
            <?php
            $i++;
       endforeach;
     }
     else{ ?>
        <div class="form-group">
            <div class="col-xs-2"><label>URL</label></div>
            <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" /></div>
          </div>
    <?php }
  ?>
      </div>
        <div class="form-group">
                         <button class="btn btn-info saveurlbtn text-right" data-menuactive='youtulee' type="submit" >
                                       <div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-save createcheck"></i> 
                                      </div>
                                      Save
                          </button>
              </div>
        <div class="url_add" data-menuactive='youtulee'><a href="javascript:void(0)">+ Add More</a></div>   
        <div class="clearfix"></div>
    </form>
    </div>
 <?php endif;
  if(defined('TUMBLRMEDIAID') && in_array(TUMBLRMEDIAID,$mediaassoc)):?>
           <div role="tabpanel" class="tab-pane fade in <?php if($mediaassoc['0']==TUMBLRMEDIAID):?> active<?php endif;?>" id="ep_tumblr">
    <form name="saveprofiletumblr" id="saveprofiletumblr" type="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saveprofileurl')?>"><input type="hidden" name="media"  value="tumblr"  />
       <div class="linkurl">
           <?php 
    $i=0;
     if(array_key_exists(TUMBLRMEDIAID, $data)){
         foreach ($data[TUMBLRMEDIAID] as  $value) : 
            if($i==0){
                $url='URL';
                $extra='';

            }
            else{
              $url='';
              $extra='<div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>';
            }
            ?>
              <div class="form-group">
                      <div class="col-xs-2"><label><?php echo $url;?></label></div>
                      <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" value="<?php echo $value;?>"/></div><?php echo $extra;?>
              </div>
            <?php
            $i++;
       endforeach;
     }
     else{ ?>
        <div class="form-group">
            <div class="col-xs-2"><label>URL</label></div>
            <div class="col-xs-8"><input type="text" name="urllist[]" class="form-control profileurl" /></div>
          </div>
    <?php }
  ?>
       </div>
          
             <div class="form-group">
                         <button class="btn btn-info saveurlbtn text-right" data-menuactive='tumblr' type="submit" >
                                       <div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-save createcheck"></i> 
                                      </div>
                                      Save
                          </button>
              </div>
        <div class="url_add" data-menuactive='tumblr'><a href="javascript:void(0)">+ Add More</a></div>   
        <div class="clearfix"></div>
    </form>
    </div>
 <?php endif;
  ?>
  

  </div>

</div>