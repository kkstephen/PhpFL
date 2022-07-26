<?php 

class Database {
    /**
     * PDO instance
     * @var type 
     */
    protected $pdo;
	private $conn;
 
    function __construct($connStr)
    { 
		$this->conn = $connStr;
    }
	
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return PDO
     */
    function open() {
		
		if ($this->pdo == null) {
			$this->pdo = new PDO($this->conn['host'],$this->conn['user'], $this->conn['password']);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
	}
	
	function close() {
		$this->pdo = null;
	} 
	
	function select($table, $cols, $cond, $params) {
		$sql = "SELECT ".$cols." FROM ".$table." where ".$cond.";";
		
		return $this->querys($sql, $params);
	} 
	
	function querys($sql, $params) {
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute($params);		
		$rows = $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass'); 
		
		$stmt = null;
		
		return $rows;
	}
	
	function insert($table, $cols, $values) {
		$n = count($cols);
		
		$sql = 'INSERT INTO '.$table.' ('.implode(", ",$cols).') VALUES ('.implode(',', array_fill(0, $n, '?')).')';
        $stmt = $this->pdo->prepare($sql);
		
		$stmt->execute($values);
     
		$stmt = null;
		
		return $this->pdo->lastInsertId();		
	}
	
	function update($table, $cols, $cond, $values) { 
		$sql = "Update ".$table.' set '.implode(", ", $cols).' where '.$cond.';';	
	  
		return $this->execute($sql, $values);
	} 
	
	function delete($table, $cond, $values) {
		$sql = 'delete from '.$table.' WHERE '.$cond.';';	
		
		return $this->execute($sql, $values);
	}
	
	function count($table) {		
		$sql = "SELECT COUNT(id) as rows FROM ".$table;
		
		$res = $this->pdo->query($sql);
		
		return $res->fetchColumn();
	}
	
	function execute($sql, $params) {
	 
		$stmt = $this->pdo->prepare($sql);		
		
		$stmt->execute($params);		
		
		$i = $stmt->rowCount();
		
		$stmt = null;
		
		return $i; 
	}
}
 