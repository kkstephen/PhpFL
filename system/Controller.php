<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * 控制器基类
 */
 
class Controller
{
    protected $_name;
    protected $_action;
	
    protected $view;
	protected $input;
	protected $db;
	
    // 构造函数，初始化属性，并实例化对应模型
    public function __construct()
    { 
		$this->input = new Parser(); 
    }

    // 分配变量
    public function ViewData($name, $value)
    { 
        $this->view->assign($name, $value);
    }
	
	public function init($controller, $action) 
	{
		$this->_name = $controller;
		$this->_action = $action; 
		
		if (!$this->view) 
		{
			$this->view = new View($this->_name, $this->_action);		
		}
	}		

    // 渲染视图
    public function Render()
    {  
        $this->view->render();
    } 	 
}