<?php 
if(count($reports)>0):
foreach ($reports as $key => $eachreports) {
  $newreports[$eachreports->bid_id][$eachreports->uploaded_media]=array('url'=>$eachreports->link,'likes'=>$eachreports->likes,'share'=>$eachreports->share,'comments'=>$eachreports->comments,'follow'=>$eachreports->follow,'tweet'=>$eachreports->tweet);
}

?>
<style>
  .rep_prod_ttl { border-bottom:1px solid #EDEDED;padding-bottom:10px; color:#848484; }
  .rep_prod_ttl span.c_type { font-weight:normal; font-size:13px; padding:10px; background-color:orange; color:#fff; display:inline-block; border-radius: 100px; margin-left:10px; }
  .report_detail_pdf .rep_dtl { color:#909090; }
  .report_detail_pdf .rep_obj { color:#848484; }
  .report_detail_pdf .rep_obj ul { list-style:none; padding-left:0; background-color:#f3f3f3; width:50%;}
  .report_detail_pdf .rep_obj ul li { padding:5px 10px 3px; border-bottom:1px solid #fff; color:#333; font-weight:normal; }
  .report_detail_pdf .report_img { list-style:none; padding:20px; text-align: center; background-color: #62B6BF; }
  .report_detail_pdf .report_img td { padding:5px; border:1px solid #ddd; background-color:#9FD3D8; }
  

</style>

<div class="campaign report_detail_pdf">
    <div role="tabpanel" class="filterview">
      
      <div class="report_head">
                
        <div class="report_product_dtl">
          <h3 class="rep_prod_ttl"><?php echo $product->name;?> <span class="c_type">&nbsp;&nbsp;<?php echo ucfirst($product->campaign_type);?> Campaign&nbsp;&nbsp;</span></h3>
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

        <table class="report_img">
          <tr>
            
            <td>
              <figure>
              <?php 
              $image='';
              if(isset($image['0'])) $image=$images['0']->image;
                   $image1=$this->general->get_product_image($image);
              ?>
                <img src="<?php echo $image1;?>" alt="">
              </figure>
            </td>
            <td>
              <figure>
              <?php 
            if(isset($image['1'])) $image=$images['1']->image;
                   $image2=$this->general->get_product_image($image);
              ?>
                <img src="<?php echo $image2;?>" alt="">
              </figure>
            </td>
            <td>
              <figure>
               <?php 
            if(isset($image['2'])) $image=$images['1']->image;
                   $image3=$this->general->get_product_image($image);
              ?>
                <img src="<?php echo $image3;?>" alt="">
              </figure>
            </td>
            <td>
              <figure>
               <?php 
            if(isset($image['3'])) $image=$images['1']->image;
                   $image4=$this->general->get_product_image($image);
              ?>
                <img src="<?php echo $image4;?>" alt="">
              </figure>
            </td>
          </tr>
        </table>
        <div class="clearfix"></div>

      </div>


<style>
  .report_user { padding:10px; }
  .report_user .ru_ul { list-style:none; padding:10px; background-color:#f9f9f9; box-shadow:0px 1px 3px 2px #eee; }
  .report_user .ru_ul h4 { margin-top:0; margin-bottom:5px; border-bottom:1px solid #d2d2d2; padding-bottom:5px; color:#238893; }
  .report_grid { font-size:12px; width:100%; }
  .report_grid { border-bottom:1px solid #ddd; }
  .report_grid td { font-weight:normal; padding:5px;}
  .report_grid td.url { border-bottom:1px solid #ddd; }
  
</style>

<?php
 foreach($newreports as $bidid=>$eachreports):
?>

      <div class="report_user">
        <ul class="ru_ul">
          <li>
            <div class="col-xs-12 col-sm-12">
              <h4>
                <?php 
               $member= $this->general->get_influencer_by_bid($bidid);
               echo $member->name;
                ?>
              </h4>
              <?php foreach ($eachreports as $uploadmedia=>$reportfinal) 
                    { 
                    
                    
                      ?>
                          <div class="row m-0">
                              <table class="report_grid">
                                <tr>
                                  <td width="15%" rowspan="2">
                                    <label><?php if($uploadmedia=='fb_page') echo 'Facebook Page';else if($uploadmedia=='fb_profile') echo 'Facebook Profile'; else if($uploadmedia=='instagram') echo 'Instagram';?></label>
                                  </td>  
                                  <td colspan="3" class="url">
                                    <h5><span class="url">URL: <?php echo $reportfinal['url'];?></span></h5>
                                  </td>
                                </tr>                
                                <tr>
                                  
                                  <td>
                                    <h5><label>Likes:</label> <span><?php echo $reportfinal['likes'];?></span></h5>
                                  </td>
                                  <td>
                                    <h5><label>Comments:</label> <span><?php echo $reportfinal['comments'];?></span></h5>
                                  </td>
                                  <td>
                                    <h5><label>Share:</label> <span><?php echo $reportfinal['share'];?></span></h5>
                                  </td>
                                </tr>
                              </table>
                                         
                            </div>
               <?php   } ?>                
              
            </div>
          </li>
          <li></li>
        </ul>
      </div>
    <?php endforeach;
    else:
      echo 'No Records Found';
    endif;
    ?>
    </div>

    <div class="clearfix"></div>
</div>

   
