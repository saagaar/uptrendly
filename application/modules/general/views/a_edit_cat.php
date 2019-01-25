<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Product Category</h2>
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
                  <div class="title_h3">Product Category</div>
                  <ul class="frm">
                  	<li>
                      <div>
                        <label>Category Name<span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" id="name" name="name" value="<?php echo set_value('name',$cat_data->name);?>" />
                        <?=form_error('name')?>
                      </div>
                    </li>
                     <li>
                      <div>
                        <label>Display ? <span>*</span> :</label>
                        <input type="radio" name="is_display" value="1" checked="checked" /> Yes
                        <input name="is_display" type="radio" value="0" <?php if($cat_data->is_display =='0'){ echo 'checked="checked"';}?>/> No
                      </div>
                    </li>  
                    </ul>
                  </fieldset>
                   
                   <fieldset>
                   	<ul class="frm">
                    <li>
                      <div>
                        <label>Short Description<span>*</span> :</label>
                         <textarea name="short_desc" cols="34" rows="2" id="short_desc"><?php echo set_value('short_desc',$cat_data->short_desc);?></textarea>
							<?=form_error('short_desc')?>
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