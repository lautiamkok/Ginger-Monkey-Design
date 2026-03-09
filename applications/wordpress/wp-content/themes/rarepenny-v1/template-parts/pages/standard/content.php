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
        <?php the_title(); ?>
      </h1>
      <div class="text-white text-xl <md:text-lg text-center w-7/12 <lg:w-10/12 border-0 border-red-500">
        <?php echo wpautop(carbon_get_the_post_meta('introduction')); ?>
      </div>
    </div>
  </div>

</div>
<!-- block -->

<!-- block -->
<div class="py-30 px-10 <md:px-5 bg-white">
   
  <!-- container -->
  <div class="2xl:container mx-auto flex flex-col flex-wrap items-center justify-center space-y-15 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    <!-- w-5/12 -->
    <div class="w-8/12 <lg:w-12/12 space-y-10 items-starts border-0 border-green-500">
      
      <div 
        class="text-xl <md:text-lg has-paragraphs has-links has-lists has-h2s has-h3s"
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

<?php get_template_part('template-parts/contents/newsletter'); ?>
