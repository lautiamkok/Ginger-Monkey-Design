<!-- w-6/12 -->
<div class="w-6/12 <lg:w-12/12 px-10 <xl:px-5 <lg:px-0 space-y-10 border-0 border-red-500" >

  <a href="<?php the_permalink(); ?>" class="aspect-1 block transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 bg-milk-light border-0 border-red-500">

    <?php if (has_post_thumbnail()): ?>
    <?php
    $thumbnail_id = get_post_thumbnail_id();
    $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    ?>
    <img 
      src="<?php the_post_thumbnail_url('medium_large'); ?>" 
      class="w-full h-full object-contain scale-90 transform object-center border-0 border-red-500" 
      alt="<?php echo $alt; ?>"
    >
    <?php endif; ?>

  </a>

  <div class="px-5 space-y-4">

    <div class="text-4xl font-title text-red-regular border-0 border-red-500">
      <p>
        <a href="<?php the_permalink(); ?>" class="transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-red-500 font-serif font-medium tracking-wide">
        <?php the_title(); ?>
        </a>
      </p>
    </div>

    <div class="text-2xl <md:text-xl border-0 border-red-500">
      <?php 
        echo replace_brackets(get_the_excerpt());
      ?>
    </div>

    <a class="btn pt-1" href="<?php the_permalink(); ?>">
      <button>Go to result</button>
    </a>

  </div>

</div>
<!-- w-6/12 -->
