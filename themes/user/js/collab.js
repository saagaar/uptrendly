
$(function(){
	//for selection of media for posting collab


	
});


$("#create_collab").click(function(e) {

       $("#addcreatorcollab").validate({
            errorElement: 'span',
			errorClass:'text-danger',
			highlight: function (element, errorClass, validClass) { 
			  $(element).parents("div.form-group").addClass('has-error').removeClass('has-success'); 
			}, 
			unhighlight: function (element, errorClass, validClass) { 
             
				$(element).parents("div.form-group").removeClass('has-error'); 
				$(element).parents(".error").removeClass('has-error').addClass('has-success'); 
			},
            rules: {
				name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
				description: {
                    required: true,
                    minlength: 2,
                    maxlength: 300
                },
               
                 least_fan_count: {
                    required: true,
                    number:true,
				},
                submission_deadline: {
                    required: true,
                }

            },
            messages: {
				name: {
                    required: errorMessage.required,
              },

                description: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
    			         	maxlength: errorMessage.maxlength,
                },
               
                least_fan_count: {
                    required: errorMessage.required,
                },
               
                submission_deadline: {
                    required: errorMessage.required,
                },
            },

            submitHandler: function(form) {

            $('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden');
      			$('#create_collab').attr('disabled',true);
				$.ajax({
						url: collaburl, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data:$('#addcreatorcollab').serialize(),        // To send DOMDocument or non processed data file it is set to false
						dataType:'json',
						success: function(data)   // A function to be called if request succeeds
						{
							
							
      						if(data.success_message)
      						{
      						
      							 $('.pop_error').removeClass('hidden');
                     $('.pop_error').addClass('success');
                     $('.pop_error_container').html(data.success_message);
      						}
                  else
                  {
      							 $('.pop_error').removeClass('hidden');
                     $('.pop_error').addClass('error');
                     $('.pop_error_container').html(data.error_message);
      							
      						}
      				    $('#create_collab').attr('disabled',false)
                  $('i.createcheck').removeClass('hidden');
                  $('.img-loader').addClass('hidden');
                    setTimeout(function(){
                     $('.pop_error').addClass('hidden');
                     $('.pop_error').removeClass('error');
                     $('.pop_error').removeClass('success');
                     $('.pop_error_container').html('');
                    },3000);
                    $('.modal').modal('hide');
      						// $('#addcreatorcollab')['0'].reset();
						}
						});
        	}

        });
});


$(document).on('click','#selectbrandbtn',function(){
		var selectbrand=[];
		$('.mediabrand').each(function(){
			if($(this).hasClass('selected'))
			{
				var mediaid=$(this).data('mediaid');
				selectbrand.push(mediaid);
			}
		});
		$('#collabsocialmedia').val(selectbrand);
		$('#postsocialmediaid').val(selectbrand);
		$('#popup-postcollab').modal('show');
		$('#myModal').modal('toggle');
});

$('.smediacollab a').click(function (e) {
	 	e.preventDefault();
	  	var buttonenable=false;
		var current=$(this);
	  	if(current.hasClass('selected')) current.removeClass('selected');
	  	else  current.addClass('selected');
	  	$('.smediacollab a').each(function(i,e){
	  		if($(this).hasClass('selected'))
	  		{
	  			 buttonenable=true;
	  		}

	  	});
  
  	if(buttonenable===true) $('#selectbrandbtn').attr('disabled',false);
  	else $('#selectbrandbtn').attr('disabled',true);
  	
  });
  
