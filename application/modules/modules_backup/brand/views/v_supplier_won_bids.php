<div class="col-md-8 col-sm-7">
        	<div class="log-form">

                 <?php if($this->session->flashdata('error_message')) { ?>
                <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></p>
              <?php } elseif($this->session->flashdata('success_message')) {?>
                <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?></p>

            <?php } ?>
            	<table class="table table-hover footable">
                    <thead>
                        <tr>
                            <th data-hide="phone">Auction ID</th>
                            <th data-class="expand">Auction Name</th>
                            <th data-hide="phone">Budget</th>
                            <th data-hide="phone">Buyer Name</th>
                            <th data-hide="phone">Feedback</th>
                        </tr>
                    </thead>
                    <tbody>	
                        <?php 
                    if(count($won_bids)>0)
                      {
                        // print_r($won_bids);
                            foreach ($won_bids as $key => $value) {
                            ?>
                            <tr>
                                    <td><?php echo $value->product_id;?></td>
                                    <td><?php echo $value->product_name;?></td>
                                    <td><?php echo $value->won_amount;?></td>
                                    <td><a href="<?php echo site_url('/'.MY_ACCOUNT.'member_profile/'.$value->seller_id); ?>"><?php echo $value->username;?></a></td>
                                    <td><a  class="clickmodalrate" data-sendfrom="<?php echo $this->session->userdata(SESSION.'user_id');?>" data-productid="<?php echo $value->product_id;?>" data-sendto="<?php  echo  $value->seller_id;?>"  data-getdata="<?php echo site_url('/'.MY_ACCOUNT.'getrating');?>" href="">Feedback</a></td>
                            </tr>
                            <?php 
                             }
                      }
                      else{
                        ?>
                        <tr>
                            <td colspan="5">No Record found</td>
                        </tr>

                        <?php 
                      } 

                        ?>                     
                    </tbody>
                </table>
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