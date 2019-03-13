<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

require_once(APP_PATH.'/system/db/Database.php');
require_once(APP_PATH.'/system/db/Repository.php');
require_once(APP_PATH.'/system/db/UnitORM.php');
require_once(APP_PATH.'/app/models/User.php');

class MyRepository extends Repository {
	
	function __construct($db)
	{
		$this->model = new User();
		$this->table = "feedback"; //table
		
		parent::__construct($db); 
	}
  
	function create()
	{		
		$sql = 'CREATE TABLE [feedback] ( 
		    [id] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
			[event_id] TEXT NULL,	 
			[fname] TEXT NULL,
			[lname] TEXT NULL,
			[email] TEXT NULL,
			[company] TEXT NULL,
			[title] TEXT NULL,		 
			[tel] TEXT NULL,			
			[rating] TEXT NULL, 
			[interest] TEXT NULL,
			[solutions] TEXT NULL,
			[solu_other] TEXT NULL,		 
			[training] TEXT NULL,
			[joincamp] TEXT NULL,
			[likeus] TEXT NULL,
			[likeother] TEXT NULL,	
			[phonecall] BOOLEAN NULL,
			[promote] BOOLEAN NULL, 	
			[ip] TEXT NULL,
			[create_date] DATETIME NULL
		);';	
		
		$this->db->execute($sql); 
	} 
}

class PdoUnit extends UnitORM {
	var $feedback;
 
	function __construct() 
	{
		$this->db = new Database(Pflmvc::$Config['db']);		
        $this->feedback = new MyRepository($this->db);	 
    }
}
