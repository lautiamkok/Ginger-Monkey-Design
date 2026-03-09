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
  class="relative overflow-hidden w-full h-[82vh] portrait:h-fit border-0 border-green-500"
  data-aos="fade-in" 
  data-aos-duration="1000"
  data-aos-delay="500"
>

  <div class="<md:hidden parallax w-full h-[90vh] border-blue-500 border-0 portrait:hidden" data-parallax-speed="4">
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

<?php $stories1 = carbon_get_the_post_meta('our_stories')[0] ?? []; ?>
<?php if (is_countable($stories1) && count($stories1) > 0): ?>

<!-- block -->
<div
  class="bg-wine-red-regular bg-cover bg-center"
  style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-white-1.jpg');"
>

  <!-- container -->
  <div class="flex-wrap flex justify-center items-stretch border-0 border-red-500 overflow-hidden">

    <!-- w-6/12 -->
    <div 
      class="py-20 w-7/12 <xl:w-full border-0 border-red-500"
    >

      <div class="2xl:container ml-auto flex justify-end">

      <!-- flex -->
      <div 
        class="2xl:w-full px-20 <2xl:px-10 <md:px-5 space-y-5 border-0 border-green-500"
        data-aos="fade-right" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >

        <h2 class="text-5xl text-wine-red-regular font-serif border-0 border-red-500 flex flex-col items-start justify-start <xl:justify-center <xl:items-center <xl:text-center">
          <?php echo to_blocks($stories1['title'], "\n"); ?>
        </h2>

        <div class="text-xl text-earth-dark w-9/12 <xl:w-full <xl:text-center border-0 border-red-500">
          <?php echo wpautop($stories1['body']); ?>
        </div>

      </div>
      <!-- flex -->

    </div>

    </div>
    <!-- w-6/12 -->

    <!-- w-6/12 -->
    <div class="w-5/12 <xl:w-full flex items-center justify-center <xl:py-20 border-0 border-red-500 bg-earth-dark">

      <?php $asset1 = $stories1['assets'][0]; ?>
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

    </div>
    <!-- w-6/12 -->

  </div>
  <!-- container -->

</div>
<!-- block -->

<?php endif; ?>

<!-- block -->
<div class="bg-wine-red-regular">

  <!-- container -->
  <div class="2xl:container mx-auto flex flex-wrap justify-center py-20 px-10 <sm:px-5 border-0 border-red-500">

    <!-- w-5/12 -->
    <div class="w-6/12 <lg:w-12/12 space-y-10 items-starts border-0 border-green-500">
      
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

<?php $our_values1 = carbon_get_the_post_meta('our_values')[0] ?? []; ?>
<?php if (is_countable($our_values1) && count($our_values1) > 0): ?>

<!-- block -->
<div 
  class="bg-wine-red-regular py-20 space-y-10 bg-cover bg-center px-10 <md:px-5"
  style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-white-1.jpg');"
>
  <!-- container -->
  <div 
    class="2xl:container mx-auto flex-wrap flex justify-start items-start border-0 border-red-500"
    data-aos="fade-up" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >

    <h2 class="text-5xl font-serif font-medium tracking-wide text-wine-red-regular border-0 border-red-500">
      <?php echo to_blocks($our_values1['title'], "\n"); ?>
    </h2>

  </div>
  <!-- container -->

  <?php $values = $our_values1['values'] ?? []; ?>
  <?php if (is_countable($values) && count($values) > 0): ?>

  <!-- container -->
  <div class="2xl:container px-60 <2xl:px-40 <xl:px-20 <lg:px-0 mx-auto flex-wrap flex justify-center items-stretch border-0 border-red-500">

    <?php foreach($values as $key => $value): ?>

    <!-- w-6/12 -->
    <div class="w-6/12 <md:w-full px-5 <md:px-0 border-0 border-red-500 my-4">

      <!-- flex -->
      <div 
        class="w-full h-full flex flex-col items-center justify-center space-y-2 bg-milk-light rounded-2xl p-10 border-0 border-blue-500"
        data-aos="fade-right" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >

        <h2 class="w-full text-5xl font-serif font-medium tracking-wide text-center text-wine-red-regular border-0 border-red-500">
          <?php echo $value['title']; ?>
        </h2>

        <div class="text-xl text-earth-dark w-9/12 text-center border-0 border-red-500">
          <?php echo wpautop($value['body']); ?>
        </div>

      </div>
      <!-- flex -->
    </div>
    <!-- w-6/12 -->

    <?php endforeach; ?>

  </div>
  <!-- container -->

  <?php endif; ?>

  <!-- container -->
  <div 
    class="2xl:container mx-auto flex-col flex justify-center items-center space-y-5 border-0 border-red-500"
    data-aos="fade-up" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >

    <div class="w-8/12 <xl:w-full text-5xl font-serif font-medium tracking-wide text-wine-red-regular text-center border-0 border-red-500">
      <?php echo wpautop($our_values1['body']); ?>
    </div>

    <?php $buttons = $our_values1['buttons']; ?>
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
  <!-- container -->

</div>
<!-- block -->

<?php endif; ?>

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
  class="relative overflow-hidden w-full h-fit border-0 border-green-500"
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

<?php get_template_part('template-parts/contents/newsletter'); ?>
