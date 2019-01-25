
<div class="col-md-8 col-sm-7">
          <div class="log-form">
			<h4>User Settings</h4>
			
<form action="" method="post" accept-charset="utf-8">	
	<fieldset>
	 	<?php if($this->session->flashdata('success_message')) {?>
	        <span class="text-success"><?php echo $this->session->flashdata('success_message'); ?></span>
	    <?php } else if($this->session->flashdata('error_message')) { ?>
	        <span class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></span>
	    <?php } ?>
		<?php if($settings) { ?>
		<table class="table demo footable">
			<thead>
				<tr>
					<th>#</th>
					<th>Subject</th>
					<th>Send Email</th>		
					<th>Send SMS</th>	
				</tr>
			</thead>
			<tbody>
			<?php foreach($settings as $set): ?>
				<tr>
					<td><?php echo $set['email_template_id']; ?></td>
					<td><?php echo $set['subject']; ?></td>
					<?php 
					$email_status = '';

					if($set['email_send_user']==1){
						$email_status ='checked = "checked"';
					}

					if($set['email_send_admin']==0){
						$email_status = 'disabled = "disabled"';
					}
					?>
					<td>
					<input type="hidden" name="email_notification[<?php echo $set['email_template_id']; ?>]" value='0'>

					<input type="checkbox" name="email_notification[<?php echo $set['email_template_id']; ?>]" <?php echo $email_status; ?> value='1'>
					</td>

					<?php 
					$sms_status = '';
					
					if($set['sms_send_user']==1){
						$sms_status ='checked = "checked"';
					}
					if($set['sms_send_admin']==0){
						$sms_status = 'disabled = "disabled"';
					}
					?>
					<td>
					<input type="hidden" name="sms_notification[<?php echo $set['email_template_id']; ?>]" value='0'>

					<input type="checkbox" name="sms_notification[<?php echo $set['email_template_id']; ?>]" <?php echo $sms_status ;?> value='1'>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<div class="btn-sec"><button type="submit" name="button" class="btn">Submit</button></div>
		</fieldset>
		<?php } else { ?>
			No user notification setting options available
		<?php } ?>
	</form>
	<div class="clearfix"></div>
    </div>
</div>