<div class="col-md-8 col-sm-7">
        	<div class="log-form">
            
               <div class="inbox_content">
                  <ul>
                    <li><a href="<?php echo site_url('/'. MY_ACCOUNT. 'buyer_message') ?>" class="refresh"><i class="fa fa-backward">&nbsp;</i> Back</a></li>
            		<li><a href="#" class="refresh" id="triggerReply"><i class="fa fa-reply">&nbsp;</i> Reply</a></li>
                  </ul>
                  <div class="clearfix"></div>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="pull-right"><?php echo $this->general->format_date_time_message(date('Y-m-d')); ?></td>
                      </tr>
                      <tr>
                        <td colspan="2"> <em>From: <span>saagarchapagian@gmail.com</span></em><em>To Me <span>(<?php echo $this->session->userdata(SESSION.'email'); ?>)</span></em></td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <p>alsdjlj lakjd lkasjld jlaksjd asdk jaksd jasjdl aksdj lajfierjiowejreojsdak jkashd kjaj dank<?php //echo $message_detail->message; ?></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
             <div class="clearfix"></div>
             
     <form action="" method="post" class="reply" enctype="multipart/form-data" id="replyForm" style="display:none;">
        <ul>
            <li class="form-group">
              <label>Reply Message</label>
              <textarea name="message" class="form-control" rows="5" id="replyMessage" aria-hidden="true"></textarea>
            </li>
        </ul>
          <button type="submit" class="btn">Send</button>
      </form>
            </div>
        </div>


<script>
$('#triggerReply').click(function(){
  $('#replyForm').toggle();
  
  if($('#replyForm:visible').length == 1){
   $('html, body').animate({
    'scrollTop' : $("#replyForm").position().top  
   }, 1500);  
  } 
 });
</script>