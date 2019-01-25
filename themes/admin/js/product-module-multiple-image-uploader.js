// JavaScript Document
$(document).ready(function () {

/*$('#cLeft').text('Your title has 80 characters remaining');

$('#title').keyup(function () {
    var max = 80;
    var len = $(this).val().length;
    if (len >= max) {
        $("#title").addClass("numericonly");
		$('#cLeft').text('You have reached the limit');
		
    } else {
        var ch = max - len;
        $('#cLeft').text('Your title has '+ ch + ' characters remaining');
    }
});*/


//validation of the seller form
$("#btnPost").click(function(){
 
 $("#sell-form").validate({
						  
      errorElement: 'span',
	
      rules: {
            name:{
				  required:true,
				  rangelength:[2,40]
				  },
			
			product_image1: { required:true	},
           
			condition: { required:true },
            
			quantity:{
				      required:true,
					  number: true
					  },
			
			product_desc:{required:true},
		
		    rrp:{
				required:true,
				number:true
				},
			
			selling_price: {
			 	           required: true,
						   number: true
						   },
		
		    item_type:{required:true},
			
			reserve_price: {
			 	           required: true,
						   number: true
						   },
			
			min_bid_price:{
			 	           required: true,
						   number: true
						   },
			
			max_bid_price:{
			 	           required: true,
						   number: true
						   },
			
			bid_fee:{ 
			               required: true,
						   number: true
						   },
			
			bid_price_increment:{
			 	           required: true,
						   number: true
						   },
			
			shipping_cost:{
			 	           required: true,
						   number: true
						   },
			
			shipping_type:{required:true},
			
			start_date:{ required:true },
			
			end_date:{ required:true }
			
	    },
		
		messages: {
				name: {
	                required: en_lang.text_required,
					rangelength : en_lang.text_range_invalid_name
				      },
		     	product_image1: { required:en_lang.text_required },
           
			    condition: { required:en_lang.text_required },
            
			    quantity:{required:en_lang.text_required},
			
			    product_desc:{required:en_lang.text_required},
			
			    rrp:{
				    required:en_lang.text_required,
				    number:en_lang.text_number
				    },
			
			    selling_price: {
			 	           required:en_lang.text_required,
						   number:en_lang.text_number
						   },
		
		        item_type:{required:en_lang.text_required},
			
			    reserve_price: {
			 	           required: en_lang.text_required,
						   number: en_lang.text_number
						   },
			
			    min_bid_price:{
			 	           required:en_lang.text_required,
						   number: en_lang.text_number
						   },
			
			    max_bid_price:{
			 	           required:en_lang.text_required,
						   number: en_lang.text_number
						   },
			
			    bid_fee:{ 
			               required: en_lang.text_required,
						   number: en_lang.text_number
						   },
			
			    bid_price_increment:{
			 	           required:en_lang.text_required,
						   number: en_lang.text_number
						   },
			
			    shipping_cost:{
			 	           required: en_lang.text_required,
						   number: en_lang.text_number
						   },
			
			    shipping_type:{required:en_lang.text_required},
			
			    start_date:{ required:en_lang.text_required },
			
			    end_date:{ required:en_lang.text_required }
			
				  },
		
		
	           submitHandler: function(form) {
               form.submit();
          }
    });

  });
	
	//Upload more other images	
   $('#btnAddMoreImages').click(function () { 
		if( $('.moreproductimages').length < productMaximumImages )
		   {
            $('#moreproductimages').before('<div class="moreproductimages"> <label class="half text-right">&nbsp;</label><input name="product_image' + counterProductImages + '" type="file" class="file_1" id="dynamicProductImages_' + counterProductImages + '" data-errorcontainer="ProductImageErrorContainer_' + counterProductImages + '" /><a href="javascript:void(0)" class="removeThis delshr" title="Cancel"></a><div class="multipleerror" id="ProductImageErrorContainer_' + counterProductImages + '"></div></div>');
            //browse other documents button
            if ($.isFunction($.fn.filestyle)) {
                $("input#dynamicProductImages_" + counterProductImages).filestyle({
                    image: fileBrowseButtonURL,
                    imageheight: 35,
                    imagewidth: 83,
                    width: 400
                });
            }
            counterProductImages++;
        } else {
            $("#moreproductimages").hide('slow');
        }
    });


    //delete other images browse button
    $(document).delegate('.removeThis', "click", function () {
        switch ($(this).parent().attr('class')) {
            //case 'moreotherdocuments': counterOtherDocuments--; $("#moreotherdocuments").show('slow'); break;
            //case 'moretaxreturn': counterTaxReturn--; $("#moretaxreturn").show('slow'); break;
            //case 'morefinancialstatement': counterFinancialStatement--; $("#morefinancialstatement").show('slow'); break;
        case 'moreproductimages':
            counterProductImages--;
            $("#moreproductimages").show('slow');
            break;
        default:
        }
        $(this).parent().remove();
    });
	
	
	
	//edit image (to show browse image button if image is checked)
	$(".updatefile").click(function () {
		if($(this).is(':checked')){
			//$("#"+this.dataset.changecontainer).hide();
			$("#"+this.dataset.changecontainer).show();
		}
		else{
			//$("#"+this.dataset.changecontainer).show();
			$("#"+this.dataset.changecontainer).hide();
		}
	});	
}); //endof document ready








//check whether to show or hide the bid specific input fields
	function checkListingType(obj) {
    if (obj.value == '2' || obj.value == '3') {
        $('#bid_specific_details').show();
    } else {
        $('#bid_specific_details').hide();
    }
    //alert(obj.value);
}


//added by rabi for toggle between two pages
function showNextPage()
  {    
	$('#first_page').hide();
	$("#1stPage").removeClass('selected');
	$("#2ndPage").addClass('selected');
	$('#second_page').css("display","block");
	 	
  }
  

//added by rabi for displaying search result
function searchCategory() {
    var cat_name = document.getElementById("search_cat").value;
    
    if(cat_name == "")
	 {
	  $("#error_mesgg").html('<span class="error">'+empty_search_field_mesg+'</span>'); 
	   return false;
	 }
    var url1 = search_url;

    jQuery.ajax({
        type: "post",
        url: url1,
        datatype: 'html',
        data: $('form#sell-form').serialize(),
        success: function (data) {
            if (data != '') {
                $("#searchRslt").show();
                $('#searchRslt').html(data);
				
            } else {
                $("#searchRslt").show();
                $("#searchRslt").html('<option>' +no_record_found+ '</option>');
            }
        }
    });
}

function show_btnContinue()
    {
	$('#btnContinue').show();
	//$("input.deactivate").prop("disabled", !this.checked);
	$('#msgCategorySelect').replaceWith("<div class='bg-success bg_nwb' style='display:block;'><p class='text-success'>"+selection_success+"</p></div>");
	}
