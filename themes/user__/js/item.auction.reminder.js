// JavaScript Document
$(document).ready(function(){
	$('#reminderArea').on('click', '#setReminder', function() {
		var uid = $(this).data('uid');
		var host = $(this).data('host');
		var item = $(this).data('item');
		var type = $(this).data('type');
		
		if(host!='' && host!='undefined'){
			//console.log(host);
			
			jQuery.ajax({
				type: "POST",
				url: urlAddReminder,
				datatype: 'json',
				async:false,
				data: {host:host,uid:uid,item:item,type:type},
				success: function(json) {
					data = jQuery.parseJSON(json);
					//console.log(data);
					if (data.status == 'success') {
						//now replace the html element
						$('#reminderArea').html('<div class="btn-gray"><a class="btn_cat" href="javascript:void(0)" id="removeReminder" data-host='+ host +' data-uid='+ uid +' data-type="'+ type +'" data-item="'+ item +'">We\'ll Remind You</a></div>');
					}
				}
			});
		}
	});



	$('#reminderArea').on('click', '#removeReminder', function() {
		var uid = $(this).data('uid');
		var host = $(this).data('host');
		var item = $(this).data('item');
		var type = $(this).data('type');
		
		if(host!='' && host!='undefined'){
			//console.log(host);
			
			jQuery.ajax({
				type: "POST",
				url: urlRemoveReminder,
				datatype: 'json',
				async:false,
				data: {host:host,uid:uid,item:item,type:type},
				success: function(json) {
					data = jQuery.parseJSON(json);
					//console.log(data);
					if (data.status == 'success') {
						//now replace the html element
						if(type=='item'){
							$('#reminderArea').html('<div class="btn-green"><a href="javascript:void(0)" class="btn_cat" id="setReminder" data-host='+ host +' data-uid='+ uid +' data-type="'+ type +'" data-item="'+ item +'">Set a Reminder</a></div>');
						}else{
							$('#reminderArea').html('<div class="btn-yellow"><a href="javascript:void(0)" class="btn_cat" id="setReminder" data-host='+ host +' data-uid='+ uid +' data-type="'+ type +'" data-item="'+ item +'">Set a Reminder</a></div>');
						}
					} 
				}
			});
		}
	});
});