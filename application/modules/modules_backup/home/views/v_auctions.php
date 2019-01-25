<?php //script for nodejs and socket.io ?>
<?php if($live_auction_host){ ?>
<script src="http://<?php echo NODE_SERVER.':'.NODE_PORT; ?>/socket.io/socket.io.js"></script>
<script>
    var connectSocket = function(aid){
		return function(){
			console.log('connected to nodejs server');
			socket.emit('auction_room',{'aid':aid});
		}	
	}
</script>
<?php  } ?>

<div class="mid_part">
  <section class="market_auction_sec">
    <div class="container">
      <h2>Live Marketplace Auctions</h2>
      <div class="row">
        <?php if($live_auction_host){foreach($live_auction_host as $auction){ ?>
        <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive" id="auctionArea_<?php echo $auction->host_id; ?>">
          <div class="categories text-center" id="auctionDiv_<?php echo $auction->host_id; ?>">
          	<h2><?php echo $this->general->string_limit($auction->product_name,20);?></h2>
            <p>Upcoming Items : <span id="remainingItems_<?php echo $auction->host_id; ?>"><?php echo ($auction->product_count - 1); ?></span></p>
            <figure><img src="<?php echo site_url(PRODUCT_IMAGE_PATH.'live_'.$auction_image[$auction->product_id]); ?>" alt=""></figure>
            <div class="row bid_info clearfix">
              <div class="col-md-4 col-sm-3"><i class="fa fa-gavel"></i> <span id="totalBids_<?php echo $auction->product_id; ?>"><?php if(isset($bids_count) && isset($bids_count[$auction->product_id])){echo $bids_count[$auction->product_id]; }else{ echo 0;} ?></span></div>
              <div class="col-md-4 col-sm-4"><i class="fa fa-users"></i> <span id="totalUsers_<?php echo $auction->host_id; ?>">0</span></div>
              <?php if($auction->retail_price!=0){ ?>
              <div class="col-md-4 col-sm-5"><i class="fa fa-tags"></i> <span id="priceDiscount_<?php echo $auction->product_id; ?>"><?php echo ($auction->retail_price >= $auction->auc_current_price)? number_format($this->general->calculate_percentage($auction->retail_price,$auction->auc_current_price)):0; ?></span>% off</div>
              <?php } ?>
            </div>
            
            <h3>CURRENT BID <?php echo DEFAULT_CURRENCY_SIGN; ?> <span id="bidAmt_<?php echo $auction->product_id; ?>"><?php echo $auction->auc_current_price; ?></span></h3>
            <div class="btn-area"> <a href="<?php echo site_url('live-auction/'.$auction->host_id.'/'.$this->general->clean_url($auction->host_name)); ?>" class="btn_cat">Enter Auction</a> </div>
          </div>
        </aside>
        
        <script>
			var socket = io.connect('http://<?php echo NODE_SERVER.':'.NODE_PORT; ?>/bidding_process');
			socket.on('connect',connectSocket('<?php echo $auction->host_id; ?>'));
        </script>
        
        <?php } }else{ ?>
        <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
          <div class="text-center">No Live Auction found</div>
        </aside>
        <?php } ?>
        <div class="clearfix"></div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
  <section class="content_sec upcomimg_auction_sec">
    <div class="container">
      <h2>Upcoming Auctions</h2>
      <div class="row">
        <?php if($upcoming_auction_hosts){foreach($upcoming_auction_hosts as $auction){ ?>
        <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
          <div class="categories cat_bdr text-center">
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
          <!-- /.categories --> 
        </aside>
        <?php } }else{ ?>
        <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
          <div class="text-center">No Upcoming Auction found</div>
        </aside>
        <?php } ?>
      </div>
      <h2>Browse by Categories</h2>
      <div class="row">
        <?php if($categories_auctions){foreach($categories_auctions as $category){ ?>
        <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
          <div class="categories cat_bdr text-center">
            <h2><a href="<?php echo site_url('category/'.$category->cat_id.'/'.$this->general->clean_url($category->cat_name)); ?>"><?php echo $category->cat_name; ?></a></h2>
            <figure><img src="<?php echo PRODUCT_IMAGE_PATH.'live_'.$auction_images[$category->product_id][0]; ?>" alt="" id="bigImg<?php echo $category->cat_id; ?>"></figure>
            <div class="thumb-sec clearfix">
              <?php
				$i=1;
            	if($auction_images[$category->product_id]){ 
					foreach($auction_images[$category->product_id] as $image){
						if($i<=3){
						?>
              			<div class="thumbs <?php echo ($i==1)?'active':''; ?>" data-link='<?php echo PRODUCT_IMAGE_PATH.'live_'.$image; ?>' data-cat='<?php echo $category->cat_id; ?>'><a href="javascript:void(0)"><img src="<?php echo PRODUCT_IMAGE_PATH.'thumb_'.$image; ?>" alt=""></a> </div>
              			<?php
                		$i++;
						}
					}
				}
			?>
            </div>
            <div class="btn-area"> <a href="<?php echo site_url('category/'.$category->cat_id.'/'.$this->general->clean_url($category->cat_name)); ?>" class="btn_cat">View this Category</a> </div>
          </div>
        </aside>
        <?php }}else{ ?>
        <aside class="col-md-4 col-sm-6 col-xs-6 cat-responsive">
          <div class="text-center">No Auction found</div>
        </aside>
        <?php } ?>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
