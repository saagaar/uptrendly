<section>
<!--start about high tree group sec -->
<div class="abt-hightree">
<div class="container">
<?php if($about_content) { ?>
	<h1>About The High Tree Group<?php //echo $about_content->heading; ?></h1>
	<p><?php echo $this->general->string_limit($about_content->content, 450); ?></p>
<?php }?>
	
       
</div>
	
</div>
<div class="clearfix"></div>
<!--end of about high tree group sec -->
</section>