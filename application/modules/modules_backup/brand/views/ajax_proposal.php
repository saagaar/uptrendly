<div class="proposal_stat">
		<div class="col-xs-3">
			<h8>
				Received
				<span><?php echo isset($proposals['0']['proposalcount'])?$proposals['0']['proposalcount']:'0';?></span>
			</h8>
		</div>
		<div class="col-xs-3">
			<h8>
				Production
				<span><?php echo isset($proposals['0']['productioncount'])?$proposals['0']['productioncount']:'0';?></span>
			</h8>
		</div>
		<div class="col-xs-3">
			<h8>
				Completed
				<span><?php echo isset($proposals['0']['completedcount'])?$proposals['0']['completedcount']:'0';?></span>
			</h8>
		</div>
		<div class="col-xs-3">
			<h8>
				Spend
				<span><?php echo isset($proposals['0']['spend'])?$proposals['0']['spend']:'0';?></span>
			</h8>
		</div>
	</div>

	<h6>&nbsp;</h6>
	<div class="col-sm-12">
		<h4 class="group-title"><?php echo ucfirst($productname);?></h4>
		<?php 
		if(count($proposals)>0)
		{ 
			foreach($proposals as $proposalscol)
		{ 
			// echo '<pre>';
			// print_r($proposalscol);
			?>
					
			<ul class="product_listing list-unstyled">
			<li class="clearfix">	
				<div class=" col-xs-12 p_block head" id="proposal_<?php echo $proposalscol['bid_id']?>">
					<!-- <span class="online_status"><i class="fa fa-circle"></i></span> -->
					<?php if(($userbalance<$proposalscol['user_bid_amt'] && $proposalscol['bidamount_paid']=='0' && $proposalscol['status']<1)) {
							
						if($userbalance<0) $userbalance=0;
						$requiredbalance=($proposalscol['user_bid_amt']-$userbalance);
						?>
						You need to <a href="<?php echo site_url('/'.BRAND.'payment/'.$requiredbalance)?>">Toup up balance:<?php echo DEFAULT_CURRENCY_SIGN.' '.$requiredbalance ;?></a> to accept this proposal.Your current Balance is <?php echo DEFAULT_CURRENCY_SIGN	.' '.$userbalance;?>
				<?php }
				else 
					{  ?>
						<select data-bidid="<?php echo $proposalscol['bid_id'];?>" data-productid="<?php echo $proposalscol['product_id'];?>" class="form-control drop-3 setstatusbrand ">
					
						<?php if($proposalscol['status']=='0'):?>
						<option <?php if($proposalscol['status']==0) echo 'selected'; ?> value="0">Proposal Sent</option>
					
						<option <?php if($proposalscol['status']==1) echo 'selected'; ?> value="1">Action Required</option>
						
						<option <?php if($proposalscol['status']==4) echo 'selected'; ?> value="4">Declined</option>
						<?php

						elseif($proposalscol['status']==7) : ?>
						<option <?php if($proposalscol['status']==7) echo 'selected'; ?> value="1">Completed</option>
						<?php
						elseif($proposalscol['status']==4) : ?>
						<option <?php if($proposalscol['status']=='4') echo 'selected'; ?> value="4">Rejected</option>
						<?php
						else:
						 if($proposalscol['status']>=1):?>
							<option <?php if($proposalscol['status']==1) echo 'selected'; ?> value="1">Action Required</option>
							<option <?php if($proposalscol['status']==2) echo 'selected'; ?> value="2">Changes Required</option>
							<option <?php if($proposalscol['status']==3) echo 'selected'; ?> value="3">Funding Required</option>
						<?php endif;?>
						<?php if($proposalscol['status']==0):?>
							<option <?php if($proposalscol['status']==4) echo 'selected'; ?> value="4">Declined</option>
						<?php endif;?>
						<?php if($proposalscol['status']>=1):?>
							<option <?php if($proposalscol['status']==5) echo 'selected'; ?> value="5">Canceled & Refunded</option>
							<option <?php if($proposalscol['status']==7) echo 'selected'; ?> value="7">Completed</option>
						<?php endif;?>
						<?php endif;?>
					</select>
				<?php 
				}
				?>
					 <div class="img-loaderstatus hidden" style="z-index:1000;">
               				 <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
     			    </div>
				<?php
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
							 <span class="pull-right round_btn btn-youtulee">
                                   <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> 
                                </span>
							
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
					<div class="col-xs-3">
						<h5>
							<b>Creator Name</b>
							<span><?php echo $proposalscol['member_name'];?></span>
						</h5>
						<h5>
							<b><?php echo $total_reach_title;?>:</b>
							<span><?php echo $proposalscol['total_reach'];?></span>
						</h5>
						
						
					</div>
					<div class="col-xs-3">
						<h5>
							<b>Country</b>
							<span><?php if($proposalscol['country']!='')echo  $proposalscol['country']; else echo 'N/A';?></span>
						</h5>
						
						<h5>
						<b>	Primary Audience Country</b>
							<span><?php if($proposalscol['audience_geography']!='')echo  $proposalscol['audience_geography']; else echo 'N/A';?></span>
						</h5>
					</div>
					<div class="col-xs-3">
						<h5>
							<b>Channel Category</b>
							<span>example category</span>
						</h5>											
					</div>
					<div class="col-xs-3">
						<h5>
							<b>Primary Audience Age</b>
							<span><?php echo $proposalscol['audience_demographic'];?></span>
						</h5>
						<h5>
							Primary Audience Gender
							<span>Male</span>
						</h5> 
					</div>
					
				</div>
				
				
				
				<div class="col-xs-12 p_block foot">
					<?php 
				if($proposalscol['status']=='1' || $proposalscol['status']=='2'|| $proposalscol['status']=='3'  ) : 
				if($proposalscol['bid_id']==$proposalscol['draft']) : 

					?>
					<a class="btn btn-sm btn-warning" href="javascript:void(0)" data-toggle="modal" data-target="#v_draft_<?php echo $proposalscol['bid_id'] ?>"><i class="fa fa-hourglass"></i> View Draft</a>
				  	<?php endif;?>
					<button class="btn btn-sm btn-primary" data-messageby="brand" data-bidid="<?php echo $proposalscol['bid_id'];?>" id="popupmessage"   ><i class="fa fa-mail-forward"></i>Send Message</button>			
					<a class="btn btn-sm btn-warning" href="<?php echo site_url('/'.MY_ACCOUNT.'messages')?>"><i class="fa fa-hourglass"></i> Past Messages</a> 
					<?php 

					if($proposalscol['draft_accept']=='1' && $proposalscol['socialtrackid']!=null) : 
					?>
					<a class="btn btn-sm btn-warning" href="javascript:void(0)" data-toggle="modal" data-target="#v_verify_upload_<?php echo $proposalscol['bid_id'] ?>"><i class="fa fa-hourglass"></i> Verify Upload</a>
				  	<?php endif;
				  	elseif($proposalscol['status']=='4') : ?>
				  			<a class="btn btn-sm btn-warning" href="javascript:void(0)">Declined</a>
				  	<?php 
				  	elseif($proposalscol['status']=='5') : ?>
				  			<a class="btn btn-sm btn-warning" href="javascript:void(0)">Cancelled</a>
				  	<?php 
				  		elseif($proposalscol['status']=='0') : ?>
				  			<a class="btn btn-sm btn-warning " href="javascript:void(0)"><i class="fa fa-ban"></i>Proposal Needs Review</a>
				  	<?php 
				  	else: ?> 
				  		<a class="btn btn-sm btn-warning" href="javascript:void(0)">Completed</a>
				  		<?php 
				  	endif;

				  	 // echo $proposalscol['link'];
				  	?>

				  	<div class="error_message text-danger hidden"></div>

					<div class="bid_prop pull-right">

						<i class="fa fa-list-alt"></i> Proposal Detail
					
						<span class="bid_prop_popup">
							<!-- <div class="popup_head">
								
								
							
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
							</div> -->
							<div class="popup_body">
								<?php echo $proposalscol['bid_details'];?>
							</div>
						</span>
					</div>
					<span class="pull-right bid_prop"><b>Bid Amount:</b> <?php echo $proposalscol['user_bid_amt'];?></span>
					<span class="pull-right bid_prop" style="padding:18px 10px 0;">|</span>
					<span class="pull-right bid_prop"><b>Delivery Date:</b><?php echo $proposalscol['delivery_date'];?></span>

					
					
				</div>
			</li>

		</ul>

 <div class="modal fade" id="v_draft_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
	<form id="communication" method="post">
        <div class="row no-marg-right">
        	<div class="col-sm-4 text-center left_draft_sec pop_left">
        		<div class="icon" data-bidid="">
        			<i class="fa fa-paper-plane-o"></i>
        			<h4>Draft</h4>
        		</div>

        	</div>
        	
        	<div class="col-sm-8">
        		<div class="right_draft_sec">
        			<div class="link_tag"><a href="javascript:void(0)"><?php echo $proposalscol['link']?></a></div>
        			<div>
        				<p>
        					<?php echo $proposalscol['description'];?>
        				</p>
    				</div>
    				<form name="draft_promotion" id="draft_send_<?php echo $proposalscol['bid_id']?>" action="#">
    				<div class="btn_sec">
    				<input type="hidden" name="bid_id_<?php echo $proposalscol['bid_id']?>" value="<?php echo $proposalscol['bid_id']?>">
    				<input type="hidden" name="draft_id_<?php echo $proposalscol['bid_id']?>" value="<?php echo $proposalscol['draft_id']?>">
    				
    					<div class="col-sm-6">
    						<button class="btn btn-primary btn_draft" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="accept">
		    						<div class="btn-img" style="float:left">
		                                          <div class="img-loader hidden" style="z-index:1000;">
		                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
		                                          </div>
		                                         <i class="fa fa-check createcheck"></i> 
		                             </div> Accept Draft
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
    					
    				</div>
    				</form>
        		</div>
        	</div>
        </div>
 	</form>  
      </div>
    </div>
  </div>

  	
   <div class="modal fade" id="v_verify_upload_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
	<form id="" method="post">
        <div class="row no-marg-right">
        	<div class="col-sm-4 text-center left_draft_sec pop_left">
        		<div class="icon" data-bidid="">
        			<i class="fa fa-paper-plane-o"></i>
        			<h4>Verify UPload</h4>
        		</div>

        	</div>
        	
        	<div class="col-sm-8">
        		<div class="right_draft_sec">
        			<div class="link_tag"><a href="javascript:void(0)">Has the Promotion Uploaded??</a></div>
        			<div>
        				<p>
        					If yes please click on Yes. Otherwise send creator a message regarding date and time of upload.
        				</p>
    				</div>
    				<form name="draft_promotion" id="draft_upload_<?php echo $proposalscol['bid_id'] ?>" action="#">
    				<div class="btn_sec">
    				<input type="hidden" name="bid_id_<?php echo $proposalscol['bid_id'] ?>" value="<?php echo $proposalscol['bid_id']?>">
    				
    					<!-- <div class="col-sm-6">
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
						</div> -->
						<div class="col-sm-6">
    						<button class="btn btn-primary btn_draft_upload" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="yes">
		    						<div class="btn-img" style="float:left">
		                                          <div class="img-loader hidden" style="z-index:1000;">
		                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
		                                          </div>
		                                         <i class="fa fa-check createcheck"></i> 
		                             </div> Yes
		                    </button>
						</div>
    					<div class="col-sm-6">
    						<button class="btn btn-danger btn_draft_upload" data-bidid="<?php echo  $proposalscol['bid_id'] ?>" data-val="no">
    						<div class="btn-img" style="float:left">
		                                          <div class="img-loader hidden" style="z-index:1000;">
		                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
		                                          </div>
		                                         <i class="fa fa-times createcheck"></i> 
		                      </div>
    					
    						No
    						</button>
						</div>
    					
    				</div>
    				</form>
        		</div>
        	</div>
        </div>
 	</form>  
      </div>
    </div>
  </div>
<?php   
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

	</script>