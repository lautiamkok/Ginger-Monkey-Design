<?php
/**
 * The template for displaying "Shop" page (Option 2)
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
// http://localhost:4000/shop/?paged=2
$paged = $wp_query->query_vars['paged'];
$page_number = is_numeric($paged) && $paged > 0 ? $paged : 1;
$post_type = 'product';

$query_args = [
  'post_type' => $post_type,
  'post_status' => ['publish'],
  'posts_per_page' => 12, // limit posts.
  'paged' => $page_number,
  'orderby' => 'date',
  'order' => 'DESC',
  'tax_query' => [
    [
      'taxonomy' => 'product_cat', // e.g. 'course-category'
      'field' => 'slug', //this is by slug
      'terms' => 'upsell', // slug name
      'operator' => 'NOT IN' // not in tag
    ]
  ]
];

$loop = new WP_Query($query_args);
// $posts = $loop->get_posts();
// print_r($posts);

// Create pager.
$max_pages = $loop->max_num_pages;
$next = (int)$max_pages === 0 || (int)$page_number === (int)$max_pages ? null :  ($page_number + 1);
$prev = (int)$page_number === 1 ? null : ($page_number - 1);
?>

<?php
// https://developer.wordpress.org/reference/functions/get_post_thumbnail_id/
$post_thumbnail_id = get_post_thumbnail_id();
if ($post_thumbnail_id):
  $image_url = wp_get_attachment_image_src($post_thumbnail_id, '1536x1536')[0];
  $image_placeholder_url = get_image_url($post_thumbnail_id, 'placeholder');
  $image_alt = carbon_get_the_post_meta('thumbnail_alt');
  // var_dump($image_url);
  // var_dump($image_placeholder_url);
?>

<!-- block -->
<div 
  class="relative overflow-hidden w-full h-[82vh] <2xl:h-[75vh] !portrait:h-fit border-0 border-green-500"
  data-aos="fade-in" 
  data-aos-duration="1000"
  data-aos-delay="500"
>

  <div class="<md:hidden parallax w-full h-[90vh] <2xl:h-[75vh] border-blue-500 border-0 portrait:hidden" data-parallax-speed="4">
    <img 
      class="
        w-full 
        h-full
        bg-black 
        object-bottom
        object-cover

        transition-all 
        duration-1000
        blur-3xl
        filter
        scale-125
        <2xl:scale-128

        lazy
      "
      src="<?php echo $image_placeholder_url; ?>"
      data-src="<?php echo $image_url; ?>"
      alt="<?php echo $image_alt; ?>"
    />
  </div>

  <div class="<md:hidden parallax w-full h-[40vh] border-blue-500 border-0 landscape:hidden" data-parallax-speed="1">
    <img 
      class="
        w-full 
        h-full
        bg-black 
        object-bottom
        object-cover

        transition-all 
        duration-1000
        blur-3xl
        filter
        scale-128

        lazy
      "
      src="<?php echo $image_placeholder_url; ?>"
      data-src="<?php echo $image_url; ?>"
      alt="<?php echo $image_alt; ?>"
    />
  </div>

  <img 
    class="
      md:hidden
      w-full 
      h-full
      bg-black 
      object-center
      object-cover

      transition-all 
      duration-1000
      blur-3xl
      filter

      lazy
    "
    src="<?php echo $image_placeholder_url; ?>"
    data-src="<?php echo $image_url; ?>"
    alt="<?php echo $image_alt; ?>"
  />
</div>
<!-- block -->

<?php endif; ?>


<!-- block -->
<div class="bg-wine-red-regular">

  <!-- container -->
  <div class="2xl:container mx-auto flex flex-wrap justify-center py-20 px-10 <sm:px-5 border-0 border-red-500">

    <!-- w-5/12 -->
    <div class="w-7/12 <xl:w-10/12 <lg:w-12/12 space-y-10 items-starts border-0 border-green-500">
      
      <div 
        class="text-4xl <md:text-3xl space-y-10 text-center font-serif tracking-wide text-milk-light"
        data-aos="fade-up" 
        data-aos-duration="1000"
      >
        <?php 
        $body = wpautop(get_the_content()); 
        echo replace_brackets($body);
        ?>
      </div>

    </div>
    <!-- w-5/12 -->

  </div>
  <!-- container -->
  
</div>
<!-- block -->

<!-- block -->
<div class="py-10 pb-20 <xl:pb-10 px-10 <md:px-5 bg-milk-regular border-0 border-red-500 <md:space-y-10" id="explore">

  <?php $note1 = carbon_get_the_post_meta('notes')[0] ?? []; ?>
  <?php if (is_countable($note1) && count($note1) > 0): ?>

  <div class="2xl:container mx-auto border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >

    <div class="text-lg text-wine-red-regular px-10 <md:px-0">
      <?php echo wpautop($note1['body']); ?>
    </div>

  </div>

  <?php endif; ?>

  <?php if ($loop->have_posts()): ?>

  <!-- container -->
  <div class="2xl:container mx-auto flex flex-col flex-wrap items-start justify-start space-y-15 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    
    <div class="flex flex-wrap items-center justify-center w-full <lg:flex-col <lg:space-x-0 <lg:space-y-5 ">
      <ul class="w-full flex flex-wrap items-stretch justify-start <md:space-y-10 border-0 border-green-500">
        <?php
        while($loop->have_posts()): $loop->the_post();
            get_template_part('template-parts/pages/shop/content');
        endwhile;
        ?>
      </ul>
    </div>

    <?php if ($next || $prev): ?>

    <!-- block: pager -->
    <div class="w-full flex flex-wrap justify-between border-0 border-red-500">

      <!-- item -->
      <nav>
        <ul class="">
          <li>

            <?php if ($prev): ?>

            <a href="<?php echo site_url(); ?>/shop/?paged=<?php echo $prev; ?>#explore"
              class="text-7xl <md:text-5xl transition-all ease-in-out duration-300 opacity-100 hover:opacity-50"
            >
              <i class="icon-chevron-thin-left"></i>
            </a>

            <?php else: ?>

            <span>
              <i class="icon-chevron-thin-left text-7xl <md:text-5xl opacity-20 cursor-not-allowed"></i>
            </span>

            <?php endif; ?>

          </li>
        </ul>
      </nav>
      <!-- item -->

      <!-- item -->
      <div class="flex justify-center items-center">
        <span>
          <?php echo $page_number; ?> / <?php echo $max_pages; ?>
        </span>
      </div>
      <!-- item -->

      <!-- item -->
      <nav>
        <ul class="">
          <li>

            <?php if ($next): ?>

            <a href="<?php echo site_url(); ?>/shop/?paged=<?php echo $next; ?>#explore"
              class="text-7xl <md:text-5xl transition-all ease-in-out duration-300 opacity-100 hover:opacity-50"
            >
              <i class="icon-chevron-thin-right"></i>
            </a>

            <?php else: ?>

            <span>
              <i class="icon-chevron-thin-right text-7xl <md:text-5xl opacity-20 cursor-not-allowed"></i>
            </span>

            <?php endif; ?>

          </li>
        </ul>
      </nav>
      <!-- item -->

    </div>
    <!-- block -->

    <?php endif; ?>

  </div>
  <!-- container -->

  <?php endif; ?>

</div>
<!-- block -->

<?php
// Reset Query
wp_reset_postdata();
?>

<?php get_template_part('template-parts/contents/newsletter'); ?>

</main>

<?php get_footer();
