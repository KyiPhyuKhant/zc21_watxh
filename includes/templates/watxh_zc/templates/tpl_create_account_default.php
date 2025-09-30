<?php

/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_login_default.php 5926 2007-02-28 18:15:39Z drbyte $
 */
?>


<!-- <div class="centerColumn" id="loginDefault"> -->
<?php if ($messageStack->size('create_account') > 0) echo $messageStack->output('create_account'); ?>


<?php //if (USE_SPLIT_LOGIN_MODE == 'True' || $ec_button_enabled) { 
?>
<!--BOF PPEC split login- DO NOT REMOVE-->
<!-- <div class="split-mode">
  <div id="login" class="back">

   <fieldset>
    <h2><?php //echo HEADING_RETURNING_CUSTOMER_SPLIT; 
        ?></h2>

    <?php //echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); 
    ?>
    <label class="inputLabel" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
    <?php //echo zen_draw_input_field('email_address', '', 'size="18" id="login-email-address"'); 
    ?>
    <br class="clearBoth" />

    <label class="inputLabel" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
    <?php //echo zen_draw_password_field('password', '', 'size="18" id="login-password"'); 
    ?>
    <?php //echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); 
    ?>
    <br class="clearBoth" />

    <div class="buttonRow back"><?php //echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); 
                                ?></div>
    <div class="buttonRow back important"><?php //echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; 
                                          ?></div>

    <?php //if (IMAGE_USE_CSS_BUTTONS == 'True') { 
    ?>
    <p>hi</p>
    <?php //} 
    ?>


    </form>
   </fieldset>
  </div>

  <div id="register" class="forward">
   <fieldset>
    <h2><?php //echo HEADING_NEW_CUSTOMER_SPLIT; 
        ?></h2>
    <div class="information"><?php //echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT; 
                              ?></div>

    <?php //echo zen_draw_form('create', zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL')); 
    ?>
    <div class="buttonRow back" id="register-button"><?php //echo zen_image_submit(BUTTON_IMAGE_CREATE_ACCOUNT, BUTTON_CREATE_ACCOUNT_ALT); 
                                                      ?></div>
    </form>
   </fieldset>
  </div>
 </div> -->
<!--EOF PPEC split login- DO NOT REMOVE-->

<?php //} else { 
?>
<!--BOF normal login-->

<!-- <div class="no-split-mode"> -->
<!-- <div id="login">
   <fieldset>
    <h2><?php //echo HEADING_RETURNING_CUSTOMER; ?></h2>
    <?php //echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
    <label class="inputLabel" for="login-email-address"><?php //echo ENTRY_EMAIL_ADDRESS; ?></label>
    <?php //echo zen_draw_input_field('email_address', '', 'size="18" id="login-email-address"'); ?>
    <br class="clearBoth" />

    <label class="inputLabel" for="login-password"><?php //echo ENTRY_PASSWORD; ?></label>
    <?php //echo zen_draw_password_field('password', '', 'size="18" id="login-password"'); ?>
    <?php // echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']);  ?>
    <br class="clearBoth" />

    <div class="buttonRow back"><?php //echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT);   ?></div>
    <div class="buttonRow back important"><?php //echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>

    </form>
   </fieldset>
  </div> -->

<!-- <div class="login">
 <form class="login-form" action="<?php // echo zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL'); ?>" method="post">
  <h3>Login</h3>
  <input type="email" name="email_address" placeholder="Email Address" id="login-email-address" required />
  <input type="password" name="password" placeholder="Password" id="login-password" required />

  <?php //echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']);  ?>
  <p class="login-form--forgot_password"> <a href="<?php //echo zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL'); ?>">Forgot your password</a></p>

  <button>Login</button>
  <p>Don't have an Account? <a href="<?php //echo zen_href_link('register'); ?>">Create One</a></p>

 </form>
</div> -->

<div class="login">
  <form name="create_account" class="login-form" action="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT, 'action=process', 'SSL') ?>" method="post" onsubmit="return check_form(this);">
  <?php echo zen_draw_hidden_field('action', 'process'); ?>
  <?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
  
  <h3>Create Account</h3>
  <p class="login-form--sign_in">Already have an Account? <a href="<?php echo zen_href_link('login'); ?>">Sign In</a></p>

  <div class="input-group">
   <label for="firstname">First Name</Label>
   <input type="text" id="firstname" name="firstname" size="<?php echo zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40'); ?>" placeholder="First Name" required />
   <?php if ($messageStack->size('first_name') > 0) echo $messageStack->output('first_name'); ?>
  </div>

  <div class="input-group">
   <label for="lastname">Last Name</Label>
   <input type="text" id="lastname" name="lastname" size="<?php echo zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') ?>" placeholder="Last Name" required />
   <?php if ($messageStack->size('last_name') > 0) echo $messageStack->output('last_name'); ?>
  </div>

  <div class="input-group">
    <label for="company">Company</label>
    <input type="text" id="company" name="company" placeholder="company" required />
  </div>

  <div class="input-group">
   <label for="email-address">Email</Label>
   <input type="email" id="email-address" name="email_address" size="<?php echo zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') ?>" placeholder="Email" required />
   <?php if ($messageStack->size('email_address') > 0) echo $messageStack->output('email_address'); ?>
  </div>

  <div class="input-group">
   <label for="password-new">Password</Label>
   <input type="password" id="password-new" name="password" size="<?php echo zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') ?>" placeholder="Password" required />
   <?php if ($messageStack->size('password') > 0) echo $messageStack->output('password'); ?>
  </div>

  <div class="input-group">
   <label for="password-confirm">Confirm Password</Label>
   <input type="password" id="password-confirm" name="confirmation" size="<?php echo zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') ?>" placeholder="Confirm Password" required />
   <?php if ($messageStack->size('password_confirmation') > 0) echo $messageStack->output('password_confirmation'); ?>
  </div>

  <div class="input-group">
    <label for="street-address">Street Address</Label>
    <input type="text" id="street-address" name="street_address" placeholder="Street Address" required />
  </div>

  <div class="input-group">
    <label for="suburb">Suburb</label>
    <input type="text" id="suburb" name="suburb" placeholder="Suburb<?php echo (zen_not_null(ENTRY_SUBURB_TEXT) ? ' (required)' : ' (optional)'); ?>" <?php echo (zen_not_null(ENTRY_SUBURB_TEXT) ? ' required' : ''); ?> />
  </div>

  <div class="input-group">
    <label for="city">City</Label>
    <input type="text" id="city" name="city" placeholder="City" required />
  </div>

  <div class="input-group">
    <label for="postcode">Postal Code</Label>
    <input type="text" id="postcode" name="postcode" placeholder="Postal Code" required />
  </div>

  <div class="input-group">
    <label for="country">Country</Label>
    <?php echo zen_get_country_list('zone_country_id', STORE_COUNTRY, 'id="country" onchange="update_zone(this.form);"'); ?>
  </div>

  <div class="input-group">
    <label for="state">State/Province</Label>
    <div id="stateDiv">
      <?php echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down(STORE_COUNTRY), STORE_ZONE, 'id="state"'); ?>
    </div>
  </div>

  <div class="input-group">
    <label for="telephone">Telephone</Label>
    <input type="text" id="telephone" name="telephone" placeholder="Telephone" required />
  </div>

  <button type="submit">Create Account</button>
 </form>
</div>

<?php //echo zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-confirm"'); 
?>
<?php //if ($messageStack->size('password_confirmation') > 0) echo $messageStack->output('password_confirmation'); 
?>


</div>
<!-- </div> -->
<!--EOF normal login-->
<?php // } 
?>
<!-- </div> -->