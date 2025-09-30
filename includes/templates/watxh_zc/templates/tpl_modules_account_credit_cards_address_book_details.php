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


<?php
  if (ACCOUNT_GENDER == 'true') {
    if (isset($gender)) {
      $male = ($gender == 'm') ? true : false;
    } else {
      $male = ($entry->fields['entry_gender'] == 'm') ? true : false;
    }
    $female = !$male;
?>
<div class="gender-wrapper">
  <label class="inputLabel"><?php echo GENDER_TITLE; ?> <?php echo (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="nmx-required">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></label>
  <?php echo zen_draw_radio_field('gender', 'm', $male, 'id="gender-male"') . '<label class="radioButtonLabel" for="gender-male">' . MALE . '</label>' . zen_draw_radio_field('gender', 'f', $female, 'id="gender-female"') . '<label class="radioButtonLabel" for="gender-female">' . FEMALE . '</label>'; ?>
</div>
<?php
  }
?>
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="firstname"><?php echo ENTRY_FIRST_NAME; ?> <?php echo (zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="nmx-required"> ' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname" data-validation="length" data-validation-length="min2"'); ?>
    <?php if ($messageStack->size('firstname') > 0) echo $messageStack->output('firstname'); ?>
  </div>
  <div class="nmx-col-6">
    <label class="inputLabel" for="lastname"><?php echo ENTRY_LAST_NAME; ?> <?php echo (zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="nmx-required"> ' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname" data-validation="length" data-validation-length="min2"'); ?>
    <?php if ($messageStack->size('lastname') > 0) echo $messageStack->output('lastname'); ?>
  </div>
</div>

<?php
  if (ACCOUNT_COMPANY == 'true') {
?>
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="company"><?php echo ENTRY_COMPANY; ?> <?php echo (zen_not_null(ENTRY_COMPANY_TEXT) ? '<span class="nmx-required"> ' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company"'); ?>
  </div>
</div>
<?php
  }
?>

<div class="nmx-row nmx-cf">
  <div class="nmx-col-12">
    <label class="inputLabel" for="street-address"><?php echo ENTRY_STREET_ADDRESS; ?> <?php echo (zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="nmx-required"> ' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address" data-validation="required"'); ?>
    <?php if ($messageStack->size('streetaddress') > 0) echo $messageStack->output('streetaddress'); ?>
  </div>
</div>

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
<div class="nmx-row nmx-cf">
  <div class="nmx-col-12">
    <label class="inputLabel" for="suburb"><?php echo ENTRY_SUBURB; ?> <?php echo (zen_not_null(ENTRY_SUBURB_TEXT) ? '<span class="nmx-required">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb"'); ?>
  </div>
</div>
<?php
  }
?>
<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="country"><?php echo ENTRY_COUNTRY; ?> <?php echo (zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="nmx-required">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></label>
    <?php echo zen_get_country_list('zone_country_id', '', 'id="country"  data-validation="required" ' . ($flag_show_pulldown_states == true ? 'onchange="update_zone(this.form);"' : '')); ?>
    <?php if ($messageStack->size('country') > 0) echo $messageStack->output('country'); ?>
  </div>
  <div class="nmx-col-6">
    <?php
      if (ACCOUNT_STATE == 'true') {
        if ($flag_show_pulldown_states == true) {
    ?>
    <label class="inputLabel" for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?> <?php echo (zen_not_null(ENTRY_STATE_TEXT) ? '<span class="nmx-required"> ' . ENTRY_STATE_TEXT . '</span>': ''); ?></label>
    <?php
          echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down(''), $zone_id, 'id="stateZone" data-validation="required"');
        }
    ?>

    <?php if ($flag_show_pulldown_states == true) { ?>
    <br class="clearBoth" id="stBreak" />
    <?php } ?>
    <label class="inputLabel" for="state" id="stateLabel"><?php echo $state_field_label; ?> <?php echo (zen_not_null(ENTRY_STATE_TEXT) ? '<span class="nmx-required" id="stText"></span>': ''); ?></label>
    <?php
        echo zen_draw_input_field('state', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"');
        if ($flag_show_pulldown_states == false) {
          echo zen_draw_hidden_field('zone_id', '', '');
        }
    ?>
    <?php
      }
    ?>
    <?php if ($messageStack->size('state') > 0) echo $messageStack->output('state'); ?>
  </div>
</div>

<div class="nmx-row nmx-cf">
  <div class="nmx-col-6">
    <label class="inputLabel" for="city"><?php echo ENTRY_CITY; ?> <?php echo (zen_not_null(ENTRY_CITY_TEXT) ? '<span class="nmx-required"> ' . ENTRY_CITY_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" data-validation="required"'); ?>
    <?php if ($messageStack->size('city') > 0) echo $messageStack->output('city'); ?>
  </div>
  <div class="nmx-col-6">
    <label class="inputLabel" for="postcode"><?php echo ENTRY_POST_CODE; ?> <?php echo (zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="nmx-required"> ' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></label>
    <?php echo zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" data-validation="required"'); ?>
    <?php if ($messageStack->size('postcode') > 0) echo $messageStack->output('postcode'); ?>
  </div>
</div>

<?php
  if ((isset($_GET['edit']) && ($_SESSION['customer_default_address_id'] != $_GET['edit'])) || (isset($_GET['edit']) == false) ) {
?>
<div class="nmx-row nmx-cf">
  <div class="nmx-col-12">
    <div class="nmx-checkbox">
      <?php echo zen_draw_checkbox_field('primary', 'on', false, 'id="primary"') . ' <label class="checkboxLabel" for="primary">' . SET_AS_PRIMARY . '</label>'; ?>
    </div>
  </div>
</div>
<?php
  }
?>