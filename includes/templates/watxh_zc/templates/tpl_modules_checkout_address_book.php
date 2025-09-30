<?php
/**
 * tpl_modules_checkout_address_book.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_checkout_address_book.php 3 2012-07-08 21:11:34Z numinix $
 */
?>
<?php
/**
 * require code to get address book details
 */
  require(DIR_WS_MODULES . zen_get_module_directory('checkout_address_book.php'));
?>

<?php
if (is_object($addresses) && !$addresses->EOF) {
  while (!$addresses->EOF) {
    if (isset($addresses->fields['address_book_id'])) {
      $defaultSelected = ($current_page_base === FILENAME_CHECKOUT_PAYMENT_ADDRESS) ? 
                          $_SESSION['billto'] : 
                          $_SESSION['sendto'];
      
      if ($addresses->fields['address_book_id'] == $defaultSelected) {
        echo '      <div id="defaultSelected" class="moduleRowSelected">' . "\n";
      } else {
        echo '      <div class="moduleRow">' . "\n";
      }
?>
      <div class="back addressRadio"><?php echo zen_draw_radio_field('address', $addresses->fields['address_book_id'], ($addresses->fields['address_book_id'] == $defaultSelected), 'id="name-' . $addresses->fields['address_book_id'] . '"'); ?></div>
      <label for="name-<?php echo $addresses->fields['address_book_id']; ?>" class="checkboxLabel">
          <?php echo zen_output_string_protected($addresses->fields['firstname'] . ' ' . $addresses->fields['lastname']); ?></label>
      <address><?php 
        if (isset($addresses->fields) && is_array($addresses->fields)) {
          echo zen_address_format($addresses->fields['format_id'], $addresses->fields, true, ' ', '<br />'); 
        } else {
          echo 'Address data not available';
        }
      ?></address>
      </div>
<?php
    }
    $addresses->MoveNext();
  }
} else {
  //echo '<p>No addresses were found in your address book. Please add a new address.</p>';
}
?>
