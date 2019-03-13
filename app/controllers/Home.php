<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class HomeController extends Controller 
{ 	
	function __construct()
    { 
		parent::__construct();		 
    }
	
	function index($id)
    {
		$this->Render();
    } 
}
