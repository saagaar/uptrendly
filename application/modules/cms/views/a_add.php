<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; CMS  Management</h2>
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
        <div class="title_h3">Add CMS Page</div>
        <form name="addcms" method="post" action="" accept-charset="utf-8">
         <fieldset>
            <div id="url" class="title_h3">Link: <?php echo base_url().'/page/{cms_slug}'?></div>
            
          </fieldset>
          <fieldset>
            <ul class="frm">
              <li>
                <div>
                  <label>Heading<span>*</span> :</label>
                  <input size="50" class="inputtext" type="text" id="heading" name="heading" value="<?php echo set_value('heading');?>">
                  <?php echo form_error('heading'); ?> </div>
              </li>
              <li>
                <div>
                  <label>CMS Slug :</label>
                  <input size="50" class="inputtext" type="text" id="slug" name="slug" value="<?php echo set_value('heading');?>" />
                </div>
              </li>
              
             <li>
                  <label>Visible<span>*</span> :</label>
                  <input name="is_display" type="radio" value="Yes" checked="checked" />Yes
                  <input name="is_display" type="radio" value="No" <?php if(isset($_POST['is_display']) && $_POST['is_display'] == 'No'){ echo 'checked="checked"';}?> />No
              </li>
             
              <li class="txtar">
                <label>Content<span>*</span> :</label>
                <?php
            $content_data = '';
            if($this->input->post('content')){$content_data=$this->input->post('content');}
            echo form_fckeditor('content',$content_data);
          ?>
                <?=form_error('content')?>
              </li>
            </ul>
          </fieldset>
          <fieldset>
            <div class="title_h3">SEO Parameters</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Page Title :</label>
                  <textarea cols="60" rows="1" id="page_title" name="page_title"><?php echo set_value('page_title');?></textarea>
                  <?php echo form_error('page_title'); ?> </div>
              </li>
              <li>
                <div>
                  <label>Meta Key Words :</label>
                  <textarea cols="60" rows="2" id="meta_key" name="meta_key"><?php echo set_value('meta_key');?></textarea>
                </div>
              </li>
              <li>
                <label>Meta Description :</label>
                <textarea cols="60" rows="2" id="meta_desc" name="meta_desc"><?php echo set_value('meta_desc');?></textarea>
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


<script>
$(document).ready(function() {
  var url = "<?php echo base_url().'/page/'; ?>"
  $('#slug').on('input', function() {
      $('#url').html('Link: ' + url + $(this).val());
  });
});
</script>
