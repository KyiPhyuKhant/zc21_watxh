<?php
// if ($nmx_disk_cache->cacheStart('tpl_index_default', array($_SESSION['languages_id']), true, true)) {
?>
<?php
      /**
       * Page Template
       *
       * Main index page<br />
       * Displays greetings, welcome text (define-page content), and various centerboxes depending on switch settings in Admin<br />
       * Centerboxes are called as necessary
       *
       * @package templateSystem
       * @copyright Copyright 2003-2006 Zen Cart Development Team
       * @copyright Portions Copyright 2003 osCommerce
       * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
       * @version $Id: tpl_index_default.php 3464 2006-04-19 00:07:26Z ajeh $
       */
      ?>

<!-- 	1. Hero Image -->

<!-- Hero -->
<section class="hero">
 <div class="container">
  <div class="hero-text">
   <label>Introducing</label>
   <h1>Most Advanced Smartwatch is here.</h1>
   <p>
    Specialized e-commerce providing original watches at a discounted price. Selling more than a thousand of
    different watch designs.
   </p>
   <button>Shop Now</button>
  </div>
 </div>
 <div class="hero-image">
  <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/banner_image.png' ?>" alt="hero image" />
 </div>
</section>
<!-- End Hero -->

<!--Discount Banner  -->
<section class="discount">
 <div class="container">
  <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/logistics-icon.svg'; ?>" alt="cart-icon" />
  <p>Free U. S. shipping</p>
  <p>On all orders over $100</p>
 </div>
</section>
<!-- End Discount Banner -->

<!-- Featured Section -->
<section class="featured">
 <div class="featured-collection container">
  <header class="sub-heading">
   <h3>Featured Collection</h3>
   <p>View all&nbsp;
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
        <path d="M1.40044 14C1.52755 14.0002 1.65326 13.9793 1.76918 13.9388C1.88511 13.8982 1.98859 13.8389 2.07273 13.7648L9.27266 7.46462C9.4191 7.33658 9.5 7.17118 9.5 6.99981C9.5 6.82844 9.4191 6.66303 9.27266 6.53499L2.07273 0.234823C1.99425 0.166153 1.89916 0.110178 1.79287 0.0700942C1.68658 0.0300104 1.57118 0.00660258 1.45326 0.00120735C1.33534 -0.00418788 1.21721 0.0085351 1.10561 0.0386499C0.994011 0.0687646 0.891131 0.115681 0.802845 0.176721C0.714559 0.237762 0.642593 0.311729 0.591059 0.394402C0.539524 0.477075 0.509429 0.566833 0.502493 0.658552C0.495557 0.750271 0.511914 0.842154 0.550632 0.928956C0.589349 1.01576 0.649669 1.09578 0.728146 1.16445L7.39708 6.99981L0.728146 12.8352C0.612602 12.9359 0.537024 13.0605 0.510533 13.194C0.484043 13.3274 0.507772 13.4639 0.578859 13.5871C0.649946 13.7102 0.765348 13.8148 0.911137 13.888C1.05692 13.9613 1.22686 14.0002 1.40044 14Z" fill="black"/>
        </svg>
    </p>
  </header>

  <div class="row">


  <?php
    $featured_products_query = "SELECT 
        p.products_id, 
        p.products_image, 
        p.products_price, 
        pd.products_name
    FROM " . TABLE_PRODUCTS . " p
    JOIN " . TABLE_FEATURED . " f ON p.products_id = f.products_id
    JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id
    WHERE 
        p.products_status = 1 
        AND f.status = 1 
        AND pd.language_id = " . (int)$_SESSION['languages_id'] . "
    ORDER BY f.featured_date_added DESC
    LIMIT 4";

function getFirstAdditionalImage($mainImage) {
  $imageDir = DIR_WS_IMAGES;
  $imagePath = DIR_FS_CATALOG . $imageDir;
  $imageBase = preg_replace('/\.[^.]+$/', '', $mainImage);
  $imageExt = pathinfo($mainImage, PATHINFO_EXTENSION);
  $matches = [];
  if ($handle = opendir($imagePath)) {
      while (false !== ($file = readdir($handle))) {
          if (preg_match('/^' . preg_quote($imageBase, '/') . '_.+\.' . preg_quote($imageExt, '/') . '$/', $file)) {
              $matches[] = $file;
          }
      }
      closedir($handle);
  }

  if (!empty($matches)) {
      natsort($matches);
      // Return the first file in sorted order
      return $imageDir . reset($matches);
  }

  return false;
}

