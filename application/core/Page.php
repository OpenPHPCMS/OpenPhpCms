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
* Page class
*
* Core class for all the pages, makes the calls to the type page object
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_Page {
	public $id;
	public $name;
	public $title;
	public $type;
	public $typeObject;
	public $layout;

	private $db;

	/**
	* Constructer
	*
	* Set database connection, page type and optional page id
	* when it is a page that already exists.
	*
	* @access public
	* @return void
	*/
	public function __construct($type, $id = null){
		$this->db 	= new OPC_Database();
		$this->type = $type;
		$this->id 	= $id;
		lang()->addSystemLangFile('page');
	}

	/**
	* getData
	*
	* Returns all the data from the page 
	*
	* @access public
	* @return void
	*/
	public function getData(){
		$data['name'] 	= $this->name;
		$data['title'] 	= $this->title;
		$data['type'] 	= $this->type;
		$data['layout'] = $this->layout;

		return array_merge($data, $this->typeObject->getData());
	}

	/**
	* validate
	*
	* Validate the data that is set and returns list with errors
	* when there are some. 
	*
	* @access public
	* @return void
	*/
	public function validate(){
		$errors = array();
		if(empty($this->name))
			$errors['name'][] = lang()->get('page_name_empty');

		if (preg_match("/[^a-zA-Z0-9-_]/i", $this->name))
			$errors['name'][] = lang()->get('page_name_invalid');

		$this->db->reset();
		$binds[] = $this->id == null ? 0 : $this->id;
		$binds[] = $this->name;
		$sql = "SELECT ID FROM OPC_Pages WHERE ID != ? AND lower(name) = lower(?)";
		$result = $this->db->query($sql, $binds);

		if(!empty($result))
			$errors['name'][] = lang()->get('page_name_already_exists');

		if(!is_dir( __APPLICATION_PATH.'pages/'.$this->type.'/' ))
			$errors['type'][] = lang()->get('page_type_not_exists');

		foreach ($this->typeObject->validate() as $key => $value) {
		    if(isset($errors[$key]))
		        $errors[$key] = array_merge($errors[$key], $value);
		    else
		        $errors[$key] = $value;
		}
		return $errors;
	}

	/**
	* save
	*
	* When no id is it wil insert an new page in database
	* else it wil update page in database.
	*
	* @access public
	* @return void
	*/
	public function save(){
		$this->db->reset();
		
		$binds['name'] 	= $this->name;
		$binds['title'] = $this->title;
		$binds['type'] 	= $this->type;
		$binds['layout']= $this->layout;

		if($this->id == null) {
			$this->db->insert('OPC_Pages', $binds);
			$this->id = $this->db->lastInsertId();
			$this->typeObject->page_id = $this->id;
			$this->typeObject->save();
		} else {
			$this->db->where('id', $this->id);
			$this->db->update('OPC_Pages', $binds);
			$this->typeObject->update();
		}	
	}

	/**
	* remove
	*
	* Remove all page data from database.
	*
	* @access public
	* @return void
	*/
	public function remove(){
		$this->typeObject->remove();
		
		$this->db->reset();
		$this->db->where('page_id', $this->id);
		$this->db->delete('OPC_Page_components');

		$this->db->reset();
		$this->db->where('id', $this->id);
		$this->db->delete('OPC_Pages');
	}
}

/* End of file Page.php */
/* Location: ./application/core/Page.php */