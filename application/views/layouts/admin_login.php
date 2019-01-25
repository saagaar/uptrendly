<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo base_url().ADMIN_IMG_DIR ?>fav.png">
    <title><?php echo $template['title']; ?></title>
    <link href="<?php echo base_url().ADMIN_CSS_DIR; ?>reset.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().ADMIN_CSS_DIR; ?>admin.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url().ADMIN_JS_DIR; ?>jquery.min.js" ></script>
    <script src="<?php echo base_url().ADMIN_JS_DIR; ?>jquery.validate-1.11.1.min.js" ></script>
    
    <script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin-forget.js" ></script>
	<script  type="text/javascript">
		$(document).ready(function(){	
		$(".loginbox").delegate(".load_new_captcha", "click", function() {
			$('#new_captcha_button').attr('src','<?php echo base_url().ADMIN_IMG_DIR; ?>loading_orange.gif');//show the loading image
			$.ajax({
					url : '<?php echo site_url('/login/password/reload');?>',
					cache : false,
					success : function(imageFromTheController){ //the success will not be executed until the server respond whith 200okk status
					   var newCaptcha = $('<span id="admin_captcha_container">'+imageFromTheController+'</span>');
					   $('#admin_captcha_container').replaceWith(newCaptcha);
						$('#new_captcha_button').attr('src','<?php echo base_url().ADMIN_IMG_DIR; ?>reload_orange.gif');
					}     
			});
			return false;	
		});	
	});
	</script>
    
</head>
    <body>
    	<div class="logo">
        	<img src="<?php echo base_url().ADMIN_IMG_DIR.'logo1.png'; ?>" alt="High Tree Group">
    	</div>
    
        <?php echo $template['body']; ?>
    </body>
