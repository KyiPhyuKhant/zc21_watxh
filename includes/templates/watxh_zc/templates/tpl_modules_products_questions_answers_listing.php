	<div class="questions-container product-section-content" id="products-questions-listing">
	<!-- bof listing -->
		<div id="vote-answer-result-msg">
			<?php if ( $messageStack->size('products_questions_answers_voting') > 0 ) echo $messageStack->output('products_questions_answers_voting'); ?>
		</div>
		<ul class="questions-list ul-unstyled" id="nmx-products-list">
		<?php foreach ( $products_questions as $products_question ) { ?>
			<li>
				<header class="questions-header">
					<div class="questions-user-details">
						<span class="questions-author"><?php echo $products_question['questions_author']; ?></span>
						<span class="questions-date"><?php echo date('M d, Y', strtotime($products_question['questions_last_modified'])); ?></span>
					</div>
				</header>
				<div class="questions-comment">
					<span class="questions-title">
						<strong class="questions-qa-mark"><?php echo TEXT_QUESTION_Q; ?></strong> <span class="questions-content"><?php echo zen_break_string(nl2br(zen_output_string_protected(stripslashes($products_question['question']))), 60, '-<br />'); ?></span>
					</span>
					<div class="cf questions-answer">
						<strong class="questions-qa-mark"><?php echo TEXT_ANSWER_A; ?></strong> <span class="questions-content"><?php echo zen_break_string(nl2br(zen_output_string_protected(stripslashes($products_question['answer']))), 60, '-<br />'); ?></span>
					</div>
					<div class="questions-helpful nmx-buttons">
						<span><?php echo TEXT_WAS_THIS_ANSWER; ?></span>
						<?php echo zen_draw_form('rate_answer', '', 'post'); ?>
						<input type="hidden" name="answers_id" value="<?php echo (int)$products_question['answers_id']; ?>">
							<button type="submit" class="cssButton js-btn-rate-answer nmx-ml0" name="js_action" value="rate-helpful">
								<span class="nmx-qa-icon-bulb"></span> <?php echo TEXT_HELPFUL; ?><span class="js-number-votes"><?php echo (int)$products_question['helpful']; ?></span>
							</button>
							<button type="submit" class="cssButton js-btn-rate-answer" name="js_action" value="rate-unhelpful">
								<span class="nmx-qa-icon-laugh"></span> <?php echo TEXT_UNHELFUL; ?><span class="js-number-votes"><?php echo (int)$products_question['unhelpful']; ?></span>
							</button>
							<button type="submit" class="cssButton js-btn-rate-answer" name="js_action" value="rate-undecided">
								<span class="nmx-qa-icon-knot"></span> <?php echo TEXT_UNDECIDED; ?><span class="js-number-votes"><?php echo (int)$products_question['undecided']; ?></span>
							</button>
						</form>
					</div>
				</div>
			</li>
		<?php } // endforeach; ?>
		</ul>
	<!-- eof listing -->

	<!-- bof pagination -->
	<?php	if ( $products_questions_total_count > MAX_DISPLAY_PAGE_LINKS ) { ?>
		<?php if ( count($products_questions) >= MAX_DISPLAY_PAGE_LINKS ) { // no show more button for the last page, shitty fix ?>
		<div class="nmx-tac btn btn-load-questions" id="js-btn-continuous">
			<a id="js-btn-show-products" data-btn-loading="<?php echo BUTTON_LOADING_ALT; ?>"  data-btn-original="<?php echo BUTTON_MORE_QUESTIONS_ALT; ?>" class="cssButton cssButton-2" href="#">
				<?php echo BUTTON_MORE_QUESTIONS_ALT; ?>
			</a>
		</div>
		<?php	} // endif; ?>
		<div class="tools-bottom clearBoth" id="js-tools-bottom">
			<div class="tools-product-listing">
				<div class="links-pagination"><?php echo TEXT_RESULT_PAGE . ' ' . $products_questions_display_links; ?></div>
			</div>
		</div>
	<?php	} // endif; ?>
	<!-- eof pagination -->
	</div>