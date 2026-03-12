'use strict'

// Import styles.
import '@/styles'

import { createApp } from 'vue'

import AOS from 'aos'
import 'aos/dist/aos.css'

// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle'

// import styles bundle
import 'swiper/css/bundle'

import { disablePageScroll, enablePageScroll } from '@fluejs/noscroll'

import CurrentBreakpoint from '@/components/current-breakpoint.vue'
import CarouselCentered from '@/components/carousel/centered.vue'
import CarouselSlide from '@/components/carousel/slide.vue'
import DisplayToggler from '@/components/display-toggler.vue'

import Lazy from '@/utils/lazy' 
import Parallax from '@/utils/parallax'
import isInViewport from '@/utils/is-in-viewport'

// Attach vue apps separately.
if (document.getElementById('app-display-toggler') !== null) {
  createApp()
    .component('DisplayToggler', DisplayToggler)
    .mount('#app-display-toggler')
}

if (document.getElementById('app-current-breakpoint') !== null) {
  createApp()
    .component('CurrentBreakpoint', CurrentBreakpoint)
    .mount('#app-current-breakpoint')
}

if (document.getElementById('app-carousel-centered') !== null) {
  createApp()
    .component('CarouselCentered', CarouselCentered)
    .mount('#app-carousel-centered')
}

if (document.getElementById('app-carousel-slide') !== null) {
  createApp()
    .component('CarouselSlide', CarouselSlide)
    .mount('#app-carousel-slide')
}

// Start AOS.
AOS.init({
  // Global settings:
  // disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
  // startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
  // initClassName: 'aos-init', // class applied after initialization
  // animatedClassName: 'aos-animate', // class applied on animation
  // useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
  // disableMutationObserver: false, // disables automatic mutations' detections (advanced)
  // debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
  // throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)

  // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
  offset: -150, // offset (in px) from the original trigger point
  // delay: 0, // values from 0 to 3000, with step 50ms
  // duration: 1000, // values from 0 to 3000, with step 50ms
  // easing: 'ease', // default easing for AOS animations
  // once: false, // whether animation should happen only once - while scrolling down
  // mirror: false, // whether elements should animate out while scrolling past them
  // anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
})

// Lazy load images.
const lazy = new Lazy()
lazy.observe()

// Create parallax.
const parallax = new Parallax('.parallax')
parallax.init()
addEventListener('resize', event => {
  parallax.init()
})

// Open and exit mobile menu.
const buttonBurger = document.getElementById('burger-button')
const buttonExit = document.getElementById('exit-button')
const menuMobile = document.getElementById('mobile-menu')
let lock = document.getElementsByTagName('body')[0]
buttonBurger.addEventListener('click', event => {
  // menuMobile.classList.remove('hidden')
  menuMobile.classList.toggle('-translate-y-full')
  menuMobile.classList.toggle('translate-y-0')
  // disablePageScroll(lock)
  // document.body.style.overflow = 'hidden';
  event.preventDefault()
  event.stopPropagation()
})
buttonExit.addEventListener('click', event => {
  // menuMobile.classList.add('hidden')
  menuMobile.classList.toggle('-translate-y-full')
  menuMobile.classList.toggle('translate-y-0')
  // enablePageScroll(lock)
  // document.body.style.overflow = 'auto';
  event.preventDefault()
  event.stopPropagation()
})

// Show button up.
// const scrollend = 'onscrollend' in window
const buttonUp = document.getElementById('button-up')
const footer = document.getElementById('footer')
if (buttonUp && footer) {
  window.addEventListener('scroll', event => {
    // console.log('scrolling')
    if (isInViewport(footer)) {
      buttonUp.classList.add('opacity-100')
      buttonUp.classList.remove('opacity-0')
    } else {
      buttonUp.classList.add('opacity-0')
      buttonUp.classList.remove('opacity-100')
    }
  })

  // https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollend_event
  // Safari not working
  window.addEventListener('scrollend', event => {
    // console.log('scrolling ended')
    if (isInViewport(footer)) {
      buttonUp.classList.add('opacity-100')
      buttonUp.classList.remove('opacity-0')
    } else {
      buttonUp.classList.add('opacity-0')
      buttonUp.classList.remove('opacity-100')
    }
  })
}

// Play, pause, mute, unmute the videos on age gate.
// document.querySelectorAll('.video-play-pause').forEach(video => {
//   video.addEventListener('click', event => {
//     if (video.paused) {
//       video.play()
//       video.muted = false
//     } else {
//       video.pause()
//       video.muted = true
//     }
//   })
// })
