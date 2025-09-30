<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Sun Aug 5 20:48:10 2012 -0400 Modified in v1.5.1 $
 */
?>



<?php if ($messageStack->size('account') > 0) echo $messageStack->output('account'); ?>
<?php if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); ?>

<?php
// Ensure $current_customer_id is set and is an integer
$current_customer_id = (int)$_SESSION['customer_id']; // Example; adjust as needed



// Prepare the SQL query with the customer ID directly included
$sql = "SELECT ab.*, c.customers_email_address, ab.entry_company AS company,
        COALESCE(co.address_format_id, 1) as format_id
        FROM address_book ab
        JOIN customers c ON c.customers_id = ab.customers_id
        LEFT JOIN countries co ON co.countries_id = ab.entry_country_id
        WHERE ab.customers_id = $current_customer_id";

// Execute the query
$address_book_query = $db->Execute($sql);


// Initialize an array to hold the addresses
$addressArray = array();

// Fetch the result
while (!$address_book_query->EOF) {
 $addressArray[] = array(
     'firstname' => $address_book_query->fields['entry_firstname'],
     'lastname' => $address_book_query->fields['entry_lastname'],
     'address_book_id' => $address_book_query->fields['address_book_id'],
     'format_id' => isset($address_book_query->fields['format_id']) ? $address_book_query->fields['format_id'] : 1,
     'email' => $address_book_query->fields['customers_email_address'],
     'company' => $address_book_query->fields['entry_company'], // Use the column name here if needed
     'street_address' => $address_book_query->fields['entry_street_address'],
     'suburb' => $address_book_query->fields['entry_suburb'],
     'city' => $address_book_query->fields['entry_city'],
     'postcode' => $address_book_query->fields['entry_postcode'],
     'state' => $address_book_query->fields['entry_state'],
     'zone_id' => $address_book_query->fields['entry_zone_id'],
     'country_id' => $address_book_query->fields['entry_country_id']
 );
 $address_book_query->MoveNext(); // Move to the next record
}
?>

<?php 
if (!empty($addressArray)) {
	foreach ($addressArray as $address) {
					if ($address['address_book_id'] == $_SESSION['customer_default_address_id']) {
									$default_address = $address;
									break; // Exit the loop once the default address is found
					}
	}
}
   ?>

<!-- <div class="centerColumn" id="accountDefault">

 <h1 id="accountDefaultHeading">
  <?php
		// echo HEADING_TITLE; 
		?>
 </h1>

 <?php
	// require($template->get_template_dir('tpl_modules_account_menu.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_account_menu.php');
	?>


 <?php
	//if (zen_count_customer_orders() > 0) {
	?>

 <div class="order-history-wrapper">
  <table id="prevOrders" class="order-history-table">
   <tr class="tableHeading">
    <th class="order-date">
     <? //php echo TEXT_ORDER_DATE; 
					?>
    </th>
    <th class="order-number"><?php //echo TEXT_ORDER_NUMBER; 
																													?></th>
    <th class="shipping-to"><?php //echo TEXT_ORDER_SHIPPED_TO; 
																												?></th>
    <th class="total"><?php //echo TEXT_ORDER_COST; 
																						?></th>
    <th class="status"><?php //echo TEXT_ORDER_STATUS; 
																							?></th>
   </tr>
   <?php
			//foreach ($ordersArray as $orders) {
			?>
   <tr>
    <td class="order-date"><?php //echo zen_date_short($orders['date_purchased']); 
																											?></td>
    <td class="order-number"><?php //echo '<a class="view-link" href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '"> '; 
																													?><span>&#xe001;</span> <?php //echo $orders['orders_id']; 
																																																					?></a></td>
    <td class="shipping-to"><?php //echo zen_output_string_protected($orders['order_name']) 
																												?></td>
    <td class="total"><?php //echo $orders['orders_status_name']; 
																						?></td>
    <td class="status"><?php //echo $orders['order_total']; 
																							?></td>
   </tr>

   <?php //		}
			?>
  </table>
 </div>

 <?php
	//if (zen_count_customer_orders() > 2) {
	?>

 <div id="show-all-orders"><?php // echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">Show All Orders</a>'; 
																											?></div>

 <?php //		}
	?>

 <?php //	}
	?>
 <br class="clearBoth" />

 <?php //
	// only show when there is a GV balance
	//if ($customer_has_gv_balance) {
	?>
 <div id="sendSpendWrapper">
  <?php // require($template->get_template_dir('tpl_modules_send_or_spend.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_send_or_spend.php'); 
		?>
 </div>
 <?php //	}
	?>
 <br class="clearBoth" />
