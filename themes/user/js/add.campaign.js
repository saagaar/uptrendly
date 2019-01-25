//Sign up form validation


$(function(){

/* Editing campaign*/
	$(document).on('click','.edit_campaign',function(){
   var productid=$(this).data('productid');
  
  $('#create_campaign').data('type','edit');
     $.ajax({
                        url: getmediaproduct+'/'+productid, // Url to which the request is send
                        type: "GET",             // Type of request to be send, called as method
                        dataType:'json',
                        success: function(data)   // A function to be called if request succeeds
                        {
                           JSON.stringify(data);

                             if(data.error_message)
                             {
                                   $('.pop_error').removeClass('hidden');
                                   $('.pop_error').addClass('error');
                                   $('.pop_error_container').html(data.error_message);
                                 
                             }
                            else
                            {
                               $('#Modalcampaignedit').modal('show');
                               $('#brandselectbtn').data('productid',productid);
                             
                               $('.mediabrand').each(function(v)
                               {  
                                  $(this).removeClass('selected');
                               })
                                $.each(data, function(index, element) {
                                  $('.mediabrand[data-mediaid="'+element+'"]').addClass('selected');
                                });
                                $('.selectbrand').attr('disabled',false);
                            }
                                $('i.createcheck').removeClass('hidden');
                                $('#create_campaign').attr('disabled',false);
                                $('.form-control').attr('disabled',false);
                                $('.img-loader').addClass('hidden');
                                 setTimeout(function(){
                                 $('.pop_error').addClass('hidden');
                                 $('.pop_error').removeClass('error');
                                 $('.pop_error').removeClass('success');
                                 $('.pop_error_container').html('');

                                },3000);
                        }

                        });  
});

   $(document).on('hidden.bs.modal','#Modalcampaignedit', function () {
               $('#addbrandcampaign')[0].reset();
               $('.form-group').each(function () { $(this).removeClass('has-success'); });
              $('.form-group').each(function () { $(this).removeClass('has-error'); });
              $('.form-group').each(function () { $(this).removeClass('has-feedback'); });
              $('.text-danger').each(function () { $(this).remove(); });
               $("#fileUpload").val('');

    });   
      $(document).on('hidden.bs.modal','#campaigncreation', function () {
        $('.modal').modal('hide');
      })
     
$(document).on('click','.selectbrand',function(){
    $('.campaigncreate').attr('disabled',true);
    $('.campaigncreate').stopPropagation();
    var productid=$(this).data('productid');
      var selectbrand=[];
    $('.mediabrand').each(function(){
      if($(this).hasClass('selected'))
      {
        var mediaid=$(this).data('mediaid');
        selectbrand.push(mediaid);
      }
      
    });
    $('#brandsocialmedia').val(selectbrand);
    

   if($.trim(productid)==null || $.trim(productid)=='' || $.trim(productid)==false || $.trim(productid)==undefined) 
    {
     $('#addbrandcampaign').trigger("reset");
     var form = $("#addbrandcampaign");
     validator = form.validate();
     validator.resetForm();
     form.find(".error").removeClass("error");
      return false;
    }

    $('.form-control').attr('disabled',true);
    $('i.createcheck').addClass('hidden');
    $('.img-loader').removeClass('hidden');
    $('#create_campaign').attr('disabled',true);
    $('#campaigncreation').modal('show');
    $.ajax({
                        url: editaction+'/'+productid, // Url to which the request is send
                        type: "GET",             // Type of request to be send, called as method
                        dataType:'json',
                        success: function(data)   // A function to be called if request succeeds
                        {
                           // JSON.stringify(data);
                           if(data.error_message)
                           {
                                 $('.pop_error').removeClass('hidden');
                                 $('.pop_error').addClass('error');
                                 $('.pop_error_container').html(data.error_message);
                               
                           }
                            if(data)
                            {
                               $('#productid').val(productid);
                               $('#c_productname').val(data.product_name);
                               $('#c_description').val(data.description);
                               // $('#brandsocialmedia').val(data.media);
                               $('#c_product_url').val(data.product_url);
                               $('#c_least_fan_count').val(data.least_fan_count);
                               $('#c_description').val(data.description);
                               $('#c_price_range').val(data.price_range);
                               $('#c_submission_deadline').val(data.submission_deadline);
                               $('#c_save_method').val(data.save_method);
                               $('#c_category').val(data.cat_id);
                               $('#brwose-image').html('<img src="'+imgurl+'/'+data.image+'"></img>');
                            }
                                $('i.createcheck').removeClass('hidden');
                                $('#create_campaign').attr('disabled',false);
                                $('.form-control').attr('disabled',false);
                                $('.img-loader').addClass('hidden');
                                 setTimeout(function(){
                                 $('.pop_error').addClass('hidden');
                                 $('.pop_error').removeClass('error');
                                 $('.pop_error').removeClass('success');
                                 $('.pop_error_container').html('');
 
                                },3000);
                        }

                        });  
})


	/**
	 * for selecting brand social media
	 * @param  {[type]} e) {             	e.preventDefault();  	var buttonenable [description]
	 * @return {[type]}    [description]
	 */
  $('.smedia a').click(function (e) {
  		e.preventDefault();
  	var buttonenable=false;
	var current=$(this);
  	if(current.hasClass('selected')) current.removeClass('selected');
  	else  current.addClass('selected');
  	$('.smedia a').each(function(i,e){
  		if($(this).hasClass('selected'))
  		{
  			 buttonenable=true;
  		}

  	});
  
  	if(buttonenable===true) $('.selectbrand').attr('disabled',false);
  	else $('.selectbrand').attr('disabled',true);
  	
  });
  jQuery.validator.addMethod("uploadimage", function(value, element) {
    var type=$('#create_campaign').data('type');
  
  if(type!='edit')
  {
    if($.trim(value)=='' || $.trim(value)==false || $.trim(value)==undefined ||  $.trim(value)==null)
    {
     return false;  
    }
    else
    {
      return true;
    }
  }
  else
  {
    return true; 
  }
}, "This field is required");  

   jQuery.validator.addMethod("smartcampaign", function(value, element) {
    var camptype=$("input[name='campaign_type']:checked").attr('id');
   stepval=$('.create_campaign:visible').data('step');
   
  if(stepval=='secondary-form' && camptype=='campaign_smart')
  {
    if($.trim(value)=='' || $.trim(value)==false || $.trim(value)==undefined ||  $.trim(value)==null)
    {
     return false;  
    }
    else
    {
      return true;
    }
  }
  else
  {
    return true; 
  }
}, "This field is required");  
jQuery.validator.addMethod("checkcreatorlist", function(value, element) {
  // alert($(".creatorslist:checked").length);
  //   if($(".creatorslist:checked").length > 0){
  //      return true;
  //  }else {
  //      return false;
  //  }
   return false;
},"You must select at least one!");


  jQuery.validator.addMethod("uploadimage", function(value, element) {
    var type=$('.create_campaign').data('type');
  
  if(type!='edit')
  {
    if($.trim(value)=='' || $.trim(value)==false || $.trim(value)==undefined ||  $.trim(value)==null)
    {
     return false;  
    }
    else
    {
      return true;
    }
  }
  else
  {
    return true; 
  }
}, "This field is required");  

//    jQuery.validator.addMethod("contactno", function(value, element) {

//   return this.optional(element) || /^[0-9+-\s]+$/.test(value);

// }, "Please enter valid Contact number"); 
 });
