<?php
/**
 * The template used for displaying stockists block
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
?>

<?php $stockists = carbon_get_the_post_meta('stockists') ?? []; ?>
<?php if (is_countable($stockists) && count($stockists) > 0): ?>

<?php $asset1 = $stockists[0]['assets'][0] ?? []; ?>
<?php if (is_countable($asset1) && count($asset1) > 0): ?>
<?php 
// $image_url = get_image_url($image['id']); 
$image_url = wp_get_attachment_image_src($asset1['id'], '1536x1536')[0];
$image_placeholder_url = get_image_url($asset1['id'], 'placeholder');
$image_alt = $asset1['alt'];
// print_r($image_url);
?>

<!-- block -->
<div 
  class="relative overflow-hidden w-full h-auto border-0 border-green-500"
  data-aos="fade-up" 
  data-aos-duration="1000"
  data-aos-delay="500"
>

  <div class="xparallax w-full h-auto border-blue-500 border-0" data-parallax-speed="4">
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

        lazy
      "
      src="<?php echo $image_placeholder_url; ?>"
      data-src="<?php echo $image_url; ?>"
      alt="<?php echo $image_alt; ?>"
    />
  </div>

  <!-- frame top-->
  <div 
    class="absolute bottom-0 left-0 right-0 bg-bottom bg-cover bg-repeat-x bg-contain <2xl:bg-auto h-[16px] border-b-1 border-blue-dark z-9"
    style="background-image: url('/wp-content/themes/Rare Penny-v1/dist/static/rectangle-blue-dark-top.png');"
  ></div>
  <!-- frame top-->

</div>
<!-- block -->

<?php endif; ?>

<!-- block -->
<div class="bg-blue-light">

  <!--group -->
  <div class="bg-blue-dark text-center py-20 space-y-8">

    <!--group -->
    <div>

      <div 
        class="space-y-2"
        data-aos="fade-up" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >
        <span class="font-subtitle text-3xl text-white">
          <?php echo $stockists[0]['title']; ?>
        </span>
        <h2 class="text-white text-10xl <lg:text-8xl uppercase font-subtitle">
          <?php echo $stockists[0]['subtitle']; ?>
        </h2>
      </div>

      <div class="2xl:container mx-auto flex flex-wrap items-center justify-center border-0 border-red-500 overflow-hidden"
        data-aos="fade-right" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >
        <div class="text-2xl <md:text-lg w-4/12 <lg:w-11/12 text-white border-0 border-red-500">
          <?php echo wpautop($stockists[0]['body']); ?>
        </div>

      </div>

    </div>
    <!--group -->

    <div
      data-aos="fade-up" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >
      <?php $buttons = $stockists[0]['buttons']; ?>
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
  <!--group -->

  <!-- frame bottom-->
  <div 
    class="bg-top bg-cover bg-repeat-x bg-contain <2xl:bg-auto h-[16px] border-0 border-green-500"
    style="background-image: url('/wp-content/themes/Rare Penny-v1/dist/static/rectangle-blue-dark-bottom.png');"
  ></div>
  <!-- frame bottom-->

  <?php $stockist2 = $stockists[1] ?? false; ?>

  <?php if ($stockist2): ?>

  <!--group -->
  <div class="bg-blue-light px-10 <md:px-5">

    <div 
      class="2xl:container mx-auto flex flex-wrap flex-col items-center justify-center py-10 space-y-5 border-0 border-red-500 overflow-hidden"
        data-aos="fade-right" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >
      <div class="flex flex-col items-center text-3xl <md:text-2xl font-title <lg:text-center font-bold border-0 border-red-500">
        <?php echo wpautop($stockists[1]['body']); ?>
      </div>
      
      <?php $buttons = $stockists[1]['buttons']; ?>
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
  <!--group -->

  <!-- frame bottom -->
  <div 
    class="bg-bottom bg-cover bg-blue-light bg-repeat-x bg-contain <2xl:bg-auto h-[16px] border-0 border-red-500"
    style="background-image: url('/wp-content/themes/Rare Penny-v1/dist/static/rectangle-blue-light-bottom.png');"
  ></div>
  <!-- frame bottom -->

  <?php endif; ?>

</div>
<!-- block -->

<?php endif; ?>
