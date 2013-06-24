<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_USER);

/* * * Inlude language file * * */
lang()->addSystemLangFile('images');

if(isset($_POST['image_update_submit'])) {
	//$_SESSION['image_edit_name'] = $_POST['image_name'];
	$image_id	= $_POST['image_id'];
	$image_name = $_POST['image_name'];

	$db = new OPC_Database();
	$db->where("ID", $image_id);
	$image = $db->select('OPC_Images');

	if(!empty($image)) {
		load_class('InputValidate','lib');
		$validate = new InputValidate();

		$validate->add('image_name', $image_name, 'none', 'empty = false');

		$errors = $validate->validate();
		if(empty($errors)){
			$binds['name'] 	= $image_name;
			$db->update('OPC_Images', $binds);
			display_success(str_replace('[image]', $image_name, lang()->get('images_update_succes')));
		} else {
			$_SESSION['image_edit_id'] 		= $image_id;
			$_SESSION['image_edit_name'] 	= $image_name;
			$_SESSION['image_edit_url'] 	= base_url('data/images/thumbnails/'.$image[0]['file_name']);
			//set error message
			$_SESSION['image_edit_error'] = "";
			foreach ($errors as $input => $input_errors) {
				foreach ($input_errors as $error) {
					$_SESSION['image_edit_error'] .= $error."<br/>";
				}
			}
		}
	} else {
		display_error(lang()->get("images_update_no_image"));
	}
} else {
	display_error(lang()->get("images_update_no_image"));
}
redirect(__ADMIN_FOLDER."/images.php");