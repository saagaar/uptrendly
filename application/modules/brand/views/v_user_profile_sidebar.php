<style>
.text-left, .text-left span{ text-align:left;}
.tbl_sec h4 b{ display:block; margin-top:8px;}
.tbl_sec h4{ font-size:15px;}
</style>
<div class="right-pad">
  <?php
  // echo '<pre>';
  // print_r($user_info[]);

  foreach ($mediadetail as $key => $value) 
  {
          $media[$value->media_type_id]=$value;
          $userid=$value->user_id;
  }
  $firstelement=0;
  $prefername='None';
  $preferencesmember=$this->general->get_member_category($userid);
  // print_R($preferencesmember);
  if(is_array($preferencesmember) && count($preferencesmember)>0)
  {
      foreach($preferencesmember as $eachpref)
      {

        $prefername=$eachpref->name.', '.$prefername;
      }
  }
?>
  <div class="profile_rt_br">
  <div class="col-xs-7">
    <div class="pro_pic">
      <?php 

                        $pp=$this->general->get_profile_image($user_info['basicinfo']['cover_image']);
                       
                        ?>
      <img src="<?php echo $pp;?>" alt="" id="profilecreator_<?php echo $userid;?>" class="pp"> </div>
    <div class="pro_name"> <?php echo $user_info['basicinfo']['name'] ;?> <span>
      <?php 
                                        if(trim($user_info['basicinfo']['country'])!='')
                                            echo $user_info['basicinfo']['country'];else echo 'N/A';
                                ?>
      </span> </div>
      </div>      
  <div class="col-xs-5">
  <?php  if(defined('YOUTUBEMEDIAID') && array_key_exists(YOUTUBEMEDIAID,$media) &&  (in_array(YOUTUBEMEDIAID,$mediaassoc))):  ?>                           
    <div id="cnt-tab-yt" class="scio_cnt <?php if($firstelement==0):?> current <?php endif; ?>">
    <div class="text-left">
    <span class="vw"> <span class="vw_ttl">Reach</span> <span class="vw_cnt"><?php echo $media[YOUTUBEMEDIAID]->total_reach?></span> </span>
    <!-- <span class="lk"> <span class="lk_ttl">Avg.Views</span> <span class="lk_cnt"><?php echo $media[YOUTUBEMEDIAID]->avg_reach?></span> </span>  -->
    </div>
    </div>
    <?php 
                        $firstelement=1;
                        endif;               
                          if(defined('TWITTERMEDIAID') && array_key_exists(TWITTERMEDIAID,$media) && in_array(TWITTERMEDIAID,$mediaassoc)): 
                         ?>
    <div id="cnt-tab-twt" class="scio_cnt <?php if($firstelement==0):?> current <?php endif; ?>">
    <div class="text-left">
    <span class="vw"> <span class="vw_ttl">Reach</span> <span class="vw_cnt"><?php echo $media[TWITTERMEDIAID]->total_reach?></span> </span>
    <!-- <span class="lk"> <span class="lk_ttl">Avg.Engage</span> <span class="lk_cnt"><?php echo $media[TWITTERMEDIAID]->avg_reach?></span> </span> -->
    <span class=" lk totalview"> <span class="lk_ttl">Total Views</span> <span class="lk_cnt">2.7K</span> </span>
    </div>
    </div>
    <?php
                            $firstelement=1;
                             endif;
                             if( defined('INSTAGRAMMEDIAID') && array_key_exists(INSTAGRAMMEDIAID,$media) && in_array(INSTAGRAMMEDIAID,$mediaassoc)):
                                 
                                ?>
    <div id="cnt-tab-insta" class="scio_cnt <?php if($firstelement==0):?> current <?php endif; ?> ">
    <div class="text-left">
    <span class="vw"> <span class="vw_ttl">Instagram Reach</span> <span class="vw_cnt"><?php echo $media[INSTAGRAMMEDIAID]->total_reach?></span> </span>
    <!-- <span class="lk"> <span class="lk_ttl">Avg.Engage</span> <span class="lk_cnt"><?php echo $media[INSTAGRAMMEDIAID]->avg_reach?></span> </span>  -->
	</div>
    </div>
    <?php 
                            $firstelement=1;
                              endif;
      if(defined('FACEBOOKMEDIAID') && array_key_exists(FACEBOOKMEDIAID,$media) && in_array(FACEBOOKMEDIAID,$mediaassoc)):
                               
                            ?>
    <div id="cnt-tab-fb" class="scio_cnt <?php if($firstelement==0):?> current <?php endif; ?>">
	<div class="text-left">
          <span class="vw"> <span class="vw_ttl">Facebook Reach</span> <span class="vw_cnt"><?php echo $media[FACEBOOKMEDIAID]->total_reach?></span> </span>
          <!-- <span class="lk"> <span class="lk_ttl">Likes</span> <span class="lk_cnt"><?php echo $media[FACEBOOKMEDIAID]->avg_reach?></span> </span>  -->
      </div>
    </div>
    <?php 
                            $firstelement=1;
                             endif;
                            if(defined('YOUTULEEMEDIAID') && array_key_exists(YOUTULEEMEDIAID,$media)&& in_array(YOUTULEEMEDIAID,$mediaassoc)):
                            ?>
    <div id="cnt-tab-ytl" class="scio_cnt <?php if($firstelement==0):?> current <?php endif; ?>">
      <div class="text-left">
      <span class="vw"> <span class="vw_ttl">Reach</span> <span class="vw_cnt"><?php echo $media[YOUTULEEMEDIAID]->total_reach?></span> </span>
      <span class="lk"> <span class="lk_ttl">Avg. Reach</span> <span class="lk_cnt"><?php echo $media[YOUTULEEMEDIAID]->avg_reach?></span> </span> 
      </div>
    </div>
    <?php 
                            $firstelement=1;
                             endif;
                            if(defined('TUMBLRMEDIAID') && array_key_exists(TUMBLRMEDIAID,$media)&& in_array(TUMBLRMEDIAID,$mediaassoc)):
                            ?>
    <div id="cnt-tab-tmb" class="scio_cnt">
    <div class="text-left">
    <span class="vw"> <span class="vw_ttl">Reach</span> <span class="vw_cnt"><?php echo $media[TUMBLRMEDIAID]->total_reach?></span> </span>
    <span class="lk"> <span class="lk_ttl">Avg. Reach</span> <span class="lk_cnt"><?php echo $media[TUMBLRMEDIAID]->avg_reach?></span> </span> 
	</div>
    </div>
    <?php 
                        $firstelement=1;
                         endif;
                       ?>
    <!--  <div class="btn_sec"> <a class="btn btn-sm btn-success invitecreator" data-userid="<?php echo $userid;?>"><i class="fa fa-send"></i>Send invite</a> 
     <button class="btn btn-sm btn-danger"><i class="fa fa-youtube-play"></i>Youtube</button> 
   </div> -->
  </div>
  <div class="clearfix"></div>
  </div>  
  <div class="tbl_sec" style="padding:10px;">
      <h4 class="col-xs-6">Gender: <b><?php if($user_info['basicinfo']['gender']=='f') echo 'Female' ;elseif($user_info['basicinfo']['gender']=='o') echo 'Other';else echo 'Male';?></b></h4>
      <h4 class="col-xs-6">Age: <b><?php echo $user_info['basicinfo']['age'];?> </b></h4>
      <h4 class="col-xs-6">Ceiling Likes: <b><?php echo $user_info['basicinfo']['ceiling_likes'];?></b></h4>
      <h4 class="col-xs-6">Profession: <b><?php echo $profession;?></b></h4>
      <h4 class="col-xs-12">Preferences: <b><?php echo $prefername;?></b></h4>
      <h4 class="col-xs-12">User Bio: <b><?php echo $user_info['basicinfo']['about_user'];?></b></h4>
    <div class="clearfix"></div>
    <?php 
                        if(count($user_info['audience_geography'])>0) :
                        
                                ?>
    <div class="tbl_ttl">
      <h4>Audience Geography</h4>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Country</th>
          <th>Percentage</th>
        </tr>
      </thead>
      <tbody>
        <?php
                                    foreach($user_info['audience_geography'] as $geo): ?>
        <tr>
          <td><?php echo $geo->country?></td>
          <td><?php echo $geo->number_user?>%</td>
        </tr>
        <?php endforeach;
                                    ?>
      </tbody>
    </table>
    <?php
                            endif; 
                        if(count($user_info['audience_demography'])>0) :
                                ?>
    <div class="tbl_ttl">
      <h4>Audience Demographic</h4>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Age Range</th>
          <th>Female</th>
          <th>Male</th>
        </tr>
      </thead>
      <tbody>
        <?php 
                               
                                    foreach($user_info['audience_demography'] as $demo): ?>
        <tr>
          <td><?php echo $demo->age_range?></td>
          <td><?php echo $demo->number_female?>%</td>
          <td><?php echo $demo->number_male?>%</td>
        </tr>
        <?php endforeach;
                               
                               
                    

                                ?>
      </tbody>
    </table>
    <?php endif;?>
  </div> 
  
</div>