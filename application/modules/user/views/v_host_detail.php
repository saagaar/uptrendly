<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">
    stLight.options({
        publisher: "967ea393-a404-468c-976f-a0b02e91e0ab",
		doNotHash: false, doNotCopy: false, 
		hashAddressBar: false,
        onhover: false,
		shareButtonColor:'#488D11',
		headerTextColor:'#49535C',
		helpTextColor:'#e45600',
		textBoxFontColor:'#BDCAD6'
    });
</script>

<style>
/*.st_sharethis_custom{
	background: url("http://path/to/image/file") no-repeat scroll left top transparent;
	padding:0px 16px 0 0;
}*/
</style>

<div class="mid_part">
  <div class="container">
    <div class="row">
      <aside class="col-md-12 col-sm-12">
        <div class="white_box">
          <section class="add_product_sec inventry_sec">
          
            <div class="title_head">
              <div class="row">
              	<div class="col-md-7 col-sm-6 col-xs-12">
                  <h3><?php echo $host->host_name; ?> <span><?php echo $this->general->month_date_time_format($host->start_date_time); ?> EST</span></h3>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-12">
                  <div class="pull-right">
                  <?php 
				  	if($user_id && $user_id!='' && $user_id!=$host->seller_id){
                    	if($host->public_private=='public' && $host->co_sellers_auctions >= $cosellers_auctions){
							if($host_terms_accepted){
								?>
                    			<span class="btn-green">
                                	<a href="<?php echo site_url('/'.MY_ACCOUNT.'inventory_host_auctions?host='.$host->id.'&cat='.$host->category.'&subcat='.$host->subcategory.'&sbid='.$host->start_bid_amount.'&fs='.$host->free_shipping.'&type=cohost'); ?>">Submit to Sell</a>
                              	</span>
                    			<?php }else{ ?>
                    			<span class="btn-green">
                                	<a href="javascript:void(0)" data-toggle='modal' data-target='#acceptTermsPopup'>Submit to Sell</a>
                              	</span>
								<?php } ?>
                    		<?php } ?>
                    
                    		<div id="reminderArea" class="reminder-area">
                                <?php if(isset($reminder) && $reminder!=false){ ?>
                                    <span class="btn-gray"><a href="javascript:void(0)" class="btn_cat" id="removeReminder" data-host='<?php echo $host->id; ?>' data-uid='<?php echo $user_id; ?>' data-type='host' data-item="">We'll Remind You</a></span>
                                <?php }else{ ?>
                                    <span class="btn-yellow"><a href="javascript:void(0)" class="btn_cat" id="setReminder" data-host='<?php echo $host->id; ?>' data-uid='<?php echo $user_id; ?>' data-type='host' data-item="">Set a Reminder</a></span>
                                <?php } ?>
                             </div>
                             
                             <span class="share_icon">
                        	<a href="<?php echo site_url(MY_ACCOUNT.'social_share/host/'.$host->id.'/'.$this->general->clean_url($host->host_name)); ?>"><i class="fa fa-share-alt"></i></a>
                      	</span>	 
                    	<?php }else{ ?>
                			<span class="btn-green">
                            	<a href="javascript:void(0)" class="btn_cat" data-toggle='modal' data-target='#loginSignupModal'>Set a Reminder</a>
                           	</span>
                            <span class="share_icon">
                        	<?php /*?><a href="<?php echo site_url(MY_ACCOUNT.'social_share/host/'.$host->id.'/'.$this->general->clean_url($host->host_name)); ?>"><i class="fa fa-share-alt"></i></a><?php */?>
                            <span class='st_sharethis_large' displayText='ShareThis'></span>
                      	</span>	
              			<?php } ?>
                	</div>
                   </div>
              	</div>
            </div>
            
            
            <div class="row host_detail">
              <aside class="col-md-3">
                <?php if($auctions){ ?>
                	<figure><img src="<?php echo site_url().PRODUCT_IMAGE_PATH.'live_'.$auctions[0]->product_image; ?>"></figure>
                <?php } ?>
              </aside>
              <aside class="<?php ($cosellers)?'col-md-6':'col-md-9'; ?>">
                <div class="host_ttl">
                  <ul>
                    <li>Hosted By <a href="<?php echo site_url('/user/'.$host->seller_id.'/'.$this->general->clean_url($host->seller_name)); ?>"><span><?php echo $host->seller_name; ?></span></a></li>
                    <li class="top_rate"> <img src="<?php echo site_url(USER_IMG_DIR) ?>/top_rate.png"> <span>
                      <p>Top</p>
                      <p>Rated</p>
                      </span> </li>
                  </ul>
                </div>
                <article>
                  <p><?php echo $host->description; ?></p>
                </article>
              </aside>
              <?php if($cosellers){ ?>
              <aside class="col-md-3 co-seller">
                <h5>Co-Sellers</h5>
                <ul>
                  <?php foreach($cosellers as $coseller){ ?>
                  <li><a href="<?php echo site_url('user/'.$coseller->id.'/'.$this->general->clean_url($coseller->name)); ?>"><?php echo $coseller->name; ?></a></li>
                  <?php } ?>
                </ul>
              </aside>
              <?php } ?>
              <div class="clearfix"></div>
            </div>
          </section>
        </div>
      </aside>
      <?php if($auctions){foreach($auctions as $auction){ ?>
      <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
        <div class="categories cat_bdr border_transparent text-center">
          <h2><a href="<?php echo site_url('/buy-product/'.$auction->product_id.'/'.$this->general->clean_url($auction->product_name)); ?>"><?php echo $this->general->string_limit($auction->product_name,20); ?></a></h2>
          <figure><a href="<?php echo site_url('/buy-product/'.$auction->product_id.'/'.$this->general->clean_url($auction->product_name)); ?>"><img src="<?php echo site_url().PRODUCT_IMAGE_PATH.'live_'.$auction->product_image; ?>" alt=""></a></figure>
          <div class="row bid_info clearfix">
            <div class="col-md-5 col-sm-4 text-left"><i class="fa fa-star"></i> 21</div>
            <div class="col-md-7 col-sm-8 text-right">
              <?php if($auction->buy_now==1){?>
              <i class="fa fa-shopping-cart"></i> <?php echo DEFAULT_CURRENCY_SIGN.$auction->buy_now_price; ?>
              <?php }else{ ?>
              <i class="fa fa-clock-o"></i>
              <?php
					if(date('Y-m-d',strtotime($current_date)) == date('Y-m-d',strtotime($host->start_date_time))){
						echo $this->general->time_format($host->start_date_time);
					}else{
						echo $this->general->short_date_time_format($host->start_date_time);
					}
				}
			?>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </aside>
      <?php }}else{ ?>
      <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
        <div class="categories text-center">No Auction found in this host</div>
        <div class="clearfix"></div>
      </aside>
      <?php } ?>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?php 

