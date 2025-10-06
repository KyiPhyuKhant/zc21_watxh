<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ot_coupon.php 6099 2007-04-01 10:22:42Z wilt $
 */
$define = [
  'MODULE_ORDER_TOTAL_COUPON_TITLE' => 'Discount Coupons',
  'MODULE_ORDER_TOTAL_COUPON_HEADER' => TEXT_GV_NAMES . '/Discount Coupon',
  'MODULE_ORDER_TOTAL_COUPON_DESCRIPTION' => 'Discount',
  'MODULE_ORDER_TOTAL_COUPON_TEXT_ENTER_CODE' => TEXT_GV_REDEEM,
  'MODULE_ORDER_TOTAL_COUPON_HEADER' => TEXT_GV_NAMES . '/Discount Coupon',
  'SHIPPING_NOT_INCLUDED' => ' [Shipping not included]',
  'TAX_NOT_INCLUDED' => ' [Tax not included]',
  'IMAGE_REDEEM_VOUCHER' => 'Redeem Voucher',
  'TEXT_GV_REDEEM' => 'Promo code:',
  'MODULE_ORDER_TOTAL_COUPON_REDEEM_INSTRUCTIONS' => '',
  'MODULE_ORDER_TOTAL_COUPON_TEXT_CURRENT_CODE' => 'Your current promo code: ',
  'MODULE_ORDER_TOTAL_COUPON_REMOVE_INSTRUCTIONS' => '<p>To remove a Discount Coupon from this order type REMOVE and press Enter or Return</p>',
  'TEXT_REMOVE_REDEEM_COUPON' => 'Discount Coupon Removed by Request!',
  'MODULE_ORDER_TOTAL_COUPON_INCLUDE_ERROR' => ' Setting Include tax = true, should only happen when recalculate = None'
];

$zc158 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= '5.8'));
if ($zc158) {
    return $define;
} else {
    nmx_create_defines($define);
}
?>