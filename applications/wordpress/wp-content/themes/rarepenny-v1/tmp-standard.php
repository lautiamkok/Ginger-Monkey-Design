<?php
/*
Template Name: Standard
Template Post Type: page
*/

/**
 * The template for displaying "Standard" page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>

<main class="space-y-24 <md:space-y-12">
<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        get_template_part('template-parts/pages/standard/content');
    endwhile;
else :
    get_template_part('template-parts/contents/none');
endif;
?>
</main>

<?php get_footer();
