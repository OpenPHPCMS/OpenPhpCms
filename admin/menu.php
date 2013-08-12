<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_DEV);

/* * * Inlude language file * * */
lang()->addSystemLangFile('menu');

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

// Save menu item
// ------------------------------------------------------------------------
if(isset($_POST['menu_submit'])) {
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
		$binds['order_number'] 	= $menu->latestOrderNumber()+1;

		$db->insert('OPC_Menu', $binds);
		display_success( lang()->get('menu_item_added') );
	} else {
		foreach ($errors as $input => $input_errors) {
			foreach ($input_errors as $error) {
				$data['error_'.$input] .= $error."<br/>";
			}
		}
	}
}
// ------------------------------------------------------------------------
// Save menu order
// ------------------------------------------------------------------------
if(isset($_POST['menu_save'])) {
	unset($_POST['menu_save']);
	foreach ($_POST as $key => $value) {
		$binds['order_number'] = $value;
		$db->where('id', $key);
		$db->update('OPC_Menu', $binds);
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
	$data['parents'] .= "<option".($item['name'] == $data['parent'] ? 'selected': '')." value='".$item['id']."'>".$item['name']."</option>\n";
}
// ------------------------------------------------------------------------
$data['menu'] = '';

$menuItems 	= $menu->getMenu();
$itemCount 	= count($menuItems);
$itemNr 	= 1;

//Create table rows for menu items
// ------------------------------------------------------------------------
foreach ($menuItems as $item) {
	$childCount = count($item['childeren']);
	
	$data['menu'] .= "<tr><td>".$item['name']."</td>\n"
	."<td>".$item['link']."</td>\n"
	."<td><select name='".$item['id']."'>\n";
	
	for($index=1; $index <= $itemCount; $index++)
		$data['menu'] .= "<option ".($index == $item['order_number'] ? 'selected': '').">".$index."</option>\n";

	$data['menu'] .= "</select></td></tr>\n";
	foreach ($item['childeren'] as $child) {

		$data['menu'] .= "<tr><td> &nbsp;&nbsp;&nbsp;- ".$child['name']."</td>\n"
		."<td> &nbsp;&nbsp;&nbsp;- ".$child['link']."</td>\n"
		."<td> &nbsp;&nbsp;&nbsp;- <select name='".$child['id']."'>\n";
		
		for($index=1; $index <= $childCount; $index++)
			$data['menu'] .= "<option ".($index == $child['order_number'] ? 'selected': '').">".$index."</option>\n";

		$data['menu'] .= "</select></td></tr>\n";
	}

	$itemNr++;
}
// ------------------------------------------------------------------------

load_view('menu', $data);