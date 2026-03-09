<?php
/**
 * The template used for displaying page header
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
?>

<?php
// Set the menu items to the WP cache.
// https://developer.wordpress.org/reference/functions/wp_cache_set/
$menu_header_items = get_menu('menu-header');
wp_cache_set('menu_header_items', $menu_header_items);

$cart_contents_count = 0;
$is_blacklisted = false;
if (is_plugin_active( 'woocommerce/woocommerce.php')) {
  global $woocommerce;
  $cart_contents_count = $woocommerce->cart->get_cart_contents_count();
  wp_cache_set('cart_contents_count', $cart_contents_count);
}
$is_blacklisted = wp_cache_get('is_blacklisted');
?>

<div class="sticky-intersection absolute top-0 left-0 right-0 h-5"></div>
<header 
  class="
    relative 
    bg-wine-red-regular

    sticky 
    sticky-header 
    top-0 

    transition-all
    ease-in-out
    duration-300 

    z-999
  " 
  >

  <!-- large up -->
  <nav class="
    py-4
    px-10
    <sm:px-2
    
    w-full
    flex
    items-center
    justify-center

    transition-all 
    ease-in-out 
    duration-300
    
    border-0 
    border-blue-500

    relative
  ">
    <ul class="flex w-5/12 items-end <xl:w-4/12 <sm:w-3/12 border-0 border-blue-500">
      <li class="border-0 border-blue-500 flex items-center justify-center">
        <a 
          href="#" 
          class="inline-flex items-center justify-center transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-blue-500 open-search"
        >
          <i class="icon-search text-2xl text-milk-light"></i>
        </a>
      </li>
    </ul>

    <div class="flex items-center justify-center w-2/12 <xl:w-4/12 <sm:w-5/12 border-0 border-red-500" >
      <a href="<?php echo site_url(); ?>" class="border-0 border-blue-500 transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 h-full logo-complete overflow-hidden">
        <img src="/wp-content/themes/rarepenny-v1/dist/static/logo-rare-penny-front.svg" class="absolute absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 object-cover object-contain w-75 <sm:w-60"/>
        <img 
          src="/wp-content/themes/rarepenny-v1/dist/static/logo-rare-penny-back.svg" 
          class="
            object-cover 
            object-contain 
            w-45
            
            logo-back 
            opacity-100 
            max-h-100 

            transition-all 
            ease-in-out 
            duration-300
          " 
          />
      </a>
    </div>

    <div class="flex justify-end w-5/12 space-x-15 <xl:hidden border-0 border-blue-500">

      <?php if (is_countable($menu_header_items) && count($menu_header_items) > 0): ?>
      <ul class="flex pr-20 <2xl:pr-10 space-x-8 <xl:space-x-5 border-0 border-blue-500">

        <?php foreach($menu_header_items as $key => $menu_item): ?>
        <li class="border-0 border-blue-500 flex items-center justify-center relative">
          <?php if ($menu_item['current']): ?>
          <a href="<?php echo $menu_item['url']; ?>" class="[&_span]:hover:visible transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 text-[1.045rem] leading-5 uppercase text-salmon-pink flex flex-col items-center border-0 border-blue-500">
            <span class="border-0 border-blue-500">
              <?php echo $menu_item['title']; ?>
            </span>
            <span class="block mt-[2px] h-[2px] w-4/12 bg-salmon-pink"></span>
          </a>
          <?php else: ?>
          <a href="<?php echo $menu_item['url']; ?>" class="[&_span]:hover:visible transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 text-[1.045rem] leading-5 uppercase text-milk-light flex flex-col items-center border-0 border-blue-500">
            <span class="border-0 border-blue-500">
              <?php echo $menu_item['title']; ?>
            </span>
            <span class="block mt-[2px] h-[2px] w-4/12 bg-milk-light invisible"></span>
          </a>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>

      </ul>
      <?php endif; ?>

      <ul class="absolute top-5 right-10 border-0 border-red-500">
        <li class="border-0 border-blue-500 flex items-center justify-center relative">
          <a 
            href="<?php echo site_url(); ?>/cart" 
            class="inline-flex items-center justify-center text-milk-light transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-blue-500"
          >
            <i class="icon-cart text-2xl"></i>
          </a>
          <span class="absolute text-md border-0 border-red-500 -top-4 left-1.5 text-milk-light">
            <?php echo $cart_contents_count; ?>
          </span>
        </li>
      </ul>

    </div>

    <!-- mobile burger -->
    <ul class="<xl:w-4/12 <sm:w-3/12 flex flex-col items-end justify-end xl:hidden border-0 border-red-500">
      <li class="border-0 border-blue-500 flex items-center justify-center">
        <a 
          href="#" 
          class="flex flex-col space-y-2 items-center transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-red-500"
          id="burger-button"
        >
          <i class="icon-burger text-lg text-milk-light"></i>
        </a>
      </li>
    </ul>
    <!-- mobile burger -->
      
  </nav>

  <?php if (!$is_blacklisted): ?>
  <!-- mobile cart -->
  <div class="fixed bg-black rounded-l-md px-2 py-3 pt-6 right-0 top-80 z-999 xl:hidden">
    <ul class="flex border-0 border-red-500">
      <li class="border-0 border-blue-500 flex items-center justify-center relative">
        <a 
          href="<?php echo site_url(); ?>/cart" 
          class="inline-flex items-center justify-center text-milk-light transition-all ease-in-out duration-300 opacity-100 hover:opacity-60 border-0 border-blue-500 open-search"
        >
          <i class="icon-cart text-2xl"></i>
        </a>
        <span class="absolute text-md border-0 border-red-500 -top-5 left-2 text-milk-light">
          <?php echo $cart_contents_count; ?>
        </span>
      </li>
    </ul>
  </div>
  <!-- mobile cart -->
  <?php endif; ?>

</header>
