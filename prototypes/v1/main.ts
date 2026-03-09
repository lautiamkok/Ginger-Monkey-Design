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
import FormNewsletter from '@/components/form/newsletter.vue'
import FormAddToCart from '@/components/form/add-to-cart.vue'
import FormAge from '@/components/form/age.vue'
import FormSearch from '@/components/form/search.vue'
import Googlemap from '@/components/googlemap.vue'
import DisplayToggler from '@/components/display-toggler.vue'

import Lazy from '@/utils/lazy' 
import Parallax from '@/utils/parallax'
import isInViewport from '@/utils/is-in-viewport'

// Attach vue apps separately.
if (document.getElementById('app-age-gate') !== null) {
  createApp()
    .component('FormAge', FormAge)
    .mount('#app-age-gate')
}

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

if (document.getElementById('app-carousel-slide-awards') !== null) {
  createApp()
    .component('CarouselSlide', CarouselSlide)
    .mount('#app-carousel-slide-awards')
}

if (document.getElementById('app-carousel-slide-cocktails') !== null) {
  createApp()
    .component('CarouselSlide', CarouselSlide)
    .mount('#app-carousel-slide-cocktails')
}

if (document.getElementById('app-carousel-slide-premixed') !== null) {
  createApp()
    .component('CarouselSlide', CarouselSlide)
    .mount('#app-carousel-slide-premixed')
}

if (document.getElementById('app-form-newsletter') !== null) {
  createApp()
    .component('FormNewsletter', FormNewsletter)
    .mount('#app-form-newsletter')
}

if (document.getElementById('app-form-add-to-cart') !== null) {
  createApp()
    .component('FormAddToCart', FormAddToCart)
    .mount('#app-form-add-to-cart')
}

if (document.getElementById('app-search') !== null) {
  createApp()
    .component('FormSearch', FormSearch)
    .mount('#app-search')

  // Open and exit search form.
  const elements = document.querySelectorAll('.open-search')
  const exitSearch = document.getElementById('exit-search')
  const search = document.getElementById('search')
  let lock = document.getElementsByTagName('body')[0]
  elements.forEach(element => {
    element.addEventListener('click', event => {
      search.classList.remove('hidden')
      disablePageScroll(lock)
      event.preventDefault()
      event.stopPropagation()
    })
  })
  exitSearch.addEventListener('click', event => {
    search.classList.add('hidden')
    enablePageScroll(lock)
    event.preventDefault()
    event.stopPropagation()
  })
}

