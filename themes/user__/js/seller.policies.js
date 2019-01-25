// JavaScript Document
$("#sellerPoliciesBtn").click(function() {	
	$("#sellerPoliciesForm").validate({
		errorElement: 'p',
        errorClass: 'text-danger',
       // onkeyup: false,
        highlight: function(element, errorClass, validClass) {
          	$(element).parents("div.form-group").addClass('has-error').removeClass('has-success');
		},

        unhighlight: function(element, errorClass, validClass) {
           	$(element).parents("div.form-group").removeClass('has-error');
		  	$(element).parents(".error").removeClass('has-error').addClass('has-success');
		},
		errorPlacement: function(error, element) {
			if (element.attr("type") == "checkbox") 
				error.insertAfter(element.parent().siblings().last());
			else
				error.insertAfter(element);
		},
		submitHandler: function(form) {
			form.submit();
		},
        rules: {
			facebook_url: {
               url: true,
			},
			twitter_url: {
               url: true,
			},
			pinterest_url: {
               url: true,
			},
			seller_bio: {
                required: true,
				maxlength :300,
            },
            buyer_pay_days: {
                required: true,
            },
            seller_ship_days: {
                required: true,
            },
            refund_days: {
                required: true,
            },
            'refund_criteria[]': {
                required: true,
            }
        },

        messages: {
			facebook_url: {
               	url: errorMessage.validURL,
			},
			twitter_url: {
              	url: errorMessage.validURL,
			},
			pinterest_url: {
              	url: errorMessage.validURL,
			},
            seller_bio: {
                required: errorMessage.text_required,
				maxlength :errorMessage.maxlength,
            },
            buyer_pay_days: {
                required: errorMessage.text_required,
            },
            seller_ship_days: {
                required: errorMessage.text_required,
            },
            refund_days: {
                required: errorMessage.text_required,
            },
           'refund_criteria[]': {
                required: errorMessage.textAtLeastOne,
            }
        }, 
    });
});