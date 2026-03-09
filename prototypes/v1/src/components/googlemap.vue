<template>
  <div ref="root">
    <slot 
      v-bind:alphabets="alphabets"
      v-bind:sortTerm="sortTerm"
      v-bind:handleChangedSort="handleChangedSort"
      v-bind:suggestions="suggestions"
      v-bind:searchTerm="searchTerm"
      v-bind:displayClearSearch="displayClearSearch"
      v-bind:displaySuggestions="displaySuggestions"
      v-bind:displayDistances="displayDistances"
      v-bind:toggleDistances="toggleDistances"
      v-bind:distanceTerm="distanceTerm"
      v-bind:getDistance="getDistance"
      v-bind:handleChangedDistance="handleChangedDistance"
      v-bind:filterTerm="filterTerm"
      v-bind:handleChangedFilter="handleChangedFilter"
      v-bind:handleInputSearch="handleInputSearch"
      v-bind:setSelectedSuggestion="setSelectedSuggestion"
      v-bind:clearInputSearch="clearInputSearch"
      v-bind:disableRadius="disableRadius"
    />
  </div>
</template>

<script setup>
import { ref, watch, onMounted, toRaw } from 'vue'
import useFetch from '@/composables/use-fetch'
import addScript from '@/utils/add-script'
import delay from '@/utils/delay'
import { setOptions, importLibrary } from '@googlemaps/js-api-loader'

const root = ref(null)
const disableRadius = ref(true) // Button is enabled by default
const displayClearSearch = ref(false)
const displayDistances = ref(false)
const displaySuggestions = ref(false)
const distanceTerm = ref(0)
const searchTerm = ref(null)
const filterTerm = ref(null)
const sortTerm = ref(null)
const data = ref([])
const alphabets = ref([])
const scopes = ref([])
const postcodes = ref([])
const suggestions = ref([])

// Define props.
const props = defineProps({
  apiLocations: {
    type: String,
    default: ''
  },
  apiLocalities: {
    type: String,
    default: ''
  },

  // Map
  apiKey: {
    type: String,
    default: 'AIzaSyAoNifGJFXlSrA4d2uYG_b8QRR36m-kd80'
  },
  mapId: {
    type: String,
    default: '85ce2b243c24bff816337030'
  },
  longitude: {
    type: Number,
    default: 50.662830
  },
  latitude: {
    type: Number,
    default: 30.217970
  },
  zoom: {
    type: Number,
    default: 4
  },
  zoomClick: {
    type: Number,
    default: 12
  },

  // Glyph CSS
  glyphColour: {
    type: String,
    default: '#f9f2e8'
  },
  glyphBorderColour: {
    type: String,
    default: '#f9f2e8'
  },
  glyphBackground: {
    type: String,
    default: '#d31f2b'
  },
})

// Google maps vars.
let map
let bounds
let circle
let infoWindow
let markers = []
let center = { lat: props.latitude, lng: props.longitude } // default (to be deprecated)

// Locality
let locality

// Disable the radius button if search term is empty.
watch(searchTerm, (newValue, oldValue) => {
  // console.log(`Count changed from ${oldValue} to ${newValue}`)
  if (newValue === '' || newValue === null) {
    disableRadius.value = true
    searchTerm.value = null
    displayClearSearch.value = false
    distanceTerm.value = 0
  }
})

