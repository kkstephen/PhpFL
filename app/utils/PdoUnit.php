<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

require_once(APP_PATH.'/app/models/User.php');

class PdoUnit extends UnitORM {
	var $feedback;
	
	function __construct() 
	{
		$this->db = new Database(Pflmvc::$Config['db']);		
		
        $this->feedback = new Repository($this->db, new User());	 
    }
}
