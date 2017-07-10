<?php

namespace pia\core;
use pia\core\_Pia_Error as PiaError;
use pia\core\_Pia_Config as PiaConfig;
use pia\core\_Pia_Route as PiaRoute;
use pia\core\_Pia_Controller as PiaController;


class _Pia_Core
{

    private $_error;
    private $_config;
    private $_routing;
    private $_controller;
    private $_version;

    public function __construct(){
        $this->_version = _PIA_VERSION_;
        $this->_error = new PiaError;
        $this->_config = new PiaConfig;
        $this->_routing = new PiaRoute;
        $this->_controller = new PiaController;
    }

    public function getConfig(){
        return $this->_config;
    }

    public function initError(){
        $this->_error->init();
        return $this;
    }

    public function initConfig(){
        $this->_config->init();
        return $this;
    }

    public function initRoute(){
        $this->_routing->init($this->_config);
        return $this;
    }

    public function initController(){
        // Do it, just do it
    }

}

?>