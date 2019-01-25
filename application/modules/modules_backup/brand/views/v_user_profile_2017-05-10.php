<div class="mid-part">
  <div class="content_sec">
    <div class="public_pfl">
      <div class="col-sm-9 no-pad-left">
        <div class="left-pad">

          <?php 
          
  // if(count($user_info['socialmediaprofile'])<1):
  //     echo 'No Profile has been set ';
  // else:
  //   echo 'yes';




          ?>
          <ul class="tabs">
           <?php 

           $mediaassoc=array();
           if(count($mediadetail)>0){
            foreach($mediadetail as $allmedia)
            {
              $mediaassoc[]=$allmedia->media_type_id;
            }
          }
          $firstelement=0;
          if(in_array(YOUTUBEMEDIAID,$mediaassoc)):?>
          <li  class="tab-link <?php if($firstelement==0):?> current <?php endif; ?>" data-tab="tab-yt">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></li>
          <?php 
          $firstelement=1;
          endif;
          if(in_array(TWITTERMEDIAID,$mediaassoc)):?>
          <li class="tab-link <?php if($firstelement==0):?> current <?php endif; ?>" data-tab="tab-twt">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></li>
          <?php 
          $firstelement=1;
          endif;
          if(in_array(INSTAGRAMMEDIAID,$mediaassoc)):?>
          <li class="tab-link <?php if($firstelement==0):?> current<?php endif;?>" data-tab="tab-insta">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></li>
          <?php 
          $firstelement=1;
          endif;
          if(in_array(FACEBOOKMEDIAID,$mediaassoc)):?>
          <li class="tab-link <?php if($firstelement==0):?> current<?php endif;?>" data-tab="tab-fb">Facebook <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></li>
          <?php 
          $firstelement=1;
          endif;
          if(in_array(YOUTULEEMEDIAID,$mediaassoc)):?>
          <li  class="tab-link <?php if($firstelement==0):?> current<?php endif;?>" data-tab="tab-ytl">Youtulee  <span class="round_btn youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"></span></li>
          <?php 
          $firstelement=1;
          endif;
          if(in_array(TUMBLRMEDIAID,$mediaassoc)):?>
          <li class="tab-link <?php  if($firstelement==0):?> current<?php endif;?>" data-tab="tab-tmb">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></li>
          <?php 
          $firstelement=1;
          endif;
          ?>
        </ul>

        <?php 

        $media=array();
        foreach ($user_info['socialmediaprofile'] as $key => $value) {
          $media[$value->media_id][]=$value;
        }
        ?>

        <!-- Youtube -->    
        <?php 

        $firstelement=0;
        $align=0;
                            // echo '<pre>';
                            // print_r($media);

        if(in_array(YOUTUBEMEDIAID,$mediaassoc) && array_key_exists(YOUTUBEMEDIAID,$media)): ?>
        <div  id="tab-yt" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">
           <?php 
          foreach($media[YOUTUBEMEDIAID] as $youtubeprofile):
                                  // get youtube id from url
           $ytid=$this->google->youtube_id_from_url($youtubeprofile->url);
         if($ytid)
         {
           /*******************Youtube data api***************************/
           $json_data=array();
           $JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id=".$ytid."&key=".YOUTUBE_API_KEY);
           $json_data = json_decode($JSON, true);
           if(count($json_data)>0)
           {
            // echo '<pre>';
            // print_r($json_data);exit;
            $img=$json_data['items']['0']['snippet']['thumbnails']['default']['url'];
            $views=0;
            $likes=0;
            $title='';
            if(count($json_data['items'])>0)
            {
              if(array_key_exists('statistics',$json_data['items']['0']))
              {
                
               $views=$json_data['items']['0']['statistics']['viewCount'];
               $likes=$json_data['items']['0']['statistics']['likeCount'];
               $comments=$json_data['items']['0']['statistics']['commentCount'];
               $title=$json_data['items']['0']['snippet']['title'];
               $description=$json_data['items']['0']['snippet']['description'];
             }


             ?>
  <a class="modalprofile" href="javascript:void(0)" data-description="<?php echo $description;?>" data-likes="<?php echo $likes ?>" data-views="<?php echo $views;?>" data-comments="<?php echo $comments;?>" data-url="<?php echo $ytid;?>" data-media="youtube" data-toggle="modal">
             <?php if($align%2==0): ?>
         
        
              <div class="col-sm-6 p_item left">
                <div class="p_cntnt">
                 <img src="<?php echo $img?>" alt="" class="pp">
                 <div class="p_item_cmt yt">
                  <h4><?php echo $title;?></h4>
                </div>
                <div class="scio_cnt">
                  <span class="col-sm-6 no-pad-sides vw">
                    <span class="vw_ttl">Views</span>
                    <span class="vw_cnt"><?php echo $views ?></span>
                  </span>
                  <span class="col-sm-6 no-pad-sides lk">
                    <span class="lk_ttl">Likes</span>
                    <span class="lk_cnt"><?php echo ($likes)?></span>
                  </span>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
          <?php else:?>
            <div class="col-sm-6 p_item right">
              <div class="p_cntnt">
                <img src="<?php echo $img?>" alt="" class="pp">
                <div class="p_item_cmt yt">
                  <h4><?php echo $title;?></h4>
                </div>
                <div class="scio_cnt">
                  <span class="col-sm-6 no-pad-sides vw">
                    <span class="vw_ttl">Views</span>
                    <span class="vw_cnt"><?php echo $views ?></span>
                  </span>
                  <span class="col-sm-6 no-pad-sides lk">
                    <span class="lk_ttl">Likes</span>
                    <span class="lk_cnt"><?php echo ($likes)?></span>
                  </span>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            <?php 
            endif; 
            ?>
        </a>
        <?php    $align++;
          }
        }
      }
      endforeach;
      ?>

      <div class="clearfix"></div>
      </a>
    </div>
    <?php  
    $firstelement=1;
    endif; ?>

    <?php  

        // $firstelement=0;
        $align=0;
                   
     if(in_array(TWITTERMEDIAID,$mediaassoc) && array_key_exists(TWITTERMEDIAID,$media)):

  
    // $params['url'] = 'https://www.facebook.com/photo.php?fbid=804794209673346&set=a.100851133400994.2344.100004283222359&type=3&theater';
   //    $params['url'] = 'https://www.instagram.com/p/BLrosAiDCs-/?taken-by=saagarchapagain';

   //  // Request URL
   //   // $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$params['url'];
   //   $request_url='https://api.instagram.com/oembed/?url='.$params['url'];
   
    
    
     $bearer=$this->twitter->get_bearer_token();
    
    ?>

    <!--twitter-->
    <div  id="tab-twt" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">
