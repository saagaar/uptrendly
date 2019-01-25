<script type="text/javascript">
$(document).ready(function() { 
    // call the tablesorter plugin 
    $("table").tablesorter({ 
        // sort on the first second third fourth and fifth column, order asc 
        //sortList: [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0]],
		 sortList: [[0,1]],
		sortInitialOrder : 'desc'
    }); 
});

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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Dispute Management</h2>
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
            	<form name="search_product" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            		<fieldset>
                    <ul class="frm">
                      <li style="width:30%">
                        <div>
                          <input type="text" name="srch" class="inputtext" size=45 placeholder="Enter Reporter name,email or Offender name ,email" value="<?php if($this->input->post('srch',TRUE)){echo $this->input->post('srch',TRUE);} ?>">
                        </div>
                      </li>
                      
                      <li><div><input type="submit" name="submit"  value="search" class="butn"></div></li>
              		</ul>
          		</fieldset>
            	</form>
            </div>

			<div class="box_block">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablesorter tbl_list tbl_full">
    				<thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="15%">Reporter Name </th>
                            <th width="15%">Offender Name</th>
                            <th width="15%">Report Title </th>
                            <th width="17%">Added Date</th>
                            <th width="10%">Status</th>
                            <th width="13%" class="optn"> Operations </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                    $id=0;
                    if($dispute_data)
                    {
                        foreach($dispute_data as $value)
                        { ?>
                          <tr>
                            <td><?php echo $id;?></td>
                            <td><?php echo Ucfirst($value->reporter)?></td>
                            <td><?php echo  Ucfirst($value->offender);?></td>
                            <?php
                              $id++;
                            ?>
                            
                          
                            <td><?php echo $value->title; ?></td>
                            
                            <td><?php echo $value->report_date; ?></td>                            
                            <td><?php if($value->remarks=='Reconciled') echo 'Reconciled'; else echo 'Unreconciled';?></td>
                           
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/dispute/view_conversation/<?php echo $value->bid_id;?>/<?php echo $value->reportid;?>" style="margin-right:5px;"><span>View Conversation</span></a>
                                        </td>
                                        
                                        <td>
                                            <a  style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/delete_product/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Reconcile</span></a>
                                        </td>
                                        
                                       
                                            <td>
                                           <!--  <a  style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/view_bids/<?php echo $value->id;?>"><span>View Bids</span></a> -->
                                        </td>
									</tr>
                                </table>
                            </td>
                          </tr>
                       <?php } }else{ ?>
                        <tr>
                        	<td colspan="7"><div class="confrmmsg"><p>No Report found.</p></div></td>
                    	</tr>
                    <?php } ?>
                </tbody>
  				</table>
  			</div>
             <?php if ($links) { echo "<ul class='pagination'>".$links."</ul>"; } ?>
		</section>
  		<div class="clearfix"></div>
	</div>
</article>
<div> </div>
