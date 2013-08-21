<?PHP
/* * * Import init * **/
require('admin_init.php');

/* * * check if user has access * * */
accessControl(__ROLE_USER);

/* * * Inlude language file * * */
lang()->addSystemLangFile('page_add');

$data['type'] 	= null;
$data['name'] 	= '';
$data['title'] 	= '';

//Get page type and give error when not selected
// ------------------------------------------------------------------------
if(isset($_GET['type']))
	$data['type'] = $_GET['type'];

if(isset($_POST['page_type']))
	$data['type'] = $_POST['page_type'];

if($data['type'] == null){
	display_error( lang()->get('pages_no_type_selected') );
	redirect(__ADMIN_FOLDER.'/pages.php');
}
// ------------------------------------------------------------------------

//Give error when type does not exists
// ------------------------------------------------------------------------
$page_type_path = __APPLICATION_PATH.'pages/'.$data['type'].'/';

if(!is_dir($page_type_path)) {
	display_error( lang()->get('pages_type_not_exists') );
	redirect(__ADMIN_FOLDER.'/pages.php');
}

define('__PAGE_TYPE', $data['type']);
// ------------------------------------------------------------------------

// Set all the necessary files and check if the exists
// ------------------------------------------------------------------------
$class_file = $page_type_path.$data['type'].'.php';
$form_file = $page_type_path.'FORM_'.$data['type'].'.php';
$content_file = $page_type_path.'CONTENT_'.$data['type'].'.php';

if(!is_file($class_file) || !is_file($form_file) || !is_file($content_file)){
	display_error( lang()->get('pages_not_all_necessary_files') );
	redirect(__ADMIN_FOLDER.'/pages.php');
}
// ------------------------------------------------------------------------

// Load page type language file.
// ------------------------------------------------------------------------	
lang()->addPageLangFile( $data['type'] );

// Load required classes and create OPC_Page object
// ------------------------------------------------------------------------	
load_class('Page', 'core');
load_class('PageFactory' , 'core');

$page = OPC_PageFactory::create($data['type'], $data['name']);
// ------------------------------------------------------------------------

// Create error index
// ------------------------------------------------------------------------
foreach ($page->getData() as $key => $value) {
	$data['error_'.$key] = '';
}
// ------------------------------------------------------------------------

// Process form when submitted
// ------------------------------------------------------------------------
if(isset($_POST['page_submit'])){
	$page->name = $_POST['name'];
	$page->title = $_POST['title'];

	unset($_POST['page_submit']);
	unset($_POST['name']);
	unset($_POST['title']);
	unset($_POST['type']);

	foreach ($_POST as $key => $value) {
		$data[$key] = $value;
		$page->typeObject->$key = $value;
	}

	$errors = $page->validate();
	
	if(empty($errors)) {
		$page->save();
		display_success( str_replace('[page]', $page->name, lang()->get('pages_succes_message'))  );
		redirect(__ADMIN_FOLDER."/pages.php");
	}

	//set error message
	foreach ($errors as $input => $input_errors) {
		foreach ($input_errors as $error) {
			$data['error_'.$input] .= $error."<br/>";
		}
	}
// ------------------------------------------------------------------------
}

$data = array_merge($data, $page->getData());
$data['page_form_file'] = $form_file;
$data['page_content_file'] = $content_file;

function template_url($request = ''){
    $baseURL = OPC_Settings::get('base_url');
    if($baseURL == ''){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'] .'/application/pages/'.__PAGE_TYPE.'/'.$request;
    } else {
       return $baseURL.'/application/pages/'.__PAGE_TYPE.'/'.$request; 
    }
}

load_view('page_add', $data);
