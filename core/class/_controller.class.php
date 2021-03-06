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
    private $_HELPER;
    private $_LAYOUT;
    private $_LAYOUT_CONFIG;
    private $_VIEW;
    private $_TEMPLATE;
    private $_SOURCES;

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
            $this->configSources();
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
            include _PIA_VIEWS_.$this->_TEMPLATE._PIA_TEMPLATE_EXTENSION_;
        }else{
            include _PIA_VIEWS_.$this->_VIEW._PIA_TEMPLATE_EXTENSION_;
        }
        $this->_OUTPUT = ob_get_contents();
        ob_end_clean();
        return $this;
    }

    protected function minifyHtmlOutput($buffer){
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }

    protected function renderView(){
        ob_start();
        include _PIA_VIEWS_.$this->_VIEW._PIA_TEMPLATE_EXTENSION_;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    protected function getChild($child){
        ob_start();
        include _PIA_VIEWS_.$child._PIA_TEMPLATE_EXTENSION_;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    protected function getOutput(){
        return $this->_OUTPUT;
    }

    protected function output(){
        if(!isset($this->_LAYOUT_CONFIG->minify_html) || $this->_LAYOUT_CONFIG->minify_html == false)
            echo $this->_OUTPUT;
        else echo $this->minifyHtmlOutput($this->_OUTPUT);
        return $this;
    }

    private function configSources(){
        $sources = $this->_CONFIG->_LAYOUT->sources;
        foreach($sources as $type => $source) {
            $this->buildHeadHtmlExternalTag($type, $source);
            if(!isset($source->concatenate) || $source->concatenate !== true){
                $this->buildHeadHtmlSourceTag($type, $source);
            }else{
                $this->concatenateHeadHtmlSourceTag($type, $source);
            }
        }
    }

    private function buildHeadHtmlSourceTag($type, $source){
        if(!isset($this->_LAYOUT_CONFIG->head->$type) || !isset($this->_LAYOUT_CONFIG->head->$type->sources))
            return false;

        $items = $this->_LAYOUT_CONFIG->head->$type->sources;

        foreach($items as $key => $item) {
            $filePath = str_replace('@src', _PIA_SOURCE_.$source->basepath.$item.$source->extension, $source->tag);
            $this->_SOURCES[$type][] = $filePath;
        }
    }

    private function concatenateHeadHtmlSourceTag($type, $source){
        if(!isset($this->_LAYOUT_CONFIG->head->$type) || !isset($this->_LAYOUT_CONFIG->head->$type->sources))
            return false;

        $items = $this->_LAYOUT_CONFIG->head->$type->sources;
        $cacheDirPath = _PIA_ENV_._PIA_SOURCES_VARS_.$type;
        $cacheWebDirPath = _PIA_SOURCES_VARS_.$type;

        if(is_dir($cacheDirPath)){

            $filePathString = '';
            foreach($items as $key => $item) {
                $filePathString .= $item;
            }
            $fileName = md5($filePathString).$source->extension;

            if(file_exists($cacheDirPath.'/'.$fileName)){
                $filePath = $cacheWebDirPath.'/'.$fileName;
                $this->_SOURCES[$type][] = str_replace('@src', $filePath, $source->tag);
            }else{
                $this->buildConcatenateHeadHtmlSourceTag($type, $source);
            }

        }else{
            $this->buildConcatenateHeadHtmlSourceTag($type, $source);
        }
    }

    private function buildConcatenateHeadHtmlSourceTag($type, $source){
        $items = $this->_LAYOUT_CONFIG->head->$type->sources;
        $cacheDirPath = _PIA_ENV_._PIA_SOURCES_VARS_.$type;
        $cacheWebDirPath = _PIA_SOURCES_VARS_.$type;

        if(!is_dir(_PIA_ENV_._PIA_SOURCES_VARS_)){
            mkdir(_PIA_ENV_._PIA_SOURCES_VARS_);
        }

        if(!is_dir($cacheDirPath)){
            mkdir($cacheDirPath);
        }

        $filePathString = '';
        $fileContent = '';
        foreach($items as $key => $item) {
            $filePathString .= $item;
            $fileContent .= file_get_contents(_PIA_SOURCE_REL_.$source->basepath.$item.$source->extension);
        }
        $fileName = md5($filePathString).$source->extension;
        $filePath = $cacheWebDirPath.'/'.$fileName;
        file_put_contents($cacheDirPath.'/'.$fileName, $fileContent);
        $this->_SOURCES[$type][] = str_replace('@src', $filePath, $source->tag);
    }

    private function buildHeadHtmlExternalTag($type, $source){
        if(!isset($this->_LAYOUT_CONFIG->head->$type) || !isset($this->_LAYOUT_CONFIG->head->$type->external))
            return false;

        $items = $this->_LAYOUT_CONFIG->head->$type->external;

        foreach($items as $key => $item) {
            $this->_SOURCES[$type][] = str_replace('@src', $item, $source->tag);
        }
    }

    protected function getSources($type){
        if(array_key_exists($type, $this->_SOURCES) && count($this->_SOURCES[$type]) > 0){
            $sourceString = '';
            $sources = $this->_SOURCES[$type];
            foreach($sources as $source){
                $sourceString .= $source;
            }
            return $sourceString;
        }else{
            return false;
        }
    }

    protected function addLayoutItem($type, $source){
        
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

    protected function getHelper($helper){
        $helperPath = _PIA_HELPER_.'/'.$helper._PIA_CORE_FILES_EXTENSION_;
        if(file_exists($helperPath)){
            require_once $helperPath;
            $helperName = str_replace('/', '_', $helper);
            $helperFullName = $this->_CONFIG->_GLOBAL->helper->prefix.$helperName.$this->_CONFIG->_GLOBAL->helper->suffix;
            if(class_exists($helperFullName))
                return new $helperFullName();
            else return false;
        }
        else return false;
    }

}

?>