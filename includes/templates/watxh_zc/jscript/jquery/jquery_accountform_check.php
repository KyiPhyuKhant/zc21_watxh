<?php
/**
 * jscript_form_check
 *
 * @package page
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_form_check.php 17018 2010-07-27 07:25:41Z drbyte $
 */
?>
<script language="javascript" type="text/javascript"><!--
var selected;

jQuery(document).ready(function(){
	jQuery("input").focus(function(){
		jQuery(this).nextAll('.tooltip:first').fadeIn();
	});
	jQuery("input").blur(function(){
		jQuery(this).nextAll('.tooltip:first').fadeOut();
	});
		
});
	

function check_form_optional(form_name) {
  //var form = form_name;
  if (jQuery('form[name="' + form_name + '"] input[name="firstname"]').length == 0) {
    return true;
  } else {
    var firstname = jQuery('[name="firstname"]').val();
    var lastname = jQuery('[name="lastname"]').val();
    var street_address = jQuery('[name="street_address"]').val();

    if (firstname == '' && lastname == '' && street_address == '') {
      return true;
    } else {
      return check_form(form_name);
    }
  }
}
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_input(field_name, field_size, message) {
  if (jQuery('[name="' + field_name + '"]') && (jQuery('[name="' + field_name + '"]').attr("visibility") != "hidden")) {
    if (field_size == 0) return;
	if (jQuery('[name="' + field_name + '"]').length > 0) {
    	var field_value = jQuery('[name="' + field_name + '"]').val();
    	if (field_value == '' || field_value.length < field_size) {
      	error = true; 
      	jQuery('[name="' + field_name + '"]').addClass("border-highlighted");
      	jQuery('[name="' + field_name + '"]').after(' <span class="errorMessage">' + message + '</span>');
		}
    }
  }
}

function check_radio(field_name, message) {
  var isChecked = false;

  if (jQuery('[name="' + field_name + '"]').val() && (jQuery('[name="' + field_name + '"]').attr("visibility") != "hidden")) {
    var radio = jQuery('[name="' + field_name + '"]');

    for (var i=0; i<radio.length; i++) {
      if (radio[i].checked == true) {
        isChecked = true;
        break;
      }
    }

    if (isChecked == false) {
      jQuery('[name="' + field_name + '"]').addClass("border-highlighted");
      jQuery('[name="' + field_name + '"]').after(' <span class="errorMessage">' + message + '</span>');
      error = true;
    }
  }
}

function check_select(field_name, field_default, message) {
  if (jQuery('[name="' + field_name + '"]') && (jQuery('[name="' + field_name + '"]').attr("visibility") != "hidden")) {
    var field_value = jQuery('[name="' + field_name + '"]').val();

    if (field_value == field_default) {
      jQuery('[name="' + field_name + '"]').addClass("border-highlighted");
      jQuery('[name="' + field_name + '"]').after(' <span class="errorMessage">' + message + '</span>');
      error = true; 
    }
  }
}

function check_password(field_name_1, field_name_2, field_size, message_1, message_2) {
  if (jQuery('[name=' + field_name_1 + ']') && (jQuery('[name=' + field_name_1 + ']').attr("visibility") != "hidden")) {
    var password = jQuery('[name=' + field_name_1 + ']').val();
    var confirmation = jQuery('[name=' + field_name_2 + ']').val();

	if (jQuery('[name="' + field_name_1 + '"]').length > 0) {
	  if (password == '' || password.length < field_size) {
		jQuery('[name=' + field_name_1 + ']').addClass("border-highlighted");
		jQuery('[name=' + field_name_1 + ']').after(' <span class="errorMessage">' + message_1 + '</span>');
		error = true;
	  } else if (password != confirmation) {
		jQuery('[name=' + field_name_2 + ']').addClass("border-highlighted");
		jQuery('[name=' + field_name_2 + ']').after(' <span class="errorMessage">' + message_2 + '</span>');
		error = true; 
	  }
	}
  }
}

function check_state(min_length, min_message, select_message) {
  if (jQuery('[name="state"]') && jQuery('[name="zone_id"]')) {
    if (!jQuery('[name="state"]').is(':disabled') && jQuery('[name="zone_id"]').val() == "") check_input("state", min_length, min_message);
  } else if (jQuery('[name="state"]') && !jQuery('[name="state"]').is(':hidden') && jQuery('[name="state"]').is(':disabled')) {
    check_select("zone_id", "", select_message);
  }
}

