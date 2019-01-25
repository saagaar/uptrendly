<div class="mid-part margin_0">
<ul class="nav nav-tabs text-uppercase" role="tablist">
    <li role="presentation" class="active"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab">Discover</a></li>
  <li role="presentation"><a href="#hired" aria-controls="hired" role="tab" data-toggle="tab">Hired</a></li>
</ul>
<div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="discover">
            <div class="col-sm-3 pull-right filter_sec">
            <div class="form-group"><h5>Sort By</h5>
            <div class="radio">
            <label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Best Cost Per Follower</label>
            <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked> Best Cost Per Engagement</label>
            <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked>  Most Hired</label></div>
            </div>
            <div class="form-group"><h5>Creators</h5>
            <div class="radio">
            <label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>  All Creators</label>
            <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked>  Featured Creators</label></div>
            </div>
            
            <div class="row">
            <div class="col-xs-6"><div class="form-group"><h6>Gender</h6>
            <select class="form-control"><option>Any Gender</option><option>Male</option><option>Female</option></select>
            </div></div>
            <div class="col-xs-6"><div class="form-group"><h6>Age</h6>
            <select class="form-control"><option>Any Age</option><option>13-20</option><option>20-30</option><option>30-40</option>
            <option>40-50</option><option>50-60</option><option>60+</option></select>
            </div></div>
            </div>
            
            <div class="row">
            <div class="col-xs-6"><div class="form-group"><h6>Creator's Country</h6>
            <select class="form-control"><option>All Country</option><option>USA</option><option>UK</option><option>UAE</option>
            <option>Canada</option><option>Australia</option><option>Singapur</option></select>
            </div></div>
            <div class="col-xs-6"><div class="form-group"><h6>Audience Country</h6>
            <select class="form-control"><option>All Country</option><option>USA</option><option>UK</option><option>UAE</option>
            <option>Canada</option><option>Australia</option><option>Singapur</option></select>
            </div></div>
            </div>
            
            <div class="form-group"><h5>Channel Category</h5>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios1" value="option1">  Beauty &amp; Fashion</label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Health &amp; Fitness</label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Gaming &amp; Apps</label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Tech </label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Pets </label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2" checked>  Other</label></div>
            </div>
            </div>
            
            <div class="col-sm-9">
            <h4 class="text-center result_ttl">Here are some of our <b><?php echo count($creators);?> Creators</b>. <a href="#">Create a campaign</a> to start inviting!</h4>
              <ul class="list-unstyled product_listing">
                
                <?php 
                 foreach ($creators as $key => $percreator) {
                if($percreator['country']!='') $country=$percreator['country'];
                       else $country='Unknown';
                         if($percreator['audience_country']!='') $audience_country=$percreator['audience_country'];
                       else $audience_country='Unknown';

                  if($percreator['category_id']=='0') $category='Other';
                  else $category=$percreator['category_id'];
                   if($percreator['rating']=='0' || $percreator['rating']==null) $rating='Not Rated';
                  else $rating=$percreator['rating'];
                 ?>
                 <li>
                   <div class="row">
                      <div class="col-xs-5 col-sm-3">
                      <?php if($percreator['cover_image']!='' && $percreator['cover_image']!=null){?>
                      <a class="image" href="">
                        
                        <img id="profilecreator_<?php echo $percreator['user_id'];?>" src="<?php echo site_url('/'.USER_IMG_DIR.$percreator['cover_image'])?>" class="creatorprofile"></a>
                      <?php } ?>
                      </div>
                      <div class="col-xs-7 col-sm-9">
                        <h4><a href="#"><?php echo $percreator['member_name'];?></a>
                        <?php 
                          if($percreator['media'])
                        { 
                           $socialmedia=explode(',',$percreator['media']);
                          
                           foreach($socialmedia as $mediaitem)
                           { 
                                if($mediaitem=='facebook')
                                {
                                  ?>
                                <span class="pull-right round_btn facebook">
                                     <i class="fa fa-facebook-f"></i>
                                </span>
                              <?php
                                }
                                 if($mediaitem=='twitter')
                                {
                                  ?>
                                <span class="pull-right round_btn twitter">
                                     <i class="fa fa-twitter-square"></i>
                                </span>
                              <?php
                                }
                                  if($mediaitem=='instagram')
                                {
                                  ?>
                                <span class="pull-right round_btn instagram">
                                     <i class="fa fa-instagram"></i>
                                </span>
                              <?php
                                }
                                  if($mediaitem=='youtube')
                                {
                                  ?>
                                <span class="pull-right round_btn youtube">
                                     <i class="fa fa-youtube-play"></i>
                                </span>
                              <?php
                                }
                           }
                          ?>
                            
                        <?php 
                        }
                        ?>
                        </h4>
                        <div class="row">
                          <div class="col-xs-4"><h5>REACH <span><?php echo $percreator['total_reach']?></span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                          <div class="col-xs-4"><h5>COUNTRY <span><?php echo $country;?></span></h5><h5>AUDIENCE COUNTRY <span><?php echo $audience_country;?></span></h5></div>
                          <div class="col-xs-4"><h5>CATEGORY <span><?php echo $category;?></span></h5><h5>RATING <span><?php echo $rating;?></span></h5></div>
                        </div>
                        <div class="text-uppercase">
                        <a href="#" class="btn btn-sm btn-primary invitecreator" data-userid="<?php echo $percreator['user_id'];?>"><i class="fa fa-paper-plane "></i> Invite</a>
                        <a href="<?php echo site_url('/'.BRAND.'profile/'. $percreator['user_id'])?>" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                        </div>
                      </div>
                      <div> </div>
                    </div>
                  </li>
                 <?php
                 }
                ?>
               
              </ul>
             </div>            
            <div class="clearfix"></div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade in" id="hired">
            <div class="col-sm-3 pull-right filter_sec">
            <div class="form-group"><h5>Sort By</h5>
            <div class="radio">
            <label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Best Cost Per Follower</label>
            <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked> Best Cost Per Engagement</label>
            <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked>  Most Hired</label></div>
            </div>
            <div class="form-group"><h5>Creators</h5>
            <div class="radio">
            <label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>  All Creators</label>
            <label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked>  Featured Creators</label></div>
            </div>
            
            <div class="row">
            <div class="col-xs-6"><div class="form-group"><h6>Gender</h6>
            <select class="form-control"><option>Any Gender</option><option>Male</option><option>Female</option></select>
            </div></div>
            <div class="col-xs-6"><div class="form-group"><h6>Age</h6>
            <select class="form-control"><option>Any Age</option><option>13-20</option><option>20-30</option><option>30-40</option>
            <option>40-50</option><option>50-60</option><option>60+</option></select>
            </div></div>
            </div>
            
            <div class="row">
            <div class="col-xs-6"><div class="form-group"><h6>Creator's Country</h6>
            <select class="form-control"><option>All Country</option><option>USA</option><option>UK</option><option>UAE</option>
            <option>Canada</option><option>Australia</option><option>Singapur</option></select>
            </div></div>
            <div class="col-xs-6"><div class="form-group"><h6>Audience Country</h6>
            <select class="form-control"><option>All Country</option><option>USA</option><option>UK</option><option>UAE</option>
            <option>Canada</option><option>Australia</option><option>Singapur</option></select>
            </div></div>
            </div>
            
            <div class="form-group"><h5>Channel Category</h5>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios1" value="option1">  Beauty &amp; Fashion</label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Health &amp; Fitness</label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Gaming &amp; Apps</label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Tech </label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2">  Pets </label></div>
            <div class="checkbox"><label><input type="checkbox" name="" id="optionsRadios2" value="option2" checked>  Other</label></div>
            </div>
            </div>
            
            <div class="col-sm-9">
            <h5 class="text-center result_ttl"><b>No Creators Hired</b> <br>This list shows all the creators you've hired once they've completed some content for you.</h5>
              <ul class="list-unstyled product_listing">
                <li>
                  <div class="row">
                    <div class="col-xs-5 col-sm-3"><a class="image" href=""><img src="imgs/baby.jpg"></a></div>
                    <div class="col-xs-7 col-sm-9">
                      <h4><a href="#">Baby Fashion for Winter</a> <span class="pull-right round_btn youtube"><i class="fa fa-youtube-play"></i></span></h4>
                      <div class="row">
                        <div class="col-xs-4"><h5>REACH <span>1.25M</span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>COUNTRY <span>Nepal</span></h5><h5>AUDIENCE COUNTRY <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>CATEGORY <span>Other</span></h5><h5>RATING <span>Not Rated</span></h5></div>
                      </div>
                      <div class="text-uppercase">
                      <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Invite</a>
                      <a href="" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                      </div>
                    </div>
                    <div> </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-xs-5 col-sm-3"><a class="image" href=""><img src="imgs/bab.jpg"></a></div>
                    <div class="col-xs-7 col-sm-9">
                      <h4><a href="#">Baby Fashion for Winter</a> <span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span></h4>
                      <div class="row">
                        <div class="col-xs-4"><h5>REACH <span>1.25M</span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>COUNTRY <span>Nepal</span></h5><h5>AUDIENCE COUNTRY <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>CATEGORY <span>Other</span></h5><h5>RATING <span>Not Rated</span></h5></div>
                      </div>
                      <div class="text-uppercase">
                      <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Invite</a>
                      <a href="" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                      </div>
                    </div>
                    <div> </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-xs-5 col-sm-3"><a class="image" href=""><img src="imgs/ba.jpg"></a></div>
                    <div class="col-xs-7 col-sm-9">
                      <h4><a href="#">Baby Fashion for Winter</a> <span class="pull-right round_btn twitter"><i class="fa fa-twitter"></i></span></h4>
                      <div class="row">
                        <div class="col-xs-4"><h5>REACH <span>1.25M</span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>COUNTRY <span>Nepal</span></h5><h5>AUDIENCE COUNTRY <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>CATEGORY <span>Other</span></h5><h5>RATING <span>Not Rated</span></h5></div>
                      </div>
                      <div class="text-uppercase">
                      <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Invite</a>
                      <a href="" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                      </div>
                    </div>
                    <div> </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-xs-5 col-sm-3"><a class="image" href=""><img src="imgs/baby.jpg"></a></div>
                    <div class="col-xs-7 col-sm-9">
                      <h4><a href="#">Baby Fashion for Winter</a> <span class="pull-right round_btn instagram"><i class="fa fa-instagram"></i></span></h4>
                      <div class="row">
                        <div class="col-xs-4"><h5>REACH <span>1.25M</span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>COUNTRY <span>Nepal</span></h5><h5>AUDIENCE COUNTRY <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>CATEGORY <span>Other</span></h5><h5>RATING <span>Not Rated</span></h5></div>
                      </div>
                      <div class="text-uppercase">
                      <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Invite</a>
                      <a href="" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                      </div>
                    </div>
                    <div> </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-xs-5 col-sm-3"><a class="image" href=""><img src="imgs/ba.jpg"></a></div>
                    <div class="col-xs-7 col-sm-9">
                      <h4><a href="#">Baby Fashion for Winter</a> <span class="pull-right round_btn facebook"><i class="fa fa-facebook-f"></i></span></h4>
                      <div class="row">
                        <div class="col-xs-4"><h5>REACH <span>1.25M</span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>COUNTRY <span>Nepal</span></h5><h5>AUDIENCE COUNTRY <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>CATEGORY <span>Other</span></h5><h5>RATING <span>Not Rated</span></h5></div>
                      </div>
                      <div class="text-uppercase">
                      <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Invite</a>
                      <a href="" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                      </div>
                    </div>
                    <div> </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-xs-5 col-sm-3"><a class="image" href=""><img src="imgs/bab.jpg"></a></div>
                    <div class="col-xs-7 col-sm-9">
                      <h4><a href="#">Baby Fashion for Winter</a> <span class="pull-right round_btn vine"><i class="fa fa-vine"></i></span></h4>
                      <div class="row">
                        <div class="col-xs-4"><h5>REACH <span>1.25M</span></h5><h5>AUDIENCE <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>COUNTRY <span>Nepal</span></h5><h5>AUDIENCE COUNTRY <span>Unknown</span></h5></div>
                        <div class="col-xs-4"><h5>CATEGORY <span>Other</span></h5><h5>RATING <span>Not Rated</span></h5></div>
                      </div>
                      <div class="text-uppercase">
                      <a href="" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Invite</a>
                      <a href="" class="btn btn-sm btn-success"><i class="fa fa-camera"></i> Profile</a>
                      </div>
                    </div>
                    <div> </div>
                  </div>
                </li>
                
              </ul>
             </div>            
            <div class="clearfix"></div>
            </div>
            </div>
