<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');

/**
* OpenPhpCms
*
* An open CMS for PHP/MYSQL
*
* @author       Maikel Martens
* @copyright    Copyright (c) 20013 - 2013, openphpcms.org.
* @license      http://openphpcms.org/license.html
* @link         http://openphpcms.org
* @since        Version 1.0
*/
// ------------------------------------------------------------------------

/**
* Menu class
*
* For getting the menu items.
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class Menu {
    private $db;

    public function __construct(){
        $this->db = new OPC_Database();
    }

    /**
    * getMenuItems
    *
    * get an one level items array
    *
    * @access public
    * @param int parent
    * @return void
    */
    public function getMenuItems($parent = 0){
        $binds[] = $parent;
        $sql = "SELECT * FROM OPC_Menu WHERE parent = ? ORDER BY ISNULL(order_number), order_number ASC";
        return $this->db->query($sql, $binds);
    }

    /**
    * latestOrderNumber
    *
    * Get the last order number of specified menu
    *
    * @access public
    * @param int parent
    * @return void
    */
    public function latestOrderNumber($parent = 0){
        $binds[] = $parent;
        $sql = "SELECT count(*) FROM OPC_Menu WHERE parent = ?";
        $result = $this->db->query($sql , $binds);
        return $result[0][0];
    }

    /**
    * getMenu
    *
    * Get the menu. child items are set in seperate array in the parrent
    * under the key childeren
    *
    * @access public
    * @return void
    */
    public function getMenu(){
        $menu = $this->getMenuItems();
        foreach ($menu as $key => $item) {
            $menu[$key]['childeren'] = $this->getMenuItems($item['ID']);
        }
        return $menu;
    }

    /**
    * createCache
    *
    * Create a cache of the menu that is used by the frontend.
    *
    * @access public
    * @return void
    */
    public function createCache(){
        $fileName = __SITE_PATH."data/cache/menu.php";
        if(file_exists($fileName))
            unlink($fileName);

        $fileHandle = fopen($fileName, 'w');
        $menu = $this->getMenu();
        $cache = "<div id='opc_menu'>\n<ul>\n";

        foreach ($menu as $item) { 
            $cache .= " <li>\n"
                    . "  <a href='".$this->getUrl($item['link'])."'>".$item['name']."</a>\n";
                
                if(!empty($item['childeren'])) {
                    $cache .= "\t<ul>\n";
                    foreach ($item['childeren'] as $child) {
                        $cache .= "\t <li>\n"
                                . "\t  <a href='".$this->getUrl($child['link'])."'>".$child['name']."</a>\n"
                                . "\t </li>\n";
                    }
                    $cache .= "\t</ul>\n";
                }

            $cache .= " </li>\n";
        }

        $cache .= "</ul>\n</div>\n";

        fwrite($fileHandle, $cache);
        fclose($fileHandle);
    }

    /**
    * getUrl
    *
    * Get the url from an item link.
    *
    * @access private
    * @return String    url
    */
    private function getUrl($link) {
        if(strlen($link) > 5 && strtolower( substr($link, 0, 4) ) == "http")
            return $link;
        return base_url( str_replace(' ', '_', $link) );
    }
}