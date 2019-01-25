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
      <?php if($this->session->flashdata('message')):?>
      <div class="confrmmsg"><p><?php echo $this->session->flashdata('message'); ?></p></div>
      <?php endif; ?>
      <?php if($logitems): ?>
      <div class="box_block">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
          <thead>
            <tr>
              <th width="2%">#</th>
              <th width="15%">Date</th>
              <th width="10%">Admin Type</th>
              <th width="7%">User Id</th>
              <th width="13%">Username</th>
              <th width="15%">Module</th>
              <th width="20%">Description</th>
              <th width="10%">IP</th>
              <th width="5%">Action</th>
              <th width="5" class="optn">Operations</th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$sn_count=$offset;
				foreach($logitems as $item): ?>
                <tr>
                  <td><?php echo ++$sn_count;?></td>
                  <td><?php echo $item['log_time']; ?></td>
                  <td><?php echo ($item['log_user_type']=='1'?"Super Admin":"Admin"); ?></td>
                  <td><?php echo $item['log_user_id']; ?></td>
                  <td><?php echo $this->log_model->get_member_username($item['log_user_id']); ?></td>
                  <td><?php echo $item['module_name'];?></td>
                  <td><?php echo $item['module_desc'];?></td>
                  <td><?php echo $item['log_ip'];?></td>
                  <td><?php echo $item['log_action'];?></td>
                  <td class="optn"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-logs/site_log_detail/'.$item['log_id']); ?>" class="setting view"><span>View</span></a></td>
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
      <?php else:?>
      <div class="confrmmsg">
        <p> No Records</p>
      </div>
      <?php endif; ?>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
