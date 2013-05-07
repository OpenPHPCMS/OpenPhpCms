<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');
/**
* OpenPhpCms
*
* An open CMS for PHP/MYSQL
*
* @author		Maikel Martens
* @copyright   	Copyright (c) 20013 - 2013, openphpcms.org.
* @license		http://openphpcms.org/license.html
* @link			http://openphpcms.org
* @since		Version 1.0
*/
// ------------------------------------------------------------------------

/**
* Settings
*
* Class with all the OpenPhpCms settings
*
* @package		OpenPhpCms
* @subpackage  	Core
* @category    	Core
* @author		Maikel Martens
*/
// ------------------------------------------------------------------------

class OPC_Settings {
	private static $settings = array();

	/**
	* get
	*
	* get setting value of given setting name
	*
	* @access	public
	* @param	String		name of setting
	* @return	String 		value of setting 
	*/
	public static function get($name){
    	if(isset(self::$settings[$name]))
      		return self::$settings[$name];
	}

	/**
	* init
	*
	* Get all the settings
	*
	* @access	public
	* @param	String		name of setting
	* @return	String 		value of setting 
	*/
	public static function init(){
		$db = new OPC_Database();
		$db->where('appid','core');
		$result = $db->select('OPC_Settings');
		foreach ($result as $setting) {
			self::$settings[$setting['setting_name']] = $setting['setting_value']; 
		}
	}
}

/* End of file Settings.php */
/* Location: ./application/core/Settings.php */