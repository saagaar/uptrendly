<div class="mid-part">
        <div class="content_sec">
            <div class="public_pfl">
                <div class="col-sm-9 no-pad-left">
                    <div class="left-pad">
                    <?php

// $json_string = file_get_contents('http://graph.facebook.com/?ids=https://www.facebook.com/photo.php?fbid=1428451857230304&set=a.101464636595706.3463.100001965098027&type=3&theater');
// $json = json_decode($json_string, true);
// echo '<pre>';
// print_r($json);exit;
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
   //    $params['url'] = 'https://www.instagram.com/p/BLrosAiDCs-/?taken-by=saagarchapagain';
 
   //  // Request URL
   //   // $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$params['url'];
   //   $request_url='https://api.instagram.com/oembed/?url='.$params['url'];
   // // echo $request_url = 'https://publish.twitter.com/oembed?url=' . $params['url'];
   //  // print_r(file_get_contents("https://publish.twitter.com/oembed?url=https://twitter.com/ekarobar_daily/status/848492338133426176"));exit;
   //     print_r(file_get_contents($request_url));exit;
   //  // Get cURL resource
   //  $curl1 = curl_init();

   //  curl_setopt_array($curl1, array(
   //      CURLOPT_RETURNTRANSFER =>true,
   //      CURLOPT_URL => ($request_url),
       
   //       CURLOPT_SSL_VERIFYPEER=>false,
   //          CURLOPT_SSL_VERIFYHOST=> false
   //  ));

   //  // Send the request
   //  $response1 = curl_exec($curl1);
    
   //  // Close request to clear up some resources
   //  curl_close($curl1);

   //  // $response = @json_decode($response, true);
   //  echo '<pre>';
   //  print_r($response1);exit;
  $firstelement=0;
  
  if(in_array(YOUTUBEMEDIAID,$mediaassoc)):
   
    ?>
      <li role="presentation" <?php if($firstelement==0):?> class="active" <?php endif; ?>><a href="#youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
  <?php
  $firstelement=1;
   endif;
  if(in_array(TWITTERMEDIAID,$mediaassoc)):
   

    ?>
          <li role="presentation" <?php if($firstelement==0):?> class="active"<?php endif; ?>><a href="#twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
 <?php 
 $firstelement=1;
 endif;
  if(in_array(INSTAGRAMMEDIAID,$mediaassoc)):
   

    ?>
          <li role="presentation" <?php if($firstelement==0):?> class="active"<?php endif; ?>><a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
 <?php 
 $firstelement=1;
 endif;
  if(in_array(FACEBOOKMEDIAID,$mediaassoc)):
   
    ?>
           <li role="presentation" <?php if($firstelement==0):?> class="active"<?php endif; ?>><a href="#facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
 <?php 
 $firstelement=1;
 endif;
  if(in_array(YOUTULEEMEDIAID,$mediaassoc)):
   
?>
             <li role="presentation" <?php if($firstelement==0):?> class="active"<?php endif; ?>><a href="#youtulee" aria-controls="settings" role="tab" data-toggle="tab">Youtulee  <span class="round_btn youtulee"><img src="../themes/user/images/push.png" alt=""></span></a></li>
 <?php 
 $firstelement=1;
 endif;
  if(in_array(TUMBLRMEDIAID,$mediaassoc)):

    ?>
            <li role="presentation" <?php if($firstelement==0):?> class="active"<?php endif; ?>><a href="#tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>
 <?php 
 $firstelement=1;
 endif;
  ?>
