<?php

  	$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.1.3' WHERE configuration_key = 'GOOGLE_PLUS_ONE_VERSION' LIMIT 1;");
  	$messageStack->add('Upgraded Google Plus One Button to v1.1.3', 'success');
