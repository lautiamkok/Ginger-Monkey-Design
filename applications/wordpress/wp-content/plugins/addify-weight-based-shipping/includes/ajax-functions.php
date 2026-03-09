<?php
add_action(
	'wp_ajax_af_wbs_live_search',
	function () {
		$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : 0;

		if (!wp_verify_nonce($nonce, 'addify-weight-base-shipping-nonce')) {

			die(esc_html__('Failed ajax security check!', 'addify-weight-based-shipping'));

		}

		$pro = isset($_POST['q']) && '' !== sanitize_text_field(wp_unslash($_POST['q'])) ? sanitize_text_field(wp_unslash($_POST['q'])) : '';
		$search_type = isset($_POST['search_type']) && '' !== sanitize_text_field(wp_unslash($_POST['search_type'])) ? sanitize_text_field(wp_unslash($_POST['search_type'])) : '';

		$data_array = array();
		$aurguments = array();



		if ('products' == $search_type) {

			$args = array(
				'post_type' => array( 'product', 'product_variation' ),
				'post_status' => 'publish',
				'posts_per_page' => 100,
				'fields' => 'ids',
				'return' => 'ids',
				'orderby' => 'title',
				'order' => 'ASC',
			);
			if (!empty($pro)) {
				$args['s'] = $pro;
			}
			$pros = get_posts($args);

			if (!empty($pros)) {
				foreach ($pros as $proo_id) {
					$product = wc_get_product($proo_id);
					$title = ( mb_strlen($product->get_name()) > 50 ) ? mb_substr($product->get_name(), 0, 49) . '...' : $product->get_name();
					$data_array[] = array( $proo_id, $title . ' (#' . $proo_id . ' )' ); // array( Post ID, Post Title ).
				}
			}
		}
		if ('categories' == $search_type) {

			$orderby = 'name';
			$order = 'asc';
			$hide_empty = false;
			$aurguments = array(
				'taxonomy' => 'product_cat',
				'orderby' => $orderby,
				'order' => $order,
				'hide_empty' => $hide_empty,
			);
			if (!empty($pro)) {
				$aurguments['name__like'] = $pro;
			}
		}
		if ('customer' == $search_type) {

			$users = new WP_User_Query(
				array(
					'search' => '*' . esc_html($pro) . '*',
					'search_columns' => array(
						'user_login',
						'user_nicename',
						'user_email',
						'user_url',
					),
					'orderby' => 'relevance',
					'order' => 'ASC',
				)
			);
			$users_found = $users->get_results();
			if (!empty($users_found)) {
				foreach ($users_found as $user) {
					$title = $user->display_name . '(' . $user->user_email . ')';
					$data_array[] = array( $user->ID, $title ); // array( User ID, User name and email ).
				}
			}
		}
		if ('tags' == $search_type) {
			$aurguments = array(
				'taxonomy' => 'product_tag',
				'hide_empty' => false,
				'orderby' => 'relevance',
				'order' => 'ASC',
			);
			if (!empty($pro)) {
				$aurguments['name__like'] = $pro;
			}

		}
		if ('shipping-class' == $search_type) {
			$aurguments = array(
				'taxonomy' => 'product_shipping_class',
				'hide_empty' => false, // Set to true if you want to exclude empty shipping classes
			);
			if (!empty($pro)) {
				$aurguments['name__like'] = $pro;
			}
		}
		if ('country' == $search_type) {

			$countries = new WC_Countries();
			$countries = $countries->get_countries();

			foreach ($countries as $key => $label) {

				if (!empty($pro) && !str_contains(strtolower($label), strtolower($pro))) {

					continue;
				}
				$data_array[] = array( $key, $label );
			}

		}
		if ('state' == $search_type) {
			$countries_obj = new WC_Countries();
			$countries = $countries_obj->get_countries();

			foreach ($countries as $key => $label) {

				foreach ($countries_obj->get_states($key) as $state_key => $state_label) {
					if (!empty($pro) && !str_contains(strtolower($state_label), strtolower($pro)) && !str_contains(strtolower($label), strtolower($pro))) {

						continue;
					}
					$data_array[] = array( $key . ',' . $state_key, $state_label . '-' . $label );
				}

			}

		}
		if ('userrole' == $search_type) {
			global $wp_roles;
			foreach ($wp_roles->get_names() as $key => $label) {
				$data_array[] = array( $key, $label );
			}
		}
		if ('stock-status' == $search_type) {
			$stock_statuses = wc_get_product_stock_status_options();
			foreach ($stock_statuses as $status_key => $status_value) {
				$data_array[] = array( $status_key, $status_value );
			}
		}
		if (count($aurguments) >= 1) {
			$af_wbs_term_data = get_terms($aurguments);
			if (!empty($af_wbs_term_data) && !is_wp_error($af_wbs_term_data)) {
				foreach ($af_wbs_term_data as $shipping_obj) {
					$title = ( mb_strlen($shipping_obj->name) > 50 ) ? mb_substr($shipping_obj->name, 0, 49) . '...' : $shipping_obj->name;
					$data_array[] = array( $shipping_obj->term_id, $title );
				}
			}
		}

		echo wp_json_encode($data_array);
		die();
	}
);
add_action('wp_ajax_af_delete_shipping_post', 'af_delete_shipping_post');
function af_delete_shipping_post() {

	$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : 0;

	if (!wp_verify_nonce($nonce, 'addify-weight-base-shipping-nonce')) {

		die(esc_html__('Failed ajax security check!', 'addify-weight-based-shipping'));

	}
	if (isset($_POST['post_id'])) {
		$post_id = sanitize_text_field(wp_unslash($_POST['post_id']));
		wp_delete_post($post_id);

		ob_start();

		show_shipping_methods_with_shipping_zone();

		$new_tr = ob_get_clean();

		wp_send_json_success(array(
			'success' => true,
			'new_tr' => $new_tr,
		));

		wp_die();

	}
}
add_action(
	'wp_ajax_af_wbs_update_post_status',
	function () {

		$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : 0;
		if (!wp_verify_nonce($nonce, 'addify-weight-base-shipping-nonce')) {

			die(esc_html__('Failed ajax security check!', 'addify-weight-based-shipping'));

		}

		$status = isset($_POST['set_status']) && !empty($_POST['set_status']) ? sanitize_text_field(wp_unslash($_POST['set_status'])) : 'publish';

		if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {

			$post_id = sanitize_text_field(wp_unslash($_POST['post_id']));

			if (get_post($post_id)) {


				$current_post_detail_status = array(
					'ID' => $post_id,
					'post_status' => $status,
				);
				wp_update_post($current_post_detail_status);

				ob_start();
				// show_shipping_methods_with_shipping_zone($current_post_detail_status);
	
				print_r($current_post_detail_status);
				$new_tr = ob_get_clean();

				wp_send_json_success(array(
					'post_status' => get_post_status($post_id),
					'success' => true,
					'new_tr' => $new_tr,
				));
				wp_die();

			}

		}
	}
);
