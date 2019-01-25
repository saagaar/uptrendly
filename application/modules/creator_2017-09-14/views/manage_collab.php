
<ul class="list-unstyled product_listing campaigns_list">
  <?php if(count($my_collabs)>0){?>
  <?php foreach($my_collabs as $datacollab){
            $image=$this->general->get_profile_image(trim($datacollab['cover_image']));
            ?>
  <li>
    <div class="row">
      <input type="hidden" id="<?php echo $datacollab['product_id'];?>_product_name" value="<?php echo $datacollab['product_name'];?>">
      <input type="hidden" id="<?php echo $datacollab['product_id'];?>_allmedia" value="<?php echo $datacollab['media'];?>" >
      <!--  <input type="hidden" id="<?php echo $datacollab['product_id'];?>_product_url" value="<?php echo $datacollab['product_url'];?>">-->
      <input type="hidden"  id="<?php echo $datacollab['product_id'];?>_fan_count" value="<?php echo $datacollab['least_fan_count'];?>">
      <input type="hidden"  id="<?php echo $datacollab['product_id'];?>_submission_deadline" value="<?php echo $datacollab['submission_deadline'];?>">
      <div class="col-xs-5 col-lg-3 col-md-4 col-sm-5">
        <div class="image"> <img id="<?php echo $datacollab['product_id'];?>_productimg" src="<?php echo $image;?>"> </div>
      </div>
      <div class="col-xs-7 col-lg-9 col-md-8 col-sm-7">
        <h4> <a href="#"><?php echo $datacollab['product_name']?></a>
          <?php 
                      if($datacollab['media'])
                        { 
                         
                           $socialmedia=explode(',',$datacollab['media']);

                          
                           foreach($socialmedia as $mediaitem)
                           { 
                               if($mediaitem=='facebook')
                                {
                                  ?>
          <span class="pull-right round_btn facebook"> <i class="fa fa-facebook-f"></i> </span>
          <?php
                                }
                                 if($mediaitem=='twitter')
                                {
                                  ?>
          <span class="pull-right round_btn twitter"> <i class="fa fa-twitter-square"></i> </span>
          <?php
                                }
                                  if($mediaitem=='instagram')
                                {
                                  ?>
          <span class="pull-right round_btn instagram"> <i class="fa fa-instagram"></i> </span>
          <?php
                                }
                                  if($mediaitem=='youtube')
                                {
                                  ?>
          <span class="pull-right round_btn youtube"> <i class="fa fa-youtube"></i> </span>
          <?php
                                }
                                 if($mediaitem=='youtulee')
                                {
                                  ?>
          <span class="pull-right round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
          <?php
                                }
                                if($mediaitem=='tumblr')
                                {
                                  ?>
          <span class="pull-right round_btn tumblr"><i class="fa fa-tumblr"></i></span>
          <?php }
                           }
                          ?>
          <input id="<?php echo $datacollab['product_id'];?>_socialmediaid" type="hidden" name="proposalformedia" data-media="<?php echo $socialmedia[0];?>" value="<?php echo constant(strtoupper($socialmedia[0]).'MEDIAID');?>">
          <?php 
                        }
                       
                        ?>
        </h4>
        <p id="<?php echo $datacollab['product_id'];?>_description"> <?php echo $datacollab['description'];
                      ?> </p>
        <div class="row">
          <div class="col-xs-4">
            <h5>Proposal Count <span><?php echo $datacollab['proposalcount']?></span></h5>
          </div>
          <div class="col-xs-4">
            <h5>Collab Count <span><?php echo $datacollab['collabscount']?></span></h5>
          </div>
          <div class="col-xs-4">
            <h5>Production Count <span><?php echo $datacollab['completedcount']?></span></h5>
          </div>
        </div>
        <div class="text-uppercase"> <a href="<?php echo site_url('/'.CREATOR.'getproposalbyproduct/'.$datacollab['product_code']);?>"   class="btn btn-sm btn-primary" ><i class="fa fa-file-text"></i> View Proposals</a> <a href="" data-productid="<?php echo $datacollab['product_id'];?>" class="btn btn-sm btn-success" id="collabdetail"><i class="fa fa-align-justify"></i> Details</a> <a class="btn btn-sm btn-default pull-right editbutton" data-action="<?php echo site_url(''.MY_ACCOUNT.'getproductbyid/')?>" productid="<?php echo $datacollab['product_id']?>"><i class="fa fa-pencil"></i> Edit</a> </div>
      </div>
    </div>
  </li>
  <?php   } ?>
  <?php 
      }
      else {

        echo '<li>No records found</li>';
      }
        ?>
</ul>
