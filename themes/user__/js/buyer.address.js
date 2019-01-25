// JavaScript Document
function getStates(type,obj)
{
	//console.log(type);
	//console.log(obj.value);
    var country_id = obj.value;
    if (country_id != '') {
        $.ajax({
            type: 'POST',
            url: dynamic_state_path,
            dataType: 'html',
            data: {
                country_id: country_id,
            },
            success: function(data) {
                //alert(data);
				if(type=='edit'){
                	$('#stateFieldEdit').html(data);
				}else{
					$('#stateField').html(data);
				}
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                /*$('#waiting').hide(500);
				$('#message').removeClass().addClass('error').text('There was an error.').show(500);
				$('#demoForm').show(500);  */
                alert('error');
            }
        });
    }
}

function addFormElementValues(aid,first_name,last_name,street1,street2,city,post_code,country,state)
{
	//.log(country);
	//console.log(state);
	//reset the form
	$("#editAddressForm").trigger('reset');
	//show bootstrap modal
	$('#editAddressPopup').modal('show');
	//now assign values to the form elements
	$('#aid').val(aid);
	$('#fname').val(first_name);
	$('#lname').val(last_name);
	$('#street1').val(street1);
	$('#street2').val(street2);
	$('#city').val(city);
	$('#post_code').val(post_code);
	$('#state').val(state);
	//remove selected one and select new value
	//$('option:selected', 'select[name="country"]').removeAttr('selected');
	$("#country").find('option').removeAttr("selected");
	$('#country').find('option[value="' + country + '"]').attr("selected",true);
	$("#country").val(country);
}

