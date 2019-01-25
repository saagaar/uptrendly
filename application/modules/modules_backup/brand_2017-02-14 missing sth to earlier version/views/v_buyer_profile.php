
<div class="col-md-8 col-sm-7">
          <div class="log-form">
            <form id="editBuyerProfileForm" method="post" action="" enctype="multipart/form-data">
          <fieldset>
              <?php if($this->session->flashdata('error_message')) { ?>
                <span class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></span>
              <?php } elseif($this->session->flashdata('success_message')) {?>
                <span class="text-success"><?php echo $this->session->flashdata('success_message'); ?></span>
              <?php } ?>
            <h4><i class="fa fa-user">&nbsp;</i> Personal Details</h4>
              <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo set_value('first_name', $profile->name); ?>">
                <?php echo form_error('first_name'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo set_value('last_name', $profile->last_name); ?>">
                <?php echo form_error('last_name'); ?>
                
                </div>
              </div>
                            <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo set_value('email', $profile->email); ?>">
                <?php echo form_error('email'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Phone No</label>
                <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', $profile->phone); ?>">
                <?php echo form_error('phone'); ?>
                </div>
              </div>
                            <div class="form-group">
                              <label>About Me</label>
                              <textarea name="about_user" class="form-control" rows="4"><?php echo set_value('about_user', $profile->about_user); ?></textarea>
                            <?php echo form_error('about_user'); ?>
                            </div>
                            
                        <h4><i class="fa fa-user">&nbsp;</i> Personal Address</h4>
                        <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Address 1</label>
                <input type="text" name="address" class="form-control"  value="<?php echo set_value('address', $profile->address); ?>">
                <?php echo form_error('address'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Address 2</label>
                <input type="text" name="address2" class="form-control"  value="<?php echo set_value('address2', $profile->address2); ?>">
                <?php echo form_error('address2'); ?>
                </div>
              </div>
                        <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>City</label>
                <input type="text" name="city" class="form-control"  value="<?php echo set_value('city', $profile->city); ?>">
                <?php echo form_error('city'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>State</label>
                <input type="text" name="state" class="form-control"  value="<?php echo set_value('state', $profile->state); ?>">
                <?php echo form_error('state'); ?>
                </div>
              </div>
                            <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Post Code</label>
                <input type="text" name="post_code" class="form-control"  value="<?php echo set_value('post_code', $profile->post_code); ?>">
                <?php echo form_error('post_code'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Country</label>
                <?php
                  $selected_country = 184;
                  if($this->input->post('country',TRUE)){
                    $selected_country = $this->input->post('country',TRUE);
                  }else if($profile->country!='' && $profile->country!=0){
                    $selected_country = $profile->country;  
                  }
                  $country_arr = array();
                  $country_arr[''] = "Choose Country";
                  foreach($countries as $country) 
                  {
                    $country_arr[$country->id] = $country->country;
                  }
                  echo form_dropdown('country', $country_arr, $selected_country, "class='form-control country'");
                  echo form_error('country');
                ?>
                  
               
                </div>
              </div>
              
            
            <h4><i class="fa fa-user">&nbsp;</i> Company Details</h4>
                <label>Company Name</label>
                <div class="form-group">
                <input type="text" name="company_name" class="form-control" placeholder="Supplier  demo company name the high tree group 1234567890.inc"  value="<?php echo set_value('last_name', $profile->company_name); ?>">
                <?php echo form_error('company_name'); ?>
                </div>
                <div class="form-group">
                                <label>Details</label>
                <textarea name="description" class="form-control" rows="5"><?php echo set_value('description', $profile->description); ?></textarea>
                <?php echo form_error('description'); ?>
                </div>
                                
                            <div class="row">
                <div class="col-md-12 col-sm-12 form-group">
                                <label>Company Address</label>
                <input type="text" name="company_address1" class="form-control" value="<?php echo set_value('company_address1', $profile->company_address1); ?>">
                <?php echo form_error('company_address1'); ?>
                </div>
              <!--   <div class="col-md-6 col-sm-12 form-group">
                                <label>Address 2</label>
                <input type="text" name="company_address2" class="form-control" value="<?php echo set_value('company_address2', $profile->company_address2); ?>">
                <?php echo form_error('company_address2'); ?>
                </div> -->
              </div>
                            <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>City</label>
                <input type="text" name="company_city" class="form-control" value="<?php echo set_value('company_city', $profile->company_city); ?>">
                <?php echo form_error('company_city'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>State</label>
                <input type="text" name="company_state" class="form-control" value="<?php echo set_value('company_state', $profile->company_state); ?>">
                <?php echo form_error('company_state'); ?>
                </div>
              </div>
                            <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Poste Code</label>
                <input type="text" name="company_zipcode" class="form-control" value="<?php echo set_value('company_zipcode', $profile->company_zipcode); ?>">
                <?php echo form_error('company_zipcode'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Country</label>
                <?php
                  $selected_country = 184;
                  if($this->input->post('company_country',TRUE)){
                    $selected_country = $this->input->post('company_country',TRUE);
                  }else if($profile->company_country!='' && $profile->company_country!=0){
                    $selected_country = $profile->company_country;  
                  }
                  $country_arr = array();
                  $country_arr[''] = "Choose Country";
                  foreach($countries as $country) 
                  {
                    $country_arr[$country->id] = $country->country;
                  }
                  echo form_dropdown('company_country', $country_arr, $selected_country, "class='form-control country'");
                  echo form_error('company_country');
                ?>
                  
                </div>
              </div>
                <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Telephone</label>
                <input type="text" name="company_phone" class="form-control" value="<?php echo set_value('company_phone', $profile->company_phone); ?>">
                <?php echo form_error('company_phone'); ?>
                </div>
                <div class="col-md-6 col-sm-12 form-group">
                                <label>Website</label>
                <input type="url" name="company_website" class="form-control" value="<?php echo set_value('company_website',$profile->company_website); ?>">
                <?php echo form_error('company_website'); ?>
                </div>
              </div>
                         <div class="btn-sec"><button id="editBuyerProfileBtn" type="submit" name="button" class="btn">Submit</button></div>
                            
          </fieldset>
        </form>   
                
             <div class="clearfix"></div>
            </div>
        </div>