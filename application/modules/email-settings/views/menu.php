<ul>
	<li <?php echo (@$current_menu == 'view_templates')?'class="active"':''?>>
    	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/email-settings/index/');?>"><span>View All Templates</span></a>
    </li>
    
    <?php if($current_menu == 'update'){ ?>
    	<li class="active">
    		<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/email-settings/detail/'.$this->uri->segment('4'));?>"><span>Edit Templates</span></a>
    	</li>

	
<!--
    <h2 class="ttl">Legends</h2>
    <dl class="dttbllist">
		<dt>[USER_ID]</dt>
		<dd>Channel owners or subscribers User Id</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[USERNAME]</dt>
		<dd>Channel owners or subscribers username</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[PASSWORD]</dt>
		<dd>Channel owners or subscribers login password</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[CONFIRM]</dt>
		<dd>Confirmation link for subscribers registration</dd>
	</dl>
    
    
    <dl class="dttbllist">
		<dt>[FIRSTNAME]</dt>
		<dd>Channel owners or subscribers First Name</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[SITENAME]</dt>
		<dd>JVTV Website Name</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[INVOICE_ID]</dt>
		<dd>Invoice Id of transaction</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[AMOUNT]</dt>
		<dd>Paid Amount for subscription</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[PAYMENT_METHOD]</dt>
		<dd>Payment method (e.g. Paypal)</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[DATE]</dt>
		<dd>Date and Time</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[VIDEO_ID]</dt>
		<dd>Video Id of uploaded video</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[VIDEO_TYPE]</dt>
		<dd>Uploaded Video Type</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[UPLOAD_DATE]</dt>
		<dd>Video Upload Date</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[CHANNEL_NUMBER]</dt>
		<dd>Channel Owner's Channel Number</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[CHANNEL_NAME]</dt>
		<dd>Channel Owner's Channel Name</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[CANCEL_REASON]</dt>
		<dd>Video Reject Reason</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[CANCEL_DATE]</dt>
		<dd>Video Rejected Date</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[ACCOUNT_TYPE]</dt>
		<dd>Users Account Type (Channel owners or subscribers)</dd>
	</dl>
    
    <dl class="dttbllist">
		<dt>[LOGIN_LINK]</dt>
		<dd>Login link to be sent to users email</dd>
	</dl>-->
    
    <?php } ?>
</ul>