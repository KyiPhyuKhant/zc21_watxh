<?php
/**
* @package Pages
* @copyright Copyright 2008-2009 RubikIntegration.com
* @copyright Copyright 2003-2006 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: link.php 149 2009-03-04 05:23:35Z yellow1912 $
*/                                                                                                         
$loaders[] = array('conditions' => array('pages' => array('account', 'account_edit', 'account_history', 'account_credit_balance', 'account_history_info', 'account_newsletters', 'account_notifications', 'account_password', 'address_book', 'address_book_process', 'account_referrals', 'account_recurring')),
								'jscript_files'	=> array(
									
									'jquery/jquery_accountform_check.php' => 4,
									'jquery/jquery_address_book_process_popup.js' 	=> 5,
									'jquery/jquery_account_nav.js' 	=> 6
								),
								'css_files' => array(
										'account_area.css' => 1
									)									
								); 
