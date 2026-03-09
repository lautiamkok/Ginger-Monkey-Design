<?php
/**
 * Rare Penny functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */

// Enable menu support.
// https://developer.wordpress.org/reference/functions/add_theme_support/
register_nav_menus([
    'primary-menu' => __('Primary Menu'),
    'secondary-menu' => __('Secondary Menu')
]);

// Enable post thumbnail support.
// https://codex.wordpress.org/Post_Thumbnails
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

// Set the image size by resizing the image proportionally (without distorting
// it): 
// https://developer.wordpress.org/reference/functions/add_image_size/
add_image_size('placeholder', 50, 50, false);

// Make sure WP doesn't use a cropped image on thumbnail in the CMS.
// add_action('after_setup_theme', function() {
//     set_post_thumbnail_size(300, 300, false);
// });

// // Prevent uploaded images from being cropped.
// // https://wordpress.stackexchange.com/questions/430478/prevent-uploaded-images-from-being-cropped
// add_action('after_setup_theme', function() {
//     add_image_size('medium', 300, 300, false);
// });

// Allow .svg files to be uploaded.
// Allow SQLite databases upload.
function enable_svg_upload($upload_mimes) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    $upload_mimes['sqlite3'] = 'application/vnd.sqlite3';
    return $upload_mimes;
}
add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

// Add a table of image sizes to the Settings > Media admin page
add_action('admin_init', function() {
    add_settings_section(
        'dummy_registered_image_sizes_info',
        esc_html__('Registered Image Sizes', 'text_domain'),
        function() {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead><tr><th>' . esc_html__('Name', 'text_domain') . '</th><th>' . esc_html__('Dimensions', 'text_domain') . '</th></tr></thead>';
            foreach ((array) wp_get_registered_image_subsizes() as $size => $dims) {
                if (! in_array($size, [ 'thumbnail', 'medium', 'large' ], true)) {
                    $width = $dims['width'] ?? 0;
                    $height = $dims['height'] ?? 0;
                    echo "<tr><td><strong>{$size}</strong></td><td>{$width}x{$height}</td>";
                }
            }
            echo '</table>';
        },
        'media'
   );
}, PHP_INT_MAX);

// Utils.
include 'inc/util/utils.php';
include 'inc/util/menus.php';
include 'inc/util/metainfo.php';

