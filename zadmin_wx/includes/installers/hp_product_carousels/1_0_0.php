<?php

// Create Admin Page

/**
 * Check and make sure this is zc 1.5. If it is, install the admin page
 */
$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) {
  $admin_page = 'configHPPC';

  // If there is a current HPPC page, delete it  
  $db->Execute("DELETE FROM ".TABLE_ADMIN_PAGES." WHERE page_key = '".$admin_page."' LIMIT 1;");

  // add configuration menu
  if (!zen_page_key_exists($admin_page)) {
    if ((int)$configuration_group_id > 0) {
      zen_register_admin_page($admin_page,
        'BOX_HPPC', 
        'FILENAME_CONFIGURATION',
        'gID=' . $configuration_group_id, 
        'configuration', 
        'Y',
        $configuration_group_id);

      $messageStack->add('Enabled Home Page Product Carousels Configuration Menu.', 'success');
    }
  }
}

// Set up the options for the home page product carousels
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order, set_function) VALUES 
            (" . (int) $configuration_group_id . ", 'HPPC_STATUS', 'Status', 'true', 'Enable Home Page Product Carousels?', 0, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
            (" . (int) $configuration_group_id . ", 'HPPC_ITEMS', 'Items (screen > 1520px)', '4', 'How many products should be displayed for wide screens (> 1520px)?', 1, NULL),
            (" . (int) $configuration_group_id . ", 'HPPC_ITEMS_DESKTOP', 'Items Desktop (screen > 1200px)', '4', 'How many products should be displayed for desktop (> 1200px)?', 1, NULL),
            (" . (int) $configuration_group_id . ", 'HPPC_ITEMS_SMALL', 'Items Small Desktop (screen > 979px)', '4', 'How many products should be displayed for small desktop (> 979px)?', 1, NULL),
            (" . (int) $configuration_group_id . ", 'HPPC_ITEMS_TABLET', 'Items Tablets (screen > 768px)', '3', 'How many products should be displayed for tablet (> 768px)?', 1, NULL),
            (" . (int) $configuration_group_id . ", 'HPPC_ITEMS_MOBILE', 'Items Mobile (screen > 520px)', '2', 'How many products should be displayed for mobile (> 520px)?', 1, NULL),
            (" . (int) $configuration_group_id . ", 'HPPC_NAVIGATION', 'Navigation', 'true', 'Display next and prev buttons', 2, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
            (" . (int) $configuration_group_id . ", 'HPPC_AUTOPLAY', 'Auto Play', 'false', 'Would you like the carousels to automatically slide every 5 seconds?', 3, 'zen_cfg_select_option(array(\"true\", \"false\"),');");
