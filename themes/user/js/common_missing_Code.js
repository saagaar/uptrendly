$(function(){
	
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

$(document).on('click','.edit_campaign',function(){
    var productid=$(this).data('productid');
    var action=$(this).data('action');
    $('.form-control').attr('disabled',true);
    $('i.createcheck').hide();
    $('.img-loader').show();
    $('#create_campaign').attr('disabled',true);
    $('#campaigncreation').modal('show');
    $.ajax({
                        url: action+'/'+productid, // Url to which the request is send
                        type: "GET",             // Type of request to be send, called as method
                        dataType:'json',
                        success: function(data)   // A function to be called if request succeeds
                        {
                           // JSON.stringify(data);
                           if(data.error_message)
                           {
                                $('.error-message').show();
                                $('.error-message').html(data.error_message);
                                
                           }
                            if(data)
                            {
                               $('#productid').val(productid);
                               $('#c_productname').val(data.product_name);
                               $('#c_description').val(data.description);
                               $('#brandsocialmedia').val(data.media);
                               $('#c_product_url').val(data.product_url);
                               $('#c_description').val(data.description);
                               $('#c_price_range').val(data.price_range);
                               $('#c_submission_deadline').val(data.submission_deadline);
                               $('#c_save_method').val(data.save_method);
                               $('#c_category').val(data.cat_id);
                               $('#brwose-image').html('<img src="'+imgurl+'/'+data.image+'"></img>');
                            }
                                $('i.createcheck').show();
                                $('.img-loader').hide();
                                $('#create_campaign').attr('disabled',false);
                                $('.form-control').attr('disabled',false);
                               
                        }

                        });

    
})

    $(document).on('click','.sponsordetail',function(e){
        e.preventDefault();
        var id=$(this).attr('id');
        var productid=$(this).data('productid');
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
         $('#communication').validate({
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
                    maxlength: 200
                }

            },
            messages: {
                message: {
                    required: errorMessage.required,
                    maxlength: errorMessage.maxlength,
                },
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
                        data:{bidid:bidid,message:message,messageby:messageby},
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
  
      messageview(msgtype,msgelement);
    })
     $(document).on('click','.namefilterclick',function(){
      msgelement= $('#filtersearchname');
      var att=($('.messagemenu li.active').children('a').data('type'));

      messageview(att,msgelement);
    })
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
                        }

                });
}