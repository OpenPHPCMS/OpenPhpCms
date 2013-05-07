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
* Secure class
*
* Secure class handle the login and authorization
*
* @package		OpenPhpCms
* @subpackage   lib
* @category     lib
* @author		Maikel Martens
*/
// ------------------------------------------------------------------------
class Secure {
	private static $secure = null;

	private function __construct(){}

	public static function getInstance(){
		if(self::$secure == null)
			self::$secure = new Secure();
		return self::$secure;
	}

	/**
	* hashPassword
	*
	* Hash an password with a sald,
	* when no sald is given it wil generate one.
	*
	* @access public
	* @param string password
	* @param String salt
	* @return String
	*/
	function hashPassword($pass, $salt = null) {
		if($salt == null)
	  		$salt = substr(md5(time()),0,8);
	  	$encrypted = '';
	  	for($i = 0; $i<10000; $i++) {
	    	$encrypted = hash("sha512",$salt . $pass . $encrypted . $pass . $salt);
	  	}
	  	return $salt.$encrypted;
	}

	/**
	* checkPassword
	*
	* Check if given password match the hasht password
	*
	* @access public
	* @param string password
	* @param String password hash
	* @return boolean
	*/
	function checkPassword($password, $hash){
	  	if($hash == $this->hashPassword($password, substr($hash,0,8)))
	    	return true;
	  	else 
	    	return false;
	}

	/**
	* login
	*
	* Login the user with given username and password,
	* returns true on success.
	*
	* @access public
	* @param string username
	* @param String password
	* @return boolean
	*/
	function login($username, $password){
		$db = new OPC_Database();
		$binds[] = $username;
		$sql = "SELECT * FROM OPC_Users WHERE lower(username) = lower(?)";
		$user = $db->query($sql, $binds);

		if(!empty($user) && $this->checkPassword($password, $user[0]['password'])){
			$_SESSION['user_username'] 	= $user[0]['username'];
			$_SESSION['user_password'] 	= $user[0]['password'];
			$_SESSION['user_level'] 	= $user[0]['level'];
			$_SESSION['user_name'] 		= $user[0]['name'];
			$_SESSION['user_surname'] 	= $user[0]['surname'];
			$_SESSION['user_email'] 	= $user[0]['email'];
			return true;
		}
		return false;
	}

	/**
	* logout
	*
	* Destroy login user session
	*
	* @access public
	* @return -
	*/
	function logout(){
		unset( $_SESSION['user_username'] );
		unset( $_SESSION['user_password'] );
		unset( $_SESSION['user_level'] );
		unset( $_SESSION['user_name'] );
		unset( $_SESSION['user_surname'] );
		unset( $_SESSION['user_email'] );
	}

	/**
	* isLoggedin
	*
	* Check if a user is loggedin, retun true when loggedin
	*
	* @access public
	* @return boolean
	*/
	function isLoggedin(){
		if(isset($_SESSION['user_level']))
			return true;
		return false;
	}

	/**
	* hasUserAccess
	*
	* Check if loggedin user has the required user role
	*
	* @access public
	* @param int user role
	* @return boolean
	*/
	function hasUserAccess($roleID){
		if(isset($_SESSION['user_level']) && $_SESSION['user_level'] >= $roleID)
			return true;
		return false;
	}
}