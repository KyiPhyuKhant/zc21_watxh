
<div class="centerColumn" id="accountDefault">
	<h1 class="accountAreaHeading"><?php echo HEADING_TITLE; ?></h1>
	<?php require($template->get_template_dir('tpl_modules_account_nav.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_account_nav.php'); ?>

	<!-- account info -->
	<div class="account-info account-recurring-order">
	<?php if (count($getRecurring) > 0 && !empty($getRecurring)): ?>
		<?php foreach ($getRecurring as $key => $value): ?>

			<!-- recurring order -->
			<div id="recurring_order" class="recurring_order">
				
				<!-- product image/name -->
				<div class="recurring_product">
					<div class="recurring_product_image">
						<?php echo zen_image(DIR_WS_IMAGES . str_replace('"', '', $value['product_image']), $value['product_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, ''); ?>
					</div>
					<span class="recurring_product_name"><?php echo $value['product_name']?></span>
				</div>
				<!-- end/product image/name -->
				
				<!-- recurring details -->
				<div class="recurring_details">
					<div id="status" class="recurring_item recurring_status"><?php echo TEXT_STATUS . $value['status']; ?></div>
					<div id="price_per_unit" class="recurring_item recurring_price_per_unit"><?php echo TEXT_PRICE_PER_UNUT . $value['product_price'] ?></div>
					<div id="qunatity" class="recurring_item recurring_quantity"><?php echo TEXT_QUNATITY . $value['product_qunatity'] ?></div>
					<!-- <div id="total" class="recurring_item recurring_total"><?php echo TEXT_TOTAL . $value['recurring_total'] ?></div> -->
					<div id="start" class="recurring_item recurring_start"><?php echo TEXT_START . $value['format_date_start'] ?></div>
					<!-- <div id="last" class="recurring_item recurring_last"><?php echo TEXT_LAST . $value['format_date_last'] ?></div> -->
					<?php if($value['status'] == 'Active'): ?>
						<!-- <div id="next" class="recurring_item recurring_next"><?php echo TEXT_NEXT.$value['format_date_next'] ?></div> -->
					<?php endif;?>
					<div id="billing_address" class="recurring_item recurring_billing_address"><?php echo TEXT_BILLING.$address_descrip[$value['billing_address']] ?></div>
					<div id="shipping_address" class="recurring_item recurring_shipping_address"><?php echo TEXT_SHIPPING.$address_descrip[$value['shipping_address']] ?></div>
					<div id="shipping_method" class="recurring_item recurring_shipping_method"><?php echo TEXT_SHIPPING_METHOD.$value['shipping_method'] ?></div>

					<?php if($value['status'] == 'Active'): ?>
						<div class="js-hidden-fancybox" id="recurring_pop<?php echo $value['recurring_payments_id']?>">
							<!-- tab nav -->
							<div id="tabs_container">
							    <ul id="tabs">
							        <li class="active"><a href="#tab_detail_<?php echo $value['recurring_payments_id']?>"><?php echo ORDER_DETAIL_TITLE; ?></a></li>
							        <li><a href="#tab_shipping_<?php echo $value['recurring_payments_id']?>"><?php echo SHIPPING_DETAIL_TITLE; ?></a></li>
							        <li><a href="#tab_billing_<?php echo $value['recurring_payments_id']?>"><?php echo BILLING_DETAIL_TITLE; ?></a></li>
							    </ul>
							</div>
							<!-- end/tab nav -->

							<!-- tab content container -->
							<div id="tabs_content_container">

								<!-- tab details -->
								<div id="tab_detail_<?php echo $value['recurring_payments_id']?>" class="tab_content active">
									<div class="recurring_product">
										<div class="recurring_product_image">
											<?php echo zen_image(DIR_WS_IMAGES.str_replace('"','',$value['product_image'])); ?>
										</div>
										<span class="recurring_product_name"><?php echo $value['product_name']?></span>
									</div>
									<form action="<?php echo strtok($_SERVER["REQUEST_URI"],'?');?>" method="GET">
										<input type="hidden" name="main_page" value="account_recurring">
										<div class="tab_row">
											<div class="tab_column">
												<label for="drop_quantity<?php echo $value['recurring_payments_id']?>"><?php echo TEXT_QUNATITY?></label>
												<input type="text" name="qunatity" id="drop_quantity<?php echo $value['recurring_payments_id']?>" value="<?php echo $value['product_qunatity']; ?>">
											</div>
											<div class="tab_column">
												<label for="drop_frequency<?php echo $value['recurring_payments_id']?>"><?php echo TEXT_FREQUENCY; ?></label>
												<p><?php
													if ((int)$value['billing_frequency'] != 7) {
														echo ((int)$value['billing_frequency'] / 7) . " weeks<br>";
														}

													else {
														echo "Every week<br>";
														} ?>
													</p><br>
												<label for="drop_frequency<?php echo $value['recurring_payments_id']?>"><?php echo TEXT_NXT_BILLING; ?></label>
												<p><?php echo $value['next_billing_date']; ?></p>
											</div>
										</div>
										<br><br>

										<input type="hidden" name="recurrID" value="<?php echo $value['recurring_payments_id']?>">
										<input type="hidden" name="action" value="update_order">

										<input class="cssButton" type="submit" value="<?php echo BUTTON_UPDATE; ?>">
									</form>

								</div>
								<!-- end/tab details -->
								<!-- tab shipping -->
								<div id="tab_shipping_<?php echo $value['recurring_payments_id']?>" class="tab_content">  
									<form action="<?php echo strtok($_SERVER["REQUEST_URI"],'?');?>" method="GET">

									 	<input type="hidden" name="main_page" value="account_recurring">
										<div class="tab_row">
											<div class="tab_column">
												<h3><?php echo POPUP_TEXT_SHIPPING_ADDRESS; ?></h3>
												<div class="address-option">
													<?php foreach ($address_descrip as $key => $shipping): ?>
														<label class="label_radio_checkbox">
															<input type="radio" name="shipping_address" value="<?php echo $key; ?>" <?php if ($value['shipping_address'] == $key) echo 'checked'; ?>>
															<span><?php echo str_replace(',', '<br>', $shipping)?></span>
														</label>
												 	<?php endforeach; ?>
												</div>
											</div>
											<div class="tab_column">
												<h3><?php echo POPUP_TEXT_SHIPPING_METHOD; ?></h3>
												<div class="address-option">
													<?php foreach ($value['shipping_quote'] as $quote): ?>
											 			<label class="label_radio_checkbox">
											 				<input type="radio" name="shipping" value="<?php echo $quote["id"]?>" <?php if ($value['payment_module'] == $quote["id"]) echo 'checked';?> >
											 				<span><?php echo $quote['module'].' '.$quote['methods'][0]['title'].'- $'.$quote['methods'][0]['cost']?></span>
											 			</label>
													<?php endforeach; ?>
												</div>
											</div>
										</div>

										<input type="hidden" name="recurrID" value="<?php echo $value['recurring_payments_id']?>">
										<input type="hidden" name="action" value="update_shipping">

										<input class="cssButton" type="submit" value="<?php echo BUTTON_UPDATE; ?>">
									</form>

								</div>
								<!-- end/tab shipping -->
								<!-- tab billing -->
								<div id="tab_billing_<?php echo $value['recurring_payments_id']?>" class="tab_content">  
									<form action="<?php echo strtok($_SERVER["REQUEST_URI"],'?');?>" method="GET">
									 	<input type="hidden" name="main_page" value="account_recurring">
										
										<div class="tab_row">
											<div class="tab_column">
												<h3><?php echo POPUP_TEXT_BILLING_ADDRESS; ?></h3>
												<div class="address-option">
												 	<?php foreach ($address_descrip as $key => $billing): ?>
												 		<label class="label_radio_checkbox">
												 			<input type="radio" name="billing_address" value="<?php echo $key; ?>" <?php if ((int)$value['billing_address'] == (int)$key)  echo 'checked';?>>
												 			<span><?php echo str_replace(',', '<br />', $billing)?></span>
												 		</label>
												 	<?php endforeach; ?>
												</div>
											</div>
											<div class="tab_column">
												<h3><?php echo POPUP_TEXT_BILLING_METHOD; ?></h3>
												<div class="payment-form">
													<label for=""><?php echo POPUP_TEXT_CC_NAME; ?></label>
													<input type="text" class="form-input" id="" name="cc_name">
													<label for=""><?php echo POPUP_TEXT_CC_NUMBER; ?></label>
													<input type="text" class="form-input" id="" name="cc_number">
													<label for=""><?php echo POPUP_TEXT_CC_EXPIRY; ?></label>
													<div class="form-inline">
														<select name="cc_exp_mon" class="form-input--month" id="">
															<option value="01">January — 01</option>
															<option value="02">February — 02</option>
															<option value="03">March — 03</option>
															<option value="04">April — 04</option>
															<option value="05">May — 05</option>
															<option value="06">June — 06</option>
															<option value="07">July — 07</option>
															<option value="08">August — 08</option>
															<option value="09">September — 09</option>
															<option value="10">October — 10</option>
															<option value="11">November — 11</option>
															<option value="12">December — 12</option>
														</select>
														<select name="cc_exp_yr" class="form-input--year" id="">
															<option value="2016">2016</option>
															<option value="2017">2017</option>
															<option value="2018">2018</option>
															<option value="2019">2019</option>
															<option value="2020">2020</option>
															<option value="2021">2021</option>
															<option value="2022">2022</option>
															<option value="2023">2023</option>
														</select>
													</div>
													<label for=""><?php echo POPUP_TEXT_CC_CVV; ?></label>
													<div class="form-inline">
														<input type="text" class="form-input--cvv" name="cc_cvv">
														<span class="form-help--cvv"><?php echo POPUP_TEXT_CC_CVV_NUMBER; ?></span>
													</div>
												</div>
											</div>
										</div>

										<input type="hidden" name="recurrID" value="<?php echo $value['recurring_payments_id']?>">
										<input type="hidden" name="action" value="update_billing">

									 	<input class="cssButton" type="submit" value="<?php echo BUTTON_UPDATE; ?>">
									</form>
								</div>
								<!-- end/tab billing -->
							</div>
							<!-- end/tab content container -->
							
						</div>
						<div class="recurring_buttons">
							<a class="cssButton js-open-fancybox" href="#recurring_pop<?php echo $value['recurring_payments_id']?>">
								<?php echo BUTTON_EDIT_DETAILS; ?>
							</a>
							<a class="cssButton js-open-fancybox-cancel" href="#popup-cancel"><?php echo BUTTON_CANCEL;?></a>
						</div>

						<!-- fancybox delete -->
						<div class="js-hidden-fancybox" id="popup-cancel">
							<h2><?php echo TITLE_CANCEL_ORDER; ?></h2>
							<p><?php echo TEXT_CANCEL_ORDER; ?></p>
							<!-- product image/name -->
							<div class="recurring_product">
								<div class="recurring_product_image">
									<?php echo zen_image(DIR_WS_IMAGES . str_replace('"', '', $value['product_image']), $value['product_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, ''); ?>
								</div>
								<span class="recurring_product_name"><?php echo $value['product_name']?></span>
							</div>
							<!-- end/product image/name -->
							<div class="cancel_buttons">
								<a class="cssButton" href="<?php echo strtok($_SERVER["REQUEST_URI"],'?');?>?main_page=account_recurring&action=cancel&recurrID=<?php echo $value['recurring_payments_id']?>">
										<?php echo BUTTON_YES_CANCEL_ORDER; ?>
								</a>
								<a class="cssButton js-close-fancybox" href="#">
									<?php echo BUTTON_NO_CANCEL_ORDER; ?>
								</a>
							</div>
						</div>
						<!-- end/fancybox delete -->
					<?php endif; ?>
				</div>
				<!-- end/recurring details -->
			</div>
			<!-- end/recurring order -->
			<?php endforeach; ?>
		<?php else: ?>
			<?php echo TEXT_NO_RECURRING; ?>
		<?php endif; ?>
	</div>
	<!-- end/account info -->
</div>