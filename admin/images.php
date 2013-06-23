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

$data['error_image_name'] = "";
$data['error_image_file'] = ""; 

$db = new OPC_Database();
$data['images'] = $db->select('OPC_Images');

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

load_view('images', $data);