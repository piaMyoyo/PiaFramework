<?php

namespace pia\core;

abstract class _Pia_Controller
{

    private $_OUTPUT;
    private $_MODELS;

    public function __construct(){

    }

    protected function prepare(){
        
    }

    protected function render(){
        echo 'Hello World !';
    }

    protected function layout($path){

    }

    protected function addLayoutItem($type, $path){
        
    }

    protected function loadModel($model){
        // Charge un model
    }

    protected function getModel($path){
        // Appel un model chargé
    }

}

?>