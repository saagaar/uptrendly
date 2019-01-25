<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; CMS  Management</h2>
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
      
        <div class="title_h3">CMS for all Languages</div>
        <form name="sitesetting" method="post" action="" accept-charset="utf-8">
          <ul id="mytabs" class="shadetabs">
            <?php
				$i='0';
				foreach ($cms_data as $data)
				{
					$i++;
					?>
            			<li> <a href="JavaScript:void(0);" rel="tab<?php echo $i;?>"> <span><?php echo $data->lang_name;?></span> </a> </li>
            		<?php
             	}
			?>
          </ul>
          
          <div style="clear:both;"></div>
          <?php
			  	$i='0';
              	foreach ($cms_data as $data)
			  	{
					$i++;
				?>
          <div id="tab<?php echo $i;?>" class="tabcontent">
            <fieldset>
              <div class="title_h3">Content data (<?php echo $data->lang_name;?>)</div>
              <ul class="frm">
                <li>
                  <div>
                    <label>Heading<span>*</span> :</label>
                    <?php
                    	$heading_name = '';
						$name = $this->input->post('name'); 
						if(!empty($name[$data->lang_id]))
						{
							$heading_name = $name[$data->lang_id];
						}
						else
						{
							$heading_name = $data->heading;
						}
					?>
                    <input size="50" class="inputtext" type="text" id="heading[<?php echo $data->lang_id;?>]" name="heading[<?php echo $data->lang_id; ?>]" value="<?php echo $heading_name; ?>">
                    <?php echo '<div class="error">'.$this->session->userdata('heading_'.$data->lang_id)."</div>"; ?> </div>
                </li>
                <li>
                  <div>
                    <label>CMS Slug<span>*</span> :</label>
                    <?php
						$slug = '';
						$name = $this->input->post('slug');
						if(!empty($name[$data->cms_slug]))
						{
							$slug = $name[$data->lang_id];
						}
						else
						{
							$slug = $data->cms_slug;
						}
					?>
                    <input size="50" class="inputtext" type="text" id="slug[<?php echo $data->lang_id; ?>]" name="slug[<?php echo $data->lang_id;?>]" value="<?php echo $slug; ?>">
                    <?php echo '<div class="error">'.$this->session->userdata('slug_'.$data->lang_id)."</div>"; ?> </div>
                </li>
                <li class="txtar">
                  <label>Content<span>*</span> :</label>
                  <?php 
							$content = ''; 
							$form_content = $this->input->post('content');
							if(!empty($form_content[$data->lang_id]))
							{
								$content = $form_content[$data->lang_id];
							}
							else
							{
								$content = $data->content;
							}
						 	
							echo form_fckeditor('content['.$data->lang_id.']', $content );	
							
							echo '<div class="error">'.$this->session->userdata('content_'.$data->lang_id)."</div>";
						?>
                </li>
              </ul>
            </fieldset>
            <fieldset>
              <div class="title_h3">SEO Parameters (<?php echo $data->lang_name;?>)</div>
              <ul class="frm">
                <li>
                  <div>
                    <label>Page Title<span>*</span> :</label>
                    <?php 
						$page_title = ''; 
						$page_title2 = $this->input->post('page_title'); 
						if(!empty($page_title2[$data->lang_id]))
						{
							$page_title = $page_title2[$data->lang_id];
						}
						else
						{
							$page_title = $data->page_title;
						}
					?>
                    <textarea cols="60" rows="1" id="page_title[<?php echo $data->lang_id ;?>]" name="page_title[<?php echo $data->lang_id; ?>]"><?php echo $page_title;?></textarea>
                  </div>
                </li>
                <li>
                  <div>
                    <label>Meta Key Words </label>
                    <?php
                    	$meta_key = ''; 
						$meta_key2 = $this->input->post('meta_key'); 
						if(!empty($meta_key2[$data->lang_id]))
						{
							$meta_key = $meta_key2[$data->lang_id];
						}
						else
						{
							$meta_key = $data->meta_key;
						}
					?>
                    <textarea cols="60" rows="2" id="meta_key[<?php echo $data->lang_id; ?>]" name="meta_key[<?php echo $data->lang_id; ?>]"><?php echo $meta_key;?></textarea>
                  </div>
                </li>
                <li>
                  <label>Meta Description</label>
                  <?php
                    	$meta_desc = ''; 
						$meta_desc2 = $this->input->post('page_title'); 
						if(!empty($meta_desc2[$data->lang_id]))
						{
							$meta_desc = $meta_desc2[$data->lang_id]; 
						}
						else
						{
							$meta_desc = $data->meta_description;
						}
					?>
                  <textarea cols="60" rows="2" id="meta_desc[<?php echo $data->lang_id;?>]" name="meta_desc[<?php echo $data->lang_id; ?>]"><?php echo $meta_desc;?></textarea>
                </li>
              </ul>
            </fieldset>
            <fieldset>
              <div class="title_h3">Display Settings (<?php echo $data->lang_name;?>)</div>
              <ul class="frm">
                <li>
                  <label>Visible<span>*</span> :</label>
                  <input name="is_display[<?php echo $data->lang_id; ?>]" type="radio" value="Yes" checked="checked" />
                  Yes
                  <input name="is_display[<?php echo $data->lang_id;?>]" type="radio" value="No" <?php if($data->is_display == 'No'){ echo 'checked="checked"';}?> />
                  No <br />
                </li>
                <li>
                  <label>Show in sitemap<span>*</span> :</label>
                  <input name="show_in_sitemap[<?php echo $data->lang_id; ?>]" type="radio" value="Yes" checked="checked" />
                  Yes
                  <input name="show_in_sitemap[<?php echo $data->lang_id;?>]" type="radio" value="No" <?php if($data->show_in_sitemap == 'No'){ echo 'checked="checked"';}?> />
                  No <br />
                  <?=form_error('show_in_sitemap')?>
                </li>
                
                <li class="txthalf">
                  <label>Position<span>*</span> :</label>
                  <input name="block_section[<?php echo $data->lang_id; ?>]" type="radio" value="1" checked="checked" />
                  Information
                  <input name="block_section[<?php echo $data->lang_id; ?>]" type="radio" value="2" <?php if($data->block_section == '2'){ echo 'checked="checked"';} ?> />
                  Service & support
                  <input name="block_section[<?php echo $data->lang_id; ?>]" type="radio" value="3" <?php if($data->block_section == '3'){ echo 'checked="checked"';}?> />
                  Others <br />
                </li>
              </ul>
            </fieldset>
          </div>
          <input size="50" class="inputtext" type="hidden" id="lang_id" name="lang_id[]" value="<?php echo $data->lang_id;?>">
          <input size="50" class="inputtext" type="hidden" id="cms_id" name="cms_id[]" value="<?php echo $data->id;?>">
          <?php }?>
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
	var mytabs_obj=new ddtabcontent("mytabs")
	mytabs_obj.setpersist(true)
	mytabs_obj.setselectedClassTarget("link") //"link" or "linkparent"
	mytabs_obj.init()
</script> 
