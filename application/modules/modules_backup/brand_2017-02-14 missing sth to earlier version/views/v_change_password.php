<div class="col-md-8 col-sm-7">
<div class="log-form">
    <?php if($this->session->flashdata('success_message')) { ?>
        <span class="text-success"><?php echo $this->session->flashdata('success_message'); ?></span>
    <?php  } elseif($this->session->flashdata('error_message')) { ?>
        <span class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></span>

    <?php  } ?>
	<form method="post" action="" enctype="multipart/form-data">
		<p class="pw_info">Please change your <b>Password</b> regularly. Do not use simple words. Use a combination of numbers, special characters, and upper and lower case letters.</p>
        			<div class="row">
					<div class="col-md-6 col-sm-12 form-group">
                    <label>Current Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>">
					<?php echo form_error('password'); ?>
					</div>
				 </div>
                 <div class="row">
                 	<div class="col-md-6 col-sm-12 form-group">
                    <label>New Password</label>
					<input type="password" name="new_password" class="form-control" value="<?php echo set_value('new_password'); ?>">
                    <?php echo form_error('new_password'); ?>

					</div>
                 </div>
                 <div class="row">
                    <div class="col-md-6 col-sm-12 form-group">
                    <label>Re-Type Password</label>
					<input type="password" name="re_new_password" class="form-control" value="<?php echo set_value('re_new_password'); ?>">
                    <?php echo form_error('re_new_password'); ?>
					</div>
                 </div>
        
       		<button type="submit" name="button" class="btn">Save</button>     
    </form>
</div>
        </div>