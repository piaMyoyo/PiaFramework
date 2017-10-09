<?php

use pia\core\_Pia_Controller as PiaController;

class c_home extends PiaController
{

    public function __construct($data){
        parent::__construct();
    }

    public function index(){
        $this->loadModel('page');
        $pages = $this->getModel('page')->getPages();
        $this->prepareLayout('main')->loadView('home')->render(true)->output();
        // var_dump($pages);
    }

}

?>