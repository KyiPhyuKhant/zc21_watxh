<?php

/**
 * Common Template - tpl_main_page.php
 *
 * Governs the overall layout of an entire page<br />
 * Normally consisting of a header, left side column. center column. right side column and footer<br />
 * For customizing, this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * - make a directory /templates/my_template/privacy<br />
 * - copy /templates/templates_defaults/common/tpl_main_page.php to /templates/my_template/privacy/tpl_main_page.php<br />
 * <br />
 * to override the global settings and turn off columns un-comment the lines below for the correct column to turn off<br />
 * to turn off the header and/or footer uncomment the lines below<br />
 * Note: header can be disabled in the tpl_header.php<br />
 * Note: footer can be disabled in the tpl_footer.php<br />
 * <br />
 * $flag_disable_header = true;<br />
 * $flag_disable_left = true;<br />
 * $flag_disable_right = true;<br />
 * $flag_disable_footer = true;<br />
 * <br />
 * // example to not display right column on main page when Always Show Categories is OFF<br />
 * <br />
 * if ($current_page_base == 'index' and $cPath == '') {<br />
 *  $flag_disable_right = true;<br />
 * }<br />
 * <br />
 * example to not display right column on main page when Always Show Categories is ON and set to categories_id 3<br />
 * <br />
 * if ($current_page_base == 'index' and $cPath == '' or $cPath == '3') {<br />
 *  $flag_disable_right = true;<br />
 * }<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_main_page.php 7085 2007-09-22 04:56:31Z ajeh $
 */

// the following IF statement can be duplicated/modified as needed to set additional flags
if ($this_is_home_page || in_array($current_page_base, explode(",", 'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces'))) {
	$flag_disable_right = true;
}


if ((((isset($_GET['cPath']) && $_GET['cPath'] != '') || (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0)) && $_GET['main_page'] == FILENAME_DEFAULT) || (in_array($_GET['main_page'], array(FILENAME_ADVANCED_SEARCH_RESULT, FILENAME_SPECIALS, FILENAME_FEATURED_PRODUCTS, FILENAME_PRODUCTS_NEW, FILENAME_PRODUCTS_ALL, FILENAME_BEST_SELLERS)))) {
	$flag_disable_left = false;
	$flag_disable_right = false;
} else {
	$flag_disable_left = true;
	$flag_disable_right = true;
}

$header_template = 'tpl_header.php';
$footer_template = 'tpl_footer.php';
$left_column_file = 'column_left.php';
$right_column_file = 'column_right.php';
$body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
?>

