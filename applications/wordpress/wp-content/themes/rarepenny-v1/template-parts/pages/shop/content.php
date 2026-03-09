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

if (is_numeric($product_vol) && $product_vol >= 1000) {
  $weight_unit = ' litre';
  $product_vol = $product_vol / 1000;
}
?>



<li class="px-10 py-10 <md:px-0 <md:py-0 w-4/12 <lg:w-6/12 <md:w-full flex flex-col flex-wrap items-center border-0 border-blue-500">
  <div class="w-full aspect-3/5 py-10 inline-block overflow-hidden relative rounded-t-3xl bg-milk-light border-0 border-red-500">
    <a href="<?php the_permalink(); ?>" class="w-full h-full transition-all ease-in-out duration-300 opacity-100 hover:opacity-60">
      
      <?php
      $image_url = null;
      $image_placeholder_url = null;
      $image_alt = null;
      $post_cover_id = carbon_get_the_post_meta('cover_id');
      if ($post_cover_id):
        $image_url = wp_get_attachment_image_src($post_cover_id, '1536x1536')[0];
        $image_placeholder_url = get_image_url($post_cover_id, 'placeholder');
        $image_alt = carbon_get_the_post_meta('cover_alt');
      ?>
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
      <?php endif; ?>

    </a>
  </div>
  <div class="px-5 py-8 w-full grow flex flex-col items-center text-center space-y-3 bg-milk-dark rounded-b-3xl border-0 border-red-500">
    <div>
      <h3 class="font-serif font-medium tracking-wide text-4xl border-0 border-red-500">
        <a href="#" class="transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-red-500 flex flex-col">
          <?php the_title(); ?>
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

    <?php if ($is_in_stock): ?>
    <div class="pt-1">
      <a class="btn" href="<?php the_permalink(); ?>">
        <button>PURCHASE HERE</button>
      </a>
    </div>
    <?php else: ?>
    <div class="pt-1">
      <a class="btn" href="<?php the_permalink(); ?>">
        <button>Out of stock</button>
      </a>
    </div>
    <?php endif; ?>

  </div>
</li>
