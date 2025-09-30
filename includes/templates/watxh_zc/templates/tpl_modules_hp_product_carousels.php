<?php
/**
 * Numinix Home Page Product Carousels
 * ============================================================
 * This file contains the template for
 * the Home Page Product Carousels Plugin
 */

/**
*  If there are multiple carousels on the page, offset the starting product of each so that they do not repeat
**/

define('OFFSET_FOR_FURTHER_CAROUSELS', 10); //if multiple carausels are on the same page, each one wil start this many products later.
if(!isset($hp_product_carousel) || !isset($offset)) {
  $offset = 0;
}
else {
  $offset += OFFSET_FOR_FURTHER_CAROUSELS;
}

$carausel_num = intval($offset / OFFSET_FOR_FURTHER_CAROUSELS);
//if($carausel_num == 0) {$carausel_num = '';}

/**
 * Pull the information needed from the hp product carousel
 * and set up variables with it.
 */

$hp_product_carousel = hp_product_carousel();
$tab_positions_array = $hp_product_carousel['tab_positions'];
$tab_number = $hp_product_carousel['tab_number'];
$tab_col_width = $hp_product_carousel['tab_col_width'];


/**
 * If there is at least one tab, run a loop through the 
 * array to grab the positions in the correct order. 
 * Before doing so set up a counter so that we can tell 
 * if this is the first iteration. That way we know which 
 * one to apply the active class to on page load.
 */ 
if ( $tab_number !== 0 ) :
?>

<div class="nmx-plugin nmx-product-carousels nmx-hp-product-carousels">
  <div id="nmx-tabs-wrapper<?php echo $carausel_num; ?>">
    <ul id="nmx-tabs-nav" class="nmx-tabs-nav">

<?php
  $i = 0;

  foreach ( $tab_positions_array as $key => $tab_position ) :

    /**
     * Create tab id name. In order to do so I
     * need to make sure it is the correct case.
     */
    $tab_id_filter = 'tab' . ucwords( strtolower( str_replace( '_', ' ', $key ) ) ); 
    $tab_id = str_replace( ' ', '', $tab_id_filter ) . '' . $carausel_num;

    /**
     * Update key so that it is uppercase and then append
     * to constant variable.
     */
    $tab_name = strtoupper($key);
    $tab_name_constant = constant('TITLE_HOME_TAB_' . $tab_name);


    /**
     * Print out tab. If it is the first tab, then add
     * class active.
     */
    $active_class = '';

    if ( $i == 0 ) {
      $active_class = ' active';
    }

    $tab_properties = 'id="' . $tab_id . '" class="nmx-tab ' . $tab_col_width  . $active_class . '"';
?>

      <li <?php echo $tab_properties; ?>>
        <span class="nmx-as-heading"><?php echo $tab_name_constant; ?></span>
      </li>

<?php    
    /**
     * Run counter
     */
    $i++;

  endforeach;
?>

    </ul><!-- /.infoTabs -->

<?php
  /**
   * Run a loop through the array to grab the 
   * content for the tabs that were printed above.
   * Before doing so reset counter so that we know
   * if this is the first iteration.
   */ 
  foreach ( $tab_positions_array as $key => $tab_position ) :

    /**  
     * Set up id for tabbed content
     */
    $tab_content_id_filter = 'tab' . ucwords( strtolower( str_replace('_', ' ', $key ) ) ) . $carausel_num . 'Content';
    $tab_content_id = str_replace( ' ', '', $tab_content_id_filter );

    /**
     * Set variable for key to slider if best sellers
     */
    $slider_key = $key;

    /**
     * Print tabbed content. If this is the first iterartion,
     * apply normal images, else, lazy load them.
     */
?>   

    <div id="<?php echo $tab_content_id; ?>" class="nmx-tab-content nmx-owl-carousel nmx-owl-carousel-products owl-carousel inactive">

<?php
    $specialSlide = getProductsSlide($slider_key, $_SESSION["languages_id"]);
    $specialSlide = array_slice($specialSlide, $offset);
 
    foreach($specialSlide as $product) {
?>                       

      <div class="nmx-product">
        <?php echo nmx_product($product["products_id"], $product["products_name"], $product["products_image"], true, true); ?>
      </div>

<?php
    }
?>

    </div><!-- /.tabcontent -->

<?php                       
    /**
     * Run counter
     */
    $i++;

  endforeach;
?>

  </div><!-- /.tabs-wrapper -->
</div><!-- /.hp-product-carousels -->

<?php
endif;
?>    
