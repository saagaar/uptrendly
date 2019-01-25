<div class="login-signup">
	
            	
                <div class="bodysec">
                <header>Reset your Password</header>
                	<?php echo form_open(EXEADMIN_PUBLIC_DIR.'/password/reset'.'/?key='.urlencode($activation_key).'&auth='.urlencode($encoded_user),array('id' => 'adminResetForm','autocomplete' => 'off'));  ?>
                    	<fieldset>
                        	<?php if($message): ?>
                            <div  class="message">
                            	<p><?php echo $message; ?></p>
                            </div>
                            <?php endif; ?>
                        	<ul>
                            <li>
                            	<label>New Password: </label>
                                <input name="admin_password" id="admin_password" type="password">
                                <?php echo form_error('admin_password'); ?>
                                
                            </li>
                             <li>
                            	<label>Confirm Password: </label>
                                <input name="admin_confirm" id="admin_confirm" type="password">
                                 <?php echo form_error('admin_confirm'); ?>
                            </li>
                             <li>
                            	<a href="<?php echo site_url(EXEADMIN_PUBLIC_DIR.'');?>" class="frgt">Login</a>
                                <button type="submit"  >Change Password</button>     
                            </li>
                            
                            </ul>
                        </fieldset>
                        
                    <?php echo form_close(); ?>
                  <footer>
                	© 2013 <a href="<?php echo site_url();?>">ENTREXCHANGE</a>. ALL RIGHTS RESERVED.
                </footer>
                </div>
             
             
</div>