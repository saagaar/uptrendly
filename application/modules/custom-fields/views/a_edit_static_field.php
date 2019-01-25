<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Product Form Fields</h2>
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
                <form name="add_cat" method="post" action="" accept-charset="utf-8" enctype="multipart/form-data">
                <fieldset>
                  <div class="title_h3">Edit Static Field (<?php echo $field_data->field_name; ?>)</div>
                  <ul class="frm">
                  	<li>
                     	<label>Field Label<span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" name="field_label" value="<?php echo set_value('field_label',$field_data->field_label); ?>">
                        <?=form_error('field_label')?>
                    </li>
                    
                    <?php if($field_data->field_name=='condition' OR $field_data->field_name=='warranty' OR $field_data->field_name=='package_size'){ ?>
                    <li class="txthalf">
                      <label>Option values<span>*</span> :</label>
                        <input size="50" class="inputtext" type="text" name="options" placeholder="separate options values by comma" value="<?php echo set_value('options',$field_data->options); ?>">
                        <?=form_error('options')?>
                    </li>
                    <?php } ?>
                    
                    <?php /*?><li>
                    	<label><span>Display</span></label>
                        <input type="radio" name="display" value="1" <?php if($field_data->display=='1'){echo 'checked="checked"';} ?>/>Yes
                        <input type="radio" name="display" value="0" <?php if($field_data->display=='0'){echo 'checked="checked"';} ?>/>No
                    </li><?php */?>
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

<?php /*?><script>var operation = 'edit';</script>
<script src="<?php echo base_url().ADMIN_JS_DIR; ?>admin.custom.fields.js" type="text/javascript"></script><?php */?>