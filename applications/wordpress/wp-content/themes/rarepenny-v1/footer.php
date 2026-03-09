<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */

?>
  
  <?php get_template_part('template-parts/footer'); ?>

<?php wp_footer(); ?>

</body>

<style>
  .wp-block-heading {
    padding-bottom: 1em;
  }

  .wc-block-grid__product {
    display: flex;
    flex-direction: column;
  }

  .wc-block-grid__product > a {
    flex-grow: 1;
  }
</style>

</html>
