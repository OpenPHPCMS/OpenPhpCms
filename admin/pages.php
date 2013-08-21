<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_USER);

/* * * Inlude language file * * */
lang()->addSystemLangFile('pages');

$data['types'] = '';

$path = __APPLICATION_PATH.'pages/';

foreach (scandir($path) as $file) {
	if($file != '.' && $file != '..' && is_dir($path.$file))
		$data['types'] = '<option>'.$file.'</option>\n';
}

$db = new OPC_Database();
$data['pages'] = $db->select('OPC_Pages');

load_view('pages', $data);