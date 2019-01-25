// JavaScript Document

//function to check all the messages in batch by check box
    $("#msg_all").click(function() {
		$(".msg_row").prop("checked", $("#msg_all").prop("checked"))
	})
	//end of check in batch function
		

	$("#btn_delete").click(function() {
        $("#adminInboxForm").validate({
            submitHandler: function(form) {
				var option_conversation_actions = $("#conversationAction").val();
				if (option_conversation_actions == '') {
					$('#mail_error').html('<div class="text-danger" style="display:block;"><strong>Warning! </strong>Select Action<p class="text-success"></p></div>');
                    //alert("Please select more action"); 
                    return false;
                } else if ($(".msg_row:checkbox:checked").length > 0) {
                    form.submit();
                } else {
                    $('#mail_error').html('<div class="text-danger" style="display:block;"><strong>Warning! </strong>Select Message<p class="text-success"></p></div>');
                    //alert('Please select message'); 
                    return false;
                }
            }
        }); //form validation ends here
    }); //end click function
	
	
	//toggle reply form
	$('#triggerReply').click(function(){
		$('#replyForm').toggle();
		
		if($('#replyForm:visible').length == 1){
			$('html, body').animate({
				'scrollTop' : $("#replyForm").position().top
			});		
		}	
	});
	
	 $("#replyBtn").click(function() {
        $("#replyForm").validate({
			submitHandler: function(form) {
				if ($("#replyMessage").val() == '') {
					$('#messageError').addClass('text-danger');
					$('#messageError').html('Please Enter Message');
					//alert("Please select more action"); 
                   	return false;
                }
                form.submit();
            }
        }); //formid validate
    }); //formid validate

//validation of buyer to send message
$("#communicationwithsupplierbtn").click(function() {

        $("#communicationwithsupplierform").validate({
        
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
				message: {
                    required: true,
                },
               
				attachmentcommunication: {     		      
		       			accept:"doc,docx,xls,xlsx,pdf,jpg,jpeg,png"
		   
                }
            },

            messages: {
			
                message: {
                    required: errorMessage.required,
					
                },
                attachmentcommunication: {
                   accept: "Only file type doc/docx/xls/xlsx/pdf/jpeg/jpg/png is allowed"
					
                }
                
            },
            submitHandler: function(form) {
				form.submit();
            	// return false;
        	}
        });
    });
if(document.getElementById('uploadBtn')){
	document.getElementById("uploadBtn").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
	};
}