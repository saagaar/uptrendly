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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; CMS  Management</h2>
  </div>
</section>

<article id="bodysec" class="sep">
	<div class="wrap">
		<aside class="lftsec"><?php $this->load->view('menu'); ?></aside>
		<section class="smfull">
			<?php
				 if($this->session->flashdata('message')) 
				 {
					 ?>
						<div id="displayErrorMessage" class="confrmmsg">
  							<p><?php echo $this->session->flashdata('message'); ?></p>
						</div>
					<?php
                 }
			?>

			<div class="box_block">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
    				<thead>
                        <tr>
                        	<!-- <th width="10%">CMS Type</th> -->
                        	<th width="25%">Heading</th>
                            <th width="35%">Page Link </th>
                           	<th width="15%">Update Date</th>
                            <th width="5%">Visible</th>
                            <th class="optn"> Operations </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                    if($cms_data)
                    {
                        foreach($cms_data as $value)
                        { ?>
                          <tr>
                          	<!-- <td><?php //echo $value->cms_type; ?></td> -->
                            <td><?php echo $value->heading; ?></td>
                            <td><?php echo base_url().'page/'.$value->cms_slug; ?></td>
                           	<td><?php echo $value->last_update; ?></td>
                           	<td><?php echo $value->is_display; ?></td>                            
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/cms/edit/<?php echo $value->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                        
                                        <?php if($value->deletable=="Yes")
										{ ?>
                                        <td width="10">
                                            <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/cms/delete/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Delete</span></a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                          </tr>
                        <?php 
                        }
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
