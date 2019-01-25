<div class="mid_part">
<section class="content_sec upcomimg_auction_sec">
  <div class="container">
    <h2><?php echo $category->name ?></h2>
    <div class="row">
      <?php if($category_auctions){foreach($category_auctions as $auction){ ?>
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
        <div class="text-center">No Auction found</div>
      </aside>
      <?php } ?>
    </div>
  </div>
</section>
</div>
<div class="clearfix"></div>
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
