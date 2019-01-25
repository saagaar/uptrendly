<div class="col-md-8 col-sm-7">
          <div class="log-form">
              <?php if($this->session->flashdata('success_message')) { ?>
                  <span class="text-success"><?php echo $this->session->flashdata('success_message'); ?> </span>
              <?php } else if($this->session->flashdata('error_message')) { ?>
                  <span class="text-danger"><?php echo $this->session->flashdata('error_message'); ?> </span>
              <?php } ?>

               <div class="inbox_content">
                  <ul>
                    <li><a href="javascript:window.history.back(-1);" class="refresh"><i class="fa fa-backward">&nbsp;</i> Back</a></li>
                <li><a href="#" class="refresh" id="triggerReply"><i class="fa fa-reply">&nbsp;</i> Reply</a></li>
                  </ul>
                  <div class="clearfix"></div>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="pull-right"><?php echo $this->general->format_date_time_message($conversations->date); ?></td>
                      </tr>
                      <tr>
                        <td colspan="2"> <em>From: <span><?php echo $seller_info->email; ?></span></em><em>To Me <span>(<?php echo $my_detail->email; ?>)</span></em></td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <p><?php echo $conversations->message; ?></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
             <div class="clearfix"></div>
             
     <form action="" method="post" class="reply" enctype="multipart/form-data" id="replyForm" style="display:none;">
        <input type="hidden" name="subject" value="RE:<?php echo $conversations->subject;?>" />
        <input type="hidden" name="sender" value="<?php echo $user_id; ?>" />
        <input type="hidden" name="receiver" value="<?php echo $seller_info->id; ?>" />
        <input type="hidden" name="msg_root" value="<?php echo $msg_id; ?>" />
        <ul>
            <li class="form-group">
              <label>Reply Message</label>
              <textarea name="message" class="form-control" rows="5" id="replyMessage" aria-hidden="true"></textarea>
              <p id="messageError"></p>
            </li>
        </ul>
          <button type="submit" class="btn" id="replyBtn">Send</button>
      </form>
            </div>
        </div>


<script>
// $('#triggerReply').click(function(){
//   $('#replyForm').toggle();
  
//   if($('#replyForm:visible').length == 1){
//    $('html, body').animate({
//     'scrollTop' : $("#replyForm").position().top  
//    }, 1500);  
//   } 
//  });
</script>