</div>

<?php if($live_auction_host){ ?>
<script>
	//define some variables
	var productImageDir = '<?php echo site_url(PRODUCT_IMAGE_PATH); ?>';
	
	//initially insert users count in each host auction
	socket.on('push_connected_users_initially',function(data){
		console.log(data);
		$.each(data.connected_users, function(key,val){
			$('#totalUsers_'+key).html(val);
		});
	});
	
	//only when any user enters the room
	socket.on('user_connected_response',function(data){
		console.log(data);
		$('#totalUsers_'+data.aid).html(data.totalUsers);
	});
	
	
	socket.on('bidding_success',function(data){
		//console.log('hello');
		if(data.auc_current_price!='' && data.auc_current_price!='undefined' ){
			$('#bidAmt_' + data.pid).html(data.auc_current_price);
			
			$('#totalBids_' + data.pid).html(data.total_bids_placed);
			
			//console.log(data.price_discount_percent_new + ' # ' + new_discount);
			$('#priceDiscount_' + data.pid).html((data.price_discount_percent_new >0 )? data.price_discount_percent_new:0);
			
			//Effect to the div containing new price
			$('#auctionDiv_' + data.aid +' h3').velocity({scaleX: "1.1", scaleY: "1.1",}, {loop: 1, delay: 50});
			//loop is for number of times the effect isto bedisplayed and delay is for the delay between two successive effects
		}
		//console.log('Response : '+data.message);
	});
		
		
	socket.on('auction_item_finished',function(data){
		console.log(data);
		//$('#bidAmt_' + data.aid).html(data.auc_current_price);
		$('#auctionDiv_' + data.aid +' h3').html('Auction Closed at '+currencySign+data.product_won_amount)
		$('#auctionDiv_' + data.aid +' h3').velocity({scaleX: "1.1", scaleY: "1.1",}, {loop: 3, delay: 100});
		
		setTimeout(function(){
			$('#auctionArea_' + data.aid).hide('slow', function(){ this.remove(); });
		}, 4000);
	});
		
		
	socket.on('auction_closed',function(data){
		$('#auctionDiv_' + data.aid +' h3').html('Sold');
	});
		

	socket.on('new_item_coming_sonn',function(data){
		$('#auctionDiv_' + data.aid +' h3').html('Upcoming');
	});
	
		
	socket.on('display_new_auction_product',function(data){
		console.log(data);
		//Now change name
		var discount_section = (data.price_discount_percent > 0)?'<div class="col-md-4 col-sm-5"><i class="fa fa-tags"></i> <span id="priceDiscount_' + data.pid + '">' + data.price_discount_percent + '</span>% off</div>':'';
		
		var auc_template = '';
		auc_template +='<h2>' + data.product_data.product_name.substring(0,20) + '</h2><p>Upcoming Items : <span id="remainingItems_' + data.aid + '">' + data.remaining_items + '</span></p><figure><img src="' + productImageDir + '/live_' + data.product_img_data[0] + '" alt=""></figure><div class="row bid_info  clearfix"><div class="col-md-4 col-sm-3"><i class="fa fa-gavel"></i> <span id="totalBids_' + data.product_data.product_id + '">' + data.total_bids + '</span></div><div class="col-md-4 col-sm-4"><i class="fa fa-users"></i> <span id="totalUsers_' + data.aid + '">' + data.total_users + '</span></div>' + discount_section + '</div><h3>CURRENT BID ' + currencySign + ' <span id="bidAmt_' + data.product_data.product_id + '">' + data.product_data.auc_current_price + '</span></h3><div class="btn-area"><a href="' + site_url +  'live-auction/' + data.aid +'/' + data.product_data.host_name.toLowerCase().replace(/[^a-z0-9]+/g,'-') + '" class="btn_cat">Enter Auction</a></div>';
	
		$('#auctionDiv_' + data.aid).html(auc_template);
		//$('#auctionDiv_' + data.aid).load(document.URL +  ' #auctionDiv_' + data.aid);
	});	
</script>
<?php } ?>

<script>
	$('.thumbs').hover(function(){
		var bidImg = $(this).data('link');
		var cat = $(this).data('cat');
		//console.log($(this).data('link'));
		$('#bigImg' + cat).attr('src',bidImg);
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	});
</script> 
