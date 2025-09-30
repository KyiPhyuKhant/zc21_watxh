<?php
/**
 * @package Pages
 * @copyright Copyright 2008-2010 RubikIntegration.com
 * @author yellow1912
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.
 */

/**
 * NOTE: You can use php files for both javascript and css.
 *
 * Global variables must be declared global as they are referenced inside the loader class
 *
 * They must be coded like so:
 * Javascript:
 * <script language="javascript" type="text/javascript">
 * <?php // php code goes here ?>
 * </script>
 *
 * CSS:
 * <style type="text/css">
 * <?php // php code goes here ?>
 * </style>
 */

$loaders[] = array('conditions' => array('pages' => array('checkout_payment')),
	'css_files' => array(
		'saved_card_checkout.css' => 1
	)
);

if(defined('FILENAME_ONE_PAGE_CHECKOUT')) {
	$loaders[] = array('conditions' => array('pages' => array(FILENAME_ONE_PAGE_CHECKOUT)),
		'css_files' => array(
			'oprc_saved_card_checkout.css' => 10
		)
	);
}