<?php

if(!@include(_PIA_ENTRY_."/autoload/config/core.config.php")){
    throw new Exception("Failed to include lauching file on '"._PIA_ENTRY_."/config/core.config.php'");
}

if(substr(_PIA_CORE_FILES_EXTENSION_, 0, 1) !== '.')
    $_PIA_CORE_FILES_EXTENSION = '.'._PIA_CORE_FILES_EXTENSION_;
else $_PIA_CORE_FILES_EXTENSION = _PIA_CORE_FILES_EXTENSION_;

if(!@include(_PIA_ENTRY_."/autoload/class/autoload.class.php")){
    throw new Exception("Failed to include autoload files");
}

if(!@include(_PIA_ENTRY_."/autoload/class/classes.class.php")){
    throw new Exception("Failed to include autoload files");
}

$autoloader = new entry\autoload\autoload;
$autoloader->_setCoreFileExtention($_PIA_CORE_FILES_EXTENSION)->init();
$autoloadClasses = $autoloader->getClassesNames();

if(!is_array($autoloadClasses)){
    throw new Exception("Cannot include core components : Classes not found");
}

foreach($autoloadClasses as $classIndex => $className){
    $classFilePath = $autoloader->classAutoload($className);
    if(!@include($classFilePath)){
        throw new Exception("Cannot include core components : Class file not found on '$classFilePath'");
    }
}

?>