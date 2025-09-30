<?php

$loaders[] = array(
    'conditions' => array('pages' => array('shopping_cart')),
    'jscript_files' => array(
        'jquery/jquery_share_my_cart.js' => 1
    ),
	'css_files' => array(
		'share_my_cart.css' => 1
	)
);

$loaders[] = array(
    'conditions' => array('pages' => array('*')),
	'css_files' => array(
        'share_my_cart_button_styles.php' => 3
	)
);