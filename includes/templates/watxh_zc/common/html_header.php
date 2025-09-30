<?php
// if ($nmx_disk_cache->cacheStart('html_header', array($_SESSION['customer_id']), true, true)) {
?>
<?php
    /**
     * Common Template
     *
     * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
     *
     * @package templateSystem
     * @copyright Copyright 2003-2010 Zen Cart Development Team
     * @copyright Portions Copyright 2003 osCommerce
     * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
     * @version $Id: html_header.php 6 2012-05-07 21:43:01Z numinix $
     */
    /**
     * load the module for generating page meta-tags
     */
    require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
    /**
     * output main page HEAD tag and related headers/meta-tags, etc
     */
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>

<head>
 <title><?php echo META_TAG_TITLE; ?></title>
 <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
 <meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
 <meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
 <meta http-equiv="imagetoolbar" content="no" />
 <meta name="author" content="The Zen Cart&trade; Team and others" />
 <meta name="generator" content="shopping cart program by Zen Cart&trade;, http://www.zen-cart.com eCommerce" />
 <meta name="robots" content="noindex, nofollow" />
 <?php if (defined('FAVICON')) { ?>
 <link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
 <link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
 <?php } //endif FAVICON 
        ?>

 <base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG); ?>" />
 <?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
 <link rel="canonical" href="<?php echo $canonicalLink; ?>" />
 <?php } ?>

 <?php
        /**
         * load the loader files
         */
        $RC_loader_files = array();
        if ($RI_CJLoader->get('status') && (!isset($Ajax) || !$Ajax->status())) {
            $RI_CJLoader->autoloadLoaders();
            $RI_CJLoader->loadCssJsFiles();
            $RC_loader_files = $RI_CJLoader->header();

            if (!empty($RC_loader_files['meta']))
                foreach ($RC_loader_files['meta'] as $file) {
                    include($file['src']);
                    echo "\n";
                }

            if (!empty($RC_loader_files['css']))
                foreach ($RC_loader_files['css'] as $file) {
                    if ($file['include']) {
                        include($file['src']);
                    } else if (!$RI_CJLoader->get('minify_css') || $file['external']) {
                        //$link = $file['src'];
                        echo '<link rel="stylesheet" type="text/css" href="' . $file['src'] . '" />' . "\n";
                    } else {
                        //$link = 'min/?f='.$file['src'].'&amp;'.$RI_CJLoader->get('minify_time');
                        echo '<link rel="stylesheet" type="text/css" href="min/?f=' . $file['src'] . '&amp;' . $RI_CJLoader->get('minify_time') . '" />' . "\n";
                    }
                }
        }
        //DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
        ?>
</head>
<?php
//     $nmx_disk_cache->cacheEnd();common/tpl_main_page.php 
// }
?>
<?php // NOTE: Blank line following is intended: 
?>