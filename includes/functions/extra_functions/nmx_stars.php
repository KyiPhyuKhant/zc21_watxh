<?php
/**
 * Numinix Stars
 * ===================================
 * Doc: https://bitbucket.org/numinix/tableau2/wiki/Framework%20Functions
*/

if (!function_exists('nmx_stars')) {

	function nmx_stars($product_id, $show_qty_reviews = true) {

		$product_review_average = getAverageForProduct($product_id); 
    	$product_review_total = getReviewCount($product_id);

		// if there is no reviews, don't show stars
		if($product_review_average != "0") {

			// transform rate to percentage
			$rate_percentage = ((int)$product_review_average * 100) / 5;
			
			$stars_html = '
				<div class="nmx-rating-wrap cf">
					<span class="review-stars">
						<span class="review-stars-off nmn-icon-star_outline-review">
							<span class="review-stars-on nmn-icon-star-review" style="width: ' . $rate_percentage . '%">
							</span>
						</span>
					</span>
			';
			if($show_qty_reviews) {
				$stars_html .= ' 
					<span class="review-qty">(' . $product_review_total . ')</span>
				'; 
			}

			$stars_html .= '</div>';
			
			return $stars_html;
		}

	}
}
