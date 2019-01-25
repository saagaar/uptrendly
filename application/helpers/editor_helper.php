<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function form_fckeditor($name = '', $value = '', $extra = '')
{
	include_once("./themes/ckeditor/ckeditor.php");
	include_once("./themes/ckfinder/ckfinder.php");
	
	$ckeditor = new CKEditor();
	$ckeditor->basePath	= site_url().'themes/ckeditor/';
	
	$config = array();
	$config['width']=970;
	$config['height']=300;
	
	$parse_url = parse_url(site_url());

	$ckfinder_basepath   = $parse_url['path'].'themes/ckfinder/';

	
	CKFinder::SetupCKEditor($ckeditor,$ckfinder_basepath);
	
	return $ckeditor->editor($name,$value,$config);
}

?>