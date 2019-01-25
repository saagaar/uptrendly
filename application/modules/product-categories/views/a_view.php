<script type="text/javascript">
function doconfirm()
{
	job=confirm("Are you sure to delete permanently?");
	if(job!=true)
	{
		return false;
	}
}
</script>

<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Product Category</h2>
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
        <th width="1%">&nbsp;</th>
        <th width="25%">Category Name</th>
       	<th width="20%">Short Description </th>
       	<th width="10%">List in menu</th>
        <th width="10%">Display</th>
        <th width="17%" class="optn">Category Operation</th>
       <!--  <th width="18%" class="optn">Sub-categories Operation</th -->
      </tr>
    </thead>
    
    <tbody>
      <?php
		if($cat_data)
   		{	
   			foreach($cat_data as $value)
   			{ 
 			?>
        		<tr>
                    <td>&nbsp;</td>
                    <td><?php echo $value->name; ?></td>
                    <td><?php echo $value->short_desc; ?></td>
                    <td><?php if($value->display_menu=='Yes') {echo "Yes"; } else echo "No"; ?></td>
                    <td><?php if($value->is_display=='1') {echo "Yes"; } else echo "No"; ?></td>
                    <td class="optn">
              					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  					<tr>
                    					<td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product-categories/edit_category/<?php echo $value->id;?>" style="margin-right:5px;" title="click to edit this category"><span>Edit</span></a></td>
                    					<td width="33"><a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product-categories/delete_category/<?php echo $value->id;?>" onClick="return doconfirm();" title="click to delete this category"><span>Delete</span></a></td>
                  					</tr>
                				</table>
      				      </td>
                            
                    <!-- <td class="optn">
      					<table width="100%" border="0" cellspacing="0" cellpadding="0">
          					<tr>
                                <td width="33"><a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product-categories/view_subcategory/<?php echo $value->id;?>" title="click to view subcategories in this category"><span>View</span></a></td>
                                 <?php // if($value->is_display=='1'): ?>
                                 <td width="33"><a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product-categories/add_sub_category/<?php echo $value->id;?>" title="click to add subcategory for this category"><span>Add</span></a></td>
                                 <?php // endif; ?>
          					</tr>
        				</table>
      				</td> -->
                    
    			</tr>
    		<?php 
			}
		}
		else
		{
		?>
		<tr>
			<td colspan="8">
				<div class="confrmmsg">
					<p>No Category found</p>
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
