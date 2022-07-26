<?php 

class Repository {
	protected $db;
	protected $reflects; 
	
	function __construct($conn, $model) {
        $this->db = $conn;		
 
		$this->reflects = new ReflectionClass($model);			
    } 
	 
	function getTable() {		
		return $this->reflects->getName();
	}
	
	function getProps() {
		return $this->reflects->getProperties(ReflectionProperty::IS_PUBLIC);
	}
	
	function Create($sql) {
		
		return $this->db->execute($sql);
	}
		
	function Get($id) {	 
		$list = $this->Gets("id = ?", array($id));	 
		
		return $list[0];		
	}
	
	function Gets($cond, $params) { 
		$rows = $this->db->select($this->getTable(), "*", $cond, $params);
		
		return $this->getdata($rows);
	}
	
	function GetPage($page, $size) {		
		$offset = ($page - 1) * $size; 
		
		return $this->Gets("id > 0 order by id desc limit ?, ?", array($offset, $size));	
	}
	
	private function getdata($rows)	{
		$list = array(); 
		$i = 0;
		
		foreach ($rows as $row)
		{  
			$list[$i] = (object)$row;
			
			$i++;
		}  
		
		return $list;	 
	}
	
	function ToList() { 
		return $this->Gets("id > ? order by id asc", array(0)); 
	}
	
	function Add($model) {
		 
		$i = 0;
		$cols = array();
		$values = array();
          
		$props = $this->getProps();
		  
		foreach ($props as $prop) {
			$cols[$i] = $prop->getName();
			$values[$i] = $prop->getValue($model);
			
			$i++;
		}

		return $this->db->insert($this->getTable(), $cols, $values); 
    }	
	
	function Modify($cols, $values) {
		 
		return $this->db->update($this->getTable(), $cols, "id = ?", $values);
	}
	
	function Update($model) {
	  
	    if (is_null($model) || $model->id == "") {
			return false;
		}
		
		$i = 0;
		$cols = array();
		$values = array();
		
		$props = $this->getProps();
		
		foreach ($props as $prop) {
			$name = $prop->getName();
			
			$cols[$i] = $name. ' = ?';
			$values[$i] = $model->$name; // not an instance of the class 
			
			$i++;
		} 
		
		$values[$i] = $model->id;
		
		return $this->Modify($cols, $values);
	}
	 
	function Remove($id) { 
		return $this->Clear(" id = ? ", array($id));
	}
	
	function Clear($cond, $keys) {
	 
		return $this->db->delete($this->getTable(), $cond, $keys);
	}
	
	function Count() {		
		return $this->db->count($this->getTable());		 
	}
}
