<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_DEV);

/* * * Inlude language file * * */
lang()->addSystemLangFile('menu_delete');

if(isset($_GET['item'])) {
	$itemId = $_GET['item'];
	
	load_class('Menu');
	$db = new OPC_Database();
	$menu = new Menu($db);
	$db->where('ID', $itemId);
	$result = $db->select('OPC_Menu');

	
	if(empty($result)) {
		display_error( lang()->get('menu_delete_item_not_exists') );
	} else {
		$db->delete('OPC_Menu');
		$menu->createCache();
		display_success(str_replace('[item]', $result[0]['name'], lang()->get('menu_delete_succes_message')));
	}
}
redirect(__ADMIN_FOLDER.'/menu.php');