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

?>
<div class="mid-part">
	<div class="content_sec">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
    <li role="presentation"><a href="#twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter  <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
    <li role="presentation"><a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram  <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
    <li role="presentation"><a href="#youtulee" aria-controls="settings" role="tab" data-toggle="tab">Youtulee  <span class="round_btn vine"><i class="fa fa-vine"></i></span></a></li>
    <li role="presentation"><a href="#tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr  <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>
    <li role="presentation"><a href="#facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook  
    <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="youtube">
    <?php 
    if(array_key_exists(YOUTUBEMEDIAID,$allcamp)):
    $this->load->library('google');
    ?>
         <ul class="product_listing content_data">
         <?php
         foreach ($allcamp[YOUTUBEMEDIAID] as $key => $value) {
          $ytid=$this->google->youtube_id_from_url('https://www.youtube.com/watch?v=KmlBnmyelHI');
         if($ytid)
         {
           /*******************Youtube data api***************************/
          
           $JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics,contentDetails&id=".$ytid."&key=".YOUTUBE_API_KEY);
           $json_data = json_decode($JSON, true);
          $content=$json_data['items'][0]['statistics'];
          // print_r($content);

         }
          ?>

           <li>
             <div class="col-xs-3"><p>Video Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Views</p><h3><?php echo $content['viewCount']?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php echo $content['likeCount']?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php endif;?>
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="twitter">
    <?php 
     
  
     

       // $request_url = 'https://publish.twitter.com/oembed?url=' . $twitterprofile->url;
       // $response=(file_get_contents($request_url."&hide_thread=true&hide_media=true&omit_script=true"));
       // $json_data = json_decode($response , true);
       // $arr = explode("/", $twitterprofile->url);
       // $tweetid= end($arr);
       //
     
   if(array_key_exists(TWITTERMEDIAID,$allcamp)):
       $this->load->library('twitter');
       $bearer=$this->twitter->get_bearer_token();
      
         ?>
         <ul class="product_listing content_data">
         <?php
         foreach ($allcamp[TWITTERMEDIAID] as $key => $value) {
             $arr = explode("/", $value->socialtrackid);
             $tweetid= end($arr);
             $postdetail=$this->twitter->get('statuses/show',array('id'=>$tweetid));
             $likes=$postdetail->favorite_count;
             $retweet=$postdetail->retweet_count;
          ?>

           <li>
             <div class="col-xs-3"><p>Video Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Retweets</p><h3><?php echo $retweet;?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php echo $likes?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php endif;?>
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="instagram">
    <?php 
    if(array_key_exists(INSTAGRAMMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php
         foreach ($allcamp[INSTAGRAMMEDIAID] as $key => $value) {
         
          ?>

           <li>
             <div class="col-xs-3"><p>Video Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Views</p><h3><?php //echo $content['viewCount']?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php// echo $content['likeCount']?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php endif;?>
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="youtulee">
    <?php 
    if(array_key_exists(YOUTULEEMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php
         foreach ($allcamp[YOUTULEEMEDIAID] as $key => $value) {
         
          ?>

           <li>
             <div class="col-xs-3"><p>Video Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Views</p><h3><?php //echo $content['viewCount']?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php// echo $content['likeCount']?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php endif;?>
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="tumblr">
    <div class="col-xs-3"><p>Videos</p><h3>0</h3></div>
    <?php 
    if(array_key_exists(TUMBLRMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php
         foreach ($allcamp[TUMBLRMEDIAID] as $key => $value) {
         
          ?>

           <li>
             <div class="col-xs-3"><p>Video Title</p><h3>0</h3></div>
            <div class="col-xs-3"><p>Views</p><h3><?php //echo $content['viewCount']?></h3></div>
            <div class="col-xs-3"><p>Like Count</p><h3><?php// echo $content['likeCount']?></h3></div>
            <div class="col-xs-3"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php endif;?>
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="facebook">
    
    <?php 
    if(array_key_exists(FACEBOOKMEDIAID,$allcamp)):
       
         ?>
         <ul class="product_listing content_data">
         <?php
         foreach ($allcamp[FACEBOOKMEDIAID] as $key => $value) {
        
      $fbdata = file_get_contents('http://graph.facebook.com/?ids='.$value->socialtrackid);

          $jsonfb = json_decode($fbdata, true);
        
          $fbarr=(current($jsonfb));
         
          
    ?>
          

           <li>
             <div class="col-xs-2"><p>Video Title</p><h3><?php echo $value->name;?></h3></div>
            <div class="col-xs-2"><p>Comment Count </p><h3><?php echo $fbarr['share']['comment_count']?></h3></div>
              <!-- div class="col-xs-2"><p>Engagement </p><h3><?php echo $fbarr['share']['comment_count']?></h3></div>
                <div class="col-xs-2"><p>Comment Count </p><h3><?php echo $fbarr['share']['comment_count']?></h3></div> -->
            <div class="col-xs-2"><p>Share Count</p><h3><?php  echo $fbarr['share']['share_count']?></h3></div>
            <div class="col-xs-2"><p>Avg. CPE</p><h3>$0.00</h3></div>
           </li>
          <?php } ?>

         </ul>
       <?php endif;?>
  </div>

</div>
	</div>