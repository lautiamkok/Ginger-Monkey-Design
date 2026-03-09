<?php
$currency_symbol = get_woocommerce_currency_symbol();
$product = wc_get_product($post->ID);
$is_in_stock = $product->is_in_stock();
// var_dump($is_in_stock);

// Get product id (wc).
$product_id = $product->get_id();

// Get product price (wc).
$product_price = $product->get_price();
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
// var_dump($product_price);
// var_dump($regular_price);
// var_dump($sale_price);

// Get product weight (wc).
$product_weight = $product->get_weight();
// Or:
// $product_weight = get_post_meta($product_post->ID, '_weight', true);

// Get product weight unit (wc).
$weight_unit = get_option('woocommerce_weight_unit');
// var_dump($weight_unit);

// Get product abv (custom field).
$product_vol = get_post_meta($post->ID, '_custom_product_vol', true);
$product_abv = get_post_meta($post->ID, '_custom_product_abv', true);
$product_note = get_post_meta($post->ID, '_custom_product_note', true);
$product_highlights = get_post_meta($post->ID, '_custom_product_highlights', true);

if (is_numeric($product_vol) && $product_vol >= 1000) {
  $weight_unit = ' litre';
  $product_vol = $product_vol / 1000;
}
?>

<!-- block -->
<div class="bg-milk-regular py-20 px-10 <md:px-5">

  <!-- container -->
  <div class="2xl:container mx-auto w-full <md:h-auto border-0 border-red-500" >

    <!-- flex -->
    <div class="-mx-10 flex flex-wrap items-start justify-start <lg:space-y-10 border-0 border-blue-500">

      <!-- w-6/12 -->
      <div 
        class="w-6/12 px-10 <lg:w-full border-0 border-red-500"
        data-aos="fade-up" 
        data-aos-duration="1000"
        data-aos-delay="500"
      >

        <div class="w-full flex justify-center py-15 inline-block overflow-hidden relative rounded-3xl bg-white">

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
          <img
            class="
              w-auto
              max-h-[900px]
              <2xl:h-[600em]
              <xl:h-[40em]
              <md:h-[30em]

              border-0 
              border-green-500

              transform 
              hover:scale-110 
              cursor-pointer

              transition-all 
              duration-1000
              blur-3xl
              filter

              lazy

              border-0 
              border-red-500
            "
            src="<?php echo $image_placeholder_url; ?>"
            data-src="<?php echo $image_url; ?>"
            alt="<?php echo $image_alt; ?>"
          />
          <?php endif; ?>

        </div>
      </div>
      <!-- w-6/12 -->

      <!-- w-6/12 -->
      <div class="w-5/12 px-10 <lg:w-full border-0 border-red-500">

        <!-- flex -->
        <div 
          class="flex flex-col space-y-8 <xl:space-y-6 <lg:items-center"
          data-aos="fade-in" 
          data-aos-duration="1000"
          data-aos-delay="500"
        >

          <div class="border-0 border-red-500 space-y-5 <lg:text-center">
            <div>
              <h1 class="font-serif font-medium tracking-wide text-wine-red-regular text-6xl <md:text-4xl">
                <?php the_title(); ?>
              </h1>
              <?php if ($product_note): ?>
              <p class="text-xl <lg:text-center font-bold">
                <?php echo $product_note; ?>
              </p>
              <?php endif; ?>
            </div>
          </div>

          <?php if (get_the_content()): ?>
          <div class="text-2xl <md:text-lg <lg:text-center has-paragraphs border-0 border-red-500">
            <?php echo wpautop(get_the_content()); ?>
          </div>
          <?php endif; ?>

          <?php $tasting_notes = carbon_get_the_post_meta('tasting_notes') ?? []; ?>
          <?php if (is_countable($tasting_notes) && count($tasting_notes) > 0): ?>

          <div class="text-2xl <md:text-lg <lg:text-center has-paragraphs space-y-5 border-0 border-red-500">
            
            <?php foreach($tasting_notes as $key => $tasting_note): ?>
            <div>
              <h2 class="text-wine-red-regular font-medium">
                <?php echo $tasting_note['title']; ?>
              </h2>
              <?php echo wpautop($tasting_note['body']); ?>
            </div>
            <?php endforeach; ?>

          </div>

          <?php endif; ?>

          <?php if ($product_highlights): ?>
          <div class="text-2xl <md:text-lg w-10/12 <lg:w-full has-lists
            [&_li]:<lg:items-center [&_li]:<lg:justify-center [&_li]:<lg:flex x[&_li]:<lg:hidden border-red-500 border-0
          ">

            <h2 class="font-serif font-medium tracking-wide text-4xl <md:text-2xl <lg:text-center">Details</h2>
            <ul>
              <?php echo to_tags($product_highlights); ?>
            </ul>
          </div>
          <?php endif; ?>

          <div class="text-2xl <md:text-lg <lg:text-center border-0 border-red-500">
            <span class="block text-wine-red-regular">
              <?php echo $product_vol; ?><?php echo $weight_unit; ?> | <?php echo $product_abv; ?>% alc/vol
            </span>
          </div>

          <span class="text-3xl block font-serif font-bold tracking-wider text-earth-dark">
            <?php echo $currency_symbol; ?><?php echo number_format((int)$product_price, 2); ?>
          </span>

          <?php if ($is_in_stock): ?>

          <div id="app-form-add-to-cart">

            <form-add-to-cart
              v-slot="{ submitForm, response, increment, decrement, qty, checkOnInput }"
              v-bind:nonce="'<?php echo wp_create_nonce('wc_store_api'); ?>'"
              v-bind:product-id="'<?php echo $product_id; ?>'"
              v-bind:api-add-to-cart="'<?php echo site_url(); ?>/wp-json/wc/store/v1/cart/add-item'" 
              v-bind:redirect-url="'<?php echo site_url(); ?>/cart/'"
              v-bind:quantity="''"
              v-bind:min="1"
              v-bind:max="50"
            >

              <form
                novalidate="true"
                v-on:submit.prevent="submitForm"
              >

                <!-- flex -->
                <div class="flex flex-wrap items-center space-x-6 <md:space-x-2 pt-4 border-0 border-red-500">

                  <!-- flex -->
                  <div class="flex flex-wrap items-center space-x-5 <md:space-x-2 border-0 border-red-500">

                    <input 
                      class="input-number w-[2.5em] hover:w-[4em] transition-all duration-700 ease-in-out" 
                      type="number" 
                      placeholder="0" 
                      v-bind:value="qty"
                      v-on:input="checkOnInput"
                    />

                    <div class="flex flex-wrap space-x-3">
                      
                      <button 
                        class="border-0 border-red-500 flex items-center justify-center"
                        v-on:click.prevent="decrement"
                      >
                        <i class="icon-previous text-xl text-earth-dark transition-all ease-in-out duration-300 opacity-100 hover:opacity-60"></i>
                      </button>

                      <button 
                        class="border-0 border-red-500 flex items-center justify-center"
                        v-on:click.prevent="increment"
                      >
                        <i class="icon-next text-xl text-earth-dark transition-all ease-in-out duration-300 opacity-100 hover:opacity-60"></i>
                      </button>

                    </div>

                  </div>
                  <!-- flex -->

                  <a class="btn border-0 border-red-500" href="#">
                    <button>Add to Cart</button>
                  </a>

                </div>
                <!-- flex -->

                <!-- flex -->
                <div 
                  class="space-x-2 hidden text-xl <md:text-xl pt-1"
                  :class="{ '!flex': response.status === 'error' }"
                >
                  <i class="icon-warning"></i>
                  <p>{{ response.message }}</p>
                </div>
                <!-- flex -->

              </form>

            </form-add-to-cart>

          </div>

          <?php else: ?>

          <div class="hidden text-3xl <xl:text-lg <md:text-xl <lg:text-center border-0 border-red-500">
            <span class="bg-blue-regular text-white py-2 px-3 inline-block font-bold">
              Out of Stock
            </span>
          </div>
          
          <?php endif; ?>

        </div>
        <!-- flex -->

      </div>
      <!-- w-6/12 -->

    </div>
    <!-- flex -->

  </div>
  <!-- container -->

</div>
<!-- block -->

<?php get_template_part('template-parts/contents/related-products'); ?>
<?php get_template_part('template-parts/contents/newsletter'); ?>
