<?php
/**
 * The template for displaying "Search" page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>

<?php 
$search_term = get_search_query();
$posts_count = $wp_query->found_posts;
 ?>

<main>

  <!-- block -->
  <div
    class="bg-earth-dark bg-cover bg-center bg-no-repeat"
    style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-black.jpg');"
  >

    <div class="text-center py-15 border-0 border-red-500" >
      <div
        class="2xl:container mx-auto flex flex-col justify-center items-center"
        data-aos="fade-up" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >
        <h1 class="w-5/12 <2xl:w-6/12 <xl:w-8/12 <lg:w-9/12 <md:w-full text-white text-7xl <lg:text-6xl font-serif border-0 border-blue-500">
          Search results for ‘<?php echo $search_term; ?>’
        </h1>
      </div>
    </div>

  </div>
  <!-- block -->


  <!-- block -->
  <div class="py-30 px-10 <md:px-5 bg-milk-regular space-y-10">

    <?php if (have_posts()): ?>

    <!-- container -->
    <div class="2xl:container mx-auto flex flex-wrap justify-center <md:pt-0 <md:pb-0 [&>div]:mb-10 border-0 border-red-500">

      <?php
      while (have_posts()): the_post();
        get_template_part('template-parts/pages/search/content');
      endwhile;
      ?>

    </div>
    <!-- container -->

    <?php else: ?>
      
    <!-- container -->
    <div class="2xl:container mx-auto flex flex-wrap justify-center [&>:not(:last-child)]:mb-10 border-0 border-red-500">

      <div class="text-3xl <md:text-2xl has-paragraphs has-links has-lists">
         <?php get_template_part('template-parts/contents/none'); ?>
      </div>

    </div>
    <!-- container -->

    <?php endif; ?>

    <?php
    // http://localhost:4000/?s=abc&paged=2
    $paged = $wp_query->query_vars['paged'];
    $page_number = is_numeric($paged) && $paged > 0 ? $paged : 1;

    // $posts_per_page = get_option('posts_per_page');
    // $query_args = [
    //     's' => $search_term,
    //     'post_status' => ['publish'],
    //     'posts_per_page' => $posts_per_page, // limit posts.
    //     'paged' => $page_number
    // ];

    // $loop = new WP_Query($query_args);
    // $max_pages = $loop->max_num_pages;

    $max_pages = $wp_query->max_num_pages; 
    $next = (int)$max_pages === 0 || (int)$page_number === (int)$max_pages ? null :  ($page_number + 1);
    $prev = (int)$page_number === 1 ? null : ($page_number - 1);
    ?>
  
    <?php if ($next || $prev): ?>

    <!-- container -->
    <div class="2xl:container mx-auto flex justify-between px-10 <md:px-5 x!hidden border-0 border-orange-500">

      <?php if ($prev): ?>

      <a 
        href="<?php echo site_url(); ?>?s=<?php echo $search_term;?>&paged=<?php echo $prev; ?>"
      >
        <i class="icon-chevron-thin-left text-7xl <md:text-5xl transition-all ease-in-out duration-300 opacity-100 hover:opacity-50"></i>
      </a>

      <?php else: ?>

      <span>
        <i class="icon-chevron-thin-left text-7xl <md:text-5xl opacity-20 cursor-not-allowed"></i>
      </span>

      <?php endif; ?>

      <!-- item -->
      <div class="flex justify-center items-center">
        <span><?php echo $page_number; ?> / <?php echo $max_pages; ?></span>
      </div>
      <!-- item -->


      <?php if ($next): ?>

      <a href="<?php echo site_url(); ?>?s=<?php echo $search_term;?>&paged=<?php echo $next; ?>">
        <i class="icon-chevron-thin-right text-7xl <md:text-5xl transition-all ease-in-out duration-300 opacity-100 hover:opacity-50"></i>
      </a>

      <?php else: ?>

      <span>
        <i class="icon-chevron-thin-right text-7xl <md:text-5xl opacity-20 cursor-not-allowed"></i>
      </span>

      <?php endif; ?>

    </div>
    <!-- container -->

    <?php endif; ?>

    <?php
    // Reset Query
    wp_reset_postdata();
    ?>

  </div>
  <!-- block -->

  <?php get_template_part('template-parts/contents/newsletter'); ?>

</main>

<?php get_footer();
