<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
};

// ioncube version 14 encoded for PHP versions less than 8.3
$autoLoadConfig[199][] = array('autoType'=>'class',
    'loadFile'=>'numinix_plugins.php',
    'classPath'=> DIR_WS_CLASSES
);