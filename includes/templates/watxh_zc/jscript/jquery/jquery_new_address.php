<?php
/**
 * jquery_new_address
 *
 * @package page
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jquery_new_address.php 17016 2010-07-27 06:54:42Z numinix $
 */
?>
<script language="javascript" type="text/javascript"><!--
function check_new_address(form_name) {
  jQuery('.validation').remove();
  jQuery('.missing').removeClass('missing');
  if (jQuery('form[name="' + form_name + '"] input[name="firstname"]').val().length > 0) {
    var firstname = jQuery('form[name="' + form_name + '"] input[name="firstname"]').val();
    var lastname = jQuery('form[name="' + form_name + '"] input[name="lasttname"]').val();
    var street_address = jQuery('form[name="' + form_name + '"] input[name="street_address"]').val();

    if (firstname == '' && lastname == '' && street_address == '') {
      return true;
    } else {
      return check_new_address_form(form_name);
    }
  } else {
    return true;
  }
}

function check_new_address_form(form_name) {
  error = false;
  form = form_name;
  error_message = "<?php echo JS_ERROR; ?>";

<?php if (ACCOUNT_GENDER == 'true') echo '  check_radio("gender", "' . QC_ENTRY_GENDER_ERROR . '");' . "\n"; ?>

<?php if ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0) { ?>
  check_input("firstname", <?php echo (int)ENTRY_FIRST_NAME_MIN_LENGTH; ?>, "<?php echo QC_ENTRY_FIRST_NAME_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0) { ?>
  check_input("lastname", <?php echo (int)ENTRY_LAST_NAME_MIN_LENGTH; ?>, "<?php echo QC_ENTRY_LAST_NAME_ERROR; ?>");
<?php } ?>

<?php if (ACCOUNT_COMPANY == 'true' && (int)ENTRY_COMPANY_MIN_LENGTH != 0) echo '  check_input("company", ' . (int)ENTRY_COMPANY_MIN_LENGTH . ', "' . QC_ENTRY_COMPANY_ERROR . '");' . "\n"; ?>

<?php if ((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0) { ?>
  check_input("street_address", <?php echo (int)ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>, "<?php echo QC_ENTRY_STREET_ADDRESS_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_POSTCODE_MIN_LENGTH > 0) { ?>
  check_input("postcode", <?php echo (int)ENTRY_POSTCODE_MIN_LENGTH; ?>, "<?php echo QC_ENTRY_POST_CODE_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_CITY_MIN_LENGTH > 0) { ?>
  check_input("city", <?php echo (int)ENTRY_CITY_MIN_LENGTH; ?>, "<?php echo QC_ENTRY_CITY_ERROR; ?>");
<?php } ?>
<?php if (ACCOUNT_STATE == 'true') { ?>
  if (jQuery('[name="state"]').hasClass("visibleField") && jQuery('[name="zone_id"]').val() == "") {
    check_input("state", <?php echo ENTRY_STATE_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_STATE_ERROR); ?>");
  } else if (jQuery('[name=state]').attr("disabled") == "disabled") {
    check_select("zone_id", "", "<?php echo addslashes(QC_ENTRY_STATE_ERROR_SELECT); ?>");
  }
<?php } ?>

  check_select("country", "", "<?php echo QC_ENTRY_COUNTRY_ERROR; ?>");

<?php if ((ACCOUNT_TELEPHONE == 'true' || ACCOUNT_TELEPHONE_SHIPPING == 'true') && (int)ENTRY_TELEPHONE_MIN_LENGTH > 0) { ?>
  check_input("telephone", <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>, "<?php echo QC_ENTRY_TELEPHONE_NUMBER_ERROR; ?>");
<?php } ?>

  if (error == true) {
    return false;
  } else {
    return true;
  }
}
//--></script>

