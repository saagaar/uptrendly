<script type="text/javascript">
  var ChangeProfileUrl = "<?php echo site_url('/'.MY_ACCOUNT.'changeprofilepicture');?>";
  var UrlRemoveDropzoneTempImage = "<?php echo site_url('/'.MY_ACCOUNT.'ajax_delete_product_temp_images'); ?>";
</script>

<div class="col-md-8 col-sm-7">

        <div class="log-form">

          <div class="profile_link"><a href="<?php echo site_url('/'. MY_ACCOUNT. 'member_profile/'.$this->session->userdata(SESSION.'user_id')); ?>">View Profile</a></div>

            <div class="clearfix"></div>

          <div class="about_user">

            <div class="row">

              <div class="col-md-6">
                 <figure>
                  <img id="pp" class="uploadFileImg" src="<?php if($details->cover_image != '') { echo base_url().USER_IMAGE_PATH.$details->cover_image;} else {echo base_url().USER_IMAGE_PATH.'profile.png';} ?>" alt="Image" />
                  <i class="fa fa-camera uploadFileImg">&nbsp;</i>
                 <img src="<?php  echo base_url().USER_IMG_DIR.'loading-bid.gif'?>" class="profileloader" style="display:none"> 
                  </figure>
                <div class="msg">
                    </div>
                   <form name="changeprofileform" id="changeprofileform" enctype="multipart/form-data">
                       <input type="file" name="profile_picture" style="position:absolute; opacity:0;" id="profile_picture"/>
                    </form>

                    <ul class="user_info">

                        <li><?php
                      
                               $name=isset($details->name) ? $details->name : ''; 
                               $lastname=isset($details->last_name) ? $details->last_name : ''; 
                         echo ucfirst($name.' '. $lastname); ?></li>

                        
                        <li>
                            <?php $percentage=isset($my_rating->averagerating)?($my_rating->averagerating/5)*100:0;

                            ?>
                             <div class="star-ratings-sprite">
                               <span style="width:<?php echo $percentage;?>%" class="star-ratings-sprite-rating"></span>
                             </div>
                         </li>

                        <li><?php echo count($productwise_rating);?> Review</li>


                    </ul>

                </div>

                <div class="col-md-6">

                <ul class="pull-right">
                <?php 

                    if(($memberinfo->membership_type)!=''){
                        $membertype=explode('_',$memberinfo->membership_type);
                        $membership=implode(' ', array_map('ucfirst', $membertype));

                        $expiry=$this->general->get_remaining_time($memberinfo->member_validity);
                        if($memberinfo->membership_type=='unlimited' && $expiry<0)
                        { 
                            $rem_days='Expired' ;
                        }
                        else if($expiry>0)
                            {   
                               $rem_days=$this->general->timeRemaining($expiry);
                            }else{
                                 $rem_days='Expired';

                            }

                    }else{
                        $membership='None';
                        $rem_days='N/a';
                    }
                ?>
                  <p>Membership: <span><?php echo $membership;?></span></p>

                    <p>Membership Expire: <span><?php echo $rem_days;?></span></p>

                </ul>    

                </div>

            </div>

            </div>

            

            

        <h4>Live Auctions</h4>

            <?php if($this->session->flashdata('error_message')) { ?>

                <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></p>

              <?php } elseif($this->session->flashdata('success_message')) {?>

                <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?></p>

            <?php } ?>

         <?php if($live_products) { ?>

         <table class="table table-hover footable">

                    <thead>

                        <tr>

                            <th data-hide="phone" width="10%">ID</th>

                            <th data-class="expand"  width="35%">Name</th>

                            <th data-hide="phone" width="20%">Start Date</th>

                            <th data-hide="phone" width="20%">End Date</th>

                            <th data-hide="phone" width="10%">Status</th>

                            <th width="5%">Options</th>

                        </tr>

                    </thead>

                    <tbody>

                    

                    <?php foreach($live_products as $product) {?>

                        <tr>

                            <td><?php echo $product->product_code ?></td>

                            <td><?php echo $product->name; ?></td>

                            <td><?php echo $this->general->date_month_year_time_format($product->auc_start_time); ?></td>

                            <td><?php echo $this->general->date_month_year_time_format($product->auc_end_time); ?></td>

                            <td><?php echo $this->general->get_product_status($product->status); ?></td>

                            <td class="text-center">

                                <div class="dropdown">

                                   <a href="#" class="list_bars" data-toggle="dropdown"><i class="fa fa-bars" aria-hidden="true"></i></a>

                                    <ul class="dropdown-menu">

                                        <?php 



                                        if($product->status == '1') { ?>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'edit_auction/'.$product->id); ?>">Edit</a></li>



                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'cancel_auction/'.$product->product_code); ?>">Cancel</a></li>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'auction_detail/'.$product->id) ?>">View Details</a></li>

                                        <?php } elseif($product->status == '2') { ?> 

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'cancel_auction/'.$product->product_code); ?>">Cancel</a></li>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'invitation/'.$product->id); ?>">Invitaiton</a></li>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'auction_detail/'.$product->id) ?>">View Details</a></li>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'bid_details/'.$product->id) ?>">View Bids</a></li>                                        

                                        <?php } elseif($product->status == '3') { ?>                                       

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'cancel_auction/'.$product->product_code); ?>">Cancel</a></li>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'auction_detail/'.$product->id) ?>">View Details</a></li>

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'bid_details/'.$product->id) ?>">View Bids</a></li>

                                        <?php } elseif($product->status == '4') { ?>                                        

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'auction_detail/'.$product->id) ?>">View Details</a></li>

                                        

                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'bid_details/'.$product->id) ?>">View Bids</a></li>

                                        <?php } ?>

                                    </ul>

                                </div>

                            </td>

                        </tr>

                    <?php  } ?>

                    </tbody>

                </table>

                <?php  } else { echo "No live products"; } ?>

         

         </div>

            

        </div>

<script type="text/javascript">


  $(function(){
    $(".uploadFileImg").on('click',function(){
   //on click of image trigger click of input type=file
   $("#profile_picture").trigger('click'); 
});
  })
  
</script>