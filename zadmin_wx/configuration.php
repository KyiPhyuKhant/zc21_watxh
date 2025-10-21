<?php
/**
 * @package admin
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Jun 30 2014 Modified in v1.5.4 $
 */

require_once('includes/application_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
  
if (zen_not_null($action)) {
	switch ($action) {
		case 'save':
			
			foreach($_POST as $cfgID => $cfgValue) {
				$strpos = strpos($cfgID, 'cfg_');
				if ($strpos !== FALSE) {
					$cID = zen_db_prepare_input(substr($cfgID, $strpos + 4));
					$configuration_value = zen_db_prepare_input($cfgValue);
					$db->Execute("UPDATE " . TABLE_CONFIGURATION . "
												SET configuration_value = '" . zen_db_input($configuration_value) . "',
												last_modified = NOW() WHERE configuration_id = '" . (int)$cID . "'");
				}
			}
			
			// set the WARN_BEFORE_DOWN_FOR_MAINTENANCE to false if DOWN_FOR_MAINTENANCE = true
			if ( (WARN_BEFORE_DOWN_FOR_MAINTENANCE == 'true') && (DOWN_FOR_MAINTENANCE == 'true') ) {
				$db->Execute("UPDATE " . TABLE_CONFIGURATION . "
											SET configuration_value = 'false', last_modified = NOW()
											WHERE configuration_key = 'WARN_BEFORE_DOWN_FOR_MAINTENANCE'"); 
			}

			zen_redirect(zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $_GET['gID'] ));
			break;
	}
}

$gID = (isset($_GET['gID'])) ? $_GET['gID'] : 1;
$_GET['gID'] = $gID;
$cfg_group = $db->Execute("SELECT configuration_group_title
													FROM " . TABLE_CONFIGURATION_GROUP . "
													WHERE configuration_group_id = '" . (int)$gID . "'");

if ($gID == 7) {
	$shipping_errors = '';
	if (zen_get_configuration_key_value('SHIPPING_ORIGIN_ZIP') == 'NONE' or zen_get_configuration_key_value('SHIPPING_ORIGIN_ZIP') == '') {
		$shipping_errors .= '<br />' . ERROR_SHIPPING_ORIGIN_ZIP;
	}
	if (zen_get_configuration_key_value('ORDER_WEIGHT_ZERO_STATUS') == '1' and !defined('MODULE_SHIPPING_FREESHIPPER_STATUS')) {
		$shipping_errors .= '<br />' . ERROR_ORDER_WEIGHT_ZERO_STATUS;
	}
	if (defined('MODULE_SHIPPING_USPS_STATUS') and (MODULE_SHIPPING_USPS_USERID=='NONE' or MODULE_SHIPPING_USPS_SERVER == 'test')) {
		$shipping_errors .= '<br />' . ERROR_USPS_STATUS;
	}
	if ($shipping_errors != '') {
		$messageStack->add(ERROR_SHIPPING_CONFIGURATION . $shipping_errors, 'caution');
	}
}

$configuration_query = "SELECT configuration_id, configuration_title, configuration_value, configuration_description, configuration_key, use_function, set_function, configuration_tab 
	FROM " . TABLE_CONFIGURATION . "
	WHERE configuration_group_id = '" . (int)$gID . "'
	ORDER BY sort_order, configuration_tab ASC";
$configuration = $db->Execute($configuration_query);
$tabs = array(); 
if ($configuration->RecordCount() > 0) {	
	while (!$configuration->EOF) {		
		if (!array_key_exists($configuration->fields['configuration_tab'], $tabs) && $configuration->fields['configuration_tab'] != '') {
			// create a new tab
			$tabs[$configuration->fields['configuration_tab']] = array('options' => array());
		}
		if ($configuration->fields['configuration_tab'] == '') $configuration->fields['configuration_tab'] = 'General';
		
		$tabs[$configuration->fields['configuration_tab']]['options'][] = array(
			'configuration_id' => $configuration->fields['configuration_id'], 
			'configuration_title' => $configuration->fields['configuration_title'],
			'configuration_description' => $configuration->fields['configuration_description'], 
			'configuration_value' => $configuration->fields['configuration_value'], 
			'configuration_key' => $configuration->fields['configuration_key'], 
			'use_function' => $configuration->fields['use_function'],
			'set_function' => $configuration->fields['set_function']
		);
		$configuration->MoveNext();	
	}		
}
    
if (count($tabs) <= 1) {
	require_once('configuration_default.php');  
} else {

?>
<!doctype html>
	<html <?php echo HTML_PARAMS; ?>>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
		<title><?php echo TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
		<link rel="stylesheet" href="includes/modules/tabbed_configuration/css/tabbed_configuration.css"> 
		<script language="javascript" src="includes/menu.js"></script>
		<script language="javascript" src="includes/general.js"></script>
		<script type="text/javascript">
			<!--
			function init()
			{
				cssjsmenu('navbar');
				if (document.getElementById)
				{
					var kill = document.getElementById('hoverJS');
					kill.disabled = true;
				}
			}
			// -->
		</script>
	</head>
	<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">
		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		<!-- header_eof //-->
			<div class="wrap">
				
				<div class="mod-header">
					<h1><?php echo $cfg_group->fields['configuration_group_title']; ?></h1>
				</div>
				<div class="mod-content">
					<?php 
						echo zen_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . (int)$_GET['gID'] . '&action=save');
					?>
					<div id="tabs">
						<?php
							foreach($tabs as $tab => $tab_vals) {
								// build the tab
						?>
						<ul class="mod-tabs resp-tabs-list">
							<li><?php echo $tab; ?></li>
						</ul>
						<div class="mod-tabs-content resp-tabs-container">
							<div>
								<table class="mod-table">
									<tbody>
										<?php
											foreach($tab_vals['options'] as $configuration_option) {
												echo '<tr>' . "\n";
												echo '	<td class="cl">' . $configuration_option['configuration_title'] . '</td>' . "\n";							
												echo '	<td class="cl is-details"><em>' . $configuration_option['configuration_description'] . '</em></td>' . "\n";
												echo '	<td class="cl">' . "\n";
												if ($configuration_option['set_function']) {
													$set_function = nmx_configuration_function($configuration_option['set_function']);
														eval('$value_field = ' . $set_function . '"' . htmlspecialchars($configuration_option['configuration_value'], ENT_COMPAT, CHARSET, TRUE) . '");');
												} else {
													$value_field = zen_draw_input_field('cfg_' . $configuration_option['configuration_id'], htmlspecialchars($configuration_option['configuration_value'], ENT_COMPAT, CHARSET, TRUE), 'size="60"');
												}							
												echo '		' . preg_replace('/<br>/', '', str_replace('configuration_value', 'cfg_' . $configuration_option['configuration_id'], $value_field), 1) . "\n";
												echo '	</td>' . "\n";	      			
												echo '</tr>' . "\n";
											}
										?>
									</tbody>
								</table>
								
							</div>
						</div>
						<?php	      		
							}
						?>
						<div class="mod-buttons">
							<button class="mod-buttons-call"><?php echo TEXT_BUTTON_SAVE_CHANGES; ?></button>
							<a href="<?php echo zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $_GET['gID']); ?>" class="mod-buttons-second"><?php echo TEXT_BUTTON_CANCEL; ?></a>
						</div>				
					</div>
					</form>
				</div>
				<div class="mod-footer">
					<div class="mod-copyright">
						<span>&copy; <?php echo date('Y'); ?> <a href="http://www.numinix.com" target="_blank">Numinix.com</a></span>
						<a href="http://www.numinix.com" target="_blank"><img src="includes/modules/tabbed_configuration/images/logo_numinix.png" alt="Numinix" /></a>
					</div>
				</div>
			</div>
			<!-- footer //-->
			<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
			<!-- footer_eof //-->
		<!-- check if jquery is already loaded in the header for avoiding conflicts -->
		<script type="text/javascript" src="//www.google.com/jsapi"></script>
		<script type="text/javascript">if (typeof jQuery == 'undefined') google.load("jquery", "1");</script>
		<script src="includes/modules/tabbed_configuration/js/jquery-easyResponsiveTabs.js"></script>  
		<script src="includes/modules/tabbed_configuration/js/jquery-main.js"></script>
	</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php } ?>