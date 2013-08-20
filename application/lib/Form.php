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
* Form class
*
* For generating html forms.
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class Form {
	private static $form = null;

	private function __construct(){}

	public static function getInstance(){
		if(self::$form == null)
			self::$form = new Form();
		return self::$form;
	}

	/**
    * text
    *
    * Print out the text form
    *
    * @access public
    * @param string post name
    * @param string label name
    * @param string info
    * @param string value
    * @param string error
    * @return void
    */
    public function text($name, $label, $info, $value = '', $error = ''){
        $html = "<p>\n <label class='formlabel'>$label</label>\n"
            .   " <label class='help'>$info</label>\n"
            .   " <input class='textfield' type='text' name='$name' value='$value'/>\n"
            .   " <span class='formError'>".$error."</span>\n"
            .   "</p>\n";
        echo $html;
    }

    /**
    * text
    *
    * Print out the select form
    *
    * @access public
    * @param string post name
    * @param string label name
    * @param string info
    * @param array list (options)
    * @param string value
    * @param string error
    * @return void
    */
    public function select($name, $label, $info, $list, $value = '', $error = ''){
        $html = "<p>\n <label class='formlabel'>$label</label>\n"
            .   " <label class='help'>$info</label>\n"
            . " <select name='$name'>\n";
        if (is_array($list)) {
            foreach ($list as $i_value => $i_content) {
                $selected = $value == $i_value ? 'selected' : ''; 
                $html .= "  <option $selected value='$i_value'>$i_content</option>\n";
            }
        }
        $html .= " </select>\n</p>\n";
        echo $html;
    }
}