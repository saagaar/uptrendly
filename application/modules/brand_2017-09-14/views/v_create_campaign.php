<?php 
  
    $classa="disabled";
    $classb="active";
    $classc="disabled";
    $reason='';
    $reasonclass='hidden';
    // echo '<pre>';
    // print_r($product);
  $objarr=array();
  $pan_no=$userdetail->pan_no;
  $owner_name=$userdetail->name;
  $contact_no=$userdetail->phone;
  $product_url=$userdetail->company_website;
  $reasonid='';
 $reasonotherid=$this->general->get_obj_reason_other_id();
$btntype='add';
if($product_id)
{
 $btntype='edit';
 $objective=$product['objective'];
 $productimage=$product['image'];
 // $classreator=$product['creator'];
 $socialmedia=$product['socialmedia'];
 $title=$product['detail']->name;
 $description=$product['detail']->description;
 $product_url=$product['detail']->product_url;
 $product_name=$product['detail']->product_name;
 $cat_id=$product['detail']->cat_id;
 $pricerange=$product['detail']->price_range;
 $save_method=$product['detail']->save_method;
 $submission_deadline=$product['detail']->submission_deadline;
 $critical_deadline=$product['detail']->critical_deadline;
 $time_sensitive=$product['detail']->time_sensitive;
 $pan_no=$product['detail']->pan_no;
 $owner_name=$product['detail']->owner_name;
 $contact_no=$product['detail']->contact_no;
if(is_array($objective) && count($objective)>0)
{
    foreach($objective as $eachobj)
    {
       $objarr[]=$eachobj->objective_id;
       if($eachobj->objective_id==$reasonotherid)
       {
        $reason=$eachobj->reason;
        $reasonid=$eachobj->objective_id;
        $reasonclass="";
       }
    }
}
}
else
{

 if($this->input->post('objective',true)) $objarr= $this->input->post('objective',true); else $objarr= array();
 if($this->input->post('image',true)) $image= $this->input->post('image',true); else $image=array();
 if($this->input->post('creator',true)) $creator=$this->input->post('creator',true); else $creator=array();
 if($this->input->post('title',true)) $title=$this->input->post('title',true);else $title='';
 if($this->input->post('description',true)) $description=$this->input->post('description',true);else $description='';
 if($this->input->post('product_name',true)) $product_name=$this->input->post('product_name',true);else $product_name='';
 if($this->input->post('cat_id',true)) $cat_id=$this->input->post('cat_id',true);else $cat_id='';
 if($this->input->post('pricerange',true)) $pricerange=$this->input->post('pricerange',true);else $pricerange='';
 if($this->input->post('save_method',true)) $save_method=$this->input->post('save_method',true);else $save_method='';
 if($this->input->post('submission_deadline',true)) $submission_deadline=$this->input->post('submission_deadline',true);else $submission_deadline='';
 if($this->input->post('critical_deadline',true)) $critical_deadline=$this->input->post('critical_deadline',true);else $critical_deadline='';
 if($this->input->post('time_sensitive',true)) $time_sensitive=$this->input->post('time_sensitive',true);else $time_sensitive='';
 if($this->input->post('pan_no',true)) $pan_no=$this->input->post('pan_no',true);else $pan_no=$pan_no;
 if($this->input->post('owner_name',true)) $owner_name=$this->input->post('owner_name',true);else $owner_name=$owner_name;
 if($this->input->post('contact_no',true)) $contact_no=$this->input->post('contact_no',true);else $contact_no=$contact_no;
 if($this->input->post('product_url',true)) $product_url=$this->input->post('product_url',true);else $product_url=$product_url;
 $productimage=array();

}

?>

