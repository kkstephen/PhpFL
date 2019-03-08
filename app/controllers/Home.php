<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class HomeController extends Controller 
{ 	
	public function __construct()
    { 
		parent::__construct();
	
		$this->db = new PdoUnit();
    }
	
	public function index($id)
    {  
		$this->ViewData('name', $this->input->Post("name"));
		
        $this->Render();
    }
	
	public function detail($id)
    {        		
		
        $this->Render();
    }
}
