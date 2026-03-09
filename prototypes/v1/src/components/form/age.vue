<template>
  <slot
    v-bind:v$="v$"
    v-bind:form="form"
    v-bind:response="response"
    v-bind:submitForm="submitForm"
    v-bind:resetResponse="resetResponse"
  >
  </slot>
</template>

<script setup>
import { reactive, computed } from 'vue'
import useVuelidate from '@vuelidate/core'
import {
  helpers,
  required,
  minLength,
  maxLength
} from '@vuelidate/validators'
import { disablePageScroll, enablePageScroll } from '@fluejs/noscroll'
import useCookie from '@/composables/use-cookie'
const { set, get, drop } = useCookie()

const gate = document.getElementById('app-age-gate')
const form = reactive({
  year: '2002',
  remember: 'no',
})
const response = reactive({
  status: '',
  message: ''
})

// Dynamic validation schema.
// https://vuelidate-next.netlify.app/examples.html#dynamic-validation-schema
const rules = computed(() => {
  const localRules = {
    year: {
      // https://vuelidate-next.netlify.app/custom_validators.html#custom-error-messages
      required: helpers.withMessage('Year of Birth', required),
      minLength: helpers.withMessage('This field should be at least 4 digits long',  minLength(4)),
      maxLength: maxLength(4)
    }, // Matches form.year
  }
  return localRules
})
const v$ = useVuelidate(rules, form)

// Delete the cookie.
// Cookies.remove('rare-penny:age-gate')
// drop('rare-penny:age-gate')

// Get the age gate cookie.
// const cookieAgeGate = Cookies.get('rare-penny:age-gate')
const cookieAgeGate = get('rare-penny:age-gate')
// console.log('cookie value =', cookieAgeGate)
// console.log('cookieAgeGate (component) =', cookieAgeGate)

// Disable scroll.
let lock = document.getElementsByTagName('body')[0]
if (cookieAgeGate === null) {
  disablePageScroll(lock)
  gate.classList.remove('hidden')
}

if (cookieAgeGate !== null && cookieAgeGate === 'passed') {
  response.status = 'ok'
}

async function submitForm () {
  // Validate form.
  const isValid = await v$.value.$validate()
  if (!isValid) {
    response.status = 'error'
    response.message = 'There are some error(s) in your form. Please correct them'
    return
  }

  // Calculate the age with Date.
  const today = new Date()
  const year = today.getFullYear()

  // Return error if under 21.
  if (year - form.year < 21) {
    response.status = 'forbidden'
    response.message = 'You must be of legal age to access this site.'
    return
  }

  // Return error if not in the year range.
  if ((form.year < 1920) || (form.year > year)) {
    response.status = 'error'
    response.message = `Your birth year should be in the 1920-${year} year range.`
    return
  }

  response.status = 'ok'
  gate.classList.add('hidden')

  // Enable scroll.
  enablePageScroll(lock)

  // If remember me set, expires in 1 day, else expires 
  // when browser closes/ session ends.
  // https://www.npmjs.com/package/js-cookie
  if (form.remember === 'yes') {
    // Cookies.set('rare-penny:age-gate', 'passed', {
    //   expires: 1 // expires in 1 day.
    // })

    const day = 1
    set('rare-penny:age-gate', 'passed', {
      // If no `expires` or `maxAge` is set, the cookie will be session-only and
      // removed when the user closes their browser.
      maxAge: day * 24 * 60 * 60
    })
  } else {
    // Cookies.set('rare-penny:age-gate', 'passed')
    set('rare-penny:age-gate', 'passed')
  }

  // Reset Vuelidate.
  v$.value.$reset()

  // Reset form properties.
  Object.entries(form).forEach(([key,value]) => {
    form[key] = ''
  })
  form.remember ='no'
}

function resetResponse (event) {
  response.status = ''
  response.message = ''
}
</script>
