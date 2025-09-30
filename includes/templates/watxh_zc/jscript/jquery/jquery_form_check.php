<script type="text/javascript"><!--
function check_form_registration(form_name) {
  jQuery('.registrationError').remove();
  if (submitted == true) {
    //alert("<?php echo JS_ERROR_SUBMITTED; ?>");
    //return false;
  }

  error = false;
  form = form_name;

<?php if (ACCOUNT_GENDER == 'true') echo '  check_radio("gender", "' . addslashes(QC_ENTRY_GENDER_ERROR) . '");' . "\n"; ?>

<?php if ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0) { ?>
  check_input("firstname", <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_FIRST_NAME_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0) { ?>
  check_input("lastname", <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_LAST_NAME_ERROR); ?>");
<?php } ?>

<?php if (ACCOUNT_COMPANY == 'true' && (int)ENTRY_COMPANY_MIN_LENGTH != 0) echo '  check_input("company", ' . ENTRY_COMPANY_MIN_LENGTH . ', "' . addslashes(QC_ENTRY_COMPANY_ERROR) . '");' . "\n"; ?>

<?php if (FEC_CONFIRM_EMAIL == 'true') { ?>
  check_email("email_address_register", "email_address_confirm", <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_EMAIL_ADDRESS_ERROR); ?>", "<?php echo addslashes(QC_ENTRY_EMAIL_ADDRESS_CONFIRM_ERROR); ?>");
<?php } else { ?>
  check_input("email_address_register", <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_EMAIL_ADDRESS_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0) { ?>
  check_input("street_address", <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_STREET_ADDRESS_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_POSTCODE_MIN_LENGTH > 0) { ?>
  check_input("postcode", <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_POST_CODE_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_CITY_MIN_LENGTH > 0) { ?>
  check_input("city", <?php echo ENTRY_CITY_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_CITY_ERROR); ?>");
<?php } ?>

<?php if (ACCOUNT_STATE == 'true') echo '  if (!jQuery(\'[name="state"]\').attr("disabled") == "disabled" && jQuery(\'[name="zone_id"]\').val() == "") check_input("state", ' . ENTRY_STATE_MIN_LENGTH . ', "' . addslashes(QC_ENTRY_STATE_ERROR) . '")' . "\n" . '  else if (jQuery(\'[name=state]\').attr("disabled") == "disabled") check_select("zone_id", "", "' . addslashes(QC_ENTRY_STATE_ERROR_SELECT) . '");' . "\n"; ?>

  check_select("zone_country_id", "", "<?php echo addslashes(QC_ENTRY_COUNTRY_ERROR); ?>");

<?php if (ACCOUNT_TELEPHONE == 'true' && (int)ENTRY_TELEPHONE_MIN_LENGTH > 0) { ?>
  check_input("telephone", <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_TELEPHONE_NUMBER_ERROR); ?>");
<?php } ?>

<?php if (FEC_SHIPPING_ADDRESS == 'true') { ?>
if (!jQuery('#shippingAddress-checkbox').is(':checked')) {
<?php if (ACCOUNT_GENDER == 'true') echo '  check_radio("gender_shipping", "' . addslashes(QC_ENTRY_GENDER_ERROR) . '");' . "\n"; ?>

<?php if ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0) { ?>
  check_input("firstname_shipping", <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_FIRST_NAME_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0) { ?>
  check_input("lastname_shipping", <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_LAST_NAME_ERROR); ?>");
<?php } ?>

<?php if (ACCOUNT_COMPANY == 'true' && (int)ENTRY_COMPANY_MIN_LENGTH != 0) echo '  check_input("company_shipping", ' . ENTRY_COMPANY_MIN_LENGTH . ', "' . addslashes(QC_ENTRY_COMPANY_ERROR) . '");' . "\n"; ?>

<?php if ((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0) { ?>
  check_input("street_address_shipping", <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_STREET_ADDRESS_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_POSTCODE_MIN_LENGTH > 0) { ?>
  check_input("postcode_shipping", <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_POST_CODE_ERROR); ?>");
<?php } ?>
<?php if ((int)ENTRY_CITY_MIN_LENGTH > 0) { ?>
  check_input("city_shipping", <?php echo ENTRY_CITY_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_CITY_ERROR); ?>");
<?php } ?>

<?php if (ACCOUNT_STATE == 'true') echo '  if (!jQuery(\'[name="state_shipping"]\').attr("disabled") == "disabled" && jQuery(\'[name="zone_id_shipping"]\').val() == "") check_input("state_shipping", ' . ENTRY_STATE_MIN_LENGTH . ', "' . addslashes(QC_ENTRY_STATE_ERROR) . '")' . "\n" . '  else if (jQuery(\'[name="state_shipping"]\').attr("disabled") == "disabled") check_select("zone_id_shipping", "", "' . addslashes(QC_ENTRY_STATE_ERROR_SELECT) . '");' . "\n"; ?>

  check_select("zone_country_id_shipping", "", "<?php echo addslashes(QC_ENTRY_COUNTRY_ERROR); ?>");

<?php if (ACCOUNT_TELEPHONE_SHIPPING == 'true' && (int)ENTRY_TELEPHONE_MIN_LENGTH > 0) { ?>
  check_input("telephone_shipping", <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>, "<?php echo addslashes(QC_ENTRY_TELEPHONE_NUMBER_ERROR); ?>");
<?php } ?>
}
<?php } ?>
<?php if ((int)ENTRY_PASSWORD_MIN_LENGTH > 0) { ?>
  if (jQuery('input[name="cowoa"]').val() == 'false') {
    check_password("password-register", "password-confirmation", <?php echo (int)ENTRY_PASSWORD_MIN_LENGTH; ?>, "<?php echo ENTRY_PASSWORD_ERROR; ?>", "<?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING; ?>");
  }
<?php } ?>
  
  if (error == true) {
    jQuery('#hideregistrationBack').after('<div class="disablejAlert registrationError">' + fecLoginValidationErrorMessage + '</div>');
    jQuery('html, body').animate({
      scrollTop: jQuery(".validation:first").siblings('label:first').offset().top
    }, 0);
    return false;
  } else {
    submitted = true;
    return true;
  }
}
//--></script>
