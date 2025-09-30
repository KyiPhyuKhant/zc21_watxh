jQuery(document).ready(function() {
	// --- close popalert
	var btnClosePop = jQuery('.js-close-nmx-popalert'),
		conPop = jQuery('#js-nmx-popalert');

	btnClosePop.on('click', function(e) {
		e.preventDefault();
		conPop.removeClass('is-active');
	});

	// --- ajax call on ask_question form submit
	jQuery(document).on('submit', 'form[name=ask_question]', function(event) {
		//event.preventDefault();
		product_questions_loading();
		scrollTarget('#ask-question-form');
		var this_form = jQuery(this);
		var submit_button = jQuery("button[type='submit']", this); // get the submit button that is clicked

		// if guests are allowed to ask questions, fire form submit right away
		if ( PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS ) {
			var response = products_questions_answers_ajax_form_submit(this_form, submit_button.attr("value"));
			// update form submit result message
			jQuery('#ask-question-result-msg').html(jQuery(response.responseText).html());
		} else {
			// check for login first if guests are not allowed to ask questions
			jQuery.ajax({
				url: ajax_login_check_url,
				type: 'GET',
				success: function ( login_check ) {
					console.log(login_check);
					if ( parseInt(login_check) == 1 ) {
						var response = products_questions_answers_ajax_form_submit(this_form, submit_button.attr("value"));
						console.log(response);
						// update form submit result message
						jQuery('#ask-question-result-msg').html(jQuery(response.responseText).html());
					} else {
						conPop.addClass('is-active');
						product_questions_stop_loading();
					}
				}
			});
		}

		return false;
	});

	jQuery('form[name=rate_answer] button[type="submit"]').on('click', function(){
	      jQuery(this).parent().data('button', this.value);
	});


	// --- ajax call on rate_answer form submit
	jQuery(document).on('submit', 'form[name=rate_answer]', function(event) {
		product_questions_loading();
		var this_form = jQuery(this);
		var submit_button_value = jQuery(this).data('button'); // get the submit button that is clicked

		//check for login first
		jQuery.ajax({
			url: ajax_login_check_url,
			type: 'GET',
			success: function ( login_check ) {
				console.log(login_check);
				if ( parseInt(login_check) == 1 ) {
					var response = products_questions_answers_ajax_form_submit(this_form, submit_button_value);

					if ( parseInt(response.responseText) == 1 ) {
						// increase current vote by 1
						var current_vote = this_form.find('button[value=' + submit_button_value + '] span.js-number-votes');
						var current_vote_value = current_vote.html();
						current_vote.html(parseInt(current_vote_value) + 1);
						jQuery('#vote-answer-result-msg').html('');

					} else {
						// update form submit result message
						scrollTarget('#ask-answer');
						jQuery('#vote-answer-result-msg').append('<div class="messageStackError nmx-mb0">' + jQuery(response.responseText).html() + '</div>');

					}
					product_questions_stop_loading();
				} else {
					conPop.addClass('is-active');
					product_questions_stop_loading();
				}
			}
		});

		return false;
	});

	// --- ajax call for sortby filter
	jQuery(document).on('click', '.js-sort-questions', function(event) {
		product_questions_loading();
		var this_filter = jQuery(this);
		var products_id = jQuery('#ask-answer').attr('products-id');
		var sort_by = jQuery(this).attr('sort-by');

		// check for login first
		jQuery.ajax({
			url: ajax_products_questions_answers_url,
			type: 'GET',
			data: {
				'products_id': products_id,
				'sort_by': sort_by
			},
			success: function ( response ) {
				// update questions listing
				jQuery('#products-questions-listing').html(jQuery(response).html());
				
				// update current selected sortby filter
				jQuery('.js-sort-questions').removeClass('is-active');
				this_filter.addClass('is-active');
				product_questions_stop_loading();
			}
		});

		return false;
	});

});

function product_questions_loading() {
	jQuery("body").append('<div class="nmx-loading"></div>');
}

function product_questions_stop_loading() {
	jQuery('.nmx-loading').remove();
}

function scrollTarget( element ) {
	jQuery("html, body").animate({ scrollTop: jQuery(element).offset().top }, 500);
}

function products_questions_answers_ajax_form_submit( form, submit_button_value ) {
	return jQuery.ajax({
		url: ajax_products_questions_answers_url,
		async: false,
		data: form.serialize() + '&'
				+ encodeURI("js_action")
				+ '='
				+ encodeURI(submit_button_value), // this is to get around the fact that .serialize() doesn't record buttons
		type: 'POST'
	});
}
