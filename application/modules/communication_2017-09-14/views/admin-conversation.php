<section class="title">
  <div class="wrap">
    <h2>Admin &raquo; Conversation</h2>
  </div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu');?>
    </aside>
    <section class="smfull">
      <?php
			if(validation_errors() != '' || $this->session->flashdata('message') != ''){
			?>
      	<div class="confrmmsg">
        <?php
			if(validation_errors() != ''){
				echo validation_errors(); 
			}
			if($this->session->flashdata('message') != ''){
				echo '<p>'.$this->session->flashdata('message').'</p>';
			} 
		  ?>
      </div>
      <?php
		}
	  ?>
      
      <?php echo form_open(ADMIN_DASHBOARD_PATH.'/communication/action/'.$current_menu,array('id' => 'adminInboxForm')); ?>
      <div class="box_block">
        <div class="title_h3 title_list">
          <ul>
            <li class="arch">
				<?php echo anchor(ADMIN_DASHBOARD_PATH.'/communication/inbox','<span>'.'Go to Inbox'.'</span>'); ?>
           	</li>
            <li class="arch">
				<?php echo anchor(ADMIN_DASHBOARD_PATH.'/communication/sent','<span>'.'Go to Outbox'.'</span>'); ?>
           	</li>
            <li class="seln">
              <div>
                <select name="conversation_actions" id="conversationAction">
                  <option value="">More Actions...</option>
                  <option value="make_read">Mark as read</option>
                  <option value="make_unread">Mark as unread</option>
                  <option value="make_delete">Delete</option>
                </select>
              </div>
            </li>
            <li>
              <button name="action_button" id="btnConversationGo" value="go" class="go">go</button>
            </li>
          </ul>
        </div>
        <?php 
		   if($conversations):
		   ?>
        <ul id="conversation">
          <?php 
			$open_msg_detail = false;
			?>
          <input name="msg_select[]" type="hidden" value="<?php echo $conversations->id; ?>">
          <li>
            <div class="accordionButton <?php //echo ($open_msg_detail)?'on':'';?>"> <?php echo htmlentities($conversations->subject); ?> <em>
              <?php //echo date('D, M j, Y \a\t H:i A',$conversations->date);?>
              </em> <em><?php echo $this->general->long_date_time_format($conversations->date); ?></em> </div>
            <div class="accordionContent" <?php //echo ($open_msg_detail)?'style="display: block;"':'style="display: none;"';?>>
              <ol class="mailadd left">
                <?php $seller_info=$this->general->fetch_members_selected_fields(array('username as name','email'),array('id'=>$seller_id));?>
                <li>
                	<?php 
						if($current_menu=='inbox'){
							echo $seller_info->name.'<em>('.$seller_info->email.')</em></br>';
							echo "To Admin";
						}else if($current_menu=='outbox'){
							echo WEBSITE_NAME."<br>";
							echo $seller_info->name.'<em>('.$seller_info->email.')</em></br>';
						}
					?>
                </li>
              </ol>
              <section>
			  	<?php echo $conversations->message;?>
                <?php if($conversations_attach){?>
                <div class="attachmentDownloadContainer">
                  <?php if($conversations_attach->id != NULL && $conversations_attach->file_name != NULL){?>
                  	<strong>There is a attached file</strong>
                  	<?php
						/*This conversation contains attachment, so dispaly the donload link*/
						echo anchor(ADMIN_DASHBOARD_PATH.'/communication/attachment/'.$current_menu."/".$conversations_attach->msg_id.'/'.$conversations_attach->id.'/'.$seller_id, $conversations_attach->file_name. ' ('.ceil($conversations_attach->file_size).'Kb)' ,array('class' => 'msg_attachment', 'title' => ''));
					}
					?>
                </div>
                <?php } ?>
              </section>
            </div>
          </li>
        </ul>
        <?php endif; ?>
        <div class="clearfix"></div>
      </div>
      <?php echo form_close(); ?> </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
