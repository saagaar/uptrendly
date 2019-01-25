// JavaScript Document
function selectCategory(name, cat, subcat) {
    console.log(name + ' : ' + cat + ' : ' + subcat);
   //assign name and cat id in hidden fields
	$('#hiddenCatId').val(cat);
    $('#hiddenSubCatId').val(subcat);
	$('#hiddenCatName').val(name);
	$('#chooseCategory').html(name + '<span class="fa fa-angle-down"></span>');
	
   	//removing error message if found  
    console.log($('#hiddenCatField').next('.error').length);
	
    if ($('#hiddenCatField').next('.error').length == 1) {
        $('#hiddenCatField').next('.error').remove();
	}
}




//for public and private
$('#publicPrivate').change(function(){
    //console.log(value);
    if ($(this).val() == 'public') {
        $('#coSellersItemAllotment').show();
    } else {
        $('#coSellersItemAllotment').hide();
    }
});

if ($('#publicPrivate').val() == 'public') {
    $('#coSellersItemAllotment').show();
} else {
    $('#coSellersItemAllotment').hide();
}

<!--add javascript validation rules-->
$('#addHostAuctionBtn').click(function() {
    //alert('submit');
    $("#addHostAuctionForm").validate({
        //by default validation pluginns ignores hidden fields, this will initiailize new ignores for this form. empty means no ignores
        //ignore: [],
		
		errorPlacement: function(error, element) {
			if (element.attr("name") == "start_date_time" )
				error.insertAfter(element.parent());
			else
				error.insertAfter(element);
		},

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

		rules: {
			start_date_time: {
                required: true,
				validDateTime: true
            },
			description: {
                required: true,
				maxlength :300,
            },
            host_name: {
                required: true,
				maxlength :100,
            },
			total_auctions: {
                required: true,
            },
			/*category: {
                required: true
            },*/
           	start_bid_amount: {
                required: true,
				number:true,
            },
            free_shipping: {
                required: true,
			},
			public_private: {
                required: true,
			},
			co_sellers_auctions: {
                required: $("#publicPrivate").val()=='public',
				number:true,
			},
			host_terms: {
                required: true,
			},
        },
        messages: {
			start_date_time: {
                required: "Auction Start Date is Required",
				validDateTime: "IUnvalid date time",
            },
			description: {
                required: "Description field is required",
            },
			host_name: {
                required: "Name field is required",
            },
			total_auctions: {
                required: "Total Items field is required",
            },
			/*category: {
                required: "Please Select Category",
            },*/
			start_bid_amount: {
                required: "Starting Bid Amount is Required"
            },
            free_shipping: {
                required: "Shipping Requirements field is required",
            },
            public_private: {
                required: "Please Select Public or Private",
            },
            co_sellers_auctions: {
                required: "Co seller items field is required",
				number: "Co seller items must be a valid number"
            },
            host_terms: {
                required: "Start Bid field is required",
			},
		},
    });
});