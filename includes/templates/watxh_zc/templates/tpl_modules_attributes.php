<?php

/**
 * Module Template
 *
 * Template used to render attribute display/input fields
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_attributes.php 3208 2006-03-19 16:48:57Z birdbrain $
 */
?>

<?php
// Get the attribute index based on its name
$attr_index = isset($attributes_to_display_index) ? $attributes_to_display_index : 0;

// Ensure the attribute index is within bounds
if ($attr_index >= 0 && $attr_index < sizeof($options_name)) {
  // Get the attribute name, options, and image URL
  $attribute_name = $options_name[$attr_index];
  $attribute_options = $options_menu[$attr_index];
  $attribute_image = isset($options_attributes_image[$attr_index]) ? $options_attributes_image[$attr_index] : '';
?>
<!-- Start of attribute <?php echo $attribute_name; ?> -->
<div class="attributes-<?php echo strtolower(htmlspecialchars($attribute_name)); ?>">
 <header>
  <h3><?php echo htmlspecialchars($attribute_name); ?></h3>
 </header>
 <div class="attributes-<?php echo strtolower(htmlspecialchars($attribute_name)); ?>-main">

  <?php
      // Display attribute options
      echo $attribute_options;
      ?>
 </div>
</div>
<?php
}
?>