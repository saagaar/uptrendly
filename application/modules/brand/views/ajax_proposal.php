<div class="proposal_stat">
  <div class="col-md-3 col-sm-3 col-xs-6">
    <h8> Received <span><?php echo isset($proposals['0']['proposalcount'])?$proposals['0']['proposalcount']:'0';?></span> </h8>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-6">
    <h8> Production <span><?php echo isset($proposals['0']['productioncount'])?$proposals['0']['productioncount']:'0';?></span> </h8>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-6">
    <h8> Completed <span><?php echo isset($proposals['0']['completedcount'])?$proposals['0']['completedcount']:'0';?></span> </h8>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-6">
    <h8> Spend <span><?php echo isset($proposals['0']['spend'])?$proposals['0']['spend']:'0';?></span> </h8>
  </div>
  <div class="clearfix"></div>
</div>
<h6>&nbsp;</h6>
<div class="col-sm-12 campaign_chk">
  <h4 class="group-title"><?php echo ucfirst($productname);?></h4>
  <?php 
// echo '<pre>';
  // print_r($proposals);
		if(count($proposals)>0)
		{ 
			foreach($proposals as $proposalscol)
		{ 
			// echo '<pre>';
			// print_r($proposalscol);
			?>
  <ul class="product_listing list-unstyled">
    <li class="clearfix">
      <div class=" col-xs-12 p_block head statushead" id="proposal_<?php echo $proposalscol['bid_id']?>"> 
        <!-- <span class="online_status"><i class="fa fa-circle"></i></span> -->
        <?php 
					$info='';
					if(($userbalance<$proposalscol['user_bid_amt'] && $proposalscol['bidamount_paid']=='0' && $proposalscol['status']==0)) {
							// echo 'here';
						if($userbalance<0) $userbalance=0;
						$requiredbalance=($proposalscol['user_bid_amt']-$userbalance);
						
						$info='You need to <a href="'. site_url('/'.BRAND.'payment/'.$requiredbalance).'">Toup up balance: '. DEFAULT_CURRENCY_SIGN.' '.$requiredbalance .'</a> to accept this proposal.Your current Balance is '.DEFAULT_CURRENCY_SIGN	.' '.$userbalance;
				 }
				// else 
				// 	{  ?>
        <!-- <select  data-bidid="<?php echo $proposalscol['bid_id'];?>" data-productid="<?php echo $proposalscol['product_id'];?>" class="form-control btn btn-sm btn-warning  drop-3 setstatusbrand " style="color:#ffffff"> -->
        
        <?php if($proposalscol['status']=='0'):
        echo 'Pending';
        ?>
      
        <!-- <option <?php if($proposalscol['status']==1) echo 'selected'; ?> value="1">Action Required(Accept)</option>
						
						<option <?php if($proposalscol['status']==4) echo 'selected'; ?> value="4">Reject</option> -->
        <?php

						elseif($proposalscol['status']==7) : ?>
        Completed
        <?php
							elseif($proposalscol['status']==5) : ?>
     Canceled
        <?php
							elseif($proposalscol['status']==6) : ?>
    Expired
           
           <?php  elseif($proposalscol['status']==4) : ?>
            Rejected
      <?php
               
                   else:
                      if($proposalscol['draft_accept']=='' ) echo 'On Progress';
                      if($proposalscol['draft_accept']=='0') echo 'Draft Received';
                      if($proposalscol['draft_accept']=='2') echo 'Draft Rejected';
                      if($proposalscol['draft_accept']=='1' && $proposalscol['upload_status']=='0') echo 'Draft Accepted .Waiting for Upload';
                      if($proposalscol['draft_accept']=='1' && $proposalscol['upload_status']=='1') echo 'Content Uploaded ';
                      // if($proposalscol['draft_accept']=='1' && $proposalscol['socialtrackid']!='' && proposalscol['status']!='7')  echo 'Waiting for Upload';

                endif;?> 
       
        <div class="img-loaderstatus hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
        <?php
        $total_reach_title='Total Fan Count';
						if(defined('YOUTUBEMEDIAID')):
							if(YOUTUBEMEDIAID==$proposalscol['mediaid']){ 
								$total_reach_title='Subscribers';
								?>
        <span class="pull-right round_btn youtube"><i class="fa fa-youtube"></i></span>
        <?php   }
						endif;
						if(defined('FACEBOOKMEDIAID')):
							if(FACEBOOKMEDIAID==$proposalscol['mediaid']){ 
								$total_reach_title='Likes';
								?>
        <span class="pull-right round_btn facebook"><i class="fa fa-facebook"></i></span>
        <?php   }
						endif;
						if(defined('INSTAGRAMMEDIAID')):
							if(INSTAGRAMMEDIAID==$proposalscol['mediaid']){ 
								$total_reach_title='Followers';
								?>
        <span class="pull-right round_btn instagram"><i class="fa fa-instagram"></i></span>
        <?php   }
						endif;
						if(defined('TWITTERMEDIAID')):
							if(TWITTERMEDIAID==$proposalscol['mediaid']){ 
								$total_reach_title='Followers';
								?>
        <span class="pull-right round_btn twitter"><i class="fa fa-twitter"></i></span>
        <?php   }
						endif;
						if(defined('YOUTULEEMEDIAID')):
							if(YOUTULEEMEDIAID==$proposalscol['mediaid']){ 
										$total_reach_title='Followers';
								?>
        <span class="pull-right round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
        <?php   }
						endif;
						if(defined('TUMBLRMEDIAID')):
							if(TUMBLRMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Followers';
								?>
        <span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span>
        <?php   }
						endif;
					?>
      </div>
      <div class="p_block body">
        <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b>Creator Name</b> <span><?php echo $proposalscol['member_name'];?></span> </h5>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b>Ceiling likes</b> <span>
            <?php if($proposalscol['ceiling_likes']!='')echo  $proposalscol['ceiling_likes']; else echo 'N/A';?>
            </span> </h5>
        </div>
        
        <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b>Profession</b> <span><?php echo $proposalscol['profession']?></span> </h5>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b>Age</b> <span>
            <?php if($proposalscol['age']!='')echo  $proposalscol['age']; else echo 'N/A';?>
            </span> </h5>
        </div>
        
        <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b><?php echo $total_reach_title;?>:</b> <span><?php echo $proposalscol['total_reach'];?></span> </h5>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b>Gender</b> <span>
            <?php if($proposalscol['gender']=='m')echo  'Male'  ; else echo 'Female';?>
            </span> </h5>
        </div>
        
       <!--  <div class="col-md-3 col-sm-4 col-xs-6">
          <h5> <b>Phone</b> <span><?php echo $proposalscol['phone'];?></span> </h5>
        </div> -->
        
        
        <div class="clearfix"></div>
      </div>
      <div class="col-xs-12 p_block foot">
        <?php 

				if($proposalscol['status']=='1' || $proposalscol['status']=='2'|| $proposalscol['status']=='3'  ) : 
				if($proposalscol['draft_accept']!='') : 

					?>
        <a class="btn btn-sm btn-warning" href="javascript:void(0)" data-toggle="modal" data-target="#v_draft_<?php echo $proposalscol['bid_id'] ?>"><i class="fa fa-hourglass"></i> View Draft</a>

        <?php 
        endif;
        //if($proposalscol['draft_accept']=='1' && $proposalscol['upload_status']=='1') :  ?>

       <!--  <button class="btn btn-sm btn-primary" data-messageby="brand" data-bidid="<?php echo $proposalscol['bid_id'];?>" id="popupmessage"   ><i class="fa fa-mail-forward"></i>Send Message</button>

        <a class="btn btn-sm btn-warning" href="<?php echo site_url('/'.MY_ACCOUNT.'messages')?>"><i class="fa fa-hourglass"></i> Past Messages</a> -->

        <?php 
       // endif;

					if($proposalscol['draft_accept']=='1' && $proposalscol['upload_status']=='1') : 
					?>
          <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_upload_<?php echo $proposalscol['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Content </a>
        <!--  <a class="btn btn-sm btn-warning" href="javascript:void(0)" data-toggle="modal" data-target="#v_verify_upload_<?php echo $proposalscol['bid_id'] ?>"><i class="fa fa-hourglass"></i> Verify Upload</a>  -->
        <?php endif;
				  	elseif($proposalscol['status']=='4') : ?>
        <a class="btn btn-sm btn-warning" href="javascript:void(0)">Declined</a>
        <?php 
				  	elseif($proposalscol['status']=='5') : ?>
        <a class="btn btn-sm btn-warning" href="javascript:void(0)">Cancelled</a>
        <?php 
				  		elseif($proposalscol['status']=='0') : ?>
        <!-- 	<a class="btn btn-sm btn-warning " href="javascript:void(0)"><i class="fa fa-ban"></i>Proposal Needs Review</a> -->
        <?php 
				  	else: 

                if($proposalscol['status']=='7' && $proposalscol['upload_status']=='1'): ?>
                     <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_upload_<?php echo $proposalscol['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Content </a>
                      <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_report_<?php echo $proposalscol['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Report </a>
                       <a class="btn btn-sm btn-default pull-right " href="<?php echo site_url('/'.BRAND.'download_partial_report/'.$proposalscol['bid_id'])?>"  ><i class="fa fa-download"></i> Download Report</a>
                <?php 
                else: ?>
                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_upload_<?php echo $proposalscol['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Content </a>
                <?php
                endif;
                ?>
       
        <?php 
				  	endif;

				  	 // echo $proposalscol['link'];
				  	?>
        <div class="error_message text-danger hidden"></div>
        

      <!--     <div class="bid_prop pull-right"> <i class="fa fa-list-alt"></i> Proposal Detail <span class="bid_prop_popup"> 
        <div class="popup_head">
                        
                        
                      
                        <?php
                    if(YOUTUBEMEDIAID==$proposalscol['mediaid']){ 
                      ?>
                      <span class="pull-right round_btn youtube"><i class="fa fa-youtube"></i></span>
                <?php   }
                    if(FACEBOOKMEDIAID==$proposalscol['mediaid']){ 
                      ?>
                      <span class="pull-right round_btn facebook"><i class="fa fa-facebook"></i></span>
                <?php   }
                
                    if(INSTAGRAMMEDIAID==$proposalscol['mediaid']){ 
                      ?>
                      <span class="pull-right round_btn instagram"><i class="fa fa-instagram"></i></span>  
                <?php   }
                    if(TWITTERMEDIAID==$proposalscol['mediaid']){ 
                      ?>
                      <span class="pull-right round_btn twitter"><i class="fa fa-twitter"></i></span>
                <?php   }
                    if(YOUTULEEMEDIAID==$proposalscol['mediaid']){ 
                          ?>
                       <span class="pull-right round_btn btn-youtulee">
                                 <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> 
                              </span>
                    
                <?php   }
                    if(TUMBLRMEDIAID==$proposalscol['mediaid']){ 
                      ?>
                      <span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span>  
                <?php   }
                  ?>  
                      <div class="clearfix"></div>
                      </div>
             <div class="popup_body"> <?php echo $proposalscol['bid_details'];?> </div>
        </span> 
      </div> -->
       <!--  <div class="campaign_prop_dtl">
          <span class="pull-right bid_prop"><b>Bid Amount:</b> <?php echo $proposalscol['user_bid_amt'];?></span> 
          <span class="pull-right bid_prop" style="padding:18px 10px 0;">|</span> 
          <span class="pull-right bid_prop"><b>Delivery Date:</b><?php echo $proposalscol['delivery_date'];?></span> 
        </div> -->
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </li>
  </ul>
<?php /********************** Draft Content************************/
      if($proposalscol['draft_accept']!=''):
?>

  <div class="modal fade" id="v_draft_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;">
          <span aria-hidden="true" class="fa fa-times"></span>
        </button>
        <form id="communication" method="post">
          <div class="row no-marg-right">
            <div class="col-sm-4 text-center left_draft_sec pop_left">
              <div class="icon" data-bidid=""> <i class="fa fa-paper-plane-o"></i>
                <h4>Draft</h4>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="right_draft_sec">
                <div class="link_tag">
                  <label>Link Of draft : </label>
                  <a href="javascript:void(0)"><?php echo $proposalscol['link']?></a>
                </div>
                <div>
                  <p> <label>Description : </label><?php echo $proposalscol['description'];?> </p>
                </div>
                <form name="draft_promotion" id="draft_send_<?php echo $proposalscol['bid_id']?>" action="#">
                  <div class="btn_sec">
                    <input type="hidden" name="bid_id_<?php echo $proposalscol['bid_id']?>" value="<?php echo $proposalscol['bid_id']?>">
                    <input type="hidden" name="draft_id_<?php echo $proposalscol['bid_id']?>" value="<?php echo $proposalscol['draft_id']?>">

                    <div class="brwose-image">
                      <img src="<?php echo site_url(DRAFT_IMAGE_PATH.  $proposalscol['image']);?>">
                    </div>

                  <?php if($proposalscol['draft_accept']=='0'):?>
                    <div class="col-sm-6">
                      <button class="btn btn-primary btn_draft" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="accept">
                        <div class="btn-img" style="float:left">
                          <div class="img-loader hidden" style="z-index:1000;"> 
                            <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> 
                          </div>
                          <i class="fa fa-check createcheck"></i> 
                        </div>
                        Accept Draft 
                      </button>
                    </div>
                    <div class="col-sm-6">
                      <button class="btn btn-danger btn_draft" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="reject">
                        <div class="btn-img" style="float:left">
                        <div class="img-loader hidden" style="z-index:1000;"> 
                          <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> 
                        </div>
                        <i class="fa fa-times createcheck"></i> 
                        </div>
                        Reject Draft 
                      </button>
                    </div>
                  <?php endif;?>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif;
/*********************************End of draft*************************************************/ 
?>

<!-- <div class="modal fade" id="v_verify_upload_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
      <form id="" method="post">
      <div class="row no-marg-right">
      <div class="col-sm-4 text-center left_draft_sec pop_left">
        <div class="icon" data-bidid=""> <i class="fa fa-paper-plane-o"></i>
          <h4>Verify UPload</h4>
        </div>
      </div>
      <div class="col-sm-8">
      <div class="right_draft_sec">
      <div class="link_tag"><a href="javascript:void(0)">Has the Promotion Uploaded??</a></div>
      <div>
        <p> If yes please click on Yes. Otherwise send creator a message regarding date and time of upload. </p>
      </div>
      <form name="draft_promotion" id="draft_upload_<?php echo $proposalscol['bid_id'] ?>" action="#">
        <div class="btn_sec">
          <input type="hidden" name="bid_id_<?php echo $proposalscol['bid_id'] ?>" value="<?php echo $proposalscol['bid_id']?>">
          
          <div class="col-sm-6">
                <button class="btn btn-primary btn_draft_upload" id="yes">
                    <div class="btn-img" style="float:left">
                                              <div class="img-loader hidden" style="z-index:1000;">
                                                      <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                              </div>
                                             <i class="fa fa-check createcheck"></i> 
                                 </div> Yes
                        </button>
            </div>
              <div class="col-sm-6">
                <button class="btn btn-danger btn_draft_upload" id="no">
                <div class="btn-img" style="float:left">
                                              <div class="img-loader hidden" style="z-index:1000;">
                                                      <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                              </div>
                                             <i class="fa fa-times createcheck"></i> 
                          </div>
              
                No
                </button>
            </div>
          <div class="col-sm-6">
            <button class="btn btn-primary btn_draft_upload" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="yes">
            <div class="btn-img" style="float:left">
              <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
              <i class="fa fa-check createcheck"></i> </div>
            Yes </button>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-danger btn_draft_upload" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="no">
            <div class="btn-img" style="float:left">
              <div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div>
              <i class="fa fa-times createcheck"></i> </div>
            No </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</form>
</div>
</div>
</div> -->
<?php
/********************************View uploaded Content*************************************************/
 if($proposalscol['upload_status']=='1'):
?>
  <div class="modal fade" id="v_view_upload_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;">
          <span aria-hidden="true" class="fa fa-times"></span>
        </button>

        <div class="col-sm-12">
          <div class="right_draft_sec 123">
            <h3 class="modal_ttl">Uploaded Content</h3>
            <div>
              <ul class="social_posts">
                <?php 
                $content=$this->general->get_uploaded_content($proposalscol['bid_id']);

                if(count($content)>0 && is_array($content)):
                $page=$this->general->get_single_row('member_socialmedia',array('user_id'=>$proposalscol['user_id'],'media_type_id'=>FACEBOOKMEDIAID));

                foreach($content as $eachcontent):
                if($eachcontent->uploaded_media=='fb_page')
                { 

                if(count($page)>0 || strpos($eachcontent->link, '://'))
                {
                $options = array(

                'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n" .
                "Cookie: uptrendly=bar\r\n" .  // check function.stream-context-create on php.net
                "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
                )
                );

                $context = stream_context_create($options);
                if (false === strpos($eachcontent->link, 'https://'))
                {
                $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url=http://facebook.com/'.$page->page_id.'/posts/'.$eachcontent->link.'&omitscript=false';
                }
                else
                {
                $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$eachcontent->link.'&omitscript=false';
                }

                $jsonresp=file_get_contents($request_url,false, stream_context_create($options));
                $response = json_decode($jsonresp, true)['html']; 
                }
                else
                {
                $response= '<a target="_blank" href="http://facebook.com/'.$eachcontent->link.'" >http://facebook/com/'.$eachcontent->link.'</a>';
                }
                ?>

                <li class="f_width">
                  <label>Facebook Page</label>
                  <div class="post"><?php print_r($response);?></div>
                </li>

                <?php
                }
                elseif($eachcontent->uploaded_media=='fb_profile'){
                ?>

                <li>
                  <label>Facebook Profile</label>
                  <div class="post">
                    <div class="fb-post" data-href="<?php echo $eachcontent->link;?>" data-width="auto" data-show-text="true">
                      <blockquote cite="<?php echo $eachcontent->link;?>" class="fb-xfbml-parse-ignore"></blockquote>
                    </div>
                  </div>
                </li>

                <?php 
                }
                //for instagran
                else
                { ?>

                <li>
                  <label>Instagram Post</label>
                  <div class="post">
                    <?php 
                    $request_url = 'https://api.instagram.com/oembed?url=' . $eachcontent->link;
                    $response=(file_get_contents($request_url."&omitscript=false&hidecaption=false"));
                    $json_data = json_decode($response , true);

                    // print_r($json_data);
                    echo $json_data['html'];
                    ?>
                  </div>
                </li>

                <?php
                }
                endforeach;
                else:
                echo '<li> No content Found</li>' ;
                endif; 
                ?>
                
              </ul>
            </div>

          </div>
        </div>


      </div>
    </div>
  </div>

  <?php 

/**************************End of uploaded content****************************************/
  /*******************************Report *************************************************/
?>
  <div class="modal fade" id="v_view_report_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;">
          <span aria-hidden="true" class="fa fa-times"></span>
        </button>

        <div class="row no-marg-right">

          <div class="col-sm-12">
            <div class="right_draft_sec">
              <h3 class="modal_ttl">Report</h3>
              <div>

                <?php 
                $report=$this->general->get_report($proposalscol['bid_id'])
                ?>

                <fieldset>
                  <div id="popupreport<?php echo $proposalscol['bid_id']?>" class="m_overlay">
                    <!-- <a class="cancel" href="#"></a> -->
                    <div class="popup posts">                                                                  

                      <div class="content">
                        <?php 

                        $pagelike='';
                        $pagecomment='';
                        $pageshare='';
                        $profilelike='';
                        $profilecomment='';
                        $profileshare='';
                        $instalike='';
                        $instacomment='';

                        foreach($content as $eachcontent): 

                        if(count($report)>0 && is_array($report))
                        {
                        foreach($report as $eachreport):
                        if($eachcontent->uploaded_media=='fb_page' && $eachcontent->id==$eachreport->content_id)
                        {
                        $pagecontentid=$eachcontent->id;
                        $pagelike=$eachreport->likes;
                        $pagecomment=$eachreport->comments;
                        $pageshare=$eachreport->share;
                        }
                        if($eachcontent->uploaded_media=='fb_profile' && $eachcontent->id==$eachreport->content_id)
                        {
                        $profilecontentid=$eachcontent->id;
                        $profilelike=$eachreport->likes;
                        $profilecomment=$eachreport->comments;
                        $profileshare=$eachreport->share;
                        }
                        if($eachcontent->uploaded_media=='instagram' && $eachcontent->id==$eachreport->content_id)
                        {
                        $instacontentid=$eachcontent->id;
                        $instalike=$eachreport->likes;
                        $instacomment=$eachreport->comments;

                        }
                        endforeach;
                        }

                        ?>

                        <ul class="frm">

                          <?php
                          if($eachcontent->uploaded_media=='fb_page'): ?>

                          <div class="row">
                            <div class="col-sm-12">
                              <li class="txtfull txtttl">
                                <label>Facebook Page</label>
                              </li>
                              <li class="col-sm-4">
                                <div>
                                  <div><label>Uploaded Link</label></div>
                                  <a target="_blank" class="word-wrap" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Like</span></label>
                                  <input class="inputtext reportinputview" name="page_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="page_like" type="text" value="<?php echo set_value('page_like',$pagelike)?>">
                                  <?=form_error('page_like')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Share</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="page_share" type="text" value="<?php echo set_value('page_share',$pageshare)?>">
                                  <?=form_error('page_share')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Comment</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="page_comment" type="text" value="<?php echo set_value('page_comment',$pagecomment)?>">
                                  <?=form_error('page_comment')?>
                                </div>
                              </li>
                            </div>
                          </div>
                          <?php
                          endif;
                          if($eachcontent->uploaded_media=='fb_profile'): ?>
                          <div class="row">
                            <div class="col-sm-12">
                              
                            
                              <input  disabled class="inputtext reportinputview" name="profile_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">

                              <li class="txtfull txtttl">
                                <label>Facebook Profile</label>
                              </li>
                              <li class="col-sm-4">
                                <div>
                                  <div><label>Uploaded Link</label></div>
                                  <a target="_blank" class="word-wrap" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Like</span></label>
                                  <input disabled size="20" class="inputtext reportinputview d_input" name="profile_like" type="text" value="<?php echo set_value('profile_like',$profilelike)?>">
                                  <?=form_error('profile_like')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Share</span></label>
                                  <input disabled size="20" class="inputtext reportinputview d_input" name="profile_share" type="text" value="<?php echo set_value('profile_share',$profileshare)?>">
                                  <?=form_error('profile_share')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Comment</span></label>
                                  <input size="20" disabled class="inputtext reportinputview d_input" name="profile_comment" type="text" value="<?php echo set_value('profile_comment',$profilecomment)?>">
                                  <?=form_error('profile_comment')?>
                                </div>
                              </li>
                            </div>
                          </div>
                          <?php
                          endif;
                          if($eachcontent->uploaded_media=='instagram'): ?>
                          <div class="row">
                            <div class="col-sm-12">
                              
                            
                              <input  disabled class="inputtext reportinputview" name="instagram_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">

                              <li class="txtfull txtttl">
                                <label>Instagram</label>
                              </li>

                              <li class="col-sm-4">
                                <div>
                                  <div><label>Uploaded Link</label></div>
                                  <a target="_blank" class="word-wrap" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                </div>  
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Like</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="instagram_like" type="text" value="<?php echo set_value('instagram_like',$instalike)?>">
                                  <?=form_error('instagram_like')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Comment</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="instagram_comment" type="text" value="<?php echo set_value('instagram_comment',$instacomment)?>">
                                  <?=form_error('instagram_comment')?>
                                </div>
                              </li>
                            </div>
                          </div>
                          <?php
                          endif;
                          ?>
                        </ul>
                        <?php
                        endforeach;
                        ?>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php 
    endif;
/**************************End of Report****************************************/

		}
	}
	else
	{
		echo '<h4 style="color:#337ab7"> No records Found </h4>';
	}  
?>
</div>
<script type="text/javascript">
		
		 var searchurl='<?php echo site_url('/'.BRAND.'ajax_proposal/')?>';
		 var changestatusurl="<?php echo site_url('/'.MY_ACCOUNT.'update_bid_status')?>";
 		 var sendmessage="<?php echo site_url('/'.MY_ACCOUNT.'send_message')?>";
 		 var acceptdraft="<?php echo site_url('/'.MY_ACCOUNT.'acceptreject_draft');?>";
 		 var acceptupload="<?php echo site_url('/'.MY_ACCOUNT.'acceptreject_upload');?>";
 		 var checkbalance="<?php echo site_url('/'.BRAND.'check_user_balance')?>";
 		 var paymentpage="<?php echo site_url('/'.BRAND.'payment')?>";
     var campaignpage="<?php echo site_url('/'.BRAND.'getproposalbyproduct/'.$product_code)?>"

	</script>