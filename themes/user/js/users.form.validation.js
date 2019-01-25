//Sign up form validation

// 

// $(function(){

//   jQuery.validator.addMethod("username", function(value, element) {

//   return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);

// }, "Please enter valid username");  

//    jQuery.validator.addMethod("contactno", function(value, element) {

//   return this.optional(element) || /^[0-9+-\s]+$/.test(value);

// }, "Please enter valid Contact number"); 
//  });
$("#creator_registration").click(function(e) {
    // e.preventDefault();

       $("#creatorsignup").validate({
            errorElement: 'span',
			errorClass:'text-danger',
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
                    checkDuplicateEmail:true,
                    minlength: 2,
                    maxlength: 50
                },
                username: {
                    required: true,
                    minlength: 2,
                    checkDuplicateUsername:true,
                    maxlength: 50
                },
                password: {
                    required: true,
					minlength: 6,
					maxlength: 20
                },
                instagram_username: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                facebook_profile: {
                    required: true,
                    minlength: 6,
                    maxlength: 200
                }
            },
            messages: {
				name: {
                    required: errorMessage.required,
                },

                email: {
                    required: errorMessage.required,
                    email: errorMessage.email,
			 		checkDuplicateEmail : errorMessage.duplicateEmail,
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,

                },
                 username: {
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,
                    required: errorMessage.required,
                    checkDuplicateUsername : errorMessage.duplicateUsername

                },

                password: {
                    required: errorMessage.required,
    				minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                }
            },

            submitHandler: function(form) {
                 
				form.submit();
        	}

        });
});


$("#brandregbtn").click(function(e) {
 
       $("#brand_registration").validate({
            errorElement: 'span',
			errorClass:'text-danger',
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
            rules: {
            	brand_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
				brand_url: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
				email: {
                    required: true,	
                    email: true,
                    minlength:2,
                    maxlength:200,
                    checkDuplicateEmail:true    
                },
				phone: {
                    required: true
                   
                },
                username: {
                    required: true, 
                    minlength:5,
                    maxlength:200,
                    urlCheckDuplicateUsername:true
                },
                password: {
                    required: true,
					minlength: 6,
					maxlength: 50
                },
                cpassword: {
                    required: true,
					minlength: 6,
					maxlength: 50,
                    equalTo:'#password'
                }
            },
            messages: {
            	brand_name: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,

                },
                brand_url: {
                   required: errorMessage.required,
                   
                },
                
				name: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },

                email: {
                    required: errorMessage.required,
                    email: errorMessage.email,
			 		checkDuplicateEmail : errorMessage.duplicateEmail,
			 		minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,

                },
                 username: {
                    required: errorMessage.required,
                    checkDuplicateUsername : errorMessage.duplicateUsername,
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,

                },

                password: {
                    required: errorMessage.required,
    				minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                }
            },

            submitHandler: function(form) {
                 
				form.submit();
        	}

        });
});

