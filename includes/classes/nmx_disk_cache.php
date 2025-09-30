<?php

/*
  Copyright (c) 2012 Numinix Web Development LLC
  Portions Copyright Zen Cart
  Portions Copyright osCommerce
  author: numinix
 */

/* usage:

  <?php
  require_once(DIR_WS_CLASSES . 'nmx_disk_cache.php');
  $nmx_disk_cache = new nmx_disk_cache();
  // 1: create a cache file with a custom id of tpl_modules_product_listing
  // 2: include a custom string to add to the end of the filename (in this case we want to use a different cache file for each sorting option. Note: all URL get parameters are automatically included)
  // 3: do not execute if there is a message being output in the html block
  // 4: automatically include all URL params (note: this should be set to false if caching a global block of code and the second parameter, $parameters, should be used)
  // 5: override the cache default time with 3600 seconds
  // 6: override the default gzip compression level with 9.
  //
  if ($nmx_disk_cache->cacheStart('tpl_modules_product_listing_', array('sort_by' => $_SESSION['sort_by']), !($messageStack->size('product_listing') > 0), true, 3600, 9)) {
  ?>
  HTML to cache
  <?php
  $nmx_disk_cache->cacheEnd();
  }
  ?>
 */

class nmx_disk_cache {

    var $enabled;
    var $filename;
    var $gzcompression;

    function __construct() {
        $this->enabled = (NMX_DISK_CACHE_STATUS == 'true' ? true : false);
    }

