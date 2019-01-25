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
			
			?>
					
			<ul class="product_listing list-unstyled">
			<li class="clearfix">	
				<div class=" col-xs-12 p_block head">
					<!-- <span class="online_status"><i class="fa fa-circle"></i></span> -->
					  
        <!-- <select  data-bidid="<?php echo $proposalscol['bid_id'];?>" data-productid="<?php echo $proposalscol['product_id'];?>" class="form-control btn btn-sm btn-warning  drop-3 setstatus " style="color:#ffffff"> -->
        
        <?php 
$info='';
        if($proposalscol['status']=='0'):?>
        <a class="btn btn-sm btn-success setstatus" data-bidid="<?php echo $proposalscol['bid_id'];?>" data-productid="<?php echo $proposalscol['product_id'];?>"  href="javascript:void(0)" value="1"> Accept</a> <a class="btn btn-sm btn-danger setstatus" data-bidid="<?php echo $proposalscol['bid_id'];?>"  data-productid="<?php echo $proposalscol['product_id'];?>" href="javascript:void(0)" value="4">Reject</a> 
        
        <!-- <option <?php if($proposalscol['status']==1) echo 'selected'; ?> value="1">Action Required(Accept)</option>
						
						<option <?php if($proposalscol['status']==4) echo 'selected'; ?> value="4">Reject</option> -->
        <?php

						elseif($proposalscol['status']==7) : ?>
       Completed
        <?php
							elseif($proposalscol['status']==5) : ?>
        <!--< option <?php// if($proposalscol['status']==5) echo 'selected'; ?> value="1"> -->Canceled<!-- </option> -->
        <?php
							elseif($proposalscol['status']==6) : ?>
        <!--< option <?php //if($proposalscol['status']=6) echo 'selected'; ?> value="1"> -->Expired<!-- </option> -->
        
        <?php
						elseif($proposalscol['status']==4) : ?>
        <!-- <option <?php// if($proposalscol['status']=='4') echo 'selected'; ?> value="4"> -->Rejected<!-- </option> -->
        <?php
						else:
							 if($proposalscol['status']==1):?>
        <a class="btn btn-sm btn-danger setstatus" data-bidid="<?php echo $proposalscol['bid_id'];?>"  data-productid="<?php echo $proposalscol['product_id'];?>" href="javascript:void(0)" value="2">Changes Required</a>
        <?php endif;?>
        <?php if($proposalscol['status']==2):?>
        <a class="btn btn-sm btn-danger setstatus" data-bidid="<?php echo $proposalscol['bid_id'];?>"  data-productid="<?php echo $proposalscol['product_id'];?>" href="javascript:void(0)" value="5">Cancel and Refunded</a>
        <?php endif;?>
        <a class="btn btn-sm btn-danger setstatus" data-bidid="<?php echo $proposalscol['bid_id'];?>"  data-productid="<?php echo $proposalscol['product_id'];?>" href="javascript:void(0)" value="7">Completed</a>
        <?php endif;?>
        </select>
        <?php
				echo $info; 
				// }
				?>
					<!--  <div class="img-loaderstatus hidden" style="z-index:1000;">
               				 <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
     			    </div> -->
				<?php
						if(defined('YOUTUBEMEDIAID') && YOUTUBEMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Subscribers';
							?>
							<span class="pull-right round_btn youtube"><i class="fa fa-youtube"></i></span>
				<?php   }
						if(defined('FACEBOOKMEDIAID') && FACEBOOKMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Likes';
							?>
							<span class="pull-right round_btn facebook"><i class="fa fa-facebook"></i></span>
				<?php   }
				
						if(defined('INSTAGRAMMEDIAID') && INSTAGRAMMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Followers';
							?>
							<span class="pull-right round_btn instagram"><i class="fa fa-instagram"></i></span>	
				<?php   }
						if(defined('TWITTERMEDIAID') && TWITTERMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Followers';
							?>
							<span class="pull-right round_btn twitter"><i class="fa fa-twitter"></i></span>
				<?php   }
						if(defined('YOUTULEEMEDIAID') &&  YOUTULEEMEDIAID==$proposalscol['mediaid']){ 
									$total_reach_title='Followers';
							?>
							 <span class="pull-right round_btn btn-youtulee">
                                   <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> 
                                </span>
						
				<?php   }
						if(defined('TUMBLRMEDIAID') && TUMBLRMEDIAID==$proposalscol['mediaid']){ 
						$total_reach_title='Followers';
							?>
							<span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span>	
				<?php   }
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

					if($proposalscol['draft_accept']=='1' && $proposalscol['upload_status']!=null) : 
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
				  			<a class="btn btn-sm btn-warning" href="javascript:void(0)">Proposal Needs Review</a>
				  	<?php 
				  	else: ?> 
				  		<a class="btn btn-sm btn-warning" href="javascript:void(0)">Completed</a>
				  		<?php 
				  	endif;
				  	?>
					<div class="bid_prop pull-right">
						<i class="fa fa-list-alt"></i> Proposal Detail
					
						<span class="bid_prop_popup">
							<div class="popup_head">
								
								<span><b>Bid Amount:</b> <?php echo $proposalscol['user_bid_amt'];?></span>
								<span style="padding:0 10px;">|</span>
								<span><b>Delivery Date:</b><?php echo $proposalscol['delivery_date'];?></span>
							
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
							<span class="pull-right round_btn vine"><i class="fa fa-vine"></i></span>
						
				<?php   }
						if(TUMBLRMEDIAID==$proposalscol['mediaid']){ 
							?>
							<span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span>	
				<?php   }
					?>	
							</div>
							<div class="popup_body">
								<?php echo $proposalscol['bid_details'];?>
							</div>
						</span>
					</div>
					 <div class="error_message text-danger"></div>
				</div>
			</li>

		</ul>

		 <div class="modal fade" id="v_draft_<?php echo $proposalscol['bid_id'] ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
	<form id="draft_<?php echo $proposalscol['bid_id'] ?>" method="post">
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
    				<form name="draft_promotion_<?php echo $proposalscol['bid_id'] ?>" id="draft_send_<?php echo $proposalscol['bid_id']?>" action="#">
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
	<form id="communication" method="post">
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
    				<form name="draft_promotion" id="draft_upload_<?php echo $proposalscol['bid_id']?>" action="#">
    				<div class="btn_sec">
    				<input type="hidden" name="bid_id_<?php echo $proposalscol['bid_id']?>" value="<?php echo $proposalscol['bid_id']?>">
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
		 var acceptdraft="<?php echo site_url('/'.MY_ACCOUNT.'acceptreject_draft');?>";
		 var acceptupload="<?php echo site_url('/'.MY_ACCOUNT.'acceptreject_upload');?>";
		 var searchurl='<?php echo site_url('/'.CREATOR.'ajax_proposal/'.$product_id)?>';
		 var changestatusurl="<?php echo site_url('/'.MY_ACCOUNT.'update_bid_status')?>";
 		 var sendmessage="<?php echo site_url('/'.MY_ACCOUNT.'send_message')?>";
 		 var action='<?php echo site_url('/'.CREATOR.'ajax_collab')?>';
	</script>