<ul class="list-unstyled product_listing campaigns_list">asdad
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
  <!-- <input type="hidden"  id="<?php echo $productdata['product_id'];?>_price_range" value="<?php echo DEFAULT_CURRENCY_SIGN.$productdata['price_range'];?>"> -->
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_submission_deadline" value="<?php echo $submission_deadline;?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_description" value="<?php echo $productdata['description'];?>">
  
  <li>
    <div class="row">
      <div class="col-xs-5 col-sm-3">
        <div class="image"> 
          <!-- <span class="btn btn-info price_range"><?php echo DEFAULT_CURRENCY_SIGN.$productdata['price_range'];?></span>  -->
          <img id="<?php echo $productdata['product_id'];?>_productimg" src="<?php echo $image;?>">
        </div>
      </div>

      <div class="col-xs-7 col-sm-9">
        <h4><a href="#" id="<?php echo $productdata['product_id'];?>_product_name"><?php echo $productdata['campaign_name'];?></a>
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
          <div class="col-xs-6 col-sm-4 col-md-3">
            <h5>Product Name<span><?php echo $productdata['product_name'];?></span></h5>
            <h5>Deadline <span><?php echo date('Y-m-d',strtotime($productdata['submission_deadline'])) ;?></span></h5>

          </div>
          <div class="col-xs-6 col-sm-4 col-md-3">
            <h5>URL <span><?php echo $productdata['product_url'];?></span></h5>
            <h5>Category <span><?php echo $productdata['category_name'];?></span></h5>
          </div>
          <!-- <div class="col-xs-6 col-sm-4 col-md-3">
            <h5>PRODUCTION <span><?php echo $productdata['productioncount'];?></span></h5>
            <h5>CPE <span><?php echo $cpe;?></span></h5>
          </div>
          <div class="col-xs-6 col-sm-4 col-md-3">
            <h5>Rejected <span><?php echo $productdata['rejectedcount'];?></span></h5>
            <h5>CLICKS <span><?php echo $click;?></span></h5>
          </div> -->
         <!--  <div class="col-xs-6 col-sm-4 col-md-2">
            <h5>COMPLETED <span><?php echo $productdata['completedcount'];?></span></h5>
            <h5>CTR <span><?php echo $ctr ;?></span></h5>
          </div> -->
        </div>
        <div class="text-uppercase">  
       <!--  <a href="<?php echo site_url('/'.BRAND.'getproposalbyproduct/'.$productdata['product_code']);?>" class="btn  btn-blue">
        <i class="fa fa-file-text"></i> View Proposals</a> -->
        <a href=""  data-productid="<?php echo $productdata['product_id'];?>" class="pull-right btn btn-primary sponsordetail" id="<?php echo $productdata['product_id'];?>_sponsordetailid">
        <i class="fa fa-th-list"></i> Detail</a>
       <!--  <a class="btn btn-sm btn-default pull-right edit_campaign" href="<?php echo site_url('/'.BRAND.'create_campaign/'.$productdata['product_id'])?>" data-productid="<?php echo $productdata['product_id'];?>" ><i class="fa fa-pencil"></i> Edit</a> --> 
        <?php if($productdata['bid_status']=='0'):?>
            <a class="btn btn-sm btn-success setstatus" data-bidid="<?php echo $productdata['bid_id'];?>" data-productid="<?php echo $productdata['product_id'];?>"  href="javascript:void(0)" value="1"> Accept</a> <a class="btn btn-sm btn-danger setstatus" data-bidid="<?php echo $productdata['bid_id'];?>"  data-productid="<?php echo $productdata['product_id'];?>" href="javascript:void(0)" value="4">Reject</a>
        <?php endif; ?>
         <?php if((isset($productdata['bid_status'])) && ($productdata['bid_status']=='1' || $productdata['bid_status']=='2') && ($productdata['draft_accept']=='0' || $productdata['draft_accept']=='2' || $productdata['draft_accept']=='')):
                        ?>
             <a href="#" data-productid="<?php echo $productdata['product_id'];?>" data-bidid="<?php echo $productdata['bid_id']?>" class="btn btn-warning draftpopupbtn" id="<?php echo $productdata['product_id'];?>_sponsordraft"><i class="fa fa-file-text"></i> Upload draft post link</a>
    <?php endif;
  
    ?>
      <?php if((isset($productdata['bid_status'])) && ($productdata['bid_status']=='1' || $productdata['bid_status']=='2') && ($productdata['draft_accept']=='1' )):
                        ?>
               <a href="#" data-productid="<?php echo $productdata['product_id'];?>" data-bidid="<?php echo $productdata['bid_id']?>" class="btn btn-danger mediatrack" id="<?php echo $productdata['product_id'];?>_sponsordetailid"><i class="fa fa-bullseye"></i> Social Media Track id</a>
    <?php endif;?>
    <?php if($productdata['socialtrackid']!=null):
                        ?>
                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_upload_<?php echo $productdata['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Content </a>
    <?php endif;?>
     <?php if($productdata['bid_status']=='4'):?>
        <p style="color:red"><b>Rejected</b></p>
     <?php endif;?>
       </div>
      </div>
      <div> </div>
    </div>
  </li>


<div class="modal fade" id="v_view_upload_<?php echo $productdata['bid_id'] ?>" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
     
      <div class="row no-marg-right">
          
          <div class="col-sm-12">
              <div class="right_draft_sec">
                  <div class="link_tag"><a href="javascript:void(0)">Uploaded Content</a></div>
                  <div>
                     <div class="fb-post" >
                         <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F<?php echo $productdata['socialtrackid'] ?>&width=500" width="500" height="626" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                          
                     </div>
                  </div>
            
              </div>
        </div>
    </div>

</div>
</div>
</div>
  <?php 


          }
      }
     else{
            echo '<p><h4 style="color:#337ab7"> No records Found </h4></p>';
         }
                    ?>
