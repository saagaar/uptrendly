<script type="text/javascript">

	var UrlFetchCustomFields = "<?php echo site_url('/'.MY_ACCOUNT.'ajax_process_custom_fields');?>";

	var UrlRemoveDropzoneTempImage = "<?php echo site_url('/'.MY_ACCOUNT.'ajax_delete_product_temp_images'); ?>";

</script>



<div class="col-md-8 col-sm-7">

	<div class="log-form">    

    	<form id="addProductForm" method="post" action="" enctype="multipart/form-data">



			<fieldset>

			<?php if($this->session->flashdata('success_message')) {
			
   ?>
   	<div class="alert alert-success fade in">
    <strong>Success!</strong> <?php echo '<span class="text-success">'.$this->session->flashdata("success_message").'</span>';
 ?>
</div>
<?php 
				
			} elseif($this->session->flashdata('error_message')) {
				?>
				<div class="alert alert-danger fade in">
   
    <strong>Error!</strong> <?php echo '<span class="text-danger">'.$this->session->flashdata("error_message").'</span>';
?>
</div>
				<?php
				

				
			}

			?>

				<h4><i class="fa fa-gavel" aria-hidden="true">&nbsp;</i> Setup Your Auction</h4>

				

				

				<div class="row">

					<div class="col-md-6 col-sm-12">                   

					<div class="btn_item dropdown drilldown">

        	<a class="btn btn_item_select dropdown-toggle" data-toggle="dropdown" type="button" id="chooseCategory"> <?php if(isset($_POST['categoryName']) && $_POST['categoryName']!=''){echo $_POST['categoryName'];}else{echo 'Choose Category'.'<span>*</span>';}; ?> <span class="fa fa-angle-down"></span> </a>

         <ul class="dropdown-menu" role="menu">

            <?php

				if($category_tree){

					foreach($category_tree as $category)

					{

						?>

                        <li <?php if($category['subcat']==''){ ?> onclick="addThis('<?php echo $category['name']; ?>','<?php echo $category['id']; ?>','0')" <?php } else { ?>class="dropdown-submenu"<?php }?>>

                        	<a href="javascript:void(0)" tabindex="-1"><?php echo $category['name']; ?></a>

                       		<?php if($category['subcat']!=''){ ?>

								<ul class="dropdown-menu" >

									<?php foreach($category['subcat'] as $subcat){?>

                                    	<li onclick="addThis('<?php echo $subcat['name']; ?>','<?php echo $category['id']; ?>','<?php echo $subcat['id']; ?>')"> 

                                        	<a href="javascript:void(0)" data-clickable="data-clickable" tabindex="-1">

												<?php echo $subcat['name']; ?>

                                        	</a>

                                     	</li>

                                    <?php } ?>

								</ul>

							<?php } ?>

                       </li> 

                        <?php

					}

				}

			?>

             </ul> 

		</div>  <input type="hidden" name="category" id="hiddenCatField" value="<?php if(isset($_POST['category']) && $_POST['category']!=''){echo $_POST['category'];}; ?>" />

        <?=form_error('category')?>

        <input type="hidden" name="categoryName" id="hiddenCatName" value="<?php if(isset($_POST['categoryName']) && $_POST['categoryName']!=''){echo $_POST['categoryName'];}; ?>" />

      </div>

				<?php if(isset($static_field['name']) && $static_field['name']['display']=='1'){ ?>

					<div class="col-md-6 col-sm-12 form-group">

                    <label><?php echo $static_field['name']['field_label']."<span>*</span>"; ?></label>

					<input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>">

					<?php echo form_error('name'); ?>

					</div>

				<?php } ?>				

				

				</div>

                <div class="row">

            		<?php if(isset($static_field['description']) && $static_field['description']['display']=='1'){ ?>



					<div class="col-md-6 col-sm-12 form-group">

                    <label><?php echo $static_field['description']['field_label']."<span>*</span>"; ?></label>

                    <textarea name="description" class="form-control" rows="4"><?php echo set_value('description'); ?></textarea>

					<?php echo form_error('description'); ?>

					</div>

					<?php } ?>

            		<?php if(isset($static_field['auction_type']) && $static_field['auction_type']['display']=='1'){ ?>



					<div class="col-md-6 col-sm-12 form-group">

                    <label><?php echo $static_field['auction_type']['field_label']; ?></label>

                    <div class="clearfix"></div>

                		<?php $auction_type = ($this->input->post('auction_type',TRUE)?$this->input->post('auction_type',TRUE):'1'); ?>



						<span class="radio-inline">

							<input type="radio" id="inlineCheckbox1" name="auction_type" value="1" <?php if($auction_type=='1'){echo 'checked="checked"';} ?>>

							Public Auction

						</span>

						<span class="radio-inline">

							 <input type="radio" id="inlineCheckbox2" name="auction_type" value="2" <?php if($auction_type=='2'){echo 'checked="checked"';} ?>>

							 Private Auction

						</span>

					</div>

					<?php } ?>

				</div>

                <div class="row">

            		<?php if(isset($static_field['auction_start_time']) && $static_field['auction_start_time']['display']=='1'){ ?>

					<div class="col-md-6 col-sm-12 form-group">

                    <label><?php echo $static_field['auction_start_time']['field_label'] ."<span>*</span>";?></label>

					<input  type="text" name="auc_start_time" class="form-control datetimepicker" value="<?php echo set_value('auc_start_time'); ?>">

					<?php echo form_error('auc_start_time'); ?>								

					</div>

					<?php } ?>

            		<?php if(isset($static_field['auction_end_days']) && $static_field['auction_end_days']['display']=='1'){ ?>

                    <div class="col-md-6 col-sm-12 form-group">

                    <label><?php echo $static_field['auction_end_days']['field_label']."<span>*</span>"; ?></label>

					<input  type="text" name="auc_end_days" class="form-control" value="<?php echo set_value('auc_end_days'); ?>">

					<?php echo form_error('auc_end_days'); ?>

					</div>

					<?php } ?>						

				</div>

                <div class="row">  

            		<?php if(isset($static_field['auction_time_zone']) && $static_field['auction_time_zone']['display']=='1'){ ?>



					<div class="col-md-6 col-sm-12 form-group">

					<label><?php echo $static_field['auction_time_zone']['field_label']; ?></label>

					 <?php

		                  $time_zone = ($this->input->post('auction_time_zone',TRUE)?$this->input->post('auction_time_zone',TRUE):'');

		                

		                  echo $this->general->timezone_list('auction_time_zone', $time_zone, 'class="form-control"');

		                  echo form_error('auction_time_zone');

		                ?>        

					

					<?php echo form_error('auction_time_zone'); ?>								

					</div>

					<?php } ?>

					<?php if(isset($static_field['currency']) && $static_field['currency']['display']=='1'){ ?>

             		<div class="col-md-6 col-sm-12 form-group">

		                <label><?php echo $static_field['currency']['field_label']; ?><span>*</span> :</label>

		                <?php

		                    $currency = ($this->input->post('currency',TRUE)?$this->input->post('currency',TRUE):'');

		                

				            $currency_list_final = '';                 

				            $currency_list_final[''] = 'Select '.$static_field['currency']['field_label'];

				            if($currencies)

				            {

				                foreach ($currencies as $curr) 

				              	{

				                   // $currency_list_final[$curr->id] = $curr->currency_code.'-'.$curr->currency_sign;
				              		$currency_list_final[$curr->id] = $curr->currency_code;

				                }

				            }

				            echo form_dropdown('currency', $currency_list_final, $currency, 'class="form-control"');

				            echo form_error('currency');

		            	?>

	              	</div>

		            <?php } ?>

                                            

				</div>

                <div class="row">

					<?php if(isset($static_field['budget']) && $static_field['budget']['display']=='1'){ ?>



					<div class="col-md-6 col-sm-12 form-group">

                        <label><?php echo $static_field['budget']['field_label']; ?></label>

						<input type="text" name="price" class="form-control" value="<?php echo set_value('price'); ?>">

						<?php echo form_error('price'); ?>								

					</div>

					<?php } ?>

					<?php if(isset($static_field['bid_decrement']) && $static_field['bid_decrement']['display']=='1'){ ?>



                    <div class="col-md-6 col-sm-12 form-group">

                        <label><?php echo $static_field['bid_decrement']['field_label']."<span>*</span>"; ?></label>

						<input type="text" name="bid_decrement" class="form-control" value="<?php echo set_value('bid_decrement'); ?>">

						<?php echo form_error('bid_decrement'); ?>

					</div>

					<?php }?>

				</div>

				<input type="hidden" name="product_code" id="pcodeImg" value="<?php echo $product_code; ?>" />

        <input type="hidden" name="cat" value="" id="hiddenCat"/>

        <input type="hidden" name="subcat" value="" id="hiddenSubCat" />

                <div class="note alert alert-info"><strong>Note</strong> The decrement is the minimum amount by which a bid may be reduced. At Reverse Auction the decrement applies to a supplier’s previous 

bid rather then an amount below the Auction’s lowest bid, ie, the decrement is owned by each bidder.</div>

                <!-- <h4><i class="fa fa-paperclip" aria-hidden="true">&nbsp;</i> Attach Supplementary Documents</h4> -->

				<div class="row">

					<!-- <div class="col-md-6 col-sm-12 form-group">

                        <label>Document Attach</label>

                    	<input type="file" class="filestyle" name="product_attachment" data-buttonName="btn-primary" data-icon="false" data-buttonText="Browse">

					</div>

					<div class="col-md-6 col-sm-12 form-group">

                        <label>Documents Information</label>

						<input type="text" name="document_info" class="form-control">

					</div> -->

					<?php echo $basic_field_html; ?>

				</div> 

				

				<div class="row" id="additionalCustomFields" <?php echo ($custom_field_html==''?'style="display:none;"':'style="display:block;"') ?>>

		          <?php echo $custom_field_html; ?>

		        </div>

					

				

              	<button id="addProductBtn" type="submit" name="button" class="btn">Add Auction</button>

			</fieldset>

		</form>

		<div class="clearfix"></div>

    </div>

</div>





