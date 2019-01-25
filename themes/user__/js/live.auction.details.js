// JavaScript Document

if ( $( ".thumbs" ).length ) {
	$("#imgArea").on("mouseover", ".thumbs", function(e) {
	//$('.thumbs').hover(function(e){
		var bidImg = $(this).data('link');
		$('#bigImg').attr('src',bidImg);
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	});
}
	
	
function PaypalVerificationError(){
	setTimeout(function() {
		$('#errorSuccessMesageArea').css('display', 'block');
		$('#errorSuccessMesageArea').removeClass('success').addClass('alert-danger');
		$('#errorSuccessMesage').html('Your Paypal is not verified. Please Verify your paypal account.');
	}, 1000);
	
	setTimeout(function() {
		//remove class and html contents
		$("#errorSuccessMesage").html('');
		$("#errorSuccessMesageArea").css("display", "none");
	}, 5000);	
}