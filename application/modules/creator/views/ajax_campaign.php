<ul class="list-unstyled product_listing campaigns_list">
  <?php 

                   if(count($campaigns)>=1){

                        foreach($campaigns as $productdata)
                    {   
                             
                                     
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
									 
                                      ?>
        </h4>
        <div class="row">
          <div class="col-xs-6 col-sm-4">
            <h5>Product Name<span><?php echo $productdata['product_name'];?></span></h5>
            <h5>Deadline <span><?php echo date('Y-m-d',strtotime($productdata['submission_deadline'])) ;?></span></h5>

          </div>
          <div class="col-xs-6 col-sm-4">
            <h5>URL <span><?php echo $productdata['product_url'];?></span></h5>
            <h5>Category <span><?php echo $productdata['category_name'];?></span></h5>
          </div>
           <div class="col-xs-6 col-sm-4 col-md-3">
            <h5>Status <span><?php 
            $status=$productdata['status'];
            if($status=='0') echo 'No Action';
            if($status=='4') echo 'Rejected';
            if($status=='6' ) echo 'Expired';
            if($status=='7') echo 'Completed';
            if($status=='1' || $status=='2') 
            {
              if($productdata['upload_status']=='1') echo 'Content Uploaded';
              if($productdata['draft_accept']=='1' && $productdata['upload_status']=='0') echo 'Draft Accepted';
              if($productdata['draft_accept']=='2') echo 'Draft Rejected';
              if($productdata['draft_accept']=='0' ) echo 'Draft Sent';
              if($productdata['draft_accept']=='' ) echo 'In Progress';
            }
           
            ?></span></h5>
            <h5></h5>
          </div>
          
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
               <a href="#" data-productid="<?php echo $productdata['product_id'];?>" data-bidid="<?php echo $productdata['bid_id']?>" class="btn btn-primary mediatrack" id="<?php echo $productdata['product_id'];?>_sponsordetailid"><i class="fa fa-bullseye"></i> Upload Social Media Link</a>
    <?php endif;?>
    <?php if($productdata['upload_status']=='1'):
                        ?>
                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_upload_<?php echo $productdata['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Content </a>
    <?php endif;?>
     <?php

      if($productdata['upload_status']=='1' && $productdata['status']=='7'):
                        ?>
                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#v_view_report_<?php echo $productdata['bid_id'] ?>" href="javascript:void(0)"><i class="fa fa-hourglass"></i> View Report </a>
                
    <?php endif;?>
     <?php if($productdata['bid_status']=='4'):?>
        <p style="color:red"><b>Rejected</b></p>
     <?php endif;?>
       </div>
      </div>
      <div> </div>
    </div>
  </li>
<?php 


/********************************View uploaded Content*************************************************/
if($productdata['upload_status']=='1'):
?>
<div class="modal fade" id="v_view_upload_<?php echo $productdata['bid_id'] ?>" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
     
      <div class="row no-marg-right">
          
           <div class="col-sm-12">
              <div class="right_draft_sec">
                  <h3 class="modal_ttl">Uploaded Content</h3>
                  <div>
                     <ul class="social_posts">
                                        <?php 
                         $content=$this->general->get_uploaded_content($productdata['bid_id']);
                          $page=$this->general->get_single_row('member_socialmedia',array('user_id'=>$productdata['user_id'],'media_type_id'=>FACEBOOKMEDIAID));

                                      foreach($content as $eachcontent):
                                        if($eachcontent->uploaded_media=='fb_page')
                                        { 

                                          if(count($page)>0 || strpos($eachcontent->link, '://'))
                                          {
                                               $options = array(
                                            
                                              'http'=>array(
                                                'method'=>"GET",
                                                'header'=>"Accept-language: en\r\n" .
                                                                            "Cookie: uptrendly=bar\r\n" .  // check function.stream-context-create on php.net
                                                                            "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
                                                                            )
                                              );

                                            $context = stream_context_create($options);
                                            if (false === strpos($eachcontent->link, 'https://'))
                                            {
                                                  $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url=http://facebook.com/'.$page->page_id.'/posts/'.$eachcontent->link.'&omitscript=false';
                                            }
                                            else
                                            {
                                              $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$eachcontent->link.'&omitscript=false';
                                            }
                                          
                                            $jsonresp=file_get_contents($request_url,false, stream_context_create($options));
                                            $response = json_decode($jsonresp, true)['html']; 
                                          }
                                          else
                                          {
                                            $response= '<a target="_blank" href="http://facebook.com/'.$eachcontent->link.'" >http://facebook/com/'.$eachcontent->link.'</a>';
                                          }
                                        ?>
                                        <li>
                                        <label>Facebook Page</label>
                                          <div class="post"><?php print_r($response);?></div>
                                        </li>
                                        <?php
                                        }
                                        elseif($eachcontent->uploaded_media=='fb_profile'){
                                        ?>
                                          <li>
                                          <label>Facebook Profile</label>
                                            <div class="post">
                                                <div class="fb-post" data-href="<?php echo $eachcontent->link;?>" data-width="auto" data-show-text="true"><blockquote cite="<?php echo $eachcontent->link;?>" class="fb-xfbml-parse-ignore"></blockquote></div>

                                            </div>
                                          </li>
                                        
                                        <?php 
                                        }
                                        //for instagran
                                        else
                                        { ?>
                                       <li>
                                       <label>Instagram Post</label>
                                       <div class="post">
                                       <?php 
                                         $request_url = 'https://api.instagram.com/oembed?url=' . $eachcontent->link;
                                         $response=(file_get_contents($request_url."&omitscript=false&hidecaption=false"));
                                         $json_data = json_decode($response , true);

                                         // print_r($json_data);
                                         echo $json_data['html'];
                                        ?>
                                        </div>
                                         </li>
                                         <?php
                                        }
                                        endforeach;?>
                                          <div></div>
                                        </ul>
                  </div>
            
              </div>
        </div>
    </div>

</div>
</div>
</div>

  <?php 
/**************************End of uploaded content****************************************/
  /*******************************Report *************************************************/
  $data['bid_id']=$productdata['bid_id'];
  $data['content']=$content;
  $data['report']=$this->general->get_report($productdata['bid_id']);
  $data['product_name']=$productdata['campaign_name'];
  $this->load->view('v_report_portion',$data);
  /**************************End of Report****************************************/

  endif;
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
        <div class="col-sm-8 resp_pad_30">
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

                      
                      <label>Facebook Page Post Id</label>
                       <div class="form-group row">
                         <div class="col-xs-10">
                             <input type="text" class="form-control" name="fb_page" id="fb_page" placeholder="Shared Facebook Page Post Id" value=""/>
                        </div>
                        
                      </div>
                     
                       <div class="form-group row">
                        <label>Facebook Profile Post URL</label>
                        <div class="col-xs-10">
                          <input type="text" class="form-control removeinput" name="fb_profile" id="fb_profile" placeholder="Shared Facebook Profile URL" value=""/>
                          </div>
                        <div class="col-xs-2 remover">
                            <a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                    
                       <div class="form-group row">
                         <label>Instagram Post URL</label>
                        <div class="col-xs-10">
                          <input type="text" class="form-control removeinput" name="instagram"  id="instagram_username" placeholder="Shared Instagram Url" value=""/>
                           </div>
                        <div class="col-xs-2 remover">
                            <a class="removeinput" href="javascript:void(0)"><i class="fa fa-times"></i> Remove</a>
                        </div>
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