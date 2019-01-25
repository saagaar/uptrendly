<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Bidpackage  Management</h2>
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
        <div class="title_h3">Add Bidpackage</div>
        <form name="addcms" method="post" action="" accept-charset="utf-8">
          <fieldset>
            <ul class="frm">
              <li>
                <div>
                  <label>Member Type<span>*</span> :</label>

                  <select id="member_type" name="member_type">
                    <option value=""> Select Member Type</option>
                    <option value="1" <?php if($bidpackage->member_type == '1' )  { echo 'selected="selected"'; } ?>> Buyer</option>
                    <option value="2"  <?php if($bidpackage->member_type == '2' )  { echo 'selected="selected"'; } ?>> Supplier</option>
                  </select>
                  <?php echo form_error('member_type'); ?> 
                  </div>
              </li>
              <li>
                <div>
                  <label>Package Name:</label>
                  <input size="50" class="inputtext" type="text" id="name" name="name" value="<?php echo set_value('name', $bidpackage->name);?>" />
                  <?php echo form_error('name'); ?> 

                </div>
              </li>
              <li>
                <label>Bids(0 For Unlimited bids)<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="credits" name="credits" value="<?php echo set_value('credits',$bidpackage->credits);?>" placeholder="" />  
                  <?php echo form_error('credits'); ?> 
                
             </li>
             <li>
                <label>Package  Cost<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="amount" name="amount" value="<?php echo set_value('amount', $bidpackage->credits);?>" />  
                  <?php echo form_error('amount'); ?> 
                
             </li>
              <li>
                <label>Valid Upto<span>*</span> :</label>
                <div>
                  <input  type="text" id="valid_months" name="valid_months" value="<?php echo set_value('valid_months', $bidpackage->valid_months);?>" />  Months
                  <?php echo form_error('valid_months'); ?> 
                  <input  type="text" id="valid_days" name="valid_days" value="<?php echo set_value('valid_days', $bidpackage->valid_days);?>" />  Days
                  <?php echo form_error('valid_days'); ?> 
                </div>
             </li>
             
             <li>
                <label>Visible<span>*</span> :</label>
                <input name="display" type="radio" value="Yes" <?php if($bidpackage->display == 'Yes'){ echo 'checked="checked"';}  ?>/>Yes
                <input name="display" type="radio" value="No" <?php if($bidpackage->display == 'No'){ echo 'checked="checked"';} ?> />No
                <?php echo form_error('display'); ?> 
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
<div> </div>

<script>
$(document).ready(function() {
  $('#member_type').change(function() {
      var member_type = $(this).val();
      if( member_type == '1') {
        $('#credits').prop('placeholder','No of Auction Posts');
      } else if(member_type == '2') {
        $('#credits').prop('placeholder','No of Bid Place');      
      } else {
        $('#credits').prop('placeholder','');  
      }
    });
});
</script>






