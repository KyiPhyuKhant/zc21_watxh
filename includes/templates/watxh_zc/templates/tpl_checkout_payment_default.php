<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_payment.<br />
 * Displays the allowed payment modules, for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_payment_default.php 19358 2011-08-24 17:36:50Z drbyte $
 */
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
 <div class="container">
  <div class="row">
   <p><a href="/">Home</a> / <a href="">Cart </a> / <a href=""> Billing Details </a></p>
  </div>
 </div>
</div>
<!-- Breadcrumb End -->



<?php echo $payment_modules->javascript_validation(); ?>

<?php 
$is_shown_static_design = false;
if ($_SESSION['customer_id'] && $is_shown_static_design) { ?>

<!-- Shopping Billing -->
<div class="billing">
 <div class="container">
  <header class="sub-heading">
   <h3>Billing Details</h3>
  </header>
  <div class="row">
   <?php
        // Generate the form tag
        $form_tag = zen_draw_form(
          'checkout_payment', // Form name
          zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), // Form action
          'post', // Form method
          ($flagOnSubmit ? 'onsubmit="return check_form();"' : '') // Form onsubmit attribute
        );

        // Add the class attribute to the form tag
        $form_tag_with_class = str_replace('<form', '<form class="billing-contact"', $form_tag);

        // Output the form tag
        echo $form_tag_with_class;
        ?>

   <?php echo zen_draw_hidden_field('action', 'submit'); ?>


   <?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
   <?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>
   <?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment'); ?>

   <div class="billing-heading">
    <h4>Contact Information</h4>
    <!-- <p>Already have an account? <a href="">Log In</a></p> -->
   </div>
   <div class="billing-email">
    <div class="billing-input">
     <input type="email" name="email" placeholder="Email Address" required />
    </div>
    <div class="billing-checkbox">
     <input type="checkbox" name="subscribe" required />
     <label for="subscribe">Keep me up to date on news and exclusive </label>
    </div>
   </div>

   <div class="billing-delivery">
    <div class="billing-heading">
     <h4>Delivery Method</h4>
    </div>
    <div class="billing-radio">
     <input type="radio" name="ship" />
     <label for="ship">Ship</label>
    </div>
    <div class="billing-radio">
     <input type="radio" name="pick-up" />
     <label for="pick-up">Pick Up</label>
    </div>
   </div>

   <div class="billing-shipping">
    <div class="billing-heading">
     <h4>Shipping Address</h4>
    </div>
    <div class="form-group">
     <div class="billing-input">
      <label for="fname">First Name (Optional)</label>
      <input type="text" name="fname" placeholder="John" required />
     </div>
     <div class="billing-input">
      <label for="lname">Last Name</label>
      <input type="text" name="lname" placeholder="Last Name" required />
     </div>
    </div>
    <div class="billing-input">
     <label for="Company (Optional)">Company</label>
     <input type="text" name="company" placeholder="Company (Optional)" required />
    </div>
    <div class="billing-input">
     <label for="address">Address</label>
     <input type="text" name="address" placeholder="Address" required />
    </div>
    <div class="billing-input">
     <label for="apartment">Apartment</label>
     <input type="name" name="apartment" placeholder="Apartment, suite, etc. (optional)" required />
    </div>
    <div class="form-group">
     <div class="billing-input">
      <label for="Phone (Optional)">Phone</label>
      <input type="phone" name="phone" placeholder="Phone Optional" required />
     </div>
     <div class="billing-input">
      <label for="City">City</label>
      <input type="text" name="city" placeholder="City" required />
     </div>
    </div>
    <div class="form-group">
     <div class="billing-input">
      <label for="countries">Country</label>
      <input list="countries" id="countries" name="countries" placeholder="Countries" />
      <datalist id="countries">
       <option value="Reading"></option>
       <option value="Traveling"></option>
       <option value="Cooking"></option>
      </datalist>
     </div>
     <div class="billing-input">
      <label for="provinces">Province</label>
      <input list="provinces" id="provinces" name="provinces" placeholder="Province" />
      <datalist id="provinces">
       <option value="Reading"></option>
       <option value="Traveling"></option>
       <option value="Cooking"></option>
      </datalist>
     </div>
    </div>
    <div class="billing-checkbox">
     <input type="checkbox" name="subscribe" required />
     <label for="subscribe">Use shipping address as billing address</label>
    </div>
   </div>

   <div class="billing-payment">
    <div class="billing-heading">
     <h4>Payment</h4>
    </div>
    <div class="billing-button">
     <button>Credit/Debit Card</button> <button><img src="<?php echo DIR_WS_TEMPLATE . 'images/icons/paypal-text-icon.svg' ?>" alt="" /></button>
    </div>

    <div class="billing-input">
     <label for=""></label>
     <input type="number" name="credit-card" placeholder="Card Number" required />
    </div>
    <div class="form-group">
     <div class="billing-input">
      <label for=""></label>
      <input type="date" name="date" placeholder="Expiry Date" required />
     </div>
     <div class="billing-input">
      <label for=""></label>
      <input type="number" name="CVV" placeholder="CVV" required />
     </div>
    </div>
    <div class="billing-input">
     <label for=""></label>
     <input type="text" name="card-name" placeholder="Cardholder Name" required />
    </div>

    <div class="billing-checkbox">
     <input type="checkbox" name="subscribe" required />
     <label for="subscribe">Save this information for next time </label>
    </div>
   </div>
   </form>
   <div class="billing-cart">

    <?php
          if ($_SESSION['cart']->count_contents() > 0) {
          ?>
    <?php
          }
          ?>
    <?php
          $productArray = isset($productArray) ? $productArray : [];
          foreach ($productArray as $product) {
          ?>
    <div class="billing-cart--card">
     <div class="billing-cart--items">
      <div class="billing-cart--image">
       <div class="billing-cart--badge">
        <p><?php echo  $product['showFixedQuantityAmount'] ?></p>
       </div>
       <div class="">
        <?php echo $product['productsImage']; ?>
       </div>
      </div>
      <div class="billing-cart--text">
       <p> <?php echo $product['productsName'] . '<span class="alert bold">' . $product['flagStockCheck'] . '</span>'; ?></p>
       <p>Color: <strong>Blue</strong></p>
      </div>
     </div>
     <div class="billing-cart--price">

      <p> <?php echo $product['productsPriceEach']; ?></p>
     </div>
    </div>

    <?php } ?>

    <div class="billing-cart--subtotal">
     <p>Subtotal</p>
     <p> <?php echo $cartShowTotal; ?></p>
    </div>
    <div class="billing-cart--shipping">
     <p>Shipping</p>
     <p>$5.00</p>
    </div>

    <div class="billing-cart--total">
     <p>Total:</p>
     <h3>$719.00</h3>
    </div>

    <button>Place Order</button>
   </div>
  </div>
 </div>
