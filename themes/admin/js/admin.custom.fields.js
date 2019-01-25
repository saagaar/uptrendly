// JavaScript Document

var selected_data_type = $('#dataType').val();
//console.log(selected_data_type);
if(selected_data_type=='DROPDOWN' || selected_data_type=='RADIO'){
	$('#optionField').css('display','inline-block');
	$('.file-field').css('display','none');
	$('.number-field').css('display','none');
	$('.text-field').css('display','none');
	$('.exact-length-field').css('display','none');
	$('.length-range-field').css('display','none');
}else if(selected_data_type=='FILE'){
	$('#optionField').css('display','none');
	$('.file-field').css('display','inline-block');
	$('.number-field').css('display','none');
	$('.text-field').css('display','none');
	$('.exact-length-field').css('display','none');
	$('.length-range-field').css('display','none');
}else if(selected_data_type=='EMAIL'){
	$('#optionField').css('display','none');
	$('.file-field').css('display','none');
	$('.number-field').css('display','none');
	$('.text-field').css('display','none');
	$('.exact-length-field').css('display','none');
	$('.length-range-field').css('display','none');
}else if(selected_data_type=='NUMBER'){
	$('#optionField').css('display','none');
	$('.file-field').css('display','none');
	$('.number-field').css('display','inline-block');
	$('.text-field').css('display','none');
	$('.exact-length-field').css('display','none');
	$('.length-range-field').css('display','none');
}else if(selected_data_type=='TEXT' || selected_data_type=='TEXTAREA'){
	$('#optionField').css('display','none');
	$('.file-field').css('display','none');
	$('.number-field').css('display','none');
	$('.text-field').css('display','inline-block');
	
	//console.log($("input[name='choose_group']:checked").val());
	if($("input[name='choose_group']:checked").val()=='exact_length'){
		$('.length-range-field').css('display','none');
		$('.exact-length-field').css('display','inline-block');
	}else if($("input[name='choose_group']:checked").val()=='length_range'){
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','inline-block');
	}
}else{
	$('#optionField').css('display','none');
	$('.file-field').css('display','none');
	$('.number-field').css('display','none');
	$('.text-field').css('display','none');
	$('.exact-length-field').css('display','none');
	$('.length-range-field').css('display','none');
}



$('#dataType').change(function(){
	var selected_data_type = $('#dataType').val();
	//console.log(selected_data_type);
	if(selected_data_type=='DROPDOWN' || selected_data_type=='RADIO'){
		$('#optionField').css('display','inline-block');
		$('.file-field').css('display','none');
		$('.number-field').css('display','none');
		$('.text-field').css('display','none');
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','none');
	}else if(selected_data_type=='FILE'){
		$('#optionField').css('display','none');
		$('.file-field').css('display','inline-block');
		$('.number-field').css('display','none');
		$('.text-field').css('display','none');
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','none');
	}else if(selected_data_type=='EMAIL'){
		$('#optionField').css('display','none');
		$('.file-field').css('display','none');
		$('.number-field').css('display','none');
		$('.text-field').css('display','none');
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','none');
	}else if(selected_data_type=='NUMBER'){
		$('#optionField').css('display','none');
		$('.file-field').css('display','none');
		$('.number-field').css('display','inline-block');
		$('.text-field').css('display','none');
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','none');
	}else if(selected_data_type=='TEXT' || selected_data_type=='TEXTAREA'){
		$('#optionField').css('display','none');
		$('.file-field').css('display','none');
		$('.number-field').css('display','none');
		$('.text-field').css('display','inline-block');
		//$('.exact-length-field').css('display','none');
		//$('.length-range-field').css('display','none');
	}else{
		$('#optionField').css('display','none');
		$('.file-field').css('display','none');
		$('.number-field').css('display','none');
		$('.text-field').css('display','none');
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','none');
	}
});



$("input[name='choose_group']").click(function() {
	//console.log($("input[name='choose_group']").val());
	//console.log($(this).val());
	if($(this).val()=='exact_length'){
		$('.exact-length-field').css('display','inline-block');
		$('.length-range-field').css('display','none');
	}else{
		$('.exact-length-field').css('display','none');
		$('.length-range-field').css('display','inline-block');
	}
});


//accordion in category
$(".accordionContent").hide(); //close all div on page load
$('.accordionTrigger').click(function() {
	$(this).closest('span.accordionTrigger').toggleClass('expandme');
	$(this).parent().last().find('ul.accordionContent').slideToggle('normal');
})

//check all the child checkboxes if parent is checked
function checkChilds(obj){
	$('.subcat' + obj.value).prop("checked",$('.cat' + obj.value).prop("checked"))
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


//function to fetch custom fields by category
function addThis(name, cat, subcat) {
	//console.log(name + ' : ' + cat + ' : ' + subcat);
	var id = (subcat != 0 && subcat != 'undefined') ? subcat : cat;
	
	if (id && id != '' && id!='undefined') {
		//assign name and cat id in hidden fields
		$('#hiddenCatField').val(id);
		$('#hiddenCatName').val(name);

		//ajac call to fetch custom fields
		$.ajax({
			type: 'POST',
			url: UrlFetchCustomFields,
			dataType: 'json',
			data: {category: id,},
			success: function(data) {
				//console.log(data);
				//alert(data);
				if (data.status == 'success') {
					$('#customFields').html(data.html);
				} else {
					$("#customFields").html('');
				}
				$('#chooseCategory').html(name);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				//$('#waiting').hide(500);
				//$('#message').removeClass().addClass('error').text('There was an error.').show(500);
				//$('#demoForm').show(500);  
				alert('error');
			}
		});
	}
	return false;
}


//function to change custom fields position only if the page is view custom fields page
if(operation != 'undefined' && operation=='view'){
$(function() {
    $('#customFields').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = $(this).sortable('toArray').toString();
			var category = $('#hiddenCatField').val();
			console.log(category);
			console.log(list_sortable);
    		// change order in the database using Ajax
            $.ajax({
                type: 'POST',
				url: UrlDragDropFieldOrder,
               	dataType: 'json',
                data: {
					list_order:list_sortable,
					category_id:category
				},
                success: function(data) {
                    //finished
					
				}
            });
        }
    }); // finished sortable
});
}//End Of if condition