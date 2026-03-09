<?php $page_not_found = carbon_get_theme_option('page_not_found')[0] ?? []; ?>
<?php if (is_countable($page_not_found) && count($page_not_found) > 0): ?>

<!-- block -->
<div class="bg-earth-dark">

  <div class="text-center py-10 border-0 border-red-500" >
    <div
      class="2xl:container mx-auto flex flex-col justify-center items-center"
      data-aos="fade-up" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >
      <h1 class="w-10/12 <md:w-full text-white text-8xl <lg:text-6xl font-serif pt-5 <lg:pt-2 border-0 border-blue-500">
        <?php echo $page_not_found['h1']; ?>
      </h1>
      <div class="text-white text-xl <md:text-lg text-center w-7/12 <lg:w-10/12 border-0 border-red-500">
        <?php echo wpautop($page_not_found['introduction']); ?>
      </div>
    </div>
  </div>

</div>
<!-- block -->

<!-- block -->
<div class="py-30 px-10 <md:px-5 bg-white">
   
  <!-- container -->
  <div class="2xl:container mx-auto flex flex-col flex-wrap items-center justify-center space-y-5 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    <div class="text-xl <md:text-lg w-6/12 <lg:w-10/12 <md:w-full text-center border-0 border-red-500">
      <?php echo wpautop($page_not_found['body']); ?>
    </div>

    <?php $buttons = $page_not_found['buttons']; ?>
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

<?php get_template_part('template-parts/contents/newsletter'); ?>

