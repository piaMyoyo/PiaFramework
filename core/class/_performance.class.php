<?php

namespace pia\core;

class _Pia_Performance
{

    private $_TOTAL_START;
    private $_TOTAL_END;

    public function init(){
        $this->performanceTotalStart();
    }

    public function destroy(){
        $this->performanceTotalEnd();
        var_dump(round($this->_TOTAL_END - $this->_TOTAL_START, 5));
    }

    public function performanceTotalStart(){
        $this->_TOTAL_START = microtime();
    }

    public function performanceTotalEnd(){
        $this->_TOTAL_END = microtime();
    }

}

?>