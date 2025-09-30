<?php

/**
 * Page Template
 *
 * Displays page-not-found message and site-map (if configured)
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_page_not_found_default.php 3230 2006-03-20 23:21:29Z drbyte $
 */
?>


<?php if (DEFINE_PAGE_NOT_FOUND_STATUS == '1') { ?>
<?php
 // require the html_define for the page_not_found page
 // require($define_page); 
 ?>
<!-- Error Section -->
<section class="error">
 <div class="error-image">
  <img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-pictures/not-found-image.png' ?>" alt="" />
 </div>

 <div class="error-text">
  <h4>Page not found</h4>
  <p>
   The page you are looking for doesn’t exist or an other error occured. <br />Go back, or head over to
   watxh.com to choose a new direction.
  </p>
 </div>

 <?php echo '<a id="logo" href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' ?>
 <button>Back to Home</button>
 <?php '</a>'; ?>
 </a>
</section>
<!-- Error End -->
<?php } ?>







<!-- <div class="site-map-tree"> -->
<?php //echo $_SESSION['category_tree']->buildCategoryString('<ul class="{class}">{child}</ul>', '<li class="{class}"><a class="{class} category-top" href="{link}"><span class="{class}">{name}</span></a>{child}</li>'); 
?>
<!-- </div> -->