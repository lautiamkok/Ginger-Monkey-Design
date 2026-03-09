<?php
/**
 * Plugin Name:       Weight Based Shipping
 * Requires Plugins: woocommerce
 * Plugin URI:        https://woocommerce.com/products/addify-weight-based-shipping/
 * Description:       WooCommerce Weight Based Shipping offers flexible, weight based shipping options and pricing for accurate rates and better cost management.
 * Version:           1.3.0
 * Author:            Addify
 * Developed By:      Addify
 * Author URI:        https://woocommerce.com/vendor/addify/
 * Support:           https://woocommerce.com/vendor/addify/
 * Domain Path:       /languages
 * Text Domain:       addify-weight-based-shipping
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * WC requires at least: 4.0
 * WC tested up to: 9.*.*
 * Requires at least: 6.5
 * Tested up to: 6.*.*
 * Requires PHP: 7.4
 * Woo: 18734004226998:00b13a8a3eb5bd5112fc30a603585b0b

 */

if (!defined('ABSPATH')) {
	exit();
}

// Check the installation of WooCommerce module if it is not a multi site.
if (!class_exists('Addify_Weight_Base_Shipping_Fee')) {

	class Addify_Weight_Base_Shipping_Fee {
	
		public function __construct() {
			$this->addify_wbsf_global_constents_vars();
			add_action('before_woocommerce_init', array( $this, 'af_wbsf_hops_compatibility' ));
			add_action('plugin_loaded', array( $this, 'af_pc_wc_check' ));
			include_once AF_WBS_DIR . 'includes/main.php';
		}
		public function af_pc_wc_check() {
			if (!is_multisite() && ( !in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true) )) {
				add_action('admin_notices', array( $this, 'af_pc_wc_active' ));
			}
		}
		public function af_pc_wc_active() {
			deactivate_plugins(__FILE__);
			?>
			<div id="message" class="error">
				<p>
					<strong>
						<?php echo esc_html__('Weight Based Shipping plugin is inactive. WooCommerce plugin must be active in order to activate it.', 'addify-weight-based-shipping'); ?>
					</strong>
				</p>
			</div>
			<?php
		}
		public function af_wbsf_hops_compatibility() {
			if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
			}
		}
		public function addify_wbsf_global_constents_vars() {
			if (!defined('AF_WBS_URL')) {
				define('AF_WBS_URL', plugin_dir_url(__FILE__));
			}
			if (!defined('AF_WBS_DIR')) {
				define('AF_WBS_DIR', plugin_dir_path(__FILE__));
			}
		}
	}
	new Addify_Weight_Base_Shipping_Fee();
}