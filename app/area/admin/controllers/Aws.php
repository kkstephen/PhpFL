<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class AwsController extends Controller 
{
	private $unit;
	
	function __construct()
    { 
		parent::__construct();
		
		$this->unit = new PdoUnit();
		$this->session = new Session(600, "");		
		
		$this->Template("AWSPL");
    }
		
	function index($id = "")
    {
		$this->checkAuth();
			
		$list = array();
		
		try
		{		
			$this->unit->open();
			
			$dataset = $this->unit->qrcode->tolist();			 
		}
		catch (Exception $e)
		{
			exit("ERROR :".$e->getMessage());
		}	

		$this->unit->close();
		
		$this->ViewData('dataset', $dataset);
			
		$this->Title("AWS Admin");  
		
		$this->Render("index");
    }
	
	function clear() 
	{		
		try
		{		
			$this->unit->open();
			
			$dataset = $this->unit->qrcode->clear();			 
		}
		catch (Exception $e)
		{
			exit("ERROR :".$e->getMessage());
		}	

		$this->unit->close();
		
		echo "clear ok.";
	}
	
	function export($id = "")
    {  
		$this->checkAuth();
		
		require(APP_PATH . 'app/utils/Excel.php');
		
		$excel = new ExportDataExcel('browser', 'hpe_qr_2019.xls');
		
		$excel->initialize();
		
		$headers = array("TrackId", "Code", "DataTime"); 
		
		$excel->addRow($headers);
		
		try
		{
			$this->unit->open();			
			
			$ds = $this->unit->qrcode->tolist();			
					 
			$rows = array();
			
			foreach ($ds as $key => $val) {
				 
				$rows[$key] = array(								 
								$val['trackid'],
								$val['code'],
								$val['createdate']								 
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
	
	private function checkAuth() 
	{		
		$auth_id = $this->session->get_data();
		
		if (isNULLorEmpty($auth_id)) {
			routeTo("user", "login");
		}
	}
	
}