onMounted(async () => {
  // Hide dropdown if click outside the targeted element.
  // https://stackoverflow.com/questions/36170425/detect-click-outside-element
  window.addEventListener('click', (event) => {
    if (!document.getElementById('button-distance').contains(event.target)) {
      // console.log('click outside element')
      displayDistances.value = false
    }
  })

  // Select the `.swiper` element in this vue component only.
  const domElement = root.value
  
  // Dummy data.
  // const items = [
  //   {
  //     "title": "12 Bar / BELGRAVE",
  //     "region": "BELGRAVE",
  //     "address": "1675 Burwood Highway, BELGRAVE, VIC, 3160",
  //     "postcode": " 3160 ",
  //     "telephone": "+60 (3) 5122 4975",
  //     "fax": "+60 (3) 5121 2069",
  //     "website": "sample.com",
  //     "email": "enquiries@sample.com",
  //     "latitude": "-37.9087948",
  //     "longitude": "145.3542967",
  //     "products": "Arktika Vodka"
  //   },
  //   {
  //     "title": "Albert Street Bottleshop / SEBASTOPOL",
  //     "region": "SEBASTOPOL",
  //     "address": "25 Albert Street, SEBASTOPOL, VIC, 3160",
  //     "postcode": "3160",
  //     "telephone": "",
  //     "fax": "",
  //     "website": "airfilter-europe.com",
  //     "email": "",
  //     "latitude": "-37.5841256",
  //     "longitude": "143.841242",
  //     "products": "Arktika Vodka, Arktika Ready to Drinks"
  //   },
  //   {
  //     "title": "Alberton Hotel / SEBASTOPOL",
  //     "region": "SEBASTOPOL",
  //     "address": "124 Port Road, SEBASTOPOL, SA, 31600",
  //     "postcode": "31600",
  //     "telephone": "+86 21 6886 7096-306",
  //     "fax": "+86 21 6886 7097-306",
  //     "website": "sample.cn",
  //     "email": "jessica.wang@zenrich.cn",
  //     "latitude": "-34.8610829",
  //     "longitude": "138.5142491",
  //     "products": "Arktika Vodka, Arktika Ready to Drinks"
  //   },
  //   {
  //     "title": "Amaroo Tavern / MOREE",
  //     "region": "MOREE",
  //     "address": "Corner Amaroo Drive & Boronia Avenue, 124 Port Road, MOREE, NSW, 2400",
  //     "postcode": "2400",
  //     "telephone": "+65 6264 0524",
  //     "fax": "+65 6262 0905",
  //     "website": "sample.sg",
  //     "email": "sales@sample.sg",
  //     "latitude": "-29.484454",
  //     "longitude": "149.8388535",
  //     "products": "Arktika Flavoured Vodka, Arktika Ready to Drinks"
  //   },
  //   {
  //     "title": "Andergrove Tavern - Bobs Bulk Booze / MOUNT PLEASANT MOREE",
  //     "region": "MOUNT PLEASANT MOREE",
  //     "address": "Suite 9-11, Mount Pleasant Plaza, 73 Phillip Street, MOUNT PLEASANT MOREE, QLD, 2400",
  //     "postcode": "2400",
  //     "telephone": "+ 60 (3) 5121 0920",
  //     "fax": "+ 60 (3) 5122 0040",
  //     "website": "sample.my",
  //     "email": "enquiries@sample.my",
  //     "latitude": "-21.1167495",
  //     "longitude": "149.1578669",
  //     "products": "Arktika Flavoured Vodka,Arktika Vodka"
  //   },
  //   {
  //     "title": "Arundel Tavern - DBS Arundel Plaza / ARUNDEL",
  //     "region": "ARUNDEL",
  //     "address": "Arundel Plaza Shopping Centre, Shop 25, 226 Napper Road, ARUNDEL, QLD, 4214",
  //     "postcode": "4214",
  //     "telephone": "+60 (3) 5122 4975",
  //     "fax": "+60 (3) 5121 2069",
  //     "website": "sample.com",
  //     "email": "enquiries@sample.com",
  //     "latitude": "-27.9471692",
  //     "longitude": "153.351831",
  //     "products": "Arktika Vodka"
  //   },
  //   {
  //     "title": "Arundel Tavern / ARUNDEL",
  //     "region": "ARUNDEL",
  //     "address": "226-323 Napper Road, ARUNDEL, QLD, 4214",
  //     "postcode": "4214",
  //     "telephone": "+60 (3) 5122 4975",
  //     "fax": "+60 (3) 5121 2069",
  //     "website": "sample.com",
  //     "email": "enquiries@sample.com",
  //     "latitude": "-27.9464118",
  //     "longitude": "153.3522648",
  //     "products": "Arktika Vodka"
  //   },
  //   {
  //     "title": "Yarram Friendly Grocer / YARRAM",
  //     "region": "YARRAM",
  //     "address": "261 Commercial Road, YARRAM, VIC, 3971",
  //     "postcode": "3971",
  //     "telephone": "+60 (3) 5122 4975",
  //     "fax": "+60 (3) 5121 2069",
  //     "website": "sample.com",
  //     "email": "enquiries@sample.com",
  //     "latitude": "-38.563921",
  //     "longitude": "146.6763323",
  //     "products": "Arktika Vodka"
  //   },
  //   {
  //     "title": "Yarram Liquor / YARRAM",
  //     "region": "YARRAM",
  //     "address": "197 Commercial Road, YARRAM, VIC, 3971",
  //     "postcode": "3971",
  //     "telephone": "+60 (3) 5122 4975",
  //     "fax": "+60 (3) 5121 2069",
  //     "website": "sample.com",
  //     "email": "enquiries@sample.com",
  //     "latitude": "-38.562241",
  //     "longitude": "146.6765631",
  //     "products": "Arktika Vodka"
  //   }
  // ]

  // const localities = [
  //   {
  //     "postcode": "2850",
  //     "locality": "AARONS PASS"
  //   },
  //   {
  //     "postcode": "6280",
  //     "locality": "ABBA RIVER"
  //   },
  //   {
  //     "postcode": "6280",
  //     "locality": "ABERDEEN"
  //   },
  // ]

  if (!props.apiLocations || !props.apiLocalities) {
    return
  }

  let { data:items } = await useFetch(props.apiLocations, {
    method: 'GET'
  })
  let { data:localities } = await useFetch(props.apiLocalities, {
    method: 'GET'
  })
  if (items.length === 0 && localities.length === 0) {
    return
  }
  // console.log(items)
  // console.log(localities)

  data.value = items

  // https://stackoverflow.com/questions/46146562/es6-loop-through-object-array-and-aggregate-unique-values-from-key-pair-cleanes
  // https://medium.com/tomincode/removing-array-duplicates-in-es6-551721c7e53f
  // https://stackoverflow.com/questions/37021649/javascript-and-es6-filter-array-with-unique-key
  // https://stackoverflow.com/questions/79800383/how-to-create-objects-from-sets
  // let uniqueRegions = Array.from(new Set(items.map(item => item.region.trim())))
  // let uniqueRegions = [...(new Set(items.map(({ region }) => region.trim())))];
  // uniqueRegions.forEach((item, index) => {
  //   scopes.value.push({
  //     value: item
  //   })
  // })
  const regionsMap = new Map(items.map(item => [item.region?.trim(), { scope: item.region }]))
  const localitiesMap = new Map(localities.map(item => [item.locality?.trim(), { scope: item.locality }]))

  const scopesMerged = [...regionsMap.values(), ...localitiesMap.values()]
  const scopesMap = new Map(scopesMerged.map(item => [item.scope?.trim(), { scope: item.scope }]))
  scopes.value = [...scopesMap.values()]
  // console.log([...regionsMap.values(), ...localitiesMap.values()])
  // console.log([...scopesMap.values()])

  const postcodesMap = new Map(items.map(item => [item.postcode?.trim(), { postcode: item.postcode }]))
  postcodes.value = [...postcodesMap.values()]
  // console.log([...postcodesMap.values()])
  
  const firstLettersMap = new Map(items.map(item => [item.title?.trim().charAt(0), { title: item.title }]))
  // const firstLetters = items.map(item => item.title?.trim().charAt(0))
  // console.log([...firstLettersMap.keys()])

  // Get the keys only and remove numbers from the list.
  alphabets.value = [...firstLettersMap.keys().filter(x => isNaN(x))]
  sortTerm.value = alphabets.value[0]

  const sidebar = document.getElementById('sidebar')
  const googleMap = document.getElementById('map')
  if (googleMap !== null) {
    // Add googlemap script and Create API keys:
    // https://console.cloud.google.com/google/maps-apis/
    // https://developers.google.com/maps/documentation/javascript/load-maps-js-api
    // https://developers.google.com/maps/documentation/javascript/examples
    // https://developers.google.com/maps/documentation/javascript/get-api-key 

    // Use the NPM js-api-loader package
    // https://www.npmjs.com/package/@googlemaps/js-api-loader
    // https://developers.google.com/maps/documentation/javascript/load-maps-js-api#javascript

    // Set the options for loading the API.
    setOptions({
      key: props.apiKey, //'AIzaSyAoNifGJFXlSrA4d2uYG_b8QRR36m-kd80',
      version: 'weekly',
    })

    const { Map } = await importLibrary('maps')
    map = new Map(document.getElementById('map'), {
      mapId: props.mapId, // '85ce2b243c24bff816337030',
      zoom: props.zoom, // 4

      // Find lat lng at:
      // https://www.latlong.net/
      // center: { lat: props.latitude, lng: props.longitude } // new google.maps.LatLng(30.217970, 50.662830),
      // center
    })
    
    items = items.filter(item => item.title?.trim().toLowerCase().startsWith(sortTerm.value.toLowerCase()))
    // items = items.filter(item => /^\d/.test(item.title))
    // console.log(items)
    await addMarkers(items)
  }
})

