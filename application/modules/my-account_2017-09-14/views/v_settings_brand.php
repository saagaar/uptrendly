<?php 
$name=$userdetail->name;
$tempname=explode(' ',$name);
$first_name=$tempname['0'];
 $profileimage=$userdetail->cover_image;
$last_name=isset($tempname['1'])?$tempname['1']:'';
$pan_no=$userdetail->pan_no;
$brand_name=$userdetail->brand_name;
$brand_url=$userdetail->brand_url;
if($userdetail->facebook_link=='' ) $facebook_link='N/A'; else $facebook_link=$userdetail->facebook_link;
$phone=$userdetail->phone;
$email=$userdetail->email;  
$address=$userdetail->address;
$designation=$userdetail->designation;
$mobile=$userdetail->mobile;
$menu=$this->input->post('formtype');



?>
<style>
#accordion h4 {
	border-bottom: 1px solid #DDD;
	margin: 0;
	padding: 15px 20px 10px;
	background: #f6f6f6;
}
#accordion h4 i {
	margin-right: 8px;
}
.panel-group {
	padding: 10px 10px 0;
}
.panel-body {
	padding: 20px 10px 10px;
}
#accordion h4 a.collapsed {
	color: #666;
}
#accordion h4 a {
	display: block;
}
#accordion h4 a, #accordion h4 a i {
	color: #62b6bf;
	text-decoration: none;
}
#accordion .panel {
	margin: 0;
}
</style>
<div class="mid-part" style="margin-top:15px;">
  <div class="col-xs-12">
    <div role="tabpanel" class="top-filter">
      <ul class="list-unstyled msz_menu">
        <li <?php if($view=='profile'):?>class="active"<?php endif;?> data-view="profile"> <a href="#form_profile" data-toggle="tab"> <span> My Profile </span> </a> </li>
        <li <?php if($view=='general'):?>class="active"<?php endif;?> data-view="general"> <a href="#form1" data-toggle="tab"> <span>Edit Profile
          <?php if(validation_errors() && ($menu=='general')){ ?>
          <i class="fa fa-exclamation-triangle text-danger"></i>
          <?php } ?>
          <i class="fa fa-exclamation-triangle hidden generalsettings text-danger"></i> </span> </a> </li>
        <li  <?php if($view=='change-password'):?>class="active"<?php endif;?> data-view="change-password"> <a href="#form4" data-toggle="tab"> <span>Change Password&nbsp;
          <?php if(validation_errors() && $menu=='changepassword'){ ?>
          <i class="fa fa-exclamation-triangle text-danger"></i>
          <?php } ?>
          <i class="fa fa-exclamation-triangle hidden changepassword text-danger"></i> </span> </a> </li>
        <!-- <li  <?php if($view=='referrals'):?>class="active"<?php endif;?> data-view="referrals"><a href="#form5" data-toggle="tab"><span>Points &amp; Referrals&nbsp;
          <?php if(validation_errors() && $menu=='referrals'){ ?>
          <i class="fa fa-exclamation-triangle text-danger"></i>
          <?php } ?>
          <i class="fa <!-- fa-exclamation-triangle hidden referrals text-danger"></i></span></a></li> -->
        
        <?php
            if($this->session->userdata(SESSION.'usertype')=='4')
            { ?>
        <li  <?php if($view=='edit_profile'):?>class="active"<?php endif;?> data-view="edit-profile"><a href="#form7" data-toggle="tab"><span>Edit Profile&nbsp; </span></a></li>
        <li  <?php if($view=='add_media'):?>class="active"<?php endif;?> data-view="add-media"><a href="#form8" data-toggle="tab"><span>Add Social Account&nbsp; </span></a></li>
        <?php 
            }
            ?>
        <div class="clearfix"></div>
      </ul>
      <div class="msz_sec">
        <div class="tab-content messages">
          <div class="tab-pane fade in <?php if($view=='profile'):?>active<?php endif;?>" id="form_profile">
            <div class="p-15 profile-tab">
              <div class="col-xs-6 col-sm-4">
                <figure class="profile-img">
                  <?php 
                    if($profileimage)
                      { ?>
                  <img src="<?php echo site_url(USER_IMAGE_PATH.'/'.$profileimage)?>">
                  <?php 
                      }
                      else {
                      ?>
                  <h1><i class="fa fa-user"></i></h1>
                  <?php 
                      }
                      ?>
                </figure>
                <div style="position:relative; text-align:center; margin:-30px auto 0; width:150px; overflow:hidden;"><span class="btn-sm fs-20"><i class="fa fa-camera"></i></span> 
                  <!--   <a class="" href="javascript:;">
                <input type="file" style="position:absolute;z-index:2;top:0;right:0;filter:alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent; width:100%; height:30px;" name="file_source" size="40" onchange="$(&quot;#upload-file-info&quot;).html($(this).val());">
                  </a>&nbsp; <span class="label label-default" id="upload-file-info"></span></div> --> 
                </div>
              </div>
              <div class="col-xs-6 col-sm-8">
                <div class="clearfix form-group" style="padding-top:60px;">
                  <div class="clearfix row form-group">
                    <div class="col-xs-6">
                      <label>Company Name </label>
                      <input type="text" class="form-control no-radius" value="<?php echo $brand_name;?> >" readonly>
                    </div>
                    <div class="col-xs-6">
                      <label>Pan No/Vat no </label>
                      <input type="text" class="form-control no-radius" value="<?php echo $pan_no;?>" readonly>
                    </div>
                  </div>
                  <div class="clearfix row">
                    <div class="col-xs-6">
                      <label>Website</label>
                      <input type="text" class="form-control no-radius" value="<?php echo $brand_url;?>" readonly>
                    </div>
                     <div class="col-xs-6">
                      <label>Facebook link</label>
                      <input type="text" class="form-control no-radius" value="<?php echo $facebook_link;?>" readonly>
                    </div>
                   
                  </div>
                   <div class="clearfix row">
                     <div class="col-xs-6">
                      <label>Address </label>
                      <input type="text" class="form-control no-radius" value="<?php echo $address?>" readonly>
                    </div>
                    <div class="col-xs-6">
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <?php //if($userdetail->about_user!='')?>
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel">
                  <div role="tab" id="headingOne">
                    <h4> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i class="fa fa-gear"></i> General Information </a> </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse active in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> 
                      <!--  <div class="form-group col-xs-12">
                <label>Bio</label>
                <textarea class="form-control" rows="4" readonly><?php echo $userdetail->about_user?>.</textarea>
              </div> -->
                      <div class="form-group">
                        <div class="col-sm-3 col-xs-6">
                          <label>Owner Name </label>
                          <input type="text" class="form-control no-radius" placeholder="<?php echo $first_name.' '.$last_name;?>" readonly>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <label>Designation </label>
                          <input type="text" class="form-control no-radius" placeholder="<?php echo $designation;?>" readonly>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <label>Mobile No. </label>
                          <input type="text" class="form-control no-radius" value="<?php echo $userdetail->mobile?>" readonly>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <label>Office No</label>
                          <input type="text" class="form-control no-radius" placeholder="2000" readonly value="<?php echo $phone?>">
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <label>Email</label>
                          <input type="text" class="form-control no-radius" placeholder="2000" readonly value="<?php echo $email?>">
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane fade in <?php if($view=='general'):?>active<?php endif;?>" id="form1">
            <form method="post" id="generalsettingform" class="advance_search col-xs-12">
              <div class="form">
                <input type="hidden" name="formtype" value="general">
                <div class="col-sm-7">
                  <div class="form-group">
                    <label class="help-block">Company <span class="red">*</span></label>
                    <input type="text" name="brand_name" placeholder="company name" i class="form-control" value="<?php echo  $brand_name; ?>">
                    <?php echo form_error('brand_name'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Company Website <span class="red">*</span></label>
                    <input type="text" name="brand_url" placeholder="Enter website" class="form-control" value="<?php echo $brand_url; ?>">
                    <?php echo form_error('brand_url'); ?> 
                  </div>
                  <div class="form-group">
                    <label class="help-block">Facebook Link </label>
                    <input type="text" name="facebook_link" placeholder="Enter Facebook Link" class="form-control" value="<?php echo $facebook_link; ?>">
                    <?php echo form_error('facebook_link'); ?> 
                  </div>
                  <div class="form-group">
                    <label class="help-block">Pan/Vat no <span class="red">*</span></label>
                    <input type="text" name="pan_no" placeholder="Enter Pan/VAT" class="form-control" value="<?php echo $pan_no; ?>">
                    <?php echo form_error('pan_no'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Location <span class="red">*</span></label>
                    <input type="text" name="address" placeholder="Add location" class="form-control"  value="<?php echo $address ?>">
                    <?php echo form_error('address'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">First Name <span class="red">*</span></label>
                    <input type="text" name="first_name" placeholder="Subject" class="form-control"  value="<?php echo $first_name ?>">
                    <?php echo form_error('first_name'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Last Name <span class="red">*</span></label>
                    <input type="text" name="last_name" placeholder="Last Name" class="form-control"  value="<?php echo $last_name;?>">
                    <?php echo form_error('last_name'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Designation <span class="red">*</span></label>
                    <input type="text" name="designation" placeholder="Designation" class="form-control"  value="<?php echo $designation;?>">
                    <?php echo form_error('designation'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Mobile No. <span class="red">*</span></label>
                    <input type="text" name="mobile" placeholder="Mobile" class="form-control"  value="<?php echo $mobile;?>">
                    <?php echo form_error('mobile'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Phone <span class="red">*</span></label>
                    <input type="text" name="phone" placeholder="phone" class="form-control"  value="<?php echo $phone;?>">
                    <?php echo form_error('phone'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Email <span class="red">*</span></label>
                    <input type="text" name="email" placeholder="Email" class="form-control"  value="<?php echo $email;?>">
                    <?php echo form_error('email'); ?> </div>
                  <h5 style="margin:20px 0;">Note: Changing this email address will change your login email! </h5>
                  <div class="form-group"> 
                    <!-- <div class="error-message" style="display:none;color:red"></div> -->
                    <button class="btn btn-info" type="submit" id="generalsettingbtn">
                    <div class="btn-img" style="float:left">
                      <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
                      <i class="fa fa-save createcheck"></i> </div>
                    Save </button>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="upload_product_image upload_profile_image text-center">
                    <div class="brwose-image">
                      <?php 

                      if($profileimage)
                      { ?>
                      <img src="<?php echo site_url(USER_IMAGE_PATH.'/'.$profileimage)?>">
                      <?php 
                      }
                      else {
                      ?>
                      <h1><i class="fa fa-user"></i></h1>
                      <?php 
                      }
                      ?>
                    </div>
                    <div class="fileUpload btn btn-lg btn-primary"> <span>Add Photo</span>
                      <input type="file" name="profile_picture"  class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade in  <?php if($view=='change-password'):?>active<?php endif;?>" id="form4">
            <div class="panel-body">
              <div class="" id="passwordchangeerror" style="display:none;color:red">
                <div class="alert alert-danger error-message"> </div>
              </div>
              <form method="post" action="#" id="changepasswordform"  class="advance_search col-xs-12">
                <h5 class="text-center" style="margin:20px 0;">Change your password by entering your old and new password below.</h5>
                <input type="hidden" name="formtype" value="changepassword">
                <div class="form-group">
                  <label class="help-block">Current Password</label>
                  <input type="password"  name="password"  class="form-control">
                  <?php echo form_error('password'); ?> </div>
                <div class="form-group">
                  <label class="help-block">New Password</label>
                  <input type="password" id="new_password" name="new_password" class="form-control">
                  <?php echo form_error('new_password'); ?> </div>
                <div class="form-group">
                  <label class="help-block">Confirm  Password</label>
                  <input type="password" name="re_new_password" class="form-control">
                  <?php echo form_error('re_new_password'); ?> </div>
                <div class="form-group">
                  <button class="btn btn-info" type="submit" id="changepasswordbtn">
                  <div class="btn-img" style="float:left">
                    <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
                    <i class="fa fa-save createcheck"></i> </div>
                  Save </button>
                </div>
              </form>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane fade in<?php if($view=='referrals'):?>active<?php endif;?>" id="form5">
            <div class="panel-body">
              <div class="btn-info btn-block text-center static_btn">
                <h3>Earn Up to <?php echo BRAND_REFER_POINT;?> <?php echo WEBSITE_NAME;?> Points For Every Brand Referral and <?php echo CREATOR_REFER_POINT;?><?php echo WEBSITE_NAME;?> Points For Every Creator Referral</h3>
                <p>Share your referral link with brands or creators to receive <?php echo WEBSITE_NAME;?> Points for your campaigns. Once a referred brand spends or a referred creator applies for sponsorship
                  you'll start earning your Points!</p>
                <h5 class="btn-success static_btn"><span>Your current Points: <?php echo $userdetail->referral_points?></span></h5>
              </div>
              <form method="post" class="advance_search col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                  <h5>&nbsp;</h5>
                  <div class="alert alert-info"> <span class="crtr_cpy">Share to login as Creator </span>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-8 col-sm-12">
                            <label class="help-block copyline" id="c"><?php echo site_url('/refer/c/'. $userdetail->username)?></label>
                          </div>
                          <div class="col-md-4 col-sm-12 text-right">
                            <button class="btn btn-info copytextbtn " data-type="c" type="reset" > <i class="fa fa-copy"></i> Copy Link </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="alert alert-info"> <span class="brnd_cpy">Share to login as Brand </span>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-8 col-sm-12">
                            <label class="help-block copyline" id="b"><?php echo site_url('/refer/b/'. $userdetail->username)?></label>
                          </div>
                          <div class="col-md-4 col-sm-12 text-right">
                            <button class="btn btn-info copytextbtn" data-type="b" type="reset"><i class="fa fa-copy"></i> Copy Link</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </form>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane fade in  <?php if($view=='hirehistory'):?>active<?php endif;?>" id="form6">
            <div class="content_sec inn_content"> 
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#youtube" aria-controls="home" role="tab" data-toggle="tab">Youtube <span class="round_btn youtube"><i class="fa fa-youtube-play"></i></span></a></li>
                <li role="presentation"><a href="#twitter" aria-controls="profile" role="tab" data-toggle="tab">Twitter <span class="round_btn twitter"><i class="fa fa-twitter"></i></span></a></li>
                <li role="presentation"><a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">Instagram <span class="round_btn instagram"><i class="fa fa-instagram"></i></span></a></li>
                <li role="presentation"><a href="#vine" aria-controls="settings" role="tab" data-toggle="tab">Vine <span class="round_btn vine"><i class="fa fa-vine"></i></span></a></li>
                <li role="presentation"><a href="#tumblr" aria-controls="messages" role="tab" data-toggle="tab">Tumblr <span class="round_btn tumblr"><i class="fa fa-tumblr"></i></span></a></li>
                <li role="presentation"><a href="#facebook" aria-controls="settings" role="tab" data-toggle="tab">Facebook <span class="round_btn facebook"><i class="fa fa-facebook-f"></i></span></a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="youtube">
                  <div class="col-xs-3">
                    <p>Videos</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Views</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPV</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPE</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="twitter">
                  <div class="col-xs-3">
                    <p>Videos</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Views</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPV</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPE</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="instagram">
                  <div class="col-xs-3">
                    <p>Videos</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Views</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPV</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPE</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="vine">
                  <div class="col-xs-3">
                    <p>Videos</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Views</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPV</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPE</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="tumblr">
                  <div class="col-xs-3">
                    <p>Videos</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Views</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPV</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPE</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="facebook">
                  <div class="col-xs-3">
                    <p>Videos</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Views</p>
                    <h3>0</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPV</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="col-xs-3">
                    <p>Avg. CPE</p>
                    <h3>$0.00</h3>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
          <?php  if($this->session->userdata(SESSION.'usertype')=='4') { ?>
          <div class="tab-pane fade in  <?php if($view=='edit-profile'):?>active<?php endif;?>" id="form7">
            <?php $this->load->view('v_profile_settings');?>
          </div>
          <div class="tab-pane fade in settings_s_media <?php if($view=='add-media'):?>active<?php endif;?>" id="form8">
            <div class="content_sec inn_content social_media_sec">
              <div class="text-center">
                <h3>You Are Currently connected to these Social Medias.</h3>
              </div>
              <div class="text-center">
                <?php 
             if(in_array('facebook',$userconnection['userconnected']))
             { ?>
                <a href="<?php echo $fb_url;?>"> <span class="social_icon facebook"> <i class="fa fa-facebook"></i> </span> </a>
                <?php 
              }
            if(in_array('youtube',$userconnection['userconnected']))
             { ?>
                <a href="<?php echo $yt_url;?>"> <span class="social_icon youtube"> <i class="fa fa-youtube"></i> </span> </a>
                <?php 
              }
              if(in_array('instagram',$userconnection['userconnected']))
             { ?>
                <a href="<?php echo $ins_url;?>"> <span class="social_icon btn-intg"> <i class="fa fa-instagram"></i> </span> </a>
                <?php 
              }
              if(in_array('twitter',$userconnection['userconnected']))
             { ?>
                <a href="<?php echo $tw_url;?>"> <span class="social_icon btn-info"> <i class="fa fa-twitter"></i> </span> </a>
                <?php 
              }
              if(in_array('youtulee',$userconnection['userconnected']))
             { ?>
                <span class="social_icon btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="60px"> </span>
                <?php 
              }
              if(in_array('tumblr',$userconnection['userconnected']))
             { ?>
                <a href="<?php echo $tm_url;?>"> <span class="social_icon btn-tumb"> <i class="fa fa-tumblr"></i> </span> </a>
                <?php 
              } ?>
              </div>
            </div>
            <div class="add_s_media">
              <div class="text-center">
                <h4> Choose another if You wish to add more Accounts.</h4>
              </div>
              <div class="text-center">
                <?php 
           $this->session->set_userdata('redirecturi', MY_ACCOUNT."settings/add-media");
             if(in_array('facebook',$userconnection['usernotconnected']))
             { ?>
                <a href="<?php echo $fb_url;?>"> <span class="social_icon facebook"> <i class="fa fa-facebook"></i> </span> </a>
                <?php 
              }
            if(in_array('youtube',$userconnection['usernotconnected']))
             { ?>
                <a href="<?php echo $yt_url;?>"> <span class="social_icon youtube"> <i class="fa fa-youtube"></i> </span> </a>
                <?php 
              }
              if(in_array('instagram',$userconnection['usernotconnected']))
             { ?>
                <a href="<?php echo $ins_url;?>"> <span class="social_icon btn-intg"> <i class="fa fa-instagram"></i> </span> </a>
                <?php 
              }
              if(in_array('twitter',$userconnection['usernotconnected']))
             { ?>
                <a href="<?php echo $tw_url;?>"> <span class="social_icon btn-info"> <i class="fa fa-twitter"></i> </span> </a>
                <?php 
              }
              if(in_array('youtulee',$userconnection['usernotconnected']))
             { ?>
                <span class="social_icon btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="60px"> </span>
                <?php 
              }
              if(in_array('tumblr',$userconnection['usernotconnected']))
             { ?>
                <a href="<?php echo $tm_url;?>"> <span class="social_icon btn-tumb"> <i class="fa fa-tumblr"></i> </span> </a>
                <?php 
              } ?>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<script>
 var basicdetailurl='<?php echo site_url('/'.MY_ACCOUNT.'settings/profile')?>';
 var loginpanelurl='<?php echo site_url('/user/login')?>';
</script> 