<?php
# vim: set sw=4 expandtab smarttab:

require_once 'Third/Smarty/Smarty.class.php';

abstract class Myrss_Action_Abstract  {
    protected $_smarty;
    protected $_param;

    private function _check($key, $desc)
    {
        if( !isset( $this->_param[$key] )){
            $this->_param[$key] = $desc['default'] ;
        }
        if ($desc['type'] == 'int')
            $this->_param[$key] = (int) $this->_param[$key];
    }

    public function __construct($param = array())
    {
        //初始化smarty
        $this->_smarty = new Smarty;
        $dir = dirname(__FILE__);
        $this->_smarty->template_dir = $dir . "/../../../templates";
        $this->_smarty->complile_dir = $dir . "/../../../templates_c";
        
        $this->_param = $_REQUEST    ;
        if(  get_magic_quotes_gpc()){//如果get_magic_quotes_gpc()是打开的
            foreach($this->_param as $k=>$v){
                $this->_param[$k] = stripslashes( $this->_param[$k] );//将字符串进行处理
            }
        }

        foreach ($param as $key => $desc)
            $this->_check($key, $desc);

        global $devicetype ;
        $this->_smarty->assign("devicetype", $devicetype);
    }
    public function execute() {
        $this->Exec();

        $scriptname = $_SERVER["SCRIPT_NAME"];
        $scriptname = substr($scriptname,1,-4).".htm";
        $this->_smarty->display($scriptname);
    }
    protected function _getParam($name)
    {
        return $this->_param[$name];
    }

    public function getReqUrl(){
        return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ;
    }
}