function toggleRadiusButton () {
  disableRadius.value = !disableRadius.value
}

async function addMarkers (items) {
  const locations = []
  items.forEach ((item, index) => {
    // Line breaks to br tags.
    let address = item.address.replace(/(?:\r\n|\r|\n)/g, '<br>')

    // Remove br tags from string.
    // let address = item.address.replace(/<br>/g, ' ')

    let infoBits = []
    let contacts = []

    infoBits.push(`<h4 class="font-bold">${item.title}</h4>`)
    if (item.region) {
      infoBits.push(`<p>${item.region}</p>`)
    }
    infoBits.push(`<p>${address}</p>`)
    if (item.telephone) {
      contacts.push(`Tel: ${item.telephone}`)
    }
    if (item.fax) {
      contacts.push(`Fax: ${item.fax}`)
    }
    if (item.email) {
      contacts.push(`${item.email}`)
    }
    if (item.website) {
      contacts.push(`${item.website}`)
    }
    if (item.telephone || item.fax || item.email || item.website) {
      infoBits.push(`<p>${contacts.join('<br/>')}</p>`)
    }

    locations.push({
      title: item.title,
      htmlFullAddress: `
      <div class="flex flex-col space-y-2 font-body text-xl">
        ${infoBits.join('')}
      </div>`,
      htmlBasicAddress: `
      <div class="flex flex-col">
        <h4 class="text-xl font-bold">
          ${item.title}
        </h4>
        <p>
          ${item.address}
        </p>
      </div>`,
      position: {
        lat: parseFloat(item.latitude),
        lng: parseFloat(item.longitude)
      },
      address: item.address,
      region: item.region,
      postcode: item.postcode
    })
  })
  // console.log(locations)

  // Clear all markers from maps.
  // https://stackoverflow.com/questions/1544739/google-maps-api-v3-how-to-remove-all-markers
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }

  // Reset markers.
  markers = []

  // Clear previous cicle from maps.
  // console.log(circle)
  if (circle) {
    circle.setMap(null)
  }
  circle = null

  if (items.length === 0) {
    // https://stackoverflow.com/questions/11149144/google-maps-get-latitude-and-longitude-having-city-name
    // https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple
    const geocoder =  new google.maps.Geocoder()
    const response = await geocoder.geocode({'address': `${searchTerm.value.toLowerCase()}, au`})

    // None await:
    // geocoder.geocode( { 'address': 'miami, us'}, function(results, status) {
    //   if (status == google.maps.GeocoderStatus.OK) {
    //     alert("location : " + results[0].geometry.location.lat() + " " +results[0].geometry.location.lng())
    //   } else {
    //     alert("Something got wrong " + status)
    //   }
    // })

    locality = {
      longitude: response.results[0].geometry.location.lng(),
      latitude: response.results[0].geometry.location.lat()
    }
    items.push(locality)
  }

  // Zoom and center a Google Map according to its markers.
  // https://stackoverflow.com/questions/3520810/zoom-and-center-a-google-map-according-to-its-markers-javascript-api-v3
  // https://github.com/JustFly1984/react-google-maps-api/discussions/2877
  bounds = new google.maps.LatLngBounds()
  items.forEach(location => {
    bounds.extend(new google.maps.LatLng(location.latitude, location.longitude))
  })
  map.fitBounds(bounds)

  infoWindow = new google.maps.InfoWindow()

  // Add markers to the map
  const { PinElement, AdvancedMarkerElement } = await importLibrary('marker')
  locations.forEach((location, index) => {
    // https://developers.google.com/maps/documentation/javascript/advanced-markers/basic-customization
    let pin = new PinElement({
      glyphColor: props.glyphColour,
      borderColor: props.glyphBorderColour,
      background: props.glyphBackground,
      scale: 1.5,
    })
    
    let marker = new AdvancedMarkerElement({
      position: location.position,
      map: map,
      title: location.title,
      // content: pin.element // Deprecated.
    })
    marker.append(pin) // ✅ Use append() instead

    // Open info window when clicking on the map
    marker.addListener('gmp-click', () => {
      // Open infowindow or perform actions
      infoWindow.close()
      infoWindow.setContent(location.htmlFullAddress)
      infoWindow.open(marker.map, marker)
    })

    // Save the info we need to use later for the side_bar.
    marker.location = location
    markers.push(marker)

    // Generate sidebar menu items.
    let listItem = document.createElement('li')
    listItem.setAttribute('class', 'cursor-pointer px-5 py-4 border-b-1 border-gray-200 hover:bg-gray-100')
    listItem.innerHTML = location.htmlBasicAddress
    sidebar.appendChild(listItem)

    // Open info window when clicking on the sidebar.
    listItem.addEventListener('click', () => {
      map.zoom = props.zoomClick // 12
      map.setCenter(location.position) // Center map on click
      infoWindow.close()
      infoWindow.setContent(location.htmlFullAddress)
      infoWindow.open(marker.map, marker)
    })
  })
}