if($user_id && !$host_terms_accepted){ ?>
<div id="acceptTermsPopup" class="modal fade host_terms" role="dialog">
  <div class="modal-dialog edit-modal">
  <!-- Modal content-->
  <form method="post" action="" id="acceptTermsForm">
    <input type="hidden" name="seller" value="<?php echo $user_id; ?>" />
    <input type="hidden" name="host" value="<?php echo $host->id; ?>" />
    <div class="modal-content">
      <div class="modal-body">
        <h3>Terms and Conditions</h3>
        <?php echo $host->host_terms; ?> </div>
      <div class="btn-green form-group clearfix">
        <label>Accept Terms</label>
        <input type="checkbox" name="accept" value="yes" />
      </div>
      <div class="btn-green form-group clearfix">
        <button type="submit"  class="btn_cat" id="acceptTermsBtn">Proceed</button>
      </div>
      <div class="text-center cancel_txt"><a href="javascript:void(0)" data-dismiss="modal">Cancel</a></div>
    </div>
  </form>
</div>
</div>
<script>
	var urlAcceptTerms = '<?php echo site_url('user/users/ajax_accept_host_auction_terms'); ?>';
	var urlAddCoHostAuctions = '<?php echo site_url('/'.MY_ACCOUNT.'inventory_host_auctions?host='.$host->id.'&cat='.$host->category.'&subcat='.$host->subcategory.'&sbid='.$host->start_bid_amount.'&fs='.$host->free_shipping.'&type=cohost'); ?>';
</script>
<?php } ?>

<script>
	var urlAddReminder = '<?php echo site_url('/home/add_item_auction_to_reminder'); ?>';
	var urlRemoveReminder = '<?php echo site_url('/home/remove_item_auction_from_reminder'); ?>';
</script>
