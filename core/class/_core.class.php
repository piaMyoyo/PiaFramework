<?php

namespace pia\core;
use pia\core\_Pia_Error as PiaError;
use pia\core\_Pia_Config as PiaConfig;
use pia\core\_Pia_Route as PiaRoute;


class _Pia_Core
{

    private $_error;
    private $_config;
    private $_routing;

    public function __construct(){
        $this->_error = new PiaError;
        $this->_config = new PiaConfig;
        $this->_routing = new PiaRoute;
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
        $this->_routing->init();
        return $this;
    }

}

?>