if (document.getElementById('app-googlemap') !== null) {
  createApp()
    .component('Googlemap', Googlemap)
    .mount('#app-googlemap')

  // Slide in and out the map sidebar.
  // https://stackoverflow.com/questions/16989585/css-3-slide-in-from-left-transition
  // const slidebarWrapper = document.getElementById('sidebar-wrapper')
  // const openSideBar = document.getElementById('button-open-sidebar')
  // const closeSideBar = document.getElementById('button-exit-sidebar')
  // openSideBar.addEventListener('click', event => {
  //   slidebarWrapper.classList.add('left-0')
  //   slidebarWrapper.classList.remove('-left-3/12', '<2xl:-left-4/12', '<xl:-left-5/12', '<md:-left-8/12')
   
  //   openSideBar.classList.add('!hidden')
  //   closeSideBar.classList.remove('!hidden')
    
  //   event.preventDefault()
  //   event.stopPropagation()
  // })

  // closeSideBar.addEventListener('click', event => {
  //   slidebarWrapper.classList.add('-left-3/12', '<2xl:-left-4/12', '<xl:-left-5/12', '<md:-left-8/12')
  //   slidebarWrapper.classList.remove('left-0')
    
  //   openSideBar.classList.remove('!hidden')
  //   closeSideBar.classList.add('!hidden')
    
  //   event.preventDefault()
  //   event.stopPropagation()
  // })
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

// Swiper newsticker.
// https://stackoverflow.com/questions/64853149/how-to-create-a-ticker-mode-slider-with-swiper-js
// https://getfizzy.co/
let SwiperTicker = new Swiper('.swiper.newsticker', {
  spaceBetween: 15,
  centeredSlides: true,

  // desktop; global
  // speed: 10000,
  
  autoplay: {
    delay: 1,
  },
  loop: true,
  slidesPerView:'auto',
  allowTouchMove: false,
  disableOnInteraction: true,

  // Resposive
  breakpoints: {
    "@0.00": {
      speed: 30000, // desktop; 30000 mobile
    },
    "@0.75": {
      speed: 15000, // desktop; 30000 mobile
    },
    "@1.00": {
      speed: 15000, // desktop; 30000 mobile
    },
    "@1.50": {
      speed: 10000, // desktop; 30000 mobile
    },
  },
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
  menuMobile.classList.remove('hidden')
  disablePageScroll(lock)
  event.preventDefault()
  event.stopPropagation()
})
buttonExit.addEventListener('click', event => {
  menuMobile.classList.add('hidden')
  enablePageScroll(lock)
  event.preventDefault()
  event.stopPropagation()
})

const scrollend = 'onscrollend' in window
const rotatable = document.querySelector('.is-rotatable')
if (rotatable) {
  window.addEventListener('scroll', event => {
    // console.log('scrolling')
    if (isInViewport(rotatable)) {
      rotatable.classList.remove('rotate-paused')
      rotatable.classList.add('rotate')
    } else {
      rotatable.classList.remove('rotate', 'rotate-paused')
    }
  })

  // https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollend_event
  // Safari not working
  window.addEventListener('scrollend', event => {
    // console.log('scrolling ended')
    if (isInViewport(rotatable)) {
      rotatable.classList.add('rotate-paused')
    } else {
      rotatable.classList.remove('rotate', 'rotate-paused')
    }
  })
}

// if (scrollend) {
//   console.log('scrollend event is supported')
// }

// Fallback for Safari!
if (!scrollend && rotatable) {
  // console.log('scrollend event is not supported')
  // https://developer.chrome.com/blog/scrollend-a-new-javascript-event
  window.addEventListener('scroll',  event => {
    // console.log('scrolling')
    if (isInViewport(rotatable)) {
      rotatable.classList.remove('rotate-paused')
      rotatable.classList.add('rotate')
    }
    clearTimeout(window.scrollEndTimer)
    window.scrollEndTimer = setTimeout(scrollended, 100)
  })
}

function scrollended () {
  // console.log('scrolling ended')
  if (isInViewport(rotatable)) {
    rotatable.classList.add('rotate-paused')
  }
}

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

// // Toggle dropdown desktop menu.
// const toggleDropdownDesktop = document.getElementById('toggle-dropdown-desktop')
// const dropdownDesktop = document.getElementById('dropdown-desktop')
// toggleDropdownDesktop.addEventListener('click', event => {
//   dropdownDesktop.classList.toggle('-translate-y-full')
//   dropdownDesktop.classList.toggle('translate-y-0')
//   toggleDropdownDesktop.classList.toggle('!text-blue-regular')
//   toggleDropdownDesktop.classList.toggle('[&>_span]:!invisible')
//   event.preventDefault()
//   event.stopPropagation()
// })

// window.addEventListener('scroll', () => {
//   const target = 800
//   const scrollPosition = window.pageYOffset

//   // If scroll down to [x] px.
//   if (scrollPosition > target && dropdownDesktop.classList.contains('translate-y-0')) {
//     dropdownDesktop.classList.toggle('-translate-y-full')
//     dropdownDesktop.classList.toggle('translate-y-0')
//     toggleDropdownDesktop.classList.toggle('!text-blue-regular')
//     toggleDropdownDesktop.classList.toggle('[&>_span]:!invisible')
//   }
// })

// // Toggle dropdown mobile menu.
// const dropdownMobile = document.getElementById('dropdown-mobile')
// document.querySelectorAll('.toggle-dropdown-mobile').forEach(element => {
//   element.addEventListener('click', event => {
//     dropdownMobile.classList.toggle('translate-x-full')
//     dropdownMobile.classList.toggle('translate-x-0')
//     event.preventDefault()
//     event.stopPropagation()
//   })
// })

// https://codepen.io/hey-nick/pen/mLpmMV
// https://taylor.callsen.me/modern-navigation-menus-with-css-position-sticky-and-intersectionobservers/
const header = document.querySelector('.sticky-header')
const intersect = document.querySelector('.sticky-intersection')

if (header && intersect) {
  const handler = (entries) => {
    // console.log(entries)
    // entries is an array of observed dom nodes
    // we're only interested in the first one at [0]
    // because that's our .intersect node.
    // Here observe whether or not that node is in the viewport
    if (!entries[0].isIntersecting) {
      console.log('sticky')
      header.classList.add('is-sticky')
    } else {
      console.log('not sticky')
      header.classList.remove('is-sticky')
    }
  }

  const options = {
    // root: null, // relative to document viewport 
    // rootMargin: '-2px', // margin around root. Values are similar to css property. Unitless values not allowed
    threshold: 1.0 // visible amount of item shown in relation to root
  }

  // create the observer
  const observer = new window.IntersectionObserver(handler, options)
  
  // give the observer some dom nodes to keep an eye on
  observer.observe(intersect)
}

// Play, pause, mute, unmute the videos on age gate.
document.querySelectorAll('.video-play-pause').forEach(video => {
  video.addEventListener('click', event => {
    if (video.paused) {
      video.play()
      video.muted = false
    } else {
      video.pause()
      video.muted = true
    }
  })
})
