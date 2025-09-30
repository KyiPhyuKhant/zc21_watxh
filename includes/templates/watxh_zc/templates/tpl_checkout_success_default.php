<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_success.<br />
 * Displays confirmation details after order has been successfully processed.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_success_default.php 16435 2010-05-28 09:34:32Z drbyte $
 */
?>
<div class="centerColumn container" id="checkoutSuccess">
<!--bof -gift certificate- send or spend box-->
<?php
// only show when there is a GV balance
  if ($customer_has_gv_balance ) {
?>
<div id="sendSpendWrapper">
<?php require($template->get_template_dir('tpl_modules_send_or_spend.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_send_or_spend.php'); ?>
</div>
<?php
  }
?>
<!--eof -gift certificate- send or spend box-->

<div class="col-left back">
	<div class="checkout-success-details-section">

	
		<h1 id="checkout-success-heading"><?php echo HEADING_TITLE; ?></h1>
		
		<?php if (DEFINE_CHECKOUT_SUCCESS_STATUS >= 1 and DEFINE_CHECKOUT_SUCCESS_STATUS <= 2) { ?>
			<div id="checkout-success-content" class="content">
			<?php
			/**
			 * require the html_defined text for checkout success
			 */
			require($define_page);
			?>
			</div>
		<?php } ?>

		<?php
			global $db;

			if (isset($zv_orders_id)) {
				$order_id = (int)$zv_orders_id;
			
				// Get order info
				$order_query = $db->Execute("
					SELECT o.orders_status, ot.text as order_total,
						o.delivery_name, o.delivery_street_address, o.delivery_city,
						o.delivery_state, o.delivery_postcode, o.delivery_country
					FROM " . TABLE_ORDERS . " o
					LEFT JOIN " . TABLE_ORDERS_TOTAL . " ot 
						ON o.orders_id = ot.orders_id 
						AND ot.class = 'ot_total'
					WHERE o.orders_id = " . $order_id
				);
			
				if (!$order_query->EOF) {
					$orders_status_id = $order_query->fields['orders_status'];
					$order_total = $order_query->fields['order_total'];
			
					// Format delivery address
					$delivery_address = $order_query->fields['delivery_street_address'] . ', ' .
										$order_query->fields['delivery_city'] . ', ' .
										$order_query->fields['delivery_state'] . ' ' .
										$order_query->fields['delivery_postcode'] . ', ' .
										$order_query->fields['delivery_country'];
			
					// Get status name
					$status_query = $db->Execute("
						SELECT orders_status_name 
						FROM " . TABLE_ORDERS_STATUS . "
						WHERE orders_status_id = '" . (int)$orders_status_id . "'
						AND language_id = '" . (int)$_SESSION['languages_id'] . "'
					");
					$orders_status_name = $status_query->fields['orders_status_name'];
				}
			}
		?>

		<ul class="checkout-success-details">
			<li id="order-total-headline">
				<?php echo '<span class="order-total-label">' . TEXT_YOUR_ORDER_TOTAL . '</span><span class="order-total">' . $order_total . '</span>'; ?>
			</li>
			<li id="order-number-headline">
				<?php echo '<span class="order-number-label">' . TEXT_YOUR_ORDER_REFERENCE . '</span><span class="order-number">' . $zv_orders_id . '</span>'; ?>
			</li>
			<li id="order-delivery-headline">
				<?php echo '<span class="order-delivery-label">' . TEXT_YOUR_ORDER_DELIVERY . '</span><span class="order-delivery">' . $delivery_address . '</span>'; ?>
			</li>
			<li id="order-status-headline">
				<?php echo '<span class="order-status-label">' . TEXT_YOUR_ORDER_STATUS . '</span><span class="order-status">' . $orders_status_name . '</span>'; ?>
			</li>
		</ul>
	</div>
		
	<div class="checkout-success-products">
		<?php
			if (isset($zv_orders_id)) {
				$order_id = (int)$zv_orders_id;
				$products_query = $db->Execute("
					SELECT op.orders_products_id, op.products_id, op.products_name, op.products_quantity, op.final_price
					FROM " . TABLE_ORDERS_PRODUCTS . " op
					WHERE op.orders_id = " . $order_id
				);
				$total_items = 0;

				// First loop to get total item count
				while (!$products_query->EOF) {
					$total_items += $products_query->fields['products_quantity'];
					$products_query->MoveNext();
				}

				// Reset query pointer for re-looping
				$products_query = $db->Execute("
					SELECT op.orders_products_id, op.products_id, op.products_name, op.products_quantity, op.final_price
					FROM " . TABLE_ORDERS_PRODUCTS . " op
					WHERE op.orders_id = " . $order_id
				);

				// Check if products were found
				if ($products_query->RecordCount() > 0) {

					echo '<h3>'. $total_items .' items</h3>';
					echo '<table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse;">';
						
					while (!$products_query->EOF) {
						$product_id = $products_query->fields['products_id'];
						$product_name = $products_query->fields['products_name'];
						$quantity = $products_query->fields['products_quantity'];
						$price = $products_query->fields['final_price'];
						$orders_products_id = $products_query->fields['orders_products_id'];
			
						// Get the product image
						$image_query = $db->Execute("
							SELECT products_image 
							FROM " . TABLE_PRODUCTS . " 
							WHERE products_id = " . (int)$product_id
						);
			
						// Check if image exists
						$product_image = DIR_WS_IMAGES . $image_query->fields['products_image'];
			
						// Display the product details in the table
						echo '<tr>
								<td><img src="' . $product_image . '" alt="product image"></td>
								<td>' . $product_name . '</td>
								<td>' . number_format($price, 2) . '</td>
							</tr>';
			
						$products_query->MoveNext();
					}
			
					echo '</table>';
				} else {
					echo 'No products found for this order.';
				}

				echo '<div class="checkout-success-footer-links">';
				echo '<form method="post" action="cancel_order.php">
						<input type="hidden" name="order_id" value="<?php echo (int)$order_id; ?>" />
						<input type="submit" value="Cancel Order" />
					</form>';
				echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">My Account</a>';
				echo '<a href="' . zen_href_link(FILENAME_SHIPPING, '', 'SSL') . '">Shipping & Returns</a>';
				echo '</div>';
			}
		?>
	</div>

	<!-- <a href="<?php //echo HTTP_SERVER . DIR_WS_CATALOG; ?>" class="continue-shopping-btn"><?php //echo BUTTON_CONTINUE_SHOPPING_ALT ?></a> -->
	<!-- <a href="<?php //echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>" class="log-off-btn"><?php //echo BUTTON_LOG_OFF_ALT ?></a> -->
</div><!--EOF .col-left-->
<!-- <div class="col-right back">
	<div class="product-notifications-wrapper">
		<?php
		/**
		 * The following creates a list of checkboxes for the customer to select if they wish to be included in product-notification
		 * announcements related to products they've just purchased.
		 **/
		    //if ($flag_show_products_notification == true) {
		?>
		<h3><?php //echo TEXT_NOTIFY_PRODUCTS; ?></h3>
		<div class="notifications-form-wrapper">
			<?php //echo zen_draw_form('order', zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?>
			
			<?php //foreach ($notificationsArray as $notifications) { ?>
			<?php //echo zen_draw_checkbox_field('notify[]', $notifications['products_id'], true, 'id="notify-' . $notifications['counter'] . '"') ;?>
			<label class="checkboxLabel" for="<?php //echo 'notify-' . $notifications['counter']; ?>"><?php //echo $notifications['products_name']; ?></label>
			<br />
			<?php //} ?>
			<div class="buttonRow"><?php ///echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
			</form>
		</div>
		<?php
		    //}
		?>
	</div>
</div> -->


<!--bof -product downloads module-->
<!--
<?php
  if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_downloads.php');
?>
-->
<!--eof -product downloads module-->
</div>

<?php $zco_notifier->notify('NOTIFY_TEMPLATE_END_CHECKOUT_SUCCESS'); ?>
