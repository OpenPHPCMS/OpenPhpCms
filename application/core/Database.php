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
* Database Connection class
*
* Holds one instance of the database connection
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_Database_Connection{
    private static $conn = null;

    public static function getConnection(){
        if(self::$conn == null){
            require(__CONFIG_PATH . 'database.php');

            self::$conn = new PDO(
                            "mysql:host=" . $host . ";port=" . $port . ";dbname=" . $database,
                            $user,
                            $password,
                            array(PDO::ATTR_PERSISTENT => true)
            );
        }
        return self::$conn;
    }
}

/**
* Database class
*
* Database class for MYSQL uses PDO.
*
* @package		OpenPhpCms
* @subpackage   Core
* @category     Core
* @author		Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_Database {
	private $dbh;
    private $stmt;
    private $where_field = null;
    private $where_value = null;
    private $orderby_field = null;
    private $orderby_sort = null;

    /**
	* Constructer
	*
	* Get the PDO object and store it in $dbh
	*
	* @access public
	* @return void
	*/
    public function __construct() {
        $this->dbh = OPC_Database_Connection::getConnection();
    }

	/**
	* Query
	*
	* Qeury the given sql statement, if there are binds in the query the
	* can be suplied by the second param as array
	*
	* @access public
	* @param string mysql query
	* @param array binds
	* @return void
	*/
    public function query($query, $binds = array()) {

        /* check if binds in qeury equals array lenght */
        if ($this->countBinds($query) != count($binds)) {
            throw new Exception("Binds in qeury are not equal to binds array");
        }

        /* prepare statement */
        $this->stmt = $this->dbh->prepare($query);

        /* Bind binds */
        $bindPostion = 1;
        foreach ($binds as $value) {
            $this->bind($bindPostion, $value);
            $bindPostion++;
        }

        /* Execute statement */
        $this->stmt->execute();
        return $this->stmt->fetchAll();
    }

    /**
	* Reset
	*
	* Reset the where and orderBy.
	*
	* @access public
	* @return void
	*/
    public function reset(){
        $this->where_field = null;
        $this->where_value = null;
        $this->orderby_field = null;
        $this->orderby_sort = null;
    }

    /**
    * lastInsertId
    *
    * Returns the last ID used with insert query
    *
    * @access public
    * @return int
    */
    public function lastInsertId(){
        return $this->dbh->lastInsertId(); 
    }

    /**
	* where
	*
	* Sets the where condition for the get, delete, update functions.
	*
	* @access public
	* @param string field
	* @param array value
	* @return void
	*/
    public function where($field, $value) {
        $this->where_field = $field;
        $this->where_value = $value;
    }

    /**
	* orderby
	*
	* Sets the order by for the get function.
	*
	* @access public
	* @param string mysql query
	* @param array binds
	* @return void
	*/
    public function orderBy($field, $sort = 'DESC'){
        $this->orderby_field = $field;
        $this->orderby_sort = $sort;
    }

    /**
	* get function
	*
	* Get array from the given table.
	*
	* @access public
	* @param string Database table name
	* @param int How many rows, default null
	* @param int From wich row, default 0
	* @return Array with row arrays
	*/
    public function select($table, $rows = null, $fromRow = 0) {
        $query = "SELECT * FROM " . $table;
        $whereBind = array();

        /* Add WHERE when $where_field and $where_value are set */
        if ($this->where_field !== null && $this->where_value !== null) {
            $query .= " WHERE " . $this->where_field . " = ? ";
            $whereBind[] = $this->where_value;
        }

        /* Add ORDER BY when $this->orderby_field and $this->orderby_sort are set */
        if(!empty($this->orderby_field) && !empty($this->orderby_sort)){
            $query .= " ORDER BY ".$this->orderby_field." ".$this->orderby_sort;
        }

        /* Add LIMIT when given in function */
        if ($rows != null && is_int($rows) && is_int($fromRow)) {
            $query .=" LIMIT " . $fromRow . " , " . $rows;
        }
        return $this->query($query, $whereBind);
    }

    /**
	* delete
	*
	* Delete a record in database, where must been set
	*
	* @access public
	* @param string table
	* @return void
	*/
    public function delete($table) {
        $query = "DELETE FROM " . $table;
        $whereBind = array();

        /* Checks if $where_field and $where_value are set */
        if ($this->where_field == null || $this->where_value == null) {
            throw new Exception("WHERE not set delete function only removes one record!");
        }

        $query .=" WHERE " . $this->where_field . " = ?";
        $whereBind[] = $this->where_value;

        return$this->query($query, $whereBind);
    }

    /**
	* insert
	*
	* insert record in table, insert data is supplied in array where key is table field
	*
	* $insert['id'] = null;
	* $insert['title'] = "Some text";
	*
	* @access public
	* @param string table
	* @param array field => values
	* @return void
	*/
    public function insert($table, $values = array()) {
        $query = "INSERT INTO " . $table . " (";
        $fieldNumbers = count($values);

        /* Checks if there are values */
        if ($fieldNumbers == 0) {
            throw new Exception("No values where given!");
        }

        /* Add insert fields to qeury */
        $firstValueSet = false;
        foreach ($values as $key => $value) {
            if (!$firstValueSet) {
                $query .= " " . $key;
                $firstValueSet = true;
            } else {
                $query .= "," . $key . " ";
            }
        }

        $query .= ") VALUES (";

        /* Add ? for binding the data */
        $firstValueSet = false;
        foreach ($values as $key => $value) {
            if (!$firstValueSet) {
                $query .= " ?";
                $firstValueSet = true;
            } else {
                $query .= ", ?";
            }
        }

        $query .= ")";
        return $this->query($query, $values);
    }

    /**
	* update
	*
	* update record in table, update data is supplied in array where key is table field
	*
	* $update['id'] = null;
	* $update['title'] = "Some text";
	*
	* @access public
	* @param string table
	* * @param array field => values
	* @return void
	*/
    public function update($table, $values = array()) {
        $query = "UPDATE " . $table . " SET ";
        $fieldNumbers = count($values);

        /* Checks if $where_field and $where_value are set */
        if ($this->where_field == null || $this->where_value == null) {
            throw new Exception("WHERE not set for update!");
        }

        /* Checks if there are values */
        if ($fieldNumbers == 0) {
            throw new Exception("No values where given!");
        }

        /* Add update fields to qeury */
        $firstValueSet = false;
        foreach ($values as $key => $value) {
            if (!$firstValueSet) {
                $query .= " " . $key . " = ?";
                $firstValueSet = true;
            } else {
                $query .= ", " . $key . " = ?";
            }
        }

        /* Add the where_value to the binds */
        $values[] = $this->where_value;
        $query .= " WHERE " . $this->where_field . " = ?";

        return $this->query($query, $values);
    }
    
    public function numRows($table) {
        $query = "SELECT count(*) FROM ".$table;
        $result = $this->query($query);
        if(isset($result[0][0])){
            return $result[0][0];
        }
        return false;
    }

    /**
	* bind
	*
	* Determinate the type of the value en bind it
	*
	* @access public
	* @param string bind postition
	* @param string value
	* @param string type
	* @return void
	*/
    private function bind($pos, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($pos, $value, $type);
        return $this;
    }

    /**
	* countBinds
	*
	* Determinate the amount af binds '?' in query
	*
	* @access public
	* @param string query
	* @return void
	*/
    private function countBinds($qeury) {
        $count = 0;
        for ($i = 0; $i < strlen($qeury); $i++) {
            if (substr($qeury, $i, 1) == '?') {
                $count++;
            }
        }
        return $count;
    }
}

/* End of file Database.php */
/* Location: ./application/core/Database.php */