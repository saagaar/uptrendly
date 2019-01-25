<script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin-add-edit.js" ></script>

<section class="title">
  <div class="wrap">
   <?php /*?> <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; <?php if($current_menu == 'edit') {echo "Edit";} else echo "Add"; ?> Administrator</h2><?php */?>
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Admins  Management </h2>
  </div>
</section>

<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    <section class="smfull">
      <?php
		if(validation_errors() != '' || $this->session->flashdata('message') != '')
		{
	  	?>
      	<div class="confrmmsg">
        <?php
			if(validation_errors() != ''){
				//echo '<p>'.validation_errors().'</p>'; 
			}
			if($this->session->flashdata('message') != ''){
				echo '<p>'.$this->session->flashdata('message').'</p>';
			} 
		?>
      </div>
      <?php
		}
	  ?>
      <div class="box_block"> <?php echo form_open('',array('id' => 'adminRegisterForm','autocomplete' => 'off')); ?>
        <fieldset>
          <div class="title_h3">Administrator Login</div>
          <ul class="frm">
            <li>
              <div>
                <label>Username <span>*</span> : </label>
                <input name="username" type="text" value="<?php echo set_value('username',$admin_default['username']);?>">
                <?php echo form_error('username'); ?> </div>
            </li>
            <li>
              <label>Email <span>*</span> : </label>
              <input name="email" type="text" value="<?php echo set_value('email',$admin_default['email']); ?>">
              <?php echo form_error('email'); ?>
           </li>
         
            <li>
              <label>Select User Type <span>*</span> :</label>
              <?php $admin_type =  set_value('user_type',$admin_default['user_type']);?>
              <select name="user_type" id="user_type">
              	<option value="">Select Admin Type</option>
                <option value="1" <?php if($admin_type == '1'){ echo 'selected="selected"';}?> >Super Admin</option>
              	<option value="2" <?php if($admin_type == '2'){ echo 'selected="selected"';}?> >Admin</option>
              </select>
              <?php echo form_error('role_id'); ?> </li>
            <li>
              <label>Status <span>*</span> : </label>
              <?php $status_selected =  set_value('status',$admin_default['status']);?>
              <select name="status">
              	<option value="">Select Status</option>
                <option value="1" <?php if($status_selected == '1'){ echo 'selected="selected"';}?> >Active</option>
                <option value="2" <?php if($status_selected == '2'){ echo 'selected="selected"';}?> >Inactive</option>
                <option value="3" <?php if($status_selected == '3'){ echo 'selected="selected"';}?> >Suspended</option>
                <option value="4" <?php if($status_selected == '4'){ echo 'selected="selected"';}?> >Closed</option>
              </select>
              <?php echo form_error('status'); ?> </li>
            <?php if($current_menu == 'edit'):?>
            <li>
              <label>
                <input name="change_password" id="change_password" type="checkbox" value="change_password" />
                <i>Want to change Password? </i></label>
            </li>
            <?php endif; ?>
          </ul>
        </fieldset>
        <div id="adminPasswordContainer" <?php if($current_menu == 'edit'){ echo 'style="display:none;"'; }?>>
          <fieldset>
            <div class="title_h3">Administrator Password</div>
            <ul class="frm">
              <li>
                <label>Password <span>*</span> : </label>
                <input name="password" id="password" type="password" value="">
                <?php echo form_error('password'); ?> </li>
              <li>
                <label>Confirm Password <span>*</span> : </label>
                <input name="confirm_password" id="confirm_password" type="password" value="">
                <?php echo form_error('confirm_password'); ?> </li>
            </ul>
          </fieldset>
        </div>
        <fieldset class="btn">
          <button type="submit" class="butn">Submit</button>
          <input type="hidden" name="id" value="<?php echo $admin_default['id'];?>" />
        </fieldset>
        <?php echo form_close(); ?> </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
