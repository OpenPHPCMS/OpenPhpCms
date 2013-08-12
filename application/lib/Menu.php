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
            $menu[$key]['childeren'] = $this->getMenuItems($item['id']);
        }
        return $menu;
    }
}