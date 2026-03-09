<?php
if (!defined('ABSPATH')) {
	exit();
}

add_action('wp_enqueue_scripts', 'af_wbsf_enqueue_scripts');

function af_wbsf_enqueue_scripts() {


	wp_enqueue_script('af_wbs_ajax', AF_WBS_URL . 'assets/js/front.js', array( 'jquery' ), '1.0.2', false);


	$aurgs = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('addify-weight-base-shipping-nonce'),
	);
	wp_localize_script('af_wbs_ajax', 'php_var', $aurgs);
}
// --------------------------------------------------- we are adding next 3 hook some time   this hook not getting trigger woocommerce_package_rates to get this hook trigger we add these hook and add and subtract quantity.

add_action('woocommerce_before_cart', 'modify_first_cart_item_quantity');
add_action('woocommerce_before_checkout_form', 'modify_first_cart_item_quantity');


function modify_first_cart_item_quantity() {
	// Get the cart contents
	$cart = WC()->cart->get_cart();

	// Check if the cart is not empty
	if (!empty($cart)) {
		// Get the first cart item key
		reset($cart);
		$first_cart_item_key = key($cart);

		// Get the first cart item
		$first_cart_item = $cart[ $first_cart_item_key ];

		// Get the current quantity
		$current_quantity = $first_cart_item['quantity'];

		// Increase the quantity by one
		WC()->cart->set_quantity($first_cart_item_key, $current_quantity + 1);

		// Decrease the quantity by one
		WC()->cart->set_quantity($first_cart_item_key, $current_quantity);
	}
}


// --------------------------------------------------- here is the end of code to trigger the hook.

add_filter('woocommerce_package_rates', 'af_wbs_add_custom_rates', 100, 2);
function af_wbs_add_custom_rates( $package_rates, $package ) {

	$default_pcakage_rate = $package_rates;

	foreach ($default_pcakage_rate as $rate_id => $rate) {

		$current_post_id = af_wbs_created_post_on_default_woocommerce_shipping($rate->get_instance_id());

		if ('yes' != get_post_meta($current_post_id, 'af_wbs_enable_weight_based_shipping', true)) {
			continue;
		}

		if (!af_wbs_check_restriction_for_shippping_method($current_post_id)) {
			unset($package_rates[ $rate_id ]);
			continue;
		}
		$final_price = af_wbs_get_price_for_current_shipping($current_post_id);
		if ('yes' == get_post_meta($current_post_id, 'af_wbs_show_shipping_if_fee_is_zero', true) && $final_price <= 0) {
			unset($package_rates[ $rate_id ]);
			continue;

		}

		if ('yes' == get_post_meta($current_post_id, 'af_wbs_is_taxable', true)) {
			$taxes = WC_Tax::calc_shipping_tax($final_price, WC_Tax::get_shipping_tax_rates());
			$rate->set_taxes($taxes);
		} else {
			$rate->set_taxes(array());
		}
		if ($final_price > 0) {
			$rate->set_cost($final_price);
		}

		$package_rates[ $rate_id ] = $rate;
	}

	$get_created_rule = get_posts(
		array(
			'post_type' => 'addify_wbs',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'fields' => 'ids',
		)
	);
	foreach ($get_created_rule as $current_post_id) {
		if (!af_wbs_check_restriction_for_shippping_method($current_post_id)) {
			continue;
		}
		$final_price = af_wbs_get_price_for_current_shipping($current_post_id);
		if ('yes' == get_post_meta($current_post_id, 'af_wbs_show_shipping_if_fee_is_zero', true) && $final_price <= 0) {
			continue;

		}
		$af_wbs_shipping_title = get_post_meta($current_post_id, 'af_wbs_shipping_title', true);

		$af_wbs_shipping_rate = new WC_Shipping_Rate();
		$af_wbs_shipping_rate->set_id('af_wbs_ship_rule:' . $current_post_id);
		$af_wbs_shipping_rate->set_method_id('af_wbs_ship_rule:' . $current_post_id);
		$af_wbs_shipping_rate->set_instance_id($current_post_id);
		$af_wbs_shipping_rate->set_label($af_wbs_shipping_title);
		$af_wbs_shipping_rate->set_cost($final_price);

		if ('yes' == get_post_meta($current_post_id, 'af_wbs_is_taxable', true)) {
			$taxes = WC_Tax::calc_shipping_tax($final_price, WC_Tax::get_shipping_tax_rates());
			$af_wbs_shipping_rate->set_taxes($taxes);
		} else {
			$af_wbs_shipping_rate->set_taxes(array());
		}

		$package_rates[ $af_wbs_shipping_rate->get_id() ] = $af_wbs_shipping_rate;
	}
	return $package_rates;
}


