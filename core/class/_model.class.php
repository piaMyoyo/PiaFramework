<?php

namespace pia\core;

abstract class _Pia_Model
{

    private $_PDO;
    private $_DATABASE;

    private $_DEFAULT;

    public function __construct(){
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
        $this->_PDO = new PDO('mysql:host=mon_serveur;dbname=ma_bdd;port=mon_port', 'mon_identifiant', 'mon_mdp');
        return $this;
    }

}

?>