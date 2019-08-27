<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class HomeController extends Controller 
{ 	
    private	$db;
	
	function __construct()
    { 
		parent::__construct();		 
		
		$this->db = new PdoUnit();
    }
	
	function index($id)
    {
		$this->Render();
    }
}
