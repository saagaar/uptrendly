
    	<section class="title">
        	<h2>Administrator &raquo; Update</h2>
        </section>
        
        <article id="bodysec" class="sep">
        	<aside class="lftsec">
            		<?php $this->load->view('menu/admin'); ?>
          </aside>
        
        	<section class="smfull">
            
            <?php
				if(validation_errors() != '' || $this->session->flashdata('message') != ''){
				?>
                  <div class="message">
                  		<?php
						if(validation_errors() != ''){
						 echo '<p>'.validation_errors().'</p>'; 
						}
						if($this->session->flashdata('message') != ''){
							
                  			echo '<p>'.$this->session->flashdata('message').'</p>';
						} 
				  ?>
                  </div>
                  <?php
					}
				  ?>
            
            
            <div class="box_block">
                
                 <?php echo form_open('',array('id' => 'changePasswordForm','autocomplete' => 'off')); ?>

                  <fieldset>
                  	<div class="title_h3">Change Password</div>
                  	<ul class="frm">
                    <li>
                    	<label>Old Password <span>*</span> : </label>
                        <input name="old_password" id="old_password" type="password" value="">
                        <?php echo form_error('old_password'); ?>
                    </li>
                    <li>
                    	<label>New Password <span>*</span> : </label>
                        <input name="new_password" id="new_password" type="password" value="">
                        <?php echo form_error('new_password'); ?>
                    </li>
                    <li>
                    	<label>Confirm New Password <span>*</span> : </label>
                        <input name="confirm_new_password" id="confirm_new_password" type="password" value="">
                        <?php echo form_error('confirm_new_password'); ?>
                    </li>
                    
                  	</ul>
                   </fieldset>
                  
                  
                  <fieldset class="btn">
                  	<button type="submit" class="butn">Update</button>
                  	<input type="hidden" name="admin_id" value="<?php echo $admin_default['admin_id'];?>" />
                  </fieldset>
                   <?php echo form_close(); ?>
                </div>  
         </section>
        
           <div class="clearfix"></div>
        </article>
        
        
     <div>
     	
     </div>   
        
