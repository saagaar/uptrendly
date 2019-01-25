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
      <?php if($this->session->flashdata('message')):?>
      <div id="displayErrorMessage" class="confrmmsg">
        <p><?php echo $this->session->flashdata('message'); ?></p>
      </div>
      <?php endif; ?>
    
      <div class="box_block">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
          <thead>
            <tr>
              <th width="2%">&nbsp;</th>
              <th width="25">name</th>
              <th width="45%">Description</th>
              <th width="25%" class="optn"> Operation </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Superadmin</td>
              <td>Ability to do view and change everything in the system</td>
              <td class="optn"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/role/edit/1'); ?>" class="setting edit"><span>Edit Permissions</span></a></tr>
            </tr>
            
            <tr>
              <td>2</td>
              <td >Admin</td>
              <td >Administrator can view and override all information</td>
              <td class="optn"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/role/edit/2'); ?>" class="setting edit"><span>Edit Permissions</span></a></tr>
            </tr>
            
          </tbody>
        </table>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
