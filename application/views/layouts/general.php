<?php //$this->load->library('general'); ?>
<?php
	// //check cookie
	// if(!$this->session->userdata(SESSION.'user_id')){
	// 	if(isset ($_COOKIE['email']) && $_COOKIE['email']!='' && isset($_COOKIE['password']) && $_COOKIE['password']!=''){
	// 		//login by cookie value
	// 		$this->general->check_login_process($_COOKIE['email'],$_COOKIE['password']);
	// 		//echo "<pre>"; print_r($_COOKIE); echo "</pre>"; exit;
	// 	}
	// } 
  //exit; 
?>
<?php
	//load header
	$this->load->view('common/header');
  
	?>

  <div id="fullpage">
    <?php echo $template['body']; ?>

  </div>

  <!--JS-START-HERE-->
  <script  src="<?php echo base_url().USER_JS_DIR; ?>jquery.min.js"></script>
  <script src="<?php echo base_url().USER_JS_DIR; ?>jquery-ui.min.js"></script>
  <script src="<?php echo base_url().USER_JS_DIR; ?>jquery.validate.min.js"></script>
  <script src="<?php echo base_url().USER_JS_DIR; ?>validation.error.messages.js"></script>
   <script src="<?php echo base_url().USER_JS_DIR; ?>additional.methods.js"></script> 
  <script src="<?php echo base_url().USER_JS_DIR; ?>users.form.validation.js"></script>
  <script type="text/javascript" src="<?php echo base_url().USER_JS_DIR; ?>jquery.fullPage.js"></script>
  <script type="text/javascript" src="<?php echo base_url().USER_JS_DIR; ?>examples.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#fullpage').fullpage({
        'verticalCentered': false,
        'css3': true,
        'sectionsColor': ['#000', '#8d06bb', '#02468d', '#c48e0a', '#26c4a1', '#8f969e', '#ececee'],
        'navigation': true,
        'navigationPosition': 'right',
        //'navigationTooltips': ['fullPage.js', 'Powerful', 'Amazing', 'Simple'],

        'afterLoad': function(anchorLink, index){
          if(index == 2){
            $('#iphone3, #iphone2, #iphone4').addClass('active');
          }
        },

        'onLeave': function(index, nextIndex, direction){
          if (index == 3 && direction == 'down'){
            $('.section').eq(index -1).removeClass('moveDown').addClass('moveUp');
          }
          else if(index == 3 && direction == 'up'){
            $('.section').eq(index -1).removeClass('moveUp').addClass('moveDown');
          }

          $('#staticImg').toggleClass('active', (index == 2 && direction == 'down' ) || (index == 4 && direction == 'up'));
          $('#staticImg').toggleClass('moveDown', nextIndex == 4);
          $('#staticImg').toggleClass('moveUp', index == 4 && direction == 'up');
        }
      });
    });
  </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url().USER_JS_DIR; ?>bootstrap.min.js"></script>
  </body>
</html>
<!--load footer-->