</div>

<!-- invitation to creators -->


<div id="invite_creators" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="sendprop_modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
                <div class="sendprop_modal_container">
                    <div class="modal_title">
                        <h2>Invite Creator</h2>
                        <p>You can invite creators to submit a proposal for a campaign below</p>
                        <div style="clear: both;"></div>
                    </div>
                    <form name="sendinvitation" id="sendinvitation" action="#" method="post">
                         <input type="hidden" name="userid" id="inviteuser" value="">
                    <div class="body">
                        <div class="col-sm-12 clearfix">
                        <div class="col-sm-12">
                            <div class="invite_img">
                               	<div class="img_box">
                                	<img src="" class="center" id="profilepicturecreator">
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-12 alert-pad-sides" id="invitesent" style="display:none;color:red">
                           <div class="alert alert-danger error-message">
                    
                           </div>
                         </div>
                             <div class="form-group">
                             <label>Select Campaign:</label>
                              <select class="form-control" name="product_id">
                               <?php 
                               foreach($campaigns as $value){
                                  ?>
                                       <option  value="<?php echo $value->id;?>"><?php echo $value->name?></option>
                                  <?php
                                  }
                                  ?>
                               
                              </select>                            
                            </div>
                                                  
                        </div>
                        <div class="col-sm-12 clearfix">
                            <textarea  rows="8" class="form-control" id="message" name="message" placeholder="Message(optional)"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                        <div class=" col-sm-12 bottom_content text-center">
                               
                                <button class="btn btn-success" id="sendinvitationbtn">
                                    <div class="btn-img" style="float:left">
                                          <div class="img-loader" style="z-index:1000;display: none;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-check createcheck"></i> 
                                    </div> Send Proposal
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
  var sendinvitation='<?php echo site_url('/'.BRAND.'inviteuser');?>'
</script>