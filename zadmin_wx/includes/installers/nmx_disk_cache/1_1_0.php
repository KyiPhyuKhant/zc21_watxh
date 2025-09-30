<?php

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            ('Reset Cache', 'NMX_DISK_CACHE_RESET', 'false', 'Manually force the cache to be reset?', " . $configuration_group_id . ", 99, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),');");
