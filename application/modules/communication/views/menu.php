<ul>
	<li <?php if($current_menu == 'compose'){ echo 'class="active"';}?>>
		<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/compose');?>"><span>Compose mail</span></a>
	</li>

	<li <?php if($current_menu == 'inbox'){ echo 'class="active"';}?>>
		<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/inbox');?>"><span>Inbox</span></a>
	</li>
	
    <li <?php if($current_menu == 'outbox'){ echo 'class="active"';}?>>
		<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/sent');?>"><span>Outbox</span></a>
	</li>

	<?php /*?><li <?php if($current_menu == 'trash'){ echo 'class="active"';}?>>
		<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/trash');?>"><span>Trash</span></a>
	</li><?php */?>
</ul>