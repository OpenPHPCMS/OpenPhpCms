<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_USER);

/* * * Inlude language file * * */
lang()->addSystemLangFile('images');

if(isset($_GET['image'])){
	$image_id	= $_GET['image'];

	$db = new OPC_Database();
	$db->where("ID", $image_id);
	$image = $db->select('OPC_Images');

	if(!empty($image)) {
		$db->delete("OPC_Images");
		$file_name = $image[0]['file_name'];
		unlink(__SITE_PATH.'/data/images/'.$file_name);
		unlink(__SITE_PATH.'/data/images/thumbnails/'.$file_name);
		display_success(str_replace('[image]', $image[0]['name'], lang()->get('images_delete_succes')));
	} else {
		display_error(lang()->get("images_update_no_image"));
	}
} else {
	display_error(lang()->get("images_update_no_image"));
}
redirect(__ADMIN_FOLDER."/images.php");