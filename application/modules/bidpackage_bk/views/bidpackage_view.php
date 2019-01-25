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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Bidpackage  Management</h2>
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
                          <th width="25%">Member Type</th>
                          <th width="20%">Bidpackage Name </th>
                          <th width="15%">Bid Credits</th>
                          <th width="15%">Bidpacakge Cost</th>
                          <th width="15%">Last Update</th>
                          <th width="5%">Visible</th>
                          <th class="optn"> Operations </th>
                        </tr>
                    </thead>
            <tbody>
          <?php 
                    $sn_count=0;
                    if($bp_data)
                    {
                        foreach($bp_data as $bidpackage)
                        { ?>
                          <tr>
                            <td>
                              <?php 
                                if( $bidpackage->member_type == 1 )
                                  echo 'Buyer';
                                else if ( $bidpackage->member_type == 2 )
                                  echo 'Supplier'; 
                              ?>
                            </td>
                            <td><?php echo $bidpackage->name; ?></td>
                            <td><?php echo ($bidpackage->credits === '0') ? 'Unlimited' : $bidpackage->credits; ?></td>
                            <td><?php echo $bidpackage->amount; ?></td>
                            <td><?php echo $bidpackage->last_update; ?></td>
                            <td><?php echo $bidpackage->display; ?></td>
                            
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/bidpackage/edit/<?php echo $bidpackage->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/bidpackage/delete/<?php echo $bidpackage->id;?>"  style="margin-right:5px;"  onClick="return doconfirm();" ><span>Delete</span></a>
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
