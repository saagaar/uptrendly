<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
        <h4 class="modal-title" id="myModalLabel">Platform Collaboration Selection</h4>
      </div>
      <div class="modal-body">
        <div class="bg_fff text-center">
          <p>Select all the social platforms that you want to collab on with other creators.</p>
          <?php 
                    $media=array();
                    $socialmedia=$this->general->get_socialmedia_user($this->session->userdata(SESSION.'user_id'));
                    if(count($socialmedia)>0)
                    {
                        foreach ($socialmedia as $key => $value) {
                          $media[]=$value->media_type_id;
                        }
                    }
                    
                      // $media[]=2;

                   
                    ?>
          <div class="form-group row brandtype c">
            <input type="hidden" name="collabsocialmedia" id="collabsocialmedia">
            <?php 
                            if(defined('YOUTUBEMEDIAID')):
                                  if(in_array(YOUTUBEMEDIAID,$media)){ ?>
            <div class="f_left smediacollab"><a data-mediaid="<?php echo YOUTUBEMEDIAID?>" href="#" class="btn btn-block btn-danger mediabrand"><i class="fa fa-youtube-play "></i></a></div>
            <?php }
                            endif;
                            if(defined('TWITTERMEDIAID')):
                                if(in_array(TWITTERMEDIAID,$media)){ ?>
            <div class="f_left smediacollab"><a  data-mediaid="<?php echo TWITTERMEDIAID?>" href="#" class="btn btn-block btn-info mediabrand"><i class="fa fa-twitter "></i></a></div>
            <?php }
                            endif;
                            if(defined('INSTAGRAMMEDIAID')):
                                if(in_array(INSTAGRAMMEDIAID,$media)){ ?>
            <div class="f_left smediacollab"><a data-mediaid="<?php echo INSTAGRAMMEDIAID?>" href="#" class="btn btn-block btn-info mediabrand btn-intg"><i class="fa fa-instagram "></i></a></div>
            <?php }
                            endif;
                            if(defined('YOUTULEEMEDIAID')):
                                if(in_array(YOUTULEEMEDIAID,$media)){ ?>
            <div class="f_left smediacollab"><a  data-mediaid="<?php echo YOUTULEEMEDIAID?>" href="#" class="btn btn-block mediabrand btn-success btn-youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </a></div>
            <?php }
                            endif;
                            if(defined('TUMBLRMEDIAID')):
                                if(in_array(TUMBLRMEDIAID,$media)){ ?>
            <div class="f_left smediacollab"><a data-mediaid="<?php echo TUMBLRMEDIAID?>" href="#" class=" mediabrand btn btn-block btn-info btn-tumb"><i class="fa fa-tumblr "></i></a></div>
            <?php }
                          endif;
                          if(defined('FACEBOOKMEDIAID')):
                               if(in_array(FACEBOOKMEDIAID,$media)){ ?>
            <div class="f_left smediacollab"><a data-mediaid="<?php echo FACEBOOKMEDIAID?>" href="#" class="mediabrand btn btn-block btn-primary"><i class="fa fa-facebook-f "></i></a></div>
            <?php }
                          endif;
                            ?>
          </div>
          <div class="small_btns">
            <p>To collaborate on the following platforms, click below to connect them to FameBit!</p>
            <a href="" class="btn btn-success btn-youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </a> <a href="" class="btn btn-info btn-intg"><i class="fa fa-instagram"></i></a> <a href="" class="btn btn-info btn-tumb"><i class="fa fa-tumblr"></i></a> <a href="" class="btn btn-info"><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-primary"><i class="fa fa-facebook-f"></i></a> </div>
        </div>
      </div>
      <div class="modal-footer" style="text-align:center;">
        <button type="button" class="btn btn-warning" disabled="disabled" id="selectbrandbtn">Go Next <i class="fa fa-arrow-right"></i></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="popup-postcollab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content post_collab_form text-center">
      <form name="addcreatorcollab" id="addcreatorcollab" method="post" action="#">
        <div class="post_collab_container">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
            <h2 class="modal-title" id="myModalLabel">Collaboration Detail</h2>
            <p>Tell fellow creator what type of collaboration you are interested in, the details, etc.</p>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" id="create_type" name="create_type" class="form-control"  value="collab">
              <input type="hidden" id="productid" name="productid" class="form-control"  value="">
              <input type="hidden" name="brandmediaid" id="postsocialmediaid" value="" >
              <input type="text" class="form-control" placeholder="Collab Title" id="c_productname" name="name"/>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="description" rows="5" id="c_description" placeholder="Collab Details"></textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="least_fan_count" id="c_leastcount" placeholder="Least Fan Count" value=""/>
            </div>
            <div class="form-group input-group date">
              <input type="text" class="form-control" id="c_submission_deadline" name="submission_deadline" placeholder="Delivery Date" />
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
            <div class="form-group">
              <select class="form-control" id="c_save_method" name="save_method">
                <option value="1">Open for Bidding</option>
                <option value="2">Saved to Draft</option>
              </select>
            </div>
          </div>
          <div class="bottom-content" style="text-align:center;">
            <div class="error-message" style="display:none;color:red"></div>
            <button class="btn btn-success" type="submit" id="create_collab">
            <div class="btn-img" style="float:left">
              <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
              <i class="fa fa-check createcheck"></i> </div>
            Create Collab </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    $('.input-group.date').datepicker({
       todayBtn: "linked",
         startDate:new Date(),
          format: 'yyyy/mm/dd',
        autoclose: true,
        todayHighlight: true
    });
    var collaburl='<?php echo site_url('/'.CREATOR.'create_collab');?>';
</script> 
<script src="<?php echo base_url().USER_JS_DIR; ?>collab.js"></script> 
