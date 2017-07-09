<?php

namespace pia\core;

class _Pia_Config
{

    private $_core_json_global_config;
    private $_app_json_global_config;

    private $_core_json_layout_config;
    private $_app_json_layout_config;

    private $_global_config;
    private $_layout_config;

    public function __construct(){
        $this->getJsonGlobalConfiguration()
             ->getJsonLayoutConfiguration();
    }

    public function init(){
        $this->buildConfiguration();
        return $this;
    }

    private function getJsonGlobalConfiguration(){
        $core_json_global_config_path = _PIA_CORE_.'config/global.config.json';
        $app_json_global_config_path = _PIA_APP_.'config/global.config.json';

        if(file_exists($core_json_global_config_path)){
            $this->_core_json_global_config = file_get_contents($core_json_global_config_path);
        }else{
            throw new Exception("Missing configuration file on $core_json_global_config_path");
        }

        if(file_exists($app_json_global_config_path)){
            $this->_app_json_global_config = file_get_contents($app_json_global_config_path);
        }else{
            $this->_app_json_global_config = array();
        }
        return $this;
    }

    private function buildGlobalConfiguration(){
        return (object) array_merge((array) json_decode($this->_core_json_global_config), (array) json_decode($this->_app_json_global_config));
    }

    private function getJsonLayoutConfiguration(){
        $core_json_layout_config_path = _PIA_CORE_.'config/layout.config.json';
        $app_json_layout_config_path = _PIA_APP_.'config/layout.config.json';

        if(file_exists($core_json_layout_config_path))
            $this->_core_json_layout_config = file_get_contents($core_json_layout_config_path);
        else throw new Exception("Missing configuration file on $core_json_layout_config_path");

        if(file_exists($app_json_layout_config_path)){
            $this->_app_json_layout_config = file_get_contents($app_json_layout_config_path);
        }else{
            $this->_app_json_layout_config = array();
        }
        return $this;
    }

    private function buildConfiguration(){
        $this->_global_config = $this->buildGlobalConfiguration();
        return $this;
    }

}

?>