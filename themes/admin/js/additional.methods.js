// JavaScript Document
$.validator.addMethod("integer", function(value, element) {
	return this.optional(element) || /^-?\d+$/.test(value);
}, "A positive or negative non-decimal number please");

$.validator.addMethod("alpha", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Please Enter only alphabets"); 


$.validator.addMethod("alphadashes", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
 },"Please Enter only alphabets and dashes");
 
$.validator.addMethod("alphaspaces", function (value, element) {
	return this.optional(element) || /^[a-z _]+$/i.test(value);
}, "Please Enter only alphabets and spaces");

$.validator.addMethod("alphanumeric", function(value, element) {
	return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
},"Please enter only Alpha Numeric Characters");


$.validator.addMethod("exactlength", function(value, element, param) {
	//console.log(value.length);
	return this.optional(element) || value.length == param;
}, jQuery.validator.format("Please enter exactly {0} characters."));


$.validator.addMethod("maxWords", function(value, element, params) {
	return this.optional(element) || stripHtml(value).match(/\b\w+\b/g).length <= params;
}, jQuery.validator.format("Please enter {0} words or less."));

$.validator.addMethod("minWords", function(value, element, params) {
	return this.optional(element) || stripHtml(value).match(/\b\w+\b/g).length >= params;
}, jQuery.validator.format("Please enter at least {0} words."));

$.validator.addMethod("rangeWords", function(value, element, params) {
	var valueStripped = stripHtml(value);
	var regex = /\b\w+\b/g;
	return this.optional(element) || valueStripped.match(regex).length >= params[0] && valueStripped.match(regex).length <= params[1];
}, jQuery.validator.format("Please enter between {0} and {1} words."));


$.validator.addMethod("checkDuplicateEmail", function (value, element) {
	var availability = '';
	$.ajax({
		type : 'POST',
		url : urlCheckDuplicateEmail,
		data : {
			email : value
		},
		async : false,
		success : function (data) {
			if (data != '' || data != undefined || data != null) {
				availability = data.trim();
			}
		}
	});
	return this.optional(element) || (availability == 'available');
}, "Email already exists.");


//use this additional method only if this page contains dropzone
if($("#my-awesome-dropzone").length != 0) {
  	Dropzone.isBrowserSupported() && $.validator.addMethod("require-two-photos", function () {
		return $("#my-awesome-dropzone").find(".dz-image-preview").length > 1
	}, "Please upload at least two photos.");
}


$.validator.addMethod("validDateTime", function (value, element) {
	var stamp = value.split(" ");
	var validDate = !/Invalid|NaN/.test(new Date(stamp[0]).toString());
	var validTime = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(stamp[1]);
	return this.optional(element) || (validDate && validTime);
}, "Please enter a valid date and time.");


// Accept a value from a file input based on a required mimetype
$.validator.addMethod("accept", function(value, element, param) {
	// Split mime on commas in case we have multiple types we can accept
	var typeParam = typeof param === "string" ? param.replace(/\s/g, '').replace(/,/g, '|') : "image/*",
	optionalValue = this.optional(element),
	i, file;

	// Element is optional
	if (optionalValue) {
		return optionalValue;
	}

	if ($(element).attr("type") === "file") {
		// If we are using a wildcard, make it regex friendly
		typeParam = typeParam.replace(/\*/g, ".*");
		var file_type = '';
		// Check if the element has a FileList before checking each file
		if (element.files && element.files.length) {
			for (i = 0; i < element.files.length; i++) {
				file = element.files[i];
				//console.log("File Type: " + file.type);
				//console.log("Type Parameters : "+typeParam);
				
				//store file type in local variable and remove inverted comma if found 
				file_type = file.type.replace(/^"(.*)"$/, '$1');
				
				//console.log("File Type after removing inverted comma: " + file_type);
				
				//Grab the mimetype from the loaded file, verify it matches
				if (!file_type.match(new RegExp( ".?(" + typeParam + ")$", "i"))) {
					//console.log('false');
					return false;
				}
			}
		}
	}
	//console.log('true');
	// Either return true because we've validated each file, or because the
	// browser does not support element.files and the FileList feature
	return true;
}, $.validator.format("Wrong File Type. Please enter a Valid File."));


$.validator.addMethod("extension", function(value, element, param) {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "doc|docx|pdf|xls|xlsx";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, $.validator.format("Please enter a value with a valid extension."));
