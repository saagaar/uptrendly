<div class="mid-part">
        <div class="content_sec">
            <div class="public_pfl">
                <div class="col-sm-9 no-pad-left">
                    <div class="left-pad">
                    <?php
$json_string = file_get_contents('http://graph.facebook.com/?ids=https://www.facebook.com/photo.php?fbid=1428451857230304&set=a.101464636595706.3463.100001965098027&type=3&theater');
$json = json_decode($json_string, true);
echo '<pre>';
print_r($json);exit;
?>

                    <!-- Nav tabs -->
                        <!-- <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
                            <li role="presentation"><a href="#twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
                            <li role="presentation"><a href="#facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook  <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
                            <li role="presentation"><a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
                            <li role="presentation"><a href="#youtulee" aria-controls="settings" role="tab" data-toggle="tab">YoutuLee <span class="round_btn youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt=""></span></a></li>
                            <li role="presentation"><a href="#tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>                         
                        </ul> -->
<ul class="nav nav-tabs" role="tablist">
                         <?php 
  $mediaassoc=array();
  if(count($mediadetail)>0){
    foreach($mediadetail as $allmedia)
    {
      $mediaassoc[]=$allmedia->media_type_id;
    }
  }
  // $mediaassoc[]=3;
  // $params['url'] = ('https://twitter.com/ekarobar_daily/status/848492338133426176');
     // $params['url'] = 'https://www.facebook.com/photo.php?fbid=804794209673346&set=a.100851133400994.2344.100004283222359&type=3&theater';
      $params['url'] = 'https://www.instagram.com/p/BLrosAiDCs-/?taken-by=saagarchapagain';
 
    // Request URL
     // $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$params['url'];
     $request_url='https://api.instagram.com/oembed/?url='.$params['url'];
   // echo $request_url = 'https://publish.twitter.com/oembed?url=' . $params['url'];
    // print_r(file_get_contents("https://publish.twitter.com/oembed?url=https://twitter.com/ekarobar_daily/status/848492338133426176"));exit;
       print_r(file_get_contents($request_url));exit;
    // Get cURL resource
    $curl1 = curl_init();

    curl_setopt_array($curl1, array(
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_URL => ($request_url),
       
         CURLOPT_SSL_VERIFYPEER=>false,
            CURLOPT_SSL_VERIFYHOST=> false
    ));

    // Send the request
    $response1 = curl_exec($curl1);
    
    // Close request to clear up some resources
    curl_close($curl1);

    // $response = @json_decode($response, true);
    echo '<pre>';
    print_r($response1);exit;
  
  if(in_array(YOUTUBEMEDIAID,$mediaassoc)):?>
      <li role="presentation" <?php if($mediaassoc['0']==YOUTUBEMEDIAID):?> class="active" <?php endif; ?>><a href="#ep_youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
  <?php endif;
  if(in_array(TWITTERMEDIAID,$mediaassoc)):?>
          <li role="presentation" <?php if($mediaassoc['0']==TWITTERMEDIAID):?> class="active"<?php endif; ?>><a href="#ep_twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
 <?php endif;
  if(in_array(INSTAGRAMMEDIAID,$mediaassoc)):?>
          <li role="presentation" <?php if($mediaassoc['0']==INSTAGRAMMEDIAID):?> class="active"<?php endif; ?>><a href="#ep_instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
 <?php endif;
  if(in_array(FACEBOOKMEDIAID,$mediaassoc)):?>
           <li role="presentation" <?php if($mediaassoc['0']==FACEBOOKMEDIAID):?> class="active"<?php endif; ?>><a href="#ep_facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
 <?php endif;
  if(in_array(YOUTULEEMEDIAID,$mediaassoc)):?>
             <li role="presentation" <?php if($mediaassoc['0']==YOUTULEEMEDIAID):?> class="active"<?php endif; ?>><a href="#ep_youtulee" aria-controls="settings" role="tab" data-toggle="tab">Youtulee  <span class="round_btn youtulee"><img src="../themes/user/images/push.png" alt=""></span></a></li>
 <?php endif;
  if(in_array(TUMBLRMEDIAID,$mediaassoc)):?>
            <li role="presentation" <?php if($mediaassoc['0']==TUMBLRMEDIAID):?> class="active"<?php endif; ?>><a href="#ep_tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>
 <?php endif;
  ?>
