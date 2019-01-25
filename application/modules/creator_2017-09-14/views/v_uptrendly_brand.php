<div class="grid">
          <div class="grid-sizer"></div>
          <?php foreach($brands as $eachbrand):
          $profile=  $this->general->get_profile_image($eachbrand->cover_image);
          ?>
          <div class="grid-item"><!-- <span class="btn btn-info price_range">$1,000 - $2,500</span> --> <img id="profilecreator_<?php echo $eachbrand->user_id;?>" src="<?php echo $profile?>">
          <div class="grid_inn"><h4><a  href="#"><?php echo $eachbrand->brand_name?></a> </h4>
          <!-- <p>I'll be in Chicago from October 7th - 11th! I'd love to meet other content creators and possibly collab while I'm there! I make reaction videos, if...</p> -->
          </div> <hr> 
           <div class="text-center"><a href="#" class="btn btn-sm btn-primary invitecreator" data-userid="<?php echo $eachbrand->user_id;?>"><i class="fa fa-paper-plane "></i> Inquire</a>
         <!-- <a href="" class="btn btn-primary" data-toggle="modal" data-target="#detail_popup">Detail</a>--></div>   
          </div>
        <?php endforeach;?>
          
        </div>


        <!-- invitation to creators -->
<div id="invite_creators" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="sendprop_modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
        <div class="sendprop_modal_container">
          <div class="modal_title">
            <h2>Invite Brand</h2>
            <p>You can invite Brand to submit a proposal for a campaign below</p>
            <div style="clear: both;"></div>
          </div>
          <form name="sendinvitation" id="sendinvitation" action="#" method="post">
            <input type="hidden" name="userid" id="inviteuser" value="">
            <div class="body">
            <div class="col-sm-12 clearfix">
              <div class="col-sm-12">
                <div class="invite_img">
                  <div class="img_box"> <img src="" class="center" id="profilepicturecreator"> </div>
                </div>
              </div>
                         <div class="form-group">
                <label>Select Image:</label>
                  <div class="upload_product_image text-center">
                 <div class="brwose-image">
                 
                  <h1><i class="fa fa-user"></i></h1>
                  
                        
                  </div>
                  <div class="fileUpload btn btn-lg btn-primary"><span>Add Photo</span>
                    <input type="file" name="uploadimage[]"   class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
                  </div>
                </div>
             </div>
            </div>
            <div class="col-sm-12 clearfix">
              <textarea  rows="8" class="form-control" id="message" name="message" placeholder="Message(optional)"></textarea>
              <div class="clear"></div>
            </div>
            <div class="col-sm-12 bottom_content text-center">
            <button class="btn btn-success" id="sendinvitationbtn">
            <div class="btn-img" style="float:left">
              <div class="img-loader" style="z-index:1000;display: none;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
              <i class="fa fa-check createcheck"></i> </div> Send Proposal</button>
            </div>
            <div class="clearfix"></div>
            </div>
          </form>
            <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>

        <script>
        var sendinvitation='<?php echo site_url(CREATOR.'/inviteuser')?>'
// external js: masonry.pkgd.js, imagesloaded.pkgd.js

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