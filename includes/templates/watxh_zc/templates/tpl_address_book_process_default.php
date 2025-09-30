<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=address_book_process.<br />
 * Allows customer to add a new address book entry
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_process_default.php 18695 2011-05-04 05:24:19Z drbyte $
 */
?>

<!-- <div class="centerColumn" id="addressBookProcessDefault">
	<?php //if (!isset($_GET['delete'])) echo zen_draw_form('addressbook', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL'), 'post', 'onsubmit="return check_form(addressbook);" id="address_book_process"'); 
     ?>


	<?php
     //if (isset($_GET['delete'])) {
     ?>

	<h1 id="addressBookProcessDefaultHeading"><?php //echo $breadcrumb->last();  
                                                  ?></h1>

	<?php //require($template->get_template_dir('tpl_modules_account_menu.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_account_menu.php'); 
     ?>

	<div id="account-content" class="delete-address">
		<p><?php //echo DELETE_ADDRESS_DESCRIPTION; 
               ?></p>
		<div class="account-info-wrapper delete-container">

			<address class=""><?php //echo zen_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'); 
                                   ?></address>
			<div class="clearBoth"></div>

			<div id="account-content">
				<div class="buttonRow back">
					<?php //echo zen_draw_form('delete_address', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'action=deleteconfirm', 'SSL'), 'post'); 
                         ?>
					<?php //echo zen_draw_hidden_field('delete', $_GET['delete']); 
                         ?>
					<?php //echo zen_image_submit(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT); 
                         ?>
					</form>
				</div>
				<div class="buttonRow back back-button">
					<?php //echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; 
                         ?>
				</div>

			</div>
		</div>
		<?php
          //} else {
          ?>
		<?php
          /**
           * Used to display address book entry form
           */
          ?>

		<h1 id="addressBookProcessDefaultHeading" class="back"><? //php // if (isset($_GET['edit'])) {
                                                                 //		echo HEADING_TITLE_MODIFY_ENTRY;
                                                                 //	} elseif (isset($_GET['delete'])) {
                                                                 //	echo HEADING_TITLE_DELETE_ENTRY;
                                                                 //	} else {
                                                                 //		echo HEADING_TITLE_ADD_ENTRY;
                                                                 //} 
                                                                 ?></h1>

		<div class="required alert forward"><?php // echo FORM_REQUIRED_INFORMATION; 
                                                  ?></div>

		<div class="clearBoth"></div>

		<?php // if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); 
          ?>

		<div class="account-info-wrapper">
			<?php // if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); 
               ?>
			<?php // require($template->get_template_dir('tpl_modules_address_book_details.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_address_book_details.php'); 
               ?>

			<div class="clearBoth"></div>
			<?php
               // if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
               ?>
			<div class="buttonRow"><?php // echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']) . zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); 
                                        ?></div>

		</div>

		<?php
          // } else {
          ?>
		<div class="buttonRow"><?php // echo zen_draw_hidden_field('action', 'process') . zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); 
                                   ?></div>

	</div>
	<?php
     //	}
     //}
     ?>
	<?php // if (!isset($_GET['delete'])) echo '</form>'; 
     ?>
</div> -->

<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=address_book_process.
 * Allows customer to add a new address book entry
 */
?>

<?php if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); ?>

