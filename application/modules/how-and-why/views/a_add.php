<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; How It Works/Why Reverse Auction Management</h2>
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
        <div class="title_h3">Add CMS Page</div>
        <form name="addcms" method="post" action="" accept-charset="utf-8"  enctype="multipart/form-data" >
          <fieldset>
            <ul class="frm">
              <li>
                <div>
                  <label>Title<span>*</span> :</label>
                  <input size="50" class="inputtext" type="text" id="title" name="title" value="<?php echo set_value('title');?>">
                  <?php echo form_error('title'); ?> </div>
              </li>              
              <li>
                <label>CMS Type<span>*</span> :</label>
                <input name="cms_type" type="radio" value="how_it_works" checked="checked" />How it Works
                <input name="cms_type" type="radio" value="why_reverse_auction" <?php if(isset($_POST['cms_type']) && $_POST['cms_type'] == 'why_reverse_auction'){ echo 'checked="checked"';}?> />Why Reverse 
             </li>
             
             <li>
                	<label>Visible<span>*</span> :</label>
                	<input name="is_display" type="radio" value="1" checked="checked" />Yes
                	<input name="is_display" type="radio" value="0" <?php if(isset($_POST['is_display']) && $_POST['is_display'] == '0'){ echo 'checked="checked"';}?> />No
            </li>
             
              <li class="txtar">
                <label>Description<span>*</span> :</label>
                <?php
						$content_data = '';
						if($this->input->post('description')){$content_data=$this->input->post('description');}
						echo form_fckeditor('description',$content_data);
					?>
                <?=form_error('description')?>
              </li>
            </ul>
          </fieldset>
          <fieldset>
            <div class="title_h3">Image</div>
            <ul class="frm">
             <li>
                  <label>Image<span>*</span> :</label>                  
                  <input type="file" name="image" />
                  <?php echo $this->session->userdata('error_img');?>
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
