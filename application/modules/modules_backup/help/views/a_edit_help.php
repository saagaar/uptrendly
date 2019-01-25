<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Help Management</h2>
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
        <form name="sitesetting" method="post" action="" accept-charset="utf-8">
          <fieldset>
            <div class="title_h3">Edit Help Content</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Help Title<span>*</span> :</label>
                  <input name="name" type="text" class="inputtext txthalf" id="name" value="<?php echo set_value('name',$data_help->title);?>" size="50" /><?=form_error('name')?>
                </div>
              </li>              
              <li>
                <label>Visible<span>*</span> :</label>
                <input name="is_display" type="radio" value="Yes" <?php echo set_value('is_display', $data_help->is_display) == 'Yes' ? "checked" : "";?> /> Yes
                <input name="is_display" type="radio" value="No" <?php echo set_value('is_display', $data_help->is_display) == 'No' ? "checked" : "";?> /> No <br />
                <?=form_error('is_display')?>
              </li>
              
              <li class="txtar">
                <label>Description<span>*</span> :</label>
               <?php
				if($this->input->post('description')){$content_data=$this->input->post('description');}else{$content_data=$data_help->description; }
					echo form_fckeditor('description',str_replace("{serverpath}", base_url(), $content_data));			
			?>
			<?=form_error('description')?>
              </li>
            </ul>
          </fieldset>
          
          <fieldset class="btn">
            <input type="submit" value="Update" class="butn">
          </fieldset>
        </form>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>

<?php //$this->load->view('dynamic_cat'); ?>