<section class="address">
 <div class="container">
  <header class="sub-heading add_addresses_heading">
   <h3>Addresses</h3>
   <h4>
    <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'); ?>">
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-left-icon.svg'; ?>" alt="" />
     <span>Add Addresses</span>
    </a>
   </h4>
  </header>

  <div class="row">
   <?php if (isset($_GET['delete'])) { ?>
   <div id="account-content" class="delete-address">
    <p><?php echo DELETE_ADDRESS_DESCRIPTION; ?></p>
    <div class="account-info-wrapper delete-container">
     <address><?php echo zen_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'); ?></address>
     <div class="buttonRow">
      <?php echo zen_draw_form('delete_address', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'action=deleteconfirm', 'SSL'), 'post'); ?>
      <?php echo zen_draw_hidden_field('delete', $_GET['delete']); ?>
      <?php echo zen_image_submit(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT); ?>
      </form>
     </div>
     <div class="buttonRow back back-button">
      <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'); ?>">
       <?php echo zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT); ?>
      </a>
     </div>
    </div>
   </div>
   <?php } else { ?>

   <form class="address-form" action="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL'); ?>" method="post" onsubmit="return check_form(addressbook);">
    <!-- Dynamically insert security token -->
    <?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>

    <div class="form-group">
     <?php
// Get the current customer ID (assuming $current_customer_id is defined)
$current_customer_id = (int)$_SESSION['customer_id']; 

// Construct the SQL query to select the gender from the address_book table
$sql = "SELECT entry_gender
        FROM address_book
        WHERE customers_id = $current_customer_id
        LIMIT 1"; // Assuming you want the default address or the first one if there are multiple

// Execute the query
$address_book_query = $db->Execute($sql);

// Initialize the selected gender variable
$selectedGender = '';

// Check if any rows were returned
if ($address_book_query->RecordCount() > 0) {
    // Fetch the gender from the query result
    $selectedGender = $address_book_query->fields['entry_gender'];
}

// Output a hidden input field with the selected gender
echo '<input type="hidden" name="gender" value="' . htmlspecialchars($selectedGender) . '">';
?>


     <div class="input-group">
      <label for="firstname">First Name</label>
      <?php echo zen_draw_input_field('firstname', $entry->fields['entry_firstname'], 'placeholder="First Name" id="firstname"') . (zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="alert"></span>' : ''); ?>
     </div>
     <div class="input-group">
      <label for="lastname">Last Name</label>
      <?php echo zen_draw_input_field('lastname', $entry->fields['entry_lastname'], 'placeholder="Last Name" id="lastname"') . (zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="alert"></span>' : ''); ?>
     </div>
    </div>

    <?php if (ACCOUNT_COMPANY == 'true') { ?>
    <div class="input-group">
     <label for="company">Company</label>
     <?php echo zen_draw_input_field('company', $entry->fields['entry_company'], 'placeholder="Company" id="company"') . (zen_not_null(ENTRY_COMPANY_TEXT) ? '<span class="alert"></span>' : ''); ?>
    </div>
    <?php } ?>

    <div class="input-group">
     <label for="street-address">Address 1</label>
     <?php echo zen_draw_input_field('street_address', $entry->fields['entry_street_address'], 'placeholder="Address 1" id="street-address"') . (zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="alert"></span>' : ''); ?>
    </div>

    <?php if (ACCOUNT_SUBURB == 'true') { ?>
    <div class="input-group">
     <label for="suburb">Address 2</label>
     <?php echo zen_draw_input_field('suburb', $entry->fields['entry_suburb'], 'placeholder="Address 2" id="suburb"') . (zen_not_null(ENTRY_SUBURB_TEXT) ? '<span class="alert"></span>' : ''); ?>
    </div>
    <?php } ?>

    <div class="form-group">
     <div class="input-group">
      <label for="city">City</label>
      <?php echo zen_draw_input_field('city', $entry->fields['entry_city'], 'placeholder="City" id="city"') . (zen_not_null(ENTRY_CITY_TEXT) ? '<span class="alert"></span>' : ''); ?>
     </div>


     <?php if (ACCOUNT_STATE == 'true') { ?>
     <?php if ($flag_show_pulldown_states == true) { ?>
     <div class="select-group">
      <label for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
      <?php echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone"'); ?>
      <?php if (zen_not_null(ENTRY_STATE_TEXT)) echo '<span class="alert"></span>'; ?>
     </div>
     <?php } ?>

     <div class="input-group">
      <label for="state" id="stateLabel"><?php echo $state_field_label; ?>State</label>
      <?php
        echo zen_draw_input_field('state', zen_get_zone_name($entry->fields['entry_country_id'], $entry->fields['entry_zone_id'], $entry->fields['entry_state']), zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"');
        if (zen_not_null(ENTRY_STATE_TEXT)) echo '<span class="alert" id="stText"></span>';
        
        if ($flag_show_pulldown_states == false) {
          echo zen_draw_hidden_field('zone_id', $zone_name);
        }
      ?>
     </div>
     <?php } ?>

     <div class="select-group">
      <label for="country">Country</label>
      <?php echo zen_get_country_list('zone_country_id', $entry->fields['entry_country_id'], 'id="country"' . ($flag_show_pulldown_states == true ? ' onchange="update_zone(this.form);"' : '')) . (zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert"></span>' : ''); ?>
     </div>
    </div>


    <div class="form-group">
     <div class="input-group">
      <label for="postcode">Postal/Zip Code</label>
      <?php echo zen_draw_input_field('postcode', $entry->fields['entry_postcode'], 'placeholder="Postal/Zip Code" id="postcode"') . (zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="alert"></span>' : ''); ?>
     </div>
     <div class="input-group">
      <label for="phone">Phone</label>
      <input type="text" name="phone" id="phone" placeholder="Phone" required />
     </div>
    </div>

    <div class="input-checkbox">
     <?php echo zen_draw_checkbox_field('primary', 'on', false, 'id="primary"') . '<label class="checkboxLabel" for="primary">Set as default address</label>'; ?>
    </div>
    <?php if (isset($_GET['edit']) && is_numeric($_GET['edit'])) { ?>
    <div class="address-buttons">
     <a href="">
      <?php echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']) ?>
      <button>Update Address</button>
     </a>
     <button type="button" onclick="window.location.href='<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'); ?>'">
          Cancel
     </button>
    </div>
    <?php } else {
          ?>
    <div class="address-buttons">
     <a href="">
      <?php echo zen_draw_hidden_field('action', 'process') ?>
      <button>Add Address</button>
     </a>
     <button type="button" onclick="window.location.href='<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'); ?>'">
          Cancel
     </button>
    </div>

   </form>
   <?php } ?>
   <?php }?>
  </div>
 </div>
</section>