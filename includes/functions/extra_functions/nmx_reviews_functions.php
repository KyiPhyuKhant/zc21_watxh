<?php

/**
 * Get average review for product
 * @param products_id int
 * @return reviews average int
 */
function getAverageForProduct($products_id) {
	global $db;
	$review = $db->Execute('SELECT AVG( reviews_rating ) AS average FROM ' . TABLE_REVIEWS . ' WHERE products_id =' . $products_id);
	return $review->fields['average'] ? round($review->fields['average']) : 0;
}

/**
 * Get reviews count for product id
 * @param products_id int
 * @return reviews_count int
 */
function getReviewCount($products_id) {
	global $db;
	$reviews = $db->Execute("select count(*) as count from " . TABLE_REVIEWS . " where products_id = '" . $products_id . "' and status = 1");
  return $reviews->fields['count'];
}

/**
 * Get Reviews for products id
 * @param $products_id int
 * @return $reviewsArray array
 */
function getReviewsForProductId($products_id) {
	global $db;
	$review_status = " and r.status = 1";


  switch ($_GET['disp_order']) {
    case '1':
      $order_by = 'r.reviews_rating DESC';
      break;
    case '2':
      $order_by = 'r.reviews_rating ASC';
      break;
    case '3':
      $order_by = 'r.date_added DESC';
      break;
    case '4':
      $order_by = 'r.date_added ASC';
      break;      
    default:
      $order_by = 'r.reviews_rating DESC';
      break;
  }

  $reviews_query_raw = "SELECT r.reviews_id, rd.reviews_text as reviews_text, r.reviews_rating, r.date_added, r.reviews_recommended, r.customers_name
                        FROM " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                        WHERE r.products_id = :productsID
                        AND r.reviews_id = rd.reviews_id
                        AND rd.languages_id = :languagesID " . $review_status . "
                        ORDER BY " . $order_by;

  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':productsID', $products_id, 'integer');
  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $reviews = $db->Execute($reviews_query_raw);
  $reviewsArray = array();
  while (!$reviews->EOF) {
    // bof customization for ILEC
    $customers_name = getShortenedCustomerName($reviews->fields['customers_name']);
    // eof customization for ILEC

  	$reviewsArray[] = array('id'=>$reviews->fields['reviews_id'],
  	                        'customersName'=>$customers_name, // customization for ILEC
  	                        'dateAdded'=>$reviews->fields['date_added'],
  	                        'reviewsText'=>$reviews->fields['reviews_text'],
                            'rewiewsRecommended'=>$reviews->fields['reviews_recommended'],
  	                        'reviewsRating'=>$reviews->fields['reviews_rating']);
    $reviews->MoveNext();
  }
	return $reviewsArray;
}

// bof customization for ILEC
function getShortenedCustomerName($name) {
    // display first name only, all later words are translated into intials
    $customers_name_array = explode(' ', $name);
    for( $i=1; $i<count($customers_name_array); $i++ ){
      $customers_name_array[$i] = strtoupper($customers_name_array[$i][0].'.');
    }
    return trim(implode(' ', $customers_name_array));

}
// eof customization for ILEC

/**
 * Get random reviews
 * @param $limit int
 * @return $reviewsArray array
 */
function getRandomReviews($limit = 20) {
	global $db;
  $reviews_query_raw = "SELECT r.reviews_id, r.products_id, rd.reviews_text, r.reviews_rating, r.date_added, r.customers_name
                        FROM " . TABLE_REVIEWS . " r
                        LEFT JOIN " . TABLE_REVIEWS_DESCRIPTION . " rd ON (rd.reviews_id = r.reviews_id)
                        WHERE rd.languages_id = :languagesID
                        AND r.status = 1
                        ORDER BY RAND()
                        LIMIT " . $limit;

  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $reviews = $db->Execute($reviews_query_raw);
  $num_rows = $reviews->RecordCount();
  $reviewsArray = array();
  if ($num_rows > 0) {
    while (!$reviews->EOF) {

    $customers_name = getShortenedCustomerName($reviews->fields['customers_name']);

     $reviewsArray[] = array('id'=>$reviews->fields['reviews_id'],
                             'productId'=>$reviews->fields['products_id'],
                             'customersName'=>$customers_name,
                             'dateAdded'=>$reviews->fields['date_added'],
                             'reviewsText'=>$reviews->fields['reviews_text'],
                             'reviewsRating'=>$reviews->fields['reviews_rating'],
                             'reviewsTitle'=>$reviews->fields['reviews_title']); 
     
      $reviews->MoveNext();
    }
  }
	return $reviewsArray;
}

/**
 * This function cannot process with the float: 4.20234..
 */
function array_average_nonzero($arr) {

  $divisor = count(array_filter($arr));
  if ($divisor > 0) { 
  	return array_sum($arr) / $divisor;
  } else {
  	return 0;
  } 
}

/**
 * Get recommendation of reviews
 */
function reviewsRecommended($productId) {
  global $db;
  $productId = (int)zen_get_prid($productId);
  $sql = 'SELECT (SUM(reviews_recommended)/COUNT(reviews_id))*100 as recommended FROM ' . TABLE_REVIEWS . ' WHERE products_id = ' . $productId;
  $review = $db->Execute($sql);
  return round($review->fields['recommended']);
}

