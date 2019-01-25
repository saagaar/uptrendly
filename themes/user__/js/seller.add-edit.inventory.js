// JavaScript Document
//script for show hide brand detail on brand radio click

if ($('input[name=free_shipping]:checked', '#addProductForm').val() == '0') {
    $('#shippingDetails').show();
	//console.log("Show " + $('input[name=free_shipping]:checked').val());
} else {
    $('#shippingDetails').hide();
	//console.log(" Hide " + $('input[name=free_shipping]:checked').val());
}


//function to add custom fields
function addThis(name, cat, subcat) {
    //console.log(name + ' : ' + cat + ' : ' + subcat);
    var id = (subcat != 0 && subcat != 'undefined') ? subcat : cat;
    $('#hiddenCat').val(cat);
    $('#hiddenSubCat').val(subcat);
	
	//console.log(id);

    //assign name and cat id in hidden fields
    $('#hiddenCatField').val(id);
    $('#hiddenCatName').val(name);

    //removing error message if found  
    //console.log($('#hiddenCatField').next('.error').length);
    if ($('#hiddenCatField').next('.text-danger').length == 1) {
        $('#hiddenCatField').next('.text-danger').remove();
    }

    if (id != '') {
        $.ajax({
            type: 'POST',
            url: UrlFetchCustomFields,
            dataType: 'json',
            data: {
                category: id,
            },
            success: function(data) {
                //console.log(data);
                //alert(data);
                if (data.status == 'success') {
                    $("#additionalCustomFields").css("display", "block");
                    $('#additionalCustomFields').html(data.html);
                } else {
                    $("#additionalCustomFields").html('');
					$("#additionalCustomFields").css("display", "none");
                }
                $('#chooseCategory').html(name + '<span class="fa fa-angle-down"></span>');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //$('#waiting').hide(500);
                //$('#message').removeClass().addClass('error').text('There was an error.').show(500);
                //$('#demoForm').show(500);  
                alert('error');
            }
        });
    }
}



<!--add javascript validation rules-->
$('#addProductBtn').click(function() {
    //alert('submit');
    $("#addProductForm").validate({
        //by default validation pluginns ignores hidden fields, this will initiailize new ignores for this form. empty means no ignores
        ignore: [],

        errorElement: 'p',
        errorClass: 'text-danger',

        highlight: function (element, errorClass, validClass) { 
          $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
        }, 
        unhighlight: function (element, errorClass, validClass) { 
        	$(element).parents("div.form-group").removeClass('has-error'); 
        	$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
        },
		
		submitHandler: function(form) {
			//myDropzone.processQueue();
            form.submit();
        },
		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") 
				error.insertAfter(element.parent().siblings().last());
			else
				error.insertAfter(element);
		},
		rules: {
            category: {
                required: true
            },
            name: {
                required: true,
                maxlength :100,
            },
            description: {
                required: true,
                maxlength :300,
            },
            auction_type: {
                required: true,
            },
            auction_time_zone: {
                required: true,
            },
            currency: {
                required: true,
            },
            bid_decrement: {
                required: true,
                number:true,
            },
            auc_start_time: {
                required: true,             
                validDateTime: true
            },
            auc_end_days: {
                required: true,
                number: true,
            },
            price:{
                required: true,
                number:true,
                min:1
            }
            
        },
        messages: {
            category: {
                required: "Please Select category to Proceed"
            },
            name: {
                required: "Name field is required",
            },
            description: {
                required: "Description field is required",
            },
            auction_type: {
                required: "Auction Type field is required",
            },
            auction_time_zone: {
                required: "Auction Time Zone field is required",
            },
            
            currency: {
                required: "Currency field is required",
            },
            
            bid_decrement: {
                required: "Bid Decrement Amount field is required",
                number: "Bid Decrement Amount must be a valid number"
            },
            auc_start_time: {
                required: "Auction Start Time field is required", 
                validDateTime: "Invalid date time",
            },
            auc_end_days: {
                required: "Auction End Days field is required",
                number: errorMessage.number, 
            },

            price: {
                required: "Previous or Prospective Spend Field is required",
                number: "Previous or Prospective Spend Amount must be a valid number"
            },
            
        },
    });
});


//remove image from dropzone area
$(".remove_image").on("click", function(e) {
	e.preventDefault();
	//e.stopPropagation();
	var imgid = $(this).data('imgid');
	var imgname = $(this).data("imgname");
	var pid = $(this).data("pid");
	var job = $(this).data('job');
	var pcode = $(this).data('pcode');
	
	//console.log('Job:' + job + ' # image id:' + imgid + ' # Image Name:'+ imgname + ' # Product ID:' + pid + ' #Pcode:' + pcode);
	
	if((job=='edit' && pid!='' && imgname!='') || (job=='relist' && imgname!='')){
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: (job=='edit')?UrlDeleteImage:UrlRemoveDropzoneTempImage,
			data: {
				name: imgname,
				pid: pid,
				pcode: pcode,
			},
			success: function(data){
				//console.log(data);
				if (data.result == "success") {
					//remove image from dropzone area
					$('#' + imgid).hide(1000,function() { $(this).remove(); } );
					//console.log('#' + imgname);
					
					//add maxFile limit in dropzone config file
					
					myDropzone.options.maxFiles = data.image_quota;
					//myDropzone.options.dictDefaultMessage = "Pradip";
					myDropzone.options.dictDefaultMessage = (data.image_quota>0?"Drop files here to upload":"Remove images to upload new image");
				} else {
					//do nothing                          
				}
			},
			error: function(errors) {
				console.log(errors);
			}
		});
	}
});




$('.update_metafile').click(function() {
  	if ($(".update_metafile").is(":checked")){
		$(this).nextAll("input.metafile:first").show();

        
		//$(this).nextAll("input.metafile:first").attr("required", "true");
        $('.bootstrap-filestyle').show();
        //
	}else{
        $('.bootstrap-filestyle').hide();
        
	}
});