<div class="prop_list">
	<div class="col-sm-12 filter-sec">
		<div class="text-filter">
			<div class="col-md-6 col-sm-12">
            <input type="text" class="form-control name" placeholder="Search by creators name" />
			<button class="btn-search filteroptname" data-productid="<?php echo $product_id;?>"><i class="fa fa-search"></i>&nbsp;Search</button>
			</div>
			<div class="drop-filter text-right col-md-6 col-sm-12">
				<select class="form-control filter mediachannel drop pull-right" data-productid="<?php echo $product_id;?>">
					<option value="">Change Media</option>
					<?php if(defined('FACEBOOKMEDIAID')) :?><option value="<?php echo FACEBOOKMEDIAID;?>">Facebook</option><?php endif;?>
					<?php if(defined('YOUTUBEMEDIAID')) :?><option value="<?php echo YOUTUBEMEDIAID;?>">YouTube</option><?php endif;?>
				  <?php if(defined('INSTAGRAMMEDIAID')) :?>	<option value="<?php echo INSTAGRAMMEDIAID?>">Instagram</option><?php endif;?>
			   	<?php if(defined('TWITTERMEDIAID')) :?>	<option value="<?php echo TWITTERMEDIAID?>">Twitter</option><?php endif;?>
					<?php if(defined('YOUTULEEMEDIAID')) :?><option value="<?php echo YOUTULEEMEDIAID;?>">Youtulee</option><?php endif;?>
			    <?php if(defined('TUMBLRMEDIAID')) :?>		<option value="<?php echo TUMBLRMEDIAID?>">Tumblr</option><?php endif;?>
				</select>
				<select class="form-control filter status drop pull-right " data-productid="<?php echo $product_id;?>">
						<option value="">Change Status</option>
						<option value="0">Proposal Submitted</option>
						<option value="1">Action Required</option>
						<option value="2">Changes Required</option>
						<option value="3">Funding Required</option>
						<option value="4">Declined</option>
						<option value="5">Canceled & Refunded</option>
					
						<option value="7">Completed</option>
				</select>
        <div class="clearfix"></div>
			</div>
            <div class="clearfix"></div>
		</div>
		
	</div>
	  <div class="img-loader" style="z-index:1000;display: none">
                <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
       </div>
	<div class="filterview">
	<?php $this->load->view('ajax_proposal');?>
	</div>




</div>


<!-- ---Modal-- -->
<div class="modal fade sendmsg" id="sendmsg" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
	      <div class="row no-marg-right">
        	<div class="col-sm-4 text-center pop_left">
        		<div class="icon"  data-bidid="">
        			<i class="fa fa-mail-forward"></i>
        			<h4>Send Message</h4>
        		</div>
        		
        		<a class="btn btn-sm btn-warning top-marg-30" href="<?php echo site_url('/'.MY_ACCOUNT.'messages')?>">
            <i class="fa fa-hourglass"></i>Past Messages</a>

        	</div>
        	<form id="brndcommunication" method="post" action="#">
  
        	<div class="col-sm-8">
        		<div class="form-group">
        		<!-- 	<label>Subject</label>
        		<input type="text" class="form-control" placeholder="Subject"/>
        		 -->
        			<label>Message</label>
        			<textarea class="form-control" name="message" id="message" placeholder="Enter your message here ..." rows="5"></textarea>
        		</div>
        		<div class="form-group">
        			<button type="submit" class="btn btn-sm btn-primary" id="sendmsgbtn" data-messageby="" data-bidid=""> 
        					<div class="btn-img" style="float:left">
                                          <div class="img-loader hidden" style="z-index:1000;">
                                                  <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                                          </div>
                                         <i class="fa fa-mail-forward defaultico"></i>
                             </div> Send Message
              </button>
                           
        		</div>
        	</div>
          </form>
        </div>
 
      </div>
    </div>
 </div>

