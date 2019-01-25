// JavaScript Document
$(document).ready(function () {
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
	$(".updatefile").click(function (){
		if($(this).is(':checked')){
			$("#"+this.dataset.changecontainer).show();
		}else{
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
