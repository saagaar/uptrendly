$(function(){
	$(document).on('change','.filteropt',function(e){
		e.preventDefault();
		filterview();
	});
	$(document).on('click','.filteroptname',function(e){

		e.preventDefault();
		filterview();
	})
})

$(document).on('click','.editbutton',function(){
	$('.modal').modal('hide');
    var productid=$(this).attr('productid');
    var action=$(this).data('action');
    $('.form-control').attr('disabled',true);
    $('i.createcheck').hide();
    $('.img-loader').show();
    $('#create_collab').attr('disabled',true);
    $('#popup-postcollab').modal('show');
    $.ajax({
                        url: action+'/'+productid, // Url to which the request is send
                        type: "GET",             // Type of request to be send, called as method
                        dataType:'json',
                        success: function(data)   // A function to be called if request succeeds
                        {
                        	console.log(data);
                           // JSON.stringify(data);
                           if(data.error_message)
                           {
                                $('.error-message').show();
                                $('.error-message').html(data.error_message);           
                                $('#create_collab').attr('disabled',true);             
                           }
                            if(data)
                            {
                               $('#productid').val(productid);
                               $('#c_productname').val(data.product_name);
                               $('#c_description').val(data.description);
                               $('#postsocialmediaid').val(data.media);
                               $('#c_leastcount').val(data.least_fan_count);
                               $('#c_submission_deadline').val(data.submission_deadline);
                               $('#c_save_method').val(data.save_method);
                                $('#create_collab').attr('disabled',false);
                               
                            }
                                $('i.createcheck').show();
                                $('.img-loader').hide();
                              
                                $('.form-control').attr('disabled',false);
                               
                        }

                        });

    
})
function filterview()
{

		var viewtype=$('.sponsorcollabtab').parent('li.active').children('a').data('type');
    if(viewtype===undefined || viewtype=='')
      viewtype =$('.viewtype').val();
    var status = $('.status').val();
		var least_fan_count  = $('.fancount').val();
		var pricerange = $('.pricerange').val();
		var mediachannel= $('.mediachannel').val();
		var category=   $('.category').val();
		var name= $('.name').val();
    var proposaltype=$('.proposaltype').val();
		
		var filterparams={};
		if(pricerange)
		{
			filterparams.filterpricerange=(pricerange);
		}
		if(mediachannel){ 
			filterparams.filtermediatype=mediachannel
		}
    if(proposaltype)
    {
        filterparams.filterproposaltype=proposaltype;
    }
		if(category){
			filterparams.filtercategory=category;
		}
		if(name){
			
			filterparams.filtername=name;
		}
    if(status)
    {
      filterparams.filterstatus=status;
    }
		if(least_fan_count)
		{
			filterparams.filterfancount=(least_fan_count);
		}
		if(viewtype)
		{
			filterparams.viewtype=(viewtype);
		}

		$('.img-loader').removeClass('hidden');
		$.ajax({
						url: action, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType:'html',
						data:filterparams,
						success: function(data)   // A function to be called if request succeeds
						{
							$('.img-loader').addClass('hidden');
								$('.filterview').html('');
      					    	$('.filterview').html(data);
      					    	 if(viewtype=='my-proposal' || viewtype=='mycollabproposals')
                            	$('a.sendproposal').html('Edit Proposal');
						}
			});
}