function af_wbs_check_restriction_for_shippping_method( $current_post_id ) {

	$af_current_user_role = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';
	$af_wbs_conditions = (array) get_post_meta($current_post_id, 'af_wbs_conditions', true);
	$af_wbs_conditions = af_wbs_custom_array_filter($af_wbs_conditions);
	$add_shipping = false;

	$length_width_heigh = af_wbs_get_product_length_width_heigh();
	$all_cart_product_stock_status_array = af_wbs_get_all_product_stock_status_array();
	$all_cart_product_stock_qty_array = af_wbs_get_all_product_stock_qty_array();

	$get_cart_product_shipping_classes = af_wbs_get_cart_product_shipping_classes();

	global $woocommerce;
	if (count($af_wbs_conditions) < 1) {
		return true;
	}

	foreach ($af_wbs_conditions as $condition_block) {

		$condition_block = (array) $condition_block;
		$condition_block = af_wbs_custom_array_filter($condition_block);

		if (count($condition_block) >= 1) {

			foreach ($condition_block as $current_contidition) {

				$current_contidition = (array) $current_contidition;
				$current_contidition = af_wbs_custom_array_filter($current_contidition);
				$condition_type = isset($current_contidition['condition_type']) ? $current_contidition['condition_type'] : '';


				$operator = af_wbs_selected_operator_for_condition($current_contidition);

				$condition_value = isset($current_contidition['condition_value']) ? $current_contidition['condition_value'] : '';

				if (count($current_contidition) >= 1) {
					if (!empty($condition_value)) {

						switch ($condition_type) {

							case 'subtotal':
								$user_data = WC()->cart->get_subtotal();
								break;
							case 'subtotal-excl-tax':
								$user_data = WC()->cart->subtotal_excl_tax;

								$subtotal = 0;
								foreach (wc()->cart->get_cart() as $id => $item) {

									if ($item['line_subtotal'] != $item['line_total']) {

										$subtotal += isset($item['line_subtotal']) ? abs($item['line_subtotal'] - $item['line_subtotal_tax']) : 0;

									} elseif (!empty($item['line_subtotal_tax'])) {

										$subtotal += isset($item['line_subtotal']) ? $item['line_subtotal'] - $item['line_subtotal_tax'] : 0;
									} else {
										$subtotal += isset($item['line_subtotal']) ? $item['line_subtotal'] : 0;
									}
								}
								$user_data = $subtotal;

								break;
							case 'tax':
								$user_data = WC()->cart->tax_total;
								break;
							case 'quantity':
								$user_data = WC()->cart->get_cart_contents_count();
								break;
							case 'width':
								$user_data = (float) $length_width_heigh['width'];
								break;
							case 'weight':
								$user_data = (float) $length_width_heigh['weight'];
								break;
							case 'height':
								$user_data = (float) $length_width_heigh['height'];
								break;
							case 'length':
								$user_data = (float) $length_width_heigh['length'];
								break;
							case 'stock':
								$user_data = $all_cart_product_stock_qty_array ? array_sum($all_cart_product_stock_qty_array) : $condition_value;
								break;
							case 'coupon':
								$user_data = WC()->cart->applied_coupons;

								$condition_value = !empty($condition_value) ? explode(',', $condition_value) : $user_data;
								$condition_value = af_wbs_custom_array_filter($condition_value);

								break;
							case 'zip-code':
								$user_data = $woocommerce->customer->get_billing_postcode();
								break;
							case 'state':
								foreach ((array) $condition_value as $key => $state_value) {
									$country_and_state = explode(',', $state_value);
									if (count($country_and_state) > 1) {
										$condition_value[ $key ] = next($country_and_state);
									}
								}
								$user_data = $woocommerce->customer->get_billing_state();
								break;
							case 'city':
								$condition_value = !empty($condition_value) ? explode(',', $condition_value) : array( $woocommerce->customer->get_billing_city() );
								$user_data = $woocommerce->customer->get_billing_city();
								break;
							case 'country':
								$user_data = $woocommerce->customer->get_billing_country();
								break;
							case 'stock-status':
								$user_data = $all_cart_product_stock_status_array;
								break;
							case 'user-role':
								$user_data = $af_current_user_role;
								break;
							case 'customer':
								$user_data = get_current_user_id();
								break;
							case 'shipping-class':
								$user_data = $get_cart_product_shipping_classes;
								break;

							default:
								$user_data = '';
								break;
						}
						$condition_value = !empty($condition_value) ? $condition_value : $user_data;

						if (!af_wbs_match_operator($condition_value, $user_data, $operator) && count($condition_block) >= 2) {

							return false;
						}

						if (af_wbs_match_operator($condition_value, $user_data, $operator)) {

							$add_shipping = true;
						}

					}

				}

			}
		}
	}

	return $add_shipping;
}


