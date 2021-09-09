<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class HomeController extends Controller 
{ 	
	private $db;
	
	function __construct()
    { 
		parent::__construct();
		
		date_default_timezone_set("Asia/Hong_Kong"); 
		
		$this->db = new PdoUnit();  
		
		$this->Title("Register | Red Hat");  
    }
 
	function index() {
		 
		
		$this->Render();
	}
	
	function register($mid) {
		if (!isset($mid) || empty($mid)) {
			$mid = "PPM";
		}		
		
		$this->ViewData('event_id', $mid);	
		$this->Render();
	}
	
	function submit($mid) { 
		$ret = false;
		
		$g = new Guest();
		
		$g->event_id = $mid;
						
		if (!empty($_POST))
		{					
			$g->prefix = $this->formParm("prefix");
			$g->fname = $this->formParm("fname");
			$g->lname = $this->formParm("lname");
			$g->title = $this->formParm("title");
			
			$g->email = $this->formParm("email");
			$g->company = $this->formParm("company"); 
			
			$g->tel = $this->formParm("tel");
			$g->mobile = $this->formParm("mobile");
			
			$g->industry = $this->formParm("industry");
			$g->staff = $this->formParm("staff");
			
			$g->promote = $this->formParm("promote");
			$g->argee = $this->formParm("argee");
			$g->unsubscribe = $this->formParm("unsubscribe");
			
			if (!$this->form_valid($g)) 
			{ 
				$g->create_date = date("Y/m/d H:i:s");
				$g->ip = $_SERVER['REMOTE_ADDR'];
				
				try
				{
					$this->db->open();

					$this->db->guests->Add($g);  
					
					$ret = true;			
				}
				catch (Exception $e)
				{
					$this->ViewData('error', $e->getMessage().' '.$this->db->connStr['host']);
				}
				
				$this->db->close();
			
			} else {
				$this->ViewData('error', "Please input required field.");
			}
		}
		
		if ($ret) {
			$this->Render("success");
		}
		else {		
			$this->ViewData('user', $g);		
			
			$this->Render("register");
		}
    } 
	 
	function success() {
		$this->Render("success");
	}
	
	function event() {		
		$num = 1;
		
		try
		{
			$this->db->open();

			$num = $this->db->guests->Count(); 		 		
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		} 
		
		echo "OK: ".$num;
	} 
	
	private function form_valid($model)	{
		if ($model->prefix == "") return true;
		if ($model->fname == "") return true;
		if ($model->lname == "") return true;
		if ($model->title == "") return true;
		if ($model->company == "") return true;
		if ($model->email == "") return true;
		if ($model->tel == "") return true;
		if ($model->mobile == "") return true;

		return false;
	}
	
	private function formParm($name) {
		return $this->input->Post($name);
	}
}
