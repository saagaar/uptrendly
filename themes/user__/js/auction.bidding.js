// JavaScript Document
function storageUtility(){
	this.aid = 0;
	this.pid = 0;
	this.uid = 0;  //user id
	this.bid_time = 0;
	this.auction_end_time = 0;
	this.server_current_time = 0;
	this.remaining_time = 0;
	this.reset_time = 0;
	this.bid_increment = 0;
}

var myVars = new storageUtility();  //this object stores variables needed for auction updater.
	
function auctionUpdater(){
	//console.log("Inside Object == aid:"+myVars.aid+" # pid:"+myVars.pid+" #auction_end_time:"+ myVars.auction_end_time + " #server_current_time"+myVars.server_current_time);
	
	this.updateTimer = function () {
		
		if ((myVars.auction_end_time - myVars.server_current_time) > 0) {
			myVars.server_current_time++;
			var auc_timer = this.formattedDate(myVars.auction_end_time - myVars.server_current_time);
			// console.log(myVars.server_current_time);
			// console.log(auc_timer);
			// console.log(myVars.pid);
			$("#timer_" + myVars.pid).html(auc_timer);
			// $("#timer_" + myVars.pid).html(myVars.auction_end_time - myVars.server_current_time);
			$("#remainingTime").val((myVars.auction_end_time - myVars.server_current_time));
			//console.log("pid : "+myVars.pid);
		} else if ((myVars.auction_end_time - myVars.server_current_time) == 0) {
			//perform emit auction closed information to operation
			//socket.emit('auction_time_finished', {'aid':myVars.aid,'pid':myVars.pid,'bid_time':myVars.bid_time});
			$('#placeBidBtn').attr("disabled", true);
			$('#placeBidBtn').html("Closed");
			//console.log("Auction End Triggered");
			$("#timer_" + myVars.pid).html('Closed Now');
		} else {
			$("#timer_" + myVars.pid).html('Closed');
			//$('#placeBidBtn').html("Closed");
			console.log(myVars.auction_end_time - myVars.server_current_time);
		}
	}
	this.formattedDate = function(time_left){
		if (time_left >= 0 && time_left <= 60)
			// return time_left + 's';
			return '<li><div class="clock">'+time_left+'</div><p>Sec</p></li>'

		var oneMinute = 60;
		var oneHour = oneMinute * 60;
		var oneDay = oneHour * 24;
		
		var dayfield = Math.floor(time_left / oneDay);
		var hourfield = Math.floor((time_left - dayfield * oneDay) / oneHour);
		var minutefield = Math.floor((time_left - dayfield * oneDay - hourfield * oneHour) / oneMinute);
		var secondfield = Math.floor((time_left - dayfield * oneDay - hourfield * oneHour - minutefield * oneMinute));
		
		if (dayfield > 0 && dayfield < 10) {
			dayfield ='<li><div class="clock">0'+ dayfield + '</div><p>Days</p></li>'; 
		} else if (dayfield > 0 && dayfield >= 10) {
			dayfield ='<li><div class="clock">'+ dayfield + '</div><p>Days</p></li>'; 
		} else {
			dayfield = '<li><div class="clock">00</div><p>Days</p></li>';
		}
		
		if (hourfield < 10)
			hourfield = '0'+ hourfield; 
		if (minutefield < 10)
			minutefield = '0'+ minutefield;
		if (secondfield < 10)
			secondfield = '0'+ secondfield;
		if (dayfield == 00) {
			if (hourfield == 00) {
				if (minutefield == 00) {
					return '<li><div class="clock">'+ secondfield + '</div><p>Sec</p></li>';
				}
				return '<li><div class="clock">' + minutefield + '</div><p>Min</p></li>' + '<li><div class="clock">'+ secondfield + '</div><p>Sec</p></li>';
			}
			return '<li><div class="clock">' + hourfield + '</div><p>Hrs</p></li>'+'<li><div class="clock">' + minutefield + '</div><p>Min</p></li>' + '<li><div class="clock">'+ secondfield + '</div><p>Sec</p></li>';

		} else {
			return dayfield + '<li><div class="clock">' + hourfield + '</div><p>Hrs</p></li>'+'<li><div class="clock">' + minutefield + '</div><p>Min</p></li>' + '<li><div class="clock">'+ secondfield + '</div><p>Sec</p></li>';
		}
	}	
}


<!--add javascript validation rules-->
$('#placeBid').click(function() {
	var budget=Number($('#budget').val());
	var bid_decrement=Number($('#bid_decrement').val());

    
    $("#placeBidForm").validate({
        //by default validation pluginns ignores hidden fields, this will initiailize new ignores for this form. empty means no ignores
        ignore: [],

        errorElement: 'span',
        errorClass: 'text-danger',

        highlight: function (element, errorClass, validClass) { 
          $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
        }, 
        unhighlight: function (element, errorClass, validClass) { 
        	$(element).parents("div.form-group").removeClass('has-error'); 
        	$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
        },
		
		
		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") 
				error.insertAfter(element.parent().siblings().last());
			else
				error.insertAfter(element);
		},
		rules: {
            bid_amount: {
                required: true,
                number : true,
                min: bid_decrement,
                max:budget
            },
            
            bid_description: {
                required: true,
            },           
            terms_and_conditions: {
                required: true,
            },
            bid_attachment: {		      
		       accept:"doc,docx,xls,xlsx,pdf"
		    }            
        },
        messages: {            
            bid_amount: {
                required: errorMessage.required,
                number : errorMessage.number,
                min: errorMessage.min,
            },
            bid_description: {
                required: errorMessage.required,
            },
            
            terms_and_conditions: {
                required: "You must agree on terms and conditions",
            }, 
            bid_attachment: {		      
		       accept: "Only file type doc/docx/xls/xlsx/pdf is allowed",
		    }            
        },
        submitHandler: function(form) {
        	var formData = new FormData($('#placeBidForm')[0]);

            jQuery.ajax({
			type : "POST",
			url : bid_url,
			datatype : 'json',
			processData: false,
			contentType: false,
			beforeSend : function () {
				$("#bidResponse").html('<img src="' + img_src + '">');
				$("#placeBid").attr("disabled", true);
			},
			complete : function () {
				$("#placeBid").removeAttr("disabled");
				$('#placeBidForm').trigger('reset');
			},
			// data : $('#placeBidForm').serialize(),
			data : formData,
			success : function (data) {
				console.log(data);
				var response = jQuery.parseJSON(data);
	
				$('html, body').animate({
					scrollTop : $("#bidResponse").offset().top
				}, 'slow');
				



					

	
				if (response.status == "success") {
					initializecharts()
					$('#bidResponse').replaceWith("<div class='alert alert-success' id='bidResponse' style='display:block;'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + response.message + "</div>");
					$('#biddesc').html(response.data.bid_details);
					console.log(response);
					$('#bid_attachment').data('placeholder',response.data.attachment);
					// $('#bidamt').val(0.00);
					$('#bidamt').val(parseFloat(response.data.user_bid_amt));

				} else {
					$('#bidResponse').replaceWith("<div class='alert alert-danger' id='bidResponse' style='display:block;'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + response.message + "</div>");
				}
			},
		}); //jquery ajax ends here
		return false;
        },
    });
});


$(document).ready(function () {
    $('#bidamt').focusout(function (e) {
        if (this.value != '') {
            twoDecVal = parseFloat(this.value).toFixed(2);
            if (isNaN(twoDecVal)) {
                twoDecVal = 0.00;
            }
            this.value = twoDecVal;
        }
    });
});