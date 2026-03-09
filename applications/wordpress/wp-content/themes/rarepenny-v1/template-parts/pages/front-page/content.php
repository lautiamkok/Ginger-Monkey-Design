<?php $penny_videos = carbon_get_the_post_meta('penny_videos') ?? []; ?>
<?php if (is_countable($penny_videos) && count($penny_videos) > 0): ?>

<!-- block: video -->
<div class="border-0 border-red-500 block cursor-pointer">

  <?php foreach($penny_videos as $key => $penny_video): ?>
  <?php
  $image_url = wp_get_attachment_image_src($penny_video['poster_id'], 'large')[0];
  $video_url = wp_get_attachment_url($penny_video['video_id']);
  ?>
  <video 
    class="
    <?php if ($penny_video['size'] === '9x16'): ?>
    video-play-pause hidden <md:!block w-full h-auto
    <?php endif; ?>
    <?php if ($penny_video['size'] === '4x5'): ?>
    video-play-pause hidden md:!block lg:!hidden w-full h-auto
    <?php endif; ?>
    <?php if ($penny_video['size'] === '16x9'): ?>
    video-play-pause hidden lg:!block w-full h-auto
    <?php endif; ?>
    " 
    autoplay
    muted
    loop
    playsinline 
    poster="<?php echo $image_url; ?>" 
    data-loaded="true"
  >
    <source src="<?php echo $video_url; ?>" type="video/mp4">
  </video>
  <?php endforeach; ?>

</div>
<!-- block: video -->

<?php endif; ?>

<!-- block -->
<div class="bg-wine-red-regular">

  <!-- container -->
  <div class="2xl:container mx-auto flex flex-wrap justify-center py-20 px-10 <sm:px-5 border-0 border-red-500">

    <!-- w-5/12 -->
    <div class="w-8/12 <lg:w-12/12 space-y-10 items-starts border-0 border-green-500">
      
      <div 
        class="text-4xl <md:text-3xl space-y-10 text-center font-serif tracking-wide text-milk-light"
        data-aos="fade-up" 
        data-aos-duration="1000"
      >
        <?php the_content(); ?>
      </div>

    </div>
    <!-- w-5/12 -->

  </div>
  <!-- container -->
  
</div>
<!-- block -->


<?php $about1 = carbon_get_the_post_meta('about')[0] ?? []; ?>
<?php if (is_countable($about1) && count($about1) > 0): ?>

