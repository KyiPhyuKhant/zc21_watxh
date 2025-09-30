<?php
  	$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.3.3' WHERE configuration_key = 'FACEBOOK_LIKE_BUTTON_VERSION' LIMIT 1;");
  	$messageStack->add('Upgraded Facebook Like Button to v1.3.3', 'success');
