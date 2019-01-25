<div class="mid-part">
        <div class="content_sec">
            <div class="public_pfl">
                
             
                            
                <div class="col-sm-9 no-pad-left">
                    <div class="left-pad">
                    <!-- Nav tabs -->
                        <!-- <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
                            <li role="presentation"><a href="#twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
                            <li role="presentation"><a href="#facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook  <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
                            <li role="presentation"><a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
                            <li role="presentation"><a href="#youtulee" aria-controls="settings" role="tab" data-toggle="tab">YoutuLee <span class="round_btn youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt=""></span></a></li>
                            <li role="presentation"><a href="#tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>                         
                        </ul> -->

                        <!-- Tab panes -->
                       
                        <ul class="tabs">
                         <?php 
                          $mediaassoc=array();
                          if(count($mediadetail)>0){
                            foreach($mediadetail as $allmedia)
                            {
                              $mediaassoc[]=$allmedia->media_type_id;
                            }
                          }
                          // $mediaassoc[]=3;

                        // echo '<pre>';
                        // print_r($user_info['socialmediaprofile']);
                          
                          if(in_array(YOUTUBEMEDIAID,$mediaassoc)):?>
                              <li  class="tab-link <?php if($mediaassoc['0']==YOUTUBEMEDIAID):?> current<?php endif;?>" data-tab="tab-yt">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></li>
                          <?php endif;
                          if(in_array(TWITTERMEDIAID,$mediaassoc)):?>
                                  <li class="tab-link <?php if($mediaassoc['0']==TWITTERMEDIAID):?> current<?php endif;?>"" data-tab="tab-twt">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></li>
                         <?php endif;
                          if(in_array(INSTAGRAMMEDIAID,$mediaassoc)):?>
                                  <li class="tab-link <?php if($mediaassoc['0']==INSTAGRAMMEDIAID):?> current<?php endif;?>"" data-tab="tab-insta">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></li>
                         <?php endif;
                          if(in_array(FACEBOOKMEDIAID,$mediaassoc)):?>
                                   <li class="tab-link <?php if($mediaassoc['0']==FACEBOOKMEDIAID):?> current<?php endif;?>"" data-tab="tab-fb">Facebook <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></li>
                         <?php endif;
                          if(in_array(YOUTULEEMEDIAID,$mediaassoc)):?>
                                     <li  class="tab-link <?php if($mediaassoc['0']==YOUTULEEMEDIAID):?> current<?php endif;?>"" data-tab="tab-ytl">Youtulee  <span class="round_btn youtulee"><img src="../themes/user/images/push.png" alt=""></span></li>
                         <?php endif;
                          if(in_array(TUMBLRMEDIAID,$mediaassoc)):?>
                                    <li class="tab-link <?php if($mediaassoc['0']==TUMBLRMEDIAID):?> current<?php endif;?>"" data-tab="tab-tmb">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></li>
                         <?php endif;
                          ?>
                        </ul>
                            <!-- Youtube -->
                             <?php
                            foreach($user_info['socialmediaprofile'] as $data)
                            {
                                $profilebymedia[$data->media_id]=$data->url;
                            }

                            // echo '<pre>';
                            // print_r($profilebymedia);
             if(in_array(YOUTUBEMEDIAID,$mediaassoc)): ?>
                   <div  id="tab-yt" class="tab-content fade current in">
                                <div class="col-sm-6 p_item left">
                                <?php
                                      $params['url'] = rawurlencode('https://www.youtube.com/watch?v=JUvJslHY7FU');
    $params['format'] = 'json';

    // Request params string
    $params_string = 'url=' . $params['url'] . '&format=' . $params['format'];

    // Request URL
    $request_url = 'http://www.youtube.com/oembed?' . $params_string;
    
    // Get cURL resource
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $request_url,
    ));

    // Send the request
    $response = curl_exec($curl);
    
    // Close request to clear up some resources
    curl_close($curl);

    $response = @json_decode($response, true);
    echo '<pre>';
    print_r($response);
    if (!empty($response) && isset($response['title'])) {
      $html =<<<html
      <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">{$response['title']}</h3>
          </div>
          <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <p>Author: <a href="{$response['author_url']}" target="_blank">{$response['author_name']}</a></p>
                    <p><img class="img-responsive" src="{$response['thumbnail_url']}" width="{$response['thumbnail_width']}" height="{$response['thumbnail_height']}" /></p>
                </div>
                <div class="col-md-9">
                    {$response['html']}
                </div>
            </div>
          </div>
        </div>
html;
        echo $html;
    } 
    ?>
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
                    <div  id="tab-twt" class="tab-content fade <?php if($mediaassoc['0']==TWITTERMEDIAID):?> current<?php endif;?>">    
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
                                 
                                  
                                    <div  id="tab-insta" class="tab-content fade <?php if($mediaassoc['0']==INSTAGRAMMEDIAID):?> current<?php endif;?>"> 
                                            iNSTAGRAM
                                    </div>
                    
                             <?php   endif;?>
                            <?php   if(in_array(FACEBOOKMEDIAID,$mediaassoc)):

                                     
                       
                           $params['url'] = ('https://www.facebook.com/photo.php?fbid=1548628768500678&set=a.149400725090163.33754.100000607107447&type=3&theater');
   
    // Request URL
   $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url=' . $params['url'];

    
    // Get cURL resource
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_URL => ($request_url),
        CURLOPT_HTTPGET=>true
    ));

    // Send the request
    $response1 = curl_exec($curl);
    
    // Close request to clear up some resources
    curl_close($curl);

    // $response = @json_decode($response, true);
    echo '<pre>';
    print_r($response1);
    if (!empty($response) && isset($response['title'])) {
//       $html =<<<html
//       <div class="panel panel-default">
//           <div class="panel-heading">
//             <h3 class="panel-title">{$response['title']}</h3>
//           </div>
//           <div class="panel-body">
//             <div class="row">
//                 <div class="col-md-3">
//                     <p>Author: <a href="{$response['author_url']}" target="_blank">{$response['author_name']}</a></p>
//                     <p><img class="img-responsive" src="{$response['thumbnail_url']}" width="{$response['thumbnail_width']}" height="{$response['thumbnail_height']}" /></p>
//                 </div>
//                 <div class="col-md-9">
//                     {$response['html']}
//                 </div>
//             </div>
//           </div>
//         </div>
// html;
//         echo $html;
    } 
   
    // Get cURL resource
    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    //     CURLOPT_RETURNTRANSFER => 1,
    //     CURLOPT_URL => $request_url,
    // ));

    // // Send the request
    // $response = curl_exec($curl);
    
    // // Close request to clear up some resources
    // curl_close($curl);
    // print_r($response);
    // $response = @json_decode($response, true);
    
                           ?>
                                  <!--   <div class="fb-post" data-href="https://www.facebook.com/BOARDOFCRICKETINDIA/posts/1271757669537383" data-width="500" data-show-text="false"><blockquote cite="https://www.facebook.com/BOARDOFCRICKETINDIA/posts/1271757669537383" class="fb-xfbml-parse-ignore">Posted by <a href="https://www.facebook.com/facebook/">Facebook</a> on&nbsp;<a href="https://www.facebook.com/20531316728/posts/10154009990506729/">Thursday, August 27, 2015</a></blockquote></div> -->
                                </div>

                                <div class="col-sm-6 p_item right">
                                    <!-- <div class="p_cntnt">
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
                                    </div> -->
                                </div>
                                                      
                                <div class="clearfix"></div>


                            
                            


                            </div>
                            <?php endif;?>
                            <?php   if(in_array(YOUTULEEMEDIAID,$mediaassoc)):?>
                                         <div  id="tab-fb" class="tab-content fade <?php if($mediaassoc['0']==YOUTULEEMEDIAID):?> current<?php endif;?>">  
                                        </div>
                            <?php
                                endif;?>
                            <?php   if(in_array(TUMBLRMEDIAID,$mediaassoc)):?>

                                  <div  id="tab-tmb" class="tab-content fade <?php if($mediaassoc['0']==TUMBLRMEDIAID):?> current<?php endif;?>">  
                                        
                                    </div>
                            <?php
                                endif;
                            ?>
                              
                          
                          
                            <!--instagram-->
                    
                        
                  
                </div>
               
           
                
                

                </div>

                <div class="col-sm-3 no-pad-sides">
                                <?php echo $this->load->view('v_user_profile_sidebar');?>   
                             </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <script type="text/javascript">
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