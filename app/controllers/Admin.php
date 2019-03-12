<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class AdminController extends Controller 
{ 	
	public function __construct()
    { 
		parent::__construct();
		
		$this->unit = new PdoUnit();
    }
	
	public function index() 
	{
		routeTo("admin", "detail");
	}
	
	public function detail($id = "")
    {
		$list = array();
		
		try
		{		
			$this->unit->open();
			
			$users = $this->unit->feedback->tolist();			 
		}
		catch (Exception $e)
		{
			exit("ERROR :".$e->getMessage());
		}	

		$this->unit->close();
		
		$this->ViewData('users', $users );
			
		$this->Render();
    }
		
	public function export($id = "")
    { 
		try
		{
			$this->unit->open();			
		}
		catch (Exception $e)
		{
			$this->ViewData('error', $e->getMessage());
		}
		
		$this->unit->close();
		
        $this->Render();
    }
	
	public function clear($id = "")
    { 
		try
		{
			$this->unit->open();
			
			$this->unit->feedback->clear();			
		}
		catch (Exception $e)
		{
			$this->ViewData('error', $e->getMessage());
		}
		
		$this->unit->close();
		
        echo "OK";
    }
}
