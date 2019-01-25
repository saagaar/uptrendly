// JavaScript Document
$(document).ready(function() {
	$(".show-hide-trigger").click(function(){
		$hostid = $(this).data('hostid');
		
		//for show hide
		$(this).closest('tr').next().toggle("fast");
		$(this).toggleClass("expand2");
		
		//check whether this div contains children or not
		//run ajax if it doesnot contains children elements
		if($('#coHostforHost' + $hostid).children().length <= 0){
			if($hostid!='' && $hostid!=undefined){
				//run ajax to fetch merchants of that specific element
				$.ajax({
					type: 'POST',
					url: UrlFetchHostAuctionSellers,
					dataType: 'json',
					data: {
						hostid: $hostid,
					},
					success: function(data) {
						console.log(data);
						//alert(data);
						if (data.status == 'success') {
							$("#coHostforHost" + $hostid).html(data.html);
						} /*else {
							$("#additionalCustomFields").html('');
							$("#additionalCustomFields").css("display", "none");
						}*/
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						//$('#waiting').hide(500);
						//$('#message').removeClass().addClass('error').text('There was an error.').show(500);
						//$('#demoForm').show(500);  
						alert('Error Occured.');
					}
				});
			}
		}	
	});
});
