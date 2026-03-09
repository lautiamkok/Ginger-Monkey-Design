<?php
add_action('admin_init', 'add_shipping_hooks');

add_action('woocommerce_settings_save_shipping', 'af_wbs_woocommerce_settings_save', 100);

function add_shipping_hooks() {

	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$page = ( null !== $page ) ? $page : 0;

	$tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$tab = ( null !== $tab ) ? $tab : 0;

	$instance_id = filter_input(INPUT_GET, 'instance_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$instance_id = ( null !== $instance_id ) ? $instance_id : 0;


	$instance_id = (int) $instance_id;
	if ('wc-settings' == $page && 'shipping' == $tab && !empty($instance_id)) {

		foreach ((array) wc()->shipping->get_shipping_methods() as $shipping_id => $shipping_class) {
			add_filter('woocommerce_shipping_instance_form_fields_' . $shipping_id, 'af_wbs_woocommerce_shipping_instance_form_fields_', 100, 1);
		}

		add_action('woocommerce_settings_' . $tab, 'af_wbs_woocommerce_settings_', 100);

	}
}//end add_shipping_hooks()


function af_wbs_woocommerce_settings_() {
	$instance_id = filter_input(INPUT_GET, 'instance_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$instance_id = ( null !== $instance_id ) ? $instance_id : 0;

	// Output the post ID for debugging
	$post_id = af_wbs_created_post_on_default_woocommerce_shipping($instance_id);

	$post = get_post($post_id);

	?>
	<div class="af-wbs-advanced-shipping">
		<?php
		af_wbsf_setting($post, $instance_id);
		af_wbsf_conditions($post);
		af_wbsf_pricing($post);

		?>
	</div>
	<?php
}//end af_wbs_woocommerce_settings_()


function af_wbs_woocommerce_settings_save() {

	$instance_id = filter_input(INPUT_GET, 'instance_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$instance_id = ( null !== $instance_id ) ? $instance_id : 0;

	$instance_id = (int) $instance_id;

	$post_id = af_wbs_created_post_on_default_woocommerce_shipping($instance_id);

	include_once AF_WBS_DIR . 'includes/admin/save-post-data.php';
}//end af_wbs_woocommerce_settings_save()


function af_wbs_woocommerce_shipping_instance_form_fields_( $fields ) {

	unset($fields['cost']);
	return $fields;
}//end af_wbs_woocommerce_shipping_instance_form_fields_()

