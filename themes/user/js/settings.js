//Sign up form validation

// 

$(function(){

$(document).on('click','.copytextbtn',function(){
     var $temp = $("<input>");
     var id=$(this).data('type');

      $("body").append($temp);
      $temp.val($('#'+id).text()).select();
      document  .execCommand("copy");
      $temp.remove();
})
 jQuery.validator.addMethod("checkhyperlink", function(value, element) {
  return this.optional(element) || /(^|\s)((http(s)?:\/\/)|(www.\S))/.test(value);
}, "Hyperlink is required(add http:// or www to your link)"); 
//   jQuery.validator.addMethod("username", function(value, element) {

//   return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);

// }, "Please enter valid username");  

//    jQuery.validator.addMethod("contactno", function(value, element) {

//   return this.optional(element) || /^[0-9+-\s]+$/.test(value);

// }, "Please enter valid Contact number"); 
 });
$(document).on('click',"#generalsettingbtn",function(e) {
 
       $("#generalsettingform").validate({
            errorElement: 'span',
			errorClass:'text-danger',
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			  $('.generalsettings').removeClass('hidden');
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
				// $('.generalsettings').removeClass('hidden');
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
                    maxlength: 300,
                    checkhyperlink:true
                },
      first_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
					
                 },
      last_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
          
                 },
      age:      {
                    required: true,
                    number:true
          
                 },
      gender:   {
                    required: true,
                 
          
                  },
     
      'profession[]': {
                    required: true,
                 
          
                  },
      'usercategory[]': 
                  {
                    required: true,
                  },
      about_user: {
                    required: true,
                    minlength:2,
                    maxlength:200
                  },
      last_name:  {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
				          },
               
      phone:      {
                      required: true,
                      minlength: 2,
                      maxlength: 20,
                  },
      address:    {
                      required: true,
                      minlength: 2,
                      maxlength: 100,
                  },
       pan_no:    {
                     
                      minlength: 2,
                      maxlength: 20,
                  },
      mobile:     {
                      required: true,
                      minlength: 10,
                      maxlength: 20,
                  },
      designation:{
                      required: true,
                      minlength: 2,
                      maxlength: 100,
                  },
      email:      {
                      required: true,
                      email:true,
                      minlength: 2,
                      maxlength: 100,
                 },
      bank_name: 
                {
                    required: true,
                    minlength:2,
                    maxlength:50
                },
      account_no: 
               {
                   required: true,
                   minlength: 2,
                   maxlength: 50
               },
       profile_picture: 
               {
                  
                   accept:'jpeg|gif|gif|png'
               },

            },
      messages: {
			     	company_name: 
                {
                     required: errorMessage.required,
                     minlength: errorMessage.minlength,
    			           maxlength: errorMessage.maxlength,
                },

                company_website: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    		        		maxlength: errorMessage.maxlength,
                },

                first_name: 
                {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				        maxlength: errorMessage.maxlength,
                },
                last_name: 
                {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    			         	maxlength: errorMessage.maxlength,
                },
                phone: 
                {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				        maxlength: errorMessage.maxlength,
                },
                email: 
                {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				        maxlength: errorMessage.maxlength,
                },
            },

            submitHandler: function(form) {
				$('.generalsettings').addClass('hidden');
      			$('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden');
      			$('#generalsettingbtn').attr('disabled',true);
      			$('input').attr('readonly',true);
				$.ajax({
						url: basicdetailurl, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						dataType:'json',
            contentType: false,       
            cache: false,             
            processData:false,  
						success: function(data)   // A function to be called if request succeeds
						{
							console.log(data);
							
      						if(data.success_message)
                  {
                     $('.pop_error_container').html(data.success_message);
                  }
                  else
                  {
                     $('.pop_error_container').html(data.error_message);
                  }
                  $('i.createcheck').removeClass('hidden');
                  $('.img-loader').addClass('hidden');
                  $('#generalsettingbtn').attr('disabled',false);
                  $('.pop_error').removeClass('hidden');
                  $('.pop_error').addClass('success');
                  $('input').attr('readonly',false);
                  setTimeout(function(){
                          window.location.href =basicdetailurl;    
                          },3000);
						}
						});
        	}

        });
});


    // e.preventDefault();
