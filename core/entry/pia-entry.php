<?php

// Autoload Configuration
$PiaAutoloadConfigClasses = 'class.config.php';
$PiaAutoloadConfigEnvironment = 'env.config.php';

if(!@include(_PIA_ENTRY_."/autoload/config/$PiaAutoloadConfigEnvironment")){
    throw new Exception("Failed to include lauching file on '"._PIA_ENTRY_."/config/$PiaAutoloadConfigEnvironment'");
}

if(!@include(_PIA_ENTRY_."/autoload/pia-autoload.php")){
    throw new Exception("Failed to include lauching file on '"._PIA_ENTRY_."/autoload/pia-autoload.php'");
}

if(!@include(_PIA_CORE_."/pia/pia.php")){
    throw new Exception("Failed to include lauching file on '"._PIA_CORE_."/pia/pia.php'");
}

$_PIA_CORE_ENTRY_POINT = new pia\core\_Pia_Core;

$_PIA_CORE_ENTRY_POINT->initPerformance()
                      ->initConfig()
                      ->initError()
                      ->initRoute();

require $_PIA_CORE_ENTRY_POINT->getRoute()->_CTRL_PATH;
if(class_exists($_PIA_CORE_ENTRY_POINT->getRoute()->_CTRL_NAME)){
    $_CTRL_NAME = $_PIA_CORE_ENTRY_POINT->getRoute()->_CTRL_NAME;
}else{
    require _PIA_CTRL_ERR_.'/404'._PIA_CORE_FILES_EXTENSION_;
    $_CTRL_NAME = $_PIA_CORE_ENTRY_POINT->getConfig()->_GLOBAL->controller->errors->_404;
}

$_PIA_MAIN_CONTROLLER = new $_CTRL_NAME();

if(method_exists($_PIA_MAIN_CONTROLLER, $_PIA_CORE_ENTRY_POINT->getConfig()->_GLOBAL->entryMethod)){
    $_PIA_MAIN_METHOD = $_PIA_CORE_ENTRY_POINT->getConfig()->_GLOBAL->entryMethod;
    $_PIA_MAIN_CONTROLLER->$_PIA_MAIN_METHOD();
}else exit;;



// Everything start with a dream

$_PIA_CORE_ENTRY_POINT->endPerformance();

?>