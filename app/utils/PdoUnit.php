<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');
 
class PdoUnit extends UnitORM { 
	var $guests; 
	
	function __construct() 
	{ 
		parent::__construct(Pflmvc::$Config['db']);
	
		$this->guests = new Repository($this->db, "Guest");
    } 
	
	function CreateGuests() {
		$sql = "CREATE TABLE [guest] ( 
		  [id] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
			[event_id] TEXT NULL,	 
			[prefix] TEXT NULL,
			[fname] TEXT NULL,
			[lname] TEXT NULL,
			[email] TEXT NULL,
			[company] TEXT NULL,
			[title] TEXT NULL,		 
			[tel] TEXT NULL,			
			[mobile] TEXT NULL,
			[industry] TEXT NULL,
			[staff] TEXT NULL,
			[argee] TEXT NULL,
			[promote] BOOLEAN NULL, 	
			[unsubscribe] TEXT NULL,
			[ip] TEXT NULL,
			[create_date] DATETIME NULL
		);";
		
		$this->guests->Create($sql);		
		
	}
	
	function Gets($sql, $params) { 
		return $this->db->querys($sql, $params);
	}
}