function generateFeaturedProductCard($product_id, $image, $name, $price, $rating)
{
    if (empty($product_id)) {
        return ''; // Return empty if no valid product ID
    }
    // Replace NULL rating with 0
    if ($rating === NULL) {
        $rating = 0;
    } else {
        // Format rating to two decimal places
        $rating = number_format($rating, 2);
    }
  
    // Format the price with 2 decimal points
    $formattedPrice = number_format($price, 2);


    // Determine the request type (SSL or NONSSL)
    // $request_type = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'SSL' : 'NONSSL';
    $request_type = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'SSL' : 'NONSSL';

    $info_page  = zen_get_info_page($product_id);
    $view_url   = zen_href_link($info_page, 'products_id=' . $product_id, $request_type);
    $add_action = zen_href_link(
        $info_page,
        zen_get_all_get_params(['action','products_id']) 
          . 'action=buy_now_homepage&products_id=' . $product_id,
        $request_type
    );

    if($image) {
      $firstAdditionalImage = getFirstAdditionalImage($image);
      if(!$firstAdditionalImage) {
        $firstAdditionalImage = 'images/no_second_image.png';
      }
    } else {
      $firstAdditionalImage = 'images/no_second_image.png';
      $image = 'no_product_image.png';
    }

    $cartContents = $_SESSION['cart']->get_products();
    $productInCart = false;

    foreach ($cartContents as $cartProduct) {
        $cartProductId = (int)explode(':', $cartProduct['id'])[0];
        
        if ($cartProductId == (int)$product_id) {
            $productInCart = true;
            break;
        }
    }

    return '
    <div class="watch-card">
      <a href="javascript:void(0);">
        <div class="watch-card--image"' . 
          ($firstAdditionalImage ? ' data-altpic="' . $firstAdditionalImage . '"' : '') . 
          ' data-original="' . DIR_WS_IMAGES . $image . '">
          <img class="card--image" src="' . DIR_WS_IMAGES . $image . '" alt="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" />
          <div class="watch-card--icons">
            <form class="watch-card--form" action="' . $add_action . '" method="post" enctype="multipart/form-data">
              ' . zen_draw_hidden_field('securityToken', $_SESSION['securityToken']) . '
              <input type="hidden" name="products_id" value="' . $product_id . '">
              <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
              <button type="submit" class="watch-card--cart home-add-to-cart '. ($productInCart ? 'active' : '') .'">' 
                . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg', 'Add to Cart') . 
              '</button>
            </form>
            <!--<div class="watch-card--form">
              <button class="watch-card--cart ajax-add-to-cart '. ($productInCart ? 'active' : '') .'" data-product-id="'. $product_id .'">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg', 'Add to Cart') . '</button>
            </div>-->
            <div class="watch-card--preview">' 
              . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-preview.svg') . 
            '</div>
            <div class="watch-card--like">' 
              . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-heart.svg') . 
            '</div>
          </div>
        </div>
        <p class="watch-card--title"><a href="' . $view_url . '">' . htmlspecialchars($name, ENT_QUOTES) . '</a></p>
        <div class="watch-card--pricing">
          <p>$' . $formattedPrice . '</p>
          <p class="watch-card--rating"><span>' . $rating . '</span> 
            <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg" alt="rating" />
          </p>
        </div>
      </a>
    </div>
    ';
 }


 // Execute query and generate product cards
 $featured_collection = $db->Execute($featured_products_query);

 $featuredCollection = '';

 while (!$featured_collection->EOF) {
    $featuredCollection .= generateFeaturedProductCard(
        $featured_collection->fields['products_id'],
        $featured_collection->fields['products_image'],
        $featured_collection->fields['products_name'],
        $featured_collection->fields['products_price'],
        // $featured_collection->fields['avg_rating']
        null // Assuming you don't need the rating for featured products
    );
    $featured_collection->MoveNext();
 }

 echo $featuredCollection;
 ?>

  </div>
 </div>
</section>
<!-- End Featured  -->

