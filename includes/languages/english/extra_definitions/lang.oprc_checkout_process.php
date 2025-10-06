<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: J_Schilz for Integrated COWOA - 14 April 2007
 */

// this is used to display the text link in the "information" or other sidebox
$define = [
    'DATE_FORMAT' => 'm/d/Y',
    'DATE_FORMAT_DATE_PICKER' => 'yy-mm-dd',
    'DATE_FORMAT_LONG' => '%A %d %B, %Y',
    'DATE_FORMAT_SHORT' => '%m/%d/%Y',
    'DATE_FORMAT_SPIFFYCAL' => 'MM/dd/yyyy',
    'DATE_TIME_FORMAT' => '%%DATE_FORMAT_SHORT%%' . ' %H:%M:%S',
];

$zc158 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= '5.8'));
if ($zc158) {
    return $define;
} else {
    nmx_create_defines($define);
}
//eof