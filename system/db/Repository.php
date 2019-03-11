<?php 

abstract class Repository {
	protected $db;
	protected $model;	 
	protected $table; 	 
	
	public function __construct($db) {
        $this->db = $db;
    }  
	
	abstract public function create();
	
	public function get($id)
	{
		$sql = "SELECT * FROM ".$this->table." where id = ?;";
		
		$row = $this->db->query($sql, $id);
	 
		$reflect = new ReflectionClass($this->model);
		$props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
		
		$user = array();
		
		foreach ($props as $prop) {
			$col = $prop->getName();		
			
			$user[$col] = $row[$col];			 
		}		 
		
		$user["id"] = $row['id'];	 
	 
		$row = null;
		
		return $user;		
	}	
	
	public function tolist()
	{
		$sql = "SELECT * FROM ".$this->table." where id > ?;";
		$rows = $this->db->querys($sql, array(0));
	 
        $list = array();
	 
		$reflect = new ReflectionClass($this->model);
		$props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
				
		$cols = array();
		$i = 0;
		
		foreach ($props as $prop) {
			$cols[$i++] = $prop->getName(); 
		} 
		
		foreach ($rows as $row)
		{
			$user = array();			
			
			foreach( $cols as $key => $val)
			{						
				$user[$val] =  $row[$val];				 
			}
			
			$user["id"] = $row['id'];	 
			
			array_push($list, $user);
		} 
		
		return $list;	 
	}
	
	public function add($model) {
		$reflect = new ReflectionClass($model);
		$props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

		$i = 0;
		$cols = array();
		$values = array();

		foreach ($props as $prop) {
			$cols[$i] = $prop->getName();
			$values[$i] = $prop->getValue($model);
			
			$i++;
		}

		$id = $this->db->insert($this->table, $cols, $values);
 
        return $id;
    }	
	
	public function drop()
	{		
		$sql = "drop table ".$this->table; 	
		
		$this->db->execute($sql); 
	}
	
	public function remove($id) {		
		$sql = 'DELETE FROM '.$this->table.' WHERE id = ?';		
		
		return $this->db->delete($sql, $id);
	}
}
