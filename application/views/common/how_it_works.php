<section>
<!--start of 4 step sec -->
<div class="how-work">
<div class="container">
  <h1>How It Works</h1>
    <div class="row">

    <?php if($how_it_works_data) { $count = 1; ?>
      
    <?php foreach($how_it_works_data as $how_it_works) { ?>
      <aside class="col-md-3 col-sm-6 col-xs-6">
          <div class="box text-center">
              <div class="number"><?php echo $count++; ?></div>
                <figure><img src="<?php echo site_url().HOW_AND_WHY_IMAGES. $how_it_works->image; ?>" alt="sign in icon" /></figure>
                <h4><?php echo $how_it_works->title; ?></h4>
                <p><?php echo $how_it_works->description; ?></p>
            </div>
        </aside>
        <?php } } ?>        
    </div>
</div>
  
</div>
<div class="clearfix"></div>
<!--end of 4 step sec -->
</section>