async function addRadiusMarkers () {
  infoWindow.close()

  // Stop here if search term is empty.
  if (searchTerm.value === '') {
    return
  }

  // Empty the sidebar element before appending new ones.
  sidebar.innerHTML = ''

  // Filter the data with the value.
  let matches = data.value.filter(item => item.postcode?.trim() === searchTerm.value)
  let unmatches = data.value.filter(item => item.postcode?.trim() !== searchTerm.value)
  if (matches.length === 0) {
    matches = data.value.filter(item => item.region?.trim() === searchTerm.value)
    unmatches = data.value.filter(item => item.region?.trim() !== searchTerm.value)
    // console.log(toRaw(matches))
  }
  if (matches.length === 0) {
    matches = data.value.filter(item => item.address?.trim() === searchTerm.value)
    unmatches = data.value.filter(item => item.address?.trim() !== searchTerm.value)
  }
  // console.log(matches)
  // console.log(unmatches)

  // Clear previous cicle from maps.
  // https://stackoverflow.com/questions/6058904/removing-a-google-maps-circle-shape
  if (circle) {
    circle.setMap(null)
  }
  circle = null
  
  // Get a random location as the center.
  const keys = Object.keys(matches)
  let random = matches[keys[ keys.length * Math.random() << 0]]
  if (matches.length === 0) { 
    random = locality
  } 
  const mapsSearchCenter = new google.maps.LatLng(random.latitude, random.longitude)

  // 1 mile ≈ 1609.34 meters
  // 20 miles = 32186.8 meters
  const radius = distanceTerm.value * 1000 // km to meters

  // https://developers.google.com/maps/documentation/javascript/libraries
  // https://developers.google.com/maps/documentation/javascript/reference/geometry#spherical.computeDistanceBetween
  const { spherical } = await importLibrary('geometry')
  unmatches.forEach((unmatch, index) => {
    const to = new google.maps.LatLng(unmatch.latitude, unmatch.longitude)

    // Distance in KM for testing.
    // const distance = Math.round(spherical.computeDistanceBetween(mapsSearchCenter, to) / 1000)
    // console.log(`${unmatch.title} is`, `${distance} away`)
    if (spherical.computeDistanceBetween(mapsSearchCenter, to) < radius) {
      matches.push(unmatch)
    }
  })
  await addMarkers(matches)

  // Add a cicle to the map.
  const circleOptions = {
    center: mapsSearchCenter,
    radius: radius,
    fillOpacity: 0,
    strokeOpacity: 0,

    // Show the red cicle for testing.
    strokeOpacity: 0.35,
    fillOpacity: 0.35,
    fillColor: '#FF0000',

    map: map
  }
  circle = new google.maps.Circle(circleOptions)
  map.fitBounds(circle.getBounds())
}

