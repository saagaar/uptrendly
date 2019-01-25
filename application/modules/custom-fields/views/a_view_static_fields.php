<script type="text/javascript" src="<?php echo site_url(JQUERYUI_PATH.'jquery-ui.min.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().JQUERYUI_PATH.'jquery-ui.min.css'; ?>">

<section class="title">
<div class="wrap">
  <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; View Product Form Fields</h2>
</div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    
    <section class="smfull">
      <?php if($this->session->flashdata('message')){?>
      <div id="displayErrorMessage" class="confrmmsg">
        <p><?php echo $this->session->flashdata('message'); ?></p>
      </div>
      <?php } ?>
      <div class="box_block">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
          <thead>
            <tr>
              <th width="25%">Field Name</th>
              <th width="25%">Field Label</th>
             <?php /*?> <th width="25%">Display</th><?php */?>
              <th width="25%" class="optn">Operation</th>
            </tr>
          </thead>
          <tbody id="customFields">
            <?php
		if($field_data)
   		{	
   			foreach($field_data as $value)
   			{
 			?>
            <tr id="<?php echo $value->id; ?>">
              <td><?php echo $value->field_name; ?></td>
              <td><?php echo $value->field_label; ?></td>
              <?php /*?><td><?php echo ($value->display=='1')?'Yes':'No'; ?></td><?php */?>
              <td class="optn">
              	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/edit_static_field/<?php echo $value->id;?>" title="click to edit this field"><span>Edit</span></a>
              	</td>
            </tr>
            <?php 
			}
		}
		else
		{
		?>
            <tr>
              <td colspan="4">
              	<div class="confrmmsg">
                  <p>No Static fields found</p>
                </div>
              </td>
            </tr>
            <?php
		}
	 ?>
          </tbody>
        </table>
      </div>
    </section>
    
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
<script>
	var operation = 'view';
	var UrlFetchCustomFields = "<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/ajax_get_custom_fields";
	var UrlDragDropFieldOrder = "<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/ajax_sort_basic_fields";
	<?php if (isset($category_id) && $category_id!=''){ ?>
		var UrlDragDropFieldOrder = "<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/ajax_sort_custom_fields";
	<?php } ?>
</script> 
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin.custom.fields.js" type="text/javascript"></script>