'use strict'

// https://stackoverflow.com/a/22193094/413225
export default (attributes) => {
  // If the script existed, don't append.
  // if (document.querySelectorAll(`script[src="${attributes.src}"]`).length > 0) {
  //   return
  // }

  const head = document.getElementsByTagName('head')[0]
  const script = document.createElement('script')
  for (var attr in attributes) {
    script.setAttribute(attr, attributes[attr] ? attributes[attr] : null)
  }
  head.appendChild(script)
  // document.body.appendChild(s)
}