</div>
<!-- End Shopping Cart -->
<?php } ?>

<div class="billing billing-details-container">
  <div class="container">
    <header class="sub-heading">
    <h3>Billing Details</h3>
    </header>
    <div class="row">
      <div class="billing-contact">
        <?php echo $payment_modules->javascript_validation(); ?>
        <div class="centerColumn checkout_pages" id="checkoutPayment">
        <?php echo zen_draw_form('checkout_payment', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', ($flagOnSubmit ? 'onsubmit="return check_form();"' : '')); ?>
        <?php echo zen_draw_hidden_field('action', 'submit'); ?>
        
        <h1 id="checkoutPaymentHeading"><?php echo HEADING_TITLE; ?></h1>
        
        <?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
        <?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>
        <?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment'); ?>
        
        <div class="col-left col-first">
          <?php
            if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
            ?>
          <fieldset>
          <legend><?php echo TABLE_HEADING_CONDITIONS; ?></legend>
          <div><?php echo TEXT_CONDITIONS_DESCRIPTION; ?></div>
          <?php echo  zen_draw_checkbox_field('conditions', '1', false, 'id="conditions"'); ?>
          <label class="checkboxLabel" for="conditions"><?php echo TEXT_CONDITIONS_CONFIRM; ?></label>
          </fieldset>
          <?php
            }
            ?>
        
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
            if (!$payment_modules->in_special_checkout()) {
              // ** END PAYPAL EXPRESS CHECKOUT ** 
            ?>
          <h2 id="checkoutPaymentHeadingAddress"><?php echo TITLE_BILLING_ADDRESS; ?></h2>
        
          <div id="checkoutBillto" class="box">
          <address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?></address>
          <?php if (MAX_ADDRESS_BOOK_ENTRIES >= 2) { ?>
          <div class="buttonRow"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a>'; ?></div>
          <?php } ?>
          </div>
        
          <p><?php echo TEXT_SELECTED_BILLING_DESTINATION; ?></p>
        
        </div>
        <div class="col-right">
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
            }
            // ** END PAYPAL EXPRESS CHECKOUT ** 
          ?>
        
          <!-- <fieldset id="checkoutOrderTotals"> -->
          <!-- <h2 id="checkoutPaymentHeadingTotal"><?php //echo TEXT_YOUR_TOTAL; ?></h2> -->
          <?php
            // if (MODULE_ORDER_TOTAL_INSTALLED) {
            //   $order_totals = $order_total_modules->process();
            ?>
          <!-- <table> -->
            <?php //$order_total_modules->output(); ?>
          <!-- </table> -->
        
          <?php
            // }
            ?>
          <!-- </fieldset> -->
        
          <?php
          $selection =  $order_total_modules->credit_selection();
          if (sizeof($selection) > 0) {
            for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {
              if (isset($_GET['credit_class_error_code']) && $_GET['credit_class_error_code'] == (isset($selection[$i]['id']) ? $selection[$i]['id'] : '')) {
          ?>
          <div class="messageStackError"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>
        
          <?php
              }
              if (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
                $fields = $selection[$i]['fields'];
                for ($j = 0, $n2 = sizeof($fields); $j < $n2; $j++) {
                ?>
          <fieldset id="discount">
          <h2><?php echo $selection[$i]['module']; ?></h2>
          <div class="box box-form">
            <?php echo $selection[$i]['redeem_instructions']; ?>
            <?php if (isset($selection[$i]['checkbox'])) { ?>
              <p><?php echo $selection[$i]['checkbox']; ?></p>
            <?php } ?>
            <div class="field">
            <label class="inputLabel" <?php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="' . $selection[$i]['fields'][$j]['tag'] . '"' : ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
            <?php echo $selection[$i]['fields'][$j]['field']; ?>
            </div>
          </div>
          </fieldset>
          <?php
                }
              }
            }
            ?>
        
          <?php
          }
          ?>
        
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
          if (!$payment_modules->in_special_checkout()) {
            // ** END PAYPAL EXPRESS CHECKOUT ** 
          ?>
          <fieldset id="checkoutPaymentMethod">
          <h2><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></h2>
          <div class="box">
            <?php
                if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
                ?>
        
            <?php
                  if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
                    echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
                  }
                  if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
                    echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
                  }
                  ?>
            <?php } ?>
        
            <?php
                $selection = $payment_modules->selection();
        
                if (sizeof($selection) > 1) {
                ?>
            <p><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p>
            <?php
                } elseif (sizeof($selection) == 0) {
                ?>
            <p><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></p>
        
            <?php
                }
                ?>
        
            <?php
              $radio_buttons = 0;
              for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {
                // Start: input-inline
                echo '<div class="input-inline">';
                if (sizeof($selection) > 1) {
                  if (empty($selection[$i]['noradio'])) {
                    echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == ($_SESSION['payment'] ?? '') ? true : false), 'id="pmt-' . $selection[$i]['id'] . '"');
                  } 
                } else {
                  echo zen_draw_hidden_field('payment', $selection[$i]['id'], 'id="pmt-' . $selection[$i]['id'] . '"');
                }
              ?>
                <label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel"><?php echo $selection[$i]['module']; ?></label>
              <?php
                echo '</div>'; //End: input-inline

                if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod') {
              ?>
                <div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
              <?php
                } else {
                  // echo 'WRONG ' . $selection[$i]['id'];
                }
                
                if (isset($selection[$i]['error'])) {
              ?>
                <div><?php echo $selection[$i]['error']; ?></div>
        
              <?php
                } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
              ?>
                <div class="ccinfo">
                <?php
                  for ($j = 0, $n2 = sizeof($selection[$i]['fields']); $j < $n2; $j++) {
                    echo '<div class="form-control form-control-'. ($j + 1) .'">';
                    echo $selection[$i]['fields'][$j]['field']; 
                ?>
                  <label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="' . $selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
                <?php
                    echo '</div>';
                  }
                ?>
                </div>
              <?php
                }
                $radio_buttons++;
              ?>
            <?php
              
              }
            ?>
          </div>
          </fieldset>
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
          } else {
          ?><input type="hidden" name="payment" value="<?php echo isset($_SESSION['payment']) ? $_SESSION['payment'] : ''; ?>" /><?php
                                                                                            }
                                                                                            // ** END PAYPAL EXPRESS CHECKOUT ** 
                                                                                              ?>
        
          <fieldset id="comments">
          <h2><?php echo TABLE_HEADING_COMMENTS; ?></h2>
          <?php echo zen_draw_textarea_field('comments', '45', '3'); ?>
          </fieldset>
        
          <div class="container-button">
          <?php
          $has_gv_account = zen_user_has_gv_account($_SESSION['customer_id']) ? 'true' : 'false';
          $order_total = isset($order->info['total']) ? $order->info['total'] : 0;
          ?>
          <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT, 'onclick="submitFunction(' . $has_gv_account . ', ' . $order_total . ')"'); ?></div>
          <div class="back"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>
          </div>
        </div>
        </form>
        </div>
      </div>

      <div class="billing-cart">
        <?php
        // Initialize productArray if it doesn't exist
        $productArray = isset($productArray) ? $productArray : [];

        if ($_SESSION['cart']->count_contents() > 0) {
          foreach ($productArray as $product) {
        ?>
        <div class="billing-cart--card">
          <div class="billing-cart--items">
            <div class="billing-cart--image">
              <div class="billing-cart--badge">
                <p><?php echo  $product['showFixedQuantityAmount'] ?></p>
              </div>
              <div class="">
                <?php echo $product['productsImage']; ?>
              </div>
            </div>
            <div class="billing-cart--text">
              <p> <?php echo $product['productsName'] . '<span class="alert bold">' . $product['flagStockCheck'] . '</span>'; ?></p>
              <p>Color: <strong>Blue</strong></p>
            </div>
          </div>
          <div class="billing-cart--price">
            <p> <?php echo $product['productsPriceEach']; ?></p>
          </div>
        </div>

        <?php 
            }
          }
        ?>

        <div class="billing-cart--subtotal">
          <!-- <p>Subtotal</p>
          <p> <?php //echo $cartShowTotal; ?></p>
          </div>
          <div class="billing-cart--shipping">
          <p>Shipping</p>
          <p>$5.00</p>
          </div>

          <div class="billing-cart--total">
          <p>Total:</p>
          <h3>$719.00</h3> -->

          <?php
            if (MODULE_ORDER_TOTAL_INSTALLED) {
              $order_totals = $order_total_modules->process();
          ?>
          <table>
            <?php $order_total_modules->output(); ?>
          </table>
        
          <?php
            }
            ?>
        </div>

        <button id="btn-place-order">Place Order</button>
      </div>
    </div>
  </div>
</div>