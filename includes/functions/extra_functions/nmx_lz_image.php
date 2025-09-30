<?php
/**
 * Numinix Lazy Load Images
 * ===================================
 * Doc: https://bitbucket.org/numinix/tableau2/wiki/Framework%20Functions
*/

if (!function_exists('nmx_lz_image')) {

		/*
		* The HTML image wrapper function
		*/
	  function nmx_lz_image($src, $alt = '', $width = '', $height = '', $parameters = '', $lazy_load = false) {
	    global $template_dir, $zco_notifier;

	    // soft clean the alt tag
	    $alt = zen_clean_html($alt);

	    // use old method on template images
	    if (strstr($src, 'includes/templates') or strstr($src, 'includes/languages') or PROPORTIONAL_IMAGES_STATUS == '0') {
	      return zen_image_OLD($src, $alt, $width, $height, $parameters);
	    }

	    //auto replace with defined missing image
	    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
	      $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
	    }

	    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
	      return false;
	    }

	    // if not in current template switch to template_default
	    if (!file_exists($src)) {
	      $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
	    }

	    // hook for handle_image() function such as Image Handler etc
	    if (function_exists('handle_image')) {
	      $newimg = handle_image($src, $alt, $width, $height, $parameters);
	      list($src, $alt, $width, $height, $parameters) = $newimg;
	      $zco_notifier->notify('NOTIFY_HANDLE_IMAGE', array($newimg));
	    }

	    // Convert width/height to int for proper validation.
	    // intval() used to support compatibility with plugins like image-handler
	    $width = empty($width) ? $width : intval($width);
	    $height = empty($height) ? $height : intval($height);

		// alt is added to the img tag even if it is null to prevent browsers from outputting
		// the image filename as default
		// lazy-loading container for loading icon
		if ($lazy_load) {
			$image = '<span class="nmx-lazy-wrapper"><img class="nmx-lazyload" data-src="' . zen_output_string($src) . '" src="' . DIR_WS_TEMPLATE . 'images/blank.gif" alt="' . zen_output_string($alt) . '"';
		} else {
			$image = '<span><img src="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';
		}

	    if (zen_not_null($alt)) {
	      $image .= ' title=" ' . zen_output_string($alt) . ' "';
	    }

	    if ( ((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height))) ) {
	      
	      if ($image_size = @getimagesize($src)) {
	        if (empty($width) && zen_not_null($height)) {
	          $ratio = $height / $image_size[1];
	          $width = $image_size[0] * $ratio;
	        } elseif (zen_not_null($width) && empty($height)) {
	          $ratio = $width / $image_size[0];
	          $height = $image_size[1] * $ratio;
	        } elseif (empty($width) && empty($height)) {
	          $width = $image_size[0];
	          $height = $image_size[1];
	        }
	      } elseif (IMAGE_REQUIRED == 'false') {
	        return false;
	      }

	    }


	    if (zen_not_null($width) && zen_not_null($height) and file_exists($src)) {
		  //      $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
	 	  // proportional images
	      $image_size = @getimagesize($src);
	      
	      // fix division by zero error
	      $ratio = ($image_size[0] != 0 ? $width / $image_size[0] : 1);
	      if ($image_size[1]*$ratio > $height) {
	        $ratio = $height / $image_size[1];
	        $width = $image_size[0] * $ratio;
	      } else {
	        $height = $image_size[1] * $ratio;
	      }
	      
	      // only use proportional image when image is larger than proportional size
	      if ($image_size[0] < $width and $image_size[1] < $height) {
	        $image .= ' width="' . $image_size[0] . '" height="' . intval($image_size[1]) . '" style="max-height:' . intval($image_size[1]) . 'px"';
	      } else {
	        $image .= ' width="' . round($width) . '" height="' . round($height) . '" style="max-height:' . round($height) . 'px"';
	      }

	    } else {
	      
	      // override on missing image to allow for proportional and required/not required
	      if (IMAGE_REQUIRED == 'false') {
	        return false;
	      } else if (substr($src, 0, 4) != 'http') {
	        $image .= ' width="' . intval(SMALL_IMAGE_WIDTH) . '" height="' . intval(SMALL_IMAGE_HEIGHT) . '"';
	      }

	    }

	    // inject rollover class if one is defined. NOTE: This could end up with 2 "class" elements if $parameters contains "class" already.
	    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
	      $parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
	    }

	    // add $parameters to the tag output
	    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

	    $image .= ' /><span class="nmx-lazy-loading"></span></span>';

	    return $image;
	  }
}

/*
 * look up a products image and send back the image's HTML \<IMG...\> tag
 */
  function nmx_lz_get_products_image($product_id, $width = SMALL_IMAGE_WIDTH, $height = SMALL_IMAGE_HEIGHT) {
    global $db;

    $sql = "select p.products_image from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return nmx_lz_image(DIR_WS_IMAGES . $look_up->fields['products_image'], zen_get_products_name($product_id), $width, $height, '', true);
  }
