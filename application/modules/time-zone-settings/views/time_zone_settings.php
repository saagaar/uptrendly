<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Time Zone Setting</h2>
  </div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    <section class="smfull">
        <div class="confrmmsg">
        <?php 
      if($this->session->flashdata('message') != '')
      {
        echo '<p>'.$this->session->flashdata('message').'</p>';
      } 
      ?>
      </div>
      <div class="box_block">
        <form name="timeZoneSettings" method="post" action="" accept-charset="utf-8" id="timeZoneSettings">
          <fieldset>
              <div class="title_h3"> Select time zone and click on button to save it.</div>
                <ul class="frm">
                    <li class="txthalf">
                      <div>
                          <label>Select Time Zone :  <span>*</span> :</label>
                          <select name="gmt_time">
    <? foreach($gmt_lists as $gmt){?>
    <option value="<?php echo $gmt['id'];?>" <?php if($gmt['status']=="on"){echo "selected";}?>>GMT<? if(strstr($gmt['gmt_time'], '-')){echo $gmt['gmt_time'];}else if($gmt['gmt_time'] == "00:00"){echo "";}else {echo $gmt['utc_time_zone'];} ?></option>
    <? }?>    
      </select>
                         
                      </div>
                  </li>
                        
                        
                        
                        
                        
                        
                    </ul>
              </fieldset>              
                <fieldset class="btn">
                <input type="submit" value="Save Time Zone" class="butn">
              </fieldset>
                
           
          </form>
            </div>
  </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>



