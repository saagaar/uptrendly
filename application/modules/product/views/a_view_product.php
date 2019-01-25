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
function doconfirmaccept()
{
  job=confirm("Are you sure to Accept the request?");
  if(job!=true)
  {
    return false;
  }
}
function doconfirmreject()
{
  job=confirm("Are you sure to Reject the request?");
  if(job!=true)
  {
    return false;
  }
}
</script>

<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Post Management</h2>
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
                          <input type="text" name="srch" class="inputtext" size=45 placeholder="Search for seller name, seller id or Post name" value="<?php if($this->input->post('srch',TRUE)){echo $this->input->post('srch',TRUE);} ?>">
                         
                          </div>
                      </li>
                      <!-- <li> <input type="radio" name="type" <?php if($this->input->post('type')=='campaign') echo 'selected';?> value="campaign">Campaign
                          <input type="radio" name="type" value="collab"  <?php if($this->input->post('type')=='collab') echo 'selected';?>>Collab</li> -->
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
                             <!-- <th width="15%">Post Type </th> -->
                            <!-- <th width="15%">Post Category</th> -->
                           <?php /*?> <th width="15%">Product Subcategory</th><?php */?>
                            <th width="10%">Campaign Name </th>
                            <th width="10%">Brand Name</th>
                            <th width="15%">Added Date</th>
                            <th width="5%">Time Sensitive</th>
                            <th width="15%">Submission Deadline</th>
                            <th width="15%">Critical Deadline</th>
                            <th width="10%">Campaign Type</th>
                            <th width="25%" class="optn"> Operations </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                    if($product_data)
                    {
                        foreach($product_data as $value)
                        { ?>
                          <tr>
                            <td><?php echo $value->id;?></td>
                            <!-- <td><?php echo Ucfirst($value->create_type)?></td> -->
                           <!--  <td><?php echo $value->cat_name;?></td> -->
                            <?php /*?><td><?php echo $this->admin_product_model->get_category_name_by_id($value->sub_cat_id);?></td><?php */?>
                            
                            <?php /*?><td>
								<?php 
									if($value->status=='1'){ ?>
                                <a href="<?php echo site_url('buy-product/'.$value->id.'/'.$this->general->clean_url($value->name)); ?>" target="_blank"><?php echo $this->general->string_limit($value->name,20); ?></a>
                                <?php }else if($value->status=='2'){ ?>
									<a href="<?php echo site_url('live-auction/'.$value->id.'/'.$this->general->clean_url($value->name)); ?>" target="_blank"><?php echo $this->general->string_limit($value->name,20); ?></a>
								<?php }else{
									echo $this->general->string_limit($value->name,20);
								}
							?>
                          	</td><?php */?>
                            <td><?php echo $this->general->string_limit($value->name,20); ?></td>
                            
                            <td><?php echo $value->buyer_name; ?></td>                            
                            <td><?php echo $this->general->date_formate($value->post_date);?></td>
                            <td><?php  if($value->time_sensitive=='1') echo 'Yes';else echo 'No'; ?></td>    
                            <td><?php echo $this->general->date_formate($value->submission_deadline) ?></td>    
                            <td><?php     echo $this->general->date_formate($value->critical_deadline) ?></td>    
                            <td><?php echo ucfirst($value->campaign_type);?></td>
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                   <?php
                                
                                    if(($value->campaign_type!='smart' or $value->smart_status=='1' ) and  $value->status=='1' ):?>
                                        <td>
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/change_status/<?php echo $value->id;?>/2" style="margin-right:5px;" onClick="return doconfirmaccept();"><span>Accept</span></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/change_status/<?php echo $value->id;?>/4" style="margin-right:5px;color:red" onClick="return doconfirmreject();"><span>Reject</span></a>
                                        </td>
                                    <?php 
                                    endif;
                                     if($value->status=='2' && $value->completedcount==0): ?> 

                                        <td>
                                            <a  style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/delete_product/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Delete</span></a>
                                        </td>
                                       <?php endif;?> 
                                       <?php 
                                      if(($value->smart_status=='1' and $value->campaign_type=='smart' ) or $value->campaign_type!='smart'): ?>
                                       
                                         <td>
                                         <a  style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/view_product_bids/<?php echo $value->id;?>"><span>View Influencers</span></a> 
                                        </td>
                                       <?php 
                                       endif;
                                       if($value->smart_status=='0' and $value->campaign_type=='smart' ): ?> 
                                         <td>
                                         <a  style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/edit_product_front/<?php echo $value->id;?>"><span>Edit</span></a> 
                                        </td>
                                        <?php 
                                      endif;
                                        if($value->completedcount>0): ?> 
                                         <td>
                                         <a class="c_button" style="margin-left:2px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/product/view_product_bids/<?php echo $value->id;?>"><span>Completed Campaign <em><?php echo $value->completedcount?></em></span></a> 
                                        </td>
                                        <?php 
                                        endif;
                                       ?>
                                       
									</tr>
                                </table>
                            </td>
                          </tr>
                       <?php } }else{ ?>
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
