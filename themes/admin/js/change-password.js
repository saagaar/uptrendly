jQuery(document).ready(function($) {
	//Admin Change Password
	$("#changePasswordForm").validate({
		submitHandler: function(form) {		   
		   form.submit();
		},
		errorElement: "div",
		//errorClass: "form_validation_error",
		rules: {
			old_password: {
				required: true,
				minlength:6,
				maxlength:20								
			},
			new_password: {
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_new_password: {
				required: true,
				minlength:6,
				maxlength:20,
				equalTo: "#new_password"
			},							
		},
	});// Administrator Register validate
	
	
});