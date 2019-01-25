<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.0.27" )
    define('ROOT_SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/uptrendly/');
else if($_SERVER['HTTP_HOST'] == "nepaimpressions.com")
    define('ROOT_SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/dev/uptrendly/');
else if($_SERVER['HTTP_HOST'] == "202.79.37.78:8888")
	define('ROOT_SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/uptrendly/');
else
    define('ROOT_SITE_PATH','http://'.$_SERVER['HTTP_HOST'].'/');

//themes dir for common assets
define('THEMES_DIR', 'themes/');

	
//themes dir for admin
define('ADMIN_THEMES_DIR', 'themes/admin/');
define('ADMIN_CSS_DIR',ADMIN_THEMES_DIR.'css/');
define('ADMIN_JS_DIR',ADMIN_THEMES_DIR.'js/');
define('ADMIN_IMG_DIR',ADMIN_THEMES_DIR.'images/');

//jquery ui directory path
define('JQUERYUI_PATH',THEMES_DIR.'jqueryui/'); //path for jquery ui
define('DROPZONE_PATH',THEMES_DIR.'dropzone/'); //path for dropzone multiple image uploader

//for calendar
define('CALENDER_PATH',THEMES_DIR.'calender/');
// define('CALENDER_FULL_PATH',ROOT_SITE_PATH.THEMES_DIR.'calender/');

//for Tinymce Editor
define('TINYMCE_PATH',THEMES_DIR.'tinymce/');
// define('TINYMCE_FULL_PATH',ROOT_SITE_PATH.THEMES_DIR.'tinymce/');


//themes dir for website users
define('USER_THEMES_DIR', 'themes/user/');
define('USER_CSS_DIR',USER_THEMES_DIR.'css/');
define('USER_JS_DIR',USER_THEMES_DIR.'js/');
define('USER_IMG_DIR',USER_THEMES_DIR.'images/');

//define('MY_ACCOUNT',		'my-account/user/');
define('MY_ACCOUNT',		'my-account/');
define('BRAND', 'brand/');
define('CREATOR', 'creator/');


define('CAPTCHA_PATH',				'captcha/');
define('FONT_PATH',					ADMIN_THEMES_DIR.'/fonts/');

//admin login session
define('ADMIN_LOGIN_ID',			'admin_user_id');
define('ADMIN_USER_NAME',			'admin_user_name');
define('ADMIN_USER_TYPE',			'admin_user_type');

//admin & dashboard path
define('ADMIN_LOGIN_PATH',			'admin');
define('ADMIN_DASHBOARD_PATH',		'dashboard');

define('BIDPACKAGE_PATH',			'upload_files/bidpackage/');
// define('BID_PACKAGE_FULL_PATH',		ROOT_SITE_PATH.BIDPACKAGE_PATH);

//upload file location
define('BLOG_IMG_PATH',				'upload_files/blog/');
// define('BLOG_IMG_FULL_PATH', 		ROOT_SITE_PATH.'upload_files/blog/');

define('PAYMENT_API_LOGO_PATH',	 	'upload_files/payment/');

define('PRODUCT_IMAGE_PATH',		'upload_files/product-images/');
define('DRAFT_IMAGE_PATH',			'upload_files/draft-images/');
define('INVITATION_IMAGE_PATH',		'upload_files/invitation-images/');
define('PRODUCT_IMAGE_PATH_TEMP',	'upload_files/product-images-temp/');

define('USER_IMAGE_PATH',			'upload_files/user-images/');

define('CUSTOM_FIELDS_FILES_PATH',	'upload_files/custom-field-files/');

define('ATTACHMENTS_DIR', 			'communication/');
define('ATTACHMENT_UPLOAD_DIR',		'upload_files/attachment/');
define('ATTACHMENT_ADMIN_UPLOAD_DIR','upload_files/attachment_admin/');
define('ALLOW_ATTACHMENT_EXTENSION', 'gif|jpg|png|bmp|jpeg|doc|docx|pdf|txt|zip|rar|gz|tar|gtar');



/*PAGINATION PER PAGE*/
define('ADMIN_LIST_PERPAGE', 10); // NO OF ADMINS PERPAGE
define('ADMIN_PRODUCT_LIST_PERPAGE', 20); // No of products per page in product module 
define('ADMIN_VIEW_BID_LIST_PERPAGE',15);
define('ADMIN_VIEW_DISPUTE_LIST_PERPAGE',15);
define('ADMIN_MEMBER_LIST_PERPAGE',20);
define('FRONTEND_TABLE_DATA',5);

define('SESSION','UPTRENDLY');


define('HOW_AND_WHY_IMAGES',		'upload_files/how-and-why/');
define('BID_ATTACHMENTS',		'upload_files/bid-attachments/');


