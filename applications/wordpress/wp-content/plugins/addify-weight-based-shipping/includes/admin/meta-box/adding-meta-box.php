<?php
add_action('add_meta_boxes', 'af_wbsf_add_meta_boxes');
function af_wbsf_add_meta_boxes() {
	add_meta_box(
		'af_wbsf_setting',
		esc_html__('Shipping Setting', 'addify-weight-based-shipping'),
		'af_wbsf_setting',
		'addify_wbs'
	);
	add_meta_box(
		'af_wbsf_pricing',
		esc_html__('Shipping Pricing', 'addify-weight-based-shipping'),
		'af_wbsf_pricing',
		'addify_wbs'
	);
	add_meta_box(
		'af_wbsf_conditions',
		esc_html__('Additional Conditions', 'addify-weight-based-shipping'),
		'af_wbsf_conditions',
		'addify_wbs'
	);
}
function af_wbsf_setting( $post, $instance_id = '' ) {
	$post_id = $post->ID;
	global $pagenow, $typenow;

	$table_class = '';

	if ('admin.php' == $pagenow) {
		$table_class = 'af-wbs-disable-weight-based-shipping';

		$taxable_default_field_name = '';

		$zones = WC_Shipping_Zones::get_zones();

		$shipping_method_details = array();

		foreach ($zones as $zone) {
			$shipping_methods = $zone['shipping_methods'];

			foreach ($shipping_methods as $method) {

				if ($method->instance_id == $instance_id) {
					$taxable_default_field_name = 'woocommerce_' . $method->id . '_tax_status';
					break;
				}

			}
		}
	}

	wp_nonce_field('af_wbsf_nonce', 'af_wbsf_nonce');
	?>



	<?php if ('admin.php' == $pagenow) { ?>
		<input type=hidden name='tax_field_name' value="<?php echo esc_attr($taxable_default_field_name); ?>" />
		<table class="form-table af-wbs-rule-table enable-weight-based-shipping-checkbox">
			<tbody>

				<tr class="af_wbs_enable_row">
					<th scope='row'>
						<label><?php echo esc_html__('Enable Weight Based Shipping', 'addify-weight-based-shipping'); ?></label>
					</th>
					<td class='forminp'>
						<input type="checkbox" name="af_wbs_enable_weight_based_shipping"
							class="af_wbs_enable_weight_based_shipping" value="yes" <?php echo checked('yes', get_post_meta($post_id, 'af_wbs_enable_weight_based_shipping', true)); ?>>
					</td>
				</tr>
			</tbody>
		</table>

		<?php
	}
	?>

	<table class="form-table af-wbs-rule-table <?php echo esc_attr($table_class); ?>">
		<tbody>
			<?php if ('admin.php' != $pagenow) { ?>
				<tr>
					<th><?php echo esc_html__('Shipping Title', 'addify-weight-based-shipping'); ?></th>
					<td>
						<input type="text" required name="af_wbs_shipping_title"
							value="<?php echo esc_attr(get_post_meta($post_id, 'af_wbs_shipping_title', true)); ?>">
					</td>
				</tr>
				<tr style="display:none;">
					<th><?php echo esc_html__('Shipping Cost', 'addify-weight-based-shipping'); ?></th>
					<td>
						<input type="number" min="0.1" step="any" name="af_wbs_shipping_cost"
							value="<?php echo esc_attr(get_post_meta($post_id, 'af_wbs_shipping_cost', true)); ?>">
					</td>
				</tr>
				<tr>
					<th><?php echo esc_html__('Is Taxable', 'addify-weight-based-shipping'); ?></th>
					<td>
						<select name="af_wbs_is_taxable" id="af_wbs_is_taxable">
							<option value="no" <?php selected('no', get_post_meta($post_id, 'af_wbs_is_taxable', true)); ?>>
								<?php echo esc_html__('No', 'addify-weight-based-shipping'); ?>
							</option>
							<option value="yes" <?php selected('yes', get_post_meta($post_id, 'af_wbs_is_taxable', true)); ?>>
								<?php echo esc_html__('Yes', 'addify-weight-based-shipping'); ?>
							</option>
						</select>
					</td>
				</tr>
			<?php } ?>

			<tr>
				<th><?php echo esc_html__('Disable Shipping If Fee Is Zero', 'addify-weight-based-shipping'); ?></th>
				<td>
					<input type="checkbox" name="af_wbs_show_shipping_if_fee_is_zero" value="yes" <?php echo checked('yes', get_post_meta($post_id, 'af_wbs_show_shipping_if_fee_is_zero', true)); ?>>
					<?php echo esc_html__('Enable checkbox to remove shipping method when fee is 0.', 'addify-weight-based-shipping'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo esc_html__('Calculate Entire Cart Weight', 'addify-weight-based-shipping'); ?></th>
				<td>
					<input type="checkbox" name="af_wbs_calculate_entire_cart_weight" value="yes" <?php echo checked('yes', get_post_meta($post_id, 'af_wbs_calculate_entire_cart_weight', true)); ?>>
					<?php echo esc_html__('Enable checkbox to calculate entire cart weight. If checkbox is disable then weight of single product will be calculated. ', 'addify-weight-based-shipping'); ?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}
function af_wbsf_conditions( $post ) {
	wp_nonce_field('af_wbsf_nonce', 'af_wbsf_nonce');

	$post_id = $post->ID;

	global $pagenow;

	$table_class = '';

	if ('admin.php' == $pagenow) {
		$table_class = 'af-wbs-disable-weight-based-shipping';
	}
	?>

	<?php if ('admin.php' == $pagenow) { ?>
		<h2 class='<?php echo esc_attr($table_class); ?>'>
			<?php echo esc_html__('Shipping Conditions', 'addify-weight-based-shipping'); ?>
		</h2>
		<?php
	}
	?>
	<div class="af-wbs-metabox-fields <?php echo esc_attr($table_class); ?>">
		<div class="af-wbs-div-conditions-wrapper">
			<?php
			if (!empty(get_post_meta($post_id, 'af_wbs_conditions', true))) {
				$counter = 0;
				foreach ((array) get_post_meta($post_id, 'af_wbs_conditions', true) as $set_group_id => $conditon_values) {

					if (is_array($conditon_values)) {
						$counter++;
						?>
						<div class="af-wbs-div-conditions-group">
							<div class="abs-number"><?php echo esc_attr($counter); ?></div>
							<div class="af-wbs-group-actions">
								<a href="#" class="af-wbs-remove-group-btn" data-remove_class="af-wbs-div-conditions-group"
									title="Remove group"><?php echo esc_html__('Remove', 'addify-weight-based-shipping'); ?></a>
							</div>
							<div class="af-wbs-conditions-wrap">
								<?php
								foreach ($conditon_values as $set_condition_id => $data) {

									if (empty($data) || !is_array($data)) {
										continue;
									}

									$condition_value = isset($data['condition_value']) ? $data['condition_value'] : '';
									?>
									<div class="af-wbs-condition-wrap" data-condition_id="<?php echo esc_attr($set_condition_id); ?>"
										data-group_id="<?php echo esc_attr($set_group_id); ?>">
										<div class="af-wbs-condition-type">
											<?php af_wbs_get_cart_conditions($data, $set_group_id, $set_condition_id); ?>
										</div>
										<div class="af-wbs-condition-operator"
											data-operator="<?php echo esc_attr(af_wbs_selected_operator_for_condition($data)); ?>">
											<?php af_wbs_get_greater_or_less_conditions($data, $set_group_id, $set_condition_id); ?>
										</div>
										<div class="af-wbs-condition-div">
											<?php
											if (isset($data['condition_type'])) {

												switch ($data['condition_type']) {
													case 'subtotal':
													case 'subtotal-excl-tax':
													case 'tax':
													case 'quantity':
													case 'weight':
													case 'width':
													case 'height':
													case 'length':
													case 'stock':
														( af_wbs_number((float) $condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'zip-code':
													case 'coupon':
													case 'city':
														( af_wbs_text($condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'country':
														( af_wbs_country($condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'state':
														( af_wbs_state($condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'stock-status':
														( af_wbs_stock_status($condition_value, $set_group_id, $set_condition_id) );
														break;

													case 'user-role':
														( af_wbs_userrole((array) $condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'customer':
														( af_wbs_customer((array) $condition_value, $set_group_id, $set_condition_id) );
														break;

													case 'shipping-class':
														( af_wbs_shipping((array) $condition_value, $set_group_id, $set_condition_id) );
														break;

													case 'tags':
														( af_wbs_tags((array) $condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'product':
														( af_wbs_product((array) $condition_value, $set_group_id, $set_condition_id) );
														break;
													case 'category':
														( af_wbs_category((array) $condition_value, $set_group_id, $set_condition_id) );
														break;

													default:
														( af_wbs_number($condition_value, $set_group_id, $set_condition_id) );

														break;
												}
											}
											?>
										</div>
										<div class="af-wbs-condition-remove">
											<span title="Remove Condition" class="dashicons dashicons-no-alt af-wbs-remove-group-btn"
												data-remove_class="af-wbs-condition-wrap"></span>
										</div>
										<fieldset class="and">
											<legend>&amp;</legend>
										</fieldset>
									</div>
									<?php

								}
								?>
							</div>
							<div class="add-condition-button">
								<button title="Add new condition" class="button af-wbs-add-group-condition"
									data-group_id="<?php echo esc_attr($set_group_id); ?>"
									type="button"><?php echo esc_html__('Add Condition', 'addify-weight-based-shipping'); ?></button>
							</div>
							<div class="af-wbs-group-seperator">
								<p class="af-wbs-or-text">
									<strong>Or</strong>
								</p>
							</div>
						</div>
						<?php
					}
				}
			}
			?>
		</div>

		<div class="af-wbs-add-group-button">
			<button title="Add OR group" class="button button-primary button-large button-af-wbs-add-group"
				type="button"><?php echo esc_html__('Add Group', 'addify-weight-based-shipping'); ?></button>
		</div>
	</div>
	<?php
}

function af_wbsf_pricing( $post ) {
	global $pagenow, $typenow;
	wp_nonce_field('af_wbsf_nonce', 'af_wbsf_nonce');

	$ul_classes = 'ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header';

	$custom_class = '';
	$hide_tooltip_in_settings = '';
	$table_class = '';

	if ('admin.php' == $pagenow) {
		$ul_classes = '';
		$custom_class = 'af-wbs-button-options';
		$hide_tooltip_in_settings = 'af-wbs-hide-tooltip';
		$table_class = 'af-wbs-disable-weight-based-shipping';
	}

	$post_id = $post->ID;

	if ('admin.php' == $pagenow) {
		?>
		<h2 class="<?php echo esc_attr($table_class); ?>">
			<?php echo esc_html__('Weight Based Shipping Rates', 'addify-weight-based-shipping'); ?>
		</h2>
		<?php
	}
	?>
	<div class="af-wbs-metabox-fields <?php echo esc_attr($table_class); ?>">
		<div id="af-wbs-tabs" class="af-wbs-tabs ui-tabs ui-corner-all ui-widget ui-widget-content">
			<div class="af-wbs-tabs-content ui-tabs-panel ui-corner-bottom ui-widget-content" id="af-wbs-tab-pricing-weight"
				aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="true">
				<table class="afwbs-pricing-table">
					<thead>
						<th>
							<label><?php echo esc_html__('Selection Type', 'addify-weight-based-shipping'); ?></label>
						</th>
						<th>
							<label><?php echo esc_html__('Select Specific', 'addify-weight-based-shipping'); ?></label>
							<span class="af-wbs-tooltip <?php echo esc_attr($hide_tooltip_in_settings); ?>"
								data-tooltip="<?php echo esc_html__('If empty will apply for all.', 'addify-weight-based-shipping'); ?>">
								<span class="af-wbs-tooltip-trigger">?</span>
							</span>
							<span><?php echo wp_kses(wc_help_tip('If empty will apply for all.'), wp_kses_allowed_html('post')); ?></span>
						</th>
						<th>
							<label><?php echo esc_html__('Min Weight', 'addify-weight-based-shipping'); ?></label>
						</th>
						<th>
							<label><?php echo esc_html__('Max Weight', 'addify-weight-based-shipping'); ?></label>
						</th>
						<th>
							<label><?php echo esc_html__('Fee Type', 'addify-weight-based-shipping'); ?></label>
						</th>
						<th>
							<label><?php echo esc_html__('Amount', 'addify-weight-based-shipping'); ?></label>
						</th>
						<th>
							<label><?php echo esc_html__('Additional Fixed Surcharge', 'addify-weight-based-shipping'); ?></label>
						</th>
						<th></th>
					</thead>
					<tbody>
						<?php
						foreach ((array) get_post_meta($post_id, 'af_wbs_weight_price_rule', true) as $set_condition_id => $data) {
							if (is_array($data)) {
								af_wbs_tab_pricing_weight($data, $set_condition_id);
							}
						}
						?>
					</tbody>
				</table>
			</div>
			<p>
				<strong><Label><?php echo esc_html__('Note', 'addify-weight-based-shipping'); ?></Label></strong> :
				<?php echo esc_html__(' Leave empty product/category/tag/shipping class field to apply on all product.', 'addify-weight-based-shipping'); ?>
			</p>

		</div>
		<button type="button"
			class="button button-primary button-large af-wbs-add-new-price-conditions af-wbs_add_weight_price_rule <?php echo esc_attr($custom_class); ?>"><?php echo esc_html__('Add new', 'addify-weight-based-shipping'); ?></button>
		<div style="clear:both"></div>
	</div>
	<?php
}

add_action('save_post_addify_wbs', 'save_post_addify_wbs');
function save_post_addify_wbs( $post_id ) {
	include_once AF_WBS_DIR . 'includes/admin/save-post-data.php';
}