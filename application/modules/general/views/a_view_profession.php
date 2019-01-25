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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Profession</h2>
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
         <th width="1%">Sn</th>
        <th width="25%">Category Name</th>
        <th width="10%">Display</th> 
        <th width="17%" class="optn"> Operation</th>
      </tr>
    </thead>
    
    <tbody>
      <?php
		if($profession)
   		{	
        $i=1;
   			foreach($profession as $value)
   			{ 
 			?>
        		<tr>
                    <td>&nbsp;</td>
                    <td><?php echo $i;?></td>
                    <td><?php echo $value->profession; ?></td>
                  
                    <td><?php if($value->status=='1') {echo "Yes"; } else echo "No"; ?></td>
                   
                    <td class="optn">
              					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  					<tr>
                    					<td width="33"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/general/add_profession/<?php echo $value->id;?>" style="margin-right:5px;" title="click to edit this profession"><span>Edit</span></a></td>
                    					<td width="33"><a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/general/delete_profession/<?php echo $value->id;?>" onClick="return doconfirm();" title="click to delete this Profession"><span>Delete</span></a></td>
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
        $i++;
			}
		}
		else
		{
		?>
		<tr>
			<td colspan="8">
				<div class="confrmmsg">
					<p>No Profession found</p>
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