$(document).on('click','.create_campaign',function(e) {
  var createcampaignbtn=$(this);

    productid=$('#productid').val();
    stepval=$(this).data('step');

   if(stepval==='main-form')
    { 
       var rules=new Object();
       var messages=new Object();

      rules['campaign_name']=
                {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                };
      rules['description']= 
                {
                    required: true,
                    minlength: 2,
                    maxlength: 200
                };
      rules['product_url']   =
                {
                   
                    //  checkhyperlink:true,
                    maxlength: 100
                };
      rules['objective[]']   =
                {
                    required: true,
                };
      
      
      rules['category'] =
                {
                    required: true
                };
      rules['submission_deadline'] = 
                {
                    required: true
                };
      rules['critical_deadline'] = 
                {
                    required: true
                };
      rules['product_name'] =
                {
                   required: true,
                   maxlength:20,
                   minlength:2
                };
      rules['owner_name']   =
                {
                   required: true,
                   maxlength:50,
                   minlength:2
                };
      rules['contact_no'] =
                {
                    required: true,
                    maxlength:15,
                    minlength:5
                };
      rules['vatno'] =   
                {
                   
                    maxlength:50,
                    minlength:2
                };
       rules['time_sensitive'] =   
                {
                    required: true,
                };

    
        rules['uploadimage[]'] =    
          {
              // uploadimage: true,
              accept: 'jpg|png|gif|jpeg'
          };
   
      rules['campaign_type'] =   
                {
                    required: true,

                };
      rules['save_method'] =   
                {
                    required: true,
                };
      
    }
   
    
       
       
        rules['no_influencer']={number:true,smartcampaign:true};
        // rules['preferred_gender']={ smartcampaign:true};
        rules['preferred_age']={smartcampaign:true};
        rules['tentative_date']={ smartcampaign:true};
  

       $("#addbrandcampaigns").validate({
            errorElement: 'span',
			errorClass:'text-danger',
    
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
        ignore: [],
        rules,     
        submitHandler: function(form) 
          {
             
              if(stepval==='main-form')
                 {
                  
                      var $active = $('.wizard .nav-tabs li.active');
                      $active.next().removeClass('disabled');
                      nextTab($active);
                 }
                else
                 {

                         var campaign=$('.campaign_type:checked').val();
                         var creatorsno=  $('.creatorslist:checked').length;
                         var campaign_type=$('.campaign_type:checked').length;
                       
                      if(campaign=='normal' || campaign=='budget')
                        {
                         if(creatorsno<1 || campaign_type<1)
                         {
                        
                            $('#c_creators').remove();
                            $('#c_campaign_type').remove();
                            $('.product_listing').after('<div id="c_creators" class="text-danger">At least one Creator must be selected');
                            $('.capm_type').after('<div id="c_campaign_type" class="text-danger">This field is required');
                           
                               if(campaign_type<1)
                                {
                                  if(creatorsno>0)
                                  {
                                     $('#c_creators').remove();
                                  }
                                   $(window).scrollTop($('.capm_type').offset().top);
                                    $('.capm_type').focus();
                                }
                                else
                                {
                                  $('#c_campaign_type').remove();
                                  $(window).scrollTop($('#c_creators').offset().top);
                                  $('#c_creators').focus();
                                }
                                 return false;
                            }  
                         }
                         else if(campaign=='smart')
                         {

                            var tentative_budget=$('#campaign_typecampaign_type').val();
                            var preferred_gender=$('#preferred_gender').val();
                            if(tentative_budget=='')
                           {
                               $('#tentative_budget').after('<div id="c_tentative_budget" class="text-danger">This field is required');
                               return false;
                           }
                             
                         }
                       

                         // else
                         // {
                            $('#c_creators').remove(); 
                            var action=$('#addbrandcampaign').attr('action');
                            $('.img-loader').removeClass('hidden');
                            createcampaignbtn.attr('disabled',true);
                            $.ajax({
                               url: action, 
                               type: "POST",
                               data: new FormData(form), 
                               contentType: false,       
                               cache: false,             
                               processData:false,        
                               dataType:'html',
                               success: function(data)   
                               {
                                 console.log(data);
                                    if(data.success_message)
                                     {
                                         $('.pop_error').removeClass('hidden');
                                         $('.pop_error').addClass('success');
                                         $('.pop_error_container').html(data.success_message);
                                     }
                                    else
                                    {
                                         $('.pop_error').removeClass('hidden');
                                         $('.pop_error').addClass('error');
                                         $('.pop_error_container').html(data.error_message);
                                    }
                                      createcampaignbtn.data('type','create');
                                      createcampaignbtn.attr('disabled',false)
                                      $('.img-loader').addClass('hidden');
                                      setTimeout(function()
                                      {
                                         $('.pop_error').addClass('hidden');
                                         $('.pop_error').removeClass('error');
                                         $('.pop_error').removeClass('success');
                                         $('.pop_error_container').html('');
                                        window.location.href =listcampaign;    
                                      },2000);
                               }
                               });
                          // }
                 }
            }

        	

        });
});


