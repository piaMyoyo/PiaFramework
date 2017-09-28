<?php

namespace pia\core;

class _Pia_Config
{

    private $_GLOBAL_JSON;
    private $_LAYOUT_JSON;
    private $_DB_JSON;

    public $_GLOBAL;
    public $_LAYOUT;
    public $_DB;

    public function __construct(){
        $this->_GLOBAL_JSON = $this->getJsonConfiguration(_PIA_CORE_.'config/global.config.json', _PIA_APP_.'config/global.config.json');
        $this->_LAYOUT_JSON = $this->getJsonConfiguration(_PIA_CORE_.'config/layout.config.json', _PIA_APP_.'config/layout.config.json');
        $this->_DB_JSON = $this->getJsonConfiguration(_PIA_CORE_.'config/database.config.json', _PIA_APP_.'config/database.config.json');
    }

    public function init(){
        $this->buildConfiguration();
        return $this;
    }

    private function getJsonConfiguration($CORE_FILE_PATH, $APP_FILE_PATH){

        if(file_exists($CORE_FILE_PATH))
            $CORE_JSON = file_get_contents($CORE_FILE_PATH);
        else throw new Exception("Missing configuration file on $CORE_FILE_PATH");

        if(file_exists($APP_FILE_PATH)){
            $APP_JSON = file_get_contents($APP_FILE_PATH);
        }else{
            $APP_JSON = array();
        }
        return array(
            'core' => $CORE_JSON,
            'app' => $APP_JSON
        );
    }

    private function toObjectConfiguration($CORE_JSON, $APP_JSON){
        return (object) array_merge((array) json_decode($CORE_JSON), (array) json_decode($APP_JSON));
    }

    private function buildConfiguration(){
        $this->_GLOBAL = $this->toObjectConfiguration($this->_GLOBAL_JSON['core'], $this->_GLOBAL_JSON['app']);
        $this->_LAYOUT = $this->toObjectConfiguration($this->_LAYOUT_JSON['core'], $this->_LAYOUT_JSON['app']);
        $this->_DB = $this->toObjectConfiguration($this->_DB_JSON['core'], $this->_DB_JSON['app']);
        return $this;
    }

}

?>