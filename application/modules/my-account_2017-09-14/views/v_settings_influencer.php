<?php 
echo validation_errors();
$name=$userdetail->name;
$tempname=explode(' ',$name);
$first_name=$tempname['0'];
 $profileimage=$userdetail->cover_image;
$last_name=isset($tempname['1'])?$tempname['1']:'';
$bank_name=$userdetail->bank_name;
$account_no=$userdetail->account_no;
$balance=$userdetail->balance;
$age=$userdetail->age;
$gender=$userdetail->gender;
$professionid=$userdetail->professionid;
$about_user=$userdetail->about_user;
$brand_name=$userdetail->brand_name;
$brand_url=$userdetail->brand_url;
$phone=$userdetail->phone;
$email=$userdetail->email;  
$address=$userdetail->address;
$company_add1=$userdetail->company_address1;
$company_add2=$userdetail->company_address2;
$city=$userdetail->company_city;
$state=$userdetail->company_state;
$zip=$userdetail->company_zipcode;
$country=$userdetail->country;
$about_user=$userdetail->about_user;
$menu=$this->input->post('formtype');
$identification_no=$userdetail->identification_no; 
$categoryarr=array();
$profile=array();
if(is_array($category) && count($category)>0)
{
  foreach ($category as $key => $value) 
  {
    $categoryarr[]=$value->category_id;
  }
}
 $mediaassoc=array();
  if(count($mediadetail)>0){
    foreach($mediadetail as $allmedia)
    {
      $mediaassoc[]=$allmedia->media_type_id;

    }
  }
