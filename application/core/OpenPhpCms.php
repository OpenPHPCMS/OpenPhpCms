<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');

/*
* ------------------------------------------------------
*  Load the global functions and classes
* ------------------------------------------------------
*/
require(__APPLICATION_PATH . 'core/Common.php');
/* load class OPC_Page */
load_class("Page", "core");
/* load class OPC_PageFactory */
load_class("PageFactory", "core");
/* load class OPC_PageFactory */
load_class("Router", "core");
/* load class OPC_PageFactory */
load_class("Template", "core");

/*
* ------------------------------------------------------
*  Set Session handler
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

/*
* ------------------------------------------------------
*  Load the OpenPhpCms settings
* ------------------------------------------------------
*/
OPC_Settings::init();

/*
* ------------------------------------------------------
*  Load the OPC_Language class and add common system language files
* ------------------------------------------------------
*/
load_class('Language', 'lib');

function lang() {
    return Language::getInstance();
}

/*
* ------------------------------------------------------
*  Get page if page is null display 404 page and die()
* ------------------------------------------------------
*/
$route 	= new OPC_Router();
$page 	= $route->getPage();

if($page == null) {
	require(__APPLICATION_PATH.'templates/errors/404.php');
	die();
}

/*
* ------------------------------------------------------
*  Load and display template
* ------------------------------------------------------
*/
$template = new OPC_Template();
$template->displayPage($page);
