<?php
if ($nmx_disk_cache->cacheStart('tpl_footer', array(), true, true)) {

?>
<?php
  /**
   * Common Template - tpl_footer.php
   *
   * this file can be copied to /templates/your_template_dir/pagename<br />
   * example: to override the privacy page<br />
   * make a directory /templates/my_template/privacy<br />
   * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_footer.php<br />
   * to override the global settings and turn off the footer un-comment the following line:<br />
   * <br />
   * $flag_disable_footer = true;<br />
   *
   * @package templateSystem
   * @copyright Copyright 2003-2010 Zen Cart Development Team
   * @copyright Portions Copyright 2003 osCommerce
   * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
   * @version $Id: tpl_footer.php 15511 2010-02-18 07:19:44Z drbyte $
   */
  require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
  ?>

<?php
  if (!isset($flag_disable_footer) || !$flag_disable_footer) {
  ?>

<div id="footer">
 
<?php
$main_page = $_GET['main_page'] ?? '';
$cPath = $_GET['cPath'] ?? '';

if (
  !($main_page == 'index' && empty($cPath)) &&
  $main_page != 'checkout_success'
):
?>
 <!-- Shipping -->
 <div class="shipping">
  <div class="container">
   <div class="row">
    <div class="shipping-column">
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/shipping-icon.svg' ?>" alt="" />
     <div class="">
      <h4>Free Shipping</h4>
      <p>Indulge in a seamless shopping spree without the worry of shipping costs!</p>
     </div>
    </div>
    <div class="shipping-column">
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/refund-icon.svg' ?>" alt="" />
     <div class="">
      <h4>100% Refund</h4>
      <p>Shop with confidence knowing that your satisfaction is our top priority.</p>
     </div>
    </div>
    <div class="shipping-column">
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/support-icon.svg' ?>" alt="" />
     <div class="">
      <h4>Support 24/7</h4>
      <p>Ready to address your inquiries, making your experience seamless.</p>
     </div>
    </div>
   </div>
  </div>
 </div>
 <!-- Shipping End -->
 <?php endif; ?>

 <!-- 		1. message	-->
 <?php
      // $banner = $db->Execute("SELECT banners_id, banners_html_text, banners_title, banners_image, banners_url FROM " . TABLE_BANNERS . " WHERE status = 1 AND banners_group = 'footerbanner' ORDER BY banners_sort_order ASC LIMIT 1");

      // if ($banner->RecordCount() > 0) {

      ?>
 <div class="footer--message">
  <div class="wrapper--container">
   <?php
          // while (!$banner->EOF) {

          // 	if($banner->fields['banners_html_text']){
          // 		$banner_string = $banner->fields['banners_html_text'];
          // 	} else {
          // 		$banner_string = '<a href="' . zen_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner->fields['banners_id']) . '" target="_blank">' . zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title']) . '</a>';
          // 	}

          // 	echo $banner_string;

          // 	zen_update_banner_display_count($banner->fields['banners_id']);

          // 	$banner->MoveNext();

          // }

          ?>
  </div>
 </div>
 <?php
      // }
      ?>


 <!--	Footer 	-->
 <footer class="footer">
  <div class="container">
   <div class="footer-top">
    <div class="footer-top--about">
     <h4>About Us</h4>
     <ul>
      <li><a href="<?php echo zen_href_link(FILENAME_ABOUT_US, '', 'NONSSL'); ?>">Our Story</a></li>
      <li><a href="">Blog</a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_FAQS); ?>">FAQs</a></li>
      <li><a href="">Theme Features</a></li>
     </ul>
    </div>
    <div class="footer-top--customer">
     <h4>Customer Care</h4>
     <ul>
      <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING, '', 'NONSSL'); ?>">Shipping Info</a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING, '', 'NONSSL'); ?>">Refund & Returns</a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS, '', 'NONSSL'); ?>">Terms and Conditions</a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>">My Account</a></li>
     </ul>
    </div>
    <div class="footer-top--contact">
     <h4>Get In Touch</h4>
     <ul>
      <li>
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/location-icon.svg' ?> " alt="" />
       <a href="">972 Zboncak Underpass Apt. <br />918, East Carterland, USA </a>
      </li>
      <li><img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/phone-footer-icon.svg' ?> " alt="" /><a href="">+1 800 123 1234</a></li>
      <li><img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/email-icon.svg' ?> " alt="" /><a href="">Email Us</a></li>
      <li><img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chat-square.svg' ?> " alt="" /><a href="">Live Chat</a></li>
     </ul>
    </div>
    <div class="footer-top--subscribe">
     <h3><a href=""><?php echo '<a id="logo" href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . 'Watxh' . '</a>'; ?></a></h3>
     <form name="subscribe" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=subscribe" method="post">
      <?php

                echo zen_draw_form('subscribe', zen_href_link(FILENAME_SUBSCRIBE, '', 'SSL'), 'post', '');
                echo zen_draw_hidden_field('act', 'subscribe');
                echo zen_draw_hidden_field('main_page', FILENAME_SUBSCRIBE);
                ?>
      <p>Subscribe today and get 10% off your first purchase</p>
      <div class="input-group">
       <?php echo zen_draw_input_field('email', '', 'id="txtsubscribe" required autocomplete="off" placeholder="' . 'Enter email address' . '"'); ?>
       <button type="submit" value="Sign Up">Subscribe</button>
       <?php echo zen_draw_hidden_field('email_format', 'HTML'); ?>
      </div>
     </form>
    </div>
   </div>
   <div class="footer-bottom">
    <div class="footer-bottom--payments">
     <h4>We Accept</h4>
     <ul>
      <li>
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/visa-icon.svg'; ?>" alt="cart-icon" />
      </li>
      <li>
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/mastercard-icon.svg'; ?>" alt=" cart-icon" />
      </li>
      <li>
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/american-express-icon.svg'; ?>" alt=" cart-icon" />
      </li>
      <li>
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/paypal-icon.svg'; ?>" alt=" cart-icon" />
      </li>
      <li>
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/discover-icon.svg'; ?>" alt=" cart-icon" />
      </li>
     </ul>
    </div>
    <div class="footer-bottom--sm">
     <h4>Follow Us</h4>
     <ul>
      <li>
       <a href="">
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/facebook.svg' ?>" alt=" cart-icon" />
       </a>
      </li>
      <li>
       <a href="">
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/instagram.svg' ?>" alt=" cart-icon" />
       </a>
      </li>
      <li>
       <a href="">
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/twitter.svg'; ?>" alt=" cart-icon" />
       </a>
      </li>
      <li>
       <a href="">
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/pinterest.svg'; ?>" alt=" cart-icon" />
       </a>
      </li>
     </ul>
    </div>
   </div>

   <div class="footer-copyright">
    <p>Copyright © 2022, Watxh Theme - Watxh</p>
    <div class="footer-links">
     <a href="<?php echo zen_href_link(FILENAME_CONDITIONS, '', 'NONSSL'); ?>">Terms of Use</a> <a href=" <?php echo zen_href_link(FILENAME_PRIVACY, '', 'NONSSL'); ?>">Privacy Policy</a><a href="">Powered By Lexmodo</a>
    </div>
   </div>
  </div>
 </footer>


 <!-- 3. copy and flags	-->
 <!-- <div class="footer--copyright-flags">
		<div class="wrapper--container">
			
			<div id="copyright-wrapper">
				<p>
					<span class="copyright"><?php //echo TABLEAU_FTR_COPYRIGHT; ?></span>
					<span class="designed-by">Web Design by <a href="https://www.numinix.com/" target="_blank">Numinix</a></span>
					<?php
          // Set session if in desktop view
          // if ($_GET['view'] == 'desktop') {
          // 	$_SESSION["view"] = 'desktop';
          // }
          // if ($_GET['view'] == 'mobile') {
          // 	$_SESSION["view"] = 'mobile';
          // }
          ?>
					<span class="device">
						<?php
            //if (($_GET['view'] == 'desktop') || ($_SESSION['view'] == 'desktop')) { ?>
							<a href="<?php //echo $_SERVER['PHP_SELF']; ?>?view=mobile"/>Mobile View</a>
						<?php //} else { ?>
							<a href="<?php //echo $_SERVER['PHP_SELF']; ?>?view=desktop"/>Desktop View</a>
						<?php //} ?>
					</span>
				</p>
			</div> -->

 <?php
      // $banner = $db->Execute("SELECT banners_id, banners_html_text, banners_title, banners_image, banners_url FROM " . TABLE_BANNERS . " WHERE status = 1 AND banners_group = 'securitybadges' ORDER BY banners_sort_order ASC LIMIT 5");

      // if ($banner->RecordCount() > 0) {

      // 	while (!$banner->EOF) {

      // if($banner->fields['banners_url']){
      // 		$banner_string = '<div style="margin-left:20px;" class="flags"><a href="' . zen_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner->fields['banners_id']) . '" target="_blank">' . zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title']) . '</a></div>';
      // 		}else{
      // 		$banner_string = '<div style="margin-left:20px;" class="flags">' . zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title']) . '</div>';
      // }
      // if($banner->fields['banners_html_text']){
      // $banner_string = '<div style="margin-left:20px;" class="flags">' . stripslashes($banner->fields['banners_html_text']) . '</div>';
      // }
      // 		echo $banner_string;

      // 		zen_update_banner_display_count($banner->fields['banners_id']);
      // 		$banner->MoveNext();

      // 	}
      // }
      ?>

</div>
</div>

<!--bof-banner #5 display -->
<?php
    if (SHOW_BANNERS_GROUP_SET5 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET5)) {
      if ($banner->RecordCount() > 0) {
    ?>
<div id="bannerFive" class="banners" style="display: none"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
      }
    }
    ?>
<!--eof-banner #5 display -->

<!--bof- banner #6 display -->
<?php
    if (SHOW_BANNERS_GROUP_SET6 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET6)) {
      if ($banner->RecordCount() > 0) {
    ?>
<div id="bannerSix" class="banners" style="display: none"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
      }
    }
    ?>

</div>


<?php
  } // flag_disable_footer
  ?>
<?php
  $nmx_disk_cache->cacheEnd();
}

?>