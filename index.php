<?php
// A new beginning

define('_PIA_VERSION_', '0.0.1');
define('_PIA_ENV_', dirname(__FILE__));
define('_PIA_CORE_', _PIA_ENV_.'/core/');
define('_PIA_ENTRY_', _PIA_CORE_.'/entry/');

//error_reporting(E_ALL);

if(!@include(_PIA_ENTRY_."/pia-entry.php")){
    throw new Exception("Failed to include launching file '"._PIA_ENTRY_."/pia-entry.php'");
}

exit();
?>