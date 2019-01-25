jQuery(document).ready(function ($) {

    jQuery.validator.addMethod("exactlength", function (value, element, param) {
        return this.optional(element) || value.length == param;
    }, jQuery.format("Please enter exact characters."));

    $('input[name=admin_username]').focus();

    //Seller Login
    $("#adminForgetForm").validate({
        submitHandler: function (form) {
            form.submit();
        },
        errorElement: "div",
        //errorClass: "form_validation_error",
        rules: {
            admin_email: {
                required: true,
               	email:true
            },
            admin_captcha: {
                required: true,
                exactlength: 8

            },

        },
        messages: {
            admin_email: {
            	required: "Email is required",
				email: "Please enter a valid Email address",
            	},
            captcha_code: {
                exactlength: "Invalid Verification Code",
                required: "Verification Code is Required",
            	}
        	},
        errorPlacement: function (error, element) {
            if (element.attr("name") == "admin_captcha") {
                error.appendTo($('#admincapcha_error_container'));
            } else {
                error.insertAfter(element);
            }
        }


    }); //seller Login validate



    /*//Investor Login
    $("#investorLoginForm").validate({
        submitHandler: function (form) {
            form.submit();
        },
        errorElement: "div",
        //errorClass: "form_validation_error",
        rules: {
            investor_e: {
                required: true,
                minlength: 2,
                maxlength: 50,
                email: true
            },
            investor_p: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            captcha_code_investor: {
                required: true,
                exactlength: 8

            },

        },
        messages: {

            investor_e: {
                minlength: "Invalid Email Address",
                maxlength: "Invalid Email Address",
                email: "Invalid Email Address",
                required: "Email Address is required",
            },
            investor_p: {
                minlength: "Invalid Password",
                maxlength: "Invalid Password",
                required: "Password is required",
            },
            captcha_code_investor: {
                exactlength: "Invalid Verification Code",
                required: "Verification Code is Required",
            }
        },

    }); //Investor Login validate*/
});