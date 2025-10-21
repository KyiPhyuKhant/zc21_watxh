<?php
  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }
  // add upgrade script
  $facebook_like_button_version = (defined('FACEBOOK_LIKE_BUTTON_VERSION') ? FACEBOOK_LIKE_BUTTON_VERSION : 'new');
  $current_version = '1.3.4';
  $zencart_com_plugin_id = 1821; // from zencart.com plugins - Leave Zero not to check

  if($facebook_like_button_version != 'new') {
    $config = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key= 'FACEBOOK_LIKE_BUTTON_VERSION'");
    $configuration_group_id = $config->fields['configuration_group_id'];
}

  while ($facebook_like_button_version != $current_version) {
    switch($facebook_like_button_version) {
      case 'new':
      case '1.3.1':
        // perform upgrade
        if (file_exists(DIR_WS_INCLUDES . 'installers/facebook_like_button/1_3_2.php')) {
          include_once(DIR_WS_INCLUDES . 'installers/facebook_like_button/1_3_2.php');
          $facebook_like_button_version = '1.3.2';          
		  break;
        } else {
          break 2;
		}				 					                  
      case '1.3.2':
        // perform upgrade
        if (file_exists(DIR_WS_INCLUDES . 'installers/facebook_like_button/1_3_3.php')) {
          include_once(DIR_WS_INCLUDES . 'installers/facebook_like_button/1_3_3.php');
          $facebook_like_button_version = '1.3.3';          
		  break;
        } else {
          break 2;
		}
      case '1.3.3':
        // perform upgrade
        if (file_exists(DIR_WS_INCLUDES . 'installers/facebook_like_button/1_3_4.php')) {
          include_once(DIR_WS_INCLUDES . 'installers/facebook_like_button/1_3_4.php');
          $facebook_like_button_version = '1.3.4';          
      break;
        } else {
          break 2;
    }
      default:
        $facebook_like_button_version = $current_version;
        // break all the loops
        break 2;      
    }
  }
  $zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
  if ($zc150 && function_exists('zen_page_key_exists')) // continue Zen Cart 1.5.0
  {
	  // add configuration menu
	  if (!zen_page_key_exists('configFacebookLikeButton'))
	  {
		  $configuration          = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'FACEBOOK_LIKE_BUTTON_VERSION' LIMIT 1;");
		  $configuration_group_id = $configuration->fields['configuration_group_id'];
		  if ((int) $configuration_group_id > 0)
		  {
			  zen_register_admin_page('configFacebookLikeButton', 'BOX_CONFIGURATION_FACEBOOKLIKEBUTTON', 'FILENAME_CONFIGURATION', 'gID=' . $configuration_group_id, 'configuration', 'Y', $configuration_group_id);
			  
			  $messageStack->add('Enabled Facebook Like Button Configuration menu.', 'success');
		  }
	  }
  } elseif ($zc150 && !function_exists('zen_page_key_exists')) {
    $messageStack->add('Your Zen Cart has not been properly upgraded!', 'warning');
  }

  // Version Checking
if ($zencart_com_plugin_id != 0) {
    if (isset($_GET['gID']) && $_GET['gID'] == $configuration_group_id) {
      $new_version_details = plugin_version_check_for_updates($zencart_com_plugin_id, $current_version);
      if ($new_version_details != FALSE) {
          $messageStack->add("Version " . $new_version_details['latest_plugin_version'] . " of " . $new_version_details['title'] . ' is available at <a href="' . $new_version_details['link'] . '" target="_blank">[Details]</a>', 'caution');
      }
    }
}

if (!function_exists('plugin_version_check_for_updates')) {

    function plugin_version_check_for_updates($fileid = 0, $version_string_to_check = '') {
        if ($fileid == 0) {
            return FALSE;
        }
        $new_version_available = FALSE;
        $lookup_index = 0;
        $url = 'http://www.zen-cart.com/downloads.php?do=versioncheck' . '&id=' . (int) $fileid;
        $data = json_decode(file_get_contents($url), true);
        // compare versions
        if (version_compare($data[$lookup_index]['latest_plugin_version'], $version_string_to_check) > 0) {
            $new_version_available = TRUE;
        }
        // check whether present ZC version is compatible with the latest available plugin version
        if (!in_array('v' . PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR, $data[$lookup_index]['zcversions'])) {
            $new_version_available = FALSE;
        }
        if ($version_string_to_check == true) {
            return $data[$lookup_index];
        } else {
            return FALSE;
        }
    }

}