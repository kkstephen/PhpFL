<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class HomeController extends Controller 
{ 	
	public function __construct()
    { 
		parent::__construct();
		
		$this->unit = new PdoUnit();
    }
	
	public function index($id)
    {
		redirect("/feedback");
    }
		
	public function detail($id)
    { 
		try
		{
			$this->unit->open();

			$this->unit->close();
		}
		catch (Exception $e)
		{
			$this->ViewData('error', $e->getMessage());
		}
		
        $this->Render();
    }
}
