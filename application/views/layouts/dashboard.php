
<!DOCTYPE html>
<html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Uptrendly</title>
        <link rel="icon" href="<?php echo base_url().USER_IMG_DIR; ?>fav.png" type="image/x-icon">
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96470743-1', 'auto');
  ga('send', 'pageview');

</script>
        <!-- may require -->
        <!-- <script src='http://localhost:8000/socket.io/socket.io.js'></script> -->
        <!-- Bootstrap -->
        <link href="<?php echo base_url().USER_CSS_DIR; ?>bootstrap.min.css" rel="stylesheet">
        <!-- <link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>jquery.fullPage.css"> -->
        <link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>style.css">
        <!-- Custom CSS -->
        <link href="<?php echo base_url().USER_CSS_DIR; ?>simple-sidebar.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo base_url().USER_CSS_DIR; ?>bootstrap-datepicker.min.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="<?php echo base_url().USER_CSS_DIR; ?>font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>selectize.default.css">
        <link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>bootstrap-tour-standalone.min.css">


        <link rel="stylesheet" href="<?php echo base_url().USER_CSS_DIR; ?>responsive.css">
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

        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        </head>
        <body>
<div id="fb-root"></div>
<script type="text/javascript">
             /**
             * For Facebook embedded posts
             * javascript
             * Sagar Chapagain
             */
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=288550634833929";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
        </script>
<div class="main_loader img-loader hidden" style="z-index:1001;color:white"> 
          <!-- <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> --> 
          <i class="fa fa-spinner fa-spin"></i> </div>
<?php 
// echo '<pre>';
// print_r($this->general->getmessage());exit;?>
<div class="pop_error hidden">
          <div class="pop_error_container"></div>
        </div>
