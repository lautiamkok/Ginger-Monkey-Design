<!-- block -->
<div class="relative w-full bg-white border-0 border-green-500">

  <!-- container -->
  <div class="2xl:container mx-auto py-20 border-0 border-red-500">

    <!-- flex -->
    <div 
      class="w-full flex flex-col items-center justify-center space-y-20 border-0 border-blue-500"
      data-aos="fade-up" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >

      <div class="text-6xl <md:text-5xl <md:px-5 font-title text-center font-extrabold uppercase border-0 border-green-500">
        <h1><?php the_title(); ?></h1>
      </div>

      <div class="text-2xl <md:text-xl w-10/12 <xl:w-full <xl:px-5 border-0 border-red-500">
        <?php the_content(); ?>
      </div>

    </div>
    <!-- flex -->

  </div>
  <!-- container -->
  
</div>
<!-- block -->

<?php get_template_part('template-parts/contents/newsletter'); ?>
<?php get_template_part('template-parts/contents/appendixes'); ?>

