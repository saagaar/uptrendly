<form method="post" id="addbrandcampaign" action="<?php echo site_url('/'.BRAND.'create_campaign')?>">
<div class="text-center capm_type">
<label class="radio"><input type="radio" name="sex" value="male"><span>Normal/Standard Campaign</span></label>
<label class="radio"><input type="radio" name="sex" value="female"><span>Budget Campaign</span></label>
<label class="radio"><input type="radio" name="sex" value="other"><span>Smart Campaign</span></label>
<div class="clearfix"></div>
</div>

  <div class="row" style="margin:0;">
    <div class="col-sm-7">
      <div class="form-group">
        <input type="hidden" id="brandsocialmedia" name="brandmediaid" class="form-control" placeholder="Campaign Title" value="">
        <input type="hidden" id="create_type" name="create_type" class="form-control"  value="campaign">
        <input type="hidden" id="productid" name="productid" class="form-control"  value="">
        <input type="text" id="c_productname" name="name" class="form-control" placeholder="Campaign Title">
        <?php echo form_error('title');?> </div>
      <div class="form-group">
        <textarea class="form-control" id="c_description" name="description" rows="5" placeholder="Campaign Details"></textarea>
      </div>
      <div class="form-group">
        <input type="text" class="form-control"  id="c_product_url" name="product_url" placeholder="Product URL (e.g. https://yourproduct.com)">
      </div>
      <div class="form-group">
        <input type="text" class="form-control"  id="c_least_fan_count" name="least_fan_count" placeholder="Minimum Fan count">
      </div>
      <div class="form-group">
        <select class="form-control" id="c_price_range" name="price_range" >
          <option value=""  name="price_range" selected="selected">Price Range</option>
          <?php 
                            $price_range=$this->general->get_price_range();
                            if(count($price_range)>0)
                            {
                               foreach ($price_range as $key => $data) {
                              ?>
          <option label="<?php echo DEFAULT_CURRENCY_SIGN.' '.$data->price_range?>" value="<?php echo $data->id?>"><?php echo DEFAULT_CURRENCY_SIGN?><?php echo $data->price_range ?></option>
          <?php
                            }
                            }
                           
                        ?>
        </select>
      </div>
      <div class="form-group">
        <select class="form-control" id="c_category" name="category">
          <option value="" selected="selected">Category</option>
          <?php 
                         $category=$this->general->get_category_tree();
                           
                        if(count($category)>0)
                        {
                            
                            foreach ($category as $key => $value) {
                            ?>
          <option label="<?php echo $value['name'];?>" value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
          <?php 
                            }
                        }
                        ?>
        </select>
      </div>
      <div class="form-group" >
        <div class="input-group date">
          <input type="text" required id="c_submission_deadline" name="submission_deadline" placeholder="Submission Deadline" readonly class="form-control">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
        <?php echo form_error('submission_deadline'); ?> </div>
      <div class="form-group" >
        <select class="form-control" id="c_save_method" name="save_method">
          <option value="1">Open for Bidding</option>
          <option value="2">Saved to Draft</option>
        </select>
      </div>
    </div>
    <div class="col-sm-5">
      <div class="upload_product_image text-center">
        <div id="brwose-image">
          <h1><i class="fa fa-user"></i></h1>
        </div>
        <div class="fileUpload btn btn-lg btn-primary"><span>Upload photos</span>
          <input type="file" name="uploadimage" id="fileUpload" class="upload" accept="image/gif, image/jpeg, image/png" />
        </div>
        <p>You will not receive any new proposals from creators after the Submission Deadline.</p>
      </div>
    </div>
    <?php echo form_error('uploadimage'); ?> </div>
</form>
<script>
    // $('.input-group.date').datepicker({
    //     format: "yyyy/mm/dd",
    //     todayBtn: "linked",
    //      startDate:new Date(),
    //     autoclose: true,
    //     todayHighlight: true
    // });
    var getmediaproduct="<?php echo site_url('/'.MY_ACCOUNT.'getmediabyproduct');?>"
    var editaction="<?php echo site_url('/'.MY_ACCOUNT.'getproductbyid')?>";
</script>