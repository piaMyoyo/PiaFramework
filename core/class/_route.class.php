<?php

namespace pia\core;

class _Pia_Route
{

    public $_QUERY_STRING;
    public $_ENTRY_NAME;
    public $_CTRL_PATH;
    public $_PARAMS;

    public function __construct(){
        if(array_key_exists('QUERY_STRING', $_SERVER))
            $this->_QUERY_STRING = $_SERVER['QUERY_STRING'];
        else $this->_QUERY_STRING = '';
    }

    public function init($config){
        
        $this->_ENTRY_NAME = trim($config->_GLOBAL->entryName);
        $this->stringRouteReader();

        return $this;
    }

    public function stringRouteReader(){
        $cleanStringRoute = $this->cleanStringRoute();
        $arraySplitedRoute = explode('/', $cleanStringRoute);
        $routePath = '';
        $routeIteration = count($arraySplitedRoute);
        $i = 0;
        
        foreach($arraySplitedRoute as $key => $route){
            $i++;
            $routeString = $routePath.'/'.$route;
            $routeDirCheck = _PIA_CTRL_.$routeString;
            $routeFileCheck = _PIA_CTRL_.$routeString._PIA_CORE_FILES_EXTENSION_;
            
            if($routeIteration > $i && is_dir($routeDirCheck)){
                $routePath = $routeString;
                continue;
            }elseif($routeIteration == $i && is_dir($routeDirCheck) && file_exists($routeDirCheck.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_)){
                $routePath = $routeDirCheck.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_;
                break;
            }elseif($routeIteration == $i && file_exists($routeFileCheck)){
                $routePath = $routeFileCheck;
                break;
            }elseif($routeIteration > $i && file_exists($routeFileCheck)){
                $routePath = $routeFileCheck;
                $this->_PARAMS = $this->generateParams($arraySplitedRoute, $key);
                break;
            }elseif($routeIteration > $i && file_exists(_PIA_CTRL_.$routePath.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_)){
                $routePath = _PIA_CTRL_.$routePath.'/'.$this->_ENTRY_NAME._PIA_CORE_FILES_EXTENSION_;
                $this->_PARAMS = $this->generateParams($arraySplitedRoute, $key);
                break;
            }else{
                $routePath = _PIA_CTRL_ERR_.'/404'._PIA_CORE_FILES_EXTENSION_;
                break;
            }
        }
        // var_dump($arraySplitedRoute, $routePath);
        
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
        var_dump($routeArray);
    }
}

?>