</div> -->


<!-- Accounts Default -->
<section class="account">
 <div class="container">
  <header class="sub-heading">
   <h3>My Account</h3>
  </header>
  <div class="row">
   <div class="account-order">
    <div class="account-heading">
     <h4>Order History</h4>
     <?php
					if (zen_count_customer_orders() <= 0) {
					?>
     <p>You haven't placed any orders</p>
     <?php } ?>
    </div>

    <!--  -->
    <?php
				if (zen_count_customer_orders() > 0) {
				?>
    <div class="account-cart">
     <!--  -->
     <div class="account-cart--card">
      <div class="account-cart--items">
       <div class="account-cart--image">
        <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/amazfit-bip.png" alt="" />
       </div>
       <div class="account-cart--text">
        <p>Amazfit Bip U</p>
        <p>Color: <strong>Blue</strong></p>
        <p>Quantity: <strong>1</strong></p>
       </div>
      </div>
      <div class="account-cart--price">
       <p>$32.00</p>
       <p>Dec 01, 2021</p>
      </div>
     </div>
     <div class="account-cart--card">
      <div class="account-cart--items">
       <div class="account-cart--image">
        <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/apple-watch-series-seven.png" alt="" />
       </div>
       <div class="account-cart--text">
        <p>Amazfit Bip U</p>
        <p>Color: <strong>Blue</strong></p>
        <p>Quantity: <strong>1</strong></p>
       </div>
      </div>
      <div class="account-cart--price">
       <p>$32.00</p>
       <p>Dec 01, 2021</p>
      </div>
     </div>
     <!--  -->
     <!--  -->
     <div class="account-cart--total">
      <div class="account-cart--amount">
       <p>Total</p>
       <p>$64.00</p>
      </div>
      <div class="account-cart--receipt">
       <p><a href="">View Receipt</a></p>
      </div>
     </div>
     <!--  -->
    </div>

    <div class="account-cart">
     <!--  -->
     <div class="account-cart--card">
      <div class="account-cart--items">
       <div class="account-cart--image">
        <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/amazfit-bip.png" alt="" />
       </div>
       <div class="account-cart--text">
        <p>Amazfit Bip U</p>
        <p>Color: <strong>Blue</strong></p>
        <p>Quantity: <strong>1</strong></p>
       </div>
      </div>
      <div class="account-cart--price">
       <p>$32.00</p>
       <p>Dec 01, 2021</p>
      </div>
     </div>
     <!--  -->
     <!--  -->
     <div class="account-cart--total">
      <div class="account-cart--amount">
       <p>Total</p>
       <p>$64.00</p>
      </div>
      <div class="account-cart--receipt">
       <p><a href="">View Receipt</a></p>
      </div>
     </div>
     <!--  -->
    </div>
    <?php } ?>
   </div>

   <!--  -->



   <div class="account-details">
    <div class="account-heading">
     <h4>Account Details</h4>
    </div>
    <div>

     <div class=" account-details--text">
      <?php 

if (!empty($default_address)) { ?>
      <!-- <p>Jeff Lew</p>
      <p>jefflew@numinix.com</p>
      <p>Numinix</p>
      <p>Vancouver, BC, Canada Vancouver, BC, Canada</p>
      <p>1009</p> -->
      <p><?php echo zen_output_string_protected($address['firstname'] . ' ' . $address['lastname']); ?></p>
      <p><?php echo zen_output_string_protected($address['email']); ?></p>
      <p><?php echo zen_output_string_protected($address['company']); ?></p>
      <p>
       <?php
  // Create an array to collect non-empty address parts
  $address_parts = array();

  // Add each part if it's not empty
  if (!empty($address['street_address'])) $address_parts[] = $address['street_address'];
  if (!empty($address['suburb'])) $address_parts[] = $address['suburb'];
  if (!empty($address['city'])) $address_parts[] = $address['city'];
  if (!empty($address['state'])) $address_parts[] = $address['state'];

  // Join the address parts with a comma and space
  echo zen_output_string_protected(implode(', ', $address_parts));
  ?>
      </p>

      </p>
      <p> <?php echo zen_output_string_protected( $address['postcode']); ?>
      </p>

      <?php } ?>
     </div>


     <?php
					if (zen_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {	?>
     <div class="account-details--buttons">
      <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL') ?>">
       <button>Add Address</button>
      </a>
      <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') ?> ">

       <button>View Addresses (<?php echo !empty($addressArray) ? count($addressArray) : 0; ?>)</button>
      </a>
     </div>
     <?php
					}
					?>
    </div>
   </div>

  </div>
 </div>
</section>