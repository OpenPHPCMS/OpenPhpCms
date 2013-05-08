<?php 
/*
* ------------------------------------------------------
*  Function for showing errors messages
* ------------------------------------------------------
*/

if (!function_exists('display_error')) {

    function display_error($error = null) {
        if($error != null) {

            $_SESSION['OPC_admin_error'] = $error;

        } else if(!empty($_SESSION['OPC_admin_error'])) {

            require(__ADMIN_PATH."essentials/error_message.php");
            unset($_SESSION['OPC_admin_error']);

        }
    }

}

/*
* ------------------------------------------------------
*  Function for showing succes messages
* ------------------------------------------------------
*/

if (!function_exists('display_success')) {

    function display_success($success = null) {
        if($success != null) {

            $_SESSION['OPC_admin_success'] = $success;
        
        } else if(!empty($_SESSION['OPC_admin_success'])) {
            
            require(__ADMIN_PATH."essentials/success_message.php");
            unset($_SESSION['OPC_admin_success']);

        }
    }

}

/*
* ------------------------------------------------------
*  Function for loading admin views
* ------------------------------------------------------
*/
if (!function_exists('load_view')) {

    function load_view($file = null, $data = array()) {
    	/* Set variables from array */
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        require(__ADMIN_PATH."essentials/header.php");
		require(__ADMIN_PATH."essentials/sidebar.php");
		require(__ADMIN_PATH."essentials/topbar.php");
		echo "<section class=\"main\">";
        
        display_error();
        display_success();
        
        if($file != null) {

            $file = __ADMIN_PATH . 'views/' . $file . '.php';

            if (!is_readable($file)) 
                throw new Exception("View file not exists '" . $file . "'");
            
            require($file);
        }
        
        echo "</section>";
        require(__ADMIN_PATH."essentials/footer.php");
    }

}