<?php

namespace pia\core;

abstract class _Pia_Model
{

    private $_PDO;
    private $_DATABASE;

    private $_DEFAULT;

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

        $this->_MODELS[$model]->init($db_params);
        if(!array_key_exists("type", $params))
            $params = '';
        $this->_PDO = new PDO('mysql:host=mon_serveur;dbname=ma_bdd;port=mon_port', 'mon_identifiant', 'mon_mdp');
        return $this;
    }

}

?>