// JavaScript Document

//Add new address
$("#changePasswordBtn").click(function() {
    $("#changePasswordForm").validate({
		errorElement: 'p',
        errorClass: 'text-danger',
		//validClass:'success',

        highlight: function(element, errorClass, validClass) {
          	$(element).parents("div.form-group").addClass('has-error').removeClass('has-success');
		},

        unhighlight: function(element, errorClass, validClass) {
           	$(element).parents("div.form-group").removeClass('has-error');
		  	$(element).parents(".error").removeClass('has-error').addClass('has-success');
		},

        rules: {
			password: {
                required: true,
            },
			new_password: {
                required: true,
				minlength : 6
            },
			re_new_password: {
                required: true,
				equalTo: "#newPassword"
            },
		},

        messages: {
			password: {
                required: errorMessage.text_required,
            },
			new_password: {
                required: errorMessage.text_required,
				//minlength :errorMessage.text_required,
            },
			re_new_password: {
                required: errorMessage.text_required,
				equalTo : errorMessage.equalTo
            },
		},

		submitHandler: function(form) {
			jQuery.ajax({
				type: "POST",
				url: urlChangePassword,
				datatype: 'json',
				data: $('form#changePasswordForm').serialize(),
				beforeSend: function(){
					$('#changePasswordBtn').html('Processing...');
					$('#changePasswordBtn').attr('disabled',true);
				},
				success: function(json) {
					//console.log(json);
					data = jQuery.parseJSON(json);
					
					$('#changePasswordBtn').html('Change Password');
					$('#changePasswordBtn').removeAttr('disabled');
					
					if (data.status == 'success') {
						$('#changePasswordResponse').css('display','inline-block');
						$('#changePasswordResponse').removeClass('error').addClass('success');
						$('#changePasswordResponse').html(data.message);
						$("#signUpForm").trigger('reset');
							
						setTimeout(function(){
							//remove class and html contents
							$("#changePasswordResponse").html('');
							$("#changePasswordResponse").css("display", "none");
							//redirect to home page.
							window.location.href = site_url;
						},5000);
					} else {
						$('#changePasswordResponse').css('display','inline-block');
						$('#changePasswordResponse').removeClass('success').addClass('error');
						$('#changePasswordResponse').html(data.message);
					}
					
					setTimeout(function(){
						//remove class and html contents
						$("#changePasswordResponse").html('');
						$("#changePasswordResponse").css("display", "none");
					},5000);
				}
			});
			return false;
		}
    });
});