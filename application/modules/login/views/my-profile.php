<section class="title">
  <div class="wrap">
    <h2>Administrator &raquo; Update</h2>
  </div>
</section>

<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu/admin'); ?>
    </aside>
    <section class="smfull">
      <?php
		if(validation_errors() != '' || $this->session->flashdata('message') != '')
		{
		?>
		<div class="message">
		<?php
            if(validation_errors() != ''){
             echo '<p>'.validation_errors().'</p>'; 
            }
            if($this->session->flashdata('message') != ''){
                echo '<p>'.$this->session->flashdata('message').'</p>';
            } 
        ?>
      </div>
		<?php
		}
	?>
      <div class="box_block">
	  <?php echo form_open('',array('id' => 'adminRegisterForm','autocomplete' => 'off')); ?>
        <fieldset>
          <div class="title_h3">My Profile</div>
          <ul class="frm">
            <li>
              <label>Email <span>*</span> : </label>
              <input name="email" type="text" value="<?php echo set_value('email',$admin_default['email']); ?>">
              <?php echo form_error('email'); ?>
            </li>
            <li>
              <label>nickname <span>*</span> : </label>
              <input name="nickname" type="text" value="<?php echo set_value('nickname',$admin_default['nickname']);?>">
              <?php echo form_error('nickname'); ?> </li>
          </ul>
        </fieldset>
        <fieldset class="btn">
          <button type="submit" class="butn">Submit</button>
          <input type="hidden" name="admin_id" value="<?php echo $admin_default['admin_id'];?>" />
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
