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
				<span>0</span>
			</h8>
		</div>
		<div class="col-xs-3">
			<h8>
				Completed
				<span>0</span>
			</h8>
		</div>
		<div class="col-xs-3">
			<h8>
				Spend
				<span>0</span>
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
					<select data-bidid="<?php echo $proposalscol['bid_id'];?>" data-productid="<?php echo $proposalscol['product_id'];?>" class="form-control drop-3 setstatus">
						<option <?php if($proposalscol['status']==0) echo 'selected'; ?> value="0">Proposal Sent</option>
						<option <?php if($proposalscol['status']==1) echo 'selected'; ?> value="1">Action Required</option>
						<option <?php if($proposalscol['status']==2) echo 'selected'; ?> value="2">Changes Required</option>
						<option <?php if($proposalscol['status']==3) echo 'selected'; ?> value="3">Funding Required</option>
						<option <?php if($proposalscol['status']==4) echo 'selected'; ?> value="4">Declined</option>
						<option <?php if($proposalscol['status']==5) echo 'selected'; ?> value="5">Canceled & Refunded</option>
						<option <?php if($proposalscol['status']==7) echo 'selected'; ?> value="7">Completed</option>
						
					</select>
					 <div class="img-loaderstatus" style="z-index:1000;display: none">
               				 <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
     			    </div>
				<?php
						if(YOUTUBEMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Subscribers';
							?>
							<span class="pull-right round_btn youtube"><i class="fa fa-youtube"></i></span>
				<?php   }
						if(FACEBOOKMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Likes';
							?>
							<span class="pull-right round_btn facebook"><i class="fa fa-facebook"></i></span>
				<?php   }
				
						if(INSTAGRAMMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Followers';
							?>
							<span class="pull-right round_btn instagram"><i class="fa fa-instagram"></i></span>	
				<?php   }
						if(TWITTERMEDIAID==$proposalscol['mediaid']){ 
							$total_reach_title='Followers';
							?>
							<span class="pull-right round_btn twitter"><i class="fa fa-twitter"></i></span>
				<?php   }
						if(VINEMEDIAID==$proposalscol['mediaid']){ 
									$total_reach_title='Followers';
							?>
							<span class="pull-right round_btn vine"><i class="fa fa-vine"></i></span>
						
				<?php   }
						if(TUMBLRMEDIAID==$proposalscol['mediaid']){ 
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
					<button class="btn btn-sm btn-primary" data-messageby="brand" data-bidid="<?php echo $proposalscol['bid_id'];?>" id="popupmessage"   ><i class="fa fa-mail-forward"></i>Send Message</button>			
					<a class="btn btn-sm btn-warning" href="<?php echo site_url('/'.MY_ACCOUNT.'messages')?>"><i class="fa fa-hourglass"></i> Past Messages</a>  <div class="error_message text-danger"></div>
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
						if(VINEMEDIAID==$proposalscol['mediaid']){ 
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
				</div>
			</li>

		</ul>
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
		 var changestatusurl="<?php echo site_url('/'.MY_ACCOUNT.'/'.'update_bid_status')?>";
 		 var sendmessage="<?php echo site_url('/'.MY_ACCOUNT.'send_message')?>";
	</script>