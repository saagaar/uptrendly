<div class="campaign">
  <div class="col-sm-3" style="margin:20px 0;">
    <select class="form-control filteropt  proposaltype">
      <option value="">All</option>
      <option value="completed">Completed</option>
      <option value="open">In progress</option>
      <option value="new_offers">New Offers</option>
    </select>
  </div>
  <div class="img-loader" style="z-index:1000;display: none"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
  <div role="tabpanel" class="col-xs-12 filterview">
    <?php $this->load->view('creator/ajax_campaign');?>
  </div>
  <div class="clearfix"></div>
</div>
<script>
      var getdraft='<?php echo site_url('/'.CREATOR.'get_draft')?>';
      var imgurl='<?php echo  site_url(DRAFT_IMAGE_PATH);?>';
      var action="<?php echo site_url('/'.CREATOR.'ajax_campaigns')?>";
      var changestatusurl="<?php echo site_url('/'.MY_ACCOUNT.'accept_reject_brand_request')?>";
    </script>
<div class="modal fade" id="send_draft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content text-center">
<form name="draftform" id="draftform" method="post" enctype="multipart/form-data" action="<?php echo site_url('/'.CREATOR.'send_draft');?>">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button><h4 class="modal-title" id="myModalLabel"><b>Draft of Promotion</b></h4></div>
  <div class="modal-body">
    <div class="form-group">
      <input type="hidden" name="bidid" id="draftbidid" value="" >
      <input type="hidden" name="draftid" id="draftid" value="" >
    </div>
    
    <!-- <div class="form-group">
            <?php $media=$this->general->get_all_media(); foreach($media as $value){?>

               <?php if($value=='facebook'){?>
                        <span class="round_btn facebook "> <i class="fa fa-facebook-f"></i> </span>
                        <?php } 

                        if($media=='twitter')
                                            {
                                            
                                              ?>
          <span class="round_btn twitter"> <i class="fa fa-twitter-square"></i> </span>
          <?php
                                            }
                                              if($value=='instagram')
                                            {
                                              ?>
          <span class="round_btn instagram"> <i class="fa fa-instagram"></i> </span>
          <?php
                                            }
                                            if($value=='youtulee')
                                          {
                                            ?>
          <span class="round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
          <?php
                                          }
                                           if($value=='tumblr')
                                          {
                                            ?>
          <span  class="round_btn  tumblr"><i class="fa fa-tumblr"></i></span>
          <?php
                                          }
                                              if($value=='youtube')
                                            {
                                              ?>
          <span class="round_btn youtube"> <i class="fa fa-youtube"></i> </span>
          <?php

               } ?><input type="radio" id="social_media" name="social_media" value="<?php echo constant(strtoupper($value).'MEDIAID');?>"> <?php } ?>

            </div> -->
    
    <div class="form-group">
      <textarea class="form-control" name="description" rows="5" id="draftdescription" placeholder="Draft Description"></textarea>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="link" id="link_url" placeholder="Link of draft" value=""/>
    </div>
    
    <div class="upload_product_image text-center form-group">
      <div class="brwose-image"><h1><i class="fa fa-user"></i></h1></div>
      <div class="fileUpload btn btn-lg btn-primary"><span>Add Photo</span>
        <input type="file" name="uploadimage" id="fileUpload0" class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
      </div>
  <?php echo form_error('uploadimage'); ?>
    </div>
  </div>
  <div class="modal-footer">
<div class="bottom-content text-center">
    <div class="error-message hidden" style="color:red"></div>
    <button class="btn btn-success" type="submit" id="send_draftpromotion" style="padding:0px 20px 0 0; line-height:40px;">
    <div class="btn-img" style="float:left">
      <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
      <i class="fa fa-check createcheck" style="margin:0 15px -15px 0;"></i> </div>
    Send Draft </button>
  </div></div>
</form>
</div>
</div>
</div>
