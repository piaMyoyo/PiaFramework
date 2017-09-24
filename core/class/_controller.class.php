<?php

namespace pia\core;

class _Pia_Controller
{

    public $_CONTROLLER_ROUTE;
    public $_PARAMS;
    public $_KPARAMS;

    public function init($route){
        $this->_CONTROLLER_ROUTE = $route->_CTRL_PATH;
        $this->_PARAMS = $route->_PARAMS;
        $this->_KPARAMS = $route->_KPARAMS;
        $this->_CONTROLLER_NAME = $route->_CTRL_NAME;

        $this->loadController();

        return $this;
    }

    public function loadController(){
        require $this->_CONTROLLER_ROUTE;
        var_dump($this);
    }

}

?>