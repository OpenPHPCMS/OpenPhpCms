<?PHP ob_start();

/* * * define the site path * * */
$site_path = realpath(dirname(__FILE__)).'/';
define('__SITE_PATH', $site_path);

/* * * define the application path * * */
$application_path = realpath(dirname(__FILE__)).'/application/';
define('__APPLICATION_PATH', $application_path);

/* * * define the config path * * */
$config_path = realpath(dirname(__FILE__)).'/application/config/';
define('__CONFIG_PATH', $config_path);

/* * * Include error handling * * */
require(__APPLICATION_PATH.'core/Errors.php');

/* * * include the System Initialization File * * */
require(__APPLICATION_PATH . 'core/OpenPhpCms.php');




//Temp Demo
?>
<html>
<head>
	<title>OpenPHPCMS - Daily Build Prototype</title>
</head>
<body>

<h3>This is an prototype and there is no front end yet</h3>

<p>
	<?php
	$filename = 'index.php';
	if (file_exists($filename)) {
		$Date = date ("F d Y H:i", filemtime($filename));
	}
	?>
	This daily build has been updated on <?php echo $Date; ?>.<br />
	The next update will be on <?php echo date('F d Y', strtotime($Date. ' + 1 days'));?>  00:00.
</p>
<p>
	You can visit the admin panel <a href="<?PHP echo base_url('admin') ?> ">here</a>
</p>
<p>Admin panel accounts: </p>
<table>
  <tr>
  	<th>Username</th>
  	<th>Password</th>
  </tr>
<tr>
	<td>admin</td>
	<td>admin</td>
</tr>
<tr>
	<td>dev</td>
	<td>dev</td>
</tr>
<tr>
	<td>user</td>
	<td>user</td>
</tr>
</table>

</body>
</html>
