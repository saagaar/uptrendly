<section class="title">
  <div class="wrap">
    <h2>Seller &raquo; Compose</h2>
  </div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    <section class="smfull">
      <div class="box_block">
        <div class="title_h3"> Write a mail </div>
        <?php
			if(validation_errors() != '' || $this->session->flashdata('message') != ''){
		?>
        <div class="confrmmsg">
        <?php
			if(validation_errors() != ''){
				echo '<p>Please correct the input data</p>';
			}
			if($this->session->flashdata('message') != ''){
				echo '<p>'.$this->session->flashdata('message').'</p>';
			} 
		?>
        </div>
        <?php
		}
	  ?>
        <?php echo form_open(ADMIN_DASHBOARD_PATH.'/communication/compose',array('id' => 'sellerComposeForm','enctype' => 'multipart/form-data','autocomplete' => 'off')); ?>
        <ul class="frm cmp_mail">
          <?php /*?><li>
            <div>
             <label>To <span class="req">*</span> :</label>
             <?php
			 	$seller_arr = array();
				$seller_arr[''] = '';
			  	if($sellers){
					foreach($sellers as $item){ 
						$seller_arr[$item->id] = $item->name. '('. $item->email .')';
					}
				}
				echo form_dropdown('msg_to',$seller_arr, set_value('msg_to'), 'id="msg_to"');
				echo form_error('msg_to');
			 ?>
            </div>
          </li><?php */?>
          
          <li>
            <div>
             <label>To <span class="req">*</span> :</label>
             <input type="text" class="form-control" name="msg_to" id="searchMembersEmail" required="required" value="<?php echo set_value('msg_to',$email); ?>">
            <?php echo form_error('msg_to'); ?>
            </div>
          </li>
           <li>
            <div>
              <label>Message Reason <span class="req">*</span>:</label>
              <select name="product_id" id="product_id">
                <option value="0">General</option>
              </select>
             </div>
          </li>
          <li>
            <div>
              <label>Subject <span class="req">*</span>:</label>
                <input name="subject" type="text" value="<?php echo set_value('subject');?>" required="required">
              <?php echo form_error('subject');?> </div>
          </li>
         <!--  <li class="txtar">
            <label> Attachments </label>
            <input name="msg_attachments" type="file" class="file_2  noxtxt fileup" />
            <div id="attachmentErrorContainer"><?php echo form_error('msg_attachments');?></div>
          </li> -->
          <li class="txtar">
            <label>Message <span class="req">*</span> :</label>
            <textarea name="message" cols="" rows="" required="required"><?php echo set_value('message');?></textarea>
            <?php echo form_error('message');?> </li>
          <li class="txtar">
            <button type="submit" class="butn">Send Mail </button>
          </li>
        </ul>
        <?php echo form_close(); ?> </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>

<script type="text/javascript" src="<?php echo site_url(JQUERYUI_PATH.'jquery-ui.min.js'); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().JQUERYUI_PATH.'jquery-ui.min.css'; ?>">

<script>
var url='<?php echo site_url(ADMIN_DASHBOARD_PATH.'/communication/get_product_by_useremail')?>'
	$("#searchMembersEmail").autocomplete({
		source : '<?php echo site_url(ADMIN_DASHBOARD_PATH); ?>'+ '/communication/get_members_email_autocomplete',
		minLength : 1,
		select : function (event, ui) {
			$('#searchMembersEmail').val(ui.item.label);
		},
		open : function (event, ui) {
			$(".ui-autocomplete").css("z-index", 99999);
		},messages: {
			results: function() {
					
			}
		}
	});

  $(document).on('focusout','#searchMembersEmail',function(){
    var memberemail=$(this).val();
    $('#product_id').val('');
    $.ajax
    ({
      url:url+'/'+encodeURIComponent(memberemail),
      type: "GET",
      dataType:'html',
       success:function(data)
       {
            $('#product_id').val('');
             $('#product_id').html(data);
       }
    })


  })
</script>