function af_wbs_get_price_for_current_shipping( $current_post_id ) {

	$pricing_condition = (array) get_post_meta($current_post_id, 'af_wbs_weight_price_rule', true);
	$af_wbs_calculate_entire_cart_weight = get_post_meta($current_post_id, 'af_wbs_calculate_entire_cart_weight', true);

	$final_price = 0;
	// echo '<pre>';
	// print_r($pricing_condition);

	$af_wbs_cart_product_details = af_wbs_cart_product_details();

	foreach ($pricing_condition as $pricing_condition_array) {
		if (is_array($pricing_condition_array)) {

			$selection_type = isset($pricing_condition_array['selection_type']) ? $pricing_condition_array['selection_type'] : 'products';
			$selection_items = array();
			$min_weight = isset($pricing_condition_array['min_weight']) ? $pricing_condition_array['min_weight'] : 0;
			$max_weight = isset($pricing_condition_array['max_weight']) ? $pricing_condition_array['max_weight'] : '';
			$price_type = isset($pricing_condition_array['price_type']) ? $pricing_condition_array['price_type'] : 'once';
			$fee = isset($pricing_condition_array['fee']) ? $pricing_condition_array['fee'] : 0;
			$base_price = isset($pricing_condition_array['base_price']) ? (float) $pricing_condition_array['base_price'] : 0;

			if (!empty($af_wbs_calculate_entire_cart_weight)) {

				// echo '<br> ==> ' . $selection_type . ' --- ';

				$af_wbs_array_key = str_replace(array( 'tags', 'products' ), array( 'tag', 'product_id' ), $selection_type);
				$af_wbs_main_key = str_replace(array( 'tags', 'categories', 'shipping-class', 'products' ), array( 'tag', 'category', 'shipping_class', 'selected_products' ), $selection_type);

				$selection_items = isset($pricing_condition_array[ $af_wbs_main_key ]) ? (array) $pricing_condition_array[ $af_wbs_main_key ] : array();

				$total_weight = 0;

				// echo ' selection_items ====>>>> ';

				// print_r($selection_items);

				if (count($selection_items) < 1) {

					foreach ($af_wbs_cart_product_details as $current_product_details) {

						if (is_array($current_product_details)) {

							$current_product_selected_array = isset($current_product_details[ $af_wbs_array_key ]) ? (array) $current_product_details[ $af_wbs_array_key ] : array();

							// echo '<br>---';

							// print_r($current_product_details);

							// print_r($current_product_selected_array);

							// echo ' --> match words ==> ' . count(array_intersect($current_product_selected_array, $selection_items));

							$current_cart_product_weight = isset($current_product_details['weight']) ? (float) $current_product_details['weight'] : 0;
							$current_cart_product_weight *= isset($current_product_details['quantity']) ? $current_product_details['quantity'] : 1;

							$total_weight += (float) $current_cart_product_weight;

						}

					}
					if (( $min_weight >= 0.1 && $min_weight > $total_weight ) || ( $max_weight >= 0.1 && $total_weight > $max_weight )) {
						continue;
					}

					$final_price = 0;
					if ('once' != $price_type) {
						$final_price += $fee * $total_weight;
					} else {
						$final_price += $fee;
					}

					// adding base feee.
					$final_price += $base_price;

					return $final_price;

				} else {
					foreach ($af_wbs_cart_product_details as $current_product_details) {

						if (is_array($current_product_details)) {

							$current_product_selected_array = isset($current_product_details[ $af_wbs_array_key ]) ? (array) $current_product_details[ $af_wbs_array_key ] : array();

							// echo '<br>---';

							// print_r($current_product_details);

							// print_r($current_product_selected_array);

							// echo ' --> match words ==> ' . count(array_intersect($current_product_selected_array, $selection_items));

							if (count(array_intersect($current_product_selected_array, $selection_items)) >= 1) {

								$current_cart_product_weight = isset($current_product_details['weight']) ? (float) $current_product_details['weight'] : 0;
								$current_cart_product_weight *= isset($current_product_details['quantity']) ? $current_product_details['quantity'] : 1;

								$total_weight += (float) $current_cart_product_weight;

							}

						}

					}
					if (( $min_weight >= 0.1 && $min_weight > $total_weight ) || ( $max_weight >= 0.1 && $total_weight > $max_weight )) {
						continue;
					}

					if ('once' != $price_type) {
						$final_price += $fee * $total_weight;
					} else {
						$final_price += $fee;
					}

					// adding base feee.
					$final_price += $base_price;

				}
				// echo '-- > category match current_cart_product_weight ==> ' . $current_cart_product_weight. '  ===> ' . $final_price;
			} else {
				switch ($selection_type) {

					case 'products': // for products.
						$selection_items = isset($pricing_condition_array['selected_products']) ? $pricing_condition_array['selected_products'] : array();
						foreach ($af_wbs_cart_product_details as $current_product_details) {
							if (is_array($current_product_details)) {

								$product_id = isset($current_product_details['product_id']) ? $current_product_details['product_id'] : 0;

								if (count($selection_items) >= 1 && !in_array($product_id, $selection_items)) {
									continue;
								}

								$current_cart_product_weight = isset($current_product_details['weight']) ? (float) $current_product_details['weight'] : 0;
								$current_cart_product_weight *= isset($current_product_details['quantity']) ? $current_product_details['quantity'] : 1;

								if ($min_weight >= 0.1 && $min_weight > $current_cart_product_weight) {

									continue;
								}

								if ($max_weight >= 0.1 && $current_cart_product_weight > $max_weight) {

									continue;
								}

								if ('once' != $price_type) {
									$final_price += $fee * $current_cart_product_weight;
								} else {
									$final_price += $fee;
								}
								// adding base feee.
								$final_price += $base_price;

								// echo $price_type;
								// echo '-- > Product match current_cart_product_weight ==> ' . $current_cart_product_weight . '  ===> ' . $final_price;
							}
						}
						break;
					case 'categories':
						$selection_items = isset($pricing_condition_array['categories']) ? $pricing_condition_array['categories'] : array();

						foreach ($af_wbs_cart_product_details as $current_product_details) {

							if (is_array($current_product_details)) {

								$category_ids_array = isset($current_product_details['categories']) ? (array) $current_product_details['categories'] : array();

								$product_id = isset($current_product_details['product_id']) ? $current_product_details['product_id'] : 0;

								if (count($selection_items) >= 1 && !has_term($selection_items, 'product_cat', $product_id)) {
									continue;
								}

								$current_cart_product_weight = isset($current_product_details['weight']) ? (float) $current_product_details['weight'] : 0;
								$current_cart_product_weight *= isset($current_product_details['quantity']) ? $current_product_details['quantity'] : 1;

								if ($min_weight >= 0.1 && $min_weight > $current_cart_product_weight) {
									continue;
								}

								if ($max_weight >= 0.1 && $current_cart_product_weight > $max_weight) {
									continue;
								}

								if ('once' != $price_type) {
									$final_price += $fee * $current_cart_product_weight;
								} else {
									$final_price += $fee;
								}

								// adding base feee.
								$final_price += $base_price;
								// echo '-- > category match current_cart_product_weight ==> ' . $current_cart_product_weight. '  ===> ' . $final_price;
							}
						}
						break;

					case 'tag':
					case 'tags':
						$selection_items = isset($pricing_condition_array['tag']) ? $pricing_condition_array['tag'] : array();
						foreach ($af_wbs_cart_product_details as $current_product_details) {
							if (is_array($current_product_details)) {

								$tags_ids_array = isset($current_product_details['tag']) ? (array) $current_product_details['tag'] : array();
								$product_id = isset($current_product_details['product_id']) ? $current_product_details['product_id'] : 0;

								if (count($selection_items) >= 1 && !has_term($selection_items, 'product_tag', $product_id)) {
									continue;
								}


								$current_cart_product_weight = isset($current_product_details['weight']) ? (float) $current_product_details['weight'] : 0;
								$current_cart_product_weight *= isset($current_product_details['quantity']) ? $current_product_details['quantity'] : 1;
								// echo '-- > tag match current_cart_product_weight ==> ' . $current_cart_product_weight;

								if ($min_weight >= 0.1 && $min_weight > $current_cart_product_weight) {
									continue;
								}

								if ($max_weight >= 0.1 && $current_cart_product_weight > $max_weight) {
									continue;
								}

								if ('once' != $price_type) {
									$final_price += $fee * $current_cart_product_weight;
								} else {
									$final_price += $fee;
								}
								// adding base feee.
								$final_price += $base_price;
							}
						}
						break;

					case 'shipping-class':
						$selection_items = isset($pricing_condition_array['shipping-class']) ? $pricing_condition_array['shipping-class'] : array();
						foreach ($af_wbs_cart_product_details as $current_product_details) {
							if (is_array($current_product_details)) {

								$shipping_class_ids_array = isset($current_product_details['shipping-class']) ? (array) $current_product_details['shipping-class'] : array();
								$product_id = isset($current_product_details['product_id']) ? $current_product_details['product_id'] : 0;

								if (count($selection_items) >= 1 && !has_term($selection_items, 'product_shipping_class', $product_id)) {
									continue;
								}

								$current_cart_product_weight = isset($current_product_details['weight']) ? (float) $current_product_details['weight'] : 0;
								$current_cart_product_weight *= isset($current_product_details['quantity']) ? $current_product_details['quantity'] : 1;

								//                          echo '-- > shipping-class match current_cart_product_weight ==> ' . $current_cart_product_weight;

								if ($min_weight >= 0.1 && $min_weight > $current_cart_product_weight) {
									continue;
								}

								if ($max_weight >= 0.1 && $current_cart_product_weight > $max_weight) {
									continue;
								}

								if ('once' != $price_type) {
									$final_price += $fee * $current_cart_product_weight;
								} else {
									$final_price += $fee;
								}
								// adding base feee.
								$final_price += $base_price;
							}
						}
						break;
					default:
						break;
				}
			}
		}
	}
	// echo '</pre>';

	return $final_price;
}



