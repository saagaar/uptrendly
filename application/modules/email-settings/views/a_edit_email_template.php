
<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Email Settings</h2>
</div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
  </aside>
  <section class="smfull">
   <div class="confrmmsg">
    <?php	
    if($this->session->flashdata('message') != '')
    {
        echo '<p>'.$this->session->flashdata('message').'</p>';
    } 
    ?>
</div>
<div class="box_block">
   <form name="emailSettingForm" method="post" action="" accept-charset="utf-8" id="emailSettingForm">
      <fieldset>
         <div class="title_h3">Email Template</div>
         <ul class="frm">             			

            <li class="txthalf">
               <div>
                  <label>Subject <span>*</span> :</label>

                  <input size="50" class="inputtext" type="text" id="subject" name="subject" value="<?php echo set_value('subject',$email_data->subject);?>" />
                  <?=form_error('subject')?>
              </div>
          </li>


          <li class="txtar">
            <label>Body <span>*</span> :</label>
            <?php
            $content_data = '';
            if($this->input->post('content') || form_error('content')){$content_data=html_entity_decode($this->input->post('content'));}
            else {$content_data= html_entity_decode($email_data->email_body);}
            echo form_fckeditor('content',$content_data);
            ?>
            <?=form_error('content')?>
        </li>
    </ul>
</fieldset>
<input size="50" class="inputtext" type="hidden" id="es_id" name="" value="<?php echo $email_data->id;?>">

<fieldset>
    <div class="title_h3">Email Settings</div>
    <ul class="frm">
        <li>
            <div>
                <label>Display Notification</label>                  
                <input name="is_display_notification" type="radio" value="0" checked="checked" />No
                <input name="is_display_notification" type="radio" value="1" <?php if($email_data->is_display_notification == '1'){ echo 'checked="checked"';}?> />Yes
                <?=form_error('is_display_notification');?>
            </div>
        </li>
        <li>
            <div>
                <label>Email Notification Send</label>                  
                <input name="is_email_notification_send" type="radio" value="0" checked="checked" />No
                <input name="is_email_notification_send" type="radio" value="1" <?php if($email_data->is_email_notification_send == '1'){ echo 'checked="checked"';}?> />Yes
                <?=form_error('is_email_notification_send');?>
            </div>
        </li>

    </fieldset>
    <?php if(SMS_NOTIFICATION==1){ ?>
     <fieldset>
     <div class="title_h3">SMS Settings</div>
        <ul class="frm">

         <li>
            <div>
                <label>SMS Notification Send</label>                  
                <input name="is_sms_notification_send" type="radio" value="0" checked="checked" />No
                <input name="is_sms_notification_send" type="radio" value="1" <?php if($email_data->is_sms_notification_send == '1'){ echo 'checked="checked"';}?> />Yes
                <?=form_error('is_sms_notification_send');?>
            </div>
        </li>
        <li>
         <div>
             <label>SMS Text</label>
             <textarea name="sms_text"><?php echo set_value('sms_text', $email_data->sms_text);?></textarea>
             <?=form_error('sms_text');?>
         </div>
     </li>
 </ul>   

</fieldset>
<?php } ?>
<fieldset class="btn">
  <input type="submit" value="Submit" class="butn">
</fieldset>


</form>
</div>
</section>
<div class="clearfix"></div>
</div>
</article>
<div> </div>
