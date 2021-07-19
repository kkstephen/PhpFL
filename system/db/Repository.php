<?php 

class Repository {
	protected $db;
	protected $reflects; 
	
	function __construct($conn, $modelName) {
        $this->db = $conn;		
		
		$model = Pflmvc::loadModel($modelName);
		$this->reflects = new ReflectionClass($model);			
    } 
	 
	function getTable() {		
		return $this->reflects->getName();
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
	 
		//$reflect = new ReflectionClass($this->model);
		$props = $this->reflects->getProperties(ReflectionProperty::IS_PUBLIC);
				
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
		//$reflect = new ReflectionClass($model);
		$props = $this->reflects->getProperties(ReflectionProperty::IS_PUBLIC);

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
	
	function Update($id, $prop, $val) {
		$sql = "Update ".$this->getTable().' set '. $prop . ' = "' . $val . '" where id = ' .$id;	
		
		return $this->db->execute($sql);
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
