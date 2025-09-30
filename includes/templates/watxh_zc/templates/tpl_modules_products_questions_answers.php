<?php
/**
 * Products Questions Answers
 */

if ( PRODUCTS_QUESTIONS_ANSWERS_ENABLED == 'true' ) {
	require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCTS_QUESTIONS_ANSWERS));
?>

<section class="ask-answer nmx nmx-wrapper" id="ask-answer" products-id="<?php echo $_GET['products_id']; ?>">
	<h2 class="nmx-mt0"><?php echo TITLE_ASK_ANSWER; ?></h3>
<!-- bof products questions answers listing -->
<?php if ( !empty($products_questions) ) { ?>
	<header>
		<!-- bof sort by filter -->
		<div class="product-section-filter">
			<span><?php echo TEXT_QUESTIONS; ?></span>
			<dl>
				<dt><?php echo FILTER_SORT_BY; ?></dt>
				<dd><a class="js-sort-questions is-active" sort-by="new" href="#"><?php echo FILTER_SORT_NEW; ?></a></dd>
				<dd><a class="js-sort-questions" sort-by="helpful" href="#"><?php echo TEXT_HELPFUL; ?></a></dd>
				<dd><a class="js-sort-questions" sort-by="unhelpful" href="#"><?php echo TEXT_UNHELFUL; ?></a></dd>
				<dd><a class="js-sort-questions" sort-by="undecided" href="#"><?php echo TEXT_UNDECIDED; ?></a></dd>
			</dl>
		</div>
		<!-- eof sort by filter -->
	</header>

	<?php require($template->get_template_dir('/tpl_modules_products_questions_answers_listing.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_products_questions_answers_listing.php'); ?>

<?php } else { ?>
	<div class="no-questions">
		<?php echo TEXT_BE_THE_FIRST; ?>
	</div>
<?php } // endif; ?>
<!-- eof products questions answers listing -->

<?php if (PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS == 'true' || !empty($_SESSION['customer_id'])) { ?>

	<!-- bof Ask question form <form> -->
	<?php echo zen_draw_form('ask_question', '', 'post', 'class="ask-question nmx-form nmx-cf" id="ask-question-form"'); ?>
		<input type="hidden" name="products_id" value="<?php echo (int)$_GET['products_id']; ?>">
		<h3><?php echo TITLE_ASK_QUESTION; ?></h3>

		<div id="ask-question-result-msg">
			<?php if ( $messageStack->size('products_questions_answers') > 0 ) echo $messageStack->output('products_questions_answers'); ?>
		</div>
		<div class="nmx-form-group">
			<label class="inputLabel" for="ask-nickname"><?php echo LABEL_NICKNAME; ?> <span class="alert">*</span></label>
			<input type="text" name="author" placeholder="<?php echo LABEL_NICKNAME_PLACEHOLDER; ?>" id="ask-nickname" value="">
		</div>
		<?php if (PRODUCTS_QUESTIONS_ANSWERS_EMAIL_ADDRESS_FIELD_ENABLED == 'true') { ?>
		<div class="nmx-form-group">
			<label class="inputLabel" for="ask-emailaddress"><?php echo LABEL_EMAILADDRESS; ?> <span class="alert">*</span></label>
			<input type="text" name="author_email_address" placeholder="<?php echo LABEL_EMAILADDRESS_PLACEHOLDER; ?>" id="ask-emailaddress" value="">
		</div>
		<?php } ?>
		<div class="nmx-form-group">
			<label class="inputLabel" for="ask-question"><?php echo LABEL_YOUR_QUESTION; ?> <span class="alert">*</span></label>
			<textarea name="question" placeholder="<?php echo LABEL_YOUR_QUESTION_PLACEHOLDER; ?>" id="ask-question" ></textarea>
		</div>

		<?php if ( PRODUCTS_QUESTIONS_ANSWERS_ALLOW_QUESTS_ASKING_QUESTIONS == 'true' && PRODUCTS_QUESTIONS_ANSWERS_GOOGLE_RECAPTCHA_SITE_KEY != '' ) { ?>
			<div class="nmx-form-group">
				<div class="g-recaptcha" data-sitekey="<?php echo PRODUCTS_QUESTIONS_ANSWERS_GOOGLE_RECAPTCHA_SITE_KEY; ?>"></div>
			</div>
		<?php } // endif; ?>
		<div class="nmx-buttons">
			<button type="submit" class="cssButton" name="js_action" value="ask_question"><?php echo BUTTON_FIRE_AWAY_ALT; ?></button>
		</div>
	</form>
	<!-- eof Ask question form -->
<?php } else { ?>
<?php echo LOG_IN_REQUEST_MSG; ?>
<?php } ?>
</section>
<?php
	if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id']) {
    	$_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => $current_page_base, 'get' => $_GET));
  	} 
?>
<div id="js-nmx-popalert" class="nmx nmx-popalert">
	<div class="nmx-pop-content">
		<p><?php echo POPUP_ALERT_LOG_MESSAGE; ?></p>
		<div class="nmx-buttons">
			<a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>" class="cssButton"><?php echo POPUP_BUTTON_LOG_IN; ?></a>
			<a href="#" class="js-close-nmx-popalert"><?php echo POPUP_BUTTON_CLOSE; ?></a>
		</div>
	</div>
</div>
<br/><br/>
<?php
} // endif;
?>