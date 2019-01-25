
	$(document).on('click','.sendproposal',function(e){
		e.preventDefault();
		document.getElementById('proposalform').reset();
		var productid=$(this).data('productid');
		var media=$('#'+productid+'_socialmediaid').data('media');
		var mediaid=$('#'+productid+'_socialmediaid').val();
		$('#mediaid').val(mediaid);
		$('#productid').val(productid);
		$('.user_media').addClass('hidden');
		$('button').attr('disabled',true);
		$('.createcheck').addClass('hidden');
		$('.img-loader').removeClass('hidden');
		$('.proposalformelement').attr('disabled',true);
		$.ajax({
						url: getmedialist+'/'+productid, // Url to which the request is send
						type: "GET",             // Type of request to be send, called as method
				 		dataType:'json',
						success: function(data)   // A function to be called if request succeeds
						{
							JSON.stringify(data);
							$('.user_media').removeClass('hidden');	
							// media = jQuery.parseJSON(data.allmedia);
							var countdata=data.userconnected.length;
							data.allmedia.forEach(function(v){
								if($.inArray(v,data.userconnected)==-1){
									$('.smedia#'+v+'media').addClass('hidden');
								}
								else{
									$('.smedia#'+v+'media').removeClass('hidden');
									if(countdata===1)
									{
				 						$('.smedia#'+v+'media a').click();
									}

								}
								if($.inArray(v,data.usernotconnected)==-1){
									$('.medianotconnected#connect'+v).addClass('hidden');
								}
								else{
									console.log(v);
									$('.medianotconnected#connect'+v).removeClass('hidden');
								}
							})	;
							$('button').attr('disabled',false);
							$('.createcheck').removeClass('hidden');
							$('.img-loader').addClass('hidden');	
						}
				});
		$('#proposal_popup').modal('show');
	});

	$(document).on('click','#submitproposal',function(e){

		var rules = new Object();
		var messages = new Object();
		$('.proposalform').not('.hidden').find('.bid_amount').each(function() {
		    rules[this.name] = { required: true ,number:true,min:1,minlength:1,maxlength:10 };
		 
		});
		$('.proposalform').not('.hidden').find('.delivery_date').each(function() {
		    rules[this.name] = { required: true ,date:true,minlength:1,maxlength:19 };
		 
		});
		$('.proposalform').not('.hidden').find('.bid_details').each(function() {
		    rules[this.name] = { required: true ,minlength:20,maxlength:500 };
		 
		});

			// e.preventDefault();
		$('#proposalform').validate({
            errorElement: 'span',
			errorClass:'text-danger',
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
         	rules,
            messages: {
				bid_amount: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },

                bid_details: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    				maxlength: errorMessage.maxlength,
                },
                delivery_date: {
                    required: errorMessage.required,
                },
            },

            submitHandler: function(form) {

      			$('i.createcheck').hide();
      			$('.img-loader').show();
      			$('#submitproposal').attr('disabled',true);
      			$('.createcheck').addClass('hidden');
				$('.img-loader').removeClass('hidden');
      			// $('input').attr('disabled',true);
				$.ajax({
						url: proposalurl, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
				 		dataType:'html',
				 		data:$('form').serialize(),
						success: function(data)   // A function to be called if request succeeds
						{
							console.log(data);
							
      						if(data.success_message)
      						{
      							$('i.createcheck').show();
      							$('.img-loader').hide();
      							$('#submitproposal').attr('disabled',false);
      							$('.error-message').show();
      					     	$('.error-message').html(data.success_message);
      						}else{

      							
      							$('i.createcheck').show();
      							$('.img-loader').hide();
      							$('#submitproposal').attr('disabled',false);
      							$('.error-message').show();
      					     	$('.error-message').html(data.error_message);
      							
      						}
      						$('.createcheck').removeClass('hidden');
							$('.img-loader').addClass('hidden');
      						setTimeout(function(){
      								$('.error-message').hide();
      							},3000);
						}
						});
        	}

        });
		})


	$(document).on('hidden.bs.modal','#proposal_popup', function () {
		        $('.proposalform').addClass('hidden');
	  			$('.proposalformelement').attr('disabled',true);
	  			$('.selected').removeClass('selected');
	});		
	
$(document).on('click','.medianotconnected',function(){
	var cur= $(this);
	var productid=$('#productid').val();
	 $.ajax({
	     type: "POST",
	     url: sessionurl,
	     data:{ sessionvar:'redirecturi',sessdata:'creator/sponsorship/public/'+productid+'/',productid:productid },
	     success:function(){
	     	cur.click();
	     }
   })


