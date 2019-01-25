
	$(document).on('click','.smedia a',function (e) 
	{
		e.preventDefault();
	  	var current=$(this);

		if(current.hasClass('selected')) current.removeClass('selected');
	  	else  current.addClass('selected');
	  	// $('.smedia a').each(function(i,e){
	  		if(current.hasClass('selected'))
	  		{

	  			var medianame=current.data('medianame');
	  			var productid=$('#productsid').val();
				var media=current.data('mediaid');
				$('button').attr('disabled',true);
				$('.createcheck').addClass('hidden');
				$('.img-loader').removeClass('hidden');
				
				$.ajax({
								url: getproposal+'/'+productid+'/'+media, // Url to which the request is send
								type: "GET",             // Type of request to be send, called as method
						 		dataType:'json',
								success: function(data)   // A function to be called if request succeeds
								{
									console.log(data);
									if(data.error_message)
									{	
										current.removeClass('selected');	
										 $('.pop_error').removeClass('hidden');
										 $('.pop_error').addClass('success');
      		            				 $('.pop_error_container').html(data.error_message);

      		            				  setTimeout(function(){
							              $('.pop_error').addClass('hidden');
			                			  $('.pop_error').removeClass('error');
			                			  $('.pop_error').removeClass('success');
			                			  $('.pop_error_container').html('');
							            	},3000);
									}
									else
									{
										$('.proposalform.'+medianame+'main').removeClass('hidden');
										if(data.length!=0)
										{	
												// $('#'+medianame+'_mediaid').val(data.mediaid);
												$('#'+medianame+'_bid_details').val(data.bid_details);
												$('#'+medianame+'_bid_amount').val(data.user_bid_amt);
												$('#'+medianame+'_productid').val(data.product_id);
												$('#'+medianame+'_delivery_date').val(data.delivery_date);
												// $(facebook.'maininput').attr('disabled',false);
												// $('textarea').attr('disabled',false);
											
										}
										$('.'+medianame+'element').attr('disabled',false);
										$('button').attr('disabled',false);
									}
									
										$('.createcheck').removeClass('hidden');
										$('.img-loader').addClass('hidden');
								}
								});
					// $('#proposal_popup').modal('show');
					// $('input').attr('disabled',true);
					// $('textarea').attr('disabled',true);
					// $('button').attr('disabled',true);
		
	  		}
	  		else{
	  			current.removeClass('selected');
	  			var medianame=current.data('medianame');
	  			$('.proposalform.'+medianame+'main').addClass('hidden');
	  			$('.'+medianame+'element').attr('disabled',true);
				
	  		}
	  	// });
		 });
	
	


	$(document).on('click','.sendproposal',function(e){
		e.preventDefault();
		document.getElementById('proposalform').reset();
		var productid=$(this).data('productid');

		var media=$('#'+productid+'_socialmediaid').data('media');
		var mediaid=$('#'+productid+'_socialmediaid').val();
		$('#mediaid').val(mediaid);
		$('#productsid').val(productid);
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
							console.log(data);
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
									// console.log(v);
									$('.medianotconnected#connect'+v).removeClass('hidden');
								}
							})	;
							$('button').attr('disabled',false);
							$('.createcheck').removeClass('hidden');
							$('.img-loader').addClass('hidden');	
						}
				});

		$('#proposal_popup').modal('show');
		// $('input').attr('disabled',true);
		// $('textarea').attr('disabled',true);
		// $('button').attr('disabled',true);
		
		
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

      			$('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden');
      			$('#submitproposal').attr('disabled',true);
      			$('.createcheck').addClass('hidden');
				$('.img-loader').removeClass('hidden');
      			// $('input').attr('disabled',true);
				$.ajax({
						url: proposalurl, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
				 		dataType:'json',
				 		data:$('#proposalform').serialize(),
						success: function(data)   // A function to be called if request succeeds
						{
							// var data=jQuery.parseJSON(data);
      						if(data.success_message)
      						{
      						  $('.pop_error').addClass('success');
      		            	  $('.pop_error_container').html(data.success_message);
      						}else
      						{
      				  			$('.pop_error_container').html(data.error_message);
      				  			$('.pop_error').addClass('error');
      						}
      						$('.modal').modal('hide');
      						$('.pop_error').removeClass('hidden');
      						$('.createcheck').removeClass('hidden');
							$('.img-loader').addClass('hidden');
							$('#submitproposal').attr('disabled',false);
      						setTimeout(function(){
				              $('.pop_error').addClass('hidden');
                			  $('.pop_error').removeClass('error');
                			  $('.pop_error').removeClass('success');
                			  $('.pop_error_container').html('');
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
	
$(document).on('click','.medianotconnected',function(e){
	e.preventDefault();
	var cur= $(this);
	href=cur.attr('href');
	var productid=$('input[name="productid"]#productsid').val();
	 $.ajax({
	     type: "POST",
	     url: sessionurl,
	     data:{ sessionvar:'redirecturi',sessdata:'creator/sponsorship/public/'+productid+'/',productid:productid },
	     success:function(){

	     	window.location.href=(href);
	     }
   })
    
})

/*for sponsorship menu tab change-->creator*/
$(document).on('click','.sponsorstabs',function(){

	   currentelement=$(this);
	   var viewtype=$(this).data('type');
 	   history.replaceState(null, null, urlhistory+'/'+viewtype);
	   window.history.pushState('', urlhistory+'/'+viewtype, viewtype);	
	   $('.img-loader').removeClass('hidden');
	  	$('.filterblock').removeClass('hidden');
	 
       if(viewtype=='invitation' || viewtype=='manage-collab' )
       {
       	
       	$('.filterblock').addClass('hidden');
       }
       if(viewtype!='manage-collab' &&  viewtype!='invitation')
       {
       	 sponsorshipview(viewtype,currentelement);
       }
       else{
       		setTimeout(function(){
       			 $('.img-loader').addClass('hidden');
       		},1000);
       }    
})
/*for collab menu tab change-->creator*/
$(document).on('click','.sponsorcollabtab',function(){
	   currentelement=$(this);
	   var viewtype=$(this).data('type');
	   window.history.pushState('', '/'.viewtype, viewtype);
	   $('.img-loader').removeClass('hidden');
	   	$('.filterblock').removeClass('hidden');
       if(viewtype!='manage-collab' &&  viewtype!='invitation')
       {
      
       	 sponsorshipview(viewtype,currentelement);
       }
        else{
        	 	$('.filterblock').addClass('hidden');
       		setTimeout(function(){
       			 $('.img-loader').addClass('hidden');
       		},1000);
       }    
})


function sponsorshipview(viewtype,curelement){

         $.ajax({
                        url: action+'/'+viewtype, // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        dataType:'html',
                        data:{viewtype:viewtype},
                        success: function(data)   // A function to be called if request succeeds
                        {
                        	$('.tabview').html('');
                            $('#'+viewtype).html('');
                            $('#'+viewtype).html(data);
                            if(viewtype=='my-proposal' || viewtype=='mycollabproposals')
                            $('a.sendproposal').html('Edit Proposal');
                            $('.img-loader').addClass('hidden');
                        }

                });
}
