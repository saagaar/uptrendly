// $(function(){
//     $(document).on('change','#changeprofile',function(){
//         alert('yes we are here');
//         var formUrl = "<?php echo site_url('/' . MY_ACCOUNT . 'changeprofilepicture')?>";
//         var formData = new FormData($('#changeprofileform')[0]);

//         $.ajax({
//                 url: formUrl,
//                 type: 'POST',
//                 data: formData,
//                 mimeType: "multipart/form-data",
//                 contentType: false,
//                 cache: false,
//                 processData: false,
//                 success: function(data, textSatus, jqXHR){
//                     console.log(data);
//                         //now get here response returned by PHP in JSON fomat you can parse it using JSON.parse(data)
//                 },
//                 error: function(jqXHR, textStatus, errorThrown){
//                         //handle here error returned
//                 }
//         });
//     })
// })

// JavaScript Document
$('#messageField').keyup(function () {
  var max = 1000;
  var len = $(this).val().length;
  if (len >= max) {
    $('#charNum').text(' you have reached the limit');
  } else {
    var char = max - len;
    $('#charNum').text(char + ' characters left');
  }
});


//send message to seller
$("#sendMessageBtn").click(function() {
    $("#sendMessageForm").validate({
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
			message: {
                required: true,
				maxlength :1000,
            },
		},

        messages: {
			message: {
                required: errorMessage.text_required,
				maxlength: errorMessage.maxlength,
            },
		},

        submitHandler: function(form) {

            jQuery.ajax({
                type: "POST",
                url: urlSendMessage,
                datatype: 'json',
                data: $('form#sendMessageForm').serialize(),
                beforeSend: function() {
                    $('#sendMessageBtn').html('Sending...');
                    $('#sendMessageBtn').attr('disabled', true);
                },
                success: function(json) {
                    data = jQuery.parseJSON(json);
                    //console.log(data);
                    $('#sendMessageBtn').html('Send');
                    $('#sendMessageBtn').removeAttr('disabled');
                    if (data.status == 'success') {
                    	//reset teh form
                        $("#sendMessageForm").trigger('reset');
						
						//add error success message and hide popup
                        setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
							$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
							$('#errorSuccessMesage').html(data.message);
							
							//hide bootstrap modal
							$('#sendMessagePopup').modal('toggle');
                        }, 1000);
						
                    } else {
						
						setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
                       	 	$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
                       	 	$('#errorSuccessMesage').html(data.message);
							
							//hide bootstrap modal
							$('#sendMessagePopup').modal('toggle');
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