<div class="col-md-8 col-sm-7">
  <div class="log-form"> 
      <div id="mail_error">
        <?php if($this->session->flashdata('success_message')) { ?>
            <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?> </p>
        <?php } else if($this->session->flashdata('error_message')) { ?>
            <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?> </p>
        <?php } ?>
      </div> 
      <?php if($buyer_messages){?>
      <form method="post" action="<?php echo site_url('/communication/mail/action/inbox');?>" id="adminInboxForm" enctype="multipart/form-data">
        
       <div class="inbox_content">
          <ul>
            <li><input id="msg_select" name="msg_all" type="checkbox"></li>
            <li><a href="<?php echo site_url('my-messages/inbox');?>" class="refresh"><i class="fa fa-refresh">&nbsp;</i> Refresh</a></li>
            <li><button id="btn_delete" class="btn btn_delete" name="action_button" disabled="disabled" value="Delete">Delete</button></li>
          </ul>
          <div class="clearfix"></div>
          <table class="table demo footable">
            <thead>
              <tr>
                <th width="25%" data-class="expand">Sent from</th>
                <th width="25%" data-hide="phone">Subject</th>
                <th width="25%" data-hide="phone">Message</th>
                <th width="25%" data-hide="phone">Date</th>
              </tr>
              </thead>
              
            <tbody>
            <?php foreach($buyer_messages as $buyer_message) { ?>
                <tr>
                  <td>
                      <input class="msg_row" name="msg_select[]" type="checkbox" value="<?php echo $buyer_message->id; ?>">
                      <span><?php echo $buyer_message->sender; ?></span>
                  </td>
                  <td><a href="<?php echo site_url('/my-messages/conversation/'.'inbox/'.$buyer_message->id.'/'.$buyer_message->sender);?>"><?php echo $buyer_message->subject; ?></a></td>
                  <td><?php echo character_limiter($buyer_message->message, 15); ?></td>
                  <td><?php echo $this->general->date_month_year_time_format($buyer_message->date); ?></td>
                </tr>                                               
              </tbody>
              <?php } ?>
          </table>
        </div>
        <input type="hidden" name="conversation_actions" value="make_delete">
        </form>
    <?php }  else { ?>
      <div>No Message found in your inbox</div>
    <?php } ?>     
     <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(           
    function() {
      $('#msg_select').click(function() {
        if ($("#msg_select").is(":checked")) {
          $('.msg_row').prop('checked', true);              
          $('#btn_delete').prop('disabled', false);
        } else {
          $('.msg_row').prop('checked', false); 
          $('#btn_delete').prop('disabled', true);

        }
      });   
    }   
  );
</script>