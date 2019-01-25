<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Newsletter  Management</h2>
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
      if($this->session->flashdata('message') != ''){
        echo '<p>'.$this->session->flashdata('message').'</p>';
      } 
    ?>
      </div>
      <div class="box_block">
        <div class="title_h3">Add NewsLetter</div>
        <form name="addcms" method="post" action="" accept-charset="utf-8">
           
          <fieldset>
            <ul class="frm">
              <li>
                <div>
                  <label>Subject<span>*</span> :</label>
                  <input size="50" class="inputtext" type="text" id="subject" name="subject" value="<?php echo set_value('subject');?>">
                  <?php echo form_error('subject'); ?> 
                </div>
              </li>
              
              <li>
                <label>Send Test Email<span>*</span> :</label>
                <input name="send_test_email" type="radio" value="Yes" checked="checked" />Yes
                <input name="send_test_email" type="radio" value="No" <?php if(isset($_POST['send_test_email']) && $_POST['send_test_email'] == 'No'){ echo 'checked="checked"';}?> />No
              </li>
             <li>
                  <label>Visible<span>*</span> :</label>
                  <input name="is_display" type="radio" value="1" checked="checked" />Yes
                  <input name="is_display" type="radio" value="0" <?php if(isset($_POST['is_display']) && $_POST['is_display'] == '0'){ echo 'checked="checked"';}?> />No
            </li>
             
              <li class="txtar">
                <label>Message<span>*</span> :</label>
                <?php
            $content_data = '';
            if($this->input->post('message')){$content_data=$this->input->post('message');}
            echo form_fckeditor('message',html_entity_decode($content_data));
          ?>
                <?=form_error('message')?>
              </li>

            </ul>
          </fieldset>
            
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

