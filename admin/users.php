<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_ADMIN);

/* * * Inlude language file * * */
lang()->addSystemLangFile('users');

function user_role_name($roleID){ 
	if($roleID >= 30)
		return lang()->get('common_admin_name');
	else if($roleID >= 20)
		return lang()->get('common_dev_name');
	else if($roleID >= 10)
		return lang()->get('common_user_name');
	else 
		return lang()->get('common_guest_name');
}

$db = new OPC_Database();
$data['users'] = $db->select('OPC_Users');
load_view('users', $data);