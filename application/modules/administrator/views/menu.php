<ul>
    <li <?php if($current_menu == 'all'){ echo 'class="active"'; }?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/index'); ?>"><span>All Administrator</span></a>
  </li>
  <li <?php if($current_menu == 'add'){ echo 'class="active"'; }?>>
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/add'); ?>"><span>Add New Admin</span></a>
  </li>
  <?php if($current_menu == 'edit'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/edit/'.$admin_default['username'].'/'.$admin_default['id']); ?>"><span>Edit Administrator</span></a>
  </li>
  <?php endif; ?>
  <?php if($current_menu == 'view'):?>
    <li class="active">
        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/edit/'.$admin_default['username'].'/'.$admin_default['id']); ?>"><span>View Administrator</span></a>
  </li>
  <?php endif; ?>
    <li  <?php if($current_menu == 'roles'){ echo 'class="active"'; }?>>
    <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/roles'); ?>"><span>View All Admin Types</span></a>
    </li>
    
     <?php if($current_menu == 'editrole'):?>
        <li class="active">
            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/administrator/role/edit/'.$this->uri->segment(5)); ?>"><span>Edit Roles</span></a>
      </li>
      <?php endif; ?>
    
</ul>