    function cacheStart($id = '', $parameters = array(), $enable = true, $use_all_url_params = false, $cache_time = NMX_DISK_CACHE_DEFAULT_TIME, $gzlevel = NMX_DISK_CACHE_DEFAULT_GZIP, $override_logged_in = false) {
      	global $session_started;
        if ($this->enabled && $session_started) {
            $reset_cache = false; // default
            if (SQL_CACHE_METHOD != '') { // SQL caching is enabled
                global $db;
                // we query the database here instead of using the constant because it has been cached
                $nmx_disk_cache_reset = $db->Execute("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'NMX_DISK_CACHE_RESET' LIMIT 1;");
                if ($nmx_disk_cache_reset->RecordCount() > 0 && $nmx_disk_cache_reset->fields['configuration_value'] == 'true') {
                    $reset_cache = true;
                }
            } elseif (NMX_DISK_CACHE_RESET == 'true') {
                $reset_cache = true;
            }
            if ($reset_cache == true) {
                $this->clearResetCache();
                $this->clearCache('*');
            }
            if ($enable && $cache_time > 0 && (NMX_DISK_CACHE_LOGGED_IN == 'true' || !isset($_SESSION['customer_id']) || $override_logged_in == true)) {
                $this->filename = array();
                // if the id is blank, force using URL parameters for unique file identifier
                if ($id == '')
                    $use_all_url_params = true;
                if ($use_all_url_params == true) {
                    // use a different cache file for HTTP vs HTTPS in case of differences in the code to be cached
                    // skip zenid 
                    $this->filename['url'] = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('zenid')), ($_SERVER['HTTPS'] == 'on' ? 'SSL' : 'NONSSL'), false);
                }
                if ($id == '') {
                    // set the id to the page URL
                    $id = $this->filename['url'];
                    // unset the url element to avoid duplication
                    unset($this->filename['url']);
                }
                if (!is_array($parameters))
                    $parameters = array();
                // add language code to parameters
                if (isset($_SESSION['language']) && !in_array($_SESSION['language'], $parameters, true))
                    $parameters[] = $_SESSION['language'];
                // add curreny code to parameters
                if (isset($_SESSION['currency']) && !in_array($_SESSION['currency'], $parameters, true))
                    $parameters[] = $_SESSION['currency'];
                // add customer wholesale to parameters
                if (isset($_SESSION['customer_whole']) && !in_array($_SESSION['customer_whole'], $parameters, true))
                    $parameters[] = $_SESSION['customer_whole'];


                if (sizeof($parameters) > 0) {
                    // combine the additional filename parameters to the end of the filename
                    $this->filename = array_merge($this->filename, $parameters);
                }
                if ($gzlevel > 0) {
                    // if the file is gzipped, put gz_ at the front
                    $id = implode('_', array('gz', $id));
                    if ($gzlevel > 9)
                        $gzlevel = 9;
                    $this->gzcompression = $gzlevel;
                }
                // build filename as gz_id_md5string.cache
                $this->filename = DIR_FS_SQL_CACHE . '/nmx_disk_cache/' . implode(array($id, md5(implode('_', $this->filename)))) . '.cache';
                $cached_content = '';
                if ((file_exists($this->filename)) && (file_exists($this->filename) && ((time() - (int) $cache_time) < filemtime($this->filename)))) {
                    $cached_content = $this->getCache($this->filename);
                    if ($this->gzcompression) {
                        $cached_content = gzinflate($cached_content);
                    }
                    if (strlen($cached_content) > 100) {
                        $cached_content = str_replace('$NDC_SECURITY_TOKEN', $_SESSION['securityToken'], $cached_content);
                        echo $cached_content;
                        return false;
                    } else {
                        ob_start(); // Start the output buffer
                        return true;
                    }
                } else {
                    ob_start(); // Start the output buffer
                    return true;
                }
            } else {
                $this->enabled = false;
                return true;
            }
        } else {
            $this->enabled = false;
            return true;
        }
    }

    function cacheEnd() {
        if ($this->enabled && isset($this->filename)) {
            $contents_for_cache = ob_get_contents();
            if(strlen(trim($contents_for_cache)) > 0 ){ //check if the cache content is not blank
	            $contents_for_cache = str_replace($_SESSION['securityToken'], '$NDC_SECURITY_TOKEN', $contents_for_cache);
	            $contents_for_cache = preg_replace('/&?zenid=[^&]*/', '', $contents_for_cache);
	            if ($this->gzcompression) {
	                $contents_for_cache = gzdeflate($contents_for_cache, $this->gzcompression);
	            }
	            $this->setCache($this->filename, $contents_for_cache);
            }
            ob_end_flush(); // Send the output to the browser
        }
    }

    function setCache($filename, $filecontents) {
        $output = serialize($filecontents);
         if ($output != '' && strlen($filecontents) > 100 && strpos($filecontents, 'zenid') === false) {
            $fp = fopen($filename, "wb"); // open file with Write permission
            fputs($fp, $output);
            fclose($fp);
        }
    }

    function getCache($filename) {
        return unserialize(file_get_contents($filename));
    }

    function clearCache($cache_files = '') {
        if (NMX_DISK_CACHE_DEFAULT_GZIP == 0 || $cache_files == '*') {
            array_map('unlink', glob(DIR_FS_SQL_CACHE . '/nmx_disk_cache/' . $cache_files . '*.cache'));
        } else {
            array_map('unlink', glob(DIR_FS_SQL_CACHE . '/nmx_disk_cache/gz_' . $cache_files . '*.cache'));
        }
    }

    function clearResetCache() {
        global $db;
        $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = 'false' WHERE configuration_key = 'NMX_DISK_CACHE_RESET' LIMIT 1;");
    }

    function adminCacheClear($page) {
        if (NMX_DISK_CACHE_ADMIN_PAGES != '') {
            $config_array = explode(",", NMX_DISK_CACHE_ADMIN_PAGES);
            foreach ($config_array as $config_value) {
                $pages_array = explode(":", $config_value);
                if ($page == $pages_array[0]) {
                    $this->clearCache($pages_array[1]);
                }
            }
        }
    }
    
    function clearExpiredFiles($hoursExpired = 24) {
    	if(!is_numeric($hoursExpired)) return;
    	$files = glob(DIR_FS_SQL_CACHE . '/nmx_disk_cache/*.cache');
    	foreach ($files as $file) {
    		if (date('U') - filemtime($file) >= 60 * 60 * $hoursExpired) { // 1 hour * $hoursExpired
    			$this->clearCache(str_replace('.cache', '', basename($file)));
    		}
    	}
    }

}
