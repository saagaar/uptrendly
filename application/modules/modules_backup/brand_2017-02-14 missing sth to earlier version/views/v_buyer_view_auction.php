<div class="col-md-8 col-sm-7">



    <div class="log-form">

   



   <!--     <div class="log-form">

          <div class="profile_link"><a href="<?php echo site_url('/'. MY_ACCOUNT. 'buyer_profile'); ?>">View Profile</a></div>

            <div class="clearfix"></div>

          <div class="about_user">

            <div class="row">

              <div class="col-md-6">

                    <ul class="user_info">

                        <li><?php //echo ucfirst($details->name.' '. $details->last_name); ?></li>

                        <li>

                        

                        <i class="fa fa-star" aria-hidden="true"></i>

                        <i class="fa fa-star-half-o" aria-hidden="true"></i>

                        <i class="fa fa-star-o" aria-hidden="true"></i>

                        <i class="fa fa-star-o" aria-hidden="true"></i>

                        <i class="fa fa-star-o" aria-hidden="true"></i>

                        

                        </li>

                        <li>14 Review</li>

                    </ul>

                </div>

                <div class="col-md-6">

                <ul class="pull-right">

                  <p>Membership: <span>1 post</span></p>

                    <p>Membership Expire: <span>14 days</span></p>

                </ul>    

                </div>

            </div>

            </div>

             -->

            

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

                    

                    <?php foreach($live_products as $product) {

                        ?>

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

                 <?php if($pagination_links):?>

        <div class="pagination"> <?php echo $pagination_links; ?> </div>

     <!--   <section> 

    <!-- pagination-Sec -->  

        <!-- <nav class="pagination_sec text-center">

          <ul class="pagination">

          <li> <?php echo $pagination_links; ?></li>

            <li><a aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>

            <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>

            <li><a href="#">2</a></li>

            <li><a href="#">3</a></li>

            <li>

              <a aria-label="Next" href="#">

                <span aria-hidden="true">»</span>

              </a>

            </li>

          </ul>

          <div class="clearfix"></div>

        </nav> -->

    <!--/.end-->

    <!-- </section> -->

        <?php endif; ?>

                <?php  } else { echo "No live bid found."; } ?>

         

         </div>

        

</div>

