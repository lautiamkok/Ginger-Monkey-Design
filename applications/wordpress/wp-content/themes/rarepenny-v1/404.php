<?php
/**
 * The template for displaying 404 page.
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
    <?php get_template_part('template-parts/pages/404/content'); ?>
</main>

<?php get_footer();
