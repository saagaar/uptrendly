// JavaScript Document

$(function() {
    $('#manageAuction').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'i', //holder which contains handle to drag and drop the html element
        update: function(event, ui) {
            var list_sortable = $(this).sortable('toArray').toString();
			//console.log(list_sortable);
			//console.log(host_id);
    		// change order in the database using Ajax
            $.ajax({
                type: 'POST',
				url: UrlDragDropAuctionOrder,
               	dataType: 'json',
                data: {
					host_id:host_id,
					list_order:list_sortable,
				},
                success: function(data) {
                    //finished
					
				}
            });
        }
    }); // finished sortable
});



$('.unschedule_me').click(function(){
	var job = confirm('Are you sure');
	//console.log(job);
	if(job!=true){
		return false;
	}
	
	var pid = $(this).data('pid');
	var host = $(this).data('host');
	var order = $(this).data('order');
	//console.log(pid + ' : ' + host + ' : ' + order);	//return;
	
	if(pid!='undefined' && pid!='' && host!='undefined' && host!='' && order!='undefined' && order!=''){
		$.ajax({
			type: 'POST',
			url: UrlUnscheduleAuction,
			dataType: 'json',
			data: {
				host:host,
				pid:pid,
				order:order
			},
			success: function(data) {
				//finished
				console.log(data);
				if(data.result=='success'){
					//remove the element from 
					//console.log($('#manageAuction').children().length);
					$('tr#' + pid).hide('slow', function(){ $('tr#' + pid).remove(); });
					
					$('#errorSuccessMesageArea').css('display', 'block');
					$('#errorSuccessMesageArea').removeClass('alert-danger').addClass('alert-success');
					$('#errorSuccessMesage').html(data.message);
					
					//console.log($('#manageAuction').children().length);
					if($('#manageAuction').children().length <= 1){
						$('#manageItemsContainer').html('No Auction found in Host');
						//console.log('no data found in side ');
					}
					
				}else if(data.result=='error'){
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
	}
	
});