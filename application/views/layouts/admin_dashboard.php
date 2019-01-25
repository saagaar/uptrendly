<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo base_url().ADMIN_IMG_DIR ?>fav.png">
<title><?php echo $template['title']; ?></title>

<link href="<?php echo base_url().ADMIN_CSS_DIR; ?>font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url().ADMIN_CSS_DIR; ?>reset.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url().ADMIN_CSS_DIR; ?>admin.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url().ADMIN_CSS_DIR; ?>custom.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url().ADMIN_CSS_DIR; ?>responsive.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url().ADMIN_JS_DIR; ?>jquery.min.js" type="text/javascript"></script>

<script src="<?php echo base_url().ADMIN_JS_DIR; ?>DD_roundies_0.0.2a.js" type="text/javascript"></script>
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>jquery.validate-1.11.1.min.js" type="text/javascript"></script>

<!--script for the messaging added by rabi-->
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin-inbox.js" type="text/javascript"></script>

<!--script and style for tabber-->
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>tabcontent.js" type="text/javascript"></script>
<link href="<?php echo base_url().ADMIN_CSS_DIR; ?>tabcontent.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
var siteurl='<?php echo base_url();?>';
var baseUrl='<?=base_url()?>';
DD_roundies.addRule('#box', '6px', true);
DD_roundies.addRule('#box h1', '6px 6px 0 0', true);
DD_roundies.addRule('.btn', '4px', true);
</script>
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>timer.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
function ConfirmDelete(itemname) {
    var reconfirm = confirm("Are you sure you want to Delete this " + itemname);
    if (reconfirm) {
        return true;
    } else {
        return false;
    }
}
</script>
<script src="<?php echo base_url().ADMIN_JS_DIR;?>jquery.tablesorter.js" type="text/javascript" charset="utf-8"></script>
</head>
<?php 
 $notification=$this->general->get_message_notification_user('1');
?>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=560607947447383";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<header id="mainhead">
  <div class="hd_sec">
    <h1>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH) ?>">
    		<img src="<?php echo base_url().ADMIN_IMG_DIR.'logo1.png'; ?>" alt="High Tree Group">
        	<span>admin panel</span>
   		</a>
        
        <div class="admin-date-time">
    		<span><?php echo $this->general->date_formate($this->general->get_local_time('time'));?></span>
      		<span id="clock" class="admin-time"></span>
        </div>
    </h1>
  </div>
  <nav id="main_nav">
    <ul class="navi">
      <li class="home" <?php if($this->uri->segment(2) == 'dashboard'){ echo 'current'; }?>><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/dashboard/index')?>"><span class="hm">Dashboard</span></a></li>

       <li <?php if($this->uri->segment(2) == 'site-settings' OR $this->uri->segment(2) == 'email-settings' OR $this->uri->segment(2) == 'block-ip'OR $this->uri->segment(2) == 'payment'){ echo 'class="current"'; }?>>
       	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-settings/index')?>"><span>System Settings</span></a>
        	<ul>
            	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-settings/index')?>">Site Settings</a></li>
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/block-ip/index')?>">Block IP</a></li>
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/email-settings/index/')?>">Email Settings</a></li>
                <!-- <li><a href="<?php //echo site_url(ADMIN_DASHBOARD_PATH.'/time-zone-settings/index/')?>">Time Zone Settings</a></li> -->
                
				<?php if(LOG_ADMIN_ACTIVITY=='Y' && LOG_ADMIN_INVALID_LOGIN=='Y'){ ?>
                    <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/index')?>">Site Logs</a></li>
                <?php } ?>
                
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment/paypal')?>">Payment Gateway</a></li>
        		<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/seo/index/')?>"><span>SEO Management</span></a></li>
    		  <li <?php if($this->uri->segment(2) == 'currency'){ echo 'class="current"'; }?>><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/currency/index/')?>"> <span>Currency Management</span></a> </li>  
        </ul>
       </li>
        
       <li <?php if($this->uri->segment(2) == 'cms' OR $this->uri->segment(2) == 'help'){ echo 'class="current"'; }?>>
       	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/index')?>"><span>Content Management</span></a>
        	<ul>
            	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/index/')?>"><span>CMS Contents</span></a></li>
                <!-- <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/help/index')?>"><span>Help Contents</span></a></li>
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/how-and-why/index')?>"><span>How & Why Reverse Auction</span></a></li> -->
            </ul>
        </li> 
      <!--   <li <?php if($this->uri->segment(2) == 'bidpackage'){ echo 'class="current"'; }?>><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/bidpackage/index/')?>"> <span>Payment Management</span></a> </li> -->
        
     <!--  <li <?php if($this->uri->segment(2) == 'newsletter'){ echo 'class="current"'; }?>><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/newsletter/index/')?>"> <span>Newsletter Management</span></a> </li> -->
        
  <li <?php if($this->uri->segment(2) == 'members'){ echo 'class="current"'; }?>><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/')?>"> <span>Members Management</span></a> 
    <ul>
              <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/advertiser')?>"> Advertiser</a></li>
              <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/members/index/influencer')?>">Influencer</a> </li>
      </ul>
  
  </li>
      
      <li <?php
     
       if($this->uri->segment(2) == 'communication'){ echo 'class="current"'; }?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/index/')?>" class="pos_relative">
          <span>Communication</span>
          <span class="c_count"><?php echo $notification;?></span>
        </a>
      </li>
      
      <li <?php if($this->uri->segment(2) == 'product-categories' OR $this->uri->segment(2) == 'product' OR $this->uri->segment(2) == 'custom-fields'){ echo 'class="current"'; }?>>
       	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index')?>"><span>Posts Manangement</span></a>
        	<ul>
            	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product-categories/index')?>"> Category</a></li>
               <!--  <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/custom-fields/index')?>">Product Form Fields</a></li> -->
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/index/')?>"> Campaign Posts</a> </li>
                <!-- <li><a href="<?php //echo site_url(ADMIN_DASHBOARD_PATH.'/product/host_list/')?>"> Host Auctions</a> </li> -->
            </ul>
      </li>
        
       <?php ?><li <?php if($this->uri->segment(2) == 'general' ){ echo 'class="current"'; }?>>
           <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/winner-payment/index/')?>"><span>General Settings</span></a>
            <ul>
              <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/general/profession')?>">Professions</a></li>
              <!-- <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/ordered-products/index/')?>">Ordered Products</a> </li> -->
            </ul>
                 </li><?php ?>
        
          <!-- <li <?php if($this->uri->segment(2) == 'rewards'){ echo 'class="current"'; }?>>
                   <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/rewards/index')?>"><span>Rewards</span></a>
                    <ul>
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/index')?>">Site Statistics</a></li>
                   <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_report/2')?>">Report Generation</a> </li>
             </ul>
                   </li>  
         <li <?php if($this->uri->segment(2) == 'dispute'){ echo 'class="current"'; }?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/index')?>"><span>Dispute Management</span></a>
          <ul>
              <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/dispute/index')?>">List Disputes</a></li>
                <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/report/generate_report/2')?>">Report Generation</a> </li>
            </ul>
        </li> -->

		  <!--show bidfee only if admin wish to charge bid fee for placing bid for product-->
		  <?php /* if(BID_FEE == 'Yes'){ ?>
          <li <?php if($this->uri->segment(2) == 'bidpackage'){ echo 'class="current"'; }?>><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/bidpackage/index/1')?>"><span>Bidpackage management</span></a></li>
         <?php }*/ ?>
    </ul>
    
    
 
    <ul class="navi profile">
      <li>Hello, <b>
        <?php echo $this->session->userdata(ADMIN_USER_NAME); ?>
        </b></li>
      <li><a href="javascript:void(0)"><span></span></a>
        <ul>
          <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/change-password/index')?>">Change Password</a></li>
          <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/index')?>">Manage Administrator</a></li>
          <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/logout');?>">logout</a></li>
        </ul>
      </li>
    </ul>
    <div class="clearfix"></div>
  </nav>

