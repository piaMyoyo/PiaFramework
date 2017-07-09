<?php

namespace pia\core;

class _Pia_Route
{

    public $_QUERY_STRING;

    public function init(){
        if(array_key_exists('QUERY_STRING', $_SERVER))
            $this->_QUERY_STRING = $_SERVER['QUERY_STRING'];
        else $this->_QUERY_STRING = '';

        if($this->_QUERY_STRING && $this->_QUERY_STRING !== '' && isset($this->_QUERY_STRING)){
            // Do some treatment
        }else{
            $this->_QUERY_STRING = 'index';
        }

        return $this;
    }

}

?>