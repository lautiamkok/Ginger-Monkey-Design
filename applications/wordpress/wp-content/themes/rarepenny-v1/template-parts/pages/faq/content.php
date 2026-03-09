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
        <?php the_content(); ?>
      </div>
    </div>
  </div>

</div>
<!-- block -->

<?php $faqs = carbon_get_the_post_meta('faqs') ?? []; ?>
<?php if (is_countable($faqs) && count($faqs) > 0): ?>

<!-- block -->
<div class="py-30 px-10 <md:px-5 bg-white" id="app-display-toggler">
   
  <!-- container -->
  <div class="2xl:container mx-auto flex flex-col flex-wrap items-center justify-center space-y-15 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    <!-- w-5/12 -->
    <div class="w-8/12 <lg:w-12/12 space-y-10 items-starts border-0 border-green-500">
      
      <!-- flex -->
      <div 
        class="w-full flex flex-col items-start space-y-8 border-0 border-blue-500"
        data-aos="fade-right" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >

        <?php foreach($faqs as $key => $faq): ?>

        <!-- item -->
        <div class="w-12/12 space-y-5 border-b-1 border-b-red-regular pb-7">

          <display-toggler v-slot="{ display, toggle }" >
          
            <div class="flex flex-wrap justify-between w-full border-0 border-red-500">
              <h2 class="text-3xl <md:text-2xl w-11/12 <md:w-10/12 font-bold">
                <?php echo $faq['title']; ?>
              </h2>
              <nav class="p-1 border-0 border-red-500">
                <a 
                  href="#" 
                  class="flex items-center justify-center transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-red-500"
                  v-on:click.prevent="toggle"
                  :class="{ '!hidden': display == true }"
                >
                  <i class="icon-plus text-2xl text-blue-regular"></i>
                </a>

                <a 
                  href="#" 
                  class=" transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-red-500 hidden"
                  v-on:click.prevent="toggle"
                  :class="{ '!block': display == true }"
                >
                  <i class="icon-minus text-2xl text-blue-regular"></i>
                </a>
              </nav>
            </div>

            <div 
              class="w-10/12 <md:w-12/12 text-xl space-y-5 hidden"
              :class="{ '!block': display == true }"
            >
              <?php echo wpautop($faq['body']); ?>
            </div>

          </display-toggler>

        </div>
        <!-- item -->

        <?php endforeach; ?>

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
