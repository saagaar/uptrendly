<!-- Home Section -->
<section id="home" class="text-center">
  <div class="section " id="section0">
    <div class="container">
      <div class="social_sec">
      <a>
  <?php if(defined('FACEBOOKMEDIAID')):?>
      <i class="fa fa-facebook"></i></a>
    <?php endif;?>
    <?php if(defined('INSTAGRAMMEDIAID')):?>
       <a><i class="fa fa-instagram"></i></a> 
      <?php endif;?> 
     <?php if(defined('TWITTERMEDIAID')):?>
       <a href="#"><i class="fa fa-twitter"></i></a> 
        <?php endif;?>
     <?php if(defined('YOUTUBEMEDIAID')):?>
       <a href="#"><i class="fa fa-youtube-play"></i></a>
         <?php endif;?> 
        <div class="clearfix"></div>
      </div>
      <h1 class="f-black fc-white fs-40 mt-40"><span class="f-light block-ele fs-35">Nepal's own Influencer Marketing Platform<br>
        </span> <!-- For Organic Branded Content --> </h1>
      <div class="btns mt-40">
      <a href="<?php echo site_url('user/register/creator');?>" class="btn btn-blue text-uppercase f-bold">I am an Influencer</a>
      <a href="<?php echo site_url('user/register/brand');?>" class="btn btn-blue text-uppercase f-bold ml-15">I am an Advertiser</a>
      </div>
    </div>
  </div>
</section>

<!-- Demo Section -->
<section id="demo" class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="fc-white fs-40 f-black">New to Influencer Marketing?</h1>
        <p class="fc-white fs-20 f-book">Uptrendly is easy to use; Here is how: </p>
        <div class="btns mt-20"><a href="<?php echo site_url('/cms/demo');?>" class="btn btn-blue text-uppercase f-bold">Click here for a demo</a></div>
      </div>
    </div>
  </div> 
</section>

<!-- Influencer Section -->
<section id="influencer" class="">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="fc-white fs-40 f-black">Got followers on Social Media?</h1>
        <p class="fc-white fs-20 f-book"> Are your posts usually flooded with likes? <br>
          Here is your opportunity to generate financial returns <br>
          just by posting pictures with your Favorite Brand</p>
        <div class="btns mt-20"><a href="<?php echo site_url('/cms/creator');?>" class="btn btn-white text-uppercase f-bold">View Detail</a></div>
      </div>
    </div>
  </div>
</section>

<!-- Brand(Advertiser) Section -->
<section id="brand" class="text-right">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="fc-white fs-40 f-black">Connect and Engage your <br>Target Audience.</h1>
        <p class="fc-white f-book fs-20">
         With subtle but effective posts<br>
         from Nepal’s top influencer,<br>
         Improve Brand Recognition<br> Boost Sales.
        </p>          	
        <div class="btns mt-20"><a href="<?php echo site_url('/cms/brand');?>" class="btn btn-white text-uppercase f-bold">View Detail</a></div>
      </div>
    </div>
  </div>
</section>
<style>
.home-form{ margin:4.8vw 0 2vw;}
.home-form .form-control{ border:none; background:#FFF;}
</style>
<!-- Contact Section -->
<section id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="f-black mb-0 fc-white">Introduce Impress Influence</h1>
        <h2 class="f-book mt-10 fc-white">Smart people believe in recommendation rather than advertisement.</h2>
        <form class="home-form">
        <h2 class="f-book mt-10 fc-white mb-20">Send us your feedback</h2>
    	<div class="row text-left fc-white">
        	<div class="col-sm-4 mb-20"><input type="text" class="form-control" placeholder="Full Name"></div>
        	<div class="col-sm-4 mb-20"><input type="text" class="form-control" placeholder="Email Address"></div>
        	<div class="col-sm-4 mb-20"><input type="text" class="form-control" placeholder="Contact Number"></div>
        	<div class="col-sm-8"><textarea class="form-control" rows="3" placeholder="Your Message...."></textarea></div>
        	<div class="col-sm-4 text-right"><button type="submit" class="btn btn-blue btn-block mt-20 text-uppercase f-bold">Send message</button></div>
            <div class="clearfix"></div>
        </div>
	    </form>        
      </div>
    </div>
  </div>
</section>
<footer>
  <div class="container mb-40">
    <div class="row mt-40">
      <div class="col-sm-5 pull-right ms_sec">
        <figure class="pull-left mr-25"><img src="<?php echo base_url().USER_IMG_DIR; ?>ms-logo.png" alt="ms-logo"></figure>
        <p>Thapathali, Kathmandu Nepal, <br> POB No. 24445 </p>
        <p><span><i class="fa fa-phone"></i> 01-5135008</span></p>
        <p><i class="fa fa-envelope-o"></i> <a href="#"> advertiser@uptrendly.com</a></span></p>
      </div>
      <div class="col-sm-7">
        <h4 class="mt-0 mb-40"><span class="block-ele f-black mt-10">Get Started Now !!</span></h4>
        <div class="btns mt-20">
        <a href="<?php echo site_url('user/register/creator');?>" class="btn btn-white text-uppercase f-bold">I am an Influencer</a>
        <a href="<?php echo site_url('user/register/brand');?>" class="btn btn-white text-uppercase f-bold ml-15">I am an Advertiser</a>
        </div>
      </div>
    </div>
  </div>