<?php
if($this->session->flashdata('error_message'))
{?>
<div class="pop_error error">
          <div class="pop_error_container"><?php echo $this->session->flashdata('error_message');?></div>
        </div>
<script>
  setTimeout(function(){
    $('.pop_error').addClass('hidden');
    $('.pop_error_container').html('');
  },3000);
  
</script>
<?php } if($this->session->flashdata('success_message')) {  ?>
<div class="pop_error success">
          <div class="pop_error_container"><?php echo $this->session->flashdata('success_message');?></div>
        </div>
<script>
  setTimeout(function(){
    $('.pop_error').addClass('hidden');
    $('.pop_error_container').html('');
  },3000);
  
</script>
<?php } ?>
<div id="wrapper"> 
          <!-- Sidebar -->
          <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
              <li class="sidebar-brand text-center"><a href="<?php echo site_url('/');?>"><img src="<?php echo base_url().USER_IMG_DIR; ?>logo.png"></a> </li>
              <?php 
     $countnotification=$this->general->count_all_data('notification',array('user_id'=>$this->session->userdata(SESSION.'user_id'),'isnotifyseen'=>'0'));
       
      if(isset($user_type) && $user_type=='creator'){ 
     
        ?>
              <li <?php if($account_menu_active=='dashboard') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.MY_ACCOUNT.'settings/profile')?>"><i class="fa fa-dashboard"></i> Dashboard</a> </li>
              <li id="creator_campaigns"  <?php if($account_menu_active=='campaigns') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.CREATOR.'campaigns')?>"><i class="fa fa-file-text"></i> Campaigns
                <?php if(count($countnotification)!='0'):?>
                <sup class="note_b backgroundRed"><?php echo $countnotification;?></sup>
                <?php endif;?>
                </a> </li>
              <!-- <li <?php if($account_menu_active=='sponsorship') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.CREATOR.'sponsorship/public')?>"><i class="fa fa-dollar"></i> Sponsorships</a> </li>
              <li <?php if($account_menu_active=='collaboration') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.CREATOR.'collaborations/public')?>"><i class="fa fa-heart"></i> Collaborations</a> </li> --> 
              <!--   <li <?php if($account_menu_active=='reward') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.MY_ACCOUNT.'settings/referrals')?>"><i class="fa fa-gift"></i> Reward</a> </li> -->
              <li id="creator_messages" <?php if($account_menu_active=='messages') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.MY_ACCOUNT.'messages/inbox')?>"><i class="fa fa-envelope"></i> Messages</a> </li>
              <!-- <li <?php if($account_menu_active=='contents') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.CREATOR.'campaigns')?>"><i class="fa fa fa-archive"></i> Archive</a> </li> -->
              <li id="brand_uptrendly" <?php if($account_menu_active=='uptrendly_brand') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.CREATOR.'uptrendly_brand')?>"><i class="fa fa fa-rocket"></i> Brands With Uptrendly</a> </li>
              <!-- <li  <?php if($account_menu_active=='New-offer') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.CREATOR.'getproposalbyproduct')?>"><i class="fa fa-file-text"></i> New Offers</a> </li> --> 
              <!-- <li <?php if($account_menu_active=='download-app') { ?> class="active"<?php } ?>> <a href="#"><i class="fa fa-apple"></i> Brands with Uptrendly</a> </li> -->
              <?php }
            else{
              ?>
              <li  <?php if($account_menu_active=='dashboard') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.MY_ACCOUNT.'settings/profile')?>"><i class="fa fa-dashboard"></i> Dashboard</a> </li>
              <li  id="create_campaign" <?php if($account_menu_active=='create_campaign') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.BRAND.'create_campaign')?>" class="camp"> 
                <!--<i class="fa fa-handshake-o"></i>--> <i class="fa fa-plus-circle"></i> Create Campaign</a> </li>
              <li id="brand_campaigns"  <?php if($account_menu_active=='campaigns') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.BRAND.'campaigns')?>"><i class="fa fa-file-text"></i> Campaigns
                <?php if(count($countnotification)!='0'):?>
                <sup class="note_b"><?php echo $countnotification;?></sup>
                <?php endif;?>
                </a> </li>
              <li id="influencer_list" <?php if($account_menu_active=='creator') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.BRAND.'influencer')?>"><i class="fa fa-star"></i> Influencer</a> </li>
              <!--  <li <?php if($account_menu_active=='reward') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.MY_ACCOUNT.'settings/referrals')?>"><i class="fa fa-gift"></i> Reward</a> </li> -->
              <li  id="brand_messages" <?php if($account_menu_active=='messages') { ?> class="active"<?php } ?>><a href="<?php echo site_url('/'.MY_ACCOUNT.'messages/inbox')?>"><i class="fa fa-envelope"></i> Messages</a> </li>
              <li id="brand_report" <?php if($account_menu_active=='contents') { ?> class="active"<?php } ?>> <a href="<?php echo site_url('/'.BRAND.'campaigns/closed')?>"><i class="fa fa-file-text"></i> Report</a> </li>
              <?php
            }

        ?>
            </ul>
    <?php 
  $countmsg=0;
  /******************************Global Notification **************************************************
   $notification= $this->general->getunseennotification($this->session->userdata(SESSION.'user_id'));
  $count=count($notification); ?>
    <div class="fixed_notification">
              <div class="relative"> <i class="fa fa-bell"></i>
        <?php if($count>0){ ?>
        <span class="noti_count"><?php echo $count;?></span>
        <?php } ?>
        <div class="pop_window">
                  <div class="noti_header"> <span>Notifications</span> </div>
                  <div class="noti_body">
            <?php if($count>0){
        foreach($notification as $data){
       ?>
            <div class="noti_block">
                      <div class="title"><span class="time-stamp"><?php echo $this->general->time_elapsed_string(strtotime($data->datetime));?></span></div>
                      <div class="noti_text"><?php echo $data->notification_message?></div>
                    </div>
            <?php 
        }
        }
       else{
        ?>
            <div class="noti_block">
                      <div class="noti_text">You have no Notification</div>
                    </div>
            <?php 
    
        
       }?>
          </div>
                </div>
      </div>
            </div>
      ********************End of global notification*********************************/

    
  /********************End of global Chat messaging********************************
$unseenmsg=$this->general->getunseenmessagenotification($this->session->userdata(SESSION.'user_id'));
$countmsg=count($unseenmsg); if($account_menu_active!='messages'):  
$allmessages=$this->general->getmessage();  $userid=$this->session->userdata(SESSION.'user_id'); ?>
    <div class="cd_chat">
              <div class="relative">
        <?php if($countmsg>0){ ?>
        <span class="noti_count"><?php echo $countmsg;?></span>
        <?php } ?>
        <i class="fa fa-comments"></i> </div>
              <div class="chat_box nav-tabs tab-content hidden">
        <div class="chatbox_head"> <span class="back_home_msg"><a data-toggle="tab" href="#chat_home"><i class="fa fa-angle-left"></i></a></span> <span>All Messages</span> <span class="pull-right available_status offline"> <i class="fa fa-circle"></i> </span> </div>
        <div class="msg_list tab-pane fade in active" id="chat_home">
                  <?php
  
      $class='';
      if($allmessages):
       foreach($allmessages as $individmsg):
      
        if($userid==$individmsg->sender_id)
        {
          $image=$individmsg->receiver_image;
          $date=$individmsg->messagedate;
           $name=$individmsg->receiver_name;

        }
        else
        {
           $image=$individmsg->sender_image;
           $date=$individmsg->messagedate;
           $name=$individmsg->sender_name;
        }
         $newdate=$this->general->time_elapsed_string(strtotime($date));
         $avatar=$this->general->get_profile_image($image);
         if($individmsg->ismsgseen=='0' && $userid==$individmsg->receiver_id){
          $class="nofify_highlight";
        }
      ?>
                  <a data-toggle="tab" class="msg_box clickablemessagedetail <?php echo $class;?>" data-bidid="<?php echo $individmsg->bid_id;?>" >
          <ul>
                    <li>
              <figure> <img src="<?php echo $avatar;?>" alt=""> </figure>
            </li>
                    <li>
              <h5><?php echo $name;?> <span><?php echo substr($individmsg->message,0,30).'...';?>.</span> </h5>
            </li>
                    <li class="msg_time"> <?php echo $newdate;?> </li>
                  </ul>
          <span class="clearfix"></span> </a>
                  <?php  
    endforeach;
    else:
      echo 'No Conversation Started!!';
    endif;

    $type='';
    ?>
                </div>
        <div class="tab-pane fade" id="chat1">
                  <div class="chat_msg_body"> </div>
                </div>
      </div>
            </div>            
    <?php endif;?>
    

          ********************End of global chat messaging*********************************/ ?>
  </div>
          <!--JS-START-HERE--> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>jquery.min.js"></script> 
          <!-- Include all compiled plugins (below), or include individual files as "4305186B4A"  needed --> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>bootstrap.min.js"></script> 
          <script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'jquery.validate.min.js'); ?>"></script> 
          <script type="text/javascript" src="<?php echo base_url(USER_JS_DIR.'validation.error.messages.js'); ?>"></script> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>additional.methods.js"></script> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>bootstrap-datepicker.min.js"></script> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>masonry.pkgd.js"></script> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>imagesloaded.pkgd.js"></script>
          <script src="<?php echo base_url().USER_JS_DIR; ?>selectize.js"></script>
          <script src="<?php echo base_url().USER_JS_DIR; ?>bootstrap-tour-standalone.min.js"></script>
          <?php 