$(document).on('click',"#addressbtn",function(e) {
 

       $("#addressform").validate({
            errorElement: 'span',
			errorClass:'text-danger',
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			  $('.address').removeClass('hidden');
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
				// $('.generalsettings').removeClass('hidden');
			},
            rules: {
				company_address1: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
				company_address2: {
                   required: true,
                    minlength: 2,
                    maxlength: 100
                },
                company_city: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
					
                },
           identification_no: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
                },
                 company_state: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
					
                },
                 company_zipcode: {
                    required: true,
                    minlength: 2,
                    maxlength: 10,
				},
                 country: {
                    required: true
                },
            },
            messages: {
				   company_address1: {
                    company_address1: errorMessage.required,
                    minlength: errorMessage.minlength,
    				        maxlength: errorMessage.maxlength,
                },

                company_address2: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    			         	maxlength: errorMessage.maxlength,
                },

                company_city: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    			        	maxlength: errorMessage.maxlength,
                },
                  identification_no: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,
                },
                company_zipcode: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    			        	maxlength: errorMessage.maxlength,
                },
                country: {
                    required: errorMessage.required
                },
            },

            submitHandler: function(form) {
				    $('.address').addClass('hidden');
      			$('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden')
      			$('#addressbtn').attr('disabled',true);
      			$('input').attr('readonly',true);
				$.ajax({
						url: basicdetailurl, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: $("#addressform").serialize(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						dataType:'json',
						success: function(data)   // A function to be called if request succeeds
						{
							console.log(data);
							
      						if(data.success_message)
      						{
                     $('.pop_error_container').html(data.success_message);
      						}
                  else
                  {
                     $('.pop_error_container').html(data.error_message);
                  }
                  $('i.createcheck').removeClass('hidden');
                  $('.img-loader').addClass('hidden');
                  $('#addressbtn').attr('disabled',false);
                  $('.pop_error').removeClass('hidden');
                  $('.pop_error').addClass('success');

                  $('input').attr('readonly',false);
                  setTimeout(function(){
                            $('.pop_error').addClass('hidden');
                            $('.pop_error').removeClass('error');
                            $('.pop_error').removeClass('success');
                            $('.pop_error_container').html('');
                          },3000);
						}
						});
        	}

        });
});


$(document).on('click',"#changepasswordbtn",function(e) {

       $("#changepasswordform").validate({
            errorElement: 'span',
			errorClass:'text-danger',
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			  $('.changepassword').removeClass('hidden');
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
				// $('.generalsettings').removeClass('hidden');
			},
            rules: {
				password: {
                    required: true
                },
				new_password: {
                   required: true,
                    minlength: 6,
                    maxlength: 20
                },
                re_new_password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                    equalTo: "#new_password"
					
                },
                
            },
            messages: {
				password: {
                    password: errorMessage.required,
                },

                new_password: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },

                re_new_password: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },
              
            },

            submitHandler: function(form) {
				$('.changepassword').addClass('hidden');
      			$('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden');
      			$('#changepasswordbtn').attr('disabled',true);
      			$('input').attr('readonly',true);
				$.ajax({
						url: basicdetailurl, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: $("#changepasswordform").serialize(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						dataType:'json',
						success: function(data)   // A function to be called if request succeeds
						{
							JSON.stringify(data);
							console.log(data);
      						if(data.success_message)
      						{
      							window.location.href =loginpanelurl;		
      						}else{
      							$('i.createcheck').removeClass('hidden');
      							$('.img-loader').addClass('hidden');
      					    $('.pop_error').removeClass('hidden');
                    $('.pop_error').addClass('error');
      					    $('.pop_error_container').html(data.error_message);
      					    $('input').attr('readonly',false);
      					    $('#changepasswordbtn').attr('disabled',false);
      					     	  setTimeout(function(){
                          $('.pop_error').addClass('hidden');
                            $('.pop_error').removeClass('error');
                            $('.pop_error').removeClass('success');
                            $('.pop_error_container').html('');
                          },5000);
      						}
						}
						});
        	}

        });
});



