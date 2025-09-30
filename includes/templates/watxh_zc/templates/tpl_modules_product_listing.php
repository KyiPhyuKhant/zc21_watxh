<?php

/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING 04/04/2006
 */

if (!defined('PRODUCT_LISTING_LAYOUT_STYLE')) define('PRODUCT_LISTING_LAYOUT_STYLE', 'columns');
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
?>

<div class="product-listing" id="productListing">

    <div class="product-tags">
        <div class="row">
            <div class="tag">
                <p><?php echo $breadcrumb->last(); ?></p>
                <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'main_page=index&cPath=0', 'NONSSL', true, false); ?>" class="tag-close-btn">
					<img src="<?php echo DIR_WS_TEMPLATE . 'images/watxh-icons/close-icon.svg'; ?>" alt="Close tag" />
				</a>
            </div>
        </div>
    </div>

    <div class="tools-product-listing">
        <?php if (isset($_GET['showall']) && $_GET['showall'] == 1) { ?>
        <?php } ?>

        <?php if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>
        <?php } ?>
    </div>

    <?php
    // only show when there is something to submit and enabled
    if ($show_top_submit_button == true) {
    ?>
        <div class="buttonRow top-add-cart">
            <?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit1" name="submit1"'); ?>
        </div>
    <?php } ?>

    <?php
    /**
     * load the list_box_content template to display the products
     */
    if (PRODUCT_LISTING_LAYOUT_STYLE == 'columns') {
        require($template->get_template_dir('tpl_columnar_display.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_columnar_display.php');
    } else { // (PRODUCT_LISTING_LAYOUT_STYLE == 'rows')
        require($template->get_template_dir('tpl_tabular_display.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_tabular_display.php');
    }
    ?>

    <?php
    // only show when there is something to submit and enabled
    if ($show_bottom_submit_button == true) {
    ?>
        <div class="buttonRow forward bottom-add-cart">
            <?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"'); ?>
        </div>
    <?php } ?>

    <?php if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>
    <?php } ?>
</div>

<?php
	if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
?>
</form>
<?php } ?>
</div>