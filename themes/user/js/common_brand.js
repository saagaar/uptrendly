$(function(){
	// $(document).on('change','.filter',function(e){
	// 	e.preventDefault();
	// 		var proposaltype=$(this).val();
	// 		var filterparams={};
	// 		if(proposaltype){
	// 			filterparams.filterproposaltype=(proposaltype);
	// 		}
			
	// 	$('.img-loader').show();
	// 	$.ajax({
	// 					url: searchurl, // Url to which the request is send
	// 					type: "POST",             // Type of request to be send, called as method
	// 					dataType:'html',
	// 					data:filterparams,
	// 					success: function(data)   // A function to be called if request succeeds
	// 					{
	// 						$('.img-loader').hide();
	// 						console.log(data);
	// 							$('.filterview').html('');
 //      					    	$('.filterview').html(data);
	// 					}
	// 		});
	// });
$(document).on('change','.filter',function(e){
	var productid=($(this).data('productid'));
		e.preventDefault();
		filterview(productid);
	});
	$(document).on('click','.filteroptname',function(e){
		var productid=($(this).data('productid'));
		e.preventDefault();
		filterview(productid);

	})
})

function filterview( productid=false)
{		
		var status = $('.status').val();
		var proposaltype = $('.proposaltype').val();
		var viewtype=$('.viewtype').val();
    	var pricerange = $('.pricerange').val();
		var mediachannel= $('.mediachannel').val();
		var fromdate = $('.fromdate').val();
		var todate= $('.todate').val();
		var age 		=   $('.age').val();
		var ceiling_likes=   $('.ceiling_likes').val();
		var profession=   $('.professions').val();
		var gender=   $('.gender').val();
		var category=   $('.category').val();
		var name= $('.name').val();
		
		var filterparams={};

		if(proposaltype)
		{
				filterparams.filterproposaltype=proposaltype;
		}
		if(pricerange)
		{
			filterparams.filterpricerange=(pricerange);
		}
		if(mediachannel){
			filterparams.filtermediatype=mediachannel
		}
		if(category){
			filterparams.filtercategory=category;
		}
		if(age){
			filterparams.filterage=age;
		}
		if(ceiling_likes){
			filterparams.filterceilinglikes=ceiling_likes;
		}
		if(profession){
			filterparams.filterprofession=profession;
		}
		if(gender){
			filterparams.filtergender=gender;
		}
		if(name){
			
			filterparams.filtername=name;
		}
		if(status)
		{
			filterparams.filterstatus=status;
		}
		if(fromdate)
		{
			filterparams.filterfromdate=fromdate;
		}
		if(todate)
		{
			filterparams.filtertodate=todate;
		}
		if(viewtype)
		{
			filterparams.viewtype=viewtype;
		}
		if(productid)
		{
			url=searchurl+'/'+productid;
		}else
		{
			url=searchurl;
		}
	
		$('.img-loader').removeClass('hidden');
		$.ajax({
						url: url, // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType:'html',
						data:filterparams,
						success: function(data)   // A function to be called if request succeeds
						{
							$('.img-loader').addClass('hidden');
							console.log(data);
								$('.filterview').html('');
      					    	$('.filterview').html(data);
						}
			});
}

$(document).on('click','.viewsocialmedia',function()
{

	$('#socialmedialinks').modal('show');
	var userid=$(this).data('userid');
	$('.img-loader').removeClass('hidden');
	$.ajax({
						url: socialmedialink+'/'+userid, 
						type: "POST",          
						dataType:'json',
						success: function(data) 
						{
							console.log(data);
							
							$('.contentprofile').html('');
							$('.mediadetail').addClass('hidden');
							$('.img-loader').addClass('hidden');
							$.each(data,function(k,v){
								$('#media'+k).removeClass('hidden');
								console.log(v.length);
								if(v.length>0)
								{

									$.each(v,function(key,value)
									{	

										$('#media'+k).next('.contentprofile').append(' <p > <a href="'+value+'" class="s_url" target="_blank">'+value+'</a> </p>')
									})
								}
								else
								{
									$('#media'+k).next('.contentprofile').append(' <p >No profile</p>');
								}
								
							})
							
						}
			});

})

 $(document).on('click','.setstatusbrand',function(){

    var productid=$(this).data('productid');
    var bidid=$(this).data('bidid');
    var status=$(this).attr('value');
    var cur=$(this);
 
    if(status=='1')
    {
    	if(!confirm('You need to pay the Creator before you Select the proposal.Do you wish to proceed ?'))
    	return false;
    }
    if(status=='4')
    { 
	   if(confirm('Are you sure you want to Reject the proposal ?'))
	   {
	   	  $('.img-loader').removeClass('hidden');
	    	 $.ajax({
					           type: "POST",
					           url: changestatusurl,
					           dataType:'json',
					           data:{ bidid:bidid,status:status,productid:productid },
					           success:function(data){
							     setTimeout(function(){
					             	
					             	 location.reload();
					            },1000);
					            
					           }
					      })
    	}
    	else{
    		return false;
    	}
    }
    else
    {
    	$.ajax({	
           type: "POST",
           url: checkbalance,
           data:{ bidid:bidid,status:status,productid:productid },
           success:function(data){
            // $('.img-loaderstatus').hide();
             var data=jQuery.parseJSON(data);

            if(data.success_message){
           
              // $('.message').show();
              // $('.message').html(data.success_message);

               if(confirm('Are you sure you want to change the status?')){
				    $('.img-loader').removeClass('hidden');
				   
				      $.ajax({
				           type: "POST",
				           url: changestatusurl,
				           dataType:'json',
				           data:{ bidid:bidid,status:status,productid:productid },
				           success:function(data){
						     setTimeout(function(){
				             	
				             	 location.reload();
				            },1000);
				            
				           }
				      })
				    }else{
				      return false; 
				    }
            }
            else{
            	
              $('.pop_error').removeClass('hidden');
              $('.pop_error').addClass('error');
              $('.pop_error_container').html(data.error_message);

                setTimeout(function(){
                window.location.replace(paymentpage);
            	},3000);	
          

          	  }
          
            
           	}
      	}) 
    }
      
})