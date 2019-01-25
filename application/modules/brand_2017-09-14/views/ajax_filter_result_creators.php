<div class="col-sm-12"> 
  <!--  <h4 class="text-center result_ttl">Here are some of our <b><?php echo count($creators);?> Creators</b>. <a href="#">Create a campaign</a> to start inviting!</h4> -->
  <ul class="list-unstyled product_listing">
    <?php 
if($account_menu_active=='create_campaign' && $product_id)
{
  $creatorslist=$product['creators'];  
}
else
{
  if($this->input->post('creators',true)) $creatorslist=$this->input->post('creators',true);else $creatorslist=array();
}

$creatorarr=array();
if(is_array($creatorslist) && count($creatorslist)>0)
{
 foreach($creatorslist as $creatdata)
    {
  
      $creatorarr[]=$creatdata->user_id;
    }
}
        if(is_array($creators) && count($creators)>0) :
                 foreach ($creators as $key => $percreator) {
              
                if($percreator['country']!='') $country=$percreator['country'];
                elseif ($percreator['user_country']!='') $country=$percreator['user_country'];
                  else $country='Unknown';
                         if($percreator['audience_country']!='') $audience_country=$percreator['audience_country'];
                       else $audience_country='Unknown';

                  if($percreator['category_id']=='0') $category='Other';
                  else $category=$percreator['category_id'];
                 ?>
    <li class="relative">
      <?php 
          if($percreator['available_status']=='1')
              {
                $status='Available';
                $class='available';
              }
              else{
                $status='Busy';
                $class='away';
              }
              ?>
      <span class="status_indicator"> <i class="fa fa-circle <?php echo $class;?>"></i> <?php echo $status;?> </span>
      <div class="row">
        <div class="col-xs-5 col-sm-3">
          <?php 
                  $pp=$this->general->get_profile_image($percreator['cover_image']); 
                  ?>
          <?php if($account_menu_active=='create_campaign' && $percreator['available_status']=='1') : ?>
          <a class="image" href="#"> <span class="btn btn-info price_range checkbox_styled">
          <input type="checkbox" name="creatorselected[]" <?php if(in_array($percreator['user_id'],$creatorarr)) echo 'checked'  ?> class="creatorslist checkbox" value="<?php echo $percreator['user_id'];?>">
          <input type="hidden" class="individualcreatorcost" value="<?php echo $percreator['price'];?>">
          </span>
          <?php 

                    endif;?>
          <img id="profilecreator_<?php echo $percreator['user_id'];?>" src="<?php echo $pp;?>" class="creatorprofile"> </a> </div>
        <div class="col-xs-7 col-sm-9">
          <h4> <a href="<?php echo site_url('/'.BRAND.'profile/'. $percreator['user_id'])?>"><?php echo $percreator['member_name'];?></a> <span class="f_search_media_links">
            <?php 
                    if($percreator['media'])
                    { 
                    $socialmedia=explode(',',$percreator['media']);

                    foreach($socialmedia as $mediaitem)
                    { 
                    if($mediaitem=='facebook')
                    {
                    ?>
            <span class="pull-right round_btn facebook"> <i class="fa fa-facebook-f"></i> </span>
            <?php
                    }
                    if($mediaitem=='twitter')
                    {
                    ?>
            <span class="pull-right round_btn twitter"> <i class="fa fa-twitter-square"></i> </span>
            <?php
                    }
                    if($mediaitem=='instagram')
                    {
                    ?>
            <span class="pull-right round_btn instagram"> <i class="fa fa-instagram"></i> </span>
            <?php
                    }
                    if($mediaitem=='youtube')
                    {
                    ?>
            <span class="pull-right round_btn youtube"> <i class="fa fa-youtube-play"></i> </span>
            <?php
                    }
                    if($mediaitem=='youtulee')
                    {
                    ?>
            <span class="pull-right round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
            <?php
                    }
                    if($mediaitem=='tumblr')
                    {
                    ?>
            <span  class="round_btn  pull-right tumblr"><i class="fa fa-tumblr"></i></span>
            <?php
                    }
                    }
                    ?>
            <?php 
                    }
                    ?>
            </span> </h4>
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-6">
              <h5>REACH <span><?php echo $percreator['total_reach']?></span></h5>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <h5>Ceiling Likes <span><?php echo $percreator['ceiling_likes'];?></span></h5>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <h5>Gender <span>
                <?php if($percreator['gender']=='m') echo 'Male';elseif ($percreator['gender']=='f') echo 'Female'; else echo 'Other';?>
                </span></h5>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <h5>Age <span><?php echo $percreator['age'];?> Year(s)</span></h5>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <h5>Profession <span><?php echo $percreator['profession'];?></span></h5>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <h5>AVERAGE PRICE <span><?php echo DEFAULT_CURRENCY_SIGN.'. '. $percreator['price'];?></span></h5>
            </div>
          </div>
          <?php if($account_menu_active!='create_campaign') : ?>
          <div class="text-uppercase"> <a href="#" class="btn btn-sm btn-primary invitecreator" data-userid="<?php echo $percreator['user_id'];?>"><i class="fa fa-paper-plane "></i> Inquire</a> <a href="<?php echo site_url('/'.BRAND.'profile/'. $percreator['user_id'])?>" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a> </div>
          <?php endif;?>
        </div>
        <div> </div>
      </div>
    </li>
    <?php
                 }
              else :
                echo 'No Records Found';
              endif;
                ?>
  </ul>
</div>
<div class="clearfix"></div>