
<div class="grid-sizer"></div>
<?php 
          $usermedia=array();
          foreach($usermediaassociation as $val){
            $usermedia[]=$val->media_type_id;
          }
          if(count($sponsorships)>0)
          {
            foreach($myproposals as $sponsitem)
            { 

          
              ?>
<div class="grid-item"> <span class="btn btn-info price_range"><?php echo DEFAULT_CURRENCY_SIGN.$sponsitem['price_range'];?></span>
  <?php if($sponsitem['image'])
                {
                  $image=$sponsitem['image'];
                }else{
                    $image='default.png';
                }
                $date=date_create( $sponsitem['submission_deadline']);
              $submission_deadline= date_format($date,"Y-m-d");
              ?>
  <figure> <img id="<?php echo $sponsitem['product_id'];?>_productimg" src="<?php echo  site_url(PRODUCT_IMAGE_PATH.$image)?>"> </figure>
  <div class="grid_inn">
    <h4> <a href="#" id="<?php echo $sponsitem['product_id'];?>_product_name"><?php echo $sponsitem['product_name'];?></a>
      <input type="hidden" id="<?php echo $sponsitem['product_id'];?>_allmedia" value="<?php echo $sponsitem['media'];?>" >
      <input type="hidden" id="<?php echo $sponsitem['product_id'];?>_product_url" value="<?php echo $sponsitem['product_url'];?>">
      <input type="hidden"  id="<?php echo $sponsitem['product_id'];?>_price_range" value="<?php echo DEFAULT_CURRENCY_SIGN.$sponsitem['price_range'];?>">
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
      <span class="pull-right round_btn facebook "> <i class="fa fa-facebook-f"></i> </span>
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
      <span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span>
      <?php }
                           }
                          ?>
      <input id="<?php echo $sponsitem['product_id'];?>_socialmediaid" type="hidden" name="proposalformedia" data-media="<?php echo $socialmedia[0];?>" value="<?php echo constant(strtoupper($socialmedia[0]).'MEDIAID');?>">
      <?php 
                        }
                       
                        ?>
    </h4>
    <p id="<?php echo $sponsitem['product_id'];?>_description"> <?php echo $sponsitem['description'];?> </p>
  </div>
  
  <!-- <hr>    -->
  <div class="text-center"> <a href="#" data-productid="<?php echo $sponsitem['product_id'];?>" data-btntype="edit" data-media="<?php echo $sponsitem['media'];?>" class="btn btn-success sendproposal" id="sponsorshipproposal_<?php  echo $sponsitem['product_id'] ?>">Send Proposal</a> <a href="#" data-productid="<?php echo $sponsitem['product_id'];?>" class="btn btn-primary sponsordetail" id="<?php echo $sponsitem['product_id'];?>_sponsordetailid" >Detail</a> </div>
  <!-- </hr> --> 
  
</div>
<?php }
          }
          else{
            ?>
No records
<?php 
          }
            
       ?>
<?php if($this->session->userdata('popup_media')=='enable'){
  ?>
<script>
    $(function(){
      $('#sponsorshipproposal_<?php echo $this->session->userdata("selectedproduct")?>').click();
      
    });
  </script>
<?php 
  $this->session->unset_userdata('popup_media');
  $this->session->unset_userdata('selectedproduct');
  }?>
