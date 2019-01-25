<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Product Form Fields</h2>
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
                <form name="add_cat" method="post" action="" accept-charset="utf-8" enctype="multipart/form-data">
                <fieldset>
                  <div class="title_h3">Edit form Fields</div>
                  <ul class="frm">
                  	<li>
                      <div>
                        <label>Name<span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" id="name" name="name" value="<?php echo set_value('name',$field_data->name); ?>">
                        <?=form_error('name')?>
                      </div>
                    </li>
                    
                    <li>
                      <div>
                        <label>Type <span>*</span> :</label>
                        <?php
							if($this->input->post('type',TRUE) && $this->input->post('type',TRUE)!=''){
								$selected_type = $this->input->post('type',TRUE);
							}else{
								$selected_type = $field_data->type;
							}
							
							$type_arr = array();
                            $data_type = array('CHECKBOX','DATE','DATETIME','DROPDOWN','EMAIL','FILE','NUMBER','RADIO','TEXT','TEXTAREA','URL');
							foreach($data_type as $type){
								$type_arr[$type] = $type;
							}
							echo form_dropdown('type',$type_arr, $selected_type, 'id="dataType"');
						?>
                      </div>
                    </li>
                    
                    
                    <li class="txthalf" id="optionField" style="display:none;">
                      <div>
                        <label>Options (Separate options with commas) <span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" name="options" value="<?php echo set_value('options', $field_data->options); ?>">
                        <?=form_error('options')?>
                      </div>
                    </li>
                    </ul>
                   </fieldset>
                    
                   <fieldset>
                  	<div class="title_h3">Validation Rules</div>
                  		<ul class="frm">
                    		<li>
                          	<?php
								$required = '';
								if($this->input->post('required',TRUE) && $this->input->post('required',TRUE)=='true'){
									$required= $this->input->post('required',TRUE);
								}else if(isset($validation_rules->required) && $validation_rules->required=='true'){
									$required= $validation_rules->required;
								}
							?>
                          		<input type="checkbox" value="true" name="required" <?php if($required=='true'){echo 'checked="checked"';} ?>>
                                <span>This field is Required/Mandatory</span>
                            </li>
                    		
                            <li class="file-field" id="extensionField" style="display:none;">
                           	<?php
                                $selected_extension_array = '';
                                if($this->input->post('extension',TRUE)){
                                    $selected_extension_array = $this->input->post('extension',TRUE);
                                }else{
                                    $selected_extension_array = explode(',',$field_data->extensions);
                                }
                                //print_r($selected_extension_array);
                            ?>
                                <label>File Extension<span>*</span> :</label>
                                <input type="checkbox" value="doc" name="extension[]" <?php if($selected_extension_array && in_array('doc', $selected_extension_array)){echo "checked";} ?>>.doc
                               <input type="checkbox" value="xls" name="extension[]" <?php if($selected_extension_array && in_array('xls', $selected_extension_array)){echo "checked";} ?>>.xls
                                <input type="checkbox" value="pdf" name="extension[]" <?php if($selected_extension_array && in_array('pdf', $selected_extension_array)){echo "checked";} ?>>.pdf
                            </li>
                    		
                            <li class="text-field" style="display:none;">
                            	<?php
									$al_alnum = '';
                            		if($this->input->post('al_alnum',TRUE) && $this->input->post('al_alnum',TRUE)!=''){
										$al_alnum = $this->input->post('al_alnum',TRUE);
									}else if(isset($validation_rules->alpha) && $validation_rules->alpha=='true'){
										$al_alnum = "alpha";
									}else if(isset($validation_rules->alphanumeric) && $validation_rules->alphanumeric=='true'){
										$al_alnum = "alphanumeric";
									}
									//echo $al_alnum; exit;
								?>
                            	<label><span>Choose Alpha or Alphanumeric</span></label>
                            	<input type="radio" name="al_alnum" value="alpha" <?php if($al_alnum=='alpha'){echo 'checked="checked"';} ?>/>Alpha
                                <input type="radio" name="al_alnum" value="alphanumeric" <?php if($al_alnum=='alphanumeric'){echo 'checked="checked"';} ?>/>AlphaNumeric
                            </li>
                            
                            <li class="number-field" style="display:none;">
                            	<?php
									$digits = '';
                            		if($this->input->post('digits',TRUE) && $this->input->post('digits',TRUE)=='true'){
										$digits= $this->input->post('digits',TRUE);
									}else if(isset($validation_rules->digits) && $validation_rules->digits=='true'){
										$digits= $validation_rules->digits;
									}
								?>
                      			<input type="checkbox" value="true" name="digits" <?php if($digits=='true'){echo 'checked="checked"';} ?>>
								<span>This field is Integer Number</span>
							</li>
                            
                            <li class="number-field" style="display:none;">
                            	<?php
									$min = '';
                            		if($this->input->post('min',TRUE) && $this->input->post('min',TRUE)!=''){
										$min= $this->input->post('min',TRUE);
									}else if(isset($validation_rules->min) && $validation_rules->min!=''){
										$min= $validation_rules->min;
									}
								?>
                      			<label><span>Min Numeric Value</span></label>
                                <input type="number" name="min" value="<?php echo set_value('min',$min); ?>">
                                <?=form_error('min')?>
							</li>
                            
                            <li class="number-field" style="display:none;">
                            	<?php
									$max = '';
                            		if($this->input->post('max',TRUE) && $this->input->post('max',TRUE)!=''){
										$max= $this->input->post('max',TRUE);
									}else if(isset($validation_rules->max) && $validation_rules->max!=''){
										$max= $validation_rules->max;
									}
								?>
                      			<label><span>Max Numeric Value</span></label>
                                <input type="number" name="max" value="<?php echo set_value('max',$max); ?>">
                                <?=form_error('max')?>
							</li>
                            
                            <li class="text-field" style="display:none;">
                            	<?php
									$choose_group = '';
                            		if($this->input->post('choose_group',TRUE) && $this->input->post('choose_group',TRUE)!=''){
										$choose_group = $this->input->post('choose_group',TRUE);
									}else if(isset($validation_rules->exactlength) && $validation_rules->exactlength!=''){
										$choose_group = "exact_length";
									}else if(isset($validation_rules->minlength) && isset($validation_rules->maxlength) && $validation_rules->minlength!='' && $validation_rules->maxlength!=''){
										$choose_group = "length_range";
									}
								?>
                            
                            	<label><span>Choose Exact Length or Length Range</span></label>
                            	<input type="radio" name="choose_group" value="exact_length" <?php if($choose_group=='exact_length'){echo 'checked="checked"';} ?>/>Exact Length
                                <input type="radio" name="choose_group" value="length_range" <?php if($choose_group=='length_range'){echo 'checked="checked"';} ?>/>Length Range
                            </li>
                            
                            <li class="exact-length-field" style="display:none;">
                            	<?php
									$exactlength = '';
                            		if($this->input->post('exactlength',TRUE) && $this->input->post('exactlength',TRUE)!=''){
										$exactlength = $this->input->post('exactlength',TRUE);
									}else if(isset($validation_rules->exactlength) && $validation_rules->exactlength!=''){
										$exactlength = $validation_rules->exactlength;
									}
								?>
                      			<label><span>Exact Length</span></label>
                                <input type="number" name="exactlength" value="<?php echo set_value('exactlength',$exactlength); ?>">
                                <?=form_error('exactlength')?>
							</li>
                            
                           	<li class="length-range-field" style="display:none;">
                           		<?php
									$minlength = '';
                            		if($this->input->post('minlength',TRUE) && $this->input->post('minlength',TRUE)!=''){
										$minlength= $this->input->post('minlength',TRUE);
									}else if(isset($validation_rules->minlength) && $validation_rules->minlength!=''){
										$minlength = $validation_rules->minlength;
									}
								?>
                            	<label><span>Minimum Length</span></label>
                      			<input type="number" name="minlength" value="<?php echo set_value('minlength',$minlength); ?>">
                                 <?=form_error('minlength')?>
							</li>
                            
                            <li class="length-range-field" style="display:none;">
                            	<?php
									$maxlength = '';
                            		if($this->input->post('maxlength',TRUE) && $this->input->post('maxlength',TRUE)!=''){
										$maxlength= $this->input->post('maxlength',TRUE);
									}else if(isset($validation_rules->maxlength) && $validation_rules->maxlength!=''){
										$maxlength = $validation_rules->maxlength;
									}
								?>
                      			<label><span>Maximum Length</span></label>
                                <input type="number" name="maxlength" value="<?php echo set_value('maxlength',$maxlength); ?>">
                                 <?=form_error('maxlength')?>
                            </li>
                    	</ul>
                    </fieldset>
                    <?php if (isset($category_tree) && (!empty($category_tree))){ ?>
                   <fieldset>
                   <div class="title_h3">Select the categories where you want to apply this attribute:</div>
                   <ul class="frm">
                    <li class="txthalf">
                     <ul class="check-box-sec">
                        <?php
                         	if($category_tree){
								foreach($category_tree as $category)
								{
									?>
                                    <li style="width:99%; background:#e4e4e4;">
                                     <?php if($category['subcat']!=''){ ?> <span class="accordionTrigger"></span><?php } ?>
                                     <input type="checkbox" name="categories[]" value="<?php echo $category['id'] ?>" class="cat<?php echo $category['id'] ?>" <?php if (in_array($category['id'], $field_cat_arr, true)) { echo "checked='checked'";} ?> onclick="return checkChilds(this);"/><?php echo $category['name']; ?>
                                        <?php if($category['subcat']!=''){ ?>
                                        	<ul class="accordionContent">
                                        		<?php foreach($category['subcat'] as $subcat){?>
                                            		<li style="width:100%; padding-left:20px;">
                                                		<input type="checkbox" name="categories[]" value="<?php echo $subcat['id'] ?>" class="subcat<?php echo $subcat['parent_id']; ?>" <?php if (in_array($subcat['id'], $field_cat_arr, true)) { echo "checked='checked'";} ?>/><?php echo $subcat['name']; ?>
													</li>
                                            	<?php } ?>
                                        	</ul>
                                        <?php } ?>
                                    </li>
                                    <?php
								}
							}
						 ?>
                         <?=form_error('categories')?>
                        </ul> 
                    </li>
                   </ul>
                </fieldset>
                <?php } ?>
                <fieldset class="btn">
                  <input type="submit" value="Submit" class="butn">
                </fieldset>
                </form>
            </div>
        </section>
    <div class="clearfix"></div>
    </div>
</article>

<script>var operation = 'edit';</script>
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin.custom.fields.js" type="text/javascript"></script>