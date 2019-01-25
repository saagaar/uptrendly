<?php 

// echo $active_sponsor;

if(((is_array($active_sponsor)) && (count($active_sponsor)>=1)) || (!isset($view) && trim($view)!='') )
{ 

  ?>
<!-- <div class="mid-part"> -->
<div class="msz_filter_sec">
<div  class="top-filter">
  <!--<div class="col-xs-3">
        <select class="btn btn-default filter status">
          <option value="">All</option>
          <option value="0">Pending Request</option>
          <option value="1">Action Required</option>
          <option value="2">Changes Required</option>
        </select>
  </div>-->
  <div class="col-xs-3">
        <select class="btn btn-default filter status">
          <option value="">All</option>
          <option value="1">Normal / Standard Campaign</option>
          <option value="0">Budget Campaign</option>
          <option value="2">Smart Campaign</option>
        </select>
  </div>
  <div class="col-xs-6 col-sm-4 col-md-3 pull-right text-right">
    <form class="form-inline search">
      <input type="text" class="form-control name" id="campaignname" placeholder="Search By Campaign name">
      <button class="btn filteroptname" type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <div class="clearfix"></div>
</div>
</div>

<!--- <div class="tab-pane panel text-center">
  <div class="col-xs-4">
    <h4>PRODUCTION</h4>
    <p>
      <?php if($productioncount) echo $productioncount;else echo '0';?>
    </p>
  </div>
  <div class="col-xs-4">
    <h4>COMPLETED</h4>
    <p>
      <?php if($completedcount) echo $completedcount;else echo '0';?>
    </p>
  </div>
  <?php if($completedsum) $sum= $completedsum;else $sum= '0';?>
  <div class="col-xs-4">
    <h4>COMPLETED</h4>
    <p><?php echo DEFAULT_CURRENCY_SIGN.' '.$sum;?> </p>
  </div>
  <div class="clearfix"></div>
</div> --->


<h4 class="creator_p_info_title">ACTIVE SPONSORSHIPS</h4>
<div class="filterview">
  <?php 

    $this->load->view('ajax_brand');  
 ?>
</div>
<?php
}
else 
{ 
  ?>
<div class="mid-part">
  <div class="row">
    <div class="col-xs-6 col-sm-2 text-center">
      <h1 class="fa fa-edit"></h1>
    </div>
    <div class="col-xs-6 col-sm-10">
      <h3>Create Campaign</h3>
      <p>Simply click Create Campaign, choose the social media channels you’d like your brand promoted on and post your campaign. It’s completely FREE to receive proposals from creators interested in endorsing your brand.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-sm-2 text-center">
      <h1 class="fa fa-envelope-o"></h1>
    </div>
    <div class="col-xs-6 col-sm-10">
      <h3>Receive Proposals</h3>
      <p>Creators will start sending you proposals almost immediately. We include creator stats and demographics along with each proposal ensuring you have all the info you need to make the right hire.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-sm-2 text-center">
      <h1 class="fa fa-hand-spock-o"></h1>
    </div>
    <div class="col-xs-6 col-sm-10">
      <h3>Hire Creators</h3>
      <p>The fun part! Simply click hire to start working with creators. Funds are held in escrow and only released once you’ve approved your content.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-sm-2 text-center">
      <h1 class="fa fa-bullhorn"></h1>
    </div>
    <div class="col-xs-6 col-sm-10">
      <h3>Drive Engagement &amp; ROI</h3>
      <p>Once you have approved your content, creators will share it with their audience driving views and engagement while growing your customers organically.</p>
    </div>
  </div>
  <div class="text-center listing_sec">
    <h4>Creating a campaign is super easy! Only takes 60 seconds.</h4>
    <!-- <a href="#" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModal">Create Campaign</a> --> 
  </div>
</div>
<?php 
}
?>
<script type="text/javascript">
  
  var searchurl='<?php echo site_url('/'.MY_ACCOUNT.'ajax_dashboard/');?>';
</script>