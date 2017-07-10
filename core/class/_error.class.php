<?php

namespace pia\core;

class _Pia_Error
{

    private $_LOCATION;

    public function __construct(){
        if(defined('_PIA_LOCATION_'))
            $this->_LOCATION = _PIA_LOCATION_;
        else $this->_LOCATION = 'dev';
    }

    public function init(){
        if($this->_LOCATION === 'dev'){
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 1);
        }elseif($this->_LOCATION === 'prod'){
            ini_set('display_errors', 0);
        }
    }


}

?>