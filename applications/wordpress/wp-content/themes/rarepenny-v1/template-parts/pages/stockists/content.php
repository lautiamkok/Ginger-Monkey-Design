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
      <h1 class="hidden"><?php the_title(); ?></h1>
      <h2 class="w-5/12 <2xl:w-6/12 <xl:w-8/12 <lg:w-9/12 <md:w-full text-white text-7xl <lg:text-6xl font-serif border-0 border-blue-500">
        <?php echo carbon_get_the_post_meta('h2'); ?>
      </h2>
      <div class="text-white text-xl <md:text-lg text-center w-7/12 <lg:w-10/12 border-0 border-red-500">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

</div>
<!-- block -->

<?php 
$locations_attachment_id = 0;
$localities_attachment_id = 0;
$databases = carbon_get_the_post_meta('databases'); 
if (is_countable($databases) && count($databases) > 0) {
  $locations_attachment_id = $databases[0]['id'];
  $localities_attachment_id = $databases[1]['id'];
}

$google_map1 = carbon_get_theme_option('google_maps')[0] ?? [];
$api_key = $google_map1['api_key'] ?? 'AIzaSyAoNifGJFXlSrA4d2uYG_b8QRR36m-kd80';
$map_id = $google_map1['map_id'] ?? '85ce2b243c24bff816337030';
$longitude = $google_map1['longitude'] ?? '133.775131';
$latitude = $google_map1['latitude'] ?? '-25.274399';
$zoom = $google_map1['zoom'] ?? '4';
$zoom_click = $google_map1['zoom_click'] ?? '12';
$zoom_search = $google_map1['zoom_search'] ?? '20';
$glyph_colour = $google_map1['glyph_colour'] ?? '#f9f2e8';
$glyph_border_colour = $google_map1['glyph_border_colour'] ?? '#f9f2e8';
$glyph_background = $google_map1['glyph_background'] ?? '#d31f2b';
?>

<?php if ($locations_attachment_id && $localities_attachment_id): ?>

