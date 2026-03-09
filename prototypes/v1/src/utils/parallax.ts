'use strict'

import isInViewport from './is-in-viewport'
import delay from './delay'

export default class Parallax {
  constructor (name) {
    this.name = name
  }

  async animate (elements) {
    // await delay(1000)

    const scrolledY = window.scrollY
    elements.forEach(element => {
      // Get the element's offset top and height.
      // https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect
      const topPosition = element.getBoundingClientRect().top + scrolledY // => $(element).offset().top
      const height = element.getBoundingClientRect().height

      // 1,  1.5, 2.5, 3, 4
      const speed = element.dataset.parallaxSpeed ?? 2
      const style = element.dataset.parallaxStyle ?? 'marginTop'

      // Make sure the element is in the viewport.
      if (isInViewport(element)) {
        // Calculate the margin top.
        const difference = scrolledY - topPosition
        const ratio = Math.round((difference / height) * 100)
        const move = ratio * speed
        element.style.transform = `translate3d(0, ${move}px, 0)`
      }
    })
  }

  init () {
    // Get current breakpoint.
    const breakpoint = window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth

    // if smaller than md (1100), don't proceed
    if (breakpoint < 1100) {
      return
    }
     
    var elements = document.querySelectorAll(this.name)
    this.animate(elements)

    // https://developer.mozilla.org/en-US/docs/Web/API/Document/scroll_event
    window.addEventListener('scroll', event => {
      this.animate(elements)
    })
  }
}