<!-- block -->
<div class="bg-earth-dark">

  <!-- container -->
  <div class="flex-wrap flex justify-center items-center border-0 border-red-500 overflow-hidden">

    <!-- w-6/12 -->
    <div class="w-6/12 <xl:w-full border-0 border-red-500">

      <!-- min-h-screen-sm -->
      <div class=" min-h-screen-sm flex items-center justify-center overflow-hidden border-0 border-red-500">
        
        <!-- flex -->
        <div 
          class="w-10/12 <xl:w-6/12 <lg:w-10/12 <md:w-full flex flex-col items-center justify-center space-y-5 text-milk-light <md:px-5 <md:py-20 border-0 border-red-500"
          data-aos="fade-up" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >
          <?php $asset1 = $about1['assets'][0] ?? []; ?>
          <?php if (is_countable($asset1) && count($asset1) > 0): ?>
          <?php 
          // $image_url = get_image_url($image['id']); 
          $image_url = wp_get_attachment_image_src($asset1['id'], '1536x1536')[0];
          $image_placeholder_url = get_image_url($asset1['id'], 'placeholder');
          $image_alt = $asset1['alt'];
          // print_r($image_url);
          ?>

          <img 
            class="
            max-w-60 

            transition-all 
            duration-1000
            blur-3xl
            filter
            scale-125

            lazy

            border-0 
            border-green-500
          "
          src="<?php echo $image_placeholder_url; ?>"
          data-src="<?php echo $image_url; ?>"
          alt="<?php echo $image_alt; ?>"
          >

          <?php endif; ?>

          <h2 class="text-5xl font-serif font-medium tracking-wide text-center border-0 border-red-500">
            <?php echo $about1['title']; ?>
          </h2>

          <div class="text-xl text-center text-milk-regula w-9/12 border-0 border-red-500">
            <?php echo wpautop($about1['body']); ?>
          </div>

          <?php $buttons = $about1['buttons']; ?>
          <?php if (is_countable($buttons) && count($buttons) > 0): ?>

          <?php foreach($buttons as $key => $button): ?>
          <?php
          $button_post = null;
          $associate = $button['associate'];
          if ($associate && $associate[0]) {
            $button_post = get_post($associate[0]['id']);
          }
          $button_url = get_permalink($button_post->ID ?? false);
          ?>

          <a class="btn" href="<?php echo $button_url; ?>">
            <button><?php echo $button['label']; ?></button>
          </a>

          <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <!-- flex -->

      </div>
      <!-- min-h-screen-sm -->

    </div>
    <!-- w-6/12 -->

    <!-- w-6/12 -->
    <div 
      class="w-6/12 <xl:w-full border-0 border-red-500"
    >

      <!-- min-h-screen-sm -->
      <div class="min-h-screen-sm overflow-hidden border-0 border-red-500"
        data-aos="fade-left" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >

        <?php $asset2 = $about1['assets'][1] ?? []; ?>
        <?php if (is_countable($asset2) && count($asset2) > 0): ?>
        <?php 
        // $image_url = get_image_url($image['id']); 
        $image_url = wp_get_attachment_image_src($asset2['id'], '1536x1536')[0];
        $image_placeholder_url = get_image_url($asset2['id'], 'placeholder');
        $image_alt = $asset1['alt'];
        // print_r($image_url);
        ?>

        <img 
          class="
          object-cover 
          object-center 
          w-full min-h-screen-sm

          transition-all 
          duration-1000
          blur-3xl
          filter
          scale-125

          lazy

          border-0 
          border-green-500
        "
        src="<?php echo $image_placeholder_url; ?>"
        data-src="<?php echo $image_url; ?>"
        alt="<?php echo $image_alt; ?>"
        >

        <?php endif; ?>

      </div>
      <!-- min-h-screen-sm -->

    </div>
    <!-- w-6/12 -->

  </div>
  <!-- container -->

</div>
<!-- block -->

<?php endif; ?>

<!-- block -->
<div id="app-carousel-centered"
  class="bg-milk-regular pt-20 bg-cover bg-center bg-no-repeat"
  style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-white-2.jpg');"
