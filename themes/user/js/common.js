$(function(){ 
  $(document).on('click','.deletebtn',function(){
    if(confirm('Are you sure you want to Delete this record?'))
    {
      return true;
    }
    else
    {
      return false;
    
    }
  });
  // $(document).on('click','.messagesend',function(e){
  //   e.preventDefault();
 
  //     var message=$('#message').val();
  //     if(jQuery.trim(message)!=='')
  //     {
  //         var bidid=$(this).data('bidid');
  //         $('#message').val('');
  //         socket.emit('send_instant_message',{
  //           message:message,
  //           bidid:bidid,
  //           sender_id:userid,
  //           avatar:avatar
  //         });
  //     }

  //   });
  //  $(document).on('keypress','#message',function(e)
  //   {
     
  //     if(e.which == 13)
  //      {
  //             var message=$('#message').val();
  //             if(jQuery.trim(message)!=='')
  //             {
  //                 var bidid=$(this).data('bidid');
  //                 $('#message').val('');
  //                 socket.emit('send_instant_message',{
  //                   message:message,
  //                   bidid:bidid,
  //                   sender_id:userid,
  //                   avatar:avatar
  //                 });
  //             }
               
  //      }
    
  //   });
   // $(document).on('click','.back_home_msg',function(e)
  //  {
  //     e.preventDefault();
  //     $('.chat_msg_body').html('');
  //      socket.emit('manual_disconnect');
  // })
	   var abc=$(".scroll").prop('scrollHeight');
      $(".scroll").scrollTop(abc);
                         

	$("form").delegate(".numericonly", "keydown", function(event) {
		
		// Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 110 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39) ) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });

    $(document).on('click','.sponsordetail',function(e){
        e.preventDefault();
        var id=$(this).attr('id');
        var productid=$(this).data('productid');
        $('#edit_campaign_for_detail').data('productid',productid);
        var name=$('#'+productid+'_product_name').html();
        var pricerange=$('#'+productid+'_price_range').val();
        var img=$('#'+productid+'_productimg').attr('src');
        var media=$('#'+productid+'_allmedia').val();
        var url=$('#'+productid+'_product_url').val();
        var description=$('#'+productid+'_description').html();
        if(description==''){
                 var description=$('#'+productid+'_description').val();
        }
        var submissiondeadline=$('#'+productid+'_submission_deadline').val();
        var mediaseprate='';

         mediaseprate=media.split(',');
         $('.mediaicon').each(function(){
                $(this).addClass('hidden');
          });
        if(media!='')
        {
            mediaseprate.forEach(function(item) {    
             $('#'+item+'ico').removeClass('hidden');
            });
        }
        
        $('#product_name').html(name);
        $('#productimg').attr('src',img);
        $('#description').html(description);
        $('#budget').html(pricerange);
        $('#producturl').html(url);
        $('#submissiondeadline').html(submissiondeadline);
        $('#detail_popup').modal('show');
        // $('#med')

    })


    $(document).on('click','#popupmessage',function(){
        var bidid=$(this).data('bidid');
        var messageby=$(this).data('messageby');
          $('#sendmsg').modal('show');
          $('#sendmsgbtn').attr('data-bidid',bidid);
          $('#sendmsgbtn').attr('data-messageby',messageby);
    });


	$(document).on('click','#sendmsgbtn',function(){
        btnclk=$(this);
         $('#brndcommunication').validate({
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
                message: {
                    required: true,
                    maxlength: 200,
                }

            },
            messages: {
                message: {
                    required: errorMessage.required,
                    maxlength: errorMessage.maxlength,
                }
            },

            submitHandler: function(form) {
                var bidid=btnclk.data('bidid');
                var messageby=btnclk.data('messageby');
                var message=$('#message').val();
                $('#sendmsgbtn').attr('disabled',true);
                $('.defaultico').addClass('hidden');
                $('.img-loader').removeClass('hidden');
                // $('input').attr('disabled',true);
                   $.ajax({
                        url: sendmessage, // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        dataType:'json',
                        data:{bidid:bidid,message:message},
                        success: function(data)   // A function to be called if request succeeds
                        {
                           JSON.stringify(data);

                            if(data.error_message)
                            {

                                $('.error_message').removeClass('hidden');
                                $('.error_message').html(data.error_message);
                                
                            }
                            else{
                                $('.error_message').removeClass('hidden');
                                $('.error_message').html(data.success_message);
                            }
                           
                                $('.defaultico').removeClass('hidden');
                                $('.img-loader').addClass('hidden');
                                $('#sendmsgbtn').attr('disabled',false);
                                (form).reset();
                                $('#sendmsg').modal('hide');
                                setTimeout(function(){
                                    $('.error_message').addClass('hidden');
                                },5000);
               
                               
                        }

                });
            }

        });
   
    });

    $(document).on('hidden.bs.modal','#sendmsg', function () {
               $('#communication')[0].reset();
    });     
    
    $(document).on('click','.messagetype',function(){
         msgelement=$(this);
        var msgtype=$(this).data('type');

          window.history.pushState('', msglist+'/'+msgtype,  msglist+'/'+msgtype);
        $('.img-loader').removeClass('hidden');

  
      messageview(msgtype,msgelement);
    })

     $(document).on('click','.namefilterclick',function(){
      msgelement= $('#filtersearchname');
      var att=($('.messagemenu li.active').children('a').data('type'));
        $('.img-loader').removeClass('hidden');

          messageview(att,msgelement);
    })

      $(document).on('click','.clickablemessagedetail',function(){
         $('.img-loader').removeClass('hidden');
         var productid=$(this).data('productid');
         var view=$(this).data('view');
         
        if(view!==undefined)
        {
            window.history.pushState('',msgdetail+'/'+productid, msgdetail+'/'+productid);
        }
       
          $.ajax({
                        url: messagedetail+'/'+productid, // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        dataType:'html',
                        data:{view:view},
                        success: function(data)   // A function to be called if request succeeds
                        {
                           
                          $('.img-loader').addClass('hidden');
                    
                          if(view===undefined)
                          {

                              $('#chat_home').removeClass('in active');
                              // $('#chat1').tab('show');
                              $('#chat1').addClass('in active');
                              $('.chat_msg_body').html('');
                         
                              $('.chat_msg_body').html(data);
                             
                          }
                          else
                          {
                           
                               $('.img-loader').addClass('hidden');
                               $('#open_msz').html('');
                               $('#open_msz').html(data);  
                          }
                          var abc=$(".scroll").prop('scrollHeight');
                          $(".scroll").scrollTop(abc);
                         
                        }

                });
    });

    $(document).on('click','.messagesend',function(){
        
       btnclk=$(this);
         $('#send_message').validate({
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
                message: {
                    required: true,
                    maxlength: 500
                },
                subject: {
                    required: true,
                    maxlength: 200
                }

            },
            submitHandler: function(form) {
            
                var bidid=btnclk.data('bidid');
                var message=$('#message').val();
                $('.messagesend').attr('disabled',true);
                var htmlsamp=$('#htmltype').val();
                var subject=$('#subject').val();
                 var productid=$('#productid').val();
                $('.defaultico').addClass('hidden');
                $('.img-loader').removeClass('hidden');
              
                                // $additionhtml.find('.message').html('Hello there');
                                // $additionhtml.find('.tym').html('8:47');
                                // $additionhtml.clone().appendTo('.chatelement');

                                // return false;
             
                             
                $('input').attr('disabled',true);
                   $.ajax({
                        url: sendmessage, // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        dataType:'html',
                        data:{bidid:bidid,message:message,subject:subject,productid:productid},
                        success: function(data)   // A function to be called if request succeeds
                        {
                          var datat= jQuery.parseJSON(data);
                           console.log(datat.success_message);
                            if(data.error_message)
                            {

                               $('.pop_error').removeClass('hidden');
                               $('.pop_error').addClass('error');
                               $('.pop_error_container').html(datat.error_message);
                                
                            }
                            else
                            {
                               $('.pop_error').removeClass('hidden');
                               $('.pop_error').addClass('success');
                               $('.pop_error_container').html(datat.success_message);  
                            }
                           
                                $('.defaultico').removeClass('hidden');
                                $('.img-loader').addClass('hidden');
                                $('.messagesend').attr('disabled',false);
                                (form).reset();
                              
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
    $(document).on('click','.remover',function(e) 
    {
      $(this).parent('.form-group').remove();
    })
//to browse image while creating campaign
     $(".previewuploadimage").on('change', function () 
  {

          if (typeof (FileReader) != "undefined") 
          {

            var size=(this.files[0].size);
            var image_holder = $(this).parents('.fileUpload').siblings('.brwose-image');
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                   var img = new Image;
                   img.src= e.target.result;
                   $(img).appendTo(image_holder);
                // alert(img.files[0].size);
                img.onload = function() 
                {
                      // access image size here 
                      var width=this.width;
                      var height=this.height;
                      var sizemb=size/(1024*1024);
                      if(width>=2000 || height>=2000|| sizemb>8)
                      {
                         $('.pop_error').removeClass('hidden');
                         $('.pop_error').addClass('error');
                         $('.pop_error_container').html('Image must be of dimensions not exceeding 2000*2000 px and size not exceeding 4Mb.');
                          setTimeout(function(){
                                   $('.pop_error').addClass('hidden');
                                   $('.pop_error').removeClass('error');
                                   $('.pop_error').removeClass('success');
                                   $('.pop_error_container').html('');
                                  },5000);
                           image_holder.empty();
                           $(".uploadcampaignimage").val('');

                         return false; 

                      }
                 
                  };
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);

          }
          else 
          {
              alert("This browser does not support FileReader.");
          }
  });
});


function messageview(msgtype,objmsg){

    var filtername=$('#filtersearchname').val();
         $.ajax({
                        url: viewmessage+'/'+msgtype, // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        dataType:'html',
                        data:{searchstr:filtername},
                        success: function(data)   // A function to be called if request succeeds
                        {
                           $('#'+msgtype+'_msz').children('table').children('tbody').html('');
                            $('#'+msgtype+'_msz').children('table').children('tbody').html(data);
                             $('.img-loader').addClass('hidden');
                        }

                });
}

$(document).on('click','#claimreport',function(){
  bidid=$(this).data('bidid');
  $('#report_bidid').val(bidid);
})
$(document).on('click','#reportsubmit',function(){

        
       btnclk=$(this);
         $('#reportuserform').validate({
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
                 title: {
                    required: true,
                    
                },
                message: {
                    
                    maxlength: 250
                }

            },
            messages: {
               title: {
                    required: errorMessage.required,
                },
                message: {
                   maxlength: errorMessage.maxlength,
                },
            },

            submitHandler: function(form) {
              // $('.modal').modal('show'return false;
                var bidid=btnclk.data('bidid');
                var message=$('#reportmessage').val();
                $('#reportsubmit').attr('disabled',true);
                $('.defaultico').addClass('hidden');
                $('.img-loader').removeClass('hidden');
              
                // $additionhtml.find('.message').html('Hello there');
                //                 $additionhtml.find('.tym').html('8:47');
                //                 $additionhtml.clone().appendTo('.chatelement');

                //                 return false;
             
                           
                // $('input').attr('disabled',true);
                   $.ajax({
                        url: reportuser, // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        dataType:'json',
                        data:$('#reportuserform').serialize(),
                        success: function(data)   // A function to be called if request succeeds
                        {
                          // console.log(data);return false;
                         
                        
                            if(data.global_error){
                              $('.modal').modal('hide');
                              $('.pop_error').removeClass('hidden');
                              $('.pop_error').removeClass('success');
                              $('.pop_error').addClass('error');
                              $('.pop_error_container').html(data.global_error);
                            }
                            else if(data.success_message)
                            {
                              $('.modal').modal('hide');
                              $('.pop_error').removeClass('hidden');
                              $('.pop_error').removeClass('error');
                              $('.pop_error').addClass('success');
                              $('.pop_error_container').html(data.success_message);
                                
                            }
                            else{
                               
                                $('.error_message').html(datat.error_message);
                            }
                           
                                $('.defaultico').removeClass('hidden');
                                $('.img-loader').addClass('hidden');
                                $('#reportsubmit').attr('disabled',false);
                                (form).reset();
                              
                                setTimeout(function(){
                                    $('.error_message').addClass('hidden');
                                    $('.pop_error').addClass('hidden');
                                },5000);
               
                               
                        }

                });
            }

     
      
       
   
    });
        
    
})
$(document).ready(function(){
    $(".fixed_notification i").click(function(){
      $(".pop_window").toggleClass("open_window");
      $(".fixed_notification .fa").toggleClass("fa-bell");
      $(".fixed_notification .fa").toggleClass("fa-times");
      
        if($('.pop_window').hasClass('open_window')){ 
             $.ajax({
                          url: notifyseen,
                          type: "POST",             
                          dataType:'json',
                          success: function(data)  
                          {
                           if(data.success_message){
                            $('.noti_count').fadeOut('3000');
                           }
                          }

                  });
        }
    });

    $('.cd_chat .fa-comments').click(function(){
       $('.chat_box').toggleClass("hidden");
    })
});

$(document).on('click','.btn_draft',function(e){

  e.preventDefault();
  $(this).children('.btn-img').children('i.createcheck').hide();
    $(this).find('.img-loader').removeClass('hidden');
    
    var bidid=$(this).data('bidid');
    var draftid=$('input[name="draft_id_'+bidid+'"]').val();
    $('button').attr('disabled',true);
    var btnval=$(this).data('val');
    var data={draftid:draftid,bidid:bidid,btnval:btnval};
  

    $.ajax({
            url: acceptdraft, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            dataType:'html',
            data:data,
            success: function(data)   // A function to be called if request succeeds
            {
                 var data1=jQuery.parseJSON(data);
              
               $('.img-loader').addClass('hidden');
                $('#v_draft_'+bidid).modal('hide');
                $('#proposal_'+bidid).find('.error_message').removeClass('hidden');
                console.log(data1.success_message);
                if(data1.success_message){
                  // $('#proposal_'+bidid).find('.error_message').html(data1.success_message);
                 
                              $('.pop_error').removeClass('hidden');
                              $('.pop_error').addClass('success');
                              $('.pop_error_container').html(data1.success_message);
                }
                else {
                              $('.pop_error').removeClass('hidden');
                              $('.pop_error').addClass('error');
                              $('.pop_error_container').html(data1.error_message);
                }
                  $('button').attr('disabled',false);
                 setTimeout(function(){
                      $('.pop_error').addClass('hidden');
                      $('.pop_error').removeClass('error');
                      $('.pop_error').removeClass('success');
                      $('.pop_error_container').html('');
                       window.location.href =campaignpage;    
                        
                  },3000);
            }
      });
});

$(document).on('click','.btn_draft_upload',function(e){
  e.preventDefault();
  $(this).children('.btn-img').children('i.createcheck').hide();
    $(this).find('.img-loader').removeClass('hidden');  
    var bidid=$(this).data('bidid');
    $('button').attr('disabled',true);
      var btnval=$(this).data('val');
    var data={bidid:bidid,btnval:btnval};
    console.log(data);
    $.ajax({
            url: acceptupload, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            dataType:'html',
            data:data,
            success: function(data)   // A function to be called if request succeeds
            {
                 var data1=jQuery.parseJSON(data);
                 $('.img-loader').hide();
                $('#v_verify_upload_'+bidid).modal('hide');
               
                if(data1.success_message){
                             $('.pop_error').removeClass('hidden');
                              $('.pop_error').addClass('success');
                              $('.pop_error_container').html(data1.success_message);
                }
                else {
                              $('.pop_error').removeClass('hidden');
                              $('.pop_error').addClass('error');
                              $('.pop_error_container').html(data1.error_message);
                }
                $('button').attr('disabled',false);
             
                 setTimeout(function(){
                      $('.pop_error').addClass('hidden');
                      $('.pop_error').removeClass('error');
                      $('.pop_error').removeClass('success');
                      $('.pop_error_container').html('');
                  },3000);
            }
      });
});