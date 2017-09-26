<?php

namespace pia\core;

abstract class _Pia_Controller
{

    private $_MODELS;


    public function __construct(){

    }

    protected function render(){
        echo 'Hello World !';
    }

    protected function layout($path){

    }

    protected function getModel($path){

    }

}

?>