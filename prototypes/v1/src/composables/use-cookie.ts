'use strict'

export default () => {
  function get (name, cookie) {
    const resource = cookie ?? document.cookie
    // console.log('resource =', resource)
    
    // Decode cookie names such as 'abc.com:xyz'
    const decodedCookie = decodeURIComponent(resource)
    // console.log('decodedCookie =', decodedCookie)
    
    let cookieValue = decodedCookie.match(`(?:(?:^|.*; *)${name} *= *([^;]*).*$)|^.*$`)[1]
    // console.log('parse =', cookieValue)
    
    if (cookieValue) {
      cookieValue = decodeURIComponent(cookieValue)
    }
    if (cookieValue === 'undefined' 
      || cookieValue === undefined 
      || cookieValue === ''
    ) {
      cookieValue = null
    }

    return cookieValue

    // console.log('parse =', JSON.parse(string))
    // return JSON.parse(string)
  }

  function set (name, value, options = {}) {
    let maxAge = 0
    
    // If options contains maxAge then we're configuring max-age.
    if (options.maxAge) {
      maxAge = options.maxAge
    }

    // If options contains days then we're configuring max-age.
    if (options.days) {
      maxAge = options.days * 60 * 60 * 24
    }

    // Define where cookies are sent to. If not set, cookies won't be sent on
    // cross-origin sites.
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#define_where_cookies_are_sent
    const domain = options.domain ?? window.location.hostname

    // Finally, creating the key. Must set `path=/` in the cookie or Firefox
    // won't remove the expired cookie automatically until the browser is
    // closed.
    
    // If an expired time is set, set the cookie with it, else expire the saved cookie when browser is closed.
    if (maxAge !== 0) {
      // document.cookie = `${name}=${encodeURIComponent(value)}; Domain=${domain}; max-age=${maxAge}; path=/`
      document.cookie = `${name}=${encodeURIComponent(value)}; max-age=${maxAge}; path=/`
    } else {
      // document.cookie = `${name}=${encodeURIComponent(value)}; Domain=${domain}; path=/`
      document.cookie = `${name}=${encodeURIComponent(value)}; path=/`
    }
    // console.log('document.cookie =', document.cookie)
  }

  function drop (name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/'
  }

  // observe, eye, spy, note, track, follow, guard, study, mark, monitor.
  function observe (ref, name) {
    // https://vuejs.org/api/reactivity-core.html#watch
    watch(ref, (newVal, prevVal) => {
      // Uncomment to see the result.
      // console.log('newVal =', newVal)
      // console.log('count.value =', count.value)

      // Stringify the reactive object before storing.
      set(name, JSON.stringify(ref.value))
    }, {
      // Force deep traversal of the source if it is an object, so that the
      // callback fires on deep mutations.
      deep: true
    })
  }

  return {
    get,
    set,
    drop,
    observe
  }
}
