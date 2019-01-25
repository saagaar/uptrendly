<section class="title">
  <div class="wrap">
  	<h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Members  Management </h2>
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
            if($this->session->flashdata('message')){
            echo "<p>".$this->session->flashdata('message')."</p>";
            }
        ?>
      </div>
      <div class="box_block">

        <form name="sitesetting" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
         
            <div class="title_h3">Personnel Detail</div>
            <ul class="frm">
            <fieldset>
                    <li><div> <b> Username : <?php echo $profile->username;?></b></div></li>
                    <li><div> <b> Number of Referral Points : <?php echo $profile->referral_points;?></b></div></li>
                    <!-- <li><div> <b> Membership Package : <?php echo isset($profile->membership_type)?$profile->membership_type:'N/A';?></b></div></li> -->
              
                  
                  
            </fieldset>
             <fieldset>
              <li>
                <div>
                  <label>Number of Free Referral Points:<span>*</span> :</label>
                  <input type="hidden" name="transaction_type" value="added_by_admin">
                  <input type="hidden" name="payment_method" value="free">
                  <input type="text" name="number_credit" class="inputtext" size=45 value="<?php echo set_value('number_credit');?>">
                  <?=form_error('number_credit')?>
                </div>
              </li>
              
              <li>
                <div>
                   <label>Transaction Name(Description):<span>*</span> :</label>
                  <textarea name="transaction_name" cols="34" rows="3" id="transaction_name"><?php echo set_value('transaction_name');?></textarea>
                  <?=form_error('transaction_name')?>
                </div>
              </li>
            </ul>
          </fieldset>
          
       
          
          <fieldset class="btn">
            <input class="butn" type="submit" name="Submit" value="Add" />
          </fieldset>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
