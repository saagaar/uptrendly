


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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Newsletter  Management</h2>
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
                <th width="5%">S.N</th>
                  <th width="30%">Subject </th>
                  <th width="20%">Update Date</th>
                  <th width="20%">Send Test Email</th>                            
                  <th width="5%">Visible</th>
                  <th class="optn"> Operations </th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $sn_count=0;
                if($newsletters)
                {
                  foreach($newsletters as $newsletter)
                  { ?>
                    <tr>
                      <td><?php echo ++$sn_count; ?></td>
                      <td><?php echo $newsletter->subject; ?></td>                           
                      <td><?php echo $newsletter->update_date; ?></td>
                      <td><?php echo $newsletter->send_test_email; ?></td>
                      <td><?php echo ($newsletter->is_display == 1) ? 'Yes' : 'No'; ?></td>                            
                      <td class="optn">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                  <td width="10">
                                      <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/newsletter/edit/<?php echo $newsletter->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                  </td>
                                  
                                  <td width="10">
                                      <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/newsletter/delete/<?php echo $newsletter->id;?>" onClick="return doconfirm();"><span>Delete</span></a>
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
