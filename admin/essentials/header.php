<?PHP
	$arr      = explode('/', $_SERVER['PHP_SELF']);
	$search   = array('_', '.php');
	$replace  = array(' ', '');
	$title_file_name     = ucfirst( str_replace($search, $replace, $arr[count($arr)-1]) );
?>
<!doctype html>
<html>
<head>
	<title>OpenPhpCms - <?PHP echo $title_file_name ?></title>
<link href="<?PHP echo base_url(__ADMIN_FOLDER.'/css/stylesheet.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?PHP echo base_url(__ADMIN_FOLDER.'/js/jquery-1.9.1.min.js') ?>"></script>

<meta name="description" content="OpenPhpCms admin panel">
<meta name="author" content="OpenPHPCMS">
</head>