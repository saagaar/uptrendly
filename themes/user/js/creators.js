$(function(){
	$(document).on('click','a.invitecreator',function(e){
		e.preventDefault();
		// alert('hello');
		// document.getElementById('proposalform').reset();
		var userid=$(this).data('userid');
		var profile =$('img#profilecreator_'+userid).attr('src');
		$('#profilepicturecreator').attr('src',profile);
		$('#inviteuser').val(userid);

		$('#invite_creators').modal('show');
	})
	$(document).on('click','#sendinvitationbtn',function(e){
				$('#sendinvitationbtn').attr('disabled',true);
				$('textarea').attr('readonly',true);
				$('i.createcheck').addClass('hidden');
      			$('.img-loader').removeClass('hidden');
	e.preventDefault();
						$.ajax({
							url: sendinvitation, 
							type: "POST",  
						    data: new FormData($('#sendinvitation')[0]), 
                            contentType: false,       
                            cache: false,             
                            processData:false,        
                            dataType:'json',
					 		
							success: function(data)
							{
								$('i.createcheck').show();
      							$('.img-loader').addClass('hidden');
      							$('#sendinvitationbtn').attr('disabled',false);
      					     	$('textarea').attr('readonly',false);
      					     	
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
                                     $('.modal').modal('hide');
                                      setTimeout(function()
                                      {
                                         $('.pop_error').addClass('hidden');
                                         $('.pop_error').removeClass('error');
                                         $('.pop_error').removeClass('success');
                                         $('.pop_error_container').html('');
                                          
                                      },2000);		
							}
							});
	})

	
	})