$(document).on('click',"#bankdetailbtn",function(e) {

       $("#bankdetailform").validate({
            errorElement: 'span',
      errorClass:'text-danger',
      highlight: function (element, errorClass, validClass) { 
        $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
        $('.bankdetail').removeClass('hidden');
      }, 
      unhighlight: function (element, errorClass, validClass) { 
             
        $(element).parents("div.form-group").removeClass('has-error'); 
        $(element).parents(".error").removeClass('has-error').addClass('has-success'); 
        // $('.generalsettings').removeClass('hidden');
      },
            rules: {
                  bank_name: 
                          {
                              required: true,
                              minlength:2,
                              maxlength:50
                          },
                  account_no: 
                           {
                               required: true,
                               minlength: 2,
                               maxlength: 50
                          },
               
                
            },
            submitHandler: function(form) {
            $('.bankdetail').addClass('hidden');
            $('i.createcheck').addClass('hidden');
            $('.img-loader').removeClass('hidden');
            $('#bankdetailbtn').attr('disabled',true);
            $('input').attr('readonly',true);
        $.ajax({
            url: basicdetailurl, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: $("#bankdetailform").serialize(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType:'json',
            success: function(data)   // A function to be called if request succeeds
            {
              JSON.stringify(data);
              console.log(data);
                 if(data.success_message)
                  {
                     $('.pop_error_container').html(data.success_message);
                  }
                  else
                  {
                     $('.pop_error_container').html(data.error_message);
                  }
                  $('i.createcheck').removeClass('hidden');
                  $('.img-loader').addClass('hidden');
                  $('#bankdetailbtn').attr('disabled',false);
                  $('.pop_error').removeClass('hidden');
                  $('.pop_error').addClass('success');

                  $('input').attr('readonly',false);
                  setTimeout(function(){
                            $('.pop_error').addClass('hidden');
                            $('.pop_error').removeClass('error');
                            $('.pop_error').removeClass('success');
                            $('.pop_error_container').html('');
                          },3000);
            }
            });
          }

        });
});

$(document).on('click','.saveurlbtn',function(e) {
    var activeclas=$(this).data('menuactive');
    var rules = new Object();
    var messages = new Object();
    $('.profileurl').each(function() {
        rules[this.name] = { required: true ,maxlength:200,checkhyperlink:true };
     
    }); 
    
    $("#saveprofile"+activeclas).validate({
            errorElement: 'span',
      errorClass:'text-danger',
      highlight: function (element, errorClass, validClass) { 
        $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
       
      }, 
      unhighlight: function (element, errorClass, validClass) { 
             
        $(element).parents("div.form-group").removeClass('has-error'); 
        $(element).parents(".error").removeClass('has-error').addClass('has-success'); 
      
      },
            rules,
            messages: {
              urllist: {
                          required: errorMessage.required,
                          minlength: errorMessage.minlength,
                          maxlength: errorMessage.maxlength,
                      },
            },

            submitHandler: function(form) {
             
        // $('.changepassword').addClass('hidden');
            $('i.createcheck').addClass('hidden');
            $('.img-loader').removeClass('hidden');
            $('.saveurlbtn ').attr('disabled',true);
            $('input').attr('readonly',true);
            $('.url_add').addClass('hidden');
            $('.remover').addClass('hidden');
           action =form.action;
           var form=form;

        $.ajax({
            url: action, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: $(form).serialize(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType:'json',
            success: function(data)   // A function to be called if request succeeds
            {
             JSON.stringify(data);
           
                  if(data.success_message)
                  {
                      $('.pop_error').removeClass('hidden');
                      $('.pop_error').addClass('success');
                      $('.pop_error_container').html(data.success_message);
                    
                  }else{
                      $('.pop_error').removeClass('hidden');
                      $('.pop_error').addClass('success');
                      $('.pop_error_container').html(data.error_message);  
                  }

                  $('input').attr('readonly',false);
                  $('i.createcheck').removeClass('hidden');
                  $('.img-loader').addClass('hidden');
                  $('.url_add').removeClass('hidden');
                  $('.remover').removeClass('hidden');
                  $('.saveurlbtn ').attr('disabled',false);
                      setTimeout(function(){
                          $('.pop_error').addClass('hidden');
                            $('.pop_error').removeClass('error');
                            $('.pop_error').removeClass('success');
                            $('.pop_error_container').html('');
                          },3000);
            }
            });
          }

        });
})

$(document).on('click','.url_add',function(e) {
  var activeclas=$(this).data('menuactive');

  $('#ep_'+activeclas).append(' <div class="form-group"> <div class="col-xs-2"></div><div class="col-xs-8"><input type="text" class="form-control profileurl" name="'+activeclas+'url[]"></div> <div class="col-xs-2 remover"><a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a></div>');
})

$(document).on('click','.remover',function(e) {
$(this).parent('.form-group').remove();
})
$(document).on('click','.msz_menu li',function(){
  var view=($(this).data('view'));
  window.history.pushState('/', view,  view);
})
