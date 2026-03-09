<?php
/**
 * The template used for displaying related posts
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
?>

<?php $related_post1 = carbon_get_the_post_meta('related_products')[0] ?? []; ?>
<?php if (is_countable($related_post1) && count($related_post1) > 0): ?>
<?php $currency_symbol = get_woocommerce_currency_symbol(); ?>

<!-- block -->
<div class="py-10 pb-20 <xl:pb-10 px-10 <md:px-5 bg-milk-regular border-0 border-red-500 <md:space-y-10">

  <div class="2xl:container mx-auto border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >

    <div class="flex flex-col flex-wrap items-start justify-start space-y-5">
      <h2 class="font-serif text-wine-red-regular text-6xl <md:text-5xl">
        Related products
      </h2>
    </div>

  </div>

  <!-- container -->
  <div class="2xl:container mx-auto flex flex-col flex-wrap items-start justify-start space-y-15 border-0 border-red-500 overflow-hidden"
    data-aos="fade-right" 
    data-aos-duration="1000"
    data-aos-delay="500"
  >
    
    <div class="flex flex-wrap items-center justify-center w-full <lg:flex-col <lg:space-x-0 <lg:space-y-5 ">

      <?php $associates = $related_post1['associates']; ?>
      <?php if (is_countable($associates) && count($associates) > 0): ?>
      <ul class=" flex flex-wrap items-stretch justify-start <md:space-y-10 border-0 border-green-500">

        <?php foreach($associates as $key => $associate): ?>
        <?php 
        $post_related = get_post($associate['id']);

        $product = wc_get_product($associate['id']);

        $is_in_stock = $product->is_in_stock();
        // var_dump($is_in_stock);

        // Get product id (wc).
        $product_id = $product->get_id();

        // Get product price (wc).
        $product_price = $product->get_price();
        $regular_price = $product->get_regular_price();

        // Get product abv (custom field).
        $product_vol = get_post_meta($associate['id'], '_custom_product_vol', true);
        $product_abv = get_post_meta($associate['id'], '_custom_product_abv', true);

        // Get product weight unit (wc).
        $weight_unit = get_option('woocommerce_weight_unit');
        if (is_numeric($product_vol) && $product_vol >= 1000) {
          $weight_unit = ' litre';
          $product_vol = $product_vol / 1000;
        }

        $image_url = null;
        $image_placeholder_url = null;
        $image_alt = null;
        $cover_id = carbon_get_post_meta($associate['id'], 'cover_id');
        if ($cover_id) {
          $image_url = wp_get_attachment_image_src($cover_id, '1536x1536')[0];
          $image_placeholder_url = get_image_url($cover_id, 'placeholder');
          $image_alt = carbon_get_post_meta($associate['id'], 'cover_alt');
          // var_dump($image_url);
          // var_dump($image_placeholder_url);
        }
        ?>
        <li class="px-10 py-10 <md:px-0 <md:py-0 w-4/12 <lg:w-6/12 <md:w-full flex flex-col flex-wrap items-center border-0 border-blue-500">
          <div class="w-full aspect-3/5 py-10 inline-block overflow-hidden relative rounded-t-3xl bg-milk-light border-0 border-red-500">
            <a href="<?php echo get_permalink($associate['id']); ?>" class="w-full h-full transition-all ease-in-out duration-300 opacity-100 hover:opacity-60">
              <img
                class="
                  w-full 
                  h-full

                  object-center
                  object-contain

                  transition-all 
                  duration-1000
                  blur-3xl
                  filter
                  scale-125

                  lazy

                  transform 
                  hover:scale-105 
                  cursor-pointer

                  border-0 
                  border-green-500
                "
                src="<?php echo $image_placeholder_url; ?>"
                data-src="<?php echo $image_url; ?>"
                alt="<?php echo $image_alt; ?>"
              />
            </a>
          </div>
          <div class="px-5 py-8 w-full grow flex flex-col items-center text-center space-y-3 bg-milk-dark rounded-b-3xl border-0 border-red-500">
            <div>
              <h3 class="font-serif font-medium tracking-wide text-4xl border-0 border-red-500">
                <a href="<?php echo get_permalink($associate['id']); ?>" class="transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-red-500 flex flex-col">
                  <?php echo $post_related->post_title; ?>
                </a>
              </h3>
            </div>
            <div class="flex flex-col">
              <span class="text-wine-red-regular text-lg">
                <?php echo $product_vol; ?><?php echo $weight_unit; ?> | <?php echo $product_abv; ?>% alc/vol
              </span>
              <span class="text-earth-dark text-xl font-bold">
                <?php echo $currency_symbol; ?><?php echo number_format((int)$product_price, 2); ?>
              </span>
            </div>
            <div class="pt-1">
              <a class="btn" href="<?php echo get_permalink($associate['id']); ?>">
                <button>PURCHASE HERE</button>
              </a>
            </div>
          </div>
        </li>
        <?php endforeach; ?>

      </ul>
      <?php endif; ?>

    </div>

  </div>
  <!-- container -->

</div>
<!-- block -->

<?php endif; ?>
