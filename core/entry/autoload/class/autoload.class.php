<?php

namespace entry\autoload;

use entry\autoload\classes as classes;

class autoload
{

    private $_classConfig;
    private $_classesNames;
    private $_classNamePrefix;
    private $_classNameSuffix;

    private $_classAutoloader;

    private $_coreFileExtension;


    public function init(){
        $this->_classConfig = $this->_getConfigCoreClassesFile();
        $this->_classesNames = $this->_classConfig->classes;
        $this->_classNamePrefix = $this->_classConfig->classNamePrefix;
        $this->_classNameSuffix = $this->_classConfig->classNameSuffix;

        $this->_classAutoloader = new classes\autoloadClass;
        $this->_classAutoloader->_setPrefix($this->_classNamePrefix)
                               ->_setSuffix($this->_classNameSuffix)
                               ->_setFileExtension($this->_coreFileExtension);

        return $this;
    }

    public function getClassesNames(){
        return $this->_classesNames;
    }

    public function getClassNamePrefix(){
        return $this->classNamePrefix;
    }

    public function getClassNameSuffix(){
        return $this->classNameSuffix;
    }

    public function classAutoload($classname){
        return $this->_classAutoloader->loadClass($classname);
    }

    public function _setCoreFileExtention($ext){
        $this->_coreFileExtension = $ext;
        return $this;
    }

    protected function _getConfigCoreClassesFile(){
        $filePath = _PIA_ENTRY_."/autoload/config/autoload.config.json";
        if(file_exists($filePath)){
            $file = file_get_contents($filePath);
            return json_decode($file);
        }else throw new Exeption("Cannot get class file configuration on location : '"._PIA_ENTRY_."/autoload/config/class.config.json'.");
    }

}

?>