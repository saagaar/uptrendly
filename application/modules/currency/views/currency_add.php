<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Currency  Management</h2>
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
        <div class="title_h3">Add Currency</div>
        <form name="addcms" method="post" action="" accept-charset="utf-8">
          <fieldset>
            <ul class="frm">              
              <li>
                <div>
                  <label>Currency Code:</label>
                  <input size="50" class="inputtext" type="text" id="currency_code" name="currency_code" value="<?php echo set_value('currency_code');?>" />
                  <?php echo form_error('currency_code'); ?> 

                </div>
              </li>
              <li>
                <div>
                  <label>Currency Sign:</label>
                  <input size="50" class="inputtext" type="text" id="currency_sign" name="currency_sign" value="<?php echo set_value('currency_sign');?>" />
                  <?php echo form_error('currency_sign'); ?> 

                </div>
              </li>
             <li>
                <label>Visible<span>*</span> :</label>
                <input name="is_display" type="radio" value="1" checked="checked" />Yes
                <input name="is_display" type="radio" value="0" <?php if(isset($_POST['is_dispaly']) && $_POST['is_display'] == '0'){ echo 'checked="checked"';}?> />No
                <?php echo form_error('is_display'); ?> 
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