if(is_array($mediaprofile) && count($mediaprofile)>0){
 foreach($mediaprofile as $value)
  {
    $profile[$value->media_id][]=$value->url;
  }
}

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
          <i class="fa fa-exclamation-triangle hidden general text-danger"></i> </span> </a> </li>
        <!-- <li <?php if($view=='bankdetail'):?>class="active"<?php endif;?> data-view="bankdetail">
              <a href="#formbank" data-toggle="tab"><span>Bank Detail&nbsp;
             <?php if(validation_errors() && $menu=='bankdetail')
             { ?>
                   <i class="fa fa-exclamation-triangle text-danger"></i>
              <?php 
              } ?>
               <i class="fa fa-exclamation-triangle hidden bankdetail text-danger"></i></span></a>
        </li> --> 
        <!--  <li  <?php if($view=='address'):?>class="active"<?php endif;?> data-view="address">
            <a href="#form2" data-toggle="tab">
                   <span>Address &nbsp;
                    <?php if(validation_errors() && ($menu=='address')){ ?>
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    <?php } ?>
                    <i class="fa fa-exclamation-triangle hidden address text-danger"></i>
                    </span>
            </a>
       </li> --> 
        
        <!--   <li <?php if($view=='notification'):?>class="active"<?php endif;?> data-view="notification"><a href="#form3" data-toggle="tab"><span>Notification&nbsp; <?php if(validation_errors() && $menu=='notification'){ ?><i class="fa fa-exclamation-triangle text-danger"></i><?php } ?><i class="fa fa-exclamation-triangle hidden notification text-danger"></i></span></a></li> -->
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
        <!--     <li <?php if($view=='hire-history'):?>class="active"<?php endif;?> data-view="hire-history"><a href="#form6" data-toggle="tab"><span>Hire History&nbsp; <?php if(validation_errors() && $menu=='hirehistory'){ ?><i class="fa fa-exclamation-triangle text-danger"></i><?php } ?><i class="fa fa-exclamation-triangle hidden hirehistory text-danger"></i></span></a></li> -->
        <?php
            if($this->session->userdata(SESSION.'usertype')=='4')
            { ?>
        <!--  <li  <?php if($view=='edit_profile'):?>class="active"<?php endif;?> data-view="edit-profile"><a href="#form7" data-toggle="tab"><span>Edit Profile&nbsp; </span></a></li> -->
        <li  <?php if($view=='add_media'):?>class="active"<?php endif;?> data-view="add-media"><a href="#form8" data-toggle="tab"><span>Add Social Account&nbsp; </span></a></li>
        <?php 
            }
            ?>
        <div class="clearfix"></div>
      </ul>
      <?php 
        /*if($this->session->flashdata('success_message')){ ?>
      <div class="alert alert-success"><?php echo $this->session->flashdata('success_message'); ?></div>
            <?php }
            if($this->session->flashdata('error_message')){ ?> 
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error_message'); ?></div>
            <?php }*/
            ?>
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
                <div style="position:relative; text-align:center; margin:-30px auto 0; width:150px; overflow:hidden;"><span class="btn-sm fs-20"><i class="fa fa-camera"></i></span><a class="" href="javascript:;"> 
                  <!-- <input type="file" style="position:absolute;z-index:2;top:0;right:0;filter:alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent; width:100%; height:30px;" name="file_source" size="40" onchange="$(&quot;#upload-file-info&quot;).html($(this).val());"> --> 
                  </a>&nbsp; <span class="label label-default" id="upload-file-info"></span></div>
              </div>
              <div class="col-xs-6 col-sm-8">
                <div class="clearfix form-group" style="padding-top:60px;">
                  <div class="clearfix row form-group">
                    <div class="col-xs-6">
                      <label>First Name</label>
                      <input type="text" class="form-control no-radius" value="<?php echo $first_name;?> >" readonly>
                    </div>
                    <div class="col-xs-6">
                      <label>Last Name</label>
                      <input type="text" class="form-control no-radius" value="<?php echo $last_name;?>" readonly>
                    </div>
                  </div>
                  <div class="clearfix row">
                    <div class="col-xs-6">
                      <label>Age</label>
                      <input type="number" class="form-control no-radius" value="<?php echo $userdetail->age;?>" readonly>
                    </div>
                    <div class="col-xs-6">
                      <label>Gender</label>
                      <input type="text" class="form-control no-radius" value="<?php if($userdetail->gender=='m') echo 'Male'; elseif ($userdetail->gender=='f') echo 'Female';else echo 'Others';?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <?php if($userdetail->about_user!='')?>
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel">
                  <div role="tab" id="headingOne">
                    <h4> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i class="fa fa-gear"></i> General Information </a> </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      <div class="form-group col-xs-12">
                        <label>Bio</label>
                        <textarea class="form-control" rows="4" readonly><?php echo $userdetail->about_user?>.</textarea>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-3 col-xs-6" data-toggle="tooltip" data-placement="top" title="This detail will be confidential">
                          <label>Contact No</label>
                          <input type="text" class="form-control no-radius" placeholder="<?php echo $userdetail->phone?>" readonly>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <label>Address</label>
                          <input type="text" class="form-control no-radius" placeholder="<?php echo $userdetail->address?>" readonly>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <label>Profession</label>
                          <input type="text" class="form-control no-radius" value="<?php echo $userdetail->profession_name?>" readonly>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <label>Ceiling Likes</label>
                          <input type="text" class="form-control no-radius" readonly value="<?php echo $userdetail->ceiling_likes;  ?>">
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(count($profile)>0):?>
                <div class="panel">
                  <div  role="tab" id="headingTwo">
                    <h4> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> <i class="fa fa-link"></i> Social Media Links </a> </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <div class="col-xs-12">
                        <?php

                             foreach($mediaassoc as $eachmedia): 
                              if(defined('FACEBOOKMEDIAID') && $eachmedia==FACEBOOKMEDIAID && array_key_exists(FACEBOOKMEDIAID,$profile)):
                               ?>
                        <label> <span class="pull-right round_btn facebook"> <i class="fa fa-facebook-f"></i> </span> </label>
                        <?php
                              endif;
                               if(defined('INSTAGRAMMEDIAID') &&  $eachmedia==INSTAGRAMMEDIAID && array_key_exists(INSTAGRAMMEDIAID,$profile)):
                              ?>
                        <label> <span class="pull-right round_btn instagram"> <i class="fa fa-instagram"></i> </span> </label>
                        <?php
                              endif;
                               if(defined('TWITTERMEDIAID')  &&  $eachmedia==TWITTERMEDIAID && array_key_exists(TWITTERMEDIAID,$profile)):
                              ?>
                        <label> <span class="pull-right round_btn twitter"> <i class="fa fa-twitter-square"></i> </span> </label>
                        <?php
                              endif;
                               if(defined('YOUTUBEMEDIAID') &&  $eachmedia==YOUTUBEMEDIAID && array_key_exists(YOUTUBEMEDIAID,$profile)):
                              ?>
                        <label> <span class="pull-right round_btn youtube"> <i class="fa fa-youtube-play"></i> </span> </label>
                        <?php
                              endif;
                              if(array_key_exists($eachmedia,$profile)):
                                foreach($profile[$eachmedia] as $eachdata):
                              ?>
                        <p> <a href="<?php echo $eachdata?>" target="_blank"><?php echo $eachdata?></a> </p>
                        <?php
                               endforeach;
                            endif;
                            endforeach;?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif;?>
                <div class="panel">
                
                  <div role="tab" id="headingThree">
                    <h4> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <i class="fa fa-university"></i> Bank Detail </a> </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      <div class="row m-0" data-toggle="tooltip" data-placement="top" title="This detail will be confidential">
                        <div class="col-xs-3 form-group">
                          <label>Bank Name</label>
                          <input type="text" class="form-control" value="<?php echo $bank_name;?>" readonly >
                        </div>
                        <div class="col-xs-3 form-group">
                          <label>Account Number</label>
                          <input type="text" class="form-control" value="<?php echo $account_no;?>" readonly>
                        </div>
                        <div class="col-xs-3 form-group">
                          <label>Uptrendly Balance</label>
                          <input type="text" class="form-control" value="<?php echo $balance;?>" readonly>
                        </div>
                        <!--<div class="col-xs-12 form-group"><button class="btn btn-default btn-sm">This detail will be confidential </button></div>-->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel">
                  <div role="tab" id="headingThree">
                    <h4> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour"> <i class="fa fa-university"></i> Preffered Product </a> </h4>
                  </div>
                  <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="panel-body">
                      <div class="row m-0">
                        <ul style="list-style: none">
                          <?php $category=$this->general->get_category_tree();?>
                          <?php foreach($category as $eachcategory):
                                         if(in_array($eachcategory['id'],$categoryarr)) { ?>
                          <li><i  class="fa fa-hand-o-right"></i>&nbsp;<?php echo $eachcategory['name']; ?></li>
                          <?php  }?>
                          <?php endforeach;?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade in <?php if($view=='general'):?>active<?php endif;?>" id="form1">
            <form method="post" id="generalsettingform" class="advance_search col-xs-12">
              <div class="form">
                <input type="hidden" name="formtype" value="general">
                <div class="col-sm-7"> 
                  
                  <!--   <div class="form-group">
                  <label class="help-block">Company</label>
                  <input type="text" name="brand_name" placeholder="company name" i class="form-control" value="<?php echo  $brand_name; ?>">
                  <?php echo form_error('brand_name'); ?> 
                  </div> --> 
                  <!--  <div class="form-group">
                  <label class="help-block">Company Website</label>
                  <input type="text" name="brand_url" placeholder="Enter website" class="form-control" value="<?php echo $brand_url; ?>">
                  <?php echo form_error('brand_url'); ?> </div> -->
                  <div class="form-group">
                    <label class="help-block">First Name  <span class="red">*</span></label>
                    <input type="text" name="first_name" placeholder="Subject" class="form-control"  value="<?php echo $first_name ?>">
                    <?php echo form_error('first_name'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Last Name  <span class="red">*</span></label>
                    <input type="text" name="last_name" placeholder="Last Name" class="form-control"  value="<?php echo $last_name;?>">
                    <?php echo form_error('last_name'); ?> </div>
                    <div class="form-group">
                    <label class="help-block">Message to Brands <span class="red">*</span></label>
                    <textarea  name="about_user" placeholder="About user" class="form-control" rows="5" > <?php echo $about_user;?></textarea>
                    <?php echo form_error('email'); ?> </div>                  
                  	<div class="row">
                    <div class="form-group col-sm-6">
                    <label class="help-block">Gender  <span class="red">*</span></label>
                    <input type="radio" name="gender" <?php  if($gender=='m') echo 'checked';?> value="m">Male
                    <input type="radio" name="gender" <?php  if($gender=='f') echo 'checked';?> value="f">Female
                    <input type="radio" name="gender" <?php  if($gender=='o') echo 'checked';?> value="o">Others 
					<?php echo form_error('gender'); ?> </div>
                    <div class="form-group col-sm-6">
                    <label class="help-block">Age  <span class="red">*</span></label>
                    <input type="text" name="age" placeholder="Age" class="form-control"  value="<?php echo $age ?>">
                    <?php echo form_error('first_name'); ?> </div>
                    </div>
                    <div class="form-group">
                    <label class="help-block">Address  <span class="red">*</span></label>
                    <input type="text" name="address" placeholder="Address" class="form-control"  value="<?php echo $address ?>">
                    <?php echo form_error('first_name'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Profession  <span class="red">*</span></label>
                    <?php $profession=$this->general->get_profession();?>
                    <select name="profession" class="form-control">
                      <option value="">--Select--</option>
                      <?php foreach($profession as $eachproffession):?>
                      <option <?php if($eachproffession->id==$professionid)  echo 'selected ';?>value="<?php echo $eachproffession->id?>"><?php echo $eachproffession->profession;?></option>
                      <?php endforeach;?>
                    </select>
                    <?php echo form_error('profession'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Preferred Products for Promotion <span class="red">*</span></label>
                    <?php $category=$this->general->get_category_tree();?>
                    <?php foreach($category as $eachcategory):?>
                    <input type="checkbox" <?php if(in_array($eachcategory['id'],$categoryarr)) echo 'checked' ;?> name="usercategory[]" value="<?php echo $eachcategory['id']?>">
                    &nbsp;<?php echo $eachcategory['name'];?>&nbsp;&nbsp;
                    <?php endforeach;?>
                    <?php echo form_error('profession'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Phone  <span class="red">*</span></label>
                    <input type="text" name="phone" placeholder="phone" class="form-control"  value="<?php echo $phone;?>" data-toggle="tooltip" data-placement="top" title="Phone numbers are kept confidential">
                    <?php echo form_error('phone'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Bank Name  <span class="red">*</span></label>
                    <input type="text"  name="bank_name"  class="form-control" value="<?php echo $bank_name?>"  data-toggle="tooltip" data-placement="top" title="Bank details kept confidential; Only required to deposit the Sum in your account">
                    <?php echo form_error('bank_name'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Account Number  <span class="red">*</span></label>
                    <input type="text" id="account_no" name="account_no" class="form-control" value="<?php echo $account_no?>"  data-toggle="tooltip" data-placement="top" title="Bank details kept confidential; Only required to deposit the Sum in your account" >
                    <?php echo form_error('account_no'); ?> </div>
                  <div class="form-group">
                    <label class="help-block">Email  <span class="red">*</span></label>
                    <input type="text" name="email" placeholder="Email" class="form-control"  value="<?php echo $email;?>">
                    <?php echo form_error('email'); ?> </div>
                  <h5 style="margin:20px 0;">Note: Changing this email address will change your login email! </h5>
                  <!-- //Social media tabs -->
                  <div class="form-group social_decor_profile">
                    <?php
                $data['mediaassoc']=$mediaassoc;
                 $this->load->view("v_profile_settings",$data) ?>
                  </div>
                  <!-- //Social media end -->
                  
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
          <div class="tab-pane fade in  <?php if($view=='bankdetail'):?>active<?php endif;?>" id="formbank">
            <div class="panel-body">
              <div class="" id="bankdetailerror" style="display:none;color:red">
                <div class="alert alert-danger error-message"> </div>
              </div>
              <form method="post" action="#" id="bankdetailform"  class="advance_search col-xs-12">
                <input type="hidden" name="formtype" value="bankdetail">
                <div class="form-group">
                  <label class="help-block">Bank Name</label>
                  <input type="text"  name="bank_name"  class="form-control" value="<?php echo $bank_name?>">
                  <?php echo form_error('bank_name'); ?> </div>
                <div class="form-group">
                  <label class="help-block">Account Number</label>
                  <input type="text" id="account_no" name="account_no" class="form-control" value="<?php echo $account_no?>" >
                  <?php echo form_error('account_no'); ?> </div>
                <div class="form-group">
                  <label class="help-block">Uptrendly Balance</label>
                  <input type="text" readonly name="balance" class="form-control" value="<?php echo $balance?>">
                </div>
                <div class="form-group">
                  <button class="btn btn-info" type="submit" id="bankdetailbtn">
                  <div class="btn-img" style="float:left">
                    <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
                    <i class="fa fa-save createcheck"></i> </div>
                  Save </button>
                </div>
              </form>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane fade in  <?php if($view=='notification'):?>active<?php endif;?>" id="form3">
            <div class="panel-body">
              <form method="post" class="advance_search col-xs-12">
                <label>Delivery Frequency:</label>
                <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                      <strong>Never <br>
                      </strong> No notification alerts are sent out. Notifications remain visible on the platform. </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                      <strong>Never <br>
                      </strong> No notification alerts are sent out. Notifications remain visible on the platform. </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                      <strong>Never <br>
                      </strong> No notification alerts are sent out. Notifications remain visible on the platform. </label>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-info" type="reset"><i class="fa fa-save"></i> Save</button>
                  </div>
                </div>
              </form>
              <div class="clearfix"></div>
            </div>
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
        <div class="clearfix"></div>            
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