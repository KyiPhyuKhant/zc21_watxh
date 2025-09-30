<?php

/**
 * Common Template - tpl_columnar_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_columnar_display.php 3157 2006-03-10 23:24:22Z drbyte $
 */

?>
<?php
// if ($title) {
?>
<?php //echo $title; 
?>
<?php
// }
?>
<!-- <ul class="productsContainer"> -->
<!-- <div class="row">
 <?php
	// var_dump(sizeof($list_box_contents));
	// if (is_array($list_box_contents) > 0) {
	// for ($row  = 1; $row < sizeof($list_box_contents); $row++) {
	// $params = "";
	// if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
	?>
 <div class="watch-card">
  <?php
		// for ($col = 0; $col < sizeof($list_box_contents[$row]); $col++) {
		// $product_listing_counter++;
		// $r_params = "";
		// if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
		// if (isset($list_box_contents[$row][$col]['text'])) {

		?>

  <?php
		// echo $list_box_contents[$row][$col]['text'];
		?>
  <?php

		// $product_listing_two_column_style = '';
		// $product_listing_three_column_style = '';
		// $product_listing_four_column_style = '';

		// Two Rows

		// if (($product_listing_counter % 2) == 1) {
		// 	$product_listing_two_column_style = 'twoColOne ';
		// }

		// Three Rows

		// if (($product_listing_counter % 3) == 1) {
		// 	$product_listing_three_column_style = 'threeColOne ';
		// }

		// Four Rows

		// if (($product_listing_counter % 4) == 1) {
		// 	$product_listing_four_column_style = 'fourColOne ';
		// }

		// $product_listing_style =  $product_listing_two_column_style . $product_listing_three_column_style . $product_listing_four_column_style;
		?>
  <?php
		// include("../functions/function_prices.php");
		// echo '<li>';
		// $prod_id = $list_box_contents[$row][$col]['product_id'];
		// if ((zen_get_products_special_price($prod_id, false) != false) && (zen_get_products_special_price($prod_id, false) != zen_get_products_base_price($prod_id))) {
		// 	echo '<div><p>Sale</p></div>';
		// }	/* products created within last two weeks considered NEW */ elseif ($list_box_contents[$row][$col]['creation_date'] > (time() - 1209600)) {
		// 	echo '<div><p>New Product</p></div>';
		// }
		// var_dump($list_box_contents[$row][$col]['text']); // Dump the value 
		// echo '</li>' . "\n";
		//echo $list_box_contents[$row][$col]['text'];
		?>
  <?php
		// }
		// }
		?>
 </div>
 <?php
	// }
	// }
	?>

</div> -->

<?php
/* 
 * Debugging
 */
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>

<div class="row product-item-listing">
	<?php
	
	global $db;
	$category_id = isset($_GET['cPath']) ? $_GET['cPath'] : 0;
	$products_query = "SELECT p.* 
	FROM products p
	JOIN products_to_categories ptc 
	ON p.products_id = ptc.products_id
	WHERE categories_id = " . $category_id . "
	AND p.products_status = 1";

	$products = $db->Execute($products_query);
	$list_box_contents = array();

	if($products->RecordCount() > 0) {
		while (!$products->EOF) {
			$product = array(
				'products_id' => $products->fields['products_id'],
				'products_name' => $products->fields['products_name'],
				'products_price' => $products->fields['products_price'],
				'products_image' => $products->fields['products_image'],
			);
			$list_box_contents[] = $product;
			$products->MoveNext();
		}
	}

	if (is_array($list_box_contents) && sizeof($list_box_contents) > 0) {
		$items_per_page = 2; // Number of products per page
		$total_items = count($list_box_contents); // Total number of products
		$total_pages = ceil($total_items / $items_per_page);

		// Get the current page from the URL
		$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		if ($current_page < 1) $current_page = 1;
		if ($current_page > $total_pages) $current_page = $total_pages;

		// Calculate the start and end index for the current page
		$start_index = ($current_page - 1) * $items_per_page;
		$end_index = min($start_index + $items_per_page, $total_items);

		$paged_list = array_slice($list_box_contents, $start_index, $items_per_page);

		foreach ($paged_list as $column) {
	?>
			<div class="watch-card watch-card-listing">
				<?php
				// Check for sale and new product status
				$prod_id = $column['products_id'];
				$is_on_sale = (zen_get_products_special_price($prod_id, false) != false) && (zen_get_products_special_price($prod_id, false) != zen_get_products_base_price($prod_id));
				$creation_date = strtotime($column['products_date_added']);
				$is_new_product = ($creation_date > (time() - 604800)); // 604800 seconds = 7 days
				
				$query = "SELECT 
								COALESCE(r.reviews_rating, 0) AS reviews_rating, 
								p.products_price, 
								p.products_image, 
								pd.products_name
							FROM 
								products p
							LEFT JOIN 
								reviews r ON p.products_id = r.products_id
							LEFT JOIN 
								products_description pd ON p.products_id = pd.products_id
							WHERE 
								p.products_id = " . (int)$prod_id;

				$result = $db->Execute($query);

				if (!$result->EOF) {
					$reviews_rating = $result->fields['reviews_rating'];
					$products_price = $result->fields['products_price'];
					$products_price = $formatted_price = number_format((float)$products_price, 2);
					$products_name = $result->fields['products_name'];
					$products_image = $result->fields['products_image'];
					$fileParts = pathinfo($products_image);
					$newImageName = $fileParts['filename'] . '-01.' . $fileParts['extension'];
					
					$newImageFilePath = DIR_WS_IMAGES . $newImageName;

					if (file_exists($newImageFilePath)) {
						$has_additional_image = true;
					} else {
						$has_additional_image = false;
					}

					echo '<a class="watch-card--custom-image" href="' . DIR_WS_CATALOG . 'index.php?main_page=product_info&amp;products_id=' . $prod_id . '">
							<div class="watch-card--image">
								<img class="origin-image" src="' . DIR_WS_IMAGES . $products_image . '" alt="" />
								<img class="hover-image" src="' . DIR_WS_IMAGES . ($has_additional_image ? $newImageName : $products_image) . '" alt="" />
								<div class="watch-card--icons">
									<div class="watch-card--cart">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg') . '</div>
									<div class="watch-card--preview">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-preview.svg') . '</div>
									<div class="watch-card--like">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-heart.svg') . '</div>
								</div>
							</div>
						</a>';

					echo '<h3 class="watch-card--title watch-card--custom-title">'. $products_name .'</h3>';

					echo '<div class="watch-card--custom-price">
							<span class="price">$'. $products_price .'</span>
							<span class="rating">'. $reviews_rating .'<img class="stars" src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt="rating star"></span>
						</div>';

					echo '<div class="watch-card--icons-grid">
							<div class="watch-card--cart">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg') . '</div>
							<div class="watch-card--preview">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-preview.svg') . '</div>
							<div class="watch-card--like">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-heart.svg') . '</div>
						</div>';

					// Display sale and new product messages
					if ($is_on_sale) {
						echo '<div class="watch-card--sale"><p>Sale</p></div>';
					}

					if ($is_new_product) {
						echo '<div><p>New Product</p></div>';
					}
				} else {
					$reviews_rating = 0;
					$products_price = 0;
					$products_name = 'Test product';
					$products_image = '';
					$newImageName = '';
				}
				
				// foreach ($columns as $column) {
				// 	// Remove leading and trailing characters (including 'c')
				// 	$product_name = trim($column['text'], 'c');
				// 	echo $product_name;
				// }

				?>
			</div>
	<?php
		}
	}
	?>
