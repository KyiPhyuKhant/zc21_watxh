<?php

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES
            (NULL, 'Status', 'AATC_STATUS', 'false', 'Enable AJAX Add to Cart?', " . $configuration_group_id . ", 1, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
            (NULL, 'AJAX Add to Cart Messages', 'AATC_ADD_TO_CART_MESSAGES', 'true', 'Display messages inside an alert box?', " . $configuration_group_id . ", 2, NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
            (NULL, 'Add to Cart Box Selector', 'AATC_ADD_TO_CART_SELECTOR', '#cartAdd', 'Define the selector which contains the quantity in cart (note: leave blank to disable)', " . $configuration_group_id . ", 22, NOW(), NULL, NULL),
            (NULL, 'Product Info Cart Custom Selectors', 'AATC_CUSTOM_SELECTORS_PRODUCTS', '', 'Define custom selectors separated by commas (no spaces):', " . $configuration_group_id . ", 23, NOW(), NULL, NULL),
            (NULL, 'Product Listing Custom Selectors', 'AATC_CUSTOM_SELECTORS_LISTINGS', '', 'Define custom selectors separated by commas (no spaces):', " . $configuration_group_id . ", 23, NOW(), NULL, NULL),
            (NULL, 'Shopping Cart Sidebox Selector', 'AATC_SHOPPINGCART_SIDEBOX_SELECTOR', 'div#shoppingcart', 'Define the selector which contains the shopping cart sidebox', " . $configuration_group_id . ", 20, NOW(), NULL, NULL),
            (NULL, 'Shopping Cart Header Selector', 'AATC_SHOPPINGCART_HEADER_SELECTOR', '', 'Define the selector which contains the shopping cart header (note: this is not standard Zen Cart, leave blank to disable)', " . $configuration_group_id . ", 20, NOW(), NULL, NULL),
            (NULL, 'Callback Function', 'AATC_CALLBACK', '', 'Add JavaScript to be executed after adding an item on the product info page:', " . $configuration_group_id . ", 24, NOW(), NULL, 'zen_cfg_textarea('),
            (NULL, 'Display Processing Message', 'AATC_PROCESSING_STATUS', 'true', 'Display a processing message when making AJAX requests?', " . $configuration_group_id . ", 30, NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
            (NULL, 'Processing Text', 'AATC_PROCESSING_TEXT', 'Processing...', 'Text to display when processing changes on the page:', " . $configuration_group_id . ", 31, NOW(), NULL, NULL),
            (NULL, 'Add to Cart Text', 'AATC_ADD_TO_CART_TEXT', 'Adding to Cart...', 'Text to display when adding products to the cart:', " . $configuration_group_id . ", 31, NOW(), NULL, NULL),
            (NULL, 'Block Background Color', 'AATC_MESSAGE_BACKGROUND_COLOR', '#000', 'Enter the hex or color name for the message background color:', " . $configuration_group_id . ", 31, NOW(), NULL, NULL),
            (NULL, 'Block Text Color', 'AATC_MESSAGE_TEXT_COLOR', '#FFF', 'Enter the hex or color name for the message text color:', " . $configuration_group_id . ", 31, NOW(), NULL, NULL),
            (NULL, 'Block Opacity', 'AATC_MESSAGE_OPACITY', '0.5', 'Enter the opacity for the block message:', " . $configuration_group_id . ", 31, NOW(), NULL, NULL),
            (NULL, 'Block Overlay Color', 'AATC_MESSAGE_OVERLAY_COLOR', '#FFF', 'Enter the hex or color name for the overlay background color:', " . $configuration_group_id . ", 32, NOW(), NULL, NULL),
            (NULL, 'Block Overlay Text Color', 'AATC_MESSAGE_OVERLAY_TEXT_COLOR', '#000', 'Enter the hex or color name for the overlay text color:', " . $configuration_group_id . ", 32, NOW(), NULL, NULL),
            (NULL, 'Block Overlay Opacity', 'AATC_MESSAGE_OVERLAY_OPACITY', '0.4', 'Enter the opacity for the block overlay:', " . $configuration_group_id . ", 32, NOW(), NULL, NULL);");

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
  // delete configuration menu
  $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = 'configAJAXAddtoCart' LIMIT 1;");
  // add configuration menu
  if (!zen_page_key_exists('configAJAXAddtoCart')) {
    $configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'AATC_VERSION' LIMIT 1;");
    $configuration_group_id = $configuration->fields['configuration_group_id'];
    if ((int)$configuration_group_id > 0) {
      zen_register_admin_page('configAJAXAddtoCart',
                              'BOX_CONFIGURATION_AJAX_ADD_TO_CART', 
                              'FILENAME_CONFIGURATION',
                              'gID=' . $configuration_group_id, 
                              'configuration', 
                              'Y',
                              $configuration_group_id);
        
      $messageStack->add('Enabled AJAX Add to Cart Configuration menu.', 'success');
    }
  }
}