<!-- Section Hub  -->
<section class="hub">
 <div class="container">
  <div class="row">
   <div class="hub-video">
    <video poster="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/video-thumbnail.jpg'; ?>">
     <source src="" type="video/mp4" />
    </video>
   </div>
   <div class="hub-card">
    <h4>The Best Watch Store Hub</h4>
    <p>
     We offer a wide selection of watch designs from heritage and classic models to novelty and designer
     styles, from sports multi-function and digital watches to mechanical and analog. Here, you will find
     timepieces that combine the well thought designs and solid craftsmanship.
    </p>
    <button>Shop Now</button>
   </div>
  </div>
 </div>
</section>
<!--  -->

<!-- Categories Section -->
<section class="categories">
 <div class="container">
  <div class="sub-heading">
   <h3>Categories</h3>
  </div>

  <div class="row">
   <?php
   // Query to get categories with their images and names
   $categories_query = "SELECT 
       c.categories_id, 
       c.categories_image, 
       cd.categories_name
   FROM " . TABLE_CATEGORIES . " c
   LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON c.categories_id = cd.categories_id
   WHERE c.categories_status = 1 
       AND cd.language_id = " . (int)$_SESSION['languages_id'] . "
       AND c.parent_id = 0
       AND c.categories_image != ''
   ORDER BY c.sort_order DESC, cd.categories_name ASC
   LIMIT 4";

   $categories_result = $db->Execute($categories_query);
   
   while (!$categories_result->EOF) {
       $category_id = $categories_result->fields['categories_id'];
       $category_image = $categories_result->fields['categories_image'];
       $category_name = $categories_result->fields['categories_name'];
       
       $request_type = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'SSL' : 'NONSSL';
       
       $category_url = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_id, 'SSL');

       $image_src = !empty($category_image) ? 
           DIR_WS_IMAGES . $category_image : 
           DIR_WS_TEMPLATE . 'images/watxh-pictures/default-category.png';
       
       echo '
       <div class="categories-card">
           <a href="' . $category_url . '">
               <img class="categories-card--image" src="' . $image_src . '" alt="' . htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') . '" />
           </a>
           <a href="' . $category_url . '">
               <h5>' . htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') . '</h5>
           </a>
       </div>';
       
       $categories_result->MoveNext();
   }
   ?>
  </div>
 </div>
</section>

<!-- Categories End -->

<!-- Section Hub  -->
<section class="explore">
 <div class="container">
  <div class="row">
   <div class="explore-image">
    <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/explore-image.png'; ?>" />
   </div>
   <div class="explore-card">
    <h4>Explore the Watxh Shop</h4>
    <p>
     Established itself as the preeminent resource for modern and vintage wristwatch enthusiasts. Now
     established as one of the most trusted timepiece and accessories retail platforms for consumers and
     enthusiasts alike. In just seven years, we grown from selling watch straps and other small accessories
     to now being an authorized retailer for over 10 of the most important watch brands in the world.
    </p>
    <button>Shop Now</button>
   </div>
  </div>
 </div>
</section>
<!--  -->

<!-- Featured Brands -->
<section class="featured">
 <div class="featured-brands container">
  <header class="sub-heading">
   <h3>Featured Brands</h3>
  </header>
  <div class="row">
   <?php
                        global $db;
                        // bof modified for RED-1041
                        $manufacturers_query = "SELECT m.manufacturers_id, m.manufacturers_image, m.manufacturers_name 
                        FROM " . TABLE_MANUFACTURERS . " m
                        LEFT JOIN " . TABLE_MANUFACTURERS_INFO . " mi on m.manufacturers_id = mi.manufacturers_id
                        WHERE m.manufacturers_image != '' AND m.manufacturers_id NOT IN (65)
                        ORDER BY m.manufacturers_name ASC LIMIT 18";
                        // eof modified for RED-1041
                        $manufacturers = $db->Execute($manufacturers_query);
                        $manu_content = '';
                        while (!$manufacturers->EOF) {
                              $manu_content .= '
                            <div class="brand-card">
                                <a href="' . DIR_WS_CATALOG . 'index.php?main_page=index&amp;manufacturers_id=' . $manufacturers->fields['manufacturers_id'] . '">';
                              $manu_content .= '<img  data-src="' . DIR_WS_IMAGES . $manufacturers->fields['manufacturers_image'] . '" src="' . DIR_WS_IMAGES . $manufacturers->fields['manufacturers_image'] . '" alt="' . $manufacturers->fields['manufacturers_name'] . '">';
                              $manu_content .= "
                                </a>";
                              $manu_content .= '
                            </div>';
                              $manufacturers->MoveNext();
                        }
                        echo $manu_content;
                        ?>
  </div>
 </div>
 </div>