>

  <carousel-centered 
    class="h-auto w-full border-0 border-blue-500"
    v-slot="{ activeSlide }"
  >

    <?php $carousel1 = carbon_get_the_post_meta('carousels')[0] ?? []; ?>
    <?php if (is_countable($carousel1) && count($carousel1) > 0): ?>

    <!-- group -->
    <div 
      class="border-0 border-blue-500 py-15"
      data-aos="fade-up" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >

      <!-- container -->
      <div class="2xl:container mx-auto h-auto px-40 <xl:px-20 <md:px-5 flex-wrap flex flex-col items-center justify-center space-y-10 border-0 border-green-500">

        <!-- heading -->
        <div 
          class="w-10/12 <sm:w-12/12 text-center flex flex-col items-center justify-center space-y-1 border-0 border-green-500"
          data-aos="fade-up" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >

          <h2 class="break-words font-serif font-medium tracking-wide text-5xl <md:text-4xl text-wine-red-regular" >
             <?php echo $carousel1['title']; ?>
          </h2>

          <div class="text-earth-dark text-xl <md:text-lg w-8/12 <md:w-10/12 <sm:w-12/12">
            <?php echo wpautop($carousel1['body']); ?>
          </div>

        </div>
        <!-- heading -->

        <?php $associates = $carousel1['associates']; ?>
        <?php if (is_countable($associates) && count($associates) > 0): ?>

        <!-- body -->
        <div 
          class="w-10/12 <2xl:w-12/12 relative border-0 border-red-500"
          data-aos="fade-in" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >
        
          <div class="swiper-button-next !text-gray-900 !hover:text-gray-400 transition-colors duration-500"></div>
          <div class="swiper-button-prev !text-gray-900 !hover:text-gray-400 transition-colors duration-500"></div>

          <!-- swiper -->
          <div class="swiper centered border-0 border-green-500" style="mask-image: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 10%, rgba(0,0,0,1) 50%, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 90%, rgba(0,0,0,0) 100%);  -webkit-mask-image: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 10%, rgba(0,0,0,1) 50%, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 90%, rgba(0,0,0,0) 100%);">

            <!-- swiper-wrapper -->
            <div class="swiper-wrapper border-0 border-orange-500 w-full">

              <?php foreach($associates as $key => $associate): ?>

              <?php
              $associate_post = get_post($associate['id']);
              $associate_url = get_permalink($associate_post->ID ?? false);

              // Get product info (wc).
              $product = wc_get_product($associate_post->ID);
              $product_description = $product->get_short_description();

              $wine_group = carbon_get_post_meta($associate_post->ID, 'group');
              ?>

              <div class="swiper-slide overflow-hidden border-0 border-green-500">

                <?php
                $image_url = null;
                $image_placeholder_url = null;
                $image_alt = null;
                $post_cover_id = carbon_get_post_meta($associate['id'], 'cover_id');
                if ($post_cover_id):
                  $image_url = wp_get_attachment_image_src($post_cover_id, '1536x1536')[0];
                  $image_placeholder_url = get_image_url($post_cover_id, 'placeholder');
                  $image_alt = carbon_get_the_post_meta('cover_alt');
                ?>
                <img 
                  src="/wp-content/themes/rarepenny-v1/dist/static/RARE_PENNY_1-placeholder.png" 
                  class="
                    object-contain 
                    <?php if ($key === 0): ?>
                    scale-100 
                    <?php else: ?>
                    scale-90 
                    <?php endif; ?>
                    w-full 
                    h-200 
                    <sm:h-100

                    transition-all 
                    duration-500 
                    ease-in-out 
                    transform 

                    blur-md
                    filter

                    lazy

                    border-0 border-orange-500
                  "
                  src="<?php echo $image_placeholder_url; ?>"
                  data-src="<?php echo $image_url; ?>"
                  alt="<?php echo $image_alt; ?>"

                  data-title="<?php echo $associate_post->post_title; ?>"
                  data-group="<?php echo $wine_group; ?>"
                  data-body="<?php echo wpautop($product_description); ?>"
                 />
                 <?php endif; ?>

              </div>

              <?php endforeach; ?>

            </div>
            <!-- swiper-wrapper -->

          </div>
          <!-- swiper -->

        </div>
        <!-- body -->

        <?php endif; ?>

      </div>
      <!-- container -->

    </div>
    <!-- group -->

    <!-- group -->
    <div class="border-0 border-blue-500 bg-wine-red-regular py-10">

      <div class="2xl:container mx-auto flex flex-wrap justify-center px-40 <2xl:px-15 <xl:px-0 <lg:px-0 <sm:px-2 border-0 border-red-500">

        <div class="w-full flex flex-wrap justify-center items-center <md:portrait:space-y-10 <sm:space-y-0 border-0 border-red-500">

          <div class="w-5/12 px-10 <2xl:px-5 <md:portrait:w-12/12 <sm:w-12/12 space-y-10 text-center flex flex-col items-center border-0 border-red-500">

            <div 
              class="space-y-2 w-full border-0 border-blue-500 text-milk-light"
              data-aos="fade-in" 
              data-aos-duration="1000"
            >
              <h2 class="break-words text-4xl <md:text-5xl font-serif font-medium tracking-wider border-0 border-blue-500">
                {{ activeSlide.title }}
              </h2>

              <div 
                class="text-xl font-san" 
                v-html="activeSlide.body"
              >
              </div>
            </div>

            <div 
              class="flex-inline dark"
              data-aos="fade-in" 
              data-aos-duration="1000"
              data-aos-delay="500"
            >
              
              <?php $buttons = $carousel1['buttons']; ?>
              <?php if (is_countable($buttons) && count($buttons) > 0): ?>

              <?php foreach($buttons as $key => $button): ?>
              <?php
              $button_post = null;
              $associate = $button['associate'];
              if ($associate && $associate[0]) {
                $button_post = get_post($associate[0]['id']);
              }
              $button_url = get_permalink($button_post->ID ?? false);
              ?>

              <a class="btn" href="<?php echo $button_url; ?>">
                <button><?php echo $button['label']; ?></button>
              </a>

              <?php endforeach; ?>
              <?php endif; ?>

            </div>
          </div>

        </div>

      </div>

    </div>
    <!-- group -->

    <?php endif; ?>

    <?php $groups = carbon_get_the_post_meta('groups') ?? []; ?>
    <?php if (is_countable($groups) && count($groups) > 0): ?>
    <?php foreach($groups as $key => $group): ?>

    <!-- group -->
    <div
      class="bg-milk-regular py-20 bg-cover bg-center px-10 <md:px-5"
      style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-white-2.jpg');"
      v-show="activeSlide.group == '<?php echo $group['group']; ?>'"
    >

      <!-- container -->
      <div class="2xl:container mx-auto flex-wrap flex justify-start items-center space-y-10 border-0 border-red-500 overflow-hidden">

        <div 
          class="w-full"
          data-aos="fade-up" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >
          <h2 class="text-5xl font-serif font-medium tracking-wide text-wine-red-regular border-0 border-red-500">
            <?php echo $group['title']; ?>
          </h2>
        </div>

        <!-- w-6/12 -->
        <div 
          class="w-6/12 <xl:w-full border-0 border-red-500 space-y-5"
          data-aos="fade-right" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >

          
          <div class="p-10 <md:px-0 <md:py-5 flex items-center justify-between overflow-hidden rounded-lg bg-[#f0ecea] border-0 border-red-500">

            <?php $associates = $group['associates']; ?>
            <?php if (is_countable($associates) && count($associates) > 0): ?>
            <?php foreach($associates as $key => $associate): ?>
            <?php
            $image_url = null;
            $image_placeholder_url = null;
            $image_alt = null;
            $post_cover_id = carbon_get_post_meta($associate['id'], 'cover_id');
            if ($post_cover_id):
              $image_url = wp_get_attachment_image_src($post_cover_id, '1536x1536')[0];
              $image_placeholder_url = get_image_url($post_cover_id, 'placeholder');
              $image_alt = carbon_get_the_post_meta('cover_alt');
            ?>
            <img 
              class="
                object-contain 
                scale-90 
                w-full 
                h-110 
                <md:h-80

                transition-all 
                duration-500 
                ease-in-out 
                transform

                blur-md
                filter

                lazy
              " 
              src="<?php echo $image_placeholder_url; ?>"
              data-src="<?php echo $image_url; ?>"
              alt="<?php echo $image_alt; ?>"
            />
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>

          </div>

        </div>
        <!-- w-6/12 -->

        <!-- w-6/12 -->
        <div 
          class="w-6/12 <xl:w-full space-y-5 px-20 <md:px-5 <md:py-20 border-0 border-red-500"
          data-aos="fade-left" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >

          <div class="text-4xl font-serif tracking-wide border-0 border-red-500">
            <?php echo wpautop($group['body']); ?>
          </div>

          <?php $buttons = $group['buttons']; ?>
          <?php if (is_countable($buttons) && count($buttons) > 0): ?>

          <?php foreach($buttons as $key => $button): ?>
          <?php
          $button_post = null;
          $associate = $button['associate'];
          if ($associate && $associate[0]) {
            $button_post = get_post($associate[0]['id']);
          }
          $button_url = get_permalink($button_post->ID ?? false);
          ?>

          <a class="btn" href="<?php echo $button_url; ?>">
            <button><?php echo $button['label']; ?></button>
          </a>

          <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <!-- w-6/12 -->

      </div>
      <!-- container -->

    </div>
    <!-- group -->

    <?php endforeach; ?>
    <?php endif; ?>

  </carousel-centered>