// Install metaboxes.
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('after_setup_theme', 'crb_load');
function crb_load() {
    require_once('vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}

include 'inc/metabox/carbon-fields/config.php';
include 'inc/metabox/carbon-fields/commons.php';
include 'inc/metabox/carbon-fields/fields/theme-options.php';
include 'inc/metabox/carbon-fields/fields/metainfo.php';
include 'inc/metabox/carbon-fields/fields/thumbnail-attributes.php';
include 'inc/metabox/carbon-fields/fields/home-attributes.php';
include 'inc/metabox/carbon-fields/fields/post-attributes.php';
include 'inc/metabox/carbon-fields/fields/blocks/home.php';
include 'inc/metabox/carbon-fields/fields/blocks/about.php';
include 'inc/metabox/carbon-fields/fields/blocks/shop.php';
include 'inc/metabox/carbon-fields/fields/blocks/faq.php';
include 'inc/metabox/carbon-fields/fields/blocks/product.php';

// Include APIs.
include 'inc/api/commons.php';
include 'inc/api/mailchimp.php';
include 'inc/api/newsletter/post/add.php';
include 'inc/api/stockists/get/get-csv.php';
include 'inc/api/stockists/get/get-sqlite.php';

// Disable Gutenberg Completely
// disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);

// disable for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

// Limit the Image Upload Size.
function whero_limit_image_size($file) {
    // Calculate the image size in KB.
    $image_size = $file['size'] / 1024;

    // File size limit in KB.
    $limit = 5120; // 5 MB

    // Check if it's an image.
    $is_image = strpos($file['type'], 'image');
    $is_gif = strpos($file['type'], 'gif');

    // No limit for gif.
    if ($is_gif !== false) {
        return $file;
    }

    if (($image_size > $limit) && ($is_image !== false)) {
        $file['error'] = 'Your picture is too large. It has to be smaller than '. $limit / 1024 .'MB. Longest dimension must not exceed 1920 pixels, 72dpi.';
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'whero_limit_image_size');

// Add extra fields to the post's featured image.
// https://wordpress.stackexchange.com/questions/263422/add-extra-fields-to-the-posts-featured-image
// https://developer.wordpress.org/reference/hooks/admin_post_thumbnail_html/
// add_filter('admin_post_thumbnail_html', 'custom_featured_image_field', 10, 2);
// function custom_featured_image_field($content, $post_id) {
//     $custom_name    = 'custom_featured_image_title';
//     $custom_value = esc_attr(get_post_meta($post_id, $custom_name, true));

//     $output = sprintf(
//         '<input type="text" id="%1$s" name="%1$s" value="%2$s">',
//         $custom_name, $custom_value
//    );

//     return $content .= $output;
// }

// https://github.com/woocommerce/woocommerce-blocks/blob/trunk/src/StoreApi/docs/nonce-tokens.md
// add_filter('woocommerce_store_api_disable_nonce_check', '__return_true');

// Add ml to weight units.
// https://wpdesk.net/blog/change-weight-unit-in-woocommerce-no-code/
function add_woocommerce_weight_unit_ml($settings) {
    foreach ($settings as &$setting) {
        if ('woocommerce_weight_unit' == $setting['id']) {
            $setting['options']['ml'] = __('ml', 'woocommerce'); // new unit
        }
    }
    return $settings;
}

add_filter('woocommerce_products_general_settings', 'add_woocommerce_weight_unit_ml');

// https://www.cloudways.com/blog/add-custom-product-fields-woocommerce/
// Display custom fields.
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
function woocommerce_product_custom_fields() {
    global $woocommerce, $post;
    echo '';

    // custom product text field.
    // Vol:
    woocommerce_wp_text_input(
        [
            'id' => '_custom_product_vol',
            'placeholder' => 'Volume in ML',
            'label' => __('Volume in ML', 'woocommerce'),
            'desc_tip' => 'true'
        ]
    );

    // ABV:
    woocommerce_wp_text_input(
        [
            'id' => '_custom_product_abv',
            'placeholder' => 'Alcohol By Volume',
            'label' => __('Alcohol By Volume', 'woocommerce'),
            'desc_tip' => 'true'
        ]
    );

    // // Region:
    // woocommerce_wp_text_input(
    //     [
    //         'id' => '_custom_product_region',
    //         'placeholder' => 'Region',
    //         'label' => __('Region', 'woocommerce'),
    //         'desc_tip' => 'true'
    //     ]
    // );

    // // Age:
    // woocommerce_wp_text_input(
    //     [
    //         'id' => '_custom_product_age',
    //         'placeholder' => 'Age',
    //         'label' => __('Age', 'woocommerce'),
    //         'desc_tip' => 'true'
    //     ]
    // );

    // Highlights:
    woocommerce_wp_textarea_input(
        [
            'id' => '_custom_product_highlights',
            'placeholder' => 'Highlights (line breaks to bullets)',
            'label' => __('Highlights', 'woocommerce'),
            'desc_tip' => 'true',
            'rows' => 9
        ]
    );

    // Note:
    woocommerce_wp_text_input(
        [
            'id' => '_custom_product_note',
            'placeholder' => 'Note',
            'label' => __('Note', 'woocommerce'),
            'desc_tip' => 'true'
        ]
    );
    echo '';
}

// Save custom fields.
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields_save($post_id) {
    update_post_meta($post_id, '_custom_product_vol', esc_attr($_POST['_custom_product_vol']));
    update_post_meta($post_id, '_custom_product_abv', esc_attr($_POST['_custom_product_abv']));

    // $woocommerce_custom_product_region = $_POST['_custom_product_region'];
    // if (!empty($woocommerce_custom_product_region)) {
    //     update_post_meta($post_id, '_custom_product_region', esc_attr($woocommerce_custom_product_region));
    // }

    // $woocommerce_custom_product_age = $_POST['_custom_product_age'];
    // if (!empty($woocommerce_custom_product_age)) {
    //     update_post_meta($post_id, '_custom_product_age', esc_attr($woocommerce_custom_product_age));
    // }

    update_post_meta($post_id, '_custom_product_highlights', esc_attr($_POST['_custom_product_highlights']));
    update_post_meta($post_id, '_custom_product_note', esc_attr($_POST['_custom_product_note']));
}

// Make sure WC doesn't use cropped images on the cart and checkout pages.
// https://wordpress.stackexchange.com/questions/318534/how-to-change-product-thumbnail-size-in-storefront-theme
// https://theme.co/forum/t/woocommerce-product-gallery-thumbnails-cropped/47367/3
// https://stackoverflow.com/questions/38811880/disable-original-image-crop-in-woocommerce
add_filter('woocommerce_get_image_size_thumbnail', function($size) {
  return array(
    'width'  => 300,
    'height' => 300,
    'crop'   => 0,
  );
});

// Create a page without adding a page in the database: unsubscribe, verify.
// https://wordpress.stackexchange.com/questions/37644/create-a-page-without-adding-a-page-in-the-database
add_action('query_vars','add_query_vars');
function add_query_vars($vars) {
    // Get params from the URL query string for course pages. e.g. /course/course-1?vip=Tt9HaHTmxlvbU3B9
    // A test.
    // Usage:
    // localhost:4000/?xyz=hello-world
    array_push($vars, 'xyz');

    // Param for subscription verification.
    // Usage:
    // localhost:4000/verify-subscription/?t=xY325erqrtqXxooox
    array_push($vars, 't');

    // Add other custom accepted query variables.
    array_push($vars, 'verify_subscription');

    // Add a custom title to the page.
    array_push($vars, 'meta_title');
    return $vars;
}

add_action('init', 'add_rewrite_rules');
function add_rewrite_rules() {
    // Must flush rewrite rules each time when a new rule is added.
    // flush_rewrite_rules();

    // Regex to match whole words only. Use ?$ to strictly match and ensure it ends there.
    // Usage:
    // http://localhost:4000/verify-subscription/?t=[token]
    add_rewrite_rule('^verify-subscription/?$','index.php?verify_subscription=1&post_type=page&meta_title=Subscription','top');
}

add_filter('template_include', 'add_templates', 1000, 1);
function add_templates($template) {
    // For testing purpose:
    // global $wp_query;
    // print_r($wp_query->query);

    if (get_query_var('verify_subscription')) {
        $new_template = get_template_directory() . '/verify-subscription.php';
        if (file_exists($new_template)) {
            $template = $new_template;
        }
    }
    return $template;
}

// https://search.brave.com/search?q=woocommerce+how+to+empty+cart+if+a+product+is+not+in+the+cart&summary=1&conversation=ab8473cca9ec7621750b4b
function custom_empty_cart_if_core_product_not_found() {
    $is_core_product = false;

    // Get the cart items
    $cart_items = WC()->cart->get_cart();
    foreach ($cart_items as $cart_item) {
        // https://developer.wordpress.org/reference/functions/wp_get_post_terms/
        $tax_tags = wp_get_post_terms($cart_item['product_id'], 'product_cat', array("fields" => "all")) ?? [];
        
        // Check if the core product is in the cart
        if (is_countable($tax_tags) && count($tax_tags) > 0) {
            $is_core_product = in_array('core-range', array_column($tax_tags, 'slug'));
        }
        if ($is_core_product) {
            break;
        }
    }

    // If the core product is not in the cart, empty the cart
    if (!$is_core_product) {
        WC()->cart->empty_cart();
    }
}
add_action('woocommerce_before_calculate_totals', 'custom_empty_cart_if_core_product_not_found');

// Limit each item order quantity to a max only.
function limit_cart_item_quantity() {
    // Get the cart instance
    $cart = WC()->cart;

    // Get the cart items and loop them.
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        // Get the quantity of the current cart item.
        if ($cart_item['quantity'] > 50) {
            // Update the quantity to 50 max.
            $cart->set_quantity($cart_item_key, 50);
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'limit_cart_item_quantity');

// A hack for emails sent by WC but not be received.
// https://www.gmass.co/smtp-test 
// https://wordpress.stackexchange.com/questions/344009/how-to-use-phpmailer-in-a-function-in-wordpress
function send_smtp_email($phpmailer) {
    // Get the SMTP details from theme options.
    $smtp_server1 = carbon_get_theme_option('smtp_servers')[0] ?? [];
    if (is_countable($smtp_server1) && count($smtp_server1) === 0) {
        return;
    }

    // Get WC email sender options.
    $from_name = get_option('woocommerce_email_from_name');
    $from_email = get_option('woocommerce_email_from_address');

    // Make the SMTP connection to send emails.
    $phpmailer->SMTPDebug = $smtp_server1['debug'] ?? false;
    $phpmailer->isSMTP();
    $phpmailer->Host = $smtp_server1['host'];
    $phpmailer->Port = $smtp_server1['port'];
    $phpmailer->SMTPSecure = $smtp_server1['encryption'];
    $phpmailer->SMTPAuth = $smtp_server1['authentication'] ?? false;
    $phpmailer->Username = $smtp_server1['username'];
    $phpmailer->Password = $smtp_server1['password'];
    $phpmailer->From = $from_email;
    $phpmailer->FromName = $from_name;
    // $phpmailer->addReplyTo('contact@lauthiamkok.net', 'Information');

    // Without SMTP connection, lines below occasionally work on certain servers.
    // $phpmailer->setFrom($from_email, $from_name);
    // $phpmailer->addAddress('lau.thiamkok@googlemail.com', 'Joe User');     //Add a recipient
    // $phpmailer->addAddress('lau15081975@gmail.com', 'Joe User');     //Add a recipient
    // $phpmailer->addReplyTo('no-reply@lauthiamkok.net', 'Information');
}
add_action('phpmailer_init', 'send_smtp_email');


// https://webhostinghero.org/how-to-remove-h1-headings-from-the-wordpress-editor-dropdown/
// https://stevegrunwell.com/blog/wordpress-tinymce-block-formats/
function remove_h1($args) {
    // Just omit h1 from the list
    $block_formats = array(
        'Paragraph=p',
        // 'Heading 1=h1',
        'Heading 2=h2',
        'Heading 3=h3',
        'Heading 4=h4',
        'Heading 5=h5',
        'Heading 6=h6',
        'Pre=pre',
        'Code=code',
    );
    $args['block_formats'] = implode(';', $block_formats);

    // formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_more,spellchecker,wp_adv,dfw
    // $args['toolbar1'] = 'formatselect,bold,italic,bullist,numlist,link,spellchecker';
    // unset($args['toolbar2']);

    return $args;
}
add_filter('tiny_mce_before_init', 'remove_h1');
