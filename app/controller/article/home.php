<?php

use pia\core\_Pia_Controller as PiaController;

class c_article_home extends PiaController
{

    public function __construct($data){
        parent::__construct();
    }

    public function index(){
        echo '<h1>Article</h1>';
        $this->render();
    }

}

?>