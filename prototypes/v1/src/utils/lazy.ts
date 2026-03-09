'use strict'

// https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API
// https://developer.mozilla.org/en-US/docs/Web/API/IntersectionObserver/unobserve
// https://www.smashingmagazine.com/2018/01/deferring-lazy-loading-intersection-observer-api/
// https://medium.com/caspertechteam/simple-image-placeholders-for-lazy-loading-images-unknown-size-19f0866ceced

import delay from '@/utils/delay'

function preloadAsset(target) {
  var imgLarge = new Image()

  if (target.nodeName === 'VIDEO') {
    const sourceElement = target.getElementsByTagName('source')[0]
    const srcAttribute = sourceElement.getAttribute('data-src')
    if (!srcAttribute) { 
      return
    }
    sourceElement.src = srcAttribute
    target.load()
  }

  if (target.nodeName === 'IMG') {
    const parent = target.parentNode
    const src = target.getAttribute('data-src')
    if (!src) { 
      return
    }

    imgLarge.src = target.getAttribute('data-src')
    imgLarge.onload = async () => {
      // console.log('image loaded')
      // await delay(2000)
      // parent.classList.remove('overflow-hidden')
      target.classList.remove('invisible', 'blur-md', 'blur-3xl', 'scale-120', 'scale-125')
      target.src = src 
    }
  }

  // if (target.nodeName === 'DIV') {
  //   const src = target.getAttribute('data-bg-img')
  //   if (!src) { 
  //     return
  //   }
  //   imgLarge.src = src

  //   imgLarge.onload = () => {
  //     // console.log('image loaded')
  //     target.classList.remove('blur-3xl', 'blur-[200px]')
  //     target.classList.add('opacity-100')
  //     target.style.backgroundImage = `url(${src})`
  //   }
  // }

  if (target.nodeName === 'DIV') {
    const parent = target.parentNode
    const clone = target.cloneNode(true)

    const src = target.getAttribute('data-bg-img')
    if (!src) { 
      return
    }
    imgLarge.src = src

    imgLarge.onload = async () => {
      // console.log('image loaded')
      clone.classList.add('opacity-0')
      clone.classList.remove('blur-3xl', 'blur-[200px]', 'scale-120', 'scale-125')

      await delay(1000)
      target.classList.add('opacity-0', 'absolute', 'z-3')
      
      clone.style.backgroundImage = `url(${src})`
      clone.classList.add('opacity-100', 'absolute', 'z-2')

      // await delay(1000)
      // target.remove()
    }
    parent.appendChild(clone)
  }
  
  return
}

function callback (entries, observer) {
  entries.forEach(entry => {
    if(entry.isIntersecting) {
      // Set `data-src` to `src`.
      preloadAsset(entry.target)

      // Stop watching after loading.
      observer.unobserve(entry.target)
    }
  })
}

export default class Lazy {
  constructor (selector = '.lazy', options) {
    const defaults = {
      rootMargin: '0px 0px 50px 0px', // must be in pixel or percentage.
      threshold: 0
    }

    if (selector instanceof Element) {
      this.element = selector || null
    }

    if (selector instanceof NodeList) {
      this.nodeList = selector || null
    }

    if (typeof selector === 'string') {
      this.nodeList = document.querySelectorAll(selector)
    }

    if (this.nodeList instanceof NodeList 
      && this.nodeList.length === 0
    ) {
      this.nodeList = null
    }

    if (this.element || this.nodeList) {
      this.observer = new IntersectionObserver(callback, options || defaults)
    }
  }

  observe () {
    if (this.element) {
      this.observer.observe(this.element)
    }

    if (this.nodeList) {
      this.nodeList.forEach(item => {
        this.observer.observe(item);
      })
    }
  }
}
