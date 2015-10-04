<?php 
foreach (glob("cgi-bin/*.php") as $filename) { include_once($filename); }
$config = ini::SettingArray('default.ini');

if(isset($_GET['ajax']) || isset($_POST['ajax'])):
	if(isset($config['language'])):	include_once('language/'.$config['language'].'.php'); endif;
	
	if(file_exists('site/ajax/'.$_GET['ajax'].'.php')) {
		include_once('site/ajax/'.$_GET['ajax'].'.php');
	} else {
		echo json_encode(array('error'=>'Ajax not Found.'));
	}
elseif(isset($_GET['html']) || isset($_POST['html'])):
	if(file_exists('site/html/'.$_GET['html'].'.html')) {
		include_once('site/html/'.$_GET['html'].'.html');
	} else {
		echo '<div id="exception">'._SITE_NONE_MODULE.'</div>';
	}
elseif(isset($_GET['doc']) || isset($_POST['doc'])): 
include_once('config.php');
if(isset($config['language'])):	include_once('language/'.$config['language'].'.php'); endif;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $config['title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config['charset']; ?>">
<link rel="stylesheet" type="text/css" href="site/css/style_css.css" />
</head>
<style>
body, table  {
	font-family:Angsana New !important;
	font-size:20px;
}

</style>
<body>
<?php
	if(file_exists('document/'.$_GET['doc'].'.html')) {
		include_once('document/'.$_GET['doc'].'.html');
	} else {
		echo '<div id="exception">'._SITE_NONE_MODULE.'</div>';
	}
?>
</body>
</html>
<?php
else: 
ob_start(); 
session_start(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php
error_reporting(-1);
date_default_timezone_set("Asia/Bangkok");

include_once('config.php');
if(isset($config['language'])):	include_once('language/'.$config['language'].'.php'); endif;
?>
<head>
<title><?php echo $config['title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config['charset']; ?>">
<meta name="Keywords" content="<?php echo $config['keywords']; ?>" />
<meta name="Description" content="<?php echo $config['description']; ?>" />
<link rel="shortcut icon" href="images/<?php echo $config['icon']; ?>">
<?php

foreach (glob("site/css/*.css") as $filename) { 
	echo '<link rel="stylesheet" type="text/css" href="'.$filename.'" />'."\n\r"; 
}
foreach (glob("plugins/*.js") as $filename) { 
	echo '<script type="text/javascript" src="'.$filename.'"></script>'."\n\r"; 
}
foreach (glob("site/js/*.js") as $filename) {
	echo '<script type="text/javascript" src="'.$filename.'"></script>'."\n\r"; 
}
?>
</head>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({ type: 'POST', dataType: 'json' });	
});
</script>
<body>
<?php
if(file_exists('site/index.php'))
{
	include_once('site/index.php');
} else {
	include_once('plugins/default.php');
}
?>
</body>
</html>
<?php 
ob_end_flush(); 
endif;
?>
