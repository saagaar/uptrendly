
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta property="og:title" content="Uptrendly" />
<meta property="og:type" content="image" />
<meta property="og:url" content="http://uptrendly/" />
<meta property="og:image" content="<?php echo base_url().USER_IMG_DIR; ?>logo.png" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo base_url().USER_IMG_DIR; ?>fav.png" type="image/x-icon">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Uptrendly</title>
<link href="<?php echo base_url().USER_CSS_DIR; ?>bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url().USER_CSS_DIR; ?>font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>custom.css">
<!--whatis-->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>#page-top {	overflow-y: scroll !important;}</style>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<header class="navbar-fixed-top">
  <nav class="navbar mb-0" role="navigation">
    <div class="container">
      <div class="navbar-header page-scroll">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand p-0" href="<?php echo site_url('cms/index');?>"><img src="<?php echo base_url().USER_IMG_DIR; ?>logo.png" alt="uptrendly logo"></a> </div>
      
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav pull-right mt-15">
          <?php 		

		if($account_menu_active=='home') {  
		$home="#home";
		$demo="#demo";
		$influencer='#influencer';
		$brand='#brand';
		$contactus='#contact';
		
		} 
		else{
			$home=site_url('cms/index');
			$contactus=site_url('cms/contact');
			$demo=site_url('cms/demo');
			$influencer= site_url('/cms/creator');
			$brand=site_url('/cms/brand');
		}

				?>
          <li <?php if($account_menu_active=='home') :?>class="active" <?php endif;?>><a class="page-scroll" href="<?php echo $home;?>">Home</a> </li>
          <li <?php if($account_menu_active=='demo') :?>class="active" <?php endif;?>><a class="page-scroll" href="<?php echo $demo;?>">Demo</a> </li>
          <li <?php if($account_menu_active=='creators') :?>class="active" <?php endif;?>><a class="page-scroll" href="<?php echo $influencer;?>">Influencer</a></li>
          <li <?php if($account_menu_active=='brands') :?>class="active" <?php endif;?>><a class="page-scroll" href="<?php echo $brand;?>">Advertiser</a></li>
          
          <!-- <li class="dropdown"><a id="dLabel" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="dLabel">
               <form method="post" class="col-xs-12 mt-10" action="<?php echo site_url('/user/login')?>" >
            <div class="form-group"><input type="text" class="form-control" placeholder="E-mail" name="email"></div>
            <div class="form-group"><input type="password" name="password" class="form-control" placeholder="Password"></div>
            <div class="checkbox">
        <label>
          <input type="checkbox" value="">
          <span class="cr"><i class="cr-icon fa fa-check"></i></span> Remember me</label>
      </div>
            <button type="submit" class="btn btn-blue mb-10">Login</button>
            <label class="block-ele pull-right f-book"><a href="<?php echo site_url('user/login/forget')?>">Forgot Password</a></label>
            </form>
            </ul>
          </li> -->
          
          <li class="<?php if($account_menu_active=='contact') :?>active <?php endif;?>"><a class="page-scroll" href="<?php echo $contactus?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
