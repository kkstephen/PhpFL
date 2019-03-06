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
        $this->Render();
    }
	
	public function detail($id)
    {        
		try		
		{
			$this->db->open();		 
		} catch (Exception $e) {
			$this->ViewData("error", 'Caught exception: '.$e->getMessage()); 			 
		}	 
		
        $this->Render();
    }
}
