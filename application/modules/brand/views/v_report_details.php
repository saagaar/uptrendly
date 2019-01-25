<?php 
if(count($reports)>0 && is_array($reports)):

foreach ($reports as $key => $eachreports) {
  $newreports[$eachreports->bid_id][$eachreports->uploaded_media]=array('url'=>$eachreports->link,'likes'=>$eachreports->likes,'share'=>$eachreports->share,'comments'=>$eachreports->comments,'follow'=>$eachreports->follow,'tweet'=>$eachreports->tweet);
}
// echo '<pre>';
// print_r($newreports);
?>

<div class="campaign report_detail">
  <form>
    <div class="rep_filter">
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
        <button class="btn btn_search filteroptname"><i class="fa fa-search"></i>Search</button>  
      </div>   
      <div class="clearfix"></div> 
    </div>

    <div class="img-loader" style="z-index:1000;display: none">
      <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
    </div>

    <div role="tabpanel" class="filterview">
      
      <div class="report_head">
        
          
        <div class="report_product_dtl">
          <h3 class="rep_prod_ttl"><?php echo $product->name;?> <span class="c_type"><?php echo ucfirst($product->campaign_type);?> Campaign</span></h3>
          <p class="rep_dtl">
           <?php echo $product->description;?>
          </p>
          <div class="rep_obj">
            <h4>Objective</h4>
            <ul>
              <?php
              if(count($objective)>0 && is_array(($objective))):
                 foreach($objective as $eachobjective):?>
                <li><?php echo $eachobjective->name;?></li>
              <?php 
                  endforeach;
                else:
                  'No Objective Found';
                endif;
              ?>
            </ul>
          </div>
        </div>

        <ul class="report_img">
          <li>
            <figure>
            <?php 
            $image='';
            if(isset($image['0'])) $image=$images['0']->image;
                 $image1=$this->general->get_product_image($image);
            ?>
              <img src="<?php echo $image1;?>" alt="">
            </figure>
          </li>
          <li>
            <figure>
            <?php 
          if(isset($image['1'])) $image=$images['1']->image;
                 $image2=$this->general->get_product_image($image);
            ?>
              <img src="<?php echo $image2;?>" alt="">
            </figure>
          </li>
          <li>
            <figure>
             <?php 
          if(isset($image['2'])) $image=$images['1']->image;
                 $image3=$this->general->get_product_image($image);
            ?>
              <img src="<?php echo $image3;?>" alt="">
            </figure>
          </li>
          <li>
            <figure>
             <?php 
          if(isset($image['3'])) $image=$images['1']->image;
                 $image4=$this->general->get_product_image($image);
            ?>
              <img src="<?php echo $image4;?>" alt="">
            </figure>
          </li>
        </ul>
        <div class="clearfix"></div>

      </div>

<?php

 foreach($newreports as $bidid=>$eachreports):

?>
      <div class="report_user">
        <ul class="list-unstyled product_listing campaigns_list">
          <li>
            <div class="col-xs-12 col-sm-12">
              <h4>
                <a href="#"><?php 
               $member= $this->general->get_influencer_by_bid($bidid);
               echo $member->name;
                ?></a>
              </h4>
              <?php foreach ($eachreports as $uploadmedia=>$reportfinal) 
                    { 
                    
                    
                      ?>
                          <div class="row m-0">
                              <ul class="report_grid">
                                <li class="width_2">
                                  <label><?php if($uploadmedia=='fb_page') echo 'Facebook Page';else if($uploadmedia=='fb_profile') echo 'Facebook Profile'; else if($uploadmedia=='instagram') echo 'Instagram';?></label>
                                </li>                  
                                <li class="width_4">
                                  <h5><span class="url"><?php echo $reportfinal['url'];?></span></h5>
                                </li>
                                <li class="width_2">
                                  <h5><label>Likes:</label> <span><?php echo $reportfinal['likes'];?></span></h5>
                                </li>
                                <li class="width_2">
                                  <h5><label>Comments:</label> <span><?php echo $reportfinal['comments'];?></span></h5>
                                </li>
                                <li class="width_2">
                                  <h5><label>Share:</label> <span><?php echo $reportfinal['share'];?></span></h5>
                                </li>

                              </ul>
                                         
                            </div>
                             <hr> 
               <?php   } ?>

            
            </div>
          </li>
          <li>
              <a class="btn btn-sm btn-default pull-right " href="<?php echo site_url('/'.BRAND.'download_reports/'.$product_id)?>"  ><i class="fa fa-download"></i> Download Report</a>
          </li>
        </ul>
      </div>
    <?php endforeach;
  else:
  echo 'No Records found';    
endif;

      ?>


    </div>

    <div class="clearfix"></div>
  </form>
</div>

   
