<?php
if (!defined('ABSPATH')) {
	exit();
}
add_action('admin_enqueue_scripts', 'af_wbsf_enqueue_scripts');

function af_wbsf_enqueue_scripts() {

	if (get_current_screen() && get_current_screen()->id && str_contains('woocommerce_page_wc-settings addify_wbs', get_current_screen()->id)) {


		wp_enqueue_style('mli_frontawesome', AF_WBS_URL . 'assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0');
		wp_enqueue_style('af_cmfw_admin_side_stylee', AF_WBS_URL . 'assets/css/admin.css', array(), '1.0.1', false);
		wp_enqueue_style('select2', plugins_url('assets/css/select2.css', WC_PLUGIN_FILE), array(), '5.7.2');

		wp_enqueue_script('select2', plugins_url('assets/js/select2/select2.min.js', WC_PLUGIN_FILE), array( 'jquery' ), '4.0.3', true);
		wp_enqueue_script('af_wbs_admin_js', AF_WBS_URL . 'assets/js/af-wbs-admin.js', array( 'jquery' ), '1.0.3', false);

		$aurgs = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('addify-weight-base-shipping-nonce'),
			'new_group' => 'af_wbs_get_block',
			'new_condition' => 'af_wbs_add_condition',
			'af-wbs-tab-pricing-weight' => 'af_wbs_tab_pricing_weight',
			'af-wbs-tab-pricing-product' => 'af_wbs_tab_pricing_product',
			'af-wbs-tab-pricing-shipping-class' => 'af_wbs_tab_pricing_shipping_class',
			'af-wbs-tab-pricing-category' => 'af_wbs_tab_pricing_category',
			'products' => 'af_wbs_product',
			'categories' => 'af_wbs_category',
			'tags' => 'af_wbs_tags',
			'shipping-class' => 'af_wbs_shipping',
			'userrole' => 'af_wbs_userrole',
			'stock-status' => 'af_wbs_stock_status',
			'customer' => 'af_wbs_customer',
			'text' => 'af_wbs_text',
			'number' => 'af_wbs_number',
			'country' => 'af_wbs_country',
			'state' => 'af_wbs_state',
			'show_shipping_methods_with_shipping_zone' => 'show_shipping_methods_with_shipping_zone',
			'af_wbs_get_shipping_method_type' => af_wbs_get_shipping_method_type(),
			'af_wbs_all_operator' => af_wbs_all_operator(),
		);

		foreach ($aurgs as $key => $functions) {

			if (str_contains('ajaxurl nonce af_wbs_all_operator af_wbs_get_shipping_method_type', $key)) {
				continue;
			}

			ob_start();
			$functions();
			$new_html = ob_get_clean();
			$aurgs[ $key ] = $new_html;

		}
		wp_localize_script('af_wbs_admin_js', 'php_var', $aurgs);
	}
}
