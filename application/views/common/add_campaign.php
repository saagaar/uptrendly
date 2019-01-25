<!-- Modal -->

<div class="modal fade"  id="Modalcampaignedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
        <h4 class="modal-title" id="myModalLabel">Where do you want to promote your brand?</h4>
      </div>
      <div class="modal-body">
        <div class="bg_fff">
          <div class="row form-group brandtype">
            <?php if(defined('YOUTUBEMEDIAID')):?>
            <div class="col-xs-2 smedia"><a data-mediaid="<?php echo YOUTUBEMEDIAID?>" href="" class="btn btn-block btn-danger mediabrand"><i class="fa fa-youtube-play "></i></a></div>
            <?php 
                            endif;
                            if(defined('TWITTERMEDIAID')):
                          ?>
            <div class="col-xs-2 smedia"><a  data-mediaid="<?php echo TWITTERMEDIAID?>" href="#" class="btn btn-block btn-info mediabrand"><i class="fa fa-twitter "></i></a></div>
            <?php 
                          endif;
                           if(defined('INSTAGRAMMEDIAID')):
                          ?>
            <div class="col-xs-2 smedia"><a data-mediaid="<?php echo INSTAGRAMMEDIAID?>" href="#" class="btn btn-block btn-info mediabrand btn-intg"><i class="fa fa-instagram "></i></a></div>
            <?php 
                          endif;
                            if(defined('YOUTULEEMEDIAID')):
                          ?>
            <div class="col-xs-2 smedia"><a  data-mediaid="<?php echo YOUTULEEMEDIAID?>" href="#" class="btn btn-block mediabrand btn-success btn-youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </a></div>
            <?php 
                            endif;
                              if(defined('TUMBLRMEDIAID')):
                            ?>
            <div class="col-xs-2 smedia"><a data-mediaid="<?php echo TUMBLRMEDIAID?>" href="#" class=" mediabrand btn btn-block btn-info btn-tumb"><i class="fa fa-tumblr "></i></a></div>
            <?php 
                              endif;
                                   if(defined('FACEBOOKMEDIAID')):
                              ?>
            <div class="col-xs-2 smedia"><a data-mediaid="<?php echo FACEBOOKMEDIAID?>" href="#" class="mediabrand btn btn-block btn-primary"><i class="fa fa-facebook-f "></i></a></div>
            <?php 
                              endif;
                              ?>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="text-align:center;">
        <button type="button" class="btn btn-warning selectbrand" id="brandselectbtn" data-productid="" disabled="disabled" data-toggle="modal" data-target=".bs-example-modal-lg">Go Next <i class="fa fa-arrow-right"></i></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="campaigncreation" role="dialog" aria-labelledby="myLargeModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header text-center">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
      <h4 class="modal-title" id="myModalLabel">Campaign Details</h4>
      <p>After posting your campaign you'll receive proposals from interested creators. From there simply select the creators you want to work with and let the magic begin.</p>
    </div>
    <div>
      <div class="modal-body" >
        <?php $this->load->view('common/add_auction');?>
      </div>
      <div class="modal-footer" style="text-align:center;">
        <div class="error-message" style="display:none;color:red"></div>
        <!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">
                                      <i class="fa fa-arrow-left"></i> Go back</button> -->
        <button type="submit" class="btn btn-primary" id="create_campaign" data-type="create" form="addbrandcampaign">
        <div class="btn-img" style="float:left">
          <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
          <i class="fa fa-check createcheck"></i> </div>
        Create Campaign</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url().USER_JS_DIR; ?>add.campaign.js"></script> 
