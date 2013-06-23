<?PHP

/* * * define the site path * * */
$site_path = realpath(dirname(__FILE__).'/..').'/';
define('__SITE_PATH', $site_path);

/* * * define the application path * * */
define('__APPLICATION_PATH', __SITE_PATH.'application/');

/* * * define the admin path * * */
$admin_path = realpath(dirname(__FILE__)).'/';
define('__ADMIN_PATH', $admin_path);

/* * * define the config path * * */
define('__CONFIG_PATH', __APPLICATION_PATH.'config/');

/* * * define the admin folder * * */
$arr = explode('/', __ADMIN_PATH);
define('__ADMIN_FOLDER', $arr[count($arr)-2]);

/* * * Include error handling * * */
require(__APPLICATION_PATH.'core/Errors.php');

/*
* ------------------------------------------------------
*  Load the global functions and classes
* ------------------------------------------------------
*/
require(__APPLICATION_PATH.'core/Common.php');

/*
* ------------------------------------------------------
*  Load the admin functions
* ------------------------------------------------------
*/
require(__ADMIN_PATH.'admin_common.php');

/*
* ------------------------------------------------------
*  Load the OpenPhpCms settings
* ------------------------------------------------------
*/
OPC_Settings::init();

/*
* ------------------------------------------------------
*  Set Session handler and start session
* ------------------------------------------------------
*/
$handler = new OPC_Session();
session_set_save_handler(
    array($handler, 'open'),
    array($handler, 'close'),
    array($handler, 'read'),
    array($handler, 'write'),
    array($handler, 'destroy'),
    array($handler, 'gc')
    );

session_start();

/*
* ------------------------------------------------------
*  Load the OPC_Secure class and define user roles
* ------------------------------------------------------
*/
load_class('Secure', 'lib');

define('__ROLE_GUEST'	, 0);
define('__ROLE_USER'	, 10);
define('__ROLE_DEV'		, 20);
define('__ROLE_ADMIN'	, 30);
define('__ROLE_OWNER'   , 40);

function secure() {
    return Secure::getInstance();
}

function accessControl($user_role) {
    if( !secure()->hasUserAccess($user_role) ){
        display_error(lang()->get('common_no_access'));
        load_view();
        die();
    }
}

/*
* ------------------------------------------------------
*  Load the OPC_Language class and add common system language files
* ------------------------------------------------------
*/
load_class('Language', 'lib');

function lang() {
    return Language::getInstance();
}

lang()->addSystemLangFile('common');
lang()->addSystemLangFile('sidebar');
lang()->addSystemLangFile('topbar');

/*
* ------------------------------------------------------
*  Check if user is loggedin
* ------------------------------------------------------
*/
if(!defined('__LOGIN_PAGE') && !secure()->isLoggedin()){
	redirect(__ADMIN_FOLDER.'/login.php');
	die();
}
