<link href="<?php echo base_url(DROPZONE_PATH.'dropzone.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url(DROPZONE_PATH.'dropzone.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
	var UrlFetchCustomFields = "<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/ajax_process_custom_fields'); ?>";
	
	var UrlDeleteImage = "<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/ajax_delete_product_image');?>";
	
	var UrlRemoveDropzoneTempImage = "<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/ajax_delete_product_temp_images'); ?>";
</script>
<script type="text/javascript">
$(document).ready(function() {
	Dropzone.options.myAwesomeDropzone = {
    //maxFiles: '<?php //echo $images_quota; ?>',
		// maxFiles: 2,
		acceptedFiles: ".jpeg,.jpg,.png,.gif,.bmp",
		addRemoveLinks: true,
		dictRemoveFile: "Remove Image",
		dictDefaultMessage : "Drop files here to upload", 			
		//default message displayed before any files are dropped
		
		init: function() {
			myDropzone = this;
			
			myDropzone.on("maxfilesexceeded", function(file) {
				this.removeFile(file);
				console.log('exceeded');
				$('.dropzoneResponse').show();
				// $('.dropzoneResponse').html('You can upload only <?php //echo MAXIMUM_NUMBERS_OF_PRODUCT_IMAGES; ?> images.');
			});
			
			myDropzone.on("sending", function(file, xhr, formData){
				formData.append('pcodeimg', '<?php echo $product_code; ?>');
				formData.append('Developer', 'openpradip@yahoo.com'); //testing append function
			});
		
			myDropzone.on("success", function(file, response){
				response =  jQuery.parseJSON(response);
				if(response.status=='success'){
					//add attribute name to the remove image element
					$(file.previewTemplate).find('.dz-remove').attr('data-name', response.name);
				}
			});
		
			myDropzone.on("removedfile",function(file) {
				var name = $(file.previewTemplate).find('.dz-remove').attr('data-name');
				//console.log("name : " + name);
				if(name != '' && name != undefined) { 
				   $.ajax({
						type: 'POST',
						url: UrlRemoveDropzoneTempImage,
						data: {name:name},
						dataType: 'json',
						success: function(response) {
							//response =  jQuery.parseJSON(response);
							//peform tasks here if we needto perform any task after success
						}
					});	
				}
			});
		},
	};
});
</script>
<section class="title">

<div class="wrap">
  <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Post Management</h2>
