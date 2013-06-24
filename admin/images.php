<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_USER);

/* * * Inlude language file * * */
lang()->addSystemLangFile('images');

//Setting all view data
//----------------------------------------------------------------
$data['image_name'] = "";
$data['image_file'] = "";
$data['update_error'] = "false";
$data['update_id'] 	= "";
$data['update_url'] = "";
$data['update_name']= "";
$data['update_error_message'] = "";

$data['error_image_name'] = "";
$data['error_image_file'] = ""; 

$db = new OPC_Database();

//Handle form when submitted
//---------------------------------------------------------------- 
if(isset($_POST['image_submit'])) {
	$data['image_name'] = $_POST['image_name'];
	if($_FILES['image_file']['error'] == 0) {
		
		load_class('InputValidate','lib');
		$validate = new InputValidate();

		$validate->add('image_name', $data['image_name'], 'none', 'empty = false');

		$errors = $validate->validate();
		load_class('ImageUpload','lib');
		$ImageUpload = new ImageUpload($_FILES['image_file']);

		if(empty($errors) && $ImageUpload->upload()){
			$binds['name'] 	= $data['image_name'];
			$binds['file_name'] 	= $ImageUpload->getImageName();
			$binds['created_by'] 	= $_SESSION['user_username'];
			$db->insert('OPC_Images', $binds);

			display_success(str_replace('[image]', $data['image_name'], lang()->get('images_succes_message')));
		}

		//set error message
		foreach ($errors as $input => $input_errors) {
			foreach ($input_errors as $error) {
				$data['error_'.$input] .= $error."<br/>";
			}
		}
	} else {
		$data['error_image_file'] = lang()->get('images_no_file_uploaded');
	}
}

if(isset($_SESSION['image_edit_id'])) {
	$data['update_error'] = "true";
	$data['update_id'] 	= $_SESSION['image_edit_id'];
	$data['update_name']= $_SESSION['image_edit_name'];
	$data['update_url'] = $_SESSION['image_edit_url'];
	$data['update_error_message'] = $_SESSION['image_edit_error'];
	unset($_SESSION['image_edit_id']);
	unset($_SESSION['image_edit_name']);
	unset($_SESSION['image_edit_url']);
	unset($_SESSION['image_edit_error']);
}

$data['images'] = $db->select('OPC_Images');

load_view('images', $data);