<?php
    foreach($media[TWITTERMEDIAID] as $twitterprofile):
       $request_url = 'https://publish.twitter.com/oembed?url=' . $twitterprofile->url;
       $response=(file_get_contents($request_url."&hide_thread=true&hide_media=true&omit_script=true"));
       $json_data = json_decode($response , true);
       $arr = explode("/", $twitterprofile->url);
       $tweetid= end($arr);
       $postdetail=$this->twitter->get('statuses/show',array('id'=>$tweetid));
       // echo '<pre>';
       // print_r($json_data);
         $likes=$postdetail->favorite_count;
         $retweet=$postdetail->retweet_count;
      ?>
      <a class="modalprofile" href="javascript:void(0)" data-description="<?php// echo $description;?>" data-likes="<?php //echo $likes ?>" data-views="<?php// echo $views;?>" data-comments="<?php// echo $comments;?>" data-url="<?php echo $twitterprofile->url;?>" data-media="twitter" data-toggle="modal">
             <?php if($align%2==0): ?>
         
        
              <div class="col-sm-6 p_item left">
                <div class="p_cntnt">
                 <!-- <img src="<?php echo $img?>" alt="" class="pp"> -->
                 <div class="p_item_cmt yt">
                  <h4><?php echo $json_data['html'];?></h4>
                </div>
                <div class="scio_cnt">
                  <span class="col-sm-6 no-pad-sides vw">
                    <span class="vw_ttl">Retweet</span>
                    <span class="vw_cnt"><?php echo $retweet ?></span>
                  </span>
                  <span class="col-sm-6 no-pad-sides lk">
                    <span class="lk_ttl">Likes</span>
                    <span class="lk_cnt"><?php echo ($likes)?></span>
                  </span>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
          <?php else:?>
            <div class="col-sm-6 p_item right">
              <div class="p_cntnt">
                <!-- <img src="<?php echo $img?>" alt="" class="pp"> -->
                <div class="p_item_cmt yt">
                  <h4><?php echo $json_data['html'];?></h4>
                </div>
                <div class="scio_cnt">
                  <span class="col-sm-6 no-pad-sides vw">
                    <span class="vw_ttl">Reweet </span>
                    <span class="vw_cnt"><?php echo $retweet ?></span>
                  </span>
                  <span class="col-sm-6 no-pad-sides lk">
                    <span class="lk_ttl">Likes</span>
                    <span class="lk_cnt"><?php echo ($likes)?></span>
                  </span>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            <?php 
            endif; 
            ?>
        </a>
        <?php    $align++;
        endforeach;
          
        
      ?> 
      <div class="clearfix"></div>
    </div>
    <?php   
    $firstelement=1;
    endif;
      // $firstelement=0;
        $align=0;

    ?>
    <?php   if(in_array(INSTAGRAMMEDIAID,$mediaassoc)&& array_key_exists(INSTAGRAMMEDIAID,$media)):

    ?>
    <div  id="tab-insta" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">

     <?php
    foreach($media[INSTAGRAMMEDIAID] as $instaprofile):
       $request_url = 'https://api.instagram.com/oembed?url=' . $instaprofile->url;
       $response=(file_get_contents($request_url."&omitscript=true&hidecaption=true"));
       $json_data = json_decode($response , true);
      
       // $arr = explode("/", $twitterprofile->url);
       // $tweetid= end($arr);
       // $postdetail=$this->twitter->get('statuses/show',array('id'=>$tweetid));
       // // echo '<pre>';
       // // print_r($postdetail);
       //   $likes=$postdetail->favorite_count;
       //   $retweet=$postdetail->retweet_count;
      ?>
      <a class="modalprofile" href="javascript:void(0)" data-description="" data-likes="" data-views="" data-comments="" data-url="<?php echo $instaprofile->url;?>" data-media="instagram" data-toggle="modal">
             <?php if($align%2==0): ?>
         
        
              <div class="col-sm-6 p_item left">
                <div class="p_cntnt">
                 <img src="<?php echo $json_data['thumbnail_url']?>" alt="" class="pp">
                 <div class="p_item_cmt yt">
                  <h4><?php echo $json_data['title'];?></h4>
                </div>
              <!--   <div class="scio_cnt">
                  <span class="col-sm-6 no-pad-sides vw">
                    <span class="vw_ttl">Retweet</span>
                    <span class="vw_cnt"><?php// echo $retweet ?></span>
                  </span>
                  <span class="col-sm-6 no-pad-sides lk">
                    <span class="lk_ttl">Likes</span>
                    <span class="lk_cnt"><?php //echo ($likes)?></span>
                  </span>
                </div> -->
                <div class="clearfix"></div>
              </div>
            </div>
            
          <?php else:?>
            <div class="col-sm-6 p_item right">
              <div class="p_cntnt">
               <img src="<?php echo $json_data['thumbnail_url']?>" alt="" class="pp">
                <div class="p_item_cmt yt">
                  <h4><?php  echo $json_data['title'];?></h4>
                </div>
              <!--   <div class="scio_cnt">
                  <span class="col-sm-6 no-pad-sides vw">
                    <span class="vw_ttl">Reweet </span>
                    <span class="vw_cnt"><?php //echo $retweet ?></span>
                  </span>
                  <span class="col-sm-6 no-pad-sides lk">
                    <span class="lk_ttl">Likes</span>
                    <span class="lk_cnt"><?php //echo ($likes)?></span>
                  </span>
                </div> -->
                <div class="clearfix"></div>
              </div>
            </div>
            <?php 
            endif; 
            ?>
        </a>
        <?php    $align++;
        endforeach;
        ?> 
       <div class="clearfix"></div>
  </div>
  <?php  
  $firstelement=1;
  endif;?>
  <?php  
  /********Facebook************/
  // $firstelement=0;
  $align=0;
  if(in_array(FACEBOOKMEDIAID,$mediaassoc) && array_key_exists(FACEBOOKMEDIAID,$media)): ?>
 <div  id="tab-fb" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">
  <?php 

    if(isset($media[FACEBOOKMEDIAID])) :       
      foreach($media[FACEBOOKMEDIAID] as $fbprofile):
        /****************Facebook oembed request url****************/
      $options = array(
        'http'=>array(
          'method'=>"GET",
          'header'=>"Accept-language: en\r\n" .
                                      "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                                      "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
                                      )
        );

      $context = stream_context_create($options);
      $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$fbprofile->url.'&omitscript=false';
      $jsonresp=file_get_contents($request_url,false, stream_context_create($options));
      $response = json_decode($jsonresp, true);   

      ?>

      <!--facebook-->

     
         <?php

                                   // }
         if(count($response)>0)
         {

          $fbdata = file_get_contents('http://graph.facebook.com/?ids='.$fbprofile->url);

          $jsonfb = json_decode($fbdata, true);
        
          $fbarr=(current($jsonfb));

                                // echo $jsonfb['likes'];
          ?>
      <a class="modalprofile" href="javascript:void(0)" data-toggle="modal" data-media="facebook" data-url="<?php echo $fbprofile->url;?>" >
      
          <?php if($align%2==0):

          ?>

          <div class="col-sm-6 p_item">
            <div class="p_cntnt">
             <!-- <img src="<?php echo $json_data['items']['0']['snippet']['thumbnails']['default']['url']?>" alt="" class="pp"> -->
             <div class="p_item_cmt yt">
              <h4><?php echo $response['html'];?></h4>
            </div>
            <div class="scio_cnt">
              <span class="col-sm-6 no-pad-sides vw">
                <span class="vw_ttl">Share</span>
                <span class="vw_cnt"><?php echo $fbarr['share']['share_count']  ?></span>
              </span>
              <span class="col-sm-6 no-pad-sides lk">
                <span class="lk_ttl">Comment</span>
                <span class="lk_cnt"><?php echo $fbarr['share']['comment_count']  ?></span>
              </span>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      <?php else:?>
        <div class="col-sm-6 p_item pull-right">
          <div class="p_cntnt">
            <!-- <img src="<?php echo $json_data['items']['0']['snippet']['thumbnails']['default']['url']?>" alt="" class="pp"> -->
            <div class="p_item_cmt yt">
              <h4><?php echo $response['html'];?></h4>
            </div>
            <div class="scio_cnt">
              <span class="col-sm-6 no-pad-sides vw">
                <span class="vw_ttl">Views</span>
                <span class="vw_cnt"><?php echo $fbarr['share']['comment_count']  ?></span>
              </span>
              <span class="col-sm-6 no-pad-sides lk">
                <span class="lk_ttl">Likes</span>
                <span class="lk_cnt"><?php echo $fbarr['share']['comment_count']  ?></span>
              </span>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <?php 
        endif;?>
      </a>
        <?php
        $align++;

      }

      endforeach;
      endif;
      ?>                  
      <div class="clearfix"></div>
    
  </div>

  <?php 

  $firstelement=1;
  endif;?>
  <?php   if(in_array(YOUTULEEMEDIAID,$mediaassoc)&& array_key_exists(FACEBOOKMEDIAID,$media)):

  ?>
  <div  id="tab-ytl" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">
  </div>
  <?php

  $firstelement=1;
  endif;?>
  <?php   if(in_array(TUMBLRMEDIAID,$mediaassoc) && array_key_exists(FACEBOOKMEDIAID,$media)):

  ?>

  <div  id="tab-tmb" class="tab-content fade <?php if($firstelement==0):?> current <?php endif; ?> in">
  </div>
  <?php

  $firstelement=1;
  endif;
  ?>



  <!--instagram-->


</div>
</div>



<div class="col-sm-3 no-pad-sides">
 <?php 
 $data['mediaassoc']=$mediaassoc;
 $data['mediadetail']=$mediadetail;
 $this->load->view('v_user_profile_sidebar',$data);?>             
</div>

</div>
<div class="clearfix"></div>
</div>
</div>


<!-- Modal -->

<?php $this->load->view('popup_post');
?>

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
 

</script>