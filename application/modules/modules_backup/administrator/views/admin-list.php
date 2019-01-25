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
      <div  class="confrmmsg">
        <p><?php echo $this->session->flashdata('message'); ?></p>
      </div>
      <?php endif; ?>
      <?php if($admins): ?>
      <?php echo form_open(ADMIN_DASHBOARD_PATH.'/administrator/actions',array('id' => 'debtorActionsForm')); ?>
      <div class="box_block">
        <div class="title_h3 title_list">
          <ul>
            <li>
              <input name="item_all" id="item_all" type="checkbox" value="Y">
            </li>
            <li class="ref"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/index'); ?>"><span>Refresh</span></a></li>
            <li class="seln">
              <div>
                <select name="more_actions">
                  <option value="">More Actions...</option>
                  <option value="make_active">Activate</option>
                  <option value="make_disable">Disable</option>
                </select>
                <button name="action_button" value="go" class="go">Go</button>
                <input type="hidden" name="current_status" value="" />
              </div>
            </li>
          </ul>
          <div class="pagmail"> </div>
        </div>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
          <thead>
            <tr>
              <th width="5%">&nbsp;</th>
              <th width="15%">Username</th>
              <th width="15">Role</th>
              <th width="20%">Email</th>
              <th width="10%">Admin Status</th>
              <th width="10%">Online Status</th>
              <th width="25%" class="optn"> Operations </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($admins as $item): ?>
            <tr>
              <td><input name="auction_select[]" type="checkbox" value="<?php echo $item->id; ?>" class="item_row"></td>
              <td ><?php echo $item->username; ?></td>
              <td ><?php if ($item->user_type == '1') {echo "Superadmin";} else if($item->user_type =='2') {echo "Admin";} ?></td>
              <td ><?php echo $item->email;?></td>
              <td ><?php if ($item->status == '1') {echo "Active";} else if($item->status =='2') {echo "Inactive";} ?></td>
              <td ><?php if ($item->is_login == '0') {echo "Offline";} else if($item->is_login =='1') {echo "Online";} ?></td>
              <td class="optn"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/view/'.$item->username.'/'.$item->id); ?>" class="setting view"><span>View</span></a></td>
                    <td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/edit/'.$item->username.'/'.$item->id); ?>" class="setting edit"><span>Edit</span></a></td>
                    <td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/delete/'.$item->username.'/'.$item->id); ?>" class="setting del" onclick="return ConfirmDelete('Administrator');"><span>Delete</span></a></td>
                  </tr>
                </table></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if($pagination_links):?>
        <div class="pagination"> <?php echo $pagination_links; ?> </div>
        <?php endif; ?>
      </div>
      <?php echo form_close(); ?>
      <?php else:?>
      <div class="confrmmsg">
        <p>:( No any debtors</p>
      </div>
      <?php endif; ?>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>

<script>
$('#item_all').click(function(){
	$('.item_row').prop("checked",$('#item_all').prop("checked"))
});
</script>
