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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Help Management</h2>
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
                            <th width="15%">IP Address</th>
                            <th width="35%">Message </th>
                            <th width="18%">Added Date</th>
                            <th width="18%">Updated Date</th>
                            <th width="10%" class="optn">Operations</th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                    if($ip_data)
                    {
                        foreach($ip_data as $value)
                        { ?>
                          <tr>
                            <td><?php echo $value->ip_address;?></td>
                            <td><?php echo $value->message;?></td>
                            <td><?php echo $this->general->long_date_time_format($value->added_date);?></td>
                            <td><?php if($value->last_update!='0000-00-00 00:00:00'){echo $this->general->long_date_time_format($value->last_update);} else echo "Not Updated Yet";?></td>
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/block-ip/edit_ip/<?php echo $value->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                        
                                        <td width="33">
                                            <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/block-ip/delete_ip/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Delete</span></a>
                                        </td>
                                       
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