</div>

<?php if (is_array($list_box_contents) && sizeof($list_box_contents) > 0 && $total_pages > 1) { ?>
<div class="listing-pagination">
	<a href="/watxh_zc/index.php?main_page=index&cPath=<?php echo $category_id; ?>&page=1" class="prev" data-step="-1">
		<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
			<path d="M7.34968 11C7.25788 11.0002 7.16709 10.9838 7.08337 10.9519C6.99965 10.92 6.92491 10.8734 6.86414 10.8152L1.66419 5.86506C1.55843 5.76446 1.5 5.6345 1.5 5.49985C1.5 5.3652 1.55843 5.23524 1.66419 5.13464L6.86414 0.184504C6.92082 0.130549 6.9895 0.0865685 7.06626 0.055074C7.14303 0.0235796 7.22637 0.00518774 7.31153 0.000948632C7.3967 -0.00329048 7.48202 0.00670615 7.56262 0.0303678C7.64321 0.0540294 7.71752 0.0908925 7.78128 0.138853C7.84504 0.186813 7.89702 0.24493 7.93424 0.309887C7.97145 0.374844 7.99319 0.445369 7.9982 0.517434C8.00321 0.589498 7.99139 0.661693 7.96343 0.729894C7.93547 0.798096 7.89191 0.860969 7.83523 0.914924L3.01878 5.49985L7.83523 10.0848C7.91868 10.1639 7.97326 10.2618 7.99239 10.3667C8.01152 10.4715 7.99439 10.5788 7.94305 10.6756C7.89171 10.7723 7.80836 10.8545 7.70307 10.912C7.59778 10.9696 7.47504 11.0002 7.34968 11Z" fill="black"/>
		</svg>
	</a>
	<?php
	for ($i = 1; $i <= $total_pages; $i++) {
		$active_class = ($i == $current_page) ? 'class="active"' : '';
		echo '<a ' . $active_class . ' href="/watxh_zc/index.php?main_page=index&cPath='. $category_id .'&page=' . $i . '">' . $i . '</a>';
	}
	?>
	<a href="/watxh_zc/index.php?main_page=index&cPath=<?php echo $category_id; ?>&page=<?php echo $total_pages; ?>" class="next" data-step="1">
		<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
			<path d="M3.65032 11C3.74212 11.0002 3.83291 10.9838 3.91663 10.9519C4.00035 10.92 4.07509 10.8734 4.13586 10.8152L9.33581 5.86506C9.44157 5.76446 9.5 5.6345 9.5 5.49985C9.5 5.3652 9.44157 5.23524 9.33581 5.13464L4.13586 0.184504C4.07918 0.130549 4.0105 0.0865685 3.93374 0.055074C3.85697 0.0235796 3.77363 0.00518774 3.68847 0.000948632C3.6033 -0.00329048 3.51798 0.00670615 3.43738 0.0303678C3.35679 0.0540294 3.28248 0.0908925 3.21872 0.138853C3.15496 0.186813 3.10298 0.24493 3.06576 0.309887C3.02855 0.374844 3.00681 0.445369 3.0018 0.517434C2.99679 0.589498 3.00861 0.661693 3.03657 0.729894C3.06453 0.798096 3.10809 0.860969 3.16477 0.914924L7.98122 5.49985L3.16477 10.0848C3.08132 10.1639 3.02674 10.2618 3.00761 10.3667C2.98848 10.4715 3.00561 10.5788 3.05695 10.6756C3.10829 10.7723 3.19164 10.8545 3.29693 10.912C3.40222 10.9696 3.52496 11.0002 3.65032 11Z" fill="black"/>
		</svg>
	</a>
</div>
<?php } ?>