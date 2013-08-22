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
* Router class
*
* Get the requesting page or show 404.
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_Router {
	private $page_name;

	public function getPage(){
		if( $this->loadUrl() ) {
			
			$db 		= new OPC_Database();
			$db->where('name', $this->page_name);
			$result = $db->select('OPC_Pages');
			if(!empty($result))
				return OPC_PageFactory::createPageObject($result[0]);
		}
		return null;
	}

	private function loadUrl(){
		if(isset($_GET['url'])) {
			$url_segments = explode('/', $_GET['url']);
			if(count($url_segments) >= 1){
				$this->page_name = $url_segments[0];
				return true;
			}
		}
		return false;
	}
}