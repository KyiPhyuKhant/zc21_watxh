<?php

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            ('Status', 'NMX_DISK_CACHE_STATUS', 'false', 'Enable Numinix Disk Cache?', " . $configuration_group_id . ", 1, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
            ('Default Cache Time', 'NMX_DISK_CACHE_DEFAULT_TIME', '3600', 'Set a default time limit in seconds for caching content.  Note: setting this option to 0 and not specifying an override in the code will disable the caching function.', " . $configuration_group_id . ", 2, NOW(), NOW(), NULL, NULL),
            ('Default GZip Level', 'NMX_DISK_CACHE_DEFAULT_GZIP', '0', 'Set to a value from 1 to 9 to enable gzip compression.  Leave as 0 or blank to disable.', " . $configuration_group_id . ", 3, NOW(), NOW(), NULL, NULL),
            ('Cron Key', 'NMX_DISK_CACHE_KEY', 'numinix', 'Set a unique key to be used for executing the cron file.', " . $configuration_group_id . ", 4, NOW(), NOW(), NULL, NULL);");

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150 && function_exists('zen_page_key_exists') && function_exists('zen_register_admin_page')) { // continue Zen Cart 1.5.0
  // delete configuration menu
  $db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = 'configNMXDiskCache' LIMIT 1;");
  // add configuration menu
  if (!zen_page_key_exists('configNMXDiskCache')) {
    if ((int)$configuration_group_id > 0) {
      zen_register_admin_page('configNMXDiskCache',
                              'BOX_CONFIGURATION_NMX_DISK_CACHE', 
                              'FILENAME_CONFIGURATION',
                              'gID=' . $configuration_group_id, 
                              'configuration', 
                              'Y',
                              $configuration_group_id);
        
      $messageStack->add('Enabled Numinix Disk Cache Configuration menu.', 'success');
    }
  }
}
