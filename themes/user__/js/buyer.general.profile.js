$(function(){
    $(document).on('change','#profile_picture',function(){
        // alert('yes we are here');
     
        var formData = new FormData($('#changeprofileform')[0]);
        $('.profileloader').show();
        $.ajax({
                url: ChangeProfileUrl,
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                dataType:'json',
                success: function(data, textSatus, jqXHR){
                    if(data.success)
                    {
                        $('#pp').attr('src',data.finalimg);
                        $('.profileloader').hide();
                        $('#profile_picture').val('');
                           $('.msg').html(data.success);
                        window.setTimeout(function(){
                            $('.msg').html(''); 
                         },3000);
                      
                        
                        //now get here response returned by PHP in JSON fomat you can parse it using JSON.parse(data)
                    }
                    else{
                         $('.msg').html('<div class="error text-danger">'+data.error+'</div>');
                          $('.profileloader').hide();
                         window.setTimeout(function(){
                             $('.msg').html(''); 

                         },3000);
                       }
                },
                error: function(jqXHR, textStatus, errorThrown){
                      $('.msg').html('<div class="error text-danger">Some unusual error occured</div>');
                      $('.profileloader').hide();
                         window.setTimeout(function(){
                             $('.msg').html(''); 
                         },3000);
                }
        });
    })
})


// JavaScript Document
$("#editBuyerProfileBtn").click(function() {
    $("#editBuyerProfileForm").validate({
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
            about_user: {
                required: true,
            },
            address:{
                required: true,
            },
            phone: {
                required: true,
			},
			city: {
				required: true,
			},
			country : {
				required: true,
			},
            state: {
                required: true,
            },
            post_code: {
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
            about_user: {
                required: errorMessage.required,
            },
            address:{
                required: errorMessage.required,
            },
            phone: {
                required: errorMessage.required,
            },
			city: {
				required: errorMessage.required,
			},
			country : {
				required: errorMessage.required,
			},
            state: {
                required: errorMessage.required,
            },
            post_code: {
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