

<!--for jquery table sorter-->
<script>
// $(document).ready(function() { 
//     // call the tablesorter plugin 
//     $("table").tablesorter({ 
//         // sort on the first second third fourth and fifth column, order asc 
//         //sortList: [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0]],
//      sortList: [[0,1]],
//     sortInitialOrder : 'desc'
//     }); 
// }); 

function doconfirm()
{
  job=confirm("Are you sure to delete permanently?");
  if(job!=true)
  {
    return false;
  }
}

function checkAll() {
  for (var i = 0; i < document.forms[0].elements.length; i++) {
    var e = document.forms[0].elements[i];
    if ((e.name != 'allbox') && (e.type == 'checkbox')) {
      e.checked = document.forms[0].allbox.checked;
    }
  }
}

function checkfill() {
  var count = 0;
  if (document.frm.newsl_id.value == '') {
    alert('Please Select the newsletter');
    document.frm.newsl_id.focus();
    return false;
  }
}
</script>

<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Newsletter Management </h2>
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

      <form name="search_member" method="post" enctype="multipart/form-data" accept-charset="utf-8" action="">
        <div class="box_block">              
            <fieldset>
                <ul class="frm">
                  <li style="width:20%">
                    <div>
                      <input type="radio" name="send_to" value="all_members" <?php if(set_value('send_to')=='all_members'){echo "checked='checked'";} ?>/>Send to all members
                    </div>

                  </li>
                  <li style="width:20%">
                    <div>
                      <input type="radio" name="send_to" value="all_buyers" <?php if(set_value('send_to')=='all_buyers'){echo "checked='checked'";} ?>/>Send to all buyers
                    </div>                        
                  </li>
                  <li style="width:20%">
                    <div>
                      <input type="radio" name="send_to" value="all_suppliers" <?php if(set_value('send_to')=='all_suppliers'){echo "checked='checked'";} ?>/>Send to all sellers
                    </div>                        
                  </li>
                  <li style="width:20%">
                    <div>
                      <input type="radio" name="send_to" value="selected_members" <?php if(set_value('send_to')=='selected_members'){echo "checked='checked'";} ?>/>Send to selected members
                    </div>                        
                  </li>
                  <?php echo form_error('send_to'); ?>
              </ul>                  
          </fieldset>             
        </div>   
        <div class="box_block">              
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
               
        </div>            
        <div class="box_block">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablesorter tbl_list tbl_full">
              <thead>
                          <tr>
                            <th width="5%">S.no</th>
                            <th width="13%" >                            
                                <input type="checkbox" value="on" name="allbox" onClick="checkAll();"/>
                                <b>All</b>                             
                            </th>
                            <th width="20%">Username</th>
                            <th width="20%">Email</th>
                            <th width="20%">User Type</th>
                          </tr>
                      </thead>
              <tbody>
              <?php
              $count = 1;
              if($offset)
              {
                $count = $offset+1;
              }
              if($member_infos) {
                foreach($member_infos as $rows) {
                ?>
                      <tr>
                          <td align="center"><?php echo $count; ?></td>
                          <td align="left"><input type="checkbox" name="member[]" value="<?=$rows['id'];?>" /></td>
                          <td align="center"><div align="left"><?php echo $rows['username'];?></div></td>
                          <td align="center"><div align="left"><?=$rows['email'];?></div></td>
                          <td align="center"><div align="left">
                            <?php 
                            switch ($rows['user_type']) {
                              case '1':
                                 echo 'Super Admin';
                                break;
                              case '2':
                                 echo 'Admin';
                                break;
                              case '3':
                                 echo 'Buyer';
                                break;
                              case '4':
                                 echo 'Supplier';
                                break;
                              default:
                                break;
                            }
                            ?>
                          </div></td>
                      
                      </tr>
                    <?php
                  $count++;
              } 
              if($this->pagination->create_links())
              {
              ?>
                <tr>
                  <td colspan="7" align="center" class="paging"><?php echo $this->pagination->create_links();?></td>
                </tr>
                <?php
              }?>
              <tr><td colspan="5"><?php echo form_error('member[]') ?></td></tr>
            <?php
            }
            ?>

              </tbody>
            </table>
          </div>
              <fieldset>
                <ul class="frm">
                  <li style="width:30%">
                    <div>
                      <?php
            $temp_arr = array();
            $temp_arr[''] = 'Select News Letter Template';
            if(count($newsletter_info)>0) {
                
                foreach($newsletter_info as $rows){
                    $temp_arr[$rows['id']] = $rows['subject'];
                }
            }
            echo form_dropdown('news_id',$temp_arr, $this->input->post('news_id',TRUE));
            echo form_error('news_id');
        ?>
                    </div>
                  </li>
                  
                  <li style="display:block;"><div><input name="sendmail" type="submit" value="Send News Letter" class="butn"></div></li>
                  <!-- <li><div><input type="submit" name="submit"  value="search" class="butn"></div></li> -->
              </ul>
            </fieldset>
        </form>       
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> 
</div>