</header>
<div id="container"> <?php echo $template['body']; ?> </div>

<?php if($this->router->fetch_module()=='product'){ ?>
	<script type="text/javascript" src="<?php echo base_url(JQUERYUI_PATH.'jquery-ui.min.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'jquery-ui.min.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(JQUERYUI_PATH.'datepicker.css'); ?>">
<script type="text/javascript" src="<?php echo base_url(JQUERYUI_PATH.'jquery-ui-timepicker-addon.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().JQUERYUI_PATH.'jquery-ui-timepicker-addon.css'; ?>">

<script>
	//initialize date time picker in datepicker and datetimepicker classes
	$('body').on('focus',".datetimepicker", function(){
		$(this).datetimepicker({
			dateFormat: "yy-mm-dd",
			altFieldTimeOnly: false,
			altTimeFormat: "h:m t",
			altSeparator: " @ ",
			beforeShow: function() {
				setTimeout(function(){
					$('.ui-datepicker').css('z-index',9999);
				}, 0);
			}
			//buttonImage: 'http://localhost/bidwarz/themes/jqueryui/images/calendar.gif', 
      		//buttonImageOnly: true
		});
	});
	

    $('body').on('focus',".datetimepickerwithmindate", function(){
    $(this).datetimepicker({
      dateFormat: "yy-mm-dd",
      altFieldTimeOnly: false,
      altTimeFormat: "h:m t",
      altSeparator: " @ ",
      minDate:0,
     
      beforeShow: function() {
        setTimeout(function(){
          $('.ui-datepicker').css('z-index',9999);
        }, 0);
      }
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

<?php

 } ?>

<script type="text/javascript" src="<?php echo base_url(ADMIN_JS_DIR.'additional.methods.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(ADMIN_JS_DIR.'admin.product.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'validation.error.messages.js'); ?>"></script>

<footer id="ftr_sec">
  <p> <!-- &copy; <?php //echo date('Y'); ?> -->  &copy; 2017 <?php echo WEBSITE_NAME?> </p>
</footer>
</body>
</html>