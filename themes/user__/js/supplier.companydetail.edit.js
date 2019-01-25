// JavaScript Document
$("#conpanyDetailEditBtn").click(function() {
    $("#companyDeatailForm").validate({
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
            first_name: {
                required: true,
			},
            last_name: {
                required: true,
            },
			email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
			},
			city: {
				required: true,
			},
			company_country: {
				required: true,
			},
            company_website: {
                required: true,
                url: true,
            },
            company_name: {
                required: true,
            },
            company_address1: {
                required: true,
            },
            company_city: {
                required: true,
            },
            company_state: {
                required: true,
            },
            company_zipcode: {
                required: true,
            },
            company_phone: {
                required: true,
            },
            description: {
                required: true,
            }
        },

        messages: {
            first_name: {
                required: errorMessage.required,
            },
            last_name: {
                required: errorMessage.required,
            },
            email: {
                required: errorMessage.required,
                email: errorMessage.email,
            },
            phone: {
                required: errorMessage.required,
            },
            city: {
                required: errorMessage.required,
            },
            company_country: {
                required: errorMessage.required,
            },
            company_website: {
                required: errorMessage.required,
                url: errorMessage.validURL,
            },
            company_name: {
                required: errorMessage.required,
            },
            company_address1: {
                required: errorMessage.required,
            },
            company_city: {
                required: errorMessage.required,
            },
            company_state: {
                required: errorMessage.required,
            },
            company_zipcode: {
                required: errorMessage.required,
            },
            company_phone: {
                required: errorMessage.required,
            },
            description: {
                required: errorMessage.required,
            }
        },

        submitHandler: function(form) {
			form.submit();
            return false;
        }
    });
});