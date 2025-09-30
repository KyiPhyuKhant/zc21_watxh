<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=adress_book.<br />
 * Allows customer to manage entries in their address book
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_default.php 5369 2006-12-23 10:55:52Z drbyte $
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

<section class="address">
 <div class="container">
  <header class="sub-heading">
   <h3>Addresses</h3>
  </header>

  <?php if (!empty($addressArray)) { ?>
  <?php foreach ($addressArray as $address) { ?>
  <div class="address-details row">
   <div class="address-text <?php if (($address['address_book_id'] % 2) != 0) { ?> address-text-odd <?php } ?>">
    <h4>
     <?php if ($address['address_book_id'] == $_SESSION['customer_default_address_id']) echo 'Default'; ?>
    </h4>
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

   </div>
   <div class="address-buttons">
    <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $address['address_book_id'], 'SSL'); ?>">
     <button>Edit</button>
    </a>
    <a class="js-delete-modal-open" data-id="<?php echo $address['address_book_id']; ?>" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $address['address_book_id'], 'SSL'); ?>">
     <button>Delete</button>
    </a>

   </div>
  </div>
  <?php } ?>
  <?php }?>

 </div>
</section>

<div class="address-delete-modal-container" id="js-address-delete-modal-container">
  <div class="address-delete-modal">
    <h3 class="delete-modal-title">
      Delete address?
      <svg class="js-delete-modal-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M18 6L6 18" stroke="#131313" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M6 6L18 18" stroke="#131313" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </h3>
    <p>If you delete this address, you won’t we able to recover it. Do you want to delete it?</p>
    <div class="delete-modal-actions">
      <button class="delete-modal-cancel js-delete-modal-close">Cancel</button>
      <?php echo zen_draw_form('delete_address', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'action=deleteconfirm', 'SSL'), 'post'); ?>
      <?php echo zen_draw_hidden_field('delete', isset($_GET['delete']) ? $_GET['delete'] : ''); ?>
        <?php echo zen_image_submit(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT); ?>
      </form>
    </div>
  </div>
</div>