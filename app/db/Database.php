<?php 

class Database {
    /**
     * PDO instance
     * @var type 
     */
    protected $pdo;
	public $conn;
 
    public function __construct($connStr)
    {
        $this->conn = $connStr;
    }
	
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return PDO
     */
    public function open() {
		 if ($this->pdo == null) {
			$this->pdo = new PDO($this->conn["host"], $this->conn["username"], $this->conn["password"]);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
	}
	
	public function close() {
		$this->pdo = null;
	}
	
	public function query($sql, $key) {
		$stmt = $this->pdo->prepare($sql);		
		$stmt->execute(array($key));

		$row = $stmt->fetch();	 
		
		$stmt = null;
		
		return $row;		
	}
	
	public function querys($sql, $params) {
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute($params);		
		$rows = $stmt->fetchAll(); 
		
		$stmt = null;
		
		return $rows;
	}
	
	public function insert($table, $cols, $values) {
		$n = count($cols);
		
		$sql = 'INSERT INTO '.$table.' ('.implode(", ",$cols).') VALUES ('.implode(',', array_fill(0, $n, '?')).')';
        $stmt = $this->pdo->prepare($sql);
		
		$stmt->execute($values);
     
		$stmt = null;
		
		$this->pdo->lastInsertId();		
	}
	
	public function delete($sql, $key) {		
		$stmt = $this->pdo->prepare($sql);		
		
		$stmt->execute(array($key));		
		
		$i = $stmt->rowCount();
		
		$stmt = null;
		
		return $i;
	}
	
	public function execute($sql) {
		$this->pdo->exec($sql);
	}
}
 