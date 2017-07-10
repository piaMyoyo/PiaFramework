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
echo 'pl';

if(!@include(_PIA_CORE_."/pia/pia.php")){
    throw new Exception("Failed to include lauching file on '"._PIA_CORE_."/pia/pia.php'");
}

$_PIA_CORE_ENTRY_POINT = new pia\core\_Pia_Core;
$_PIA_CORE_ENTRY_POINT->initConfig()->initError();
var_dump($_PIA_CORE_ENTRY_POINT);
?>