<?php if ($_GET['main_page'] == FILENAME_ACCOUNT_PASSWORD) { ?>
function check_password_new(field_name_1, field_name_2, field_name_3, field_size, message_1, message_2, message_3) {
  if (jQuery('[name=' + field_name_1 + ']') && (jQuery('[name=' + field_name_1 + ']').attr("visibility") != "hidden")) {
    
	if (jQuery('[name="' + field_name_2 + '"]').length > 0) {
		var password_current = jQuery('[name=' + field_name_1 + ']').val();
		var password_new = jQuery('[name=' + field_name_2 + ']').val();
		var password_confirmation = jQuery('[name=' + field_name_3 + ']').val();
	
		if (password_current == '' || password_current.length < field_size) {
		  jQuery('[name=' + field_name_1 + ']').addClass("border-highlighted");
		  jQuery('[name=' + field_name_1 + ']').after(' <span class="errorMessage">' + message_1 + '</span>');
		  error = true; 
		} else if (password_new == '' || password_new.length < field_size) {
		  jQuery('[name=' + field_name_2 + ']').addClass("border-highlighted");
		  jQuery('[name=' + field_name_2 + ']').after(' <span class="errorMessage">' + message_2 + '</span>');
		  error = true; 
		} else if (password_new != password_confirmation) {
		  jQuery('[name=' + field_name_3 + ']').addClass("border-highlighted");
		  jQuery('[name=' + field_name_3 + ']').after(' <span class="errorMessage">' + message_3 + '</span>');
		  error = true;
		}
	}
  }
}
<?php }?>

function check_form(form_name) {
	
  jQuery('.border-highlighted').removeClass('border-highlighted');
  jQuery('.errorMessage').remove();
  
  if (submitted == true) {
    return false;
  }

  error = false;
  form = form_name;
  error_message = "<?php echo JS_ERROR; ?>";

<?php if (ACCOUNT_GENDER == 'true') echo '  check_radio("gender", "' . ENTRY_GENDER_ERROR . '");' . "\n"; ?>

<?php if ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0) { ?>
  check_input("firstname", <?php echo (int)ENTRY_FIRST_NAME_MIN_LENGTH; ?>, "<?php echo ENTRY_FIRST_NAME_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0) { ?>
  check_input("lastname", <?php echo (int)ENTRY_LAST_NAME_MIN_LENGTH; ?>, "<?php echo ENTRY_LAST_NAME_ERROR; ?>");
<?php } ?>

<?php if (ACCOUNT_DOB == 'true' && (int)ENTRY_DOB_MIN_LENGTH != 0) echo '  check_input("dob", ' . (int)ENTRY_DOB_MIN_LENGTH . ', "' . ENTRY_DATE_OF_BIRTH_ERROR . '");' . "\n"; ?>
<?php if (ACCOUNT_COMPANY == 'true' && (int)ENTRY_COMPANY_MIN_LENGTH != 0) echo '  check_input("company", ' . (int)ENTRY_COMPANY_MIN_LENGTH . ', "' . ENTRY_COMPANY_ERROR . '");' . "\n"; ?>

<?php if ((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0) { ?>
  check_input("email_address", <?php echo (int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>, "<?php echo ENTRY_EMAIL_ADDRESS_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0) { ?>
  check_input("street_address", <?php echo (int)ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>, "<?php echo ENTRY_STREET_ADDRESS_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_POSTCODE_MIN_LENGTH > 0) { ?>
  check_input("postcode", <?php echo (int)ENTRY_POSTCODE_MIN_LENGTH; ?>, "<?php echo ENTRY_POST_CODE_ERROR; ?>");
<?php } ?>
<?php if ((int)ENTRY_CITY_MIN_LENGTH > 0) { ?>
  check_input("city", <?php echo (int)ENTRY_CITY_MIN_LENGTH; ?>, "<?php echo ENTRY_CITY_ERROR; ?>");
<?php } ?>
<?php if (ACCOUNT_STATE == 'true') { ?>
  check_state(<?php echo (int)ENTRY_STATE_MIN_LENGTH . ', "' . ENTRY_STATE_ERROR . '", "' . ENTRY_STATE_ERROR_SELECT; ?>);
<?php } ?>

  check_select("country", "", "<?php echo ENTRY_COUNTRY_ERROR; ?>");

<?php if ((int)ENTRY_TELEPHONE_MIN_LENGTH > 0) { ?>
  check_input("telephone", <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>, "<?php echo ENTRY_TELEPHONE_NUMBER_ERROR; ?>");
<?php } ?>

<?php if ((int)ENTRY_PASSWORD_MIN_LENGTH > 0) { ?>
  check_password("password", "confirmation", <?php echo (int)ENTRY_PASSWORD_MIN_LENGTH; ?>, "<?php echo ENTRY_PASSWORD_ERROR; ?>", "<?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING; ?>");
<?php } ?>

<?php if ($_GET['main_page'] == FILENAME_ACCOUNT_PASSWORD) { ?>
  check_password_new("password_current", "password_new", "password_confirmation", <?php echo (int)ENTRY_PASSWORD_MIN_LENGTH; ?>, "<?php echo ENTRY_PASSWORD_ERROR; ?>", "<?php echo ENTRY_PASSWORD_NEW_ERROR; ?>", "<?php echo ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING; ?>"); 
<?php } ?>



  if (error == true) {
    return false;
  } else {
    submitted = true;
    return true;
  }
}
//--></script>
