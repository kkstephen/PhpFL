<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
 
class FeedbackController extends Controller 
{ 	
	public function __construct()
    { 
		parent::__construct();
		
		$this->unit = new PdoUnit();
    }
	
	public function index($id)
    {
		$this->ViewData('name', $this->input->Post("name"));

        $this->Render();
    }
	
	public function submit($id)
    { 		
		$user = new User();
		
		$user->event_id = "e2019314";
		
		$user->fname = $this->input->Post("name");		
		$user->title = $this->input->Post("title");
		$user->company = $this->input->Post("company");		
		$user->email = $this->input->Post("email");
		$user->tel = $this->input->Post("tel");
		
		$user->rating = array();

		for( $i = 1; $i <= 7; $i++) 
		{
			$user->rating[$i] = $this->input->Post("rate_".$i);
		}			 
				
		$user->rating = implode(",", $user->rating);
		$user->interest = $this->input->PostList("interest");
		$user->solutions = $this->input->PostList("solutions");
		$user->solu_other = $this->input->Post("solu_other");
		$user->training = $this->input->PostList("training");
		$user->joincamp = $this->input->Post("joincamp");
		$user->likeus = $this->input->PostList("likeus");
		$user->meeting = $this->input->Post("meeting");
		$user->likeother = $this->input->Post("likeother");
		$user->phonecall = $this->input->Post("phonecall");
		$user->promote = $this->input->Post("promote");
		
		$user->create_date = date("Y/m/d H:i:s");
		$user->ip = "";
	
		$ret = false;
		
		if (isset($_POST)) {
			try
			{
				$this->unit->open();

				$this->unit->feedback->add($user); 
				
				$ret = true;			
			}
			catch (Exception $e)
			{
				$this->ViewData('error', $e->getMessage());
			}
			
			$this->unit->close();
		}
		
		if ($ret) {
			$this->Render("success");
		}
		else {		
			$this->ViewData('user', $user);		

			$this->Render("index");
		}
    }
	
	public function success($id)
    { 
		$this->Render("index");
	}
}
