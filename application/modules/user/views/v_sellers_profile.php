<section class="mid_part">
  <div class="container">
    <div class="row">
      <aside class="col-md-12 col-sm-12">
        <div class="white_box">
          <div class="row host_detail">
            <aside class="col-md-2">
              <figure>
                <?php if($seller->image!=''){ ?>
                <img src="<?php echo base_url(USER_IMAGE_PATH.$seller->image); ?>">
                <?php } else{?>
                <img src="<?php echo base_url(USER_IMG_DIR); ?>/avatar.jpg">
                <?php }	?>
              </figure>
              <?php /*if($this->session->userdata(SESSION.'user_id') == $seller->id) {?>
            <div>
			<form id="changeProfileImageForm" enctype="multipart/form-data" method="post" action="<?php echo site_url('/user/user/upload_profile_image/'.$seller->id);?>">
        		<input type="hidden" name="uid" value="<?php echo $seller->id;?>">
        		<input type="hidden" name="old_file" value="<?php if($seller->image)echo $seller->image;?>">
        		<a class="file-input-wrapper btn btn-default" href="javascript:void(0);">
        			<i class="fa-icon-pencil"></i> Change <input type="file" name="profile_picture" id="profilePicture" onchange="this.form.submit()">
        		</a>
        	</form>
        	</div>
		<?php }*/ ?>
            </aside>
            <aside class="col-md-5">
              <div class="host_ttl account_name">
                <ul>
                  <li><?php echo $seller->name; ?></li>
                  <li class="top_rate"><img src="<?php echo base_url(USER_IMG_DIR); ?>/top_rate.png"><span>
                    <p>Top</p>
                    <p>Rated</p>
                    </span></li>
                </ul>
              </div>
              <article>
                <p>
                  <?php if(isset($seller->seller_bio)){ echo $seller->seller_bio; } ?>
                </p>
              </article>
            </aside>
            <aside class="col-md-3 ac_view">
              <ul>
                <li><i class="fa fa-comments">&nbsp;</i> 532 Positive feedback</li>
                <?php if($seller->state!='' && $seller->country!=''){ ?>
                <li><i class="fa fa-map-marker">&nbsp;</i> <?php echo $seller->state; ?>, <?php echo $seller->country; ?></li>
                <?php } ?>
                <li><i class="fa fa-bookmark">&nbsp;</i> Member since <?php echo date('Y',strtotime($seller->reg_date)); ?></li>
              </ul>
            </aside>
            <aside class="col-md-2 right_link">
              <ul>
                <?php
                    if($this->session->userdata(SESSION.'user_id') && $this->session->userdata(SESSION.'user_id')!=''){
                        if($this->session->userdata(SESSION.'user_id')!=$seller->id){ ?>
                <li><a href="javascript:void(0)" data-toggle='modal' data-target='#sendMessagePopup'><i class="fa fa-paper-plane">&nbsp;</i> Contact</a></li>
                <?php } }else{ ?>
                <li><a href="javascript:void(0)" data-toggle='modal' data-target='#loginSignupModal'><i class="fa fa-paper-plane">&nbsp;</i> Contact</a></li>
                <?php } ?>
                <li>
                  <?php if(isset($seller->shop_url) && $seller->shop_url!=''){ ?>
                  <a href="<?php echo $seller->shop_url; ?>" target="_blank"><i class="fa fa-flag">&nbsp;</i> Visit Store</a>
                  <?php }else{ ?>
                  <a href="javascript:void(0);" id="viewStore"><i class="fa fa-flag">&nbsp;</i> Visit Store</a>
                  <?php } ?>
                </li>
                <li>
                  <?php if(isset($seller->facebook_url) && $seller->facebook_url!=''){ ?>
                  <a href="<?php echo $seller->facebook_url; ?>" target="_blank"><i class="fa fa-facebook-square">&nbsp;</i> Facebook</a>
                  <?php }else{ ?>
                  <a href="javascript:void(0);"><i class="fa fa-facebook-square">&nbsp;</i> Facebook</a>
                  <?php } ?>
                </li>
              </ul>
            </aside>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="white_box feedback_rate_sec">
          <h4>Feedback Ratings <span>(12 month)</span></h4>
          <ul>
            <li class="row">
              <ul>
                <li class="col-md-2 col-sm-4 positive"><i class="fa fa-thumbs-up">&nbsp;</i> Positive</li>
                <li class="col-md-8 col-sm-5 progress-bar-sec">
                  <div class="progress pull-left">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"> </div>
                  </div>
                  <span class="liker">532</span> </li>
                <li class="col-md-2 col-sm-3 month text-center"><span>12 month</span></li>
                <div class="clearfix"></div>
              </ul>
              <ul>
                <li class="col-md-2 col-sm-4 neutral"><i class="fa fa-smile-o">&nbsp;</i> Neutral</li>
                <li class="col-md-8 col-sm-5 progress-bar-sec">
                  <div class="progress pull-left">
                    <div class="progress-bar progress-bar-2" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;"> </div>
                  </div>
                  <span class="liker">19</span> </li>
                <li class="col-md-2 col-sm-3 month text-center">6 month</li>
                <div class="clearfix"></div>
              </ul>
              <ul>
                <li class="col-md-2 col-sm-4 negative"><i class="fa fa-thumbs-down">&nbsp;</i> Negative</li>
                <li class="col-md-8 col-sm-5 progress-bar-sec">
                  <div class="progress pull-left">
                    <div class="progress-bar progress-bar-3" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;"> </div>
                  </div>
                  <span class="liker">29</span> </li>
                <li class="col-md-2 col-sm-3 month text-center">1 month</li>
                <div class="clearfix"></div>
              </ul>
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>
        <div class="white_box feedback_sec">
          <div class="feedback_tab">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#tab-1" data-toggle="tab">Feedback as a buyer</a> </li>
              <li><a href="#tab-2" data-toggle="tab">Feedback as a seller</a> </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade in active in" id="tab-1">
                <ul class="feedback_list">
                  <li>
                    <div class="feedbacker_name"><i class="fa fa-user">&nbsp;</i> <span>Bikash Bhandari</span></div>
                    <h4><a href="#">Apple iPad Air Wi-Fi+Cellular 32GB</a> <span>05/27/2015</span></h4>
                    <article>Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended.</article>
                  </li>
                  <li>
                    <div class="feedbacker_name"><i class="fa fa-user">&nbsp;</i> <span>Bikash Bhandari</span></div>
                    <h4><a href="#">Apple iPad Air Wi-Fi+Cellular 32GB</a> <span>05/27/2015</span></h4>
                    <article>Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended.</article>
                  </li>
                  <li>
                    <div class="feedbacker_name"><i class="fa fa-user">&nbsp;</i> <span>Bikash Bhandari</span></div>
                    <h4><a href="#">Apple iPad Air Wi-Fi+Cellular 32GB</a> <span>05/27/2015</span></h4>
                    <article>Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended.</article>
                  </li>
                </ul>
              </div>
              <div class="tab-pane fade" id="tab-2">
                <ul class="feedback_list">
                  <li>
                    <div class="feedbacker_name"><i class="fa fa-user">&nbsp;</i> <span>Samantha Pettifer</span></div>
                    <h4><a href="#">Apple iPad Air Wi-Fi+Cellular 32GB</a> <span>05/27/2015</span></h4>
                    <article>Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended.</article>
                  </li>
                  <li>
                    <div class="feedbacker_name"><i class="fa fa-user">&nbsp;</i> <span>Bikash Bhandari</span></div>
                    <h4><a href="#">Apple iPad Air Wi-Fi+Cellular 32GB</a> <span>05/27/2015</span></h4>
                    <article>Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended. Very Good Seller. In-time Delivery.. Perfect Condition.. Recommended.</article>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </aside>
      <h2 class="col-sm-12 upcoming_ttl" id="viewSellersStore">Upcoming Auctions</h2>
      <?php if($upcoming_auction_hosts){foreach($upcoming_auction_hosts as $auction){ ?>
      <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
        <div class="categories cat_bdr border_transparent text-center">
          <h2><a href="<?php echo site_url('/host-auction-detail/'.$auction->host_id.'/'.$this->general->clean_url($auction->host_name)); ?>"><?php echo $this->general->string_limit($auction->host_name,20); ?></a></h2>
          <figure><a href="<?php echo site_url('/host-auction-detail/'.$auction->host_id.'/'.$this->general->clean_url($auction->host_name)); ?>"><img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'live_'.$auction->image); ?>" alt=""></a></figure>
          <div class="row bid_info  clearfix">
            <div class="col-md-5 col-sm-4 text-left"><i class="fa fa-star"></i> 21</div>
            <div class="col-md-7 col-sm-8 text-right">
              <?php if($auction->buy_now==1){?>
              <i class="fa fa-shopping-cart"></i> <?php echo DEFAULT_CURRENCY_SIGN.$auction->buy_now_price; ?>
              <?php }else{ ?>
              <i class="fa fa-clock-o"></i>
              <?php 
						if(date('Y-m-d',strtotime($current_date)) == date('Y-m-d',strtotime($auction->start_date_time))){
							echo $this->general->time_format($auction->start_date_time);
						}else{
							echo $this->general->short_date_time_format($auction->start_date_time);
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
        <div class="text-center">No upcoming auctions found</div>
      </aside>
      <?php } ?>
      <h2 class="col-sm-12 upcoming_ttl" id="viewSellersStore">Sellers Store</h2>
      <?php if($store_products){foreach($store_products as $item){ ?>
      <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
        <div class="categories cat_bdr border_transparent text-center">
          <h2><a href="<?php echo site_url('/buy-product/'.$item->product_id.'/'.$this->general->clean_url($item->name)); ?>"><?php echo $this->general->string_limit($item->name,20); ?></a></h2>
          <figure><a href="<?php echo site_url('/buy-product/'.$item->product_id.'/'.$this->general->clean_url($item->name)); ?>"><img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'live_'.$item->image); ?>" alt=""></a></figure>
          <div class="row bid_info  clearfix">
            <div class="col-md-5 col-sm-4 text-left"><i class="fa fa-star"></i> 21</div>
            <div class="col-md-7 col-sm-8 text-right"> <i class="fa fa-shopping-cart"></i> <?php echo DEFAULT_CURRENCY_SIGN.$item->buy_now_price; ?> </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </aside>
      <?php }}else{ ?>
      <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
        <div class="text-center">No item found in store</div>
      </aside>
      <?php } ?>
    </div>
  </div>
  <div class="clearfix"></div>
</section>
<?php if($this->session->userdata(SESSION.'user_id') && $this->session->userdata(SESSION.'user_id')!=''){  ?>
<div id="sendMessagePopup" class="modal fade" role="dialog">
  <div class="modal-dialog edit-modal"> 
    <!-- Modal content-->
    <form method="post" action="" id="sendMessageForm">
      <input type="hidden" name="sender" value="<?php echo $user_id; ?>" />
      <input type="hidden" name="receiver" value="<?php echo $seller->id; ?>" />
      <div class="modal-content">
        <div class="modal-body">
          <div class="row clearfix"><i class="pull-right" id="charNum">1000 characters</i>
            <textarea name="message" class="form-control contact-seller" placeholder="Enter message" id="messageField"></textarea>
          </div>
          <div class="btn-green form-group clearfix">
            <button type="submit"  class="btn_cat" id="sendMessageBtn">Send</button>
          </div>
          <div class="text-center cancel_txt"><a href="javascript:void(0)" data-dismiss="modal">Cancel</a></div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
	var urlSendMessage = '<?php echo site_url('user/users/ajax_send_message'); ?>';
</script>
<?php } ?>
<script>
$("#viewStore").click(function() {
    $('html,body').animate({scrollTop: $("#viewSellersStore").offset().top},2000);
});
</script>