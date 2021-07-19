<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');
 
class PdoUnit extends UnitORM { 
	var $guests; 
	
	function __construct() 
	{ 
		parent::__construct();
	
		$this->guests = new Repository($this->db, "Guest");
    }
	
	function Gets($sql, $params) { 
		return $this->db->querys($sql, $params);
	}
}
