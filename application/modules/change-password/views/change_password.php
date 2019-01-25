<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Change Password </h2>
  </div>
</section>

<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php // $this->load->view('menu/website'); ?>
    </aside>
    <section class="smfull">
      <div class="confrmmsg">
        <?php
        	if($this->session->flashdata('message'))
			{
				echo "<p>".$this->session->flashdata('message')."</p>";
			}
		?>
      </div>
      <div class="box_block">
        <form name="changePasswordForm" method="post" action="" id="changePasswordForm">
          <fieldset>
            <div class="title_h3">Change Admin Password</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Old Password<span>*</span> :</label>
                  <input name="old_password" type="password" id="old_password" value="<?php echo set_value('old_password');?>" size=30>
                  <?=form_error('old_password')?>
                </div>
              </li>
              
              <li>
                <div>
                  <label>New Password<span>*</span> :</label>
                  <input name="new_password" type="password" id="new_password" value="<?php echo set_value('new_password');?>" size=30>
                  <?=form_error('new_password')?>
                </div>
              </li>
              
              <li>
                <div>
                  <label>Confirm Password <span>*</span> :</label>
                  <input name="re_password" type="password" id="re_password" value="<?php echo set_value('re_password');?>" size=30>
                  <?=form_error('re_password')?>
                </div>
              </li>
            </ul>
          </fieldset>
          <fieldset class="btn">
            <input class="butn" type="submit" name="Submit" value="Change Password" />
          </fieldset>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
