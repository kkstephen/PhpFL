<?php 

class UnitORM {
 	protected $db;
	
	function open()
	{
		if ($this->db != null)			
			$this->db->open();
	}
	
	function close() 
	{
		if ($this->db != null)
			$this->db->close();
	}
}
