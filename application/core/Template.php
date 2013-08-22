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
* OPC_Template class
*
* Get and display the tempalte files and content
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_Template {
	private $page;
	private $pageData;

	public function displayPage($page){
		$this->page = $page;
		$this->pageData = $page->getData();
		$layout_file = __APPLICATION_PATH.'templates/layouts/'.$page->layout.'.php';
		if(is_file($layout_file))
			require($layout_file);
		else 
			require(__APPLICATION_PATH.'templates/errors/system_error.php');
	} 

	private function menu(){
		$menu_file = __SITE_PATH.'data/cache/menu.php';
		if(is_file($menu_file)) 
			require($menu_file);
	}

	private function content(){
		$conten_file_temp = __APPLICATION_PATH.'templates/pages/'.$this->page->type.'.php';
		$conten_file_page = __APPLICATION_PATH.'pages/'.$this->page->type.'/TEMP_'.$this->page->type.'.php';
		if(is_file($conten_file_temp)) {
			require($conten_file);
		} else if (is_file($conten_file_page)) {
			require($conten_file_page);
		}
	}

	private function display($key){
		if(isset($this->pageData[$key]))
            echo $this->pageData[$key];
	}
}