</ul>
                        <!-- Tab panes -->
                        <?php 

                        $media=array();
                        foreach ($user_info['socialmediaprofile'] as $key => $value) {
                            $media[$value->media_id][]=$value;
                        }
                        // print_r($media);
                        ?>
                        <!-- <div class="tab-content"> -->
                            <!-- Youtube -->    
                            <?php 
                            // print_r($media);
                            $firstelement=0;
                            if(in_array(YOUTUBEMEDIAID,$mediaassoc)): 
                                foreach($media[YOUTUBEMEDIAID] as $youtubeprofile):

                                // $pic =file_get_contents($image,);
                             $JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id=Gq4Ti4WQICA&key=AIzaSyCyVNboZ93IgX4Ap622BTzaIwXzACULkBI");
                            $json_data = json_decode($JSON, true);
                            // echo '<pre>';
                            // print_r( $json_data['items']['0']);

            // $a=$this->general->get_data('members');
                                        ?>
                             <div role="tabpanel" class="tab-pane fade in <?php if($firstelement==0):?> class='active' <?php endif; ?>" id="youtube">
                                <div class="col-sm-6 p_item left">
                                    <div class="p_cntnt">
                                       <img src="<?php echo $json_data['items']['0']['snippet']['thumbnails']['default']['url']?>" alt="" class="pp">
                                        <div class="p_item_cmt yt">
                                            <h4><?php echo $json_data['items']['0']['snippet']['title'];?></h4>
                                        </div>
                                        <div class="scio_cnt">
                                            <span class="col-sm-6 no-pad-sides vw">
                                                <span class="vw_ttl">Views</span>
                                                <span class="vw_cnt"><?php echo ( $json_data['items']['0']['statistics']['viewCount'])  ?></span>
                                            </span>
                                            <span class="col-sm-6 no-pad-sides lk">
                                                <span class="lk_ttl">Likes</span>
                                                <span class="lk_cnt"><?php echo ($json_data['items']['0']['statistics']['likeCount'])?></span>
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
                                <?php 
                                endforeach;
                                ?>
                                     
                                <div class="clearfix"></div>
                            </div>
                            <?php  
                            $firstelement=1;
                             endif; ?>
                                
                            <?php   if(in_array(TWITTERMEDIAID,$mediaassoc)):
                                 
                            ?>

                            <!--twitter-->
                            <div role="tabpanel" class="tab-pane fade in <?php if($firstelement==0):?> class="active" <?php endif; ?>" id="twitter">
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
                            <?php   
                            $firstelement=1;
                            endif;?>
                            <?php   if(in_array(INSTAGRAMMEDIAID,$mediaassoc)):
                             
                              ?>
                                    <div role="tabpanel" class="tab-pane fade in <?php if($firstelement==0):?> class='active' <?php endif; ?>" id="instagram">
                                    </div>
                             <?php  
                            $firstelement=1;
                              endif;?>
                            <?php   if(in_array(FACEBOOKMEDIAID,$mediaassoc)):
                             
                              ?>

                                      <!--facebook-->
                            <div role="tabpanel" class="tab-pane fade in <?php if($firstelement==0):?> class='active' <?php endif; ?>" id="facebook">
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
                            <?php 

                            $firstelement=1;
                            endif;?>
                            <?php   if(in_array(YOUTULEEMEDIAID,$mediaassoc)):
                             
                              ?>
                                        <div role="tabpanel" class="tab-pane fade in <?php if($firstelement==0):?> class='active' <?php endif; ?>" id="youtulee">
                                        </div>
                            <?php

                            $firstelement=1;
                                endif;?>
                            <?php   if(in_array(TUMBLRMEDIAID,$mediaassoc)):
                                 
                            ?>

                                    <div role="tabpanel" class="tab-pane fade in<?php if($firstelement==0):?> class='active' <?php endif; ?>" id="tumblr">
                                    </div>
                            <?php

                            $firstelement=1;
                                endif;
                            ?>
                              
                          
                          
                            <!--instagram-->
                    
                        <!-- </div> -->
                    </div>
                </div>
               
           
                
                <div class="col-sm-3 no-pad-sides">
                       <?php $this->load->view('v_user_profile_sidebar');?>             
                </div>
                <a href="javascript:void(0)" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    <!-- Modal -->

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
            <p>Some text in the modal.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>