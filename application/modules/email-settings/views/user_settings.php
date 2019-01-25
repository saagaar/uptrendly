<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>test</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<form action="" method="post" accept-charset="utf-8">	
		<table cellspacing="30">
			<caption>User Settings</caption>
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
		<input type="submit" value="submit">
	</form>
</body>
</html>