<form name="create_campaign_brand" id="addbrandcampaigns" action="#" method="post">
  <section class="container-fluid">
    <div class="wizard">
      <div class="wizard-inner" style="display:none;">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class=" <?php echo  $classa;?>"><a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1"> <span class="round-tab"><i class="fa fa-hand-pointer-o"></i></span></a></li>
          <li role="presentation" class=" <?php echo  $classb;?> step2"><a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2"> <span class="round-tab"><i class="fa fa-file-text-o"></i></span></a></li>
          <li role="presentation" class=" <?php echo  $classc;?>"><a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete"> <span class="round-tab"><i class="fa fa-search"></i></span></a></li>
        </ul>
      </div>
      <div class="tab-content" style="background:#FFF;">
        <?php 
      /*******************************Selection of social media in creating campaign**********************************************
      ?>
        <div class="tab-pane active" role="tabpanel" id="step1">
          <div class="text-center">
            <div class="modal-header">
              <h3 class="modal-title mt-0" id="myModalLabel">Where do you want to promote your brand?</h3>
            </div>
            <div class="modal-body">
              <div class="bg_fff">
                <div class="row form-group brandtype">
                  <?php if(defined('YOUTUBEMEDIAID')):?>
                  <div class="smedia"><a data-mediaid="<?php echo YOUTUBEMEDIAID?>" href="" class="btn btn-block btn-danger mediabrand"><i class="fa fa-youtube-play "></i></a></div>
                  <?php  endif; if(defined('TWITTERMEDIAID')): ?>
                  <div class="smedia"><a  data-mediaid="<?php echo TWITTERMEDIAID?>" href="" class="btn btn-block btn-info mediabrand"><i class="fa fa-twitter "></i></a></div>
                  <?php  endif; if(defined('INSTAGRAMMEDIAID')): ?>
                  <div class="smedia"><a data-mediaid="<?php echo INSTAGRAMMEDIAID?>" href="" class="btn btn-block btn-info mediabrand btn-intg"><i class="fa fa-instagram"></i></a></div>
                  <?php  endif; if(defined('YOUTULEEMEDIAID')): ?>
                  <div class="smedia"><a  data-mediaid="<?php echo YOUTULEEMEDIAID?>" href="" class="btn btn-block mediabrand btn-success btn-youtulee"><img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </a></div>
                  <?php  endif; if(defined('TUMBLRMEDIAID')): ?>
                  <div class="smedia"><a data-mediaid="<?php echo TUMBLRMEDIAID?>" href="" class=" mediabrand btn btn-block btn-info btn-tumb"><i class="fa fa-tumblr "></i></a></div>
                  <?php  endif; if(defined('FACEBOOKMEDIAID')): ?>
                  <div class="smedia"><a data-mediaid="<?php echo FACEBOOKMEDIAID?>" href="" class="mediabrand btn btn-block btn-primary"><i class="fa fa-facebook-f "></i></a></div>
                  <?php   endif; ?>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="text-align:center;"> 
              <!--   <button type="button" class="btn btn-warning selectbrand" id="brandselectbtn" data-productid="" disabled="disabled" data-toggle="modal" data-target=".bs-example-modal-lg">Go Next <i class="fa fa-arrow-right"></i></button> -->
              <div >
                <button type="button" class="btn btn-info next-step selectbrand"  id="brandselectbtn" data-productid="" disabled="disabled">Continue</button>
              </div>
            </div>
          </div>
        </div>

     <?php    /******************************End of selecting social media******************************************************/ ?>
        <div class="tab-pane active" role="tabpanel" id="step2">
        	<div class="p-20">
        <h3 class="m-0"><b>New Campaign</b></h3><hr class="mt-10">
              <div class="form-group">
                <input type="hidden" id="brandsocialmedia" name="brandmediaid" class="form-control" placeholder="Campaign Title" value="">
                <input type="hidden" id="create_type" name="create_type" class="form-control"  value="campaign">
                <input type="hidden" id="productid" name="productid" class="form-control"  value="<?php echo $product_id;?>">
                
                <label>Campaign Title <span class="asterick">*</span></label>
                <input type="text" id="c_campaign_name" name="campaign_name" class="form-control" placeholder="Campaign Title" value="<?php echo $title;?>">
                <?php echo form_error('campaign_name');?>
                </div>
              <div class="row">
              <div class="form-group col-sm-8">
              <label>Campaign Details <span class="asterick">*</span></label>
                <textarea class="form-control" id="c_description" name="description" rows="4" placeholder="Campaign Details" ><?php echo $description;?></textarea>
                 <?php echo form_error('description');?>
              </div>
              <div class="form-group  col-sm-4">
              <?php $objective=$this->general->get_objectives();

              ?>
              <label>Campaign Purpose <span class="asterick">*</span></label>
              <div class="obj col-xs-12 campaign_purpose">
                <?php 
                          if( is_array($objective) && count($objective)>0)
                            {
                               foreach ($objective as $obj) 
                               {
                              ?>
		                      		<div class="checkbox">
                                <label>
                                  <input type="checkbox" class="c_objective" data-name="<?php echo $obj->name;?>" name="objective[]" <?php if(in_array($obj->id,$objarr)) echo 'checked';?> value="<?php echo $obj->id?>"><?php echo $obj->name;
                                 
                                  ?> 
                                </label>
                              </div>
                        <?php
                                }
                            }
                        ?>
                 <?php echo form_error('objective');
               
              
                 ?>
                 <textarea name="reason<?php echo $reasonotherid;?>" class="form-control <?php echo $reasonclass?>" id="objreason"><?php echo $reason;?></textarea>
				      </div>
                <div class="clearfix"></div>
              </div>
              </div>
              
              <div class="row">
              <div class="form-group col-xs-6">
              <label>Product Name <span class="asterick">*</span></label>
                <input type="text"  id="c_product_name" name="product_name" placeholder="Product Name" class="form-control" value="<?php echo $product_name;?>">
                 <?php echo form_error('product_name');?>
              </div>              
              <div class="form-group col-xs-6">
              <label>Vat/Pan Number <span class="asterick">*</span></label>
                <input type="text"  id="c_vatno" name="vatno" placeholder="Vat/Pan no"  class="form-control" value="<?php echo $pan_no;?>">
                 <?php echo form_error('vatno');?>
              </div>
              </div>
              <div class="row">
              <div class="form-group col-xs-6">
              <label>Full Name <span class="asterick">*</span></label>
                <input type="text"  id="c_owner_name" name="owner_name" placeholder="Full Name"  class="form-control" value="<?php echo  $owner_name;?>">
                 <?php echo form_error('owner_name');?>
              </div>
              <div class="form-group col-xs-6">
              <label>Contact number <span class="asterick">*</span></label>
                <input type="text"  id="c_contact_no" name="contact_no" placeholder="Contact no."  class="form-control" value="<?php echo $contact_no;?>">
                 <?php echo form_error('contact_no');?>
              </div>
              </div>
             
              <div class="row">
              <div class="form-group col-xs-6">
              <label>Product URL <span class="asterick">*</span></label>
                <input type="text" class="form-control"  id="c_product_url" name="product_url" placeholder="(e.g. https://yourproduct.com)" value="<?php echo $product_url;?>">
                    <?php echo form_error('product_url');?>
              </div>
            <div class="form-group col-xs-6">

              <label>Campaign Category <span class="asterick">*</span></label>
                <select class="form-control" id="c_category" name="category">
                  <option value="" selected="selected">Category</option>
                  <?php 
                         $category=$this->general->get_category_tree();
                           
                        if(count($category)>0)
                        {
                            
                            foreach ($category as $key => $value) {

                            ?>
                           <option <?php if($value['id']==$cat_id) echo 'selected';?> label="<?php echo $value['name'];?>" value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                    <?php 
                            }
                        }
                        ?>
                </select>
                 <?php echo form_error('category');?>
           <!--     <label>Campaign Price Range <span class="asterick">*</span></label>
               <select class="form-control" id="c_price_range" name="price_range" >
                 <option value=""  name="price_range" selected="selected">Select Price</option>
                 <?php 
                           $price_range=$this->general->get_price_range();
                           if(count($price_range)>0)
                           {
                              foreach ($price_range as $key => $data) {
                             ?>
                             <option <?php if($data->id==$pricerange) echo 'selected';?> label="<?php echo DEFAULT_CURRENCY_SIGN.' '.$data->price_range?>" value="<?php echo $data->id?>"><?php echo DEFAULT_CURRENCY_SIGN?><?php echo $data->price_range ?></option>
                 <?php
                           }
                           }
                          
                       ?>
               </select>
                <?php echo form_error('price_range');?> -->
             </div>
              </div>
              <div class="row">
              <div class="form-group col-xs-6">
              <label>Tentative Start Date <span class="asterick">*</span></label>
                <div class="input-group date">
                  <input type="text"  id="c_submission_deadline" name="submission_deadline" placeholder="Start Date"  class="form-control" value="<?php echo $submission_deadline;?>">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <?php echo form_error('submission_deadline'); ?>
              </div>
              
              <div class="form-group col-xs-6">
              <label>Tentative End Date (*) <span class="asterick">*</span></label>
                <div class="input-group date">
                  <input type="text"  id="c_critical_deadline" name="critical_deadline" placeholder="End Date"  class="form-control" value="<?php echo $critical_deadline;?>">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
                <?php echo form_error('critical_deadline'); ?> 
              </div>
              </div>
              <div class="row">
              <div class="form-group col-xs-6">
               <label>Time sensitive <span class="asterick">*</span></label>
              <div class="row m-0">
              <div class="col-xs-3"><div  class="radio"><label><input type="radio" class="time_sensitive" name="time_sensitive"  <?php if($time_sensitive=='1') echo 'checked'?> value="1"> Yes</label></div></div>
              <div class="col-xs-3"><div class="radio"><label><input type="radio" class="time_sensitive" name="time_sensitive" <?php if($time_sensitive=='0') echo 'checked'?>  value="0"> No</label></div></div>
               <?php echo form_error('time_sensitive');?>
               </div>
               </div>
              <div class="form-group col-xs-6">
              
              </div>
                
            <!--   <div class="form-group col-xs-6">
              <label>Time sensitive</label>
              <div class="row m-0">
              <div class="col-xs-3"><div  class="radio"><label><input type="radio" class="time_sensitive" name="time_sensitive"  <?php if($time_sensitive=='1') echo 'checked'?> value="1"> Yes</label></div></div>
              <div class="col-xs-3"><div class="radio"><label><input type="radio" class="time_sensitive" name="time_sensitive" <?php if($time_sensitive=='0') echo 'checked'?>  value="0"> No</label></div></div>
               <?php echo form_error('time_sensitive');?>
              </div>
              </div> -->
              </div>
              <div class="row form-group">
              <div class="col-xs-12"> <h4><b>Campaign Images</b> <span class="asterick">*</span></h4></div>
                <div class="col-xs-3">
              	<div class="upload_product_image text-center">
                  <div class="brwose-image">
                  <?php 

                  if((count($productimage)>=1) && $productimage['0'])
                  { ?>
                      <img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'/'.$productimage['0']->image)?>">
                  <?php 
                  }
                  else {
                  ?>
                  <h1><i class="fa fa-user"></i></h1>
                  <?php 
                   }
                  ?>
                        
                  </div>
                  <div class="fileUpload btn btn-lg btn-primary"><span>Add Photo</span>
                    <input type="file" name="uploadimage[]" id="fileUpload0" class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
                  </div>
                </div>
                </div>
                
                <div class="col-xs-3">
              	<div class="upload_product_image text-center">

                   <div class="brwose-image">
                      <?php if((count($productimage)>=2) && isset($productimage['1']))
                      { ?>
                          <img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'/'.$productimage['0']->image)?>">
                      <?php 
                      }
                      else 
                      {
                      ?>
                      <h1><i class="fa fa-user"></i></h1>
                      <?php 
                       }
                      ?>
                        
                  </div>
                  <div class="fileUpload btn btn-lg btn-primary"><span>Add Photo</span>
                    <input type="file" name="uploadimage[]"   class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
                  </div>
                </div>
                </div>
                
                <div class="col-xs-3">
              	<div class="upload_product_image text-center">

                 <div class="brwose-image">
                  <?php if((count($productimage)>=3) && isset($productimage['2']))
                  { ?>
                      <img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'/'.$productimage['0']->image)?>">
                  <?php 
                  }
                  else {
                  ?>
                  <h1><i class="fa fa-user"></i></h1>
                  <?php 
                   }
                  ?>
                        
                  </div>
                  <div class="fileUpload btn btn-lg btn-primary"><span>Add Photo</span>
                    <input type="file" name="uploadimage[]"  class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
                  </div>
                </div>
                </div>
                
                <div class="col-xs-3">
              	<div class="upload_product_image text-center">
                 <div class="brwose-image">
                  <?php if((count($productimage)>=4) && isset($productimage['3']))
                  { ?>
                      <img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'/'.$productimage['0']->image)?>">
                  <?php 
                  }
                  else {
                  ?>
                  <h1><i class="fa fa-user"></i></h1>
                  <?php 
                   }
                  ?>
                        
                  </div>
                  <div class="fileUpload btn btn-lg btn-primary"><span>Add Photo</span>
                    <input type="file" name="uploadimage[]"   class="previewuploadimage upload" accept="image/gif, image/jpeg, image/png" />
                  </div>
                </div>
                </div>
                </div>
                
                 <?php echo form_error('uploadimage'); ?>
                 
                   <p>Upload the kind of picture you want the influencer to post on their social media.</p>
			</div>
          <div class="modal-footer">           
            <div class="pull-right">
              <button type="button" class="btn btn-default prev-step">Previous</button>
              <button type="submit" class="btn btn-primary  create_campaign" id="addcampaignmedia" data-type="<?php echo $btntype?>"  data-step="main-form">continue</button>
            </div>
          </div>
        </div>
        <div class="tab-pane " role="tabpanel" id="complete">
          <?php $this->load->view('ajax_creators');?>
          <div class="cleafix">
            <button type="submit" name="save_method" class="btn btn-info create_campaign fix-btn" style="right:205px;" id="" data-type="<?php echo $btntype?>"  data-step="secondary-form" value="2">Save as Draft</button>
            <button type="submit" name="save_method" class="btn btn-primary create_campaign fix-btn"  id="submitcreatecampaign" data-type="<?php echo $btntype?>" data-step="secondary-form" value="1" >Submit campaign</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</form>
<script>
    $('.input-group.date').datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
         startDate:new Date(),
        autoclose: true,
        todayHighlight: true
    });
    var getmediaproduct="<?php echo site_url('/'.MY_ACCOUNT.'getmediabyproduct');?>"
    var editaction="<?php echo site_url('/'.MY_ACCOUNT.'getproductbyid')?>";

$(document).ready(function () {

  $('.c_objective').click(function(){
    var name= $(this).data('name');
   if(name.toLowerCase()=='others' || name.toLowerCase()=='other')
   {
     
      $('#objreason').toggleClass('hidden');
       if(!($('#objreason').is(':visible')))
       {

         $('#objreason').html('');
         $('#objreason').val('');
         $('#objreason').attr('name','reason');
       }
   }
  })
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var $target = $(e.target);    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });
    $(".next-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
    });
    $(".prev-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);
    });
});
function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
var createcampaign='<?php echo site_url('/'.BRAND.'create_campaign')?>';
var listcampaign='<?php echo site_url('/'.BRAND.'campaigns')?>';
</script>