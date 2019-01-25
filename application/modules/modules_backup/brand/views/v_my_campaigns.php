<div class="mid-part margin_0">

    <div class="col-sm-3">
        <select class="form-control filter proposaltype">      
            <option value="all">All</option>
            <option value="open">Open</a></option>
            <option value="draft">Draft</option>
            <option value="closed">Closed</option>
        </select>  
          
    </div>                    
       <div class="img-loader" style="z-index:1000;display: none">
                <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
       </div>
      <div role="tabpanel" class="col-xs-12 filterview">
        <?php $this->load->view('brand/ajax_campaign');?>
       </div>
</div>

    <script>
      var imgurl='<?php echo  site_url(PRODUCT_IMAGE_PATH);?>';
      var searchurl="<?php echo site_url('/'.BRAND.'ajax_campaigns')?>";
    </script>