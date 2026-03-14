<template>
  <div ref="root">
    <slot 
      v-bind:display="display"
      v-bind:toggle="toggle"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// import Swiper JS
// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle'
import 'swiper/css/bundle'

// https://masonry.desandro.com/
import Masonry from 'masonry-layout'

import { disablePageScroll, enablePageScroll } from '@fluejs/noscroll'

const root = ref(null)
const swiper = ref(null)
const gallery = ref([])
const lock = ref(null)
const display = ref(false)

function toggle (event) {
  const domElement = root.value

  event.preventDefault()
  event.stopPropagation()

  const xxx = domElement.querySelector('.xxx')
  console.log(xxx)
  // xxx.classList.toggle('hidden')
  // xxx.classList.toggle('-left-[9999px]')
  console.log(domElement.querySelector('.xxx'))

  display.value = !display.value

  // Exit fullscreen is it is on the fullscreen mode.
  if (document.fullscreenElement !== null) {
    exitFullscreen()
  }

  // Destroy the swiper on exit.
  if (display.value === false) {
    reset()

    console.log('destroying swiper...')
    swiper.value.destroy(true, true)
    swiper.value = null

    return
  }

  // Lock scroll bar here.
  lock.value = document.getElementsByTagName('body')[0]
  disablePageScroll(lock.value)

  // Get the data from the data attributes.
  const data = event.currentTarget.dataset
  const initialIndex = data.index
  console.log('Clicked:', initialIndex)

  
  const swiperElement = domElement.querySelector('.swiper.slide')

  // Create global swiper for image slide
  swiper.value = new Swiper(swiperElement, {
    // Use these options when you have hidden elements.
    // https://stackoverflow.com/questions/41638408/idangero-us-swiper-not-working-when-inside-a-div-set-hidden-displaynone
    observer: true,
    observeParents: true,

    initialSlide: initialIndex,
    slideToClickedSlide: true,
    grabCursor: true,
    slidesPerView: 1,
    keyboard: {
      enabled: true,
    },

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
      type: 'fraction',
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    }
  })
}

function reset () {
  console.log('resetting gallery...')
  if (display.value) {
    display.value = false
  }
  if (lock.value) {
    enablePageScroll(lock.value)
    lock.value = null
  }
}

onMounted(() => {
  // Select the `.swiper` element in this vue component only.
  const domElement = root.value
  const swiperElement = domElement.querySelector('.swiper.slide')

  // https://masonry.desandro.com/#getting-started
  const elem = domElement.querySelector('.grid')
  const msnry = new Masonry( elem, {
    // options
    itemSelector: '.grid-item',
    columnWidth: 0
  })
})
</script>
