<?PHP

class PAGE_Static {
	public $page_id;
	public $content = '';
	public $db;

	public function __construct($data, $page_id = null){
		$this->db 		= new OPC_Database();
		$this->page_id 	= $page_id;
		if(!empty($data)) 
			$this->content = $data[0]['value'];
	}
	
	public  function validate(){
		return array();
	}

	public  function getData(){
		return array('content' => $this->content);
	}

	public  function save(){
		$binds['page_id'] 	= $this->page_id;
		$binds['name'] 		= 'content';
		$binds['value'] 	= $this->content;
		$this->db->insert('OPC_Page_content', $binds);
	}

	public  function update(){
		$binds[] = $this->content;
		$binds[] = $this->page_id;
		$binds[] = 'content';
		
		$sql = "UPDATE OPC_Page_content SET value = ? WHERE page_id = ? AND name = ?";
		$this->db->query($sql, $binds);
	}

	public  function remove(){
		$this->db->reset();
		$this->db->where('page_id', $this->page_id);
		$this->db->delete('OPC_Page_content');
	}
}