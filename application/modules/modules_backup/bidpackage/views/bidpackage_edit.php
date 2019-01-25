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
        <div class="title_h3">Edit Bidpackage</div>
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
                  <label>Package Type<span>*</span> :</label>

                  <select id="package_type" name="package_type">
                    <option value=""> Select Member Type</option>
                    <option class="buyer" value="one_post" <?php if($bidpackage->package_type == 'one_post' )  { echo 'selected="selected"'; } ?>> One Post</option>
                    <option class="seller" value="one_bid"   <?php if($bidpackage->package_type == 'one_bid' )  { echo 'selected="selected"'; } ?>> One Bid</option>
                    <option value="unlimited"  <?php if($bidpackage->package_type == 'unlimited' )  { echo 'selected="selected"'; } ?>> Unlimited</option>
                  </select>
                  <?php echo form_error('package_type'); ?> 
                  </div>
              </li>
              <li>
                <div>
                  <label>Package Name:</label>
                  <input size="50" class="inputtext" type="text" id="package_name" name="package_name" value="<?php echo set_value('package_name', $bidpackage->package_name);?>" />
                  <?php echo form_error('package_name'); ?> 

                </div>
              </li>
              <li>
                <label>Bids(0 For Unlimited bids)<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="bids" name="bids" value="<?php echo set_value('bids',$bidpackage->bids);?>" placeholder="" />  
                  <?php echo form_error('bids'); ?> 
                
             </li>
             <li>
                <label>Package  Cost<span>*</span> :</label>
                <input size="50" class="inputtext" type="text" id="cost" name="cost" value="<?php echo set_value('cost', $bidpackage->cost);?>" />  
                  <?php echo form_error('cost'); ?> 
                
             </li>
              <li class="validity">
                <label>Valid Time<span>*</span> :</label>
                <div>
                  
                  <input  type="text" id="valid_time" name="valid_time" value="<?php echo set_value('valid_time', $bidpackage->valid_time);?>" />  {in days}
                  <?php echo form_error('valid_time'); ?> 
                </div>
             </li>
             
             <li>
                <label>Visible<span>*</span> :</label>
                <input name="is_display" type="radio" value="1" <?php if($bidpackage->is_display == '1'){ echo 'checked="checked"';}  ?>/>Yes
                <input name="is_display" type="radio" value="0" <?php if($bidpackage->is_display == '0'){ echo 'checked="checked"';} ?> />No
                <?php echo form_error('is_display'); ?> 
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
var packages = $('#package_type').val();
if(packages != 'unlimited')
{
  $('.validity').hide();
}
  $(document).on('change','#package_type',function(){

      if($(this).val()!='unlimited')
      {
        $('.validity').hide();
        $('#valid_time').val('');
      }else{
         $('.validity').show();
      }
  });
  $('#member_type').change(function() {
    $('#package_type').val('');
      var member_type = $(this).val();
      if( member_type == '1') {
        $('.buyer').show();
        $('.seller').hide();
        $('#bids').prop('placeholder','No of Auction Posts');
      } else if(member_type == '2') {
         $('.seller').show();
         $('.buyer').hide();
        $('<div class="buyer"></div>').hide();
        $('#bids').prop('placeholder','No of Bid Place');      
      } else {
        $('#bids').prop('placeholder','');  
      }
    });
});
</script>