$(document).on('click','.draftpopupbtn',function(){
             
         var bidid=$(this).data('bidid');
         //  $('#draftbidid').val(bidid);
         //  var media=current.data('mediaid');
          $('button').attr('disabled',true);
          $('.createcheck').addClass('hidden');
          $('.img-loader').removeClass('hidden');
          $('#send_draft').modal('show');
        $.ajax({
                url: getdraft, 
                type: "POST",  
                dataType:'json',
                data : {bidid:bidid}  ,
                success: function(data)     
                {
                  
                  if(data.customlink)
                  {
                      $('#customlinkdiv').removeClass('hidden');
                      $('#customlinkline').html(data.customlink);
                  }
                  else 
                  {
                      $('#customlinkdiv').addClass('hidden');
                  }
                  $('#draftdescription').val('');
                  $('#link_url').val('');
                  $('#draftid').val('');
                  $('#draftbidid').val('');
                  if(data.data!==undefined)
                  { 
                      $('#draftdescription').val(data.data.description);
                      $('#link_url').val(data.data.link);
                      $('#draftid').val(data.data.id);
                      $('#draftbidid').val(data.data.bid_id);

                       $('.brwose-image').html('<img src="'+imgurl+'/'+data.data.image+'"></img>');
                   
                  }
                  else
                  {
                    $('#draftbidid').val(bidid);
                  }
                      $('button').attr('disabled',false);
                      $('.createcheck').removeClass('hidden');
                      $('.img-loader').addClass('hidden');
                }
                });
	
	

});
// $(document).on('click','#copytoclipboard',function(e){
//   e.preventDefault();
//   document.execCommand('copy');
// })

$(document).on('click','.mediatrack',function(){

         var bidid=$(this).data('bidid');
          $('#trackbidid').val(bidid);
          $('button').attr('disabled',true);
          $('.createcheck').addClass('hidden');
          $('.img-loader').removeClass('hidden');
          $('#add_socialtrack').modal('show');
        $.ajax({
                url: gettrackid, 
                type: "POST",        
                dataType:'json',
                data : {bidid:bidid}  ,
                success: function(data)   
                {
                 
                  if(!data.error_message)
                  { 
                    if(data.length>0)
                    {
                         $('#fb_page').val(data.fb_page);
                         $('#fb_profile').val(data.fb_profile);
                         $('#instagram_username').val(data.instagram);
                    }
                  
                  }
                  else
                  {
                      
                      $('#add_socialtrack').modal('hide');
                      $('.pop_error').removeClass('hidden');
                      $('.pop_error').removeClass('error');
                      $('.pop_error').addClass('error');
                      $('.pop_error_container').html(data.error_message);
                   }
                  $('button').attr('disabled',false);
                  $('.createcheck').removeClass('hidden');
                  $('.img-loader').addClass('hidden');
                  setTimeout(function(){
                        $('.error_message').addClass('hidden');
                        $('.pop_error').addClass('hidden');
                    },5000);
                }
                });
  
  

});
 jQuery.validator.addMethod("checkhyperlink", function(value, element) {
  return this.optional(element) || /(^|\s)((http(s)?:\/\/)|(www.\S))/.test(value);
}, "Hyperlink is required(add http:// or www to your link)"); 

 $(document).on('click','.setstatus',function(){
    var productid=$(this).data('productid');
    var bidid=$(this).data('bidid');
    var status=$(this).attr('value');
    var cur=$(this);


    if(confirm('Are you sure you want to change the status?')){
      cur.parent('div').find('.img-loaderstatus').removeClass('hidden');
      $('.img-loader').removeClass('hidden');
      $.ajax({
           type: "POST",
           url: changestatusurl,
           data:{ bidid:bidid,status:status,productid:productid },
           success:function(data){
     
             setTimeout(function(){
                       cur.parent('div').find('.img-loaderstatus').addClass('hidden');
                       location.reload();
                    },3000);
          //   if(data.success_message){
          //     $('.pop_error').removeClass('hidden');
          //     $('.pop_error').addClass('success');
          //     $('.pop_error_container').html(data.success_message);
          //   }
          //   else{
          //      $('.pop_error').removeClass('hidden');
          //      $('.pop_error').addClass('error');
          //      $('.pop_error_container').html(data.error_message);
          //   }
          //    setTimeout(function(){
          //      $('.pop_error').addClass('hidden');
          //      $('.pop_error').removeClass('error');
          //      $('.pop_error').removeClass('success');
          //      $('.pop_error_container').html('');
          // },3000);
            
           }
      })
    }else{
      return false; 
    }
    
    
})

