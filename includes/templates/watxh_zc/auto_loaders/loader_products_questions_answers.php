<?php
/**
 * Products Questions Answers
 */

$loaders[] = array('conditions' => array('pages' => array(FILENAME_PRODUCT_INFO)),
	'jscript_files' => array(
		'jquery/jquery-1.12.0.min.js' => 1,
		'jquery/jquery-migrate-1.3.0.min.js' => 2,
		'jquery/jquery_continuous_scroll.js' => 6,
		'//www.google.com/recaptcha/api.js' => 10,
		'jquery/jquery_products_questions_answers.php' => 11,
		'jquery/jquery_products_questions_answers.js' => 12,
	),
	'css_files' => array(
		'prod_qa.css' => 2,
		'auto_loaders/prod_qa_over.css' => 3
	)
);
