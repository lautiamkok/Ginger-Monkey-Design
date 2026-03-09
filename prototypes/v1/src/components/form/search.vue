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
  minLength
} from '@vuelidate/validators'

const form = reactive({
  search: ''
})
const response = reactive({
  status: '',
  message: ''
})

// Define props.
const props = defineProps({
  formId: {
    type: String,
    default: ''
  }
})

// Dynamic validation schema.
// https://vuelidate-next.netlify.app/examples.html#dynamic-validation-schema
const rules = computed(() => {
  const localRules = {
    search: {
      required,
      minLength: helpers.withMessage('This field should be at least 4 digits long',  minLength(4)),
    }, // Matches form.search
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

  // Submit form.
  setTimeout(() => {
    console.log(`submitting form...`)
    document.getElementById(props.formId).submit()
  }, 500)
}

function resetResponse (event) {
  response.status = ''
  response.message = ''
}
</script>