$(document).on('click','.cmedia a',function (e) {
    e.preventDefault();
    var current=$(this);
    if(current.hasClass('selected')) current.removeClass('selected');
      else  current.addClass('selected');
      // $('.smedia a').each(function(i,e){
        if(current.hasClass('selected'))
        {

          var medianame=current.data('medianame');
          var productid=$('#productids').val();
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
                            $('#'+medianame+'_productid').val(data.product_id);
                            $('#'+medianame+'_delivery_date').val(data.delivery_date);
                            // $(facebook.'maininput').attr('disabled',false);
                            // $('textarea').attr('disabled',false);
                          
                        }
                         $('.'+medianame+'element').attr('disabled',false);
                          $('button').attr('disabled',false);
                          $('.createcheck').removeClass('hidden');
                          $('.img-loader').addClass('hidden');
                  }
                     
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


  $(document).on('click','#collabdetail',function(e){
    e.preventDefault();
    var productid=$(this).data('productid');
    var currentuser=$('#current_user').val();
    var branduser=$(this).data('brandid');
    $('.editbutton').addClass('hidden');
    if(currentuser==branduser)
    { 
      $('.editbutton').removeClass('hidden');
      $('#editbuttoncollab').attr('productid',productid);
    }


    var name=$('#'+productid+'_product_name').html();
    var fancount=$('#'+productid+'_fan_count').val();
    var img=$('#'+productid+'_productimg').attr('src');
    var media=$('#'+productid+'_allmedia').val();
    var url=$('#'+productid+'_product_url').val();
    var description=$('#'+productid+'_description').html();
    var submissiondeadline=$('#'+productid+'_submission_deadline').val();
     mediaseprate=media.split(',');

      $('.mediaicon').each(function(){
          $(this).addClass('hidden');
      });
  
    mediaseprate.forEach(function(item) {
          console.log(item);
         $('#'+item+'ico').removeClass('hidden');
    });
    $('#product_name').html(name);
    $('#productimg').attr('src',img);
    $('#description').html(description);
    $('#followers_count').html(fancount);
    $('#producturl').html(url);
    $('#submissiondeadline').html(submissiondeadline);
    $('#detail_popup').modal('show');
    // $('#med')

  })

  //   $(document).on('click','.collabproposal',function(e){
  //   e.preventDefault();
  //   document.getElementById('proposalform').reset();
  //   var productid=$(this).data('productid');
  //   var media=$('#'+productid+'_socialmediaid').data('media');
  //   var mediaid=$('#'+productid+'_socialmediaid').val();
  //   $('#mediaid').val(mediaid);
  //   $('#productid').val(productid);
  //   $('#proposalmediaicon').attr('class','round_btn round-icon proposalmediaicon');
  //   if(media!=undefined)
  //   {
  //       $('.proposalmediaicon').addClass(media);
  //       $('.proposalmediaicon').children('i').addClass('fa-'+media);
  //   }
    
  //   $.ajax({
  //           url: getproposal+'/'+productid, // Url to which the request is send
  //           type: "GET",             // Type of request to be send, called as method
  //           dataType:'json',
  //           success: function(data)   // A function to be called if request succeeds
  //           {
  //             if(data.length!=0)
  //             {
  //                 $('#mediaid').val(data.mediaid);
  //                 $('#bid_details').val(data.bid_details);
  //                 $('#bid_amount').val(data.user_bid_amt);
  //                 $('#productid').val(data.product_id);
  //                 $('#delivery_date').val(data.delivery_date);
  //             }
  //                 $('input').attr('disabled',false);
  //                 $('textarea').attr('disabled',false);
  //                 $('button').attr('disabled',false);
  //           }
  //           });
  //   $('#collab_proposal_popup').modal('show');
  //   $('input').attr('disabled',true);
  //   $('textarea').attr('disabled',true);
  //   $('button').attr('disabled',true);
    
    
  // });


  $(document).on('click','.collabproposal',function(e){
    e.preventDefault();

    document.getElementById('proposalform').reset();
    var productid=$(this).data('productid');
    var media=$('#'+productid+'_socialmediaid').data('media');
    var mediaid=$('#'+productid+'_socialmediaid').val();

    $('#mediaid').val(mediaid);
    $('#productids').val(productid);
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
              console.log(data);
              JSON.stringify(data);
              $('.user_media').removeClass('hidden'); 
              // media = jQuery.parseJSON(data.allmedia);
            var countdata=data.userconnected.length;
              data.allmedia.forEach(function(v){
                if($.inArray(v,data.userconnected)==-1){
                  $('.cmedia#'+v+'media').addClass('hidden');
                }
                else{
                  $('.cmedia#'+v+'media').removeClass('hidden');
                  if(countdata===1)
                  {
                      $('.cmedia#'+v+'media a').click();
                  }
                }
                if($.inArray(v,data.usernotconnected)==-1){
                  $('.medianotconnected#connect'+v).addClass('hidden');
                }
                else{
                  console.log(v);
                  $('.medianotconnected#connect'+v).removeClass('hidden');
                }
              })  ;
              $('button').attr('disabled',false);
              $('.createcheck').removeClass('hidden');
              $('.img-loader').addClass('hidden');  
            }
        });
    $('#collab_proposal_popup').modal('show');
    // $('input').attr('disabled',true);
    // $('textarea').attr('disabled',true);
    // $('button').attr('disabled',true);
    
    
  });
    // $(document).on('click','#fb-login',function(){
    //   var action=$(this).data('action');
    //     $.ajax({
    //         url:action, // Url to which the request is send
    //         type: "GET",             // Type of request to be send, called as method
    //         dataType:'html',
    //         success: function(data)   // A function to be called if request succeeds
    //         {
    //           console.log(data);
    //         }
    //         });
    // })
    // 
    // 
    $(document).on('click','#submitproposalcollab',function(e){

    var rules = new Object();
    var messages = new Object();
  
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

                bid_details: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,
                },
                delivery_date: {
                    required: errorMessage.required,
                    minlength: errorMessage.minlength,
                    maxlength: errorMessage.maxlength,
                },
            },

            submitHandler: function(form) {
              $('i.createcheck').addClass('hidden');
              $('#submitproposalcollab').attr('disabled',true);
             $('.img-loader').removeClass('hidden');
           
        $.ajax({
            url: proposalurl, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            dataType:'json',
            data:$('form').serialize(),
            success: function(data)   // A function to be called if request succeeds
            {
              console.log(data);
              
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
                  $('#submitproposalcollab').attr('disabled',false);
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
  $(document).on('hidden.bs.modal','#collab_proposal_popup', function () {
            $('.proposalform').addClass('hidden');
          $('.proposalformelement').attr('disabled',true);
          $('.selected').removeClass('selected');
  });   
  