<?php
/**
 * Module Template
 *
 * Displays address-book details/selection
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_address_book_details.php 5924 2007-02-28 08:25:15Z drbyte $
 */
?>

<!-- flags -->
<!-- <div class="nmx-row nmx-cf">
  <div class="nmx-col-6 nmx-flags" id="js-flags">
    <img class="mastercard" src="<?php echo DIR_WS_TEMPLATE ?>images/icons/mastercard.png" alt="Mastercard">
    <img class="visa" src="<?php echo DIR_WS_TEMPLATE ?>images/icons/visa.png" alt="visa">
  </div>
</div> -->
<input type="hidden" name="paymenttype" id="paymenttype" class="cc_type">
<!-- end/flags -->

<!-- card number -->
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="js-cc_number"><?php echo LABEL_CARD_NUMBER ?> <span class="nmx-required">*</span></label>
    <?php echo zen_draw_input_field('cardnumber', '', 'id="js-cc_number" data-validation="length" data-validation-length="min16" maxlength="20"'); ?>
  </div>
</div>
<!-- end/card number -->

<!-- name on card -->
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="fullname"><?php echo LABEL_NAME_ON_CARD; ?> <span class="nmx-required">*</span> <span class="label__info"><?php echo ENTRY_FULL_NAME_ON_CARD ?></span></label>
    <?php echo zen_draw_input_field('fullname', $edit_card['name_on_card'], 'data-validation="length" data-validation-length="min5"'); ?>
  </div>
</div>
<!-- end/name on card -->

<!-- expiry date -->
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="monthexpiry"><?php echo LABEL_EXPIRY ?> <span class="nmx-required">*</span></label>
    <div class="nmx-cc-expiry nmx-cf">
      <select name="monthexpiry" id="monthexpiry" data-validation="required">
          <option value="">Month</option>
          <?php for($m = 1; $m< 13; $m++) {  ?>
          <option value="<?php echo ($m < 10 ? '0' : '') . $m; ?>"><?php echo ($m < 10 ? '0' : '') . $m; ?></option>
          <?php } ?>
      </select>
      <select name="yearexpiry" id="yearexpiry" data-validation="required">
          <option value="">Year</option>
          <?php for($y = date('Y'); $y< date('Y') + 10; $y++) { ?>
          <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
          <?php } ?>
      </select>
    </div>
  </div>
</div>
<!-- end/expiry -->

<!-- cvv -->
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6 nmx-cvv">
    <label class="inputLabel"><?php echo LABEL_CVV ?> <span class="nmx-required">*</span></label>
    <?php echo zen_draw_input_field('cvv', '', 'data-validation="length" data-validation-length="min3"'); ?>
    <?php echo HELP_CVV; ?>
  </div>
</div>
<!-- end/cvv -->