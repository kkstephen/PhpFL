<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class EventController extends Controller 
{ 	 
	private $unit;
   
	function __construct()
    { 
		parent::__construct();
		
		$this->unit = new PdoUnit();
		$this->session = new Session(600, "");	
		
		$this->Title("Event RSVP User");
    }
	
	private function is_auth() {
		$auth_id = $this->session->get_data();
		
		if (isNULLorEmpty($auth_id)) {
			$this->Redirect("user", "login");
		}
	}
	
	function index() 
	{ 
		$this->is_auth();
	
		try
		{		
			$this->unit->open();
			
			$users = $this->unit->guests->ToList();			 
		}
		catch (Exception $e)
		{
			exit("ERROR: ".$e->getMessage());
		}	

		$this->unit->close();
		
		$this->ViewData('users', $users); 
		
		$this->Render("index");	 			
	}  
		
	function export($id = "")
    {   
		$this->is_auth();
	
		require(APP_PATH . 'app/utils/Excel.php');
		
		$excel = new ExportDataExcel('browser', 'event_report.xls');
		
		$excel->initialize();
		
		$headers = array("No.", "Prefix", "First Name", "Last Name", "Title", "Company", "Email", "Tel", "Mobile", "Industry", "Staff", "Promote", "Argee", "Unsubscribe", "Date", "IP"); 
	  
		$excel->addRow($headers);
	  
		try
		{
			$this->unit->open();			
			
			$ds = $this->unit->guests->Tolist();			
					 
			$rows = array();
			
			$n = 1;
			
			foreach ($ds as $key => $val) { 
			    
				$rows[$key] = array(				
								$n++,
								$val['prefix'],				
								$val['fname'],
								$val['lname'],
								$val['title'],
								$val['company'],
								$val['email'],
								$val['tel'],
								$val['mobile'],
								$val['industry'],							 
								$val['staff'],	
								$val['promote'],									
								$val['argee'],
								$val['unsubscribe'],	
								$val['create_date'],
								$val['ip']
							);			
			}
			
			foreach ($rows as $row) {
				$excel->addRow($row); 
			}
		}
		catch (Exception $e)
		{
			$this->ViewData('error', $e->getMessage());
		}
		
		$this->unit->close();		
		
		$excel->finalize();
		
		exit(0);
    }
	
	function del($id = "")
    {
		$this->is_auth();
	
		if (!isNULLorEmpty($id))
		{
			try
			{
				$this->unit->open();
				
				$this->unit->guests->Remove($id);
			}
			catch (Exception $e)
			{
				$this->ViewData('error', $e->getMessage());
			}
			
			$this->unit->close();
		}
		
		echo "OK"; 
    } 
}
