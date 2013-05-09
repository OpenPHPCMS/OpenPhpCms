<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_ADMIN);

/* * * Inlude language file * * */
lang()->addSystemLangFile('user_add');
lang()->addSystemLangFile('user_edit');

//redirect back when username not set
if(!isset($_GET['username'])) {
	display_error(lang()->get('user_edit_no_username'));
	redirect(__ADMIN_FOLDER.'/users.php');
}

$db = new OPC_Database();
$db->where('username', $_GET['username']);
$user = $db->select('OPC_Users');

if(empty($user)){
	display_error(lang()->get('user_edit_user_not_exists'));
	redirect(__ADMIN_FOLDER.'/users.php');
}

//Setting all view data
//---------------------------------------------------------------- 
$data['username'] 	= $user[0]['username'];
$data['password'] 	= '';
$data['level'] 		= $user[0]['level'];
$data['name'] 		= $user[0]['name'];
$data['surname'] 	= $user[0]['surname'];
$data['email'] 		= $user[0]['email'];

$data['error_password'] = '';
$data['error_level'] 	= '';
$data['error_name'] 	= '';
$data['error_surname'] 	= '';
$data['error_email'] 	= '';

//Handle form when submitted
//---------------------------------------------------------------- 
if(isset($_POST['user_submit'])){
	$data['username'] 	= $_POST['user_username'];
	$data['password'] 	= $_POST['user_password'];
	$data['level'] 		= $_POST['user_level'];
	$data['name'] 		= $_POST['user_name'];
	$data['surname'] 	= $_POST['user_surname'];
	$data['email'] 		= $_POST['user_email'];
	
	load_class('InputValidate','lib');
	$validate = new InputValidate();

	//Set validation
	if(strlen($data['password']) > 0 )
		$validate->add('password', $data['password'], 'none', 'empty = false; minlength = 6');
	
	$validate->add('level', $data['level'], 'numeric', 'empty = false');
	$validate->add('name', $data['name'], 'alphabet', 'empty = false');
	$validate->add('surname', $data['surname'], 'alphabet', 'empty = false');
	$validate->add('email', $data['email'], 'email', 'empty = false');

	$errors = $validate->validate();

	if(empty($errors)){
		if(strlen($data['password']) > 0 )
			$binds['password'] 	= secure()->hashPassword($data['password']);
		
		$binds['level'] 	= $data['level'];
		$binds['name'] 		= $data['name'];
		$binds['surname'] 	= $data['surname'];
		$binds['email'] 	= $data['email'];
		$db->update('OPC_Users', $binds);

		display_success(str_replace('[username]', $data['username'], lang()->get('user_edit_succes_message')));
		redirect(__ADMIN_FOLDER.'/users.php');
	}

	//set error message
	foreach ($errors as $input => $input_errors) {
		foreach ($input_errors as $error) {
			$data['error_'.$input] .= $error."<br/>";
		}
	}

}



$user_roles = array(
"0" 	=> lang()->get('common_guest_name'),
"10" 	=> lang()->get('common_user_name'),
"20" 	=> lang()->get('common_dev_name'),
"30" 	=> lang()->get('common_admin_name')
);

$data['user_roles'] = '';
foreach ( $user_roles as $key=>$value ) {
	$selected = ( ($data['level']==$key) ? 'selected="selected"' : '');
	$data['user_roles'].= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>\n';
}

load_view('user_edit', $data);