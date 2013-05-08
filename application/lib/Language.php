<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');
/**
* OpenPhpCms
*
* An open CMS for PHP/MYSQL
*
* @author       Maikel Martens
* @copyright    Copyright (c) 20013 - 2013, openphpcms.org.
* @license      http://openphpcms.org/license.html
* @link         http://openphpcms.org
* @since        Version 1.0
*/
// ------------------------------------------------------------------------

/**
* Language class
*
* Handles all the language files
*
* @package      OpenPhpCms
* @subpackage   lib
* @category     lib
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class Language {
    private static $instance = null;
    private $language = array();

    /**
    * getInstance
    *
    * Get instance of OPC_Language
    *
    * @access public
    * @return OPC_Language
    */
    public static function getInstance(){
        if(self::$instance == null)
            self::$instance = new Language();
        return self::$instance;
    }

    private function addLangFile($path) {
       if(is_file($path)) {
            require($path);
            $this->language = array_merge($this->language, $language);
            return true;
        } 
        return false;
    }

    /**
    * addSystemLangFile
    *
    * Add an system language file to OPC_Language
    *
    * @access public
    * @param  String File name  
    * @return void
    */
    public function addSystemLangFile($file){
        //Add the default language file (EN)
        $path = __ADMIN_PATH."languages/EN/".$file.".php";
        $this->addLangFile($path);

        //Add the configured language file
        $lang = OPC_Settings::get('language');
        $path = __ADMIN_PATH."languages/".$lang."/".$file.".php";
        $this->addLangFile($path);
    }

    /**
    * addPageLangFile
    *
    * Add an page language file to OPC_Language
    *
    * @access public
    * @param  String File name  
    * @return void
    */
    public function addPageLangFile($page){
        /** 
        * @todo 
        */
    }

    /**
    * addComponentLangFile
    *
    * Add an component language file to OPC_Language
    *
    * @access public
    * @param  String File name  
    * @return void
    */
    public function addComponentLangFile($component){
        /** 
        * @todo 
        */
    }

    /**
    * get
    *
    * Get an translation from the given key,
    * if key not exists returns empty string
    *
    * @access public
    * @param  String key  
    * @return String
    */
    public function get($key){
        if(isset($this->language[$key]))
            return $this->language[$key];
        return '';
    }
}