<!-- block -->
<div class="py-20 px-10 <md:px-5 bg-milk-light" id="app-googlemap">

  <googlemap
    v-bind:api-locations="'<?php echo site_url(); ?>/wp-json/api/v1/get-stockists/csv/<?php echo $locations_attachment_id; ?>'"
    v-bind:api-localities="'<?php echo site_url(); ?>/wp-json/api/v1/get-stockists/csv/<?php echo $localities_attachment_id; ?>'"
    v-bind:api-key="'<?php echo $api_key; ?>'"
    v-bind:map-id="'<?php echo $map_id; ?>'"
    v-bind:longitude="<?php echo $longitude; ?>"
    v-bind:latitude="<?php echo $latitude; ?>"
    v-bind:zoom="<?php echo $zoom; ?>"
    v-bind:zoom-click="<?php echo $zoom_click; ?>"
    v-bind:glyph-colour="'<?php echo $glyph_colour; ?>'"
    v-bind:glyph-border-colour="'<?php echo $glyph_border_colour; ?>'"
    v-bind:glyph-background="'<?php echo $glyph_background; ?>'"

    v-slot="{ alphabets, sortTerm, handleChangedSort, suggestions, setSelectedSuggestion, searchTerm, displaySuggestions, displayDistances, toggleDistances, distanceTerm, getDistance, handleChangedDistance, filterTerm, handleChangedFilter, handleInputSearch, clearInputSearch, displayClearSearch, disableRadius }"
  >

    <!-- <div class="hiddenx">{{ alphabets }}</div>
    <div class="hiddenx">{{ sortTerm }}</div> -->

    <!-- container -->
    <div class="2xl:container mx-auto pl-5 py-5 <md:px-5 bg-white flex flex-wrap justify-between items-center <xl:flex-col <xl:space-y-5 <xl:items-start border-0 border-red-500">

      <!-- search + Distance -->
      <div class="w-5/12 <xl:w-full border-0 border-red-500 relative z-101">

        <div 
          class="w-full flex justify-start items-end bg-white space-x-3 <md:flex-col <md:items-start <md:space-x-0 <md:space-y-2"
        >
          
          <!-- input search -->
          <div class="w-[400px] <md:w-full flex justify-center items-center px-2 pb-1 bg-white border-b-1 border-blue-dark relative z-102">
            <div class="">
              <i class="icon-search text-sm"></i>
            </div>
            <input
              class="input-autocomplete w-full"
              type="text"
              placeholder="Enter address, region name, or zipcode"
              v-bind:value="searchTerm"
              v-on:input="handleInputSearch"
            >
            <button 
              class="transition-all ease-in-out duration-300 text-black hover:text-gray-500 border-0 border-red-500"
              v-on:click.prevent="clearInputSearch"
              v-show="displayClearSearch == true"
            >
              <i class="icon-close text-xs"></i>
            </button>
            <ul 
              class="
                absolute top-[115%] right-0 left-0 z-999 bg-white p-2 border-1 border-gray-200 shadow-xl flex flex-col
                overflow-hidden opacity-100 xmax-h-0 x-translate-y-full transition-all ease-in-out duration-300
              "
              v-show="suggestions.length && displaySuggestions == true"
            >
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                v-for="item in suggestions"
                v-bind:key="item.title || item.postcode || item.scope"
                v-on:click.prevent="setSelectedSuggestion(event, item)"
              >
                {{ item.address || item.scope || item.postcode }}
              </li>
              <!-- <li class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100">Victoria</li>
              <li class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100">Melbourne</li>
              <li class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100">Sydney</li> -->
            </ul>
          </div>
          <!-- input search -->

          <!-- distance options -->
          <div class="min-w-[100px] relative border-0 border-red-500">
            <button
              class="w-full bg-wine-red-regular hover:bg-blue-regular border flex items-center justify-between space-x-2 px-4 py-3 transition duration-300 ease cursor-pointer relative z-103 <md:z-101"
              v-on:click.prevent="toggleDistances"
              id="button-distance"
              :disabled="disableRadius"
              :class="{ 'rounded opacity-50 cursor-not-allowed': disableRadius == true }"
            >
              <div class="text-white border-0 border-red-500">
                <i class="icon-chevron-thin-down text-xs"></i>
              </div>
              <span class="text-white text-md border-0 border-red-500">
                {{ distanceTerm }} km
              </span>
            </button>
            <ul 
              class="
                absolute top-[110%] right-0 -left-5 z-102 <md:z-100 bg-white border-0 border-gray-200 shadow-2xl flex flex-col
                overflow-hidden opacity-0 max-h-0 -translate-y-full transition-all ease-in-out duration-300
              "
              :class="{ '!translate-y-0 max-h-60 opacity-100 !border-1 p-2': displayDistances == true || searchTerm == '' }"
            >
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100" 
                data-distance="0"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 0 }"
              >0 km</li>
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100" 
                data-distance="10"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 10 }"
              >10 km</li>
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="20"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 20 }"
              >20 km</li>
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="50"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 50 }"
              >50 km</li>
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="100"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 100 }"
              >100 km</li>
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="250"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 250 }"
              >250 km</li>
              <!-- <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="400"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 400 }"
              >400 km</li> -->
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="500"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 500 }"
              >500 km</li>
              <!-- <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="800"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 800 }"
              >800 km</li>
              <li 
                class="py-1 px-3 cursor-pointer transition duration-300 ease-in-out hover:bg-gray-100"
                data-distance="1200"
                v-on:click.prevent="getDistance"
                :class="{ 'font-bold': distanceTerm == 1200 }"
              >1200 km</li> -->
            </ul>
          </div>
          <!-- distance options -->

          <!-- distance options: hidden -->
          <div class="w-[120px] border-0 border-red-500 hidden">
            <div class="relative">
              <select
                class="w-full bg-white placeholder:text-slate-400 text-slate-700 text-xl border border-slate-200 rounded pr-3 pl-10 py-2 pt-2.2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
                v-bind:value="distanceTerm"
                v-on:change="handleChangedDistance"
              >
                <option value="10">10 km</option>
                <option value="20">20 km</option>
                <option value="50">50 km</option>
                <option value="100">100 km</option>
                <option value="250">250 km</option>
                <option value="500">500 km</option>
              </select>
              <div class="h-5 w-5 ml-1 absolute top-3.5 left-2 text-blue-dark border-0 border-red-500">
                <i class="icon-chevron-thin-down"></i>
              </div>
            </div>
          </div>
          <!-- distance options: hidden -->
          
        </div>

      </div>
      <!-- search + Distance -->

      <!-- Sort by -->
      <div class="flex items-center justify-center space-x-3 <md:px-0 <md:w-full <md:flex-col <md:items-start <md:space-x-0 <md:space-y-2 border-0 border-red-500 z-100">
        <span class="text-xl">Sort by: </span>
        <div class="relative <md:w-full border-0 border-red-500">
          <select
            class="min-w-[80px] <md:!w-full bg-white placeholder:text-slate-400 text-slate-700 text-xl border border-slate-200 rounded pl-3 pr-8 py-2 pt-2.2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
            v-on:change="handleChangedSort"
            v-bind:value="sortTerm"
          >
            <option value="">Select One</option>
            <option value="0-9">0 - 9</option>
            <option :value="alphabet" v-for="alphabet in alphabets" :key="alphabet">{{ alphabet }}</option>
          </select>
          <div class="h-5 w-5 ml-1 absolute top-3.5 right-3 text-slate-700">
            <i class="icon-chevron-thin-down"></i>
          </div>
        </div>
      </div>
      <!-- Sort by -->

      <!-- Filter by -->
      <div class="pr-5 flex items-center justify-center space-x-3 <md:px-0 <md:w-full <md:flex-col <md:items-start <md:space-x-0 <md:space-y-2 border-0 border-red-500 z-100">
        <span class="text-xl">Filter by: </span>
        <div class="relative <md:w-full border-0 border-red-500">
          <select
            class="min-w-[300px] <md:!w-full bg-white placeholder:text-slate-400 text-slate-700 text-xl border border-slate-200 rounded pl-3 pr-8 py-2 pt-2.2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
            v-on:change="handleChangedFilter"
            v-bind:value="filterTerm"
          >
            <option value="">Select One</option>
            <!-- <option value="All">All</option> -->
            <option value="Rare Penny Cabernet Merlot 750ml">Rare Penny Cabernet Merlot 750ml</option>
            <option value="Rare Penny Cabernet Sauvignon 750ml">Rare Penny Cabernet Sauvignon 750ml</option>
            <option value="Rare Penny Chardonnay 750ml">Rare Penny Chardonnay 750ml</option>
            <option value="Rare Penny Pinot Grigio 750ml">Rare Penny Pinot Grigio 750ml</option>
            <option value="Rare Penny Pinot Noir 750ml">Rare Penny Pinot Noir 750ml</option>
            <option value="Rare Penny Prosecco 750ml">Rare Penny Prosecco 750ml</option>
            <option value="Rare Penny Sauvignon Blanc 750ml">Rare Penny Sauvignon Blanc 750ml</option>
            <option value="Rare Penny Shiraz 750ml">Rare Penny Shiraz 750ml</option>
          </select>
          <div class="h-5 w-5 ml-1 absolute top-3.5 right-3 text-slate-700">
            <i class="icon-chevron-thin-down"></i>
          </div>
        </div>
      </div>
      <!-- Filter by -->

    </div>
    <!-- container -->

    <!-- container -->
    <div class="2xl:container mx-auto flex flex-wrap justify-center items-center border-0 border-red-500">

      <div class="h-screen-md w-4/12 <md:w-full <md:order-2">

        <!-- sidebar content -->
        <div class="w-full bg-white h-full overflow-auto border-0 border-blue-500">
          <ul id="sidebar" class="flex flex-col text-xl <md:text-lg">
          </ul>
        </div>
        <!-- sidebar content -->

      </div>
      <div id="map" class="h-screen-md w-8/12 <md:w-full <md:order-1">
        <!-- maps -->
      </div>
    </div>
  <!-- container -->

  </googlemap>

</div>
<!-- block -->

<?php else: ?>

<div class="py-20 px-10 <md:px-5 bg-milk-light">

  <div class="text-6xl <md:text-5xl <md:px-5 text-center uppercase py-10 border-0 border-green-500 font-bold">
    <p>Coming Soon.</p>
  </div>

</div>
<!-- block -->

<?php endif; ?>

<?php get_template_part('template-parts/contents/newsletter'); ?>
