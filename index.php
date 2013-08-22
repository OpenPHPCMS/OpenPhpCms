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