</ul>
                        <!-- Tab panes -->
                        <?php 
                        // echo '<pre>';
                        // print_r($user_info['socialmediaprofile']);?>
                        <div class="tab-content">
                            <!-- Youtube -->
                            <?php 
                                    if(in_array(YOUTUBEMEDIAID,$mediaassoc)): ?>
                                             <div role="tabpanel" class="tab-pane fade in active" id="youtube">
                                <div class="col-sm-6 p_item left">
                                    <div class="p_cntnt">
                                       <img src="<?php echo site_url('/'.USER_IMG_DIR.$user_info['basicinfo']['cover_image'])?>" alt="" class="pp">
                                        <div class="p_item_cmt yt">
                                            <h4>Contrail Clouds</h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Views</span>
                                                <span class="vw_cnt">1K</span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt">none</span>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 p_item right">
                                    <div class="p_cntnt">
                                    <img src="<?php echo site_url('/'.USER_IMG_DIR.$user_info['basicinfo']['cover_image'])?>" alt="" class="pp">
                                        <div class="p_item_cmt yt">
                                            <h4>Lost In The Scene</h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Views</span>
                                                <span class="vw_cnt">2.7K</span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt">2.7K</span>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                     
                                <div class="clearfix"></div>
                            </div>
                            <?php   endif; ?>
                                
                            <?php   if(in_array(TWITTERMEDIAID,$mediaassoc)):?>

                            <!--twitter-->
                            <div role="tabpanel" class="tab-pane fade in" id="twitter">
                                <div class="col-sm-6 p_item left">
                                    <div class="p_cntnt">
                                        <img src="imgs/contrail.jpg" alt="vd">
                                        <div class="p_item_cmt">
                                            <h4>Contrail Clouds</h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Retweets</span>
                                                <span class="vw_cnt">2.7K</span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt">2.7K</span>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 p_item right">
                                    <div class="p_cntnt">
                                        <img src="imgs/look-out.jpg" alt="vd">
                                        <div class="p_item_cmt">
                                            <h4>Lost In The Scene</h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Retweets</span>
                                                <span class="vw_cnt">2.7K</span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt">2.7K</span>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                                             
                                <div class="clearfix"></div>
                            </div>
                            <?php   endif;?>
                            <?php   if(in_array(INSTAGRAMMEDIAID,$mediaassoc)):?>
                                    <div role="tabpanel" class="tab-pane fade in" id="instagram">
                                    </div>
                             <?php   endif;?>
                            <?php   if(in_array(FACEBOOKMEDIAID,$mediaassoc)):?>

                                      <!--facebook-->
                            <div role="tabpanel" class="tab-pane fade in" id="facebook">
                                <div class="col-sm-6 p_item left">
                                    <div class="p_cntnt">
                                        <img src="imgs/contrail.jpg" alt="vd">
                                        <div class="p_item_cmt">
                                            <h4>Contrail Clouds</h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Shares</span>
                                                <span class="vw_cnt">2.7K</span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt">2.7K</span>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 p_item right">
                                    <div class="p_cntnt">
                                        <img src="imgs/look-out.jpg" alt="vd">
                                        <div class="p_item_cmt">
                                            <h4>Lost In The Scene</h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Shares</span>
                                                <span class="vw_cnt">2.7K</span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt">2.7K</span>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                                      
                                <div class="clearfix"></div>
                            </div>
                            <?php endif;?>
                            <?php   if(in_array(YOUTULEEMEDIAID,$mediaassoc)):?>
                                        <div role="tabpanel" class="tab-pane fade in" id="youtulee">
                                        </div>
                            <?php
                                endif;?>
                            <?php   if(in_array(TUMBLRMEDIAID,$mediaassoc)):?>

                                    <div role="tabpanel" class="tab-pane fade in" id="tumblr">
                                    </div>
                            <?php
                                endif;
                            ?>
                              
                          
                          
                            <!--instagram-->
                    
                        </div>
                    </div>
                </div>
               
           
                
                <div class="col-sm-3 no-pad-sides">
                    <div class="right-pad">
                        <div class="profile_rt_br">
                            <div class="pro_pic">
                                <img src="<?php echo site_url('/'.USER_IMG_DIR.$user_info['basicinfo']['cover_image'])?>" alt="" class="pp">
                            </div>
                            <div class="pro_name">
                                <?php echo $user_info['basicinfo']['name'] ;?>
                                <span>  <?php 
                                        if(trim($user_info['basicinfo']['country'])!='')
                                            echo $user_info['basicinfo']['country'];else echo 'N/A';
                                ?></span>
                            </div>
                            
                            <div class="scio_cnt">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="btn_sec">
                                <button class="btn btn-sm btn-success"><i class="fa fa-send"></i>Send invite</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-youtube-play"></i>Youtube</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="tbl_sec">
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
                                        <td><?php echo $geo->country_code?></td>
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
                                        <td><?php echo $demo->number_male?>%</td>
                                        <td><?php echo $demo->number_female?>%</td>
                                    </tr>
                               <?php endforeach;
                               
                               
                    

                                ?>
                                   
                                                 
                                </tbody>
                            </table>    
                            <?php endif;?>                    
                        </div>
                    </div>                  
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>