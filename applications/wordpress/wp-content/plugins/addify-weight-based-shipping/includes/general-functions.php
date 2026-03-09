<?php
if (!defined('ABSPATH')) {
	exit();
}
function af_wbs_get_block( $data = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {

	$condition_value = isset($data['condition_value']) ? $data['condition_value'] : '';
	?>
	<div class="af-wbs-div-conditions-group">
		<div class="abs-number"><?php echo esc_attr($set_group_id); ?></div>
		<div class="af-wbs-group-actions">
			<a href="#" class="af-wbs-remove-group-btn" data-remove_class="af-wbs-div-conditions-group"
				title="Remove group"><?php echo esc_html__('Remove', 'addify-weight-based-shipping'); ?></a>
		</div>
		<div class="af-wbs-conditions-wrap">
			<div class="af-wbs-condition-wrap" data-condition_id="<?php echo esc_attr($set_condition_id); ?>"
				data-group_id="<?php echo esc_attr($set_group_id); ?>">
				<div class="af-wbs-condition-type">
					<?php af_wbs_get_cart_conditions($data, $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id'); ?>
				</div>
				<div class="af-wbs-condition-operator"
					data-operator="<?php echo esc_attr(af_wbs_selected_operator_for_condition($data)); ?>">
					<?php af_wbs_get_greater_or_less_conditions($data, $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id'); ?>
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
							case 'height':
							case 'length':
							case 'stock':
								af_wbs_number($condition_value);
								break;

							case 'coupon':
							case 'state':
							case 'city':
							case 'country':
							case 'zip-code':
								af_wbs_text($condition_value);
								break;

							case 'stock-status':
								af_wbs_stock_status($condition_value);
								break;

							case 'user-role':
								af_wbs_userrole((array) $condition_value);
								break;

							case 'customer':
								af_wbs_customer((array) $condition_value);
								break;

							case 'shipping-class':
								af_wbs_shipping((array) $condition_value);
								break;

							case 'tags':
								af_wbs_tags((array) $condition_value);
								break;
							case 'product':
								af_wbs_product((array) $condition_value);
								break;
							case 'category':
								af_wbs_category((array) $condition_value);
								break;

							default:
								af_wbs_number($condition_value);

								break;
						}
					}
					?>
					<input data-search_type="number" type="number"
						name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value]"
						class="af-wbs-condition-value " min="0" step="any">
				</div>
				<div class="af-wbs-condition-remove">
					<span title="Remove Condition" class="dashicons dashicons-no-alt af-wbs-remove-group-btn"
						data-remove_class="af-wbs-condition-wrap"></span>
				</div>
				<fieldset class="and">
					<legend>&amp;</legend>
				</fieldset>
			</div>
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
function af_wbs_add_condition( $data = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	?>
	<div class="af-wbs-condition-wrap" data-condition_id="<?php echo esc_attr($set_condition_id); ?>"
		data-group_id="<?php echo esc_attr($set_group_id); ?>">
		<div class="af-wbs-condition-type">
			<?php af_wbs_get_cart_conditions($data, $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id'); ?>
		</div>
		<div class="af-wbs-condition-operator"
			data-operator="<?php echo esc_attr(af_wbs_selected_operator_for_condition($data)); ?>">
			<?php af_wbs_get_greater_or_less_conditions($data, $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id'); ?>
		</div>
		<div class="af-wbs-condition-div">
			<input type="number" min="0" step="any"
				name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value]"
				class="input-text af-wbs-condition-value-input">
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
function af_wbs_get_cart_conditions( $data = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$selected_term = isset($data['condition_type']) ? $data['condition_type'] : '';

	?>
	<select class="input-select af-wbs-condition-type-select" data-condition_id="<?php echo esc_attr($set_condition_id); ?>"
		data-group_id="<?php echo esc_attr($set_group_id); ?>"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_type]">
		<optgroup label="<?php echo esc_html__('Cart Based', 'addify-weight-based-shipping'); ?>">
			<option <?php selected('subtotal', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="subtotal">
				<?php echo esc_html__('Subtotal', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('subtotal-excl-tax', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="subtotal-excl-tax">
				<?php echo esc_html__('Subtotal Excl. tax', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('tax', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="tax">
				<?php echo esc_html__('Tax', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('quantity', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="quantity">
				<?php echo esc_html__('Quantity', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('coupon', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="text" value="coupon">
				<?php echo esc_html__('Coupon', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('weight', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="weight">
				<?php echo esc_html__('Weight', 'addify-weight-based-shipping'); ?>
			</option>

		</optgroup>
		<optgroup label="<?php echo esc_html__('User Based', 'addify-weight-based-shipping'); ?>">
			<option <?php selected('zip-code', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="text" value="zip-code">
				<?php echo esc_html__('Zip code', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('country', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="country" value="country">
				<?php echo esc_html__('Country', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('state', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="state" value="state">
				<?php echo esc_html__('State', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('city', $selected_term); ?> data-disabled="=,!=,>,<,>=,<=" data-select_field_type="text"
				value="city">
				<?php echo esc_html__('City', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('user-role', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="userrole" value="user-role">
				<?php echo esc_html__('User role', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('customer', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="customer" value="customer">
				<?php echo esc_html__('Specific customer', 'addify-weight-based-shipping'); ?>
			</option>
		</optgroup>
		<optgroup label="<?php echo esc_html__('Product Based', 'addify-weight-based-shipping'); ?>">
			<option <?php selected('width', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="width">
				<?php echo esc_html__('Width', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('height', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="height">
				<?php echo esc_html__('Height', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('length', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="length">
				<?php echo esc_html__('Length', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('stock', $selected_term); ?> data-disabled="included,excluded"
				data-select_field_type="number" value="stock">
				<?php echo esc_html__('Stock', 'addify-weight-based-shipping'); ?>
			</option>
			<option <?php selected('stock-status', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="stock-status" value="stock-status">
				<?php echo esc_html__('Stock Status', 'addify-weight-based-shipping'); ?>
			</option>
			<option style="display:none;" <?php selected('product', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="products" value="product">
				<?php echo esc_html__('Contains Product', 'addify-weight-based-shipping'); ?>
			</option>
			<option style="display:none;" <?php selected('category', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="categories" value="category">
				<?php echo esc_html__('Contains Category', 'addify-weight-based-shipping'); ?>
			</option>
			<option style="display:none;" <?php selected('shipping-class', $selected_term); ?>
				data-disabled="=,!=,>,<,>=,<=" data-select_field_type="shipping-class" value="shipping-class">
				<?php echo esc_html__('Contains Shipping class', 'addify-weight-based-shipping'); ?>
			</option>
			<option style="display:none;" <?php selected('tags', $selected_term); ?> data-disabled="=,!=,>,<,>=,<="
				data-select_field_type="tags" value="tags">
				<?php echo esc_html__('Products Tags', 'addify-weight-based-shipping'); ?>
			</option>
		</optgroup>
	</select>

	<?php
}


function af_wbs_selected_operator_for_condition( $data = array() ) {
	$operator = isset($data['condition_operator']) ? $data['condition_operator'] : '';

	$condition_type = isset($data['condition_type']) ? $data['condition_type'] : '';

	if (in_array($condition_type, array( 'user-role', 'state', 'country', 'customer', 'tags', 'shipping-class', 'product', 'category', 'stock-status', 'coupon', 'city' )) && !in_array($operator, array( 'included', 'excluded' ))) {
		$operator = 'included';
	}
	if (!in_array($condition_type, array( 'user-role', 'state', 'country', 'customer', 'tags', 'shipping-class', 'product', 'category', 'stock-status', 'coupon', 'city' )) && in_array($operator, array( 'included', 'excluded' ))) {
		$operator = '=';
	}

	return $operator;
}
function af_wbs_get_greater_or_less_conditions( $data = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$operator = af_wbs_selected_operator_for_condition($data);
	?>
	<select class="input-select af-wbs-condition-operator-select"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_operator]">
		<option <?php selected($operator, '='); ?> value="=">
			<?php echo esc_html__('is Equal to', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, '!='); ?> value="!=">
			<?php echo esc_html__('is Not equal to', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, '>'); ?> value=">">
			<?php echo esc_html__('is Greater than', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, '<'); ?> value="<">
			<?php echo esc_html__('is Less than', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, '>='); ?> value=">=">
			<?php echo esc_html__('is Greater than or equals', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, '<='); ?> value="<=">
			<?php echo esc_html__('is Less than or equals', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, 'included'); ?> value="included">
			<?php echo esc_html__('Included', 'addify-weight-based-shipping'); ?>
		</option>
		<option <?php selected($operator, 'excluded'); ?> value="excluded">
			<?php echo esc_html__('Excluded', 'addify-weight-based-shipping'); ?>
		</option>
	</select>
	<?php
}
function af_wbs_all_operator() {
	return array(
		'=' => 'Is Equal to',
		'!=' => 'Is Not equal to',
		'>' => 'Is Greater than',
		'<' => 'Is Less than',
		'>=' => 'Is Greater than or equals',
		'<=' => 'Is Less than or equals',
		'included' => 'Included',
		'excluded' => 'Excluded',
	);
}
function af_wbs_tab_pricing_weight( $data = array(), $set_condition_id = 'set_condition_id' ) {

	$min_weight = isset($data['min_weight']) ? $data['min_weight'] : 1;
	$max_weight = isset($data['max_weight']) ? $data['max_weight'] : 1;
	$selection_type = isset($data['selection_type']) ? $data['selection_type'] : 'products';
	$price_type = isset($data['price_type']) ? $data['price_type'] : 'once';
	$base_price = isset($data['base_price']) ? $data['base_price'] : 0;

	$product = isset($data['selected_products']) ? $data['selected_products'] : array();
	$shipping_class = isset($data['shipping_class']) ? $data['shipping_class'] : array();
	$category = isset($data['category']) ? $data['category'] : array();
	$tag = isset($data['tag']) ? $data['tag'] : array();
	$fee = isset($data['fee']) ? $data['fee'] : 0;
	$data = (array) $data;

	?>
	<tr data-condition_id="<?php echo esc_attr($set_condition_id); ?>" class="af-wbs-tab-pricing-weight-tr">
		<td>
			<select class="input-select af-wbs-selection-type"
				name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][selection_type]">
				<option <?php selected($selection_type, 'products'); ?> value="products">
					<?php echo esc_html__('Specific Product', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($selection_type, 'categories'); ?> value="categories">
					<?php echo esc_html__('Specific Category', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($selection_type, 'tags'); ?> value="tags">
					<?php echo esc_html__('Specific Tag', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($selection_type, 'shipping-class'); ?> value="shipping-class">
					<?php echo esc_html__('Specific Shipping Class', 'addify-weight-based-shipping'); ?>
				</option>
			</select>
		</td>
		<td>
			<div class="af-wbs-pricing-products af-wbs-pricing-select">
				<select class="af-wbs_pricing_select af-wbs_product_search af-wbs-live-search-for" multiple
					data-search_type="products"
					name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][selected_products][]">
					<?php
					foreach ($product as $product_id) {
						$product = wc_get_product($product_id);

						if ($product && !is_wp_error($product)) {
							?>
							<option selected value="<?php echo esc_attr($product_id); ?>">
								<?php echo esc_attr($product->get_name()); ?>
							</option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div class="af-wbs-pricing-shipping-class af-wbs-pricing-select">
				<select class="af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
					data-search_type="shipping-class"
					name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][shipping_class][]">
					<?php
					foreach ($shipping_class as $shipping_class_id) {
						$shipping_class = get_term($shipping_class_id, 'product_shipping_class');

						if ($shipping_class && !is_wp_error($shipping_class)) {
							?>
							<option selected value="<?php echo esc_attr($shipping_class_id); ?>">
								<?php echo esc_attr($shipping_class->name); ?>
							</option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div class="af-wbs-pricing-categories af-wbs-pricing-select">
				<select class="af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
					data-search_type="categories"
					name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][category][]">
					<?php
					foreach ($category as $category_id) {
						$category = get_term($category_id, 'product_cat');

						if ($category && !is_wp_error($category)) {
							?>
							<option selected value="<?php echo esc_attr($category_id); ?>">
								<?php echo esc_attr($category->name); ?>
							</option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div class="af-wbs-pricing-tags af-wbs-pricing-select">
				<select class="af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
					data-search_type="tags"
					name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][tag][]">
					<?php
					foreach ($tag as $tag_id) {
						$tag = get_term($tag_id, 'product_tag');

						if ($tag && !is_wp_error($tag)) {
							?>
							<option selected value="<?php echo esc_attr($tag_id); ?>">
								<?php echo esc_attr($tag->name); ?>
							</option>
							<?php
						}
					}
					?>
				</select>
			</div>
		</td>
		<td>
			<input name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][min_weight]"
				value="<?php echo esc_attr($min_weight); ?>" type="number" min="0" step="any">
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][max_weight]"
				value="<?php echo esc_attr($max_weight); ?>">
		</td>
		<td>
			<select class="input-select af-wbs-condition-operator-select"
				name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][price_type]">
				<option <?php selected($price_type, 'once'); ?> value="once">
					<?php echo esc_html__('Fixed', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($price_type, 'per-kg'); ?> value="per-kg">
					<?php
					echo esc_html__('Per ', 'addify-weight-based-shipping');
					echo esc_attr(get_option('woocommerce_weight_unit'));
					?>
				</option>
			</select>
		</td>
		<td>
			<input type="number" step="any" min="0"
				name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][fee]"
				value="<?php echo esc_attr($fee); ?>">
		</td>
		<td>
			<input type="number" step="any" min="0"
				name="af_wbs_weight_price_rule[<?php echo esc_attr($set_condition_id); ?>][base_price]"
				value="<?php echo esc_attr($base_price); ?>">
		</td>
		<td>
			<span title="Remove" class="dashicons dashicons-no-alt af-wbs-remove-group-btn"
				data-remove_class="af-wbs-tab-pricing-weight-tr"></span>
		</td>

	</tr>
	<?php
}
function af_wbs_tab_pricing_product( $data = array(), $set_condition_id = 'set_condition_id' ) {
	$min_weight = isset($data['min_weight']) ? $data['min_weight'] : 1;
	$max_weight = isset($data['max_weight']) ? $data['max_weight'] : 1;
	$price_type = isset($data['price_type']) ? $data['price_type'] : 'once';
	$product = isset($data['selected_products']) ? $data['selected_products'] : array();

	$fee = isset($data['fee']) ? $data['fee'] : 0;
	$data = (array) $data;

	?>
	<tr data-condition_id="<?php echo esc_attr($set_condition_id); ?>" class="af-wbs-tab-pricing-product-tr">
		<td>
			<select class="af-wbs_pricing_select af-wbs_product_search af-wbs-live-search-for" multiple
				data-search_type="products"
				name="af_wbs_product_price_rule[<?php echo esc_attr($set_condition_id); ?>][selected_products][]">
				<?php
				foreach ($product as $product_id) {
					$product = wc_get_product($product_id);

					if ($product && !is_wp_error($product)) {
						?>
						<option selected value="<?php echo esc_attr($product_id); ?>">
							<?php echo esc_attr($product->get_name()); ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_product_price_rule[<?php echo esc_attr($set_condition_id); ?>][min_weight]"
				value="<?php echo esc_attr($min_weight); ?>">
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_product_price_rule[<?php echo esc_attr($set_condition_id); ?>][max_weight]"
				value="<?php echo esc_attr($max_weight); ?>">
		</td>
		<td>
			<select class="input-select af-wbs-condition-operator-select"
				name="af_wbs_product_price_rule[<?php echo esc_attr($set_condition_id); ?>][price_type]">
				<?php $price_type = isset($data['price_type']) ? $data['price_type'] : ''; ?>
				<option <?php selected($price_type, 'once'); ?> value="once">
					<?php echo esc_html__('Fixed', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($price_type, 'per-kg'); ?> value="per-kg">
					<?php
					echo esc_html__('Per ', 'addify-weight-based-shipping');
					echo esc_attr(get_option('woocommerce_weight_unit'));
					?>
				</option>
			</select>
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_product_price_rule[<?php echo esc_attr($set_condition_id); ?>][fee]"
				value="<?php echo esc_attr($fee); ?>">
		</td>
		<td>
			<span title="Remove" class="dashicons dashicons-no-alt af-wbs-remove-group-btn"
				data-remove_class="af-wbs-tab-pricing-product-tr"></span>
		</td>
	</tr>

	<?php
}
function af_wbs_tab_pricing_shipping_class( $data = array(), $set_condition_id = 'set_condition_id' ) {

	$min_weight = isset($data['min_weight']) ? $data['min_weight'] : 1;
	$max_weight = isset($data['max_weight']) ? $data['max_weight'] : 1;
	$price_type = isset($data['price_type']) ? $data['price_type'] : 'once';
	$fee = isset($data['fee']) ? $data['fee'] : 0;
	$shipping_class = isset($data['shipping_class']) ? $data['shipping_class'] : array();
	$data = (array) $data;

	?>
	<tr data-condition_id="<?php echo esc_attr($set_condition_id); ?>" class="af-wbs-tab-shipping-pricing-tr">
		<td>
			<select class="af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
				data-search_type="shipping-class"
				name="af_wbs_shipping_class_price_rule[<?php echo esc_attr($set_condition_id); ?>][shipping_class][]">
				<?php
				foreach ($shipping_class as $shipping_class_id) {
					$shipping_class = get_term($shipping_class_id, 'product_shipping_class');

					if ($shipping_class && !is_wp_error($shipping_class)) {
						?>
						<option selected value="<?php echo esc_attr($shipping_class_id); ?>">
							<?php echo esc_attr($shipping_class->name); ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_shipping_class_price_rule[<?php echo esc_attr($set_condition_id); ?>][min_weight]"
				value="<?php echo esc_attr($min_weight); ?>">
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_shipping_class_price_rule[<?php echo esc_attr($set_condition_id); ?>][max_weight]"
				value="<?php echo esc_attr($max_weight); ?>">
		</td>
		<td>
			<select class="input-select af-wbs-condition-operator-select"
				name="af_wbs_shipping_class_price_rule[<?php echo esc_attr($set_condition_id); ?>][price_type]">
				<?php $price_type = isset($data['price_type']) ? $data['price_type'] : ''; ?>
				<option <?php selected($price_type, 'once'); ?> value="once">
					<?php echo esc_html__('Fixed', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($price_type, 'per-kg'); ?> value="per-kg">
					<?php
					echo esc_html__('Per ', 'addify-weight-based-shipping');
					echo esc_attr(get_option('woocommerce_weight_unit'));
					?>
				</option>
			</select>
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_shipping_class_price_rule[<?php echo esc_attr($set_condition_id); ?>][fee]"
				value="<?php echo esc_attr($fee); ?>">
		</td>
		<td>
			<span title="Remove" class="dashicons dashicons-no-alt af-wbs-remove-group-btn"
				data-remove_class="af-wbs-tab-shipping-pricing-tr"></span>
		</td>
	</tr>

	<?php
}
function af_wbs_tab_pricing_category( $data = array(), $set_condition_id = 'set_condition_id' ) {
	$min_weight = isset($data['min_weight']) ? $data['min_weight'] : 1;
	$max_weight = isset($data['max_weight']) ? $data['max_weight'] : 1;
	$price_type = isset($data['price_type']) ? $data['price_type'] : 'once';
	$fee = isset($data['fee']) ? $data['fee'] : 0;
	$category = isset($data['category']) ? $data['category'] : array();
	$data = (array) $data;

	?>
	<tr data-condition_id="<?php echo esc_attr($set_condition_id); ?>" class="af-wbs-tab-category-pricing-tr">
		<td>
			<select class="af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
				data-search_type="categories"
				name="af_wbs_category_price_rule[<?php echo esc_attr($set_condition_id); ?>][category][]">
				<?php
				foreach ($category as $shipping_class_id) {
					$shipping_class = get_term($shipping_class_id, 'product_cat');

					if ($shipping_class && !is_wp_error($shipping_class)) {
						?>
						<option selected value="<?php echo esc_attr($shipping_class_id); ?>">
							<?php echo esc_attr($shipping_class->name); ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_category_price_rule[<?php echo esc_attr($set_condition_id); ?>][min_weight]"
				value="<?php echo esc_attr($min_weight); ?>">
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_category_price_rule[<?php echo esc_attr($set_condition_id); ?>][max_weight]"
				value="<?php echo esc_attr($max_weight); ?>">
		</td>
		<td>
			<select class="input-select af-wbs-condition-operator-select"
				name="af_wbs_category_price_rule[<?php echo esc_attr($set_condition_id); ?>][price_type]">
				<?php $price_type = isset($data['price_type']) ? $data['price_type'] : ''; ?>
				<option <?php selected($price_type, 'once'); ?> value="once">
					<?php echo esc_html__('Fixed', 'addify-weight-based-shipping'); ?>
				</option>
				<option <?php selected($price_type, 'per-kg'); ?> value="per-kg">
					<?php
					echo esc_html__('Per ', 'addify-weight-based-shipping');
					echo esc_attr(get_option('woocommerce_weight_unit'));
					?>
				</option>
			</select>
		</td>
		<td>
			<input type="number" min="0" step="any"
				name="af_wbs_category_price_rule[<?php echo esc_attr($set_condition_id); ?>][fee]"
				value="<?php echo esc_attr($fee); ?>">
		</td>
		<td>
			<span title="Remove" class="dashicons dashicons-no-alt af-wbs-remove-group-btn"
				data-remove_class="af-wbs-tab-category-pricing-tr"></span>
		</td>
	</tr>
	<?php
}
function af_wbs_product( $products = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$products = (array) $products;
	?>
	<select class="af-wbs-condition-value af-wbs_pricing_select af-wbs_product_search af-wbs-live-search-for" multiple
		data-search_type="products"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]">
		<?php
		foreach ($products as $product_id) {
			$product = wc_get_product($product_id);

			if ($product && !is_wp_error($product)) {
				?>
				<option selected value="<?php echo esc_attr($product_id); ?>">
					<?php echo esc_attr($product->get_name()); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_country( $countries_list = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$countries = new WC_Countries();
	$countries = $countries->get_countries();
	$countries_list = (array) $countries_list;
	?>
	<select class="af-wbs-condition-value af-wbs_pricing_select af-wbs_product_search af-wbs-live-search-for" multiple
		data-search_type="country"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]">
		<?php
		foreach ($countries_list as $country_key) {

			if (isset($countries[ $country_key ])) {
				?>
				<option selected value="<?php echo esc_attr($country_key); ?>">
					<?php echo esc_attr($countries[ $country_key ]); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_state( $state_list = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$state_list = (array) $state_list;
	$countries_obj = new WC_Countries();

	?>
	<select class="af-wbs-condition-value af-wbs_pricing_select af-wbs_product_search af-wbs-live-search-for" multiple
		data-search_type="state"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]">
		<?php
		foreach ($state_list as $country_key) {

			if (empty($country_key)) {
				continue;
			}
			$country_and_state = explode(',', $country_key);
			if (count($country_and_state) >= 2) {

				$country_key = current($country_and_state);
				$state_key = next($country_and_state);

				$country_name = $countries_obj->get_countries() ? $countries_obj->get_countries()[ $country_key ] : '';
				$all_states = $countries_obj->get_states($country_key);
				if (isset($all_states) && isset($all_states[ $state_key ])) {
					?>
					<option selected value="<?php echo esc_attr($country_key . ',' . $state_key); ?>">
						<?php echo esc_attr($all_states[ $state_key ] . '-' . $country_name); ?>
					</option>
					<?php
				}
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_category( $category = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {

	$category = (array) $category;
	?>
	<select
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]"
		class="af-wbs-condition-value af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
		data-search_type="categories">
		<?php
		foreach ($category as $shipping_class_id) {
			$shipping_class = get_term($shipping_class_id, 'product_cat');

			if ($shipping_class && !is_wp_error($shipping_class)) {
				?>
				<option selected value="<?php echo esc_attr($shipping_class_id); ?>">
					<?php echo esc_attr($shipping_class->name); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_tags( $tags = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {

	?>
	<select
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]"
		class="af-wbs-condition-value af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
		data-search_type="tags">
		<?php
		foreach ($tags as $shipping_class_id) {
			$shipping_class = get_term($shipping_class_id, 'product_tag');

			if ($shipping_class && !is_wp_error($shipping_class)) {
				?>
				<option selected value="<?php echo esc_attr($shipping_class_id); ?>">
					<?php echo esc_attr($shipping_class->name); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_shipping( $shipping = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {

	$shipping = (array) $shipping;
	?>
	<select
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]"
		class="af-wbs-condition-value af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
		data-search_type="shipping-class">
		<?php
		foreach ($shipping as $shipping_class_id) {
			$shipping_class = get_term($shipping_class_id, 'product_shipping_class');

			if ($shipping_class && !is_wp_error($shipping_class)) {
				?>
				<option selected value="<?php echo esc_attr($shipping_class_id); ?>">
					<?php echo esc_attr($shipping_class->name); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_customer( $customer = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$customer = (array) $customer;
	?>
	<select
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]"
		class="af-wbs-condition-value af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
		data-search_type="customer">
		<?php
		foreach ($customer as $selected_customer_id) {
			$get_user_detail = get_user_by('ID', $selected_customer_id);
			if ($get_user_detail) {
				?>
				<option selected value="<?php echo esc_attr($selected_customer_id); ?>">
					<?php echo esc_attr($get_user_detail->display_name); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_userrole( $userrole = array(), $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	global $wp_roles;
	$userrole = (array) $userrole;
	?>
	<select
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value][]"
		class="af-wbs-condition-value af-wbs_pricing_select af-wbs_category_search af-wbs-live-search-for" multiple
		data-search_type="userrole">
		<?php

		foreach ($userrole as $selected_userrole) {

			if (isset($wp_roles->get_names()[ $selected_userrole ])) {
				?>
				<option selected value="<?php echo esc_attr($selected_userrole); ?>">
					<?php echo esc_attr($wp_roles->get_names()[ $selected_userrole ]); ?>
				</option>
				<?php
			}
		}
		?>
	</select>
	<?php
}
function af_wbs_stock_status( $stock_status = '', $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	?>
	<select class="af-wbs-condition-value af-wbs_pricing_select af-wbs_stock_status_search af-wbs-live-search-for"
		data-search_type="stock-status"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value]">
		<?php if (!empty($stock_status) && isset(wc_get_product_stock_status_options()[ $stock_status ])) { ?>
			<option selected value="<?php echo esc_attr($stock_status); ?>">
				<?php echo esc_attr(wc_get_product_stock_status_options()[ $stock_status ]); ?>
			</option>
		<?php } ?>
	</select>
	<?php
}
function af_wbs_text( $text = '', $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$text = (string) $text;

	?>
	<input data-search_type="text" type="text"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value]"
		class="af-wbs-condition-value " value="<?php echo esc_attr($text); ?>">
	<?php
}

function af_wbs_number( $number = 0, $set_group_id = 'set_group_id', $set_condition_id = 'set_condition_id' ) {
	$number = (float) $number;

	?>
	<input data-search_type="number" type="number"
		name="af_wbs_conditions[<?php echo esc_attr($set_group_id); ?>][<?php echo esc_attr($set_condition_id); ?>][condition_value]"
		class="af-wbs-condition-value " value="<?php echo esc_attr($number); ?>" min="0" step="any">
	<?php
}

function af_wbs_created_post_on_default_woocommerce_shipping( $instance_id ) {
	// Define query arguments
	$post_args = array(
		'post_type' => 'addify_wbs_a_s_c_f_w',
		'post_status' => 'publish',
		'fields' => 'ids',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => 'af_wbs_shipping_instance_id',
				'value' => $instance_id,
				'compare' => '=',
			),
		),
	);

	// Retrieve existing posts that match the meta query
	$existing_posts = get_posts($post_args);

	if (!empty($existing_posts)) {
		// If existing posts are found, retrieve the first post ID
		$post_id = current($existing_posts);
	} else {
		// If no existing posts are found, insert a new post
		$post_id = wp_insert_post(
			array(
				'post_type' => 'addify_wbs_a_s_c_f_w',
				'post_status' => 'publish',
				'meta_input' => array(
					'af_wbs_shipping_instance_id' => $instance_id,
				),
			)
		);
	}

	return $post_id;
}
function show_shipping_methods_with_shipping_zone( $current_post_detail_status = array() ) {
	$get_all_posts = get_posts(
		array(
			'post_type' => 'addify_wbs',
			'post_status' => 'any',
			'fields' => 'ids',
			'posts_per_page' => -1,
		)
	);

	foreach ($get_all_posts as $current_post_id) {
		if ($current_post_id) {

			$new_post_status = get_post_status($current_post_id);
			if (in_array($current_post_id, $current_post_detail_status) && isset($current_post_detail_status['post_status'])) {

				$new_post_status = $current_post_detail_status['post_status'];
			}

			if (in_array($new_post_status, array( 'publish', 'published' ))) {
				?>
				<tr class="af-wbs-custom-shipping" data-id="1" data-enabled="yes"
					data-post_id="<?php echo esc_attr($current_post_id); ?>">
				<?php } else { ?>
				<tr class="af-wbs-custom-shipping" data-id="1" data-enabled="no"
					data-post_id="<?php echo esc_attr($current_post_id); ?>">
				<?php } ?>

				<td width="1%" class="wc-shipping-zone-method-sort ui-sortable-handle"></td>
				<td class="wc-shipping-zone-method-title">
					<?php echo esc_attr(get_post_meta($current_post_id, 'af_wbs_shipping_title', true)); ?>
				</td>
				<td width="1%" class="wc-shipping-zone-method-enabled">
					<?php if (in_array($new_post_status, array( 'publish', 'published' ))) { ?>
						<a href="#" class="af-wbs-publish-draft-post" data-set_status="draft">
							<span
								class="woocommerce-input-toggle woocommerce-input-toggle--enabled"><?php echo esc_html__('Yes', 'addify-weight-based-shipping'); ?></span>
						</a>
					<?php } else { ?>
						<a href="#" class="af-wbs-publish-draft-post" data-set_status="publish">
							<span
								class="woocommerce-input-toggle woocommerce-input-toggle--disabled"><?php echo esc_html__('No', 'addify-weight-based-shipping'); ?></span>
						</a>
					<?php } ?>
				</td>
				<td class="wc-shipping-zone-method-description">
					<p><?php echo esc_attr(get_the_title($current_post_id)) . ' ' . esc_html__('(Created by Weight Based Shipping extension)', 'addify-weight-based-shipping'); ?>
					</p>
				</td>
				<td class="wc-shipping-zone-actions">
					<div>
						<a class="wc-shipping-zone-action-edit"
							href="<?php echo esc_url(get_edit_post_link($current_post_id)); ?>&amp;tab=shipping&amp;instance_id=1"><?php echo esc_html__('Edit', 'addify-weight-based-shipping'); ?>
						</a>
						<a href="#" data-post_id="<?php echo esc_attr($current_post_id); ?>"
							class="af-delete-shipping-post wc-shipping-zone-method-delete wc-shipping-zone-actions"><?php echo esc_html__('Delete', 'addify-weight-based-shipping'); ?>
						</a>
					</div>
				</td>
			</tr>
			<?php
		}
	}
}

function af_wbs_get_shipping_method_type() {
	$zones = WC_Shipping_Zones::get_zones();

	$shipping_method_details = array();

	foreach ($zones as $zone) {
		$shipping_methods = $zone['shipping_methods'];

		foreach ($shipping_methods as $method) {

			$post_id = af_wbs_created_post_on_default_woocommerce_shipping($method->instance_id);

			$enable_weight_based_shipping = get_post_meta($post_id, 'af_wbs_enable_weight_based_shipping', true);


			$shipping_method_details[] = array(
				'instance_id' => $method->instance_id,
				'method_type' => $method->id,
				'enabled_weight_base_shipping' => $enable_weight_based_shipping,
			);
		}
	}
	return $shipping_method_details;
}



function af_wbs_custom_array_filter( $filters = array() ) {
	$filters = array_filter(
		(array) $filters,
		function ( $current_value, $current_key ) {
			return ( '' !== $current_value && '' !== $current_key );
		},
		ARRAY_FILTER_USE_BOTH
	);

	return $filters;
}