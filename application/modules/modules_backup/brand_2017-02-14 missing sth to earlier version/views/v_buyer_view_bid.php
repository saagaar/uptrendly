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

            

        <h4>Current Bids</h4>

       

            <div class="successinfo alert alert-success" style="display:none"></div>

           

       

            <?php if($this->session->flashdata('error_message')) { ?>

                <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></p>

              <?php } elseif($this->session->flashdata('success_message')) {?>

                <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?></p>

            <?php } ?>

         <?php if($bidslist) {



          ?>

        <table class="table table-hover footable">

                    <thead>

                        <tr>

                            <th data-hide="phone" width="10%">ID</th>

                            <th data-class="expand"  width="35%">User Name</th>

                            <th data-hide="phone" width="20%">Description</th>

                            <th data-hide="phone" width="20%">Rating</th>

                            <th data-hide="phone" width="20%">Bid Date</th>

                            <th data-hide="phone" width="10%">Bid Amount</th>

                            <th width="5%">Options</th>

                        </tr>

                    </thead>

                    <tbody>

                    

                    <?php

                    $i=1;

                     foreach($bidslist as $bids) {

                 // print_r($bids);

                       ?>

                        <tr>

                            <td><?php echo $i;?></td>

                            <td> <a href="<?php echo site_url('/'.MY_ACCOUNT.'member_profile/'.$bids->user_id);?>"><?php echo $bids->username; ?></a></td>

                            <td><?php echo substr($bids->bid_details,0,20).'...'; ?></td>

                            <td><?php echo round($my_rating->averagerating,1);?></td>

                            <td><?php echo $bids->bid_date ?></td>

                            <td><?php echo $bids->user_bid_amt; ?></td>

                            <td class="text-center">

                                <div class="dropdown">

                                   <a href="#" class="list_bars" data-toggle="dropdown"><i class="fa fa-bars" aria-hidden="true"></i></a>

                                    <ul class="dropdown-menu">

                                        <?php 



                                        if($bids->productstatus == '2') { ?>

                                        <li><a onclick="return verifyaction();" href="<?php echo site_url('/'.MY_ACCOUNT.'make_winner/'.$bids->product_id.'/'.$bids->id); ?>">Make Winner</a></li>



                                        <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'send_message/'.$bids->product_id.'/'.$bids->bidid); ?>">Send Message</a></li>

                                      <?php if($bids->attachment) { ?>  <li><a href="<?php echo site_url('/download/bid_document/'.$bids->bidid); ?>">Download Attchment</a></li><?php } ?>

                                      

                                        <?php } else { ?>

                                             <li><a href="<?php echo site_url('/'.MY_ACCOUNT.'send_message/'.$bids->product_id.'/'.$bids->bidid); ?>">Send Message</a></li>

                                     <?php if($bids->attachment) { ?>  <li><a href="<?php echo site_url('/download/bid_document/'.$bids->bidid); ?>">Download Attchment</a></li><?php } ?>

                                        <?php if($bids->winnerbid && $bids->productstatus=='3') { ?> <li><a  class="clickmodalrate" data-sendfrom="<?php echo $this->session->userdata(SESSION.'user_id');?>" data-productid="<?php echo $bids->product_id;?>" data-sendto="<?php  echo  $bids->user_id;?>" data-getdata="<?php echo site_url('/'.MY_ACCOUNT.'getrating');?>" href="">Rate Supplier</a></li><?php } ?>

                                        <?php } ?>

                                    </ul>

                                </div> 

                            </td>

                        </tr>

                    <?php  

                    $i++;

                    } ?>

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

                <?php  } else { echo "No live products"; } ?>

         

         </div>

        

</div>



<!-- For rating supplier -->

<div id="myModal" class="modal fade" role="dialog">

  <div class="modal-dialog popup_sec">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <div class="modal-title">

        <p>Choose a rating and Leave comments</p>

        </div>

      </div>

      <div class="modal-body">

      <form method="post" action="<?php echo site_url('/'.MY_ACCOUNT.'saverating');?>" class="saverating"  enctype="multipart/form-data">

      <div class="form-group">

      <div class="errorinfo alert alert-danger" style="display:none"></div>

        <label>Rating</label>

        <div class="rating">   

              <span><i class="fa fa-star ratestar" id="1-rate" ></i></span> 

              <span><i class="fa fa-star ratestar" id="2-rate"></i></span>  

              <span><i class="fa fa-star ratestar" id="3-rate"></i></span>  

              <span><i class="fa fa-star ratestar" id="4-rate"></i></span>  

              <span><i class="fa fa-star ratestar" id="5-rate"></i></span>

        </div>

       </div>

      <div class="form-group">

        <label>Comments</label>

        <input type="hidden" name="fromuser" id="fromuser" value="<?php echo $this->session->userdata(SESSION.'user_id');?>">

        <input type="hidden" name="touser" id="touser" value="">

        <input type="hidden" name="product_id" id="product_id" value="">

       

        <textarea name="textarea" rows="5" class="form-control comment"></textarea>

      </div>

      

      <button name="button" class="btn btn_submit ratingsubmit" type="submit">Submit</button>

      </form>

      

      </div>

    </div>



  </div>

</div>




