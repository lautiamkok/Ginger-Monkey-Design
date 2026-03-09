<?php
/**
 * The template used for displaying appendixes
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
?>

<?php $appendix1 = carbon_get_theme_option('appendixes')[0] ?? []; ?>
<?php if (is_countable($appendix1) && count($appendix1) > 0): ?>
<!-- block -->
<div class="bg-blue-light">

  <!-- frame bottom -->
  <div 
    class="bg-top bg-repeat-x bg-contain <2xl:bg-auto h-[16px] border-0 border-red-500"
    style="background-image: url('/wp-content/themes/Rare Penny-v1/dist/static/rectangle-blue-regular-bottom.png');"
  ></div>
  <!-- frame bottom -->

  <div class="2xl:container mx-auto flex flex-wrap items-center justify-center py-10 space-x-10 <xl:px-10 <lg:px-5 <lg:flex-col <lg:space-x-0 <lg:space-y-5 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    <div class="flex flex-col items-center text-3xl <md:text-2xl font-title <lg:text-center font-bold border-0 border-red-500">
      <?php echo wpautop($appendix1['body']); ?>
    </div>

    <?php $buttons = $appendix1['buttons']; ?>
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
<!-- block -->

<?php endif; ?>
