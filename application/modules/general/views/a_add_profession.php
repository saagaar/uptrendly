<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo;Add Profession</h2>
  </div>
</section>
<?php 
if(count($profession) && is_object($profession))
{
  $status=$profession->status;
  $profession=$profession->profession;
}
else{
  $status=$this->input->post('is_display');
  $profession=$this->input->post('profession');
}
if($status=='')
{
  $status='1';
}
?>
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
                <form name="add_profession" method="post" action="" accept-charset="utf-8" enctype="multipart/form-data">
                <fieldset>
                  <div class="title_h3">Profession</div>
                  <ul class="frm">
                  	<li>
                      <div>
                        <label>Profession Name<span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" id="name" name="profession" value="<?php echo set_value('profession',$profession); ?>">
                        <?=form_error('profession')?>
                      </div>
                    </li>
                    <li>
                      <div>
                        <label>Display ? <span>*</span> :</label>
                        	<input type="radio" name="is_display"  value="1" <?php if($status=='1') echo 'checked="checked"'?> /> Yes
      						        <input type="radio" name="is_display"  value="0"  <?php if($status=='0') echo 'checked="checked"'?> /> No
                      </div>
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