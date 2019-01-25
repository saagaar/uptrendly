//Sign up form validation
// 
$(function(){
  jQuery.validator.addMethod("username", function(value, element) {
  return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
}, "Please enter valid username");  


   jQuery.validator.addMethod("contactno", function(value, element) {
  return this.optional(element) || /^[0-9+-\s]+$/.test(value);
}, "Please enter valid Contact number"); 
})


    $("#btnBuyerRegistration,#btnSupplierRegistration").click(function() {
     // var timeoutID = window.setTimeout(code, [delay]);
     // e.preventDefault();
     var cur=$(this);

     if(cur.hasClass('disabledbtn'))
     {
        return false;
     }
     else{


       cur.addClass('disabledbtn');
       
       $("#buyer_registration_form,#supplier_registration_form").validate({
        // alert('asd');
            errorElement: 'span',
			errorClass:'text-danger',
			//validClass:'success',
			  
			highlight: function (element, errorClass, validClass) { 
                
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			
			unhighlight: function (element, errorClass, validClass) { 
                cur.removeClass('disabledbtn');
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
			
            rules: {
				first_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                last_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
				email: {
                    required: true,
                    email: true,
					checkDuplicateEmail : true,
                    minlength: 2,
                    maxlength: 50
                },
                phone: {
                    required: true,
                    contactno:true,
                    minlength: 4,
                    maxlength: 50
                },
                username: {
                	required: true,
                	checkDuplicateUsername : true,
                    username:true,
                    minlength: 6,
                    maxlength: 20
                    

                },
                password: {
                    required: true,
					minlength: 6,
					maxlength: 20
                },
                terms_conditions: {
                	required: true
                }
            },

            messages: {
				first_name: {
                    required: errorMessage.required,
                },
                last_name: {
                    required: errorMessage.required,
                },
                phone: {
                    required: errorMessage.required,
                },
                email: {
                    required: errorMessage.required,
                    email: errorMessage.email,
					checkDuplicateEmail : errorMessage.duplicateEmail
                },
                username: {
                	required: errorMessage.required,
					checkDuplicateUsername : errorMessage.usernameExist

                },
                password: {
                    required: errorMessage.required,
					minlength: errorMessage.minlength,
					maxlength: errorMessage.maxlength,
                },
                terms_conditions: {
                	required: errorMessage.terms_conditions,
                }
            },
            submitHandler: function(form) {
                 cur.addClass('disabledbtn');
				form.submit();
                // success:function(){

                //    cur.removeClass('disabledbtn');
                // }
            	// return false;
        	}
        });

 
 }
// alert('asd');
    });
	
	//contact us form validation
 $("#btnctactform").click(function() {
 
        $("#contact_forms").validate({
        
            errorElement: 'span',
			errorClass:'text-danger',
			//validClass:'success',
			  
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			
			unhighlight: function (element, errorClass, validClass) { 
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
			
            rules: {
				name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
               
				email: {
                    required: true,
                    email: true,
                    minlength: 2,
                    maxlength: 50
                },
                contactno: {
                    required: true,
                    contactno:true,
                    minlength: 2,
                    maxlength: 50
                },
               
               
                message: {
                	required: true,
                    minlength: 50,
                    maxlength: 250

                }
            },

            messages: {
				name: {
                    required: errorMessage.required,
                },
                email: {
                    required: errorMessage.required,
                    email: errorMessage.email,
                },
                contactno: {
                	required: errorMessage.required
					
                },
                message: {
                    required: errorMessage.required,
					
                },
                
            },
            submitHandler: function(form) {
				form.submit();
            	// return false;
        	}
        });
    });

    //signup form validation ends here	

    $("#signInBtn").click(function() {
        $("#signInForm").validate({

            errorElement: 'p',
			errorClass:'text-danger',
			//validClass:'success',
			  
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			
			unhighlight: function (element, errorClass, validClass) { 
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
			
            rules: {
				email: {
                    required: true,
                    email: true,
					//checkEmailExistence : true
                },
				password: {
					required:true,
				}
            },

            messages: {
				email: {
                    required: errorMessage.required,
                    email: errorMessage.email,
					//checkEmailExistence : errorMessage.emailDoesnotExist
                },
                password: {
                    required: errorMessage.required,
                },
            },

            submitHandler: function(form) {

                jQuery.ajax({
                    type: "POST",
                    url: urlUserLogin,
                    datatype: 'json',
                    data: $('form#signInForm').serialize(),
					beforeSend: function(){ 
						$('#signInBtn').html('Signing In');
						$('#signInBtn').attr('disabled',true);
					},
					success: function(json) {
						data = jQuery.parseJSON(json);
						
						$('#signInBtn').html('Sign In');
						$('#signInBtn').removeAttr('disabled');
						
                        if (data.status == 'success') {
							$('#loginRegisterResponse').css('display','inline-block');
							$('#loginRegisterResponse').removeClass('error').addClass('success');
							$('#loginRegisterResponse').html(data.message);
							$("#signInForm").trigger('reset');
							
							setTimeout(function(){
								//remove class and html contents
								$("#loginRegisterResponse").html('');
								$("#loginRegisterResponse").css("display", "none");
								//redirect to users my account
								//window.location.href = site_url;
								//window.location.href = site_url + 'my-account/user/index';
								window.location.href = data.return_url;
							},3000);
						} else {
                           	$('#loginRegisterResponse').css('display','inline-block');
							$('#loginRegisterResponse').removeClass('success').addClass('error');
							$('#loginRegisterResponse').html(data.message);
						}
						
						setTimeout(function(){
							//remove class and html contents
							$("#loginRegisterResponse").html('');
							$("#loginRegisterResponse").css("display", "none");
						},3000);
					}
                });
                return false;
            }
        });
    });	
	
	//contact us form validation
    $("#forgotPasswordBtn").click(function() {
		//console.log('forgotPasswordBtn');
		
        $("#forgotPasswordForm").validate({
			
            errorElement: 'p',
			errorClass:'text-danger',
			//validClass:'success',
			  
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			
			unhighlight: function (element, errorClass, validClass) { 
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
			
            rules: {
				email: {
                    required: true,
                    email: true,
					//checkEmailExistence : true
                }
            },

            messages: {
				email: {
                    required: errorMessage.required,
                    email: errorMessage.invalid_email,
					//checkEmailExistence : errorMessage.emailDoesnotExist
                },
            },

            submitHandler: function(form) {

                jQuery.ajax({
                    type: "POST",
                    url: urlForgotPassword,
                    datatype: 'json',
                    data: $('form#forgotPasswordForm').serialize(),
					beforeSend: function(){ 
						$('#forgotPasswordBtn').html('Resetting Password');
						$('#forgotPasswordBtn').attr('disabled',true);
					},
					success: function(json) {
						data = jQuery.parseJSON(json);
						
						$('#forgotPasswordBtn').html('Reset Password');
						$('#forgotPasswordBtn').removeAttr('disabled');
						
                        if (data.status == 'success') {
                            $('#loginRegisterResponse').css('display','inline-block');
							$('#loginRegisterResponse').removeClass('error').addClass('success');
							$('#loginRegisterResponse').html(data.message);
							
                     	} else {
                           	$('#loginRegisterResponse').css('display','inline-block');
							$('#loginRegisterResponse').removeClass('success').addClass('error');
							$('#loginRegisterResponse').html(data.message);
						}
						
						setTimeout(function(){
							//remove class and html contents
							$("#loginRegisterResponse").html('');
							$("#loginRegisterResponse").css("display", "none");
						},3000);
					}
                });
                return false;
            }
        });
    });
