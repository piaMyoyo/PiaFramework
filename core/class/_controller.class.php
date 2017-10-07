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
        if($modelPath = $this->getModelPath($model)){
            require_once $modelPath;
            $modelName = $this->getModelName($model);
            if(class_exists($modelName)){
                $modelExpression = $this->getModelExpression($model);
                $this->_MODELS[$modelExpression] = new $modelName();
                $this->_MODELS[$modelExpression]->init($this->_CONFIG->_DB);
                return $this->_MODELS[$modelExpression];
            }else return false;
        }else{
            return false;
        }
    }

    protected function getModel($model){
        return $this->_MODELS[$model];
    }

    protected function modelExists($model){

    }

    private function getModelPath($model){
        $fullPath = _PIA_MODEL_.'/'.$model._PIA_CORE_FILES_EXTENSION_;
        if(file_exists($fullPath)){
            return $fullPath;
        }else{
            return false;
        }
    }

    private function getModelName($model){
        $modelName = str_replace('/', '_', $model);
        return $this->_CONFIG->_GLOBAL->model->prefix.$modelName.$this->_CONFIG->_GLOBAL->model->suffix;
    }

    private function getModelExpression($model){
        $modelPathArray = explode('/', $model);
        $modelNameIndex = count($modelPathArray) - 1;
        return $modelPathArray[$modelNameIndex];
    }

}

?>