</div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    <section class="smfull">
      <div class="confrmmsg">
        <?php				
			if($this->session->flashdata('message') != ''){
				echo '<p>'.$this->session->flashdata('message').'</p>';
			} 
		?>
      </div>
      <div class="box_block">
        <form name="edit-product-form" id="editProductForm" method="post" action="" accept-charset="utf-8" enctype="multipart/form-data">
        <input type="hidden" name="create_type" value="<?php echo $product->create_type;?>">
         <?php if($product->create_type=='campaign'){
          $posttype="Campaign";
         } 
         else{
          $posttype="Collab";
         }
         ?>
          <div class="title_h3">Edit <?php echo $posttype;?></div>
    <?php 
  
          if($product->create_type=='campaign'){

      ?>
          <fieldset>
            <?php //if(PRODUCT_CATEGORY_STATUS=='enabled'){ ?>
            <h4>Choose Category</h4>
            <div class="ddmenu"> <a id="chooseCategory" href="javascript:void(0)" class="main_btn">
              <?php if($this->input->post('categoryName',TRUE)){echo $this->input->post('categoryName',TRUE);}else{ echo $categoryName;};?>
              </a>
              <ul>
                <?php
                    if($category_tree){
                        foreach($category_tree as $category)
                        {
                            ?>
                <li <?php if($category['subcat']==''){ ?> onclick="addThis('<?php echo $category['name']; ?>','<?php echo $category['id']; ?>','0')" <?php } else { ?>class="dropdown-submenu"<?php }?>> <a href="javascript:void(0)" tabindex="-1"><?php echo $category['name']; ?></a>
                  <?php if($category['subcat']!=''){ ?>
                  <ul class="dropdown-menu" >
                    <?php foreach($category['subcat'] as $subcat){?>
                    <li onclick="addThis('<?php echo $subcat['name']; ?>','<?php echo $category['id']; ?>','<?php echo $subcat['id']; ?>')"> <a href="javascript:void(0)" data-clickable="data-clickable" tabindex="-1"> <?php echo $subcat['name']; ?> </a> </li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </li>
                <?php
					}
				}
				?>
              </ul>
            </div>
            <input type="hidden" name="category" id="hiddenCatField" value="<?php if(isset($_POST['category']) && $_POST['category']!=''){echo $_POST['category'];} else {echo $cat_id;} ?>" />
            <?=form_error('category')?>
            <input type="hidden" name="categoryName" id="hiddenCatName" value="<?php echo set_value('categoryName',$categoryName); ?>" />
            <?php //} ?>
          </fieldset>
          <?php 
        }
          ?>
          
          <fieldset>
            <div class="title_h3">Item Description
            <?php
 if(count($socialmedia)>0){
                 
                  // $mediaarray=array('1','2','3','4');
                  // print_r($mediaarray);

                               if(in_array('facebook',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn facebook ">
                                     <i class="fa fa-facebook-f"></i>
                                </span>
                              <?php
                                }
                               if(in_array('twitter',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn twitter">
                                     <i class="fa fa-twitter-square"></i>
                                </span>
                              <?php
                                }
                                if(in_array('instagram',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn instagram">
                                     <i class="fa fa-instagram"></i>
                                </span>
                              <?php
                                }
                               if(in_array('youtube',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn youtube">
                                     <i class="fa fa-youtube"></i>
                                </span>
                              <?php
                                }
                                if(in_array('youtulee',$socialmedia))
                                { ?>
                                  <span class="admin_pos_fix round_btn btn-youtulee">
                                   <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="25px"> 
                                </span>
                             <?php
                                }
                                 if(in_array('tumblr',$socialmedia))
                                { ?>
                                   <span  class="round_btn tumblr"><i class="fa fa-tumblr"></i></span>
                          <?php }
              
              }
              ?>
            </div>
            <ul class="frm">
            <li>
              <div>
                <label> <?php echo $posttype;?> Name<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="name" name="name" value="<?php echo set_value('name',$product->name); ?>">
                <?=form_error('name')?>
              </div>
            </li>
           
            <li class="txthalf">
              <label><?php echo $posttype;?> Description:</label>
              <textarea rows="7" name="description" class="form-control"><?php echo set_value('description',$product->description); ?></textarea>
              <?=form_error('description')?>
            </li>
            <?php   if($product->create_type=='campaign'):?>
            <li>
              <div>
                <label> <?php echo $posttype;?> Url<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="product_url" name="product_url" value="<?php echo set_value('name',$product->product_url); ?>">
                <?=form_error('product_url')?>
              </div>
            </li>
          <?php endif ;?>
          
              <li>
              <div>
                <label> Least Fan Count<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="least_fan_count" name="least_fan_count" value="<?php echo set_value('least_fan_count',$product->least_fan_count); ?>">
                <?=form_error('least_fan_count')?>
              </div>
            </li>
            <li>

              <div>
                <label><?php echo $posttype;?> Type<span>*</span> :</label>
                <?php $auction_type = ($this->input->post('auction_type',TRUE)?$this->input->post('auction_type',TRUE):$product->auction_type); ?>
                <span class="radio-inline"><input type="radio" name="auction_type" value="1" <?php if($auction_type=='1'){echo 'checked="checked"';} ?>> Public </span> 
                <span class="radio-inline"><input type="radio" name="auction_type" value="2" <?php if($auction_type=='2'){echo 'checked="checked"';} ?>> Private </span>
                <?=form_error('auction_type')?>
              </div>
            </li>
            <?php   if($product->create_type=='campaign'):?>
            <li>
                <div>
                  <label>Price Range <span>*</span> :</label>
                 <select name="price_range">
                 <option value="">--select--</option>
                 <?php foreach($price_range as $range){
                  ?>
                  <option value="<?php echo $range->id;?>" <?php if($product->price_range==$range->id) echo "selected='selected'"?>>                  <?php echo DEFAULT_CURRENCY_SIGN .' '.$range->price_range;?> </option>
                  <?php
                  } ?>
                  </select>
                    <?=form_error('price_range')?>
                </div>
              </li>
              <?php endif ;?>
             <li>
                <div>
                  <label>Submission Deadline<span>*</span> :</label>
                  <input size="50" class="inputtext datetimepicker" type="text" name="submission_deadline" value="<?php echo set_value('submission_deadline', $product->submission_deadline); ?>">
                  <?=form_error('submission_deadline')?>
                </div>
              </li>
             
               <li>
                <div>
                  <label>Save Method <span>*</span> :</label>
                 <select name="save_method">
                   <option value="1" <?php if($product->save_method=='1') echo "selected='selected'"?>>Open for Bid</option>
                   <option value="2" <?php if($product->save_method=='2') echo "selected='selected'"?>>Save to Draft</option>
                  </select>
                    <?=form_error('save_method')?>
                </div>
              </li>
               
           
         
         <!--   
         <li>
           <div>
             <label><?php echo $static_field['auction_time_zone']['field_label']; ?><span>*</span> :</label>
             <?php
               $time_zone = ($this->input->post('auction_time_zone',TRUE)?$this->input->post('auction_time_zone',TRUE): $product->auction_time_zone);
             
               echo $this->general->timezone_list('auction_time_zone', $time_zone);
               echo form_error('auction_time_zone');
             ?>
           </div>
         </li>
      
            <?php if(isset($static_field['currency']) && $static_field['currency']['display']=='1'){ ?>
            <li>
              <div>
                <label><?php echo $static_field['currency']['field_label']; ?><span>*</span> :</label>
                <?php
                  $currency = ($this->input->post('currency',TRUE)?$this->input->post('currency',TRUE):$product->currency);
                  $currency_list_final = '';                 
                  $currency_list_final[''] = 'Select '.$static_field['currency']['field_label'];
                  if($currencies)
                  {
                    foreach ($currencies as $curr) 
                    {
                      $currency_list_final[$curr->id] = $curr->currency_code.'-'.$curr->currency_sign;
                    }
                  }            
                  echo form_dropdown('currency', $currency_list_final, $currency, 'class="form-control select_control"');
                  echo form_error('currency');
                ?>
              </div>
            </li>
            <?php } ?> -->

            <!-- <?php if(isset($static_field['budget']) && $static_field['budget']['display']=='1'){ ?>
              <li>
                <div>
                  <label><?php echo $static_field['budget']['field_label']; ?><span>*</span> :</label>
                  <input size="50" class="inputtext" type="text" name="budget" value="<?php echo set_value('budget', $product->budget); ?>">
                  <?=form_error('budget')?>
                </div>
              </li>
            <?php } ?>
            <?php if(isset($static_field['bid_decrement']) && $static_field['bid_decrement']['display']=='1'){ ?>
              <li>
                <div>
                  <label><?php echo $static_field['bid_decrement']['field_label']; ?><span>*</span> :</label>
                  <input size="50" class="inputtext" type="text" name="bid_decrement" value="<?php echo set_value('bid_decrement', $product->bid_decrement); ?>">
                  <?=form_error('bid_decrement')?>
                </div>
              </li>
            <?php } ?>
            
            
            
            <?php if(isset($static_field['auction_end_days']) && $static_field['auction_end_days']['display']=='1'){ ?>
              <li>
                <div>                    
                  <label><?php echo $static_field['auction_end_days']['field_label']; ?></label>
                  <input  type="text" name="auc_end_days" class="inputtext" value="<?php echo set_value('auc_end_days', $product->auc_end_days); ?>">
                  <?php echo form_error('auc_end_days'); ?>
                </div>
                </li>
            <?php } ?>  
            <br />-->
            <li> 
              <div>
                <label>Status<span>*</span> :</label>
                <?php   $status=$product->status; ?>
                <span class="radio-inline " ><input type="radio" class="prostatus" id="pending" name="status" value="1" <?php if($status=='1'){echo 'checked="checked"';} ?>> Pending </span> 
                <span class="radio-inline "><input type="radio" class="prostatus" id="active" name="status" value="2" <?php if($status=='2'){echo 'checked="checked"';} ?>> Active </span>
                <span class="radio-inline "><input type="radio" class="prostatus" id="closed" name="status" value="3" <?php if($status=='3'){echo 'checked="checked"';} ?>> Closed </span>
                <span class="radio-inline "><input type="radio" class="prostatus" id="cancelled" name="status" value="4" <?php if($status=='4'){echo 'checked="checked"';} ?>> Cancelled </span>
                <?=form_error('status')?>
              </div>
            </li>
            <?php 
              $dis='';
              $hid='';
              if($product->status!='4'){
                $dis="disabled='disabled'";
                $hid="style='display: none'";
              }?>
            <li class="dbl_wth" id="cancel_reason"  <?php echo $hid?>>
              <div>
                <label>
                  Reason
                </label>
                <textarea name="reject_reason" id="reject_reason" rows="0"  <?php echo $dis?> class="form-control"><?php echo $product->reject_reason;?></textarea>
                 <?=form_error('reject_reason')?>
              </div>
            </li>
            </ul>
          </fieldset>
          
          
          <?php //if(UPLOAD_PRODUCT_IMAGES=='Yes' && isset($static_field['upload_photos'])){ ?>
          
          <!-- <fieldset>
            <div class="title_h3">Product Images</div>
            <p>Please upload 1 photos of your item. One photo should be taken by you, clearly showing any features or defects. Photos must be at least 500 pixels wide and 480 pixels tall and no more than 4MB in file size.</p>
            <div class="dropzoneResponse" style="display:none;"></div>
            <div action='<?php echo site_url('/'.MY_ACCOUNT.'multiple_image_ajax_uploader')?>' class='form-group row dropzone' id='my-awesome-dropzone'>
              <?php 
			if($product_images){
				foreach($product_images as $image)
				{
					?>
              <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" id="<?php echo $image->id;?>">
                <div class="dz-image edit-image">
                  <?php if($job=='edit'){ ?>
                  <img alt="<?php echo $image->image; ?>" src="<?php echo site_url(PRODUCT_IMAGE_PATH.'upcoming_'.$image->image); ?>" />
                  <?php } else if($job=='relist'){ ?>
                  <img alt="<?php echo $image->image; ?>" src="<?php echo site_url(PRODUCT_IMAGE_PATH_TEMP.$image->image); ?>" />
                  <?php } ?>
                </div>
                <div class="dz-details">
                  <div class="dz-filename"> <span><?php echo $image->image; ?></span></div>
                </div>
                <a href="javascript:void(0);" class="dz-remove remove_image" data-job="<?php echo $job; ?>" data-imgname="<?php echo $image->image; ?>" data-imgid="<?php echo $image->id; ?>" data-pid='<?php echo ($job=='edit')?$product->id:''; ?>'  data-pcode="<?php echo ($job=='relist')?$product_code:''; ?>">Remove file</a> </div>
              <?php
				}
		
		?>
            </div>            
            <!--<input class="transparent" minimum-photos-required="minimum-photos-required" data-error="Upload at least two photos.">
            <input class="transparent" require-two-photos="require-two-photos" data-error="Upload at least two photos.">
            <?php } ?>
            </fieldset>
               -->
            
        
        
        
       <!--  <fieldset id="basicFields">
        	<?php //echo $basic_field_html; ?>
        </fieldset>
        
        <fieldset id="additionalCustomFields" <?php echo ($custom_field_html==''?'style="display:none;"':'style="display:block;"') ?>>
        	<?php echo $custom_field_html; ?>
        </fieldset> -->
        
        <input type="hidden" name="pcodeimg" id="pcodeImg" value="<?php echo $product_code; ?>" />
        <input type="hidden" name="cat" value="<?php echo $product->cat_id; ?>" id="hiddenCat" />
        <!-- <input type="hidden" name="subcat" value="<?php echo $product->sub_cat_id; ?>;" id="hiddenSubCat" /> -->
       	
        <fieldset class="btn">
           	<input type="submit" value="Submit" class="butn" id="editProductBtn">
        </fieldset>
        <div style="clear:both;"></div>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
<script src="<?php echo base_url(ADMIN_JS_DIR.'admin.edit.product.js'); ?>" type="text/javascript"></script>