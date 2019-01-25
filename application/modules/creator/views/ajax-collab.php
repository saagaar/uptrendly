<div class="grid-sizer"></div>
<input type="hidden" id="current_user" value="<?php echo $this->session->userdata(SESSION.'user_id')?>">
<?php 
           $usermedia=array();
           $socialmedia=array();
          foreach($usermediaassociation as $val){
            $usermedia[]=$val->media_type_id;
          }
          if(count($collaboration)>0)
          {
            foreach($collaboration as $sponsitem)
            { 

              
              ?>
<div class="grid-item"> <span class="btn btn-info price_range">Likes > <?php echo $sponsitem['least_fan_count'];?></span>
  <?php 
                $image=$this->general->get_profile_image(trim($sponsitem['image']));
                $date=date_create( $sponsitem['submission_deadline']);
               $submission_deadline= date_format($date,"Y-m-d");
              ?>
  <figure> <img id="<?php echo $sponsitem['product_id'];?>_productimg" src="<?php echo  $image;?>"> </figure>
  <div class="grid_inn">
    <h4> <a href="#" id="<?php echo $sponsitem['product_id'];?>_product_name"><?php echo $sponsitem['product_name'];?></a>
      <input type="hidden" id="<?php echo $sponsitem['product_id'];?>_allmedia" value="<?php echo $sponsitem['media'];?>" >
      <!--  <input type="hidden" id="<?php echo $sponsitem['product_id'];?>_product_url" value="<?php echo $sponsitem['product_url'];?>">-->
      <input type="hidden"  id="<?php echo $sponsitem['product_id'];?>_fan_count" value="<?php echo $sponsitem['least_fan_count'];?>">
      <input type="hidden"  id="<?php echo $sponsitem['product_id'];?>_submission_deadline" value="<?php echo $submission_deadline;?>">
      <?php 

                        if($sponsitem['media'])
                        { 
                         
                           $socialmedia=explode(',',$sponsitem['media']);

                          
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
      <span class="pull-right round_btn youtube"> <i class="fa fa-youtube"></i> </span>
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
          
      if(defined("constant(strtoupper($socialmedia[0]).'MEDIAID'"))
      {
        ?>
      <input id="<?php echo $sponsitem['product_id'];?>_socialmediaid" type="hidden" name="proposalformedia" data-media="<?php echo $socialmedia[0];?>" value="<?php echo constant(strtoupper($socialmedia[0]).'MEDIAID');?>">
      <?php 
      }
                        }
                       
                        ?>
    </h4>
    <p id="<?php echo $sponsitem['product_id'];?>_description"> <?php echo $sponsitem['description'];
                      ?> </p>
  </div>
  <div class="text-center">
    <?php if($sponsitem['brand_id']!=$this->session->userdata(SESSION.'user_id')){
                    ?>
    <a href="#" data-productid="<?php echo $sponsitem['product_id'];?>" data-media="<?php echo $sponsitem['media'];?>" class="btn btn-success collabproposal sendproposal" id="sendcollabproposal_<?php echo $sponsitem['product_id'];?>"><i class="fa fa-paper-plane"></i> Send Proposal</a>
    <?php
                    } ?>
    <a href="#" data-productid="<?php echo $sponsitem['product_id'];?>" data-brandid="<?php echo $sponsitem['brand_id'];?>" class="btn btn-primary " id="collabdetail"><i class="fa fa-th-list"></i> Detail</a>
    <?php if((isset($sponsitem['bid_status'])) && ($sponsitem['bid_status']=='2' || $sponsitem['bid_status']=='1') && ($sponsitem['draft_accept']=='0' || $sponsitem['draft_accept']=='' ||  $sponsitem['draft_accept']=='2')){
                        ?>
    <a href="#" data-productid="<?php echo $sponsitem['product_id'];?>" data-bidid="<?php echo $sponsitem['bid_id']?>" class="btn btn-warning draftpopupbtn" id="<?php echo $sponsitem['product_id'];?>_sponsordetailid"><i class="fa fa-file-text"></i> Send Draft</a>
    <?php }
                        ?>
    <?php if((isset($sponsitem['bid_status'])) && ($sponsitem['bid_status']=='2' || $sponsitem['bid_status']=='1') && ($sponsitem['draft_accept']=='1' )){
                        ?>
    <a href="#" data-productid="<?php echo $sponsitem['product_id'];?>" data-bidid="<?php echo $sponsitem['bid_id']?>" class="btn btn-danger mediatrack" id="<?php echo $sponsitem['product_id'];?>_sponsordetailid"><i class="fa fa-bullseye"></i> Social Media Track id</a>
    <?php }
                        ?>
    <div class="clearfix"></div>
  </div>
</div>
<?php }
 if($this->session->userdata('popup_media')=='enable'){
  ?>
<script>
    $(function(){
      $('#sendcollabproposal_<?php echo $this->session->userdata("selectedproduct")?>').click();
      
    });
  </script>
<?php 
  $this->session->unset_userdata('popup_media');
  }

?>
<div id="collab_proposal_popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="sendprop_modal">
        <div class="sendprop_modal_container">
          <div class="modal_title">
            <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php    }
                if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php 

                }
                     ?>
            <div class="user_media hidden">
              <div class="row form-group userconnectedmedia brandtype">
                <?php 
                          if(defined('FACEBOOKMEDIAID')):
                          if(in_array(FACEBOOKMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 cmedia hidden" id="facebookmedia"><a data-productid="<?php echo $sponsitem['product_id'];?>" data-mediaid="<?php echo FACEBOOKMEDIAID?>" data-medianame="facebook" href="#" class="mediabrand btn btn-block btn-primary"><i class="fa fa-facebook-f "></i></a></div>
                <?php }
                          endif;
                          ?>
                <?php 
                           if(defined('YOUTUBEMEDIAID')):
                               if(in_array(YOUTUBEMEDIAID,$usermedia))
                              { ?>
                <div class="col-xs-1 cmedia hidden" id="youtubemedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo YOUTUBEMEDIAID?>" href="" data-medianame="youtube" class="btn btn-block btn-danger mediabrand "><i class="fa fa-youtube-play "></i></a></div>
                <?php }
                          endif;
                          ?>
                <?php 
                           if(defined('TWITTERMEDIAID')):
                               if(in_array(TWITTERMEDIAID,$usermedia))
                              { ?>
                <div class="col-xs-1 cmedia hidden" id="twittermedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo TWITTERMEDIAID?>" href="#" data-medianame="twitter" class="btn btn-block btn-info mediabrand "><i class="fa fa-twitter "></i></a></div>
                <?php }
                            endif;
                          ?>
                <?php 
                            if(defined('INSTAGRAMMEDIAID')):
                               if(in_array(INSTAGRAMMEDIAID,$usermedia))
                              { ?>
                <div class="col-xs-1 cmedia hidden" id="instagrammedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo INSTAGRAMMEDIAID?>" href="#"  data-medianame="instagram" class="btn btn-block btn-info mediabrand btn-intg"><i class="fa fa-instagram "></i></a></div>
                <?php }
                          endif;
                          ?>
                <?php if(defined('YOUTULEEMEDIAID')):
                               if(in_array(YOUTULEEMEDIAID,$usermedia))
                              { ?>
                <div class="col-xs-1 cmedia hidden" id="youtuleemedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"   data-mediaid="<?php echo YOUTULEEMEDIAID?>" href="#" data-medianame="youtulee" class="btn btn-block mediabrand btn-success btn-youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </a></div>
                <?php }
                      endif;
                          ?>
                <?php 
                           if(defined('TUMBLRMEDIAID')):
                               if(in_array(TUMBLRMEDIAID,$usermedia))
                              { ?>
                <div class="col-xs-1 cmedia hidden" id="tumblrmedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo TUMBLRMEDIAID?>" href="#" data-medianame="tumblr" class=" mediabrand btn btn-block btn-info btn-tumb"><i class="fa fa-tumblr "></i></a></div>
                <?php }
                          endif;
                          ?>
              </div>
            </div>
            <h2>Send Collab Proposal</h2>
            <p>Tell the brand what kind of content you want to create, your fee, etc.
              Sponsored content must stay up for at least six months.</p>
            <div style="clear: both;"></div>
          </div>
          <form name="submitporposal" id="proposalform" method="post">
            <div class="body">
              <?php 
                         $data['socialmedia']=$socialmedia;
                         $this->load->view('creator/collab_proposal_submit',$data);?>
              <div class=" col-sm-12 bottom_content">
                <div class="col-sm-4">
                  <div class="error-message" style="display:none;color:red; font-size:12px;"></div>
                  <button class="btn btn-success" id="submitproposalcollab">
                  <div class="btn-img" style="float:left">
                    <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
                    <i class="fa fa-check createcheck"></i> </div>
                  Send Proposal</button>
                </div>
                <div class="clearfix"></div>
                <div class="user_media hidden">
                  <h4>You can connect to following media by clicking</h4>
                  <div class="row form-group usernotconnectedmedia brandtype">
                    <?php 
                          if(defined('FACEBOOKMEDIAID')):
                                if(!in_array(FACEBOOKMEDIAID,$usermedia))
                                { ?>
                    <a href="<?php echo $fb_url;?>" id="connectfacebook" class="medianotconnected btn btn-block btn-primary hidden"><i class="fa fa-facebook-f "></i></a>
                    <?php }
                          endif;
                          if(defined('YOUTUBEMEDIAID')):
                              if(!in_array(YOUTUBEMEDIAID,$usermedia))
                              { ?>
                    <a href="<?php echo $yt_url;?>" id="connectyoutube"  class="btn btn-block btn-danger medianotconnected hidden  "><i class="fa fa-youtube-play "></i></a>
                    <?php }
                          endif;
                          if(defined('TWITTERMEDIAID')):
                              if(!in_array(TWITTERMEDIAID,$usermedia))
                              { ?>
                    <a href="<?php echo $tw_url;?>" id="connecttwitter"  class="btn btn-block btn-info medianotconnected  hidden"><i class="fa fa-twitter "></i></a>
                    <?php }
                           endif;
                          if(defined('INSTAGRAMMEDIAID')):
                               if(!in_array(INSTAGRAMMEDIAID,$usermedia))
                              { ?>
                    <a href="<?php echo $ins_url;?>" id="connectinstagram" class="btn btn-block btn-info medianotconnected btn-intg hidden"><i class="fa fa-instagram "></i></a>
                    <?php }
                          endif;
                          if(defined('YOUTULEEMEDIAID')):
                                if(!in_array(YOUTULEEMEDIAID,$usermedia))
                                { ?>
                    <a href="<?php echo $ytl_url;?>" id="connectyoutulee" class="btn btn-block medianotconnected hidden btn-youtulee "><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"></a>
                    <?php }
                          endif;
                          if(defined('TUMBLRMEDIAID')):
                                if(!in_array(TUMBLRMEDIAID,$usermedia))
                                { ?>
                    <a href="<?php echo $tm_url;?>" id="connecttumblr" class=" medianotconnected btn btn-block btn-info btn-tumb hidden "><i class="fa fa-tumblr "></i></a>
                    <?php }
                          endif;
                          ?>
                  </div>
                </div>
                <div style="clear: both;"></div>
              </div>
            </div>
          </form>
          <div style="clear: both;"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
 var getproposal='<?php echo site_url('/'.CREATOR.'getproposal')?>';
  var proposalurl='<?php echo site_url('/'.CREATOR.'sendproposal')?>';
  var getmedialist='<?php echo site_url('/'.CREATOR.'getmedialist')?>';
  var sessionurl='<?php echo site_url('/'.CREATOR.'setsession');?>'
</script>
<?php
          }
          else{
            ?>
No records
<?php 
          }
            
       ?>

<script>
// init Isotope
var grid = document.querySelector('.grid');
var msnry = new Masonry( grid, {
  itemSelector: '.grid-item',
  columnWidth: '.grid-sizer',
  percentPosition: true
});
imagesLoaded( grid ).on( 'progress', function() {
  // layout Masonry after each image loads
  msnry.layout();
});
</script> 
<script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }

</script> 
