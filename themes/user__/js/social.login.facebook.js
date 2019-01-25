// JavaScript Document

//facebook login script
    window.fbAsyncInit = function() {
        FB.init({
            appId: FacebookAppID, // Set YOUR APP ID
            channelUrl: 'http://connect.facebook.net/en_US/all.js', // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true, // parse XFBML
            version: 'v2.3' // use version 2.2
        });
    };


function facebookLogin() {
    //alert('login triggered');
    console.log('login triggered');
    FB.login(function(response) {
        if (response.authResponse) {
            getUserInfo();
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    }, {
        scope: 'email,user_photos,user_videos,user_birthday,user_location,public_profile'
    });
}



function getUserInfo() {
    console.log('Inside getUserInfo function');
    FB.api('/me', function(response) {

        /*var str="<b>Name</b> : "+response.name+"<br>";
          	str +="<b>Link: </b>"+response.link+"<br>";
          	str +="<b>Username:</b> "+response.username+"<br>";
          	str +="<b>id: </b>"+response.id+"<br>";
          	str +="<b>Email:</b> "+response.email+"<br>";
        	str +="<input type='button' value='Get Photo' onclick='getPhoto();'/>";
          	str +="<input type='button' value='Logout' onclick='Logout();'/>"; 
		console.log(str); return;*/

        if (response.id && response.email) {
            $.ajax({
                url: urlFacebookLogin,
                type: 'post',
                dataType: 'json',
                data: response,
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


function Logout() {
    FB.logout(function() {
        document.location.reload();
    });
}

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));