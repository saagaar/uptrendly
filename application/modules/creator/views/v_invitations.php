<div class="col-md-12 col-sm-7">
  <div class="log-form tran_his">
    <h4>Invitations </h4>
    <?php 

            if($this->session->flashdata('error_message')) { ?>
    <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></p>
    <?php } elseif($this->session->flashdata('success_message')) {?>
    <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?></p>
    <?php } ?>
    <?php   
         if($invitation!='') { 
             ?>
    <table class="table table-hover footable">
      <thead>
        <tr>
          <th data-hide="phone" width="8%">Id</th>
          <th data-class="expand">Invited By</th>
          <th data-hide="phone">Invitation for Campaign</th>
          <th data-hide="phone" class="text-center">Linked media</th>
          <th data-hide="phone">Message</th>
          <th data-hide="phone" class="text-center">Date And Time</th>
        </tr>
      </thead>
      <tbody>
        <?php 
                    $i=1;
                    foreach($invitation as $item) {

                        ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $item->brandname; ?></td>
          <td><?php echo ($item->campaign); ?></td>
          <td class="text-center"><?php 
                           

                        if($item->media)
                        { 

                           $socialmedia=explode(',',$item->media);
                           foreach($socialmedia as $mediaitem)
                           { 

                                if(defined('FACEBOOKMEDIAID') && $mediaitem==FACEBOOKMEDIAID)
                                {
                                  ?>
            <span class="round_btn facebook "> <i class="fa fa-facebook-f"></i> </span>
            <?php
                                }
                                 if(defined('TWITTERMEDIAID') && $mediaitem==TWITTERMEDIAID)
                                {
                                  ?>
            <span class="round_btn twitter"> <i class="fa fa-twitter-square"></i> </span>
            <?php
                                }
                                  if(defined('INSTAGRAMMEDIAID') && $mediaitem==INSTAGRAMMEDIAID)
                                {
                                  ?>
            <span class="round_btn instagram"> <i class="fa fa-instagram"></i> </span>
            <?php
                                }
                                  if(defined('YOUTUBEMEDIAID') && $mediaitem==YOUTUBEMEDIAID)
                                {
                                  ?>
            <span class="round_btn youtube"> <i class="fa fa-youtube"></i> </span>
            <?php
                                }
                                  if(defined('YOUTULEEMEDIAID') && $mediaitem==YOUTULEEMEDIAID)
                                {
                                  ?>
            <span class="round_btn btn-youtulee"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
            <?php
                                }
                                 if(defined('TUMBLRMEDIAID') && $mediaitem==TUMBLRMEDIAID)
                                {
                                  ?>
            <span  class="round_btn tumblr"><i class="fa fa-tumblr"></i></span>
            <?php
                                }
                           }
                          
                              ?></td>
          <td><?php echo $item->message; ?></td>
          <td class="text-center"><?php echo $this->general->date_month_year_time_format($item->invite_date); ?></td>
        </tr>
        <?php
                    $i++;
                  }
                } ?>
      </tbody>
    </table>
    <?php if($pagination_links):?>
    <div class="pagination"> <?php echo $pagination_links; ?> </div>
    <?php endif;
                 } else { echo "No Invitation History"; } ?>
  </div>
</div>
