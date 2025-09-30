// default
var productListingSelectors = '#nmx-products-list',
	nextPageSelector = '#js-tools-bottom .next-button',
	next_link = null,
	morePages = false,
	next_link_number = 1,
	viewMoreMaxRes = 980,
	buttonViewMore = '#js-btn-show-products';

// options
var continousOptions = {
	scrollAutoLoadingProduct: false // change to true to enable scroll auto loading products
}

// programming stuff
// we need to show the button, if there is pagination right
jQuery(function() {
	continuous_scroll();
});

function continuous_scroll()
{
	// if there is no javascipt we should show the pagination
	// button show more has the oposite behavior
	jQuery("#js-tools-top").hide();
	jQuery("#js-tools-bottom").hide();
	jQuery("#productsListingTopNumber").css("display","inline-block");

	// get url from next page
	next_link = jQuery('.next-button').parent().attr('href');

	// if there is more pages
	morePages = next_link != null;

	// there is more?
	if (morePages) {

		// show button
		jQuery(buttonViewMore).parent().show();

		// button event
		jQuery(buttonViewMore).on("click", function(e) {

			// check if buttons has the loading
			// if it's loading, user shouldn't be able load more products
			if (!jQuery(this).hasClass("is--loading")) {

				// add loading message to button
				jQuery(buttonViewMore).addClass("is--loading");
				jQuery(buttonViewMore).html(jQuery(buttonViewMore).attr('data-btn-loading'));

				// go get the products
				loadProducts();
			}

			// prevent default action
			e.preventDefault();
		});
	}

}

function cacheProductPage(param) {
	jQuery.get(next_link, function(data) {
		products = jQuery('#productListingSeparator, .displayProductsContainer, .navSplitPagesLinks', data).remove().end().find(productListingSelectors).html();
		// get next link
		next_link = jQuery(data).find(nextPageSelector).parent().attr('href');
		// load products from next page
		jQuery(productListingSelectors).append(products);
		// remove loading from button.. change content back to Show more
		jQuery(buttonViewMore).removeClass("is--loading");
		jQuery(buttonViewMore).html(jQuery(buttonViewMore).attr('data-btn-original'));
		// check if there is more pages
		morePages = next_link != null;
		if( !morePages ) {
			jQuery(buttonViewMore).remove();
		}
	});
}

function loadProducts() {
	if( morePages ) {
		next_link_number = getParameter(next_link, 'page'); // next_link is a global variable
		cacheProductPage();
	}

	if( !morePages && cached_pages.length == 0) {
		next_link_number = next_link_number + 1;
	}
}


function getParameter(url, paramName) {
	var searchString = url,
			i, val, params = searchString.split("?");

	for (i=0;i<params.length;i++) {
		val = params[i].split("=");
		if (val[0] == paramName) {
			return unescape(val[1]);
		}
	}
	return null;
}
