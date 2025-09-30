<?php
    $configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'PIN_IT_BUTTON_VERSION' LIMIT 1;");
    if ($configuration->RecordCount() > 0) {
        $configuration_group_id = $configuration->fields['configuration_group_id'];
        
        $checkPBSP =  $db->Execute("SELECT configuration_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'PINTEREST_BUTTON_SHAPE'")->RecordCount(); 
        $checkPBS =  $db->Execute("SELECT configuration_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'PINTEREST_BUTTON_SIZE'")->RecordCount(); 
        $checkPBC =  $db->Execute("SELECT configuration_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'PINTEREST_BUTTON_COLOR'")->RecordCount();
        
        if ($checkPBSP < 1) {
            $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            (NULL, 'Pinterest Button Shape', 'PINTEREST_BUTTON_SHAPE', 'Rectangular', 'Use the Rectangular or Circular icon?', " . $configuration_group_id . ", 10, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\'Rectangular\', \'Circular\'),')");
        }

        if ($checkPBS < 1) {
            $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            (NULL, 'Pinterest Button Size', 'PINTEREST_BUTTON_SIZE', 'Large', 'Use the Large or Small icon?', " . $configuration_group_id . ", 10, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\'Large\', \'Small\'),')");
        }

        if ($checkPBC < 1) {
            $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            (NULL, 'Pinterest Button Color', 'PINTEREST_BUTTON_COLOR', 'red', 'Use the red, gray, or white icon?', " . $configuration_group_id . ", 10, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\'red\', \'gray\', \'white\'),')");
        }

        $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET set_function = 'zen_cfg_select_option(array(\'none\', \'above\', \'beside\'),' WHERE configuration_key = 'PINTEREST_BUTTON_COUNT' LIMIT 1;");
        switch (PINTEREST_BUTTON_COUNT) {
            case 'horizontal':
                $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = 'beside' WHERE configuration_key = 'PINTEREST_BUTTON_COUNT' LIMIT 1;");
                break;
            case 'vertical':
                $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = 'above' WHERE configuration_key = 'PINTEREST_BUTTON_COUNT' LIMIT 1;");
                break;
        }    
        $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.3.0' WHERE configuration_key = 'PIN_IT_BUTTON_VERSION' LIMIT 1;");
        $messageStack->add('Upgraded Pin It Button to v1.3.0', 'success');

    }