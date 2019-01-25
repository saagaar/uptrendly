<aside class="col-md-9 col-sm-8">
  <div class="white_box">
    <section class="inbox_sec">
      <div class="title_head">
        <h3>Outbox</h3>
      </div>
      <div id="mail_error"></div>
      <?php if($outbox_msg){?>
      <form method="post" action="<?php echo site_url('/communication/mail/action/outbox');?>" id="adminInboxForm" enctype="multipart/form-data">
        <div class="inbox_content">
          <ul>
            <li>
              <input name="msg_all" id="msg_all" type="checkbox" value="Y">
            </li>
            <li><a href="<?php echo site_url('my-messages/inbox');?>" class="refresh"><i class="fa fa-refresh">&nbsp;</i> Refresh</a></li>
            <li>
            <select name="conversation_actions" id="conversationAction" class="form-control">
                <option value="">More Actions</option>
                <option value="make_delete">Delete</option>
              </select>
             </li>
             
            <!--<li class="btn-yellow"> <a href="your_message.html">GO</a> </li>-->
            
            <li><button class="btn btn-yellow" name="action_button" value="go" id="btnGo">Go</button></li>
          </ul>
          <div class="clearfix"></div>
          <table class="table demo footable">
            <thead>
              <tr>
                <th width="25%" data-class="expand">Sent To</th>
                <th width="25%" data-hide="phone">Subject</th>
                <th width="25%" data-hide="phone">Message</th>
                <th width="25%" data-hide="phone">Date</th>
              </tr>
            <tbody>
             <?php foreach($outbox_msg as $msg){?>
             	<tr>
                  	<td>
                  		<input name="msg_select[]" type="checkbox" value="<?=$msg->id; ?>" class="msg_row">
                    	<span><?php echo ($msg->user_type=='1' && $msg->name=='')?'Admin':$msg->name; ?></span>
               		</td>
                  <td><a href="<?php echo site_url('/my-messages/conversation/'.'outbox/'.$msg->id.'/'.$msg->receiver);?>" class="new_mail"> <?php echo ($msg->subject!='')?$this->general->string_limit($msg->subject,20):'View Detail'; ?></a></td>
                  <td><?php echo $this->general->string_limit($msg->message,20); ?></td>
                  <td><?php echo $this->general->bidwarz_date_format($msg->date);?></td>
                </tr>
             <?php } ?>
            </tbody>
            </thead>
            
          </table>
        </div>
      </form>
      <?php }else{ ?>
      	<div>No Message found in your outbox</div>
      <?php } ?>
    </section>
  </div>
</aside>
