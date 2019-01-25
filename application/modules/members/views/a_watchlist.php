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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Members Management </h2>
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
                        	<th width="20%">Product Id</th>
                            <th width="20%">Product Name</th>
                            <th width="20%">Seller Id</th>
                            <th width="20%">Seller Name</th>
                            <th width="15%">Watched Date</th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    //$sn_count=0;
                    if($transaction_data)
                    {
                        foreach($transaction_data as $value)
                        {				
						?>
                          <tr>
                            <td><?php echo $value->product_id; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->seller_id; ?></td>
                            <td><?php echo $value->memname; ?></td>
                           	<td><?php echo $value->watch_date; ?></td>
                          </tr>
                        <?php 
                        }
                    }
                    ?>
                </tbody>
  				</table>
  			</div>
             <?php if ($links) { echo "<ul class='pagination'>".$links."</ul>"; } ?>
		</section>
  		<div class="clearfix"></div>
	</div>
</article>
<div> </div>
