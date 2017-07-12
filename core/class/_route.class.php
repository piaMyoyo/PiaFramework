<?php

namespace pia\core;

class _Pia_Route
{

    public $_QUERY_STRING;

    public function __construct(){
        if(array_key_exists('QUERY_STRING', $_SERVER))
            $this->_QUERY_STRING = $_SERVER['QUERY_STRING'];
        else $this->_QUERY_STRING = '';
    }

    public function init($config){
        
        $routeEntryName = trim($config->_GLOBAL->entryName);
        var_dump($this->_QUERY_STRING);
        $this->stringRouteReader();

        // if($this->_QUERY_STRING && $this->_QUERY_STRING !== '' && isset($this->_QUERY_STRING)){
        //     // Do some treatment
        // }else{
        //     if($routeEntryName && isset($routeEntryName)){
        //         $this->_QUERY_STRING = $routeEntryName;
        //     }else{
        //         $this->_QUERY_STRING = 'index';
        //     }
        // }

        return $this;
    }

    public function stringRouteReader(){
        $cleanStringRoute = $this->cleanStringRoute();
        $arraySplitedRoute = explode('/', $cleanStringRoute);
        var_dump($arraySplitedRoute);
    }

    public function cleanStringRoute(){
        $stringRoute = trim(urldecode($this->_QUERY_STRING));

        while(substr($stringRoute, 0, 1) === '/'){
            $stringRoute = trim(substr($stringRoute, 1));
        }

        while(substr($stringRoute, -1) === '/'){
            $stringRoute = trim(substr($stringRoute, 0, -1));
        }

        return $stringRoute;
    }

}

?>