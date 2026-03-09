<?php
/**
 * The template used for displaying newsletter
 *
 * @package WordPress
 * @subpackage Rare Penny
 * @since 1.0
 * @version 1.0
 */
?>

<?php $forms = carbon_get_theme_option('forms'); ?>
<?php if (is_countable($forms) && count($forms) > 0): ?>

<?php
$subscribe_setting = get_haystack_item('newsletter', $forms);
$subscribe_labels = $subscribe_setting['labels'];
?>

<!-- block -->
<div class="bg-earth-dark">

  <div class="py-20 space-y-10">
    
    <!-- container -->
    <div 
      class="2xl:container mx-auto flex-center-x overflow-hidden <md:px-5 border-0 border-red-500"
      data-aos="fade-up" 
      data-aos-duration="1000"
      data-aos-delay="500"
    >

      <!-- flex -->
      <div class="w-full flex flex-col items-center space-y-4 border-0 border-blue-500">

        <div class="flex flex-col items-center space-y-2">
          <h2 class="font-serif font-medium tracking-wide text-5xl text-white text-center leading-14">
            <?php echo $subscribe_setting['title']; ?>
          </h2>

          <div class="text-2xl text-white w-8/12 <md:w-full text-center">
            <?php echo wpautop(replace_brackets($subscribe_setting['body'])); ?>
          </div>
        </div>

      </div>
      <!-- flex -->

    </div>
    <!-- container -->

    <!-- container -->
    <div 
      class="2xl:container mx-auto <md:px-5 border-0 border-red-500" 
      id="app-form-newsletter"
    >

      <form-newsletter
        v-slot="{ v$, form, response, submitForm, resetResponse }"
        v-bind:api-add-subscriber="'/wp-json/api/v1/subscriber/add'"
      >
        <form
          class="w-full flex flex-col items-center justify-center space-y-10 border-0 border-red-500"
          novalidate="true"
          v-on:submit.prevent="submitForm"
        >

          <!-- fields -->
          <div class="w-3.5/12 <xl:w-4/12 <lg:w-5/12 <md:w-full">

            <!-- block: honey -->
            <div class="absolute top-0 left-0 w-0 h-0 -z-1 opacity-0">
              <label class="block" for="name">
                Full Name
              </label>
              <input
                id="name"
                type="text"
                name="name"
                autocomplete="disabled"
                v-model.trim="form.name"
              >

              <label class="block" for="fname">
                First Name
              </label>
              <input
                id="fname"
                type="text"
                name="fname"
                autocomplete="disabled"
                v-model.trim="form.fname"
              >

              <label class="block" for="lname">
                Last Name
              </label>
              <input
                id="lname"
                type="text"
                name="lname"
                autocomplete="disabled"
                v-model.trim="form.lname"
              >

              <label class="block" for="email">
                Email
              </label>
              <input
                id="email"
                type="email"
                name="email"
                autocomplete="disabled"
                v-model.trim="form.email"
              >

              <label class="block" for="telephone">
                Telephone
              </label>
              <input
                id="telephone"
                type="text"
                name="telephone"
                autocomplete="disabled"
                v-model.trim="form.telephone"
              >
            </div>
            <!-- block: honey -->

            <!-- flex -->
            <div 
              class="flex flex-wrap flex-col items-center justify-center space-y-5 border-0 border-red-500 bg-[#f3efed] py-6 px-5 rounded-xl"
              data-aos="fade-up" 
              data-aos-duration="1000"
              data-aos-delay="500"
            >
              
              <div class="w-full border-0 border-red-500">
                <input 
                  type="text" 
                  placeholder="First name" 
                  class="input-light" 
                  v-model.trim="form.firstName"
                  v-on:blur="v$.firstName.$touch"
                  v-bind:class="{ 'has-error': v$.firstName.$errors.length }"
                />
                <div v-for="error of v$.firstName.$errors" :key="error.$uid">
                  <div class="text-red-500 text-xl px-4">{{ error.$message }}</div>
                </div>
              </div>

              <div class="w-full border-0 border-red-500">
                <input 
                  type="text" 
                  placeholder="Last name" 
                  class="input-light" 
                  v-model.trim="form.lastName"
                  v-on:blur="v$.lastName.$touch"
                  v-bind:class="{ 'has-error': v$.lastName.$errors.length }"
                />
                <div v-for="error of v$.lastName.$errors" :key="error.$uid">
                  <div class="text-red-500 text-xl px-4">{{ error.$message }}</div>
                </div>
              </div>
              
              <div class="w-full border-0 border-red-500">
                <input 
                  type="text" 
                  placeholder="Email address" 
                  class="input-light" 
                  v-model.trim="form.emailAddress"
                  v-on:blur="v$.emailAddress.$touch"
                  v-bind:class="{ 'has-error': v$.emailAddress.$errors.length }"
                />
                <div v-for="error of v$.emailAddress.$errors" :key="error.$uid">
                  <div class="text-red-500 text-xl px-4">{{ error.$message }}</div>
                </div>
              </div>

            </div>
            <!-- flex -->

          </div>
          <!-- fields -->

          <div 
            data-aos="fade-up" 
            data-aos-duration="1000"
            data-aos-delay="500"
          >
            <a class="btn" href="#">
              <button>
                <?php echo get_key_value('button_signup', $subscribe_labels); ?>
              </button>
            </a>
          </div>

        </form>

        <div
          v-on:click.prevent="resetResponse"
          class="hidden top-0 bottom-0 left-0 right-0 bg-white bg-opacity-90 z-9999"
          :class="{ 'fixed flex justify-center items-center flex-wrap': response.status === 'ok' }"
        >
          <div class="w-6/12 <xl:w-10/12 <md:w-11/12 flex-center-x border-0 border-red-500">
            <p class="bg-blue-light py-4 px-6 text-3xl text-center">
              <i class="icon-thumb-up"></i> {{ response.message }}
            </p>
          </div>
        </div>

        <div
          v-on:click.prevent="resetResponse"
          class="hidden top-0 bottom-0 left-0 right-0 bg-white bg-opacity-90 z-9999 border-0 border-red-500"
          :class="{ 'fixed flex justify-center items-center flex-wrap': response.status === 'error' }"
        >
          <div class="w-6/12 <xl:w-10/12 <md:w-11/12 flex-center-x">
            <p class="bg-red-200 py-4 px-6 text-3xl text-center">
              <i class="icon-warning"></i> {{ response.message }}
            </p>
          </div>
        </div>

      </form-newsletter>

    </div>
    <!-- container -->

  </div>

</div>
<!-- block -->

<?php endif; ?>
