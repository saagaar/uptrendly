<ul class="list-unstyled product_listing campaigns_list">
  <?php 

                   if(count($campaigns)>=1){

                        foreach($campaigns as $productdata)
                    {   
                        // $engagements='';
                        // $data=''

                                      // $this->load->library('GoogleAnalytics');
                                      $dimensions='ga:hits';
                                      $filters='ga:eventCategory==sponsoritemdetail;ga:eventLabel==detailbutton_'.$productdata['product_id'];
                                      $start_date=$productdata['post_date'];
                                      $date=date_create($start_date);
                                       $start_date=date_format($date,'Y-m-d');
                                       $end_date = date('Y-m-d', strtotime("+6 months", strtotime($start_date)));
                                      $engage=0;
                                      $click=0;
                                      $data=array();
                                      $engagements=array();
                                      // $data=$this->googleanalytics->get_custom_event_data($dimensions,$filters,$start_date,$end_date);
                                  
                                      if((is_object($data))>0)
                                      {
                                         
                                        if(count($data->rows)<1)
                                         {
                                         
                                          $click=0;
                                         }
                                         else
                                         {
                                           $click=($data->rows['0']['0']);
                                         }
                                      } 
                                     
                                    // echo $click;
                                      $dimensions='ga:hits';
                                      $filters2='ga:eventCategory==customlink;ga:eventLabel==customlink_'.$productdata['product_id'];

                                      // $engagements=$this->googleanalytics->get_custom_event_data($dimensions,$filters2,$start_date,$end_date);
                                      if(is_object($engagements)>0)
                                      {
                                        if(count($engagements->rows)>0)
                                         {
                                          $engage=($engagements->rows['0']['0']);
                                         }
                                        else
                                         {
                                          $engage=0;
                                         }
                                      }
                                    
                                      $image=$this->general->get_product_image($productdata['image']);
                                    $submission_deadline=$this->general->date_formate($productdata['submission_deadline']);
              ?>
  <input type="hidden" id="<?php echo $productdata['product_id'];?>_allmedia" value="<?php echo $productdata['media'];?>" >
  <input type="hidden" id="<?php echo $productdata['product_id'];?>_product_url" value="<?php echo $productdata['product_url'];?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_price_range" value="<?php echo DEFAULT_CURRENCY_SIGN.$productdata['price_range'];?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_submission_deadline" value="<?php echo $submission_deadline;?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_description" value="<?php echo $productdata['description'];?>">
  <li>
    <div class="row">
      <div class="col-xs-5 col-sm-3">
        <div class="image"> <span class="btn btn-info price_range"><?php echo DEFAULT_CURRENCY_SIGN.$productdata['price_range'];?></span> <img id="<?php echo $productdata['product_id'];?>_productimg" src="<?php echo  $image;?>"> </div>
      </div>
      <div class="col-xs-7 col-sm-9 fourstep">
        <h4><a href="#" id="<?php echo $productdata['product_id'];?>_product_name"><?php echo $productdata['product_name'];?></a>
          <?php 
                                    $socialmedia=array();
                                    if($productdata['media'])
                                    { 

                                       $socialmedia=explode(',',$productdata['media']);
                                       foreach($socialmedia as $mediaitem)
                                       { 
                                            if($mediaitem=='facebook')
                                            {
                                              ?>
          <span class="pull-right round_btn facebook "> <i class="fa fa-facebook-f"></i> </span>
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
                                            if($mediaitem=='youtulee')
                                          {
                                            ?>
          <span class="pull-right round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
          <?php
                                          }
                                           if($mediaitem=='tumblr')
                                          {
                                            ?>
          <span  class="round_btn  pull-right tumblr"><i class="fa fa-tumblr"></i></span>
          <?php
                                          }
                                              if($mediaitem=='youtube')
                                            {
                                              ?>
          <span class="pull-right round_btn youtube"> <i class="fa fa-youtube"></i> </span>
          <?php
                                     
                                          
                                            }
                                       }
									   
                                     }
									 
                                     $spend=0;
                                     if($productdata['spend']=='')
                                     {
                                      $spend=0;
                                     }
                                     else{
                                      $spend=$productdata['spend'];
                                     }
                                     $ctr=0;$cpe=0;
                                     if($engage!=0)
                                     {
                                        $cpe=$spend/$engage;
                                     }
                                      if($productdata['proposalcount']!=0)
                                      {
                                        $ctr=$click/$productdata['proposalcount'];
                                      }
                                      ?>
        </h4>
        <div class="row">
          <div class="col-xs-6 col-sm-3">
            <h5>PENDING <span><?php echo $productdata['pendingcount'];?></span></h5>
            
            <!--<h5>ENGAGEMENT <span><?php echo $engage;?></span></h5>--> 
          </div>
          <div class="col-xs-6 col-sm-3">
            <h5>In progress<span><?php echo $productdata['productioncount'];?></span></h5>
            <!--<h5>SPEND <span><?php echo $spend;?></span></h5>--> 
          </div>
          <!--  <div class="col-xs-6 col-sm-4 col-md-2">
           <h5>PROPOSALS <span><?php echo $productdata['proposalcount'];?></span></h5>
           <h5>CPE <span><?php echo $cpe;?></span></h5>
         </div> -->
          <div class="col-xs-6 col-sm-3">
            <h5>Request Rejected <span><?php echo $productdata['rejectedcount'];?></span></h5>
            <!--<h5>CLICKS <span><?php echo $click;?></span></h5>--> 
          </div>
          <div class="col-xs-6 col-sm-3">
            <h5>Completed Campaigns<span><?php echo $productdata['completedcount'];?></span></h5>
            <!--<h5>CTR <span><?php echo $ctr ;?></span></h5>--> 
          </div>
        </div>
        <div class="text-uppercase"> <a href="<?php echo site_url('/'.BRAND.'getproposalbyproduct/'.$productdata['product_code']);?>" class="btn  btn-blue"> <i class="fa fa-file-text"></i> View Progress</a> <a href="" data-productid="<?php echo $productdata['product_id'];?>" class="btn btn-primary sponsordetail" id="<?php echo $productdata['product_id'];?>_sponsordetailid"> <i class="fa fa-th-list"></i> Detail</a> <a class="btn btn-sm btn-default pull-right btn-danger deletebtn" href="<?php echo site_url('/'.BRAND.'delete_campaign_post/'.$productdata['product_id'])?>" data-productid="<?php echo $productdata['product_id'];?>" ><i class="fa fa-trash"></i> Delete</a> 
          <!-- <a class="btn btn-sm btn-default pull-right edit_campaign" href="<?php echo site_url('/'.BRAND.'create_campaign/'.$productdata['product_id'])?>" data-productid="<?php echo $productdata['product_id'];?>" ><i class="fa fa-pencil"></i> Edit</a> --> </div>
      </div>
    </div>
  </li>
  <?php 
          }
      }
     else{
            echo '<p><h4 style="color:#337ab7"> No records Found </h4></p>';
         }
                    ?>
</ul>
<!-- Modal -->

<div id="detail_popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
      <div class="row">
        <div class="col-sm-4 text-center pop_left">
          <figure><img id="productimg" src=""></figure>
          <h4 id="product_name"></h4>
          <a href="#" id="edit_campaign_for_detail" class="btn btn-warning edit_campaign" data-action="" data-productid="<?php echo $productdata['product_id'];?>">Edit Campaigns</a> </div>
        <div class="col-sm-8">
          <div class="row text-center three_sec">
            <div class="col-xs-4">
              <h5>CONTENT BUDGET</h5>
              <b>
              <p id="budget"></p>
              </b></div>
            <div class="col-xs-4 channel">
              <h5>CHANNELS</h5>
              <span id="facebookico" class="round_btn mediaicon hidden  facebook"><i class="fa fa-facebook-f"></i></span> <span id="youtulee" class="round_btn mediaicon hidden btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span> <span id="youtubeico" class="round_btn mediaicon hidden youtube"><i class="fa fa-youtube-play"></i></span> <span id="twitterico" class="round_btn mediaicon hidden twitter"><i class="fa fa-twitter"></i></span> <span id="tumblrico" class="round_btn mediaicon hidden tumblr"><i class="fa fa-tumblr"></i></span> <span id="instagramico" class="round_btn mediaicon hidden instagram"><i class="fa fa-instagram"></i></span> </div>
            <div class="col-xs-4">
              <h6>SUBMISSION DEADLINE</h6>
              <b id="submissiondeadline"></b></div>
          </div>
          
          <!-- <h5>VIDEO TYPES: REVIEW,MENTION,HAUL,FAVORITES</h5> -->
          <h5>SITE: <a href="#" id="producturl" ></a></h5>
          <div>
            <p id="description"> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
