<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Payment Gateway Management</h2>
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
                    if($this->session->flashdata('message') != ''){
                        echo '<p>'.$this->session->flashdata('message').'</p>';
                    } 
              ?>
            </div>
            <div class="box_block">
                <form name="edit_cat" method="post" action="" accept-charset="utf-8" enctype="multipart/form-data" >
                <fieldset>
                  <div class="title_h3">Paypal Payment Gateway Settings</div>
                  <ul class="frm">
                    <li>
                      <div>
                        <label>PayPal Email<span>*</span> :</label>
                        <input size="50" class="inputtext" type="email" id="email" name="email" value="<?php echo set_value('email',$payment->email);?>" />
                        <?=form_error('email')?>
                      </div>
                    </li>
                
                     <li>
                      <div>
                        <label>Payment Mode ? <span>*</span> :</label>
                        	<input type="radio" name="status" value="1" checked="checked" /> Test
      						<input type="radio" name="status" value="2" <?php if($payment->status=='2')echo 'checked';?> /> Live
                      </div>
                    </li>
                    
                     <li>
                      <div>
                        <label>Display ? <span>*</span> :</label>
                        	<input type="radio" name="is_display" value="Yes" checked="checked" /> Yes
      						<input type="radio" name="is_display" value="No" <?php if($payment->is_display=='No')echo 'checked';?> /> No
                      </div>
                    </li>
                    
                    </ul>
                </fieldset>
                
               	<fieldset>
                    <ul class="frm">
                        <li class="txthalf">
                          <div><img src='<?php echo base_url().PAYMENT_API_LOGO_PATH.$payment->payment_logo;?>'></div>
                        </li>
                    
                        <li>
                          <div>
                            <label>Payment Image <span>*</span> :</label>
                            <input name="logo" type="file" id="img" />
                            <input type="hidden" name="logo_old" value="<?php echo $payment->payment_logo; ?>" />
                          </div>
                        </li>
                    </ul>
                </fieldset>
                
                
                
                <fieldset class="btn">
                  <input type="submit" value="Submit" class="butn">
                </fieldset>
                </form>
            </div>
        </section>
    <div class="clearfix"></div>
    </div>
</article>