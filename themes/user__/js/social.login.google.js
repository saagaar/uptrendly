// JavaScript Document
function logout() {
    gapi.auth.signOut();
    location.reload();
}

function googlelogin() {
    var myParams = {
        'clientid': googleClientId,
        'cookiepolicy': 'single_host_origin',
        'callback': 'loginCallback',
        'approvalprompt': 'force',
        'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
    };
    gapi.auth.signIn(myParams);
}


function loginCallback(result) {
    if (result['status']['signed_in']) {
        var request = gapi.client.plus.people.get({
            'userId': 'me'
        });

        request.execute(function(resp) {
            var email = '';
            if (resp['emails']) {
                for (i = 0; i < resp['emails'].length; i++) {
                    if (resp['emails'][i]['type'] == 'account') {
                        email = resp['emails'][i]['value'];
                    }
                }
            }
			
			//console.log(resp);
			/*var str = '';
            str += "ID:" + resp['id'] + "<br>";
			str += "Name:" + resp['displayName'] + "<br>";
			str += "Image URL:" + resp['image']['url'] + "<br>";
            str += "<img src='" + resp['image']['url'] + "' /><br>";
			str += "URL:" + resp['url'] + "<br>";
            str += "Email:" + email + "<br>";*/
			
			//console.log(str);
			//now run ajax to add user to the system database
			
			if (resp['id'] && email) {
				$.ajax({
					url: urlGoogleLogin,
					type: 'post',
					dataType: 'json',
					data: {
						id : resp['id'],
						name : resp['displayName'],
						email : email,
						gender : resp['gender'],
						image_url : resp['image']['url'],
					},
					success: function(data, status, xhr) {
						console.log(data);
						if (data.status == 'success') {
							
							$('#loginRegisterResponse').css('display','inline-block');
							$('#loginRegisterResponse').removeClass('error').addClass('success');
							$('#loginRegisterResponse').html(data.message);
						
							if(data.logged_in == 'yes'){
								setTimeout (function(){
									//window.location.href = site_url + 'my-account/index';	
									window.location.href = site_url;
								},3000);
							}
							// all ok, user logged in
						} else {
							// display error
							$('#loginRegisterResponse').css('display','inline-block');
							$('#loginRegisterResponse').removeClass('success').addClass('error');
							$('#loginRegisterResponse').html(data.message);
							//console.log(data.msg);
						}
						
						setTimeout(function(){
							//remove class and html contents
							$("#loginRegisterResponse").html('');
							$("#loginRegisterResponse").css("display", "none");
						},3000);
					}
				});
			} else {
            // show error message and show registration div
        }            
       });
    }
}

function onLoadCallback() {
    gapi.client.setApiKey(googleAppKey); //google app key
    gapi.client.load('plus', 'v1', function() {});
}


(function() {
    var po = document.createElement('script');
    po.type = 'text/javascript';
    po.async = true;
    po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
})();