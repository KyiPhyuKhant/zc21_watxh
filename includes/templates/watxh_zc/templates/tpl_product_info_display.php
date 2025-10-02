<?php

/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 19690 2011-10-04 16:41:45Z drbyte $
 */
//require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
?>

<?php
global $db;
$current_product = (int)$_GET['products_id'];

$countQ      = "SELECT COUNT(*) AS total_reviews FROM reviews WHERE products_id = " . (int)$_GET['products_id'];
$countR      = $db->Execute($countQ);
$totalReviews = (int)$countR->fields['total_reviews'];

?>



<div class="product">
  <div class="container">
    <!--bof Form start-->
    <?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
    <!--eof Form start-->
    
    <?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>
    <?php
    if ($nmx_disk_cache->cacheStart('tpl_product_info_display', '', true, true)) {
    ?>
    
  <?php //} ?>
  <div class="product-single">
  <div class="row">
  <div class="product-view">
  <div class="product-view--side" id="">
  
  <?php
  /**
  * display the products additional images
  */
  require($template->get_template_dir('/tpl_modules_additional_images.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_additional_images.php'); ?>
  </div>
  <div class="product-view--main">
  <?php require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?>
  <?php
  echo  zen_image($products_image_medium, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT) /* . '</a>'*/;
  ?>
</div>
</div>
<div class="product-details">
  <div class="product-details--header">
    <label><?php echo $products_manufacturer; ?></label>
      <h5><?php echo $products_name; ?></h5>
      </div>
      <div class="product-details--rating">
        <div class="">
          <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg' ?>" alt="" />
            <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg' ?>" alt="" />
              <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg' ?>" alt="" />
                <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg' ?>" alt="" />
                  <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg' ?>" alt="" />
                  </div>
                  <?php
                  $reviews_count_query = "SELECT COUNT(*) AS review_count
                  FROM
                  reviews r
                  JOIN
                  reviews_description rd ON r.reviews_id = rd.reviews_id
                  JOIN
                  customers cu ON r.customers_id = cu.customers_id
                  JOIN
                  address_book ab ON cu.customers_id = ab.customers_id
                  WHERE
                  r.products_id = " . $current_product;
                  
                  $reviews_count = $db->Execute($reviews_count_query);
                  ?>
                  <p>(<?php echo $reviews_count->fields['review_count']; ?>)</p>
                </div>
                <div class="product-details--number">
                  <p><?php echo $products_model; ?></p>
                </div>
                <div class="product-details--pricing<?php echo (zen_has_product_specials($_GET['products_id'])) ? ' has-special' : ''; ?>">
                  
                  <p>
                  <?php
                  // base price
                  if ($show_onetime_charges_description == 'true') {
                    $one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span>';
                  } else {
                    $one_time = '';
                  }
                  // echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$_GET['products_id']);
                  echo $one_time . zen_get_products_display_price((int)$_GET['products_id']);
                  ?>
                </p>
              </div>
              <div class="product-details--type">
                <!-- <div class="horizontal-rule"></div> -->
                  <?php
                  if (isset($options_name) && is_array($options_name)) {
                    $attribute_name = 'Color';
                    $attributes_to_display_index = array_search($attribute_name, $options_name);
                    if ($attributes_to_display_index !== false) {
                      require($template->get_template_dir('/tpl_modules_attributes.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_attributes.php');
                    }
                  } else {
                    // Optional: Add alternate content or debug message
                    echo "No color options available for this product";
                  }
                  ?>
                </div>
                
                <div class="product-details--extra">
                  <!-- <div class="horizontal-rule"></div> -->
                    <?php
                    $attribute_name = 'Extra';
                    if (isset($options_name) && is_array($options_name)) {
                      $attributes_to_display_index = array_search($attribute_name, $options_name);
                      if ($attributes_to_display_index !== false) {
                        require($template->get_template_dir('/tpl_modules_attributes.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_attributes.php');
                      }
                    } else {
                      // Optional: Add alternate content or debug message
                      echo "No extra options available for this product";
                    }
                    ?>
                  </div>
                  <?php
                  if (CUSTOMERS_APPROVAL == 3 && TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
                    // do nothing
                  } else {
                    ?>
                    <?php
                    $display_qty = (($flag_show_product_info_in_cart_qty == 1 && $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
                    if ($products_qty_box_status == 0 || $products_quantity_order_max == 1) {
                      // hide the quantity box and default to 1
                      $the_button = '<input type="hidden" name="cart_quantity" value="1" /><span class="btn-add-cart">' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</span>';
                    } else {
                      // show the quantity box
                      $the_button = '<div class="product-details--quantity back">
                      <p>Quantity</p>
                      <div class="quantity">
                      <span class="quantity-decrease"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/minus-icon.svg" alt="" /></span>
                      <input type="number" class="quantity-value" name="cart_quantity" value="1" min="1" />
                      <span class="quantity-increase"><img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/plus-icon.svg" alt="" /></span>
                      </div>
                      </div>';
                    }
                    $display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
                    ?>
                    <?php
                    ?>
                    
                    <?php
                    // if (FACEBOOK_LIKE_BUTTON_STATUS == 'true' && $_SERVER['https'] != 'on') {
                    //   require($template->get_template_dir('tpl_modules_facebook_like_button.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_facebook_like_button.php');
                    // }
                    ?>
                    
                    <!-- Google +1 Button BEGIN -->
                    <?php
                    // if (GOOGLE_PLUS_ONE_ENABLED == 'true') {
                    //   require($template->get_template_dir('tpl_modules_google_plus_one.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_google_plus_one.php');
                    // }
                    ?>
                    <!-- Google +1 Button END -->
                    
                    
                    <!-- <div id="cartAdd" class="back"> -->
                    <?php echo $display_button; ?>
                    
                    <div class="product-details--button">
                    <!-- <span class="btn-add-cart"></span> -->
                    <input type="hidden" name="products_id" value="<?php echo (int)$_GET['products_id'] ?>">
                      <button type="submit" name="add_to_cart" value="1">Add to Cart</button>
                      <button type="submit" name="buy_now" value="1">Buy it Now</button>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="clearBoth"></div> -->
                  <?php } // display qty and button
                  ?>
                <?php //} // CUSTOMERS_APPROVAL == 3
                ?>
                
                
                
                <div class="product-details--accordion">
                  <div class="product-details--dropdown">
                    <header class="product-details--dropdown--header">
                      <h4>Description</h4>
                        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
                        </header>
                        <section class="product-details--dropdown--content">
                          <p>
                          <?php echo stripslashes($products_description); ?>
                          </p>
                          </section>
                          </div>
                          <div class="product-details--dropdown">
                          <header class="product-details--dropdown--header">
                          <h4>Specification</h4>
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
                          </header>
                          <section class="product-details--dropdown--content">
                          <ul>
                          <li><strong>Brand, Seller, or Collection Name:</strong> Citizen</li>
                          <li><strong>Model number: </strong> MX0002-52X</li>
                          <li><strong>Part Number:</strong> MX0002-52X</li>
                          <li><strong>Item Shape:</strong> Round</li>
                          <li><strong>Dial window material type:</strong> Glass</li>
                          <li><strong>Display Type:</strong> Digital</li>
                          <li><strong>Clasp:</strong> Deployant Clasp</li>
                          <li><strong>Case material:</strong> Stainless Steel</li>
                          <li><strong>Case diameter:</strong> 46 millimeters</li>
                          <li><strong>Case Thickness:</strong> 13 millimeters</li>
                          <li><strong>Band Material:</strong> Stainless Steel</li>
                          <li><strong>Band size:</strong> Mens Standard</li>
                          <li><strong>Band width:</strong> 22 millimeters</li>
                          <li><strong>Band Color:</strong> Gold</li>
                          <li><strong>Dial color:</strong> Black</li>
                          <li><strong>Bezel material:</strong> Stainless Steel</li>
                          <li><strong>Bezel function:</strong> Stationary</li>
                          <li><strong>Calendar:</strong> Day-Date-Month</li>
                          <li><strong>Special features:</strong> Speaker, Microphone, GPS, Heartrate, Stainless Steel</li>
                          <li><strong>Movement:</strong> Automatic</li>
                          <li><strong>Water resistant depth:</strong> 30 Meters</li>
                          <li>
                          <strong>Warranty:</strong> Manufacturer’s warranty can be requested from customer service.
                          Click <a href="#">here</a> to make a request to customer service.
                          </li>
                          </ul>
                          </section>
                          </div>
                          <div class="product-details--dropdown">
                          <header class="product-details--dropdown--header">
                          <h4>About</h4>
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
                          </header>
                          <section class="product-details--dropdown--content">
                          <ul>
                          <li><strong>Date First Available:</strong> October 7, 2021</li>
                          <li><strong>Manufacturer:</strong> CITIZEN</li>
                          <li><strong>ASIN:</strong> B09HYSM197</li>
                          <li><strong>#1,881 in Smartwatches</strong></li>
                          </ul>
                          </section>
                          </div>
                          <div class="product-details--dropdown">
                          <header class="product-details--dropdown--header">
                          <h4>FAQs</h4>
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/chevron-down-icon.svg' ?>" alt="" />
                          </header>
                          <section class="product-details--dropdown--content">
                          <p>
                          Smartwatch powered by Wear OS By Google is compatible with Iphone and Android: Preloaded apps
                          include Google Assistant, Google Pay, Google Fit, Google Play Store, Agenda, Alarm, Calendar,
                          Contacts, Stopwatch, Timer, Translate, Smart Battery Modes, Enhanced Phone Dialer App, Wellness
                          App with Sleep Tracking, Battery-Optimized Activity Mode, Cardio Level Tracking, Spotify, Strava
                          and Noonlight
                          </p>
                          </section>
                          </div>
                          </div>
                          </div>
                          </div>
                          
                          <div class="product-pictures">
                          <div class="product-gallery-container">
                          <div class="product-gallery-img">
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/products/feature-img01.jpg'; ?>" alt="product">
                          </div>
                          <div class="product-gallery-img">
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/products/feature-img02.jpg'; ?>" alt="product">
                          </div>
                          <div class="product-gallery-img">
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/products/feature-img03.jpg'; ?>" alt="product">
                          </div>
                          <div class="product-gallery-img">
                          <img src="<?php echo DIR_WS_TEMPLATE . 'images/products/feature-img04.jpg'; ?>" alt="product">
                          </div>
                          </div>
                          
                          <?php
                          $attribute_name = 'Pictures';
                          if (isset($options_name) && is_array($options_name)) {
                            $attributes_to_display_index = array_search($attribute_name, $options_name);
                            if ($attributes_to_display_index !== false) {
                              require($template->get_template_dir('/tpl_modules_attributes.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_attributes.php');
                            }
                          } else {
                            // Optional: Add alternate content or debug message
                            echo "<!-- No picture attributes available for this product -->";
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    
                  </form>
                  <div class="reviews">
                    <div class="container">
                      <header>
                        <h4>Reviewed by <?php echo $totalReviews; ?> Customers</h4>
                          
                          <button id="openModal">
                            Write A Review
                          </button>
                        </header>
                        
                        <?php
                        
                        
                        // SQL query
                        $reviews_query = "SELECT
                        r.customers_name,
                        r.date_added,
                        r.reviews_rating,
                        rd.reviews_text,
                        SUBSTRING_INDEX(rd.reviews_text, '\n', 1) AS review_summary,
                        c.countries_name
                        FROM
                        reviews r
                        JOIN
                        reviews_description rd ON r.reviews_id = rd.reviews_id
                        JOIN
                        customers cu ON r.customers_id = cu.customers_id
                        JOIN
                        address_book ab ON cu.customers_id = ab.customers_id
                        JOIN
                        countries c ON ab.entry_country_id = c.countries_id
                        WHERE
                        r.products_id = $current_product
                        LIMIT 4;"; // limit to the first 4 reviews
                        
                        // Function to generate the review card HTML
                        function generateReviewCard($name, $date, $rating, $summary, $text, $country)
                        {
                          // Format the date
                          $formattedDate = date('m/d/y', strtotime($date));
                          
                          // Replace NULL rating with 0
                          if ($rating === NULL) {
                            $rating = 0;
                          }
                          
                          // Format the rating with 2 decimal points
                          $formattedRating = number_format($rating, 1);
                          
                          // Build the review card HTML
                          $html = '
                          <div class="reviews-card">
                          <div class="reviews-card--left">
                          <div class="reviews-card--top">
                          <div class="reviews-card--rating">';
                          
                          for ($i = 0; $i < 5; $i++) {
                            $html .= '<img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/' . ($i < $rating ? 'rating-icon' : 'rating-icon-empty') . '.svg" alt="" />';
                          }
                          
                          $html .= '</div>
                          <p>' . $formattedRating . '</p>
                          <p>' . htmlspecialchars($summary) . '</p>
                          </div>
                          <div class="reviews-card--bottom">
                          <div class="reviews-card--main">
                          <p>' . htmlspecialchars($text) . '</p>
                          </div>
                          <div class="reviews-card--right d-mobile">
                          <p>' . $formattedDate . '</p>
                          <p>' . htmlspecialchars($name) . ' from ' . htmlspecialchars($country) . '</p>
                          </div>
                          <div class="reviews-card--helpful">
                          <p>Was this review helpful to you?</p>
                          <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/thumbs-up-icon.svg" alt="" />
                          <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/thumbs-down-icon.svg" alt="" />
                          </div>
                          </div>
                          </div>
                          <div class="reviews-card--right d-desktop">
                          <p>' . $formattedDate . '</p>
                          <p>' . htmlspecialchars($name) . ' from ' . htmlspecialchars($country) . '</p>
                          </div>
                          </div>';
                          
                          return $html;
                        }
                        
                        // Execute the query
                        $reviews = $db->Execute($reviews_query);
                        $reviewCard = '';
                        
                        // Loop through the results and generate the review cards
                        while (!$reviews->EOF) {
                          $reviewCard .= generateReviewCard(
                          $reviews->fields['customers_name'],
                          $reviews->fields['date_added'],
                          $reviews->fields['reviews_rating'],
                          $reviews->fields['review_summary'],
                          $reviews->fields['reviews_text'],
                          $reviews->fields['countries_name']
                          );
                          $reviews->MoveNext();
                        }
                        
                        // Output the review cards
                        echo $reviewCard;
                        
                        ?>
                        
                        
                        <!-- Review Footer -->
                        <div class="reviews-footer">
                          <div class="reviews-footer--left">
                            <p>Displaying Reviews</p>
                            <p>1-10</p>
                          </div>
                          <div class="reviews-footer--right">
                            <p>Back to Top</p>
                            <p>Next</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Featured Brands -->
                    <section class="featured">
                      <div class="featured-related container">
                        <header class="sub-heading">
                          <h3>Related Products</h3>
                          </header>
                          <div class="row">
                            
                            <?php
                            $current_product = (int)$current_product;
                            
                            $related_products_query = "SELECT p2.*,
                            pd.products_name
                            FROM products p1
                            JOIN products p2 ON p1.products_id != p2.products_id
                            LEFT JOIN products_description pd ON p2.products_id = pd.products_id
                            WHERE p1.products_id = $current_product
                            AND ABS(p1.products_price - p2.products_price) <= 50
                            GROUP BY p2.products_id
                            ORDER BY ABS(p1.products_price - p2.products_price) ASC
                            LIMIT 4;  -- Limit the results to the first 4 rows";
                            
                            function generateRelatedProductCard($product_id, $image, $name, $price, $rating) {
                              // Replace NULL rating with 0
                              if ($rating === NULL) {
                                $rating = 0;
                              } else {
                                // Format rating to two decimal places
                                $rating = number_format($rating, 2);
                              }
                              
                              // Format the price with 2 decimal points
                              $formattedPrice = number_format($price, 2);
                              
                              $fileParts = pathinfo($image);
                              
                              // Construct the new file name with the postfix
                              $newImageName = $fileParts['filename'] . '-01.' . $fileParts['extension'];
                              $newImageFilePath = DIR_WS_IMAGES . $newImageName;
                              
                              if (file_exists($newImageFilePath)) {
                                $has_additional_image = true;
                              } else {
                                $has_additional_image = false;
                              }
                              
                              return '
                              <div class="watch-card '. ($newImageName ? 'has-newname' : '') .'">
                              <a href="' . DIR_WS_CATALOG . 'index.php?main_page=product_info&amp;products_id=' . $product_id . '">
                              <div class="watch-card--image">
                              <img class="" src="' . DIR_WS_IMAGES . $image . '" alt="" />
                              <img class="hover-image" src="' . DIR_WS_IMAGES .  ($has_additional_image ? $newImageName : $image)  . '" alt="" />
                              <div class="watch-card--icons">' . '<div class="watch-card--cart">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg') . '</div>' . '<div class="watch-card--preview">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-preview.svg') . '</div>' . '<div class="watch-card--like">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-heart.svg') . '</div>' . '</div>' . '</div>
                              
                              <p class="watch-card--title">' . $name . '</p>
                              <div class="watch-card--pricing">
                              <p>$' . $formattedPrice . '</p>
                              <p class="watch-card--rating"><span>' . $rating . '<span> <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg" alt="" /></p>
                              </div>
                              </a>
                              </div>
                              ';
                            }
                            
                            $related_products = $db->Execute($related_products_query);
                            $relatedProductsContent = '';
                            
                            if ($related_products->EOF) {
                              echo "No related products found.";
                            } else {
                              while (!$related_products->EOF) {
                                $avgRating = isset($related_products->fields['avg_rating'])
                                ? (float)$related_products->fields['avg_rating']
                                : 0.0;
                                
                                $relatedProductsContent .= generateRelatedProductCard(
                                $related_products->fields['products_id'],
                                $related_products->fields['products_image'],
                                $related_products->fields['products_name'],
                                $related_products->fields['products_price'],
                                $avgRating
                                );
                                $related_products->MoveNext();
                              }
                            }
                            
                            echo $relatedProductsContent;
                            ?>
                          </div>
                        </div>
                      </section>
                      <!-- Featured End -->
                      
                      <!-- Featured Brands -->
                      <section class="featured">
                        <div class="featured-recent container">
                          <header class="sub-heading">
                            <h3>Recently Viewed</h3>
                            </header>
                            <div class="row">
                              <?php
                              
                              // Assuming $db is the database connection object and $current_product is sanitized and validated
                              
                              $recently_viewed_query = "SELECT p2.*, pd.products_name, pd.products_viewed,
                              CASE
                              WHEN COUNT(reviews.reviews_rating) > 0 THEN AVG(reviews.reviews_rating)
                              ELSE NULL
                              END AS avg_rating
                              FROM products p1
                              JOIN products p2 ON p1.products_id != p2.products_id
                              LEFT JOIN reviews ON p2.products_id = reviews.products_id
                              LEFT JOIN products_description pd ON p2.products_id = pd.products_id
                              WHERE p1.products_id = $current_product
                              AND pd.language_id = 1
                              AND ABS(pd.products_viewed - (
                              SELECT pd1.products_viewed
                              FROM products_description pd1
                              WHERE pd1.products_id = $current_product
                              AND pd1.language_id = 1
                              )) <= 500  -- Adjust the threshold as per your requirement
                              GROUP BY p2.products_id, reviews.reviews_rating
                              LIMIT 4;  -- Limit the results to the first 4 rows
                              ";
                              
                              function generateRecentlyViewedProductCard($product_id, $image, $name, $price, $rating)
                              {
                                // Replace NULL rating with 0
                                if ($rating === NULL) {
                                  $rating = 0;
                                } else {
                                  // Format rating to two decimal places
                                  $rating = number_format($rating, 2);
                                }
                                
                                // Format the price with 2 decimal points
                                $formattedPrice = number_format($price, 2);
                                
                                $fileParts = pathinfo($image);
                                
                                // Construct the new file name with the postfix
                                $newImageName = $fileParts['filename'] . '-01.' . $fileParts['extension'];
                                $newImageFilePath = DIR_WS_IMAGES . $newImageName;
                                
                                if (file_exists($newImageFilePath)) {
                                  $has_additional_image = true;
                                } else {
                                  $has_additional_image = false;
                                }
                                
                                return '
                                <div class="watch-card  '. ($newImageName ? 'has-newname' : '') .'">
                                <a href="' . DIR_WS_CATALOG . 'index.php?main_page=product_info&amp;products_id=' . $product_id . '">
                                <div class="watch-card--image">
                                <img src="' . DIR_WS_IMAGES . $image . '" alt="" />
                                <img class="hover-image" src="' . DIR_WS_IMAGES . ($has_additional_image ? $newImageName : $image) . '" alt="" />
                                
                                <div class="watch-card--icons">' . '<div class="watch-card--cart">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg') . '</div>' . '<div class="watch-card--preview">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-preview.svg') . '</div>' . '<div class="watch-card--like">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-heart.svg') . '</div>' . '</div>' . '</div>
                                
                                <p class="watch-card--title">' . $name . '</p>
                                <div class="watch-card--pricing">
                                <p>$' . $formattedPrice . '</p>
                                <p class="watch-card--rating"><span>' . $rating . '</span> <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg" alt="" /></p>
                                </div>
                                </a>
                                </div>
                                ';
                              }
                              
                              $recently_viewed = $db->Execute($recently_viewed_query);
                              
                              // $recentlyViewedContent = '';
                              
                              // while (!$recently_viewed->EOF) {
                              //   $recentlyViewedContent .= generateRecentlyViewedProductCard(
                              //       $recently_viewed->fields['products_id'],
                              //       $recently_viewed->fields['products_image'],
                              //       $recently_viewed->fields['products_name'],
                              //       $recently_viewed->fields['products_price'],
                              //       $recently_viewed->fields['avg_rating']
                              //   );
                              //   $recently_viewed->MoveNext();
                              // }
                              
                              // echo $recentlyViewedContent;
                              
                              /**
                              * Start: New Recently View
                              */
                              
                              // Start the session if not already started
                              if (!isset($_SESSION)) {
                                session_start();
                              }
                              
                              // Get the current product ID
                              $current_product_id = (int)$_GET['products_id'];
                              
                              // Initialize the recently viewed session array if not already set
                              if (!isset($_SESSION['recently_viewed'])) {
                                $_SESSION['recently_viewed'] = [];
                              }
                              
                              // Add the current product ID to the beginning of the array
                              if (!in_array($current_product_id, $_SESSION['recently_viewed'])) {
                                array_unshift($_SESSION['recently_viewed'], $current_product_id);
                              }
                              
                              // Limit the array to 4 items
                              $_SESSION['recently_viewed'] = array_slice($_SESSION['recently_viewed'], 0, 4);
                              
                              if (!empty($_SESSION['recently_viewed'])) {
                                $recent_ids = implode(',', $_SESSION['recently_viewed']);
                                
                                // Query to get product details
                                $recent_query = "SELECT p.products_id,
                                p.products_image,
                                p.products_price,
                                pd.products_name
                                FROM products p
                                LEFT JOIN products_description pd
                                ON p.products_id = pd.products_id
                                WHERE p.products_id IN ($recent_ids)
                                ORDER BY FIELD(p.products_id, $recent_ids)
                                LIMIT 4;";
                                
                                $recent_products_query = $db->Execute($recent_query);
                                
                                if ($recent_products_query->RecordCount() > 0) {
                                  $recentlyViewedContent = '';
                                  
                                  while (!$recent_products_query->EOF) {
                                    $avgRating = isset($recent_products_query->fields['avg_rating'])
                                    ? (float)$recent_products_query->fields['avg_rating']
                                    : 0.0;
                                    $recentlyViewedContent .= generateRecentlyViewedProductCard(
                                    $recent_products_query->fields['products_id'],
                                    $recent_products_query->fields['products_image'],
                                    $recent_products_query->fields['products_name'],
                                    $recent_products_query->fields['products_price'],
                                    $avgRating
                                    );
                                    $recent_products_query->MoveNext();
                                  }
                                  
                                  echo $recentlyViewedContent;
                                }
                              }
                              /**
                              * End: New Recently View
                              */
                              
                              ?>
                            </div>
                          </div>
                        </section>
                        <!-- Featured End -->
                        
                      </div>
                      
                      <div id="addToCartToast" class="toast-success" style="display: none;">
                        Product successfully added to your cart!
                      </div>
                      
                      <!-- Review Modal  -->
                      <div id="modal" class="modal review-modal">
                        <div class="modal-content">
                          <header>
                            <h3>Write a review</h3>
                              <?php
                              // Define an empty variable to store the generated HTML
                              $headerText = '';
                              
                              // Check if the flag is greater than or equal to 1
                              if ($flag_show_product_info_reviews_count >= 1 && $totalReviews > 0) {
                                // Generate the related product card HTML
                                $headerText = ' <p> There are ' . $totalReviews . ' reviews for this product</p>';
                              } else {
                                // Generate the HTML for the "no reviews yet" message
                                $headerText = '<p>There are no reviews yet</p>';
                                $headerText .= '<p>Be the first to review the ' . $products_name . ' ' . $products_model . '</p>';
                              }
                              
                              // Output the generated HTML
                              echo $headerText;
                              ?>
                            </header>
                            <!-- Ratings  -->
                            <?php
                            function generateStarRating($rating)
                            {
                              $starsHTML = '<div class="modal-icons">';
                              
                              // Loop to generate 5 stars
                              for ($i = 1; $i <= 5; $i++) {
                                // Check if the current star should be filled or empty based on the rating
                                $starClass = ($i <= $rating) ? 'filled' : 'stroke';
                                // Add the HTML for the star
                                $starsHTML .= '<div class="modal-icons--item">';
                                $starsHTML .= '<svg class="star" viewBox="0 0 37 37" fill="" xmlns="http://www.w3.org/2000/svg" data-rating="' . $i . '">
                                <path  d="M18.0112 28.5327L8.12217 34L10.0112 22.4202L2 14.2201L13.0555 12.5352L18 2L22.9445 12.5352L34 14.2201L25.9888 22.4202L27.8778 34L18.0112 28.5327Z"  fill="" stroke="" stroke-width="2.3125" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                ';
                                $starsHTML .= '</div>';
                              }
                              
                              // Add the hidden input field to store the rating value
                              $starsHTML .= '<input type="hidden" name="rating" id="rating" value="' . $rating . '">';
                              
                              $starsHTML .= '</div>';
                              
                              return $starsHTML;
                            }
                            
                            // Example usage:
                            $rating = 0; // Set the rating value here
                            echo generateStarRating($rating);
                            ?>
                            
                            <!-- End Rating -->
                            
                            <p class="">Click to rate</p>
                              <form name="product_reviews_write" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
                                <div class=" input-group">
                                  <?php
                                  session_start();
                                  
                                  // Check if the customer is logged in
                                  if (isset($_SESSION['customer_id'])) {
                                    // Customer is logged in
                                    // No additional code needed
                                  } else {
                                    // Customer is not logged in
                                    $customerInputs = '
                                    <div class="input-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" placeholder="" />
                                    </div>
                                    <div class="input-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" placeholder="" />
                                    <p><small>Your email address will not be published.</small></p>
                                    </div>
                                    ';
                                    echo $customerInputs;
                                  }
                                  ?>
                                  <label for="title">Review Title</label>
                                    <input type="text" class="form-control" placeholder="Example: Easy to use" />
                                  </div>
                                  <div class="input-group">
                                    <label for="review">Product Review</label>
                                      <?php echo zen_draw_textarea_field('review_text', 0, 0, '~*~*#', 'placeholder="Example: Since I bought this a month ago, it has been used a lot. What I like best/what is worst about this product is ..."'); ?>
                                      <?php echo zen_draw_input_field('should_be_empty', '', ' size="60" id="RAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
                                      </div>
                                      <p>Would you recommend this product to a friend?</p>
                                      <div class="form-group">
                                      <div class="input-group">
                                      <label for="option">Yes</label>
                                      <input type="radio" class="form-control" value="yes" name="option" />
                                      </div>
                                      <div class="input-group">
                                      <label for="option">No</label>
                                      <input type="radio" class="form-control" value="no" name="option" />
                                      </div>
                                      </div>
                                      <div class="form-button">
                                      <button typ="submit">Submit</button>
                                      </div>
                                      </form>
                                      </div>
                                      </div>
