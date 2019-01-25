<div class="campaign">
<form>
    <div class="col-sm-3" style="margin:20px 0 0">
         <input type="text" class="form-control name" placeholder="Search ...">
         <button class="btn_txtsearch filteroptname"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-sm-3" style="margin:20px 0 0;">
        
        <div class="input-group date">
          <input type="text" placeholder="Start Date" class="form-control fromdate">
          <span class="input-group-addon "><i class="fa fa-calendar"></i></span>
        </div>      
                     
    </div>       
    <div class="col-sm-3" style="margin:20px 0 0;">

        <div class="input-group date">
          <input type="text" placeholder="End Date" class="form-control todate">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>      
                     
    </div>     
    <div class="col-sm-3" style="margin:20px 0 0;">
        <!-- <input type="text" class="form-control "> -->
        <button class="btn btn_search filteroptname"><i class="fa fa-search"></i>Search</button>  
                     
    </div>         
       <div class="img-loader" style="z-index:1000;display: none">
                <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
       </div>
      <div role="tabpanel" class="col-xs-12 filterview">
        <?php $this->load->view('ajax_report');?>
       </div>
       <div class="clearfix"></div>
       </form>
</div>

    <script>
      var imgurl='<?php echo  site_url(PRODUCT_IMAGE_PATH);?>';
      var searchurl="<?php echo site_url('/'.MY_ACCOUNT.'ajax_report')?>";
    </script>