<?php
/**
 * @package Home Page Prodcut Carousels
 * @copyright Copyright 20010-2013 Numinix.com
 * @partial Copyright 2008-2010 RubikIntegration.com
 * @author numinix
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

/**
 * If Home Page Product Carousels is turned on, load files
 */



  if(HPPC_STATUS == 'true') {
    
    global $a_numinix_template_is_in_use;
    
    // numinix template doesn't need to load the css files
    if( $a_numinix_template_is_in_use ) {

      $loaders[] = array(

        /**
         * Only load files on home page
         */
        'conditions' => array(
          'pages' => array('index_home'),
        ),

        /**
         * Load jQuery files
         */
        'jscript_files' => array(
          'jquery/jquery-1.11.3.min.js'                       =>  1,
          'jquery/jquery.lazysizes.min.js'                    =>  2,
          'jquery/jquery.owl.carousel.min.js'                 =>  4,
          'jquery/jquery_hp_product_carousels.js'             =>  5,
          'jquery/jquery_hp_product_carousels.php'            =>  6
        ),

      );

    } else {

      $loaders[] = array(

        /**
         * Only load files on home page
         */
        'conditions' => array(
          'pages' => array('index_home'),
        ),

        /**
         * Load jQuery files
         */
        'jscript_files' => array(
          'jquery/jquery-1.11.3.min.js'                       =>  1,
          'jquery/jquery.lazysizes.min.js'                    =>  2,
          'jquery/jquery.owl.carousel.min.js'                 =>  4,
          'jquery/jquery_hp_product_carousels.js'             =>  5,
          'jquery/jquery_hp_product_carousels.php'            =>  6
        ),

        /**
         * Load CSS files
         */
        'css_files' => array(
          'auto_loaders/jquery.owl.carousel.css'              =>  1,
          'hp_product_carousels.css'                          =>  2,
          'auto_loaders/hp_product_carousels_overrides.css'   =>  3   
        )

      );
    }
  }

