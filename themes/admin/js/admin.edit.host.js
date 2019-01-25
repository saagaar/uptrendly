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



//for open close category menu
$(".ddmenu").on("click", function(e) {
    e.preventDefault();
    e.stopPropagation();
    if ($(this).hasClass("open")) {
        $(this).removeClass("open");
        $(this).children("ul").slideUp("fast");
    } else {
        $(this).addClass("open");
        $(this).children("ul").slideDown("fast");
    }
});
//for closing on click on anywhere    
$(document).click(function (e){
	if($('.ddmenu').hasClass("open")){
		var container = $('.ddmenu');
		if (!container.is(e.target) && container.has(e.target).length === 0){
			// if the target of the click isn't the container...
			// ... nor a descendant of the container
			console.log('outside');
			$('.ddmenu').removeClass("open");
			$('.ddmenu').children("ul").slideUp("fast");
		}
	}
});



	// JavaScript Document
	$('#editHostAuctionBtn').click(function(){
		//alert('submit');
		$("#editHost").validate({
			//by default validation pluginns ignores hidden fields, this will initiailize new ignores for this form. empty means no ignores
			ignore: [],
			
			
			submitHandler: function(form){
				form.submit();	
			},
			
			errorElement: 'div',
			errorClass: 'error',
			
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
