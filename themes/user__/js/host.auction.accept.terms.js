// JavaScript Document
$("#acceptTermsBtn").click(function() {
    $("#acceptTermsForm").validate({
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
			accept: {
                required: true,
			},
		},

        messages: {
			message: {
                required: errorMessage.text_required,
			},
		},

        submitHandler: function(form) {

            jQuery.ajax({
                type: "POST",
                url: urlAcceptTerms,
                datatype: 'json',
                data: $('form#acceptTermsForm').serialize(),
                beforeSend: function() {
                    $('#acceptTermsBtn').html('Processing...');
                    $('#acceptTermsBtn').attr('disabled', true);
                },
                success: function(json) {
                    data = jQuery.parseJSON(json);
                    console.log(data);
                    $('#acceptTermsBtn').html('Process');
                    $('#acceptTermsBtn').removeAttr('disabled');
                    if (data.status == 'success') {
                    	//reset teh form
                        $("#acceptTermsForm").trigger('reset');
						
						//add error success message and hide popup
                        setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
							$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
							$('#errorSuccessMesage').html(data.message);
							
							//hide bootstrap modal
							$('#acceptTermsPopup').modal('toggle');
							
							//redirect to page if success
							window.location = urlAddCoHostAuctions;
                        }, 1000);
						
                    } else {
						
						setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
                       	 	$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
                       	 	$('#errorSuccessMesage').html(data.message);
							
							//hide bootstrap modal
							$('#acceptTermsPopup').modal('toggle');
                        }, 1000);
					}

                    setTimeout(function() {
                        //remove class and html contents
                        $("#errorSuccessMesage").html('');
                        $("#errorSuccessMesageArea").css("display", "none");
                    }, 15000);
                }
            });
            return false;
        }
    });
});