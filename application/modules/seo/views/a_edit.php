<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; SEO  Management</h2>
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
        <form name="addcms" method="post" action="" accept-charset="utf-8">
       		<fieldset>
            	<div class="title_h3">SEO Page</div>
            		<ul class="frm">
             			<li>
                    		<div>
                                <label>Select Page<span>*</span></label>
                                <select name="seo_page_name">
                                <?php if($all_seo_pages){?>
                                <option value="">Select a page</option>
                                <?php foreach($all_seo_pages as $pages){?>
                                <option value="<?php echo $pages->seo_page_name;?>" <?php if($pages->id == $seo_data->id){echo "selected='selected'";}?>><?php echo $pages->seo_page_name;?></option>
                                <?php } ?>
                                <?php } else {?>
                                <option value="">No pages found</option>
                                <?php } ?>
                        	</select>
						 <?php echo form_error('seo_page_name'); ?>
                    </div>
                </li> 
            </ul>
          </fieldset>
        	
            <fieldset>
            <div class="title_h3">SEO Parameters</div>
            <ul class="frm">
              <li>
                <div>
                  <label>Page Title<span>*</span> :</label>
                 	<textarea cols="60" rows="1" id="page_title" name="page_title"><?php echo set_value('page_title',$seo_data->page_title); ?></textarea>
                    <?php echo form_error('page_title'); ?>
                </div>
              </li>
              
              <li>
                <div>
                  <label>Meta Key Words</label>
                  	<textarea cols="60" rows="2" id="meta_key" name="meta_key"><?php echo set_value('meta_key',$seo_data->meta_key); ?></textarea>
                     <?php echo form_error('meta_key'); ?>
                </div>
              </li>
              
              <li>
                <label>Meta Description</label>
                	<textarea cols="60" rows="2" id="meta_desc" name="meta_desc"><?php echo set_value('meta_desc',$seo_data->meta_description); ?></textarea>
                    <?php echo form_error('meta_desc'); ?>
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