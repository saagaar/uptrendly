<?php //var_dump($communications);?>
<section class="title">
  <div class="wrap">
    <h2>Admin &raquo; Inbox</h2>
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
					//echo '<p>'.validation_errors().'</p>'; 
				}
				if($this->session->flashdata('message') != ''){
					
					echo '<p>'.$this->session->flashdata('message').'</p>';
				} 
			?>
      </div>
      <?php
		}
	  ?>
      <?php if($communications):?>
      <div class="box_block"> <?php echo form_open(ADMIN_DASHBOARD_PATH.'/communication/action/inbox',array('id' => 'adminInboxForm')); ?>
        <div class="title_h3 title_list">
          <ul>
            <li>
              <input name="msg_all" id="msg_all" type="checkbox" value="Y">
            </li>
            <li class="ref"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/inbox'); ?>"><span>Refresh</span></a></li>
            <li class="seln">
              <div>
                <select name="conversation_actions" id="conversationAction">
                  <option value="">More Action</option>
                  <option value="make_read">Mark as read</option>
                  <option value="make_unread">Mark as unread</option>
                  <option value="make_delete">Delete</option>
                </select>
              </div>
            </li>
            <li>
              <button name="action_button" value="go" class="go" id="btnGo">go</button>
            </li>
          </ul>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_mail">
          <thead>
            <tr>
              <th width="4%">&nbsp;</th>
              <th width="16%">Sent from</th>
              <th width="30%">Subj  ect</th>
              <th width="26%">Message</th>
              <th width="20%"> Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($communications as $item):
			$read_unread = ($item->ismsgseen ==  '0')? 'new_mail': 'msg_old'; 
			$no_msg_treads = '';
			//if($item->no_of_conversations >1){
				//		  $no_msg_treads = ' ('.$item->no_of_conversations.')';
			//}
			?>
            <tr class="<?php echo $read_unread; ?>">
              <td class="chk"><input name="msg_select[]" type="checkbox" value="<?php echo $item->id; ?>" class="msg_row"></td>
              	<td><?php echo $item->username;?></td>
				<td>
			  	<?php 
          if($item->subject!='') $subject=$item->subject;else $subject ='No subject';
          echo anchor(ADMIN_DASHBOARD_PATH.'/communication/conversation/'.'inbox/'.$item->id.'/'.$item->sender_id, htmlentities($subject),array('class' => $read_unread)); ?>
            	</td>
              	
                <td ><?php echo $this->general->string_limit(strip_tags($item->message),40); ?></td>
              	<td><?php echo $this->general->long_date_time_format($item->messagedate);?></td>
			</tr>
            <?php
			  endforeach;
			  ?>
          </tbody>
        </table>
        <?php echo form_close(); ?>
        <?php if($pagination_links):?>
        <div class="pagination"> <?php echo $pagination_links; ?> </div>
        <?php endif; ?>
      </div>
      <?php else:?>
      <div class="confrmmsg">
        <p>No any conversation</p>
      </div>
      <?php endif; ?>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
