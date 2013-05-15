<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * Inlude language file * * */
lang()->addSystemLangFile('user_add');

$error['input'] = "";

if(isset($_GET['input']) && isset($_GET['value'])) {
	$error['input'] = $_GET['input'];
	$value = $_GET['value'];

	load_class('InputValidate','lib');
	$validate = new InputValidate();

	switch ($error['input']) {
		case 'user_username':
			$validate->add('user_username', $value, 'alphanumeric', 'empty = false; minlength = 3');
			$db = new OPC_Database();
			$db->where('username', $value);
			$result = $db->select('OPC_Users');
			if(!empty($result)) 
				$error[] = str_replace('[username]', $value, lang()->get('user_add_error_user_exists'));
			break;
		case 'user_password':
			$validate->add('user_password', $value, 'none', 'empty = false; minlength = 6');
			break;
		case 'user_level':
			$validate->add('user_level', $value, 'numeric', 'empty = false');
			break;
		case 'user_name':
			$validate->add('user_name', $value, 'alphabet', 'empty = false');
			break;
		case 'user_surname':
			$validate->add('user_surname', $value, 'alphabet', 'empty = false');
			break;
		case 'user_email':
			$validate->add('user_email', $value, 'email', 'empty = false');
			break;
		default:
			break;
	}
	
	$errors = $validate->validate();

	if(!empty($errors)) 
		$error = array_merge($error, $errors[$error['input']]);
}
echo json_encode($error);

