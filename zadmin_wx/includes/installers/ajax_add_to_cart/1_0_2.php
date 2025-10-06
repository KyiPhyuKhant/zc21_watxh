<?php

global $sniffer;
if (!$sniffer->field_exists(TABLE_CONFIGURATION, 'configuration_tab'))  $db->Execute("ALTER TABLE " . TABLE_CONFIGURATION . " ADD configuration_tab varchar(32) NOT NULL DEFAULT 'both';");
 
  $db->Execute("UPDATE " . TABLE_CONFIGURATION . " 
		SET configuration_tab = 'Advanced'
		WHERE configuration_key IN ('AATC_CALLBACK',
		  'AATC_ADD_TO_CART_SELECTOR',
		  'AATC_CUSTOM_SELECTORS_PRODUCTS',
		  'AATC_CUSTOM_SELECTORS_LISTINGS',
		  'AATC_SHOPPINGCART_SIDEBOX_SELECTOR',
		  'AATC_SHOPPINGCART_HEADER_SELECTOR');");
  $db->Execute("UPDATE " . TABLE_CONFIGURATION . " 
		SET configuration_tab = 'Style'
		WHERE configuration_key IN ('AATC_PROCESSING_STATUS',
		  'AATC_PROCESSING_TEXT',
		  'AATC_ADD_TO_CART_TEXT',
		  'AATC_MESSAGE_BACKGROUND_COLOR',
		  'AATC_MESSAGE_TEXT_COLOR',
		  'AATC_MESSAGE_OPACITY',
		  'AATC_MESSAGE_OVERLAY_COLOR',
		  'AATC_MESSAGE_OVERLAY_TEXT_COLOR',
		  'AATC_MESSAGE_OVERLAY_OPACITY');");		  
$configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'AJAX Add to Cart Configuration' ORDER BY configuration_group_id ASC;");
