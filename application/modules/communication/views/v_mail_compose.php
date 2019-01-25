<div class="banner-sec container">
  <div class="col-lg-12">
    <?php //$this->load->view('common/header_section');?>
    <div class="advance_seacrh"> <?php echo $this->load->view('common/left_common_menu');?>
      <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 form_area profile_edit">
        <div class="col-lg-12 v_compose">
          <h4 class="h3"><?php echo lang('mail_write');?></h4>
          <div class="sell_step">
            <div class="row">
              <form action="" method="POST" enctype="multipart/form-data" id="send-mail-form">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label><strong><?php echo lang('subject');?></strong></label>
                  <input type="text" name="subject" class="form-control slct" value="<?php echo set_value('subject');?>">
                  <?=form_error('subject')?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label><strong><?php echo lang('mail_attach_file');?></strong></label>
                  <input type="file" class="slct" name="msg_attachments">
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12 col-xs-12">
                  <label><strong><?php echo lang('mail_description');?></strong></label>
                  <textarea name="message" class="jqte-test" cols="" rows="10"><?php echo set_value('message');?></textarea>
                  <div class="clearfix"></div>
                  <?=form_error('message')?>
                </div>
                <div class="clearfix"></div>
                <div class="btns_sec">
                  <button type="submit" class="btn pnk_btn" id="btnSendMail"><?php echo lang('send');?></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