function toggleDistances (event) {
  // console.log(event.target)
  // ToggleDistances the value.
  displayDistances.value = !displayDistances.value
}

// https://stackoverflow.com/questions/18364715/google-maps-api-radius-search-for-markers-using-places
// https://stackoverflow.com/questions/29262086/how-to-restrict-a-google-maps-api-v3-radius-search-only-to-the-markers-within-th
async function getDistance (event) {
  const value = event.target.dataset.distance
  distanceTerm.value = value
  await addRadiusMarkers()

  // Bounds back to the original center.
  if (Number(value) === 0) {
    // console.log('is 0')
    map.fitBounds(bounds)
  }
}

async function handleChangedDistance (event) {
  const value = event.target.value
  distanceTerm.value = value
  await addRadiusMarkers()
}

async function handleChangedSort (event) {
  const sort = event.target.value
  sortTerm.value = sort
  // console.log(sort)

  if (sort === '') {
    return
  }

  // Filter the data with the value.
  let items = []
  if (sort === '0-9') {
    items = data.value.filter(item => /^\d/.test(item.title))
  } else {
    items = data.value.filter(item => item.title?.trim().toLowerCase().startsWith(sort.toLowerCase()))
  }
  // console.log(items)

  // Reset search.
  searchTerm.value = null
  displayClearSearch.value = false

  // Reset distance.
  distanceTerm.value = 0

  // Empty the sidebar element before appending new ones.
  sidebar.innerHTML = ''
  await addMarkers(items)
}

