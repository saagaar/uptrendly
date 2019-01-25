  <!--for jquery table sorter-->
<script>
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
            	<form name="search_member" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            		<fieldset>
                    <ul class="frm">
                      <li style="width:30%">
                        <div>
                          <input type="text" name="srch" class="inputtext" size=45 placeholder="Enter name or email" value="<?php if($this->input->post('srch',TRUE)){echo $this->input->post('srch',TRUE);} ?>">
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
                        	<th width="20%">Name</th>
                            <th width="20%">Email</th>
                           	<th width="10%">User Type</th>
                            <th width="5%">Status </th>
                            <th width="20%">Reg Date</th>
                          <?php if($usertype=='influencer'):?>
                            <th width="20%">Media list</th>
                            <th width="20%">Facebook Profile</th>
                            <th width="20%">Instagram Username</th>
                          <?php endif;?>
                           	<th width="10%" class="optn"> Operations </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php

					if($member_data)
                    {
                        foreach($member_data as $value)
                        {
							?>
                          <tr>
                          	<td><?php
                                 if($value->user_type == '3')
                                {
                                  echo 'A'; 
                                }
                                elseif($value->user_type == '4')
                                  
                                  echo 'I';
                             echo $value->id; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->email; ?></td>
                           
                            <td>
                              <?php 
                                if($value->user_type == '3')
                                {
                                  echo 'Advertiser'; 
                                }
                                elseif($value->user_type == '4')

                                  echo 'Influencer';
                              ?>
                            </td>
                         	  
                            <td><?php if ($value->status == '1') {echo "Active";} else if($value->status == '2') { echo "Inactive";} else if ($value->status == '3') {echo "Suspended";} else echo "Closed"; ?> </td>
                           
                            <td><?php echo $this->general->long_date_time_format($value->reg_date); ?></td>
                             <?php if($usertype=='influencer'):?>
                           	 <td>
                              <?php 
                                $socialmedia=$this->general->get_member_media($value->id);
                               if(count($socialmedia)>0){
                 
                                if(in_array('facebook',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn facebook ">
                                     <i class="fa fa-facebook-f"></i>
                                </span>
                              <?php
                                }
                               if(in_array('twitter',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn twitter">
                                     <i class="fa fa-twitter-square"></i>
                                </span>
                              <?php
                                }
                                if(in_array('instagram',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn instagram">
                                     <i class="fa fa-instagram"></i>
                                </span>
                              <?php
                                }
                               if(in_array('youtube',$socialmedia))
                                {
                                  ?>
                                <span class="round_btn youtube">
                                     <i class="fa fa-youtube"></i>
                                </span>
                              <?php
                                }
                                if(in_array('youtulee',$socialmedia))
                                { ?>
                                  <span class=" admin_pos_fix round_btn btn-youtulee">
                                   <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="25px"> 
                                </span>
                             <?php
                                }
                                 if(in_array('tumblr',$socialmedia))
                                { ?>
                                   <span  class="round_btn  pull-right tumblr"><i class="fa fa-tumblr"></i></span>
                          <?php }
              
              }
                              ?>
                            </td>

                            <td width="20%"><?php echo $value->facebook_profile?></td>
                            <td width="20%"><?php echo $value->instagram_username?></td>
                            <?php endif;?>
                           	<td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/members/edit_member/<?php echo $value->status;?>/<?php echo $value->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                        
                                        <td width="33">
                                            <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/members/delete_member/<?php echo $value->status;?>/<?php echo $value->id;?>" onClick="return doconfirm();"><span>Delete</span></a>
                                        </td>
                                        <!--  <td width="33">
                                           <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/members/add_balance/<?php echo $value->id;?>" ><span>Add Balance
                                           </span></a>
                                                                                </td> -->
                                    </tr>
                                </table>
                            </td>
                            
                          </tr>
                        <?php } }else{ ?>
                        <tr>
                        	<td colspan="7"><div class="confrmmsg"><p>No Member found.</p></div></td>
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
