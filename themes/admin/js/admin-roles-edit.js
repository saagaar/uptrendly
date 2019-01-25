jQuery(document).ready(function ($) {
    var rolePermissions = {
		"7": "module-administrator",
		"13": "module-cms",
        "17": "module-help",
		"26": "module-product-category",
		"81": "module-custom-field",
		"40": "module-member",
		"46": "module-product",
		"61": "module-bidpackage",
		"70": "module-currency",
		"76": "module-newsletter",
		"85": "module-how-and-why",
	};

    $.each(rolePermissions, function (key, value) {
		$("#" + value).click(function(){
			$("." + value).prop("checked",$("#" + value).prop("checked"))
		})
    });
});