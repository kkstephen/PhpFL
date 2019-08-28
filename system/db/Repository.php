<?php 

class Repository {
	protected $db;
	protected $model; 
	
	function __construct($db, $model) {
        $this->db = $db;
		$this->model = $model;
    } 
	
	private function getTable() {		
		return get_class($this->model);
	}
	
	function Get($id) {
		$sql = "SELECT * FROM ".$this->getTable()." where id = ?;";
		
		$rows = $this->db->query($sql, $id);
	 
		$user = $this->getdata($rows);	 
		
		return $user[0];		
	}	
	
	function Gets($page, $size) {		
		$offset = ($page - 1) * $size;
		
		$sql = "SELECT * FROM ".$this->getTable()." where id > 0 order by id desc limit ?, ?";
		$rows = $this->db->querys($sql, array($offset, $size));
		
		return $this->getdata($rows);	
	}
	
	private function getdata($rows)	{
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
	
	function ToList() {
		$sql = "SELECT * FROM ".$this->getTable()." where id > ? order by id asc;";
		$rows = $this->db->querys($sql, array(0));
	          
		return $this->getdata($rows);	 
	}
	
	function Add($model) {
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

		$id = $this->db->insert($this->getTable(), $cols, $values);
 
        return $id;
    }	
	
	function Drop()	{	
		$sql = "drop table ".$this->getTable(); 	
		
		$this->db->execute($sql); 
	}
	
	function Remove($id) {
		$sql = 'delete from '.$this->getTable().' WHERE id = ?;';		
		
		return $this->db->delete($sql, $id);
	}
	
	function Clear() {
		$sql = 'delete from '.$this->getTable().';';
		
		return $this->db->execute($sql);
	}
	
	function Count() {		
		return $this->db->count($this->table);		 
	}
}
