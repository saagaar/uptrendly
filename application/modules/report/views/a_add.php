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
       <div class="title_h3">Add CMS Pages for all languages</div>
      
        <form name="addcms" method="post" action="" accept-charset="utf-8">
        
        	<?php for($i=0; $i<count($lang_details); $i++)
		  		{
					$language_id = '';
					$lang = $this->input->post('lang_id');
					if(!empty($lang[$i])){ $language_id = $lang[$i]; }
					?>
            		<input type="hidden" name="lang_id[]" value="<?php echo $lang_details[$i]->id;?>" checked="checked" 
					<?php // if($language_id == $lang_details[$i]->id) echo 'checked="checked"'; ?> />
            		<?php // echo $lang_details[$i]->lang_name;?>
            		<?php 
				}?>
        
         <ul id="mytabs" class="shadetabs">
            <?php for($i=1; $i<=count($lang_details); $i++)
				{
					?>
                		<li>
                        	<a href="JavaScript:void(0);" rel="tab<?php echo $i;?>">
                        		<span><?php echo $lang_details[$i-1]->lang_name;?></span>
                           	</a>
                       </li>
                	<?php
                   }
				?>
              </ul>
              
                <div style="clear:both;"></div>
              
              <?php
              	for($i=1; $i<=count($lang_details); $i++)
			  	{
				?>
              <div id="tab<?php echo $i;?>" class="tabcontent">
        
          		<fieldset>
            <div class="title_h3">Add CMS Pages for all languages</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Heading<span>*</span> :</label>
                  <?php
                    	$heading = '';
						$name = $this->input->post('heading'); 
						if(!empty($name[$lang_details[$i-1]->id]))
						{
							$heading = $name[$lang_details[$i-1]->id]; };
						?>
                      <input size="50" class="inputtext" type="text" id="name[<?php echo $lang_details[$i-1]->id;?>]" name="heading[<?php echo $lang_details[$i-1]->id;?>]" value="<?php echo $heading; ?>">
                      <?php echo '<div class="error">'.$this->session->userdata('heading_'.$lang_details[$i-1]->id)."</div>"; ?></td>
                </div>
              </li>
              
              <li>
                <div>
                  <label>CMS Slug<span>*</span> :</label>
                  <?php
                        	$slug = '';
							$name = $this->input->post('slug');
							if(!empty($name[$lang_details[$i-1]->id]))
							{
								$slug = $name[$lang_details[$i-1]->id];
							}
						?>
                      <input size="50" class="inputtext" type="text" id="slug[<?php echo $lang_details[$i-1]->id;?>]" name="slug[<?php echo $lang_details[$i-1]->id;?>]" value="<?php echo $slug; ?>">
                      <?php echo '<div class="error">'.$this->session->userdata('slug_'.$lang_details[$i-1]->id)."</div>"; ?>
                </div>
              </li>
              
              <li class="txtar">
                <label>Content<span>*</span> :</label>
               		<?php 
						$content = ''; 
						$name = $this->input->post('content');
						if(!empty($name[$lang_details[$i-1]->id]))
						{
							$content = $name[$lang_details[$i-1]->id];
						};
						
						echo form_fckeditor('content['.$lang_details[$i-1]->id.']', $content );	
						
						echo '<div class="error">'.$this->session->userdata('content_'.$lang_details[$i-1]->id)."</div>";
					?>
              </li>
            </ul>
          </fieldset>
          
          		<fieldset>
            <div class="title_h3">SEO Parameters</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Page Title<span>*</span> :</label>
                 	<?php 
						$page_title = ''; 
						$page_title2 = $this->input->post('page_title'); 
						if(!empty($page_title2[$lang_details[$i-1]->id])){ $page_title = $page_title2[$lang_details[$i-1]->id]; };
					?>
                	<textarea cols="60" rows="1" id="page_title[<?php echo $lang_details[$i-1]->id;?>]" name="page_title[<?php echo $lang_details[$i-1]->id;?>]"><?php echo $page_title;?></textarea>
                </div>
              </li>
              
              <li>
                <div>
                  <label>Meta Key Words</label>
                  <?php
                    	$meta_key = ''; 
						$meta_key2 = $this->input->post('page_title'); 
						if(!empty($meta_key2[$lang_details[$i-1]->id])){ $meta_key = $meta_key2[$lang_details[$i-1]->id]; };
					?>
                	<textarea cols="60" rows="2" id="meta_key[<?php echo $lang_details[$i-1]->id;?>]" name="meta_key[<?php echo $lang_details[$i-1]->id;?>]"><?php echo $meta_key;?></textarea>
                </div>
              </li>
              
              <li>
                <label>Meta Description</label>
                	<?php
                    	$meta_desc = ''; 
						$meta_desc2 = $this->input->post('page_title'); 
						if(!empty($meta_desc2[$lang_details[$i-1]->id])){ $meta_desc = $meta_desc2[$lang_details[$i-1]->id]; };
					?>
                	<textarea cols="60" rows="2" id="meta_desc[<?php echo $lang_details[$i-1]->id;?>]" name="meta_desc[<?php echo $lang_details[$i-1]->id;?>]"><?php echo $meta_desc;?></textarea>
              </li>
              
            </ul>
          </fieldset>
          
          		<fieldset>
            <div class="title_h3">Display Settings</div>
            <ul class="frm">
              <li>
                <label>Visible<span>*</span> :</label>
                <input name="is_display[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="Yes" checked="checked" />Yes
                <input name="is_display[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="No" <?php if(isset($_POST['is_display'][$lang_details[$i-1]->id]) && $_POST['is_display'][$lang_details[$i-1]->id] == 'No'){ echo 'checked="checked"';}?> />
              </li>
              
              <li>
                <label>Show in sitemap<span>*</span> :</label>
                 <input name="show_in_sitemap[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="Yes" checked="checked" />Yes
                <input name="show_in_sitemap[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="No" <?php if(isset($_POST['show_in_sitemap'][$lang_details[$i-1]->id]) && $_POST['show_in_sitemap'][$lang_details[$i-1]->id] == 'No'){ echo 'checked="checked"';}?> />No
              </li>
              
             <li class="txthalf">
                  <label>Position<span>*</span> :</label>
                  	<input name="block_section[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="1" checked="checked" />Information
                	<input name="block_section[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="2" <?php if(isset($_POST['block_section'][$lang_details[$i-1]->id]) && $_POST['block_section'][$lang_details[$i-1]->id] == '2'){ echo 'checked="checked"';}?> />Service & support
                    <input name="block_section[<?php echo $lang_details[$i-1]->id;?>]" type="radio" value="3" <?php if(isset($_POST['block_section'][$lang_details[$i-1]->id]) && $_POST['block_section'][$lang_details[$i-1]->id] == '3'){ echo 'checked="checked"';}?> />Others
			 <br />
            </ul>
          </fieldset>
          	
            </div>
          
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
