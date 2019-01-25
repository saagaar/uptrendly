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
                            <th width="10%">Invoice</th>
                            <th width="20%">Name</th>
                            <th width="15%">Txn Type</th>
                            <th width="10%">Amount/Free Credit</th>
                            <th width="10%">Credits </th>
                            <th width="10%">Debit/Credit </th>	
                            <th width="20%">Date</th>
                            <th width="10%" class="optn"> Status </th>
                        </tr>
                    </thead>
    				<tbody>
					  <?php 
                    //$sn_count=0;
                    if($transaction_data)
                    {
                        foreach($transaction_data as $value)
                        {				
                          // print_r($this
						?>          
              <tr>
                            <td><?php echo $value->invoice_id; ?></td>
                            <td><?php echo $value->transaction_name; ?></td>
                            <td><?php echo $value->transaction_type; ?></td>
                            <td><?php if($value->transaction_type=='added_by_admin') echo  round($value->amount,1) .'(Free Credit)'; else echo $value->amount.' '. DEFAULT_CURRENCY_SIGN;?></td>
					               		<td><?php echo $value->credit_get; ?></td>	
                            <td><?php echo $value->credit_debit; ?></td>
                           	<td><?php echo $value->transaction_date; ?></td>
                           	<td><?php echo $value->transaction_status; ?></td>
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
