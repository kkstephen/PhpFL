<?php 
require_once(APP_PATH.'/app/db/Database.php');
require_once(APP_PATH.'/app/db/Repository.php');
require_once(APP_PATH.'/app/db/UnitORM.php');
require_once(APP_PATH.'/app/models/User.php');

class MyRepository extends Repository {
	
	public function __construct($db)
	{
		$this->model = new User();
		$this->table = "2019_Generic_eForm"; //table
		
		parent::__construct($db); 
	}
  
	public function create()
	{		
		$sql = "CREATE TABLE IF NOT EXISTS `2019_Generic_eForm` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255),
			`company` varchar(255),
			`email` varchar(128),	 
			`tel` varchar(32),
			`title` varchar(128),
			`enquiry` varchar(1024),			 
			`promote` boolean,	
			`ref` varchar(8),		
			`reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"; 	
		
		$this->db->execute($sql); 
	} 
}

class PdoUnit extends UnitORM {
	public $user;
 
	public function __construct() 
	{		
		$connStr = array("host" => "mysql:host=localhost;dbname=CPE;charset=utf8", "username" => "PPM_CPE", "password" => "PPM_pass");
		
		$this->db = new Database($connStr);		
        $this->user = new MyRepository($this->db);	 
    }
}
?>