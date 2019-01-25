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
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Currency  Management</h2>
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
                          <th width="10%">Currency Id</th>
                          <th width="25%">Currency Code</th>
                            <th width="20%">Currrency Sign </th>
                            <th width="15%">Last Update</th>
                            <th width="5%">Visible</th>
                            <th class="optn"> Operations </th>
                        </tr>
                    </thead>
            <tbody>
          <?php 
                    $sn_count=0;
                    if($currencies)
                    {
                        foreach($currencies as $currency)
                        { ?>
                          <tr>
                            <td><?php echo $currency->id; ?></td>
                            <td><?php echo $currency->currency_code; ?></td>
                            <td><?php echo $currency->currency_sign; ?></td>
                            <td><?php echo $currency->update_date; ?></td>
                            <td><?php echo ($currency->is_display == '1') ? 'Yes' : 'No'; ?></td>
                            
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/currency/edit/<?php echo $currency->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/currency/delete/<?php echo $currency->id;?>" style="margin-right:5px;"  onClick="return doconfirm();"><span>Delete</span></a>
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