</section>
<!-- Featured End -->

<!-- Featured Section -->
<section class="trending">
 <div class="trending-products container">
  <header class="sub-heading">
   <h3>Trending Products</h3>
   <p>View all&nbsp;
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
        <path d="M1.40044 14C1.52755 14.0002 1.65326 13.9793 1.76918 13.9388C1.88511 13.8982 1.98859 13.8389 2.07273 13.7648L9.27266 7.46462C9.4191 7.33658 9.5 7.17118 9.5 6.99981C9.5 6.82844 9.4191 6.66303 9.27266 6.53499L2.07273 0.234823C1.99425 0.166153 1.89916 0.110178 1.79287 0.0700942C1.68658 0.0300104 1.57118 0.00660258 1.45326 0.00120735C1.33534 -0.00418788 1.21721 0.0085351 1.10561 0.0386499C0.994011 0.0687646 0.891131 0.115681 0.802845 0.176721C0.714559 0.237762 0.642593 0.311729 0.591059 0.394402C0.539524 0.477075 0.509429 0.566833 0.502493 0.658552C0.495557 0.750271 0.511914 0.842154 0.550632 0.928956C0.589349 1.01576 0.649669 1.09578 0.728146 1.16445L7.39708 6.99981L0.728146 12.8352C0.612602 12.9359 0.537024 13.0605 0.510533 13.194C0.484043 13.3274 0.507772 13.4639 0.578859 13.5871C0.649946 13.7102 0.765348 13.8148 0.911137 13.888C1.05692 13.9613 1.22686 14.0002 1.40044 14Z" fill="black"/>
        </svg>
    </p>
  </header>

  <div class="row">
   <?php

// Assuming $db is the database connection object and $current_product is sanitized and validated

$recently_viewed_query = "SELECT 
p.products_id, 
p.products_image,
p.products_price,
pd.products_name, 
pd.products_viewed, 
CASE 
    WHEN COUNT(reviews.reviews_rating) > 0 THEN AVG(reviews.reviews_rating) 
    ELSE NULL 
END AS avg_rating
FROM 
products p
LEFT JOIN 
reviews ON p.products_id = reviews.products_id
LEFT JOIN 
products_description pd ON p.products_id = pd.products_id
WHERE 
pd.language_id = 1
GROUP BY 
p.products_id, pd.products_name, pd.products_viewed
ORDER BY 
pd.products_viewed DESC
LIMIT 12;
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

    $request_type = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'SSL' : 'NONSSL';

    $info_page  = zen_get_info_page($product_id);
    $view_url   = zen_href_link($info_page, 'products_id=' . $product_id, $request_type);
    $add_action = zen_href_link(
        $info_page,
        zen_get_all_get_params(['action','products_id']) 
          . 'action=buy_now_homepage&products_id=' . $product_id,
        $request_type
    );

    if($image) {
      $firstAdditionalImage = getFirstAdditionalImage($image);
      if(!$firstAdditionalImage) {
        $firstAdditionalImage = 'images/no_second_image.png';
      }
    } else {
      $firstAdditionalImage = 'images/no_second_image.png';
      $image = 'no_product_image.png';
    }

    $cartContents = $_SESSION['cart']->get_products();
    $productInCart = false;

    foreach ($cartContents as $cartProduct) {
        $cartProductId = (int)explode(':', $cartProduct['id'])[0];
        
        if ($cartProductId == (int)$product_id) {
            $productInCart = true;
            break;
        }
    }

    return '
        <div class="watch-card">
            <a href="' . DIR_WS_CATALOG . 'index.php?main_page=product_info&amp;products_id=' . $product_id . '">
              <div class="watch-card--image"' . 
              ($firstAdditionalImage ? ' data-altpic="' . $firstAdditionalImage . '"' : '') . 
              ' data-original="' . DIR_WS_IMAGES . $image . '">
                  <img class="card--image" src="' . DIR_WS_IMAGES . $image . '" alt="" />

                  <div class="watch-card--icons">
                    <form class="watch-card--form" action="' . $add_action . '" method="post" enctype="multipart/form-data">
                      ' . zen_draw_hidden_field('securityToken', $_SESSION['securityToken']) . '
                      <input type="hidden" name="products_id" value="' . $product_id . '">
                      <input type="hidden" class="quantity-value" name="cart_quantity" value="1">
                      <button type="submit" class="watch-card--cart home-add-to-cart '. ($productInCart ? 'active' : '') .'">' 
                        . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg', 'Add to Cart') . 
                      '</button>
                    </form>
                    <!--<div class="watch-card--form">
                      <button class="watch-card--cart ajax-add-to-cart '. ($productInCart ? 'active' : '') .'" data-product-id="'. $product_id .'">' . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/cart-icon.svg', 'Add to Cart') . '</button>
                    </div>-->
                    <div class="watch-card--preview">' 
                      . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-preview.svg') . 
                    '</div>
                    <div class="watch-card--like">' 
                      . zen_image(DIR_WS_TEMPLATE . 'images/watxh-icons/icon-heart.svg') . 
                    '</div>
                  </div>
                </div>
                <p class="watch-card--title"><a href="' . $view_url . '">' . $name . '</a></p>
                <div class="watch-card--pricing">
                    <p>$' . $formattedPrice . '</p>
                    <p class="watch-card--rating"><span>' . $rating . '</span> <img src="' . DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg" alt="" /></p>
                </div>
            </a>
        </div>
    ';
}

