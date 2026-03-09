<?php
/**
 * The template used for displaying page footer
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
?>

<?php
$address1 = carbon_get_theme_option('addresses')[0];
$email1 = carbon_get_theme_option('emails')[0];
$warning1 = carbon_get_theme_option('warnings')[0];
$social_profile1 = carbon_get_theme_option('social_profiles')[0];
$copyright = carbon_get_theme_option('copyright');
$mobile_menu_items = get_menu('menu-header');
$menu_footer_items = get_menu('menu-footer'); 
$menu_footnote_items = get_menu('menu-footnote'); 
?>

<footer id="footer">

  <!-- block -->
  <div class="py-20 px-10 <md:px-5 pt-30 space-y-10 bg-wine-red-regular bg-[size:120%_auto] <xl:bg-[size:200%_auto] <lg:bg-[size:300%_auto] <md:bg-[size:400%_auto] bg-repeat border-0 border-red-500"
    style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/stamp-pattern.png'); background-position: -100px 20px; xbackground-blend-mode: color;"
  >

    <!-- container -->
    <div class="2xl:container mx-auto flex flex-wrap items-start items-stretch justify-between <md:space-y-10 border-0 border-red-500">

      <!-- w-6/12 -->
      <div class="w-6/12 <md:w-full space-y-20 border-0 border-red-500"
        data-aos="fade-up" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >
        <div class="space-y-10">
          <div class="border-0 border-green-500">
            <img src="/wp-content/themes/rarepenny-v1/dist/static/logo-rare-penny-footer.svg" class="w-80" />
          </div>

          <?php if (is_countable($address1) && count($address1) > 0): ?> 
          <div class="space-y-8">
            <div class="text-xl <md:text-lg text-white">
              <?php echo wpautop($address1['body']); ?>
            </div>
          </div>
          <?php endif; ?>

          <div class="flex flex-col items-start space-y-5 border-0 border-red-500">
            <ul class="flex flex-wrap items-center justify-center space-x-3 border-0 border-blue-500">
              
              <li>
                <a href="" class="rounded-full  w-[60px] <md:w-[50px] h-[60px] <md:h-[50px] flex items-center justify-center bg-milk-light transition-all ease-in-out duration-300 opacity-100 hover:opacity-60">
                  <i class="icon-social-facebook text-4xl <md:text-2xl text-center text-wine-red-regular"></i>
                </a>
              </li>

              <li>
                <a href="" class="rounded-full  w-[60px] <md:w-[50px] h-[60px] <md:h-[50px] flex items-center justify-center bg-milk-light transition-all ease-in-out duration-300 opacity-100 hover:opacity-60">
                  <i class="icon-social-instagram text-4xl <md:text-2xl text-center text-wine-red-regular"></i>
                </a>
              </li>
            </ul>
          </div>

        </div>

        <?php if (is_countable($menu_footnote_items) && count($menu_footnote_items) > 0): ?>
        <ul class="flex flex-wrap flex-col text-xl <lg:text-xl <md:text-lg text-white">

          <?php foreach($menu_footnote_items as $key => $menu_footnote_item): ?>
          <li>
            <a href="<?php echo $menu_footnote_item['url']; ?>" class="transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 underline decoration-gray-400">
              <?php echo $menu_footnote_item['title']; ?>
            </a>
          </li>
          <?php endforeach; ?>

        </ul>
        <?php endif; ?>

      </div>
      <!-- w-6/12 -->

      <!-- w-6/12 -->
      <div 
        class="w-6/12 <md:w-full border-0 border-red-500"
        data-aos="fade-up" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >

        <div class="flex flex-col items-start h-full <xl:space-y-10 border-0 border-red-500">

          <div class="w-full flex-1 border-0 border-red-500">

            <?php if (is_countable($menu_footer_items) && count($menu_footer_items) > 0): ?>
            <ul class="flex flex-col items-end space-y-0 border-0 border-red-500">

              <?php foreach($menu_footer_items as $key => $menu_footer_item): ?>
              <li>

                <?php if ($menu_footer_item['current']): ?>
                <a href="<?php echo $menu_footer_item['url']; ?>" class="text-salmon-pink text-2xl uppercase inline-block border-0 border-red-500">
                  <?php echo $menu_footer_item['title']; ?>
                </a>
                <?php else: ?>
                <a href="<?php echo $menu_footer_item['url']; ?>" class="text-white text-2xl uppercase inline-block transition-all hover:opacity-50 border-0 border-red-500">
                  <?php echo $menu_footer_item['title']; ?>
                </a>
                <?php endif; ?>

              </li>
              <?php endforeach; ?>

            </ul>
            <?php endif; ?>

          </div>

          <div class="flex flex-col items-end flex-0 space-y-12 border-0 border-green-500">

            <?php if (is_countable($warning1) && count($warning1) > 0): ?>
            <div class="text-xl text-right <md:text-lg text-white w-8/12">
              <p><?php echo $warning1['title']; ?></p>
              <?php echo wpautop($warning1['body']); ?>
            </div>
            <?php endif; ?>

            <?php if ($copyright): ?>
            <div class="text-xl <lg:text-xl <md:text-lg text-right text-white">
              <p>
                <?php echo $copyright; ?>
              </p>
            </div>
            <?php endif; ?>

          </div>

        </div>

      </div>
      <!-- w-6/12 -->

    </div>
    <!-- container -->

  </div>
  <!-- block -->
  
</footer>

<!-- up nav -->
<div 
  class="fixed right-0 bottom-0 z-999 p-5 border-0 border-blue-500 opacity-0 transition-all duration-1000 ease-in-out" 
  id="button-up"
>
  <nav>
    <ul>
      <li>
        <a
          href="#top"
          class="flex items-center justify-center text-xl bg-gray-600 px-4 py-3 rounded-3xl text-white block transition-all duration-1000 ease-in-out hover:opacity-50"
        >
          <i class="icon-chevron-thin-up"></i>
        </a>
      </li>
    </ul>
  </nav>
</div>
<!-- up nav -->

<!-- mobile nav -->
<div 
  class="hidden xl:hidden fixed top-0 bottom-0 left-0 right-0 px-5 py-5 bg-wine-red-regular z-999 overflow-x-auto space-y-5"
  id="mobile-menu"
>

  <div class="flex justify-end w-full border-0 border-blue-500">
    <nav>
      <ul>
        <li>
          <a
            href="#"
            class="text-2xl text-white block transition-all duration-1000 ease-in-out hover:opacity-50"
            id="exit-button"
          >
            <i class="icon-close"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <div class="flex-center-y border-0 border-red-500 px-2">

    <?php if (is_countable($mobile_menu_items) && count($mobile_menu_items) > 0): ?>
    <ul class="flex-col space-y-2 border-0 border-red-500">
      
      <?php foreach($mobile_menu_items as $key => $mobile_menu_item): ?>
      <li>
        <?php if ($mobile_menu_item['current']): ?>
        <a href="<?php echo $mobile_menu_item['url']; ?>" class="text-salmon-pink text-5xl <md:text-2xl font-extrabold uppercase inline-block border-0 border-red-500">
          <?php echo $mobile_menu_item['title']; ?>
        </a>
        <?php else: ?>
        <a href="<?php echo $mobile_menu_item['url']; ?>" class="text-white text-5xl <md:text-2xl font-extrabold uppercase inline-block transition-all hover:opacity-50 border-0 border-red-500">
          <?php echo $mobile_menu_item['title']; ?>
        </a>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>

      <li class="border-0 border-blue-500">
        <a 
          href="#" 
          class="inline-flex items-center justify-center transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-blue-500 open-search"
        >
          <i class="icon-search text-2xl text-white"></i>
        </a>
      </li>
    </ul>
    <?php endif; ?>

  </div>

</div>
<!-- mobile nav -->

<div id="wait" class="hidden fixed top-0 bottom-0 left-0 right-0 z-999">
  <div class="flex items-center justify-center h-12/12 w-12/12 bg-black bg-opacity-50 z-4 text-white text-xl">
    <p>Please wait...</p>
  </div>
</div>

<!-- search -->
<div id="search" class="hidden fixed top-0 bottom-0 left-0 right-0 z-999 bg-white">
  <div class="absolute top-5 right-5">
    <nav class="flex justify-end w-full border-0 border-blue-500">
      <ul>
        <li>
          <a
            href="#"
            class="text-xl text-wine-red-regular p-2 transition-all duration-1000 ease-in-out hover:opacity-50 border-0 border-red-500"
            id="exit-search"
          >
            <i class="icon-close"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <div class="2xl:container mx-auto w-full h-full flex flex-wrap justify-center items-center border-0 border-red-500"
    id="app-search"
  >
    <form-search 
      v-slot="{ v$, form, response, submitForm, resetResponse }"
      v-bind:form-id="'form-search'"
    >
      <form 
        id="form-search"
        class="w-full h-full flex flex-wrap justify-center items-center space-x-4 border-0 border-blue-500"
        action="<?php echo site_url(); ?>" 
        novalidate="true"
        v-on:submit.prevent="submitForm"
      >
        <div class="w-5/12 <xl:w-6/12 <lg:w-8/12 border-0 border-blue-500 relative">
          <input
            class="input-search w-full"
            type="text"
            name="s"
            placeholder="Search"
            v-model="form.search"
            v-on:blur="v$.search.$touch"
          >
          <div v-for="error of v$.search.$errors" :key="error.$uid"  class="absolute top-13 left-0 right-0 border-0 border-blue-500">
            <div class="text-red-500 text-xl leading-4.5">{{ error.$message }}</div>
          </div>
        </div>

        <button class="w-7 h-7 rounded-full inline-flex items-center justify-center transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 bg-wine-red-regular border-0 border-blue-500 mt-2">
          <i class="icon-search text-sm text-white"></i>
        </button>

      </form>
    </form-search>

  </div>
  
</div>
<!-- search -->

<?php if (is_user_logged_in() === false): ?>

<!-- age gate -->
<div 
  class="bg-wine-red-regular hidden fixed top-0 bottom-0 left-0 right-0 bg-cover bg-center bg-no-repeat z-9999" 
  id="app-age-gate"
  data-aos="fade-down" 
  style="background-image: url('/wp-content/themes/rarepenny-v1/dist/static/texture-red.jpg');"
>

  <div class="border-0 h-full w-full border-red-500 block <md:px-5 overflow-y-auto border-0 border-red-500">

    <!-- container -->
    <div class="2xl:container mx-auto w-full h-full flex flex-wrap justify-center items-center border-0 border-red-500 relative">

      <!-- w-10/12 -->
      <div class="w-full flex flex-col items-center justify-center space-y-8 <lg:space-y-5 py-20 border-0 border-red-500">

        <!-- logo -->
        <div class="flex justify-center pb-5 border-0 border-red-500">
          <img src="/wp-content/themes/rarepenny-v1/dist/static/logo-rare-penny-white.svg" class="object-cover object-contain w-150" />
        </div>
        <!-- logo -->

        

        <div class="w-7/12 <xl:w-10/12 <md:w-full flex justify-center items-center flex-col text-center border-0 border-red-500">
          <div class="text-4xl <xl:text-2xl text-milk-light font-serif tracking-wider border-1 border-milk-light px-4 py-2">
            <p>Are you legal drinking age?</p>
          </div>
        </div>

        <div class="w-3/12 <xl:w-10/12 <md:w-full flex justify-center items-center flex-col text-center border-0 border-red-500">
          <div class="text-2xl text-milk-light leading-7">
            <p>You must be of legal drinking age to use the site.</p>
          </div>
        </div>

        <form-age v-slot="{ v$, form, response, submitForm, resetResponse }">

          <form
            class="flex-col flex justify-center items-center w-full border-0 border-blue-500"
            novalidate="true"
            v-on:submit.prevent="submitForm"
          >

            <div class="flex flex-col justify-center w-full border-0 border-red-500">

              <div 
                class="flex items-center justify-center border-0 border-red-500"
                data-aos="fade-in" 
                data-aos-duration="1000"
                data-aos-delay="500"
              >
                <div class="btn age">
                  <button>
                    Yes I am 18, or over >
                  </button>
                </div>
              </div>
            </div>

           </form>

         </form-age>
        
      </div>
      <!-- w-10/12 -->

    </div>
    <!-- container -->

  </div>

</div>
<!-- age gate -->

<?php endif; ?>


<!-- Google tag (gtag.js) -->
<?php $google_analytics1 = carbon_get_theme_option('google_analytics')[0]; ?>
<?php if (is_countable($google_analytics1) && count($google_analytics1) > 0): ?>

<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google_analytics1['measurement_id']; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $google_analytics1['measurement_id']; ?>');
</script>

<?php endif; ?>
<!-- Google tag (gtag.js) -->
