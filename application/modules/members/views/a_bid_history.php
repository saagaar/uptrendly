<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Members Management </h2>
  </div>
</section>

<article id="bodysec" class="sep">
	<div class="wrap">
		<aside class="lftsec"><?php $this->load->view('menu'); ?></aside>
		<section class="smfull">
			<div class="box_block">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
    				<thead>
                        <tr>
                            <th width="10%">Product ID</th>
                            <th width="20%">Product Name</th>
                            <th width="15%">Bid Fee</th>
                            <th width="10%">Bids Count</th>
                            <th width="10%">Credit Used </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    //$sn_count=0;
                    if($bids_data)
                    {
                        foreach($bids_data as $value)
                        {				
						?>
                          <tr>
                            <td><?php echo $value->product_id; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->bid_fee; ?></td>
                            <td><?php echo $value->hits_count; ?></td>
							<td><?php echo $value->total_credit_used; ?></td>
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
