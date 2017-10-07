<?php

use pia\core\_Pia_Controller as PiaController;

class c_home extends PiaController
{

    public function __construct($data){
        parent::__construct();
    }

    public function index(){
        $this->loadModel('page');
        $this->render();
        $pages = $this->getModel('page')->getPages();
        var_dump($pages);
    }

}

?>