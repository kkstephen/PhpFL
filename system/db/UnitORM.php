<?php 

class UnitORM {
	 
 	protected $db;
	
	function __construct($dsn) 
	{  
		$this->db = new Database($dsn);
    } 
	
	function open()
	{  
		$this->db->open(); 
	}
	
	function close() 
	{
		if ($this->db != null)
			$this->db->close();
	}
}
