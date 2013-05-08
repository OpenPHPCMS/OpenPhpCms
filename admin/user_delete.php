<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_ADMIN);

/* * * Inlude language file * * */
lang()->addSystemLangFile('user_delete');

if(isset($_GET['username'])) {
	$username = $_GET['username'];
	
	$db = new OPC_Database();
	$db->where('username', $username);
	$result = $db->select('OPC_Users');
	
	if(empty($result)) {
		display_error(str_replace('[username]', $username, lang()->get('users_delete_user_not_exists')));
	} else {
		if($result[0]['level'] >= 40) {
			display_error(lang()->get('users_delete_cannot_del_owner'));
		} else {
			$db->delete('OPC_Users');
			display_success(str_replace('[username]', $username, lang()->get('users_delete_succes_message')));
		}
	}
}
redirect(__ADMIN_FOLDER.'/users.php');