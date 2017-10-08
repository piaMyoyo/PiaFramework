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

    private $_MODELS;
    private $_LAYOUT;
    private $_LAYOUT_CONFIG;
    private $_VIEW;
    private $_TEMPLATE;

    private $_OUTPUT;

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

    protected function prepareLayout($layout){
        $layoutParamsPath = _PIA_LAYOUT_.$layout.'.json';
        if(file_exists($layoutParamsPath)){
            $this->_LAYOUT = $layout;
            $this->_LAYOUT_CONFIG = json_decode( file_get_contents( $layoutParamsPath ) );
            $this->_TEMPLATE = $this->_LAYOUT_CONFIG->template;
        }
        return $this;
    }

    protected function getLayout(){
        return $this->_LAYOUT;
    }

    protected function loadView($view){
        $this->_VIEW = $view;
        return $this;
    }

    protected function getView(){
        return $this->_VIEW;
    }

    protected function render(){
        ob_start();
        if($this->_TEMPLATE && !is_null($this->_TEMPLATE)){
            include _PIA_VIEWS_.$this->_TEMPLATE._PIA_CORE_FILES_EXTENSION_;
        }else{
            include _PIA_VIEWS_.$this->_VIEW._PIA_CORE_FILES_EXTENSION_;
        }
        $this->_OUTPUT = ob_get_contents();
        ob_end_clean();
        return $this;
    }

    protected function renderView(){
        ob_start();
        include _PIA_VIEWS_.$this->_VIEW._PIA_CORE_FILES_EXTENSION_;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    protected function getChild($child){
        ob_start();
        include _PIA_VIEWS_.$child._PIA_CORE_FILES_EXTENSION_;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    protected function getOutput(){
        return $this->_OUTPUT;
    }

    protected function output(){
        echo $this->_OUTPUT;
        return $this;
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