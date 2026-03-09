<?php
/**
 * The template for displaying "Product" single page
 * Use this template to override Woocommerce default shop page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>

<main>
<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        get_template_part('template-parts/singles/product/content');
    endwhile;
else :
    get_template_part('template-parts/contents/none');
endif;
?>
</main>

<?php get_footer();
