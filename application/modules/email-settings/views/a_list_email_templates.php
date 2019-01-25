-<section class="title">
<div class="wrap">
  <h2><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Members Management </h2>
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
         <th width="8%">#</th>                        	
         <th width="20%">Email Subject</th>
         <th width="10%">Send Email</th>
         <?php if(SMS_NOTIFICATION==1) {?>
          <th width="10%">Send SMS</th>
          <?php } ?>
          <th width="15%">Last Update</th>
          <th width="10%" class="optn"> Operations </th>
        </tr>
      </thead>
      <tbody>
       <?php 
       $sn_count=0;
       
					//print_r($member_data);
                    //print_r($email_templates);
       if($email_templates)
       {
        foreach($email_templates as $value)
        {
         $sn_count++;
         ?>
         <tr>
           <td><?php echo $sn_count; ?></td>
           <td><?php echo $value->subject; ?></td>
           <td><?php $isemail = $value->is_email_notification_send==1?'Yes':'No'; echo $isemail;  ?></td>

           <?php if(SMS_NOTIFICATION==1){?>
            <td><?php $issms = $value->is_sms_notification_send==1?'Yes':'No'; echo $issms; ?></td>
            <?php } ?>
            
            <td><?php echo $value->last_update; ?></td>
            <td class="optn">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="10">
                    <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/email-settings/detail/<?php echo $value->email_code;?>"><span>Edit</span></a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <?php 
        }
      }
      else
      {
       ?>
       <tr>
         <td colspan="8">
           <div class="confrmmsg">
            <p>No Email Templates found</p>
          </div>
        </td>
      </tr>
      <?php }
      ?>
    </tbody>
  </table>
</div>
</section>
<div class="clearfix"></div>
</div>
</article>
<div> </div>