$(document).on('click','.campaigncreate',function(){
 $('.mediabrand').each(function(){
      $(this).removeClass('selected');
    });
  // $('#create_campaign').data('type','create');
 $('.selectbrand').data('productid','');
 // $('#addbrandcampaign')['0'].reset();
 $('.selectbrand').attr('disabled',true);
 $('#brwose-image').html('');

})
/**
 *Campaign creation choose normal /budget /smart campaign
 */

$(document).on('change','.campaign_type',function(){
  var element=$(this).val();
  $('.creatorslist').removeAttr('checked');
  $('.budgetamount').val('0');
  $('.costgroup').addClass('hidden');
  $('#'+element).removeClass('hidden');
  $('.budgetamount').attr('disabled',false);  
  $('.budgetamount').not('.'+element+'element').attr('disabled',true);
  if(element=='smart')
  {
    $('.creatorslist').addClass('hidden');
    $('.filterview').addClass('hidden');
  }
  else{
   $('.creatorslist').removeClass('hidden');
    $('.filterview').removeClass('hidden');
  }
})

$(document).on('change','.creatorslist',function(){
currentevent=$(this);
var elementbudget=$(this).next('input.individualcreatorcost').val();
var campaigntype= $('.campaign_type:checked').val();

var budgetamount=$('#'+campaigntype).find('.budgetamount').val();
if(campaigntype=='budget')
{
  var limitbudget=$('#budget_limit').val();
  
    if(($(this).is(':checked')))
    {
      if((parseInt(budgetamount)+parseInt(elementbudget))>limitbudget)
      {
         currentevent.attr('checked',false);
         $('.pop_error').removeClass('hidden');
         $('.pop_error').addClass('error');
         $('.pop_error_container').html('Your Allocated Budget is full.You can increase your budget to select more Creators');
                              setTimeout(function(){
                                 $('.pop_error').addClass('hidden');
                                 $('.pop_error').removeClass('error');
                                 $('.pop_error_container').html('');
                                },3000);
      }
      else
      {

          $('#'+campaigntype).find('.budgetamount').val(parseInt(budgetamount)+parseInt(elementbudget));
      }
        
      
    }
    else
    {
        $('#'+campaigntype).find('.budgetamount').val(parseInt(budgetamount)-parseInt(elementbudget));
    }
}
else
{
  if(($(this).is(':checked')))
  {
      
     $('#'+campaigntype).find('.budgetamount').val(parseInt(budgetamount)+parseInt(elementbudget));
  }
  else
  {
      $('#'+campaigntype).find('.budgetamount').val(parseInt(budgetamount)-parseInt(elementbudget));
  }
}

  
})



$("#brandregbtn").click(function(e) {
 e.preventDefault();
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
                    maxlength: 20
                },
				brand_url: {
                    required: true
                },
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
				email: {
                    required: true,	
                    email: true,
                    checkDuplicateEmail:true
                   
                },
                password: {
                    required: true,
          					minlength: 6,
          					maxlength: 20
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