if($account_menu_active=='settings' || $account_menu_active=='dashboard')
{ ?>
          <script src="<?php echo base_url().USER_JS_DIR;?>settings.js"></script>
          <?php }?>
          <script src="<?php echo base_url().USER_JS_DIR; ?>creators.js"></script>
          <?php 
       
if(isset($user_type) && $user_type=='creator'){ ?>
          <script src="<?php echo base_url().USER_JS_DIR; ?>sponsorship.js"></script> 
          <script src="<?php echo base_url().USER_JS_DIR; ?>common_creator.js"></script>
          <?php }  ?>
          
          <!-- /#sidebar-wrapper --> 
          
          <!-- Page Content -->
          <div id="page-content-wrapper">
    <header class="fix_header1">
    <div class="two_btns pull-left"><a href="#menu-toggle" class="fa fa-outdent btn btn-lg" id="menu-toggle"> </a></div>
                <?php
              /*******************bottom menu for creator****************************/
            if($user_type=='creator')
             {  
              /******************Bootstrap tour for creator*********************************/
             if($this->session->userdata(SESSION.'first_login')==true)
             {  
              
            ?>
              <script>
                  $(function(){
                    var t = new Tour({
                          steps: [
                              {
                                  element: "#creatorprofile_edit",
                                  title: "Profile Edit",
                                  placement: 'bottom',
                                  backdropPadding :0,
                                  orphan :true, 
                                  content: "Create an appealing profile for Influencers to pick you for Business. All Sensitive information will be kept confidential." ,
                                  backdrop: false
                              },
                              {
                                  element: "#creator_campaigns",
                                  title: "Campagin",
                                  placement: 'bottom',
                                  content: "The list of Campaigns you've been selected for. Accept or Decline campaigns. Upload sample photos for Brands approval and finally upload the content on Social media platforms.",
                                  backdrop: false
                              },
                             {
                                  element: "#creator_messages",
                                  title: "Messages",
                                  placement: 'bottom',
                                  content: "Communicate with us to get all your queries cleared.",
                                  backdrop: false
                             },
                            {
                                  element: "#brand_uptrendly",
                                  title: "Brands with Uptrendly",
                                  placement: 'bottom',
                                  content: "The list of Brands currently associated with Uptrendly. Suggest a creative campaign yourself to promote the product.",
                                  backdrop: false
                              } 
                          ]
                      }).restart();
                      function getTourElement(tour){
                          return tour._options.steps[tour._current].element
                      }

                  })

              </script>
              
              <?php 
              $this->session->unset_userdata(SESSION.'first_login') ;
            }
              /**************************Bootstrap tour ends*********************************/
                      $this->load->view('common/post_collab');  ?>
              <?php  

             }  
             
              else 
              {    
            /**************************Bootstrap tour for brand***********************/
            if($this->session->userdata(SESSION.'first_login')==true)
           {  
           ?>
                 <script>
                  $(function(){
                    var t = new Tour({
                          steps: [
                              {
                                  element: "#brandprofile_edit",
                                  title: "Profile Edit",
                                  placement: 'bottom',
                                  content: "Create an appealing profile for Influencers to pick you for Business. All Sensitive information will be kept confidential." ,
                                  backdrop: false
                              },
                              {
                                  element: "#create_campaign",
                                  title: "Create Campagin",
                                  placement: 'bottom',
                                  content: "Pick the best Influencers, Set your budget and create a campaign to meet your requirements.",
                                  backdrop: false
                              },
                             {
                                  element: "#brand_campaigns",
                                  title: "Campaigns",
                                  placement: 'bottom',
                                  content: "The list of your running/completed campaigns.",
                                  backdrop: false
                             },
                            {
                                  element: "#influencer_list",
                                  title: "Influencers",
                                  placement: 'bottom',
                                  content: "The list of all Influencer available with us for product endorsements.",
                                  backdrop: false
                            },
                             {
                                  element: "#brand_messages",
                                  title: "Messages",
                                  placement: 'bottom',
                                  content: "Communicate with us to get the most out of your Campaign.",
                                  backdrop: false
                            } ,
                            {
                                  element: "#brand_report",
                                  title: "Reports",
                                  placement: 'bottom',
                                  content: "Download a Report after the campaign is complete to know how it performed.",
                                  backdrop: false
                            } 
                          ]
                      }).restart();
                      function getTourElement(tour){
                          return tour._options.steps[tour._current].element
                      }

                  })

              </script>
          <?php  
          $this->session->unset_userdata(SESSION.'first_login') ;
        }
          /**************************Bootstrap tour ends*********************************/
              }   
            ?>
              <?php ?><ul class="nav navbar-nav pull-right">
        <?php /*?><li class="dropdown msg_dropdown"> <span class="msg_count"><?php echo $countmsg;?></span> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                  <ul class="dropdown-menu">
            <?php
          if($countmsg>0)
          {
            foreach($unseenmsg as $rowmsg){
              $image= $this->general->get_profile_image($rowmsg->image);
                // if(!file_exists(site_url(USER_IMAGE_PATH.$rowmsg->image)))
                // {
                  
                //   $image=site_url(USER_IMAGE_PATH.'00123456789_profiledefault.jpg');
                // }else {
                //   $image=site_url(USER_IMAGE_PATH.$rowmsg->cover_image);
                // }
              ?>
            <a style="text-decoration: none" href="<?php echo site_url('/'.MY_ACCOUNT.'Detailmessages/'.$rowmsg->bid_id)?>">
                    <li>
              <figure><img src="<?php echo $image?>" alt="sender image" /></figure>
              <div class="msg_ttl"><i class="fa fa-envelope-o"></i><?php echo $rowmsg->name;?> <span class="msg_time"><?php echo $this->general->time_elapsed_string(strtotime($rowmsg->messagedate));?></span></div>
              <div class="subject"><?php echo $rowmsg->name;?> sent you message</div>
            </li>
                    </a>
            <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'messages')?>">View all messages</a></li>
            <?php 
              }
          }
          else{
            echo '<li>No new Messages</li>';?>
            <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'messages')?>">View all messages</a></li>
            <?php
          }
             
          ?>
          </ul>
                </li><?php */?>
        <li class="dropdown"><a href="<?php echo site_url('user/logout')?>"><i class="fa fa-sign-out"></i> Logout</a>
                  <?php /*?> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata(SESSION.'fullname');?> <span class="caret"></span></a><ul class="dropdown-menu">
            <!--  <li><a href="#">Poplr Bucks</a></li>
            <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'settings/general')?>">Setting</a></li>
            <li><a href="#">Help Center</a></li> --> 
            <!-- <li role="separator" class="divider"></li> -->
            <li><a href="<?php echo site_url('user/logout')?>">Logout</a></li>
          </ul><?php */?>
                </li>
      </ul><?php ?>
              <?php if($this->session->userdata(SESSION.'usertype')=='4'): ?>
              <span class="toggle_indicator"> <span class="toggle_label">Online/Offline: </span>
      <label class="switch">
                <?php $userdetail=$this->general->get_user_details($this->session->userdata(SESSION.'user_id'));?>
                <input type="checkbox"  class="availabilitystatus" <?php if($userdetail->available_status=='1') echo 'checked';?> >
                <span class="slider round"></span> </label>
      </span>
              <?php endif; ?>
              <div class="clearfix"></div>
            </header>
    <div class="mid-part margin_0"> <?php echo $template['body']; ?> </div>
  </div>
          <div class="clearfix"></div>
        </div>
