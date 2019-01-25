<script type="text/javascript" src="<?php echo site_url(JQUERYUI_PATH.'jquery-ui.min.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().JQUERYUI_PATH.'jquery-ui.min.css'; ?>">

<section class="title">
<div class="wrap">
  <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Product Form Fields</h2>
</div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    
    <section class="smfull">
    	<?php if (isset($category_id) && $category_id!=''){ ?>
          <form action="" method="post">
            <input type="hidden" name="category_id" id="hiddenCatField" value="<?php echo $category_id; ?>" />
            <div class="ddmenu"> <a id="chooseCategory" href="javascript:void(0)" class="main_btn">
              <?php if(isset($_POST['categoryName']) && $_POST['categoryName']!=''){echo $_POST['categoryName'];}else{echo $category_name;}; ?>
              </a>
              <ul>
                <?php
                if($category_tree){
                    foreach($category_tree as $category)
                    {
                        ?>
                        <li <?php if($category['subcat']==''){ ?> onclick="addThis('<?php echo $category['name']; ?>','<?php echo $category['id']; ?>','0')" <?php } else { ?>class="dropdown-submenu"<?php }?>> <a href="javascript:void(0)" tabindex="-1"><?php echo $category['name']; ?></a>
                            <?php if($category['subcat']!=''){ ?>
                            <ul class="dropdown-menu" >
                                <?php foreach($category['subcat'] as $subcat){?>
                                <li onclick="addThis('<?php echo $subcat['name']; ?>','<?php echo $category['id']; ?>','<?php echo $subcat['id']; ?>')"> <a href="javascript:void(0)" data-clickable="data-clickable" tabindex="-1"> <?php echo $subcat['name']; ?> </a> </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php
                    }
                }
                ?>
              </ul>
            </div>
          </form>
    	<?php } ?>
      <?php if($this->session->flashdata('message')){?>
      <div id="displayErrorMessage" class="confrmmsg">
        <p><?php echo $this->session->flashdata('message'); ?></p>
      </div>
      <?php } ?>
      <div class="box_block">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
          <thead>
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="50%">Field Name</th>
              <th width="25%">Field Type</th>
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
              <td><span class="handle">&nbsp;</span></td>
              <td><?php echo $value->name; ?></td>
              <td><?php echo $value->type; ?></td>
              <td class="optn">
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <?php if($value->form_field_type=='custom'){ ?>
                    <td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/edit_custom_field/<?php echo $value->id;?>" style="margin-right:5px;" title="click to edit this field"><span>Edit</span></a></td>
                    <?php }else if($value->form_field_type=='basic'){ ?>
                    	<td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/edit_basic_field/<?php echo $value->id;?>" style="margin-right:5px;" title="click to edit this field"><span>Edit</span></a></td>
					<?php } ?>
                    
                    <td width="33"><a  href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/custom-fields/delete/<?php echo $value->id;?>/<?php echo $value->form_field_type;?>" onClick="return ConfirmDelete('field');" title="click to delete this field"><span>Delete</span></a></td>
                  </tr>
                </table>
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
                  <p>No <?php echo $current_menu=='view_basic_fields'?'Basic':'Custom'; ?> field found</p>
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