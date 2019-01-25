<section class="title">
  <div class="wrap">
    <h2>Settings &raquo; Audit Trial</h2>
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
          <div class="title_h3">Admins Activity Log Detail <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/index'); ?>" class="edit"><span></span></a> </div>
          <ul class="frm">
            <li>
              <div>
                <label>Date</label>
                <span class="default_txt"><?php echo $item_default['log_time']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>User Type</label>
                <span class="default_txt"><?php echo $item_default['log_user_type']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Username</label>
                <span class="default_txt"><?php   echo $this->log_model->get_member_username($item_default['log_user_id']); ?>
                </span> </div>
            </li>
            <li>
              <div>
                <label>Module Name</label>
                <span class="default_txt"><?php echo $item_default['module_name']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Description</label>
                <span class="default_txt"><?php echo $item_default['module_desc']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Action</label>
                <span class="default_txt"><?php echo $item_default['log_action']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>IP</label>
                <span class="default_txt"><?php echo $item_default['log_ip']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Browser</label>
                <span class="default_txt"><?php echo $item_default['log_browser']; ?></span> </div>
            </li>
            <li>
              <div>
                <label>Platform</label>
                <span class="default_txt"><?php echo $item_default['log_platform']; ?></span> </div>
            </li>
            <li  class="txtar">
              <div>
                <label>Agent Detail</label>
                <span class="default_txt"><?php echo $item_default['log_agent']; ?></span> </div>
            </li>
            <li  class="txtar">
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
