<section class="title">
  <div class="wrap">
    <h2>Settings &raquo; Invalid Login</h2>
  </div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
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
      <div class="box_block">
        <fieldset>
          <div class="title_h3">Invalid Login Detail <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/invalid_login'); ?>" class="edit"><span></span></a> </div>
          <ul class="frm">
            <li>
              <div>
                <label>Date</label>
                <span class="default_txt"><?php echo $item_default['log_time']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Module</label>
                <span class="default_txt"><?php echo $item_default['log_module']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Username</label>
                <span class="default_txt"><?php echo $item_default['log_username']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Password</label>
                <span class="default_txt"><?php echo $this->encrypt->decode($item_default['log_password'],'kks'); ?></span> </div>
            </li>
            <li>
              <div>
                <label>IP</label>
                <span class="default_txt"><?php echo $item_default['log_ip']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Platform</label>
                <span class="default_txt"><?php echo $item_default['log_platform']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Browser</label>
                <span class="default_txt"><?php echo $item_default['log_browser']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Agent Detail</label>
                <span class="default_txt"><?php echo $item_default['log_agent']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Description</label>
                <span class="default_txt"><?php echo $item_default['log_desc']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Extra Information</label>
                <span class="default_txt"><?php echo $item_default['log_extra_info']; ?></span> </div>
            </li>
            <li class="txtar">
              <div>
                <label>URL</label>
                <span class="default_txt"><?php echo $item_default['log_referrer']; ?></span> </div>
            </li>
          </ul>
        </fieldset>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