<body id="<?php echo $body_id . 'Body'; ?>" <?php if ($zv_onload != '') echo ' onload="' . $zv_onload . '"'; ?>>
 <?php
	if (SHOW_BANNERS_GROUP_SET1 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET1)) {
		if ($banner->RecordCount() > 0) {
	?>
 <div id="bannerOne" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
 <?php
		}
	}
	?>
 <div>



  <?php
		/**
		 * prepares and displays header output
		 *
		 */
		if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
			$flag_disable_header = true;
		}
		require($template->get_template_dir('tpl_header.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_header.php'); ?>

  <!-- <div id="contentMainWrapper" <?php if ($this_is_home_page) { ?><?php } else { ?>class="content-wrapper" <?php } ?>>
   <?php
			// if (TABLEAU_SOCIAL_ICONS == "true") {
			?>
   <ul class="social-links">
    <?php
				// echo (TABLEAU_FACEBOOK_URL != '' ? '<li class="is-facebook"><a href="' . TABLEAU_FACEBOOK_URL . '">Facebook</a></li>' : '');
				// echo (TABLEAU_TWITTER_URL != '' ? '<li class="is-twitter"><a href="' . TABLEAU_TWITTER_URL . '">Twitter</a></li>' : '');
				// echo (TABLEAU_GOOGLE_PLUS_URL != '' ? '<li class="is-gplus"><a href="' . TABLEAU_GOOGLE_PLUS_URL . '">Google Plus</a></li>' : '');
				// echo (TABLEAU_YOUTUBE_URL != '' ? '<li class="is-youtube"><a href="' . TABLEAU_YOUTUBE_URL . '">YouTube</a></li>' : '');
				// echo (TABLEAU_BLOG_URL != '' ? '<li class="is-rss"><a href="' . TABLEAU_BLOG_URL . '">Blog</a></li>' : '');
				?>
   </ul>
   <?php
			// }
			?> -->
  <!--BOF PRODUCT LISTING-->
  <?php
    $categories_id = 0; // Initialize with default value
		if (isset($_GET['cPath']) && $_GET['main_page'] == FILENAME_DEFAULT) {
			$cPath_array = explode('_', $_GET['cPath']);
			$categories_id = $cPath_array[sizeof($cPath_array) - 1];
		?>
  <!--BOF Category Image-->
  <?php
			if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS == 'true') {
				if ($categories_image = zen_get_categories_image($current_category_id)) {
			?>

  <header class="header product-listing-heading">
   <div class="header-listing">
    <div class="container">
     <div class="header-listing--text">
      <h2>
       <?php echo $breadcrumb->last(); ?>
      </h2>
      <p>
      </p>
     </div>
    </div>
    <div class="header-listing--image">
     <?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT); ?>
    </div>
   </div>
  </header>
  <?php
				}
			}
			?>
  <!--EOF Category Image-->
  <?php } ?>
  <!--EOF PRODUCT LISTING-->

  <!--BOF PRODUCT PAGE-->
  <?php
		if ($_GET['main_page'] != FILENAME_DEFAULT) {
		?>
  <div class="">
   <?php } ?>
   <!--EOF PRODUCT PAGE-->

   <?php if ((((isset($_GET['cPath']) && $_GET['cPath'] != '') || (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0)) && $_GET['main_page'] == FILENAME_DEFAULT) || (in_array($_GET['main_page'], array(FILENAME_ADVANCED_SEARCH_RESULT, FILENAME_SPECIALS, FILENAME_FEATURED_PRODUCTS, FILENAME_PRODUCTS_NEW, FILENAME_PRODUCTS_ALL, FILENAME_BEST_SELLERS)))) { ?>


   <section class="product" id="product-listing-<?php echo $categories_id; ?>">

    <?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING)); ?>
    <div class="container">
     <div class="product-filter row">
      <p><?php echo $listing_split->number_of_rows;	?> <?php echo $listing_split->number_of_rows > 0 ? 'products' : 'product'; ?></p>
      <div class="product-filter-sort row">
        <div class="product-filter-sort-container">
          <div id="filter-button-mb">
            Filter
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
              <rect y="0.75" width="14" height="1.5" fill="black"/>
              <rect x="1.5" y="5.25" width="11" height="1.5" fill="black"/>
              <rect x="2.5" y="9.75" width="9" height="1.5" fill="black"/>
            </svg>
          </div>
          <?php echo zen_draw_form('sortbyform',
              zen_href_link($_GET['main_page'], zen_get_all_get_params(), $request_type, false),
              'get') . zen_hide_session_id(); ?>

          <?php
            // only keep valid “key=value” pairs for hidden fields
            $rawParams = zen_get_all_get_params(['sortby']);
            if ($rawParams) {
              $pairs = explode('&', $rawParams);
              foreach ($pairs as $pair) {
                if (!str_contains($pair, '=')) {
                  continue;
                }
                list($k, $v) = explode('=', $pair, 2);
                echo zen_draw_hidden_field(urldecode($k), urldecode($v));
              }
            }
          ?>

          <div class="input-group">
            <label>Sort By:</label>
            <?php
              $sortby_array = array(
                array('id' => 0, 'text' => 'Default'),
                array('id' => 1, 'text' => 'Newest First'),
                array('id' => 2, 'text' => 'Most Popular'),
                array('id' => 3, 'text' => 'Price (High to Low)'),
                array('id' => 4, 'text' => 'Price (Low to High)'),
                array('id' => 5, 'text' => 'Name (A-Z)'),
                array('id' => 6, 'text' => 'Name (Z-A)'),
              );

              $current_sort = isset($_GET['sortby']) ? (int)$_GET['sortby'] : 0;
              echo zen_draw_pull_down_menu(
                'sortby',
                $sortby_array,
                $current_sort,
                'onchange="this.form.submit();"'
              );
            ?>
          </div>
          <div id="sorting-dropdown-mb">
              <span>
                Sort
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                  <rect y="0.75" width="14" height="1.5" fill="black"/>
                  <rect y="5.25" width="11" height="1.5" fill="black"/>
                  <rect y="9.75" width="9" height="1.5" fill="black"/>
                </svg>
              </span>
              <ul class="sorting-dropdown-menu">
                <?php
                  foreach ($sortby_array as $item) {
                    echo '<li class="sorting-dropdown-item" data-id="' . $item['id'] . '" data-value="' . $item['text'] . '">' . $item['text'] . '</li>' . PHP_EOL;
                  }
                ?>
              </ul>
          </div>
          <?php echo '</form>'; ?>
        </div>
       <!-- <form name="sortbyform" action="">
        <div class="input-group">
         <label for="">Sort By:</label>
         <select name="" id="">
          <option value="">Featured</option>
          <option value=""></option>
          <option value=""></option>
          <option value=""></option>
          <option value=""></option>
         </select>
        </div>
       </form> -->
       <div class="product-filter-view row">
        <button class="product-filter-btn active" data-type="grid">
         <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/view-grid-icon.svg'; ?>" />
        </button>
        <button class="product-filter-btn" data-type="list">
         <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/view-column-icon.svg' ?>" />
        </button>
       </div>
      </div>
     </div>
     <div class="product-row row">

      <!-- <div class="product-listing-header"> -->

      <?php } ?>
      <!-- bof  breadcrumb -->
      <?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page && !in_array($current_page_base, explode(",", 'login,create_account,conditions,privacy,about_us,page_not_found,faqs,account,address_book,address_book_process,password_forgotten,index,cPath,shopping_cart,checkout_shipping,checkout_payment')))) { ?>
      <?php if($_GET['main_page'] != 'index' && $_GET['main_page'] != 'checkout_success'): ?>
      <div id="navBreadCrumb"></div>
      <div class="breadcrumb">
       <div class="container">
        <p>
         <!-- <a href="">Home</a> > <a href="">Featured </a> >
         <a href=""> CZ Smart Stainless Steel Smartwatch Touchscreen</a> -->
         <?php echo $breadcrumb->trail('&nbsp; &rsaquo; &nbsp;'); ?>
        </p>
       </div>
      </div>
      <?php endif; ?>
      
      <?php } ?>
      <!-- eof breadcrumb -->
      <!-- <div class="clearBoth"></div> -->
      <?php if ((((isset($_GET['cPath']) && $_GET['cPath'] != '') || (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0)) && $_GET['main_page'] == FILENAME_DEFAULT) || (in_array($_GET['main_page'], array(FILENAME_SPECIALS, FILENAME_FEATURED_PRODUCTS, FILENAME_PRODUCTS_NEW, FILENAME_PRODUCTS_ALL, FILENAME_BEST_SELLERS)))) { ?>
      <!-- <h1 id="productListHeading"><?php echo $breadcrumb->last(); ?></h1> -->
      <?php
						}
						?>
      <?php if ($_GET['main_page'] == FILENAME_ADVANCED_SEARCH_RESULT) { ?>
      <h1 id="advSearchResultsDefaultHeading"><?php echo HEADING_TITLE; ?></h1>
      <?php } ?>

      <?php if ((((isset($_GET['cPath']) && $_GET['cPath'] != '') || (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0)) && $_GET['main_page'] == FILENAME_DEFAULT) || (in_array($_GET['main_page'], array(FILENAME_ADVANCED_SEARCH_RESULT, FILENAME_SPECIALS, FILENAME_FEATURED_PRODUCTS, FILENAME_PRODUCTS_NEW, FILENAME_PRODUCTS_ALL, FILENAME_BEST_SELLERS)))) { ?>

      <!-- </div> -->
      <?php } ?>

      <?php
						if (COLUMN_LEFT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
							// global disable of column_left
							$flag_disable_left = true;
						}
						if (!isset($flag_disable_left) || !$flag_disable_left) {
						?>

      <div id="navColumnOne" class="product-sidebar">
        <div class="sidebar-filter-mb">
          <span>
            Filter 
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
              <rect y="0.75" width="14" height="1.5" fill="black"/>
              <rect x="1.5" y="5.25" width="11" height="1.5" fill="black"/>
              <rect x="2.5" y="9.75" width="9" height="1.5" fill="black"/>
            </svg>
          </span>

          <svg id="sidebar-filter-mb-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M11.4138 9.99997L17.7069 3.70697C17.8944 3.51946 17.9997 3.26515 17.9997 2.99997C17.9997 2.73479 17.8944 2.48048 17.7069 2.29297C17.5193 2.10546 17.265 2.00012 16.9998 2.00012C16.7347 2.00012 16.4804 2.10546 16.2928 2.29297L9.99985 8.58597L3.70685 2.29297C3.614 2.20013 3.50378 2.12648 3.38247 2.07623C3.26117 2.02598 3.13115 2.00012 2.99985 2.00012C2.86855 2.00012 2.73853 2.02598 2.61722 2.07623C2.49592 2.12648 2.38569 2.20013 2.29285 2.29297C2.10534 2.48048 2 2.73479 2 2.99997C2 3.26515 2.10534 3.51946 2.29285 3.70697L8.58585 9.99997L2.29285 16.293C2.10534 16.4805 2 16.7348 2 17C2 17.2651 2.10534 17.5195 2.29285 17.707C2.48036 17.8945 2.73467 17.9998 2.99985 17.9998C3.26503 17.9998 3.51934 17.8945 3.70685 17.707L9.99985 11.414L16.2928 17.707C16.3855 17.8002 16.4957 17.8741 16.617 17.9246C16.7383 17.975 16.8684 18.001 16.9998 18.001C17.1313 18.001 17.2614 17.975 17.3827 17.9246C17.504 17.8741 17.6142 17.8002 17.7069 17.707C17.7998 17.6142 17.8735 17.504 17.9238 17.3827C17.9742 17.2613 18 17.1313 18 17C18 16.8686 17.9742 16.7386 17.9238 16.6173C17.8735 16.496 17.7998 16.3858 17.7069 16.293L11.4138 9.99997Z" fill="#202223"/>
          </svg>
        </div>
        <!-- <span class="filter-results-title">Refine your results</span> -->
        <?php
								/**
								 * prepares and displays left column sideboxes
								 *
								 */
								?>
        <div id="navColumnOneWrapper">
            <?php require(DIR_WS_MODULES . zen_get_module_directory('column_left.php')); ?>
            <button id="reset-btn" type="button">Clear filters</button>
        </div>
      </div>
      <!--EOF #navColumnOne-->
      <?php } ?>

      <?php
        /**
         * prepares and displays center column
         *
         */
          if (isset($_GET['main_page']) && $_GET['main_page'] == 'product_info') {
            $old_error = error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
          }
          
          require($body_code);
          
          if (isset($old_error)) {
              error_reporting($old_error);
          }
      ?>

      <?php
						//if (COLUMN_RIGHT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF == 'true' && $_SESSION['customers_authorization'] != 0)) {
						if (COLUMN_RIGHT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
							// global disable of column_right
							$flag_disable_right = true;
						}
						if (!isset($flag_disable_right) || !$flag_disable_right) {
						?>

   
      <!--EOF #navColumnTwo-->
      <?php
						}
						?>
      <div class="clearBoth"></div>
      <?php
						if (isset($_GET['cPath']) && $_GET['main_page'] == FILENAME_DEFAULT) {
							$cPath_array = explode('_', $_GET['cPath']);
							echo '</div>';
						}
						?>
      <!--BOF PRODUCT PAGE-->
      <?php
						if ($_GET['main_page'] != FILENAME_DEFAULT) {
						?>
     </div>
     <?php } ?>
     <!--EOF PRODUCT PAGE-->
     <div class="clearBoth"></div>
    </div>
   </section>
   <?php
				/**
				 * prepares and displays footer output
				 *
				 */
				if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_FOOTER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
					$flag_disable_footer = true;
				}
				require($template->get_template_dir('tpl_footer.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_footer.php');
				?>
   <!--bof- parse time display -->
   <?php
				if (defined('DISPLAY_PAGE_PARSE_TIME') && DISPLAY_PAGE_PARSE_TIME == 'true') {
				?>
   <div class="smallText center">Parse Time: <?php echo $parse_time; ?> - Number of Queries: <?php echo $db->queryCount(); ?> - Query Time: <?php echo $db->queryTime(); ?></div>
   <?php
				}
				?>
  </div>
  <!--eof- parse time display -->
  <?php
/**
* load the loader JS files
*/
if(!empty($RC_loader_files)){
  foreach($RC_loader_files['css'] as $RC_order=>$file){
		if ($file['defer']) {
			if($file['include']) {
					include($file['src']);
			} else if (!$RI_CJLoader->get('minify_css') || (isset($file['external']) && $file['external'])) {
					//$link = $file['src'];
					echo '
					<script type="text/javascript" async>
						var elm = document.createElement("link");
						elm.rel = "stylesheet";
						elm.type = "text/css";
						elm.href = "'.$file['src'] .'";
						
						var links = document.getElementsByTagName("link")[0];
						links.parentNode.appendChild(elm);
					</script>';
			} else {
					//$link = 'min/?f='.$file['src'].'&'.$RI_CJLoader->get('minify_time');
					echo '
					<script type="text/javascript" async>
						var elm = document.createElement("link");
						elm.rel = "stylesheet";
						elm.type = "text/css";
						elm.href = "min/?f='.$file['src'].'&'.$RI_CJLoader->get('minify_time').'";
						
						var links = document.getElementsByTagName("link")[0];
						links.parentNode.appendChild(elm);
					</script>';
			}
		}
	}

  foreach($RC_loader_files['jscript'] as $file)
    if($file['include']) {
      include($file['src']);
    } else if(!$RI_CJLoader->get('minify_js') || (isset($file['external']) && $file['external'])) {
      echo '<script type="text/javascript" src="'.$file['src'].'"'.($file['defer'] ? ' defer async': '').'></script>'."\n";

    } else {
      echo '<script type="text/javascript" src="min/?f='.$file['src'].'&'.$RI_CJLoader->get('minify_time').'"'.($file['defer'] ? ' defer async': '').'></script>'."\n";
    }
}
//DEBUG: echo '';
?>
</body>