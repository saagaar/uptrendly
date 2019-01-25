<script type="text/javascript">
$(document).ready(function() { 
    // call the tablesorter plugin 
    $("table").tablesorter({ 
        // sort on the first second third fourth and fifth column, order asc 
        //sortList: [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0]],
		//  sortList: [[1,0]],
		// sortInitialOrder : 'asc'
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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Reawrds Management</h2>
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
            	<form name="search_rewards" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            		<fieldset>
                    <ul class="frm">
                      <li style="width:30%">
                        <div>
                          <input type="text" name="srch" class="inputtext" size=45 placeholder="Enter Rewards Title or Rewards points" value="<?php if($this->input->post('srch',TRUE)){echo $this->input->post('srch',TRUE);} ?>">
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
                            <th width="5%">P. Id</th>
                             <th width="15%"> Title </th>
                            <th width="15%"> Description</th>
                            <th width="10%">Required Points</th>
                            <th width="17%">Is display</th>
                            <th width="13%" class="optn"> Operations </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=1;
                    if($rewards_list)
                    {
                        foreach($rewards_list as $value)
                        {
                         ?>
                          <tr>
                           <td><?php echo $sn_count;?></td>
                           <td><?php echo $this->general->string_limit($value->title,20); ?></td>
                           <td><?php echo $this->general->string_limit($value->description,50); ?></td>
                           <td><?php echo $value->points; ?></td>                            
                         
                            <td><?php if($value->is_display=='1') {echo "Yes";} else echo "No"; ;?></td>
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/rewards/add_rewards/<?php echo $value->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                        
                                        <td>
                                            <a  style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/rewards/delete_rewards/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Delete</span></a>
                                        </td>
                                        
                                       
                                            <td>
                                          
                                        </td>
					                   				</tr>
                                </table>
                            </td>
                          </tr>
                       <?php 
                       $sn_count++;
                       } }else{ ?>
                        <tr>
                        	<td colspan="7"><div class="confrmmsg"><p>No Product found.</p></div></td>
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