<div id="proposal_popup_edit" class="modal fade bs-example-modal-lg proposal_popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="sendprop_modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
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
                <?php if(in_array(FACEBOOKMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 smedia hidden" id="facebookmedia"><a data-productid="<?php echo $sponsitem['product_id'];?>" data-mediaid="<?php echo FACEBOOKMEDIAID?>" data-medianame="facebook" href="#" class="mediabrand btn btn-block btn-primary"><i class="fa fa-facebook-f "></i></a></div>
                <?php }
                          ?>
                <?php if(in_array(YOUTUBEMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 smedia hidden" id="youtubemedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo YOUTUBEMEDIAID?>" href="" data-medianame="youtube" class="btn btn-block btn-danger mediabrand "><i class="fa fa-youtube-play "></i></a></div>
                <?php }
                          ?>
                <?php if(in_array(TWITTERMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 smedia hidden" id="twittermedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo TWITTERMEDIAID?>" href="#" data-medianame="twitter" class="btn btn-block btn-info mediabrand "><i class="fa fa-twitter "></i></a></div>
                <?php }
                          ?>
                <?php if(in_array(INSTAGRAMMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 smedia hidden" id="instagrammedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo INSTAGRAMMEDIAID?>" href="#"  data-medianame="instagram" class="btn btn-block btn-info mediabrand btn-intg"><i class="fa fa-instagram "></i></a></div>
                <?php }
                          ?>
                <?php if(in_array(YOUTULEEMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 smedia hidden" id="youtuleemedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"   data-mediaid="<?php echo YOUTULEEMEDIAID?>" href="#" data-medianame="youtulee" class="btn btn-block mediabrand btn-success btn-youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"></a></div>
                <?php }
                          ?>
                <?php if(in_array(TUMBLRMEDIAID,$usermedia))
                          { ?>
                <div class="col-xs-1 smedia hidden" id="tumblrmedia"><a data-productid="<?php echo $sponsitem['product_id'];?>"  data-mediaid="<?php echo TUMBLRMEDIAID?>" href="#" data-medianame="tumblr" class=" mediabrand btn btn-block btn-info btn-tumb"><i class="fa fa-tumblr "></i></a></div>
                <?php }
                          ?>
              </div>
            </div>
            <h2>Send Proposal</h2>
            <p>Tell the brand what kind of content you want to create, your fee, etc.
              Sponsored content must stay up for at least six months.</p>
            <div style="clear: both;"></div>
          </div>
          <form name="submitporposal" id="proposalform" method="post">
            <div class="body">
              <?php 
                       $data['socialmedia']=$socialmedia;
                        $this->load->view('creator/proposal_submit',$data);?>
              <div class=" col-sm-12 bottom_content">
                <div class="col-sm-4">
                  <div class="error-message" style="display:none;color:red; font-size:12px;"></div>
                  <button class="btn btn-success" id="submitproposal">
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
                          
                          if(!in_array(FACEBOOKMEDIAID,$usermedia))
                          { ?>
                    <a href="<?php echo $fb_url;?>" id="connectfacebook" class="medianotconnected btn btn-block btn-primary hidden"><i class="fa fa-facebook-f "></i></a>
                    <?php }
                          ?>
                    <?php if(!in_array(YOUTUBEMEDIAID,$usermedia))
                          { ?>
                    <a href="<?php echo $yt_url;?>" id="connectyoutube"  class="btn btn-block btn-danger medianotconnected hidden  "><i class="fa fa-youtube-play "></i></a>
                    <?php }
                          ?>
                    <?php if(!in_array(TWITTERMEDIAID,$usermedia))
                          { ?>
                    <a href="<?php echo $tw_url;?>" id="connecttwitter"  class="btn btn-block btn-info medianotconnected  hidden"><i class="fa fa-twitter "></i></a>
                    <?php }
                          ?>
                    <?php if(!in_array(INSTAGRAMMEDIAID,$usermedia))
                          { ?>
                    <a href="<?php echo $ins_url;?>" id="connectinstagram" class="btn btn-block btn-info medianotconnected btn-intg hidden"><i class="fa fa-instagram "></i></a>
                    <?php }
                          ?>
                    <?php if(!in_array(YOUTULEEMEDIAID,$usermedia))
                          { ?>
                    <a href="<?php echo $ytl_url;?>" id="connectyoutulee" class="btn btn-block medianotconnected btn-success hidden"><i class="fa fa-youtulee "></i></a>
                    <?php }
                          ?>
                    <?php if(!in_array(TUMBLRMEDIAID,$usermedia))
                          { ?>
                    <a href="<?php echo $tm_url;?>" id="connecttumblr" class=" medianotconnected btn btn-block btn-info btn-tumb hidden "><i class="fa fa-tumblr "></i></a>
                    <?php }
                          ?>
                  </div>
                </div>
                <!--  <div class="col-sm-3">
                                <span class="text-right"> Expire Date:</span>
                            </div> --> 
                <!--   <div class="col-sm-5 no-pad-left">
                                <div class="input-group date">
                                    <input type="text" id="bid_expire_date" name="bid_expire_date" class="form-control"/><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>                                                               
                            </div> --> 
              </div>
              <div style="clear: both;"></div>
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