jQuery(document).ready(function($) {
	jQuery.validator.addMethod("exactlength", function(value, element, param) {
	 return this.optional(element) || value.length == param;
	}, jQuery.format("Please enter exact characters."));
	
	
	
	
	//Seller Login
	$("#adminRegisterForm").validate({
		submitHandler: function(form) {		   
		   form.submit();
		},
		errorElement: "div",
		//errorClass: "form_validation_error",
		rules: {
			user_name: {
				required: true,
				minlength:6,
				maxlength:100,
				//alphanumeric:true,								
			},
			email: {
				required: true,
				email:true
			},
			user_type: {
				required: true,
			},
			status: {
				required: true,
			},
			password: {
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_password: {
				required: true,
				minlength:6,
				maxlength:20,
				equalTo: "#password"
			},	
		},
		
	});// Administrator Register validate




	$('#change_password').click(function() {
		if( $(this).is(':checked')) {
			$("#adminPasswordContainer").show();
		} else {
			$("#adminPasswordContainer").hide();
		}
	}); 




});