async function handleChangedFilter (event) {
  const tag = event.target.value
  filterTerm.value = tag
  // console.log(tag)

  if (tag === '') {
    return
  }

  // Filter the data with the value.
  let items = data.value.filter(item => item.products?.split(/\s*,\s*/).indexOf(tag) !== -1)
  if (tag === 'All') {
    items = data.value
  }
  // console.log(items)

  // Reset search.
  searchTerm.value = null
  displayClearSearch.value = false

  // Reset distance.
  distanceTerm.value = 0

  // Empty the sidebar element before appending new ones.
  sidebar.innerHTML = ''
  await addMarkers(items)
}

function handleInputSearch (event) {
  const search = event.target.value
  searchTerm.value = search
  // console.log(search)

  // Reset terms.
  filterTerm.value = null
  sortTerm.value = null
  distanceTerm.value = 0

  let items = []

  // Don't search if the word length is less than 2.
  if (search.trim().length <= 2) {
    return
  }

  // Filter the data with the value.
  items = postcodes.value.filter(item => item.postcode?.trim().includes(search.toLowerCase()))
  if (items.length === 0) {
    items = scopes.value.filter(item => item.scope?.trim().toLowerCase().includes(search.toLowerCase()))
    // console.log(toRaw(items))
  }
  if (items.length === 0) {
    items = data.value.filter(item => item.address?.trim().toLowerCase().includes(search.toLowerCase()))
  }
  // console.log(items)

  suggestions.value = items
  displaySuggestions.value = true
}

async function setSelectedSuggestion (event, item) {
  // console.log(item)
  searchTerm.value = item.address || item.scope || item.postcode
  suggestions.value = []
  displaySuggestions.value = false
  displayClearSearch.value = true
  // console.log(searchTerm.value)

  let items = []
  
  // Filter the data with the value.
  items = data.value.filter(item => item.postcode?.trim() === searchTerm.value)
  if (items.length === 0) {
    items = data.value.filter(item => item.region?.trim() === searchTerm.value)
    // console.log(toRaw(items))
  }
  if (items.length === 0) {
    items = data.value.filter(item => item.address?.trim() === searchTerm.value)
  }
  // console.log(items)

  // Empty the sidebar element before appending new ones.
  sidebar.innerHTML = ''
  await addMarkers(items)

  // Enable the radius button.
  disableRadius.value = false
}

function clearInputSearch (event) {
  searchTerm.value = null
  displayClearSearch.value = false
  disableRadius.value = true
  distanceTerm.value = 0
  // map.fitBounds(bounds)
}
</script>
