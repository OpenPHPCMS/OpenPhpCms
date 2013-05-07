<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');
/**
* OpenPhpCms
*
* An open CMS for PHP/MYSQL
*
* @author		Maikel Martens
* @copyright    Copyright (c) 20013 - 2013, openphpcms.org.
* @license		http://openphpcms.org/license.html
* @link         http://openphpcms.org
* @since		Version 1.0
*/
// ------------------------------------------------------------------------

/**
* Error handling
*
* Handle PHP errors and exceptions
*
* @package		OpenPhpCms
* @subpackage   Core
* @category     Core
* @author		Maikel Martens
*/
// ------------------------------------------------------------------------

/**
* OPC_error_handler
*
* Catch php errors and display info when debug is on
*
* @access	public
* @param	int		 level of the error raised
* @param	string	 error message
* @param	string	 filename that the error was raised in
* @param	string	 line number the error was raised at
* @return	boolean
*/
if (!function_exists('OPC_error_handler')) {
	function OPC_error_handler($errno, $errstr, $errfile, $errline) {
		$errorType = "";
		switch ($errno) {
    		case E_ERROR:
 				$errorType = "Fatal error";
        		break;
    		case E_WARNING:
    			$errorType = "Warning";
        		break;
    		case E_NOTICE:
 				$errorType = "Notice";
        		break;
        	case E_PARSE:
 				$errorType = "Parse error";
        		break;
    		default:
        		$errorType = "Unknown error";
        		break;
    	}
    	
    	$errorMessage ="PHP $errorType: $errstr in $errfile on line $errline";
    	error_log($errorMessage, 0);

    	displayError($errorType, $errstr, $errfile, $errline);
	    return true;
	}
}

/* * * Set OPC_error_handler as the function to handle PHP errors * * */
set_error_handler("OPC_error_handler");


/**
* OPC_exception_handler
*
* Catch php exceptions and display info when debug is on
* and log exceptions when log exception is on
*
* @access	public
* @param	Exception		exception object
* @return	void
*/
if (!function_exists('OPC_exception_handler')) {
	function OPC_exception_handler($exception) {
		require(__CONFIG_PATH.'config.php');
		if($log_exceptions){
			$errorMessage ="PHP Exception: ".$exception->getMessage()." in ".$exception->getFile()." on line ".$exception->getLine()
			.", referer: ".$_SERVER['SERVER_NAME'];
	    	error_log($errorMessage, 0);
    	}

  		displayError('Exception', $exception->getMessage(), $exception->getFile(), $exception->getLine());
	}
}

/* * * Set OPC_exception_handler as the function to handle exceptions * * */
set_exception_handler('OPC_exception_handler');


/**
* displayError
*
* Cleans the Output buffer and displays error.
*
* @access	public
* @param	String 	Error type name
* @param	String 	Error message
* @param	string	filename that the error was raised in
* @param	string	line number the error was raised at
* @return	void
*/
if (!function_exists('displayError')) {
	function displayError($errorType, $message, $filepath, $line ){
		ob_end_clean();

		require(__CONFIG_PATH.'config.php');
		if(!$debug_on){
			require(__APPLICATION_PATH.'templates/errors/system_error.php');
			die();
		} 	
		
echo <<<message
<html>
	<head>
		<title>A PHP Error was encountered</title>
	</head>
<body>
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h3>A PHP Error was encountered</h3>
<p>Error type:  $errorType</p>
<p>Message:  $message</p>
<p>Filename: $filepath</p>
<p>Line Number: $line</p>

</div>
</body>
</html>
message;
		die();
	} 
}

