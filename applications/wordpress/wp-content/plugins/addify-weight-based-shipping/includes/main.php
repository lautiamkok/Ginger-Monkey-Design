<?php
add_action('init', 'af_wbsf_check_woocommerce_is_defined_or_not');
function af_wbsf_check_woocommerce_is_defined_or_not() {
	if (defined('WC_PLUGIN_FILE')) {

		include AF_WBS_DIR . 'includes/general-functions.php';
		include AF_WBS_DIR . 'includes/ajax-functions.php';

		if (is_admin()) {
			include_once AF_WBS_DIR . 'includes/admin/af-wbs-admin.php';
			include_once AF_WBS_DIR . 'includes/admin/meta-box/adding-meta-box.php';
			include_once AF_WBS_DIR . 'includes/admin/setting/setting.php';

		} else {
			include_once AF_WBS_DIR . 'includes/front/af-wbs-front.php';
		}

		$labels = array(
			'name' => esc_html__('Shipping By Weight', 'addify-weight-based-shipping'),
			'singular_name' => esc_html__('Shipping By Weight', 'addify-weight-based-shipping'),
			'add_new' => esc_html__('Add New Rule', 'addify-weight-based-shipping'),
			'add_new_item' => esc_html__('Add Rule', 'addify-weight-based-shipping'),
			'edit_item' => esc_html__('Edit Rule', 'addify-weight-based-shipping'),
			'new_item' => esc_html__('New Rule', 'addify-weight-based-shipping'),
			'view_item' => esc_html__('View Rule', 'addify-weight-based-shipping'),
			'search_items' => esc_html__('Search Rule', 'addify-weight-based-shipping'),
			'exclude_from_search' => true,
			'not_found' => esc_html__('No rule found', 'addify-weight-based-shipping'),
			'not_found_in_trash' => esc_html__('No rule found in trash', 'addify-weight-based-shipping'),
			'parent_item_colon' => '',
			'all_items' => esc_html__('Shipping By Weight', 'addify-weight-based-shipping'),
			'menu_name' => esc_html__('Shipping By Weight', 'addify-weight-based-shipping'),
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'show_in_menu' => 'woocommerce',
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 30,
			'rewrite' => array(
				'slug' => 'addify_wbs',
				'with_front' => false,
			),
			'supports' => array( 'title', 'page-attributes' ),
		);
		register_post_type('addify_wbs', $args);
		// hidden post of already shipping created with woocommerce.
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 30,
			'rewrite' => array(
				'slug' => 'addify_wbs_a_s_c_f_w',
				'with_front' => false,
			),
			'supports' => array( 'title' ),
		);
		register_post_type('addify_wbs_a_s_c_f_w', $args);

	}
}


add_action('wp_loaded', 'addify_wbs_load_text_domain');
function addify_wbs_load_text_domain() {
	if (function_exists('load_plugin_textdomain')) {
		load_plugin_textdomain('addify-weight-based-shipping', false, AF_WBS_DIR . '/languages/');
	}
}
