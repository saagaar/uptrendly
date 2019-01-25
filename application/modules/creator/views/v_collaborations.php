
<div class="mid-part margin_0">
<ul class="nav nav-tabs"  role="tablist">
  <li  role="presentation" <?php if($views=='public'):?>  class="active"<?php endif;?>><a data-toggle="tab" data-type="public" href="#public" class="sponsorcollabtab">Public</a></li>
  <li  role="presentation" <?php if($views=='manage-collab'):?>   class="active"<?php endif;?> ><a data-toggle="tab" href="#manage-collab" data-type="manage-collab" class="sponsorcollabtab">Manage</a></li>
  <li  role="presentation" <?php if($views=='my-proposal'):?>   class="active"<?php endif;?> ><a data-toggle="tab" href="#my-proposal" data-type="my-proposal" class="sponsorcollabtab">My Proposals</a></li>
</ul>

<div class="msz_filter_sec  filterblock <?php if($views=='manage-collab') echo 'hidden'?>">
  <div class="col-xs-6 col-sm-4 col-md-3">
    <form class="form-inline search">
      <input type="text" class="form-control name" id="exampleInputName2"  placeholder="Jane Doe">
      <button class="btn filteroptname" type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <div class="col-xs-6 pull-right text-right">
    <ul class="list-unstyled">
      <li>
        <select class="mediachannel filteropt btn btn-default">
          <option value="">Channel</option>
          <?php

                          $socialmedia=$this->general->get_socialmedia_channel();
                          foreach($socialmedia as $channel)
                          {
                            echo '<option  value='."$channel->id".'>'. ucfirst($channel->media_type).'</option>';
                          }

                      ?>
        </select>
      </li>
      <li>
        <select  class="btn btn-default filteropt fancount">
          <option value="">Filter by Likes</option>
          <option value="1000">&lt;1K</option>
          <option value="5000">&lt;5K</option>
          <option value="10000">&lt;10K</option>
          <option value="50000">&lt;50K</option>
          <option value="100000">&lt;1M</option>
        </select>
      </li>
      <li><a href="#" class="btn btn-default"><i class="fa fa-refresh"></i></a></li>
    </ul>
  </div>
  <div class="clearfix"></div>
</div>

<div class="tab-content">
  <div class="grid filterview tab-pane fade in  <?php if($views=='public'):?>  active<?php endif;?> tabview" id="public">
    <?php

        if($views=='public'):
        $this->load->view('creator/ajax-collab');
        endif;
        ?>
  </div>
  <div  class="tab-pane fade in filterview <?php if($views=='manage-collab'):?>  active<?php endif;?> in" id="manage-collab">
    <?php $this->load->view('creator/manage_collab');?>
  </div>
  <div  class="tab-pane fade in filterview tabview<?php if($views=='my-proposal'):?>  active<?php endif;?>" id="my-proposal">
    <?php 

       if($views=='my-proposal'):
        $this->load->view('creator/ajax-collab');
        endif;
        ?>
  </div>
  <div class="clearfix"></div>
</div>
<div id="detail_popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
      <div class="row">
        <div class="col-sm-4 text-center pop_left">
          <figure><img id="productimg" src=""></figure>
          <h4 id="product_name"></h4>
          <a href="#" class="btn btn-warning editbutton hidden" data-action="<?php echo site_url('/'.MY_ACCOUNT.'getproductbyid')?>" id="editbuttoncollab" productid='' >Edit Collab</a> </div>
        <div class="col-sm-8">
          <div class="row text-center three_sec">
            <div class="col-xs-4">
              <h5>Followers Count</h5>
              <b>
              <p id="followers_count"></p>
              </b></div>
            <div class="col-xs-4 channel">
              <h5>CHANNELS</h5>
              <span id="facebookico" class="round_btn hidden facebook"><i class="fa fa-facebook-f"></i></span> <span id="youtuleeico" class="round_btn mediaicon hidden youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"></span> <span id="youtubeico" class="round_btn mediaicon hidden youtube"><i class="fa fa-youtube-play"></i></span> <span id="twitterico" class="round_btn mediaicon hidden twitter"><i class="fa fa-twitter"></i></span> <span id="tumblrico" class="round_btn mediaicon hidden tumblr"><i class="fa fa-tumblr"></i></span> <span id="instagramico" class="round_btn mediaicon hidden instagram"><i class="fa fa-instagram"></i></span> </div>
            <div class="col-xs-4">
              <h6>SUBMISSION DEADLINE</h6>
              <b id="submissiondeadline"></b></div>
          </div>
          <p id="description"> </p>
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
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="bidid" id="trackbidid" value="" >
            </div>
            <!--  <div class="form-group">
                          <textarea class="form-control" name="description" rows="5" id="draftdescription" placeholder="Draft Description"></textarea>
                      </div> -->
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
<script type="text/javascript">
    
    var action='<?php echo site_url('/'.CREATOR.'ajax_collab')?>';
    var getdraft='<?php echo site_url('/'.CREATOR.'get_draft')?>';
    var gettrackid='<?php echo site_url('/'.MY_ACCOUNT.'gettrackid')?>';
  </script>