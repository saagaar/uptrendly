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
    // maxFiles: '<?php //echo $images_quota; ?>',
		// maxFiles: 2,
		acceptedFiles: ".jpeg,.jpg,.png,.gif,.bmp",
		addRemoveLinks: true,
		dictRemoveFile: "Remove Image",
		// dictDefaultMessage : (parseInt('<?php //echo $images_quota; ?>')>0?"Drop files here to upload":"Remove images to upload new image"),    
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
  <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Reward Management</h2>
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
        <form name="edit-reward-form" id="editRewardForm" method="post" action="" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="title_h3">Add Reward</div>
          <fieldset>
            <?php
            $title=isset($data->title)?$data->title:'';
            $description=isset($data->description)?$data->description:'';
            $is_display=isset($data->is_display)?$data->is_display:'1';
            $points=isset($data->points)?$data->points:'';
            $image=isset($data->image)?$data->image:'';
             ?>
         
            <ul class="frm">
             
             <li>
                  <label>Title :</label>
                 <input size="50" class="inputtext" type="text" id="title" name="title" value="<?php echo set_value('title',$title); ?>">
                <?=form_error('title')?>
             </li>
            <li >
              <label>Description :</label>
              <textarea rows="7" name="description" class="form-control"><?php echo set_value('description',$description); ?></textarea>
              <?=form_error('description')?>
            </li>   
             <li>
                <label>Requrired Points</label>
                <input size="50" class="inputtext" type="text" id="points" name="points" value="<?php echo set_value('points',$points); ?>">
                <?=form_error('points')?></li>
              <li >
               <li>
              <div>   
              <label>
                  Is Display
              </label>      
            
                <span class="radio-inline"><input type="radio" name="is_display" value="1" <?php if($is_display!='0'){echo 'checked="checked"';} ?>> YES </span> 
                <span class="radio-inline"><input type="radio" name="is_display" value="2" <?php if($is_display=='0'){echo 'checked="checked"';} ?>> No </span>
                <?=form_error('is_display')?>
              </div>
            </li>
            </ul>
            
         
          </fieldset>
          
        
          
          
          
          <fieldset>
            <div class="title_h3">Upload Photos</div>
             <div class="col-sm-5">
                          <div class="upload_product_image text-center">
                            <div id="brwose-image">
                            <?php if($image==''): ?>
                            <h1>
                            <i class="fa fa-user"></i></h1>
                            <?php 
                            else:
                              ?>
                            <img src="<?php echo site_url('/'.PRODUCT_IMAGE_PATH.$image);?>">
                            <?php
                            endif;
                            ?>

                            </div>
                          
                              <div class="fileUpload btn btn-lg btn-primary"><span>Upload photos</span>
                                   <input type="file" name="uploadimage" id="fileUpload" class="upload" accept="image/gif, image/jpeg, image/png" />
                              </div>
                           
                          </div>
                          </div>
  <?php
  if(isset($error) && $error!='')
  { 
    
    ?>
      <div class="confrmmsg"><?php echo $error;?></div>
  <?php
  unset($error); 
  }
  ?>                
            </fieldset>
        
            <fieldset class="btn">
               	<input type="submit" value="Submit" class="butn" id="editRewardsBtn">
            </fieldset>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>

<script type="text/javascript">
  $("#fileUpload").on('change', function () {
          if (typeof (FileReader) != "undefined") {
            var image_holder = $("#brwose-image");
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });
  </script>