<section>
<!--start Why Reverse Auction sec -->
<div class="why-rev-auc">
<div class="container">
	<h1>Why Reverse Auction ?</h1>
       <div class="row">
       <div class="col-md-10 col-sm-12">
       <div class="row">
       <?php if($why_reverse_data) { ?>
       <?php foreach($why_reverse_data as $why_reverse) { ?>
        <aside class="col-md-3 col-sm-6 col-xs-6">
        	<div class="box2 text-center">
                <figure><img src="<?php echo site_url().HOW_AND_WHY_IMAGES.$why_reverse->image; ?>" alt="cost-reduction" /></figure>
                <h4><?php echo $why_reverse->title; ?></h4>
                <p><?php echo $why_reverse->description; ?></p>
            </div>
        </aside>
        <?php } }?>
        
       </div>
       </div>
       <div class="col-md-2 col-sm-12"></div>
       <?php $cms = $this->general->get_cms_selected_fields_data(array('10'),array('cms_slug'));
                if($cms)
                {
                  foreach($cms as $data)
                  {
                  ?>                    
                    <a href="<?php echo site_url('/page/'.$data->cms_slug); ?>" class="btn-more">More</a>           
                  <?php
                  }
                } 
      ?>
    	<!-- <a href="#" class="btn-more">More</a> -->
    </div>                         
</div>
	
</div>
<div class="clearfix"></div>
<!--end of Why Reverse Auction sec -->
</section>