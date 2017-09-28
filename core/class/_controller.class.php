<?php

namespace pia\core;

use pia\core\_Pia_Model as PiaModel;

abstract class _Pia_Controller
{

    private $_PARAMS;
    private $_INDEX_PARAMS;
    private $_METHOD;
    private $_ROUTE;
    private $_CONFIG;

    private $_OUTPUT;
    private $_LAYOUT;
    private $_MODELS;

    public function __construct(){
        $this->_MODELS = [];
    }

    public function setParams($params){
        $this->_PARAMS = $params;
    }

    protected function getParams(){
        return $this->_PARAMS;
    }

    public function setIndexParams($params){
        $this->_INDEX_PARAMS = $params;
    }

    protected function getIndexParams(){
        return $this->_INDEX_PARAMS;
    }

    public function setMethod($method){
        $this->_METHOD = $method;
    }

    protected function getMethod(){
        return $this->_METHOD;
    }

    public function setRoute($route){
        $this->_ROUTE = $route;
    }

    protected function getRoute(){
        return $this->_ROUTE;
    }

    public function setConfig($config){
        $this->_CONFIG = $config;
    }

    protected function getConfig(){
        return $this->_CONFIG;
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
        
    }

    protected function getModel($path){
        // Appel un model chargé
    }

    protected function modelExists($model){

    }

}

?>