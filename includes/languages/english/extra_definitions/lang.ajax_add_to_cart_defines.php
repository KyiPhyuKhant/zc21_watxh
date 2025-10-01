<?php
  /*
  * Copyright 2013 Numinix Web Development Ltd, All rights reserved.
  */
  //ZC1.5.8 Constant definitions
   $define = [
    'AJSC_ITEMS_ADDED_HEADING' => 'Items Added to Cart',
    'AJSC_CONTINUE_SHOPPING' => 'Continue Shopping',
    'AJSC_CHECKOUT' => 'Checkout',
    'AJSC_QTY' => 'Qty:'
  ];
  
  $zc158 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= '5.8'));
  if ($zc158) {
      return $define;
  } else {
      nmx_create_defines($define);
  }