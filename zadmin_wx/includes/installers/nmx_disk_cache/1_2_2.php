<?php
$configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'Numinix Disk Cache Configuration' ORDER BY configuration_group_id ASC;");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            ('Status', 'NMX_DISK_CACHE_LOGGED_IN', 'false', 'Enable caching for logged in users?', " . $configuration_group_id . ", 5, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),');");
            