function af_wbs_get_product_length_width_heigh() {
	$total_weight = 0;
	$total_height = 0;
	$total_length = 0;
	$width = 0;
	// Loop through each item in the cart to calculate total weight and dimensions
	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		// Retrieve the product object
		$product = $cart_item['data'];

		$total_weight += (float) $product->get_weight() * $cart_item['quantity'];
		$total_height += (float) $product->get_height() * $cart_item['quantity'];
		$total_length += (float) $product->get_length() * $cart_item['quantity'];
		$width += (float) $product->get_width() * $cart_item['quantity'];

	}

	return array(
		'weight' => $total_weight,
		'height' => $total_height,
		'length' => $total_length,
		'width' => $width,
	);
}
function af_wbs_get_all_product_stock_status_array() {
	$stock_status_array = array();
	if (WC()->cart->get_cart()) {
		// Loop through each item in the cart to calculate total weight and dimensions
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			// Retrieve the product object
			$product = $cart_item['data'];
			$stock_status_array[] = $product->get_stock_status();
		}
	}

	return $stock_status_array;
}
function af_wbs_get_all_product_stock_qty_array() {
	$stock_qty_array = array();
	if (WC()->cart->get_cart()) {
		// Loop through each item in the cart to calculate total weight and dimensions
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			// Retrieve the product object
			$product = $cart_item['data'];
			$stock_qty_array[] = $product->get_stock_quantity();
		}
	}

	return $stock_qty_array;
}
function af_wbs_get_cart_product_shipping_classes() {
	$get_shipping_class = array();
	if (WC()->cart->get_cart()) {
		// Loop through each item in the cart to calculate total weight and dimensions
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			// Retrieve the product object
			$product = $cart_item['data'];
			$get_shipping_class[] = $product->get_shipping_class_id();
		}
	}

	return $get_shipping_class;
}

