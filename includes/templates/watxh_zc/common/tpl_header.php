<?php

/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Tue Aug 14 14:56:11 2012 +0100 Modified in v1.5.1 $
 */
?>

<?php
// Display all header alerts via messageStack:
if ($messageStack->size('header') > 0) {
  echo $messageStack->output('header');
}
if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
  echo htmlspecialchars(urldecode($_GET['error_message']), ENT_COMPAT, CHARSET, TRUE);
}
if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
  echo htmlspecialchars($_GET['info_message'], ENT_COMPAT, CHARSET, TRUE);
} else {
}
?>

<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>
<?php
  if ($nmx_disk_cache->cacheStart('tpl_header', array($_SESSION['customer_id'] ?? null, $_SESSION['customer_first_name'] ?? '', $_SESSION['cart']->count_contents()), array($_SESSION['languages_id']), true, true)) {
  ?>
<div id="header" role="banner">

 <!-- 
			1. banner area
			if no banner associated, this are shouldn't appear.
		-->
 <!-- <?php
            if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
              if ($banner->RecordCount() > 0) {
            ?>
			<?php echo zen_display_banner('static', $banner); ?>

		<?php
              }
            }
    ?>


		<?php
    $banner = $db->Execute("SELECT banners_id, banners_html_text, banners_title, banners_image, banners_url FROM " . TABLE_BANNERS . " WHERE status = 1 AND banners_group = 'headerbanner' ORDER BY banners_sort_order ASC LIMIT 1");

    if ($banner->RecordCount() > 0) {
    ?>
		<div class="header--banner">
			<div class="wrapper--container">
				<?php

        while (!$banner->EOF) {

          if ($banner->fields['banners_html_text']) {
            $banner_string = $banner->fields['banners_html_text'];
          } else {
            $banner_string = '<a href="' . zen_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner->fields['banners_id']) . '" target="_blank">' . zen_image(DIR_WS_IMAGES . $banner->fields['banners_image'], $banner->fields['banners_title']) . '</a>';
          }

          echo $banner_string;

          zen_update_banner_display_count($banner->fields['banners_id']);
          $banner->MoveNext();
        }

        ?>

			</div>
		</div>
		<?php
    }
    ?> -->

 <nav class="navbar">
  <div class="navbar-top">
   <div class="container">
    <ul class="navbar-top--right">
     <li>
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/email-icon.svg'; ?>" alt="email-icon" />
      <p>support@watxh.com</p>
     </li>
     <li>
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/phone-icon.svg'; ?>" alt="email-icon" />
      <p>(12345)67890</p>
     </li>
    </ul>
    <!--  -->
    <form class="navbar-top--left">
     <select name="" id="language-selector">
      <option value="">English</option>
      <option value="">Spanish</option>
      <option value="">French</option>
     </select>
     <select name="" id="currency-selector">
      <option value="">USD</option>
      <option value="">GBP</option>
      <option value="">EUR</option>
      <option value="">YEN</option>
     </select>
    </form>
   </div>
   <!-- </div> -->
  </div>
  <div class="navbar-menu container">
   <div class="navbar-menu--list">
    <div class="navbar-menu--logo">
     <!-- <a href="<?php echo zen_href_link('/'); ?>">Watxh</a> -->

     <!-- logo -->
     <?php echo '<a id="logo" href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . 'Watxh' . '</a>'; ?>
     <!-- end/logo -->
    </div>
    <ul class="navbar-menu--items">
     <div id="close-icon" class="navbar-menu--close"><img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/close-icon.svg'; ?>" alt="" /></div>
     <li>
      <p id="brand-dropdown">Brand <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg'; ?>" alt="" /></p>
      <?php
        $mq = $db->Execute("SELECT m.manufacturers_id, m.manufacturers_name, COUNT(p.products_id) as product_count FROM " . TABLE_MANUFACTURERS . " m INNER JOIN " . TABLE_PRODUCTS . " p ON m.manufacturers_id = p.manufacturers_id WHERE p.products_status = 1 GROUP BY m.manufacturers_id, m.manufacturers_name HAVING product_count > 0 ORDER BY m.manufacturers_name");

        $lifestyle_names = ['Apple', 'Samsung', 'Garmin', 'Fitbit', 'Amazfit', 'Huawei', 'Xiaomi', 'Honor'];
        $fashion_names = ['Citizen', 'Timex', 'Michael Kors', 'Guess', 'Fossil'];
        $lifestyle_brands = $fashion_brands = $other_brands = [];

        while (!$mq->EOF) {
            $bd = ['name' => $mq->fields['manufacturers_name'], 'url' => zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $mq->fields['manufacturers_id']), 'id' => $mq->fields['manufacturers_id'], 'count' => $mq->fields['product_count']];
            
            if (in_array($bd['name'], $lifestyle_names)) $lifestyle_brands[] = $bd;
            elseif (in_array($bd['name'], $fashion_names)) $fashion_brands[] = $bd;
            else $other_brands[] = $bd;
            
            $mq->MoveNext();
        }

        $lifestyle_brands = array_merge($lifestyle_brands, $other_brands);
      ?>

      <div class="navbar-menu--dropdown navbar-menu--brand hide">
       <div class="container">
        <div class="row">
         <div class="navbar-menu--dropdown--left">
          <div class="navbar-menu--dropdown--section">
           <h5>Lifestyle</h5>
           <hr />
           <ul class="navbar-menu--dropdown--lifestyle">
              <?php foreach ($lifestyle_brands as $brand) { ?>
              <li>
                  <a href="<?php echo $brand['url']; ?>">
                      <?php echo zen_output_string($brand['name']); ?>
                  </a>
              </li>
              <?php } ?>
          </ul>
          </div>
          <div class="navbar-menu--dropdown--section">
           <h5>Fashion</h5>
           <hr />
           <ul class="navbar-menu--dropdown--fashion">
              <?php foreach ($fashion_brands as $brand) { ?>
              <li>
                  <a href="<?php echo $brand['url']; ?>">
                      <?php echo zen_output_string($brand['name']); ?>
                  </a>
              </li>
              <?php } ?>
          </ul>
          </div>
         </div>

         <div class="navbar-menu--dropdown--right">
          <?php
            foreach ([169, 168] as $pid) {
                $pq = $db->Execute("SELECT pd.products_name, p.products_image FROM " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id WHERE p.products_id = $pid AND p.products_status = 1 AND pd.language_id = " . $_SESSION['languages_id']);
                if (!$pq->EOF) {
                    $purl = zen_href_link(zen_get_info_page($pid), 'products_id=' . $pid);
                    $pimg = DIR_WS_IMAGES . $pq->fields['products_image'];
                    $pname = zen_output_string($pq->fields['products_name']);
                    $pprice = zen_get_products_display_price($pid);
          ?>
          <div class="watch-card">
           <a href="<?php echo $purl; ?>">
            <img class="watch-card--image" src="<?php echo $pimg; ?>" alt="<?php echo $pname; ?>" />
            <p class="watch-card--title"><?php echo $pname; ?></p>
            <div class="watch-card--pricing">
             <p><?php echo $pprice; ?></p>
             <p>5.0 <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg'; ?>" alt="" /></p>
            </div>
           </a>
          </div>
          <?php }} ?>
         </div>

        </div>
       </div>
      </div>
     </li>
     <li>
      <p id="watch-dropdown">
       Show Watches
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg'; ?>" alt="/" />
      </p>
      <div class="navbar-menu--dropdown navbar-menu--watch hide">
       <div class="container">
        <div class="row">
         <div class="navbar-menu--dropdown--left">
          <div class="navbar-menu--dropdown--section">
           <h5>Shop By Gender</h5>
           <hr />
           <ul class="navbar-menu--dropdown--gender">
            <li>
                <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=22'); ?>">Men Watches</a>
            </li>
            <li>
                <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=23'); ?>">Women Watches</a>
            </li>
            <li>
                <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=28'); ?>">Unisex Watches</a>
            </li>
           </ul>
          </div>
          <?php
            $fbq = $db->Execute("SELECT m.manufacturers_id, m.manufacturers_name, COUNT(p.products_id) as product_count FROM " . TABLE_MANUFACTURERS . " m INNER JOIN " . TABLE_PRODUCTS . " p ON m.manufacturers_id = p.manufacturers_id WHERE p.products_status = 1 GROUP BY m.manufacturers_id, m.manufacturers_name HAVING product_count > 0 ORDER BY product_count DESC, m.manufacturers_name LIMIT 20");

            $featured_brands = [];
            while (!$fbq->EOF) {
                $featured_brands[] = ['name' => $fbq->fields['manufacturers_name'], 'url' => zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $fbq->fields['manufacturers_id']), 'count' => $fbq->fields['product_count']];
                $fbq->MoveNext();
            }
          ?>

            <div class="navbar-menu--dropdown--section">
                <h5>Featured Brands</h5>
                <hr />
                <ul class="navbar-menu--dropdown--brands">
                    <?php foreach ($featured_brands as $brand) { ?>
                    <li>
                        <a href="<?php echo $brand['url']; ?>">
                            <?php echo zen_output_string($brand['name']); ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
         </div>

         <div class="navbar-menu--dropdown--right">
          <?php
            foreach ([169, 168] as $pid) {
                $pq = $db->Execute("SELECT pd.products_name, p.products_image FROM " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id WHERE p.products_id = $pid AND p.products_status = 1 AND pd.language_id = " . $_SESSION['languages_id']);
                if (!$pq->EOF) {
                    $purl = zen_href_link(zen_get_info_page($pid), 'products_id=' . $pid);
                    $pimg = DIR_WS_IMAGES . $pq->fields['products_image'];
                    $pname = zen_output_string($pq->fields['products_name']);
                    $pprice = zen_get_products_display_price($pid);
          ?>
          <div class="watch-card">
           <a href="<?php echo $purl; ?>">
            <img class="watch-card--image" src="<?php echo $pimg; ?>" alt="<?php echo $pname; ?>" />
            <p class="watch-card--title"><?php echo $pname; ?></p>
            <div class="watch-card--pricing">
             <p><?php echo $pprice; ?></p>
             <p>5.0 <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg'; ?>" alt="" /></p>
            </div>
           </a>
          </div>
          <?php }} ?>
         </div>
         
        </div>
       </div>
      </div>
     </li>
     <li>
      <p>Sale</p>
     </li>
     <li>
      <p><a href="<?php echo zen_href_link(FILENAME_ABOUT_US, '', 'NONSSL'); ?>">About</a></p>
     </li>
     <li>
      <p>Blog</p>
     </li>
     <li>
      <hr />

      <?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id']) { ?>
      <a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/user-icon.svg' ?>" alt="user-icon" />
       <p>My Account</p>
      </a>
      <a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/logout-icon.svg' ?>" alt="user-icon" />
       <p>Log Out</p>
      </a>
      <?php } ?>

      <a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/user-icon.svg'; ?>" alt="user-icon" />
       <p>Log In</p>
      </a>
     </li>
    </ul>
   </div>

   <div class="navbar-menu--other">
    <!-- <div class="navbar-menu--search">
     <div class="input-group">
      <input type="text" class="form-control" placeholder="Search..." />
      <button type="button"><img src="<?php //echo DIR_WS_TEMPLATE . 'images/watxh-icons/search-icon-white.svg'; ?>" /></button>
     </div>
    </div> -->
    <div class="navbar-menu--search">
      <div class="input-group">
        <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
      </div>
    </div>

    <div class="navbar-menu--icons">
     <!--  -->

     <div class="navbar-menu--icons--user">

     <?php if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id']) { ?>
      <a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>">
       <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/user-icon.svg'; ?>" alt="user-icon" />
      </a>
      <?php } ?>



      <?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id']) { ?>
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/user-icon.svg'; ?>" alt="user-icon" id="user-dropdown" />
      <ul class=" navbar-menu--user hide">
       <li>
        <a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>">
         <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/user-icon.svg' ?>" alt="user-icon" />
         <p>My Account</p>
        </a>
       </li>
       <li>
        <a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>">
         <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/logout-icon.svg' ?>" alt="user-icon" />
         <p>Log Out</p>
        </a>
       </li>
      </ul>
      <?php } ?>
     </div>
     <div class="navbar-menu--icons--search">
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/search-icon.svg'; ?>" alt="menu-icon" />
     </div>
     <div class="navbar-menu--icons--cart" id="cart-sidebar">
      <div class="badge">
       <label>
        <?php  if (isset($_SESSION['cart'])) {
        $totalItemsInCart = $_SESSION['cart']->count_contents();
        echo $totalItemsInCart;
    
  
    }?>
       </label>
      </div>
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg'; ?>" alt="cart-icon" />
     </div>
     <div id="menu-icon" class="navbar-menu--icons--menu">
      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/menu-icon.svg' ?>" alt="search-icon" />
     </div>
     <!--  -->
    </div>
   </div>
  </div>

  <div class="navbar-search-container">
    <div class="container">
      <div class="navbar-search-header">
        <a class="navbar-search-logo" href="https://devdemos.numinix.com/watxh_zc/">Watxh</a>
        <!-- <form name="search" class="navbar-search-form">
          <div class="form-control">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">
              <img src="includes/templates/watxh_zc/images/watxh-icons/search-icon-white.svg">
            </button>
          </div>
          <span class="navbar-close-icon">&times;</span>
        </form> -->
         <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
      </div>

      <div class="navbar-searh-products">
        <h3>Top searched</h3>
        <div class="navbar-search-products-container">
          <div class="watch-card">
            <a href="/watxh_zc/index.php?main_page=product_info&products_id=195">
              <div class="watch-card--image">
                <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/product-search-1-1.jpg" alt="Amazfit Halo">
                <div class="watch-card--icons">
                  <form class="watch-card--form" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=product_info&action=add_product&zenid=8fc9bf972d03e4e9ec2c438d5e14978e" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="securityToken" value="3c3295027804705df3a957c3f1352db3">
                    <input type="hidden" name="products_id" value="195">  
                    <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                    <button type="submit" class="watch-card--cart">
                      <img src="includes/templates/watxh_zc/images/watxh-icons/cart-icon.svg" alt="Add to Cart" title=" Add to Cart ">
                    </button>
                  </form>
                  <div class="watch-card--preview"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-preview.svg" alt=""></div>
                  <div class="watch-card--like"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-heart.svg" alt=""></div>
                </div>
              </div>
              <p class="watch-card--title">Apple Watch Series 5</p>
              <div class="watch-card--pricing">
                <p>$315.00</p>
                <p class="watch-card--rating"><span>5.0</span> <img src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt=""></p>
              </div>
            </a>
          </div>

          <div class="watch-card">
            <a href="/watxh_zc/index.php?main_page=product_info&products_id=195">
              <div class="watch-card--image">
                <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/product-search-2-1.jpg" alt="Amazfit Halo">
                <div class="watch-card--icons">
                  <form class="watch-card--form" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=product_info&action=add_product&zenid=8fc9bf972d03e4e9ec2c438d5e14978e" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="securityToken" value="3c3295027804705df3a957c3f1352db3">
                    <input type="hidden" name="products_id" value="195">  
                    <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                    <button type="submit" class="watch-card--cart">
                      <img src="includes/templates/watxh_zc/images/watxh-icons/cart-icon.svg" alt="Add to Cart" title=" Add to Cart ">
                    </button>
                  </form>
                  <div class="watch-card--preview"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-preview.svg" alt=""></div>
                  <div class="watch-card--like"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-heart.svg" alt=""></div>
                </div>
              </div>
              <p class="watch-card--title">Fitbit Versa 2</p>
              <div class="watch-card--pricing">
                <p>$129.94</p>
                <p class="watch-card--rating"><span>5.0</span> <img src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt=""></p>
              </div>
            </a>
          </div>

          <div class="watch-card">
            <a href="/watxh_zc/index.php?main_page=product_info&products_id=195">
              <div class="watch-card--image">
                <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/product-search-3-1.jpg" alt="Amazfit Halo">
                <div class="watch-card--icons">
                  <form class="watch-card--form" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=product_info&action=add_product&zenid=8fc9bf972d03e4e9ec2c438d5e14978e" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="securityToken" value="3c3295027804705df3a957c3f1352db3">
                    <input type="hidden" name="products_id" value="195">  
                    <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                    <button type="submit" class="watch-card--cart">
                      <img src="includes/templates/watxh_zc/images/watxh-icons/cart-icon.svg" alt="Add to Cart" title=" Add to Cart ">
                    </button>
                  </form>
                  <div class="watch-card--preview"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-preview.svg" alt=""></div>
                  <div class="watch-card--like"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-heart.svg" alt=""></div>
                </div>
              </div>
              <p class="watch-card--title">Citizen CZ Smart</p>
              <div class="watch-card--pricing">
                <p>$315.00 <del>$395.00</del></p>
                <p class="watch-card--rating"><span>5.0</span> <img src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt=""></p>
              </div>
            </a>
          </div>

          <div class="watch-card">
            <a href="/watxh_zc/index.php?main_page=product_info&products_id=195">
              <div class="watch-card--image">
                <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/product-search-4-1.jpg" alt="Amazfit Halo">
                <div class="watch-card--icons">
                  <form class="watch-card--form" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=product_info&action=add_product&zenid=8fc9bf972d03e4e9ec2c438d5e14978e" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="securityToken" value="3c3295027804705df3a957c3f1352db3">
                    <input type="hidden" name="products_id" value="195">  
                    <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                    <button type="submit" class="watch-card--cart">
                      <img src="includes/templates/watxh_zc/images/watxh-icons/cart-icon.svg" alt="Add to Cart" title=" Add to Cart ">
                    </button>
                  </form>
                  <div class="watch-card--preview"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-preview.svg" alt=""></div>
                  <div class="watch-card--like"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-heart.svg" alt=""></div>
                </div>
              </div>
              <p class="watch-card--title">Apple Watch SE</p>
              <div class="watch-card--pricing">
                <p>$299.00</p>
                <p class="watch-card--rating"><span>5.0</span> <img src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt=""></p>
              </div>
            </a>
          </div>

          <div class="watch-card">
            <a href="/watxh_zc/index.php?main_page=product_info&products_id=195">
              <div class="watch-card--image">
                <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/product-search-5-1.jpg" alt="Amazfit Halo">
                <div class="watch-card--icons">
                  <form class="watch-card--form" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=product_info&action=add_product&zenid=8fc9bf972d03e4e9ec2c438d5e14978e" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="securityToken" value="3c3295027804705df3a957c3f1352db3">
                    <input type="hidden" name="products_id" value="195">  
                    <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                    <button type="submit" class="watch-card--cart">
                      <img src="includes/templates/watxh_zc/images/watxh-icons/cart-icon.svg" alt="Add to Cart" title=" Add to Cart ">
                    </button>
                  </form>
                  <div class="watch-card--preview"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-preview.svg" alt=""></div>
                  <div class="watch-card--like"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-heart.svg" alt=""></div>
                </div>
              </div>
              <p class="watch-card--title">SAMSUNG Galaxy Watch</p>
              <div class="watch-card--pricing">
                <p>$99.99</p>
                <p class="watch-card--rating"><span>5.0</span> <img src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt=""></p>
              </div>
            </a>
          </div>

          <div class="watch-card">
            <a href="/watxh_zc/index.php?main_page=product_info&products_id=195">
              <div class="watch-card--image">
                <img src="<?php echo DIR_WS_TEMPLATE; ?>images/watxh-pictures/product-search-6-1.jpg" alt="Amazfit Halo">
                <div class="watch-card--icons">
                  <form class="watch-card--form" action="https://devdemos.numinix.com/watxh_zc/index.php?main_page=product_info&action=add_product&zenid=8fc9bf972d03e4e9ec2c438d5e14978e" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="securityToken" value="3c3295027804705df3a957c3f1352db3">
                    <input type="hidden" name="products_id" value="195">  
                    <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                    <button type="submit" class="watch-card--cart">
                      <img src="includes/templates/watxh_zc/images/watxh-icons/cart-icon.svg" alt="Add to Cart" title=" Add to Cart ">
                    </button>
                  </form>
                  <div class="watch-card--preview"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-preview.svg" alt=""></div>
                  <div class="watch-card--like"><img src="includes/templates/watxh_zc/images/watxh-icons/icon-heart.svg" alt=""></div>
                </div>
              </div>
              <p class="watch-card--title">HUAWAI Band 6</p>
              <div class="watch-card--pricing">
                <p>$69.99</p>
                <p class="watch-card--rating"><span>5.0</span> <img src="includes/templates/watxh_zc/images/watxh-icons/rating-icon.svg" alt=""></p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
 </nav>


 <div class="cart-modal navbar-menu--cart hide">

  <div class="container">

   <header class="sub-heading row">
    <h3>Shopping Cart</h3>
    <button id="cart-button">
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/close-icon.svg' ?>" alt="" />
     </butto>
   </header>

    <?php
      if (isset($_SESSION['cart']) && method_exists($_SESSION['cart'], 'get_products')) {
        $cart_products = $_SESSION['cart']->get_products();
    ?>
    <?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type)); ?>
    <div class="cart-main">
      <div class="cart-header">
        <ul>
          <li>Items</li>
          <li>Price</li>
          <li>Quantity</li>
          <li>Total</li>
        </ul>
      </div>
      <?php
        if (!empty($cart_products)) {
            $final_total = 0;
            foreach ($cart_products as $product) {
              $product_id = (int)$product['id'];
              $product_url = zen_href_link(zen_get_info_page($product_id), 'products_id=' . $product_id);
              $product_image_url = DIR_WS_IMAGES . $product['image'];
              $product_image = '<img src="' . htmlspecialchars($product_image_url) . '" alt="' . htmlspecialchars($product['name']) . '" width="50" height="50">';
              $price = $product['final_price'];
              $total_price = (int)$product['quantity'] * $price;
              $final_total += $total_price;
          ?>
             <div class="cart-card" id="cart-card_<?php echo $product_id; ?>">
              <div class="cart-items">
                <div class="cart-image">
                  <div class="cart-badge">
                    <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>">
                      <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/close-white-icon.svg' ?>" alt="" />
                    </a>
                  </div>

                  <a href="<?php echo htmlspecialchars($product_url); ?>"><?php echo $product_image; ?></a>
                </div>
                <div class=" cart-text">
                  <p> <?php echo htmlspecialchars($product['name']) . 
                  (isset($product['flagStockCheck']) ? '<span class="alert bold">' . $product['flagStockCheck'] . '</span>' : ''); ?></p>
                  <p>Color: <strong>Blue</strong></p>
                </div>
              </div>
              <div class="cart-price">
                <p> <?php echo $currencies->format($price); ?></p>
              </div>
              <div class="quantity">
                <?php      
                  echo '<span class="quantity-decrease mini-cart-qty-update" data-value="'. $price .'" data-pid="'. $product_id .'">
                          <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/minus-icon.svg" alt="" />
                        </span>
                        <input type="number" class="quantity-value mini-cart-input" name="cart_quantity" value="' . (int)$product['quantity'] . '" disabled/>
                        <span class="quantity-increase mini-cart-qty-update" data-value="'. $price .'" data-pid="'. $product_id .'">
                          <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/plus-icon.svg" alt="" />
                        </span>';
                ?>
                <!-- <span class="quantity-increase"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/plus-icon.svg" alt="" /></span> -->
              </div>
              <div class="cart-price cart-price-total">
                <p><?php echo $currencies->format($total_price); ?></p>
              </div>
            </div>
            
        <?php } ?>
        </div>

        <div class="cart-total mini-cart-total-final" data-final="<?php echo $final_total; ?>">
          <p>Total:</p>
          <h3>$<?php echo $final_total; ?></h3>
        </div>

        <div class="cart-form">
          <div class="cart-footer">
            <p>Special instructions for the seller</p>
            <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-right-icon.svg' ?>" alt="" />
          </div>
          <button>View Cart</button>
        </div>

        </form>
      <?php 
        } else { 
      ?>
        <div class="cart-empty">
          <div class="cart-empty--image">
          <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/cart-empty.png' ?>" alt="" />
          </div>
          <div class="cart-empty--text">
          <p>Your cart is currently empty.</p>
          <p>Looks like you have not added anything to your cart. Go ahead and explore top categories.</p>
          <button>Shop Now</button>
          </div>
        </div>
      <?php
        }
      } else {
          echo '<p>Cart not available.</p>';
      }
    ?>

    <?php
    /**
     * Start: Old mini cart (removed as it doesn't work properly)
     */
    $is_old_minicart_used = false;
    if($is_old_minicart_used) :
      if ($_SESSION['cart']->count_contents() > 0) {
    ?>
   <?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type)); ?>
   <div class="cart-main">
    <div class="cart-header">
     <ul>
      <li>Items</li>
      <li>Price</li>
      <li>Quantity</li>
      <li>Total</li>
     </ul>
    </div>
    <?php foreach ($productArray as $product) { ?>
    <div class="cart-card">
     <div class="cart-items">
      <div class="cart-image">
       <div class="cart-badge">
        <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>">
         <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/close-white-icon.svg' ?>" alt="" />
        </a>
       </div>

       <a href="<?php echo $product['linkProductsName']; ?>"><?php echo $product['productsImage']; ?></a>
      </div>
      <div class=" cart-text">
       <p> <?php echo $product['productsName'] . '<span class="alert bold">' . $product['flagStockCheck'] . '</span>'; ?></p>
       <p>Color: <strong>Blue</strong></p>
      </div>
     </div>
     <div class="cart-price">
      <p> <?php echo $product['productsPriceEach']; ?></p>
     </div>
     <div class="quantity">
      <?php
                    if ($product['flagShowFixedQuantity']) {
                      echo '<span class="quantity-decrease"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/minus-icon.svg" alt="" /></span><input type="number" class="quantity-value" name="cart_quantity" value="' . $product['showFixedQuantityAmount'] . '" disabled/><span class="quantity-increase"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/plus-icon.svg" alt="" /></span>' . '<span style="display: none;" class="alert bold">' . $product['flagStockCheck'] . '</span>' . $product['showMinUnits'];
                    } else {
                      echo '<span class="quantity-decrease"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/minus-icon.svg" alt="" /></span><input type="number" class="quantity-value" name="cart_quantity" value="' . $product['showFixedQuantityAmount'] . '" disabled/><span class="quantity-increase"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/plus-icon.svg" alt="" /></span><span style="display: none;" class="alert bold">' . $product['flagStockCheck'] . '</span>' . $product['showMinUnits'];
                    }
                    ?>
      <!-- <span class="quantity-increase"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/plus-icon.svg" alt="" /></span> -->
     </div>
     <div class="cart-price">
      <p>
       <?php echo $product['productsPrice']; ?>
      </p>
     </div>
    </div>
    <?php } ?>
   </div>

   <div class="cart-total">
    <p>Total:</p>
    <h3>
     <?php echo $cartShowTotal; ?></h3>
   </div>

   <div class="cart-form" action="">
    <div class="cart-footer">
     <p>Special instructions for the seller</p>
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-right-icon.svg' ?>" alt="" />
    </div>
    <button>View Cart</button>
   </div>

   </form>

   <?php } else { ?>

   <div class="cart-empty">
    <div class="cart-empty--image">
     <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/cart-empty.png' ?>" alt="" />
    </div>
    <div class="cart-empty--text">
     <p>Your cart is currently empty.</p>
     <p>Looks like you have not added anything to your cart. Go ahead and explore top categories.</p>
     <button>Shop Now</button>
    </div>
   </div>

   <?php } 
   
   endif;
   /**
     * End: Old mini cart
     */
   ?>


  </div>
 </div>


</div>
<?php
    $nmx_disk_cache->cacheEnd();
  }
  ?>


<!--bof contact us popup-->
<?php require($template->get_template_dir('tpl_modules_contact_us_popup.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_contact_us_popup.php'); ?>
<!--eof contact us popup-->

<?php } ?>