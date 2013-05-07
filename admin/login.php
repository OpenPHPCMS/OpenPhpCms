<?PHP
define('__LOGIN_PAGE'	, 1);

/* * * Import init * * */
require('admin_init.php');

/* * * Inlude language file * * */
lang()->addSystemLangFile('login');

$data['username'] 	= '';
$loginError 		= '';

if( isset($_POST['login_submit']) ){
	$data['username'] = $_POST['login_username'];
	
	if( $_POST['login_token'] != $_SESSION['login_token'] ) {

		$loginError  .= lang()->get('login_session').".<br/>";

	} else if( !secure()->login($_POST['login_username'], $_POST['login_password'])) {
		
		$loginError  .= lang()->get('login_invalid').".<br/>"; 

	}
	display_error($loginError);
}

if( secure()->isLoggedin()) {
	redirect(__ADMIN_FOLDER);
} else {
	$_SESSION['login_token'] = random_string(32);
	load_view('login', $data);
}