<?php
$nonce = isset($_POST['af_wbsf_nonce']) ? sanitize_text_field(wp_unslash($_POST['af_wbsf_nonce'])) : '';
if (isset($_POST['af_wbs_shipping_title']) && !wp_verify_nonce($nonce, 'af_wbsf_nonce')) {
	wp_die(esc_html__('Security Violate!', 'addify-weight-based-shipping'));
}
// For custom post type:
$exclude_statuses = array(
	'auto-draft',
	'trash',
);
$current_post_action = isset($_GET['action']) ? sanitize_text_field(wp_unslash($_GET['action'])) : '';

if (!in_array(get_post_status($post_id), $exclude_statuses) && !is_ajax() && 'untrash' != $current_post_action) {

	// Save your data
	$af_wbs_shipping_title = isset($_POST['af_wbs_shipping_title']) ? sanitize_text_field(wp_unslash($_POST['af_wbs_shipping_title'])) : '';
	update_post_meta($post_id, 'af_wbs_shipping_title', $af_wbs_shipping_title);

	$af_wbs_enable_weight_based_shipping = isset($_POST['af_wbs_enable_weight_based_shipping']) ? sanitize_text_field(wp_unslash($_POST['af_wbs_enable_weight_based_shipping'])) : '';
	update_post_meta($post_id, 'af_wbs_enable_weight_based_shipping', $af_wbs_enable_weight_based_shipping);

	$af_wbs_show_shipping_if_fee_is_zero = isset($_POST['af_wbs_show_shipping_if_fee_is_zero']) ? sanitize_text_field(wp_unslash($_POST['af_wbs_show_shipping_if_fee_is_zero'])) : '';
	update_post_meta($post_id, 'af_wbs_show_shipping_if_fee_is_zero', $af_wbs_show_shipping_if_fee_is_zero);

	$af_wbs_calculate_entire_cart_weight = isset($_POST['af_wbs_calculate_entire_cart_weight']) ? sanitize_text_field(wp_unslash($_POST['af_wbs_calculate_entire_cart_weight'])) : '';
	update_post_meta($post_id, 'af_wbs_calculate_entire_cart_weight', $af_wbs_calculate_entire_cart_weight);

	$af_wbs_shipping_cost = isset($_POST['af_wbs_shipping_cost']) ? sanitize_text_field(wp_unslash($_POST['af_wbs_shipping_cost'])) : '';
	update_post_meta($post_id, 'af_wbs_shipping_cost', $af_wbs_shipping_cost);

	$af_wbs_is_taxable = isset($_POST['af_wbs_is_taxable']) ? sanitize_text_field(wp_unslash($_POST['af_wbs_is_taxable'])) : '';
	update_post_meta($post_id, 'af_wbs_is_taxable', $af_wbs_is_taxable);

	if (isset($_POST['tax_field_name'])) {
		$tax_field_name = sanitize_text_field(wp_unslash($_POST['tax_field_name']));
		$af_wbs_is_taxable = isset($_POST[ $tax_field_name ]) ? sanitize_text_field(wp_unslash($_POST[ $tax_field_name ])) : 'no';
		if ('taxable' === $af_wbs_is_taxable) {
			$af_wbs_is_taxable = 'yes';
		}
		update_post_meta($post_id, 'af_wbs_is_taxable', $af_wbs_is_taxable);
	}

	$af_wbs_conditions = isset($_POST['af_wbs_conditions']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_conditions']), '') : array();
	update_post_meta($post_id, 'af_wbs_conditions', $af_wbs_conditions);

	$af_wbs_condition_type = isset($_POST['af_wbs_condition_type']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_condition_type']), '') : array();
	update_post_meta($post_id, 'af_wbs_condition_type', $af_wbs_condition_type);

	$af_wbs_condition_operator = isset($_POST['af_wbs_condition_operator']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_condition_operator']), '') : array();
	update_post_meta($post_id, 'af_wbs_condition_operator', $af_wbs_condition_operator);

	$af_wbs_condition_value = isset($_POST['af_wbs_condition_value']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_condition_value']), '') : array();
	update_post_meta($post_id, 'af_wbs_condition_value', $af_wbs_condition_value);

	$af_wbs_weight_price_rule = isset($_POST['af_wbs_weight_price_rule']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_weight_price_rule']), '') : array();
	update_post_meta($post_id, 'af_wbs_weight_price_rule', $af_wbs_weight_price_rule);

	$af_wbs_product_price_rule = isset($_POST['af_wbs_product_price_rule']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_product_price_rule']), '') : array();
	update_post_meta($post_id, 'af_wbs_product_price_rule', $af_wbs_product_price_rule);

	$af_wbs_shipping_class_price_rule = isset($_POST['af_wbs_shipping_class_price_rule']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_shipping_class_price_rule']), '') : array();
	update_post_meta($post_id, 'af_wbs_shipping_class_price_rule', $af_wbs_shipping_class_price_rule);

	$af_wbs_category_price_rule = isset($_POST['af_wbs_category_price_rule']) ? sanitize_meta('', wp_unslash($_POST['af_wbs_category_price_rule']), '') : array();
	update_post_meta($post_id, 'af_wbs_category_price_rule', $af_wbs_category_price_rule);

}
