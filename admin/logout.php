<?PHP

/* * * Import init * **/
require('admin_init.php');

secure()->logout();
redirect(__ADMIN_FOLDER.'/login.php');
