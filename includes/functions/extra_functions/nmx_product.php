<?php
/**
 * Numinix Product
 * ===================================
 * Doc: https://bitbucket.org/numinix/tableau2/wiki/Framework%20Functions
*/

if (!function_exists('nmx_product')) {

	function nmx_product($product_id, $product_name, $product_image, $product_price = true, $product_review = true) {

    // prod
		$product = '';

    // product image
    if ($product_image != '') {
      $product .= '
        <div class="nmx-product-image">
          <div class="nmx-product-badge">
            ' . nmx_badges($product_id) . '
          </div>
          <a href="' . zen_href_link(zen_get_info_page($product_id), 'products_id=' . $product_id) . '">
            ' . nmx_lz_image(DIR_WS_IMAGES . $product_image, $product_name, IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT, '', true) . '
            <noscript>
            ' . zen_image(DIR_WS_IMAGES . $product_image, $product_name, IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT) . '
            </noscript>
          </a>
        </div>
      ';
    }

    // product title
    if ($product_name != '') {
      $product .= '
        <span class="nmx-product-title">
          <a href="' . zen_href_link(zen_get_info_page($product_id), 'products_id=' . $product_id) . '">' . $product_name . '</a>
        </span>
      ';
    }
    
    // reviews
    if ($product_review) {
      $product .= nmx_stars($product_id);
    }

    // price
    if ($product_price) {
      $product .= '
        <span class="nmx-product-price">' . zen_get_products_display_price($product_id) . '</span>
      ';
    }

		return $product;

	}
}
