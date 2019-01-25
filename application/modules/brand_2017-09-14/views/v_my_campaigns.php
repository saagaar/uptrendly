<div class="campaign">
    <div class="col-sm-3" style="margin:20px 0 0;">
        <select class="form-control filter proposaltype">      
            <option value="all">All</option>
            <option value="closed">Completed</option>
            <option value="open">In progress</option>
            <option value="draft">Draft</option>
        </select>            
    </div>                    
       <div class="img-loader" style="z-index:1000;display: none">
                <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
       </div>
      <div role="tabpanel" class="col-xs-12 filterview">
        <?php $this->load->view('ajax_campaign');?>
       </div>
       <div class="clearfix"></div>
</div>

    <script>
      var imgurl='<?php echo  site_url(PRODUCT_IMAGE_PATH);?>';
      var searchurl="<?php echo site_url('/'.BRAND.'ajax_campaigns')?>";
    </script>