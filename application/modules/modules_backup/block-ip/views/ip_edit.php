<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; BLock IP Management</h2>
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
        <form name="sitesetting" method="post" action="" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Add IP</div>
            <ul class="frm">
              
              
              <li>
                <div>
                  <label>IP Address<span>*</span> :</label>
                  <input class="inputtext" type="text" id="ip_address" name="ip_address" value="<?php echo set_value('ip_address',$data_ip->ip_address);?>">
                  <?=form_error('ip_address')?>
                </div>
              </li>
              
              <li>
                <label>Message<span>*</span> :</label>
                <textarea name="message" cols="50" class="inputtext" id="message"><?php echo set_value('message',$data_ip->message);?></textarea>
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
