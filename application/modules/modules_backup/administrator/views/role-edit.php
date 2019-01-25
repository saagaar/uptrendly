<script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin-roles-edit.js" type="text/javascript"></script>

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
      
      <div class="box_block">
	  <?php echo form_open('',array('id' => 'adminRoleForm','autocomplete' => 'off')); ?>
        <fieldset>
          <div class="title_h3">Permissions</div>
          	<?php
				//Generate Selected Permissions for Roles
				//var_dump($selected_permissions_array);
			?>
          <div class="frm">
          
            <?php 
			if($modules):
				foreach($modules as $item):
					if(array_key_exists($item->info->permission_id, $selected_permissions_array))
					{
						$selected_checked_modules = 'checked="checked"';
					}
					else
					{
						$selected_checked_modules = '';
					}
				?>
            	<div class="title_h3 subtitle1">
              		<label  class="chklbl">
                		<input name="permission[]" <?php echo $selected_checked_modules;?>  id="<?php echo $item->info->code; ?>" type="checkbox" value="<?php echo $item->info->permission_id; ?>">
                		<?php echo $item->info->name;?>
                    </label>
            	</div>
                
            <?php 
				if($item->child):
				if( ($item->info->code == 'module-administrator') || ($item->info->code == 'module-cms') || ($item->info->code == 'module-help')  || ($item->info->code == 'module-product-category') || ($item->info->code == 'module-custom-field') || ($item->info->code == 'module-member') || ($item->info->code == 'module-product') || ($item->info->code == 'module-bidpackage') || ($item->info->code == 'module-help') || ($item->info->code == 'module-currency')  || ($item->info->code == 'module-newsletter') || ($item->info->code == 'module-how-and-why'))
				{?>
            		<div class="subbox subboxmrg">
                      <ul class="chklist">
                        <?php foreach($item->child as $lists):							
                            if(array_key_exists($lists->info->permission_id, $selected_permissions_array)){
                                $selected_checked_items = 'checked="checked"';
                            }else{
                                $selected_checked_items = '';
                            }
                            ?>
                        <li>
                          <label class="chklbl" >
                            <input name="permission[]" <?php echo $selected_checked_items;?> type="checkbox" class="<?php echo $item->info->code;?>" value="<?php echo $lists->info->permission_id; ?>"  />
                            <?php echo $lists->info->name;?> </label>
                        </li>
                        <?php endforeach;?>
                      </ul>
            		</div>
            	<?php 
			}
			else
			{?>
            <div class="subbox subboxmrg">
              <?php 
			  	foreach($item->child as $items):
					if(array_key_exists($items->info->permission_id, $selected_permissions_array)){
						$selected_checked_menu = 'checked="checked"';
					}else{
						$selected_checked_menu = '';
					}						
				?>
                
              <div class="title_h3 title_h4">
                <label  class="chklbl">
                  <input name="permission[]" <?php echo $selected_checked_menu;?> id="<?php echo $items->info->code; ?>" type="checkbox" class="<?php echo $item->info->code; ?>" value="<?php echo $items->info->permission_id; ?>">
                  <?php echo $items->info->name;?> </label>
              </div>
              
              
              
              <?php if($items->child):?>
              <ul class="chklist">
                <?php foreach($items->child as $lists):						
					if(array_key_exists($lists->info->permission_id, $selected_permissions_array)){
						$selected_checked_items = 'checked="checked"';
					}else{
						$selected_checked_items = '';
					}							
				?>
                <li>
                  <label  class="chklbl">
                    <input name="permission[]" <?php echo $selected_checked_items; ?> type="checkbox" class="<?php echo $items->info->code; ?>" value="<?php echo $lists->info->permission_id; ?>">
                    <?php echo $lists->info->name;?> </label>
                </li>
                <?php endforeach;?>
              </ul>
              
              <?php endif;?>
              <?php endforeach; ?>
            </div>
            
            <?php }?>
            <?php endif;?>
            <?php endforeach;?>
          </div>
          <?php endif;?>
        </fieldset>
        <fieldset class="btn">
          <button type="submit" class="butn">Submit</button>
          <input type="hidden" name="user_type" value="<?php echo $this->uri->segment('5'); ?>" />
        </fieldset>
        <?php echo form_close(); ?> </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