$recently_viewed = $db->Execute($recently_viewed_query);

$recentlyViewedContent = '';

while (!$recently_viewed->EOF) {
  $recentlyViewedContent .= generateRecentlyViewedProductCard(
      $recently_viewed->fields['products_id'],
      $recently_viewed->fields['products_image'],
      $recently_viewed->fields['products_name'],
      $recently_viewed->fields['products_price'],
      $recently_viewed->fields['avg_rating']
  );
  $recently_viewed->MoveNext();
}

echo $recentlyViewedContent;

?>
  </div>
 </div>
</section>
<!-- End Featured  -->

<!-- Content -->
<section class="content">
 <div class="container">
  <div class="row">
   <h3>Unique Features Of leatest & Trending Poducts</h3>
   <div class="content-image">
    <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/uniqie-feature-image.png'; ?>" alt="" />
   </div>
   <div class="content-text">
    <h3>Unique Features Of leatest & Trending Poducts</h3>
    <ul>
     <li>
      <p>All frames constructed with hardwood solids and laminates.</p>
     </li>
     <li>
      <p>Reinforced with double wood dowels, glue, screw - nails corner blocks and machine nails.</p>
     </li>
     <li>
      <p>Arms, backs and seats are structurally reinforced.</p>
     </li>
    </ul>
    <button>Learn more</button>
   </div>
  </div>
 </div>
</section>
<!-- Content End -->

