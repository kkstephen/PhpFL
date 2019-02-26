<?php
/**
 * 视图基类
 */
class View
{
    protected $_data = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }
 
    // 分配变量
    public function assign($name, $value)
    {
        $this->_data[$name] = $value;
    }
 
    // 渲染显示
    public function render()
    {      
		extract($this->_data, EXTR_SKIP);
		
        $layout = APP_PATH . 'app/views/' . $this->_controller . '/' . $this->_action . '.php';
      
        //判断视图文件是否存在
        if (file_exists($layout)) {
            include $layout;
        } else {
            echo "无法找到视图文件:".$this->_action;
        }         
    }
}
