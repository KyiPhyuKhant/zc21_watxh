<?php

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function) VALUES
            ('Admin Pages to Reset Cache', 'NMX_DISK_CACHE_ADMIN_PAGES', '', 'Enter the admin pages that reset the cache', " . $configuration_group_id . ", 99, NOW(), NOW(), NULL);");
