<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class Database {
    /**
     * PDO instance
     * @var type 
     */
    protected $pdo;
	var $conn;
 
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
			$this->pdo = new PDO($this->conn["host"]);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
	}
	
	function close() {
		$this->pdo = null;
	}
	
	function query($sql, $key) {
		$stmt = $this->pdo->prepare($sql);		
		$stmt->execute(array($key));

		$row = $stmt->fetch();	 
		
		$stmt = null;
		
		return $row;		
	}
	
	function querys($sql, $params) {
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute($params);		
		$rows = $stmt->fetchAll(); 
		
		$stmt = null;
		
		return $rows;
	}
	
	function insert($table, $cols, $values) {
		$n = count($cols);
		
		$sql = 'INSERT INTO '.$table.' ('.implode(", ",$cols).') VALUES ('.implode(',', array_fill(0, $n, '?')).')';
        $stmt = $this->pdo->prepare($sql);
		
		$stmt->execute($values);
     
		$stmt = null;
		
		$this->pdo->lastInsertId();		
	}
	
	function delete($sql, $key) {		
		$stmt = $this->pdo->prepare($sql);		
		
		$stmt->execute(array($key));		
		
		$i = $stmt->rowCount();
		
		$stmt = null;
		
		return $i;
	}		
	
	function count($table) {
		$q = $this->pdo->query("SELECT count(*) from ".$table);
		$row = $q->fetch();
		
		$q = null;
		
		return $row[0];
	}

	function execute($sql) {
		$this->pdo->exec($sql);
	}
}
 