</ul>
<!-- Submit of draft of content -->

<div id="detail_popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
      <div class="row">
        <div class="col-sm-4 text-center pop_left">
          <figure><img id="productimg" src=""></figure>
          <h4 id="product_name"></h4>
          <!-- <a href="#" id="edit_campaign_for_detail" class="btn btn-warning edit_campaign" data-action="" data-productid="<?php echo $productdata['product_id'];?>">Edit Campaigns</a> --> </div>
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
          <div >
            <p id="description"> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- **************************Social media track popup*************************** -->



<div class="modal fade" id="add_socialtrack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content post_collab_form text-center">
         <form name="trackmedia" id="save_trackmediaform" method="post" action="<?php echo site_url('/'.MY_ACCOUNT.'savetrackid');?>">
               
        <div class="post_collab_container">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
                <h2 class="modal-title" id="myModalLabel">Add Social media Id</h2>
                <p>Place the id of post you have shared in social media so that system can track the progress.</p>
                 <div class="alert alert-danger error-message">
                  <span class="text-danger">Note:</span>   <span class="round_btn facebook"><i class="fa fa-facebook"></i></span> Please add trackid as  <b> Facebook Post Id </b>
                  </div>
            </div>
             <div class="modal-body">
                      <div class="form-group">
                      <input type="hidden" name="bidid" id="trackbidid" value="" >
                   
                      </div>
                     <!--  <div class="form-group">
                          <textarea class="form-control" name="description" rows="5" id="draftdescription" placeholder="Draft Description"></textarea>
                      </div> -->
                       <div class="form-group">
                          <input type="text" class="form-control" name="socialmediaid" id="socialmediaid" placeholder="Shared Post Id" value=""/>
                      </div>
              </div>
           
            <div class="bottom-content" style="text-align:center;">
              <div class="error-message hidden" style="color:red"></div>
                                
        
                <button class="btn btn-success" type="submit" id="save_trackmediabtn">
                     <div class="btn-img" style="float:left">
                      <div class="img-loader hidden" style="z-index:1000;">
                              <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                      </div>
                     <i class="fa fa-check createcheck"></i> </div>Save Media Id
                </button>
            </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
  
  var gettrackid='<?php echo site_url('/'.MY_ACCOUNT.'gettrackid')?>'

</script>