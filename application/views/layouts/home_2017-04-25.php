<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Vid.energy|Home </title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url().USER_CSS_DIR; ?>bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>jquery.fullPage.css">
	<link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>style.css">
    <!-- Bootstrap -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
	<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900">-->   
    <!-- Google Fonts embed code <!-- import Google font -->
        <script type="text/javascript">
            (function() {
                var link_element = document.createElement("link"),
                    s = document.getElementsByTagName("script")[0];
                if (window.location.protocol !== "http:" && window.location.protocol !== "https:") {
                    link_element.href = "http:";
                }
                link_element.href += "//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900";
                link_element.rel = "stylesheet";
                link_element.type = "text/css";
                s.parentNode.insertBefore(link_element, s);
            })();
        </script> 
    
   
  </head>
  <body>
  <?php $this->load->view('common/header');?>
  <div id="fullpage">
  <?php echo $template['body']; ?>
  </div>
 <!--JS-START-HERE-->
    <script src="<?php echo base_url().USER_JS_DIR; ?>jquery.min.js"></script>
    <script src="<?php echo base_url().USER_JS_DIR; ?>jquery-ui.min.js"></script>
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
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>