<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');

/**
* OpenPhpCms
*
* An open CMS for PHP/MYSQL
*
* @author		Maikel Martens
* @copyright    Copyright (c) 20013 - 2013, openphpcms.org.
* @license		http://openphpcms.org/license.html
* @link         http://openphpcms.org
* @since		Version 1.0
*/
// ------------------------------------------------------------------------

/**
* PageFactory class
*
* Creating the OPC_Page objects and the typeObject that is associated with it
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_PageFactory {

	/**
	* create
	*
	* Get all the neceserya data from database to create page object
	* else create base object.
	*
	* @access public
	* @return OPC_Page
	*/
	public static function create($type, $name, $id = null){
		$path = __APPLICATION_PATH.'pages/'.$type.'/';
		$file = $path.$type.'.php';
		
		//Check if file and path are valid
		if(is_dir($path) && is_file($file)){
			require($file);
			$class = 'PAGE_'.$type;

			$result = null;
			$db = new OPC_Database();

			//Get page from database if exists
			if($id == null){
				$db->where('name', $name);
				$result = $db->select('OPC_Pages');
			} else {
				$db->where('ID', $id);
				$result = $db->select('OPC_Pages');
			}
			
			$page = null;

			//when page exists create object and fill with data
			if(!empty($result)){
				$page 			= new OPC_Page($type, $result[0]['ID']);
				$page->title 	= $result[0]['title'];
				$page->name 	= $result[0]['name'];
				$page->layout 	= $result[0]['layout'];

				//get typeObject data
				$db->reset();
				$db->where('page_id', $page->id);
				$result = $db->select('OPC_Page_content');

				//Create typeObject and add to OPC_Page
				$page->typeObject = new $class( $result, $page->id );

			} else {
				//Create base OPC_Page when not found in database
				$page = new OPC_Page($type);
				$page->typeObject = new $class( array() );
			}
		}
		return $page;
	}

	public static function createPageObject($result){
		if(!isset($result['ID']))
			return null;

		$file = __APPLICATION_PATH.'pages/'.$result['type'].'/'.$result['type'].'.php';
		if(!is_file($file))
			return null;

		require($file);
		$class = 'PAGE_'.$result['type'];

		$page 			= new OPC_Page($result['type'], $result['ID']);
		$page->title 	= $result['title'];
		$page->name 	= $result['name'];
		$page->layout 	= $result['layout'];

		//get typeObject data
		$db = new OPC_Database();
		$db->where('page_id', $page->id);
		$result = $db->select('OPC_Page_content');

		//Create typeObject and add to OPC_Page
		$page->typeObject = new $class( $result, $page->id );

		return $page;
	}
}