<?php 

class UnitORM {
	public $connStr;
 	protected $db;
	
	function __construct() 
	{
		$this->connStr = Pflmvc::$Config['db'];
		$this->db = new Database($this->connStr);
    } 
	
	function open()
	{
		if ($this->db != null) {			
			$this->db->open(); 
		}
	}
	
	function close() 
	{
		if ($this->db != null)
			$this->db->close();
	}
}
