<!-- <script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script> -->
<?php 
$allcamp=array();
foreach ($mycampaign as $key => $value) {
  $allcamp[$value->mediaid][]=$value;
   // $value->mediaid;
}
// echo '<pre>';
// print_r($allcamp);exit;
?>
<div class="mid-part">
	<div class="content_sec">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  <?php 
    if(defined('YOUTUBEMEDIAID')):
  ?>
    <li role="presentation" class="active"><a href="#youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube(<?php if(isset($allcamp[YOUTUBEMEDIAID])) echo count($allcamp[YOUTUBEMEDIAID]);else echo 0;?>) <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
  <?php 
     endif;
     if(defined('TWITTERMEDIAID')):
  ?>
    <li role="presentation"><a href="#twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter(<?php if(isset($allcamp[TWITTERMEDIAID])) echo count($allcamp[TWITTERMEDIAID]);else echo 0;?>) <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
  <?php 
     endif;
     if(defined('INSTAGRAMMEDIAID')):
  ?>
    <li role="presentation"><a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram(<?php if(isset($allcamp[INSTAGRAMMEDIAID])) echo count($allcamp[INSTAGRAMMEDIAID]);else echo 0;?>)  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
  <?php 
     endif;
     if(defined('YOUTULEEMEDIAID')):
  ?>
    <li role="presentation"><a href="#youtulee" aria-controls="settings" role="tab" data-toggle="tab">Youtulee(<?php if(isset($allcamp[YOUTULEEMEDIAID])) echo count($allcamp[YOUTULEEMEDIAID]);else echo 0;?>)<span class="pull-right round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> 
     </span></a></li>
   <?php 
     endif;
     if(defined('TUMBLRMEDIAID')):
  ?> 
   <li role="presentation"><a href="#tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr (<?php if(isset($allcamp[TUMBLRMEDIAID])) echo count($allcamp[TUMBLRMEDIAID]);else echo 0;?>) <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>
   <?php 
     endif;
     if(defined('FACEBOOKMEDIAID')):
  ?>
    <li role="presentation"><a href="#facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook (<?php if(isset($allcamp[FACEBOOKMEDIAID])) echo count($allcamp[FACEBOOKMEDIAID]);else echo 0;?>) 
    <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
   <?php 
     endif;
   
  ?>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
   <?php 
     if(defined('YOUTUBEMEDIAID')):
    ?>
    <div role="tabpanel" class="tab-pane fade in active" id="youtube">
    <?php 
    
    if(array_key_exists(YOUTUBEMEDIAID,$allcamp)):
    $this->load->library('google');
    ?>
         <ul class="product_listing content_data">
         <?php
         if(count($allcamp[YOUTUBEMEDIAID])>0):
         foreach ($allcamp[YOUTUBEMEDIAID] as $key => $value) {
          $ytid=$this->google->youtube_id_from_url('https://www.youtube.com/watch?v=KmlBnmyelHI');
         if($ytid)
         {
           /*******************Youtube data api***************************/
          
           $JSON = file_get_contents("https://www.googleapis.com/youtube/v3/Content Title=snippet,statistics,contentDetails&id=".$ytid."&key=".YOUTUBE_API_KEY);
           $json_data = json_decode($JSON, true);
          $content=$json_data['items'][0]['statistics'];
          // print_r($content);

         }
          ?>

           <li>
             <div class="col-xs-3"><p>Content Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Views</p><h3><?php echo $content['viewCount']?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php echo $content['likeCount']?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php 
        endif;
       else:
        echo CONTENT_DEFAULT_TEXT;
       endif;
     

       ?>
    </div>
     <?php 
     endif;
     if(defined('TWITTERMEDIAID')):
    ?>
    <div role="tabpanel" class="tab-pane fade in" id="twitter">
    <?php 
   if(array_key_exists(TWITTERMEDIAID,$allcamp)):
       $this->load->library('twitter');
       $bearer=$this->twitter->get_bearer_token();
      
         ?>
         <ul class="product_listing content_data">
         <?php
          if(count($allcamp[TWITTERMEDIAID])>0):
         foreach ($allcamp[TWITTERMEDIAID] as $key => $value) {
             $arr = explode("/", $value->socialtrackid);
             $tweetid= end($arr);
             $postdetail=$this->twitter->get('statuses/show',array('id'=>$tweetid));
             $likes=$postdetail->favorite_count;
             $retweet=$postdetail->retweet_count;
          ?>

           <li>
             <div class="col-xs-3"><p>Content Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Retweets</p><h3><?php echo $retweet;?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php echo $likes?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
        <?php 
        endif;
       else:
        echo 'No content';
       endif;
        
       ?>
    </div>
    <?php 
     endif;
     if(defined('INSTAGRAMMEDIAID')):
    ?>
    <div role="tabpanel" class="tab-pane fade in" id="instagram">
    <?php 

    if(array_key_exists(INSTAGRAMMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php
         if(count($allcamp[INSTAGRAMMEDIAID])>0):
         foreach ($allcamp[INSTAGRAMMEDIAID] as $key => $value) {
         
          ?>

           <li>
             <div class="col-xs-3"><p>Content Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Views</p><h3><?php //echo $content['viewCount']?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php// echo $content['likeCount']?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php 
       endif;
       else:
        echo 'No content';
       endif;
     
       ?>
    </div>
     <?php 
      endif;
     if(defined('YOUTULEEMEDIAID')):
    ?>
    <div role="tabpanel" class="tab-pane fade in" id="youtulee">
    <?php 
   
    if(array_key_exists(YOUTULEEMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php
         if(count($allcamp[YOUTULEEMEDIAID])):
         foreach ($allcamp[YOUTULEEMEDIAID] as $key => $value) {
         
          ?>

           <li>
             <div class="col-xs-3"><p>Content Title</p><h4><?php echo $value->name;?></h4></div>
            <div class="col-xs-3"><p>Views</p><h4>0<?php //echo $content['viewCount']?></h4></div>
            <div class="col-xs-3"><p>Like Count</p><h4>0<?php// echo $content['likeCount']?></h4></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h4>$0.00</h4></div>
           </li>
          <?php } ?>

         </ul>
      <?php 
       endif;
       else:
        echo 'No content';
       endif;
       ?>
    </div>
     <?php 
      endif;
     if(defined('TUMBLRMEDIAID')):
    ?>
    <div role="tabpanel" class="tab-pane fade in" id="tumblr">
   
    <?php 
   
    if(array_key_exists(TUMBLRMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php

          if(count($allcamp[TUMBLRMEDIAID])>0):
            $member=$this->general->get_single_row('member_socialmedia',array('user_id'=>$allcamp[TUMBLRMEDIAID]['0']->user_id,'media_type_id'=>TUMBLRMEDIAID));
         foreach ($allcamp[TUMBLRMEDIAID] as $key => $value) {
          $notes_count=0;
            try
            {
              $this->load->library('tumblr');
              $data=  $this->tumblr->get("https://api.tumblr.com/v2/blog/".$member->socialmedia_id."/posts/text?api_key=".TUMBLR_APP_KEY."&notes_count=true&id=".$value->socialtrackid);
          

                  
                   if($data->meta->status=='200')
                   {
                      $notes_count=($data->response->posts['0']->note_count); 
                   }
                   else
                    $notes_count=0;
            }
           catch(Exception $e){
            throw $e->getMessage();
            $notes_count=0;
           }
         // if($json_data[''])
          ?>

           <li>
             <div class="col-xs-4"><p>Content Title</p><h3><?php echo $value->name;?></h3></div>
            <div class="col-xs-4"><p>Notes</p><h3><?php echo $notes_count;?></h3></div>
            <!-- <div class="col-xs-3"><p>Like Count</p><h3><?php// echo $content['likeCount']?></h3></div> -->
            <div class="col-xs-4"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php 
       endif;
       else:
        echo 'No content';
      
      endif;

       ?>
    </div>
     <?php 
      endif;

     if(defined('FACEBOOKMEDIAID')):
    ?>
    <div role="tabpanel" class="tab-pane fade in" id="facebook">
    <script type="text/javascript"></script>
    
    <?php   
    if(array_key_exists(FACEBOOKMEDIAID,$allcamp)):
        $this->load->library('facebook');
          $accestoken=$this->facebook->getAppAccessToken();

         ?>
         <ul class="product_listing content_data">
         <?php
          if(count($allcamp[FACEBOOKMEDIAID])>0):
         foreach ($allcamp[FACEBOOKMEDIAID] as $key => $value) {
         if(strpos($value->socialtrackid, "_") === false)
          {
            $userid=$value->user_id;
            $mediadata=$this->general->get_single_row('member_socialmedia',array('user_id'=>$userid,'media_type_id'=>FACEBOOKMEDIAID
              ));
            $page_id=$mediadata->page_id;
            $trackid=$page_id.'_'.$value->socialtrackid;
          }
          else{
            $trackid=$value->socialtrackid;
          }
          $likes=$this->facebook->request('GET',$trackid.'/likes?summary=true',$accestoken);
          $comments=$this->facebook->request('GET',$trackid.'/comments?summary=true',$accestoken);
          $reactions=$this->facebook->request('GET', $trackid.'/reactions?summary=true',$accestoken);
          $fbdata = file_get_contents('http://graph.facebook.com/?ids=https://www.facebook.com/'.$value->socialtrackid);
          $jsonfb = json_decode($fbdata, true);
          $shares=(current($jsonfb)); 
         
          
    ?>
         <li>
             <div class="col-xs-2"><p>Campaign Title</p><h3><?php echo $value->name;?></h3></div>
            <div class="col-xs-2"><p>Likes Count </p><h3><?php echo $likes['summary']['total_count'];?></h3></div>
            <div class="col-xs-2"><p>Reactions Count </p><h3><?php echo $reactions['summary']['total_count']-$likes['summary']['total_count']?></h3></div>
            <div class="col-xs-2"><p>Comment Count </p><h3><?php echo $comments['summary']['total_count'];?></h3></div> 
            <div class="col-xs-2"><p>Share Count</p><h3><?php echo $shares['share']['share_count'];?></h3></div>
            <div class="col-xs-2"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
        <?php
        endif; 
       else:
        echo 'No content';
       endif;
      

       ?>
  </div>
  <?php 
      endif;
  ?>
</div>
	</div>