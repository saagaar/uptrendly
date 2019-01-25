<section>
<!--start of banner -->
<div class="banner-sec">
      <div class="container text-center">
      <?php 
        if($banner_text)  
        {
          echo $banner_text->content;
        } 
    if(!($this->session->userdata(SESSION.'user_id')))
    {
        ?>
      <div class="banner-btn-sec">
        <a href="<?php echo site_url('/user/register/buyer'); ?>" class="buyer-btn">Buyer Register</a> 
        <a href="<?php echo site_url('/user/register/supplier'); ?>" class="supplier-btn">Supplier Register</a>
      </div>
    <?php 
    }
    ?> 
      </div>
      <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<!--end of banner -->
</section>