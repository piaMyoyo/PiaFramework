<?php
// A new beginning

define('_PIA_LOCATION_', 'dev'); // dev OR prod

define('_PIA_ENV_', dirname(__FILE__));
define('_PIA_CORE_', _PIA_ENV_.'/core/');
define('_PIA_ENTRY_', _PIA_CORE_.'/entry/');

if(!@include(_PIA_ENTRY_."/pia-entry.php")){
    throw new Exception("Failed to include launching file '"._PIA_ENTRY_."/pia-entry.php'");
}

exit();
?>