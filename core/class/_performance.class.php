<?php

namespace pia\core;

class _Pia_Performance
{

    private $_TOTAL_START;
    private $_TOTAL_END;
    private $_TOTAL;

    public function init(){
        $this->performanceTotalStart();
    }

    public function destroy(){
        $this->performanceTotalEnd();
        $this->_TOTAL = round($this->_TOTAL_END - $this->_TOTAL_START, 5);
        return $this->_TOTAL;
    }

    public function performanceTotalStart(){
        $this->_TOTAL_START = microtime(true);
    }

    public function performanceTotalEnd(){
        $this->_TOTAL_END = microtime(true);
    }

}

?>