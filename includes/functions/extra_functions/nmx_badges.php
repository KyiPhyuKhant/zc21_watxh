<?php
/**
 * Numinix Badges
 * ===================================
 * Doc: https://bitbucket.org/numinix/tableau2/wiki/Framework%20Functions
*/

  function nmx_badges($product_id) {
      return nmx_badge_new_product($product_id) . nmx_badge_sale_product($product_id);
  }

  // get badge for new products
  function nmx_badge_new_product($product_id){
    global $db;

    $return_data = '';
    $limit = (int)SHOW_NEW_PRODUCTS_LIMIT;

    $product_settings = array(
                  7 => 7,
                  14 => 14 ,
                  30 => 30 ,
                  60 => 60 ,
                  90 => 90 ,
                  120 => 120 
    );

    // all products
    if ($limit == 0) { 
      $return_data = '<span class="badge-new" data-badge-content="' . TEXT_BADGE_NEW . '">' . TEXT_BADGE_NEW . '</span>';
    }
      
    // this Month
    if ($limit == 1) {
        
        $product_date = $db->Execute('SELECT products_id FROM ' . TABLE_PRODUCTS . '
          WHERE products_id = ' . (int)$product_id . '
          AND date_format(products_date_added, "%Y-%m") = date_format(now(), "%Y-%m")'
        );

        if ((int)$product_date->fields['products_id'] == (int)$product_id) {
          $return_data = '<span class="badge-new" data-badge-content="' . TEXT_BADGE_NEW . '">' . TEXT_BADGE_NEW . '</span>';
        } 

        unset($product_date); 
    }

    //Product Settings day
    if (isset($product_settings[$limit])){

      $product_date = $db->Execute('SELECT products_id FROM '.TABLE_PRODUCTS.' WHERE products_id = '.(int)$product_id.' AND 
        date_format(products_date_added, "%Y-%m-%d") BETWEEN CURDATE() - INTERVAL '.$product_settings[$limit].' DAY AND CURDATE()');

      if ((int)$product_date->fields['products_id'] == (int)$product_id) {
        $return_data = '<span class="badge-new" data-badge-content="' . TEXT_BADGE_NEW . '">' . TEXT_BADGE_NEW . '</span>';	
      }
    }

    unset($limit);

    return $return_data;
  }

  // get badge for sale products
  function nmx_badge_sale_product($product_id){
    global $db;

    $return_data = '';
    $product_id = (int)$product_id;
    
      $product_info = 'SELECT p.products_id,pc.categories_id
            FROM   ' . TABLE_PRODUCTS . ' p
            LEFT JOIN '.TABLE_PRODUCTS_TO_CATEGORIES.' pc ON pc.products_id = ' . $product_id . '
            WHERE  p.products_status = 1
            AND    p.products_id = ' . $product_id;

      $product_info = $db->Execute($product_info);   

      if ($product_info->fields['categories_id'] != '' && !empty($product_info->fields['categories_id'])){
        $sale_ends = $db->Execute('SELECT DATE_FORMAT(`sale_date_end`,\'%M %d %Y\') as sale_date_end, sale_specials_condition  FROM '.TABLE_SALEMAKER_SALES.' WHERE 
          ( `sale_categories_selected` LIKE "%'.(int)$product_info->fields['categories_id'].'%" OR `sale_categories_all` LIKE "%'.(int)$product_info->fields['categories_id'].'%") ');
        if  (isset($sale_ends->fields['sale_date_end']) && !is_null($sale_ends->fields['sale_date_end']) && !empty($sale_ends->fields['sale_date_end'])){
            if ((int)$sale_ends->fields['sale_specials_condition'] == 0){// Then Use the Sales Maker condition
              
              if ( (int)date('d') == (int)substr($sale_ends->fields['sale_date_end'] , 0, 2) && (int)date('m') == (int)substr($sale_ends->fields['sale_date_end'] , 3, 4) ) {
                $sale_ends->fields['sale_date_end'] = 'Today';
              }
              $return_data = '<span class="badge-sale" data-badge-content="' . TEXT_BADGE_SALE . '">' . TEXT_BADGE_SALE . '</span>';
            } 
        } else {
          $return_data = '';
        }
      }

      if ($return_data === ''){
        $sale_ends = $db->Execute('SELECT DATE_FORMAT(`expires_date`,\'%M %d %Y\') as sale_date_end FROM '.TABLE_SPECIALS.' WHERE products_id ='.$product_id);
        if  (isset($sale_ends->fields['sale_date_end']) && !is_null($sale_ends->fields['sale_date_end']) && !empty($sale_ends->fields['sale_date_end'])){
            
            if ( (int)date('d') == (int)substr($sale_ends->fields['sale_date_end'] , 0, 2) && (int)date('m') == (int)substr($sale_ends->fields['sale_date_end'] , 3, 4) ) {
                $sale_ends->fields['sale_date_end'] = 'Today';
            }
            $return_data = '<span class="badge-sale" data-badge-content="' . TEXT_BADGE_SALE . '">' . TEXT_BADGE_SALE . '</span>';

        } else {
          $return_data = '';
        }      
      }

      return $return_data;
  }

?>