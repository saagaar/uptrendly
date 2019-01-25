<section class="title">
  <div class="wrap">
  	<h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Members  Management </h2>
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
          if($this->session->flashdata('message'))
          {
            echo "<p>".$this->session->flashdata('message')."</p>";
          }
        ?>
      </div>
      <div class="box_block">
        <form name="sitesetting" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Personnel Detail</div>
            <ul class="frm">
              <li>
                <div>
                  <label>First Name <span>*</span> :</label>
                  <input type="text" name="name" class="inputtext" size=45 value="<?php echo set_value('name');?>">
                  <?=form_error('name')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Last Name <span>*</span> :</label>
                  <input type="text" name="last_name" class="inputtext" size=45 value="<?php echo set_value('last_name');?>">
                  <?=form_error('last_name')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Email <span>*</span></label>
                  <input type="text" name="email" class="inputtext" size=45 value="<?php echo set_value('email');?>">
                  <?=form_error('email')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Login Username <span>*</span></label>
                  <input type="text" name="username" class="inputtext" size=45 value="<?php echo set_value('username');?>">
                  <?=form_error('username')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Login Password<span>*</span> :</label>
                  <input type="password" name="password" class="inputtext" size=45 value="<?php echo set_value('password');?>">
                  <?=form_error('password')?>
                </div>
              </li>
              
              <li>
                <div>
                  <label>Phone Number <span>*</span> :</label>
                  <input type="text" name="phone" class="inputtext" size=45 value="<?php echo set_value('phone');?>">
                  <?=form_error('phone')?>
                </div>
              </li>
             
              <li>
                <div>
                  <label>User type:</label>                    
                    <input name="user_type" type="radio" value="3" checked="checked" />Advertiser
                   
                </div>
              </li>
               <li>
                <div>
                  <label>Brand Name <span>*</span> :</label>
                  <input type="text" name="brand_name" class="inputtext" size=45 value="<?php echo set_value('brand_name');?>">
                  <?=form_error('brand_name')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Advertiser URL <span>*</span> :</label>
                <input type="text" name="brand_url" class="inputtext" size=45 value="<?php echo set_value('brand_url');?>">
                  <?=form_error('brand_url')?>
                </div>
              </li>
            </ul>
          </fieldset>
          
         <fieldset>
            <div class="title_h3">Address Details</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Street1<span>*</span> :</label>
                  <input name="company_address1" type="text" class="inputtext" id="company_address1" value="<?php echo set_value('company_address1');?>" size=45>
                  <?=form_error('company_address1')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Street2<span>*</span> :</label>
                  <input name="company_address2" type="text" class="inputtext" id="company_address2" value="<?php echo set_value('company_address2');?>" size=45>
                  <?=form_error('company_address2')?>
                </div>
              </li>
              <li>
                <div>
                  <label>City<span>*</span> :</label>
                  <input name="company_city" type="text" class="inputtext" id="company_city" value="<?php echo set_value('company_city');?>" size=45>
                  <?=form_error('company_city')?>
                </div>
              </li>
              <li>
                <div>
                  <label>State<span>*</span> :</label>
                  <input name="company_state" type="text" class="inputtext" id="company_state" value="<?php echo set_value('company_state');?>" size=45>
                  <?=form_error('company_state')?>
                </div>
              </li>              
              <li>
                <div>
                  <label>Country <span>*</span> :</label>
                  <?php
                    $selected_country = '';
                    if($this->input->post('company_country',TRUE)){
                      $selected_country = $this->input->post('company_country',TRUE);
                    }
                    
                    $country_arr = array();
                    $country_arr[''] = "Select Country";
                    if($countries)
                    {
                      foreach($countries as $country)  
                      {
                        $country_arr[$country->id] = $country->country;
                      }
                    }
                  echo form_dropdown('company_country', $country_arr, $selected_country);
                ?>
                <?=form_error('company_country')?>
                </div>
              </li>

              <li>
                <div>
                  <label>Zip Code<span>*</span> :</label>
                  <input name="company_zipcode" type="text" class="inputtext" id="company_zipcode" value="<?php echo set_value('company_zipcode');?>" size=45>
                  <?=form_error('company_zipcode')?>
                </div>
              </li>
            </ul>
          </fieldset>          
          <fieldset>
            <div class="title_h3">Company Details</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Company Name<span>*</span> :</label>
                  <input name="company_name" type="text" class="inputtext" id="company_name" value="<?php echo set_value('company_name');?>" size=45>
                  <?=form_error('company_name')?>
                </div>
              </li>
               <li>
                <div>
                  <label>Company Website<span>*</span> :</label>
                  <input name="company_website" type="text" class="inputtext" id="company_website" value="<?php echo set_value('company_website');?>" size=45>                
                  <?=form_error('company_website')?>
                </div>
              </li>
              <li>
               <!--  <div>
                  <label>Company Info<span>*</span> :</label>
                  <textarea name="company_info" type="text" class="inputtext" id="company_info" ><?php echo set_value('company_info');?></textarea>
                  <?=form_error('company_info')?>
                </div> -->
              </li>
              <li>
               <!--  <div>
                  <label>Company Description<span>*</span> :</label>
                  <textarea name="description" type="text" class="inputtext" id="description" ><?php echo set_value('description');?></textarea>
                  <?=form_error('description')?>
                </div> -->
              </li>
            </ul>
          </fieldset>
          <!-- <fieldset>
            <div class="title_h3">Company Address Details</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Company Address1<span>*</span> :</label>
                  <input name="company_address1" type="text" class="inputtext" id="company_address1" value="<?php echo set_value('company_address1');?>" size=45>
                  <?=form_error('company_address1')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company Address2<span>*</span> :</label>
                  <input name="company_address2" type="text" class="inputtext" id="company_address2" value="<?php echo set_value('company_address2');?>" size=45>                
                  <?=form_error('company_address2')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company City<span>*</span> :</label>
                  <input name="company_city" type="text" class="inputtext" id="company_city" value="<?php echo set_value('company_city');?>" size=45>                
                  <?=form_error('company_city')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company State<span>*</span> :</label>
                  <input name="company_state" type="text" class="inputtext" id="company_state" value="<?php echo set_value('company_state');?>" size=45>                
                  <?=form_error('company_state')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company Zip Code<span>*</span> :</label>
                  <input name="company_zipcode" type="text" class="inputtext" id="company_zipcode" value="<?php echo set_value('company_zipcode');?>" size=45>                
                  <?=form_error('company_zipcode')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company Country <span>*</span> :</label>
                  <?php
                    $selected_country = '';
                    if($this->input->post('company_country',TRUE)){
                      $selected_country = $this->input->post('company_country',TRUE);
                    }
                    
                    $country_arr = array();
                    $country_arr[''] = "Select Country";
                    if($countries)
                    {
                      foreach($countries as $country)  
                      {
                        $country_arr[$country->id] = $country->country;
                      }
                    }
                    echo form_dropdown('company_country', $country_arr, $selected_country);
                  ?>
                  <?=form_error('company_country')?>
                </div>
              </li>
          
              <li>
                <div>
                  <label>Company Phone<span>*</span> :</label>
                  <input name="company_phone" type="text" class="inputtext" id="company_phone" value="<?php echo set_value('company_phone');?>" size=45>                
                  <?=form_error('company_phone')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company Fax<span>*</span> :</label>
                  <input name="company_fax" type="text" class="inputtext" id="company_fax" value="<?php echo set_value('company_fax');?>" size=45>                
                  <?=form_error('company_fax')?>
                </div>
              </li>
              <li>
                <div>
                  <label>Company Website<span>*</span> :</label>
                  <input name="company_website" type="text" class="inputtext" id="company_website" value="<?php echo set_value('company_website');?>" size=45>                
                  <?=form_error('company_website')?>
                </div>
              </li>
            </ul>
          </fieldset> -->
          <fieldset class="btn">
            <input class="butn" type="submit" name="Submit" value="Add" />
          </fieldset>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
