<?php

namespace pia\core;

use PDO;

abstract class _Pia_Model
{

    private $_DATABASE;

    private $_DEFAULT;

    protected $_PDO;
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

    public function init($params){
        $dbName = $this->_DATABASE;
        $db_params = $params->$dbName;


        if(!array_key_exists("type", $db_params))
            $this->_TYPE = $this->_DEFAULT['type'];
        else $this->_TYPE = $db_params->type;

        if(!array_key_exists("host", $db_params))
            $this->_HOST = $this->_DEFAULT['host'];
        else $this->_HOST = $db_params->host;

        if(!array_key_exists("port", $db_params))
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