function af_wbs_get_cart_product_tags() {
	$product_tags = array();
	if (WC()->cart->get_cart()) {
		// Loop through each item in the cart to calculate total weight and dimensions
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			// Retrieve the product object
			$product_id = $cart_item['product_id'];

			// Get the product tags
			$tags = wp_get_post_terms($product_id, 'product_tag', array( 'fields' => 'ids' ));

			// Add tags to the array
			if (!empty($tags)) {
				$product_tags = array_merge($product_tags, $tags);
			}

		}
	}

	return $product_tags;
}
function af_wbs_cart_product_details() {

	$cart_products_detail = array();

	// Loop through each item in the cart to calculate total weight and dimensions
	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		// Retrieve the product object
		$product = $cart_item['data'];
		$product_id = $product->get_id();
		$main_product = wc_get_product($cart_item['product_id']);
		$cart_products_detail[ $cart_item_key ] = array(
			'product_id' => $product_id,
			'quantity' => $cart_item['quantity'],
			'stock' => (float) $product->get_stock_quantity(),
			'weight' => (float) $product->get_weight(),
			'width' => (float) $product->get_width(),
			'height' => (float) $product->get_height(),
			'length' => (float) $product->get_length(),
			'categories' => $main_product->get_category_ids(),
			'tag' => wp_get_post_terms($cart_item['product_id'], 'product_tag', array( 'fields' => 'ids' )),
			'shipping-class' => $main_product->get_shipping_class_id(),
		);

	}

	return $cart_products_detail;
}

