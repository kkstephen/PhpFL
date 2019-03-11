<?php 

class UnitORM {
 	protected $db;
	
	public function open()
	{
		if ($this->db != null)			
			$this->db->open();
	}
	
	public function close() 
	{
		if ($this->db != null)
			$this->db->close();
	}
}