function addMailingAddress(id)
{
	job = confirm("Are you sure to add this address as a primary shipping addres?");
    if (job != true) {
        return false;
    } else {
		$.ajax({
            type: "POST",
			datatype: 'json',
            url: urlAddMailingAddress,
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
					
					var new_field ='';
					
					$.each(data.data, function(key, value) {
						//console.log(value);
						var seller_mailing = '';
						if(value.is_mailing_address=='no'){
							seller_mailing = '<a href="javascript:void(0);" onclick="return addMailingAddress(\''+ value.id +'\');"><i class="fa fa-truck">&nbsp;</i></a>';
						}
						//console.log(seller_mailing);
			
					new_field += '<li id="address' + value.aid + '"><div class="row form-group clearfix"><div class="col-md-9 col-sm-8 dtl_info"><i class="fa fa-map-marker">&nbsp;</i><span class="information"><strong class="name">' + value.first_name +' '+ value.last_name +'</strong><strong>' + value.street_adress_1 + '</strong><strong>' + value.street_adress_2 + '</strong><strong>' + value.city +' '+ value.state +' '+ value.post_code + '</strong><strong>' + value.country_name + '</strong></span></div><div class="col-md-3 col-sm-4"><div class="option_link pull-right"><a href="javascript:void(0);" onclick="return deleteAddress('+ value.id +')"><i class="fa fa-times">&nbsp;</i></a><a href="javascript:void(0)" onclick="return addFormElementValues(\'' + value.id + '\',\''+ value.first_name +'\',\''+ value.last_name +'\',\''+ value.street_adress_1 +'\',\''+ value.street_adress_2 +'\',\''+ value.city +'\',\''+ value.post_code +'\',\''+ value.country +'\',\''+ value.state +'\')"><i class="fa fa-pencil">&nbsp;</i></a>' + seller_mailing + '</div></div></div></li>';
					});
					
					$('#addressBooks').html(new_field);
					
				} else {
					//show success message
					$('#errorSuccessMesageArea').css('display', 'block');
					$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
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


function deleteAddress(id)
{
	job = confirm("Are you sure to delete permanently?");
    if (job != true) {
        return false;
    } else {
        $.ajax({
            type: "POST",
			datatype: 'json',
            url: urlDeleteAddress,
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
						$('#address' + id).addClass("hide-div");
						// hide deleted div 
						$('#address' + id).hide(3000);
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

//Add new address
$("#addNewAddressBtn").click(function() {
    $("#addNewAddressForm").validate({
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
			fname: {
                required: true,
            },
			lname: {
                required: true,
            },
			adress1: {
                required: true,
            },
			city: {
				required: true,
			},
			post_code: {
                required: true,
            },
			country : {
				required: true,
			},
			state : {
				required: true,
			}
		},

        messages: {
			fname: {
                required: errorMessage.text_required,
            },
			lname: {
                required: errorMessage.text_required,
            },
			adress1: {
                required: errorMessage.text_required,
            },
			city: {
				required: errorMessage.text_required,
			},
			post_code: {
                required: errorMessage.text_required,
            },
			country : {
				required: errorMessage.text_required,
			},
			state : {
				required: errorMessage.text_required,
			}
		},

        submitHandler: function(form) {

            jQuery.ajax({
                type: "POST",
                url: urlAddBuyerAddress,
                datatype: 'json',
                data: $('form#addNewAddressForm').serialize(),
                beforeSend: function() {
                    $('#addNewAddressBtn').html('Saving...');
                    $('#addNewAddressBtn').attr('disabled', true);
                },
                success: function(json) {
                    data = jQuery.parseJSON(json);
                    console.log(data);
                    $('#addNewAddressBtn').html('Add');
                    $('#addNewAddressBtn').removeAttr('disabled');

                    if (data.status == 'success') {
                    	//reset the form
                        $("#addNewAddressForm").trigger('reset');
						
						//add error success message and hide popup
                        setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
							$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
							$('#errorSuccessMesage').html(data.message);
							
							var seller_mailing = '';
							if(data.paypal_verified=='Yes' && data.data.is_mailing_address=='no'){
								seller_mailing = '<a href="javascript:void(0);" onclick="return addMailingAddress(\''+ data.data.aid +'\');"><i class="fa fa-truck">&nbsp;</i></a>';
							}
							
							var new_field = '<li id="address' + data.data.aid + '"><div class="row form-group clearfix"><div class="col-md-9 col-sm-8 dtl_info"><i class="fa fa-map-marker">&nbsp;</i><span class="information"><strong class="name">' + data.data.fname + data.data.lname +'</strong><strong>' + data.data.address1 + '</strong><strong>' + data.data.address2 + '</strong><strong>' + data.data.city +' '+ data.data.state +' '+data.data.post_code + '</strong><strong>' + data.data.country_name + '</strong></span></div><div class="col-md-3 col-sm-4"><div class="option_link pull-right"><a href="javascript:void(0);" onclick="return deleteAddress('+ data.data.aid +')"><i class="fa fa-times">&nbsp;</i></a><a href="javascript:void(0)" onclick="return addFormElementValues(\'' + data.data.aid + '\',\''+ data.data.fname +'\',\''+ data.data.lname +'\',\''+ data.data.address1 +'\',\''+ data.data.address2 +'\',\''+ data.data.city +'\',\''+ data.data.post_code +'\',\''+ data.data.country +'\',\''+ data.data.state +'\')"><i class="fa fa-pencil">&nbsp;</i></a>'+ seller_mailing +'</div></div></div></li>';
							
							$('#addressBooks').append(new_field);
						
							//hide bootstrap modal
							$('#addNewAddressPopup').modal('toggle');
                        }, 1000);
						
                    } else {
						
						setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
                       	 	$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
                       	 	$('#errorSuccessMesage').html(data.message);
							
							//hide bootstrap modal
							$('#addNewAddressPopup').modal('toggle');
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



$("#editAddressBtn").click(function() {
    $("#editAddressForm").validate({
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
			fname: {
                required: true,
            },
			lname: {
                required: true,
            },
			adress1: {
                required: true,
            },
			city: {
				required: true,
			},
			post_code: {
                required: true,
            },
			country : {
				required: true,
			},
			state : {
				required: true,
			}
		},

        messages: {
			fname: {
                required: errorMessage.text_required,
            },
			lname: {
                required: errorMessage.text_required,
            },
			adress1: {
                required: errorMessage.text_required,
            },
			city: {
				required: errorMessage.text_required,
			},
			post_code: {
                required: errorMessage.text_required,
            },
			country : {
				required: errorMessage.text_required,
			},
			state : {
				required: errorMessage.text_required,
			}
		},

        submitHandler: function(form) {

            jQuery.ajax({
                type: "POST",
                url: urlEditBuyerAddress,
                datatype: 'json',
                data: $('form#editAddressForm').serialize(),
                beforeSend: function() {
                    $('#editAddressBtn').html('Saving...');
                    $('#editAddressBtn').attr('disabled', true);
                },
                success: function(json) {
                    data = jQuery.parseJSON(json);
                   	console.log(data);
                    $('#editAddressBtn').html('Edit');
                    $('#editAddressBtn').removeAttr('disabled');

                    if (data.status == 'success') {
                    	//reset teh form
                        $("#editAddressForm").trigger('reset');
						
						//add error success message and hide popup
                        setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
							$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
							$('#errorSuccessMesage').html(data.message);
							
							
							var seller_mailing = '';
							if(data.paypal_verified=='Yes' && data.data.is_mailing_address=='no'){
								seller_mailing = '<a href="javascript:void(0);" onclick="return addMailingAddress(\''+ data.data.aid +'\');"><i class="fa fa-truck">&nbsp;</i></a>';
							}
					
							var new_field = '<li id="address' + data.data.aid + '"><div class="row form-group clearfix"><div class="col-md-9 col-sm-8 dtl_info"><i class="fa fa-map-marker">&nbsp;</i><span class="information"><strong class="name">' + data.data.fname +' '+ data.data.lname +'</strong><strong>' + data.data.address1 + '</strong><strong>' + data.data.address2 + '</strong><strong>' + data.data.city +' '+ data.data.state +' '+ data.data.post_code + '</strong><strong>' + data.data.country_name + '</strong></span></div><div class="col-md-3 col-sm-4"><div class="option_link pull-right"><a href="javascript:void(0);" onclick="return deleteAddress('+ data.data.aid +')"><i class="fa fa-times">&nbsp;</i></a><a href="javascript:void(0)" onclick="return addFormElementValues(\'' + data.data.aid + '\',\''+ data.data.fname +'\',\''+ data.data.lname +'\',\''+ data.data.address1 +'\',\''+ data.data.address2 +'\',\''+ data.data.city +'\',\''+ data.data.post_code +'\',\''+ data.data.country +'\',\''+ data.data.state +'\')"><i class="fa fa-pencil">&nbsp;</i></a>' + seller_mailing + '</div></div></div></li>';

							$('#address' + data.data.aid).replaceWith(new_field);
							
							
							//hide bootstrap modal
							$('#editAddressPopup').modal('toggle');
                        }, 1000);
						
                    } else {
						
						setTimeout(function() {
							//show success message
							$('#errorSuccessMesageArea').css('display', 'block');
                       	 	$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
                       	 	$('#errorSuccessMesage').html(data.message);
							
							//hide bootstrap modal
							$('#editAddressPopup').modal('toggle');
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