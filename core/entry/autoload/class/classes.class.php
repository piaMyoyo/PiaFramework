<?php

namespace entry\autoload\classes;

class autoloadClass
{

    public $_fileExtension;

    protected $_prefix;
    protected $_suffix;

    protected $_classFileName;
    protected $_classFilePath;

    public function _setPrefix($prefix){
        $this->_prefix = $prefix;
        return $this;
    }

    public function _setSuffix($suffix){
        $this->_suffix = $suffix;
        return $this;
    }

    public function _setFileExtension($fileExtension){
        $this->_fileExtension = $fileExtension;
        return $this;
    }

    protected function buildClassFileName($classname){
        $this->_classFileName = $this->_prefix.$classname.$this->_suffix.$this->_fileExtension;
        return $this;
    }

    protected function buildClassFilePath(){
        return _PIA_CORE_CLASSES_.$this->_classFileName;
    }

    public function loadClass($classname){
        return $this->buildClassFileName($classname)->buildClassFilePath();
    }

}

?>