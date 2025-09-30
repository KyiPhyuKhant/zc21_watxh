<?php
    $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.2.4' WHERE configuration_key = 'PIN_IT_BUTTON_VERSION' LIMIT 1;");
  	$messageStack->add('Upgraded Pin It Button to v1.2.4', 'success');