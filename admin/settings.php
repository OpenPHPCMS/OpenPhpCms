<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_ADMIN);

/* * * Inlude language file * * */
lang()->addSystemLangFile('settings');


$data['title'] 			= OPC_Settings::get('title');
$data['slogan'] 		= OPC_Settings::get('slogan');
$data['description'] 	= OPC_Settings::get('description');
$data['titleformat'] 	= OPC_Settings::get('title_format');
$data['email'] 			= OPC_Settings::get('admin_email');
$data['baseurl'] 		= OPC_Settings::get('base_url');
$data['language'] 		= OPC_Settings::get('language');
$data['error_title'] 			= '';
$data['error_slogan'] 			= '';
$data['error_description'] 		= '';
$data['error_titleformat'] 		= '';
$data['error_email'] 			= '';
$data['error_baseurl'] 			= '';
$data['error_language'] 		= '';
$data['languageOptions']	= '';

// Function for saving config item
//----------------------------------------------------------------
$db = new OPC_Database();
function save_config($key, $value) {
	global $db;
	$binds['value'] = $value;
	$sql = "UPDATE OPC_Settings SET setting_value = ? WHERE appid = 'core' AND setting_name = '$key';";
	$db->query($sql, $binds);
}

// Validate/Save form data
//----------------------------------------------------------------
if(isset($_POST['settings_save'])) {
	
	$data['title'] = $_POST['title'];
	$data['slogan'] = $_POST['slogan'];
	$data['description'] = $_POST['description'];
	$data['titleformat'] = $_POST['titleformat'];
	$data['email'] = $_POST['email'];
	$data['baseurl'] = $_POST['baseurl'];
	$data['language'] = $_POST['language'];
	

	load_class('InputValidate','lib');
 	$validate = new InputValidate();

 	//Set validation
 	$validate->add('email', $data['email'], 'email');

 	$errors = $validate->validate();

	if(empty($errors)){
		save_config('title', $data['title']);
		save_config('slogan', $data['slogan']);
		save_config('description', $data['description']);
		save_config('title_format', $data['titleformat']);
	 	save_config('admin_email', $data['email']);
	 	save_config('base_url', $data['baseurl']);
	 	save_config('language', $data['language']);
 	
 		display_succes(lang()->get('settings_success_message'));
 		redirect(__ADMIN_FOLDER.'/settings.php');
	} else {
		display_error(lang()->get('settings_error_message'));
	}

	foreach ($errors as $input => $input_errors) {
		foreach ($input_errors as $error) {
			$data['error_'.$input] .= $error."<br/>";
		}
	}
}

// Generate some HTML needed for the view
//----------------------------------------------------------------

//get language options
$path = __ADMIN_PATH.'languages'; 
foreach (scandir($path) as $file) {
	if ($file == '.' || $file == '..' || is_file($path.'/'.$file))
		continue;
	$selected = $file == OPC_Settings::get('language')? 'selected' : '';
	$data['languageOptions'] .= "<option $selected>".$file."</option>";
}

load_view('settings', $data);