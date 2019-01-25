 <?php 

// echo '<pre>';
 // print_r($communicationdata);
 ?>
 <div class="col-md-8 col-sm-7">
  <div class="log-form">

   <div class="inbox_content">
    <ul>
      <li><label>Reply Message</label></li>
    </ul>
    <div class="clearfix"></div>
    <?php if($this->session->flashdata('error_message')) { ?>
    <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></p>
    <?php } elseif($this->session->flashdata('success_message')) {?>
    <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?></p>
    <?php } ?>
    <table class="table">
      <tbody>
        <tr>
          <td colspan="2">
            <form id="communicationwithsupplierform" action="<?php echo site_url('/'.MY_ACCOUNT.'send_message/'.$product_id.'/'.$bid_id); ?>" method="post" class="reply" enctype="multipart/form-data">
              <div class="form-group">
                <input type="hidden" name="bid_id" value="<?php echo $bid_id ;?>">
                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                <textarea name="message" class="form-control" rows="6" aria-hidden="true"></textarea>
                <?php echo form_error('message'); ?>
              </div>
              <div class="form-group">
               <label>Document Attach</label>
               <input type="file" class="filestyle" name="attachmentcommunication" accept="image/png,image/jpeg,application/msword ,application/docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/excel, application/vnd.ms-excel, application/vnd.msexcel,application/pdf, application/x-pdf, application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" data-buttonName="btn-primary" data-icon="glyphicon glyphicon-paperclip" data-buttonText="">
               <?php if($this->session->flashdata('upload_error')) { ?>
               <p class="text-danger"><?php echo $this->session->flashdata('upload_error'); ?></p>
               <?php }
               ?>
             </div>
             <button type="submit" class="btn" id="communicationwithsupplierbtn">Send</button>
           </form>
         </td>
       </tr>
       <tr>
        <td colspan="2">
          <div class="row">
            <?php 
            $chatclass='';
           
            // echo '<pre>';
            // print_r($communicationdata);
            if(count($communicationdata)){
              foreach($communicationdata as $chat)
              {
                 $widths='';
                 $chat->file_saved;
                if(!($chat->file_saved)){

                  $widths="width:100%";
                }
                // echo $widths;
                $datetime = new DateTime($chat->senddate);
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i');

                        // echo $date;
                if($date==date('Y-m-d')){
                  $date='';
                }
                $user= $communicationdata[0]->user_id;
                if($user==$chat->user_id)
                  {?>

                <div class="user_a">
                 <div class="col-md-2"><img src="<?php echo site_url('/'.USER_IMAGE_PATH.$chat->cover_image);?>" /></div>
                 <div class="col-md-10 dtl">
                  <span class="tym"><?php echo $date.' '.$time;?></span> <span class="u_name"><?php echo $chat->username?></span>
                       <p> <em style="<?php echo $widths;?>"> <?php echo $chat->message;?> </em> <?php if($chat->file_saved){?><a href="<?php echo site_url('/download/message_attachment/'.$chat->attachmentid); ?>"> <i class="fa fa-cloud-download" aria-hidden="true"></i></a><?php } ?></p> 
            
                </div> 
                <?php 
              }else{
                ?>

                <div class="user_b text-right">
                 <div class="col-md-10 dtl">
                  <span class="u_name"><?php echo $chat->username;?></span> <span class="tym">10:47 AM</span>
                  <p> <em style="<?php echo $widths;?>"> <?php echo $chat->message;?> </em> <?php if($chat->file_saved){?><a href="<?php echo site_url('/download/message_attachment/'.$chat->attachmentid); ?>"> <i class="fa fa-cloud-download" aria-hidden="true"></i></a><?php } ?></p> 
                </div>
                <div class="col-md-2"><img src="<?php echo site_url('/'.USER_IMAGE_PATH.$chat->cover_image);?>" /></div>
              </div>
              <?php

            }
            ?>


                      <!--   <div class="">
                         <div class="col-md-10 dtl">
                           <span class="tym">11:20 AM </span> <span class="u_name">Sangi Bhandari</span>
                         <p>In an ordinary auction (also known as a forward auction), buyers compete to obtain a product or service. In a reverse auction, sellers compete to obtain business.</p></div>
                         <div class="col-md-2"><img src="images/profile.png" /></div>
                         
                       </div> -->

                       <?php 
                     }
                   }
                   else{
                    ?>
                    <div class="">
                      <?php 
                      echo 'No Previous Message found';
                      ?>
                    </div>
                    <?php 
                  }
                  ?>
                </div>



              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="clearfix"></div>


    </div>
  </div>