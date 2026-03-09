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
  email as isEmail,
  minLength
} from '@vuelidate/validators'
import useFetch from '@/composables/use-fetch'

const form = reactive({
  firstName: '',
  lastName: '',
  emailAddress: '',
  // terms: 'Yes',
  subscribed: 'Yes',
  verified: 'No',
  
  // honeypot
  // https://dev.to/felipperegazio/how-to-create-a-simple-honeypot-to-protect-your-web-forms-from-spammers--25n8
  name: '',
  fname: '',
  lname: '',
  email: '',
  telephone: ''
})
const response = reactive({
  status: '',
  message: ''
})

// Define props.
const props = defineProps({
  apiAddSubscriber: {
    type: String,
    default: ''
  }
})

// Dynamic validation schema.
// https://vuelidate-next.netlify.app/examples.html#dynamic-validation-schema
const rules = computed(() => {
  const localRules = {
    firstName: {
      required,
      minLength: minLength(3)
    }, // Matches form.firstName
    lastName: {
      required,
      minLength: minLength(3)
    }, // Matches form.lastName
    emailAddress: {
      required,
      isEmail
    }, // Matches form.emailAddress
    // terms: {
    //   required: helpers.withMessage('This checkbox must be checked', required)
    // }, // Matches form.terms
  }
  return localRules
})
const v$ = useVuelidate(rules, form)

async function submitForm () {
  // Validate form.
  const isValid = await v$.value.$validate()
  if (!isValid) {
    response.status = 'error'
    response.message = 'There are some error(s) in your form. Please correct them'
    return
  }

  // Don't send the form if it is a spam.
  if (form.name || 
      form.fname || 
      form.lname || 
      form.email || 
      form.telephone
    ) {
    // console.log('spam!')
    return
  }

  // Remove the class name to show a loading layer.
  const wait = document.getElementById('wait')
  wait.classList.remove('hidden')

  // Inject the contact to the database.
  const { data:sent } = await useFetch(props.apiAddSubscriber, {
    method: 'POST',
    body: JSON.stringify(form),
    headers: {
      'Content-type': 'application/json; charset=UTF-8'
    }
  })

  // Dummy responses.
  // const sent = {
  //   status: 'ok',
  //   message: 'Thank you!'
  // }

  // const sent = {
  //   status: 'error',
  //   message: 'An error occurred!'
  // }

  // Add the hide class back.
  wait.classList.add('hidden')

  if (sent.status === 'error') {
    response.status = sent.status
    response.message = sent.message
    return
  }

  // Reset form.
  if (sent.status === 'ok') {
    // Reset Vuelidate.
    v$.value.$reset()

    // Reset form properties.
    Object.entries(form).forEach(([key,value]) => {
      form[key] = ''
    })
    form.verified ='No'
    form.subscribed ='Yes'
  }

  // If path is set, then redirect.
  if (sent.path !== undefined) {
    // Simulate an HTTP redirect:
    window.location.replace(sent.path)
  }

  // Else just print the message.
  if (sent) {
    response.status = sent.status
    response.message = sent.message
  }
}

function resetResponse (event) {
  response.status = ''
  response.message = ''
}
</script>
