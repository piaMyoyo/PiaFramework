<?php

namespace pia\core;

abstract class _Pia_Model
{

    private $_PDO;
    private $_DATABASE;

    private $_DEFAULT;

    protected $_TYPE;
    protected $_HOST;
    protected $_PORT;

    public function __construct(){
        $this->_DATABASE = "default";
        $this->_DEFAULT = [
            "type" => "mysql",
            "host" => "localhost",
            "port" => "3306"
        ];
    }

    public function setDatabase($db_name){
        $this->_DATABASE = $db_name;
        return $this;
    }

    public function init(){
        $db_config = $this->_CONFIG->_DB;

        if(!array_key_exists($model, $db_config)){
            die('Unable to connect database.');
        }

        $db_params = $db_config->$model;
        $this->_MODELS[$model] = new PiaModel;

        if(!array_key_exists("type", $params))
            $this->_TYPE = $this->_DEFAULT['type'];
        else $this->_TYPE = $db_params->type;

        if(!array_key_exists("host", $params))
            $this->_HOST = $this->_DEFAULT['host'];
        else $this->_HOST = $db_params->host;

        if(!array_key_exists("port", $params))
            $this->_PORT = $this->_DEFAULT['port'];
        else $this->_PORT = $db_params->port;

        $_PDO_CONNECT = $this->_TYPE.':host='.$this->_HOST.';dbname='.$db_params->name.';port='.$this->_PORT;

        try{
            $this->_PDO = new PDO($_PDO_CONNECT, $db_params->user, $db_params->pass);
            return $this;
        }
        catch (Exception $e){
          die("Unable to connect to database: " . $e->getMessage());
        }
    }

}

?>