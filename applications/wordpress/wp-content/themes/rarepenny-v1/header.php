<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */

// Redirect the Shop page to the Courses page.
// Get current request URL.
// global $wp;
// $url = home_url($wp->request);

// // Parse URL into an array.
// // https://www.php.net/manual/en/function.parse-url.php
// $arrayUrl = parse_url($url, $component = -1);

// // Redirect all product pages to shop before the header in rendered.
// // https://developer.wordpress.org/reference/functions/wp_redirect/
// if (isset($arrayUrl['path']) && strpos($arrayUrl['path'], '/product/') !== false) {
//   wp_redirect(site_url() . '/shop/');
// }

// // Redirect all recipe pages to shop before the header in rendered.
// if (isset($arrayUrl['path']) && strpos($arrayUrl['path'], '/recipe/') !== false) {
//   wp_redirect(site_url() . '/cocktails/');
// }

// Retrieves the ID of the currently queried object with get_queried_object_id().
// https://developer.wordpress.org/reference/functions/get_queried_object_id/
$post_meta = create_post_meta(get_queried_object_id(), $type = 'article');
$meta_og = $post_meta['og'];

// Get the theme meta.
$open_graph = carbon_get_theme_option('open_graph')[0];
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- standard meta content -->
  <meta name="description" content="<?php echo $post_meta['description'];?>">
  <meta name="keywords" content="<?php echo $post_meta['keywords']; ?>">

  <!-- social meta content -->
  <meta property="og:type" content="<?php echo $open_graph['og_type']; ?>">
  <meta property="og:url" content="<?php echo site_url(); ?>">
  <meta property="og:title" content="<?php echo $meta_og['title']; ?>">
  <meta property="og:description" content="<?php echo $meta_og['description']; ?>">
  <meta property="og:image" content="<?php echo $meta_og['image']; ?>">
  <meta property="og:image:width" content="<?php echo $open_graph['og_image_width']; ?>">
  <meta property="og:image:height" content="<?php echo $open_graph['og_image_height']; ?>">
  <meta property="fb:app_id" content="<?php echo $open_graph['fb_app_id']; ?>">

  <?php if ($open_graph['twitter_site']): ?>
  <meta name="twitter:site" content="<?php echo $open_graph['twitter_site']; ?>">
  <?php endif; ?>

  <?php if ($open_graph['twitter_creator']): ?>
  <meta name="twitter:creator" content="<?php echo $open_graph['twitter_creator']; ?>">
  <?php endif; ?>

  <meta name="twitter:card" content="<?php echo $open_graph['twitter_card']; ?>">
  <meta name="twitter:description" content="<?php echo $meta_og['description']; ?>">

  <title><?php echo $post_meta['title']; ?></title>

  <?php wp_head(); ?>

  <?php get_template_part('template-parts/scripts/global');?>
</head>

<body id="top">
<?php wp_body_open(); ?>

<?php
// No Vue for Woocommerce in the following pages.
global $post;
$current_page_slug = $post ? $post->post_name : '';
$blacklist = [
  'cart',
  'checkout'
];
$is_blacklisted = in_array($current_page_slug, $blacklist) ?? false;
wp_cache_set('is_blacklisted', $is_blacklisted);
?>

  <?php get_template_part('template-parts/header');?>
