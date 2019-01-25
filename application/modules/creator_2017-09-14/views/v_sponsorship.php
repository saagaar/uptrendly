<?php 
 foreach($usermediaassociation as $val){
            $usermedia[]=$val->media_type_id;
          }

?>

<div class="mid-part margin_0">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php if($views=='public'):?>  class="active"<?php endif;?>><a href="#public" aria-controls="home" role="tab" data-toggle="tab" class="sponsorstabs" data-type="public">Sponsorships</a> </li>
    <li role="presentation"   <?php if($views=='invitation'):?>  class="active"<?php endif;?>><a class="sponsorstabs" href="#invitation" data-type="invitation" aria-controls="profile" role="tab" data-toggle="tab">Invitation</a></li>
    <li role="presentation"  <?php if($views=='my-proposal'):?>  class="active"<?php endif;?>  ><a href="#my-proposal" data-type="my-proposal"  class="sponsorstabs" aria-controls="proposals" role="tab" data-toggle="tab">Proposals</a></li>
  </ul>
  <?php //if($views!='invitation'):

  ?>
  <div class="msz_filter_sec filterblock <?php if($views=='invitation') echo 'hidden'?>">
    <div class="col-xs-6 col-sm-4 col-md-3">
      <form class="form-inline search" >
        <input type="text" class="form-control name"  placeholder="Jane Doe" autocomplete="off">
        <button class="btn filteroptname" type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    
    <div class="col-xs-6 pull-right text-right">
      <ul class="list-unstyled">
        <li>
          <select class="mediachannel filteropt btn btn-default">
            <option value="">Channel</option>
            <?php

                          $price_range=$this->general->get_price_range();
                          $socialmedia=$this->general->get_socialmedia_channel();
                          foreach($socialmedia as $channel)
                          {
                            echo '<option  value='."$channel->id".'>'. ucfirst($channel->media_type).'</option>';
                          }

                      ?>
          </select>
        </li>
        <li>
          <select class="btn btn-default pricerange filteropt">
            <option value="">Filter by </option>
            <?php 
                             foreach($price_range as $pr)
                              {
                              echo '<option  value='."$pr->id".'>'. ucfirst($pr->price_range).'</option>';
                              }
                              ?>
          </select>
        </li>
        <!-- <li><a href="#" class="btn btn-default"><i class="fa fa-refresh"></i></a></li> -->
      </ul>
    </div>

    <div class="clearfix"></div>
  </div>
  <?php //endif;?>
  <div class="tab-content">
    <div class="tab-pane fade in grid filterview   <?php if($views=='public'):?>  active<?php endif;?> tabview" id="public">
      <?php
        if($views=='public'):
        $this->load->view('creator/ajax-sponsorship');
        endif;
        ?>
    </div>
    <div class="tab-pane fade grid in <?php if($views=='invitation'):?>  active<?php endif;?>" id="invitation">
      <?php    $this->load->view('creator/v_invitations');?>
    </div>
    <div class="tab-pane fade in tabview grid filterview  <?php if($views=='my-proposal'):?>  active<?php endif;?>" id="my-proposal">
      <?php 
       if($views=='my-proposal'):
          $this->load->view('creator/ajax-sponsorship');
        endif;
    ?>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
</div>
</div>
<div id="detail_popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
      <div class="row">
        <div class="col-sm-4 text-center pop_left">
          <figure><img id="productimg" src=""></figure>
          <h4 id="product_name"></h4>
          <!-- <a href="#" class="btn btn-warning">Edit Campaigns</a> --> 
        </div>
        <div class="col-sm-8">
          <div class="row text-center three_sec">
            <div class="col-xs-4">
              <h5>CONTENT BUDGET</h5>
              <b>
              <p id="budget"></p>
              </b></div>
            <div class="col-xs-4 channel">
              <h5>CHANNELS</h5>
              <span id="facebookico" class="round_btn hidden facebook"><i class="fa fa-facebook-f"></i></span> <span id="youtuleeico" class="round_btn mediaicon hidden youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"></span> <span id="youtubeico" class="round_btn mediaicon hidden youtube"><i class="fa fa-youtube-play"></i></span> <span id="twitterico" class="round_btn mediaicon hidden twitter"><i class="fa fa-twitter"></i></span> <span id="tumblrico" class="round_btn mediaicon hidden tumblr"><i class="fa fa-tumblr"></i></span> <span id="instagramico" class="round_btn mediaicon hidden instagram"><i class="fa fa-instagram"></i></span> </div>
            <div class="col-xs-4">
              <h6>SUBMISSION DEADLINE</h6>
              <b id="submissiondeadline"></b></div>
          </div>
          
          <!-- <h5>VIDEO TYPES: REVIEW,MENTION,HAUL,FAVORITES</h5> -->
          <h5>SITE: <a href="#" id="producturl" ></a></h5>
          <div >
            <p id="description"> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="send_draft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content post_collab_form text-center">
      <form name="draftform" id="draftform" method="post" action="<?php echo site_url('/'.CREATOR.'send_draft');?>">
        <div class="post_collab_container">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
            <div class="hidden" id="customlinkdiv"> You custom link
              <div id="customlinkline" class="alert alert-info"></div>
              <!-- <div id="button"><button id="copytoclipboard" class="btn btn-info" >Copy Link</button></div> --> 
              
            </div>
            <h2 class="modal-title" id="myModalLabel">Draft of Promotion</h2>
            <!-- <p>Tell fellow creator what type of collaboration you are interested in, the details, etc.</p> --> 
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="bidid" id="draftbidid" value="" >
              <input type="hidden" name="draftid" id="draftid" value="" >
            </div>
            <div class="form-group">
              <textarea class="form-control" name="description" rows="5" id="draftdescription" placeholder="Draft Description"></textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="link" id="link_url" placeholder="Link of draft" value=""/>
            </div>
          </div>
          <div class="bottom-content" style="text-align:center;">
            <div class="error-message hidden" style="color:red"></div>
            <button class="btn btn-success" type="submit" id="send_draftpromotion">
            <div class="btn-img" style="float:left">
              <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
              <i class="fa fa-check createcheck"></i> </div>
            Send Draft </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="add_socialtrack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content post_collab_form text-center">
      <form name="trackmedia" id="save_trackmediaform" method="post" action="<?php echo site_url('/'.MY_ACCOUNT.'savetrackid');?>">
        <div class="post_collab_container">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
            <h2 class="modal-title" id="myModalLabel">Add Social media Id</h2>
            <p>Place the id of post you have shared in social media so that system can track the progress.</p>
            <div class="alert alert-danger error-message"> <span class="text-danger">Note:</span> <span class="round_btn facebook"><i class="fa fa-facebook"></i></span> Please add trackid in format <b>PAGEID_POSTID </b> </div>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="bidid" id="trackbidid" value="" >
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="socialmediaid" id="socialmediaid" placeholder="Shared Post Id" value=""/>
            </div>
          </div>
          <div class="bottom-content" style="text-align:center;">
            <div class="error-message hidden" style="color:red"></div>
            <button class="btn btn-success" type="submit" id="save_trackmediabtn">
            <div class="btn-img" style="float:left">
              <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
              <i class="fa fa-check createcheck"></i> </div>
            Save Media Id </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
var action='<?php echo site_url('/'.CREATOR.'ajax_sponsorship')?>';
var getdraft='<?php echo site_url('/'.CREATOR.'get_draft')?>';
var gettrackid='<?php echo site_url('/'.MY_ACCOUNT.'gettrackid')?>'
var urlhistory='<?php echo site_url('/'.CREATOR.'sponsorship');?>'
</script> 