</div>
<!-- block -->

<?php $parallax1 = carbon_get_the_post_meta('assets')[0] ?? []; ?>
<?php if (is_countable($parallax1) && count($parallax1) > 0): ?>

<?php 
// $image_url = get_image_url($image['id']); 
$image_url = wp_get_attachment_image_src($parallax1['id'], '1536x1536')[0];
$image_placeholder_url = get_image_url($parallax1['id'], 'placeholder');
$image_alt = $asset1['alt'];
// print_r($image_url);
?>

<!-- block -->
<div 
  class="relative overflow-hidden w-full h-fit <md:h-auto border-0 border-green-500"
  data-aos="fade-in" 
  data-aos-duration="1000"
  data-aos-delay="500"
>

  <div class="<md:hidden parallax w-full h-fit border-blue-500 border-0 portrait:hidden" data-parallax-speed="4">
    <img 
      class="
        w-full 
        h-full
        bg-black 
        object-center
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

  <div class="<md:hidden parallax w-full h-fit border-blue-500 border-0 landscape:hidden" data-parallax-speed="1">
    <img 
      class="
        w-full 
        h-full
        bg-black 
        object-center
        object-cover

        transition-all 
        duration-1000
        blur-3xl
        filter
        scale-130

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


<?php $value1 = carbon_get_the_post_meta('value')[0] ?? []; ?>
<?php if (is_countable($value1) && count($value1) > 0): ?>

