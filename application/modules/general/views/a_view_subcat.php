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
    <div class="cat_title">Category name: <?php echo $catname; ?></div>
     
	<div class="box_block">
   	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
    <thead>
      <tr>
        <th width="15%">Subcategory Name</th>
        <th width="15%">Short Description </th>
        <th width="10%">List in menu</th>
        <th width="10%">Display</th>
        <th width="15%" class="optn">Operation</th>
      </tr>
    </thead>
    
    <tbody>
      <?php
		if($subcat_data)
   		{	
   			foreach($subcat_data as $value)
   			{ 
 			?>
        		<tr>
                    <td><?php echo $value->name; ?></td>
                    <td><?php echo $value->short_desc; ?></td>
                    <td><?php echo $value->display_menu; ?></td>
                    <td><?php if($value->is_display=='1') {echo "Yes"; } else echo "No"; ?></td>
                    <td class="optn">
      					<table width="100%" border="0" cellspacing="0" cellpadding="0">
          					<tr>
            					<td width="10"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product-categories/edit_sub_category/<?php echo $value->id;?>" style="margin-right:5px;"><span>Edit</span></a></td>
            					<td width="33"><a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product-categories/delete_category/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Delete</span></a></td>
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
			<td colspan="8">
				<div class="confrmmsg">
					<p>No Subcategory found</p>
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
