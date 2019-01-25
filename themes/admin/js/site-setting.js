jQuery(document).ready(function($) {
	$("#select_default_country").select2({
		placeholder: "Select Default Country",
		width: "100%"
	 });
	 $("#select_default_jurisdiction").select2({
		placeholder: "Select Default Jurisdiction",
		width: "100%"
	 });
	
	$("#siteSettingsForm").validate({
		submitHandler: function(form) {
		   
		   form.submit();
		},
		errorElement: "div",
		rules: {
			
			site_name: {
				required: true,
				minlength:2,
				maxlength:100,
			},
			system_email_address: {
				required: true,
				email: true				
			},
			system_email_name: {
				required: true,
				minlength:2,
				maxlength:100,
			},
			exe_cms_site_url: {
				required: true,
				url:true
			},
			exe_app_site_url: {
				required: true,
				url:true
			},
			max_file_upload_size: {
				required: true,
				digits:true
			},
			exe_auction_id_length: {
				required: true,
				digits:true,
				min: 5,
				max: 15,
			},
			exe_debtor_id_length: {
				required: true,
				digits:true,
				min: 5,
				max: 15,
			},
			exe_seller_prefix: {
				required: true,
				minlength:2,
				maxlength:10,
			},
			exe_investor_prefix:{
				required: true,
				minlength:2,
				maxlength:10,
			},
			exe_debtor_prefix: {
				required: true,
				minlength:2,
				maxlength:10,
			},
			exe_invoice_prefix: {
				required: true,
				minlength:2,
				maxlength:10,
			},
			site_status: {
				required: true,
			},
			site_offline_msg: {
				required: true,
			},
			select_default_country: {
				required: true,
			},
			select_default_jurisdiction: {
				required: true,
			},
			select_default_currency: {
				required: true,
			},
			max_no_shareholders: {
				required: true,
				min: 1,
				max: 100,
			},
			max_no_nonshareholders: {
				required: true,
				min: 1,
				max: 100,
			},
			max_no_finance_customer: {
				required: true,
				min: 5,
				max: 100,
			},
			default_page_title: {
				required: true,
				minlength:2,
				maxlength:100,
			}
		},
		
	});//formid validate
	
});