<!-- Carousel -->
<div class="review container review-section-container">
 <header class="sub-heading">
  <h3>Don't take our word for it</h3>
  <div class="review-rating">
   <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg"'; ?>" alt="" />
   <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg"'; ?>" alt="" />
   <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg"'; ?>" alt="" />
   <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg"'; ?>" alt="" />
   <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/rating-icon.svg"'; ?>" alt="" />
  </div>
 </header>
 <section>
  <ul class="review-carousel owl-carousel owl-theme">
   
    <!-- Start: Static codes -->
    <li class="item">
        <figure>
            <div>
                <img src="includes/templates/watxh_zc/images/watxh-pictures/slide-user.png" alt="">
            </div>
            <figcaption>
                <h5><p>Bill Smith</p></h5>
                <p>billsmith</p>
            </figcaption>
        </figure>
        <main>
            <p>There’s no other program that walks you through exactly what you need to know to start an online store fast, written by someone who has built several 7-figure ecommerce businesses from scratch.</p>
        </main>
    </li>
    
    <li class="item">
        <figure>
            <div>
                <img src="includes/templates/watxh_zc/images/watxh-pictures/slide-user.png" alt="">
            </div>
            <figcaption>
                <h5><p>Bill Smith</p></h5>
                <p>billsmith</p>
            </figcaption>
        </figure>
        <main>
            <p>What’s more, everything has been broken down in step-by-step detail with real action plans including finding your niche.</p>
        </main>
    </li>
    
    <li class="item">
        <figure>
            <div>
                <img src="includes/templates/watxh_zc/images/watxh-pictures/slide-user.png" alt="">
            </div>
            <figcaption>
                <h5><p>Bill Smith</p></h5>
                <p>billsmith</p>
            </figcaption>
        </figure>
        <main>
            <p>What’s more, everything has been broken down in step-by-step detail with real action plans including finding your niche.</p>
        </main>
    </li>

    <li class="item">
        <figure>
            <div>
                <img src="includes/templates/watxh_zc/images/watxh-pictures/slide-user.png" alt="">
            </div>
            <figcaption>
                <h5><p>Bill Smith</p></h5>
                <p>billsmith</p>
            </figcaption>
        </figure>
        <main>
            <p>There’s no other program that walks you through exactly what you need to know to start an online store fast, written by someone who has built several 7-figure ecommerce businesses from scratch.</p>
        </main>
    </li>
    
    <li class="item">
        <figure>
            <div>
                <img src="includes/templates/watxh_zc/images/watxh-pictures/slide-user.png" alt="">
            </div>
            <figcaption>
                <h5><p>Bill Smith</p></h5>
                <p>billsmith</p>
            </figcaption>
        </figure>
        <main>
            <p>What’s more, everything has been broken down in step-by-step detail with real action plans including finding your niche.</p>
        </main>
    </li>
    
    <li class="item">
        <figure>
            <div>
                <img src="includes/templates/watxh_zc/images/watxh-pictures/slide-user.png" alt="">
            </div>
            <figcaption>
                <h5><p>Bill Smith</p></h5>
                <p>billsmith</p>
            </figcaption>
        </figure>
        <main>
            <p>What’s more, everything has been broken down in step-by-step detail with real action plans including finding your niche.</p>
        </main>
    </li>
    <!-- End: Static codes -->
  </ul>
 </section>
</div>
<!-- Carousel End -->

<!-- Latest Blog -->
<section class="blog">
 <div class="container">
  <header class="sub-heading">
   <h3>Latest Blog</h3>
  </header>
  <div class="row">
   <div class="blog-post">
    <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/blog-image-i.png'; ?>" alt="" />
    <div class="blog-details">
     <ul class="blog-author">
      <li>
       <div>
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/pen-icon.svg" alt="pen-icon'; ?>" />
       </div>
       <p>SaberAli</p>
      </li>
      <li>
       <div>
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/calendar-icon.svg" alt="pen-icon'; ?>" />
       </div>
       <p>21, August 2021</p>
      </li>
     </ul>
    </div>
    <h4>Top esssential Trends in 2021</h4>
    <p>
     Fresh picks on our shelves just in time for spring 2022. Bring your best self with our latest lines.
    </p>
    <a href="">Shop trends</a>
   </div>
   <div class="blog-post">
    <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/blog-image-02.jpg'; ?>" alt="" />
    <div class="blog-details">
     <ul class="blog-author">
      <li>
       <div>
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/pen-icon.svg'; ?>" alt="pen-icon" />
       </div>
       <p>SaberAli</p>
      </li>
      <li>
       <div>
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/calendar-icon.svg' ?>" alt="pen-icon" />
       </div>
       <p>21, August 2021</p>
      </li>
     </ul>
    </div>
    <h4>Our pick: Lady Suite</h4>
    <p>
      Fresh picks on our shelves just in time for spring 2022. Bring your best self with our latest lines.
    </p>
    <a href="">Shop trends</a>
   </div>
   <div class="blog-post">
    <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/blog-image-03.jpg'; ?>" alt="" />
    <div class="blog-details">
     <ul class="blog-author">
      <li>
       <div>
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/pen-icon.svg' ?>" alt="pen-icon" />
       </div>
       <p>SaberAli</p>
      </li>
      <li>
       <div>
        <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/calendar-icon.svg' ?>" alt="pen-icon" />
       </div>
       <p>21, August 2021</p>
      </li>
     </ul>
    </div>
    <h4>10% off all Fitness band</h4>
    <p>
      Use this section to explain a set of product features, to link to a series of pages, or to answer common questions.
    </p>
    <a href="">Shop trends</a>
   </div>
  </div>
 </div>
</section>

<!-- </div> -->
<?php
//       $nmx_disk_cache->cacheEnd();
// }
?>