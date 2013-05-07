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
* Session handler class
*
* Handle session to store in database
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class OPC_Session {
    private $db;

    /**
    * open
    *
    * Re-initialize existing session, or creates a new one. 
    * Called when a session starts or when session_start() is invoked. 
    *
    * @access public
    * @return boolean
    */
    function open() {
        $this->db = new OPC_Database();
        ini_set('session.gc_probability', 1); 
        ini_set('session.gc_divisor', 100); 
        return true;
    }

    /**
    * close
    *
    * Closes the current session. This function is automatically executed when closing the session, 
    * or explicitly via session_write_close(). 
    *
    * @access public
    * @return boolean
    */
    function close() {
        return true;
    }

    /**
    * read
    *
    * Reads the session data from the session storage, and returns the results. 
    * Called right after the session starts or when session_start() is called.
    *
    * @access public
    * @param String     Session ID
    * @return String    Session data
    */
    function read($id) {
        $this->db->reset();
        $this->db->where('ID',$id);
        $data = $this->db->select('OPC_Sessions');
        if(isset($data[0]['data']))
            return $data[0]['data'];
        return '';
    }

    /**
    * write
    *
    * Writes the session data to the session storage. Called by session_write_close(), 
    * when session_register_shutdown() fails, or during a normal shutdown.
    *
    * @access public
    * @param String     Session ID
    * @param String     Session data
    * @return boolean
    */
    function write($id, $data) {
        $binds[] = $id;
        $binds[] = time();
        $binds[] = $data;
        $sql = "REPLACE INTO OPC_Sessions VALUES (?, ?, ?)";

        $this->db->query($sql, $binds);
        return true;
    }

    /**
    * destroy
    *
    * Destroys a session. Called by session_regenerate_id() (with $destroy = TRUE), 
    * session_destroy() and when session_decode() fails. 
    *
    * @access public
    * @param String     Session ID
    * @return boolean
    */
    function destroy($id) {
        $this->db->reset();
        $this->db->where('ID',$id);
        $this->db->delete('OPC_Sessions');
        return true;
    }

    /**
    * gc
    *
    * Cleans up expired sessions. Called by session_start(), 
    * based on session.gc_divisor, session.gc_probability and session.gc_lifetime settings.
    * These settings are set in open(). 
    *
    * @access public
    * @param int     Session max life time in seconds
    * @return boolean
    */
    function gc($maxlifetime) {
        $time = time()-$maxlifetime;
        $sql = "DELETE FROM OPC_Sessions WHERE last_accessed < '$time'";
        $this->db->query($sql);
        return true;
    }
}

/* End of file Session.php */
/* Location: ./application/core/Session.php */