$("#youtuleeregbtn").click(function(e) {

       $("#registrationyoutulee").validate({
            errorElement: 'span',
			errorClass:'text-danger',
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
                    checkDuplicateEmail:true,
                    minlength: 2,
                    maxlength: 200
                },
                password: {
                    required: true,	
                    minlength: 2,
                    maxlength: 50
                },
				
                youtulee_id: {
                    required: true,
					minlength: 2,
					maxlength: 50
                },
                username: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
                    checkDuplicateUsername:true
                },
               
				
                 total_reach: {
                    required: true,
                    integer:true,
					
                },
                 average_reach: {
                    required: true,
					integer:true
                },
                 country: {
                    required: true,
					
                },
                  ratings: {
                   
					integer:true
                }
            },
            messages: {
            	name: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,

                },
                email: {
                    required: errorMessage.required,
                    email: errorMessage.email,
			 		checkDuplicateEmail : errorMessage.duplicateEmail,
			 		minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,

                },

                password: {
                    required: errorMessage.required,
    				minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },
               
                 youtulee_id: {
                    required: errorMessage.required,
            		minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,

                },
                 username: {
                    required: errorMessage.required,
                    checkDuplicateUsername : errorMessage.duplicateUsername,
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,

                },
                
                total_reach: {
                    required: errorMessage.required,
    				
                },
                 average_reach: {
                    required: errorMessage.required,
                   
			 		//checkDuplicateEmail : errorMessage.duplicateEmail,

                },

                country: {
                    required: errorMessage.required,
    				
                },
                ratings: {
                    required: errorMessage.required,
    			
                },

            },

            submitHandler: function(form) {
                 
				form.submit();
        	}

        });
});


	

	//contact us form validation

 // $("#btnctactform").click(function() {

 

 //        $("#contact_forms").validate({

        

 //            errorElement: 'span',

	// 		errorClass:'text-danger',

	// 		//validClass:'success',

			  

	// 		highlight: function (element, errorClass, validClass) { 

	// 		  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 

	// 		}, 

			

	// 		unhighlight: function (element, errorClass, validClass) { 

	// 			$(element).parents("div.form-group").removeClass('has-error'); 

	// 			$(element).parents(".error").removeClass('has-error').addClass('has-success'); 

	// 		},

			

 //            rules: {

	// 			name: {

 //                    required: true,

 //                    minlength: 2,

 //                    maxlength: 50

 //                },

               

	// 			email: {

 //                    required: true,

 //                    email: true,

 //                    minlength: 2,

 //                    maxlength: 50

 //                },

 //                contactno: {

 //                    required: true,

 //                    contactno:true,

 //                    minlength: 2,

 //                    maxlength: 50

 //                },

               

               

 //                message: {

 //                	required: true,

 //                    minlength: 50,

 //                    maxlength: 250



 //                }

 //            },



 //            messages: {

	// 			name: {

 //                    required: errorMessage.required,

 //                },

 //                email: {

 //                    required: errorMessage.required,

 //                    email: errorMessage.email,

 //                },

 //                contactno: {

 //                	required: errorMessage.required

					

 //                },

 //                message: {

 //                    required: errorMessage.required,

					

 //                },

                

 //            },

 //            submitHandler: function(form) {

	// 			form.submit();

 //            	// return false;

 //        	}

 //        });

 //    });



 //    //signup form validation ends here	



 //    $("#signInBtn").click(function() {

 //        $("#signInForm").validate({



 //            errorElement: 'p',

	// 		errorClass:'text-danger',

	// 		//validClass:'success',

			  

	// 		highlight: function (element, errorClass, validClass) { 

	// 		  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 

	// 		}, 

			

	// 		unhighlight: function (element, errorClass, validClass) { 

	// 			$(element).parents("div.form-group").removeClass('has-error'); 

	// 			$(element).parents(".error").removeClass('has-error').addClass('has-success'); 

	// 		},

			

 //            rules: {

	// 			email: {

 //                    required: true,

 //                    email: true,

	// 				//checkEmailExistence : true

 //                },

	// 			password: {

	// 				required:true,

	// 			}

 //            },



 //            messages: {

	// 			email: {

 //                    required: errorMessage.required,

 //                    email: errorMessage.email,

	// 				//checkEmailExistence : errorMessage.emailDoesnotExist

 //                },

 //                password: {

 //                    required: errorMessage.required,

 //                },

 //            },



 //            submitHandler: function(form) {



 //                jQuery.ajax({

 //                    type: "POST",

 //                    url: urlUserLogin,

 //                    datatype: 'json',

 //                    data: $('form#signInForm').serialize(),

	// 				beforeSend: function(){ 

	// 					$('#signInBtn').html('Signing In');

	// 					$('#signInBtn').attr('disabled',true);

	// 				},

	// 				success: function(json) {

	// 					data = jQuery.parseJSON(json);

						

	// 					$('#signInBtn').html('Sign In');

	// 					$('#signInBtn').removeAttr('disabled');

						

 //                        if (data.status == 'success') {

	// 						$('#loginRegisterResponse').css('display','inline-block');

	// 						$('#loginRegisterResponse').removeClass('error').addClass('success');

	// 						$('#loginRegisterResponse').html(data.message);

	// 						$("#signInForm").trigger('reset');

							

	// 						setTimeout(function(){

	// 							//remove class and html contents

	// 							$("#loginRegisterResponse").html('');

	// 							$("#loginRegisterResponse").css("display", "none");

	// 							//redirect to users my account

	// 							//window.location.href = site_url;

	// 							//window.location.href = site_url + 'my-account/user/index';

	// 							window.location.href = data.return_url;

	// 						},3000);

	// 					} else {

 //                           	$('#loginRegisterResponse').css('display','inline-block');

	// 						$('#loginRegisterResponse').removeClass('success').addClass('error');

	// 						$('#loginRegisterResponse').html(data.message);

	// 					}

						

	// 					setTimeout(function(){

	// 						//remove class and html contents

	// 						$("#loginRegisterResponse").html('');

	// 						$("#loginRegisterResponse").css("display", "none");

	// 					},3000);

	// 				}

 //                });

 //                return false;

 //            }

 //        });

 //    });	

	

	// //contact us form validation

 //    $("#forgotPasswordBtn").click(function() {

	// 	//console.log('forgotPasswordBtn');

		

 //        $("#forgotPasswordForm").validate({

			

 //            errorElement: 'p',

	// 		errorClass:'text-danger',

	// 		//validClass:'success',

			  

	// 		highlight: function (element, errorClass, validClass) { 

	// 		  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 

	// 		}, 

			

	// 		unhighlight: function (element, errorClass, validClass) { 

	// 			$(element).parents("div.form-group").removeClass('has-error'); 

	// 			$(element).parents(".error").removeClass('has-error').addClass('has-success'); 

	// 		},

			

 //            rules: {

	// 			email: {

 //                    required: true,

 //                    email: true,

	// 				//checkEmailExistence : true

 //                }

 //            },



 //            messages: {

	// 			email: {

 //                    required: errorMessage.required,

 //                    email: errorMessage.invalid_email,

	// 				//checkEmailExistence : errorMessage.emailDoesnotExist

 //                },

 //            },



 //            submitHandler: function(form) {



 //                jQuery.ajax({

 //                    type: "POST",

 //                    url: urlForgotPassword,

 //                    datatype: 'json',

 //                    data: $('form#forgotPasswordForm').serialize(),

	// 				beforeSend: function(){ 

	// 					$('#forgotPasswordBtn').html('Resetting Password');

	// 					$('#forgotPasswordBtn').attr('disabled',true);

	// 				},

	// 				success: function(json) {

	// 					data = jQuery.parseJSON(json);

						

	// 					$('#forgotPasswordBtn').html('Reset Password');

	// 					$('#forgotPasswordBtn').removeAttr('disabled');

						

 //                        if (data.status == 'success') {

 //                            $('#loginRegisterResponse').css('display','inline-block');

	// 						$('#loginRegisterResponse').removeClass('error').addClass('success');

	// 						$('#loginRegisterResponse').html(data.message);

							

 //                     	} else {

 //                           	$('#loginRegisterResponse').css('display','inline-block');

	// 						$('#loginRegisterResponse').removeClass('success').addClass('error');

	// 						$('#loginRegisterResponse').html(data.message);

	// 					}

						

	// 					setTimeout(function(){

	// 						//remove class and html contents

	// 						$("#loginRegisterResponse").html('');

	// 						$("#loginRegisterResponse").css("display", "none");

	// 					},3000);

	// 				}

 //                });

 //                return false;

 //            }

 //        });

 //    });

