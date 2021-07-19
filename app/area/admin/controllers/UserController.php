<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class UserController extends Controller 
{ 	 
	private $unit;

	function __construct()
    { 
		parent::__construct();
		
		$this->session = new Session(1200, "");		
		
		$this->Title("Login | PPM WebAdmin");  
    }
	
	function index() 
	{
		$this->checkAuth();
	
		$this->Redirect("event", "index");			
	}
	
	function login()
	{  
		$this->Render();
	}
	
	function logout()
	{ 
		$this->session->clear();
		
		$this->Redirect("user", "login");		
	}
	
	function auth() 
	{
		$pw = $this->input->Post("passwd");			

		if ($pw == "ppm28931266") {
			$this->session->set_data("FAA1BEAB-2584-4D8D-9173-8389A85915B6");
			
			$this->Redirect("event", "index");
		} else {
			$this->ViewData('msg', "error");
			$this->Render("login");	
		}
	}
		 
	private function checkAuth() 
	{		
		$auth_id = $this->session->get_data();
		
		if (isNULLorEmpty($auth_id)) {
			$this->Redirect("user", "login");
		}
	}
}
