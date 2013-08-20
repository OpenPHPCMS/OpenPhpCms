<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_DEV);

/* * * Inlude language file * * */
lang()->addSystemLangFile('menu_edit');

$data['id']			= '';
$data['name'] 		= '';
$data['link_select']= 'exturl';
$data['link_url'] 	= '';
$data['parent'] 	= '';

$data['error_name'] 	= '';
$data['error_link'] 	= '';
$data['error_parent'] 	= '';

load_class('Menu');
$db = new OPC_Database();
$menu = new Menu($db);

if(isset($_GET['item']))
	$data['id'] = $_GET['item'];


$db->where('ID', $data['id']);
$item = $db->select('OPC_Menu');
if(empty($item)) {
	display_success( lang()->get('menu_edit_not_exists') );
	redirect(__ADMIN_FOLDER.'/menu.php');
} else {
	$data['name'] = $item[0]['name'];

	$db->reset();
	$isInternPage = false;
	foreach ($db->select('OPC_Pages') as $page) {
		if ($page['name'] == $item[0]['link'])
			$isInternPage = true; 
	}
	if($isInternPage)
		$data['link_select'] = $item[0]['link'];
	else 
		$data['link_url'] = $item[0]['link'];
	
	$data['parent'] = $item[0]['parent'];
}

// Save menu item
// ------------------------------------------------------------------------
if(isset($_POST['menu_submit'])) {
	$data['id']			= $_POST['id'];
	$data['name'] 		= $_POST['name'];
	$data['link_select']= $_POST['link_select'];
	$data['link_url']	= $_POST['link_url'];
	$data['parent'] 	= $_POST['parrent'];

	if($data['link_select'] == "exturl")
		$data['link'] = $data['link_url'];
	else
		$data['link'] = $data['link_select'];

	load_class('InputValidate','lib');
	$validate = new InputValidate();
	
	//validation
	$validate->add('name', $data['name'], 'none', 'empty = false');
	$validate->add('link', $data['link'], 'none', 'empty = false');
	$validate->add('parent', $data['parent'], 'numeric');

	$errors = $validate->validate();
	if(empty($errors)){
		$binds['name'] 			= $data['name'];
		$binds['link'] 			= $data['link'];
		$binds['parent'] 		= $data['parent'];
		if($data['parent'] != $item[0]['parent'])
			$binds['order_number'] 	= $menu->latestOrderNumber($data['parent'])+1;

		$db->where('ID', $data['id']);
		$db->update('OPC_Menu', $binds);
		$menu->createCache();
		display_success( lang()->get('menu_edit_item_saved') );
		redirect(__ADMIN_FOLDER.'/menu.php');
	} else {
		foreach ($errors as $input => $input_errors) {
			foreach ($input_errors as $error) {
				$data['error_'.$input] .= $error."<br/>";
			}
		}
	}
}

// ------------------------------------------------------------------------
// Create all the options for all the links
// ------------------------------------------------------------------------
$data['link_options'] = "";
$db->reset();
$pages = $db->select('OPC_Pages');
foreach ($pages as $page) {
	$selected = $page['name'] == $data['link_select'] ? 'selected': '';
	$data['link_options'] .= "<option $selected>"
	.$page['name']."</option>";
}
// Create all the options for all the pages
// ------------------------------------------------------------------------
$data['parents'] = '<option value="0"> - </option>';
foreach ($menu->getMenuItems() as $item) {
	if($item['ID'] != $data['id'])
		$data['parents'] .= "<option ".($item['ID'] == $data['parent'] ? 'selected': '')." value='".$item['ID']."'>".$item['name']."</option>\n";
}
// ------------------------------------------------------------------------
load_view('menu_edit', $data);