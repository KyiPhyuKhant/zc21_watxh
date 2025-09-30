<?php

$db->Execute("INSERT IGNORE INTO " . TABLE_BANNERS . " (banners_title, banners_url, banners_image, banners_group, banners_html_text, status, banners_on_ssl)
  VALUES 
  ('Unique and Exciting', 'https://www.numinix.com/plugins/zen-cart-plugins/templates/tableau-responsive-template', 'banners/unique.png', 'homepageslide', '', 1, 1)");
