<section class="title">
  <div class="wrap">
     <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Admins  Management </h2>
  </div>
</section>

<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    <section class="smfull">
      <div class="box_block">
        <fieldset>
          <div class="title_h3">Administrator Login</div>
          <ul class="frm">
            <li>
              <div>
                <label>Username  : </label>
                <span class="default_txt"><?php echo $admin_default['username']; ?></span> </div>
            </li>
            
            <li>
              <label>Email  : </label>
              <span class="default_txt"><?php echo $admin_default['email']; ?></span>
           </li>
           
            <li>
              <label>Select Role  :</label>
              <span class="default_txt"><?php if ($admin_default['user_type'] == '1') {echo "Superadmin";} else if($admin_default['user_type'] =='2') {echo "Admin";} ?></span> </li>
            <li>
              <label>Status  : </label>
              <span class="default_txt"><?php if ($admin_default['is_login'] == '0') {echo "Offline";} else if($admin_default['is_login'] =='1') {echo "Online";} ?></span> </li>
          </ul>
        </fieldset>
        <fieldset>
          <div class="title_h3">Extra Information</div>
          <ul class="frm">
            <li>
              <label>Registered Date  : </label>
              <span class="default_txt"><?php echo $admin_default['reg_date'];?></span> </li>
            <li>
              <label>Registered IP Address  : </label>
              <span class="default_txt"><?php echo $admin_default['reg_ip'];?></span> </li>
            <li>
              <label>Last Login Date  : </label>
              <span class="default_txt"><?php echo $admin_default['last_login_date'];?></span> </li>
            <li>
              <label>Last Login IP Address  : </label>
              <span class="default_txt"><?php echo $admin_default['last_login_ip'];?></span> </li>
          </ul>
        </fieldset>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
