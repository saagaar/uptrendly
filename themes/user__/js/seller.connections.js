// JavaScript Document
$("#referBtn").click(function() {
	$("#referForm").validate({
		errorElement: 'p',
        errorClass: 'text-danger',
        onkeyup: false,
        highlight: function(element, errorClass, validClass) {
          	$(element).parents("div.form-group").addClass('has-error').removeClass('has-success');
		},

        unhighlight: function(element, errorClass, validClass) {
           	$(element).parents("div.form-group").removeClass('has-error');
		  	$(element).parents(".error").removeClass('has-error').addClass('has-success');
		},

        rules: {
            'email[]': {
                required: true,
                email: true,
            },
            message: {
                required: true,
            },
        },

        messages: {
            'email[]': {
                required: errorMessage.text_required,
                email: errorMessage.text_invalid_email,
            },
            message: {
                required: errorMessage.text_required,
            },
        },

        submitHandler: function(form) {
			form.submit();	
		}
    });
});