<?php

use pia\core\_Pia_Model as PiaModel;

class page_model extends PiaModel
{
    public function __construct(){
        parent::__construct();
    }

    public function getPages(){
        $sql = 'SELECT * FROM page';
        $req = $this->_PDO->prepare($sql);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
}

?>