<!-- block -->
<div 
  class="bg-wine-red-regular py-20 bg-cover bg-center px-10 <md:px-5"
  style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-white-1.jpg');"
>

  <!-- container -->
  <div class="2xl:container mx-auto flex-wrap flex justify-center items-center <xl:space-y-10 border-0 border-red-500">

    <!-- w-7/12 -->
    <div class="w-7/12 <xl:w-full border-0 border-red-500">

      <!-- flex -->
      <div class="flex items-center justify-center border-0 border-red-500">
        
        <!-- flex -->
        <div 
          class="w-full flex flex-col items-start justify-start <xl:items-center <xl:justify-center <xl:text-center space-y-5 text-wine-red-regular"
          data-aos="fade-right" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >

          <h2 class="text-5xl font-serif font-medium tracking-wide border-0 border-red-500">
            <?php echo $value1['title']; ?>
          </h2>

          <div class="text-xl text-earth-dark w-9/12 border-0 border-red-500">
            <?php echo wpautop($value1['body']); ?>
          </div>

          <?php $buttons = $value1['buttons']; ?>
          <?php if (is_countable($buttons) && count($buttons) > 0): ?>

          <?php foreach($buttons as $key => $button): ?>
          <?php
          $button_post = null;
          $associate = $button['associate'];
          if ($associate && $associate[0]) {
            $button_post = get_post($associate[0]['id']);
          }
          $button_url = get_permalink($button_post->ID ?? false);
          ?>

          <a class="btn" href="<?php echo $button_url; ?>">
            <button><?php echo $button['label']; ?></button>
          </a>

          <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <!-- flex -->

      </div>
      <!-- flex -->

    </div>
    <!-- w-7/12 -->

    <!-- w-5/12 -->
    <div 
      class="w-5/12 <xl:w-full border-0 border-red-500"
    >

      <!-- flex -->
      <div 
        class="flex justify-center border-0 border-red-500"
        data-aos="fade-left" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >
        <?php $asset1 = $value1['assets'][0] ?? []; ?>
        <?php if (is_countable($asset1) && count($asset1) > 0): ?>
        <?php 
        // $image_url = get_image_url($image['id']); 
        $image_url = wp_get_attachment_image_src($asset1['id'], '1536x1536')[0];
        $image_placeholder_url = get_image_url($asset1['id'], 'placeholder');
        $image_alt = $asset1['alt'];
        // print_r($image_url);
        ?>

        <img 
          class="
            object-contain 
            object-center 
            max-w-100 
            <md:max-w-60

            transition-all 
            duration-1000
            blur-3xl
            filter
            scale-125

            lazy

            border-0 
            border-green-500
          "
          src="<?php echo $image_placeholder_url; ?>"
          data-src="<?php echo $image_url; ?>"
          alt="<?php echo $image_alt; ?>"
        >

        <?php endif; ?>

      </div>
      <!-- flex -->

    </div>
    <!-- w-5/12 -->

  </div>
  <!-- container -->

</div>
<!-- block -->

<?php endif; ?>

<?php get_template_part('template-parts/contents/newsletter'); ?>
