$(function(){
	
	$("form").delegate(".numericonly", "keydown", function(event) {
		
		// Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 110 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39) ) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });


    $(document).on('click','.sponsordetail',function(e){
        e.preventDefault();
        var id=$(this).attr('id');
        alert(id);
        var productid=$(this).data('productid');
        var name=$('#'+productid+'_product_name').html();
        var pricerange=$('#'+productid+'_price_range').val();
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
                
             $('#'+item+'ico').removeClass('hidden');
        });
        $('#product_name').html(name);
        $('#productimg').attr('src',img);
        $('#description').html(description);
        $('#budget').html(pricerange);
        $('#producturl').html(url);
        $('#submissiondeadline').html(submissiondeadline);
        $('#'+id).modal('show');
        // $('#med')

    })
	
});