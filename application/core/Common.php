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
* Common Functions
*
* Loads the commen functions and classes.
*
* @package		OpenPhpCms
* @subpackage   Core
* @category     Core
* @author		Maikel Martens
*/
// ------------------------------------------------------------------------

/*
* Keep track of wich class is already loaded
*/

$loaded_class = array();

// ------------------------------------------------------------------------

/**
* Class Loader
*
* Loads file with name with $param.php
*
* @access	public
* @param	string	the class name being requested
* @param	string	the directory where the class should be found, default lib
* @return	boolean
*/
if (!function_exists('load_class')) {

    function load_class($class, $path = "lib") {
        global $loaded_class;
        $file = __APPLICATION_PATH . $path . "/" . $class . ".php";
        if (is_readable($file) && !in_array($class, $loaded_class)) {
            if($path == 'core')
                $class= 'OPC_'.$class;
            $loaded_class[] = $class;
            require($file);
            return true;
        } else {
            return false;
        }
    }

}

/**
* isValidUrlData
*
* Chekcs if given string is valid url data
* valid url data is: a-z A-Z 0-9 . / : - _ ~ %
*
* @access  public
* @param   string  Data needed to check
* @return  boolean
*/
if (!function_exists('base_url')) {
    
    function base_url($request = ''){
        $baseURL = OPC_Settings::get('base_url');
        if($baseURL == ''){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            return $protocol . "://" . $_SERVER['HTTP_HOST'] .'/'.$request;
        } else {
           return $baseURL.$request; 
        }
    }
    
}

/**
* random String
*
* Create an random string of the given length
*
* @access	public
* @param	int		the length of the random string
* @return	String
*/
if(!function_exists('random_string')){
    function random_string($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }
}

/**
* redirect
*
* redirect to given page or url
*
* @access   public
* @param    string     page/url
* @return   void
*/
if ( ! function_exists('redirect')) {
    function redirect($url = '') {
        if (!preg_match('#^https?://#i', $url)) {
            $url = base_url($url);
        }
        header("Location: ".$url, TRUE);
        die();
    }
}

/* load class OPC_Settings */
load_class("Settings", "core");

/* load class OPC_Database */
load_class("Database", "core");

/* load class OPC_Session */
load_class("Session", "core");

/* End of file Common.php */
/* Location: ./application/core/Common.php */