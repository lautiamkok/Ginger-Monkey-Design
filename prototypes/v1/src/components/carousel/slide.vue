<template>
  <div ref="root">
    <slot />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// import Swiper JS
// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle'
import 'swiper/css/bundle'

const root = ref(null)

onMounted(() => {
  // Select the `.swiper` element in this vue component only.
  const domElement = root.value
  const swiperElement = domElement.querySelector('.swiper.slide')

  var swiperAutoPlay = new Swiper(swiperElement, {
    spaceBetween: 0,
    centeredSlides: true,
    grabCursor: true,
    // loop: true,

    keyboard: {
      enabled: true,
    },

    // autoplay: {
    //   delay: 5000,
    //   disableOnInteraction: true, // does not work!
    // },
    
    pagination: {
      el: domElement.querySelector('.swiper-pagination'),
      clickable: true,
    },

    navigation: {
      nextEl: domElement.querySelector('.swiper-button-next'),
      prevEl: domElement.querySelector('.swiper-button-prev'),
    },
  })

  // https://stackoverflow.com/questions/32945099/how-to-detect-current-slide-in-swiper-js
  // swiperAutoPlay.on('slideChange', function () {
  //   let index = swiperAutoPlay.activeIndex
  //   let current = swiperAutoPlay.slides[index]
  //   console.log(current)
  // })
})
</script>
