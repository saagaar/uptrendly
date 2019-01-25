<?php 
// echo '<pre>';
// print_r($active_sponsor);
if(((is_array($active_sponsor)) && (count($active_sponsor)>=1)) || (!isset($view) && trim($view)!='') )
{
?>

<div class="msz_filter_sec">
<div  class="top-filter">
  <div class="col-xs-6">
        <select class="btn btn-default filteropt status">
          <option value="">All</option>
          <option value="0">Proposal Sent</option>
          <option value="1">Action Required</option>
          <option value="2">Changes Required</option>
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
<!--<div class="tab-pane panel text-center">
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
</div>-->
<div class="msz_filter_sec">
<h4 class="creator_p_info_title">ACTIVE SPONSORSHIPS</h4>
<div class="filterview">
  <?php 

    $this->load->view('ajax_creator');  
 ?>
</div>
<?php 
}
else 
{ 
?>
<div class="msz_filter_sec"> 
  <!--  <div class="col-xs-6"><ul class="list-unstyled">
                 <li>
                 <select class="btn btn-default"><option selected>All</option><option>Read</option><option>Unread</option></select></li>
            <li><a href="#" class="btn btn-default"><i class="fa fa-refresh"></i></a></li>
          </ul>
    
    </div> -->
  <div class="col-xs-6 col-sm-4 col-md-3 pull-right text-right">
    <form class="form-inline search">
      <input type="text" class="form-control" id="exampleInputName2" placeholder="Search">
      <button class="btn" type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <div class="clearfix"></div>
</div>
<div class="tab-pane panel text-center">
  <div class="col-xs-4">
    <h4>PRODUCTION</h4>
    <p>
      <?php if($productioncount!='') echo $productioncount;else echo '0';?>
    </p>
  </div>
  <div class="col-xs-4">
    <h4>COMPLETED</h4>
    <p>
      <?php if($completedcount!='') echo $completedcount==0;else echo '0';?>
    </p>
  </div>
  <?php if($completedsum) $sum= $completedsum;else $sum= '0';?>
  <div class="col-xs-4">
    <h4>COMPLETED</h4>
    <p><?php echo DEFAULT_CURRENCY_SIGN.' '.$sum;?> </p>
  </div>
  <div class="clearfix"></div>
</div>
<div class="text-center" style="margin-top:60px;">
  <h1 class="fa fa-eye-slash"></h1>
  <h2>No Actions Required</h2>
  <p><?php echo PROPOSAL_DEFAULT_TEXT;?></p>
</div>
<?php
}?>
<script>
  
  var reportuser='<?php echo site_url('/'.MY_ACCOUNT.'reportuser');?>'  
  var action='<?php echo site_url('/'.MY_ACCOUNT.'ajax_dashboard/');?>';

</script> 
