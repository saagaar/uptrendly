// JavaScript Document
$("#verifyAddPaypalBtn").click(function() {
	
	$type = $(this).data('type');
	$("#verifyAddPaypalForm").validate({
		errorElement: 'p',
        errorClass: 'text-danger',
        onkeyup: false,
        highlight: function(element, errorClass, validClass) {
          	$(element).parents("div.form-group").addClass('has-error').removeClass('has-success');
		},

        unhighlight: function(element, errorClass, validClass) {
           	$(element).parents("div.form-group").removeClass('has-error');
		  	$(element).parents(".error").removeClass('has-error').addClass('has-success');
		},

        rules: {
            email: {
                required: true,
                email: true,
                checkDuplicateEmail : true
            },
            fname: {
                required: true,
            },
            lname: {
                required: true,
            }
        },

        messages: {
            email: {
                required: errorMessage.text_required,
                email: errorMessage.text_invalid_email,
                checkDuplicateEmail : errorMessage.duplicateEmail
            },
            fname: {
                required: errorMessage.text_required,
            },
            lname: {
                required: errorMessage.text_required,
            },
        },

        submitHandler: function(form) {

            jQuery.ajax({
                type: "POST",
                url: urlVerifyPaypal,
                datatype: 'json',
                data: $("form#verifyAddPaypalForm").serialize(),
                beforeSend: function() {
					$('#verifyAddPaypalBtn').attr('disabled', true);
					if($type=='verify'){
						$('#verifyAddPaypalBtn').html('Verifying...');
					}else if($type=='add'){
						$('#verifyAddPaypalBtn').html('Saving...');
					}
				},
                success: function(json) {
                    data = jQuery.parseJSON(json);
                    console.log(data);
					$('#verifyAddPaypalBtn').removeAttr('disabled');
					if($type=='verify'){
						$('#verifyAddPaypalBtn').html('Verify');
					}else if($type=='add'){
						$('#verifyAddPaypalBtn').html('Save Changes');
						//hide bootstrap modal
						$('#addNewPaypalAccountPopup').modal('toggle');	
					}
					
					if (data.status == 'success') {
                        $('#errorSuccessMesageArea').css('display', 'block');
                        $('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
                        $('#errorSuccessMesage').html(data.message);
                        $("#verifyAddPaypalForm").trigger('reset');
						
						if($type == 'add'){
							if(data.data.is_default=='yes'){
								var operations = '<button class="btn btn-success" disabled="disabled">Default Account</button>';
							}else{
								var operations = '<button class="btn btn-default" onclick="return deleteAccount(' + data.data.id +')">Delete</button><button class="btn btn-default" onclick="return changePrimaryAccount(' + data.data.id +');">Set Primary</button>';
							}
								
							//append new paypal account to list
							$('#paypalAccounts').append('<li id="paypal' + data.data.id + '"><div class="row form-group clearfix"><div class="col-md-9 col-sm-8 dtl_info"><i class="fa fa-paypal">&nbsp;</i><span class="information"><strong class="name">' + data.data.fname +' '+ data.data.lname +'</strong><strong>' + data.data.email + '</strong></span></div><div class="col-md-3 col-sm-4"><div class="pull-right btn-group-vertical">'+ operations +'</div></div></div></li>');
						}

                        setTimeout(function() {
                            //remove class and html contents
                            $("#errorSuccessMesage").html('');
                            $("#errorSuccessMesageArea").css("display", "none");
                            //redirect to users my account if request is made from verify page
							if($type=='verify'){
                            	window.location.href = site_url + 'my-account/profile';
							}
                        }, 5000);
                    } else {
                        $('#errorSuccessMesageArea').css('display', 'block');
                        $('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
                        $('#errorSuccessMesage').html(data.message);
                    }

                    setTimeout(function() {
                        //remove class and html contents
                        $("#errorSuccessMesage").html('');
                        $("#errorSuccessMesageArea").css("display", "none");
                    }, 5000);
                }
            });
            return false;
        }
    });
});



function deleteAccount(id)
{
	job = confirm("Are you sure to delete permanently?");
    if (job != true) {
        return false;
    } else {
        $.ajax({
            type: "POST",
			datatype: 'json',
            url: urlDeletePaypalAddress,
            data: {
                id: id
            },
            success: function (data) {
				data = jQuery.parseJSON(data);
			 	if(data.status == 'success') {
					//add error success message and hide popup
					setTimeout(function() {
						//show success message
						$('#errorSuccessMesageArea').css('display', 'block');
						$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
						$('#errorSuccessMesage').html(data.message);

						 // add css class to the hiding div
						$('#paypal' + id).addClass("hide-div");
						// hide deleted div 
						$('#paypal' + id).hide(3000);
					}, 1000);
						
				} else {
					setTimeout(function() {
						//show success message
						$('#errorSuccessMesageArea').css('display', 'block');
						$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
						$('#errorSuccessMesage').html(data.message);
					}, 1000);
				}

				setTimeout(function() {
					//remove class and html contents
					$("#errorSuccessMesage").html('');
					$("#errorSuccessMesageArea").css("display", "none");
				}, 15000); 
            }
        });
    }
}



function changePrimaryAccount(id)
{
	job = confirm("Are you sure to change this account to primary?");
    if (job != true) {
        return false;
    } else {
		
        $.ajax({
            type: "POST",
			datatype: 'json',
            url: urlChangePrimaryPaypalAccount,
            data: {
                id: id
            },
            success: function (data) {
				data = jQuery.parseJSON(data);
			 	if(data.status == 'success') {
					//show success message
					$('#errorSuccessMesageArea').css('display', 'block');
					$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
					$('#errorSuccessMesage').html(data.message);
					 // replace div with new data.
					$('#paypalAccounts').html(data.data);
				} else {
						//show success message
						$('#errorSuccessMesageArea').css('display', 'block');
						$('#errorSuccessMesageArea').removeClass('alert-success').addClass('alert-danger');
						$('#errorSuccessMesage').html(data.message);
				}
				setTimeout(function() {
					//remove class and html contents
					$("#errorSuccessMesage").html('');
					$("#errorSuccessMesageArea").css("display", "none");
				}, 15000); 
            }
        });
    	
	}
}