function af_wbs_match_operator( $admin_selected_value, $user_data, $operator ) {
	//  print_r($operator);
//  print_r($user_data);
//  print_r($admin_selected_value);

	$match_or_not = false;
	switch ($operator) {
		case '=':
			if ($admin_selected_value == $user_data) {
				$match_or_not = true;
			}
			break;
		case '!=':
			if ($admin_selected_value != $user_data) {
				$match_or_not = true;
			}
			break;
		case '>':
			if ($user_data > $admin_selected_value) {
				$match_or_not = true;
			}
			break;
		case '<':
			if ($user_data < $admin_selected_value) {
				$match_or_not = true;
			}
			break;
		case '<=':
			if ($user_data <= $admin_selected_value) {
				$match_or_not = true;
			}
			break;
		case '>=':
			if ($user_data >= $admin_selected_value) {
				$match_or_not = true;
			}
			break;
		case 'included':
			$admin_selected_value = array_map('strtolower', (array) $admin_selected_value);
			$user_data = array_map('strtolower', (array) $user_data);

			if (is_array($admin_selected_value) && is_array($user_data) && array_intersect($admin_selected_value, $user_data)) {

				$match_or_not = true;
			} else if (is_array($admin_selected_value) && !is_array($user_data) && in_array($user_data, $admin_selected_value)) {
				$match_or_not = true;
			} else if (!is_array($admin_selected_value) && is_array($user_data) && in_array($admin_selected_value, $user_data)) {
				$match_or_not = true;
			}

			break;
		case 'excluded':
			$admin_selected_value = array_map('strtolower', (array) $admin_selected_value);
			$user_data = array_map('strtolower', (array) $user_data);

			if (is_array($admin_selected_value) && is_array($user_data) && !array_intersect($admin_selected_value, $user_data)) {
				$match_or_not = true;
			} else if (is_array($admin_selected_value) && !is_array($user_data) && !in_array($user_data, $admin_selected_value)) {
				$match_or_not = true;
			} else if (!is_array($admin_selected_value) && is_array($user_data) && !in_array($admin_selected_value, $user_data)) {
				$match_or_not = true;
			}
			break;
	}
	return $match_or_not;
}