$(document).on('click',"#send_draftpromotion",function(e) {
      $("#draftform").validate({
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
             
              social_media: {
                    required: true,
              },

				description: {
                    required: true,
                    minlength: 2,
                    maxlength: 200
                },
				link: {
                    required: true,
                    minlength: 2,
                    maxlength: 200,
                },
               

            },
            messages: {
              social_media: {
                required: errorMessage.required,
                   },
				link: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },

                description: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },
            },

            submitHandler: function(form) {

                var action=$('#draftform').attr('action');
      			$('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden');
      			$('#send_draftpromotion').attr('disabled',true);

				$.ajax({
						url: action, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
					  data: new FormData($("#draftform")[0]), 
            contentType: false,       
            cache: false,             
            processData:false,
						dataType:'json',
						success: function(data)   // A function to be called if request succeeds
						{
							console.log(data);
							$('#send_draft').modal('hide');
      						if(data.success_message)
      						{
      							$('i.createcheck').removeClass('hidden');
      							$('.img-loader').addClass('hidden');
      							$('#send_draftpromotion').attr('disabled',false);
      							     $('.pop_error').removeClass('hidden');
                         $('.pop_error').addClass('success');
                         $('.pop_error_container').html(data.success_message);
      						}else{

      							
      							$('i.createcheck').removeClass('hidden');
      							$('.img-loader').addClass('hidden');
      							$('#send_draftpromotion').attr('disabled',false);
      						       $('.pop_error').removeClass('hidden');
                         $('.pop_error').addClass('error');
                         $('.pop_error_container').html(data.error_message);
      						}
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


$(document).on('click',"#save_trackmediabtn",function(e) {
    $("#save_trackmediaform").validate({
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
               fb_page: 
                    {
                        required: true,
                        minlength: 2,
                        maxlength: 300
                    },
                fb_profile:{
                  checkhyperlink:true
                },
                instagram:{
                  checkhyperlink:true
                }
            },
            messages: {
                    socialmediaid: {
                                required: errorMessage.required,
                                minlength: errorMessage.minlength,
                                maxlength: errorMessage.maxlength,
                            },
            },

            submitHandler: function(form) {

            var action=$('#save_trackmediaform').attr('action');
            $('i.createcheck').addClass('hidden');
            $('.img-loader').removeClass('hidden');
            $('#save_trackmediabtn').attr('disabled',true);

        $.ajax({
            url: action, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: $('#save_trackmediaform').serialize(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType:'json',
            success: function(data)   // A function to be called if request succeeds
            {
              console.log(data);
              $('#add_socialtrack').modal('hide');
                  if(data.success_message)
                  {
                      $('.pop_error_container').html(data.success_message);
                  }else
                  {
                      $('.pop_error_container').html(data.error_message);
                  }
                   $('#save_trackmediabtn').attr('disabled',false);
                   $('i.createcheck').removeClass('hidden');
                   $('.img-loader').addClass('hidden');
                   $('.error-message').removeClass('hidden');
                   $('.pop_error').removeClass('hidden');
                   $('.pop_error').removeClass('error');
                   $('.pop_error').addClass('error');
                    setTimeout(function(){
                          $('.error_message').addClass('hidden');
                          $('.pop_error').addClass('hidden');
                      },5000);
            }
            });
          }

        });
});

$(document).on('change','.availabilitystatus',function(){
 if($(this).is(':checked'))
 {
  status='1';
 }
 else
 {
  status='0';
 }
    $('.img-loader').removeClass('hidden');
  $.ajax({
            url: go_on_off, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: {availability_status:status}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType:'json',
            success: function(data)   // A function to be called if request succeeds
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
                         $('.pop_error').addClass('error');
                         $('.pop_error_container').html(data.error_message);
                  }
                   $('.pop_error').removeClass('hidden');
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