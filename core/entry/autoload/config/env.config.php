<?php

// Application environment vars
define('_PIA_APP_', _PIA_ENV_.'/app/');
define('_PIA_CTRL_', _PIA_APP_.'controller');
define('_PIA_CTRL_ERR_', _PIA_CTRL_.'/errors');
define('_PIA_MODEL_', _PIA_APP_.'model');
define('_PIA_VIEWS_', _PIA_APP_.'views/');
define('_PIA_LAYOUT_', _PIA_APP_.'layout/');
// -----------------------------------------

// Frontend environment vars
define('_PIA_SOURCE_', 'src/');
define('_PIA_SOURCE_REL_', _PIA_ENV_.'/src/');
// -----------------------------------------

// Viriable ressources environment vars
define('_PIA_VARS_', '/var/');
define('_PIA_SOURCES_VARS_', _PIA_VARS_.'web/');
// -----------------------------------------

?>