<!-- Reporting pop up user -->

<div class="modal fade" id="reportModal" role="dialog">
          <div class="modal-dialog"> 
    <!-- Modal content-->
    <form id="reportuserform" method="post" name="reportuser">
              <div class="modal-content">
        <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="fa fa-times"></span> </button>
                  <h4 class="modal-title" id="myModalLabel">Report</h4>
                  <p>Would you like to report this Creator? Please give us some information below.</p>
                </div>
        <div class="modal-body">
                  <div class="form-group">
            <input name="bidid" id="report_bidid" type="hidden" value="">
            <select class="form-control" name="title" id="reporttitle">
                      <option value="">Report for?</option>
                      <option value="Spam">Spam</option>
                      <option value="Harrassment">Harrassment</option>
                      <option value="Other">Other</option>
                    </select>
            <textarea class="form-control" rows="4" id="reportmessage" name="message" placeholder="Message (Optional)" maxlength="250"></textarea>
          </div>
                </div>
        <div class="modal-footer" style="text-align:center;">
                  <button type="submit" class="btn btn-primary" id="reportsubmit">
          <div class="btn-img" style="float:left">
                    <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
                    <i class="fa fa-exclamation-circle defaultico"></i> </div>
          Report </button>
                </div>
      </div>
            </form>
  </div>
        </div>
<!-- End of reporting --> 
<script src="<?php echo base_url().USER_JS_DIR; ?>common.js"></script>
<?php 
if($user_type=='brand'){
    $this->load->view('common/add_campaign');
    ?>
<script src="<?php echo base_url().USER_JS_DIR; ?>common_brand.js"></script>
<?php  }  ?>
<script>
var notifyseen='<?php echo site_url("/".MY_ACCOUNT."update_notification_toseen");?>';
var messagedetail='<?php echo site_url('/'.MY_ACCOUNT.'getdetailmessage');?>';
var go_on_off='<?php echo site_url('/'.CREATOR.'change_user_availability_option');?>';
</script> 
<script>
    $('.input-group.date').datepicker({
    format: "yyyy/mm/dd",
   
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
    });
</script> 
<!-- Menu Toggle Script --> 
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script> 
<script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script> 
<script>

var edii


$(function () {



  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<div class="clearfix"></div>
</body>
</html>
