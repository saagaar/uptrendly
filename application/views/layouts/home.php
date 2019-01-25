<?php $this->load->view('common/header');?>

<?php echo $template['body']; ?>

<footer>
<?php $this->load->view('common/footer');?>
</footer>

<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'jquery-2.1.4.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'bootstrap.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'jquery.validate.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'additional.methods.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'validation.error.messages.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'auction.bidding.js'); ?>"></script>
<?php //display these only if the page is auction details page ?>
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'jquery.timer.js'); ?>"></script>
<?php if($this->session->userdata(SESSION.'user_id')){ ?>
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'seller.add-edit.inventory.js'); ?>"></script>
<?php //inport jquery ui pluginn ?>
<script type="text/javascript" src="<?php echo base_url(JQUERYUI_PATH.'jquery-ui.min.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'jquery-ui.min.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'datepicker.css'); ?>">
<script type="text/javascript" src="<?php echo base_url(JQUERYUI_PATH.'jquery-ui-timepicker-addon.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'jquery-ui-timepicker-addon.css'); ?>">
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'users.form.validation.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'members.communication.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'supplier.companydetail.edit.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo site_url(USER_JS_DIR.'buyer.general.profile.js'); ?>"></script> 
<script>
  //initialize date time picker in datepicker and datetimepicker classes
  $('body').on('focus',".datetimepicker", function(){
    $(this).datetimepicker({
      dateFormat: "yy-mm-dd",
      altFieldTimeOnly: false,
      altTimeFormat: "h:m t",
      altSeparator: " @ ",
      //buttonImage: 'http://localhost/bidwarz/themes/jqueryui/images/calendar.gif', 
          //buttonImageOnly: true
    });
  });
  $('body').on('focus',".datepicker", function(){
    $(this).datepicker({
      dateFormat: "yy-mm-dd"
    });
  });
</script>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'users.form.validation.js'); ?>"></script>
<?php } ?>

<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'jquery.easing.min.js'); ?>"></script>
<script>
//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $(document).on('click', 'a.page-scroll', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});
</script> 
<script>
$(window).scroll(function() {
    if ($(this).scrollTop() > 1){  
        $('header').addClass("sticky");
    }
    else{
        $('header').removeClass("sticky");
    }
});
</script>
</body>
</html>