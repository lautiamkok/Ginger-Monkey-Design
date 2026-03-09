<template>
  <div ref="root">
    <slot v-bind:activeSlide="activeSlide" />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'

// import Swiper JS
// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle'
import 'swiper/css/bundle'

const root = ref(null)

const activeSlide = reactive({
  heading: '',
  body: '',
  awards: []
})

onMounted(() => {
  // Select the `.swiper` element in this vue component only.
  const domElement = root.value
  const swiperElement = domElement.querySelector('.swiper.centered')

  // https://codesandbox.io/p/sandbox/zvzq7y?file=%2Findex.html%3A74%2C7-76%2C28
  var swiper = new Swiper(swiperElement, {
    // slidesPerView: 8,
    // spaceBetween: 30,
    centeredSlides: true,
    grabCursor: true,
    loop: true,

    keyboard: {
      enabled: true,
    },

    pagination: {
      el: domElement.querySelector('.swiper-pagination'),
      clickable: true,
    },

    navigation: {
      nextEl: domElement.querySelector('.swiper-button-next'),
      prevEl: domElement.querySelector('.swiper-button-prev'),
    },

    breakpoints: {
      "@0.00": {
        slidesPerView: 1,
        spaceBetween: 0,
      },
      "@0.50": {
        slidesPerView: 1,
        spaceBetween: 0,
      },
      "@0.75": {
        slidesPerView: 3,
        spaceBetween: 0,
      },
      "@1.00": {
        slidesPerView: 4,
        spaceBetween: 0,
      },
      "@1.50": {
        slidesPerView: 4,
        spaceBetween: 0,
      },
    },
  })

  let previousTarget = null

  var startIndex = swiper.activeIndex
  var startElement = swiper.slides[startIndex]
  var startTarget = startElement.getElementsByTagName("img")[0]
  previousTarget = startTarget

  activeSlide.title = startTarget.dataset.title ?? ''
  activeSlide.group = startTarget.dataset.group ?? ''
  activeSlide.body = startTarget.dataset.body ?? ''

  swiper.on('realIndexChange', x => {
    if (previousTarget) {
      previousTarget.classList.add('scale-90')
      previousTarget.classList.remove('scale-100')
    }

    var activeIndex = x.activeIndex
    // console.log(activeIndex)

    var currentElement = x.slides[activeIndex]
    var currentTarget = currentElement.getElementsByTagName("img")[0]
    previousTarget = currentTarget

    currentTarget.classList.remove('scale-90')
    currentTarget.classList.add('scale-100')
    // console.log('currentTarget =', currentTarget)

    activeSlide.title = currentTarget.dataset.title ?? ''
    activeSlide.group = currentTarget.dataset.group ?? ''
    activeSlide.body = currentTarget.dataset.body ?? ''
  })

})
</script>
