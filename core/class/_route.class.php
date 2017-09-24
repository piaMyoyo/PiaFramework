<?php

namespace pia\core;

class _Pia_Route
{

    public $_QUERY_STRING;
    public $_ENTRY_NAME;
    public $_CTRL_PATH;
    public $_CTRL_NAME_PREFIX;
    public $_CTRL_NAME_SUFFIX;
    public $_CTRL_NAME;
    public $_KPARAMS;
    public $_PARAMS;

    public function __construct(){
        if(array_key_exists('QUERY_STRING', $_SERVER))
            $this->_QUERY_STRING = $_SERVER['QUERY_STRING'];
        else $this->_QUERY_STRING = '';
    }

    public function init($config){
        
        $this->_ENTRY_NAME = trim($config->_GLOBAL->entryName);
        $this->_CTRL_NAME_PREFIX = trim($config->_GLOBAL->controller->prefix);
        $this->_CTRL_NAME_SUFFIX = trim($config->_GLOBAL->controller->suffix);
        $this->stringRouteReader();

        return $this;
    }

    public function stringRouteReader(){
        $cleanStringRoute = $this->cleanStringRoute();
        $arraySplitedRoute = explode('/', $cleanStringRoute);
        $routePath = '';
        $controllerName = $this->_CTRL_NAME_PREFIX;
        $routeIteration = count($arraySplitedRoute);
        $i = 0;
        
        foreach($arraySplitedRoute as $key => $route){
            $i++;
            $routeString = $routePath.'/'.$route;
            $routeDirCheck = _PIA_CTRL_.$routeString;
            $routeFileCheck = _PIA_CTRL_.$routeString._PIA_CORE_FILES_EXTENSION_;
            
            if($routeIteration > $i && is_dir($routeDirCheck)){
                $routePath = $routeString;
                $controllerName = $controllerName.$route;
                continue;
            }elseif($routeIteration == $i && is_dir($routeDirCheck) && file_exists($routeDirCheck.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_)){
                $routePath = $routeDirCheck.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_;
                $this->_CTRL_NAME = $controllerName.$this->_CTRL_NAME_SUFFIX;
                break;
            }elseif($routeIteration == $i && file_exists($routeFileCheck)){
                $routePath = $routeFileCheck;
                $this->_CTRL_NAME = $controllerName.$this->_CTRL_NAME_SUFFIX;
                break;
            }elseif($routeIteration > $i && file_exists($routeFileCheck)){
                $routePath = $routeFileCheck;
                $this->_CTRL_NAME = $controllerName.$this->_CTRL_NAME_SUFFIX;
                $this->generateParams($arraySplitedRoute, $key);
                break;
            }elseif($routeIteration > $i && file_exists(_PIA_CTRL_.$routePath.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_)){
                $routePath = _PIA_CTRL_.$routePath.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_;
                $this->_CTRL_NAME = $controllerName.$this->_CTRL_NAME_SUFFIX;
                $this->generateParams($arraySplitedRoute, $key-1);
                break;
            }else{
                $routePath = _PIA_CTRL_ERR_.'/404'._PIA_CORE_FILES_EXTENSION_;
                $this->_CTRL_NAME = 'pia_errors_404';
                break;
            }
        }
        
        $this->_CTRL_PATH = $routePath;
    }

    public function cleanStringRoute(){
        $stringRoute = explode('&', trim(urldecode($this->_QUERY_STRING)));
        $stringRoute = $stringRoute[0];

        while(substr($stringRoute, 0, 1) === '/'){
            $stringRoute = trim(substr($stringRoute, 1));
        }

        while(substr($stringRoute, -1) === '/'){
            $stringRoute = trim(substr($stringRoute, 0, -1));
        }

        return $stringRoute;
    }

    public function generateParams($routeArray, $index){
        for($i=0;$i<=$index;$i++){
            unset($routeArray[$i]);
        }

        $this->_KPARAMS = array_values($routeArray);

        $n = 1;
        $lastIterationKey = '';
        foreach($routeArray as $key => $param){
            if($n % 2){
                $this->_PARAMS[$param] = '';
                $lastIterationKey = $param;
            }else{
                $this->_PARAMS[$lastIterationKey] = $param;
            }
            $n++;
        }
    }
}

?>